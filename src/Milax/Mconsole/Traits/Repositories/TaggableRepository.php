<?php

namespace Milax\Mconsole\Traits\Repositories;

/**
 * Makes repository taggable
 */
trait TaggableRepository {
    
    protected $repositoryName = 'Milax\Mconsole\Contracts\Repositories\TagsRepository';
    /**
     * Get query for specific tag
     * @param  string $tag [Tag name]
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tagQuery($tag) {
        return app($this->repositoryName)->query()->where('name', $tag)->first()->tagged($this->model);
    }

    /**
     * Get query for specific tag
     * @param  integer $tagId [Tag id]
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function tagQueryByID($tagId) {
        return app($this->repositoryName)->query()->where('id', $tagId)->first()->tagged($this->model);
    }
}