<?php

use App\Http\Controllers\api\GradeController;
use App\Http\Controllers\api\LoginController;
use App\Http\Controllers\api\StudentController;
use App\Http\Controllers\api\SubjectController;
use App\Http\Middleware\UserIsAdmin;
use App\Http\Middleware\UserIsStudent;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

Route::post('login', [LoginController::class, 'login'])->name('login');

Route::get('logout', [LoginController::class, 'logout'])->middleware('auth:api');

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::middleware(['auth:api', UserIsStudent::class])->group(function(){
    Route::get('/student/grades', [GradeController::class, 'getStudentGrades']);
    Route::get('/student/report-card', [GradeController::class, 'getStudentReport']);
});

Route::middleware(['auth:api', UserIsAdmin::class])->group(function(){

    Route::get('/grades/{subject_id}', [GradeController::class, 'getGrades']);
    Route::get('/grades/export/{subject_id}', [GradeController::class, 'exportSubject']);
    Route::get('/grades/export/pdf/{subject_id}', [GradeController::class, 'exportSubjectPDF']);
    Route::get('/export/ranking', [StudentController::class, 'rankingPDF']);
    Route::get('/export/award', [StudentController::class, 'rankingAwardPDF']);

    Route::post('/grades/import/{subject_id}', [GradeController::class, 'importGrades']);

    Route::post('/subjects', [SubjectController::class, 'getSubjects']);

    Route::post('/get-ranking', [StudentController::class, 'getRankingByGWA']);
});


Route::post('/test', function(Request $request){
    $subjects_request = new Collection($request->subjects);
    return $request->min_gwa;
});