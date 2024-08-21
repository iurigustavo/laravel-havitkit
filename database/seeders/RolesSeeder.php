<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = $this->data();

        foreach ($data as $value) {
            Role::create([
                'name' => $value['name'],
                'description' => $value['description'],
            ]);
        }
    }

    public function data(): array
    {
        return [
            ['name' => 'admin',  'description' => 'Oversees system settings and user access, ensuring system stability.'],
            ['name' => 'editor',  'description' => 'Has viewing access to data but lacks editing privileges.'],
        ];
    }
}
