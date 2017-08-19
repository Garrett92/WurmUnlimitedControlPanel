$( function() {
    var availableItems = [
    
<?php
$allItems = getItemListForSearch();
for($i = 0; $i < count($allItems); ++$i) {
	echo("\t{value:'".$allItems[$i][1]."',data:'".$allItems[$i][0]."'}");
	if ($i != (count($allItems)-1)) {
		echo(",\n");
	}
}
?>

    ];
    $( "#autoItems" ).autocomplete({
		lookup: availableItems,
		triggerSelectOnValidInput: false,
		autoSelectFirst: true,
		onSelect: function (suggestion) {
			document.getElementById("autoFill").value = suggestion.data;
        	//alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
    	}
    });
  } );