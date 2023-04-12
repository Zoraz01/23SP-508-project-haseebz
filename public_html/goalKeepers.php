<?php 

// Show all employees on the employees table

require_once('connection.php');

global $conn;

$stmt = $conn->prepare("SELECT l.Person_id,concat(First_name,' ',Last_name) AS Full_name
                        FROM Person p,Goalkeeper l
                        Where p.Person_id = l.Person_id
                        ORDER BY First_name,Last_name;");
$stmt->execute();

?>

<table style='border: solid 1px black;'>
<thead>
	<tr>
    	<th>ID</th>
    	<th>Full name</th>
	</tr>
</thead>
<tbody>

<?php 
while ($row = $stmt->fetch()) {
    echo "<tr>
             <td>$row[Person_id]</td>
             <td>$row[Full_name]</td>
          </tr>";
}
?>

</tbody>
</table>