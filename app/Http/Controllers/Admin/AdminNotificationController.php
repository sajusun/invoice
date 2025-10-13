<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\AdminNotification;
use App\Models\Role;
use App\Services\Admin\AuthNeed;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminNotificationController extends Controller
{
    public function index()
    {
        return response()->json([
            'notifications' => AdminNotification::latest()->take(20)->get(),
            'unreadCount' => AdminNotification::where('is_read', false)->count(),
        ]);
    }

    public function markAsRead($id)
    {
        $notification = AdminNotification::find($id);

        if ($notification) {
            $notification->update(['is_read' => true]);
        }

        return response()->json(['success' => true]);
    }


}
