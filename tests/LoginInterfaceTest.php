<?php

class LoginInterfaceTest extends TestCase
{
	
	public $user;
	
	public function startTestSuite()
	{
		parent::startTestSuite();
		\View::share('errors', new \Illuminate\Support\ViewErrorBag);
		\View::share('mconsole_menu', \Milax\Mconsole\Models\MconsoleMenu::getCached());
		\View::share('mconsole_options', \Milax\Mconsole\Models\MconsoleOption::getCached());
		\View::share('mconsole_changelog', 'Testing');
	}
	
	public function setUp()
	{
		parent::setUp();
		$this->user = factory(App\User::class)->create([
			'role_id' => 1,
			'password' => bcrypt('testing'),
		]);
	}
	
	/**
	 * Test if mconsole dashboard is working.
	 *
	 * @access public
	 * @return void
	 */
	public function testDashboardIsWorking()
	{
		$this->actingAs($this->user)->visit('/mconsole')->see($this->user->name);
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
		
		$this->visit('/mconsole/login')
			->type('test', 'login')
			->type('test', 'password')
			->press(trans('mconsole::login.buttons.login'))
			->seePageis('/mconsole/login');
	}

	/**
	 * Test user login success.
	 *
	 * @access public
	 * @return void
	 */
	public function testLoginSuccess()
	{
		$this->assertTrue(true);
		
		$this->visit('/mconsole/login')
			->type($this->user->email, 'login')
			->type('testing', 'password')
			->press(trans('mconsole::login.buttons.login'))
			->seePageIs('/mconsole')
			->see($this->user->name);
	}

	/**
	 * Test user logout success.
	 *
	 * @access public
	 * @return void
	 */
	public function testLogoutSuccess()
	{
		$this->assertTrue(true);

		$this->actingAs($this->user)
			->visit('/mconsole/logout')
			->seePageIs('/mconsole/login');
	}

	/**
	 * Cleanup
	 * 
	 * @return void
	 */
	public function tearDown()
	{
		\App\User::destroy($this->user->id);
	}

}
