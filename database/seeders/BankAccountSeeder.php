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
                'account_name' => 'John Doe Main Account',
                'account_number' => '1234567890',
                'bank_name' => 'Global Bank Ltd.',
                'branch_name' => 'Main Branch',
                'initial_balance' => 50000.00,
                'account_type' => 'savings',
                'description' => 'Primary savings account for business operations.',
                'status' => 'active',
            ],
            [
                'account_name' => 'Jane Smith Operations',
                'account_number' => '0987654321',
                'bank_name' => 'Commerce Bank Plc',
                'branch_name' => 'Corporate Hub',
                'initial_balance' => 75000.00,
                'account_type' => 'checking',
                'description' => 'Main checking account for daily transactions.',
                'status' => 'active',
            ],
            [
                'account_name' => 'Business Reserve Fund',
                'account_number' => '2468135790',
                'bank_name' => 'Secure Trust Bank',
                'branch_name' => 'Wealth Management Division',
                'initial_balance' => 120000.00,
                'account_type' => 'current',
                'description' => 'High-yield current account for reserves.',
                'status' => 'inactive',
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
