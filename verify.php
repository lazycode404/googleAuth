<?php

try {

    $otp_code = $_POST['code'];
    $secret_key = $_GET['auth'];

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => "https://google-authenticator.p.rapidapi.com/validate/?code=$otp_code&secret=$secret_key",
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

    if ($response == 'False') {
        header("Location: otp.php");
    } else {
        
        echo "Redirecting in 3 seconds..";
        header('Refresh: 3;URL=home.php');
    }
} catch (Exception $e) {
}


