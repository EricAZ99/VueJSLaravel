<?php



use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Profile\PasswordController;



Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/verify_user_email', [AuthController::class, 'verifyUserEmail']);
Route::post('/auth/resend_email_verification', [AuthController::class, 'resendEmailVerificationLink']);

Route::post('/data', [AuthController::class, 'login']);

Route::middleware(['auth'])->group(function () {
    Route::post('/change_password', [PasswordController::class, 'changeUserPassword']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
});
