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
			url:"advanced-manager-action.php",
			type:"POST",
			data:{
					action:'listManagers'
				},
			dataType:"json"
		},
		"columnDefs":[ {"targets":[0], "visible":false} ], // Hide first column of the table containing the employee ID
		"buttons": [
				{
					extend: 'excelHtml5',
					title: 'Managers',
					filename: 'Managers',
					exportOptions: {columns: [1,2,3,4,5,6]}
				},
				{
					extend: 'pdfHtml5',
					title: 'PManagers',
					filename: 'Managers',
					exportOptions: {columns: [1,2,3,4,5,6]}
				},
				{
					extend: 'print',
					title: 'Managers',
					filename: 'Managers',
					exportOptions: {columns: [1,2,3,4,5,6]}
				}]
	});	
	
	$("#addManager").click(function(){
		$('#manager-form')[0].reset();
		$('#manager-modal').modal('show'); // Open model (popup) on the browser
		$('.modal-title').html("Add Manager");
		$('#action').val('addManager');
		$('#save').val('Add');
	});
	
	$("#manager-modal").on('submit','#manager-form', function(event){
		event.preventDefault();
		$('#save').attr('disabled','disabled');
		$.ajax({
			url:"advanced-manager-action.php",
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
				action: $('#action').val(),
			},
			success:function(){
				$('#manager-modal').modal('hide');
				$('#manager-form')[0].reset();
				$('#save').attr('disabled', false);
				tablePlayer.ajax.reload();
			}
		})
	});		
	
	$("#table-manager").on('click', '.update', function(){
		var ID = $(this).attr("man_id");
		var action = 'getManager';
		$.ajax({
			url:'advanced-manager-action.php',
			method:"POST",
			data:{ID:ID, action:action},
			dataType:"json",
			success:function(data){
				// Copy variables from the returned JSON from the SQL query in getEmployee into the modal (popup)
				$('#manager-modal').modal('show');
				$('#ID').val(ID);
				$('#firstname').val(data.First_name);
				$('#lastname').val(data.Last_name);
				$('#nationality').val(data.Nationality);
				$('#salary').val(data.Salary);
				$('#birthdate').val(data.Date_of_birth);
				$('#club').val(data.Club);
				$('#contractenddate').val(data.Contract_end_date);
				$('.modal-title').html("Edit Manager");
				$('#action').val('updateManager');
				$('#save').val('Save');
			}
		})
	});
	
	$("#table-manager").on('click', '.delete', function(){
		var ID = $(this).attr("man_id");		
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