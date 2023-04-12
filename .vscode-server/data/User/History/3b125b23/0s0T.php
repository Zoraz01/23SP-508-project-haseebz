<?php
require_once ('connection.php');

global $conn;

function listPlayers()
{
    global $conn;
    
    $sqlQuery = "SELECT p.Person_ID as `ID`,
                        concat(p.First_name, ' ', p.Last_name) as `name`,
                        p.Salary as `salary`,
                        p.Nationality as 'nationality',
                        p.Club as 'club',
                        p.Contract_end_date as 'contractenddate',
                        m.Goals as 'goals',
                        m.Assists as 'assists',
                        m.Appearances as 'appearances',
                        m.Position as 'position',
                        m.Value as 'value'
                 FROM Person p
                 INNER JOIN  Player m ON (p.Person_id = m.Person_iD)";
    
    if (! empty($_POST["search"]["value"])) {
        $sqlQuery .= 'WHERE (p.first_name LIKE "%' . $_POST["search"]["value"] . '%" OR p.last_name LIKE "%' . $_POST["search"]["value"] . '%"';
    }
    
    if (! empty($_POST["order"])) {
        $sqlQuery .= 'ORDER BY ' . ($_POST['order']['0']['column'] + 1) . ' ' . $_POST['order']['0']['dir'] . ' ';
    } else {
        $sqlQuery .= 'ORDER BY p.Person_id DESC ';
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
        $dataRow[] = $sqlRow['name'];
        $dataRow[] = $sqlRow['salary'];
        $dataRow[] = $sqlRow['nationality'];
        $dataRow[] = $sqlRow['club'];
        $dataRow[] = $sqlRow['contractenddate'];
        $dataRow[] = $sqlRow['goals'];
        $dataRow[] = $sqlRow['assists'];
        $dataRow[] = $sqlRow['appearances'];
        $dataRow[] = $sqlRow['position'];
        $dataRow[] = $sqlRow['value'];
        
        $dataRow[] = '<button type="button" name="update" pla_id="' . $sqlRow["ID"] . '" class="btn btn-warning btn-sm update">Update</button>
                      <button type="button" name="delete" pla_id="' . $sqlRow["ID"] . '" class="btn btn-danger btn-sm delete" >Delete</button>';
        
        $dataTable[] = $dataRow;
    }
    
    $output = array(
        "recordsTotal" => $numberRows,
        "recordsFiltered" => $numberRows,
        "data" => $dataTable
    );
    
    echo json_encode($output);
}
    
function getPlayer()
{
    global $conn;
    
    if ($_POST["ID"]) {
        
        $sqlQuery = "SELECT p.Person_ID as `ID`,
                        First_name,
                        Last_name,
                        Salary,
                        Nationality,
                        Club,
                        Contract_end_date,
                        Goals,
                        Assists,
                        Appearances,
                        Position,
                        Value
                     FROM Person p INNER JOIN Player m ON (p.Person_id = m.Person_iD)
                     WHERE p.Person_ID = :Person_ID";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':Person_ID', $_POST["ID"]);
        $stmt->execute();
        
        echo json_encode($stmt->fetch());
    }
}

function updatePlayer()
{
    global $conn;
    
    if ($_POST['ID']) {
        
        $sqlQuery = "UPDATE Players, Person
                        SET
                        First_name = :First_name,
                        Last_name = :Last_name,
                        Nationality = :Nationality,
                        Club = :Club,
                        Contract_end_date = :Contract_end_date,
                        Goals = :Goals,
                        salary = :salary,
                        Assists = :Assists,
                        Appearances = :Appearances,
                        Position = :Position,
                        Value = :Value
                    WHERE Person_ID = :Person_ID AND Players.Person_id = Person.Person_ID";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':first_name', $_POST["firstname"]);
        $stmt->bindValue(':last_name', $_POST["lastname"]);
        $stmt->bindValue(':manager_ID', $_POST["manager"]);
        $stmt->bindValue(':department_ID', $_POST["department"]);
        $stmt->bindValue(':email', $_POST["email"]);
        $stmt->bindValue(':job_ID', $_POST["job"]);
        $stmt->bindValue(':salary', $_POST["salary"]);
        $stmt->bindValue(':employee_ID', $_POST["ID"]);
        $stmt->execute();
    }
}

function addPlayer()
{
    global $conn;
    
    $sqlQuery = "INSERT INTO employees
                 (first_name, last_name, manager_ID, department_ID, email, job_ID, salary, hire_date)
                 VALUES
                 (:first_name, :last_name, :manager_ID, :department_ID, :email, :job_ID, :salary, CURDATE())";
    
    $stmt = $conn->prepare($sqlQuery);
    $stmt->bindValue(':first_name', $_POST["firstname"]);
    $stmt->bindValue(':last_name', $_POST["lastname"]);
    $stmt->bindValue(':manager_ID', $_POST["manager"]);
    $stmt->bindValue(':department_ID', $_POST["department"]);
    $stmt->bindValue(':email', $_POST["email"]);
    $stmt->bindValue(':job_ID', $_POST["job"]);
    $stmt->bindValue(':salary', $_POST["salary"]);
    $stmt->execute();
}

function deletePlayer()
{
    global $conn;
    
    if ($_POST["ID"]) {
        
        $sqlQuery = "DELETE FROM job_history WHERE employee_ID = :employee_ID";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':employee_ID', $_POST["ID"]);
        $stmt->execute();
        
        $sqlQuery = "DELETE FROM employees WHERE employee_ID = :employee_ID";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':employee_ID', $_POST["ID"]);
        $stmt->execute();
    }
}

if(!empty($_POST['action']) && $_POST['action'] == 'listPlayers') {
    listPlayers();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addPlayer') {
    addPlayer();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getPlayer') {
    getPlayer();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updatePlayer') {
    updatePlayer();
}
if(!empty($_POST['action']) && $_POST['action'] == 'deletePlayer') {
    deletePlayer();
}

?>