<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'code'  => 'OLH',
                'name'  => 'Olahraga'
            ],
            [
                'code'  => 'ALMSK',
                'name'  => 'Alat Musik'
            ]
        ];

        foreach ($categories as $row) {
            Category::create($row);
        }
    }
}
