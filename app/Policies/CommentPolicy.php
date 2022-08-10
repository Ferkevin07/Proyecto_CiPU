<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function isAuthor(User $user, Comment $comment)
    {
        return $comment->user_id === $user->id;
    }
}


/* public function isActive(User $user, Comment $comments){

        return 
    } */

class OrderPolicy
{
    use HandlesAuthorization;

    public function isAuthor(User $user, Order $order)
    {
        return $order->user_id === $user->id;
    }
}