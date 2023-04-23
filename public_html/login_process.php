<?php
require_once('connection.php');

// If the user_ID session is not set, then the user has not logged in yet
if (!isset($_SESSION['user_ID'])) {
    // If the page is receiving the email and password from the login form then verify the login data
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $stmt = $conn->prepare("SELECT ID, password FROM user WHERE email=:email");
        $stmt->bindValue(':email', $_POST['email']);
        $stmt->execute();

        $queryResult = $stmt->fetch();
        if (!empty($queryResult) && $_POST['email'] == 'admin@vcu.edu' && password_verify($_POST["password"], $queryResult['password'])) {
            $_SESSION['user_ID'] = $queryResult['ID'];

            // Redirect to main page
            header("Location: indexAdmin.php");
            exit;
        }

        // Verify password submitted by the user with the hash stored in the database
        if (!empty($queryResult) && password_verify($_POST["password"], $queryResult['password'])) {
            // Create session variable
            $_SESSION['user_ID'] = $queryResult['ID'];

            // Redirect to main page
            header("Location: homePage.php");
            exit;
        } else {
            // Password mismatch, show login page with an error message
            $errorMessage = "Invalid email or password. Please try again.";
            require('login.php');
            $conn = null;
            exit();
        }
    } else {
        // Show login page
        require('login.php');
        exit();
    }
} else {
    
    // If the user is already logged in, redirect to the main page
    header("Location: homePage.php");
    exit;
}

$conn = null;
