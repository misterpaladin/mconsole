<?php

class CommandsTest extends TestCase
{
	
	/**
	 * Test installer.
	 * 
	 * @access public
	 * @return void
	 */
	public function testMconsoleInstaller()
	{
		\Artisan::call('mconsole:install', [
			'--update' => true
		]);
	}

}
