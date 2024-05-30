<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function getSubjects(Request $request){
        if($request->subject_id){
            if(!Subject::find($request->subject_id)){
                return response('subject id doesn`t exist', 404);
            }
        }
        
        return Subject::all();
    }

    public static function addSubject($name){
        $new_sub = Subject::create(['name'=>$name]);
        $student_ids = DB::table('students')->select(['id'])->get();

        foreach($student_ids as $student){
            Grade::create(['subject_id'=>$new_sub->id, 'student_id'=>$student->id]);
        }

        return $new_sub;
    }
}
