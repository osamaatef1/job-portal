<?php

namespace App\Notifications;

use App\Events\UserRegistered;
use Illuminate\Notifications\Notification;

class SendRegistrationNotification extends Notification
{
    public function handle(UserRegistered $event)
    {
        Notification::create([
            'user_id' => $event->user->id,
            'type'    => 'registration',
            'message' => 'Welcome to our platform!'
        ]);

        // Send email notification
        $event->user->notify(new WelcomeNotification());
    }
}
