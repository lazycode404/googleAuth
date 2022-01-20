<?php
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
include('db.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password = md5($password);

    $select_user = "SELECT * FROM tbl_users WHERE username='$username'";
    $run_user = mysqli_query($con, $select_user);

    if ($run_user) {
        if ($run_user && mysqli_num_rows($run_user) > 0) {
            $userdata = mysqli_fetch_assoc($run_user);
            if ($userdata['password'] == $password) {
                if ($userdata['auth_status'] == 1) {
                    $_SESSION['username'] = $userdata['username'];
                    
                    header("Location: otp.php?auth=$username");
                    exit();
                } else {
                    $_SESSION['username'] = $userdata['username'];
                    header("Location: home.php");
                    exit();
                }
            } else {
                header("Location: index.php?");
                exit();
            }
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Google authenticator Tutorial</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="post">
        <h3>Login Here</h3>

        <label for="username">Username</label>
        <input type="text" placeholder="Username" name="username" id="username">

        <label for="password">Password</label>
        <input type="password" placeholder="Password" name="password" id="password">

        <button name="login">Log In</button>
        <div class="social">
            <a href="register.php">Register</a>
        </div>
    </form>
</body>

</html>