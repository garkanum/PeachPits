<title>PeachPits - Matches</title>
<?php 
	/*********************
    Allows event admins to create and edit matches
    **********************/
	include dirname(__DIR__) . "/header.php";
	 
	if(loggedOn()) {
    	include "menu.php";
        $event = $currentEvent . "_matches";
?>
<head><script src="admin/js/manageMatches.js"></script></head>

		<div class="col-md-10 container-dashboard-content">
			<div class="dashboard-toolbar">
				<div class="container-fluid text-center">
					<button id="addMatch" class="btn btn-default">Add a Match</button>
					<a href="#" id="populate" class="btn btn-default" data-toggle="modal">Auto Fill Matches</a>
				</div>
			</div>
			<div class="container-add text-center">
				<form class="form-inline" action="admin/add_match?event=<?php echo $currentEvent; ?>" method="post">
					<input type="text" name="matchid" id="matchid" class="form-control" style="width:100px;" placeholder="Match Id">
					<input type="text" name="matchnumber" id="matchnumber" class="form-control" style="width:80px;" placeholder="Match #">
					<input type="text" name="setnumber" id="setnumber" class="form-control" style="width:80px;" placeholder="Set #">
					<input type="text" name="starttime" id="starttime" class="form-control" style="width:120px;" placeholder="Start Time">
					<?php $sql = $mysqli->query("SELECT t.teamid FROM `".$currentEvent."_teams` AS e, teams AS t WHERE e.teamid = t.teamid ORDER BY `teamid` ASC") ?>
					Red 1: <select name="red1" id="red1" class="form-control">
								<?php while($row = mysqli_fetch_array($sql, MYSQLI_BOTH)){ echo "<option>". $row['teamid'] ."</option>"; } ?>
								</select>
					<?php $sql = $mysqli->query("SELECT t.teamid FROM `".$currentEvent."_teams` AS e, teams AS t WHERE e.teamid = t.teamid ORDER BY `teamid` ASC") ?>
					Red 2: <select name="red2" id="red2" class="form-control">
								<?php while($row = mysqli_fetch_array($sql, MYSQLI_BOTH)){ echo "<option>". $row['teamid'] ."</option>"; } ?>
								</select>
					<?php $sql = $mysqli->query("SELECT t.teamid FROM `".$currentEvent."_teams` AS e, teams AS t WHERE e.teamid = t.teamid ORDER BY `teamid` ASC") ?>
					Red 3: <select name="red3" id="red3" class="form-control">
								<?php while($row = mysqli_fetch_array($sql, MYSQLI_BOTH)){ echo "<option>". $row['teamid'] ."</option>"; } ?>
								</select>
					<?php $sql = $mysqli->query("SELECT t.teamid FROM `".$currentEvent."_teams` AS e, teams AS t WHERE e.teamid = t.teamid ORDER BY `teamid` ASC") ?>
					Blue 1: <select name="blue1" id="blue1" class="form-control">
								<?php while($row = mysqli_fetch_array($sql, MYSQLI_BOTH)){ echo "<option>". $row['teamid'] ."</option>"; } ?>
								</select>
					<?php $sql = $mysqli->query("SELECT t.teamid FROM `".$currentEvent."_teams` AS e, teams AS t WHERE e.teamid = t.teamid ORDER BY `teamid` ASC") ?>
					Blue 2: <select name="blue2" id="blue2" class="form-control">
								<?php while($row = mysqli_fetch_array($sql, MYSQLI_BOTH)){ echo "<option>". $row['teamid'] ."</option>"; } ?>
								</select>
					<?php $sql = $mysqli->query("SELECT t.teamid FROM `".$currentEvent."_teams` AS e, teams AS t WHERE e.teamid = t.teamid ORDER BY `teamid` ASC") ?>
					Blue 3: <select name="blue3" id="blue3" class="form-control">
								<?php while($row = mysqli_fetch_array($sql, MYSQLI_BOTH)){ echo "<option>". $row['teamid'] ."</option>"; } ?>
								</select>
					Match Type: <select name="matchtype" class="form-control">
						<option>Qualification Match</option>
						<option>Quarterfinals</option>
						<option>Semifinals</option>
						<option>Finals</option>
					</select>
					<input type="hidden" name="auto" value="false">
					<input type="hidden" name="eventid" value="<?php echo $currentEvent; ?>">
					<button type="submit" class="btn btn-default" name="submit">Add</button>
					<a id="addMatch_cancel" href="#" class="btn btn-default btn-add-cancel">Cancel</a>
				</form>
			</div>
			<div class="dashboard-content">
                <div id="tables-matches" class="table-responsive">
                    <table id="table-team-matches" class="table table-hover">
			            <?php 
                        //Goes to the databse and fetches all matches in order
                        $sql = $mysqli->query("SELECT * FROM `".$event."` WHERE `matchtype` LIKE 'qm' ORDER BY matchnumber ASC");
                        echo '<thead>';
                        echo '  <td class="text-center"><b>Match #</b></td>';
                        echo '  <td class="text-center"><b>Start Time</b></td>';
                        echo '  <td class="text-center"><b>Red 1</b></td>';
                        echo '  <td class="text-center"><b>Red 2</b></td>';
                        echo '  <td class="text-center"><b>Red 3</b></td>';
                        echo '  <td class="text-center"><b>Red 1</b></td>';
                        echo '  <td class="text-center"><b>Red 2</b></td>';
                        echo '  <td class="text-center"><b>Red 3</b></td>';
                        echo '  <td class="text-center"><b>Pit</b></td>';
                        echo '</thead>';
                        while($row = mysqli_fetch_array($sql, MYSQLI_BOTH)){
                            echo "<tr id='". $row['matchid'] ."'>";
                            echo "<td style='width:8%; padding-left: 15px;' class='text-center' id='matchnumber'>". $row['matchnumber'] ."</td>";
                            echo "<td class='text-center' id='starttime'>". $row['start'] ."</td>";
                            echo "<td id='red1' class='red text-center'>". $row['red1'] ."</td>";
                            echo "<td id='red2' class='red text-center'>". $row['red2'] ."</td>";
                            echo "<td id='red3' class='red text-center'>". $row['red3'] ."</td>";
                            echo "<td id='blue1' class='blue text-center'>". $row['blue1'] ."</td>";
                            echo "<td id='blue2' class='blue text-center'>". $row['blue2'] ."</td>";
                            echo "<td id='blue3' class='blue text-center'>". $row['blue3'] ."</td>";
                            echo "<td class='text-center'><a href='#' class='edit' data-toggle='modal' data-target='#editMatch'>Edit</a>";
                        }	
                        ?>
		            </table>
		            <table id="table-team-matches-mobile" class="table">
			            <?php 
                        //Goes to the databse and fetches all matches in order
                        $sql = $mysqli->query("SELECT * FROM `".$event."` WHERE `matchtype` LIKE 'qm' ORDER BY matchnumber ASC");
                        echo '<thead>';
                        echo   '<tr>';
                        echo     '<td rowspan="2" style="vertical-align:middle"><b>Match</b></td>';
                        echo     '<td rowspan="2" class="text-center" style="vertical-align:middle"><b>Time</b></td>';
                        echo     '<td colspan="3" class="text-center"><b>Driver\'s Station</b></td>';
                        echo     '<td rowspan="2" rowclass="text-center" class="text-center" style="vertical-align:middle"><b>Pit</b></td>';
                        echo   '</tr>';
                        echo   '<tr>';
                        echo     '<td class="text-center"><b>1</b></td>';
                        echo     '<td class="text-center"><b>2</b></td>';
                        echo     '<td class="text-center"><b>3</b></td>';
                        echo   '</tr>';
                        echo '</thead>';
                        while($row = mysqli_fetch_array($sql, MYSQLI_BOTH)){
                            echo "<tr id='". $row['matchid'] ."'>";
                            echo "<td rowspan='2' style='width:8%; padding-left: 15px; vertical-align:middle;' class='text-left' id='matchnumber'>". $row['matchnumber'] ."</td>";
                            echo "<td rowspan='2' 'class='text-center' style='vertical-align:middle' id='starttime'>". $row['start'] ."</td>";
                            echo "<td id='red1' class='red text-center'>". $row['red1'] ."</td>";
                            echo "<td id='red2' class='red text-center'>". $row['red2'] ."</td>";
                            echo "<td id='red3' class='red text-center'>". $row['red3'] ."</td>";
                            echo "<td rowspan='2' style='vertical-align:middle;' class='text-center'><a href='#' class='edit' data-toggle='modal' data-target='#editMatch'>Edit</a>";
                            echo "</tr>";
                            echo "<tr id='". $row['matchid'] ."'>";
                            echo "<td id='blue1' class='blue text-center'>". $row['blue1'] ."</td>";
                            echo "<td id='blue2' class='blue text-center'>". $row['blue2'] ."</td>";
                            echo "<td id='blue3' class='blue text-center'>". $row['blue3'] ."</td>";
                            echo "</tr>";
                        }	
                        ?>
		            </table>
	            </div>
			</div>
		</div>
	</div>
</div>	

<!-- Popup for editing an existing match -->
<div class="modal fade" id="editMatch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Match Info</h4>
      </div>
      <div class="modal-body text-center">
        <form action="admin/edit_match?event=<?php echo $currentEvent; ?>" method="post">
            <b>Match Number: </b><p id="matchnumbermodal"></p>
			<input type="text" name="starttime" id="starttimemodal" class="form-control" placeholder="Start Time"><br/>
			<input type="text" name="red1" id="red1modal" class="form-control" placeholder="Red Team 1"><br/>
			<input type="text" name="red2" id="red2modal" class="form-control" placeholder="Red Team 2"><br/>
			<input type="text" name="red3" id="red3modal" class="form-control" placeholder="Red Team 3"><br/>
			<input type="text" name="blue1" id="blue1modal" class="form-control" placeholder="Blue Team 1"><br/>
			<input type="text" name="blue2" id="blue2modal" class="form-control" placeholder="Blue Team 2"><br/>
			<input type="text" name="blue3" id="blue3modal" class="form-control" placeholder="Blue Team 3"><br/>
			<input type="hidden" name="matchid" id="matchidmodal">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-default" name="submit">Edit</button></form>
      </div>
    </div>
  </div>
</div>		
	
	
<?php 
	} else { echo '<script>document.location.href="signin"</script>'; }
	
	include dirname(__DIR__) . "/footer.php"; 
?>