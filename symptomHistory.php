<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: logout.php");
    exit(); }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Asthma Support App Symptom History page</title>
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/symptomHistory.css">
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

$query = "SELECT * FROM Users WHERE username ='".$_SESSION['username']."'";
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
        $_SESSION['session_date'] = $date;
        $_SESSION['symptom_statement'] = $_SESSION['symptom_firstname']." ".$_SESSION['symptom_surname']."'s symptoms from ".$_SESSION['session_date']."";
    }
}
else{
    $_SESSION['session_date'] = date('Y-m-d');
    $_SESSION['symptom_statement'] = $_SESSION['symptom_firstname']." ".$_SESSION['symptom_surname']."'s symptoms from ".$_SESSION['session_date']."";
}

$query = "SELECT * FROM Symptoms WHERE username ='".$_SESSION['symptom_username']."' AND post_date = '".$_SESSION['session_date']."'";
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

?>
<main>
    <form class="symptomHistory" action="" method="post" >
        <div class="topnav">
            <a href="viewSymptoms.php">Back</a>
        </div>
        <div class="symptomHistory-container">
            <div class="symptomHistory-header">
                <h1>History of Symptoms</h1>
            </div>
            <input class="symptomHistory-input" type="date" name="current_date" value="<?php echo $_SESSION['session_date']; ?>"/>
            <button class="symptomHistory-button" type="submit" name="Search">Search</button>

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