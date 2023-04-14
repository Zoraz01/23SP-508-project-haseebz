$(document).ready(function(){
	
	var tableClub = $('#table-club').DataTable({
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
			url:"advanced-club-action.php",
			type:"POST",
			data:{
					action:'listClubs'
				},
			dataType:"json"
		},
		"columnDefs":[ {"targets":[0], "visible":false} ], // Hide first column of the table containing the employee ID
		"buttons": [
				{
					extend: 'excelHtml5',
					title: 'Clubs',
					filename: 'Clubs',
					exportOptions: {columns: [1,2,3,4,5,6]}
				},
				{
					extend: 'pdfHtml5',
					title: 'Clubs',
					filename: 'Clubs',
					exportOptions: {columns: [1,2,3,4,5,6]}
				},
				{
					extend: 'print',
					title: 'Clubs',
					filename: 'Clubs',
					exportOptions: {columns: [1,2,3,4,5,6]}
				}]
	});	
	
	$("#addClub").click(function(){
		$('#club-form')[0].reset();
		$('#club-modal').modal('show'); // Open model (popup) on the browser
		$('.modal-title').html("Add Club");
		$('#action').val('addClub');
		$('#save').val('Add');
	});
	
	$("#club-modal").on('submit','#club-form', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		$.ajax({
			url:"advanced-club-action.php",
			method:"POST",
			data:{
				// Copy variables from the modal (popup) to send it to the POST
				ID: $('#ID').val(),
				clubname: $('#clubname').val(),
				gamesplayed: $('#gamesplayed').val(),
				goalsscored: $('#goalsscored').val(),
				goalsconceded: $('#goalsconceded').val(),
				points: $('#points').val(),
                division: $('#division').val(),
				action: $('#action').val(),
			},
			success:function(){
				$('#club-modal').modal('hide');
				$('#club-form')[0].reset();
				$('#save').attr('disabled', false);
				tableClub.ajax.reload();
			}
		})
	});		
	
	$("#table-club").on('click', '.update', function(){
		var ID = $(this).attr("clu_id");
		var action = 'getClub';
		$.ajax({
			url:'advanced-club-action.php',
			method:"POST",
			data:{ID:ID, action:action},
			dataType:"json",
			success:function(data){
				// Copy variables from the returned JSON from the SQL query in getEmployee into the modal (popup)
				$('#club-modal').modal('show');
                $('#ID').val(ID);
                $('#clubname').val(data.Club_name);
                $('#gamesplayed').val(data.Games_played);
                $('#goalsscored').val(data.Goals_Scored);
                $('#goalsconceded').val(data.Goals_conceded);
                $('#points').val(data.Points);
                $('#division').val(data.Division_name);
                $('.modal-title').html("Edit Club");
                $('#action').val('updateClub');
                $('#save').val('Save');
			}
		})
	});
	
	$("#table-club").on('click', '.delete', function(){
		var ID = $(this).attr("clu_id");		
		var action = "deleteClub";
		if(confirm("Are you sure you want to delete this club?")) {
			$.ajax({
				url:'advanced-club-action.php',
				method:"POST",
				data:{ID:ID, action:action},
				success:function() {					
					tableClub.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});
});