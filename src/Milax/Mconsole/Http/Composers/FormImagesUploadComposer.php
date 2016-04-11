<?php

namespace Milax\Mconsole\Http\Composers;

use Illuminate\View\View;
use Milax\Mconsole\Models\MconsoleUploadPreset;
use Request;

class FormImagesUploadComposer
{
    /**
     * Compose pages title and caption
     * 
     * @param  View   $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('presets', MconsoleUploadPreset::getCached());
    }
}
