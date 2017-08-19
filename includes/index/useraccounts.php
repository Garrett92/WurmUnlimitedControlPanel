		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="g-table" style="width:100%;">
						<div class="g-table-row">
							<?php if (isset($_SESSION['steamid'])) { ?>
								<div class="g-table-cell">Your Accounts</div>
								<div class="g-table-cell" align="right">Admin Level: <?php echo(findSteamIDPower($_SESSION['steamid'])); ?></div>
							<?php } else { ?>
								<div class="g-table-cell" align="center"><b>Steam Sign In</b></div>
							<?php } ?>
						</div>
					</div>
				</div>
					<div class="panel-body">
					<?php if (isset($_SESSION['steamid'])) { ?>
    					<table id="custom_table">
    						<tbody>
    							<tr>
								<?php
								
								if (isset($_POST["characterNameCreation"])) {
									$playerArray = findPlayersWithSteamID($_SESSION['steamid']);
									if (count($playerArray) === 0) {
										$characterName = htmlentities(trim($_POST["characterNameCreation"]));
										if (ctype_alpha($characterName)) {
											error_log("Character created - Name: " . $characterName . ", SteamID: " . $_SESSION['steamid'], 0);
											$sendCharacterRequest = parseArray(sendCommand("createPlayer?".$characterName."&".$_SESSION['steamid']."&4&1&0"), true, true);
											if ($sendCharacterRequest["PlayerId"] == -1) {
												$characterCreationError = $sendCharacterRequest["error"];
											}
										} else {
											$characterCreationError = "Please only use letters from A to Z in your name.";
										}
									} else {
										$characterCreationError = "You have already created a character!";
									}
								}
								
								$playerArray = findPlayersWithSteamID($_SESSION['steamid']);
                                asort($playerArray);
                                $save = array();
                                foreach ($playerArray as $k => $player) {
                                    $timeLength = "Last Online: Unknown";
                                    $buttonColor = "btn-primary";
                                    $buttonIcon = "fa-user";
                                    $playerInfo = getPlayerSummary($player[1]);
                                    if (isset($playerInfo["Last login"])) {
                                        $time = getWurmUnixTime($playerInfo["Last login"]);
                                        if ($time != 0) {
                                            $timeLength = "Online for " . time_elapsed_string('@' . $time);
                                            $buttonColor = "btn-success";
                                        } else {
                                            // player is offline
                                            if (isset($playerInfo["Last logout"])) {
                                                $time = getWurmUnixTime($playerInfo['Last logout']);
                                                $timeLength = "Offline for " . time_elapsed_string('@' . $time);
                                                $timeDiff = calcTimeDifference($time);
                                                if ($timeDiff < 86400) {
                                                    // offline for less than 1 day
                                                    $buttonColor = "btn-info";
                                                } else if ($timeDiff < 604800) {
                                                    // offline for less than 1 week
                                                } else if ($timeDiff < 2592000) {
                                                    // offline for less than 1 month
                                                } else {
                                                    // offline for greater than 1 month
                                                }
                                            }
                                        }
                                    }
                                    
                                    if (isset($val) && $val == 1) {
                                    	$rewardButton = "<br><button class='btn btn-primary'><b>REWARD PLAYER</b></button>";
                                    	$hiddenForm = '<input type="hidden" name="reward-playerID" value="' . $player[1] . '" />';
                                    } else {
                                    	$rewardButton = "";
                                    	$hiddenForm = "";
                                    }
                                        foreach ($_POST as $key => $value) {
                                            if ($key != "reward-playerID" && $key != "search")
                                                $hiddenForm .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
                                        }
                                        $shortName = strlen($player[0]) > 9 ? substr($player[0],0,9)."-" : $player[0];
                                        $userSaved = ('<td><form action="" method="post">' . $hiddenForm . '<center>'.
                                            '<button type="button" class="btn ' . $buttonColor . '" ' . 
                                            'data-html="true" data-toggle="popover" title="<center><b>' . $player[0] . '</b></center>" '.
                                            'data-placement="bottom" data-trigger="focus" '.
                                            'data-content="<center>' . $timeLength . '<br>'.$rewardButton.'</center>">'.
                                            '<i class="fa ' . $buttonIcon . ' fa-4x"></i></button><br><small><b>' . $shortName . '</b></small></center></form></td>');
                                        array_push($save, $userSaved);
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
                                    	if ($key != "page" && $key != "broadcast" && $key != "shutdownMessage" && $key != "cancelShutdown") {
                                            echo('<input type="hidden" name="'.$key.'" value="'.$value.'" />'); 
                                    	}
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
					
					<?php
					if (count($playerArray) === 0) {
                    ?>
						<div class="g-table" style="width:100%;">
							<div class="g-table-row">
								<div class="g-table-cell" align="center">
									Looks like you don't have any accounts on the server!
									<hr>
								</div>
							</div>
							<div class="g-table-row">
								<div class="g-table-cell" align="center">
									Would you like to create a character?<br><br>
									<form action="" method="post">
									  Player Name<br>
									  <input type="text" name="characterNameCreation" value=""><br>
									  <input type="submit" value="Submit">
									</form> 
									<?php if (isset($characterCreationError)) echo("<br><b>".$characterCreationError."</b>"); ?>
								</div>
							</div>
						</div>
					<?php
					}
					 } else { ?>
					<div class="g-table" style="width:100%;">
						<div class="g-table-row">
							<div class="g-table-cell" align="center">
							<?php
								loginbutton();
							?>
							</div>
						</div>
						<div class="g-table-row">
							<div class="g-table-cell" align="center">
							Sign in to access your accounts
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
    		</div>
    	</div>