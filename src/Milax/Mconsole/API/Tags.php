<?php

namespace Milax\Mconsole\API;

use Milax\Mconsole\Contracts\API\GenericAPI;
use Milax\Mconsole\Contracts\API\RepositoryAPI;
use Request;

class Tags extends RepositoryAPI implements GenericAPI
{
    public $model = \Milax\Mconsole\Models\Tag::class;
    public $categories = [];
    
    /**
     * Sync or detach tags
     * 
     * @param  mixed $instance [Related object instance]
     * @return void
     */
    public function sync($instance)
    {
        if ($tags = Request::input('tags')) {
            $instance->tags()->sync($tags);
        } else {
            $instance->tags()->detach();
        }
    }
    
    /**
     * Detach all tags
     *
     * @param mixed $instance [Taggable object]
     * @return mixed
     */
    public function detach($instance)
    {
        return $instance->tags()->detach();
    }

    /**
     * Register tag category
     * 
     * @param mixed $input [Could be string or string[]]
     * @return void
     */
    public function registerCategory($input)
    {
        if (is_array($input)) {
            $this->categories = array_merge($this->categories, $input);
        } else {
            array_push($this->categories, $input);
        }
    }

    /**
     * Get categories as select options array
     * 
     * @return array
     */
    public function getCategories()
    {
        $categories = array_combine($this->categories, $this->categories);
        array_unshift($categories, '—');

        return $categories;
    }
}
