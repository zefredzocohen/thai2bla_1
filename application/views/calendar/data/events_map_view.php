<?php
	require_once('<?php echo base_url();?>calendar/common/connector/scheduler_connector.php');
	include ('<?php echo base_url();?>calendar/common/config.php');
	
	$scheduler = new SchedulerConnector($res, $dbtype);
	$scheduler->render_table("lifetek_events_map","event_id","start_date,end_date,event_name,details,event_location,lat,lng");
?>