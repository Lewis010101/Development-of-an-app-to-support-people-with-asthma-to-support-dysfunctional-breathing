<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <title>Asthma Support App Sign Up page</title>
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/signup.css">
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

$username_error = $email_error = $firstname_error = $surname_error = $password_error = $confirm_password_error = "";

if (isset($_REQUEST['username'])){

    if(empty(trim($_POST["username"]))) {
        $username_error = "Please enter a username.";
    } else{
        $select = mysqli_query($link, "SELECT * FROM Users WHERE username = '".$_POST['username']."'");
        if(mysqli_num_rows($select)) {
            $username_error = "This username is already taken.";
        } else {
            $username = stripslashes($_REQUEST['username']);
            $username = mysqli_real_escape_string($link,$username);
        }
    }

    if(empty(trim($_POST["email"]))) {
        $email_error = "Please enter an email.";
    } else{
        $select = mysqli_query($link, "SELECT * FROM Users WHERE email = '".$_POST['email']."'");
        if(mysqli_num_rows($select)) {
            $email_error = "This email is already taken.";
        } else {
            $email = stripslashes($_REQUEST['email']);
            $email = mysqli_real_escape_string($link,$email);
        }
    }

    if(empty(trim($_POST["firstname"]))) {
        $firstname_error = "Please enter your firstname.";
    } else{
        $firstname = stripslashes($_REQUEST['firstname']);
        $firstname = mysqli_real_escape_string($link,$firstname);
    }

    if(empty(trim($_POST["surname"]))) {
        $surname_error = "Please enter your surname.";
    } else{
        $surname = stripslashes($_REQUEST['surname']);
        $surname = mysqli_real_escape_string($link,$surname);
    }

    if(empty(trim($_POST["password"]))){
        $password_error = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 8){
        $password_error = "Password must have at least 8 characters.";
    } else{
        $password = stripslashes($_REQUEST['password']);
        $password = mysqli_real_escape_string($link,$password);
    }

    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_error = "Please confirm password.";
    } else{
        $confirm_password = stripslashes($_REQUEST['confirm_password']);
        $confirm_password = mysqli_real_escape_string($link,$confirm_password);
        if(empty($password_error) && ($password != $confirm_password)){
            $confirm_password_error = "Password did not match.";
        }
    }

    function generateRandomString($length = 15) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    $user_code = generateRandomString();

    if(empty($username_error) && empty($email_error) && empty($firstname_error) && empty($surname_error) && empty($password_error) && empty($confirm_password_error)){

        $query = "INSERT into `Users` (username, firstname, surname, email, password, user_code) VALUES ('$username', '$firstname', '$surname', '$email', '".md5($password)."', '$user_code')";
        $result = mysqli_query($link,$query);

        if($result){
            header("location: index.php");
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
}
?>
<main>
    <form class="signup" action="signup.php" method="post">
        <div class="signup-container">
            <div class="signup-header">Sign up</div>
            <span class="invalid-feedback"><?php echo $username_error; ?></span>
            <input class="signup-input" type="text" name="username" placeholder="Username">

            <span class="invalid-feedback"><?php echo $firstname_error; ?></span>
            <input class="signup-input" type="text" name="firstname" placeholder="Firstname">

            <span class="invalid-feedback"><?php echo $surname_error; ?></span>
            <input class="signup-input" type="text" name="surname" placeholder="Surname">

            <span class="invalid-feedback"><?php echo $email_error; ?></span>
            <input class="signup-input" type="email" name="email" placeholder="Email">

            <span class="invalid-feedback"><?php echo $password_error; ?></span>
            <input class="signup-input" type="password" name="password" placeholder="Password">

            <span class="invalid-feedback"><?php echo $confirm_password_error; ?></span>
            <input class="signup-input" type="password" name="confirm_password" placeholder="Confirm Password">

            <button class="signup-button" type="submit">SignUp</button>
            <div class="signup-links">
                <p>Already have an account? </p><a class="signup-links" href="index.php">Log In</a>
            </div>
        </div>
    </form>
</main>

</body>
</html>
