<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Models
use App\Models\Rsvp;

class RsvpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
         * rsvps Seed
         * ------------------
         */

        // DB::table('rsvps')->truncate();
        // echo "Truncate: rsvps \n";

        Rsvp::factory()->count(100)->create();
        $rows = Rsvp::all();
        echo " Insert: rsvps \n\n";
    }
}
