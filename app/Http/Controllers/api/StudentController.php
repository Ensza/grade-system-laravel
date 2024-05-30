<?php

namespace App\Http\Controllers\api;

use App\Exports\StudentsExport;
use App\Imports\StudentsImport;
use App\Models\Grade;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;

class StudentController extends BaseController
{
    public function rankingPDF(Request $request){
        $data = ['students' => $this->getRankingByGWA($request)];
        $pdf = Pdf::loadView('ranking-pdf', $data);
        return $pdf->download('ranking.pdf');
    }

    public function getRankingByGWA(Request $request){
        $min_gwp = $request->min_gwa;
        $subjects_request = new Collection($request->subjects);

        $invalid_range = $subjects_request->filter(function($item){
            if($item['value'] > 100 || $item['value'] < 0){
                return true; // if subject minimum grade is outside range, return true to filter
            }
            return false;
        })->all();

        if($invalid_range || $min_gwp > 100 || $min_gwp < 0){
            return response(['error'=>'Grade outside range'], 404); // if minimum gwa or minimum grades is outside range, return error response
        }

        $students = Student::all()
            ->loadAvg('grades', 'grade') // load average of grades
            ->where('grades_avg_grade', '>=', $min_gwp) // filter grades with gwa lower than min
            ->load('grades'); // load grades models

        $ranking = $students->filter(function($model) use($subjects_request){
            $criteria = true; // true if student passes the criteria

            foreach($model->grades as $grade){
                $subject_min = $subjects_request->where('subject_id', $grade->subject->id)->value('value'); // get the minimum grade for subject from request

                if($grade->grade < $subject_min){ // if grade is below minimum, break loop and return false to filter
                    $criteria = false;
                    break;
                }
            }

            return $criteria;
        });
        
        return $ranking->sortByDesc('grades_avg_grade')->values()->all();
    }

}
