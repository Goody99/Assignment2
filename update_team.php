<?php
    //start the session
    session_start();

    //get all variables from POST method and team id from session
    $name = $_POST['team_name'];

    //get id from session variable
    $id=$_SESSION['id'];

    $_SESSION['validatedDone']=true;

    //include files to get variables required to connect to database
    require_once (dirname(__FILE__) . "/shared/connect.php");

    //if name is submitted empty than store error message and redirect back.
	if(empty( $name )) {
	    $_SESSION['message']="Team name must be filled.<br>";
	    $_SESSION['failed']=true;
	    header('Location:update_team_name.php?id='.$id);
	    exit;
	} else {    //if team name is provided than sanitize it
	    $name = filter_var($name,FILTER_SANITIZE_STRING);
	}

    // 1. build the SQL statement
    $sql = "UPDATE tblteams SET team_name = :name WHERE team_id = :id";

	// 2. prepare the SQL statement
	$sth = $dbh->prepare($sql);

    //bind parameters
    $sth->bindParam(':name',$name,PDO::PARAM_STR);
    $sth->bindParam(':id',$id,PDO::PARAM_INT);

    // 4. execute the SQL
    $sth->execute();

    // 5. close the DB connection
    $dbh = null;

    $_SESSION['update_team_msg']= "Team <strong>".$_SESSION['old_team_name']. "</strong> is changed to <strong>".$name ."</strong>.<br>";
    //redirect to team.php
    header("Location: teams.php");
    exit;
?>