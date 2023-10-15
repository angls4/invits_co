<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Models
use App\Models\Invitation;
use App\Models\Wedding;

class WeddingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /*
        * Weddings Seed
        * ------------------
        */

       // DB::table('weddings')->truncate();
       // echo "Truncate: weddings \n";

       $invitations = Invitation::all();
       foreach ($invitations as $invitaion) {
           Wedding::factory()->create(['invitation_id' => $invitaion->id]);
       }
       $rows = Wedding::all();
       echo " Insert: weddings \n\n";
    }
}
