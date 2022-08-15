<?php

namespace App\Policies;

use App\Models\Debt;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DebtPolicy
{
    use HandlesAuthorization;

    public function __construct()
    {
        //
    }

    /* public function isAuthor(User $user, Debt $debt)
    {
        return $debt->user_id === $user->id;
    } */
    /* public function isClient(User $user, User $client)
    {
        if($client->role_id===4){
            return true;
        }else{
            return false;
        }
    } */
}
