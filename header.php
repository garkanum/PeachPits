<?php 
    /*********************
    This file must be included at the top of each page
    **********************/
    require_once (dirname(__FILE__) .  "/includes/session.php");
    
    global $sessionEmail;
    
    if (isset($_SESSION['email'])){
        $sessionEmail = $_SESSION['email'];
    }
    
    error_reporting(0);
    $filePath = "http://" . $_SERVER['SERVER_NAME'] . "/peachpits/";
    $currentEvent = $_GET['event'];
    
    //Fetch some general information about the user from the database for later use
    $sql = $mysqli->query("SELECT * FROM `users` WHERE `email`='$sessionEmail'");
    $row = mysqli_fetch_assoc($sql);
    
    $firstname = $row['firstname'];
    $lastname = $row['lastname'];
    $superRole = $row['role'];
    $events = $row['events'];
    $eventsArr = explode(';', $events);

    if($currentEvent != '' && isset($_SESSION['email'])){
        $sqlEvents = $mysqli->query("SELECT * FROM `events` WHERE `eventid` = '$currentEvent'");
        $rowEvents = mysqli_fetch_assoc($sqlEvents);
        //$index = in_array('Event', $eventsArr);
        foreach($eventsArr as $index => $string) {
            if (strpos($string, $rowEvents['eventname']) !== FALSE){
                $index;
                break;
            }
        }
        $str = $eventsArr[$index];
        $arr = explode('@',$str);
        $role = $arr[0];
    }
    else if ($currentEvent == '' && isset($_SESSION['email'])){
        $role = 'None selected';
    }
    
    if(($role == 'No Event' || $role == 'None selected') && $superRole == 'Super Admin'){
        $role = 'Super Admin';
    }
    
    //Checks if a user is a super admin
    function isSuperAdmin($role){
        if($role == "Super Admin"){
            return true;
        }
    }    
    //Checks if a user is an event admin
    function isEventAdmin($role){
        if($role == "Event Admin"){
            return true;
        }
    }  
    //Checks if a user is a lead inspector
    function isLeadInspector($role){
        if($role == "Lead Inspector"){
            return true;
        }
    }
    //Checks if a user is an inspector
    function isInspector($role){
        if($role == "Inspector"){
            return true;
        }
    }
    

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <title>PeachPits</title>
        <base href="<?php echo $filePath ?>">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/styles.css" rel="stylesheet"/>
        <link href="css/admin.css" rel="stylesheet"/>
        <link href="css/home.css" rel="stylesheet"/>
        <link href="css/map.css" rel="stylesheet"/>
        <link href="css/footer.css" rel="stylesheet" />
        <link href="css/bootstrap-sortable.css" rel="stylesheet"/>
        <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
        <script src="js/bootstrap-sortable.js"></script>
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script>var currentEvent = '<?php echo $currentEvent; ?>';</script>
        <script>
            var currentPage = document.URL;
            console.log(currentPage);
        </script>
    </head>
    <body>
    <?php 
    $actualLink = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if(strpos($actualLink, 'display.php')==false){
    ?>
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a href="index?event=<?php echo $currentEvent; ?>" class="navbar-brand">PeachPits</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse-1" style="margin-left:0px !important;">
                <ul class="nav navbar-nav navbar-right cl-effect-4">
                    <?php if (empty($currentEvent)){ ?>
                    <li class="dropdown">
                        <button data-toggle="dropdown" class="dropdown-toggle btn-dropdown-nav navbar-btn">Select an Event <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <?php 
                                $sql = $mysqli->query("SELECT * FROM `events` WHERE `eventstatus` LIKE 'Live'");
                                while($row = mysqli_fetch_array($sql, MYSQLI_BOTH)){
                                    echo '<li><a href="pitmap?event=' . $row['eventid'] . '">' . $row['eventname'] . '</a></li>';
                                }	 
                            ?>
                            <!--<li class="divider"></li>
				            <li><a href="contact" style="color:red;">Don't see your event? Click Here -REPLACE THIS-</a></li>-->
                        </ul>
                    </li>
                    <?php } else { ?>
                    <li class="dropdown">
                        <button data-toggle="dropdown" class="dropdown-toggle btn-dropdown-nav navbar-btn">
                            <?php
                                $sql = $mysqli->query("SELECT `eventname` FROM `events` WHERE `eventid` LIKE '$currentEvent'");
                                $row = mysqli_fetch_assoc($sql);
                                echo $row['eventname'];
                            ?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li class="disabled"><a href="#"><b>Current: </b><?php echo $row['eventname']; ?></a></li>
                            <li role="separator" class="divider"></li>
                            <?php 
                                $sql = $mysqli->query("SELECT * FROM `events` WHERE `eventstatus` LIKE 'Live'");
                                while($row = mysqli_fetch_array($sql, MYSQLI_BOTH)){
                                    if($row['eventid'] != $currentEvent){
                                        echo '<li><a href="pitmap?event=' . $row['eventid'] . '">' . $row['eventname'] . '</a></li>';
                                    }
                                }	 
                            ?>
                            <!--<li class="divider"></li>
				            <li><a href="" style="color:red;">Don't see your event? Click Here -REPLACE THIS-</a></li>-->
                        </ul>
                    </li>
                    <?php } ?>
                    <li><a href="teams?event=<?php echo $currentEvent; ?>">Team List</a></li>
                    <li><a href="matches?event=<?php echo $currentEvent; ?>">Match Schedule</a></li>
                    <li><a href="pitmap?event=<?php echo $currentEvent; ?>">Pit Map</a></li>
                </ul>
            </div>
        </div>      
    </nav>
<?php } ?>
<!-- Popup box for selecting an event -->
<div class="modal fade" id="event-select" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Change Your Password</h4>
      </div>
      <div class="modal-body">
    <?php
        $sqlEventsStr;
        $index = 0;
        foreach($eventsArr as $singleEvent){
            $str = $eventsArr[$index];
            $arr = explode('@',$str);
            $singleEvent = $arr[1];
            $sqlEventsStr[] = "`eventname` LIKE '".$singleEvent."'";
            $index++;
        }
        $sql = $mysqli->query("SELECT * FROM `events` WHERE " .implode(" OR ", $sqlEventsStr));
        while($row = mysqli_fetch_array($sql, MYSQLI_BOTH)){
            echo '<li><a href="admin/dashboard?event=' . $row['eventid'] . '">' . $row['eventname'] . '</a></li>';
        }
    ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-default" name="submit">Change Password</button></form>
      </div>
    </div>
  </div>
</div>