$(document).ready(function(){
	
	var tablePlayer = $('#table-manager').DataTable({
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
			url:"advanced-player-action.php",
			type:"POST",
			data:{
					action:'listPlayers'
				},
			dataType:"json"
		},
		"columnDefs":[ {"targets":[0], "visible":false} ], // Hide first column of the table containing the employee ID
		"buttons": [
				{
					extend: 'excelHtml5',
					title: 'Players',
					filename: 'Players',
					exportOptions: {columns: [1,2,3,4,5,6]}
				},
				{
					extend: 'pdfHtml5',
					title: 'Players',
					filename: 'Players',
					exportOptions: {columns: [1,2,3,4,5,6]}
				},
				{
					extend: 'print',
					title: 'Players',
					filename: 'Players',
					exportOptions: {columns: [1,2,3,4,5,6]}
				}]
	});	
	
	$("#addPlayer").click(function(){
		$('#player-form')[0].reset();
		$('#player-modal').modal('show'); // Open model (popup) on the browser
		$('.modal-title').html("Add Player");
		$('#action').val('addPlayer');
		$('#save').val('Add');
	});
	
	$("#player-modal").on('submit','#player-form', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		$.ajax({
			url:"advanced-player-action.php",
			method:"POST",
			data:{
				// Copy variables from the modal (popup) to send it to the POST
				ID: $('#ID').val(),
				firstname: $('#firstname').val(),
				lastname: $('#lastname').val(),
				nationality: $('#nationality').val(),
				salary: $('#salary').val(),
				birthdate: $('#birthdate').val(),
				club: $('#club').val(),
                contractenddate: $('#contractenddate').val(),
                appearances: $('#appearances').val(),
                goals: $('#goals').val(),
                assists: $('#assists').val(),
                position: $('#position').val(),
                value: $('#value').val(),
				action: $('#action').val(),
			},
			success:function(){
				$('#player-modal').modal('hide');
				$('#player-form')[0].reset();
				$('#save').attr('disabled', false);
				tablePlayer.ajax.reload();
			}
		})
	});		
	
	$("#table-player").on('click', '.update', function(){
		var ID = $(this).attr("pla_id");
		var action = 'getPlayer';
		$.ajax({
			url:'advanced-player-action.php',
			method:"POST",
			data:{ID:ID, action:action},
			dataType:"json",
			success:function(data){
				// Copy variables from the returned JSON from the SQL query in getEmployee into the modal (popup)
				$('#player-modal').modal('show');
				$('#ID').val(ID);
				$('#firstname').val(data.First_name);
				$('#lastname').val(data.Last_name);
				$('#nationality').val(data.Nationality);
				$('#salary').val(data.Salary);
				$('#birthdate').val(data.Date_of_birth);
				$('#club').val(data.Club);
				$('#contractenddate').val(data.Contract_end_date);
                $('#appearances').val(data.Appearances);
                $('#goals').val(data.Goals);
                $('#assists').val(data.Assists);
                $('#position').val(data.Position);
                $('#value').val(data.Value);
				$('.modal-title').html("Edit Player");
				$('#action').val('updatePlayer');
				$('#save').val('Save');
			}
		})
	});
	
	$("#table-player").on('click', '.delete', function(){
		var ID = $(this).attr("pla_id");		
		var action = "deletePlayer";
		if(confirm("Are you sure you want to delete this player?")) {
			$.ajax({
				url:'advanced-player-action.php',
				method:"POST",
				data:{ID:ID, action:action},
				success:function() {					
					tablePlayer.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});
});