<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\StudentProfile;

class Classes extends Model
{
    protected $table = 'classes'; 

    protected $fillable = ['name', 'numeric_value', 'description'];

    public function students() {
        return $this->hasMany(StudentProfile::class, 'class_id');
    }

    /**
     * Get all enrollments for this class.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'class_id');
    }
}
    