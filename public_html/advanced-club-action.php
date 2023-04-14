<?php
require_once ('connection.php');

global $conn;

function listClubs()
{
    global $conn;
    
    $sqlQuery = "SELECT Club_id as 'ID',
                        Club_name as `Club Name`,
                        Games_played as 'Games Played',
                        Goals_Scored as 'Goals Scored',
                        Goals_Conceded as 'Goals Conceded',
                        Points as 'Points',
                        Division_name as 'Division Name'
                    FROM Club";
    /*
    if (! empty($_POST["search"]["value"])) {
        $sqlQuery .= 'WHERE Club_name LIKE "%' . $_POST["search"]["value"] . '%" ';
    }
    */
    /*
    if (! empty($_POST["order"])) {
        $sqlQuery .= 'ORDER BY ' . ($_POST['order']['0']['column'] + 1) . ' ' . $_POST['order']['0']['dir'] . ' ';
    } else {
        $sqlQuery .= 'ORDER BY Club_name DESC ';
    }
    */
    $stmt = $conn->prepare($sqlQuery);
    $stmt->execute();
    
    $numberRows = $stmt->rowCount();
    /*
    if ($_POST["length"] != - 1) {
        $sqlQuery .= 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }
    */
    $stmt = $conn->prepare($sqlQuery);
    $stmt->execute();
    
    $dataTable = array();
    
    while ($sqlRow = $stmt->fetch()) {
        $dataRow = array();
        
        $dataRow[] = $sqlRow['ID'];
        $dataRow[] = $sqlRow['Club Name'];
        $dataRow[] = $sqlRow['Games Played'];
        $dataRow[] = $sqlRow['Goals Scored'];
        $dataRow[] = $sqlRow['Goals Conceded'];
        $dataRow[] = $sqlRow['Points'];
        $dataRow[] = $sqlRow['Division Name'];        
        $dataRow[] = '<button type="button" name="update" clu_id="' . $sqlRow["ID"] . '" class="btn btn-warning btn-sm update">Update</button>
                      <button type="button" name="delete" clu_id="' . $sqlRow["ID"] . '" class="btn btn-danger btn-sm delete" >Delete</button>';
        
        $dataTable[] = $dataRow;
    }
    
    $output = array(
        "recordsTotal" => $numberRows,
        "recordsFiltered" => $numberRows,
        "data" => $dataTable
    );
    
    echo json_encode($output);
}
    
function getClub()
{
    global $conn;
    
    if ($_POST["ID"]) {
        
        $sqlQuery = "SELECT 
                            Club_id as 'ID',
                            Club_name,
                            Games_played,
                            Goals_Scored,
                            Goals_Conceded,
                            Points,
                            Division_name
                            FROM Club
                            WHERE Club_id = :Club_id";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':Club_id', $_POST["ID"]);
        $stmt->execute();
        
        echo json_encode($stmt->fetch());
    }
}

function updateClub()
{
    global $conn;
    
    if ($_POST['ID']) {
        
        $sqlQuery = "UPDATE Club
                            SET
                            Club_name = :Club_name,
                            Games_played= :Games_played,
                            Goals_Scored = :Goals_Scored,
                            Goals_Conceded = :Goals_Conceded,
                            Points = :Points,
                            Division_name = :Division_name
                        WHERE Club_iD = :Club_iD";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':Games_played', $_POST["gamesplayed"]);
        $stmt->bindValue(':Goals_Scored', $_POST["goalsscored"]);
        $stmt->bindValue(':Goals_Conceded', $_POST["goalsconceded"]);
        $stmt->bindValue(':Points', $_POST["points"]);
        $stmt->bindValue(':Division_name', $_POST["division"]);
        $stmt->bindValue(':Club_name', $_POST["clubname"]);
        $stmt->bindValue(':Club_iD', $_POST["ID"]);
        $stmt->execute();
    }
}

function addClub()
{
    global $conn;
    
    $sqlQuery = "INSERT INTO Club
                    (Club_name, Games_played, Goals_Scored, Goals_conceded, Points,Division_name)
                    VALUES
                    (:Club_name, :Games_played, :Goals_Scored, :Goals_Conceded, :Points, :Division_name);";
    
    $stmt = $conn->prepare($sqlQuery);
    $stmt->bindValue(':Games_played', $_POST["gamesplayed"]);
    $stmt->bindValue(':Goals_Scored', $_POST["goalsscored"]);
    $stmt->bindValue(':Goals_Conceded', $_POST["goalsconceded"]);
    $stmt->bindValue(':Points', $_POST["points"]);
    $stmt->bindValue(':Division_name', $_POST["division"]);
    $stmt->bindValue(':Club_name', $_POST["clubname"]);
    //$stmt->bindValue(':Person_ID', $_POST["ID"]);
    $stmt->execute();
}

function deleteClub()
{
    global $conn;
    
    if ($_POST["ID"]) {
        
        $sqlQuery = "DELETE FROM Club WHERE Club_id = :Club_id";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':Club_iD', $_POST["ID"]);
        $stmt->execute();
        
    }
}

if(!empty($_POST['action']) && $_POST['action'] == 'listClubs') {
    listClubs();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addClub') {
    addClub();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getClub') {
    getClub();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateClub') {
    updateClub();
}
if(!empty($_POST['action']) && $_POST['action'] == 'deleteClub') {
    deleteClub();
}

?>