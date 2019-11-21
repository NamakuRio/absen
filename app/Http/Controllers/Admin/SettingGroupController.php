<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SettingGroup;
use Illuminate\Http\Request;

class SettingGroupController extends Controller
{
    public function index()
    {
        $setting_groups = SettingGroup::all();
        return view('admin.settings.index', compact('setting_groups'));
    }

    public function show(SettingGroup $settingGroup)
    {
        $setting_groups = SettingGroup::all();
        return view('admin.settings.show', compact(['setting_groups', 'settingGroup']));
    }
}
