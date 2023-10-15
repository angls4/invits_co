<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Models
use App\Models\Guest;

class GuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
         * guests Seed
         * ------------------
         */

        // DB::table('guests')->truncate();
        // echo "Truncate: guests \n";

        Guest::factory()->count(100)->create();
        $rows = Guest::all();
        echo " Insert: guests \n\n";
    }
}
