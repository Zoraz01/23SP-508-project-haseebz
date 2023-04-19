$(document).ready(function(){
	
	var tableGoalkeeper = $('#table-goalkeeper').DataTable({
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
			url:"advanced-goalkeeper-action.php",
			type:"POST",
			data:{
					action:'listGoalkeepers'
				},
			dataType:"json"
		},
		"columnDefs":[ {"targets":[0], "visible":false} ], // Hide first column of the table containing the employee ID
		"buttons": [
				{
					extend: 'excelHtml5',
					title: 'Goalkeepers',
					filename: 'Goalkeepers',
					exportOptions: {columns: [1,2,3,4,5,6]}
				},
				{
					extend: 'pdfHtml5',
					title: 'Goalkeepers',
					filename: 'Goalkeepers',
					exportOptions: {columns: [1,2,3,4,5,6]}
				},
				{
					extend: 'print',
					title: 'Goalkeepers',
					filename: 'Goalkeeepers',
					exportOptions: {columns: [1,2,3,4,5,6]}
				}]
	});	
	
	$("#addGoalkeeper").click(function(){
		$('#goalkeeper-form')[0].reset();
		$('#goalkeeper-modal').modal('show'); // Open model (popup) on the browser
		$('.modal-title').html("Add Goalkeeper");
		$('#action').val('addGoalkeeper');
		$('#save').val('Add');
	});
	
	$("#goalkeeper-modal").on('submit','#goalkeeper-form', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		$.ajax({
			url:"advanced-goalkeeper-action.php",
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
				cleansheets: $('#cleansheets').val(),
				goalsconceded: $('#goalsconceded').val(),
				action: $('#action').val(),
			},
			success:function(){
				$('#goalkeeper-modal').modal('hide');
				$('#goalkeeper-form')[0].reset();
				$('#save').attr('disabled', false);
				tableGoalkeeper.ajax.reload();
			}
		})
	});		
	
	$("#table-goalkeeper").on('click', '.update', function(){
		var ID = $(this).attr("goa_id");
		var action = 'getGoalkeeper';
		$.ajax({
			url:'advanced-goalkeeper-action.php',
			method:"POST",
			data:{ID:ID, action:action},
			dataType:"json",
			success:function(data){
				// Copy variables from the returned JSON from the SQL query in getEmployee into the modal (popup)
				$('#goalkeeper-modal').modal('show');
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
				$('#cleansheets').val(data.Clean_sheets);
				$('#goalsconceded').val(data.Goals_conceded);
				$('.modal-title').html("Edit Goalkeeper");
				$('#action').val('updateGoalkeeper');
				$('#save').val('Save');
			}
		})
	});
	
	$("#table-goalkeeper").on('click', '.delete', function(){
		var ID = $(this).attr("goa_id");		
		var action = "deleteGoalkeeper";
		if(confirm("Are you sure you want to delete this goalkeeper?")) {
			$.ajax({
				url:'advanced-goalkeeper-action.php',
				method:"POST",
				data:{ID:ID, action:action},
				success:function() {					
					tableGoalkeeper.ajax.reload();
				}
			})
		} else {
			return false;
		}
	});
});