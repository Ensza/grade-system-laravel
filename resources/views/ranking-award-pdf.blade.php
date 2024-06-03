<html>
    <head>
        <style type='text/css'>
            body, html {
                margin: 0;
                padding: 0;
            }
            body {
                color: black;
                font-family: Georgia, serif;
                font-size: 24px;
                text-align: center;
            }
            .container{
                background-image: url('bg-award.png');
                background-repeat: no-repeat;
                background-size: cover;
                position: relative;
                width: 100%;
                height: 753.5px;
                border: 20px solid {{$rank == 1 ? 'orange' : ($rank == 2 ? 'silver' : ($rank == 3 ? 'brown' : 'blue'))}};
                display: table;
            }

            .content {
                display: table-cell;
                text-align: center;
                vertical-align: middle;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div style="margin-top: 100px; font-size: 24px;">
                    Our School
                </div>
    
                <div style="margin-top: 50px; font-size: 60px;">
                    Award
                </div>
    
                <div style="margin-top: 30px;">
                    This award is given to
                </div>
    
                <div style="margin-top: 60px; font-size: 40px;">
                    {{$student->name}}
                </div>
    
                <div style="margin-top: 30px;">
                    for
                </div>

                <div style="margin-top: 30px; font-size: 40px;">
                    Ranking {{$rank}}
                </div>

                <div style="margin-top: 30px;">
                    among the students with a GWA of {{round($student->grades_avg_grade, 2)}}
                </div>
            </div>
            <div style="width: 200px; height: 200px; border-top: 10px solid blue; border-left: 10px solid blue; position: absolute; top: 20px; left: 20px"></div>
            <div style="width: 200px; height: 200px; border-right: 10px solid blue; border-bottom: 10px solid blue; position: absolute; bottom: 20px; right: 20px"></div>
        </div>
    </body>
</html>