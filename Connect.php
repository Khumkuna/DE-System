<?php
date_default_timezone_set("Asia/Bangkok");
$servername = "localhost";
$username = "root";
$password = "Root123;";
$database = "de_system_db";


// Create connection
$conn = new mysqli($servername, $username, $password,$database);
mysqli_set_charset($conn, "utf8mb4");

$conn->query("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

include 'Disabled_Warning.php';


session_start();
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire'); // works
//session_cache_limiter('public'); // works too




?>




