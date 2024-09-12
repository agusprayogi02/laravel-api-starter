<?php

namespace Database\Seeders\Menu;

use App\Models\Menu\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::query()->insert([
            [
                'name' => 'App',
                'slug' => 'app',
                'level' => 1,
                'order' => 1,
                'icon' => null,
                'route' => '#',
                'parent_id' => null,
                'created_at' => '2023-09-05T01:46:53.000000Z',
                'updated_at' => '2023-09-05T01:46:53.000000Z',
            ],
            [
                'name' => 'Dashboard',
                'slug' => 'dashboard',
                'level' => 2,
                'order' => 1,
                'icon' => null,
                'route' => '#',
                'parent_id' => 1,
                'created_at' => '2023-09-05T01:46:53.000000Z',
                'updated_at' => '2023-09-05T01:46:53.000000Z',
            ],
            [
                'name' => 'Setup',
                'slug' => 'setup',
                'level' => 2,
                'order' => 2,
                'icon' => null,
                'route' => '#',
                'parent_id' => 1,
                'created_at' => '2023-09-05T01:46:53.000000Z',
                'updated_at' => '2023-09-05T01:46:53.000000Z',
            ],
            [
                'name' => 'Master',
                'slug' => 'master',
                'level' => 3,
                'order' => 1,
                'icon' => 'teacher',
                'route' => '#',
                'parent_id' => 2,
                'created_at' => '2023-09-05T01:46:53.000000Z',
                'updated_at' => '2023-09-05T01:46:53.000000Z',
            ],
            [
                'name' => 'User & Role',
                'slug' => 'userRole',
                'level' => 3,
                'order' => 99,
                'icon' => 'profile-circle',
                'route' => '#',
                'parent_id' => 3,
                'created_at' => '2023-09-05T01:46:53.000000Z',
                'updated_at' => '2023-09-05T01:46:53.000000Z',
            ],
            [
                'name' => 'Role Menu',
                'slug' => 'roleMenu',
                'level' => 4,
                'order' => 1,
                'icon' => null,
                'route' => '/setup/user-role/role-menu',
                'parent_id' => 5,
                'created_at' => '2023-09-05T01:46:53.000000Z',
                'updated_at' => '2023-09-05T01:46:53.000000Z',
            ],
            [
                'name' => 'Sync User to Role',
                'slug' => 'syncUserRole',
                'level' => 4,
                'order' => 2,
                'icon' => null,
                'route' => '/setup/user-role/sync-user-role',
                'parent_id' => 5,
                'created_at' => '2023-09-05T01:46:53.000000Z',
                'updated_at' => '2023-09-05T01:46:53.000000Z',
            ],
        ]);
    }
}
