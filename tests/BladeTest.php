<?php

class BladeTest extends TestCase
{
	/**
	 * Test Blade renderer class.
	 *
	 * @return void
	 */
	public function testBladeRenderer()
	{
		$now = \Carbon\Carbon::now()->format('d.m.Y H:i');
		$blade = new \Milax\Mconsole\Blade\BladeRenderer("@datetime('d.m.Y H:i')");
		$this->assertEquals($now, $blade->render()->render());
	}
}
