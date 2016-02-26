<?php

class PagesTest extends TestCase
{
    protected $user;

    /**
     * Share views.
     */
    public function startTestSuite()
    {
        parent::startTestSuite();
        \View::share('errors', new \Illuminate\Support\ViewErrorBag());
        \View::share('mconsole_menu', \Milax\Mconsole\Models\MconsoleMenu::getCached());
        \View::share('mconsole_options', \Milax\Mconsole\Models\MconsoleOption::getCached());
        \View::share('mconsole_changelog', 'Testing');
    }

    /**
     * Create test user.
     */
    public function setUp()
    {
        parent::setUp();
        $this->user = factory(App\User::class)->create([
            'role_id' => 1,
            'password' => bcrypt('testing'),
        ]);
    }

    /**
     * Test pages index.
     */
    public function testPagesIndex()
    {
        $this->auth()->visit('/mconsole/pages')->assertResponseOk();
    }

    /**
     * Test creating pages.
     */
    public function testPagesStore()
    {
        $dbCount = \DB::table('pages')->count();
        $slug = md5(time());

        $this->auth()->visit('/mconsole/pages')->assertResponseOk();

        $response = $this->auth()->call('POST', '/mconsole/pages', [
            'slug' => $slug,
            'title' => 'My Test Page',
            'heading' => $slug,
            'preview' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'description' => 'My test page',
        ]);
        $this->assertEquals(302, $response->status());
        $this->assertEquals($dbCount + 1, \DB::table('pages')->count());
        $this->auth()->visit('/mconsole/pages')->see($slug);
    }

    /**
     * Test updating pages.
     */
    public function testPageUpdate()
    {
        $slug = md5(time());
        $page = \DB::table('pages')->orderBy('id', 'desc')->first();

        $this->auth()->visit('/mconsole/pages/'.$page->id.'/edit')->assertResponseOk();

        $response = $this->auth()->call('POST', '/mconsole/pages/'.$page->id, [
            'slug' => $slug,
            '_method' => 'PUT',
        ]);
        $this->assertEquals(302, $response->status());
        $this->auth()->visit('/mconsole/pages');
    }

    /**
     * Test pages deletion.
     */
    public function testPagesDelete()
    {
        $dbCount = \DB::table('pages')->count();
        $page = \DB::table('pages')->orderBy('id', 'desc')->first();
        $response = $this->auth()->call('DELETE', '/mconsole/pages/'.$page->id);
        $this->assertEquals(302, $response->status());
        $this->assertEquals($dbCount - 1, \DB::table('pages')->count());
    }

    /**
     * Return authenticated SectionsTest.
     * 
     * @return SectionsTest
     */
    protected function auth()
    {
        return $this->actingAs($this->user);
    }

    /**
     * Cleanup.
     */
    public function tearDown()
    {
        \App\User::destroy($this->user->id);
    }
}
