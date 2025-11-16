<?php

use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\AttendanceController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::apiResource('students', StudentController::class);
    Route::post('attendance/bulk', [AttendanceController::class,'storeBulk']);
    Route::get('attendance/today', [AttendanceController::class,'todaysAttendance']);
    Route::get('attendance/report/monthly', [AttendanceController::class,'monthlyReport']);
});

