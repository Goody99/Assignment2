<?php

    //include files to get variables require to connect to database
    require_once (dirname(__FILE__) . "/shared/connect.php");

    //start session
    session_start();

    //get team id
    $id=$_GET['id'];

    $sql_team_name = "SELECT team_name FROM tblteams WHERE team_id= $id";

    $sth= $dbh->prepare($sql_team_name);

    $sth->execute();

    $team = $sth->fetch();


    $sth->closeCursor();


    //write sql statement to delete team having selected team id
    $sql ="DELETE FROM tblteams WHERE team_id= $id";

    //prepare sql statement
    $sth=$dbh->prepare($sql);

    //execute the statement
    $sth->execute();

    //disconnect from data
    $dbh=null;

    $_SESSION['delete_team_msg'] = "Team ".$team['team_name'] ." is deleted successfully.";
    //redirect to teams.php to show all teams
    header('Location:teams.php');
    exit;
?>