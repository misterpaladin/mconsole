<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PagesTest extends TestCase
{
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testCacheRetain()
	{
		$this->assertTrue(true);
		
		// Pages creation test
		$pagesCount = \Milax\Mconsole\Models\Page::count();
		$page = \Milax\Mconsole\Models\Page::create([
			'slug' => str_random(16),
		]);
		$newPagesCount = \Milax\Mconsole\Models\Page::count();
		$this->assertEquals($pagesCount, $newPagesCount - 1);
		
		// Updated attribute
		$now = \Carbon\Carbon::now()->format('m.d.Y');
		$this->assertEquals($page->updated, $now);
		
		// Deletion
		$page->delete();
		$newPagesCount = \Milax\Mconsole\Models\Page::count();
		$this->assertEquals($pagesCount, $newPagesCount);
	}
}
