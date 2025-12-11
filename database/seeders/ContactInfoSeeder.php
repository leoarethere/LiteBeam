<?php

namespace Database\Seeders;

use App\Models\ContactInfo;
use Illuminate\Database\Seeder;

class ContactInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan tabel kosong dulu agar tidak duplikat saat di-seed ulang
        ContactInfo::truncate();

        ContactInfo::create([
            'admin_phone'       => '(021) 5704720',
            'partnership_phone' => '(021) 5733125',
            'hotline_phone'     => '0812-3456-7890', // Contoh nomor HP/WhatsApp
            'address'           => 'Jl. Gerbang Pemuda No. 8, Gelora, Kecamatan Tanah Abang, Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta 10270',
            'email'             => 'humas@tvri.go.id',
            'is_active'         => true,
        ]);
    }
}