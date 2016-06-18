<?php
    //include files to get variables require to connect to database
    require_once (dirname(__FILE__) . "/shared/connect.php");
    //start session
    session_start();

    //get player id
    $id=$_GET['id'];

    //select player name which is selected
    $player_name_sql = "SELECT * FROM tblplayers WHERE player_Id = $id";

    $sth = $dbh->prepare($player_name_sql);

    $sth ->execute();

    $player =$sth->fetch();

    $sth->closeCursor();


    //write sql statement to delete team having selected player id
    $sql ="DELETE FROM tblplayers WHERE player_Id = $id";

    //prepare sql statement
    $sth=$dbh->prepare($sql);

    //execute the statement
    $sth->execute();

    //disconnect from data
    $dbh=null;
    $_SESSION['delete_player_msg'] ="Player ".$player['player_name']." is deleted successfully.<br>";
    //redirect to teams.php to show all teams
    header('Location:players.php?id='.$player['team_id']);
    exit;
?>