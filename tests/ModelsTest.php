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
				
				$data = [];
				
				if ($class == 'Page')
					$data['slug'] = str_random(16);
				
				if ($class == 'MconsoleUser')
					$data['email'] = str_random(10) . '@' . str_random(5) . 'com';
				
				$object = $namespaced::create($data);
				
				$newDbCount = $namespaced::count();
				$this->assertEquals($dbCount, $newDbCount - 1);
				
				// Tests depending on class
				switch ($class) {
					case 'MconsoleMenu':
						$this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\BelongsToMany', $object->roles());
						$this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\HasMany', $object->menus());
						$this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\BelongsTo', $object->menu());
						break;
					
					case 'MconsoleRole':
						$this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\BelongsToMany', $object->menus());
						$this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\HasMany', $object->users());
						break;
					
					case 'MconsoleUser':
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
