<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Firda Rahayu',
            'email' => 'firdarahayu105@gmail.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        Role::create([
            'name' => 'admin'
        ]);

        User::find(1)->roles()->attach([1]);
    }
}
