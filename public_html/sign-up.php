<?php
require_once('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (!empty($email) && !empty($password)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare SQL statement to insert new user
        $stmt = $conn->prepare("INSERT INTO user (email, password) VALUES (:email, :password)");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);

        // Execute the prepared statement
        if ($stmt->execute()) {
            header("Location: login.php");
            exit;
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    } else {
        echo "Please fill out all fields.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Premiere League database - Sign Up</title>
<link rel="icon" type="image/x-icon" href="images/ball.png">
<?php require_once('header.php'); ?>
</head>
<body style = "background-color: #04f5ff;">
    <div class="container mt-3 mb-3">
        <form method="post">
            <div class="row justify-content-center">
                <div class="col-4">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" placeholder="name@example.com" name="email" required>
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary" style = "margin-top: 10px;">Sign up</button>
                        <a type="submit" class="btn btn-primary" style = "margin-top: 10px;" href = "login.php">Log in</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>