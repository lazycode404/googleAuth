<?php

if (!isset($_SESSION)) {
    session_start();
}

include('db.php');

$username = $_SESSION['username'];

$select_user = "SELECT * FROM tbl_users WHERE username='$username'";
$run_user = mysqli_query($con, $select_user);
while ($row_user = mysqli_fetch_array($run_user)) {
    $secret_key = $row_user['secert_key'];
    $auth_status = $row_user['auth_status'];
}
try {
    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://google-authenticator.p.rapidapi.com/enroll/?secret=$secret_key&account=$username&issuer=localhost/googleAuth",
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
} catch (Exception $e) {
}

if (isset($_POST['enableAuth'])) {
    $status = 1;

    $code = $_POST['otp'];

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://google-authenticator.p.rapidapi.com/validate/?code=$code&secret=$secret_key",
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

    if($response == 'True')
    {
        $update_status = "UPDATE tbl_users SET auth_status='$status' WHERE username='$username'";
        $run_update = mysqli_query($con,$update_status);
        if($run_update)
        {
            header("Location: home.php");
        }
    }
}

?>
<style>
    .auth {
        text-decoration: none !important;
        color: blue;
    }

    a {
        text-decoration: none !important;
    }

    .setting {
        opacity: 0.5;
    }
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/jquery-1.9.1.js">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <br>
    <br>
    <center>
        <h2><?php echo $username; ?></h2>
        <a href="logout.php">Logout</a>
    </center>
    <br><br>
    <!-- Button trigger modal -->
    <center>
        <?php
        if ($auth_status == 0) {
        ?>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Google authenticator
            </button>
        <?php
        } else {
        }
        ?>
    </center>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <center><img class="setting" src="icon.png" height="70" alt=""></center><br>
                    <center>
                        <h3>Activate the authenticator App</h3><br>
                    </center>
                    <p>
                        You'll need to install a two-factor authenticator application on your smartphone/table such as
                        <a class="auth">Google Authenticator</a>.
                    </p>
                    <br>
                    <h5>1. Configure the app</h5>
                    Open your <a class="auth">two-factor authentication application</a> and add your website account by scanning the QR code.
                    <center><br>
                        <img src="<?php echo $response ?>" alt=""><br><br>
                        If you can't use a QR code, enter this text code.
                        <a class="auth"><?php echo $secret_key; ?></a>
                    </center>
                    <br>
                    <h5>2. Enter the 6-digit code</h5>
                    <form class="row g-1" method="POST">
                        <div class="col">
                            <input type="text" name="otp" maxlength="6" class="form-control">
                        </div>
                        <div class="col-auto">
                            <button type="submit" name="enableAuth" class="btn btn-primary mb-3">Enable</button>
                        </div>
                    </form>
                    <center><a href="home.php"><-Back to Dashbaord</a></center>
                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>