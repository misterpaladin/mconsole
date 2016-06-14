<?php 

namespace Milax\Mconsole\Contracts;

interface ContentLocalizator
{
    /**
     * Localize object json fields
     *
     * @param  [object] $object
     * @param  [string] $lang [Language key]
     * @return [object]
     */
    public function localize($object, $lang = null);
}