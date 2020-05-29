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

 

 

 

 

  // Pass Curl the URL

  curl_setopt($curl, CURLOPT_URL, 'http://admin:admin123@45.79.208.254:5984/thinuiusers/_all_docs');

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

            curl_setopt($curl, CURLOPT_URL, 'http://admin:admin123@45.79.208.254:5984/thinuiusers/'.$record->id);   

            $record=json_decode(curl_exec($curl));

            if(isset($record->system)){
                        /*
                        $record->system->username = $qDecoded      = encrypt_decrypt('encrypt', mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $salt ), base64_decode($record->system->username), MCRYPT_MODE_CBC, md5( md5( $salt ) ) ));

                        $record->system->password = $qDecoded      = encrypt_decrypt('encrypt', mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $salt ), base64_decode($record->system->password), MCRYPT_MODE_CBC, md5( md5( $salt ) ) ));               
                        
                        curl_setopt($curl2, CURLOPT_URL, 'http://admin:admin123@45.79.208.254:5984/thinuiusers/'.$record->_id);
                        curl_setopt($curl2, CURLOPT_CUSTOMREQUEST, "PUT");
                        curl_setopt($curl2, CURLOPT_POSTFIELDS,json_encode($record));
                        $x = curl_exec($curl2);
                        echo $x."<br>";*/
                        array_push($updateList, $record);
                        

            }

  }

 

  for($i=0; $i<count($updateList); $i++){

            echo $updateList[$i]->system->username." = ".encrypt_decrypt("decrypt",$updateList[$i]->system->username)."<br>";

            echo $updateList[$i]->system->password." = ".encrypt_decrypt("decrypt",$updateList[$i]->system->password)."<br>";

            echo "-------------------------------<br>";

  }

  curl_close($curl);
  curl_close($curl2);
 

?>