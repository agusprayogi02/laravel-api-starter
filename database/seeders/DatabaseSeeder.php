<?php

namespace Database\Seeders;

use Database\Seeders\General\AboutUsSeeder;
use Database\Seeders\General\ContactMeSeeder;
use Database\Seeders\Geo\GeoSeeder;
use Database\Seeders\Menu\MenuSeeder;
use Database\Seeders\Menu\RoleMenuSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            GeoSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            MenuSeeder::class,
            UserSeeder::class,
            RoleMenuSeeder::class,
            AboutUsSeeder::class,
            ContactMeSeeder::class,
        ]);
    }
}
