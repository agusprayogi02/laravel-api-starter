<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use YasinTgh\LaravelPostman\Collections\Builder;
use YasinTgh\LaravelPostman\Collections\RouteGrouper;

class PostmanCustomServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Extend the Postman Builder to support group-based URLs
        $this->app->extend(Builder::class, function ($builder, $app) {
            return new CustomPostmanBuilder(
                $app->make(RouteGrouper::class),
                config('postman')
            );
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

class CustomPostmanBuilder extends Builder
{
    protected function buildVariables(): array
    {
        $variables = [
            ['key' => 'base_url', 'value' => $this->config['base_url']],
        ];

        // Add group-based variables if enabled
        if ($this->config['groups']['enabled'] ?? false) {
            $defaults = $this->config['groups']['defaults'] ?? [];

            foreach ($defaults as $key => $value) {
                $variables[] = [
                    'key' => $key,
                    'value' => $value,
                    'type' => 'default',
                ];
            }

            // Add composed URLs
            $groupMapping = $this->config['groups']['mapping'] ?? [];
            foreach ($groupMapping as $group => $pattern) {
                $urlKey = $group.'_url';
                if ($group === 'api') {
                    $urlKey = 'api_url';
                } elseif ($group === 'auth') {
                    $urlKey = 'auth_url';
                } elseif ($group === 'api-internal') {
                    $urlKey = 'internal_url';
                } elseif ($group === 'api-external') {
                    $urlKey = 'external_url';
                }

                $variables[] = [
                    'key' => $urlKey,
                    'value' => $pattern,
                    'type' => 'default',
                ];
            }
        }

        return $variables;
    }

    public function build(array $routes): array
    {
        $collection = [
            'info' => $this->buildInfo(),
            'item' => $this->routeGrouper->organize($routes),
            'variable' => $this->buildVariables(),
        ];

        if ($this->config['auth']['enabled'] ?? false) {
            $collection['auth'] = $this->buildAuth();
            $authVariables = $this->buildAuthVariables();
            $collection['variable'] = array_merge($collection['variable'], $authVariables);
        }

        return $collection;
    }
}
