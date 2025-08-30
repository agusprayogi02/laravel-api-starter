<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;

class GenerateQueryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:query {name : The name of the query class}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate query builder class for advanced database queries';

    protected Filesystem $files;

    protected const STUB_PATH = __DIR__.'/../../../stubs/Query.stub';

    protected string $targetPath;

    protected string $singularClassName;

    protected string $singularModelName;

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
            ->setSingularModelName()
            ->setTargetFilePath()
            ->makeDirectory();

        if (! $this->files->exists($this->targetPath)) {
            $this->files->put($this->targetPath, $this->getTemplateFileContent());
            $this->info("✅ Query class created: {$this->targetPath}");
            $this->info("🎉 Successfully created query class: {$this->singularClassName}");
        } else {
            $this->warn("⚠️  Query class already exists: {$this->targetPath}");
            $this->comment('ℹ️  File already exists, no changes made.');
        }
    }

    private function getStubVariables(): array
    {
        $singularClassName = $this->singularClassName;

        $explodedClassName = explode('/', $singularClassName);

        $namespace = '';
        $explodedNamespace = explode('/', $singularClassName);

        $singularModelName = $this->singularModelName;
        $explodedModelName = explode('/', $singularModelName);
        // when namespace is more than 1 segment, remove last part because it is class name, and get previous part because its namespace dir
        if (count($explodedNamespace) > 1) {
            array_pop($explodedNamespace);
            $namespace = '\\'.implode('\\', $explodedNamespace);
        }

        return [
            'NAMESPACE' => ucwords(str_replace('/', '\\', config('services.target_query_dir', 'app/Queries'))).$namespace,
            'CLASS_NAME' => end($explodedClassName),
            'MODEL_NAME' => end($explodedModelName),
        ];
    }

    private function getTemplateFileContent()
    {
        $content = file_get_contents(self::STUB_PATH);

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

    private function setSingularModelName(): self
    {
        $modelname = $this->argument('name');
        $modelname = str_replace('Query', '', $modelname);

        $this->singularModelName = ucwords(Pluralizer::singular($modelname));

        return $this;
    }

    private function setTargetFilePath(): self
    {
        $className = $this->singularClassName;
        $this->targetPath = base_path(config('services.target_query_dir', 'app/Queries'))."/$className.php";

        return $this;
    }

    private function makeDirectory(): self
    {
        if (! $this->files->isDirectory(dirname($this->targetPath))) {
            $this->files->makeDirectory(dirname($this->targetPath), 0777, true, true);
        }

        return $this;
    }
}
