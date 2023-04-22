<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "cmsc508.com";
$username = "23SP_haseebz";     // Replace yourVCUeid
$password = "23SP_haseebz";     // Replace yourVCUeid
$database = "23SP_haseebz_pr";  // Replace yourVCUeid

try {
    // Establish a connection with the MySQL server
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


// Start or resume session variables
session_start();

// If the user_ID session is not set, then the user has not logged in yet
if (!isset($_SESSION['user_ID']))
{
    // If the page is receiving the email and password from the login form then verify the login data

    if (isset($_POST['email']) && isset($_POST['password']))
    {
        
        $stmt = $conn->prepare("SELECT ID, password FROM user WHERE email=:email");
        $stmt->bindValue(':email', $_POST['email']);
        $stmt->execute();
        
        $queryResult = $stmt->fetch();
        if(!empty($queryResult)  && $_POST['email'] == 'admin@vcu.edu' && password_verify($_POST["password"], $queryResult['password'])){
            $_SESSION['user_ID'] = $queryResult['ID'];
            
            // Redirect to main page 
            header("Location: indexAdmin.php");
            return;
        }

        // Verify password submitted by the user with the hash stored in the database
        if(!empty($queryResult) && password_verify($_POST["password"], $queryResult['password']))
        {
            // Create session variable
            $_SESSION['user_ID'] = $queryResult['ID'];
            
            // Redirect to main page 
            header("Location: homePage.php");
        } else {
            // Password mismatch, show login page
            require('login.php');
            $conn = null;
            exit();
        }
    }
    else
    {
        // Show login page
        require('login.php');
        exit();
    }
}

?>