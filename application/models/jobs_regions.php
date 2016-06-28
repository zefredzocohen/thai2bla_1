<?php
class Jobs_regions extends Employee
{
    public function __construct(){
        parent::__construct();
        $this->_table_regions = $this->db->dbprefix('jobs_regions');
        $this->_table_important = $this->db->dbprefix('jobs_important');
        $this->_table_employees = $this->db->dbprefix('employees');
        $this->_table_people = $this->db->dbprefix('people');
        $this->_table_status = $this->db->dbprefix('jobs_status');
        $this->_table_permissions = $this->db->dbprefix('permissions');
        $this->_table_permissions_action = $this->db->dbprefix('permissions_actions');
    }

    /* ByAuthor: @SnguyenOne
     * - Function: count_all()
     * - Description: Get total record of the table $_table_employees_jobs
     * - Param : param :$person_id is validator
     * - Return : number round this table
     *
     * */

    public function count_all($person_id)
    {
        $data = parent::getPersonId($person_id);
        $this->db->where_in($data);
        $this->db->from($this->_table_regions);

        return $this->db->count_all_results();

    }
    function checkUpdate($person_id,$module_id)
    {
        return parent::checkUpdate('add_update',$person_id,$module_id);
    }

    function get_all($person_id,$limit = 10000, $offset = 0, $col='jobs_regions_id',$order = 'DESC')
    {
        $data = parent::getPersonId($person_id);
        $sql = "SELECT * FROM ".$this->_table_regions." r INNER JOIN ".$this->_table_people. " p ON r.person_id=p.person_id WHERE r.person_id IN ($data) ORDER BY ".$col." ".$order." LIMIT $offset,$limit ";
        $data = $this->db->query($sql);
        return $data;
    }


    function get_jobs_important_info()
    {
        $sql = "SELECT * FROM ".$this->_table_important;
        $query = $this->db->query($sql);

        return $query->result();
    }
     function get_person_info()
     {
            $sql = "SELECT a.person_id,first_name,last_name
            FROM ".$this->_table_employees.' AS a ,'.$this->_table_people ." AS b
            WHERE a.person_id = b.person_id AND a.deleted = 0 ";
            $query = $this->db->query($sql);

            return $query->result();
     } 

    function get_jobs_status_info()
    {
        $sql = "SELECT * FROM ".$this->_table_status;
        $query = $this->db->query($sql);

        return $query->result();
    }
    /** get all table status for update */
    function get_regions($jobs_regions_id)
    {
        $sql = "SELECT * FROM ".$this->_table_regions. "
                WHERE jobs_regions_id = ".$jobs_regions_id;
        $query = $this->db->query($sql);

        return $query->row();
    }

    /*
     * By Author: @SnguyenOne
     * - Function : Manager Save Regions
     * - Description : Function thực hiện update và thêm mới phân quyền nhân viên quản lý khu vực
     * - Param :  $item_data and $jobs_regions_id
     * - Return :
     * */
    function save2(&$item_data,$jobs_regions_id = false)
    {
        if($jobs_regions_id == -1)
        {
            parent::updateEmployees(1,$item_data['person_id']);
            //parent::callInsertPermission('regions',$item_data['person_id']);
            parent::callInsertPermission('employees',$item_data['person_id'],1);

            if($this->db->insert($this->_table_regions,$item_data)){
                 return 1;
            }
            return false;
        }else{
            $item = parent::getInformationPerson('jobs_regions','jobs_regions_id',$jobs_regions_id);
            //Hàm thực hiện lấy thông tin toàn bộ nhân viên cấp dưới thực hiện update người quản lý mói
            //Lấy toàn bộ person_id quản lý thành phố thuộc khu vực đang thực hiên update người quản lý mới cho khu vực này
            $person_id_city = parent::getInformationPerson('jobs_city','jobs_regions_id',$jobs_regions_id,1);
            parent::updateEmployees($item_data['person_id'],$person_id_city);
            //Xóa bỏ toàn bộ quyền của nhân viên mới
            $result = parent::getCountInformation('jobs_regions','jobs_regions_id',$jobs_regions_id,'person_id',$item->person_id);
            if($result == 0){
                parent::updateEmployees(0,$item->person_id);
                parent::callDeletePermission('regions',$item->person_id);
                //parent::callDeletePermission('employees',$item->person_id);
            }
            //Hàm thực hiện xóa bỏ quyền quản lý nhân viên cũ update lại quyền cho nhân viên mới
            parent::updateEmployees(1,$item_data['person_id']);
            //parent::callInsertPermission('regions',$item_data['person_id']);
            parent::callInsertPermission('employees',$item_data['person_id'],1);
            $this->db->where('jobs_regions_id', $jobs_regions_id);
            return $this->db->update($this->_table_regions,$item_data);
        }
    }

