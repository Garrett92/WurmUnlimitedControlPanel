<?php require "includes/rmi-functions.php"; ?>
<?php require "includes/header.php"; ?>
<?php require "includes/navigation.php"; ?>

<div id="page-wrapper">
	<br>
	<div class="row">
		<?php
		if ($wurmPower >= $view_players) {
			if ($wurmPower >= $view_players_list) {
				require "includes/players/playerlist.php";
			}
			if ($wurmPower >= $view_players_summary) {
				require "includes/players/playersummary.php";
			}
		} else {
			echo("<b>Sorry, you do not have access to view players.php</b>");
		}
		?>
	</div>
</div>

<?php require "includes/footer.php"; ?>