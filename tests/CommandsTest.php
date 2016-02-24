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
		$exitCode = \Artisan::call('mconsole:install', [
			'--update' => true
		]);
		$this->assertEquals($exitCode, 0);
	}

}
