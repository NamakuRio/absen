<?php

use App\Models\SettingGroup;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            'generalSettings' => [
                ['name' => 'app_name', 'value' => 'Absen', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['name' => 'app_description', 'value' => 'Aplikasi Absen', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['name' => 'app_logo', 'value' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['name' => 'favicon', 'value' => null, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['name' => 'app_author', 'value' => 'CoffeeDev', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['name' => 'app_version', 'value' => '0.0.1', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ],
        ];

        foreach($settings['generalSettings'] as $setting){
            $settingGroup = SettingGroup::find(['id' => 1])->first();
            $settingGroup->settings()->create($setting);
        }
    }
}
