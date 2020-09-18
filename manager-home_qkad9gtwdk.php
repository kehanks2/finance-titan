<?php
include('session.php');
if ($_SESSION['user_type'] != 'manager') {
	if ($_SESSION['user_type'] == 'admin') {
		header("Location: admin-home.php");
	} elseif ($_SESSION['user_type'] == 'accountant') {
		header("Location: accountant-home.php");
	}
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Finance Titan - Home</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap-4.4.1.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
<body>
	  
  <!-- NAVIGATION -->
<?php include('include/navbar.php'); ?>

<section id="admin-home" class="container-fluid home-screen">
	<div class="row">
		
		<!-- SIDE BAR -->
		<div class="col-sm-auto">
			<h1>Welcome, <?php echo $login_session; ?></h1>
			<h3>Manager Account</h3>
			<hr>
		</div>
	</div>
</section>
	
<?php
echo "<mm:dwdrfml documentRoot=" . __FILE__ .">";$included_files = get_included_files();foreach ($included_files as $filename) { echo "<mm:IncludeFile path=" . $filename . " />"; } echo "</mm:dwdrfml>";
?>