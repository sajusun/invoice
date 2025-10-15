<?php
namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\UserNotification;
use Illuminate\Http\Request;

class UserNotificationController extends Controller
{
    public function index(Request $request)
    {

        $notifications = UserNotification::where('user_id', $request->user_id)
            ->latest()->take(20)
            ->get();
        $unreadCount=UserNotification::where('is_read', false)->count();

        return response()->json([
            'notifications'=>$notifications,
            'unreadCount'=>$unreadCount,
        ]);
    }

    public function markAsRead($id)
    {
        $notification = UserNotification::findOrFail($id);
        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}
