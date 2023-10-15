<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// Models
use App\Models\Package;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Package::create([
            'name'              => 'Bronze',
            'price'             => 'Rp. 100.000',
            'description'       => 'Paket yang memenuhi kebutuhan dasar undanganmu',
            'features'          => '<li>Informasi Dasar Pernikahan</li>',
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ]);

        Package::create([
            'name'              => 'Silver',
            'price'             => 'Rp. 300.000',
            'description'       => 'Pilihan paket membuat undanganmu lebih keren',
            'features'          => '<li>Informasi Dasar Pernikahan</li><li>Gallery</li><li>Konfirmasi Kehadiran</li>',
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ]);

        Package::create([
            'name'              => 'Gold',
            'price'             => 'Rp. 500.000',
            'description'       => 'Paket mewah lengkap untuk undanganmu',
            'features'          => '<li>Informasi Dasar Pernikahan</li><li>Gallery</li><li>Konfirmasi Kehadiran</li><li>Love Stories</li><li>Wishes & Gifts</li><li>Save to Google Calendar</li>',
            'created_at'        => Carbon::now(),
            'updated_at'        => Carbon::now(),
        ]);

        $rows = Package::all();
        echo " Insert: packages \n\n";
    }
}
