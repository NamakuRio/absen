<?php

namespace App\Models;

use App\Traits\SettingGroupTrait;
use Illuminate\Database\Eloquent\Model;

class SettingGroup extends Model
{
    use SettingGroupTrait;

    protected $fillable = ['name', 'slug', 'description', 'icon'];

    public function getRouteKeyName()
    {
        return "slug";
    }
}
