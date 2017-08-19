<div class="col-lg-<?php $ret = isset($_POST['playerID']) ? 6 : 12; echo($ret) ?> ">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="g-table" style="width:100%;">
						<div class="g-table-row">
							<div class="g-table-cell" align="left">
								Players
							</div>
							<div class="g-table-cell" align="right">
								<form action="" method="post">
									<?php foreach ($_POST as $key => $value) { if ($key != "search") echo('<input type="hidden" name="'.$key.'" value="'.$value.'" />'); } ?>
									<input type="text" name="search" placeholder="Search..." size="30" style="padding: 0px; font-size: 12px;">
									<button class="btn btn-xs btn-default">
										<i class="fa fa-search"></i>
									</button>
								</form>
							</div>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="g-table" style="width:100%;">
						<div class="g-table-row">
							<div class="g-table-cell">
								<form action="" method="post">
									<?php foreach ($_POST as $key => $value) { if ($key == "page" || $key == "max" || $key == "playerID") echo('<input type="hidden" name="'.$key.'" value="'.$value.'" />'); } ?>
									<button class="btn btn-xs btn-warning <?php if (!isset($_POST["filter"]) || $_POST["filter"] == "all") echo("active"); ?>" name="filter" value="all">All</button>
									<button class="btn btn-xs btn-warning <?php if (isset($_POST["filter"]) && $_POST["filter"] == "online") echo("active"); ?>" name="filter" value="online">Online</button>
									<button class="btn btn-xs btn-warning <?php if (isset($_POST["filter"]) && $_POST["filter"] == "recent") echo("active"); ?>" name="filter" value="recent">Recent</button>
								</form>
							</div>
							<div class="g-table-cell" align="right">
								<form action="" method="post">
									<?php foreach ($_POST as $key => $value) { if ($key == "filter" || $key == "page" || $key == "playerID") echo('<input type="hidden" name="'.$key.'" value="'.$value.'" />'); } ?>
									<small>Show 
									<select name="max" onchange="this.form.submit()">
    									<option value="10"<?php if (!isset($_POST["max"]) || $_POST["max"] == "10") echo(' selected="selected"'); ?>>10</option>
    									<option value="25"<?php if (isset($_POST["max"]) && $_POST["max"] == "25") echo(' selected="selected"'); ?>>25</option>
    									<option value="50"<?php if (isset($_POST["max"]) && $_POST["max"] == "50") echo(' selected="selected"'); ?>>50</option>
    									<option value="100"<?php if (isset($_POST["max"]) && $_POST["max"] == "100") echo(' selected="selected"'); ?>>100</option>
  									</select> 
  									players</small>
								</form>
							</div>
						</div>
					</div>
					<table id="custom_table">
						<tbody>
							<tr>
								<?php
								
								$playerArray = getRecentPlayers("999999999999999999");
								
								function sortByName($a, $b) {
									return ($a[1][0] > $b[1][0]);
								}
								
								usort($playerArray, 'sortByName');
                                
                                $save = array();
                                
                                foreach ($playerArray as $k => $player) {
                                    if (isset($_POST["search"])) {
                                    	if (($_POST["search"] != '') && strpos(strtolower($player[1][0]), strtolower($_POST["search"])) === FALSE) {
                                            continue;
                                        }
                                    }
    
                                    if (! isset($_POST["filter"]) || $_POST["filter"] == "all")
                                        $show = TRUE;
                                    else
                                        $show = FALSE;
                                    
                                    $timeLength = "Last Online: Unknown";
                                    $buttonColor = "btn-primary";
                                    $buttonIcon = "fa-user";
                                    if (isset($player[1])) {
                                    	$time = $player[1][1];
                                    	$timeCalc = strtotime("-".$time." seconds");
                                    	if ($player[1][2] == "TRUE") {
                                            // player is online
                                            if (! $show && ($_POST["filter"] == "online" || $_POST["filter"] == "recent")) {
                                                $show = TRUE;
                                            }
                                            $timeLength = "Online for " . time_elapsed_string('@' . $timeCalc);
                                            $buttonColor = "btn-success";
                                        } else {
                                            // player is offline
                                        	$timeLength = "Offline for " . time_elapsed_string('@' . $timeCalc);
                                            if ($time < 86400) {
                                                // offline for less than 1 day
                                                if (! $show && ($_POST["filter"] == "recent")) {
                                                    $show = TRUE;
                                                }
                                                $buttonColor = "btn-info";
                                            } else if ($time < 604800) {
                                                // offline for less than 1 week
                                            } else if ($time < 2592000) {
                                                // offline for less than 1 month
                                            } else {
                                                // offline for greater than 1 month
                                            }
                                        }
                                    }
                                    if ($show) {
                                    	$clToLoad = "<br><br>- <b><small>DOUBLE CLICK TO LOAD</small></b> -";
                                        $onDblClick = 'ondblclick="this.form.submit()"';
                                        $hiddenForm = '<input type="hidden" name="playerID" value="' . $player[0] . '" />';
                                        if (isset($_POST["playerID"])) {
                                            if ($_POST["playerID"] == $player[0]) {
                                                //playersummary is loaded
                                                $buttonIcon = "fa-times";
                                                $onDblClick = 'onclick="this.form.submit()"';
                                                $hiddenForm = '';
                                            }
                                        }
                                        foreach ($_POST as $key => $value) {
                                        	if ($key == "filter" || $key == "page" || $key == "max")
                                                $hiddenForm = $hiddenForm . '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
                                        }
                                        if ($wurmPower < $view_players_summary) {
                                        	$clToLoad = "";
                                        	$onDblClick = "";
                                        }
                                        $shortName = strlen($player[1][0]) > 9 ? substr($player[1][0],0,9)."-" : $player[1][0];
                                        $userSaved = ('<td><form action="" method="post">' . $hiddenForm . '<center>'.
                                            '<button type="button" class="btn ' . $buttonColor . '" ' . $onDblClick . 
                                        	' data-html="true" data-toggle="popover" title="<center><b>' . $player[1][0] . '</b></center>" '.
                                            'data-placement="bottom" data-trigger="focus" '.
                                        	'data-content="<center>' . $timeLength . $clToLoad . '</center>">'.
                                            '<i class="fa ' . $buttonIcon . ' fa-4x"></i></button><br><small><b>' . $shortName . '</b></small></center></form></td>');
                                        array_push($save, $userSaved);
                                    }
                                }

                                $max = (!isset($_POST["max"])) ? '10' : $_POST["max"];
                                $page = (!isset($_POST["page"])) ? '1' : $_POST["page"];

                                $count = count($save);
                                $totalPages = ceil($count / $max);
                                if ($page > $totalPages) {
                                	$page = 1;
                                }
                                $output = array_slice($save, (($page-1)*$max), $max);
                                foreach ($output as $user) {
                                	echo ($user);
                                }

                                ?>
							</tr>
						</tbody>
					</table>
			
					<div class="g-table" style="width:100%;">
						<div class="g-table-row">
							<div class="g-table-cell" align="left"><br>
								<form action="" method="post">
									<?php 
                                    foreach ($_POST as $key => $value) { 
                                    	if ($key == "filter" || $key == "max" || $key == "playerID" || $key == "search") 
                                            echo('<input type="hidden" name="'.$key.'" value="'.$value.'" />'); 
                                    }
                                    if ($totalPages > 5 && $page > 1) {
                                        echo ('<button class="btn btn-xs btn-default" name="page" value="1"><small>&lt;&lt;</small></button>');
                                        echo ('<button class="btn btn-xs btn-default" name="page" value="'.($page-1).'"><small>PREV</small></button>');
                                    }
                                    if (($totalPages - $page) == 0) {
                                        $i = -4;
                                    } else if (($totalPages - $page) == 1) {
                                        $i = -3;
                                    } else {
                                        $i = -2;
                                    }
                                    $c = 0;
                                    while ($i < 5) {
                                        $calc = ($page + $i);
                                        if ($totalPages <= 1 || $calc > $totalPages || $c >= 5) {
                                            $i++;
                                            break;
                                        }
                                        if ($calc > 0 && $calc <= $totalPages) {
                                            if ($calc == $page)
                                                echo('<button class="btn btn-xs btn-default active" name="page" value="'.$calc.'"><small>'.$calc.'</small></button>');
                                            else
                                                echo('<button class="btn btn-xs btn-default" name="page" value="'.$calc.'"><small>'.$calc.'</small></button>');
                                            $c++;
                                        }
                                        $i++;
                                    }
                                    if ($totalPages > 5 && $page < $totalPages) {
                                        echo ('<button class="btn btn-xs btn-default" name="page" value="'.($page+1).'"><small>NEXT</small></button>');
                                        echo ('<button class="btn btn-xs btn-default" name="page" value="'.$totalPages.'"><small>&gt;&gt;</small></button>');
                                    }
                                    ?>
								</form>
							</div>
						</div>
					</div>	
				</div>		
			</div>
		</div>