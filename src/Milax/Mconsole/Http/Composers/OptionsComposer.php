<?php

namespace Milax\Mconsole\Http\Composers;

use Illuminate\View\View;
use Milax\Mconsole\Models\MconsoleOption;

class OptionsComposer
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
        $options = new \ stdClass();
        MconsoleOption::getCached()->each(function ($option) use (&$options) {
            $options->{$option->key} = $option->value;
        });

        $view->with('mconsole_options', $options);
    }
}
