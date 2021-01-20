<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $adminUser = new User();
        $adminUser->name = 'Juango';
        $adminUser->email = 'admin@ventus.com';
        $adminUser->password = Hash::make('password');
        $adminUser->email_verified_at = now();
        $adminUser->remember_token = Str::random(10);
        $adminUser->save();
    }
}
