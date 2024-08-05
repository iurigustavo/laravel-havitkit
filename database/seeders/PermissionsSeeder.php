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
                'name'       => $value,
                'guard_name' => 'web',
            ]);

            $admin->givePermissionTo($value);
        }
    }

    public function data(): array
    {
        return [
            'management',
            'impersonate',
        ];
    }
}
