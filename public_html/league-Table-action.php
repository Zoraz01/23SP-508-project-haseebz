<?php
require_once ('connection.php');

global $conn;

function listClubs()
{
    global $conn;
    
    $sqlQuery = "SELECT Club_id as 'ID',
    RANK() OVER (ORDER BY Points DESC) AS rankk,
                    Club_name as `club_name`,
                    Games_played as 'games_played',
                    Goals_Scored as 'goals_scored',
                    Goals_Conceded as 'goals_conceded',
                    Points as 'points',
                    Division_name as 'division_name',
                    image as 'image'
                FROM Club ORDER BY Points DESC" ;
    /*
    if (! empty($_POST["search"]["value"])) {
        $sqlQuery .= 'WHERE (Club_name LIKE "%' . $_POST["search"]["value"] . '%")';
    }
    */
    /*
    if (! empty($_POST["order"])) {
        $sqlQuery .= 'ORDER BY ' . ($_POST['order']['0']['column'] + 1) . ' ' . $_POST['order']['0']['dir'] . ' ';
    } else {
        $sqlQuery .= 'ORDER BY Points DESC ';
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
        $dataRow[] = $sqlRow['rankk'];
        $dataRow[] = $sqlRow['image'];
        $dataRow[] = $sqlRow['club_name'];
        $dataRow[] = $sqlRow['games_played'];
        $dataRow[] = $sqlRow['goals_scored'];
        $dataRow[] = $sqlRow['goals_conceded'];
        $dataRow[] = $sqlRow['points'];
        
        $dataTable[] = $dataRow;
    }
    
    $output = array(
        "recordsTotal" => $numberRows,
        "recordsFiltered" => $numberRows,
        "data" => $dataTable
    );
    
    echo json_encode($output);
}

if(!empty($_POST['action']) && $_POST['action'] == 'listClubs') {
    listClubs();
}
?>