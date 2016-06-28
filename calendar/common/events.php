<?php
	require_once('connector/scheduler_connector.php');
	include ('config.php');
	
	$scheduler = new SchedulerConnector($res, $dbtype);
	$scheduler->render_table("events_map","event_id","start_date,end_date,event_name,details,event_location,lat,lng");
?>