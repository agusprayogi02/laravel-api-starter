<?php

namespace Database\Seeders\General;

use App\Models\General\AboutUs;
use Illuminate\Database\Seeder;

class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AboutUs::query()
            ->insert([
                [
                    'title' => 'Profil Perusahaan',
                    'description' => '-- Description --',
                    'order'=> 1,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'title' => 'Visi Misi',
                    'description' => '-- Description --',
                    'order'=> 2,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'title' => 'Budaya Perusahaan',
                    'description' => '-- Description --',
                    'order'=> 3,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ]);
    }
}
