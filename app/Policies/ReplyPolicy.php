<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reply;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Reply $reply)
    {
    	if (!$user->hasRole(['admin']))
            return $reply->user_id == $user->id;

        return true;
    }
}
