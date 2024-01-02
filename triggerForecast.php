<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: logout.php");
    exit(); }
?>

<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Asthma Support App Trigger Forecast page</title>
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/triggerForecast.css">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>
<body>
<div class="triggerForecast">
    <div class="topnav">
        <a href="home.php">Back</a>
    </div>
    <div class="triggerForecast-container">
        <h1>Trigger Forecasts</h1>
        <div id="aqiGaugeContainer">
            <p id="aqiMessage"></p>
        </div>
        <div id="grassPollenGaugeContainer">
            <p id="grassPollenMessage"></p>
        </div>
        <div id="temperatureGaugeContainer">
            <p id="temperatureMessage"></p>
        </div>
        <br><br>
        <div id="errorMessage">
            <p>Unable to fetch location. Please check your location settings or try again later. <br><br> Android devices require locating method to be high accuracy.</p>
        </div>
    </div>
</div>

<script>
    async function fetchData(latitude, longitude) {
        try {
            const aqiResponse = await fetch(`https://api.openweathermap.org/data/2.5/air_pollution?lat=${latitude}&lon=${longitude}&appid=bbd30f0f8b188d5dc80796b8617da87a`);
            const aqiData = await aqiResponse.json();
            const aqi = aqiData.list[0].main.aqi;

            const temperatureResponse = await fetch(`https://api.openweathermap.org/data/2.5/weather?lat=${latitude}&lon=${longitude}&appid=bbd30f0f8b188d5dc80796b8617da87a&units=metric`);
            const temperatureData = await temperatureResponse.json();
            const temperature = temperatureData.main.temp;

            const grassPollenResponse = await fetch(`https://api.tomorrow.io/v4/timelines?location=${latitude},${longitude}&fields=grassIndex&apikey=OLqgPkFGgB7WpMJTBgNWh6Ddg9eppDAa`);
            const grassPollenData = await grassPollenResponse.json();
            const grassPollenIndex = grassPollenData.data.timelines[0].intervals[0].values.grassIndex;

            updateAQIGauge(aqi);
            updateAQIMessage(aqi);
            updateTemperatureGauge(temperature);
            updateTemperatureMessage(temperature);
            updateGrassPollenGauge(grassPollenIndex);
            updateGrassPollenMessage(grassPollenIndex);
        } catch (error) {
            console.error('Error fetching data:', error);
        }
    }

    function updateAQIGauge(aqi) {
        var gaugeData = [
            {
                domain: { x: [0, 1], y: [0, 1] },
                value: aqi,
                title: { text: 'Air Quality Index' },
                type: 'indicator',
                mode: 'gauge+number',
                gauge: {
                    axis: {
                        range: [0, 5],
                        tickmode: 'array',
                        tickvals: [0, 1, 2, 3, 4, 5],
                        ticktext: ['0', '1', '2', '3', '4', '5']
                    },
                    bar: { color: '#005eb8' },
                    steps: [
                        { range: [0, 1], color: '#2ca02c' },
                        { range: [1, 2], color: '#7cbf7c' },
                        { range: [2, 3], color: '#ffeb3b' },
                        { range: [3, 4], color: '#ffc107' },
                        { range: [4, 5], color: '#d62728' }
                    ],
                }
            }
        ];

        var layout = { width: 300, height: 180, margin: { t: 0, b: 0 } };
        Plotly.newPlot('aqiGaugeContainer', gaugeData, layout);
    }

    function updateAQIMessage(aqi) {
        var message = '';
        if (aqi === 1) {
            message = 'Air quality in your area is good';
        } else if (aqi === 2) {
            message = 'Air quality in your area is fair';
        } else if (aqi === 3) {
            message = 'Air quality in your area is moderate';
        } else if (aqi === 4) {
            message = 'Air quality in your area is poor and may negatively affect your condition';
        } else if (aqi === 5) {
            message = 'Air quality in your area is very poor and may negatively affect your condition';
        }

        document.getElementById('aqiMessage').textContent = message;
    }

    function updateTemperatureGauge(temperature) {
        var gaugeData = [
            {
                domain: { x: [0, 1], y: [0, 1] },
                value: temperature,
                title: { text: 'Temperature' },
                type: 'indicator',
                mode: 'gauge+number',
                gauge: {
                    axis: {
                        range: [0, 50],
                        tickmode: 'array',
                        tickvals: [0, 10, 20, 30, 40, 50],
                        ticktext: ['0', '10', '20', '30', '40', '50']
                    },
                    bar: { color: '#005eb8' },
                    steps: [
                        { range: [0, 10], color: '#2ca02c' },
                        { range: [10, 20], color: '#7cbf7c' },
                        { range: [20, 30], color: '#ffeb3b' },
                        { range: [30, 40], color: '#ffc107' },
                        { range: [40, 50], color: '#d62728' }
                    ],
                }
            }
        ];

        var layout = { width: 300, height: 180, margin: { t: 0, b: 0 } };
        Plotly.newPlot('temperatureGaugeContainer', gaugeData, layout);
    }

    function updateTemperatureMessage(temperature) {
        var message = 'Temperature in your area: ' + temperature + ' °C';

        if (temperature < 5) {
            message += 'It is very cold outside, this may negatively affect your condition.';
        }

        document.getElementById('temperatureMessage').textContent = message;
    }

    function updateGrassPollenGauge(grassPollenIndex) {
        var gaugeData = [
            {
                domain: { x: [0, 1], y: [0, 1] },
                value: grassPollenIndex,
                title: { text: 'Grass Pollen Index' },
                type: 'indicator',
                mode: 'gauge+number',
                gauge: {
                    axis: {
                        range: [0, 5],
                        tickmode: 'array',
                        tickvals: [0, 1, 2, 3, 4, 5],
                        ticktext: ['0', '1', '2', '3', '4', '5']
                    },
                    bar: { color: '#005eb8' },
                    steps: [
                        { range: [0, 1], color: '#2ca02c' },
                        { range: [1, 2], color: '#7cbf7c' },
                        { range: [2, 3], color: '#ffeb3b' },
                        { range: [3, 4], color: '#ffc107' },
                        { range: [4, 5], color: '#d62728' }
                    ],
                }
            }
        ];

        var layout = { width: 300, height: 180, margin: { t: 0, b: 0 } };
        Plotly.newPlot('grassPollenGaugeContainer', gaugeData, layout);
    }

    function updateGrassPollenMessage(grassPollenIndex) {
        var message = '';
        if (grassPollenIndex === 0) {
            message = 'Pollen count is very low';
        } else if (grassPollenIndex === 1) {
            message = 'Pollen count is low';
        } else if (grassPollenIndex === 2) {
            message = 'Pollen count is moderate';
        } else if (grassPollenIndex === 3) {
            message = 'Pollen count is high and may negatively affect your condition';
        } else if (grassPollenIndex === 4) {
            message = 'Pollen count is very high and may negatively affect your condition';
        } else if (grassPollenIndex === 5) {
            message = 'Pollen count is extremely high and may negatively affect your condition';
        }

        document.getElementById('grassPollenMessage').textContent = message;
    }

    function getUserCoordinates() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;

                    fetchData(latitude, longitude);
                    document.getElementById('errorMessage').style.display = 'none';
                },
                (error) => {
                    console.error('Error getting user location:', error);
                    document.getElementById('errorMessage').style.display = 'block';
                }
            );
        } else {
            console.error('Geolocation is not supported by this browser.');
            document.getElementById('errorMessage').style.display = 'block';
        }
    }

    getUserCoordinates();
    setInterval(getUserCoordinates, 5 * 60 * 1000);
</script>
</body>
</html>
