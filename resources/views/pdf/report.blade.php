<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <div id="columnchart_values" style="width: 900px; height: 300px; display:none">
    </div>
    <img src="" id="img-chart" alt="">
    <p id="text"></p>
</body>

</html>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load("current", {
        callback: function() {
            drawChart();
        },
        packages: ['corechart']
    });
    // google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ["Element", "Density", {
                role: "style"
            }],
            ["Copper", 8.94, "#b87333"],
            ["Silver", 10.49, "silver"],
            ["Gold", 19.30, "gold"],
            ["Platinum", 21.45, "color: #e5e4e2"]
        ]);

        var view = new google.visualization.DataView(data);
        view.setColumns([0, 1,
            {
                calc: "stringify",
                sourceColumn: 1,
                type: "string",
                role: "annotation"
            },
            2
        ]);

        var options = {
            title: "Density of Precious Metals, in g/cm^3",
            width: 600,
            height: 400,
            bar: {
                groupWidth: "95%"
            },
            legend: {
                position: "none"
            },
        };
        var chart = new google.visualization.ColumnChart(document.getElementById("columnchart_values"));
        chart.draw(view, options);
        // console.log(chart.getImageURI());
        document.getElementById('img-chart').setAttribute('src', chart.getImageURI());
        // document.getElementById('text').innerHTML = 'abc';

        // let draw_chart = document.getElementById('draw-chart');
        // google.visualization.events.addListener(chart, 'ready', function () {
        //     console.log(chart.getImageURI());
        // });
        setTimeout(() => {
            document.getElementById('img-chart').setAttribute('src', chart.getImageURI());
        }, 1000);
    }
</script>
