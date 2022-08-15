<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    /* public function isAuthor(User $user, Comment $comment)
    {
        return false;
        //$comment->user_id === $user->id;
    } */

    public function isClient(User $user, User $client)
    {
        if($client->role->id===4){
            return true;
        }else{
            return false;
        }
    }
}
