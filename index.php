<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Asthma Support App login page</title>
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/index.css">
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
if (isset($_POST['submit'])){
    if(empty(trim($_POST["username"]))) {
        $username_error = "Please enter a username";
    } else{
        $username = stripslashes($_REQUEST['username']);
        $username = mysqli_real_escape_string($link,$username);
    }
    if(empty(trim($_POST["password"]))) {
        $password_error = "Please enter a password";
    } else{
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($link,$password);
    }
    if(empty($username_error) && empty($password_error)){
        $query = "SELECT * FROM `Users` WHERE username='$username'and password='".md5($password)."'";
        $result = mysqli_query($link,$query) or die(mysqli_error());
        $rows = mysqli_num_rows($result);
        if($rows==1){
            $_SESSION['username'] = $username;
            header("Location: home.php");
            exit();
        } else {
            $username_error = "Incorrect username or password";
        }
    }
}
?>
<main>
    <form class="login" action="" method="post">
        <div class="login-container">
            <div class="login-header">Log In</div>
            <span class="invalid-feedback"><?php echo $username_error; ?></span>
            <input class="login-input" name="username" type="text" placeholder="Username">

            <span class="invalid-feedback"><?php echo $password_error; ?></span>
            <input class="login-input" name="password" type="password" placeholder="Password">

            <input class="login-button" type="submit" name="submit" value="Login">
            <div class="login-links">
                <a class="login-links" href="signup.php">Sign Up</a>
                <br>
                <br>
                <a class="login-links" href="resetPassword.php">Forgot your password?</a>
                <br>
                <br>
                <a class="login-links" href="clinicianLogin.php">Log in as a Clinician</a>
            </div>
        </div>
    </form>
</main>
</body>
</html>