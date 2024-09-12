<?php

namespace Database\Seeders;

use App\Enums\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Permission::cases() as $key => $permission){
            \App\Models\Permission::create([
                "name" => $permission->value,
                "guard_name" => "sanctum",
                "description" => $permission->description(),
                "feature" => $permission->featureGroup()
            ]);
        }
    }
}
