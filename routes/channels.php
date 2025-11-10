<?php
use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('user.notifications.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
},['guards'=>['web']]);

Broadcast::channel('App.Models.Admin.{id}', function ($admin, $id) {
    return (int) $admin->id === (int) $id;
},['guards' => ['web', 'admin']]);

Broadcast::channel('admin.notifications', function ($admin) {
    return (int) auth('admin')->check();
},['guards' => ['web', 'admin']]);
