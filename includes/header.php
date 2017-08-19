<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?php $currentPage = basename($_SERVER['PHP_SELF'],'.php'); ?>
	<title>WU Control Panel - <?php echo($currentPage); ?></title>
	<link href="/dist/css/custom.css" rel="stylesheet">
	<link href="/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="/vendor/metisMenu/metisMenu.min.css" rel="stylesheet">
	<link href="/dist/css/sb-admin-2.css" rel="stylesheet">
	<link href="/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	<?php 
	if ($currentPage == "players") {
	?>
		<style>
			.autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
			.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
			.autocomplete-selected { background: #F0F0F0; }
			.autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
			.autocomplete-group { padding: 2px 5px; }
			.autocomplete-group strong { display: block; border-bottom: 1px solid #000; }
		</style>
	<?php
	}
	?>
	<script src="/vendor/jquery/jquery.min.js"></script>
	<script src="/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="/vendor/metisMenu/metisMenu.min.js"></script>
	<script src="/dist/js/sb-admin-2.js"></script>
</head>
<body>
<div id="wrapper">