<html>
<head>
<title>Club Database</title>
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

<script src="js/advanced-club.js"></script>

<!-- CSS for datatables buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css"/>
</head>

<?php require_once('connection.php'); global $conn; ?>

<body>

<div class="container-fluid mt-3 mb-3">
	<h4>Clubs</h4>
	
	<div class="pb-3">
		<button type="button" id="addClub" class="btn btn-primary btn-sm">Add Club</button>
	</div> 
        	
	<div>
		<table id="table-club" class="table table-bordered table-striped">
			<thead>
				<tr>
				<th>ID</th>
                    <th>Club Name</th>
                    <th>Games Played</th>
                    <th>Goals Scored</th>
                    <th>Goals Conceded</th>
                    <th>Points</th>
                    <th>Division Name</th>
                    <th>Actions</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<div id="club-modal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="club-form">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Club</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">

					<label>Club Name</label><input type="text" class="form-control" id="clubname" placeholder="Enter Club Name" required>
                        
                        <label>Games Played</label> <input type="number" class="form-control" min="0" step="1" size="3" value="0" id="gamesplayed">

                        <label>Goals Scored</label> <input type="number" class="form-control" min="0" step="1" size="3" value="0" id="goalsscored">

                        <label>Goals Conceded</label> <input type="number" class="form-control" min="0" step="1" size="3" value="0" id="goalsconceded">
                        
                        <label>Points</label> <input type="number" class="form-control" min="0" step="1" size="3" value="0" id="points">
                        

                        
                        <label>Division Name</label>
                        <select class="form-control" id="division">
                            <?php
                                $sqlQuery = "SELECT Division_name FROM Division ORDER BY Division_name ASC";
                                $stmt = $conn->prepare($sqlQuery);
                                $stmt->execute();
                                while ($row = $stmt->fetch()) {
                                    echo "<option value=\"" . $row["Division_name"] . "\">" . $row["Divison_name"] . "</option>";
                                }
                            ?>
                        </select>                       
            			
						

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