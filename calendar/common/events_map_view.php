<?php
	require_once('connector/scheduler_connector.php');
    include ('connector/crosslink_connector.php');
	include ('config.php');
	
//	mysql_query("set character_set_results='utf8'");
        $cross = new CrossOptionsConnector($res, $dbtype);
		$cross->options->render_table("select lifetek_people.person_id as value, lifetek_people.first_name as label 
from lifetek_people join lifetek_employees where lifetek_people.person_id = lifetek_employees.person_id and deleted = 0", "value", "value, label");
		$cross->link->render_table("lifetek_event_user","event_id", "user_id,event_id");
        $scheduler = new SchedulerConnector($res, $dbtype);
        $scheduler->set_options("person_id", $cross->options);
		$scheduler->render_table("lifetek_events_map","event_id","start_date,end_date,event_name,details,event_location,lat,lng");
?>