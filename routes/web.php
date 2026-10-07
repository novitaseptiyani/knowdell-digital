<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CounselorController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing'); });
Route::get('/tentang', fn() => view('about'))->name('about');
Route::get('/kebijakan-privasi', fn() => view('privacy-policy'))->name('privacy-policy');
Route::get('/disclaimer', fn() => view('disclaimer'))->name('disclaimer');
Route::get('/faq', fn() => view('faq'))->name('faq');

/*
|--------------------------------------------------------------------------
| USER ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth:web')->group(function () {

    Route::get('/setup', [OnboardingController::class, 'show'])->name('onboarding');
    Route::post('/setup', [OnboardingController::class, 'store'])->name('onboarding.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('user.password.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/riwayat-tes', [TestController::class, 'history'])->name('tests.history');
    Route::delete('/riwayat-tes/{session}', [TestController::class, 'destroySession'])->name('tests.session.destroy');

    // Routes yang butuh onboarding selesai dulu
    Route::middleware('onboarding')->group(function () {

        Route::get('/dashboard', fn() => view('dashboard'))->name('dashboard');

        Route::get('/tests/{id}/intro', [TestController::class, 'intro'])->name('tests.intro');
        Route::get('/tests/{id}/start', [TestController::class, 'start'])->name('tests.start');
        Route::post('/tests/{id}/save', [TestController::class, 'saveProgress'])->name('tests.save');
        Route::post('/tests/{id}/finish', [TestController::class, 'finish'])->name('tests.finish');
        Route::get('/tests/{id}/worksheet/{session}', [TestController::class, 'worksheet'])->name('tests.worksheet');
        Route::post('/tests/worksheet/{session}', [TestController::class, 'saveWorksheet'])->name('tests.worksheet.save');
        Route::get('/tests/{id}/result/{session}', [TestController::class, 'result'])->name('tests.result');
    });
});

// Profil publik konselor — user & staff bisa akses
Route::get('/konselor/{id}/profil', [CounselorController::class, 'publicProfile'])
    ->middleware('auth:web,staff')
    ->name('counselor.public.profile');

Route::patch('/profile/career', [ProfileController::class, 'updateCareer'])
    ->name('profile.career.update');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:staff', 'admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/counselors', [AdminController::class, 'counselors'])->name('admin.counselors');
    Route::post('/counselors', [AdminController::class, 'storeCounselor'])->name('admin.counselors.store');
    Route::delete('/counselors/{user}', [AdminController::class, 'destroyCounselor'])->name('admin.counselors.destroy');
    Route::get('/assignments', [AdminController::class, 'assignments'])->name('admin.assignments');
    Route::post('/assignments/{user}', [AdminController::class, 'assignCounselor'])->name('admin.assignments.update');
    Route::delete('/assignments/{user}', [AdminController::class, 'unassignCounselor'])->name('admin.assignments.unassign');
    Route::get('/export-users', [AdminController::class, 'exportUsers'])->name('admin.export.users');
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::patch('/profile', [AdminController::class, 'updateProfile'])->name('admin.profile.update');
    Route::put('/profile/password', [AdminController::class, 'updatePassword'])->name('admin.profile.password');
    Route::get('/admins', [AdminController::class, 'admins'])->name('admin.admins');
    Route::post('/admins', [AdminController::class, 'storeAdmin'])->name('admin.admins.store');
    Route::delete('/admins/{user}', [AdminController::class, 'destroyAdmin'])->name('admin.admins.destroy');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
});

/*
|--------------------------------------------------------------------------
| COUNSELOR ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:staff', 'counselor'])->prefix('counselor')->group(function () {

    Route::get('/dashboard', [CounselorController::class, 'dashboard'])->name('counselor.dashboard');
    Route::get('/patients', [CounselorController::class, 'patients'])->name('counselor.patients');
    Route::get('/patients/{user}', [CounselorController::class, 'showPatient'])->name('counselor.patient');
    Route::get('/results/{session}', [CounselorController::class, 'showResult'])->name('counselor.result');
    Route::post('/results/{session}/recommendation', [CounselorController::class, 'saveRecommendation'])->name('counselor.recommendation');
    Route::get('/completed-tests', [CounselorController::class, 'completedTests'])->name('counselor.completed_tests');
    Route::get('/unreviewed', [CounselorController::class, 'unreviewedTests'])->name('counselor.unreviewed');
    Route::get('/export-results', [CounselorController::class, 'exportResults'])->name('counselor.export');
    Route::get('/export-patients', [CounselorController::class, 'exportPatients'])->name('counselor.export.patients');
    Route::get('/profile', [CounselorController::class, 'profile'])->name('counselor.profile');
    Route::patch('/profile', [CounselorController::class, 'updateProfile'])->name('counselor.profile.update');
    Route::put('/profile/password', [CounselorController::class, 'updatePassword'])->name('counselor.profile.password');
    Route::patch('/profile/biography', [CounselorController::class, 'updateBiography'])->name('counselor.profile.bio');
});

require __DIR__ . '/auth.php';
