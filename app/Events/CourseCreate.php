<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourseCreate implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $course;

    /**
     * Create a new event instance.
     */
    public function __construct($course)
    {
        $this->course = $course;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
       return new Channel('courses');
    }

    /**
     * Customize the broadcast name.
     */
    public function broadcastAs()
    {
        return 'course.create';
    }

    /**
     * Customize the data sent with the broadcast.
     */
    public function broadcastWith()
    {
        return [
            'message' => 'New course [' . $this->course->title . '] has been created',
            'time' => now()->format('H:i:s'),
            'course' => $this->course,
        ];
    }
}
