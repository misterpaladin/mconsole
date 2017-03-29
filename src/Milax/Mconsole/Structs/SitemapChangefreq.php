<?php

namespace Milax\Mconsole\Structs;

abstract class SitemapChangefreq
{
    const Always = 'always';
    const Hourly = 'hourly';
    const Daily = 'daily';
    const Weekly = 'weekly';
    const Monthly = 'monthly';
    const Early = 'yearly';
    const Never = 'never';
}