<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BankAccount;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BankAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::whereIn('role', ['superadmin', 'admin'])->get();

        if ($users->isEmpty()) {
            $this->command->info('No superadmin or admin users found to assign bank accounts to. Please create some first.');
            return;
        }

        $accounts = [
            [
                'account_name' => 'Bkash Mobile Banking',
                'account_number' => '017XXXXXXXX',
                'bank_name' => 'Bkash',
                'branch_name' => 'MFS banking',
                'initial_balance' => 50000.00,
                'account_type' => 'other',
                'description' => 'Primary mobile banking account for Bkash transactions.',
                'status' => 'active',
            ],
            [
                'account_name' => 'Nagad Mobile Banking',
                'account_number' => '018XXXXXXXX',
                'bank_name' => 'Nagad',
                'branch_name' => 'MFS banking',
                'initial_balance' => 75000.00,
                'account_type' => 'other',
                'description' => 'Main mobile banking account for Nagad transactions.',
                'status' => 'active',
            ],
            [
                'account_name' => 'Business Reserve Fund',
                'account_number' => '2468135790',
                'bank_name' => 'Secure Trust Bank',
                'branch_name' => 'MFS banking',
                'initial_balance' => 120000.00,
                'account_type' => 'current',
                'description' => 'High-yield current account for reserves.',
                'status' => 'active',
            ],
            [
                'account_name' => 'Cash in Hand',
                'account_number' => 'N/A',
                'bank_name' => 'Physical Cash',
                'branch_name' => 'MFS banking',
                'initial_balance' => 25000.00,
                'account_type' => 'other',
                'description' => 'Physical cash handling for direct transactions.',
                'status' => 'active',
            ]
        ];

        foreach ($accounts as $accountData) {
            $user = $users->random();
            DB::table('bank_accounts')->insert([
                'account_name' => $accountData['account_name'],
                'account_number' => $accountData['account_number'],
                'bank_name' => $accountData['bank_name'],
                'branch_name' => $accountData['branch_name'],
                'initial_balance' => $accountData['initial_balance'],
                'current_balance' => $accountData['initial_balance'],
                'account_type' => $accountData['account_type'],
                'description' => $accountData['description'],
                'status' => $accountData['status'],
                'created_by' => $user->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Bank accounts seeded successfully.');
    }
}
