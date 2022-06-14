<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\Manager;

class ManagerSeeder extends Seeder
{
    public function run()
    {
        //guarda nombre del rol admin
        $rol_admin=Role::where('name','admin')->first();
        //enlazarlo con 5 usuarios con FOR
        Manager::factory()->for($rol_admin)->count(5)->create();
        //guarda nombre del rol seller
        $rol_seller=Role::where('name','seller')->first();
        //enlazarlo con 5 usuarios con FOR
        Manager::factory()->for($rol_seller)->count(5)->create();
        //guarda nombre del rol passant
        $rol_passant=Role::where('name','passant')->first();
        //enlazarlo con 5 usuarios con FOR
        Manager::factory()->for($rol_passant)->count(5)->create();
    }
}
