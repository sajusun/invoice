<?php

namespace App\Helpers;

use App\Models\AdminNotification;
use App\Events\AdminNotification as AdminNotificationEvent;
use App\Models\Invoices;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Throwable;

class AdminNotifier
{
    private static AdminNotifier|null $instance = null;
    private string $title;
    private string $message;
    private ?string $route = null;

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
            'title'   => $title,
            'message' => $message,
            'route'   => $route,
        ]);

        try {
            broadcast(new AdminNotificationEvent($notification));
        } catch (Throwable $e) {
            Log::warning('Websocket broadcast failed: ' . $e->getMessage());
        }
    }

    private function push(): void
    {
        $notification = AdminNotification::create([
            'title'   => $this->title,
            'message' => $this->message,
            'route'   => $this->route,
        ]);

        try {
            broadcast(new AdminNotificationEvent($notification));
        } catch (Throwable $e) {
            Log::warning('Websocket broadcast failed: ' . $e->getMessage());
        }
    }

    public static function invoiceGenerate(Invoices $invoice): void
    {
        $instance = self::getInstance();
        $instance->route = '#';
        $instance->title = "New Invoice";
        $instance->message = "A new invoice was generated: " . $invoice->invoice_number;
        $instance->push();
    }

    public static function userRegister(User $user): void
    {
        $instance = self::getInstance();
        $instance->route = route('admin.dashboard.user.page', $user->id);
        $instance->title = "New User Registered";
        $instance->message = "A new user named " . $user->name . " just registered.";
        $instance->push();
    }

    public static function userVerified(User $user): void
    {
        $instance = self::getInstance();
        $instance->route = route('admin.dashboard.user.page', $user->id);
        $instance->title = "Account Verification";
        $instance->message = "User " . $user->name . " has verified their account.";
        $instance->push();
    }

    public static function userDelete(User $user): void
    {
        $instance = self::getInstance();
        $instance->route = route('admin.dashboard.user.page', $user->id);
        $instance->title = "Account Deleted";
        $instance->message = "User " . $user->name . " has deleted their account.";
        $instance->push();
    }

    public static function purchasePlan(User $user): void
    {
        $instance = self::getInstance();
        $instance->route = route('admin.dashboard.user.page', $user->id);
        $instance->title = "Plan Purchased";
        $instance->message = "User " . $user->name . " purchased a plan.";
        $instance->push();
    }
}
