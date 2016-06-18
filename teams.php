<?php
    //start session
    session_start();

    if(isset($_SESSION['message'])) {
        //get success messages
        $message = $_SESSION['message'];
        $class = "success";
    } else if(isset($_SESSION['delete_team_msg'])) {
        //get success messages
        $message = $_SESSION['delete_team_msg'];
        $class = "danger";
    } else if(isset($_SESSION['update_team_msg'])){
        $message =$_SESSION['update_team_msg'];
        $class= "info";
    }
    else {
        $message = null;
    }

    //destroy session;
    session_destroy();
    //include files to get variables required to connect to database
	require_once (dirname(__FILE__) . "/shared/connect.php");

    //Select statement to get all teams
    $sql ='SELECT * FROM tblteams';

    //prepare sql statement
    $sth=$dbh->prepare($sql);

    //execute statement
    $sth->execute();

    //fetch all the data
    $teams=$sth->fetchAll();

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
                    <li><a href="new_team.php" title="Add new team here">Add Team</a></li>
                    <li ><a href="new_player.php" title="Add new Player here">Add player</a></li>
                    <li class="active"><a href="teams.php" title="View all Team here">View Team</a></li>
                </ul>
            </div>
        </nav>
    </div>

    <!--THIS IS BODY PART-->
      <div class="container">
        <header>
          <h1 class="page-header">All Teams</h1>
        </header>
          <?php if ($message != null) {?>
            <div class="alert alert-<?=$class;?>">
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
                  <td><strong>Team Name</strong></td>
                </tr>
              </thead>
              <tbody>
                <?php $i =1;?> <!--THIS IS NEW VARIABLE TO DISPLAY INDEX-->
                <?php foreach ($teams as $team): ?>
                  <tr>
                      <td><?=$i;$i++;?></td> <!--DISPLAY INDEX AND THAN INCREAMENT IT -->

                      <!--DISPLAY ALL TEAMS DETAILS-->
                    <td><strong><a href="players.php?id=<?=$team['team_id']?>" > <?= htmlspecialchars($team['team_name']) ?></a></strong></td>
                      <td><a href="update_team_name.php?id=<?= $team['team_id']?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                              Update</a></td>
                      <td><a href="delete_team.php?id=<?= $team['team_id']?>"><i class="fa fa-trash-o" aria-hidden="true"></i>
                              Delete</a></td>
                  </tr>
                <?php endforeach ?>
              </tbody>
            </table>
          <?php else: ?>

              <!--IF THERE IS NO ANY DATA AVAILABLE-->
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
