<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;

class GenerateApiControllerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:api {name : The name of the API controller}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate API controller with resource and collection classes';

    protected Filesystem $files;

    protected const STUB_PATH = __DIR__.'/../../../stubs/Api.stub';

    protected const RESOURCE_PATH = __DIR__.'/../../../stubs/Resource.stub';

    protected const COLLECTION_PATH = __DIR__.'/../../../stubs/Collection.stub';

    protected string $targetPath;

    protected string $collectionPath;

    protected string $resourcePath;

    protected string $singularClassName;

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->setSingularClassName()
            ->setTargetFilePath()
            ->makeDirectory();

        $created = 0;

        if (! $this->files->exists($this->targetPath)) {
            $this->files->put($this->targetPath, $this->getTemplateFileContent(self::STUB_PATH));
            $this->info("✅ Controller created: {$this->targetPath}");
            $created++;
        } else {
            $this->warn("⚠️  Controller already exists: {$this->targetPath}");
        }

        if (! $this->files->exists($this->collectionPath)) {
            $this->files->put($this->collectionPath, $this->getTemplateFileContent(self::COLLECTION_PATH));
            $this->info("✅ Resource Collection created: {$this->collectionPath}");
            $created++;
        } else {
            $this->warn("⚠️  Resource Collection already exists: {$this->collectionPath}");
        }

        if (! $this->files->exists($this->resourcePath)) {
            $this->files->put($this->resourcePath, $this->getTemplateFileContent(self::RESOURCE_PATH));
            $this->info("✅ Resource created: {$this->resourcePath}");
            $created++;
        } else {
            $this->warn("⚠️  Resource already exists: {$this->resourcePath}");
        }

        if ($created > 0) {
            $this->info("🎉 Successfully created {$created} file(s) for API controller: {$this->singularClassName}");
        } else {
            $this->comment('ℹ️  All files already exist, no changes made.');
        }
    }

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    private function getTemplateFileContent(string $stub): array|false|string
    {
        $content = file_get_contents($stub);

        foreach ($this->getStubVariables() as $search => $replace) {
            $content = str_replace("*$search*", $replace, $content);
        }

        return $content;
    }

    private function getStubVariables(): array
    {
        $singularClassName = $this->singularClassName;

        $explodedClassName = explode('/', $singularClassName);

        $namespace = '';
        $explodedNamespace = explode('/', $singularClassName);

        // when namespace is more than 1 segment, remove last part because it is class name, and get previous part because its namespace dir
        if (count($explodedNamespace) > 1) {
            array_pop($explodedNamespace);
            $namespace = '\\'.implode('\\', $explodedNamespace);
        }

        $prefix = '';
        foreach ($explodedClassName as $item) {
            $prefix .= Str::snake($item);
            if ($item !== end($explodedClassName)) {
                $prefix .= '/';
            }
        }

        return [
            'NAMESPACE' => ucwords(str_replace('/', '\\', config('services.target_controller_dir', 'app/Http/Controllers/Api/Internal'))).$namespace,
            'REQUEST_NAMESPACE' => ucwords(str_replace('/', '\\', config('services.target_request_dir', 'app/Http/Requests'))).'\\'.str_replace('/', '\\', $singularClassName),
            'RESOURCE_NAMESPACE' => ucwords(str_replace('/', '\\', config('services.target_resource_dir', 'app/Http/Resources'))).'\\'.str_replace('/', '\\', $singularClassName),
            'PREFIX_NAME' => $prefix,
            'ROUTE_NAME' => str_replace('/', '.', $prefix),
            'CLASS_NAME' => end($explodedClassName),
            'SNAKE_NAME' => Str::snake(end($explodedClassName)),
            'SINGULAR_NAME' => str_replace('/', '\\', $singularClassName),
        ];
    }

    private function setSingularClassName(): self
    {
        $this->singularClassName = ucwords(Pluralizer::singular($this->argument('name')));

        return $this;
    }

    private function setTargetFilePath(): self
    {
        $className = $this->singularClassName;
        $explodedClassName = explode('/', $className);
        $name = end($explodedClassName);

        $this->targetPath = base_path(config('services.target_controller_dir', 'app/Http/Controllers/Api/Internal'))."/$className".'Controller.php';
        $this->collectionPath = base_path(config('services.target_resource_dir', 'app/Http/Resources')).'/'.$className.'/'.$name.'ResourceCollection.php';
        $this->resourcePath = base_path(config('services.target_resource_dir', 'app/Http/Resources')).'/'.$className.'/'.$name.'Resource.php';

        return $this;
    }

    private function makeDirectory(): self
    {
        if (! $this->files->isDirectory(dirname($this->targetPath))) {
            $this->files->makeDirectory(dirname($this->targetPath), 0777, true, true);
        }
        if (! $this->files->isDirectory(dirname($this->resourcePath))) {
            $this->files->makeDirectory(dirname($this->resourcePath), 0777, true, true);
        }

        return $this;
    }
}
