<?php

namespace Milax\Mconsole\Contracts;

interface Menu
{
	/**
	 * Load menu from storage
	 * 
	 * @return Illuminate\Support\Collection
	 */
	public function load();
}