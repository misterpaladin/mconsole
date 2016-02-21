<?php

namespace Milax\Mconsole\Commands;

use DB;

use Illuminate\Console\Command;

use Milax\Mconsole\Seeds\MconsoleOptionsSeeder;
use Milax\Mconsole\Seeds\MconsoleMenusSeeder;
use Milax\Mconsole\Seeds\MconsoleRolesSeeder;

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
	protected $signature = 'mconsole:install {--update : Run update without package initializing}';

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
		$this->components();
		$this->migrate();
		$this->seeds();
		
		if (!$this->option('update'))
			$this->users();
		
		$this->finish();
	}
	
	public function components()
	{
		if ($this->option('update'))
			$this->comment('Updating package components..');
		else
			$this->comment('Installing package components..');
		
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
		if ($this->option('update'))
			$this->comment('Updating database records..');
		else
			$this->comment('Installing database components..');
		
		$this->info(MconsoleOptionsSeeder::run());
		$this->info(MconsoleMenusSeeder::run());
		$this->info(MconsoleRolesSeeder::run());
		
		$this->info('Done!');
		$this->comment(null);
	}
	
	/**
	 * Create admin user
	 *
	 * @return void
	 */
	public function users()
	{
		$this->comment('Creating admin user..');
		while (!$this->userCreated) {
			$name = $this->ask('Enter admin name');
			$email = $this->ask('Enter admin email');
			$pass = $this->ask('Enter admin password');
			if (DB::table('users')->where('email', $email)->count() == 0) {
				DB::table('users')->insert([
					'role_id' => 1,
					'name' => $name,
					'email' => $email,
					'password' => bcrypt($pass),
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
	 * @access public
	 * @return void
	 */
	public function migrate()
	{
		$this->comment('Migrating database..');
		$this->call('migrate');
		$this->comment(null);
	}
	
	/**
	 * Show end message.
	 * 
	 * @access public
	 * @return void
	 */
	public function finish()
	{
		if ($this->option('update'))
			$this->comment('Update completed!');
		else
			$this->comment('Installation completed! Visit ' . config('app.url') . '/mconsole, log in and enjoy!');
		
		$this->comment(null);
		
		if ($this->userCreated) {
			$this->info('Admin login: ' . $this->email);
			$this->info('Admin password: ' . $this->pass);
			$this->comment(null);
		}
	}

}