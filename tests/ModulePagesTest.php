<?php

class ModulePagesTest extends TestCase
{
    protected $user;

    /**
     * Share views.
     */
    public function startTestSuite()
    {
        parent::startTestSuite();
        \View::share('errors', new \Illuminate\Support\ViewErrorBag());
        \View::share('mconsole_menu', app('API')->menu->get());
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
     * Test module installation
     */
    public function testInstallModule()
    {
        $this->auth()->visit('/mconsole/modules');
        $this->auth()->visit('/mconsole/modules/mconsole-pages/install');
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
        
        $this->auth()->visit('/mconsole/pages/create')->see($this->user->name);
        
        $response = $this->auth()->call('POST', '/mconsole/pages', [
            'slug' => $slug,
            'heading' => $slug,
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

        $this->auth()->visit('/mconsole/pages/' . $page->id.'/edit')->see($this->user->name);

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
        $response = $this->auth()->call('DELETE', '/mconsole/pages/' . $page->id);
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
        // \App\User::destroy($this->user->id);
    }
}
