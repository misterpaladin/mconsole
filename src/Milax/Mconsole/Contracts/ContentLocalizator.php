<?php 

namespace Milax\Mconsole\Contracts;

interface ContentLocalizator
{
    /**
     * Localize object json fields
     *
     * @param  mixed $object
     * @param  string $lang [Language key]
     * @return mixed
     */
    public function localize($object, $lang = null);
}