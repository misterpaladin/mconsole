<?php

namespace Milax\Mconsole\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        view()->composer('mconsole::app', 'Milax\Mconsole\Http\Composers\SectionComposer');
        view()->composer('mconsole::partials.menu', 'Milax\Mconsole\Http\Composers\MenuComposer');
        view()->composer('mconsole::app', 'Milax\Mconsole\Http\Composers\OptionsComposer');
        view()->composer('mconsole::partials.upload', 'Milax\Mconsole\Http\Composers\FormImagesUploadComposer');
        view()->composer('mconsole::forms.tags', 'Milax\Mconsole\Http\Composers\TagsInputComposer');
    }
}
