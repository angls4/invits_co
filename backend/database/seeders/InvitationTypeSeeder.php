<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Models
use App\Models\InvitationType;

class InvitationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        InvitationType::create([
            'type' => 'WEDDING'
        ]);

        echo " Insert: invitation_types \n\n";
    }
}
