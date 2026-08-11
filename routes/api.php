<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 1. API ที่ไม่ต้อง Login (Public Routes)
// เวลา App เรียกใช้งานจะเรียกผ่าน url: http://your-domain.com/api/login
Route::post('/login', [AuthController::class, 'login']);
Route::post('/login/google', [AuthController::class, 'googleLogin']);


// 2. API ที่ต้อง Login ก่อนถึงจะเรียกใช้งานได้ (Protected Routes)
// เวลา App เรียกใช้งาน ต้องแนบ Header -> Authorization: Bearer {token} มาด้วยเสมอ
Route::middleware('auth:sanctum')->group(function () {

    // ดึงข้อมูล User ปัจจุบันที่กำลัง Login อยู่
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    // ออกจากระบบ
    Route::post('/logout', [AuthController::class, 'logout']);

    // --- เขียนเชื่อมต่อ API จัดการโครงงาน หรืออื่นๆ ของคุณต่อใน Block นี้ได้เลย ---
    // Route::get('/projects', [ProjectController::class, 'index']);

});
