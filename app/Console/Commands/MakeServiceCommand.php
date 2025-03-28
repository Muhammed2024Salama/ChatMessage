<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service {name : The name of the service}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service class';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $filesystem = app(Filesystem::class);

        $path = app_path("Services/{$name}.php");

        if ($filesystem->exists($path)) {
            $this->error("Service {$name} already exists!");
            return Command::FAILURE;
        }

        $filesystem->ensureDirectoryExists(app_path('Services'));

        $stub = <<<PHP
        <?php

        namespace App\Services;

        class {$name}
        {
            //
        }
        PHP;

        $filesystem->put($path, $stub);

        $this->info("Service {$name} created successfully!");
        return Command::SUCCESS;
    }
}