    function delete_list2($regions_id)
    {
        $this->db->trans_start();
        if(is_array($regions_id)){
            foreach($regions_id AS $values){
                /*
             * Xủ lý xóa bỏ thông tin mảng thành viên khi xóa thông tin khu vực thì xóa bỏ toàn bộ quyền của nhân viên với khu vực đó
             * */
                $items = parent::getInformationPerson('jobs_regions','jobs_regions_id',$values);
                $result = parent::getCountInformation('jobs_regions','jobs_regions_id',$values,'person_id',$items->person_id);
                if($result == 0){
                    parent::updateEmployees(0,$items->person_id);
                    parent::callDeletePermission('regions',$items->person_id);
                    parent::callDeletePermission('employees',$items->person_id);
                }
            }
            $this->db->where_in('jobs_regions_id',$regions_id);
            if($this->db->delete($this->_table_regions)){
                $this->Jobs_city->delete_list('',$regions_id);
                $this->db->trans_complete();
                return true;
            }else{
                $this->db->trans_complete();
                return false;
            }
        }else{
            /*
             * Xủ lý xóa bỏ thông tin mảng thành viên khi xóa thông tin khu vực thì xóa bỏ toàn bộ quyền của nhân viên với khu vực đó
             * */
            $items = parent::getInformationPerson('jobs_regions','jobs_regions_id',$regions_id);
            $result = parent::getCountInformation('jobs_regions','jobs_regions_id',$regions_id,'person_id',$items->person_id);
            if($result == 0){
                parent::updateEmployees(0,$items->person_id);
                parent::callDeletePermission('regions',$items->person_id);
                parent::callDeletePermission('employees',$items->person_id);
            }

            $this->db->where_in('jobs_regions_id',$regions_id);
            if($this->db->delete($this->_table_regions)){
                $this->Jobs_city->delete_list('',$regions_id);
                $this->db->trans_complete();
                return true;
            }else{
                $this->db->trans_complete();
                return false;
            }
        }
    }
    
    //hung audi
	function save(&$item_data,$jobs_regions_id = false)
    {
        if($jobs_regions_id == -1)
        {
            parent::updateEmployees(1,$item_data['person_id']);
            //parent::callInsertPermission('regions',$item_data['person_id']);
            parent::callInsertPermission('city',$item_data['person_id'],1);
            parent::callInsertPermission('affiliates',$item_data['person_id'],1);
            parent::callInsertPermission('department',$item_data['person_id'],1);
            
            parent::callInsertPermission('employees',$item_data['person_id'],1);

            if($this->db->insert($this->_table_regions,$item_data)){
                 return 1;
            }
            return false;
        }else{
            $item = parent::getInformationPerson('jobs_regions','jobs_regions_id',$jobs_regions_id);
            //Hàm thực hiện lấy thông tin toàn bộ nhân viên cấp dưới thực hiện update người quản lý mói
            //Lấy toàn bộ person_id quản lý thành phố thuộc khu vực đang thực hiên update người quản lý mới cho khu vực này
            $person_id_city = parent::getInformationPerson('jobs_city','jobs_regions_id',$jobs_regions_id,1);
            parent::updateEmployees($item_data['person_id'],$person_id_city);
            //Xóa bỏ toàn bộ quyền của nhân viên mới
            $result = parent::getCountInformation('jobs_regions','jobs_regions_id',$jobs_regions_id,'person_id',$item->person_id);
            if($result == 0){
                parent::updateEmployees(0,$item->person_id);
                //parent::callDeletePermission('regions',$item->person_id);
            	parent::callDeletePermission('city',$item->person_id);
            	parent::callDeletePermission('affiliates',$item->person_id);
            	parent::callDeletePermission('department',$item->person_id);
	            parent::callDeletePermission2('employees',$item->person_id);
            }
            //Hàm thực hiện xóa bỏ quyền quản lý nhân viên cũ update lại quyền cho nhân viên mới
            parent::updateEmployees(1,$item_data['person_id']);
            //parent::callInsertPermission('regions',$item_data['person_id']);
            parent::callInsertPermission('city',$item_data['person_id'],1);
            parent::callInsertPermission('affiliates',$item_data['person_id'],1);
            parent::callInsertPermission('department',$item_data['person_id'],1);
            parent::callInsertPermission('employees',$item_data['person_id'],1);
            
            $this->db->where('jobs_regions_id', $jobs_regions_id);
            return $this->db->update($this->_table_regions,$item_data);
        }
    }

