<?php 

require_once('connection.php');

global $conn;

setlocale(LC_MONETARY, 'en_US');

if (!isset($_GET['Person_id'])) {

    // Retrieve list of employees
    $stmt = $conn->prepare("SELECT Person_id, first_name, last_name FROM Person ORDER BY first_name, last_name");
    $stmt->execute();
    
    echo "<form method='get'>";
    echo "<select name='Person_id' onchange='this.form.submit();'>";
    echo "<option value='0' selected disabled>Select a person</option>";
    
    while ($row = $stmt->fetch()) {
        echo "<option value='$row[Person_id]'>$row[first_name] $row[last_name]</option>";
    }
    
    echo "</select>";
    echo "</form>";
} else {
    
    $employee_id = $_GET["Person_id"]; // GET NOT SAFE FOR PRIVACY OF VARIABLES
    
    //$stmt = $conn->prepare("SELECT Person_id, first_name, last_name,  FROM employees WHERE Person_id=$Person_id"); // NOT SAFE FOR SQL INJECTION    
    
    $stmt = $conn->prepare("SELECT Person_id, first_name, last_name, nationality,salary FROM Person WHERE Person_id=:Person_id"); // PREPARED STATEMENT SAFE FOR SQL INJECTION
    $stmt->bindValue(':Person_id', $Person_id);
    
    $stmt->execute();
    
    echo "<table style='border: solid 1px black;'>";
    echo "<thead><tr><th>ID</th><th>First name</th><th>Last name</th><th>Salary</th></tr></thead>";
    echo "<tbody>";
    
    $fmt = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY );
    
    while ($row = $stmt->fetch()) {
        echo "<tr><td>$row[Person_id]</td><td>$row[first_name]</td><td>$row[last_name]</td><td>" . $fmt->formatCurrency($row["salary"], "USD") . "</td></tr>";
    }
        
    echo "</tbody>";
    echo "</table>";    
}

?>