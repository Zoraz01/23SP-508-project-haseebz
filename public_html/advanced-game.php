<html>
<head>
<title>Game Database</title>
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

<script src="js/advanced-game.js"></script>

<!-- CSS for datatables buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css"/>
</head>

<?php require_once('connection.php'); global $conn; ?>

<body>

<div class="container-fluid mt-3 mb-3">
	<h4>Games</h4>
	
	<div class="pb-3">
		<button type="button" id="addGame" class="btn btn-primary btn-sm">Add Game</button>
	</div> 
        	
	<div>
		<table id="table-game" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>ID</th>
					<th>Home Team</th>
					<th>Home Score</th>
					<th>Away Score</th>
					<th>Away Team</th>
					<th>Date</th>
					<th>Actions</th>
				</tr>
			</thead>
		</table>
	</div>
</div>

<div id="game-modal" class="modal fade">
	<div class="modal-dialog">
		<form method="post" id="game-form">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Game</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">

						<label>Home Team</label>
						<select class="form-control" id="hometeam">
            			    <?php
            			        $sqlQuery = "SELECT Club_name FROM Club ORDER BY Club_name ASC";
            			        $stmt = $conn->prepare($sqlQuery);
            			        $stmt->execute();
            			        while ($row = $stmt->fetch()) {
            			            echo "<option value=\"" . $row["Club_name"] . "\">" . $row["Club_name"] . "</option>";
            			        }
                            ?>
            			</select>

            			
						<label>Home Score</label> <input type="number" class="form-control" min="0" step="1" size="3" value="0" id="homescore">

                        <label>Away Team</label>
						<select class="form-control" id="awayteam">
            			    <?php
            			        $sqlQuery = "SELECT Club_name FROM Club ORDER BY Club_name ASC";
            			        $stmt = $conn->prepare($sqlQuery);
            			        $stmt->execute();
            			        while ($row = $stmt->fetch()) {
            			            echo "<option value=\"" . $row["Club_name"] . "\">" . $row["Club_name"] . "</option>";
            			        }
                            ?>
            			</select>
						<label>Away Score</label> <input type="number" class="form-control" min="0" step="1" size="3" value="0" id="awayscore">

						<label>Date</label> <input type="date" class="form-control" size="12" value="0" id="dateplayed">

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