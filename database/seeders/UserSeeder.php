<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'firstname' => 'Admin',
            'lastname' => 'Root',
            'email' => 'admin@crm.com',
            'email_verified_at' => now(),
            'image' => 'default.png',
            'admin' => true,
            'active' => true,
            'password' => Hash::make('admin'),//admin
            'remember_token' => Str::random(10)
        ]);

        DB::table('users')->insert([
            'firstname' => 'User',
            'lastname' => 'Basic',
            'email' => 'user@crm.com',
            'email_verified_at' => now(),
            'image' => 'default.png',
            'admin' => false,
            'active' => true,
            'password' => Hash::make('user'),//admin
            'remember_token' => Str::random(10)
        ]);

        DB::table('users')->insert([
            'firstname' => 'User',
            'lastname' => 'Basico Dos',
            'email' => 'user2@crm.com',
            'email_verified_at' => now(),
            'image' => 'default.png',
            'admin' => false,
            'active' => true,
            'password' => Hash::make('user'),//admin
            'remember_token' => Str::random(10)
        ]);
    }
}
