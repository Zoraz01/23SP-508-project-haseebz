<?php
require_once ('connection.php');

global $conn;

function listGoalkeepers()
{
    global $conn;
    
    $sqlQuery = "SELECT p.Person_id as 'ID',
                        concat(p.First_name, ' ', p.Last_name) as `Name`,
                        p.Salary as `salary`,
                        p.Nationality as 'nationality',
                        p.Club as 'club',
                        p.Contract_end_date as 'contractenddate',
                        p.Date_of_birth as 'birthdate',
                        m.Goals as 'goals',
                        m.Assists as 'assists',
                        m.Appearances as 'appearances',
                        m.Position as 'position',
                        m.Value as 'value',
                        g.Clean_sheets as 'Clean Sheets',
                        g.Goals_conceded as 'Goals Conceded'
                        FROM Person p 
                        INNER JOIN Player m ON (p.Person_id = m.Person_id)
                        INNER JOIN Goalkeeper g ON (p.Person_id = g.Person_id);";
                        
    if (! empty($_POST["search"]["value"])) {
        $sqlQuery .= 'WHERE (p.first_name LIKE "%' . $_POST["search"]["value"] . '%" OR p.last_name LIKE "%' . $_POST["search"]["value"] . '%")';
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
        $dataRow[] = $sqlRow['Name'];
        $dataRow[] = $sqlRow['club'];
        $dataRow[] = $sqlRow['nationality'];
        $dataRow[] = $sqlRow['appearances'];
        $dataRow[] = $sqlRow['goals'];
        $dataRow[] = $sqlRow['assists'];
        $dataRow[] = $sqlRow['birthdate'];
        $dataRow[] = $sqlRow['salary'];
        $dataRow[] = $sqlRow['value'];
        $dataRow[] = $sqlRow['contractenddate'];
        $dataRow[] = $sqlRow['position'];   
        $dataRow[] = $sqlRow['Clean Sheets'];
        $dataRow[] = $sqlRow['Goals Conceded'];      
        $dataRow[] = '<button type="button" name="update" goa_id="' . $sqlRow["ID"] . '" class="btn btn-warning btn-sm update">Update</button>
                      <button type="button" name="delete" goa_id="' . $sqlRow["ID"] . '" class="btn btn-danger btn-sm delete" >Delete</button>';
        
        $dataTable[] = $dataRow;
    }
    
    $output = array(
        "recordsTotal" => $numberRows,
        "recordsFiltered" => $numberRows,
        "data" => $dataTable
    );
    
    echo json_encode($output);
}
    
function getGoalkeeper()
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
                        Date_of_birth,
                        Goals,
                        Assists,
                        Appearances,
                        Position,
                        Value
                        Clean_sheets,
                        Goals_conceded
                     FROM Person p INNER JOIN Player m ON (p.Person_id = m.Person_iD)
                     INNER JOIN Goalkeeper g ON (p.Person_id = g.Person_id)
                     WHERE p.Person_ID = :Person_ID";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':Person_ID', $_POST["ID"]);
        $stmt->execute();
        
        echo json_encode($stmt->fetch());
    }
}

function updateGoalkeeper()
{
    global $conn;
    
    if ($_POST['ID']) {
        
        $sqlQuery = "UPDATE Player, Person,Goalkeeper
                        SET
                        Person.First_name = :First_name,
                        Person.Last_name = :Last_name,
                        Person.Nationality = :Nationality,
                        Person.Club = :Club,
                        Person.Contract_end_date = :Contract_end_date,
                        Person.Date_of_birth = :Date_of_birth,
                        Player.Goals = :Goals,
                        Person.Salary = :Salary,
                        Player.Assists = :Assists,
                        Player.Appearances = :Appearances,
                        Player.Position = :Position,
                        Player.Value = :Value,
                        Goalkeeper.Clean_sheets = :Clean_sheets,
                        Goalkeeper.Goals_conceded = :Goals_conceded
                    WHERE Player.Person_id = Person.Person_iD AND Player.Person_id = Goalkeeper.Person_id AND Person.Person_iD = :Person_iD";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':First_name', $_POST["firstname"]);
        $stmt->bindValue(':Last_name', $_POST["lastname"]);
        $stmt->bindValue(':Nationality', $_POST["nationality"]);
        $stmt->bindValue(':Club', $_POST["club"]);
        $stmt->bindValue(':Contract_end_date', $_POST["contractenddate"]);
        $stmt->bindValue(':Goals', $_POST["goals"]);
        $stmt->bindValue(':Salary', $_POST["salary"]);
        $stmt->bindValue(':Date_of_birth', $_POST["birthdate"]);
        $stmt->bindValue(':Assists', $_POST["assists"]);
        $stmt->bindValue(':Appearances', $_POST["appearances"]);
        $stmt->bindValue(':Position', $_POST["position"]);
        $stmt->bindValue(':Value', $_POST["value"]);
        $stmt->bindValue(':Clean_sheets', $_POST["cleansheets"]);
        $stmt->bindValue(':Goals_conceded', $_POST["goalsconceded"]);
        $stmt->bindValue(':Person_iD', $_POST["ID"]);
        $stmt->execute();
    }
}

