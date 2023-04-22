<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Premier League Fixtures</title>
    <link href = https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css rel= "stylesheet">
    <link rel="icon" type="image/x-icon" href="images/ball.png">
    <?php require_once('header.php'); ?>
    <style>
      .heading-container {
        display: flex;
        justify-content: space-between;
      }
      .paragraph-container {
        white-space: nowrap;
      }

      .paragraph-container .card-text {
        display: inline;
        margin: 0;
      }
      h5 {
        margin: 10;
        padding: 10px;
        font-size: 50px;
       }
    </style>
    <script src="js/fixtures.js"></script>
  </head>

    <?php require_once('connection.php'); global $conn; ?>
  <body style = "background-color: #04f5ff;">
    <?php require_once('navBar.php'); ?>
    
        <div class="container mt-5" id="game_cards_container">
        </div>
        </div>
        </div>
    </div>
  </body>
</html>