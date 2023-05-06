<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
        User::insert([
            [
                'name' => "Admin",
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'status' => 1
            ],
            [
                'name' => "Kasir",
                'email' => 'kasir@gmail.com',
                'password' => Hash::make('kasir'),
                'status' => 1
            ],
        ]);
    }
}
