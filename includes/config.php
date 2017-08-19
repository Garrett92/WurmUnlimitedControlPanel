<?php 

	/*
	 * RMI Tool address - https://github.com/Garrett92/WurmWebRMI
	 */
	$RMI_ADDRESS = "localhost:8080";

	/*
	 * Default timezone -- available options found here: http://php.net/manual/en/timezones.php
	 */
	date_default_timezone_set('America/Los_Angeles');
	
	/*
	 * Require steam login to access the control panel - true: kicks user to login.php if they are not logged in
	 * IMPORTANT: BE SURE TO SETUP YOUR STEAM API INFORMATION AT 'includes/steamauth/SteamConfig.php'
	 */
	$requireSteamLogin = false; //even if users are not logged in, they will have an access power of 0.
	
	/*
	 * Map Location - creates an iframe with the source set to the specified location
	 */
	$mapLocation = "/map/index.php";
	
	/*
	 * wurm-unlimited.com voting options
	 */
	$wurmUnlimitedVoterEnabled = false; //set to false to disable (this may cause a few second delay to load information from their webserver)
	$alwaysShowVoting = false; //false will hide banner if user has already voted for the day
	$voteServerID = "0000"; //Server ID on wurm-unlimited.com
	$voteapikey = ""; //API key from wurm-unlimited.com (https://wurm-unlimited.com/server/SERVERID/api/)
	$voteBannerLink = "https://wurm-unlimited.com/server/".$voteServerID."/"; //leave this - links to your wurm-unlimited.com server page
	$voteBannerImage = $voteBannerLink."banners/regular-banner-2.png"; //only change if you want to set a custom banner image
	$voteRewardText = "1 Silver";
	$voteRewardAmountInIron = 10000; //this is the amount that will be added to the players bank account (10000 = 1 silver)
	
	/*
	 * Admin Command Levels - Pulled from the Wurm Unlimited server (User must be logged in via Steam)
	 * 0 = ALL USERS
	 * 1 = CM (Chat Moderation)
	 * 2 = GM (Player Control)
	 * 3 = High God
	 * 4 = Arch GM (Server Control)
	 * 5 = Implementor
	 * 6 = DISABLED
	 */
	//SERVER COMMANDS
	$admin_shutdown 	= 5;
	$admin_broadcast 	= 2;
	//PLAYER COMMANDS
	$admin_changePower 	= 5;
	$admin_giveItem 	= 2;
	$admin_giveMoney 	= 2;
	$admin_removeMoney 	= 2;
	$admin_banPlayer 	= 2;
	$admin_unbanPlayer 	= 2;
	
	/*
	 * Power level to view pages/specific tables
	 * (Same levels as the Admin command)
	 */
	$view_admin = 5; //ability to view the admin page (website logs / full RMI access) 
	
	$view_index = 0; //this will disable the index.php for anyone below this power level (recommend leaving it set to 0)
	$view_index_serversummary = 0; //allows the user to see the server summary (basic info - safe for all players)
	$view_index_voter = 0; //allows the user to see the vote menu (safe for all users)
	$view_index_useraccounts = 0; //allows the user to see their characters -- also used for the reward system. (Safe for all users)
	
	$view_map = 0; //ability to view the map page
	
	$view_players = 0; //ability to view the players page
	$view_players_list = 0; //ability to view all of the players on the server
	$view_players_summary = 0; //ability to view information about the player
	
	$view_villages = 0; //ability to view the villages page
	$view_villages_list = 0; //ability to view all of the villages on the server
	$view_villages_summary = 0; //ability to view information about the village
?>