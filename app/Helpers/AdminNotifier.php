<?php

namespace App\Helpers;

use App\Models\AdminNotification;
use App\Events\AdminNotification as AdminNotificationEvent;
use App\Models\Invoices;
use App\Models\User;

class AdminNotifier
{
    private static AdminNotifier|null $instance = null;
    private string $title;
    private string $message;
    private string $route;

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


    public static function invoiceGenerate(Invoices $invoice): void
    {
        $instance = self::getInstance();
        $instance->route = '#';
        $instance->title = " New Invoice";
        $instance->message = "A new invoice Generate " . $invoice->id;
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
    public static function userVerified(User $user): void
    {
        $instance = self::getInstance();
        $instance->route = route('admin.dashboard.user.page', $user->id);
        $instance->title = "Account Verification";
        $instance->message = "A user named ".$user->name ." just verified there account.";
        $instance->push();
    }
    public static function userDelete(User $user): void
    {
        $instance = self::getInstance();
        $instance->route = route('admin.dashboard.user.page', $user->id);
        $instance->title = "Account Delete";
        $instance->message = "A  user named ".$user->name ." just delete there account.";
        $instance->push();
    } public static function purchasePlan(User $user): void
    {
        $instance = self::getInstance();
        $instance->route = route('admin.dashboard.user.page', $user->id);
        $instance->title = "Purchase Plan";
        $instance->message = "A  user named ".$user->name ." just Purchase a plan.";
        $instance->push();
    }

}
