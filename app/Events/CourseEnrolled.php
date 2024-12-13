<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourseEnrolled implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $course;
    public $user;
    /**
     * Create a new event instance.
     */
    public function __construct($course, $user)
    {
        $this->course = $course;
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
       return new Channel('course-enrolled');
    }

    /**
     * Customize the broadcast name.
     */
    public function broadcastAs()
    {
        return 'course.enrolled';
    }

    /**
     * Customize the data sent with the broadcast.
     */
    public function broadcastWith()
    {
        return [
            'message' => $this->user->name . ' has enrolled in the course [' . $this->course->title . ']',
            'time' => now()->format('H:i:s'),
        ];
    }
}
