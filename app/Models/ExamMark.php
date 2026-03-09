<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamMark extends Model
{
    protected $fillable = ['exam_id', 'subject_id', 'student_id', 'total_marks', 'obtained_marks', 'is_absent', 'remarks'];

    public function student() {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function subject() {
        return $this->belongsTo(Subject::class);
    }
    public function exam() {
        return $this->belongsTo(Exam::class);
    }   
}
