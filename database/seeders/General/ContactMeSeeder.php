<?php

namespace Database\Seeders\General;

use App\Models\General\ContactMe;
use Illuminate\Database\Seeder;

class ContactMeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactMe::query()
            ->insert([
                [
                    'name' => 'Agus Prayogi',
                    'email' => 'agus@gmail.com',
                    'message' => 'Pelayanan Bagus',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'Diah Putri N',
                    'email' => 'puput@gmail.com',
                    'message' => 'Pelayanan Biasa Aja',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
            ]);
    }
}
