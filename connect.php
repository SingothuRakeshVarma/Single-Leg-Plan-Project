<?php 
// $host = "localhost";
// $username = "trcelioe_realvisinewebsite";
// $password = "Realvisine";
// $database = "trcelioe_user_data";

$host = "127.0.0.1";
$username = "root";
$password = "";
$database = "success_slp";

$con = new mysqli($host, $username, $password, $database);

if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
?>