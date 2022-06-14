<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Type;

class TypeSeeder extends Seeder
{
    public function run()
    {
        $types =['parabrisas','ventolera','ventana derecha', 'ventada izquierda', 'parabrisas atras'];

        for($i=0; $i<5; $i++)
        {
            Type::create([
                'name'=>$types[$i]
            ]);
        }
    }
}
