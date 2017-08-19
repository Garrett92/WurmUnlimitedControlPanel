<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="table">
				<table class="table">
					<thead>
						<tr>
							<td colspan="2" align="center"><h4><b><?php echo(getServerName()); ?></b></h4></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td align="left"><b>Server Status</b></td>
							<td align="right"><?php echo(trim(sendCommand("getServerStatus")[0])); ?></td>
						</tr>
						<tr>
							<td align="left"><b>Players Online</b></td>
							<td align="right"><?php echo(trim(sendCommand("getPlayerCount")[0])); ?></td>
						</tr>
						<tr>
							<td align="left"><b>Uptime</b></td>
							<td align="right"><?php echo(trim(sendCommand("getUpTime")[0])); ?></td>
						</tr>
					</tbody>
				</table>
    					
				<div class="g-table" style="width:100%;">
					<?php 
					if ($wurmPower >= $admin_broadcast) {
					?>
						<div class="g-table-row">
							<div class="g-table-cell" align="center">
								<?php 
								if (isset($_POST["broadcast"])) {
									sendCommand("broadcast?".$_POST['broadcast'], true);
	    							echo("<b>Your broadcast has been sent to the server!</b><br>");
	    						}
	    						?>
	    						<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#broadcastModal">Broadcast Message</button>
  								<div class="modal fade" id="broadcastModal" role="dialog">
    								<div class="modal-dialog">
      									<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Broadcast Message</h4>
											</div>
        									<div class="modal-body">
												<form action="" method="post">
													<input type="text" name="broadcast" maxlength="150" autocomplete="off" style="width:100%;max-width:100%"><br>
													<input type="submit" value="Submit">
												</form>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
		    		<?php
		    		}
		    		if ($wurmPower >= $admin_shutdown) {
		    			if (isset($_POST["shutdownMessage"])) {
		    				sendCommand("shutdown?".$_POST['shutdownTime']."&".$_POST['shutdownMessage'], true);
		    			}
		    			if (isset($_POST["cancelShutdown"])) {
		    				sendCommand("cancelshutdown", true);
		    			}
		    		?>
		    			<div class="g-table-row">
							<div class="g-table-cell" align="center">
	    						<?php 
	    						if ($wurmPower >= $admin_broadcast) {
	    							echo("<br>");
	    						}
	    						if (isset($_POST["shutdownMessage"])) {
	    							echo("<b>Server is shutting down!</b><br>");
	    						}
	    						if (isset($_POST["cancelShutdown"])) {
	    							echo("<b>Server shutdown canceled!</b><br>");
	    						}
	    						if(strpos(sendCommand("getServerStatus")[0], "Shutting down") === false) {
	    							echo('<button type="button" class="btn btn-danger btn-md" data-toggle="modal" data-target="#shutdownModal">Shutdown Server</button>');
	    						} else {
	    							echo('<button type="button" class="btn btn-warning btn-md" data-toggle="modal" data-target="#cancelShutdownModal">Cancel Shutdown</button>');
	    						}
	    						?>
  								<div class="modal fade" id="shutdownModal" role="dialog">
    								<div class="modal-dialog">
      									<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Shutdown Server</h4>
											</div>
        									<div class="modal-body">
												<form action="" method="post">
													Time (in seconds)<br><input type="text" name="shutdownTime" maxlength="150" autocomplete="off" style="width:100px;max-width:100px"><br><br>
													Reason<br><input type="text" name="shutdownMessage" maxlength="100" autocomplete="off" style="width:200px;max-width:200px"><br><br>
													<input type="submit" class="btn btn-danger" value="Shutdown">
												</form>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>
								<div class="modal fade" id="cancelShutdownModal" role="dialog">
    								<div class="modal-dialog">
      									<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Cancel Shutdown</h4>
											</div>
        									<div class="modal-body">
												<form action="" method="post">
													<input type="submit" class="btn btn-warning" name="cancelShutdown" value="Cancel Shutdown">
												</form>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
		    		<?php
		    		}
    				?>
    			</div>
    		</div>
    	</div>
    </div>
</div>