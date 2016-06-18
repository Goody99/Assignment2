<?php
    //include files to get variables required to connect to database
	require_once (dirname(__FILE__) . "/shared/connect.php");

    //start session
    session_start();

    if(isset($_SESSION['message'])) {
        //get success messages
        $message = $_SESSION['message'];
        $class = "success";

    } else if(isset($_SESSION['delete_player_msg'])){
        $message = $_SESSION['delete_player_msg'];
        $class = "danger";
    } else if(isset($_SESSION['update_player_msg'])) {
        $message = $_SESSION['update_player_msg'];
        $class="info";
    }
    else {
        $message = null;
    }

    //destroy session
    session_destroy();

    //get team id
    $team_id = $_GET['id'];

    //write sql statement to get team details which is selected by user
    $team_sql ="SELECT * FROM tblteams WHERE team_id = $team_id";

    //prepare statement
    $sth=$dbh->prepare($team_sql);

    //execute statement
    $sth->execute();

    //fetch fata get from select statement
    $teams=$sth->fetch();

    //close cursor to use $sth with player table
    $sth->closeCursor();

    //select players details where team id is same as id get from $team_sql statement
    $player_sql = "SELECT * FROM tblplayers WHERE team_id = $team_id";

    //prepare statement
    $sth=$dbh->prepare($player_sql);

    //execute statement
    $sth->execute();

    //fetch all data
    $players=$sth->fetchAll();

    //count rows
    $row_count = $sth->rowCount();
    //disconnect from database
    $dbh=null;


?>

<!DOCTYPE HTML>
    <html lang="en">

    <head>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.2/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-aNUYGqSUL9wG/vP7+cWZ5QOM4gsQou3sBfWRr/8S3R1Lv0rysEmnwsRKMbhiQX/O" crossorigin="anonymous">
        <title>Hockey Teams</title>
    </head>

    <body>
        <div class="container-fluid">
            <!--THIS IS GLOBAL NAVIGATION-->
            <nav class=" navbar navbar-inverse">
                <div class="navbar-header">
                    <a href="new_team.php" class="navbar-brand">HOCKEY</a>
                </div>
                <div>
                    <ul class="nav navbar-nav navbar-right" style="margin-right: 20px;">
                        <li><a href="new_team.php">Add Team</a></li>
                        <li><a href="new_player.php">Add player</a></li>
                        <li><a href="teams.php">View Team</a></li>
                    </ul>
                </div>
            </nav>
        </div>
        <!--THIS IS BODY PART-->
        <div class="container">
            <header>
                <h1 class="page-header">All Players</h1>
            </header>
                <?php if ($message != null) {?>
                    <div class="alert alert-success">
                        <?=$message;?>
                    </div>
                <?php }?>
            <section>

                <!--IF THERE IS ANY DATA AVAILABLE-->
                <?php if ($row_count > 0 ): ?>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <td><strong>No</strong></td>
                            <td><strong>Players Name</strong></td>
                        </tr>
                        </thead>
                        <tbody>

                        <!--GET VARIABLE TO PRINT SEQUENCE -->
                        <?php $i=1?>

                        <!--DISPLAY PLAYERS DETAILS-->
                        <?php foreach ($players as $player): ?>
                            <tr>
                                <td><?= $i; $i++;?></td><!--INCREMENT INDEX-->
                                <td><?= htmlspecialchars($player['player_name']) ?></td>
                                <td><a href="update_player_name.php?id=<?= $player['player_Id']?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        Update</a></td>
                                <td><a href="delete_player.php?id=<?= $player['player_Id']?>"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                        Delete</a></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>

                    <!--IF THERE IS NOT ANY DATA-->
                <?php else: ?>
                    <div class="alert alert-warning">
                        No team information to display
                    </div>
                <?php endif ?>
            </section>
        </div>

        <script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </body>

</html>
