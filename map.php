<?php require "includes/rmi-functions.php"; ?>
<?php require "includes/header.php"; ?>
<?php require "includes/navigation.php"; ?>

<div id="page-wrapper">
	<br>
	<div class="row">
		<?php
		if ($wurmPower >= $view_map) {
		?>
		<div class="col-lg-12">
			<iframe src="<?php echo($mapLocation); ?>" style="height: 85vh;" width="100%"></iframe>
		</div>
		<?php
		} else {
			echo("<b>Sorry, you do not have access to view map.php</b>");
		}
		?>
	</div>
</div>

<?php require "includes/footer.php"; ?>