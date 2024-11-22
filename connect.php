<?php 
// $host = "localhost";
// $username = "trcelioe_realvisinewebsite";
// $password = "Realvisine";
// $database = "trcelioe_user_data";

$host = "localhost";
$username = "root";
$password = "";
$database = "user_data";

$con = new mysqli($host, $username, $password, $database);


if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}




?>