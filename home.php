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
$post_date = $_SESSION['session_date'] = date("Y-m-d");

$select = mysqli_query($link, "SELECT * FROM Symptoms WHERE username ='$username' AND post_date = '$post_date'");

$hasSymptoms = mysqli_num_rows($select) > 0;

$select_questionnaire = mysqli_query($link, "SELECT * FROM Questionnaire WHERE username ='$username' ORDER BY questionnaire_date DESC LIMIT 1");

$hasQuestionnaire = mysqli_num_rows($select_questionnaire) > 0;

$questionnaire_result = 0;
$questionnaire_date = null;

if ($hasQuestionnaire) {
    $row = mysqli_fetch_assoc($select_questionnaire);
    $questionnaire_result = $row['questionnaire_result'];
    $questionnaire_date = $row['questionnaire_date'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Asthma Support App Home page</title>
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/home.css">
</head>
<body>
<main>
    <form class="home" action="" method="post">
        <div class="topnav">
            <a href="logout.php">Log Out</a>
        </div>
        <div class="home-container">
            <button id="button1" type="button">Asthma Questionnaire</button>
            <button id="button2" type="button">Symptom Tracker</button>
            <button id="button3" type="button">Breathing Exercises</button>
            <button id="button4" type="button">Asthma and Other Respiratory Disease Info</button>
            <button id="button5" type="button">Trigger Forecast</button>
            <button id="button6" type="button">Profile</button>
        </div>

    </form>
</main>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var button1 = document.getElementById("button1");
        var button2 = document.getElementById("button2");
        var button3 = document.getElementById("button3");
        var button4 = document.getElementById("button4");
        var button5 = document.getElementById("button5");
        var button6 = document.getElementById("button6");


        button1.addEventListener("click", function() {
            window.location.href = "questionnaire.php";
        });

        button2.addEventListener("click", function() {
            window.location.href = "symptomTracker.php";
        });

        button3.addEventListener("click", function() {
            window.location.href = "breathingExercises.php";
        });

        button4.addEventListener("click", function() {
            window.location.href = "asthmaInfo.php";
        });

        button5.addEventListener("click", function() {
            window.location.href = "triggerForecast.php";
        });

        button6.addEventListener("click", function() {
            window.location.href = "profile.php";
        });

        var symptomCondition = <?php echo $hasSymptoms ? 'true' : 'false'; ?>;

        if (symptomCondition) {
            button2.textContent = "View Symptoms";
            button2.addEventListener("click", function() {
                window.location.href = "viewSymptoms.php";
            });
        } else {
            button2.addEventListener("click", function() {
                window.location.href = "symptomTracker.php";
            });
        }

        var hasQuestionnaire = <?php echo $hasQuestionnaire ? 'true' : 'false'; ?>;

        if (hasQuestionnaire) {
            var today = new Date();
            var questionnaireDateStr = "<?php echo $questionnaire_date; ?>";
            var questionnaireDate = new Date(questionnaireDateStr.replace(/-/g, '/'));
            var oneWeekAgo = new Date(today);
            var oneWeekFromQuestionnaire = new Date(questionnaireDate);

            oneWeekFromQuestionnaire.setDate(questionnaireDate.getDate() + 7);

            oneWeekAgo.setDate(today.getDate() - 7);

            var timeUntilAvailable = Math.ceil((oneWeekFromQuestionnaire.getTime() - today.getTime()) / (1000 * 60 * 60 * 24));
            var days = Math.max(0, timeUntilAvailable);


            if (questionnaireDate >= oneWeekAgo) {
                button1.classList.add("greyed-out");
                button1.disabled = true;

                var questionnaireResult = <?php echo $questionnaire_result; ?>;
                var resultMessage = displayResultMessage(questionnaireResult);

                button1.innerHTML = "Questionnaire Result: " + questionnaireResult + " / 25" + "<br><br>" + resultMessage + "<br><br>Next questionnaire available in: "  + days + " days";
            } else {
                button1.addEventListener("click", function() {
                    window.location.href = "questionnaire.php";
                });
            }
        } else {
            button1.addEventListener("click", function() {
                window.location.href = "questionnaire.php";
            });
        }

        function displayResultMessage(questionnaireResult) {
            var message;
            if (questionnaireResult === 25) {
                message = "Well Done! Your asthma appears to be under control. However, contact your doctor or nurse if you are experiencing any problems.";
            } else if (questionnaireResult >= 20 && questionnaireResult <= 24) {
                message = "On Target! Your asthma appears to be reasonably well controlled. However, contact your doctor or nurse if you are experiencing any problems. Attempting some of the breathing exercises may help improve your control.";
            } else if (questionnaireResult < 20) {
                message = "Off Target. Your asthma may not be controlled. Your doctor or nurse can recommend an asthma action plan to help improve your asthma control.";
            } else {
                message = "No result available.";
            }
            return message;
        }
    });
</script>
</body>
</html>
