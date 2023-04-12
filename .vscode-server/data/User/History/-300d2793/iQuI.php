<?php 

// Show all employees on the employees table

require_once('connection.php');

global $conn;

$stmt = $conn->prepare("SELECT Person_id, First_Name,Last_name
                        FROM Person
                        ORDER BY Name");
$stmt->execute();

?>

<table style='border: solid 1px black;'>
<thead>
	<tr>
    	<th>ID</th>
    	<th>First name</th>
    	<th>Last name</th>
	</tr>
</thead>
<tbody>

<?php 
while ($row = $stmt->fetch()) {
    echo "<tr>
             <td>$row[Person_id]</td>
             <td>$row[first_name]</td>
             <td>$row[last_name]</td>
          </tr>";
}
?>

</tbody>
</table>

