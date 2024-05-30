<style>
    h2 {
        font-family: Arial, Helvetica, sans-serif;
    }

    table {
      font-family: Arial, Helvetica, sans-serif;
      font-size: 12px;
      border-collapse: collapse;
      width: 100%;
    }
    
    table td, table th {
      border: 1px solid #ddd;
      padding: 4px;
    }
    
    table tr:nth-child(even){background-color: #f2f2f2;}
    
    table tr:hover {background-color: #ddd;}
    
    table th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: center;
      background-color: #43526e;
      color: white;
    }
</style>
<h2>{{$subject->name}}</h2>
<div style="display: block">
    <table style="width: 100%; border: 1px; border: 1px solid;">
        <thead>
            <tr style="" class="border-b bg-slate-600 text-slate-50">
                <th>id</th>
                <th>name</th>
                <th>grade</th>
                <th>remarks</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subject->grades as $grade)
            <tr>
                <th class="text-center" style="text-align: center">{{$grade->id}}</th>
                <td>{{$grade->student->name}}</td>
                <td class="text-center" style="text-align: center">{{$grade->grade ?? 'ungraded'}}</td>
                <td style="text-align: center; {{
                    $grade->grade != NULL ? 
                        $grade->grade > 5 ? 'background: #33ca5a ; color: white;' : 'background: #e34747; color: white;' : 
                    ''
                }}">{{
                $grade->grade != NULL ? 
                    $grade->grade > 5 ? 'PASSED' : 'FAILED' : 
                'ungraded'
                }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>