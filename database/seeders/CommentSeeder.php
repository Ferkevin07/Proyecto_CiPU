<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Comment;
use App\Models\User;

class CommentSeeder extends Seeder
{
    public function run()
    {
        //se trae todos los usuario con state activo
        $clients=User::where('role_id','4')->get();
        //dd($users);
        //se crea 2 comentarios por usuario
        $clients->each(function($client)
        {
            Comment::factory()->count(2)->for($client)->create();
        });
    }
}
