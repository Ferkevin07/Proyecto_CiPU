<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Provider;
use App\Models\Product;

class ProviderSeeder extends Seeder
{
    public function run()
    {
        Provider::factory()->count(10)->create();

        //muchos a muchos -> tabla provider_products

        $products=Product::all();
        $providers=Provider::all();

        $providers->each(function($provider) use($products){
            $provider->products()->attach($products->shift(3));
        });
    }
}
