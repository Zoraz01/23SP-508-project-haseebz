<!DOCTYPE html>
<html>
<head>
<title>Premiere League database</title>
<link rel="icon" type="image/x-icon" href="images/ball.png">
<?php require_once('header.php'); ?>
<style>
    .login-card {
        min-height: 300px;
    }
    .full-height {
        height: 100vh;
    }
    .center-contents {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
</style>
</head>
<body style="background-color: #04f5ff;">
    <div class="container full-height center-contents">
        <img src="images/Premier_League-Logo.wine.png" alt="Premier League" style="width: 300px; height: auto; margin-bottom: 20px;">
        <div class="row justify-content-center w-100">
            <div class="col-4">
                <div class="card login-card">
                    <div class="card-header">
                        <h3 class="text-center">Login</h3>
                    </div>
                    <div class="card-body">
                        <?php if (isset($errorMessage)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo $errorMessage; ?>
                            </div>
                        <?php endif; ?>
                        <form method="post" action="login_process.php">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" placeholder="name@example.com" name="email" required>
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
                                <label for="floatingPassword">Password</label>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary" style="margin-top: 10px;">Log in</button>
                                <a type="submit" class="btn btn-primary" style="margin-top: 10px;" href="sign-up.php">Sign up</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
