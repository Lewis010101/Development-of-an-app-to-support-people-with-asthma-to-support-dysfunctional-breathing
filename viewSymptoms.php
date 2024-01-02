<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: logout.php");
    exit(); }

define('DB_SERVER', 'devweb2022.cis.strath.ac.uk');
define('DB_USERNAME', 'mfb18124');
define('DB_PASSWORD', 're6Oob4chiWi');
define('DB_NAME', 'mfb18124');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$username = $_SESSION['username'];
$sevenDaysAgo = date('Y-m-d', strtotime('-6 days'));
$lastSevenDaysQuery = "SELECT peak_flow, post_date FROM Symptoms WHERE username = '$username' AND post_date >= '$sevenDaysAgo' ORDER BY post_date ASC";
$lastSevenDaysResult = mysqli_query($link, $lastSevenDaysQuery);

if ($lastSevenDaysResult) {
    $pastSevenDaysPeakFlow = array();

    while ($row = mysqli_fetch_assoc($lastSevenDaysResult)) {
        $pastSevenDaysPeakFlow[] = array(
            'peak_flow' => $row['peak_flow'],
            'post_date' => $row['post_date']
        );
    }

    $peakFlowJSON = json_encode($pastSevenDaysPeakFlow);
    mysqli_free_result($lastSevenDaysResult);
} else {
    echo "Error executing the last seven days query: " . mysqli_error($link);
}

$highestPeakFlowQuery = "SELECT MAX(peak_flow) AS highest_peak_flow FROM Symptoms WHERE username = '$username'";
$highestPeakFlowResult = mysqli_query($link, $highestPeakFlowQuery);

if ($highestPeakFlowResult) {
    $highestPeakFlowData = mysqli_fetch_assoc($highestPeakFlowResult);
    $highestPeakFlow = $highestPeakFlowData['highest_peak_flow'];
} else {
    echo "Error executing the highest peak flow query: " . mysqli_error($link);
}

$currentDate = date('Y-m-d');
$currentDateDataQuery = "SELECT symptom, medication, other_notes, peak_flow FROM Symptoms WHERE username = '$username' AND post_date = '$currentDate'";
$currentDateDataResult = mysqli_query($link, $currentDateDataQuery);

if ($currentDateDataResult) {
    $currentDateData = mysqli_fetch_assoc($currentDateDataResult);
    $currentSymptom = $currentDateData['symptom'];
    $currentMedication = $currentDateData['medication'];
    $currentOtherNotes = $currentDateData['other_notes'];
    $currentPeakFlow = $currentDateData['peak_flow'];
} else {
    echo "Error executing the current date data query: " . mysqli_error($link);
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Asthma Support App View Symptoms page</title>
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/viewSymptoms.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.28.3/dist/apexcharts.min.js"></script>
</head>
<body>
<main>
    <form class="viewSymptoms" action="" method="post">
        <div class="topnav">
            <a href="home.php">Back</a>
        </div>
        <div class="viewSymptoms-container">
            <h1>Peak Flow for the Past 7 Days</h1>
            <div class="graph-container" id="graph"></div>
            <fieldset>
            <legend>Peak Flow Feedback:</legend>
            <p><?php
                $percentage = ($currentPeakFlow / $highestPeakFlow) * 100;

                if ($percentage >= 80 && $percentage <= 100) {
                    echo "<p class='good-feedback'>Your peak flow for today is good!</p>";
                } elseif ($percentage >= 50 && $percentage < 80) {
                    echo "<p class='ok-feedback'>Your peak flow for today is ok. <br><br> Pay attention to any symptoms and take your medication as prescribed. <br><br> Attempting some of the breathing exercises may help improve your condition.</p>";
                } else {
                    echo "<p class='bad-feedback'>Your peak flow for today is low. <br><br> Please consult your healthcare provider for further evaluation and follow your asthma action plan.</p>";
                }
                ?></p>
            </fieldset>
            <fieldset>
            <legend>Today's Symptoms:</legend>
            <p class='symptom'><?php echo $currentSymptom; ?></p>
            </fieldset>
            <fieldset>
            <legend>Today's Medications:</legend>
            <p class='medication'><?php echo $currentMedication; ?></p>
            </fieldset>
            <fieldset>
            <legend>Other Notes for Today:</legend>
            <p class='notes'><?php echo $currentOtherNotes; ?></p>
            </fieldset>
            <a href="symptomHistory.php" class="viewSymptoms-button">Symptom History</a>
        </div>
    </form>
</main>
<script>
    var peakFlowData = <?php echo $peakFlowJSON; ?>;

    var dates = peakFlowData.map(item => item.post_date);
    var peakFlows = peakFlowData.map(item => parseInt(item.peak_flow));

    var options = {
        chart: {
            type: 'line',
            width: 300,
            height: 250
        },
        series: [{
            name: 'Peak Flow (L/min)',
            data: peakFlows
        }],
        xaxis: {
            categories: dates,
            labels: {
                show: true,
                rotate: -45,
                rotateAlways: false
            }
        },
        yaxis: {
            title: {
                text: 'Peak Flow (L/min)'
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#graph"), options);
    chart.render();
</script>