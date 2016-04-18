<?php

namespace Milax\Mconsole\Composers;

use Illuminate\View\View;
use Milax\Mconsole\Models\MconsoleUploadPreset;
use Milax\Mconsole\Models\Language;
use Request;

class UploadFormComposer
{
    /**
     * Compose pages title and caption
     * 
     * @param  View   $view
     * @return void
     */
    public function compose(View $view)
    {
        $languages = Language::getCached()->lists('name', 'id');
        $languages->prepend(trans('mconsole::uploader.all'), 0);
        $view->with('presets', MconsoleUploadPreset::getCached())->with('languages', $languages);
    }
}
