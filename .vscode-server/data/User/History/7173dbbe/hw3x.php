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
    
    echo "<select name='Club_name'>";
    
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
} else {
    
    try {
        $stmt = $conn->prepare("INSERT INTO Person (First_name, Last_name, Nationality, hire_date, job_id, salary, manager_id, department_id)
                                VALUES (:first_name, :last_name, :email, CURDATE(), :job_id, :salary, :manager_id, :department_id)");

        $stmt->bindValue(':first_name', $_POST['first_name']);
        $stmt->bindValue(':last_name', $_POST['last_name']);
        $stmt->bindValue(':email', $_POST['email']);
        $stmt->bindValue(':job_id', $_POST['job_id']);
        $stmt->bindValue(':salary', $_POST['salary']);
        
        if($_POST['manager_id'] != -1) {
            $stmt->bindValue(':manager_id', $_POST['manager_id']);
        } else {
            $stmt->bindValue(':manager_id', null, PDO::PARAM_INT);
        }
        
        if($_POST['department_id'] != -1) {
            $stmt->bindValue(':department_id', $_POST['department_id']);
        } else {
            $stmt->bindValue(':department_id', null, PDO::PARAM_INT);
        }
        
        $stmt->execute();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        die();
    }

    echo "Success";    
}

?>