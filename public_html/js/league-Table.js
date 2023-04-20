$(document).ready(function(){
	
	var tableClub = $('#leagueTable').DataTable({
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
			url:"league-Table-action.php",
			type:"POST",
			data:{
					action:'listClubs'
				},
			dataType:"json"
		},
		"columnDefs":[ {"targets":[0], "visible":false} ], // Hide first column of the table containing the employee ID
	});	
	
	
});