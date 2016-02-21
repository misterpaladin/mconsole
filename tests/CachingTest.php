<?php

use Milax\Mconsole\Models\MconsoleUploadPreset;

class CachingTest extends TestCase
{
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testCacheRetain()
	{
		$old = MconsoleUploadPreset::getCached();
		$slug = str_random(8);
		MconsoleUploadPreset::create(['slug' => $slug]);
		$new = MconsoleUploadPreset::getCached();
		$this->assertEquals($old->count(), $new->count() - 1);
	}
}
