<?php

namespace Milax\Mconsole\Composers;

use Illuminate\View\View;
use Milax\Mconsole\Models\Language;

class LanguagesComposer
{
    /**
     * Compose mconsole options with app view.
     * 
     * @access public
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('languages', Language::all());
    }
}
