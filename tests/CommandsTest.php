<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommandsTest extends TestCase
{

	public function testMconsoleInstaller()
	{
		$this->assertTrue(true);
		\Artisan::call('mconsole:install', [
			'--update' => true
		]);
	}

}
