<?php

namespace Milax\Mconsole\Repositories;

use Milax\Mconsole\Repositories\EloquentRepository;
use Milax\Mconsole\Contracts\Repositories\MenusRepository as Repository;
use Milax\Mconsole\Contracts\ContentLocalizator;

class MenusRepository extends EloquentRepository implements Repository
{
    public $model = \Milax\Mconsole\Models\Menu::class;

    protected $localizator;
    
    public function __construct(ContentLocalizator $localizator)
    {
        $this->localizator = $localizator;
    }

    public function findByKey($key, $lang = null)
    {
        $menu = $this->query()->where('key', $key)->firstOrFail();
        return $this->localizator->localize($menu, $lang);
    }
}
