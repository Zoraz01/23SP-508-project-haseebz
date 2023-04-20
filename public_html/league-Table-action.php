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
        
        $dataRow[] = $sqlRow['ID'];
        $dataRow[] = $sqlRow['Club Name'];
        $dataRow[] = $sqlRow['Games Played'];
        $dataRow[] = $sqlRow['Goals Scored'];
        $dataRow[] = $sqlRow['Goals Conceded'];
        $dataRow[] = $sqlRow['Points'];
        
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