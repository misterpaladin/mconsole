<?php

namespace Milax\Mconsole\Composers;

use Illuminate\View\View;
use Milax\Mconsole\Models\Variable;

class BladeHelperViewComposer
{
    /**
     * Compose pages title and caption
     * 
     * @param  View   $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('variables', Variable::getCached()->sortBy('key'));
    }
}
