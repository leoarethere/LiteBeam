<?php

namespace Database\Seeders;

use App\Models\Broadcast;
use Illuminate\Database\Seeder;

class BroadcastSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat 15 data dummy broadcast
        Broadcast::factory(15)->create();
    }
}