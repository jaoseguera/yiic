<?php

 

  // Initialize Curl

  $curl = curl_init();
  $curl2 = curl_init();

  $salt = md5("build.thinui.com");

 

  function encrypt_decrypt($action, $string) {

    $output = false;

    $encrypt_method = "AES-256-CBC";

    $salt = md5("build.thinui.com");

    $secret_key = md5($salt);

    $secret_iv = substr(md5(md5($salt)),0,16);

    // hash

    $key = hash('sha256', $secret_key);

    $key = $secret_key;

 
    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning

    $iv = $secret_iv;//substr(hash('sha256', $secret_iv), 0, 16);

    if ( $action == 'encrypt' ) {

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);

        $output = base64_encode($output);

    } else if( $action == 'decrypt' ) {

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

    }

    return $output;

}
echo "HOST:".(encrypt_decrypt("encrypt","smtp.gmail.com"))."<br>";
echo "PORT:".(encrypt_decrypt("encrypt","587"))."<br>";
echo "USERNAME:".(encrypt_decrypt("encrypt","help.thinui@emergyscorp.com"))."<br>";
echo "PASS:".(encrypt_decrypt("encrypt","9y=67eHH1"))."<br>";
 

?>