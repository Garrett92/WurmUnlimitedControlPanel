		<?php
        if (isset($_POST["villageID"])) {
            $villageInfo = getVillageSummary($_POST["villageID"]);
        ?>
    		<div class="col-lg-6">
    			<div class="panel panel-default">
    				<div class="panel-heading"><?php if (isset($villageInfo["Name"])) echo($villageInfo["Name"]); else echo("Village not found"); ?></div>
    				<div class="panel-body">
    					<?php
                        echo ("<pre>getDeedSummary ");
                        print_r($villageInfo);
                        echo("getPlayersForDeed ");
                        print_r(parseArray(sendCommand("getPlayersForDeed?".$_POST["villageID"]), false));
                        echo("getHistoryForDeed ");
                        print_r(parseArray(sendCommand("getHistoryForDeed?".$_POST["villageID"]."&100"), false));
                        echo ("</pre>");
                        ?>
    				</div>
    			</div>
    		</div>
		<?php
        }
        ?>