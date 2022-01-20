<?php

session_start();
include('db.php');

$username = $_GET['auth'];

$select_key = mysqli_query($con,"SELECT * FROM tbl_users WHERE username='$username'");
while ($row_key = mysqli_fetch_array($select_key))
{
    $secret_key = $row_key['secert_key'];
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Design by foolishdeveloper.com -->
    <title>Glassmorphism login Form Tutorial in html css</title>

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
    <form method="POST" action="verify.php?auth=<?php echo $secret_key ?>">
        <h3>OTP</h3>
        <label>OTP CODE</label>
        <input type="text" maxlength="6" placeholder="OTP CODE" name="code">
        <button name="verify">Verify</button>
    </form>
</body>

</html>