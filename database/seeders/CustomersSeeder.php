<?php

namespace Database\Seeders;

use App\Models\Customers;
use App\Models\User;
use Illuminate\Database\Seeder;

class CustomersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testUser = User::where('email', 'testuser@example.com')->first() ?? User::first();

        // 1. Curated realistic customers for primary test user
        $curatedCustomers = [
            [
                'name'    => 'Acme Corporation',
                'email'   => 'billing@acmecorp.com',
                'phone'   => '+1 (555) 301-4455',
                'address' => '100 Industrial Parkway, Austin, TX 78701',
            ],
            [
                'name'    => 'Apex Digital Solutions',
                'email'   => 'accounts@apexdigital.io',
                'phone'   => '+1 (555) 412-8899',
                'address' => '75 Silicon Avenue, San Jose, CA 95113',
            ],
            [
                'name'    => 'CloudScale Technologies',
                'email'   => 'finance@cloudscale.net',
                'phone'   => '+1 (555) 523-1122',
                'address' => '220 Tech Hub Blvd, Seattle, WA 98101',
            ],
            [
                'name'    => 'BrightPath Marketing Group',
                'email'   => 'invoicing@brightpath.agency',
                'phone'   => '+1 (555) 634-3344',
                'address' => '45 Madison Avenue, Suite 12, New York, NY 10010',
            ],
            [
                'name'    => 'Global Logistics & Supply Ltd',
                'email'   => 'ap@globallogistics.com',
                'phone'   => '+1 (555) 745-5566',
                'address' => '890 Harbor Way, Miami, FL 33132',
            ],
            [
                'name'    => 'Nexus Creative Studio',
                'email'   => 'hello@nexuscreative.design',
                'phone'   => '+1 (555) 856-7788',
                'address' => '310 Arts District St, Denver, CO 80202',
            ],
            [
                'name'    => 'Quantum Systems LLC',
                'email'   => 'finance@quantumsys.com',
                'phone'   => '+1 (555) 967-9900',
                'address' => '500 Innovation Loop, Boston, MA 02110',
            ],
            [
                'name'    => 'BlueHorizon Media',
                'email'   => 'payments@bluehorizon.co',
                'phone'   => '+1 (555) 178-2233',
                'address' => '120 Ocean Drive, Santa Monica, CA 90401',
            ],
            [
                'name'    => 'Vertex Innovations',
                'email'   => 'billing@vertexinnovations.io',
                'phone'   => '+1 (555) 289-4455',
                'address' => '404 Founders Row, Chicago, IL 60606',
            ],
            [
                'name'    => 'Summit Consulting Partners',
                'email'   => 'accounting@summitcp.com',
                'phone'   => '+1 (555) 390-6677',
                'address' => '600 High St, Columbus, OH 43215',
            ],
            [
                'name'    => 'Echo Dynamics Robotics',
                'email'   => 'purchasing@echodynamics.ai',
                'phone'   => '+1 (555) 491-8800',
                'address' => '77 Automation Dr, Pittsburgh, PA 15213',
            ],
            [
                'name'    => 'Starlight Retail Ventures',
                'email'   => 'orders@starlightretail.com',
                'phone'   => '+1 (555) 592-1133',
                'address' => '300 Commerce Way, Dallas, TX 75201',
            ],
        ];

        if ($testUser) {
            foreach ($curatedCustomers as $cust) {
                Customers::updateOrCreate(
                    [
                        'user_id' => $testUser->id,
                        'email'   => $cust['email'],
                    ],
                    [
                        'name'       => $cust['name'],
                        'phone'      => $cust['phone'],
                        'address'    => $cust['address'],
                        'created_at' => now()->subDays(rand(10, 100)),
                        'updated_at' => now(),
                    ]
                );
            }
        }

        // 2. Add customers for all other users if they don't have customers yet
        $otherUsers = User::where('id', '!=', $testUser?->id)->get();
        foreach ($otherUsers as $user) {
            if ($user->customers()->count() == 0) {
                Customers::factory()->count(rand(2, 4))->create([
                    'user_id' => $user->id,
                ]);
            }
        }
    }
}
