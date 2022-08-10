<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        //guarda nombre del rol admin
        $rol_admin=Role::where('name','admin')->first();
        //enlazarlo con 5 usuarios con FOR
        User::factory()->for($rol_admin)->count(2)->create();

        //guarda nombre del rol seller
        $rol_seller=Role::where('name','seller')->first();
        //enlazarlo con 5 usuarios con FOR
        User::factory()->for($rol_seller)->count(2)->create();

        //guarda nombre del rol passant
        $rol_passant=Role::where('name','passant')->first();
        //enlazarlo con 5 usuarios con FOR
        User::factory()->for($rol_passant)->count(2)->create();

        //guarda nombre del rol client
        $rol_client=Role::where('name','client')->first();
        //enlazarlo con 5 usuarios con FOR
        User::factory()->for($rol_client)->count(10)->create();
        
    }
}
