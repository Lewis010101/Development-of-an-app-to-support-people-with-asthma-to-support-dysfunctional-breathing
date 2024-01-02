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
    <title>Asthma Support App Symptom Tracker page</title>
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/symptomTracker.css">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
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

$peak_flow_error = $symptom_error = $medication_error = $other_notes_error= "";

if (isset($_REQUEST['peak_flow'])){

    if (empty(trim($_POST["peak_flow"])) || !is_numeric($_POST["peak_flow"])) {
        $peak_flow_error = "Please enter a valid numeric value for Peak Flow.";
    } else {
        $peak_flow = (int) $_POST['peak_flow'];
    }

    if(empty(trim($_POST["symptom"]))) {
        $symptom_error = "Please enter a symptom you experienced or enter none.";
    } else{
        $symptom = stripslashes($_REQUEST['symptom']);
        $symptom = mysqli_real_escape_string($link,$symptom);
    }

    if(empty(trim($_POST["medication"]))) {
        $medication_error = "Please enter any medication you took or enter none.";
    } else{
        $medication = stripslashes($_REQUEST['medication']);
        $medication = mysqli_real_escape_string($link,$medication);
    }

    if(empty(trim($_POST["other_notes"]))) {
        $other_notes_error = "Please enter some info about your day.";
    } else{
        $other_notes = stripslashes($_REQUEST['other_notes']);
        $other_notes = mysqli_real_escape_string($link,$other_notes);
    }

    $post_date = date("Y-m-d");

    $_SESSION['session_date'] = date("Y-m-d");

    $username = $_SESSION['username'];

    if(empty ($peak_flow_error) && empty($symptom_error) && empty($medication_error) && empty($other_notes_error)){

        $select = mysqli_query($link, "SELECT * FROM Symptoms WHERE username ='".$_SESSION['username']."' AND post_date = '".$_SESSION['session_date']."'");
        if(mysqli_num_rows($select)) {
            $update_query = "UPDATE `Symptoms` SET peak_flow = '$peak_flow', symptom = '$symptom', medication = '$medication', username = '$username', post_date = '$post_date', other_notes = '$other_notes' WHERE username = '".$_SESSION['username']."' AND post_date = '".$_SESSION['session_date']."'";
            $update_result = mysqli_query($link,$update_query);
            if($update_result){
                header("location: home.php");
            }
            else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        else{
            $query = "INSERT into `Symptoms` (peak_flow, symptom, medication, username, post_date, other_notes) VALUES ('$peak_flow', '$symptom', '$medication', '$username', '$post_date', '$other_notes')";
            $result = mysqli_query($link,$query);

            if($result){
                header("location: home.php");
                exit();
            }
            else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    }
}
?>
<form class="symptomTracker" action="symptomTracker.php" method="post">
    <div class="topnav">
        <a href="home.php">Back</a>
    </div>
    <div class="symptomTracker-container">
        <h1>Enter Daily Info</h1>

        <input class="symptomTracker-input" type = "text" name = "peak_flow" placeholder="Enter Peak Flow (L/Min)">
        <span class="invalid-feedback"><?php echo $peak_flow_error; ?></span>

        <input class="symptomTracker-input" type = "text" name = "symptom" placeholder="Enter Symptoms">
        <span class="invalid-feedback"><?php echo $symptom_error; ?></span>

        <input class="symptomTracker-input" type = "text"  name = "medication" placeholder="Enter Medication">
        <span class="invalid-feedback"><?php echo $medication_error; ?></span>

        <input class="symptomTracker-input" type = "text"  name = "other_notes" placeholder="Enter Other Notes">
        <span class="invalid-feedback"><?php echo $other_notes_error; ?></span>

        <input class="symptomTracker-button" type="submit" value="Submit"">
    </div>
</form>
</body>
</html>