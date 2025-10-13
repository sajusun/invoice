<?php

namespace App\Helpers;

use App\Models\AdminNotification;
use App\Events\AdminNotification as AdminNotificationEvent;
use App\Models\User;

class AdminNotifier
{
    private static $instance = null;
    private $title;
    private $message;
    private $route;

    private static function getInstance(): ?AdminNotifier
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public static function send(string $title, string $message, ?string $route = null): void
    {
        $notification = AdminNotification::create([
            'title' => $title,
            'message' => $message,
            'route' => $route,
        ]);

        broadcast(new AdminNotificationEvent($notification));

    }

    private function push(): void
    {
        $notification = AdminNotification::create([
            'title' => $this->title,
            'message' => $this->message,
            'route' => $this->route,
        ]);

        broadcast(new AdminNotificationEvent($notification));
    }


    public static function invoiceGenerate($invoice): void
    {
        $instance = self::getInstance();
        $instance->route = '#';
        $instance->title = " New Invoice";
        $instance->message = "A new invoice Generate " . $invoice;
        $instance->push();
    }
    public static function userRegister(User $user): void
    {
        $instance = self::getInstance();
        $instance->route = route('admin.dashboard.user.page', $user->id);
        $instance->title = "New User Registered";
        $instance->message = "A new user named ".$user->name ." just registered.";
        $instance->push();
    }
    public static function userDelete(User $user): void
    {
        $instance = self::getInstance();
        $instance->route = route('admin.dashboard.user.page', $user->id);
        $instance->title = "Account Delete";
        $instance->message = "A  user named ".$user->name ." just delete there account.";
        $instance->push();
    }

}
