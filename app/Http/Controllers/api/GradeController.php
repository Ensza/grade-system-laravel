<?php

namespace App\Http\Controllers\api;

use App\Exports\GradeExport;
use App\Http\Controllers\Controller;
use App\Imports\GradeImport;
use App\Models\Grade;
use App\Models\Subject;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GradeController extends Controller
{

    public function getStudentReport(Request $request){
        $user = $request->user();
        $request->request->add(['profile'=>$user->profile->load('user')]);
        $grades = Grade::where('student_id', $user->profile->id)->get()->load('subject');
        $request->request->add(['grades'=>$grades]);
        $pdf = Pdf::loadView('report-card-pdf', $request->request->all());
        return $pdf->download('report-card.pdf');
    }

    public function getStudentGrades(Request $request){
        $user = $request->user();
        $grades = Grade::where('student_id', $user->profile->id)->get()->load('subject');
        $request->request->add(['grades'=>$grades]);
        return response($request->request->all());
    }

    public function getGrades($subject_id){
        $subject = Subject::find($subject_id);
        return response($subject->grades->load('student'));
    }

    public function exportSubject($subject_id){
        $subject = Subject::find($subject_id);
        return Excel::download(new GradeExport($subject_id), $subject->name.'.xlsx');
    }

    public function exportSubjectPDF($subject_id){
        $data = ['subject'=>Subject::find($subject_id)];
        $pdf = Pdf::loadView('grades-pdf', $data);
        return $pdf->download('grades.pdf');
    }

    public function importGrades($subject_id, Request $request){
        
        $validate = validator($request->all(),
            [
                'file'=>['required','extensions:xlsx']
            ]
        );

        if($validate->fails()){
            return [
                'success' => 0,
                'errors' => $validate->errors()
            ];
        }

        $sheet_data = Excel::toArray(new GradeImport, request()->file);
        $has_grade_outside_range = false;


        foreach($sheet_data[0] as $grade){
            // if score is NOT outside 0-10 range
            if(($grade['grade'] >= 0 && $grade['grade'] < 101) || $grade['grade'] == null){
                $grade_model = Grade::find($grade['id']);

                if($grade_model->subject->id == $subject_id){ //check if the grade and subject matches
                    if($grade_model){
                        $grade_model->grade = $grade['grade'];
                        $grade_model->save();
                    }
                }

            }else{
                $has_grade_outside_range = true;
            }
        }
        
        if($has_grade_outside_range){

            return [
                'success' => 1,
                'errors' => ['file'=>'There is/are invalid grade/s. Make sure the grades are within 0-10 range']
            ];
        }

        return [
            'success' => 1,
            'errors' => $validate->errors()
        ];
    }
}
