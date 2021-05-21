<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder{

    public function run(){
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(CouponSeeder::class);
    }
}
