<?php

use App\Http\Controllers\api\GradeController;
use App\Http\Controllers\api\StudentController;
use App\Livewire\Students;
use App\Models\Grade;
use App\Models\Student;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

Route::get('/', [StudentController::class, 'getRankingByGWA']);

//Route::get('export/math', [GradeController::class, 'exportMath']);