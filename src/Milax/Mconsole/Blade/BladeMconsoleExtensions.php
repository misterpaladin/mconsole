<?php

namespace Milax\Mconsole\Blade;

use Illuminate\Support\ServiceProvider;

use App\File;
use App\Gallery;

use Blade;
use View;

class BladeMconsoleExtensions extends ServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		Blade::directive('datetime', function($expression) {
            return "<?php echo \Carbon\Carbon::now()->format({$expression}); ?>";
        });
	}

	/**
	 * Register the application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	protected function clean($string)
	{
		return str_replace(array( '(', ')' ), '', $string);
	}

}