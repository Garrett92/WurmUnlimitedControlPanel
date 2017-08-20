		<div class="col-lg-<?php $ret = isset($_POST['villageID']) ? 6 : 12; echo($ret) ?> ">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="g-table" style="width:100%;">
						<div class="g-table-row">
							<div class="g-table-cell" align="left">
								Villages
							</div>
							<div class="g-table-cell" align="right">
								<form action="" method="post">
									<?php foreach ($_POST as $key => $value) { if ($key == "max" || $key == "page" || $key == "villageID") echo('<input type="hidden" name="'.$key.'" value="'.$value.'" />'); } ?>
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
								<div class="g-table-cell" align="right">
									<form action="" method="post">
										<?php foreach ($_POST as $key => $value) { if ($key == "page" || $key == "villageID") echo('<input type="hidden" name="'.$key.'" value="'.$value.'" />'); } ?>
										<small>Show 
										<select name="max" onchange="this.form.submit()">
	    									<option value="10"<?php if (!isset($_POST["max"]) || $_POST["max"] == "10") echo(' selected="selected"'); ?>>10</option>
	    									<option value="25"<?php if (isset($_POST["max"]) && $_POST["max"] == "25") echo(' selected="selected"'); ?>>25</option>
	    									<option value="50"<?php if (isset($_POST["max"]) && $_POST["max"] == "50") echo(' selected="selected"'); ?>>50</option>
	    									<option value="100"<?php if (isset($_POST["max"]) && $_POST["max"] == "100") echo(' selected="selected"'); ?>>100</option>
	  									</select> 
	  									villages</small>
									</form>
								</div>
							</div>
						</div>
					<table id="custom_table">
						<tbody>
							<tr>
								<?php
								$c = 0;
								$save = array();
                                $villageArray = getAllVillages();
                                
                                function sortByName($a, $b) {
                                	return ($a[1] > $b[1]);
                                }
                                
                                usort($villageArray, 'sortByName');
                                
                                foreach ($villageArray as $village) {
                                	if (isset($_POST["search"])) {
                                		if (($_POST["search"] != '') && strpos(strtolower($village[1]), strtolower($_POST["search"])) === FALSE) {
                                			continue;
                                		}
                                	}
                                	$buttonIcon = "fa-home";
                                	$onDblClick = 'ondblclick="this.form.submit()"';
                                	$clToLoad = "<br><center>- <b><small>DOUBLE CLICK TO LOAD</small></b> -</center>";
                                    $buttonColor = "btn-primary";
                                    $villageInfo = getVillageSummary($village[0]);
                                    $citizenCount = count(parseArray(sendCommand("getPlayersForDeed?" . $village[0])));
                                    $hiddenForm = '<input type="hidden" name="villageID" value="' . $village[0] . '" />';
                                    if (isset($_POST["villageID"])) {
                                    	if ($_POST["villageID"] == $village[0]) {
                                    		//village summary is loaded
                                    		$buttonIcon = "fa-times";
                                    		$onDblClick = 'onclick="this.form.submit()"';
                                    		$hiddenForm = '';
                                    	}
                                    }
                                    foreach ($_POST as $key => $value) {
                                    	if ($key == "max" || $key == "page") {
                                    		$hiddenForm = $hiddenForm . '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
                                    	}
                                    }
                                    if ($wurmPower < $view_villages_summary) {
                                    	$onDblClick = "";
                                    	$clToLoad = "";
                                    }
                                    $shortName = strlen($village[1]) > 9 ? substr($village[1],0,9)."-" : $village[1];
                                    $savedVillage = '<td><form action="" method="post">'.$hiddenForm.'<center>'.
                                        '<button type="button" class="btn ' . $buttonColor . ' " '.$onDblClick.' data-html="true" data-toggle="popover" '.
                                        'title="<center><b>' . $village[1] . '</b></center>" data-placement="bottom" data-trigger="focus" '.
                                        'data-content="'.
                                        '<div class=\'g-table\' style=\'width:200px;\'>'.
                                        '<div class=\'g-table-row\'><div class=\'g-table-cell\'>'.
                                        '<b>Mayor</b>'.
                                        '</div><div class=\'g-table-cell\' align=\'right\'>'. 
                                        $villageInfo['Mayor'] . 
                                        '</div></div><div class=\'g-table-row\'><div class=\'g-table-cell\'>'.
                                        '<b>Citizens</b>'.
                                        '</div><div class=\'g-table-cell\' align=\'right\'>'. 
                                        $citizenCount . 
                                        '</div></div></div>'.
                                        $clToLoad . '">'.
                                        '<i class="fa '.$buttonIcon.' fa-4x"></i></button><br><small><b>' . $shortName . '</b></small></center></form></td>';
                                    
                                        array_push($save, $savedVillage);
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
                                    	if ($key == "max" || $key == "villageID" || $key == "search") 
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