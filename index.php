<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="index.css">
    <link rel="icon" href="favicon.ico">
    <title>Lake Temperature</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script> 
</head>
<body>
    <h1 id="Title">Lake Temperature</h1><br>
    <a id="login_button" href="admin.php">Admin</a>
    <div id="current_data"></div><br>
    <div id="color_picker">
        <label for="lineColor"></label>
        <input type="color" id="lineColor" name="lineColor" value="#0000ff">
        <button onclick="applyColorSettings()">Apply</button>
    </div>
    <canvas id="chart"></canvas>

    <script type="text/javascript">
        let lake_name = "Balaton";
        let refresh_interval = 3000;
        let chart = null;
        let lineColor = "#0000ff"; // Default line color

        // Load color from local storage if available
        if (localStorage.getItem("lineColor")) {
            lineColor = localStorage.getItem("lineColor");
            document.getElementById("lineColor").value = lineColor;
        }

        function applyColorSettings() {
            lineColor = document.getElementById("lineColor").value;
            localStorage.setItem("lineColor", lineColor); // Store color in local storage
            if (chart !== null) {
                chart.data.datasets[0].borderColor = lineColor;
                chart.update();
            }
        }

        function draw_the_graph(dates, temperatures) {
            chart = new Chart("chart", {
                type: "line",
                data: {
                    labels: dates,
                    datasets: [{
                        data: temperatures,
                        borderColor: lineColor,
                        fill: false
                    }]
                },
                options: {
                    legend: { display: false },
                    title: {
                        display: true,
                        text: lake_name,
                        fontSize: 16
                    },
                    scales: {
                        xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Date'
                            }
                        }],
                        yAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Temperature (°C)'
                            }
                        }]
                    }
                }
            });
        }

        let xhttp = new XMLHttpRequest();
        xhttp.onload = function() {
            if (xhttp.status == 200) {
                let data = xhttp.responseText.split("\n");
                let dates = [];
                let temperatures = [];
                data.forEach(function(item, index) { // Make 2 lists of 1 spliting the items on " " 
                    items = item.split(" ");
                    dates.push(items[0]);
                    temperatures.push(Number(items[1]));
                });
                if (chart === null) {
                    draw_the_graph(dates, temperatures); // Draw the graph if it's not already drawn
                } else {
                    // Clear existing chart data
                    chart.data.labels = [];
                    chart.data.datasets[0].data = [];

                    // Add new data to the chart
                    chart.data.labels = dates
                    chart.data.datasets[0].data = temperatures;

                    chart.update(); // Update the chart
                }
                
                // Display current data above the graph
                let latest_date = dates[dates.length - 1];
                let latest_temperature = temperatures[temperatures.length - 1];
                document.getElementById("current_data").innerHTML = "<p>Date: " + latest_date + "<br>Temperature: " + latest_temperature + "°C</p>";
            }
        };

        function refresh() {
            xhttp.open("GET", "/database.php");
            xhttp.send();
        }

        // Draw the graph initially when the page loads
        window.onload = function() {
            refresh();
        };

        // Start the refresh interval
        setInterval(function () {
            refresh();
        }, refresh_interval);
    </script>

</body>
</html>
