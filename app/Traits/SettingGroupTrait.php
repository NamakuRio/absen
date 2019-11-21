<?php

namespace App\Traits;

use App\Models\Setting;

trait SettingGroupTrait
{
    public function settings()
    {
        return $this->hasMany(Setting::class);
    }
}
