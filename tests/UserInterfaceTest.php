<?php

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
		$this->boot();

		$user = $this->makeUser('testing');

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
	 * Test user login success.
	 *
	 * @access public
	 * @return void
	 */
	public function testLoginSuccess()
	{
		$this->assertTrue(true);
		$this->boot();

		$user = $this->makeUser('testing');

		$this->visit('/mconsole/login')
			->type($user->email, 'login')
			->type('testing', 'password')
			->press(trans('mconsole::login.buttons.login'))
			->seePageIs('/mconsole')
			->see($user->name);
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
		$this->boot();

		$this->actingAs($this->makeUser('testing'))
			->visit('/mconsole/logout')
			->seePageIs('/mconsole/login');
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
	protected function makeUser($pass)
	{
		return factory(App\User::class)->create([
			'role_id' => 1,
			'password' => bcrypt($pass),
		]);
	}

}
