<?php

namespace Milax\Mconsole\Traits\Repositories;

/**
 * Makes repository taggable
 */
trait TaggableRepository {
    
    /**
     * Get query for specific tag
     * @param  string $tag [Tag name]
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tagQuery($tag) {
        return app('Milax\Mconsole\Contracts\Repositories\TagsRepository')->query()->where('name', $tag)->first()->tagged($this->model);
    }
}