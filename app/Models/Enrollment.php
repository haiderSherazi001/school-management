<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'class_id',
        'academic_session'
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