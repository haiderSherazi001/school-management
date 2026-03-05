<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FeeVoucher;
use Illuminate\Http\Request;

class FeeVoucherPrintController extends Controller
{
    public function show($id)
    {
        $voucher = FeeVoucher::with(['student.studentProfile', 'class'])->findOrFail($id);
        
        return view('admin.fees.print-voucher', compact('voucher'));
    }
}