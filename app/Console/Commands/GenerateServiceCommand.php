<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;

class GenerateServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "make:service {name : service filename}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for generate service';


    protected Filesystem $files;
    protected const STUB_PATH = __DIR__ . '/../../../stubs/Service.stub';
    protected const STORE_REQ_PATH = __DIR__ . '/../../../stubs/StoreRequest.stub';
    protected const UPDATE_REQ_PATH = __DIR__ . '/../../../stubs/UpdateRequest.stub';
    protected string $targetPath;
    protected string $storeRequestPath;
    protected string $updateRequestPath;
    protected string $singularClassName;



    /**
     * @param Filesystem $files
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }


    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->setSingularClassName()
            ->setTargetFilePath()
            ->makeDirectory();


        if (!$this->files->exists($this->targetPath)) {
            $this->files->put($this->targetPath, $this->getTemplateFileContent());
            $this->info("File : {$this->targetPath} created");
        } else {
            $this->info("File : {$this->targetPath} already exits");
        }

        if (!$this->files->exists($this->storeRequestPath)) {
            $this->files->put($this->storeRequestPath, $this->getTemplateStoreReqFileContent());
            $this->info("File : {$this->storeRequestPath} created");
        } else {
            $this->info("File : {$this->storeRequestPath} already exits");
        }

        if (!$this->files->exists($this->updateRequestPath)) {
            $this->files->put($this->updateRequestPath, $this->getTemplateUpdateReqFileContent());
            $this->info("File : {$this->updateRequestPath} created");
        } else {
            $this->info("File : {$this->updateRequestPath} already exits");
        }
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
            'NAMESPACE' => ucwords(str_replace("/", "\\", config("services.target_service_dir", "app/Services"))) . $namespace,
            'REQUEST_NAMESPACE' => ucwords(str_replace("/", "\\", config("services.target_request_dir", "app/Http/Requests"))) . "\\" . str_replace("/", "\\", $singularClassName),
            'CLASS_NAME' => end($explodedClassName)
        ];
    }

    private function getTemplateFileContent(): array|false|string
    {
        $content = file_get_contents(self::STUB_PATH);

        foreach ($this->getStubVariables() as $search => $replace) {
            $content = str_replace("*$search*", $replace, $content);
        }

        return $content;
    }

    private function getTemplateStoreReqFileContent(): array|false|string
    {
        $content = file_get_contents(self::STORE_REQ_PATH);

        foreach ($this->getStubVariables() as $search => $replace) {
            $content = str_replace("*$search*", $replace, $content);
        }

        return $content;
    }

    private function getTemplateUpdateReqFileContent(): array|false|string
    {
        $content = file_get_contents(self::UPDATE_REQ_PATH);

        foreach ($this->getStubVariables() as $search => $replace) {
            $content = str_replace("*$search*", $replace, $content);
        }

        return $content;
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

        $this->targetPath = base_path( config("services.target_service_dir","app/Services")) . "/$className" . "Service.php";
        $this->storeRequestPath = base_path( config("services.target_request_dir","app/Http/Requests")) ."/". $className . "/Store" . $name . "Request.php";
        $this->updateRequestPath = base_path( config("services.target_request_dir","app/Http/Requests")) ."/". $className . "/Update" . $name . "Request.php";

        return $this;
    }

    private function makeDirectory(): self
    {
        if (!$this->files->isDirectory(dirname($this->targetPath))) {
            $this->files->makeDirectory(dirname($this->targetPath), 0777, true, true);
        }
        if (!$this->files->isDirectory(dirname($this->storeRequestPath))) {
            $this->files->makeDirectory(dirname($this->storeRequestPath), 0777, true, true);
        }

        return $this;
    }
}
