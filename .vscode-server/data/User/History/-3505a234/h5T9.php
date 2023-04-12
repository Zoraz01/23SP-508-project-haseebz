<?php

require_once('connection.php');

global $conn;

setlocale(LC_MONETARY, 'en_US');

if (!isset($_POST['Person_id'])) {
    
    // Retrieve list of employees
    $stmt = $conn->prepare("SELECT Person_id, first_name, last_name FROM Person ORDER BY first_name, last_name");
    $stmt->execute();
    
    echo "<form method='post'>";
    echo "<select name='employee_id' onchange='this.form.submit();'>";
    echo "<option value='0' selected disabled>Select a person</option>";
    
    while ($row = $stmt->fetch()) {
        echo "<option value='$row[Person_id]'>$row[first_name] $row[last_name]</option>";
    }
    
    echo "</select>";
    echo "</form>";
} else {
    
    try{
    $Person_id = $_POST["Person_id"];
    
    //$stmt = $conn->prepare("SELECT employee_id, first_name, last_name, salary FROM employees WHERE employee_id=$employee_id"); // NOT SAFE FOR SQL INJECTION
    
    $stmt = $conn->prepare("DELETE FROM Person WHERE Person_id=:Person_id"); // PREPARED STATEMENT SAFE FOR SQL INJECTION
    $stmt->bindValue(':Person_id', $Person_id);
    
    $stmt->execute();
    
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        die();
    }
    
    echo "Success";
}

?>