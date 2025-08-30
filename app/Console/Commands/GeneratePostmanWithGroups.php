<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use YasinTgh\LaravelPostman\Contracts\RouteAnalyzerInterface;
use YasinTgh\LaravelPostman\Services\PostmanFormatter;

class GeneratePostmanWithGroups extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'postman:generate-groups
                            {--environment : Also generate environment file with group variables}';

    /**
     * The console command description.
     */
    protected $description = 'Generate Postman collection with group-based URL support';

    protected array $config;

    /**
     * Execute the console command.
     */
    public function handle(
        RouteAnalyzerInterface $analyzer,
        PostmanFormatter $formatter,
    ): int {
        $this->config = config('postman');

        $this->info('🚀 Generating Postman collection with group support...');

        $routes = $analyzer->analyze();
        $collection = $this->buildCollectionWithGroups($routes);
        $path = $this->saveCollection($collection);

        $this->info("📁 Collection saved to: {$path}");

        if ($this->option('environment')) {
            $envPath = $this->generateGroupEnvironment();
            $this->info("🌍 Environment file saved to: {$envPath}");
        }

        $this->info('✅ Postman collection with group support generated successfully!');

        return Command::SUCCESS;
    }

    protected function buildCollectionWithGroups(array $routes): array
    {
        $variables = $this->buildGroupVariables();

        $collection = [
            'info' => [
                'name' => $this->config['name'],
                'description' => $this->config['description'],
                'schema' => 'https://schema.getpostman.com/json/collection/v2.1.0/collection.json',
            ],
            'item' => $this->organizeRoutesWithGroups($routes),
            'variable' => $variables,
        ];

        if ($this->config['auth']['enabled'] ?? false) {
            $collection['auth'] = $this->buildAuth();
            $collection['variable'] = array_merge($variables, $this->buildAuthVariables());
        }

        return $collection;
    }

    protected function buildGroupVariables(): array
    {
        $variables = [
            ['key' => 'base_url', 'value' => $this->config['base_url']],
        ];

        if ($this->config['groups']['enabled'] ?? false) {
            $defaults = $this->config['groups']['defaults'] ?? [];

            foreach ($defaults as $key => $value) {
                $variables[] = [
                    'key' => $key,
                    'value' => $value,
                    'type' => 'default',
                ];
            }
        }

        return $variables;
    }

    protected function organizeRoutesWithGroups(array $routes): array
    {
        $groupedRoutes = [];

        foreach ($routes as $route) {
            $group = $this->detectRouteGroup($route);
            $formattedRoute = $this->formatRouteWithGroup($route, $group);

            // Organize by nested path as before, but with group-aware URLs
            $groupedRoutes[] = $formattedRoute;
        }

        return $this->organizeByNestedPath($groupedRoutes);
    }

    protected function detectRouteGroup($route): string
    {
        $uri = $route->uri;
        $middleware = $route->middleware;

        // Detect based on URI patterns
        if (str_starts_with($uri, 'api/auth')) {
            return 'auth';
        } elseif (str_starts_with($uri, 'api/internal')) {
            return 'api-internal';
        } elseif (str_starts_with($uri, 'api/external')) {
            return 'api-external';
        } elseif (str_starts_with($uri, 'api')) {
            return 'api';
        }

        // Fallback detection based on middleware
        if (in_array('auth:sanctum', $middleware)) {
            return 'api-internal';
        }

        return 'api';
    }

    protected function formatRouteWithGroup($route, string $group): array
    {
        $groupMapping = $this->config['groups']['mapping'] ?? [];
        $baseUrl = $groupMapping[$group] ?? '{{base_url}}/'.$route->uri;

        // Replace the prefix part of URI with group variable
        $uri = $route->uri;
        switch ($group) {
            case 'auth':
                $uri = str_replace('api/auth', '{{auth_prefix}}', $uri);
                $baseUrl = '{{base_url}}/{{auth_prefix}}';
                break;
            case 'api-internal':
                $uri = str_replace('api/internal', '{{api_internal}}', $uri);
                $baseUrl = '{{base_url}}/{{api_internal}}';
                break;
            case 'api-external':
                $uri = str_replace('api/external', '{{api_external}}', $uri);
                $baseUrl = '{{base_url}}/{{api_external}}';
                break;
            case 'api':
                if (str_starts_with($uri, 'api/') && ! str_contains($uri, 'api/auth') && ! str_contains($uri, 'api/internal')) {
                    $uri = str_replace('api', '{{api_prefix}}', $uri);
                    $baseUrl = '{{base_url}}/{{api_prefix}}';
                }
                break;
        }

        // Build clean URI without prefix for path array
        $pathSegments = explode('/', $uri);
        $cleanedUri = $uri;

        $formatted = [
            'name' => $this->generateRequestName($route),
            'request' => [
                'method' => $route->methods[0],
                'header' => $this->buildHeaders(),
                'url' => [
                    'raw' => $baseUrl.'/'.ltrim(str_replace(['{{auth_prefix}}', '{{api_internal}}', '{{api_external}}', '{{api_prefix}}'], '', $uri), '/'),
                    'host' => ['{{base_url}}'],
                    'path' => array_filter($pathSegments, fn ($segment) => ! empty($segment)),
                ],
            ],
            'group' => $group,
        ];

        // Add request body if FormRequest exists
        if ($route->formRequest) {
            $formatted['request']['body'] = $this->generateRequestBody($route->formRequest);
        }

        // Add authentication for protected routes
        if ($this->isProtectedRoute($route)) {
            $formatted['request']['auth'] = $this->buildRouteAuth();
        }

        return $formatted;
    }

    protected function organizeByNestedPath(array $routes): array
    {
        $maxDepth = $this->config['structure']['folders']['max_depth'] ?? 4;
        $mapping = $this->config['structure']['folders']['mapping'] ?? [];
        $result = [];

        foreach ($routes as $route) {
            $uri = $route['request']['url']['raw'];

            // Extract path for folder organization (remove variables)
            $cleanUri = preg_replace('/\{\{[^}]+\}\}/', '', $uri);
            $cleanUri = trim($cleanUri, '/');
            $segments = explode('/', $cleanUri);
            $segments = array_filter($segments, fn ($segment) => ! empty($segment));

            $current = &$result;

            foreach ($segments as $i => $segment) {
                if ($i < $maxDepth) {
                    $folderName = $mapping[$segment] ?? ucwords(str_replace(['-', '_'], ' ', $segment));

                    $found = false;
                    foreach ($current as &$item) {
                        if (isset($item['name']) && $item['name'] === $folderName) {
                            $current = &$item['item'];
                            $found = true;
                            break;
                        }
                    }

                    if (! $found) {
                        $current[] = [
                            'name' => $folderName,
                            'item' => [],
                        ];
                        $current = &$current[count($current) - 1]['item'];
                    }

                    if ($i === count($segments) - 1 || $i === $maxDepth - 1) {
                        unset($route['group']); // Remove internal group info
                        $current[] = $route;
                        break;
                    }
                }
            }
        }

        return $result;
    }

    protected function generateRequestName($route): string
    {
        $format = $this->config['structure']['naming_format'];
        $action = $route->action ?? 'unknown';
        $method = $route->methods[0] ?? 'GET';
        $uri = $route->uri;
        $controller = class_basename($route->controller ?? '');

        return str_replace(
            ['{method}', '{uri}', '{controller}', '{action}'],
            [$method, $uri, $controller, $action],
            $format
        );
    }

    protected function buildHeaders(): array
    {
        $headers = [];
        foreach ($this->config['headers'] ?? [] as $key => $value) {
            $headers[] = [
                'key' => $key,
                'value' => $value,
                'type' => 'text',
            ];
        }

        return $headers;
    }

    protected function generateRequestBody($formRequest): array
    {
        // Simplified request body generation
        try {
            $rules = $formRequest->rules();
            $body = [];

            foreach ($rules as $field => $rule) {
                $body[$field] = $this->generateFieldValue($field, $rule);
            }

            return [
                'mode' => 'raw',
                'raw' => json_encode($body, JSON_PRETTY_PRINT),
                'options' => ['raw' => ['language' => 'json']],
            ];
        } catch (\Exception $e) {
            return [
                'mode' => 'raw',
                'raw' => '{}',
                'options' => ['raw' => ['language' => 'json']],
            ];
        }
    }

    protected function generateFieldValue(string $field, $rules): mixed
    {
        $ruleArray = is_array($rules) ? $rules : explode('|', $rules);

        if (in_array('email', $ruleArray)) {
            return 'user@example.com';
        }
        if (in_array('boolean', $ruleArray)) {
            return true;
        }
        if (in_array('numeric', $ruleArray) || in_array('integer', $ruleArray)) {
            return 1;
        }

        return "{$field} sample value";
    }

    protected function isProtectedRoute($route): bool
    {
        $authMiddleware = $this->config['auth']['protected_middleware'] ?? ['auth:sanctum'];

        return ! empty(array_intersect($authMiddleware, $route->middleware));
    }

    protected function buildAuth(): array
    {
        return [
            'type' => 'bearer',
            'bearer' => [
                ['key' => 'token', 'value' => '{{auth_token}}'],
            ],
        ];
    }

    protected function buildAuthVariables(): array
    {
        return [
            ['key' => 'auth_token', 'value' => '', 'type' => 'secret'],
        ];
    }

    protected function buildRouteAuth(): array
    {
        return [
            'type' => 'bearer',
            'bearer' => [
                ['key' => 'token', 'value' => '{{auth_token}}'],
            ],
        ];
    }

    protected function saveCollection(array $collection): string
    {
        $driver = $this->config['output']['driver'];
        $path = $this->config['output']['path'];
        $filename = str_replace('.json', '_with_groups.json', $this->config['output']['filename']);

        $disk = Storage::build([
            'driver' => $driver,
            'root' => $path,
        ]);

        $contents = json_encode($collection, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $disk->put($filename, $contents);

        return $disk->path($filename);
    }

    protected function generateGroupEnvironment(): string
    {
        $environment = [
            'id' => 'invest-learn-groups-environment',
            'name' => 'Investment Learning API - Groups Environment',
            'values' => [
                ['key' => 'base_url', 'value' => 'http://localhost:8000', 'type' => 'default', 'enabled' => true],
                ['key' => 'auth_token', 'value' => '', 'type' => 'secret', 'enabled' => true],
                ['key' => 'auth_prefix', 'value' => 'api/auth', 'type' => 'default', 'enabled' => true],
                ['key' => 'api_prefix', 'value' => 'api', 'type' => 'default', 'enabled' => true],
                ['key' => 'api_internal', 'value' => 'api/internal', 'type' => 'default', 'enabled' => true],
                ['key' => 'api_external', 'value' => 'api/external', 'type' => 'default', 'enabled' => true],
            ],
        ];

        $path = $this->config['output']['path'];
        $filename = 'invest_learn_groups_environment.json';

        $disk = Storage::build([
            'driver' => $this->config['output']['driver'],
            'root' => $path,
        ]);

        $contents = json_encode($environment, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        $disk->put($filename, $contents);

        return $disk->path($filename);
    }
}
