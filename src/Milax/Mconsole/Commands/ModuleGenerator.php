<?php

namespace Milax\Mconsole\Commands;

use Illuminate\Console\Command;
use Milax\Mconsole\Models\Language;
use File;
use Schema;

class ModuleGenerator extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {class : Module class name} {--namespace= : Specify module namespace} {--package : Add composer.json to the project, set namespaces and workbench directories}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Mconsole module';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->blueprint = [
            'bootstrap' => [
                'destination' => 'bootstrap.php',
                'file' => file_get_contents(__DIR__ . '/../Blueprints/Module/bootstrap.php'),
            ],
            'installer' => [
                'destination' => 'Installer.php',
                'file' => file_get_contents(__DIR__ . '/../Blueprints/Module/Installer.php'),
            ],
            'routes' => [
                'destination' => 'Http/routes.php',
                'file' => file_get_contents(__DIR__ . '/../Blueprints/Module/Http/routes.php'),
            ],
            'controller' => [
                'destination' => 'Http/Controllers/%sController.php',
                'file' => file_get_contents(__DIR__ . '/../Blueprints/Module/Http/Controllers/Controller.php'),
            ],
            'serviceprovider' => [
                'destination' => 'Provider.php',
                'file' => file_get_contents(__DIR__ . '/../Blueprints/Module/Provider.php'),
            ],
        ];
        
        $this->directories = [
            'assets/migrations',
            'assets/config',
            'assets/public/css',
            'assets/public/img',
            'assets/public/js',
            'assets/resources/views',
            'Models',
        ];
        
        if (Schema::hasTable(Language::getQuery()->from)) {
            Language::getCached()->each(function ($lang) {
                array_push($this->directories, 'assets/resources/lang/' . $lang->key);
            });
        }
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $package = $this->option('package');
        $class = $this->argument('class');
        
        if ($package) {
            $namespace = 'Milax\Mconsole';
            $path = base_path(sprintf('workbench/milax/mconsole-%s', strtolower($class)));
            $root = sprintf('%s/src/Milax/Mconsole/%s', $path, $class);
        } else {
            $namespace = 'App';
            $path = app_path(sprintf('Mconsole/%s', $class));
            $root = $path;
        }
        
        if ($this->option('namespace')) {
            $namespace = $this->option('namespace');
        }
        
        if (File::exists($path)) {
            return $this->error(sprintf('Module "%s" already exists!', $class));
        }
        
        File::makeDirectory(sprintf('%s/Http/Controllers', $root), 0775, true, true);
        File::put(sprintf('%s/%s', $root, $this->blueprint['bootstrap']['destination']), sprintf($this->blueprint['bootstrap']['file'], $namespace, $class, $class, $class, strtolower($class), $namespace, $class));
        File::put(sprintf('%s/%s', $root, $this->blueprint['routes']['destination']), sprintf($this->blueprint['routes']['file'], $class, $class));
        File::put(sprintf('%s/%s', $root, sprintf($this->blueprint['controller']['destination'], $class)), sprintf($this->blueprint['controller']['file'], $namespace, $class, $class, $class));
        File::put(sprintf('%s/%s', $root, $this->blueprint['installer']['destination']), sprintf($this->blueprint['installer']['file'], $namespace, $class));
        File::put(sprintf('%s/%s', $root, $this->blueprint['serviceprovider']['destination']), sprintf($this->blueprint['serviceprovider']['file'], $namespace, $class));
        
        foreach ($this->directories as $dir) {
            File::makeDirectory(sprintf('%s/%s', $root, sprintf($dir, $class)), 0775, true, true);
        }

        if ($package) {
            File::put(sprintf('%s/composer.json', $path), sprintf(file_get_contents(__DIR__ . '/../Blueprints/Module/composer.json'), strtolower($class), $class, $class));
            $this->info(sprintf('Package module "%s" was created! Don\'t forget to edit your composer.json file!', $class));
        } else {
            $this->info(sprintf('Module "%s" was created!', $class));
        }
    }
}
