$(document).ready(function(){
	
	var tableGame = $('#table-game').DataTable({
		"dom": 'Blfrtip',
		"autoWidth": false,
		"processing":true,
		"serverSide":true,
		"pageLength":15,
		"lengthMenu":[[15, 25, 50, 100, -1], [15, 25, 50, 100, "All"]], // Number of rows to show on the table
		"responsive": true,
		"language": {processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>'}, // Loading icon while data is read from the database
		"order":[],
		"ajax":{
			url:"advanced-game-action.php",
			type:"POST",
			data:{
					action:'listGames'
				},
			dataType:"json"
		},
		"columnDefs":[ {"targets":[0], "visible":false} ], // Hide first column of the table containing the employee ID
		"buttons": [
				{
					extend: 'excelHtml5',
					title: 'Games',
					filename: 'Games',
					exportOptions: {columns: [1,2,3,4,5,6]}
				},
				{
					extend: 'pdfHtml5',
					title: 'Games',
					filename: 'Games',
					exportOptions: {columns: [1,2,3,4,5,6]}
				},
				{
					extend: 'print',
					title: 'Games',
					filename: 'Games',
					exportOptions: {columns: [1,2,3,4,5,6]}
				}]
	});	
	
	$("#addGame").click(function(){
		$('#game-form')[0].reset();
		$('#game-modal').modal('show'); // Open model (popup) on the browser
		$('.modal-title').html("Add Game");
		$('#action').val('addGame');
		$('#save').val('Add');
	});
	
	$("#game-modal").on('submit','#game-form', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		$.ajax({
			url:"advanced-game-action.php",
			method:"POST",
			data:{
				// Copy variables from the modal (popup) to send it to the POST
				ID: $('#ID').val(),
				hometeam: $('#hometeam').val(),
				homescore: $('#homescore').val(),
				awayteam: $('#awayteam').val(),
				awayscore: $('#awayscore').val(),
				dateplayed: $('#dateplayed').val(),
				action: $('#action').val(),
			},
			success:function(){
				$('#game-modal').modal('hide');
				$('#game-form')[0].reset();
				$('#save').attr('disabled', false);
				tableGame.ajax.reload();
			}
		})
	});		
	
	$("#table-game").on('click', '.update', function(){
		var ID = $(this).attr("gam_id");
		var action = 'getGame';
		$.ajax({
			url:'advanced-game-action.php',
			method:"POST",
			data:{ID:ID, action:action},
			dataType:"json",
			success:function(data){
				// Copy variables from the returned JSON from the SQL query in getEmployee into the modal (popup)
				$('#game-modal').modal('show');
				$('#ID').val(ID);
				$('#dateplayed').val(data.Date_played);
				$('#hometeam').val(data.Club_name);
				$('#homescore').val(data.Home_score);
				$('#awayteam').val(data.Club_name);
				$('#awayscore').val(data.Away_score);
				$('.modal-title').html("Edit Game");
				$('#action').val('updateGame');
				$('#save').val('Save');
			}
		})
	});
	
	$("#table-game").on('click', '.delete', function(){
		var ID = $(this).attr("gam_id");		
		var action = "deleteGame";
		if(confirm("Are you sure you want to delete this Game?")) {
			$.ajax({
				url:'advanced-game-action.php',
				method:"POST",
				data:{ID:ID, action:action},
				success:function() {					
					tableGame.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});
});