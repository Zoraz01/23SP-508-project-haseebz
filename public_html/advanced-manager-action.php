<?php
require_once ('connection.php');

global $conn;

function listManagers()
{
    global $conn;
    
    $sqlQuery = "SELECT p.Person_ID as `ID`,
                        concat(p.First_name, ' ', p.Last_name) as `name`,
                        p.Salary as `salary`,
                        p.Nationality as 'nationality',
                        p.Club as 'club',
                        p.Contract_end_date as 'contractenddate',
                        p.Date_of_birth as 'birthdate'
                 FROM Person p
                 INNER JOIN  Manager m ON (p.Person_id = m.Person_iD)";
    
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
        $dataRow[] = $sqlRow['club'];
        $dataRow[] = $sqlRow['nationality'];
        $dataRow[] = $sqlRow['birthdate'];
        $dataRow[] = $sqlRow['salary'];
        $dataRow[] = $sqlRow['contractenddate'];        
        $dataRow[] = '<button type="button" name="update" man_id="' . $sqlRow["ID"] . '" class="btn btn-warning btn-sm update">Update</button>
                      <button type="button" name="delete" man_id="' . $sqlRow["ID"] . '" class="btn btn-danger btn-sm delete" >Delete</button>';
        
        $dataTable[] = $dataRow;
    }
    
    $output = array(
        "recordsTotal" => $numberRows,
        "recordsFiltered" => $numberRows,
        "data" => $dataTable
    );
    
    echo json_encode($output);
}
    
function getManager()
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
                        Date_of_birth
                     FROM Person p INNER JOIN Manager m ON (p.Person_id = m.Person_iD)
                     WHERE p.Person_ID = :Person_ID";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':Person_ID', $_POST["ID"]);
        $stmt->execute();
        
        echo json_encode($stmt->fetch());
    }
}

function updateManager()
{
    global $conn;
    
    if ($_POST['ID']) {
        
        $sqlQuery = "UPDATE Manager, Person
                        SET
                        Person.First_name = :First_name,
                        Person.Last_name = :Last_name,
                        Person.Nationality = :Nationality,
                        Person.Club = :Club,
                        Person.Contract_end_date = :Contract_end_date,
                        Person.Date_of_birth = :Date_of_birth,
                        Person.Salary = :Salary
                    WHERE Manager.Person_id = Person.Person_ID AND Person.Person_ID = :Person_ID";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':First_name', $_POST["firstname"]);
        $stmt->bindValue(':Last_name', $_POST["lastname"]);
        $stmt->bindValue(':Nationality', $_POST["nationality"]);
        $stmt->bindValue(':Club', $_POST["club"]);
        $stmt->bindValue(':Contract_end_date', $_POST["contractenddate"]);
        $stmt->bindValue(':Salary', $_POST["salary"]);
        $stmt->bindValue(':Date_of_birth', $_POST["birthdate"]);
        $stmt->bindValue(':Person_ID', $_POST["ID"]);
        $stmt->execute();
    }
}

function addManager()
{
    global $conn;
    
    $sqlQuery = "INSERT INTO Person
                 (First_name, Last_name, Nationality, Salary, Contract_end_date,Club,Date_of_birth)
                 VALUES
                 (:First_name, :Last_name, :Nationality, :Salary, :Contract_end_date, :Club,:Date_of_birth);

                 INSERT INTO Manager 
                 (Person_id)
                 VALUES 
                 (LAST_INSERT_ID())";
    
    $stmt = $conn->prepare($sqlQuery);
    $stmt->bindValue(':First_name', $_POST["firstname"]);
    $stmt->bindValue(':Last_name', $_POST["lastname"]);
    $stmt->bindValue(':Nationality', $_POST["nationality"]);
    $stmt->bindValue(':Salary', $_POST["salary"]);
    $stmt->bindValue(':Contract_end_date', $_POST["contractenddate"]);
    $stmt->bindValue(':Club', $_POST["club"]);
    $stmt->bindValue(':Date_of_birth', $_POST["birthdate"]);
    //$stmt->bindValue(':Person_ID', $_POST["ID"]);
    $stmt->execute();
}

function deleteManager()
{
    global $conn;
    
    if ($_POST["ID"]) {
        
        $sqlQuery = "DELETE FROM Manager WHERE Person_ID = :Person_ID";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':Person_ID', $_POST["ID"]);
        $stmt->execute();
        
        $sqlQuery = "DELETE FROM Person WHERE Person_ID = :Person_ID";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':Person_ID', $_POST["ID"]);
        $stmt->execute();
    }
}

if(!empty($_POST['action']) && $_POST['action'] == 'listManagers') {
    listManagers();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addManager') {
    addManager();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getManager') {
    getManager();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateManager') {
    updateManager();
}
if(!empty($_POST['action']) && $_POST['action'] == 'deleteManager') {
    deleteManager();
}

?>