<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UserHasRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The authenticated user.
     *
     * @var \Illuminate\Contracts\Auth\Authenticatable
     */
    public $User;

    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable $user
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->User = $user;
    }
}
