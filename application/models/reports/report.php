<?php
abstract class Report extends CI_Model 
{
	var $params	= array();
	
	function __construct()
	{
		parent::__construct();

		//Make sure the report is not cached by the browser
		$this->output->set_header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");
		$this->output->set_header("Cache-Control: post-check=0, pre-check=0", false);
		$this->output->set_header("Pragma: no-cache");		
	}
	
	public function setParams(array $params)
	{
		$this->params = $params;
	}
	
	//Returns the column names used for the report
	public abstract function getDataColumns();
	
	//Returns all the data to be populated into the report
	public abstract function getData();
	
	//Returns key=>value pairing of summary data for the report
	public abstract function getSummaryData();
}
?>