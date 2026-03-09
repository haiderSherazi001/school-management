<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['name', 'class_id', 'total_marks'];

    public function class() {
        return $this->belongsTo(Classes::class, 'class_id');
    }
}
