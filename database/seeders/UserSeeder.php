<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public const DATA_USER = [
        [
            "name" => "superadmin",
            "username" => "superadmin",
            "email" => "superadmin@mail.com",
            "password" => "superadmin",
            "phone" => "0895123123123",
            "email_verified_at" => "2024-08-07 08:06:45.000000",
        ],
        [
            "name" => "regularadmin",
            "username" => "regularadmin",
            "email" => "regularadmin@mail.com",
            "password" => "regularadmin",
            "phone" => "08951231231234",
            "email_verified_at" => "2024-08-07 08:06:45.000000",
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::DATA_USER as $user) {
            User::query()
                ->create($user);
        }

        $role = Role::query()
            ->where('name', 'superadmin')
            ->first();

        User::query()->where("username", "superadmin")
            ->first()
            ->assignRole($role);
    }
}
