<?php

namespace App\Livewire;

use App\Models\Student;
use Livewire\Component;

class StudentRow extends Component
{
    public Student $student;

    public function deleteStudent(){
        $this->student->delete();
        $this->dispatch('StudentDeleted'); // dispatch student deleted event
    }

    public function render()
    {
        return view('livewire.student-row');
    }
}
