<?php 

// Show all employees on the employees table

require_once('connection.php');

global $conn;

$stmt = $conn->prepare("SELECT l.Person_id,Last_name,First_name
                        FROM Person p,Player l
                        Where p.Person_id = l.Person_id
                        ORDER BY First_name,Last_name;");
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
             <td>$row[First_name]</td>
             <td>$row[Last_name]</td>
          </tr>";
}
?>

</tbody>
</table>