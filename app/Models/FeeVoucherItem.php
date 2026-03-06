<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeVoucherItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'fee_voucher_id',
        'title',
        'amount'
    ];

    public function voucher()
    {
        return $this->belongsTo(FeeVoucher::class, 'fee_voucher_id');
    }
}