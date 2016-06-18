<?php
    //include file to get variables require to connect database
	require_once (dirname(__FILE__) . "/shared/connect.php");

    //start session
	session_start();
    
    if(isset($_SESSION['failed_player'])) {
        $failed = $_SESSION['failed_player'];
        $message = $_SESSION['failed_message_player'];
    } else {
        $failed = false;
    }
    session_destroy();

    $sql ='SELECT * FROM tblteams';

    $sth=$dbh->prepare($sql);

    $sth->execute();

    $teams=$sth->fetchAll();

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
        <!--THIS IS GLOBAL NABIGATION BAR-->
        <div class="container-fluid">
            <nav class=" navbar navbar-inverse">
                <div class="navbar-header">
                    <a href="new_team.php" class="navbar-brand">HOCKEY</a>
                </div>
                <div>
                <ul class="nav navbar-nav navbar-right" style="margin-right: 20px;">
                    <li><a href="new_team.php" title="Add new team here">Add Team</a></li>
                    <li class="active" title="Add new Player here"><a href="new_player.php">Add player</a></li>
                    <li><a href="teams.php" title="View all team here">View Team</a></li>
                </ul>
                </div>
            </nav>
        </div>
    <!-- This is a Bootstrap container. Get more info at http://getbootstrap.com/ -->
        <div class="container">
            <form  action="add_player.php" method="POST">
                <div class="page-header">
                    <h1>Add New Player</h1>
                </div>
                <?php if($failed) {?>
                    <div class="alert alert-danger">
                        <?=$message;?>
                    </div>
                <?php } ?>
                <fieldset>
                    <legend>Players Information</legend>
                    <!--THIS IS DROPDOWN MENU TO SHOW ALL TEAMS' NAME-->
                    <select name="id" required>
                        <option value=0>Select Team..</option>
                        <?php foreach ($teams as $team):?>
                            <option value="<?=$team['team_id']?>"><?=$team['team_name'];?></option>
                        <?php endforeach;?>
                    </select>
                    <div class="form-group">
                        <label for="player_name">Name</label>
                        <input type="text" name="player_name" class="form-control"  required/>
                    </div>

                </fieldset>
                <div class="form-group">
                    <button type="submit" name="submit" class="btn btn-success btn-large"><i class="fa fa-plus"></i>&nbsp;Add Player</button>
                    <button type="reset" name="reset" class="btn btn-danger btn-large">Clear</button>
                </div>
            </form>
        </div>

        <script src="https://code.jquery.com/jquery-2.2.3.min.js" integrity="sha256-a23g1Nt4dtEYOj7bR+vTu7+T8VP13humZFBJNIYoEJo=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    </body>
</html>