<?php

namespace Database\Seeders\Menu;

use App\Models\Menu\RoleMenu;
use Illuminate\Database\Seeder;

class RoleMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoleMenu::query()
            ->insert([
                [
                    'role_id' => 1,
                    'menu_id' => 5,
                ],
                [
                    'role_id' => 1,
                    'menu_id' => 6,
                ],
                [
                    'role_id' => 1,
                    'menu_id' => 7,
                ]
            ]);
    }
}
