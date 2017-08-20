<?php 

//load user config options
require 'includes/config.php';

//load steamauth scripts for steam login authentication
require 'includes/steamauth/steamauth.php';

//kick user to login page if they are not logged in & $requireSteamLogin=true
if(!isset($_SESSION['steamid']) && $requireSteamLogin) {
	header('Location: login.php');
	exit;
}

//set power variable to 0
$wurmPower = 0;

//set power variable to highest wurm steam account on server
if (isset($_SESSION['steamid'])) {
	$wurmPower = findSteamIDPower($_SESSION['steamid']);
}

function getLogs() {
	$directory = 'logs/';
	$scanned_directory = array_diff(scandir($directory, 1), array('..', '.'));
	
	$count = 0;
	foreach ($scanned_directory as $k => $v) {
		if ($v == "index.html" || $v == ".htaccess") {
			continue;
		}
		$return[$count] = $v;
		$count++;
	}
	
	if (isset($return)) {
		return $return;
	}
}

function dailyLog($logInfo) {
	
	$directory = 'logs/';
	$scanned_directory = array_diff(scandir($directory), array('..', '.'));
	$zipFile = "oldLogs.zip";
	$logname  = date("m-d-Y") . '.commands.log';
	
	foreach ($scanned_directory as $k => $v) {
		if ($v == $logname || $v == $zipFile || $v == "index.html") {
			continue;
		}
	}

	if (file_exists($directory.$logname)) {
		$fp=fopen($directory.$logname,'a');
	}else{
		$fp=fopen($directory.$logname,'w');
	}
	
	fwrite($fp, $logInfo.PHP_EOL);
	fclose($fp);
}

//send command to RMI server and return array for each line
function sendCommand($cmd, $log=false) {
	global $RMI_ADDRESS;
	$lines = file('http://'.$RMI_ADDRESS.'/'.$cmd);
	
	for($i = 0; $i < count($lines); ++$i) {
		$lines[$i] = trim($lines[$i]);
		if ($lines[$i] == "") {
			//remove line from array if it is empty
			unset($lines[$i]);
		}
	}
	
	//log command and steamID information
	if ($log) {
		$currentTime = date('H:i:s');
		if (isset($_SESSION['steamid'])) {
			dailyLog("[" . $currentTime . "] (" . $_SERVER['REMOTE_ADDR'] . ") SteamID {" . $_SESSION['steamid'] . "} - Sent command: " . $cmd);
		} else {
			dailyLog("[" . $currentTime . "] (" . $_SERVER['REMOTE_ADDR'] . ") No Steam Logon - Sent command: " . $cmd);
		}
	}

	//if first line of array is empty, return a blank array
	if (isset($lines[0]) && $lines[0] == "") {
		return array();
	}
    return $lines;
}

//explode each line of the array at the '=' sign, if $nameKey=true use $array[x][0] as the array key.
function parseArray($array, $explode = true, $nameKey = false) {
    if ($explode) {
        foreach ($array as $k => $v) {
            $tmp = explode("=", $v);
            if ($nameKey) {
                $new[$tmp[0]] = $tmp[1];
            } else {
                $array[$k] = array($tmp[0], $tmp[1]);
            }
        }
        if ($nameKey) {
            return $new;
        }
    }
    return $array;
}


function get_string_between($string, $start, $end) {
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function getServerName() {
    return get_string_between(sendCommand("doesPlayerExist?0")[2], "error occurred on the ", " game server: No");
}

function getAllPlayers() {
    return parseArray(sendCommand("getAllPlayers"));
}

function getAllVillages() {
    return parseArray(sendCommand("getDeeds"));
}

function getVillageSummary($villageID) {
    return parseArray(sendCommand("getDeedSummary?" . $villageID), true, true);
}

function getPlayerSummary($playerID) {
    return parseArray(sendCommand("getPlayerSummary?" . $playerID), true, true);
}

function getPlayerSkills($playerID) {
	return parseArray(sendCommand("getSkillsForPlayer?" . $playerID), true, true);
}

function findSteamIDPower($steamID) {
	return trim(sendCommand("findSteamIDPower?".$steamID)[0]);
}

function getMoneyString($money, $s = "s ", $c = "c ", $i = "i") {
	$money = trim($money);
	$silver = floor($money/10000);
	$copper = floor(($money%10000)/100);
	$iron = floor(($money%10000)%100);
	return ($silver . $s . $copper .$c . $iron . $i);
}

function givePlayerMoney($playerID, $amount) {
	sendCommand("addMoneyToBank?&".$playerID."&".$amount);
	return getPlayerSummary($playerID)["Money in bank"];
}

function findPlayersWithSteamID($steamID) {
    $players = parseArray(sendCommand("findPlayersWithSteamID?" . $steamID));
    foreach ($players as &$player) {
        $tmp = explode(",", get_string_between($player[1], "[", "]"));
        $player[1] = $player[0];
        $player[0] = $tmp[0];
    }
    return $players;
}

function getAllPlayerStates() {
    $players = getAllPlayers();
    $loadString = '';
    foreach ($players as $player) {
        $loadString .=  $player[1] . '&';
    }
    $players = parseArray(sendCommand('getPlayerStates?'.$loadString));
    foreach ($players as &$player) {
        $player[1] = explode(",", get_string_between($player[1], "[", "]"));
    }
    return $players;
}

function getRecentPlayers($timeInSeconds) {
	$players = parseArray(sendCommand("getRecentPlayers?".$timeInSeconds));
	foreach ($players as &$player) {
		$player[1] = explode(",", get_string_between($player[1], "[", "]"));
	}
	return $players;
}

function getOnlinePlayers() {
    $players = parseArray(sendCommand("getOnlinePlayers"));
    foreach ($players as &$player) {
        $player[1] = explode(",", get_string_between($player[1], "[", "]"));
    }
    return $players;
}

function getPlayerInventory($playerID) {
    return parseArray(sendCommand("getInventory?" . $playerID));
}

function getItemListForSearch() {
	$items = parseArray(sendCommand("getItemTemplates"));
	foreach ($items as &$item) {
		$item[1] = ucfirst(strtolower(preg_replace('/(?<!\ )[A-Z]/', ' $0', $item[1])));
		if (strpos($item[1], '_') !== false) {
			$item[1] = implode(' ', explode('_', $item[1]));
		}
	}
	array_pop($items); //remove the last item in array (numberOfItems)
	return $items;
}

function getWurmUnixTime($time) {
    return DateTime::createFromFormat('D M d H:i:s T Y', $time)->format('U');
}

function calcTimeDifference($datetime) {
    $now = new DateTime;
    $now = $now->format('U');
    $ago = $datetime;
    return ($now - $ago);
}

function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);
    
    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;
    
    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }
    
    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) : 'just now';
}

?>