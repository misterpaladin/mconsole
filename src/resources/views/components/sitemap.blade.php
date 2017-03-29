<?xml version="1.0" encoding="UTF-8"?>
<urlset
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
@foreach ($links as $link)
<url>
    <loc>{{ $base }}{{ $link->path }}</loc>
    @if ($link->changefreq)
        <changefreq>{{ $link->changefreq }}</changefreq>
    @endif
    @if ($link->lastmod)
        <lastmod>{{ $link->lastmod->format('Y-m-d') }}</lastmod>
    @endif
    @if ($link->priority)
        <priority>{{ $link->priority }}</priority>
    @endif
</url>
@endforeach
</urlset>