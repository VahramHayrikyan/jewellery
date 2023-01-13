<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Test',
                'email' => 'test@gmail.com',
                'password' => Hash::make('password'),
                'group_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User Standard',
                'email' => 'user-standard@gmail.com',
                'password' => Hash::make('password'),
                'group_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'User VIP',
                'email' => 'user-vip@gmail.com',
                'password' => Hash::make('password'),
                'group_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
