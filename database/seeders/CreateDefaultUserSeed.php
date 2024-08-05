<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateDefaultUserSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = (new User())->firstOrCreate([
            'name'     => 'Administrator',
            'email'    => 'admin@admin.com',
            'password' => bcrypt('123456'),
            'active'   => 1,
        ]);

        $user->assignRole('admin');
    }
}
