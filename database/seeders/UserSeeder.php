<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Akun Admin (Petugas Fasilitas)
        User::create([
            'name' => 'Petugas Fasilitas FST',
            'email' => 'admin@uinjkt.ac.id',
            'password' => Hash::make('password123'), // Default password
            'role' => 'admin',
        ]);

        // 2. Akun Mahasiswa (Menggunakan data Anda)
        User::create([
            'name' => 'Reyhan Ribelfa',
            'email' => 'reyhan@mhs.uinjkt.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        // 3. Akun Dosen
        User::create([
            'name' => 'Hendra Bayu Suseno M.Kom',
            'email' => 'hendra.bayu@uinjkt.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'dosen',
        ]);
        
        // (Opsional) Tambahkan beberapa mahasiswa dummy lain jika ingin tes banyak data
        User::create([
            'name' => 'Mahasiswa Dummy',
            'email' => 'dummy@mhs.uinjkt.ac.id',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);
    }
}
