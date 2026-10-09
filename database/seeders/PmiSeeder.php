<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PmiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $pmis = [
            'PMI Tangerang Selatan',
            'PMI Kota Tangerang Selatan',
            'PMI Kota Tangerang',
            'PMI Kabupaten Tangerang',
            'PMI Jakarta Barat',
            'PMI Jakarta Selatan',
            'PMI Jakarta Utara',
            'PMI Jakarta Timur',
            'PMI Jakarta Pusat', // Added this as it's common
            'PMI DKI Jakarta',
        ];

        foreach ($pmis as $pmi) {
            \App\Models\Pmi::firstOrCreate(['name' => $pmi]);
        }
    }
}
