<?php require "includes/rmi-functions.php"; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>jQuery UI Autocomplete - Default functionality</title>
  <style>
	.autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
	.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
	.autocomplete-selected { background: #F0F0F0; }
	.autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
	.autocomplete-group { padding: 2px 5px; }
	.autocomplete-group strong { display: block; border-bottom: 1px solid #000; }
  </style>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="dist/js/jquery.autocomplete.min.js"></script>
  <script>
  <?php require "includes/players/js/itemList.php"; ?>
  </script>
</head>
<body>
 
<div class="ui-widget">
  <label>Tags: </label>
  <input id="autoItems">
</div>
 
 
</body>
</html>