<?php

use App\Models\Permission;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['name' => 'setting_group.create', 'guard_name' => 'Menambahkan Kelompok Pengaturan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'setting_group.view', 'guard_name' => 'Melihat Kelompok Pengaturan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'setting_group.update', 'guard_name' => 'Memperbarui Kelompok Pengaturan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'setting_group.delete', 'guard_name' => 'Menghapus Kelompok Pengaturan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'setting_group.manage', 'guard_name' => 'Mengelola Kelompok Pengaturan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'setting.create', 'guard_name' => 'Menambahkan Pengaturan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'setting.view', 'guard_name' => 'Melihat Pengaturan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'setting.update', 'guard_name' => 'Memperbarui Pengaturan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'setting.delete', 'guard_name' => 'Menghapus Pengaturan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'setting.manage', 'guard_name' => 'Mengelola Pengaturan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'role.create', 'guard_name' => 'Menambahkan Peran', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'role.view', 'guard_name' => 'Melihat Peran', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'role.update', 'guard_name' => 'Memperbarui Peran', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'role.delete', 'guard_name' => 'Menghapus Peran', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'role.manage', 'guard_name' => 'Mengelola Peran', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'permission.create', 'guard_name' => 'Menambahkan Izin', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'permission.view', 'guard_name' => 'Melihat Izin', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'permission.update', 'guard_name' => 'Memperbarui Izin', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'permission.delete', 'guard_name' => 'Menghapus Izin', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'user.create', 'guard_name' => 'Menambahkan Pengguna', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'user.view', 'guard_name' => 'Melihat Pengguna', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'user.update', 'guard_name' => 'Memperbarui Pengguna', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'user.delete', 'guard_name' => 'Menghapus Pengguna', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'user.manage', 'guard_name' => 'Mengelola Pengguna', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'employee.create', 'guard_name' => 'Menambahkan Karyawan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'employee.view', 'guard_name' => 'Melihat Karyawan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'employee.update', 'guard_name' => 'Memperbarui Karyawan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'employee.delete', 'guard_name' => 'Menghapus Karyawan', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'presence_type.create', 'guard_name' => 'Menambahkan Tipe Kehadiran', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'presence_type.view', 'guard_name' => 'Melihat Tipe Kehadiran', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'presence_type.update', 'guard_name' => 'Memperbarui Tipe Kehadiran', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'presence_type.delete', 'guard_name' => 'Menghapus Tipe Kehadiran', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'presence.view', 'guard_name' => 'Melihat Kehadiran', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            ['name' => 'presence_detail.view', 'guard_name' => 'Melihat Detail Kehadiran', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        foreach($permissions as $permission){
            $insert = Permission::create($permission);
            $insert->assignRole('developer');
        }
    }
}
