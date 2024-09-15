<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;

class GenerateApiControllerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:api {name : query filename}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for generate api controller';

    protected Filesystem $files;
    protected const STUB_PATH = __DIR__ . '/../../../stubs/Api.stub';
    protected const RESOURCE_PATH = __DIR__ . '/../../../stubs/Resource.stub';
    protected const COLLECTION_PATH = __DIR__ . '/../../../stubs/Collection.stub';
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

        if (!$this->files->exists($this->targetPath)) {
            $this->files->put($this->targetPath, $this->getTemplateFileContent(self::STUB_PATH));
            $this->info("File : {$this->targetPath} created");
        } else {
            $this->info("File : {$this->targetPath} already exits");
        }

        if (!$this->files->exists($this->collectionPath)) {
            $this->files->put($this->collectionPath, $this->getTemplateFileContent(self::COLLECTION_PATH));
            $this->info("File : {$this->collectionPath} created");
        } else {
            $this->info("File : {$this->collectionPath} already exits");
        }

        if (!$this->files->exists($this->resourcePath)) {
            $this->files->put($this->resourcePath, $this->getTemplateFileContent(self::RESOURCE_PATH));
            $this->info("File : {$this->resourcePath} created");
        } else {
            $this->info("File : {$this->resourcePath} already exits");
        }
    }

    /**
     * @param Filesystem $files
     */
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

        $explodedClassName = explode("/", $singularClassName);

        $namespace = "";
        $explodedNamespace = explode("/", $singularClassName);

        // when namespace is more than 1 segment, remove last part because it is class name, and get previous part because its namespace dir
        if (count($explodedNamespace) > 1) {
            array_pop($explodedNamespace);
            $namespace = "\\" . implode("\\", $explodedNamespace);
        }

        return [
            'NAMESPACE' => ucwords(str_replace("/", "\\", config("services.target_controller_dir", "app/Http/Controllers/Api/Internal"))) . $namespace,
            'RESOURCE_NAMESPACE' => ucwords(str_replace("/", "\\", config("services.target_resource_dir", "app/Http/Resources"))) . "\\" . str_replace("/", "\\", $singularClassName),
            'PREFIX_NAME' => str_replace("/", "\\", strtolower($singularClassName)),
            'ROUTE_NAME' => str_replace("/","." ,strtolower($singularClassName)),
            'CLASS_NAME' => end($explodedClassName),
            'SNAKE_NAME' => strtolower(end($explodedClassName)),
            "SINGULAR_NAME" => str_replace("/", "\\", $singularClassName),
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
        $explodedClassName = explode("/", $className);
        $name = end($explodedClassName);

        $this->targetPath = base_path( config("services.target_controller_dir","app/Http/Controllers/Api/Internal")) . "/$className" . "Controller.php";
        $this->collectionPath = base_path( config("services.target_resource_dir","app/Http/Resources")) ."/". $className . "/" . $name . "ResourceCollection.php";
        $this->resourcePath = base_path( config("services.target_resource_dir","app/Http/Resources")) ."/". $className . "/" . $name . "Resource.php";

        return $this;
    }


    private function makeDirectory(): self
    {
        if (!$this->files->isDirectory(dirname($this->targetPath))) {
            $this->files->makeDirectory(dirname($this->targetPath), 0777, true, true);
        }
        if (!$this->files->isDirectory(dirname($this->resourcePath))) {
            $this->files->makeDirectory(dirname($this->resourcePath), 0777, true, true);
        }

        return $this;
    }
}
