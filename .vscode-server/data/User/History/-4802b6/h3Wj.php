<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "cmsc508.com";
$username = "23SP_haseebz";     // Replace yourVCUeid
$password = "23SP_haseebz";     // Replace yourVCUeid
$database = "23SP_haseebz_sp";  // Replace yourVCUeid

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

?>