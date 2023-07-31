<?php

namespace App\Policies\Topic;

use App\Models\Topic;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TopicPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Topic $topic)
    {
        $this->isOwner($user, $topic);
    }

    public function addQuestion(User $user, Topic $topic)
    {
        $this->isOwner($user, $topic);
    }

    private function isOwner(User $user, Topic $topic)
    {
        return $user->id === $topic->user_id
            ? Response::allow()
            : Response::deny('You do not own this topic.');
    }
}
