<?php require "includes/rmi-functions.php"; ?>
<?php require "includes/header.php"; ?>
<?php require "includes/navigation.php"; ?>

<div id="page-wrapper">
	<br>
	<div class="row">
        <?php
        if ($wurmPower >= $view_villages) {
        	if ($wurmPower >= $view_villages_list) {
				require "includes/villages/villagelist.php";
			}
			if ($wurmPower >= $view_villages_summary) {
				require "includes/villages/villagesummary.php";
			}
		} else {
			echo("<b>Sorry, you do not have access to view players.php</b>");
		}
		?>
	</div>
</div>

<?php require "includes/footer.php"; ?>