<?php
include('include/session.php');
if (isset($_SESSION['inactive'])) {
	header("Location: login.php");
} else {
	if ($_SESSION['user_type'] != 'accountant') {
		if ($_SESSION['user_type'] != 'manager') {
			if ($_SESSION['user_type'] == 'admin') {
				header("Location: admin-home.php");
			} else {
				header("Location: login.php");				
			}
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<!-- HEADER -->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Finance Titan - Reporting</title>

	<!-- Stylesheets -->
	<link href="css/bootstrap-4.4.1.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css">
</head>
	
<body>	    
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.debug.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.1/html2pdf.bundle.min.js"></script>
    <script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
<!-- NAVIGATION -->
<?php include('include/navbar.php'); ?>

<!-- PAGE CONTENT -->
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12" id="help-modal-container">
			<?php include('include/help-modal.php'); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-3">
			<h2>Generate a Report</h2>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-3">
			<div class="btn-group-vertical">
				<button type="button" id="trial-bal" class="btn btn-outline-primary"><h5>Trial Balance</h5></button>
				<button type="button" id="bal-sheet" class="btn btn-outline-primary"><h5>Balance Sheet</h5></button>
				<button type="button" id="inco-stmt" class="btn btn-outline-primary"><h5>Income Statement</h5></button>
				<button type="button" id="ret-earns" class="btn btn-outline-primary"><h5>Retained Earnings</h5></button>
			</div>			
		</div>
		<div class="col-sm-9">
			<div id="alert-msg"></div>
			<div id="show-report"></div>
			<div id="pdf-btn"></div>
		</div>
	</div>
</div>

	<!-- Include all compiled plugins (below), or include individual files as needed --> 
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap-4.4.1.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
	<script>
		// enable tooltips and popovers
		$('[data-toggle="tooltip"]').tooltip();
		$('[data-toggle="popover"]').popover();
	</script>
	
	<script type="text/javascript">
		// initialize pdf doc
		var pdfdoc = document.getElementById('show-report');
		var opt = {
			margin:			0.5,
			filename:		'document.pdf',
			image:			{ type: 'jpeg', quality: 0.99 },
			html2canvas:	{ scale: 2 },
			jsPDF:			{ unit: 'in', format: 'letter', orientation: 'portrait' }
		};
		
		$(document).ready(function() {
			
			// on click function for trial balance report
			$('#trial-bal').click(function() {
				$.ajax({
					method: 'POST',
					url: 'reports/trial-bal.php',
					dataType: 'JSON',
					success: function(data) {
						displayReport(data);
					}
				})
			})
			
			// on click function for balance sheet report
			$('#bal-sheet').click(function() {
				$.ajax({
					method: 'POST',
					url: 'reports/bal-sheet.php',
					dataType: 'JSON',
					success: function(data) {
						displayReport(data);
					}
				})
			})
			
			// on click function for income statement report
			$('#inco-stmt').click(function() {
				$.ajax({
					method: 'POST',
					url: 'reports/inco-stmt.php',
					dataType: 'JSON',
					success: function(data) {
						displayReport(data);
					}
				})
			})
			
			// on click function for retained earnings report
			$('#ret-earns').click(function() {
				$('#show-report').html('<h2 id="report-name"></h2>');
				$('#pdf-btn').html('');
				
				//$('#report-name').html('<strong>Select Date(s)</strong>');
				//var html = '<label for="date-start" class="form-label">From: </label><input type="date" id="date-start" placeholder="mm/dd/yyyy" class="form-input"><br><br>';
				//html += '<label for="date-end" class="form-label">To: </label><input type="date" id="date-end" placeholder="mm/dd/yyyy" class="form-input"><br><br>';
				var html ='<button type="button" class="btn btn-primary btn-width" id="gen-ret-earn">Generate Report</button>';
				$('#show-report').append(html);
			})
			
			$('#show-report').on('click', '#gen-ret-earn', function() {
				var error = '';
				/*if ($('#date-start').val()) {
					var start = $('#date-start').val();					
				} else {
					error += 'You must choose a start date. ';
				}
				if ($('#date-end').val()) {
				var end = $('#date-end').val();				
				} else {
					error += 'You must choose an end date. ';
				}*/
				if (error != '') {
					$('#alert-msg').html('<div class="alert alert-warning">'+error+'</div>');
					
					setInterval(function(){
						$('#alert-msg').html('');
					}, 5000);
				} else {
					$.ajax({
						method: 'POST',
						url: 'reports/ret-earns.php',
						dataType: 'JSON',
					 // data: {
					 // 	startdate: start,
					 // 	enddate: end
					 // },
						success: function(data) {
							displayReport(data);
						}
					})
				}					
			})				
			
			function displayReport(data) {
				$('#show-report').html('<h2 id="report-name"></h2>');
				
				$('#report-name').html('<strong>'+data[0]+'</strong>');
				$('#show-report').append(data[1]);
				$('#pdf-btn').html('<button class="btn btn-primary btn-width" id="gpdf" type="button">Generate PDF</button>');
			};
			
			// on click function for generate pdf btn
			$('#pdf-btn').on('click', '#gpdf', function() {
				html2pdf(pdfdoc, opt);
			});
		})
		
		
	</script>
</body>
</html>