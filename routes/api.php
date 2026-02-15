<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/students', [StudentController::class, 'index']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/connection-test', function () {
    return response()->json([
        'message' => 'Successfully Connected to Laravel!',
        'status' => 200
    ]);
});
