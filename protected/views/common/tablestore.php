<?php
try {
    if(isset($_REQUEST['pos']))
    {
        $doc->$_REQUEST['dd']->positions = $_REQUEST['pos'];
    }
    if(isset($_REQUEST['hid']))
    {
        $doc->$_REQUEST['dd']->hiden_columns = $_REQUEST['hid'];
    }
    if(isset($_REQUEST['fav']))
    {
        echo $_REQUEST['fav'];
        $doc->favorites->$_REQUEST['fav'] = $_REQUEST['tit'].",".$_REQUEST['type'].",".Controller::Bapiname($_REQUEST['fav']);
    }
    $client->storeDoc($doc);
} 
catch (Exception $e) {
    echo $e->getMessage();
}
?>