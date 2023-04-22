$(document).ready(function(){
	
	var scoringTable = $('#scoringTable').DataTable({
		"dom": 'Blfrtip',
		"autoWidth": false,
		"processing":true,
		"serverSide":true,
		"pageLength":15,
		"lengthMenu":[[15, 25, 50, 100, -1], [15, 25, 50, 100, "All"]], // Number of rows to show on the table
		"responsive": true,
        "searching": false, 
        "ordering": false, 
		"language": {processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>'}, // Loading icon while data is read from the database
		"order":[],
		"ajax":{
			url:"league-Leaders-action.php",
			type:"POST",
			data:{
					action:'listScorers'
				},
			dataType:"json"
		}
	});	
    var assistsTable = $('#assistsTable').DataTable({
		"dom": 'Blfrtip',
		"autoWidth": false,
		"processing":true,
		"serverSide":true,
		"pageLength":15,
		"lengthMenu":[[15, 25, 50, 100, -1], [15, 25, 50, 100, "All"]], // Number of rows to show on the table
		"responsive": true,
        "searching": false,
        "ordering": false, 
		"language": {processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>'}, // Loading icon while data is read from the database
		"order":[],
		"ajax":{
			url:"league-Leaders-action.php",
			type:"POST",
			data:{
					action:'listAssisters'
				},
			dataType:"json"
		}
	});	

    var appearancesTable = $('#appearancesTable').DataTable({
		"dom": 'Blfrtip',
		"autoWidth": false,
		"processing":true,
		"serverSide":true,
		"pageLength":15,
		"lengthMenu":[[15, 25, 50, 100, -1], [15, 25, 50, 100, "All"]], // Number of rows to show on the table
		"responsive": true,
        "searching": false, 
        "ordering": false, 
		"language": {processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>'}, // Loading icon while data is read from the database
		"order":[],
		"ajax":{
			url:"league-Leaders-action.php",
			type:"POST",
			data:{
					action:'listAppearances'
				},
			dataType:"json"
		}
	});	

});