<?php
class Module extends CI_Model 
{
    function __construct()
    {
        parent::__construct();
    }
	
	function get_module_name($module_id)
	{
		$query = $this->db->get_where('modules', array('module_id' => $module_id), 1);
		
		if ($query->num_rows() ==1)
		{
			$row = $query->row();
			return lang($row->name_lang_key);
		}
		
		return lang('error_unknown');
	}
	
	function get_module_desc($module_id)
	{
		$query = $this->db->get_where('modules', array('module_id' => $module_id), 1);
		if ($query->num_rows() ==1)
		{
			$row = $query->row();
			return lang($row->desc_lang_key);
		}
	
		return lang('error_unknown');	
	}
	
	function get_all_modules()
	{
	     $this->_item = $this->session->userdata('person_id');
		
		if($this->_item != 1){
		 $data = array(
				'item2s'=>'item2s',
				'item4s'=>'item4s',
				'department'=>'department',
				'regions'=>'regions',
				'affiliates'=>'affiliates',
				'city'=>'city',
				'citys'=>'citys',
				'kh'=>'kh',
				'profix'=>'profix',
				'abouts'=>'abouts',
				'salestraining'=>'salestraining'
			);	
		}else{
			 $data = array(
				'item2s'=>'item2s',
				'item4s'=>'item4s',
				'citys'=>'citys',
				'kh'=>'kh',
				'profix'=>'profix',
				'abouts'=>'abouts',
				'salestraining'=>'salestraining'
			);
		}
       
        $this->db->where_not_in('module_id',$data);
		$this->db->from('modules');
		$this->db->order_by("SORT", "ASC");
		return $this->db->get();		
	}
	
	function get_allowed_modules_home($person_id)
	{
		$this->db->from('modules');
		$this->db->join('permissions','permissions.module_id = modules.module_id');
		$this->db->where("permissions.person_id",$person_id);
		$this->db->where('active_home',1);
		$this->db->order_by("sort", "ASC");
		return $this->db->get();		
	}
	
	function get_allowed_modules($person_id)
	{
		$this->db->from('modules');
		$this->db->join('permissions','permissions.module_id = modules.module_id');
		$this->db->where("permissions.person_id",$person_id);
                $this->db->where('active_category',1);
		$this->db->order_by("sort", "asc");
		return $this->db->get();		
	}
	
	function get_allowed_modules_header($person_id)
	{
		$this->db->from('modules');
		$this->db->join('permissions','permissions.module_id=modules.module_id');
		$this->db->where("permissions.person_id",$person_id);
		$this->db->where('active_header',1);
		$this->db->order_by("sort", "asc");
		return $this->db->get();		
	}
}

