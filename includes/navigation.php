<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<a class="navbar-brand" href="./">WU Control Panel</a>
	</div>
	
	<ul class="nav navbar-top-links navbar-right">

		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-bell fa-fw"></i> <i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu dropdown-alerts">
				
			</ul>
		</li>
		<li class="dropdown">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
			</a>
			<ul class="dropdown-menu dropdown-user">
				<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a></li>
				<li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a></li>
				<li class="divider"></li>
				<?php 
					if(!isset($_SESSION['steamid'])) {
						echo('<li><a href="?login"><i class="fa fa-sign-in fa-fw"></i> Sign In</a></li>');
					} else {
						echo('<li><a href="?logout"><i class="fa fa-sign-out fa-fw"></i> Sign Out</a></li>');
					}
				?>
			</ul>
		</li>
	</ul>
	
	<div class="navbar-default sidebar" role="navigation">
		<div class="sidebar-nav navbar-collapse">
			<ul class="nav" id="side-menu">
				<li>
					<a href="./"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
				</li>
				<?php if ($wurmPower >= $view_players) { ?>
				<li>
					<a href="players.php"><i class="fa fa-users fa-fw"></i> Players</a>
				</li>
				<?php } if ($wurmPower >= $view_villages) { ?>
				<li>
					<a href="villages.php"><i class="fa fa-home fa-fw"></i> Villages</a>
				</li>
				<?php } if ($wurmPower >= $view_map) { ?>
				<li>
					<a href="map.php"><i class="fa fa-map-marker fa-fw"></i> Map</a>
				</li>
				<?php } if ($wurmPower >= $view_admin) { ?>
				<li>
					<a href="admin.php"><i class="fa fa-server fa-fw"></i> Admin</a>
				</li>
				<?php } ?>
			</ul>
		</div>
	</div>
</nav>