<?php

namespace App\Http\ViewComposers;

use App\Models\SettingGroup;
use Illuminate\View\View;

class SettingComposer
{
    public function compose(View $view)
    {
        $settings = SettingGroup::first()->settings;

        $app_logo = $settings->where('name', 'app_logo')->first()->value;
        $favicon = $settings->where('name', 'favicon')->first()->value;

        if($settings->where('name', 'app_logo')->first()->value == null) {
            $app_logo = 'uploads/site/logo/default.png';
        }
        if($settings->where('name', 'favicon')->first()->value == null) {
            $favicon = 'uploads/site/favicon/default.png';
        }

        $view->with([
            'app_name' => $settings->where('name', 'app_name')->first()->value,
            'app_description' => $settings->where('name', 'app_description')->first()->value,
            'app_logo' => $app_logo,
            'favicon' => $favicon,
            'app_author' => $settings->where('name', 'app_author')->first()->value,
            'app_version' => $settings->where('name', 'app_version')->first()->value,
            'app_name_small' => substr($settings->where('name', 'app_name')->first()->value, 0, 2),
        ]);
    }
}
