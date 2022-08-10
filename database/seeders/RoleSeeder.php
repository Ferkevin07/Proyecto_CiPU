<?php

namespace Database\Seeders;
use App\Models\Role;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $rols =['admin','seller','passant','client'];

        for($i=0; $i<4; $i++)
        {
            Role::create([
                'name'=>$rols[$i]
            ]);
        }

    }
}
