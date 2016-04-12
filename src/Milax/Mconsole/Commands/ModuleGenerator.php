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
    protected $signature = 'make:module {class=: class name of the module}';

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
                'destination' => 'Mconsole/%s/bootstrap.php',
                'file' => file_get_contents(__DIR__ . '/../Blueprints/Module/bootstrap.php'),
            ],
            'installer' => [
                'destination' => 'Mconsole/%s/Installer.php',
                'file' => file_get_contents(__DIR__ . '/../Blueprints/Module/Installer.php'),
            ],
            'routes' => [
                'destination' => 'Mconsole/%s/Http/routes.php',
                'file' => file_get_contents(__DIR__ . '/../Blueprints/Module/Http/routes.php'),
            ],
            'controller' => [
                'destination' => 'Mconsole/%s/Http/Controllers/%sController.php',
                'file' => file_get_contents(__DIR__ . '/../Blueprints/Module/Http/Controllers/Controller.php'),
            ],
        ];
        
        $this->directories = [
            'Mconsole/%s/assets/migrations',
            'Mconsole/%s/assets/config',
            'Mconsole/%s/assets/resources/views',
            'Mconsole/%s/Models',
        ];
        
        if (Schema::hasTable(Language::getQuery()->from)) {
            Language::getCached()->each(function ($lang) {
                array_push($this->directories, 'Mconsole/%s/assets/resources/lang/' . $lang->key);
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
        $class = $this->argument('class');
        
        if (File::exists(app_path(sprintf('Mconsole/%s', $class)))) {
            return $this->error(sprintf('Module %s already exists!', $class));
        }
        
        File::makeDirectory(app_path(sprintf('Mconsole/%s/Http/Controllers', $class)), 0775, true, true);
        
        File::put(app_path(sprintf($this->blueprint['bootstrap']['destination'], $class)), sprintf($this->blueprint['bootstrap']['file'], $class, $class, $class, strtolower($class)));
        File::put(app_path(sprintf($this->blueprint['routes']['destination'], $class)), sprintf($this->blueprint['routes']['file'], $class, $class));
        File::put(app_path(sprintf($this->blueprint['controller']['destination'], $class, $class)), sprintf($this->blueprint['controller']['file'], $class, $class, $class));
        File::put(app_path(sprintf($this->blueprint['installer']['destination'], $class, $class)), sprintf($this->blueprint['installer']['file'], $class));
        
        foreach ($this->directories as $dir) {
            File::makeDirectory(app_path(sprintf($dir, $class)), 0775, true, true);
        }
        
        $this->info(sprintf('Module %s was created!', $class));
    }
}
