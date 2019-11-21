<?php

use App\Models\SettingGroup;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SettingGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settingGroups = [
            ['name' => 'Pengaturan Umum', 'slug' => Str::slug('Pengaturan Umum'), 'description' => 'Pengaturan umum seperti, judul situs, deskripsi situs, alamat dan sebagainya.', 'icon' => 'fas fa-cog', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        SettingGroup::insert($settingGroups);
    }
}
