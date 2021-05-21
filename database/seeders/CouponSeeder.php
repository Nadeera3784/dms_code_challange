<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

use App\Models\Coupon;

class CouponSeeder extends Seeder{

    public function run(){

        Coupon::insert([
            [   
                'code' => '5rKzK9WH',
                'discount' => '10',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'code' => 'CN5CbjiP',
                'discount' => '20',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);

    }
}
