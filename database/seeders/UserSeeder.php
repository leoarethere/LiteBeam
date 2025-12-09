<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Menggunakan firstOrCreate untuk mencegah error jika user 'leo' sudah ada
        User::firstOrCreate(
            ['username' => 'leo'], // Kriteria pencarian unik
            [
                'name' => 'Leo',
                'email' => 'leonardounofficialz@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'remember_token' => Str::random(10)
            ]
        );
        
        // Buat 5 user dummy lainnya
        User::factory(5)->create();
    }
}