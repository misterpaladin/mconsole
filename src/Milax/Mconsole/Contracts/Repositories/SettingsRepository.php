<?php

namespace Milax\Mconsole\Contracts\Repositories;

interface SettingsRepository
{
    /**
     * Get settings
     * 
     * @param  bool $withDisabled [Get disabled options]
     * @return Illuminate\Database\Collection
     */
    public function get($withDisabled = false);
}
