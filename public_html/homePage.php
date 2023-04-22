<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Premier League Home Page</title>
    <link rel="stylesheet" href="homePage.css">
    <link href = https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css rel= "stylesheet">
    <link rel="icon" type="image/x-icon" href="images/ball.png">
    <style>
      .center-image {
        display: flex;
        justify-content: center;
        align-items: center; 
      }
      .h1-welcome {
        display: flex;
        justify-content: center;
        align-items: center; 
        color: #38003c;
      }
      .button-container {
        display: flex;
        justify-content: center;
        align-items: center; 
        margin-top: 20px;
      }
      
    </style>

    <?php require_once('header.php'); ?>
    
  </head>

  <?php require_once('connection.php'); ?>
  
  <body style = "background-color: #04f5ff;">
    <?php require_once('navBar.php'); ?>
    
    <div class = "center-image">
      <img src="images/Premier_League-Logo.wine.png" height = "400" width = "600">
    </div>
    
    <h1 class = "h1-welcome">The Home of Premier League Statistics</h1>
    <div class="button-container">
    <a class="btn btn-light btn-lg" href = "league-Table.php" role = "button">Premier League Table</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>
