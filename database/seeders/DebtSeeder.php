<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Debt;
use App\Models\User;

class DebtSeeder extends Seeder
{
    public function run()
    {
        $clients=User::where('role_id','4')->get();
        //$users=User::where('role_id','3')->get();

        for($i=1; $i<5; $i++)
        {
            /* if($i % 2 === 0)
            {
                Debt::factory()->for($users[$i])->create();
            }
            else
            {
                Debt::factory()->for($clients[$i])->create();
            } */
            Debt::factory()->for($clients[$i])->create();
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
