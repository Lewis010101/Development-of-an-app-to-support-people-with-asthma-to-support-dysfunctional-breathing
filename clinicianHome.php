<?php
session_start();
if(!isset($_SESSION["clinician_username"])){
    header("Location: clinicianLogout.php");
    exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Asthma Support App Clinician home page</title>
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/clinicianHome.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.28.3/dist/apexcharts.min.js"></script>
</head>
<body>

<?php

define('DB_SERVER', 'devweb2022.cis.strath.ac.uk');
define('DB_USERNAME', 'mfb18124');
define('DB_PASSWORD', 're6Oob4chiWi');
define('DB_NAME', 'mfb18124');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if(isset($_POST['Search'])){
    if (isset($_POST['user_code'])) {
        $user_code = stripslashes($_REQUEST['user_code']);
        $user_code = mysqli_real_escape_string($link,$user_code);
        $_SESSION['session_user_code'] = $user_code;
    }
}
else{
    $_SESSION['session_user_code'] = "";
}

$query = "SELECT * FROM Users WHERE user_code ='".$_SESSION['session_user_code']."'";
$result = $link->query($query);

if ($result->num_rows > 0){
    while ($row = $result->fetch_assoc()){
        $post_username = $row["username"];
        $_SESSION['symptom_username'] = $post_username;
        $post_firstname = $row["firstname"];
        $_SESSION['symptom_firstname'] = $post_firstname;
        $post_surname = $row["surname"];
        $_SESSION['symptom_surname'] = $post_surname;
    }
}
else{
    $_SESSION['symptom_username'] = "";
    $_SESSION['symptom_firstname'] = "";
    $_SESSION['symptom_surname'] = "";
}

if(isset($_POST['Search'])){
    if (isset($_POST['current_date'])) {
        $date = $_POST['current_date'];
        $_SESSION['clinician_session_date'] = $date;
        $_SESSION['graph_statement'] = $_SESSION['symptom_firstname']." ".$_SESSION['symptom_surname']."'s Peak Flow for the past 7 days";
        $_SESSION['symptom_statement'] = $_SESSION['symptom_firstname']." ".$_SESSION['symptom_surname']."'s symptoms from ".$_SESSION['clinician_session_date']."";
    }
}
else{
    $_SESSION['clinician_session_date'] = date('Y-m-d');
    $_SESSION['graph_statement'] = "";
    $_SESSION['symptom_statement'] = "";

}

$query = "SELECT * FROM Symptoms WHERE username ='".$_SESSION['symptom_username']."' AND post_date = '".$_SESSION['clinician_session_date']."'";
$result = $link->query($query);

if ($result->num_rows > 0){
    while ($row = $result->fetch_assoc()){
        $peak_flow = $row["peak_flow"];
        $symptom = $row["symptom"];
        $medication = $row["medication"];
        $otherNotes = $row["other_notes"];
    }
}
else{
    $peak_flow = "No peak flow recorded for this day";
    $symptom = "No symptoms recorded for this day.";
    $medication = "No medications recorded for this day.";
    $otherNotes = "No notes recorded for this day.";
}

$sevenDaysAgo = date('Y-m-d', strtotime('-6 days'));
$lastSevenDaysQuery = "SELECT peak_flow, post_date FROM Symptoms WHERE username = '".$_SESSION['symptom_username']."' AND post_date >= '$sevenDaysAgo' ORDER BY post_date ASC";
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
?>
<main>
    <form class="clinicianHome" action="" method="post" >
        <div class="topnav">
            <a href="clinicianLogout.php">Log Out</a>
        </div>
        <div class="clinicianHome-container">
            <div class="clinicianHome-header">
                <h1>Enter User Code to View Symptoms</h1>
            </div>
            <input class="clinicianHome-input" type="text" name="user_code" placeholder="User Code">
            <input class="clinicianHome-input" type="date" name="current_date" value="<?php echo $_SESSION['clinician_session_date']; ?>"/>
            <button class="clinicianHome-button" type="submit" name="Search">Search</button>

            <h2><?php echo $_SESSION['graph_statement']?></h2>
            <div class="graph-container" id="graph"></div>
            <h2> <?php echo "".$_SESSION['symptom_statement'].""?></h2>
            <fieldset>
                <legend>Daily Peak Flow</legend>
                <p><?php echo "$peak_flow"; ?></p>
            </fieldset>
            <br>
            <fieldset>
                <legend>Daily Symptoms</legend>
                <p><?php echo "$symptom"; ?></p>
            </fieldset>
            <br>
            <fieldset>
                <legend>Daily Medication</legend>
                <p><?php echo "$medication"; ?></p>
            </fieldset>
            <br>
            <fieldset>
                <legend>Daily Notes</legend>
                <p><?php echo "$otherNotes"; ?></p>
            </fieldset>
        </div>
    </form>
</main>
</body>
</html>
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