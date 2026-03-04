<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'billing_month',
        'base_salary',
        'bonuses',
        'deductions',
        'net_payable',
        'status',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    /**
     * Get the staff member this payslip belongs to.
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}