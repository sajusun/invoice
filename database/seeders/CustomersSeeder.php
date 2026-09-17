<?php

namespace Database\Seeders;

use App\Models\Customer;
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
                'name'         => 'Acme Corporation',
                'company_name' => 'Acme Global Industries',
                'email'        => 'billing@acmecorp.com',
                'phone'        => '+1 (555) 301-4455',
                'tax_id'       => 'US-948271039',
                'address'      => '100 Industrial Parkway, Austin, TX 78701',
                'metadata'     => ['crm_id' => 'CRM-1001', 'tier' => 'enterprise'],
            ],
            [
                'name'         => 'Apex Digital Solutions',
                'company_name' => 'Apex Digital LLC',
                'email'        => 'accounts@apexdigital.io',
                'phone'        => '+1 (555) 412-8899',
                'tax_id'       => 'US-482910482',
                'address'      => '75 Silicon Avenue, San Jose, CA 95113',
                'metadata'     => ['crm_id' => 'CRM-1002', 'tier' => 'growth'],
            ],
            [
                'name'         => 'CloudScale Technologies',
                'company_name' => 'CloudScale Networks Inc.',
                'email'        => 'finance@cloudscale.net',
                'phone'        => '+1 (555) 523-1122',
                'tax_id'       => 'US-829104829',
                'address'      => '220 Tech Hub Blvd, Seattle, WA 98101',
                'metadata'     => ['crm_id' => 'CRM-1003', 'tier' => 'enterprise'],
            ],
            [
                'name'         => 'BrightPath Marketing Group',
                'company_name' => 'BrightPath Agency Inc.',
                'email'        => 'invoicing@brightpath.agency',
                'phone'        => '+1 (555) 634-3344',
                'tax_id'       => 'US-192837465',
                'address'      => '45 Madison Avenue, Suite 12, New York, NY 10010',
                'metadata'     => ['crm_id' => 'CRM-1004', 'tier' => 'standard'],
            ],
            [
                'name'         => 'Global Logistics & Supply Ltd',
                'company_name' => 'Global Logistics International',
                'email'        => 'ap@globallogistics.com',
                'phone'        => '+1 (555) 745-5566',
                'tax_id'       => 'US-564738291',
                'address'      => '890 Harbor Way, Miami, FL 33132',
                'metadata'     => ['crm_id' => 'CRM-1005', 'tier' => 'enterprise'],
            ],
            [
                'name'         => 'Nexus Creative Studio',
                'company_name' => 'Nexus Visual Design Ltd',
                'email'        => 'hello@nexuscreative.design',
                'phone'        => '+1 (555) 856-7788',
                'tax_id'       => 'US-839201928',
                'address'      => '310 Arts District St, Denver, CO 80202',
                'metadata'     => ['crm_id' => 'CRM-1006', 'tier' => 'standard'],
            ],
            [
                'name'         => 'Quantum Systems LLC',
                'company_name' => 'Quantum AI Systems',
                'email'        => 'finance@quantumsys.com',
                'phone'        => '+1 (555) 967-9900',
                'tax_id'       => 'US-928374650',
                'address'      => '500 Innovation Loop, Boston, MA 02110',
                'metadata'     => ['crm_id' => 'CRM-1007', 'tier' => 'enterprise'],
            ],
            [
                'name'         => 'BlueHorizon Media',
                'company_name' => 'BlueHorizon Studios',
                'email'        => 'payments@bluehorizon.co',
                'phone'        => '+1 (555) 178-2233',
                'tax_id'       => 'US-382910482',
                'address'      => '120 Ocean Drive, Santa Monica, CA 90401',
                'metadata'     => ['crm_id' => 'CRM-1008', 'tier' => 'standard'],
            ],
            [
                'name'         => 'Vertex Innovations',
                'company_name' => 'Vertex Labs Inc.',
                'email'        => 'billing@vertexinnovations.io',
                'phone'        => '+1 (555) 289-4455',
                'tax_id'       => 'US-473829102',
                'address'      => '404 Founders Row, Chicago, IL 60606',
                'metadata'     => ['crm_id' => 'CRM-1009', 'tier' => 'growth'],
            ],
            [
                'name'         => 'Summit Consulting Partners',
                'company_name' => 'Summit Advisors Group',
                'email'        => 'accounting@summitcp.com',
                'phone'        => '+1 (555) 390-6677',
                'tax_id'       => 'US-293847561',
                'address'      => '600 High St, Columbus, OH 43215',
                'metadata'     => ['crm_id' => 'CRM-1010', 'tier' => 'standard'],
            ],
            [
                'name'         => 'Echo Dynamics Robotics',
                'company_name' => 'Echo Dynamics AI Corp',
                'email'        => 'purchasing@echodynamics.ai',
                'phone'        => '+1 (555) 491-8800',
                'tax_id'       => 'US-847362910',
                'address'      => '77 Automation Dr, Pittsburgh, PA 15213',
                'metadata'     => ['crm_id' => 'CRM-1011', 'tier' => 'enterprise'],
            ],
            [
                'name'         => 'Starlight Retail Ventures',
                'company_name' => 'Starlight E-Commerce LLC',
                'email'        => 'orders@starlightretail.com',
                'phone'        => '+1 (555) 592-1133',
                'tax_id'       => 'US-102938475',
                'address'      => '300 Commerce Way, Dallas, TX 75201',
                'metadata'     => ['crm_id' => 'CRM-1012', 'tier' => 'growth'],
            ],
        ];

        if ($testUser) {
            foreach ($curatedCustomers as $cust) {
                Customer::updateOrCreate(
                    [
                        'user_id' => $testUser->id,
                        'email'   => $cust['email'],
                    ],
                    [
                        'name'         => $cust['name'],
                        'company_name' => $cust['company_name'],
                        'phone'        => $cust['phone'],
                        'tax_id'       => $cust['tax_id'],
                        'address'      => $cust['address'],
                        'metadata'     => $cust['metadata'],
                        'created_at'   => now()->subDays(rand(10, 100)),
                        'updated_at'   => now(),
                    ]
                );
            }
        }

        // 2. Add customers for other demo users
        $otherUsers = User::where('id', '!=', $testUser?->id)->get();
        foreach ($otherUsers as $user) {
            if ($user->customers()->count() == 0) {
                for ($k = 1; $k <= 3; $k++) {
                    Customer::create([
                        'user_id'      => $user->id,
                        'name'         => "Client {$k} for {$user->name}",
                        'company_name' => "Enterprise {$k} Ltd",
                        'email'        => "client{$k}_{$user->id}@example.com",
                        'phone'        => '+1 (555) ' . rand(100, 999) . '-' . rand(1000, 9999),
                        'address'      => rand(100, 999) . ' Business Park Ave, CA',
                    ]);
                }
            }
        }
    }
}
