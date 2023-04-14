<?php
require_once ('connection.php');

global $conn;

function listGames()
{
    global $conn;
    
    $sqlQuery = "SELECT g.Game_id as 'ID',
                        g.Date_played as 'Date Played',
                        h.Club_name as 'Home Team',
                        h.Home_score as 'Home Score',
                        a.Club_name as 'Away Team',
                        a.Away_score as 'Away Score'
                        From Game g 
                        INNER JOIN Home_game h on (g.Game_id = h.Game_id)
                        INNER JOIN Away_game a on (g.Game_id = a.Game_id)";
    
    if (! empty($_POST["search"]["value"])) {
        $sqlQuery .= 'WHERE (h.Club_name LIKE "%' . $_POST["search"]["value"] . '%" OR a.Club_name LIKE "%' . $_POST["search"]["value"] . '%")';
    }
    
    if (! empty($_POST["order"])) {
        $sqlQuery .= 'ORDER BY ' . ($_POST['order']['0']['column'] + 1) . ' ' . $_POST['order']['0']['dir'] . ' ';
    } else {
        $sqlQuery .= 'ORDER BY h.Club_name DESC ';
    }
    
    $stmt = $conn->prepare($sqlQuery);
    $stmt->execute();
    
    $numberRows = $stmt->rowCount();
    
    if ($_POST["length"] != - 1) {
        $sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }
    
    $stmt = $conn->prepare($sqlQuery);
    $stmt->execute();
    
    $dataTable = array();
    
    while ($sqlRow = $stmt->fetch()) {
        $dataRow = array();
        
        $dataRow[] = $sqlRow['ID'];
        $dataRow[] = $sqlRow['Home Team'];
        $dataRow[] = $sqlRow['Home Score'];
        $dataRow[] = $sqlRow['Away Team'];
        $dataRow[] = $sqlRow['Away Score'];    
        $dataRow[] = $sqlRow['Date Played'];   
        $dataRow[] = '<button type="button" name="update" gam_id="' . $sqlRow["ID"] . '" class="btn btn-warning btn-sm update">Update</button>
                      <button type="button" name="delete" gam_id="' . $sqlRow["ID"] . '" class="btn btn-danger btn-sm delete" >Delete</button>';
        
        $dataTable[] = $dataRow;
    }
    
    $output = array(
        "recordsTotal" => $numberRows,
        "recordsFiltered" => $numberRows,
        "data" => $dataTable
    );
    
    echo json_encode($output);
}
    
function getGame()
{
    global $conn;
    
    if ($_POST["ID"]) {
        
        $sqlQuery = "SELECT g.Game_id,
                            h.Club_name,
                            h.Home_score,
                            a.Club_name,
                            a.Away_score,
                            g.Date_played
                            From Game g 
                            INNER JOIN Home_game h on (g.Game_id = h.Game_id)
                            INNER JOIN Away_game a on (g.Game_id = a.Game_id)
                            WHERE g.Game_id = :Game_id";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':Game_id', $_POST["ID"]);
        $stmt->execute();
        
        echo json_encode($stmt->fetch());
    }
}

function updateGame()
{
    global $conn;
    
    if ($_POST['ID']) {
        
        $sqlQuery = "UPDATE Game, Home_game,Away_game
                        SET
                        Game.Date_played = :Date_played,
                        Home_game.Home_score = :Home_score,
                        Away_game.Away_score = :Away_score
                        
                    WHERE Game.Game_id = Home_game.Game_id AND Game.Game_id = Away_game.Game_id AND Game.Game_id = :Game_id";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':Home_score', $_POST["homescore"]);
        $stmt->bindValue(':Away_score', $_POST["awayscore"]);
        $stmt->bindValue(':Date_played', $_POST["dateplayed"]);
        $stmt->bindValue(':Game_id', $_POST["ID"]);
        $stmt->execute();
    }
}

function addGame()
{
    global $conn;
    
    $sqlQuery = "INSERT INTO Game
                 (Date_played)
                 VALUES
                 (:Date_played);

                 INSERT INTO Away_game 
                 (Game_id,Club_name,Away_score)
                 VALUES 
                 (LAST_INSERT_ID(),:Away_team,:Away_score);

                 INSERT INTO Home_game 
                 (Game_id,Club_name,Home_score)
                 VALUES 
                 (LAST_INSERT_ID(),:Home_team,:Home_score)";
    
    $stmt = $conn->prepare($sqlQuery);
    $stmt->bindValue(':Date_played', $_POST["dateplayed"]);
    $stmt->bindValue(':Away_team', $_POST["awayteam"]);
    $stmt->bindValue(':Away_score', $_POST["awayscore"]);
    $stmt->bindValue(':Home_team', $_POST["hometeam"]);
    $stmt->bindValue(':Home_score', $_POST["homescore"]);
    $stmt->execute();
}

function deleteGame()
{
    global $conn;
    
    if ($_POST["ID"]) {
        
        $sqlQuery = "DELETE FROM Home_game WHERE Game_id = :Game_id";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':Game_id', $_POST["ID"]);
        $stmt->execute();
        
        $sqlQuery = "DELETE FROM Away_game WHERE Game_id = :Game_id";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':Game_id', $_POST["ID"]);
        $stmt->execute();

        $sqlQuery = "DELETE FROM Game WHERE Game_id = :Game_id";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':Game_id', $_POST["ID"]);
        $stmt->execute();
    }
}

if(!empty($_POST['action']) && $_POST['action'] == 'listGames') {
    listGames();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addGame') {
    addGame();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getGame') {
    getGame();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateGame') {
    updateGame();
}
if(!empty($_POST['action']) && $_POST['action'] == 'deleteGame') {
    deleteGame();
}

?>