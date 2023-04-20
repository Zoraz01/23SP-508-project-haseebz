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
    <div class = "container-sm" style = "margin-top: 50px;">
        <table id = "leagueTable" class="table table-secondary table-striped table-hover">
            <thead>
                <tr>
                <th scope="col">Position</th>
                <th scope="col">Club</th>
                <th scope="col">Matches Played</th>
                <th scope="col">Goals Scored</th>
                <th scope="col">Goals Conceded</th>
                <th scope="col">Points</th>
                </tr>
            </thead>
            <tbody class = "table-group-divider">
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
  </body>
</html>
