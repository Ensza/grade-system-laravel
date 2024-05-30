<div class="w-full p-2">
    <div class="w-full lg:w-1/2 p-2 rounded shadow my-2 mx-auto bg-slate-50 text-slate-600 relative overflow-clip">

        <h2 class="text-lg mb-2">Add student</h2>

        <div class="inline-flex w-full gap-2 items-center text-slate-600">
            <label for="name" class="text-sm">Name</label>
            <x-input id="name" class="me-2" wire:model='name'/>
            <x-button wire:click="addStudent()">
                Add
            </x-button>
            @error('name')
            <span class="text-sm text-red-500">
                {{$message}}
            </span>
            @enderror
        </div>

        <div class="block mt-4 border rounded overflow-clip shadow">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b bg-slate-600 text-slate-50">
                        <th>delete</th>
                        <th>id</th>
                        <th>name</th>
                        <th>grade</th>
                        <th>remarks</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                        <livewire:student-row :$student :key="$student->id.$student->grade" />
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="block mt-2" wire:ignore>
            <div class="max-w-[500px] mx-auto"><canvas id="students-chart"></canvas></div>
            <script>
                const studentsChart = new Chart("students-chart", {
                    type: "bar",
                    data: {
                        labels: ["Ungraded", "Failed", "Passed"],
                        datasets: [{
                            label: "Students Remarks",
                            backgroundColor: ["gray","red","green"],
                            data: [
                                @php
                                $count = $students->countBy(function($m){
                                    return $m->grade == null ? 'ungraded' : ($m->grade > 5 ? 'passed' : 'failed');
                                });

                                echo ($count['ungraded'] ?? 0)
                                .','.($count['failed'] ?? 0)
                                .','.($count['passed'] ?? 0).',';

                                @endphp
                                0
                            ]
                        }]
                    },
                    options: {}
                });
            </script>
        </div>
        
        @script
        <script>
            $wire.$on('StudentsUpdated', function(){
                studentsChart.data.datasets[0].data = $wire.$get('students_remarks');
                studentsChart.update();
            })
        </script>
        @endscript

        <div class="block mt-2 text-end">
            <x-button wire:click="exportStudents()">
                Export
            </x-button>
        </div>

        <h2 class="text-lg mb-2 mt-4">Import Sheet</h2>
        
        <div class="block">
            <input type="file" wire:model="imported"
            class="border p-0.5 rounded outline-slate-500 text-sm 
            bg-slate-400 text-white 
            file:bg-slate-200 file:hover:bg-slate-300 
            file:border-0 file:rounded file:text-slate-800
            file:cursor-pointer">
            <x-button wire:click="importStudentsSheet()">Upload File</x-button>
        </div>

        @error('imported')
        <div class="block p-2 rounded mt-2 border border-red-400 bg-red-50 text-sm text-red-500">
            {{$message}}
        </div>
        @enderror

        <div wire:loading.attr="aria-loading"
        class="absolute aria-[loading]:hidden w-full h-full top-0 left-0 bg-white bg-opacity-30
        flex justify-center items-center"
        aria-loading="false"
        >
            <div role="status">
                <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        </div>

    </div>
    
</div>
