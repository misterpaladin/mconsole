<?php

namespace Milax\Mconsole;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
	protected $fillable = ['slug', 'title', 'heading', 'preview', 'text', 'description', 'hide_heading', 'fullwidth', 'system', 'enabled'];
}
