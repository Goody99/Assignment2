<?php
	//start session
	session_start();

	//include file to get all variables require to connect to database
	require_once (dirname(__FILE__) . "/shared/connect.php");
		
		// 1. build the SQL statement to insert team name
		$sql = "INSERT INTO tblteams (team_name) VALUES (:team_name)";

		// assign our values to variables
		$team_name = $_POST["team_name"];

		//if team name filled empty,we will storre message into session variable and flag
		if(empty($team_name)) {
			$_SESSION['failed']=true;
			$_SESSION['failed_message'] = "Team Name must be given";
			header('Location:new_team.php');
			exit;

		} else {	//if team name was not empty than it will sanitize team name
			$_SESSION['failed']=false;
			$team_name = filter_var($team_name,FILTER_SANITIZE_STRING);
		}

		// 2. prepare the SQL statement
		$sth = $dbh->prepare($sql);
		
		// 3. fill the placehoders
		$sth->bindParam(":team_name", $team_name, PDO::PARAM_STR, 50);

		// 4. execute the SQL
		$sth->execute();
		
		// 5. close the DB connection
		$dbh = null;

		// this is success message stored in session
		$_SESSION["message"] = "Team ".$team_name." was added successfully.<br />";
		//redirect to teams.php page
		header("Location: teams.php");

?>