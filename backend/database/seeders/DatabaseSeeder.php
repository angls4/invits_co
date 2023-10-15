<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call('Database\Seeders\UserSeeder');
        $this->call('Database\Seeders\PackageSeeder');
        $this->call('Database\Seeders\ThemeSeeder');
        $this->call('Database\Seeders\OrderSeeder');
        $this->call('Database\Seeders\PaymentSeeder');
        $this->call('Database\Seeders\InvitationTypeSeeder');
        $this->call('Database\Seeders\InvitationSeeder');
        $this->call('Database\Seeders\GuestSeeder');
    }
}
