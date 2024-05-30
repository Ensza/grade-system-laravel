<?php

namespace App\Livewire;

use App\Exports\StudentsExport;
use App\Imports\StudentsImport;
use App\Models\Student;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Livewire\WithFileUploads;

class Students extends Component
{
    use WithFileUploads;

    #[Validate(['required', 'unique:students,name'])]
    public $name = '';

    public $students;

    public $students_remarks = [];

    public $imported;

    public function mount(){
        $this->students = Student::all();

        // dd($this->students->countBy(function($m){
        //     return $m->grade == null ? 'ungraded' : ($m->grade > 5 ? 'passed' : 'failed');
        // }));
    }

    public function addStudent(){
        $this->validate();
        Student::create(['name'=>$this->name]);

        //refresh students table
        $this->tableUpdated();
        
        $this->name = '';
    }

    public function exportStudents(){
        return Excel::download(new StudentsExport, 'students.xlsx');
    }

    public function importStudentsSheet(){
        $this->validate([
            'imported'=>['required','extensions:xlsx']
        ]);

        $sheet_data = Excel::toArray(new StudentsImport, $this->imported);
        $has_grade_outside_range = false;

        foreach($sheet_data[0] as $student){
            // if score is NOT outside 0-10 range
            if(($student['grade'] >= 0 && $student['grade'] < 11) || $student['grade'] == null){
                $student_model = Student::find($student['id']);
                if($student_model){
                    $student_model->grade = $student['grade'];
                    $student_model->save();
                }
            }else{
                $has_grade_outside_range = true;
            }
        }
        
        if($has_grade_outside_range){
            $this->addError('imported', 
            'There is/are invalid grade/s. Make sure the grades are within 0-10 range');
        }

        //refresh students table
        $this->tableUpdated();
    }

    #[On('StudentDeleted')] // update the table if a student record is deleted
    public function tableUpdated(){
        //refresh students table
        $this->students = Student::all();

        $count = $this->students->countBy(function($m){
            return $m->grade == null ? 'ungraded' : ($m->grade > 5 ? 'passed' : 'failed');
        });

        $this->students_remarks = [$count['ungraded'] ?? 0, $count['failed'] ?? 0, $count['passed'] ?? 0, 0];

        $this->dispatch('StudentsUpdated');
    }
    
    public function render()
    {
        return view('livewire.students')->layoutData(['title'=>'Students Grading']);
    }
}
