<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminNotification implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


//    public $user;
//    public $message;
//    public $route='#';
//
//    public function __construct(User $user, $message='New notification',$route='#')
//    {
//        $this->user = $user;
//        $this->message = $message;
//        $this->route=$route;
//
//    }
    public $notification;

    public function __construct(\App\Models\AdminNotification $notification)
    {
        $this->notification = $notification;
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('admin.notifications');
    }
//    public function broadcastWith(): array
//    {
//        return [
//            'id' => $this->user->id,
//            'name' => $this->user->name,
//            'email' => $this->user->email,
//            'message' => $this->message,
//            'route' => $this->route,
//        ];
//    }
    public function broadcastWith(): array
    {
        return [
            'id' => $this->notification->id,
            'title' => $this->notification->title,
            'message' => $this->notification->message,
            'route' => $this->notification->route,
            'is_read' => $this->notification->is_read,
            'created_at' => $this->notification->created_at->diffForHumans(),
        ];
    }
}
