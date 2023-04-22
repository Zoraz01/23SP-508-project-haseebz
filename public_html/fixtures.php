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
        <!--
        <div class="card text-bg-dark text-center" style = "width: 40rem;" >
            <div class="card-body">
                
                <div class = "heading-container">
                <img src = "images/club-images/manchester_united_17973.png" style = "width: 100px; height: 100px;" id = "home_image">
                <h5 class="card-title" id = "home_score">2</h5>
                <h5 class="card-title">-</h5>
                <h5 class="card-title" id = "away_score">2</h5>
                <img src = "images/club-images/newcastle_united_17970.png" style = "width: 100px; height: 100px;" id = "away_image">
                </div>
                <div class = "paragraph-container">
                <p class="card-text" id = "home_team">Manchester United</p>
                <p class="card-text">vs</p>
                <p class="card-text" id = "away_team">Newcastle United</p>
                </div>
            </div>
            <div class="card-footer" id = "date">
                2 days ago
            </div> -->
        </div>
        </div>
    </div>
  </body>
</html>