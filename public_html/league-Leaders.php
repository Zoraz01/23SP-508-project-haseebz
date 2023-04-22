<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Premier League Leaders </title>
    <link href = https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css rel= "stylesheet">
    <link rel="icon" type="image/x-icon" href="images/ball.png">
    <?php require_once('header.php'); ?>
    <style>
       
    </style>
    <script src="js/league-Leaders.js"></script>
  </head>

  <?php require_once('connection.php'); global $conn; ?>

  <body style = "background-color: #04f5ff;">
    <?php require_once('navBar.php'); ?>
        <div class = "container-sm" style = "margin-top: 50px; display: flex; justify-content: center;">
            <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
                Scoring Leaders
            </a>
        </div>
        <div class = "container-sm" style = "margin-top: 50px;">
            <div class="collapse" id="collapseExample">
                <table id = "scoringTable" class="table table-dark table-secondary table-striped table-hover">
                    <thead>
                        <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Club</th>
                        <th scope="col">Goals</th>
                        <th scope="col">Assists</th>
                        <th scope="col">Appearances</th>
                        </tr>
                    </thead>
                    <tbody class = "table-group-divider">
                    </tbody>
                </table>
        </div>
        <div class = "container-sm" style = "margin-top: 50px; display: flex; justify-content: center;">
            <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseAssists" role="button" aria-expanded="false" aria-controls="collapseExample">
                Assist Leaders
            </a>
        </div>
        <div class = "container-sm" style = "margin-top: 50px;">
            <div class="collapse" id="collapseAssists">
                <table id = "assistsTable" class="table table-dark table-secondary table-striped table-hover">
                    <thead>
                        <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Club</th>
                        <th scope="col">Assists</th>
                        <th scope="col">Goals</th>
                        <th scope="col">Appearances</th>
                        </tr>
                    </thead>
                    <tbody class = "table-group-divider">
                    </tbody>
                </table>
        </div>
        <div class = "container-sm" style = "margin-top: 50px; display: flex; justify-content: center;">
            <a class="btn btn-primary" data-bs-toggle="collapse" href="#collapseAppearance" role="button" aria-expanded="false" aria-controls="collapseExample">
                Appearance Leaders
            </a>
        </div>
        <div class = "container-sm" style = "margin-top: 50px;">
            <div class="collapse" id="collapseAppearance">
                <table id = "appearancesTable" class="table table-dark table-secondary table-striped table-hover">
                    <thead>
                        <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Club</th>
                        <th scope="col">Appearances</th>
                        <th scope="col">Goals</th>
                        <th scope="col">Assists</th>
                        </tr>
                    </thead>
                    <tbody class = "table-group-divider">
                    </tbody>
                </table>
        </div>
    </div>
  </body>
</html>
