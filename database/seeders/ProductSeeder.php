<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProductSeeder extends Seeder{

    public function run(){

        Product::insert([
            [
                'title' => 'Matilda',
                'slug' => Str::slug('Matilda', '-'),
                'category_id' => '1',
                'description' => 'Matilda Wormwood\'s father thinks she\'s a little scab. Matilda\'s mother spends all afternoon playing bingo.',
                'price' => '20',
                'author' => 'Quentin Blake',
                'image' => '1.jpg',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Charlie and the chocolate factory',
                'slug' => Str::slug('Charlie and the chocolate factory', '-'),
                'category_id' => '1',
                'description' => 'Mr Willy Wonka is the most extraordinary chocolate maker in the world.',
                'price' => '25',
                'author' => 'Roald Dahl',
                'image' => '2.jpg',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Fantastic mr fox',
                'slug' => Str::slug('Fantastic mr fox', '-'),
                'category_id' => '1',
                'description' => 'Boggis is an enormously fat chicken farmer who only eats boiled chickens smothered in fat. Bunce is a duck-and-goose farmer whose dinner gives him a beastly temper',
                'price' => '18',
                'author' => 'Quentin Blake',
                'image' => '3.jpg',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Realm breaker',
                'slug' => Str::slug('Realm breaker', '-'),
                'category_id' => '2',
                'description' => 'A strange darkness is growing in the Ward. Even Corayne an-Amarat can feel it, tucked away in her small town at the edge of the sea.',
                'price' => '35',
                'author' => 'Victoria Aveyard',
                'image' => '4.jpg',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'The song of achilles',
                'slug' => Str::slug('The song of achilles', '-'),
                'category_id' => '2',
                'description' => 'Greece in the age of heroes. Patroclus, an awkward young prince, has been exiled to the court of King Peleus and his perfect son Achilles. Despite their differences',
                'price' => '25',
                'author' => 'Madeline Miller',
                'image' => '5.jpg',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'The night circus',
                'slug' => Str::slug('The night circus', '-'),
                'category_id' => '2',
                'description' => 'n 1886 a mysterious travelling circus becomes an international sensation. Open only at night, constructed entirely in black and whites',
                'price' => '19',
                'author' => 'Erin Morgenstern',
                'image' => '6.jpg',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
