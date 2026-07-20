<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    protected $fillable = ['title', 'default_salary', 'department', 'is_active', 'paid_leave_days_per_month'];

    public function staffProfiles()
    {
        return $this->hasMany(StaffProfile::class, 'designation_id');
    }
}