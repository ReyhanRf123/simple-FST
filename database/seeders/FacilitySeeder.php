<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \App\Models\Facility::insert([
            ['facility_name' => 'AC Lab Komputer', 'facility_score' => 3],
            ['facility_name' => 'Proyektor Ruang Kelas', 'facility_score' => 2],
            ['facility_name' => 'Jaringan Internet/WiFi', 'facility_score' => 3],
            ['facility_name' => 'Lampu Koridor', 'facility_score' => 1],
            ['facility_name' => 'Kursi Kuliah', 'facility_score' => 2],
        ]);
    }
}
