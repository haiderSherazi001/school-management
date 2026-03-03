<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    protected $fillable = ['class_id', 'academic_session', 'tuition_fee'];

    public function academicClass()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}