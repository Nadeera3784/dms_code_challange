<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Str;

use App\Models\Category;

class CategorySeeder extends Seeder{

    public function run(){

        Category::insert([
            [
                'title' => 'Children',
                'slug' => Str::slug('Children', '-'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Fiction',
                'slug' => Str::slug('Fictionk', '-'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);

    }
}
