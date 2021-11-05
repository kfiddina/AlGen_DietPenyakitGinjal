<?php 

$host = "localhost";
$username = "root";
$password = "";
$database = "algen4";
$port = "";

$connection = mysqli_connect($host, $username, $password, $database);
if(!$connection){
	die("Error connecting to MySQL: ".mysqli_connect_error());
}

?>