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
<h2>Student Ranking</h2>
<div style="display: block">
    <table style="width: 100%; border: 1px; border: 1px solid;">
        <thead>
            <tr style="" class="border-b bg-slate-600 text-slate-50">
                <th style="width: 5%;">Ranking</th>
                <th>Name</th>
                <th>GWA</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
            <tr style="background-color: #{{
            $loop->index + 1 == 1 ? 'feef90' : 
            ($loop->index + 1 == 2 ? 'e5e7eb' :
            ($loop->index + 1 == 3 ? 'ffedd6' : ''))
            }}">
                <td class="text-center" style="text-align: center; padding-top: 10px; padding-bottom: 10px;">{{$loop->index + 1}}</td>
                <td>{{$student->name}}</td>
                <td class="text-center" style="text-align: center">{{round($student->grades_avg_grade,2)}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>