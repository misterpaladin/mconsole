<?php

namespace Milax\Mconsole\Composers;

use Illuminate\View\View;
use Milax\Mconsole\Models\Tag;

class TagsInputComposer
{
    /**
     * Compose tags list for form
     * 
     * @param  View   $view
     * @return void
     */
    public function compose(View $view)
    {
        return $view->with('allTags', Tag::getCached());
    }
}
