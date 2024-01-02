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
    <title>Asthma App profile page</title>
    <link rel="stylesheet" href="CSS/normalize.css">
    <link rel="stylesheet" href="CSS/profile.css">
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
        $user_code = $row["user_code"];
        $firstname = $row["firstname"];
        $surname = $row["surname"];
        $email = $row["email"];
    }
}

if (isset($_POST["delete"])) {
    $sql = "DELETE FROM Symptoms WHERE username = '".$_SESSION['username']."'";
    $result = mysqli_query($link,$sql);
}

mysqli_close($link);
?>
<main>
    <form class="profile" action="profile.php" method="post">
        <div class="topnav">
            <a href="home.php">Back</a>
        </div>
        <div class="profile-container">
            <h1><?php echo $_SESSION['username']?></h1>
            <br>
            <fieldset>
                <legend>User information</legend>
                Firstname:
                <br>
                <?php echo $firstname?>
                <br><br>
                Surname:
                <br>
                <?php echo $surname?>
                <br><br>
                Email:
                <br>
                <?php echo $email?>
            </fieldset>
            <br>
            <fieldset>
                <legend>User Code</legend>
                <?php echo $user_code; ?>
            </fieldset>
            <button class="profile-button" id="delete" type="submit" name="delete" onclick="return confirmDelete()">Delete All Symptoms Data</button>
        </div>
    </form>
</main>
</body>
</html>
<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete all symptoms?");
    }
</script>