<?php

namespace Database\Seeders;
use App\Models\Role;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $rols =['admin','seller','passant'];

        for($i=0; $i<3; $i++)
        {
            Role::create([
                'name'=>$rols[$i]
            ]);
        }
    }
}
