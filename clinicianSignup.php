<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Asthma Support App Clinician signup page</title>
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/clinicianSignup.css">
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

$username_error = $email_error= $password_error = $confirm_password_error = "";

if (isset($_REQUEST['clinician_username'])){

    if(empty(trim($_POST["clinician_username"]))) {
        $username_error = "Please enter a username.";
    } else{
        $select = mysqli_query($link, "SELECT * FROM Clinicians WHERE username = '".$_POST['clinician_username']."'");
        if(mysqli_num_rows($select)) {
            $username_error = "This username is already taken.";
        } else {
            $username = stripslashes($_REQUEST['clinician_username']);
            $username = mysqli_real_escape_string($link, $username);
        }
    }

    if(empty(trim($_POST["clinician_email"]))) {
        $email_error = "Please enter an email.";
    } else{
        $select = mysqli_query($link, "SELECT * FROM Clinicians WHERE email = '".$_POST['clinician_email']."'");
        if(mysqli_num_rows($select)) {
            $email_error = "This email is already taken.";
        } else {
            $email = stripslashes($_REQUEST['clinician_email']);
            $email = mysqli_real_escape_string($link, $email);
        }
    }

    if(empty(trim($_POST["clinician_password"]))){
        $password_error = "Please enter a password.";
    } elseif(strlen(trim($_POST["clinician_password"])) < 8){
        $password_error = "Password must have atleast 8 characters.";
    } else{
        $password = stripslashes($_REQUEST['clinician_password']);
        $password = mysqli_real_escape_string($link,$password);
    }

    if(empty(trim($_POST["clinician-re-enter-password"]))){
        $confirm_password_error = "Please confirm password.";
    } else{
        $confirm_password = stripslashes($_REQUEST['clinician-re-enter-password']);
        $confirm_password = mysqli_real_escape_string($link,$confirm_password);
        if(empty($password_error) && ($password != $confirm_password)){
            $confirm_password_error = "Password did not match.";
        }
    }

    $carer_date = date("Y-m-d");

    if(empty($username_error) && empty($email_error) && empty($password_error) && empty($confirm_password_error)){

        $query = "INSERT into `Clinicians` (username, password, email) VALUES ('$username', '".md5($password)."', '$email')";
        $result = mysqli_query($link,$query);

        if($result){
            header("location: clinicianLogin.php");
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
}
?>
<main>
    <form class="clinicianSignup" action="clinicianSignup.php" method="post">
        <div class="clinicianSignup-container">
            <div class="clinicianSignup-header">Create an account.</div>
            <span class="invalid-feedback"><?php echo $username_error; ?></span>
            <input class="clinicianSignup-input" type="text" name="clinician_username" placeholder="Username">

            <span class="invalid-feedback"><?php echo $email_error; ?></span>
            <input class="clinicianSignup-input" type="email" name="clinician_email" placeholder="Email">

            <span class="invalid-feedback"><?php echo $password_error; ?></span>
            <input class="clinicianSignup-input" type="password" name="clinician_password" placeholder="Password">

            <span class="invalid-feedback"><?php echo $confirm_password_error; ?></span>
            <input class="clinicianSignup-input" type="password" name="clinician-re-enter-password" placeholder="Re-Enter-Password">

            <button class="clinicianSignup-button" type="submit">SignUp</button>
            <div class="clinicianSignup-links">
                <a class="clinicianSignup-links" href="clinicianLogin.php">I already have an account</a>
            </div>
        </div>
    </form>
</main>
</body>
</html>