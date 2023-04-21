$(document).ready(function(){
	
	var tableClub = $('#leagueTable').DataTable({
		"dom": 'Blfrtip',
		"autoWidth": false,
		"processing": true,
		"serverSide": true,
		"pageLength": 15,
		"lengthMenu": [[15, 25, 50, 100, -1], [15, 25, 50, 100, "All"]],
		"responsive": true,
		"language": {processing: '<i class="fa fa-spinner fa-spin fa-2x fa-fw"></i>'},
		"order": [],
		"ajax": {
			url: "league-Table-action.php",
			type: "POST",
			data: {
				action: 'listClubs'
			},
			dataType: "json"
		},
		"columns": [
			{ "data": 0 },
			{ "data": 1, "render": function(data, type, row) {
				return '<img src="' + data + '" alt="Club Image" style="width: 25px; height: 25px;">';
			}},
			{ "data": 2 },
			{ "data": 3 },
			{ "data": 4 },
			{ "data": 5 },
			{ "data": 6 }
		],
		
		"columnDefs": [
			{ "targets": 1, "orderable": false }
		]
	});
});
