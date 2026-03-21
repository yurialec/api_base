<?php

namespace Database\Seeders;

use App\Models\User;
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
        if (!User::where('email', 'yuri@email.com')->exists()) {
            User::create([
                'name' => 'Yuri',
                'email' => 'yuri@email.com',
                'password' => Hash::make('123456a!'),
            ]);
        }
    }
}
