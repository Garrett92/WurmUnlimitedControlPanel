<?php
if (isset($_POST["playerID"])) {
	
	if (isset($_POST["changePowerSubmit"]) && $wurmPower >= $admin_changePower) {
		$setOutput = '<br><br><b>You have changed the players power level</b><br>RMI Output:<br>' . sendCommand("changePower?".$_POST["playerID"]."&".$_POST["changePowerLevel"], true)[0]."<br><br>";
	}else if (isset($_POST["giveItemSubmit"]) && $wurmPower >= $admin_giveItem) {
		$setOutput = '<br><br><b>Items have been added to the players inventory</b><br>RMI Output:<br>' . sendCommand("giveItem?".$_POST["playerID"]."&".$_POST["itemTemplateID"]."&".$_POST["itemQuality"]."&".$_POST["itemRarity"]."&".$_POST["itemCreator"]."&".$_POST["itemAmount"], true)[0]."<br><br>";
	}else if (isset($_POST["giveMoneySubmit"]) && $wurmPower >= $admin_giveMoney) {
		$setOutput = '<br><br><b>You have added money to the players bank</b><br>RMI Output:<br>' . sendCommand("addMoneyToBank?".$_POST["giveMoneyName"]."&".$_POST["playerID"]."&".$_POST["giveMoneyAmount"], true)[0]."<br><br>";
	}else if (isset($_POST["removeMoneySubmit"]) && $wurmPower >= $admin_removeMoney) {
		$setOutput = '<br><br><b>You have removed money from the players bank</b><br>RMI Output:<br>' . sendCommand("chargeMoney?".$_POST["removeMoneyName"]."&".$_POST["removeMoneyAmount"], true)[0]."<br><br>";
	}else if (isset($_POST["banPlayerSubmit"]) && $wurmPower >= $admin_banPlayer) {
		$setOutput = '<br><br><b>You have banned the player</b><br>RMI Output:<br>' . sendCommand("banPlayer?".$_POST["banPlayerName"]."&".$_POST["banPlayerReason"]."&".$_POST["banPlayerDays"], true)[0]."<br><br>";
		sendCommand("kickPlayer?".$_POST["playerID"]."&".$_POST["banPlayerReason"], true);
	}else if (isset($_POST["unbanPlayerSubmit"]) && $wurmPower >= $admin_unbanPlayer) {
		$setOutput = '<br><br><b>You have unbanned the player</b><br>RMI Output:<br>' . sendCommand("pardonBan?".$_POST["unbanPlayerName"], true)[0]."<br><br>";
	}
	
	$playerInfo = getPlayerSummary($_POST["playerID"]);
	$currentPower = sendCommand("getPower?".$_POST["playerID"])[0];
	$currentlyOnline = isset($playerInfo["Coord x"]);
	
?>

<script src="dist/js/jquery.autocomplete.min.js"></script>
<script><?php require "includes/players/js/itemList.php"; ?></script>
<script>

	function resetDivs() {
		document.getElementById('changePowerDiv').style.display = 'none';
		document.getElementById('giveItemDiv').style.display = 'none';
		document.getElementById('giveMoneyDiv').style.display = 'none';
		document.getElementById('removeMoneyDiv').style.display = 'none';
		document.getElementById('banPlayerDiv').style.display = 'none';
		document.getElementById('unbanPlayerDiv').style.display = 'none';
	}

	function showResult(e) {
		resetDivs();
		var btnName = e.textContent || e.innerText;
		switch (btnName) {
		case "Change Power":
			document.getElementById('changePowerDiv').style.display = 'block';
			break;
		case "Give Item":
			document.getElementById('giveItemDiv').style.display = 'block';
			break;
		case "Give Money":
			document.getElementById('giveMoneyDiv').style.display = 'block';
			break;
		case "Remove Money":
			document.getElementById('removeMoneyDiv').style.display = 'block';
			break;
		case "Ban Player":
			document.getElementById('banPlayerDiv').style.display = 'block';
			break;
		case "Unban Player":
			document.getElementById('unbanPlayerDiv').style.display = 'block';
			break;
		}
	}
</script>

	<div class="col-lg-6">
		<div class="panel panel-default">
			<div class="panel-heading"><?php if (isset($playerInfo["Name"])) echo("<b>" . $playerInfo["Name"] . "</b> - Current Power: " . $currentPower); else echo("Player not found"); ?></div>
			<div class="panel-body">
				<p align="center">
					<?php 
						if ($wurmPower >= $admin_changePower && $currentlyOnline) {
							echo('<button type="button" class="btn btn-primary btn-sm" onclick="showResult(this)">Change Power</button> ');
						}
						if ($wurmPower >= $admin_giveItem && $currentlyOnline) {
							echo('<button type="button" class="btn btn-primary btn-sm" onclick="showResult(this)">Give Item</button> ');
						}
						if ($wurmPower >= $admin_giveMoney) {
							echo('<button type="button" class="btn btn-primary btn-sm" onclick="showResult(this)">Give Money</button> ');
						}
						if ($wurmPower >= $admin_removeMoney) {
							echo('<button type="button" class="btn btn-primary btn-sm" onclick="showResult(this)">Remove Money</button> ');
						}
						if ($playerInfo["Banned"] == "false" && $wurmPower >= $admin_banPlayer) {
							echo('<button type="button" class="btn btn-primary btn-sm" onclick="showResult(this)">Ban Player</button> ');
						} else if ($wurmPower >= $admin_unbanPlayer) {
							echo('<button type="button" class="btn btn-primary btn-sm" onclick="showResult(this)">Unban Player</button> ');
						}
						
						if (isset($setOutput)) {
							echo($setOutput);
						}
					?>
				</p>
				<div id="unbanPlayerDiv" align="center">
					<form action="" method="post" onsubmit="return confirm('Are you sure you want to unban <?php echo($playerInfo["Name"]); ?>?')">
						<?php 
						foreach ($_POST as $key => $value) {
							if ($key == "filter" || $key == "max" || $key == "page" || $key == "playerID" || $key == "search") {
								echo('<input type="hidden" name="'.$key.'" value="'.$value.'" />');
							}
						}
						?>
						<input type="hidden" name="unbanPlayerName" value="<?php echo($playerInfo["Name"]); ?>" />
			 			<button name="unbanPlayerSubmit" type="submit" class="btn btn-danger btn-sm">Unban <?php echo($playerInfo["Name"]); ?></button>
		 			</form>
				</div>
				<div id="banPlayerDiv" align="center">
					<form action="" method="post" onsubmit="return confirm('Are you sure you want to ban <?php echo($playerInfo["Name"]); ?>?')">
						<?php 
						foreach ($_POST as $key => $value) {
							if ($key == "filter" || $key == "max" || $key == "page" || $key == "playerID" || $key == "search") {
								echo('<input type="hidden" name="'.$key.'" value="'.$value.'" />');
							}
						}
						?>
						<input type="hidden" name="banPlayerName" value="<?php echo($playerInfo["Name"]); ?>" />
						<label>Reason for ban</label> (max length 100 chars)<br>
			 			<input type="text" name="banPlayerReason" maxlength="100"><br><br>
						<label>How many days?</label><br>
			 			<input type="text" name="banPlayerDays" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="4"><br><br>
			 			<button name="banPlayerSubmit" type="submit" class="btn btn-danger btn-sm">Ban <?php echo($playerInfo["Name"]); ?></button>
		 			</form>
				</div>
				<div id="removeMoneyDiv" align="center">
					<form action="" method="post" onsubmit="return confirm('Are you sure you want to remove money from <?php echo($playerInfo["Name"]); ?>?')">
						<?php 
						foreach ($_POST as $key => $value) {
							if ($key == "filter" || $key == "max" || $key == "page" || $key == "playerID" || $key == "search") {
								echo('<input type="hidden" name="'.$key.'" value="'.$value.'" />');
							}
						}
						?>
						<input type="hidden" name="removeMoneyName" value="<?php echo($playerInfo["Name"]); ?>" />
			 			<label>Current Money</label><br>
			 			<input type="text" name="currentAmount" value="<?php echo(getMoneyString($playerInfo["Money in bank"])); ?>" disabled><br><br>
			 			<label>Amount to remove in iron</label> (10000 = 1 silver)<br>
			 			<input type="text" name="removeMoneyAmount" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="10"><br><br>
			 			<button name="removeMoneySubmit" type="submit" class="btn btn-secondary btn-sm">Submit</button>
		 			</form>
				</div>
				<div id="giveMoneyDiv" align="center">
					<form action="" method="post" onsubmit="return confirm('Are you sure you want to give money to <?php echo($playerInfo["Name"]); ?>?')">
						<?php 
						foreach ($_POST as $key => $value) {
							if ($key == "filter" || $key == "max" || $key == "page" || $key == "playerID" || $key == "search") {
								echo('<input type="hidden" name="'.$key.'" value="'.$value.'" />');
							}
						}
						?>
						<input type="hidden" name="giveMoneyName" value="<?php echo($playerInfo["Name"]); ?>" />
			 			<label>Current Money</label><br>
			 			<input type="text" name="currentAmount" value="<?php echo(getMoneyString($playerInfo["Money in bank"])); ?>" disabled><br><br>
			 			<label>Amount to add in iron</label> (10000 = 1 silver)<br>
			 			<input type="text" name="giveMoneyAmount" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="10"><br><br>
			 			<button name="giveMoneySubmit" type="submit" class="btn btn-secondary btn-sm">Submit</button>
		 			</form>
				</div>
				<div id="changePowerDiv" align="center">
					<form action="" method="post" onsubmit="return confirm('Are you sure you want to change the power level for <?php echo($playerInfo["Name"]); ?>?')">
						<?php 
						foreach ($_POST as $key => $value) {
							if ($key == "filter" || $key == "max" || $key == "page" || $key == "playerID" || $key == "search") {
								echo('<input type="hidden" name="'.$key.'" value="'.$value.'" />');
							}
						}
						?>
			 			<label>Current Power</label><br>
			 			<input type="text" name="currentPower" value="<?php echo($currentPower); ?>" disabled><br><br>
			 			<label>Power Level</label><br>
			 			<input type="text" name="changePowerLevel" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="1"><br><br>
			 			<button name="changePowerSubmit" type="submit" class="btn btn-secondary btn-sm">Submit</button>
		 			</form>
	 			</div>
				<div id="giveItemDiv" align="center">
					<form action="" method="post" onsubmit="return confirm('Are you sure you want to give an item to <?php echo($playerInfo["Name"]); ?>?')">
						<?php 
						foreach ($_POST as $key => $value) {
							if ($key == "filter" || $key == "max" || $key == "page" || $key == "playerID" || $key == "search") {
								echo('<input type="hidden" name="'.$key.'" value="'.$value.'" />');
							}
						}
						?>
						<label>Item Search</label><br>
			 			<input id="autoItems"><br><br>
			 			<label>Item Template ID</label>
			 			(Use item search)<br>
			 			<input id="autoFill" type="text" name="itemTemplateID" readonly="readonly"><br><br>
			 			<label>Item Quality</label><br>
			 			<input type="text" name="itemQuality" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="2"><br><br>
			 			<label>Item Rarity</label><br>
			 			<select name="itemRarity">
			 				<option value="0">Normal</option>
							<option value="1">Rare</option>
							<option value="2">Supreme</option>
							<option value="3">Fantastic</option>
			 			</select><br><br>
			 			<label>Item Amount</label><br>
			 			<input type="text" name="itemAmount" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="2"><br><br>
			 			<label>Creator Name</label><br>
			 			<input type="text" name="itemCreator" maxlength="40"><br><br>
			 			<button name="giveItemSubmit" type="submit" class="btn btn-secondary btn-sm">Submit</button>
		 			</form>
	 			</div>
	 			<?php
                        echo ("<pre>PlayerSummary ");
                        print_r($playerInfo);
                        echo ("</pre>");
                        $playerSkills = getPlayerSkills($_POST["playerID"]);
                        echo ("<pre>PlayerSkills ");
                        print_r($playerSkills);
                        echo ("</pre>");
                ?>
			</div>
		</div>
	</div>
	
	<script>
		resetDivs();
	</script>
	
<?php
}
?>