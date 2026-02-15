<?php

namespace App\Http\Controllers;

use App\Models\StudentProfile;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = StudentProfile::with(['user', 'class'])->get();

        return response()->json([
            'status' => 200,
            'students' => $students
        ]);
    }
}