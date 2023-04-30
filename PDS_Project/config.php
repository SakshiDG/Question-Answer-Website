<?php
// $db_host = "localhost";
// $db_name = "demo";
// $db_user = "demo_admin";
// $db_pass = "dnuDn01ODp3GsYp8";

$db_host = '127.0.0.1';
$db_user = 'root';
$db_password = 'root';
$db_db = 'PDS';
$db_port = 8889;

// $link = mysqli_connect($db_host,$db_user,$db_pass,$db_name,);
$link = new mysqli($db_host, $db_user, $db_password, $db_db, $db_port);
if (mysqli_connect_error()){
    echo mysqli_connect_error();
    exit;
}
?>