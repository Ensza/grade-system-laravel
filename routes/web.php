<?php

use App\Http\Controllers\api\GradeController;
use App\Http\Controllers\api\StudentController;
use App\Livewire\Students;
use App\Models\Grade;
use App\Models\Student;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;

Route::get('/', function(Request $request){
    $student_controller = new StudentController();
    $rank = 1;

    $ranking = $student_controller->getRankingByGWA($request);

    if($rank < 1 || $rank > count($ranking)){
        return response(['error'=>'outside range'], 404);
    }

    $pdf = Pdf::loadView('ranking-award-pdf', ['student'=>$ranking[$rank - 1], 'rank'=>$rank])
        ->setPaper('a4', 'landscape');;
    return $pdf->stream('award.pdf');
});

//Route::get('export/math', [GradeController::class, 'exportMath']);