<?php

namespace Milax\Mconsole\Components;

use Milax\Mconsole\Contracts\Components\SitemapHandler as Base;

class SitemapHandler implements Base
{
    public function handle($stack)
    {
        $links = collect();
        foreach ($stack as $handler) {
            $links = $links->merge($handler());
        }

        return response()->view('mconsole::components.sitemap', [
            'links' => $links,
            'base' => str_finish(app('API')->options->getByKey('project_url'), '/'),
        ])->header('Content-Type', 'text/xml');
    }
}