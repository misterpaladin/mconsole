<?php

namespace Milax\Mconsole\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::composer('mconsole::app', 'Milax\Mconsole\Composers\SectionComposer');
        View::composer('mconsole::partials.menu', 'Milax\Mconsole\Composers\MenuComposer');
        View::composer('mconsole::app', 'Milax\Mconsole\Composers\OptionsComposer');
        View::composer(['mconsole::forms.upload', 'mconsole::uploads.form'], 'Milax\Mconsole\Composers\UploadFormComposer');
        View::composer('mconsole::forms.tags', 'Milax\Mconsole\Composers\TagsInputComposer');
        View::composer('mconsole::helpers.blade', 'Milax\Mconsole\Composers\BladeHelperViewComposer');
        View::composer('mconsole::forms.links', 'Milax\Mconsole\Composers\LinksSetsComposer');
        View::composer('mconsole::menu.form', 'Milax\Mconsole\Composers\LanguagesComposer');
    }
}
