<?php

class ModelsTest extends TestCase
{
	
	/**
	 * Test models.
	 * 
	 * @access public
	 * @return void
	 */
	public function testModels()
	{
		foreach (glob(__DIR__ . '/../src/Milax/Mconsole/Models/*.php') as $file) {
			
			require_once $file;
			
			$class = basename($file, '.php');
			
			if (class_exists($class)) {
				// Model creation test
				$dbCount = \Milax\Mconsole\Models\Page::count();
				$object = \Milax\Mconsole\Models\Page::create([
					'slug' => str_random(16),
				]);
				$newDbCount = \Milax\Mconsole\Models\Page::count();
				$this->assertEquals($dbCount, $newDbCount - 1);
				
				// Tests depending on class
				switch ($class) {
					case 'Page':
						$now = \Carbon\Carbon::now()->format('m.d.Y');
						$this->assertEquals($object->updated, $now);
						break;
					
					case 'MconsoleMenu':
						$this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\BelongsToMany', $object->roles());
						break;
					
					case 'MconsoleRole':
						$this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\BelongsToMany', $object->menus());
						$this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\HasMany', $object->users());
						break;
					
					case 'MconsoleUser':
						$now = \Carbon\Carbon::now()->format('m.d.Y');
						$this->assertEquals($object->updated, $now);
						
						$this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\BelongsTo', $object->role());
						
						break;
				}
				
				// Deletion
				$page->delete();
				$newPagesCount = \Milax\Mconsole\Models\Page::count();
				$this->assertEquals($pagesCount, $newPagesCount);
			}
		}
	}
}
