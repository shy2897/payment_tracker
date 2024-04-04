<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SubcategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        $categories = ['product', 'annual', 'change', 'capex', 'opex'];

        for ($i = 2015; $i <= 2040; $i++) {
            foreach ($categories as $category) {
                $data[] = [
                    'year' => $i,
                    'category' => $category,
                    'sub_category' => 'No Category',
                    'budget' => 0,
                    'balance' => 0,
                ];
            }
        }

        DB::table('categories')->insert($data);
    }
}
