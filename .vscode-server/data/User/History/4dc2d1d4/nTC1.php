<html>
<head>
<title>Player Database</title>
<?php require_once('header.php'); ?>

<!-- Font Awesome library -->
<script src="https://kit.fontawesome.com/aec5ef1467.js"></script>

<!-- JS libraries for datatables buttons-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<script src="js/advanced-employee.js"></script>

<!-- CSS for datatables buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css"/>
</head>

<?php require_once('connection.php'); global $conn; ?>

<body>

<div class="container-fluid mt-3 mb-3">
	<h4>People</h4>
	
	<div class="pb-3">
		<button type="button" id="add Player" class="btn btn-primary btn-sm">Add Player</button>
	</div> 
        	
	<div>
		<table id="table-player" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Club</th>
					<th>Nationality</th>
					<th>Appearances</th>
					<th>Goals</th>
					<th>Assists</th>
					<th>Birth Date</th>
					<th>Salary</th>
					<th>Value</th>
					<th>Contract End Date</th>
					<th>Actions</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<div id="player-modal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="player-form">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Person</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">

						<label>First name</label><input type="text" class="form-control" id="firstname" placeholder="Enter first name" required>
						
						<label>Last name</label> <input type="text" class="form-control" id="lastname" placeholder="Enter last name" required>
						
						<label>Nationality</label> <input type="text" class="form-control" id="nationality" placeholder="Enter Nationality" required>
						
						<label>Salary</label> <input type="number" class="form-control" min="0.01" step="0.01" size="12" value="0" id="salary">

						<label>Birth Date</label> <input type="date" class="form-control" size="12" value="0" id="birthdate">

						
						<label>Club</label>
						<select class="form-control" id="club">
            			    <?php
            			        $sqlQuery = "SELECT Club_name FROM Club ORDER BY Club_name ASC";
            			        $stmt = $conn->prepare($sqlQuery);
            			        $stmt->execute();
            			        while ($row = $stmt->fetch()) {
            			            echo "<option value=\"" . $row["Club_name"] . "\">" . $row["Club_name"] . "</option>";
            			        }
                            ?>
            			</select>

                        <label>Contract End Date</label> <input type="date" class="form-control" size="12" value="0" id="contractendate">
            			
						<label>Appearances</label> <input type="number" class="form-control" min="0" step="1" size="3" value="0" id="appearances">

						<label>Goals</label> <input type="number" class="form-control" min="0" step="1" size="3" value="0" id="goals">

						<label>Assists</label> <input type="number" class="form-control" min="0" step="1" size="3" value="0" id="assists">

						<label>Postion</label> <input type="text" class="form-control" id="position" placeholder="Enter Position" required>

						<label>Value</label> <input type="number" class="form-control" min="0.01" step="0.01" size="12" value="0" id="value">


					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="ID" id="ID"/>
					<input type="hidden" name="action" id="action" value=""/>
					<input type="submit" name="save" id="save" class="btn btn-info" value="Save" />
					<button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</form>
	</div>
</div>

</body>
</html>