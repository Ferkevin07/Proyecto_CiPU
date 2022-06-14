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
        $users=User::where('state',true)->get();
        //dd($users);
        //se crea 2 comentarios por usuario
        $users->each(function($user)
        {
            Comment::factory()->count(2)->for($user)->create();
        });
    }
}
