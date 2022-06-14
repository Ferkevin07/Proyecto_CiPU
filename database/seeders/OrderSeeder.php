<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class OrderSeeder extends Seeder
{
    public function run()
    {
        //se trae todos los usuario con state activo
        $users=User::all();
        //se crea 2 comentarios por usuario
        $users->each(function($user)
        {
            Order::factory()->count(3)->for($user)->create();
        });

        $orders=Order::all();

        $products=Product::all();

        $orders->each(function($order) use($products)
        {
            $order->products()->attach($products->shift(2));
        });
        
    }
}
