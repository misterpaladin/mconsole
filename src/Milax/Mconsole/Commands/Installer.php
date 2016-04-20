<?php

namespace Milax\Mconsole\Commands;

use DB;
use File;
use Illuminate\Console\Command;
use Milax\Mconsole\Seeds;
use Carbon;

class Installer extends Command
{
    protected $name;
    protected $email;
    protected $pass;
    protected $userCreated = false;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mconsole:install {--update : Run update without package initializing} {--quick : Run without copying assets}';

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
        if (!$this->option('quick')) {
            $this->components();
        }
        $this->migrate();
        $this->seeds();
        $this->modules();
        
        if (!$this->option('update')) {
            $this->users();
        }
        
        $this->cleanup();
        $this->finish();
    }
    
    /**
     * Install core package components
     *
     * @access protected
     * @return void
     */
    protected function components()
    {
        if ($this->option('update')) {
            $this->comment('Updating package components..');
        } else {
            $this->comment('Installing package components..');
        }
        
        $this->call('vendor:publish', [
            '--provider' => "Milax\Mconsole\Providers\MconsoleServiceProvider",
            '--force' => true,
        ]);
        $this->comment(null);
    }
    
    /**
     * Seed database.
     * 
     * @access protected
     * @return void
     */
    protected function seeds()
    {
        if ($this->option('update')) {
            $this->comment('Updating database records..');
        } else {
            $this->comment('Installing database components..');
        }
        
        $this->info(Seeds\MconsoleOptionsSeeder::run());
        $this->info(Seeds\MconsoleRolesSeeder::run());
        $this->info(Seeds\MconsoleLanguaugeSeeder::run());
        $this->info(Seeds\MconsoleMenusSeeder::run());
        
        $this->info('Done!');
        $this->comment(null);
    }
    
    /**
     * Create admin user
     *
     * @access protected
     * @return void
     */
    protected function users()
    {
        $this->comment('Creating admin user..');
        while (!$this->userCreated) {
            $email = $this->ask('Enter admin email');
            $name = $this->ask('Enter admin name');
            $pass = $this->ask('Enter admin password');
            if (DB::table('users')->where('email', $email)->count() == 0) {
                DB::table('users')->insert([
                    'role_id' => 1,
                    'name' => $name,
                    'email' => $email,
                    'password' => bcrypt($pass),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                $this->userCreated = true;
                $this->email = $email;
                $this->pass = $pass;
                $this->info('Done!');
            } else {
                $this->comment('User with email ' . $email . ' already exists!');
            }
        }
        $this->comment(null);
    }
    
    /**
     * Run database migration.
     * 
     * @access protected
     * @return void
     */
    protected function migrate()
    {
        $this->comment('Migrating database..');
        $this->call('migrate');
        $this->comment(null);
    }
    
    /**
     * Update modules
     * 
     * @return void
     */
    protected function modules()
    {
        $this->comment('Updating modules components..');
        app('API')->modules->get('installed')->each(function ($module) {
            app('API')->modules->install($module, true);
        });
        
        $this->comment('Updating translations..');
        File::deleteDirectory(storage_path('app/lang'));
        app('API')->translations->load();
    }
    
    /**
     * Clear application caches
     *
     * @access protected
     * @return void
     */
    protected function cleanup()
    {
        $this->call('cache:clear');
        $this->call('view:clear');
        $this->call('route:clear');
        $this->comment(null);
    }
    
    /**
     * Final steps, show finish message.
     * 
     * @access protected
     * @return void
     */
    protected function finish()
    {
        if ($this->option('update')) {
            $this->info('Update completed!');
        } else {
            $this->info('Installation completed! Visit ' . config('app.url') . '/mconsole, log in and enjoy!');
        }
        
        $this->comment(null);
        
        if ($this->userCreated) {
            $this->info('Admin login: ' . $this->email);
            $this->info('Admin password: ' . $this->pass);
            $this->comment(null);
        }
    }
}
