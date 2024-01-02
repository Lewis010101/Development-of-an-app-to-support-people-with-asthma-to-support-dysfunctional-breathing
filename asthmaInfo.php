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
    <title>Asthma Support App Asthma Info page</title>
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/asthmaInfo.css">
</head>
<body>
<div class="asthmaInfo">
    <div class="topnav">
        <a href="home.php">Back</a>
    </div>
    <div class="asthmaInfo-container">

        <h1>Chronic Respiratory Diseases</h1>

        <div class="dropdown">
            <button class="button" onclick="toggleDropdown()">Select a Respiratory Disease</button>
            <div id="dropdown-content" class="dropdown-content">
                <a href="#" onclick="selectedDisease('asthma')">Asthma</a>
                <a href="#" onclick="selectedDisease('copd')">Chronic Obstructive Pulmonary Disease</a>
                <a href="#" onclick="selectedDisease('pulmonary fibrosis')">Pulmonary Fibrosis</a>
                <a href="#" onclick="selectedDisease('cystic fibrosis')">Cystic Fibrosis</a>
            </div>
        </div>

        <div id="asthma" class="disease">
            <h2>Asthma</h2>
            <fieldset>
                <legend>About</legend>
                Asthma is a common long term lung condition where air passages to the lungs are narrowed due to inflammation and tightening of muscles around airways.
                <br><br>
                The symptoms of asthma can become worse due to asthma attacks which can be caused by triggers such as pollen or exercise.
                <br><br>
                There is currently no cure for asthma however symptoms can be controlled using medication or treatments such as breathing exercises.
            </fieldset>
            <fieldset>
                <legend>Common Symptoms</legend>
                <ul>
                    <li>Wheezing</li>
                    <li>Breathlessness</li>
                    <li>Coughing</li>
                    <li>Tight Chest</li>
                </ul>
            </fieldset>
            <fieldset>
                <legend>Common Medication & Treatment</legend>
                Inhalers
                <ul>
                    <li>Reliever Inhaler - to treat symptoms when they occur</li>
                    <li>Preventer Inhaler - taken each day to stop symptoms occurring</li>
                </ul>
                Tablets
                <ul>
                    <li>Theophylline</li>
                    <li>Steroid Tablets</li>
                    <li>Leukotriene receptor antagonists (LTRAs) </li>
                </ul>
                Other Treatments
                <ul>
                    <li>Bronchial Thermoplasty</li>
                    <li>Biologic Therapies</li>
                    <li>Breathing Exercises</li>
                </ul>
            </fieldset>
            <a href="https://www.asthmaandlung.org.uk/conditions/asthma" target="_blank">
                <button class="asthmaInfo-button">More Asthma Information via (Asthma + Lung UK)</button>
            </a>
            <a href="https://asthma.net/forums" target="_blank">
                <button class="asthmaInfo-button">Asthma Support Forum</button>
            </a>
        </div>

        <div id="copd" class="disease">
            <h2>Chronic Obstructive Pulmonary Disease (COPD)</h2>
            <fieldset>
                <legend>About</legend>
                Chronic Obstructive Pulmonary Disease is the name for a group of lung conditions where airflow out of the lungs is obstructed.
                <br><br>
                It is caused by exposure to risk factors over time these include, smoking and air pollution.
                <br><br>
                Diseases which fall under COPD include Bronchitis and Emphysema.
                <br><br>
                While there is no cure for COPD there are treatments and medication which can be taken.
            </fieldset>
            <fieldset>
                <legend>Common Symptoms</legend>
                <ul>
                    <li>Shortness of Breath</li>
                    <li>Persistent Cough</li>
                    <li>Wheezing</li>
                    <li>Coughing up Phlegm</li>
                </ul>
            </fieldset>
            <fieldset>
                <legend>Common Medication & Treatment</legend>
                Short-acting Bronchodilator Inhalers
                <ul>
                    <li>beta-2 agonist inhalers – salbutamol and terbutaline</li>
                    <li>antimuscarinic inhalers – ipratropium</li>
                </ul>
                Long-acting Bronchodilator Inhalers
                <ul>
                    <li>beta-2 agonist inhalers – salmeterol, formoterol and indacaterol</li>
                    <li>antimuscarinic inhalers – tiotropium, glycopyronium and aclidinium</li>
                </ul>
                Other Treatment
                <ul>
                    <li>Theophylline tablets</li>
                    <li>Steroid tablets</li>
                    <li>Antibiotics</li>
                    <li>Breathing Exercises</li>
                </ul>
            </fieldset>
            <a href="https://www.asthmaandlung.org.uk/conditions/copd-chronic-obstructive-pulmonary-disease" target="_blank">
                <button class="asthmaInfo-button">More COPD Information via (Asthma + Lung UK)</button>
            </a>
            <a href="https://copd.net/forums" target="_blank">
                <button class="asthmaInfo-button">COPD Support Forum</button>
            </a>
        </div>

        <div id="pulmonary fibrosis" class="disease">
            <h2>Pulmonary Fibrosis</h2>
            <fieldset>
                <legend>About</legend>
                Pulmonary Fibrosis is the build up of scar tissue on the lungs, in most cases the cause of this scarring cannot be identified.
                <br><br>
                In some cases it can be caused by Interstitial Lung Diseases which are a group of Lung Diseases which damage lung tissue.
                <br><br>
                Common Interstitial Lung Diseases
                <ul>
                    <li>Occupational interstitial lung diseases - where harmful dusts in work places cause scarring to lung tissue</li>
                    <li>Sarcoidosis - where the immune system causes damage to tissue and organs it is most often found in the lungs</li>
                </ul>
                Similar to other Chronic Respiratory Diseases there is no cure however there is treatment to help control symptoms.
            </fieldset>
            <fieldset>
                <legend>Common Symptoms</legend>
                <ul>
                    <li>Breathlessness</li>
                    <li>Persistent Cough</li>
                    <li>Tiredness and Fatigue</li>
                    <li>Clubbing of Fingers and Toes - the tips of fingers and toes enlarging</li>
                </ul>
            </fieldset>
            <fieldset>
                <legend>Common Medication & Treatment</legend>
                Medication
                <ul>
                    <li>Pirfenidone</li>
                    <li>Nintedanib</li>
                    <li>Steroids or other immunosuppressant drugs</li>
                </ul>
                Other Treatments
                <ul>
                    <li>Lung Transplant - when Pulmonary Fibrosis progresses and treatment fails to stabilise it</li>
                </ul>
            </fieldset>
            <a href="https://www.asthmaandlung.org.uk/conditions/pulmonary-fibrosis" target="_blank">
                <button class="asthmaInfo-button">More Pulmonary Fibrosis Information via (Asthma + Lung UK)</button>
            </a>
            <a href="https://www.inspire.com/groups/living-with-pulmonary-fibrosis/" target="_blank">
                <button class="asthmaInfo-button">Pulmonary Fibrosis Support Forum</button>
            </a>
        </div>

        <div id="cystic fibrosis" class="disease">
            <h2>Cystic Fibrosis</h2>
            <fieldset>
                <legend>About</legend>
                Cystic Fibrosis is an inherited condition which affects the balance of salt and water in the body. This causes mucus to build up in the lungs and gut.
                <br><br>
                The build of mucus in the lungs can lead to germs growing which cause lung infections. Mucus can also build up in the digestive system affecting how food is digested.
                <br><br>
                There is no cure for Cystic Fibrosis but there are treatments to help control symptoms and improve quality of life.
            </fieldset>
            <fieldset>
                <legend>Common Symptoms</legend>
                Symptoms affecting the Lungs
                <ul>
                    <li>Chest Infections</li>
                    <li>Wet Cough</li>
                    <li>Wheezing</li>
                    <li>Shortness of Breath</li>
                </ul>
                Symptoms affecting the Digestive System
                <ul>
                    <li>Needing to eat more food</li>
                    <li>Frequent bowl movements</li>
                    <li>Constipation</li>
                </ul>
                Complications
                <ul>
                    <li>Diabetes</li>
                    <li>Osteoporosis</li>
                    <li>Liver problems</li>
                </ul>
            </fieldset>
            <fieldset>
                <legend>Common Medication & Treatment</legend>
                <ul>
                    <li>Airway clearance</li>
                    <li>Mucolytics - medicine to make mucus easier to clear</li>
                    <li>CFTR modulator drugs</li>
                    <li>Antibiotics - to treat the chest infections caused by Cystic Fibrosis</li>
                    <li>Dietitian - to give advice on what foods to eat due to digestive issues</li>
                    <li>Lung Transplant</li>
                </ul>
            </fieldset>
            <a href="https://www.asthmaandlung.org.uk/conditions/cystic-fibrosis" target="_blank">
                <button class="asthmaInfo-button">More Cystic Fibrosis Information via (Asthma + Lung UK)</button>
            </a>
            <a href="https://cystic-fibrosis.com/forums" target="_blank">
                <button class="asthmaInfo-button">Cystic Fibrosis Support Forum</button>
            </a>
        </div>

    </div>
</div>
<script>
    function toggleDropdown() {
        var dropdownContent = document.getElementById("dropdown-content");
        dropdownContent.classList.toggle("show");
    }

    function selectedDisease(disease) {
        var allDiseases = document.getElementsByClassName("disease");
        for (var i = 0; i < allDiseases.length; i++) {
            allDiseases[i].style.display = "none";
        }

        var selectedDisease = document.getElementById(disease);
        selectedDisease.style.display = "block";

        var dropdownContent = document.getElementById("dropdown-content");
        dropdownContent.classList.remove("show");
    }

    selectedDisease('asthma');
</script>
</body>
</html>

