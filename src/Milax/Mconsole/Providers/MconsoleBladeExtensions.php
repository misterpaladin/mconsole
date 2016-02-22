<?php

namespace Milax\Mconsole\Providers;

use Illuminate\Support\ServiceProvider;

use Milax\Mconsole\Models\MconsoleUploadPreset;

use Blade;
use View;

class MconsoleBladeExtensions extends ServiceProvider
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

		Blade::directive('upload', function ($expression) {
			$presets = MconsoleUploadPreset::getCached();
			return "<?php echo View::make('mconsole::mconsole.partials.upload')->with('presets', '{$presets}'); ?>";
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