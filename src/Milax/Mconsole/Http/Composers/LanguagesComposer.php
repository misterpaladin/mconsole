<?php

namespace Milax\Mconsole\Http\Composers;

use Milax\Mconsole\Models\Language;
use Illuminate\View\View;

class LanguagesComposer
{
    public function compose(View $view)
    {
        $view->with('languages', Language::all());
    }
}
