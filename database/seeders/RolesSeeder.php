<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
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
                'name'        => $value,
                'description' => Str::title($value),
            ]);
        }
    }

    public function data(): array
    {
        return [
            'admin',
            'editor',
        ];
    }
}
