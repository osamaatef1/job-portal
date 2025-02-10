<?php

namespace App\Events;


use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class JobApplicationSubmitted implements ShouldBroadcast
{
    public function broadcastOn()
    {
        return new PrivateChannel('admin-channel');
    }

    public function broadcastWith()
    {
        return [
            'application_id' => $this->application->id,
            'job_title'      => $this->application->job->title
        ];
    }
}