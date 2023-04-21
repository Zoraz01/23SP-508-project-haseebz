<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Premier League Table </title>
    <link href = https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css rel= "stylesheet">
    <link rel="icon" type="image/x-icon" href="images/ball.png">
    <?php require_once('header.php'); ?>
    <style>
       
    </style>
    <script src="js/league-Table.js"></script>
  </head>

    <?php require_once('connection.php'); global $conn; ?>
  <body style = "background-color: #04f5ff;">
    <?php require_once('navBar.php'); ?>
    <div style = "display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 3rem;">
        <div class="card text-bg-dark text-center" style = "width: 40rem;" >
            <div class="card-body">
                <h5 class="card-title">2-2</h5>
                <p class="card-text">Manchester United vs Newcastle United</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
            <div class="card-footer text-body-secondary">
                2 days ago
            </div>
        </div>
        </div>
    </div>
  </body>
</html>