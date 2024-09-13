<?php

namespace Database\Seeders;

use App\Enums\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public const DATA_ROLE = [
        [
            "name" => "superadmin",
            "guard_name" => "sanctum"
        ],
        [
            "name" => "guru",
            "guard_name" => "sanctum"
        ],
        [
            "name" => "user",
            "guard_name" => "sanctum"
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::DATA_ROLE as $key => $role) {
            Role::create($role);
        }

        $role = Role::where("name", "superadmin")
            ->first();

        foreach (Permission::values() as $permission) {
            $role->givePermissionTo($permission);
        }
    }
}
