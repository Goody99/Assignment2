<?php
    //start session
    session_start();
    //get variables from post array
    $name = $_POST['player_name'];

    //get id of player to delete it
    $id=$_SESSION['id'];
    //set session variable to validate if player name is empty or not
    $_SESSION['validatedDone']=true;

    //include files to get variables required to connect to database
    require_once (dirname(__FILE__) . "/shared/connect.php");

    //if player name is empty ,redirect back
    if(empty( $name )) {
        $_SESSION['message']="Player name must be filled.<br>";
        $_SESSION['failed']=true;
        header('Location:update_player_name.php?id='.$id);
        exit;
    } else {//if player name is not empty than sanitize it
        $name = filter_var($name,FILTER_SANITIZE_STRING);
    }

    // 1. build the SQL statement
    $sql = "UPDATE tblplayers SET player_name = :name WHERE player_Id = :id";

    // 2. prepare the SQL statement
    $sth = $dbh->prepare($sql);

    $sth->bindParam(':name',$name,PDO::PARAM_STR);
    $sth->bindParam(':id',$id,PDO::PARAM_INT);

    // 4. execute the SQL
    $sth->execute();

    // 5. close the DB connection
    $dbh = null;

    $_SESSION['update_player_msg'] = "Player <strong>".$_SESSION['old_player_name'] . "</strong> is changed to <strong>". $name ."</strong>. <br>";

    //redirect it to team page
    header("Location: players.php?id=".$_SESSION['team_id']);
    exit;
?>