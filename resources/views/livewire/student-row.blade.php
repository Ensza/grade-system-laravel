<tr>
    <th class="text-center">
        <button wire:click="deleteStudent" wire:confirm="Are you sure you want to delete this record?"
        class="text-red-500">X</button>
    </th>
    <th class="text-center">{{$student->id}}</th>
    <td>{{$student->name}}</td>
    <td class="text-center">{{$student->grade ?? 'ungraded'}}</td>
    <td class="text-center
    {{
        $student->grade != NULL ? 
            $student->grade > 5 ? 'bg-green-500 text-white' : 'bg-red-500 text-white' : 
        ''
    }}
    ">{{
    $student->grade != NULL ? 
        $student->grade > 5 ? 'PASSED' : 'FAILED' : 
    'ungraded'
    }}</td>
</tr>
