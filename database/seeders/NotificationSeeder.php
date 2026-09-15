<?php

namespace Database\Seeders;

use App\Models\AdminNotification;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Admin Notifications (if table empty or first run)
        if (AdminNotification::count() == 0) {
            $adminNotifications = [
                [
                    'title'   => 'New User Registered',
                    'message' => 'Sarah Jenkins registered for a Business subscription account.',
                    'route'   => '/admin/users',
                    'is_read' => false,
                ],
                [
                    'title'   => 'Payment Received',
                    'message' => 'Payment of $37.99 received via Stripe from Sarah Jenkins.',
                    'route'   => '/admin/payments',
                    'is_read' => false,
                ],
                [
                    'title'   => 'Plan Upgrade',
                    'message' => 'Test User upgraded subscription to Premium Plan.',
                    'route'   => '/admin/payments',
                    'is_read' => true,
                ],
                [
                    'title'   => 'System Backup Completed',
                    'message' => 'Automated nightly database backup completed successfully.',
                    'route'   => '/admin/settings',
                    'is_read' => true,
                ],
            ];

            foreach ($adminNotifications as $notif) {
                AdminNotification::create($notif);
            }
        }

        // 2. User Notifications (for test users)
        $testUser = User::where('email', 'testuser@example.com')->first();
        if ($testUser && UserNotification::where('user_id', $testUser->id)->count() == 0) {
            $userNotifications = [
                [
                    'user_id' => $testUser->id,
                    'title'   => 'Welcome to Invozen!',
                    'message' => 'Your account is ready. Start creating beautiful invoices in seconds.',
                    'route'   => '/invoice/create',
                    'is_read' => true,
                ],
                [
                    'user_id' => $testUser->id,
                    'title'   => 'Invoice Paid',
                    'message' => 'Invoice INV-1002 was marked as paid by Acme Corporation.',
                    'route'   => '/invoices',
                    'is_read' => false,
                ],
                [
                    'user_id' => $testUser->id,
                    'title'   => 'Subscription Active',
                    'message' => 'Your Premium subscription is active until ' . now()->addYear()->format('M d, Y') . '.',
                    'route'   => '/profile',
                    'is_read' => false,
                ],
            ];

            foreach ($userNotifications as $notif) {
                UserNotification::create($notif);
            }
        }
    }
}
