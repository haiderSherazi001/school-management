<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeVoucher extends Model
{
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

    public function academicClass()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}