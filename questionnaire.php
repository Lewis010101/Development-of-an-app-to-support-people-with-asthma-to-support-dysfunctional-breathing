<?php
session_start();
if(!isset($_SESSION["username"])){
    header("Location: logout.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Asthma App Questionnaire page</title>
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/questionnaire.css">
</head>
<body>
<?php

function calculateScore($q1, $q2, $q3, $q4, $q5) {
    return $q1 + $q2 + $q3 + $q4 + $q5;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $q1 = isset($_POST["q1"]) ? intval($_POST["q1"]) : 0;
    $q2 = isset($_POST["q2"]) ? intval($_POST["q2"]) : 0;
    $q3 = isset($_POST["q3"]) ? intval($_POST["q3"]) : 0;
    $q4 = isset($_POST["q4"]) ? intval($_POST["q4"]) : 0;
    $q5 = isset($_POST["q5"]) ? intval($_POST["q5"]) : 0;

    $q1_error = $q2_error = $q3_error = $q4_error = $q5_error = "";

    if (empty($_POST["q1"])) {
        $q1_error = "Please select an answer to Question 1.";
    }

    if (empty($_POST["q2"])) {
        $q2_error = "Please select an answer to Question 2.";
    }

    if (empty($_POST["q3"])) {
        $q3_error = "Please select an answer to Question 3.";
    }

    if (empty($_POST["q4"])) {
        $q4_error = "Please select an answer to Question 4.";
    }

    if (empty($_POST["q5"])) {
        $q5_error = "Please select an answer to Question 5.";
    }

    if (empty($q1_error) && empty($q2_error) && empty($q3_error) && empty($q4_error) && empty($q5_error)) {
        $totalScore = calculateScore($q1, $q2, $q3, $q4, $q5);

        define('DB_SERVER', 'devweb2022.cis.strath.ac.uk');
        define('DB_USERNAME', 'mfb18124');
        define('DB_PASSWORD', 're6Oob4chiWi');
        define('DB_NAME', 'mfb18124');

        $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (mysqli_connect_errno()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }

        $questionnaire_result = intval($totalScore);
        $questionnaire_date = date("Y-m-d");
        $username = $_SESSION['username'];

        $query = "INSERT INTO `Questionnaire` (questionnaire_result, username, questionnaire_date) VALUES ('$questionnaire_result', '$username', '$questionnaire_date')";
        $result = mysqli_query($link, $query);

        if ($result) {
            header("Location: home.php");
            exit();
        } else {
            echo "<script>alert('Failed to insert data. Please try again later.'); </script>";
            header("Location: questionnaire.php");
            exit();
        }
    }
}
?>
<div class="questionnaire">
    <div class="topnav">
        <a href="home.php">Back</a>
    </div>
    <form class="questionnaire-container" action="questionnaire.php" method="post">

        <div class="question">Question 1: Over the past week, how often did your asthma prevent you from getting as much done at work, school or home?</div>
        <div class="answer-options">
            <label><input type="radio" name="q1" value="5"> None of the time</label>
            <label><input type="radio" name="q1" value="4"> A little of the time</label>
            <label><input type="radio" name="q1" value="3"> Some of the time</label>
            <label><input type="radio" name="q1" value="2"> Most of the time</label>
            <label><input type="radio" name="q1" value="1"> All the time</label>
            <?php if (isset($q1_error)) { echo "<span class='invalid-feedback'>$q1_error</span>"; } ?>
        </div>

        <div class="question">Question 2: Over the past week, how often have you had shortness of breath?</div>
        <div class="answer-options">
            <label><input type="radio" name="q2" value="5"> None at all</label>
            <label><input type="radio" name="q2" value="4"> 1-2 times a week</label>
            <label><input type="radio" name="q2" value="3"> 3-6 times a week</label>
            <label><input type="radio" name="q2" value="2"> Once a day</label>
            <label><input type="radio" name="q2" value="1"> More than once a day</label>
            <?php if (isset($q2_error)) { echo "<span class='invalid-feedback'>$q2_error</span>"; } ?>
        </div>

        <div class="question">Question 3: Over the past week, how often did your asthma symptoms (wheezing, coughing, chest tightness, shortness of breath) wake you up at night or earlier than usual in the morning?</div>
        <div class="answer-options">
            <label><input type="radio" name="q3" value="5"> None at all</label>
            <label><input type="radio" name="q3" value="4"> 1 time a week</label>
            <label><input type="radio" name="q3" value="3"> 2-3 times a week</label>
            <label><input type="radio" name="q3" value="2"> 4-5 times a week</label>
            <label><input type="radio" name="q3" value="1"> +5 times a week</label>
            <?php if (isset($q3_error)) { echo "<span class='invalid-feedback'>$q3_error</span>"; } ?>
        </div>

        <div class="question">Question 4: Over the past week, how often have you used your reliever inhaler (usually blue)?</div>
        <div class="answer-options">
            <label><input type="radio" name="q4" value="5"> None at all</label>
            <label><input type="radio" name="q4" value="4"> Once a week or less</label>
            <label><input type="radio" name="q4" value="3"> 2-3 times a week</label>
            <label><input type="radio" name="q4" value="2"> 1-2 times a day</label>
            <label><input type="radio" name="q4" value="1"> 3 or more times a day</label>
            <?php if (isset($q4_error)) { echo "<span class='invalid-feedback'>$q4_error</span>"; } ?>
        </div>

        <div class="question">Question 5: How would you rate your asthma control during the past week?</div>
        <div class="answer-options">
            <label><input type="radio" name="q5" value="5"> Completely controlled</label>
            <label><input type="radio" name="q5" value="4"> Well controlled</label>
            <label><input type="radio" name="q5" value="3"> Somewhat controlled</label>
            <label><input type="radio" name="q5" value="2"> Poorly controlled</label>
            <label><input type="radio" name="q5" value="1"> Not controlled</label>
            <?php if (isset($q5_error)) { echo "<span class='invalid-feedback'>$q5_error</span>"; } ?></div>

        <div class="score">
            <button class="questionnaire-button" type="submit">Submit Answers</button>
        </div>
    </form>
</div>
</body>
</html>
