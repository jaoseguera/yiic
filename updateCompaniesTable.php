<?php  
  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

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



  // Pass Curl the URL

  curl_setopt($curl, CURLOPT_URL, 'http://admin:admin123@45.79.208.254:5984/thinuicompanies/_all_docs');
  curl_setopt($curl, CURLOPT_HEADER, 0); 
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

  // Perform actions

  $updateList = array();

  $db_list = curl_exec($curl);  

  $db_list = json_decode($db_list);

  $db_list = $db_list->rows;

  $cont = 0;

  for($i=0; $i<count($db_list); $i++){
    $record = $db_list[$i];            
    curl_setopt($curl, CURLOPT_URL, 'http://admin:admin123@45.79.208.254:5984/thinuicompanies/'.$record->id);     
              $record=json_decode(curl_exec($curl));


              if(isset($record->mailserver)){
                  $record->mailserver->host = $qDecoded      = encrypt_decrypt('encrypt', mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $salt ), base64_decode($record->mailserver->host), MCRYPT_MODE_CBC, md5( md5( $salt ) ) ));

                  $record->mailserver->port = $qDecoded      = encrypt_decrypt('encrypt', mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $salt ), base64_decode($record->mailserver->port), MCRYPT_MODE_CBC, md5( md5( $salt ) ) ));            

                  $record->mailserver->username = $qDecoded      = encrypt_decrypt('encrypt', mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $salt ), base64_decode($record->mailserver->username), MCRYPT_MODE_CBC, md5( md5( $salt ) ) ));

                  $record->mailserver->fromname = $qDecoded      = encrypt_decrypt('encrypt', mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $salt ), base64_decode($record->mailserver->fromname), MCRYPT_MODE_CBC, md5( md5( $salt ) ) ));            

                  if(isset($record->mailserver->smtpauth) && $record->mailserver->smtpauth == 'true'){
                  $record->mailserver->password = $qDecoded      = encrypt_decrypt('encrypt', mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $salt ), base64_decode($record->mailserver->password), MCRYPT_MODE_CBC, md5( md5( $salt ) ) ));    
                  }        
                  /*
                  curl_setopt($curl2, CURLOPT_URL, 'http://admin:admin123@45.79.208.254:5984/thinuicompanies/'.$record->_id);
                  curl_setopt($curl2, CURLOPT_CUSTOMREQUEST, "PUT");
                  curl_setopt($curl2, CURLOPT_POSTFIELDS,json_encode($record));
                  
                  $x = curl_exec($curl2);
                  echo $x."<br>";*/
                  array_push($updateList, $record);

              }

  }

 

  for($i=0; $i<count($updateList); $i++){

              echo $updateList[$i]->_id."<br>";
              echo $updateList[$i]->mailserver->host." = ".encrypt_decrypt("decrypt",$updateList[$i]->mailserver->host)."<br>";

              echo $updateList[$i]->mailserver->port." = ".encrypt_decrypt("decrypt",$updateList[$i]->mailserver->port)."<br>";

    echo $updateList[$i]->mailserver->username." = ".encrypt_decrypt("decrypt",$updateList[$i]->mailserver->username)."<br>";

    echo $updateList[$i]->mailserver->fromname." = ".encrypt_decrypt("decrypt",$updateList[$i]->mailserver->fromname)."<br>";
    if(isset($updateList[$i]->mailserver->smtpauth) && $updateList[$i]->mailserver->smtpauth == 'true'){
      echo $updateList[$i]->mailserver->password." = ".encrypt_decrypt("decrypt",$updateList[$i]->mailserver->password)."<br>";
    }
              echo "-------------------------------<br>";

  }

  curl_close($curl);
  curl_close($curl2);


?>