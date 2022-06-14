<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product;
use App\Models\Type;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $types=Type::all();
        //dd($types);
        //dd(count($types));
        $types->each(function($type)
        {
            Product::factory()->count(10)->for($type)->create();
        });
    }
}
