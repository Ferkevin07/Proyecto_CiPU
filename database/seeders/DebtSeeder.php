<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Debt;
use App\Models\Manager;
use App\Models\User;

class DebtSeeder extends Seeder
{
    public function run()
    {
        $managers=Manager::all();
        $users=User::all();

        for($i=1; $i<10; $i++)
        {
            if($i % 2 === 0)
            {
                Debt::factory()->for($users[$i])->create();
            }
            else
            {
                Debt::factory()->for($managers[$i])->create();
            }
            
        }
        /* $users->each(function($user)
        {
            Debt::factory()->for($user)->count(2)->create();
        });

        $debts=Debt::where('to_pay',false)->get();
        //dd(count($debts));
        $debts->each(function($debt)
        {
            Debt::factory()->for($users)->count(1)->create();
        }); */
        

    }
}
