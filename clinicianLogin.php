<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Asthma Support App clinician login page</title>
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/clinicianLogin.css">
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

$username_error = $password_error = "";

session_start();
if (isset($_POST['submit'])) {
    if (empty(trim($_POST["clinician_username"]))) {
        $username_error = "Please enter your username.";
    } else {
        $username = stripslashes($_REQUEST['clinician_username']);
        $username = mysqli_real_escape_string($link, $username);
    }
    if (empty(trim($_POST["clinician_password"]))) {
        $password_error = "Please enter your password.";
    } else {
        $password = stripslashes($_REQUEST['clinician_password']);
        $password = mysqli_real_escape_string($link, $password);
    }

    if (empty($username_error) && empty($password_error)) {
        $query = "SELECT * FROM `Clinicians` WHERE username='$username'and password='" . md5($password) . "'";
        $result = mysqli_query($link, $query) or die(mysqli_error());
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
            $_SESSION['clinician_username'] = $username;
            header("Location: clinicianHome.php");
            exit();
        }else{
            $username_error = "Username does not exist or password is incorrect.";
        }
    }
}
?>
<main>
    <form class="clinicianLogin" action="" method="post">
        <div class="clinicianLogin-container">
            <div class="carer-login-header">Login into your clinician account</div>

            <span class="invalid-feedback"><?php echo $username_error; ?></span>
            <input class="clinicianLogin-input" name="clinician_username" type="text" placeholder="Username">

            <span class="invalid-feedback"><?php echo $password_error; ?></span>
            <input class="clinicianLogin-input" name="clinician_password" type="password" placeholder="Password">

            <input class="clinicianLogin-button" type="submit" name="submit" value="Login">
            <div class="clinicianLogin-links">
                <a class="clinicianLogin-links" href="clinicianSignup.php">Sign Up</a>
                <br>
                <br>
                <a class="clinicianLogin-links" href="clinicianResetPassword.php">Forgot your password?</a>
                <br>
                <br>
                <a class="clinicianLogin-links" href="index.php">Login as normal user</a>
            </div>
        </div>
    </form>
</main>
</body>
</html>