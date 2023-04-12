<?php 

require_once('connection.php');

global $conn;

session_start();

if (!isset($_GET['Person_id']) && $_SERVER['REQUEST_METHOD'] != 'POST') {
    
    // Retrieve list of employees
    $stmt = $conn->prepare("SELECT Person_id, first_name, last_name FROM Person ORDER BY first_name, last_name");
    $stmt->execute();
    
    echo "<form method='get'>";
    echo "<select name='Person_id' onchange='this.form.submit();'>";
    echo "<option value='0' selected disabled>Select a person/option>";
    
    while ($row = $stmt->fetch()) {
        echo "<option value='$row[Person_id]'>$row[first_name] $row[last_name]</option>";
    }
    
    echo "</select>";
    echo "</form>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    
    $Person_id = $_GET["Person_id"];
    
    $stmt = $conn->prepare("SELECT First_name, Last_name,Date_of_birth,Nationality,Contract_end_date,club,salary FROM Person WHERE Person_id=:Person_id");
    $stmt->bindValue(':Person_id', $Person_id);
    
    $stmt->execute();
    
    $row = $stmt->fetch();

    echo "<form method='post' action='editPerson.php'>";
    echo "<table style='border: solid 1px black;'>";
    echo "<tbody>";
    echo "<tr><td>First name</td><td><input name='First_name' type='text' size='25' value='$row[first_name]'></td></tr>";
    echo "<tr><td>Last name</td><td><input name='Last_name' type='text' size='25' value='$row[last_name]'></td></tr>";
    echo "<tr><td>Date of birth</td><td><input name='Date_of_birth' type='date' size='10' value='$row[Date_of_birth]'></td></tr>";
    echo "<tr><td>Nationality</td><td><input name='Nationality' type='text' size='25' value='$row[Nationality]'></td></tr>";
    echo "<tr><td>Contract end date</td><td><input name='Contract_end_date' type='date' size='10' value='$row[Contract_end_date]'></td></tr>";
    echo "<tr><td>Salary</td><td><input name='Salary' type='number' min='0.01' step='0.01' size='8' value='$row[salary]'></td></tr>";
    echo "<tr><td>Club</td><td>";
    
    // Retrieve list of employees as potential manager of the new employee
    $stmt = $conn->prepare("SELECT Club_name FROM Club");
    $stmt->execute();
    
    echo "<select name='Club'>";
    
    echo "<option value='-1'>No Club</option>";
    
    while ($row = $stmt->fetch()) {
        echo "<option value='$row[Club_name]'>$row[Club_name]</option>";
    }
    
    echo "</select>";
    echo "</td></tr>";
    echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
    echo "</tbody>";
    echo "</table>";
    echo "</form>";
    
    $_SESSION["editPerson_id"] = $Person_id;    
    
} else {
    
    try {
        $stmt = $conn->prepare("UPDATE Person SET First_name=:First_name, Last_name=:Last_name, Nationality=:Nationality, Salary=:Salary Date_of_birth = :Date_of_birth, Contract_end_date = :Contract_end_date, Club = :Club WHERE Person_id=:Person_id");

        $stmt->bindValue(':First_name', $_POST['First_name']);
        $stmt->bindValue(':Last_name', $_POST['Last_name']);
        $stmt->bindValue(':Nationality', $_POST['Nationality']);
        $stmt->bindValue(':Salary', $_POST['Salary']);
        $stmt->bindValue(':Club', $_POST['Club']);
        $stmt->bindValue(':Date_of_birth', $_POST['Date_of_birth']);
        $stmt->bindValue(':Contract_end_date', $_POST['Contract_end_date']);
        $stmt->bindValue(':Person_id', $_SESSION["editPerson_id"]);
        
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    
    unset ($_SESSION["editPerson_id"]);

    echo "Success";    
}

?>