<?php 
	require "includes/rmi-functions.php";
	require "includes/header.php"; 
	require "includes/navigation.php"; 
?>

<div id="page-wrapper">
	<br>
	<div class="row">
    	<?php 

    	if ($wurmPower >= $view_index) {
    		if ($wurmPower >= $view_index_serversummary) {
	    		require "includes/index/serverinfo.php"; 
    		}
    		if ($wurmPower >= $view_index_voter) {
	    		require "includes/index/wurmvoter.php"; 
	    	}
	    	if ($wurmPower >= $view_index_useraccounts) {
	    		require "includes/index/useraccounts.php";
	    	}
    	} else {
    		echo("<b>Sorry, you do not have access to view index.php</b>");
    	}
		?>
    </div>
</div>
<?php require "includes/footer.php"; ?>