    function delete_list($regions_id)
    {
        $this->db->trans_start();
        if(is_array($regions_id)){
            foreach($regions_id AS $values){
                /*
             * Xủ lý xóa bỏ thông tin mảng thành viên khi xóa thông tin khu vực thì xóa bỏ toàn bộ quyền của nhân viên với khu vực đó
             * */
                $items = parent::getInformationPerson('jobs_regions','jobs_regions_id',$values);
                $result = parent::getCountInformation('jobs_regions','jobs_regions_id',$values,'person_id',$items->person_id);
                if($result == 0){
                    parent::updateEmployees(0,$items->person_id);
                    //parent::callDeletePermission('regions',$items->person_id);
                    parent::callDeletePermission('city',$items->person_id);
            		parent::callDeletePermission('affiliates',$items->person_id);
            		parent::callDeletePermission('department',$items->person_id);
                    parent::callDeletePermission2('employees',$items->person_id);
                }
            }
            $this->db->where_in('jobs_regions_id',$regions_id);
            if($this->db->delete($this->_table_regions)){
                $this->Jobs_city->delete_list('',$regions_id);
                $this->db->trans_complete();
                return true;
            }else{
                $this->db->trans_complete();
                return false;
            }
        }else{
            /*
             * Xủ lý xóa bỏ thông tin mảng thành viên khi xóa thông tin khu vực thì xóa bỏ toàn bộ quyền của nhân viên với khu vực đó
             * */
            $items = parent::getInformationPerson('jobs_regions','jobs_regions_id',$regions_id);
            $result = parent::getCountInformation('jobs_regions','jobs_regions_id',$regions_id,'person_id',$items->person_id);
            if($result == 0){
                parent::updateEmployees(0,$items->person_id);
                //parent::callDeletePermission('regions',$items->person_id);
                parent::callDeletePermission('city',$items->person_id);
            	parent::callDeletePermission('affiliates',$items->person_id);
            	parent::callDeletePermission('department',$items->person_id);
                parent::callDeletePermission2('employees',$items->person_id);
            }

            $this->db->where_in('jobs_regions_id',$regions_id);
            if($this->db->delete($this->_table_regions)){
                $this->Jobs_city->delete_list('',$regions_id);
                $this->db->trans_complete();
                return true;
            }else{
                $this->db->trans_complete();
                return false;
            }
        }
    }

   /*
    Get search suggestions to find status
    */
   
     public function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();
        $this->db->from('jobs_regions');
		$this->db->like('jobs_regions_name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		
		$this->db->order_by("jobs_regions_name", "asc");
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=array('label' => $row->jobs_regions_name);
		}
                //begin dungbv
                $this->db->from('jobs_regions');
                $this->db->join('people','jobs_regions.person_id=people.person_id','inner');
                if ($this->config->item('speed_up_search_queries')) {
	            $this->db->where("(first_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
				last_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
				CONCAT(`first_name`,' ',`last_name`) LIKE '" . $this->db->escape_like_str($search) . "%')");
	        } else {
	            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
				last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
				CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%')");
	        }
            
                $by_name_employee=$this->db->get();
                foreach($by_name_employee->result() as $row)
		{
			$suggestions[]=array('label' => $row->first_name .' '.$row->last_name);
		}
                //end dungbv
        //only return $limit suggestions
       if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
        return $suggestions;
    }
    
    function get_category_search_suggestions($search,$limit=25)
	{
		$suggestions = array();

		$this->db->from('jobs_regions');
		
		$this->db->like('jobs_regions_name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("jobs_regions_name", "asc");
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=array('value' => $row->id, 'label' => $row->jobs_regions_name);
		}
		
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}

    public function search($search, $limit = 20, $offset = 0, $column = 'jobs_regions_name', $orderby = 'asc') {
        $this->db->from('jobs_regions');
        $this->db->join('people','jobs_regions.person_id=people.person_id','inner');
        $this->db->where("jobs_regions_name LIKE '%" . $this->db->escape_like_str($search) . "%' or CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%' ");
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function search_count_all($search, $limit=10000)
    {
        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->from($this->_table_regions);
            $this->db->where("jobs_regions_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by("jobs_regions_name", "ASC");

            $result=$this->db->get();
            return $result->num_rows();
        }
        else
        {
            $this->db->from($this->_table_regions);
            $this->db->where("jobs_regions_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by("jobs_regions_name", "ASC");

            $result=$this->db->get();
            return $result->num_rows();
        }
    }

    function checkRegionsName($regions_name,$regions_id)
    {
        if(empty($regions_id) OR $regions_id == -1){
            $this->db->where("jobs_regions_name LIKE '".$this->db->escape_like_str($regions_name)."'");
        }else{
            $this->db->where("jobs_regions_name LIKE '".$this->db->escape_like_str($regions_name)."' AND $regions_id != ".$regions_id);
        }

        $result = $this->db->get($this->_table_regions);
        return $result->num_rows();
    }
    
	//hung audi
    function get_region_id($person_id)
    {
        $sql = "SELECT * FROM ".$this->_table_regions. "
                WHERE person_id = ".$person_id;
        $query = $this->db->query($sql);
    	return $query;
    }
}

