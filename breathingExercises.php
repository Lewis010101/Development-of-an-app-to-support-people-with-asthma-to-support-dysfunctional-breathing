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
    <title>Asthma Support App Breathing Exercise page</title>
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/breathingExercises.css">
</head>
<body>
<div class="breathingExercise">
    <div class="topnav">
        <a href="home.php">Back</a>
    </div>
    <div class="breathingExercise-container">

        <h1>Breathing Exercises</h1>

        <div class="dropdown">
            <button class="button" onclick="toggleDropdown()">Select a Breathing Exercise</button>
            <div id="dropdown-content" class="dropdown-content">
                <a href="#" onclick="selectedExercise('nhs advice')">NHS Breathing Well</a>
                <a href="#" onclick="selectedExercise('pursed lip')">Pursed Lip Breathing</a>
                <a href="#" onclick="selectedExercise('diaphragmatic breathing')">Diaphragmatic Breathing</a>
                <a href="#" onclick="selectedExercise('buteyko breathing')">Buteyko Breathing Method</a>
                <a href="#" onclick="selectedExercise('papworth breathing')">Papworth Breathing Method</a>
            </div>
        </div>

        <div id="nhs advice" class="exercise">
            <h2>NHS Breathing Well</h2>
            <br>
            <fieldset>
                <legend>About</legend>
                <p>It is important to maintain a good breathing pattern so you are able to recognise the symptoms of irregular breathing.</p>
                <p>To achieve a good breathing pattern you should practice 20 minutes each day.</p>
                <p>We will divide breathing into 2 parts Good Posture and Good Breathing.</p>
            </fieldset>
            <fieldset>
                <legend>Good Posture</legend>
                To achieve good posture in a seated position:
                <ul>
                    <li>Sit with your bottom at the back of the chair</li>
                    <li>Put your feet flat on the floor</li>
                    <li>Drop your shoulders away from your ears</li>
                    <li>Let your arms go heavy</li>
                </ul>
            </fieldset>
            <fieldset>
                <legend>Good Breathing</legend>
                With the correct posture in a seated position:
                <ul>
                    <li>place your lips together and think about breathing through your nose</li>
                    <li>Let your body determine the size of each breath</li>
                    <li>should notice your tummy gently fills as you breathe in and falls as you breathe out</li>
                </ul>
                <p>If you struggle to achive a good breathing pattern while seated try while lying on your back with a pillow under your head.</p>
            </fieldset>
            </div>

        <div id="pursed lip" class="exercise">
            <h2>Pursed Lip Breathing</h2>
            <br>
            <fieldset>
                <legend>About</legend>
                Pursed lip breathing is a technique used by people with Asthma or COPD to help control shortness of breath.
                <br>
                <br>
                It is a quick method to slow the pace of your breathing and make each breath more effcetive.
            </fieldset>
            <fieldset>
                <legend>Benefits</legend>
                <ul>
                    <li>Controls shortness of breath</li>
                    <li>Reduced stress</li>
                    <li>Improves quality of life</li>
                </ul>
            </fieldset>
            <fieldset>
                <legend>How to Perform</legend>
                <ul>
                    <li>Relax your shoulders</li>
                    <li>Breathe in slowly through the nose with your mouth closed</li>
                    <li>Purse your lips</li>
                    <li>Exhale slowly through the mouth</li>
                    <br>
                    <li>Repeat until your breathing becomes normal</li>
                </ul>
            </fieldset>
            <p>Video on how to perform Pursed Lip Breathing by American Lung Association</p>
            <iframe width="300" height="225" src="https://www.youtube.com/embed/7kpJ0QlRss4" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>

        <div id="diaphragmatic breathing" class="exercise">
            <h2>Diaphragmatic Breathing</h2>
            <br>
            <fieldset>
                <legend>About</legend>
                Diaphragmatic Breathing (also called "Belly Breathing") is a technique used to improve ventilation and minimise the work respiratory muscles do while breathing.
                <br><br>
                It is an effective method to help with shortness of breathing caused by Asthma, COPD and other Respiratory Diseases.
            </fieldset>
            <fieldset>
                <legend>Benefits</legend>
                <ul>
                    <li>Helps control the symptoms of asthma</li>
                    <li>Lowers blood pressure</li>
                    <li>Reduces stress levels</li>
                </ul>
            </fieldset>
            <fieldset>
                <legend>How to Perform</legend>
                <ul>
                    <li>Sit Down with hands on your belly</li>
                    <li>Breathe in slowly through the nose</li>
                    <li>Exhale Through pursed lips</li>
                    <li>Make sure your chest remains still throughout</li>
                    <li>Repeat for 5 to 10 minutes</li>
                    <li>Keep hands on your belly to focus on air going in and out</li>
                </ul>
            </fieldset>
            <p>Video on how to perform Diaphragmatic Breathing by American Lung Association</p>
            <iframe width="300" height="225" src="https://www.youtube.com/embed/wai-GIYGMeo" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>

        <div id="buteyko breathing" class="exercise">
            <h2>Buteyko Breathing Method</h2>
            <br>
            <fieldset>
                <legend>About</legend>
                Buteyko Breathing Method is a technique used to manage the symptoms of asthma and other chronic respiratory diseases.
                <br><br>
                It focuses on controlling hyperventilation (rapid or deep breathing).
            </fieldset>
            <fieldset>
                <legend>Benefits</legend>
                <ul>
                    <li>Reduce the symptoms of asthma</li>
                    <li>Reduced anxiety levels</li>
                    <li>Reduce the need for medications</li>
                </ul>
            </fieldset>
            <fieldset>
                <legend>How to Perform</legend>
                <ul>
                    <li>Breathe normally for a couple of minutes</li>
                    <li>After a relaxed exhale hold your breath using your index finger and thumb to plug your nose</li>
                    <li>Hold your breath like this until you feel the need to breathe, then inhale</li>
                    <li>Breathe normally for around 10 seconds</li>
                    <li>Repeat several times</li>
                </ul>
            </fieldset>
            <p>Image showing how to perform the Breathing Method from Buteyko Breathing Centre</p>
            <img src="https://i0.wp.com/buteykocenter.dk/wp-content/uploads/2017/08/holding_breath.png?w=562&ssl=1" alt="Buteyko Breathing Method Diagram" style="width: 100%;">
        </div>

        <div id="papworth breathing" class="exercise">
            <h2>Papworth Breathing Method</h2>
            <br>
            <fieldset>
                <legend>About</legend>
                Papworth Breathing Method is a technique used to teach people which muscles to use to avoid breathing too fast and deeply by accentuating breathing through the nose.
                <br><br>
                It has been shown to alleviate the symptoms and improve the quality of life of people with asthma.
            </fieldset>
            <fieldset>
                <legend>Benefits</legend>
                <ul>
                    <li>More controlled and efficient breathing</li>
                    <li>Reduced anxiety</li>
                    <li>Possible reduced reliance on medications</li>
                </ul>
            </fieldset>
            <fieldset>
                <legend>How to Perform</legend>
                Papworth Breathing Method is a series of relaxation and breathing exercises taught by respiratory physiotherapists.
                <br>
                (so a full guide on how to perform it will not be available here)
                <br><br>
                It consists of 5 components:
                <ul>
                    <li>breathing training</li>
                    <li>relaxation training</li>
                    <li>education about the physical stress response</li>
                    <li>integration of techniques into daily life</li>
                    <li>daily home exercises</li>
                </ul>
            </fieldset>
        </div>
    </div>
    <script>
        function toggleDropdown() {
            var dropdownContent = document.getElementById("dropdown-content");
            dropdownContent.classList.toggle("show");
        }

        function selectedExercise(exercise) {
            var allExercises= document.getElementsByClassName("exercise");
            for (var i = 0; i < allExercises.length; i++) {
                allExercises[i].style.display = "none";
            }

            var selectedExercise = document.getElementById(exercise);
            selectedExercise.style.display = "block";

            var dropdownContent = document.getElementById("dropdown-content");
            dropdownContent.classList.remove("show");
        }

        selectedExercise('nhs advice');
    </script>
</body>
</html>