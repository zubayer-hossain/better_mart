<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeed extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create(
            [
                'name'              => 'Super Admin',
                'email'             => 'superadmin@proactiveservicing.com',
                'role_id'           => 1,
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'remember_token'    => Str::random(10),
                'address'           => NULL,
            ]
        );

        User::query()->create(
            [
                'name'              => 'Md. Rejaul Islam',
                'email'             => 'rejaul26@yahoo.com',
                'role_id'           => 2,
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'remember_token'    => Str::random(10),
                'address'           => NULL,
            ]
        );

        User::query()->create(
            [
                'name'              => 'Zubayer Hossain',
                'email'             => 'zubayer@gmail.com',
                'role_id'           => NULL,
                'email_verified_at' => now(),
                'password'          => Hash::make('password'),
                'remember_token'    => Str::random(10),
                'address'           => 'House#08, Road#02, Block#G, Mirpur-2, Dhaka.',
            ]
        );
    }
}
