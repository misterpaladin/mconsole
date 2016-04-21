<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserInterfaceTest extends TestCase
{

	/**
	 * Test if mconsole dashboard is working.
	 * 
	 * @access public
	 * @return void
	 */
	public function testDashboardIsWorking()
	{
		$this->assertTrue(true);
		$this->boot();
		
		$user = $this->makeUser();
		
		$this->actingAs($user)->visit('/mconsole')->see($user->name);
	}
	
	/**
	 * Test if MconsoleMiddleware is working.
	 * 
	 * @access public
	 * @return void
	 */
	public function testLoginFail()
	{
		$this->assertTrue(true);
		$this->boot();
		
		$this->visit('/mconsole/login')
			->type('test', 'login')
			->type('test', 'password')
			->press(trans('mconsole::login.buttons.login'))
			->seePageis('/mconsole/login');
	}
	
	/**
	 * Test login success.
	 * 
	 * @access public
	 * @return void
	 */
	public function testLoginSuccess()
	{
		$this->assertTrue(true);
		$this->boot();
		
		$user = $this->makeUser();
		
		$this->visit('/mconsole/login')
			->type($user->email, 'login')
			->type('testing', 'password')
			->press(trans('mconsole::login.buttons.login'))
			->seePageIs('/mconsole')
			->see($user->name);
	}
	
	/**
	 * Share required data with views.
	 * 
	 * @access protected
	 * @return void
	 */
	protected function boot()
	{
		\View::share('errors', new \Illuminate\Support\ViewErrorBag);
		\View::share('mconsole_menu', \Milax\Mconsole\Models\MconsoleMenu::getCached());
		\View::share('mconsole_options', \Milax\Mconsole\Models\MconsoleOption::getCached());
		\View::share('mconsole_changelog', 'Testing');
	}
	
	/**
	 * Make test user.
	 * 
	 * @access protected
	 * @return void
	 */
	protected function makeUser()
	{
		return factory(App\User::class)->create([
			'role_id' => 1,
			'password' => bcrypt('testing'),
		]);
	}
	
}
