<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rezervasyon";

$connection = new mysqli($servername, $username, $password, $dbname);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$connection->query('SET NAMES UTF8');
session_start();

function redirect($url){
    if (!headers_sent()){
        header('Location: '.$url); exit;
    }else{
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; exit;
    }
}

?>