function addGoalkeeper()
{
    global $conn;
    
    $sqlQuery = "INSERT INTO Person
                (First_name, Last_name, Nationality, Salary, Contract_end_date,Club,Date_of_birth)
                VALUES
                (:First_name, :Last_name, :Nationality, :Salary, :Contract_end_date, :Club,:Date_of_birth);

                INSERT INTO Player 
                (Person_id,Goals,Assists,Appearances,Position,Value)
                VALUES 
                (LAST_INSERT_ID(),:Goals,:Assists,:Appearances,:Position,:Value);

                INSERT INTO Goalkeeper
                 (Person_id, Clean_sheets, Goals_conceded)
                 VALUES
                 (LAST_INSERT_ID(),:Clean_sheets,:Goals_conceded);";
    
    $stmt = $conn->prepare($sqlQuery);
    $stmt->bindValue(':Person_id', $_POST["ID"]);
    $stmt->bindValue(':Clean_sheets', $_POST["cleansheets"]);
    $stmt->bindValue(':Goals_conceded', $_POST["goalsconceded"]);
    $stmt->bindValue(':Salary', $_POST["salary"]);
    $stmt->bindValue(':Contract_end_date', $_POST["contractenddate"]);
    $stmt->bindValue(':Club', $_POST["club"]);
    $stmt->bindValue(':Date_of_birth', $_POST["birthdate"]);
    $stmt->bindValue(':Goals', $_POST["goals"]);
    $stmt->bindValue(':Assists', $_POST["assists"]);
    $stmt->bindValue(':Appearances', $_POST["appearances"]);
    $stmt->bindValue(':Position', $_POST["position"]);
    $stmt->bindValue(':Value', $_POST["value"]);
    $stmt->bindValue(':Clean_sheets', $_POST["cleansheets"]);
    $stmt->bindValue(':Goals_conceded', $_POST["goalsconceded"]);
    //$stmt->bindValue(':Person_ID', $_POST["ID"]);
    $stmt->execute();
}

function deleteGoalkeeper()
{
    global $conn;
    
    if ($_POST["ID"]) {

        $sqlQuery = "DELETE FROM Goalkeeper WHERE Person_ID = :Person_ID";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':Person_ID', $_POST["ID"]);
        $stmt->execute();
        
        $sqlQuery = "DELETE FROM Player WHERE Person_ID = :Person_ID";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':Person_ID', $_POST["ID"]);
        $stmt->execute();
        
        $sqlQuery = "DELETE FROM Person WHERE Person_ID = :Person_ID";
        
        $stmt = $conn->prepare($sqlQuery);
        $stmt->bindValue(':Person_ID', $_POST["ID"]);
        $stmt->execute();
    }
}

if(!empty($_POST['action']) && $_POST['action'] == 'listGoalkeepers') {
    listGoalkeepers();
}
if(!empty($_POST['action']) && $_POST['action'] == 'addGoalkeeper') {
    addGoalkeeper();
}
if(!empty($_POST['action']) && $_POST['action'] == 'getGoalkeeper') {
    getGoalkeeper();
}
if(!empty($_POST['action']) && $_POST['action'] == 'updateGoalkeeper') {
    updateGoalkeeper();
}
if(!empty($_POST['action']) && $_POST['action'] == 'deleteGoalkeeper') {
    deleteGoalkeeper();
}

?>