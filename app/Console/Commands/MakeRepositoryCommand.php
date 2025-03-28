<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeRepositoryCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name : The name of the repository}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $filesystem = app(Filesystem::class);

        $path = app_path("Repository/{$name}.php");

        if ($filesystem->exists($path)) {
            $this->error("Repository {$name} already exists!");
            return Command::FAILURE;
        }

        $filesystem->ensureDirectoryExists(app_path('Repository'));

        $stub = <<<PHP
        <?php

        namespace App\Repository;

        class {$name}
        {
            //
        }
        PHP;

        $filesystem->put($path, $stub);

        $this->info("Repository {$name} created successfully!");
        return Command::SUCCESS;
    }
}
