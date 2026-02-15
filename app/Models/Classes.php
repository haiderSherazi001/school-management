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
}
    