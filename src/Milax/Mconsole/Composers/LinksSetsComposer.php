<?php

namespace Milax\Mconsole\Composers;

use Illuminate\View\View;

class LinksSetsComposer
{
    public function compose(View $view)
    {
        $view->with('linkable_sets', app('API')->links->getGroupedSets());
    }
}
