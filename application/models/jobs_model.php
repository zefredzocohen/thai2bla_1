<?php
class Jobs_model extends Employee
{
    public function __construct(){
        parent::__construct();
        $this->_table_employees_jobs = $this->db->dbprefix('jobs_employees');
        $this->_table_people = $this->db->dbprefix('people');
        $this->_table_permissions = $this->db->dbprefix('permissions');
        $this->_table_permissions_action = $this->db->dbprefix('permissions_actions');
        $this->_table_jobs = $this->db->dbprefix('jobs');
        $this->_table_employees = $this->db->dbprefix('employees');
    }
    private $_items =array();
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
        if($person_id == 1){
            $this->db->from($this->_table_employees_jobs);

            return $this->db->count_all_results();
        }else{
            $this->db->from($this->_table_employees_jobs);
            $this->db->where('person_id', $person_id);

            return $this->db->count_all_results();
        }
    }
    /*
   Returns all the employees
   */
    function get_all($person_id = 1,$limit = 10000, $offset =0, $col='jobs_important',$order = 'DESC')
    {
        if($person_id == 1){
            $sql = "SELECT * FROM "
                    .$this->_table_employees_jobs.','.$this->_table_jobs.','.$this->_table_people.','.$this->_table_employees."
                    WHERE ".$this->_table_employees_jobs.".person_id = ".$this->_table_people.".person_id AND "
                    .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
                    .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND ".$this->_table_employees.".deleted = 0
                    ORDER BY ".$col." ".$order." LIMIT ".$offset.','.$limit ;

                    $data = $this->db->query($sql);

            }else{
                $sql = "SELECT * FROM "
                    .$this->_table_employees_jobs.','.$this->_table_jobs.','.$this->_table_people.",".$this->_table_employees."
                     WHERE ".$this->_table_employees_jobs.".person_id = ".$this->_table_people.".person_id AND "
                    .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
                    .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND "
                    .$this->_table_employees_jobs.".person_id = ".$person_id." AND ".$this->_table_employees.".deleted = 0".
                    " ORDER BY ".$col." ".$order." LIMIT ".$offset.','.$limit;

                $data = $this->db->query($sql);
        }

        return $data;
    }

    public function get_parent_jobs($person_id =1 ,$limit = 10000, $offset =0, $col='last_name',$order = 'DESC')
    {
        $sql = " SELECT first_name AS parent_name
                 FROM ".$this->_table_people ." AS a,".$this->_table_employees_jobs." AS b,".$this->_table_employees." AS c
                 WHERE b.person_id = c.person_id AND a.person_id = b.parent_id AND deleted = 0";

        $query = $this->db->query($sql);

        print_r($query->result_array());

        return $query->result_array();
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
        $sql = "SELECT * FROM ".$this->_table_employees_jobs." WHERE employees_jobs_id = ".$jobs_id ;

        $query = $this->db->query($sql);
        return $query->row();
    }
    function get_info_jobs()
    {
        $this->db->select('jobs_id,jobs_name');
        $this->db->where('jobs_id != ',3);
        $query = $this->db->get($this->_table_jobs);

        return $query->result_array();
    }
    function get_info_employees($person_id)
    {
        $this->db->select('username');
        $this->db->from($this->_table_employees);
        $this->db->join($this->_table_permissions_action,$this->_table_employees.'.person_id = '.$this->_table_permissions_action.".person_id");
        $this->db->where($this->_table_permissions_action.".person_id = ".$person_id ." AND module_id = 'jobs' AND action_id = 'add_update' ");
        $result = $this->db->get();
        $num_row = $result->num_rows();

        if($num_row > 0 ){
             $items = $this->recursion($this->get_recursion(),$person_id);
             $array_id = implode(',',$items);
             echo $array_id;

             if(empty($array_id)){
                 $sql = "SELECT first_name,last_name,$this->_table_employees.person_id
                    FROM ".$this->_table_people.','.$this->_table_employees .','.$this->_table_permissions.'
                    WHERE '.$this->_table_people .'.person_id = '.$this->_table_employees.'.person_id
                           AND '.$this->_table_employees .".person_id != ".$person_id ."
                           AND ".$this->_table_permissions.".person_id = ".$this->_table_employees.'.person_id' ."
                           AND module_id = 'jobs'
                           AND $this->_table_employees.deleted = 0";

                 echo $sql;

                 $query = $this->db->query($sql);

             }else{
                 $sql = "SELECT first_name,last_name,$this->_table_employees.person_id
                    FROM ".$this->_table_people.','.$this->_table_employees .','.$this->_table_permissions.'
                    WHERE '.$this->_table_people .'.person_id = '.$this->_table_employees.'.person_id
                           AND '.$this->_table_employees .".person_id != ".$person_id ."
                           AND ".$this->_table_permissions.".person_id = ".$person_id ."
                           AND module_id = 'jobs'
                           AND $this->_table_employees.deleted = 0
                           AND $this->_table_employees.person_id IN ($array_id)";

                 $query = $this->db->query($sql);

             }

            return $query->result_array();
        }else{
            $array = array(array('first_name'=>'Bạn không có quyền giao việc trong cho nhân viên nào .'));

            return $array;
        }
    }
    function recursion($data, $parent_id)
    {
        foreach($data AS $values){
            if($values['parent_id'] == $parent_id){
                $this->_items[] = $values['person_id'];
                $this->recursion($data,$values['person_id']);
            }
        }

        return $this->_items;
    }

    function get_recursion()
    {
        $sql = "SELECT person_id,parent_id FROM ".$this->_table_employees." WHERE deleted = 0";
        $query = $this->db->query($sql);

        return $query->result_array();
    }
    /*
    Determines if a given person_id is an employee
    */
    function exists($jobs_id)
    {
        $this->db->from($this->_table_jobs);
        $this->db->join($this->_table_division, $this->_table_division.".jobs_id =".$this->_table_jobs.".jobs_id");
        $this->db->where($this->_table_jobs.".jobs_id = ",$jobs_id);
        $query = $this->db->get();

        return ($query->num_rows()==1);
    }


    function employee_username_exists($username)
    {
        $this->db->from('employees');
        $this->db->join('people', 'people.person_id = employees.person_id');
        $this->db->where('employees.username',$username);
        $query = $this->db->get();

        if($query->num_rows()==1)
        {
            return $query->row()->username;
        }
    }



    /*
    Gets information about multiple employees
    */
    function get_multiple_info($employee_ids)
    {
        $this->db->from('employees');
        $this->db->join('people', 'people.person_id = employees.person_id');
        $this->db->where_in('employees.person_id',$employee_ids);
        $this->db->order_by("last_name", "asc");
        return $this->db->get();
    }

    /*
    Inserts or updates an employee
    */
    function save(&$item_data,$employee_jobs_id = false)
    {
        if($employee_jobs_id==-1)
        {
            if($this->db->insert('employees_jobs',$item_data))
            {
                return true;
            }
            return false;
        }

        $this->db->where('employees_jobs_id', $employee_jobs_id);
        return $this->db->update('employees_jobs',$item_data);
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
    function delete_list($employee_ids)
    {
        $this->db->trans_start();

        $this->db->where_in('employees_jobs_id',$employee_ids);
        //Delete permissions
        if($this->db->delete($this->_table_employees_jobs)){
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
        $suggestions = array();

        $this->db->from('employees');
        $this->db->join('people','employees.person_id=people.person_id');

        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->where("(first_name LIKE '".$this->db->escape_like_str($search)."%' or
			last_name LIKE '".$this->db->escape_like_str($search)."%' or
			CONCAT(`first_name`,' ',`last_name`) LIKE '".$this->db->escape_like_str($search)."%') and deleted=0");
        }
        else
        {
            $this->db->where("(first_name LIKE '%".$this->db->escape_like_str($search)."%' or
			last_name LIKE '%".$this->db->escape_like_str($search)."%' or
			CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");
        }

        $this->db->order_by("first_name", "ASC");
        $by_name = $this->db->get();
        foreach($by_name->result() as $row)
        {
            $suggestions[]=array('label'=> $row->first_name);
        }

        $this->db->from('employees_jobs');
        $this->db->join('jobs','employees_jobs.jobs_id = jobs.jobs_id');
        $this->db->like("jobs_name",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("jobs_name", "DESC");
        $by_jobs_name = $this->db->get();
        foreach($by_jobs_name->result() as $row)
        {
            $suggestions[]=array('label'=> $row->jobs_name);
        }

        $this->db->from('employees_jobs');
        $this->db->join('jobs','employees_jobs.jobs_id = jobs.jobs_id');
        $this->db->like("jobs_content",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("jobs_content", "DESC");
        $by_jobs_content = $this->db->get();
        foreach($by_jobs_content->result() as $row)
        {
            $suggestions[]=array('label'=> $row->jobs_content);
        }

        $this->db->from('employees_jobs');
        $this->db->join('jobs','employees_jobs.jobs_id = jobs.jobs_id');
        $this->db->like("jobs_start_date",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("jobs_start_date", "DESC");
        $by_jobs_start_date = $this->db->get();
        foreach($by_jobs_start_date->result() as $row)
        {
            $suggestions[]=array('label'=> $row->jobs_start_date);
        }

        $this->db->from('employees_jobs');
        $this->db->join('jobs','employees_jobs.jobs_id = jobs.jobs_id');
        $this->db->like("jobs_end_date",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("jobs_end_date", "DESC");
        $by_jobs_end_date = $this->db->get();
        foreach($by_jobs_end_date->result() as $row)
        {
            $suggestions[]=array('label'=> $row->jobs_end_date);
        }
        //only return $limit suggestions
        if(count($suggestions > $limit))
        {
            $suggestions = array_slice($suggestions, 0, $limit);
        }

        return $suggestions;

    }



    /*
    Preform a search on employees
    */
    function search($search='nguyen', $limit=20,$offset=0,$column='last_name',$orderby='asc')
    {
        if ($this->config->item('speed_up_search_queries'))
        {

            //return $this->db->query($query);
        }
        else
        {
            $this->db->from('jobs,employees_jobs,employees,people');
            $this->db->where("".$this->_table_employees_jobs.".person_id = ".$this->_table_employees.".person_id AND "
            .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
            .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND
            (first_name LIKE '%".$this->db->escape_like_str($search)."%' OR
			last_name LIKE '%".$this->db->escape_like_str($search)."%' OR
			jobs_name LIKE '%".$this->db->escape_like_str($search)."%' OR
			jobs_content LIKE '%".$this->db->escape_like_str($search)."%' OR
			jobs_start_date LIKE '%".$this->db->escape_like_str($search)."%' OR
			jobs_end_date LIKE '%".$this->db->escape_like_str($search)."%' OR
			CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') AND deleted=0");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);
            return $this->db->get();
        }
    }

    function search_count_all($search, $limit=10000)
    {
        if ($this->config->item('speed_up_search_queries'))
        {

            $query = "
				select *
			from (
           	(select ".$this->db->dbprefix('people').".*, ".$this->db->dbprefix('employees').".username, ".$this->db->dbprefix('employees').".deleted
           	from ".$this->db->dbprefix('employees')."
           	join ".$this->db->dbprefix('people')." ON ".$this->db->dbprefix('employees').".person_id = ".$this->db->dbprefix('people').".person_id
           	where first_name like '".$this->db->escape_like_str($search)."%' and deleted = 0
           	order by `last_name` ASC limit ".$this->db->escape($limit).") union

		 	(select ".$this->db->dbprefix('people').".*, ".$this->db->dbprefix('employees').".username, ".$this->db->dbprefix('employees').".deleted
           	from ".$this->db->dbprefix('employees')."
           	join ".$this->db->dbprefix('people')." ON ".$this->db->dbprefix('employees').".person_id = ".$this->db->dbprefix('people').".person_id
           	where last_name like '".$this->db->escape_like_str($search)."%' and deleted = 0
           	order by `last_name` asc limit ".$this->db->escape($limit).") union

			(select ".$this->db->dbprefix('people').".*, ".$this->db->dbprefix('employees').".username, ".$this->db->dbprefix('employees').".deleted
         	from ".$this->db->dbprefix('employees')."
          	join ".$this->db->dbprefix('people')." ON ".$this->db->dbprefix('employees').".person_id = ".$this->db->dbprefix('people').".person_id
          	where email like '".$this->db->escape_like_str($search)."%' and deleted = 0
          	order by `last_name` asc limit ".$this->db->escape($limit).") union

			(select ".$this->db->dbprefix('people').".*, ".$this->db->dbprefix('employees').".username, ".$this->db->dbprefix('employees').".deleted
        	from ".$this->db->dbprefix('employees')."
        	join ".$this->db->dbprefix('people')." ON ".$this->db->dbprefix('employees').".person_id = ".$this->db->dbprefix('people').".person_id
        	where phone_number like '".$this->db->escape_like_str($search)."%' and deleted = 0
        	order by `last_name` asc limit ".$this->db->escape($limit).") union

			(select ".$this->db->dbprefix('people').".*, ".$this->db->dbprefix('employees').".username, ".$this->db->dbprefix('employees').".deleted
      		from ".$this->db->dbprefix('employees')."
      		join ".$this->db->dbprefix('people')." ON ".$this->db->dbprefix('employees').".person_id = ".$this->db->dbprefix('people').".person_id
      		where username like '".$this->db->escape_like_str($search)."%' and deleted = 0
      		order by `last_name` asc limit ".$this->db->escape($limit).") union

			(select ".$this->db->dbprefix('people').".*, ".$this->db->dbprefix('employees').".username, ".$this->db->dbprefix('employees').".deleted
    		from ".$this->db->dbprefix('employees')."
    		join ".$this->db->dbprefix('people')." ON ".$this->db->dbprefix('employees').".person_id = ".$this->db->dbprefix('people').".person_id
    		where CONCAT(`first_name`,' ',`last_name`)  like '".$this->db->escape_like_str($search)."%' and deleted = 0
    		order by `last_name` asc limit ".$this->db->escape($limit).")
			) as search_results
			order by `last_name` asc limit ".$this->db->escape($limit);

            $result=$this->db->query($query);
            return $result->num_rows();
        }
        else
        {
            $this->db->from('jobs,employees_jobs,employees,people');
            $this->db->where("".$this->_table_employees_jobs.".person_id = ".$this->_table_employees.".person_id AND "
                .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
                .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND
            (first_name LIKE '%".$this->db->escape_like_str($search)."%' OR
			last_name LIKE '%".$this->db->escape_like_str($search)."%' OR
			jobs_name LIKE '%".$this->db->escape_like_str($search)."%' OR
			jobs_content LIKE '%".$this->db->escape_like_str($search)."%' OR
			jobs_start_date LIKE '%".$this->db->escape_like_str($search)."%' OR
			jobs_end_date LIKE '%".$this->db->escape_like_str($search)."%' OR
			CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') AND deleted=0");
            $this->db->order_by("jobs_important", "DESC");
            $result=$this->db->get();
            return $result->num_rows();
        }
    }

    /*
    Attempts to login employee and set session. Returns boolean based on outcome.
    */
    function login($username, $password)
    {
        $query = $this->db->get_where('employees', array('username' => $username,'password'=>md5($password), 'deleted'=> 0), 1);
        if ($query->num_rows() ==1)
        {
            $row=$query->row();
            $this->session->set_userdata('person_id', $row->person_id);
            return true;
        }
        return false;
    }

    /*
    Logs out a user by destorying all session data and redirect to login
    */
    function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }

    /*
    Determins if a employee is logged in
    */
    function is_logged_in()
    {
        return $this->session->userdata('person_id') == true;
    }

    /*
    Gets information about the currently logged in employee.
    */
    function get_logged_in_employee_info()
    {
        if($this->is_logged_in())
        {
            return $this->get_info($this->session->userdata('person_id'));
        }

        return false;
    }

    function authentication_check($password)
    {
        $pd=$this->session->userdata('person_id');
        $pass=md5($password);
        $query = $this->db->get_where('employees', array('person_id' => $pd,'password'=>$pass), 1);
        return $query->num_rows() == 1;
    }

    /*
    Determins whether the employee specified employee has access the specific module.
    */
    function has_module_permission($module_id,$person_id)
    {
        //if no module_id is null, allow access
        if($module_id==null)
        {
            return true;
        }

        $query = $this->db->get_where('permissions', array('person_id' => $person_id,'module_id'=>$module_id), 1);
        return $query->num_rows() == 1;
    }

    function has_module_action_permission($module_id, $action_id, $person_id)
    {
        //if no module_id is null, allow access
        if($module_id==null)
        {
            return true;
        }

        $query = $this->db->get_where('permissions_actions', array('person_id' => $person_id,'module_id'=>$module_id,'action_id'=>$action_id), 1);
        return $query->num_rows() == 1;
    }

    function get_employee_by_username_or_email($username_or_email)
    {
        $this->db->from('employees');
        $this->db->join('people', 'people.person_id = employees.person_id');
        $this->db->where('username',$username_or_email);
        $this->db->or_where('email',$username_or_email);
        $query = $this->db->get();

        if ($query->num_rows() == 1)
        {
            return $query->row();
        }

        return false;
    }

    function update_employee_password($employee_id, $password)
    {
        $employee_data = array('password' => $password);
        $this->db->where('person_id', $employee_id);
        $success = $this->db->update('employees',$employee_data);

        return $success;
    }
}

