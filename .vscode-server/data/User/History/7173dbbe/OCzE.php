<?php 

require_once('connection.php');

global $conn;

if ($_SERVER['REQUEST_METHOD'] != 'POST') {

    echo "<form method='post' action='addPerson.php'>";
    echo "<table style='border: solid 1px black;'>";
    echo "<tbody>";
    echo "<tr><td>First name</td><td><input name='First_name' type='text' size='25'></td></tr>";
    echo "<tr><td>Last name</td><td><input name='Last_name' type='text' size='25'></td></tr>";
    echo "<tr><td>Nationality</td><td><input name='Nationality' type='text' size='25'></td></tr>";
    echo "<tr><td>Salary</td><td><input name='salary' type='number' min='0.01' step='0.01' size='8'></td></tr>";
    echo "<tr><td>Contract End Date</td><td><input name='Contract_end_date' type='date' size='10'></td></tr>";
    echo "<tr><td>Club</td><td>";
    
    // Retrieve list of employees as potential manager of the new employee
    $stmt = $conn->prepare("SELECT Club_name FROM Club");
    $stmt->execute();
    
    echo "<select name='Club'>";
    
    echo "<option value='-1'>No Club</option>";
    
    while ($row = $stmt->fetch()) {
        echo "<option value='$row[Club_name]'>$row[Club]</option>";
    }
    
    echo "</select>";
    echo "</td></tr>";
    
    echo "<tr><td></td><td><input type='submit' value='Submit'></td></tr>";
    
    echo "</tbody>";
    echo "</table>";
    echo "</form>";
} else {
    
    try {
        $stmt = $conn->prepare("INSERT INTO Person (First_name, Last_name, Nationality, Salary, Club)
                                VALUES (:First_name, :Last_name, :Nationality, :Salary, :Club)");

        $stmt->bindValue(':First_name', $_POST['First_name']);
        $stmt->bindValue(':Last_name', $_POST['Last_name']);
        $stmt->bindValue(':Nationality', $_POST['Nationality']);
        $stmt->bindValue(':salary', $_POST['salary']);
        $stmt->bindValue(':Club', $_POST['Club']);

        
        
        
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        die();
    }

    echo "Success";    
}

?>