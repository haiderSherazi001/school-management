<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class StaffProfile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'cnic',
        'designation',
        'qualification',
        'phone',
        'personal_email',
        'address',
        'gender',
        'joining_date',
        'salary',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}