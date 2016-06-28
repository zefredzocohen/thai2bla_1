<?php
class Jobs_projects extends Employee
{
    public function __construct(){
        parent::__construct();
        $this->_table_jobs = $this->db->dbprefix('jobs');
        $this->_table_jobs_status = $this->db->dbprefix('jobs_status');
        $this->_table_jobs_security = $this->db->dbprefix('jobs_security');
        $this->_table_jobs_important = $this->db->dbprefix('jobs_important');

    }

    /*
     * Khái báo var trong class
     */

    /* ByAuthor: @SnguyenOne
     * - Function: count_all()
     * - Description: Get total record of the table $_table_employees_jobs
     * - Param : param :$person_id is validator
     * - Return : number round this table
     *
     * */

    public function count_all($person_id)
    {
        $this->db->from($this->_table_jobs);
        $this->db->where('project_status',1);

        return $this->db->count_all_results();

    }
	
	public function findnewreport(){
                 $person_id=$this->session->all_userdata();
	         $id=$person_id['person_id'];
		 $this->db->from('gantt_project');	
                 $this->db->where('progress !=',1);
                 $this->db->where('person_id',$id);
		 $this->db->limit(10);
		 $query = $this->db->get();
		return $query->result_array();
    }
    
    public function findnewcalenda(){
                 $person_id=$this->session->all_userdata();
	         $id=$person_id['person_id'];
		 $this->db->from('gantt_project');	
                 $this->db->where('progress !=',1);
                 $this->db->where('person_id',$id);
		 $this->db->limit(10);
		 $query = $this->db->get();
		return $query->result_array();
    }
    function findAllItem(){
		$this->db->where('progress !=',1);
		$query = $this->db->get('gantt_project');
		return $query->result_array();
	}
    function get_info_task($task_id)
	{
		$this->db->from('gantt_project');
		$this->db->where('id',$task_id);
		
		$query = $this->db->get();

		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			//Get empty base parent object, as $item_id is NOT an item
			$item_obj=new stdClass();

			//Get all the fields from items table
			$fields = $this->db->list_fields('gantt_project');

			foreach ($fields as $field)
			{
				$item_obj->$field='';
			}

			return $item_obj;
		}
	}

    public function count_all_status()
    {
        $this->db->from($this->_table_jobs_status);

        return $this->db->count_all_results();

    }
    public function count_all_important()
    {
        $this->db->from($this->_table_jobs_important);

        return $this->db->count_all_results();

    }

    public function count_all_security()
    {
        $this->db->from($this->_table_jobs_security);

        return $this->db->count_all_results();

    }
    /*
   Returns all the employees
   */
    function get_all($limit = 10000, $offset =0, $col='jobs_important',$order = 'DESC')
    {
        $sql = "SELECT * FROM ".$this->_table_jobs." WHERE project_status = 1 ORDER BY ".$col." ".$order." LIMIT $offset,$limit ";
        $data = $this->db->query($sql);

        return $data;
    }

    function get_all_status($limit = 10000, $offset =0, $col='jobs_status_name',$order = 'DESC')
    {
        $sql = "SELECT * FROM ".$this->_table_jobs_status." ORDER BY ".$col." ".$order." LIMIT $offset,$limit ";
        $data = $this->db->query($sql);

        return $data;
    }

    function get_all_important($limit = 10000, $offset =0, $col='jobs_important_name',$order = 'DESC')
    {
        $sql = "SELECT * FROM ".$this->_table_jobs_important." ORDER BY ".$col." ".$order." LIMIT $offset,$limit ";
        $data = $this->db->query($sql);

        return $data;
    }

    function get_all_security($limit = 10000, $offset =0, $col='jobs_security_name',$order = 'DESC')
    {
        $sql = "SELECT * FROM ".$this->_table_jobs_security." ORDER BY ".$col." ".$order." LIMIT $offset,$limit ";
        $data = $this->db->query($sql);

        return $data;
    }
   function get_all_security_info()
   {
       $sql = "SELECT * FROM ".$this->_table_jobs_security."";
       $data = $this->db->query($sql);

       return $data->result();
   }
    function get_all_important_info()
    {
        $sql = "SELECT * FROM ".$this->_table_jobs_important."";
        $data = $this->db->query($sql);

        return $data->result();
    }

    /*
      Gets information about a particular jobs
      */
    function get_jobs_info($jobs_id)
    {
        $this->db->from($this->_table_jobs);
        $this->db->where('jobs_id',$jobs_id);
        $query = $this->db->get();

        return $query->row();

    }
    function get_jobs_parent($jobs_id)
    {
       if(empty($jobs_id)){
           $sql = "SELECT jobs_id,jobs_name,jobs_parent FROM ".$this->_table_jobs;
           $query = $this->db->query($sql);
       }else{
           $sql = "SELECT jobs_id,jobs_name,jobs_parent FROM ".$this->_table_jobs." WHERE jobs_id != ".$jobs_id;
           $query = $this->db->query($sql);
       }

       return $query->result();

    }
    /*

    /* ByAuthor: @SnguyenOne
     * - Function: count_all()
     * - Description: Get total record of the table $_table_employees_jobs
     * - Param : param :$person_id is validator
     * - Return : number round this table
     *
     * */

    function get_jobs_employees_info($jobs_id)
    {
        $sql = "SELECT * FROM ".$this->_table_jobs." WHERE employees_jobs_id = ".$jobs_id ;

        $query = $this->db->query($sql);
        return $query->row();
    }
    /** get all table status */
    function get_jobs_status_info()
    {
        $sql = "SELECT * FROM ".$this->_table_jobs_status;
        $query = $this->db->query($sql);

        return $query->result();
    }
    /** get all table status for update */
    function get_jobs_status($jobs_status_id)
    {
        $sql = "SELECT * FROM ".$this->_table_jobs_status. " WHERE jobs_status_id = ".$jobs_status_id;
        $query = $this->db->query($sql);

        return $query->row();
    }
      /** get all table status for update */
        function get_jobs_important($jobs_important_id)
        {
            $sql = "SELECT * FROM ".$this->_table_jobs_important. " WHERE jobs_important_id = ".$jobs_important_id;
            $query = $this->db->query($sql);

            return $query->row();
        }
   /** get all table status for update */
        function get_jobs_security($jobs_security_id)
        {
            $sql = "SELECT * FROM ".$this->_table_jobs_security. " WHERE jobs_security_id = ".$jobs_security_id;
            $query = $this->db->query($sql);

            return $query->row();
        }


   /*/*
    Inserts or updates an employee
    */
    function save(&$item_data,$jobs_id)
    {
        if(empty($jobs_id))
        {
            if($this->db->insert($this->_table_jobs,$item_data))
            {
                return true;
            }
            return false;
        }

        $this->db->where('jobs_id', $jobs_id);
        return $this->db->update($this->_table_jobs,$item_data);
    }
   /*
    Inserts or updates an employee
    */
    function save_status(&$item_data,$jobs_status_id = false)
    {
        if($jobs_status_id ==-1)
        {
            if($this->db->insert($this->_table_jobs_status,$item_data))
            {
                return true;
            }
            return false;
        }

        $this->db->where('jobs_status_id', $jobs_status_id);
        return $this->db->update($this->_table_jobs_status,$item_data);
    }
     /*
        Inserts or updates an employee
        */
        function save_important(&$item_data,$jobs_important_id = false)
        {
            if($jobs_important_id ==-1)
            {
                if($this->db->insert($this->_table_jobs_important,$item_data))
                {
                    return true;
                }
                return false;
            }

            $this->db->where('jobs_important_id', $jobs_important_id);
            return $this->db->update($this->_table_jobs_important,$item_data);
        }
        /*
        Inserts or updates an employee
        */
        function save_security(&$item_data,$jobs_security_id = false)
        {
            if($jobs_security_id == -1)
            {
                if($this->db->insert($this->_table_jobs_security,$item_data))
                {
                    return true;
                }
                return false;
            }

            $this->db->where('jobs_security_id', $jobs_security_id);
            return $this->db->update($this->_table_jobs_security,$item_data);
        }


    /*
    Deletes one employee
    */
    function delete($employee_id)
    {
        $success=false;

        //Don't let employee delete their self
        if($employee_id==$this->get_logged_in_employee_info()->person_id)
            return false;

        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();

        //Delete permissions
        if($this->db->delete('permissions', array('person_id' => $employee_id)) && $this->db->delete('permissions_actions', array('person_id' => $employee_id)))
        {
            $this->db->where('person_id', $employee_id);
            $success = $this->db->update('employees', array('deleted' => 1));
        }
        $this->db->trans_complete();
        return $success;
    }

    /*
    Deletes a list of employees
    */
    function delete_list($jobs_id)
    {
        $this->db->trans_start();
        $this->db->where_in('jobs_id',$jobs_id);
        //Delete permissions
        if($this->db->delete($this->_table_jobs)){
            $this->db->trans_complete();
            return true;
        }else{
            $this->db->trans_complete();
            return false;
        }
    }
    /*
    Deletes a list of employees
    */
    function delete_list_status($jobs_id)
    {
        $this->db->trans_start();
        $this->db->where_in('jobs_status_id',$jobs_id);
        //Delete permissions
        if($this->db->delete($this->_table_jobs_status)){
            $this->db->trans_complete();
            return true;
        }else{
            $this->db->trans_complete();
            return false;
        }
    }
    /*
    Deletes a list of important
    */
    function delete_list_important($jobs_id)
    {
        $this->db->trans_start();
        $this->db->where_in('jobs_important_id',$jobs_id);
        //Delete permissions
        if($this->db->delete($this->_table_jobs_important)){
            $this->db->trans_complete();
            return true;
        }else{
            $this->db->trans_complete();
            return false;
        }
    }
     /*
        Deletes a list of important
        */
        function delete_list_security($jobs_id)
        {
            $this->db->trans_start();
            $this->db->where_in('jobs_security_id',$jobs_id);
            //Delete permissions
            if($this->db->delete($this->_table_jobs_security)){
                $this->db->trans_complete();
                return true;
            }else{
                $this->db->trans_complete();
                return false;
            }
        }

    /*
    Get search suggestions to find employees
    */
    function get_search_suggestions($search,$limit=10000)
    {

        $this->db->from('jobs');
        $this->db->like("jobs_name",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->where('project_status',1);
        $this->db->order_by("jobs_name", "DESC");
        $by_jobs_name = $this->db->get();
        foreach($by_jobs_name->result() as $row)
        {
            $suggestions[]=array('label'=> $row->jobs_name);
        }

        //only return $limit suggestions
        if(count($suggestions )> $limit)
        {
            $suggestions = array_slice($suggestions, 0,$limit);
        }
        return $suggestions;

    }
   /*
    Get search suggestions to find status
    */
    function get_search_suggestions_status($search,$limit=10000)
    {

        $this->db->from($this->_table_jobs_status);
        $this->db->like("jobs_status_name",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("jobs_status_name", "DESC");
        $by_jobs_name = $this->db->get();
        foreach($by_jobs_name->result() as $row)
        {
            $suggestions[]=array('label'=> $row->jobs_status_name);
        }

        //only return $limit suggestions
        if(count($suggestions )> $limit)
        {
            $suggestions = array_slice($suggestions, 0,$limit);
        }
        return $suggestions;

    } /*
    Get search suggestions to find status
    */
    function get_search_suggestions_security($search,$limit=10000)
    {

        $this->db->from($this->_table_jobs_security);
        $this->db->like("jobs_security_name",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("jobs_security_name", "DESC");
        $by_jobs_name = $this->db->get();
        foreach($by_jobs_name->result() as $row)
        {
            $suggestions[]=array('label'=> $row->jobs_security_name);
        }

        //only return $limit suggestions
        if(count($suggestions )> $limit)
        {
            $suggestions = array_slice($suggestions, 0,$limit);
        }
        return $suggestions;

    }
    /*
    Get search suggestions to find status
    */
    function get_search_suggestions_important($search,$limit=10000)
    {

        $this->db->from($this->_table_jobs_important);
        $this->db->like("jobs_important_name",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("jobs_important_name", "DESC");
        $by_jobs_name = $this->db->get();
        foreach($by_jobs_name->result() as $row)
        {
            $suggestions[]=array('label'=> $row->jobs_important_name);
        }

        //only return $limit suggestions
        if(count($suggestions )> $limit)
        {
            $suggestions = array_slice($suggestions, 0,$limit);
        }
        return $suggestions;

    }

    /*
    Preform a search on employees
    */
    function search($search, $limit=50, $offset=0,$column='jobs_important',$orderby='DESC')
    {
        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->from('jobs');
            $this->db->where("jobs_name LIKE '%".$this->db->escape_like_str($search)."%' OR jobs_content LIKE '%".$this->db->escape_like_str($search)."%' AND project_status = 1");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);
            return $this->db->get();
        }
        else
        {
            $this->db->from('jobs');
            $this->db->where("jobs_name LIKE '%".$this->db->escape_like_str($search)."%' OR jobs_content LIKE '%".$this->db->escape_like_str($search)."%'  AND project_status = 1");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);
            return $this->db->get();
        }
    }
    /*
    Preform a search on employees
    */
    function search_status($search, $limit=50,$offset=0,$column='jobs_status_name',$orderby='ASC')
    {
        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->from('jobs_status');
            $this->db->where("jobs_status_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);

            return $this->db->get();
        }
        else
        {
            $this->db->from('jobs_status');
            $this->db->where("jobs_status_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);

            return $this->db->get();
        }
    }
    function search_important($search, $limit=50,$offset=0,$column='jobs_important_name',$orderby='ASC')
    {
        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->from($this->_table_jobs_important);
            $this->db->where("jobs_important_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);

            return $this->db->get();
        }
        else
        {
            $this->db->from($this->_table_jobs_important);
            $this->db->where("jobs_important_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);

            return $this->db->get();
        }
    }

    function search_security($search, $limit=50,$offset=0,$column='jobs_security_name',$orderby='ASC')
    {
        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->from($this->_table_jobs_security);
            $this->db->where("jobs_security_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);

            return $this->db->get();
        }
        else
        {
            $this->db->from($this->_table_jobs_security);
            $this->db->where("jobs_security_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);

            return $this->db->get();
        }
    }

    function search_count_all_status($search, $limit=10000)
    {
        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->from('jobs_status');
            $this->db->where("jobs_status_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by("jobs_status_name", "ASC");

            $result=$this->db->get();
            return $result->num_rows();
        }
        else
        {
            $this->db->from('jobs_status');
            $this->db->where("jobs_status_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by("jobs_status_name", "ASC");

            $result=$this->db->get();
            return $result->num_rows();
        }
    }

    function search_count_all_security($search, $limit=10000)
    {
        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->from($this->_table_jobs_security);
            $this->db->where("jobs_security_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by("jobs_security_name", "DESC");

            $result=$this->db->get();
            return $result->num_rows();
        }
        else
        {
            $this->db->from($this->_table_jobs_security);
            $this->db->where("jobs_security_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by("jobs_security_name", "DESC");

            $result=$this->db->get();
            return $result->num_rows();
        }
    }
    function search_count_all_important($search, $limit=10000)
    {
        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->from($this->_table_jobs_important);
            $this->db->where("jobs_important_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by("jobs_important_name", "ASC");

            $result=$this->db->get();
            return $result->num_rows();
        }
        else
        {
            $this->db->from($this->_table_jobs_important);
            $this->db->where("jobs_important_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by("jobs_important_name", "ASC");

            $result=$this->db->get();
            return $result->num_rows();
        }
    }
    function search_count_all($search, $limit=10000)
    {
        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->from($this->_table_jobs);
            $this->db->where("jobs_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by("jobs_name", "DESC");

            $result=$this->db->get();
            return $result->num_rows();
        }
        else
        {
            $this->db->from($this->_table_jobs);
            $this->db->where("jobs_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by("jobs_name", "DESC");

            $result=$this->db->get();
            return $result->num_rows();
        }
    }
}

