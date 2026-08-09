<?php

use App\Http\Controllers\Api\Student\AnnouncementController;
use App\Http\Controllers\Api\Student\ConductController;
use App\Http\Controllers\Api\Student\AppSettingController;
use App\Http\Controllers\Api\Student\BannerController;
use App\Http\Controllers\Api\Student\AuthController;
use App\Http\Controllers\Api\Student\CategoryController;
use App\Http\Controllers\Api\Student\CourseActivationController;
use App\Http\Controllers\Api\Student\CourseController;
use App\Http\Controllers\Api\Student\EducationalNoteController;
use App\Http\Controllers\Api\Student\ExamController;
use App\Http\Controllers\Api\Student\HomeController;
use App\Http\Controllers\Api\Student\LessonController;
use App\Http\Controllers\Api\Student\LessonProgressController;
use App\Http\Controllers\Api\Student\NotificationController;
use App\Http\Controllers\Api\Student\PreviousYearExamController;
use App\Http\Controllers\Api\Student\ProfileController;
use App\Http\Controllers\Api\Student\QuestionBankController;
use App\Http\Controllers\Api\Student\TeacherController;
use App\Http\Controllers\Api\Student\WeeklyPlannerController;
use App\Http\Controllers\Api\Student\WorksheetController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Student Mobile API — v1
|--------------------------------------------------------------------------
| Base URL : /api/v1/student/...
| Auth     : Laravel Sanctum — Bearer token
| Locale   : Accept-Language: ar|en  (default: ar)
|
| Response format:
|   { "status": true|false, "message": "...", "data": {...} }
|   Paginated: adds "pagination": { current_page, last_page, per_page, total }
|--------------------------------------------------------------------------
*/

Route::prefix('v1/')->middleware('api.locale')->group(function () {


    // ── Protected routes (require Bearer token) ────────────────────────────
    Route::middleware('auth:sanctum')->group(function () {

    });
});
