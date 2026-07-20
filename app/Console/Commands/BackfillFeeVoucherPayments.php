<?php

namespace App\Console\Commands;

use App\Models\FeeVoucher;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class BackfillFeeVoucherPayments extends Command
{
    protected $signature = 'fees:backfill-payments {--dry-run} {--chunk=200}';

    protected $description = 'Create a matching payment record for every legacy paid voucher that has no payment history yet';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $chunkSize = (int) $this->option('chunk');

        $totalCount = 0;
        $totalAmount = 0;

        FeeVoucher::where('status', 'paid')
            ->whereDoesntHave('payments')
            ->chunkById($chunkSize, function ($vouchers) use (&$totalCount, &$totalAmount, $dryRun) {
                foreach ($vouchers as $voucher) {
                    if ($dryRun) {
                        $this->line("Would backfill voucher #{$voucher->id} ({$voucher->voucher_number}) — Rs. {$voucher->amount}");
                        $totalCount++;
                        $totalAmount += $voucher->amount;
                        continue;
                    }

                    DB::transaction(function () use ($voucher) {
                        $voucher->payments()->create([
                            'amount' => $voucher->amount,
                            'method' => 'other',
                            'collected_by' => null,
                            'paid_at' => $voucher->paid_at ?? $voucher->updated_at,
                            'note' => 'Backfilled from legacy paid status',
                        ]);

                        $voucher->recalculateStatus();
                    });

                    $totalCount++;
                    $totalAmount += $voucher->amount;
                }
            });

        $verb = $dryRun ? 'Would backfill' : 'Backfilled';
        $this->info("{$verb} {$totalCount} voucher(s) totaling Rs. " . number_format($totalAmount, 2) . '.');

        return self::SUCCESS;
    }
}
