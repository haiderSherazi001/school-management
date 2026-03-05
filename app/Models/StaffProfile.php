<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffProfile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'cnic',
        'designation_id',
        'employment_status',
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

    public function documents() {
        return $this->morphMany(Document::class, 'documentable');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }
}