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
			$namespaced = 'Milax\\Mconsole\\Models\\' . $class;
			
			if (class_exists($namespaced)) {
				// Model creation test
				
				$dbCount = $namespaced::count();
				
				if ($class == 'Page')
					$data['slug'] = str_random(16);
				else
					$data = [];
				
				$object = $namespaced::create($data);
				
				$newDbCount = $namespaced::count();
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
				$object->delete();
				$newCount = $namespaced::count();
				$this->assertEquals($dbCount, $newCount);
			}
		}
	}
}
