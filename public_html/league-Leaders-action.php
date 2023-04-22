<?php
require_once ('connection.php');

global $conn;

function listScorers()
{
    global $conn;
    
    $sqlQuery = "SELECT p.Person_ID as `ID`,
                        concat(p.First_name, ' ', p.Last_name) as `name`,
                        p.Salary as `salary`,
                        p.Nationality as 'nationality',
                        p.Club as 'club',
                        p.Contract_end_date as 'contractenddate',
                        p.Date_of_birth as 'birthdate',
                        m.Goals as 'goals',
                        m.Assists as 'assists',
                        m.Appearances as 'appearances',
                        m.Position as 'position',
                        m.Value as 'value'
                 FROM Person p
                 INNER JOIN  Player m ON (p.Person_id = m.Person_iD)
                 ORDER BY goals DESC";
    /*
    if (! empty($_POST["search"]["value"])) {
        $sqlQuery .= 'WHERE (p.first_name LIKE "%' . $_POST["search"]["value"] . '%" OR p.last_name LIKE "%' . $_POST["search"]["value"] . '%")';
    }
    
    if (! empty($_POST["order"])) {
        $sqlQuery .= 'ORDER BY ' . ($_POST['order']['0']['column'] + 1) . ' ' . $_POST['order']['0']['dir'] . ' ';
    } else {
        $sqlQuery .= 'ORDER BY p.Person_id DESC ';
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
        
        $dataRow[] = $sqlRow['name'];
        $dataRow[] = $sqlRow['club'];
        $dataRow[] = $sqlRow['goals'];
        $dataRow[] = $sqlRow['assists'];
        $dataRow[] = $sqlRow['appearances'];
        $dataTable[] = $dataRow;
    }
    
    $output = array(
        "recordsTotal" => $numberRows,
        "recordsFiltered" => $numberRows,
        "data" => $dataTable
    );
    
    echo json_encode($output);
}

function listAssisters()
{
    global $conn;
    
    $sqlQuery = "SELECT p.Person_ID as `ID`,
                        concat(p.First_name, ' ', p.Last_name) as `name`,
                        p.Salary as `salary`,
                        p.Nationality as 'nationality',
                        p.Club as 'club',
                        p.Contract_end_date as 'contractenddate',
                        p.Date_of_birth as 'birthdate',
                        m.Goals as 'goals',
                        m.Assists as 'assists',
                        m.Appearances as 'appearances',
                        m.Position as 'position',
                        m.Value as 'value'
                 FROM Person p
                 INNER JOIN  Player m ON (p.Person_id = m.Person_iD)
                 ORDER BY assists";
    
    /*
    if (! empty($_POST["search"]["value"])) {
        $sqlQuery .= 'WHERE (p.first_name LIKE "%' . $_POST["search"]["value"] . '%" OR p.last_name LIKE "%' . $_POST["search"]["value"] . '%")';
    }
    
    if (! empty($_POST["order"])) {
        $sqlQuery .= 'ORDER BY ' . ($_POST['order']['0']['column'] + 1) . ' ' . $_POST['order']['0']['dir'] . ' ';
    } else {
        $sqlQuery .= 'ORDER BY p.Person_id DESC ';
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
        
        $dataRow[] = $sqlRow['name'];
        $dataRow[] = $sqlRow['club'];
        $dataRow[] = $sqlRow['assists'];
        $dataRow[] = $sqlRow['goals'];
        $dataRow[] = $sqlRow['appearances'];
        $dataTable[] = $dataRow;
    }
    
    $output = array(
        "recordsTotal" => $numberRows,
        "recordsFiltered" => $numberRows,
        "data" => $dataTable
    );
    
    echo json_encode($output);
}
function listAppearances()
{
    global $conn;
    
    $sqlQuery = "SELECT p.Person_ID as `ID`,
                        concat(p.First_name, ' ', p.Last_name) as `name`,
                        p.Salary as `salary`,
                        p.Nationality as 'nationality',
                        p.Club as 'club',
                        p.Contract_end_date as 'contractenddate',
                        p.Date_of_birth as 'birthdate',
                        m.Goals as 'goals',
                        m.Assists as 'assists',
                        m.Appearances as 'appearances',
                        m.Position as 'position',
                        m.Value as 'value'
                 FROM Person p
                 INNER JOIN  Player m ON (p.Person_id = m.Person_iD)
                 ORDER BY appearances DESC";
    
    /*
    if (! empty($_POST["search"]["value"])) {
        $sqlQuery .= 'WHERE (p.first_name LIKE "%' . $_POST["search"]["value"] . '%" OR p.last_name LIKE "%' . $_POST["search"]["value"] . '%")';
    }
    
    if (! empty($_POST["order"])) {
        $sqlQuery .= 'ORDER BY ' . ($_POST['order']['0']['column'] + 1) . ' ' . $_POST['order']['0']['dir'] . ' ';
    } else {
        $sqlQuery .= 'ORDER BY p.Person_id DESC ';
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
        
        $dataRow[] = $sqlRow['name'];
        $dataRow[] = $sqlRow['club'];
        $dataRow[] = $sqlRow['appearances'];
        $dataRow[] = $sqlRow['goals'];
        $dataRow[] = $sqlRow['assists'];
        $dataTable[] = $dataRow;
    }
    
    $output = array(
        "recordsTotal" => $numberRows,
        "recordsFiltered" => $numberRows,
        "data" => $dataTable
    );
    
    echo json_encode($output);
}

if(!empty($_POST['action']) && $_POST['action'] == 'listScorers') {
    listScorers();
}
if(!empty($_POST['action']) && $_POST['action'] == 'listAssisters') {
    listAssisters();
}
if(!empty($_POST['action']) && $_POST['action'] == 'listAppearances') {
    listAppearances();
}

?>