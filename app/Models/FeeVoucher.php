<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeVoucher extends Model
{
    use HasFactory;

    protected $fillable = [
        'voucher_number', 'user_id', 'class_id', 'academic_session',
        'billing_month', 'amount', 'due_date', 'status', 'paid_at'
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    /**
     * Get the individual line items for this voucher.
     */
    public function items()
    {
        return $this->hasMany(FeeVoucherItem::class, 'fee_voucher_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'fee_voucher_id');
    }

    public function getAmountPaidAttribute(): float
    {
        $payments = $this->relationLoaded('payments')
            ? $this->payments->whereNull('voided_at')
            : $this->payments()->whereNull('voided_at')->get();

        return (float) $payments->sum('amount');
    }

    public function getBalanceDueAttribute(): float
    {
        return max(0, round((float) $this->amount - $this->amount_paid, 2));
    }

    /**
     * Recompute and persist `status`/`paid_at` from active (non-voided) payments.
     * This is the only code path allowed to set `status` on an unpaid/partial/paid voucher —
     * `cancelled` is a terminal state and is never touched here.
     */
    public function recalculateStatus(): void
    {
        if ($this->status === 'cancelled') {
            return;
        }

        $paid = $this->amount_paid;

        $status = match (true) {
            $paid <= 0 => 'unpaid',
            $paid < $this->amount => 'partial',
            default => 'paid',
        };

        $this->update([
            'status' => $status,
            'paid_at' => $status === 'paid' ? ($this->paid_at ?? now()) : null,
        ]);
    }

    /**
     * Total outstanding balance (billed minus collected) across a user's
     * not-fully-paid vouchers.
     */
    public static function outstandingBalanceForUser(int $userId): float
    {
        $billed = static::where('user_id', $userId)
            ->whereIn('status', ['unpaid', 'partial'])
            ->sum('amount');

        $collected = Payment::whereNull('voided_at')
            ->whereHas('voucher', function ($query) use ($userId) {
                $query->where('user_id', $userId)->whereIn('status', ['unpaid', 'partial']);
            })
            ->sum('amount');

        return max(0, (float) $billed - (float) $collected);
    }
}