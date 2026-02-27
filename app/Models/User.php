<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\StudentProfile;
use App\Models\StaffProfile;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Enrollment;
use App\Models\Setting;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name', 'username', 'email', 'avatar_path', 'password', 'email_verified_at',
    ];  

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function studentProfile() {
    return $this->hasOne(StudentProfile::class);
    }

    public function staffProfile() {
    return $this->hasOne(StaffProfile::class);
    }

    /**
     * Get all enrollments for this student over the years.
     */
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Get the student's current active class based on the Global Settings!
     */
    public function currentClass()
    {
        $currentSession = Setting::get('current_session');
        
        $enrollment = $this->enrollments()->where('academic_session', $currentSession)->first();
        
        return $enrollment ? $enrollment->academicClass : null;
    }
}
