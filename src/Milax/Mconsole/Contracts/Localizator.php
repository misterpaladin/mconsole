<?php

namespace Milax\Mconsole\Contracts;

interface Localizator
{
    /**
     * Localize page content to given locale
     * 
     * @param  string $locale [Locale key]
     * @return void
     */
    public function localizePage(\Milax\Mconsole\Models\Page $page, $locale = null);
}
