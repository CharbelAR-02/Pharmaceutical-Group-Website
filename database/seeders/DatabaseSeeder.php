<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Medication;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        $medications = [
            [
                'name' => 'ciprofloxacin',
                'category' => 'antibiotic',
                'state' => 'orals',
                // Add more columns and values as needed
            ],
            [
                'name' => 'ibuprofen',
                'category' => 'painkiller',
                'state' => 'tablet',
                // Add more columns and values as needed
            ],
            [
                'name' => 'acetaminophen',
                'category' => 'painkiller',
                'state' => 'tablet',
                // Add more columns and values as needed
            ],
            [
                'name' => 'amlodipine',
                'category' => 'antihypertensive',
                'state' => 'tablet',
                // Add more columns and values as needed
            ],
            [
                'name' => 'insulin',
                'category' => 'diabetes',
                'state' => 'injection',
                // Add more columns and values as needed
            ],
            [
                'name' => 'levothyroxine',
                'category' => 'thyroid',
                'state' => 'tablet',
                // Add more columns and values as needed
            ],
            [
                'name' => 'aspirin',
                'category' => 'painkiller',
                'state' => 'tablet',
                // Add more columns and values as needed
            ],
            [
                'name' => 'metformin',
                'category' => 'diabetes',
                'state' => 'tablet',
                // Add more columns and values as needed
            ],
            [
                'name' => 'warfarin',
                'category' => 'anticoagulant',
                'state' => 'tablet',
                // Add more columns and values as needed
            ],
            // Add more medication records here
            // ...
        ];

        DB::table('medications')->insert($medications);
    }
}
