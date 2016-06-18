<?php
    //start session
    session_start();
    //include file to get variables required to connect to databasd
	require_once (dirname(__FILE__) . "/shared/connect.php");

    //get all variables from POST array
    $team_id =  $_POST['id'];
    $player_name = $_POST['player_name'];

    //set session varaibles to validate player_name and to store error messages
    $_SESSION['failed_player']=false;
    $_SESSION['failed_message_player']="";

    //check team is selected or not - By defaul we gave 0 value to 'Select team'
    if($team_id == 0) {
        $_SESSION['failed_message_player'].="Team Must be selected.<br>";
        $_SESSION['failed_player']=true;
    } else {    // if team is selected ,sanitize it -
        $team_id = filter_var($team_id,FILTER_SANITIZE_NUMBER_INT);
    }
    //check if player name is empty than append error message
    if(empty( $player_name )) {
        $_SESSION['failed_message_player'].="Player name must be selected.<br>";
        $_SESSION['failed_player']=true;
    } else {
        $player_name = filter_var($player_name,FILTER_SANITIZE_STRING);
    }
    //if validation wend wrong redirect page back to new_player.php
    if($_SESSION['failed_player']) {
        header('Location:new_player.php');
        exit;
    }

    //this is insert statement to add team id and player name in player table
    $sql ='INSERT INTO tblplayers (player_name,team_id) VALUE (:player_name,:team_id)';

    //prepare sql statement
    $sth=$dbh->prepare($sql);

    //bind parameters
    $sth->bindParam(':player_name',$player_name,PDO::PARAM_STR,50);
    $sth->bindParam(':team_id',$team_id,PDO::PARAM_INT,11);

    //execute query
    $sth->execute();

    //disconnect databse
    $dbh=null;


    // this is success message stored in session
    $_SESSION["message"] = "Player ".$player_name." was added successfully.<br />";

    //redirect to page where all players of selected team is shown
    header('Location:players.php?id='.$team_id);
    exit;

?>