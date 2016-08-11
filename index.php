<!DOCTYPE html>
<html>
<head>
	<title>Table</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<link rel="stylesheet" type="text/css" href="assets/datatables.min.css"/>
	<script type="text/javascript" src="assets/datatables.min.js"></script>
	<style type="text/css">
		.editors
		{
			display: none;
		}
	</style>
	<script type="text/javascript">
		$(document).ready(function(){
			ETable.init();
		});
	</script>
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-md-6">
				<div class="table-responsive">
					<table id="data_table" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Email</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
			<div class="col-md-3"></div>
		</div>
	</div>
</body>
<script type="text/javascript" language="javascript" class="init">
ETable={
	"existingValue":"",
	"init":function(){
		$('#data_table').dataTable({
			"sServerMethod": "GET", 
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "data.php",
			colReorder: true,
			fixedHeader: true,
			keys: true,
			responsive: true,
			rowReorder: true,
			
		});

		$(document).on('dblclick','.originals',function(){
			ETable.openEditable(this);
		});

		$(document).on('blur','.editable',function(){
			ETable.saveNewData(this);
		});

	},
	"openEditable":function(elem){
		$('.editors').hide();
		$('.originals').show();
		$(elem).hide();
		$(elem).siblings().show();
		$(elem).siblings().find('.editable').focus();
		ETable.existingValue=$(elem).html();
	},
	"saveNewData":function(elem){
		$('.editors').hide();
		$('.originals').show();
		var newVal=$(elem).val();
		if(newVal==ETable.existingValue)
		{
			console.warn("Same Value");
		}
		else
		{
			$(elem).parent().siblings().html(newVal)
			$.ajax({
				url     : 'data.php',
				method    : 'POST',
				data    :
				{
					update:"y",
					row:$(elem).attr('for-row'),
					col:$(elem).attr('for-field'),
					val:newVal
				},
				success   : function(response)
				{
				},
				error : function(e)
				{
				}
			});
		}
	}
}
</script>
</html>