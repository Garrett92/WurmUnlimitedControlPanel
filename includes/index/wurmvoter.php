<?php
if ($wurmUnlimitedVoterEnabled && isset($_SESSION['steamid'])) {
	$val = trim(file_get_contents("https://wurm-unlimited.com/api/?object=votes&element=claim&key=".$voteapikey."&steamid=" . $_SESSION['steamid']));
	if ($alwaysShowVoting || $val < 2 || isset($_POST['reward-playerID'])) {
?>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">Vote! Earn <?php echo($voteRewardText); ?>.</div>
				<div class="panel-body" align="center">
					<a href="<?php echo($voteBannerLink); ?>" target="_blank"><img src="<?php echo($voteBannerImage); ?>" border="0" style="max-width:100%;"></a>
					<br><br><b>
					<?php 	
					if ($val == 0) {
						$say = "Go vote and refresh this page to apply ".$voteRewardText." to your account!";
					} else if ($val == 1) {
						$say = "Select your account below and click Reward to receive the ".$voteRewardText.".";
						if (isset($_POST['reward-playerID'])) {
							$submitval = trim(file_get_contents("https://wurm-unlimited.com/api/?action=post&object=votes&element=claim&key=".$voteapikey."&steamid=" . $_SESSION['steamid']));
							if ($submitval == 1) {
								$say = "Thank you for voting! Your account balance is now: " . getMoneyString(givePlayerMoney($_POST['reward-playerID'], $voteRewardAmountInIron));
								$val = 2;
							} else {
								$say = "You have already received your reward today!";
							}
						}
					} else {
						$say = "You have already received your reward today!";
					}
					echo($say);
					
					?>
					</b>
				</div>
			</div>
		</div>
<?php 
    }
}
?>
