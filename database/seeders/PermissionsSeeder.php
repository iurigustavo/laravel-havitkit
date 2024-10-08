<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $data = $this->data();

        $admin = Role::query()->where('name', 'admin')->first();

        foreach ($data as $value) {
            Permission::create([
                'name' => $value['name'],
                'description' => $value['description'],
                'guard_name' => 'web',
            ]);

            $admin->givePermissionTo($value['name']);
        }
    }

    public function data(): array
    {
        return [
            ['name' => 'management',  'description' => 'Management'],
            ['name' => 'impersonate',  'description' => 'Can impersonate an user'],
        ];
    }
}
