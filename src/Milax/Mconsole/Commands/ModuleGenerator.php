<?php

namespace Milax\Mconsole\Commands;

use Illuminate\Console\Command;
use File;

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
    protected $description = 'Install mconsole package';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
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
            return $this->error(sprintf('Custom module %s already exists!', $class));
        }
        
        File::makeDirectory(app_path(sprintf('Mconsole/%s/Http/Controllers', $class)), 0775, true, true);
        File::put(app_path(sprintf('Mconsole/%s/Http/routes.php', $class)), sprintf("<?php

Route::group([
    'prefix' => 'mconsole',
    'middleware' => ['web', 'mconsole'],
    'namespace' => 'App\Mconsole\%s\Http\Controllers',
], function () {

    //

});
", $class));
        File::put(app_path(sprintf('Mconsole/%s/Http/Controllers/%sController.php', $class, $class)), sprintf("<?php

namespace App\Mconsole\%s\Http\Controllers;

use App\Http\Controllers\Controller;

class %sController extends Controller
{
    
    //
    
}
", $class, $class));
        File::makeDirectory(app_path(sprintf('Mconsole/%s/assets/migrations', $class)), 0775, true, true);
        File::makeDirectory(app_path(sprintf('Mconsole/%s/assets/config', $class)), 0775, true, true);
        File::makeDirectory(app_path(sprintf('Mconsole/%s/assets/resources', $class)), 0775, true, true);
    }
}
