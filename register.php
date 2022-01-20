<?php
include('db.php');

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password = md5($password);
    $auth_status = 0;
    try {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://google-authenticator.p.rapidapi.com/new_v2/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "x-rapidapi-host: google-authenticator.p.rapidapi.com",
                "x-rapidapi-key: 0fbe618565mshf269b32acbdef8bp1af87cjsn1d9c39db09b8"
            ],
        ]);

        $response = curl_exec($curl);

        $insert_user = "INSERT INTO tbl_users(username,password,secert_key,auth_status) VALUES ('$username','$password','$response','$auth_status')";
        $run_insert = mysqli_query($con, $insert_user);
        if ($run_insert) {
            header("Location: index.php");
        }
    } catch (Exception $e) {
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
        <h3>Register Here</h3>

        <label for="username">Username</label>
        <input type="text" placeholder="Username" name="username" id="username">

        <label for="password">Password</label>
        <input type="password" placeholder="Password" name="password" id="password">

        <button name="register">Register</button>
        <div class="social">
            <a href="index.php">Login</a>
        </div>
    </form>
</body>

</html>