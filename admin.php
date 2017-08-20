<?php require "includes/rmi-functions.php"; ?>
<?php require "includes/header.php"; ?>
<?php require "includes/navigation.php"; ?>

<div id="page-wrapper">
	<br>
	<div class="row">
		<?php
		if ($wurmPower >= $view_admin) {
			if (isset($_GET["steamlookup"])) {
		?>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">SteamID Lookup - <?php echo($_GET["steamlookup"]); ?></div>
				<div class="panel-body">
					Players linked to this SteamID:<br><br>
					<?php 
					$steamPlayers = findPlayersWithSteamID($_GET["steamlookup"]);
					foreach ($steamPlayers as $v) {
						echo($v[0] . "<br>");
					}
					?>
				</div>
			</div>
		</div>
		<?php } ?>
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">Admin Logs</div>
				<div class="panel-body">
				<?php 
				
				$getLogs = getLogs();
				if (!empty($getLogs)) {
				
					foreach($getLogs as $k => $v) {
						echo("<a href='?load=" . $v . "'>" . $v . "</a><br>");
					}
					
					if (isset($_GET["load"])) {
						echo("<br><pre>");
						$fh = fopen('logs/'.$_GET["load"],'r');
						while ($line = fgets($fh)) {
							$steamIDfound = get_string_between($line, "{", "}");
							if ($steamIDfound != "") {
								echo("<a href='?load=" . $_GET["load"] . "&steamlookup=" . $steamIDfound . "'>" . $line . "</a>");
							} else {
								echo($line);
							}
						}
						echo("</pre>");
						fclose($fh);
					}
				
				} else {
					echo("No log files have been created!");
				}
				
				?>
				</div>
			</div>
		</div>
		<?php
		} else {
			echo("<b>Sorry, you do not have access to view admin.php</b>");
		}
		?>
	</div>
</div>

<?php require "includes/footer.php"; ?>