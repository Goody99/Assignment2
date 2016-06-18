<?php
	//start session
	session_start();

	//check if validation went wrong (in sense Team name is given blank)
	if(isset($_SESSION['failed'])) { //if session['failed'] is set than we will take its value and print messages otherwise it will be false
		$failed = $_SESSION['failed'];
		$message = $_SESSION['failed_message'];

	} else {
		$failed = false;
	}
	//destroy session
	session_destroy();
?>
<!DOCTYPE html>
<html>
  <head>
	<link crossorigin='anonymous' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css' integrity='sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7' rel='stylesheet'>
	<link crossorigin='anonymous' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css' integrity='sha384-aNUYGqSUL9wG/vP7+cWZ5QOM4gsQou3sBfWRr/8S3R1Lv0rysEmnwsRKMbhiQX/O' rel='stylesheet'>
	<title>Hockey Teams</title>
  </head>
  <body>
  <!--THIS IS GLOBAL NAVIGATION SYSTEM-->
	<div class="container-fluid">
		<nav class=" navbar navbar-inverse">
			<!--THIS IS NAME OF WEBSITE IN NAVIGATION BAR-->
			<div class="navbar-header">
				<a href="new_team.php" class="navbar-brand">HOCKEY</a>
			</div>
			<div>
			<ul class="nav navbar-nav navbar-right" style="margin-right: 20px;">
				<li class="active"><a href="new_team.php" title="Add new team here">Add Team</a></li>
				<li><a href="new_player.php" title="Add new Player here">Add player</a></li>
				<li><a href="teams.php" title="View all Team here">View Team</a></li>
			</ul>
			</div>
		</nav>
	</div>
	<!--THIS IS BODY PART-->
	<div class="container">
		<h1 class="page-header">Add Team</h1>
		<!--THIS IS WHERE WE WILL DISPLAY OUR ERROR MESSAGES-->
		<?php if($failed) {?>
			<div class="alert alert-danger">
				<?=$message;?>
			</div>
		<?php } ?>
		<!--FORM WITH BOOTSTRAP CLASSES -->
		<form method="post" action="add_team.php">
			<fieldset>
				<legend>Hockey Team Information</legend>
				<div class="form-group">
					<label>Team Name</label>
					<input type="text" name="team_name" class="form-control" placeholder="Input Team Name"  required/>
				</div>
		
				<div class="form-group">
					<button type="submit" name="submit" class="btn btn-success btn-large"><i class="fa fa-plus"></i>&nbsp;Add Player</button>
					<button type="reset" name="reset" class="btn btn-danger btn-large">Clear</button>
				</div>
			</fieldset>
		</form>
	</div>
	
	<script crossorigin='anonymous' integrity='sha256-laXWtGydpwqJ8JA+X9x2miwmaiKhn8tVmOVEigRNtP4=' src='https://code.jquery.com/jquery-2.2.3.js'></script>
	<script crossorigin='anonymous' integrity='sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS' src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js'></script>
  </body>
</html>
