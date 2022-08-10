<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            TypeSeeder::class,
            UserSeeder::class,
            CommentSeeder::class,
            ProductSeeder::class,
            OrderSeeder::class,
            ProviderSeeder::class,
            DebtSeeder::class
        ]);
    }
}
