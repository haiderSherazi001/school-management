<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Classes;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Document;

class StudentProfile extends Model
{
    /** @use HasFactory<\Database\Factories\StudentProfileFactory> */
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = [
    'user_id', 'roll_number', 'admission_date', 'cnic', 
    'date_of_birth', 'gender', 'blood_group', 'personal_phone', 
    'personal_email', 'guardian_name', 'guardian_phone', 
    'guardian_email', 'address'
];

    public function user() {    
        return $this->belongsTo(User::class);
    }

    public function documents() {
        return $this->morphMany(Document::class, 'documentable');
    }
}
