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
        view()->composer('mconsole::app', 'Milax\Mconsole\Composers\SectionComposer');
        view()->composer('mconsole::partials.menu', 'Milax\Mconsole\Composers\MenuComposer');
        view()->composer('mconsole::app', 'Milax\Mconsole\Composers\OptionsComposer');
        view()->composer('mconsole::forms.upload', 'Milax\Mconsole\Composers\UploadFormComposer');
        view()->composer('mconsole::forms.tags', 'Milax\Mconsole\Composers\TagsInputComposer');
        view()->composer('mconsole::helpers.blade', 'Milax\Mconsole\Composers\BladeHelperViewComposer');
    }
}
