<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'classes'; 

    protected $fillable = ['name', 'numeric_value', 'description'];

    /**
     * Get all enrollments for this class.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'class_id');
    }
}
    