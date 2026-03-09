<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['name', 'academic_session', 'start_date'];
    protected $casts = [
        'start_date' => 'date',
    ]; 
}
