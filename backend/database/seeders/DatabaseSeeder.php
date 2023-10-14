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
    }
}
