<style>
    body{
        font-family: Arial, Helvetica, sans-serif;
        color:#222222;
    }
    td{
        border: 1px solid #555555;
        padding: 5px;
    }

    th{
        background-color: #384657;
        border: 1px solid #22344b;
        color: aliceblue;
        padding: 5px;
    }
</style>
<body>
    <div style="width: 100%; border: 1px solid">
        <div style="display: block; padding: 20px;">
            School name:
        </div>
        <div style="padding: 20px; text-align: center; font-size: 22px; font: bold;">
            School Report Card
        </div>
        <div style="padding: 20px;">
            <table style="width: 100%; color:#555555; border-collapse: collapse;">
                <tbody>
                    <tr>
                        <td colspan="2">NAME: {{$profile['name']}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">EMAIL: {{$profile['user']['email']}}</td>
                    </tr>
                    <tr>
                        <td colspan="2">LRN: </td>
                    </tr>
                    <tr>
                        <td>Grade: </td>
                        <td>Section: </td>
                    </tr>
                </tbody>
            </table>

            <table style="width: 100%; color:#555555; border-collapse: collapse; margin-top: 20px">
                <thead>
                    <tr>
                        <th style="width: 60%">Subject</th>
                        <th style="width: 20%">Grade</th>
                        <th style="width: 20%">Remark</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($grades as $grade)
                    @php $total += $grade['grade']; @endphp
                        <tr>
                            <td>{{$grade['subject']['name']}}</td>
                            <td style="text-align: center">{{$grade['grade'] ?? 'ungraded'}}</td>
                            <td style="text-align: center">{{$grade['grade'] == null ? 'ungraded' : ($grade['grade'] > 5 ? 'PASSED' : 'FAILED')}}</td>
                        </tr>
                    @endforeach
                    @php $average = $total / count($grades); @endphp
                    <tr>
                        <td style="padding-top: 20px; padding-bottom: 20px;"><b>AVERAGE</b></td>
                        <td style="text-align: center" colspan="2"><b>{{$average}}</b></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div style="display: block;">
            <div style="display:table; margin: 0 auto; text-align: center">
                <b>Remarks:</b><br>&gt;5 PASSED<br> &lt;=5 FAILED
            </div>
        </div>
        <div style="display: block; white-space: nowrap; margin-top: 50px;">
            <div style="display:inline-block; width: 50%; white-space: normal;">
                <div style="border: 1px solid; height: 100px; margin: 20px; margin-right: 10px; padding: 10px;">
                    <b>Comments:</b>
                </div>
            </div><div style="display:inline-block; width: 50%; white-space: normal;">
                <div style="border: 1px solid; height: 100px; margin: 20px; margin-left: 10px; padding: 10px;">
                    <b>Recommendations:</b>
                </div>
            </div>
        </div>
    </div>
</body>
