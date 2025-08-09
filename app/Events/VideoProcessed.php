<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VideoProcessed
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $videoData;
    public $processingType;

    public function __construct($videoData, $processingType = 'upload')
    {
        $this->videoData = $videoData;
        $this->processingType = $processingType;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('video-processing');
    }
}
