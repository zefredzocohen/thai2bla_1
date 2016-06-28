<?php
class Jobs_employees extends Employee
{
    public function __construct(){
        parent::__construct();
        $this->_table_employees_jobs = $this->db->dbprefix('jobs_employees');
        $this->_table_people = $this->db->dbprefix('people');
        $this->_table_permissions = $this->db->dbprefix('permissions');
        $this->_table_permissions_action = $this->db->dbprefix('permissions_actions');
        $this->_table_jobs = $this->db->dbprefix('jobs');
        $this->_table_employees = $this->db->dbprefix('employees');
        $this->_table_jobs_status = $this->db->dbprefix('jobs_status');
        $this->_table_jobs_important = $this->db->dbprefix('jobs_important');
        $this->_table_jobs_report = $this->db->dbprefix('jobs_report');
        $this->_table_jobs_city= $this->db->dbprefix('jobs_city');
        $this->_table_jobs_department= $this->db->dbprefix('jobs_department');
        $this->_table_jobs_affiliates= $this->db->dbprefix('jobs_affiliates');
        $this->_table_hopdong= $this->db->dbprefix('hopdong');
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

     function count_all($person_id)
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
    public function count_my_jobs_all($person_id)
    {
        $this->db->from($this->_table_jobs);
        $this->db->where('person_id',$person_id);

        return $this->db->count_all_results();

    }
    /*
     * Function return số công việc mà người đó đã làm
     * */
    public function count_all_success($person_id)
    {
        $sql = 'SELECT * FROM '.$this->_table_employees_jobs.' AS a,'.$this->_table_jobs.' AS b '.$this->table_.'
                WHERE a.person_id = '.$person_id." AND a.jobs_id = b.jobs_id AND jobs_status_id = 4 ";
        $this->db->query($sql);

        return $this->db->count_all_results();
    }
    public function  count_all_jobs_success($person_id)
    {
        $sql = "SELECT a.person_id FROM ".$this->_table_employees_jobs." AS a,".$this->_table_jobs." AS b,
        ".$this->_table_jobs_report." AS c WHERE a.employees_jobs_id = c.employees_jobs_id AND c.jobs_reports_result = '100' AND
         a.person_id = ".$person_id ." AND a.jobs_id = b.jobs_id" ;

        $result = $this->db->query($sql);
        return $result->num_rows();
    }

    public function count_all_near_expired($person_id,$config_number = 1)
    {
        $sql = "SELECT * FROM "
            .$this->_table_employees_jobs.','.$this->_table_jobs.','.$this->_table_people.",".$this->_table_employees.",$this->_table_jobs_report
             WHERE ".$this->_table_employees_jobs.".person_id = ".$this->_table_people.".person_id AND "
            .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
            .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND "
            .$this->_table_employees_jobs.".employees_jobs_id = ".$this->_table_jobs_report.".employees_jobs_id AND "
            .$this->_table_employees_jobs.".person_id = ".$person_id." AND ".$this->_table_employees.".deleted = 0
             AND ".floor(abs(strtotime($this->_table_jobs.'jobs_end_date')."-".strtotime(date('Y-m-d')))/(60 * 60 * 24))."= $config_number ";

        $data = $this->db->query($sql);

        return $data->num_rows;
    }
    /*
     * Function return số công việc mà người đó đã làm
     * */
    public function count_all_jobs_person($person_id)
    {
        $sql = "SELECT person_id FROM ".$this->_table_employees_jobs." WHERE person_id = ".$person_id;
        $result = $this->db->query($sql);

        return $this->db->count_all_results();
    }
    /*
     * Function return số công việc mà người đó đã làm
     * */
    public function count_all_jobs_manager($person_id)
    {
        $sql = "SELECT person_id FROM ".$this->_table_employees_jobs." WHERE employees_jobs_parent_id = ".$person_id;

        $result = $this->db->query($sql);
        return $result->num_rows();
    }
    /*
     * Function return số công việc mà người đó đã làm
     * */
    public function count_all_manage($person_id)
    {
        $sql = "SELECT person_id FROM ".$this->_table_employees_jobs." WHERE employees_jobs_parent_id = ".$person_id;
        $this->db->query($sql);

        return $this->db->count_all_results();
    }
    /*
     * View thông tin chi tiêt công việc
     *
     * */
    function get_detail_jobs($jobs_id)
    {
        $sql = "SELECT * FROM ".$this->_table_jobs.' WHERE jobs_id = '.$jobs_id;
        $query = $this->db->query($sql);

        return $query->row();

    }
     /*
     * View thông tin chi tiêt công việc
     *
     * */
    function get_jobs_important()
    {
        $sql = "SELECT * FROM ".$this->_table_jobs_important ;
        $query = $this->db->query($sql);

        return $query->result();

    }
    /*
     * View thông tin chi tiêt công việc
     *
     * */
    function get_jobs_status()
    {
        $sql = "SELECT * FROM ".$this->_table_jobs_status ;
        $query = $this->db->query($sql);

        return $query->result();

    }
    /**
        Lấy person_id hay toàn bộ  nhân viên mà người này quản lý
     */
    function  getEmployeesManager($person_id)
    {
        $sql = "SELECT person_id FROM ".$this->_table_employees ." WHERE parent_id = ".$person_id;
        $data = $this->db->query($sql);
        

        return $data->result();
    }
    /*
     *  Get information của công việc mà các nhân viên này đã tạo hoặc được giao
     * */
    function getJobsManager($person_id)
    {
        $employees_manager = $this->getEmployeesManager($person_id);
        $items = array();
        foreach($employees_manager AS $values){
            $items[]= $values->person_id;
        }
        $items[] = $person_id;
        $id = implode($items,',');
        $sql = " SELECT a.jobs_id,jobs_name FROM ".$this->_table_jobs." AS a, $this->_table_employees_jobs AS b
                WHERE a.jobs_id != b.jobs_id AND a.person_id IN ($id) AND jobs_approve = 1 GROUP BY a.jobs_id,jobs_name,jobs_end_date,jobs_start_date,jobs_approve ";
        $data = $this->db->query($sql);

        return $data->result_array();
    }
    /*
    * Function return số công việc mà người đó đã làm
    * */
    public function count_all_jobs_start($person_id)
    {
        $sql = "SELECT b.person_id FROM ".$this->_table_employees_jobs." AS a,
                ".$this->_table_jobs." AS b,$this->_table_jobs_report AS c
                WHERE a.person_id = ".$person_id ." AND a.jobs_id = b.jobs_id
                AND a.employees_jobs_id = c.employees_jobs_id AND jobs_reports_result = 0" ;

        $query = $this->db->query($sql);
        return $query->num_rows();
    }

    /*
     * Function return số công việc mà người đó đã làm
     * */
    public function count_all_jobs_doing($person_id)
    {
        $sql = "SELECT a.person_id FROM ".$this->_table_employees_jobs." AS a,".$this->_table_jobs." AS b, $this->_table_jobs_report AS c
        WHERE a.person_id = ".$person_id ." AND a.jobs_id = b.jobs_id AND c.employees_jobs_id = a.employees_jobs_id AND jobs_reports_result > 0 AND jobs_reports_result < 100" ;

        $result = $this->db->query($sql);
        return $result->num_rows();
    }

    /*
     * function count jobs doing
     * */
    public function count_all_doing($person_id)
    {
        $sql = "SELECT person_id FROM ".$this->_table_employees_jobs." AS a,".$this->_table_jobs." AS b
        WHERE a.person_id = ".$person_id ." AND a.jobs_id = b.jobs_id" ;

        $result = $this->db->query($sql);
        return $result->num_rows();
    }

    /*
     * Function return số công việc mà người đó đã làm
     * */
    public function count_all_jobs_expired($person_id)
    {
        $data = $this->get_jobs_date_expired($person_id);
        foreach($data AS $data){
            $sql = "SELECT a.person_id FROM ".$this->_table_employees_jobs." AS a,".$this->_table_jobs." AS b
            WHERE a.person_id = ".$person_id ." AND a.jobs_id = b.jobs_id AND ". strtotime(date('Y-m-d'))." >=".strtotime($data['jobs_end_date'])."" ;

            $result = $this->db->query($sql);
        }
        return $result->num_rows();
    }
    /*
     * Lấy thông tin công việc quản lý cần duyệt
     * */
    function getManagerApprove($person_id,$limit = 10000, $offset =0, $col='jobs_important',$order = 'DESC')
    {
        $employees_manager = $this->getEmployeesManager($person_id);
        $items = array();
        foreach($employees_manager AS $values){
            $items[]= $values->person_id;
        }
        $id = implode($items,',');
        $sql = " SELECT a.jobs_id,jobs_name,jobs_end_date,jobs_start_date,jobs_approve FROM ".$this->_table_jobs." AS a, $this->_table_employees_jobs AS b
                 WHERE a.jobs_id != b.jobs_id AND a.person_id IN ($id) AND jobs_approve = 1 GROUP BY a.jobs_id,jobs_name,jobs_end_date,jobs_start_date,jobs_approve";


        $data = $this->db->query($sql);

        return $data;
    }
     /*
     * Lấy thông tin công việc quản lý cần duyệt
     * */
    function getManagerNotApprove($person_id,$limit = 10000, $offset =0, $col='jobs_important',$order = 'DESC')
    {
        $employees_manager = $this->getEmployeesManager($person_id);
        $items = array();
        foreach($employees_manager AS $values){
            $items[]= $values->person_id;
        }
        $id = implode($items,',');
        $sql = " SELECT a.jobs_id,jobs_name,jobs_end_date,jobs_start_date,jobs_approve FROM ".$this->_table_jobs." AS a, $this->_table_employees_jobs AS b
                 WHERE a.jobs_id != b.jobs_id AND a.person_id IN ($id) AND jobs_approve = 0 GROUP BY a.jobs_id,jobs_name,jobs_end_date,jobs_start_date,jobs_approve";


        $data = $this->db->query($sql);

        return $data;
    }
    /**
        Lấy tổng số bản ghi của công việc cần duyệt
     */
    function count_all_jobs_manager_not_approve($person_id)
    {
        $employees_manager = $this->getEmployeesManager($person_id);
        $items = array();
        foreach($employees_manager AS $values){
            $items[]= $values->person_id;
        }
        $id = implode($items,',');
        $sql = " SELECT a.jobs_id FROM ".$this->_table_jobs." AS a, $this->_table_employees_jobs AS b
                 WHERE a.jobs_id != b.jobs_id AND a.person_id IN ($id) AND jobs_approve = 0
                 GROUP BY a.jobs_id,jobs_name,jobs_end_date,jobs_start_date,jobs_approve";
        $data = $this->db->query($sql);

        return $data->num_rows();
    }
    /**
        Lấy tổng số bản ghi của công việc cần duyệt
     */
    function count_all_jobs_manager_approve($person_id)
    {
        $employees_manager = $this->getEmployeesManager($person_id);
        $items = array();
        foreach($employees_manager AS $values){
            $items[]= $values->person_id;
        }
        $id = implode($items,',');
        $sql = " SELECT a.jobs_id FROM ".$this->_table_jobs." AS a, $this->_table_employees_jobs AS b
                 WHERE a.jobs_id != b.jobs_id AND a.person_id IN ($id) AND jobs_approve = 1 GROUP BY a.jobs_id,jobs_name,jobs_end_date,jobs_start_date,jobs_approve";
        $data = $this->db->query($sql);
        

        return $data->num_rows();
    }
    /**

    /**
        Lấy thông tin các công việc chưa được duyệt trong bang table jobs
     */
    function count_all_jobs_approve($person_id)
    {
        $sql = "SELECT jobs_id FROM ".$this->_table_jobs." WHERE person_id = ".$person_id ." AND jobs_approve = 1";
       
        $data = $this->db->query($sql);

        return $data->num_rows();
    }
    /**
        Lấy thông tin các công việc chưa được duyệt trong bang table jobs
     */
    function count_all_jobs_not_approve($person_id)
    {
        $sql = "SELECT jobs_id FROM ".$this->_table_jobs." WHERE person_id = ".$person_id ." AND jobs_approve = 0";
        $data = $this->db->query($sql);

        return $data->num_rows();
    }
    /**
        Function get information of the table not approve
     */
    function get_jobs_approve($person_id)
    {
        $sql = "SELECT * FROM ".$this->_table_jobs." WHERE person_id = ".$person_id ." AND jobs_approve = 1";
        $data = $this->db->query($sql);

        return $data;
    }
    /**
        Function get information of the table not approve
     */
    function get_jobs_not_approve($person_id)
    {
        $sql = "SELECT * FROM ".$this->_table_jobs." WHERE person_id = ".$person_id ." AND jobs_approve = 0";
        $data = $this->db->query($sql);

        return $data;
    }
    /*
     * Function return jobs success
     * */
    public function get_jobs_success($person_id = 1,$limit = 10000, $offset =0, $col='jobs_important',$order = 'DESC')
    {
        $sql = "SELECT * FROM "
            .$this->_table_employees_jobs.','.$this->_table_jobs.','.$this->_table_people.",".$this->_table_employees.",$this->_table_jobs_report
             WHERE ".$this->_table_employees_jobs.".person_id = ".$this->_table_people.".person_id AND "
            .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
            .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND "
            .$this->_table_employees_jobs.".employees_jobs_id = ".$this->_table_jobs_report.".employees_jobs_id AND "
            .$this->_table_employees_jobs.".person_id = ".$person_id." AND ".$this->_table_employees.".deleted = 0 AND $this->_table_jobs_report.jobs_reports_result = '100' ".
            " ORDER BY ".$col." ".$order." LIMIT ".$offset.','.$limit;

        $data = $this->db->query($sql);

        return $data;
    }
    /*
     *  Ham lấy tất cả các thành phố thuộc Khu vực lựa chọn
     * */
    function getAllCity($regions_id)
    {
        $sql = "SELECT jobs_city_name,jobs_city_id FROM ".$this->_table_jobs_city.' WHERE jobs_regions_id = '.$regions_id;
        $data = $this->db->query($sql);

        return $data->result();
    }
    /**
        Lấy thông tin từ bảng chi nhánh
     */
    function getActionsDepartment($id,$array_id)
    {
        $sql = "SELECT department_name,department_id FROM ".$this->_table_jobs_department." WHERE jobs_affiliates_id IN ($array_id)";
        $data = $this->db->query($sql);

        return $data->result();

    }
    /*
     * Lấy thông tin tu các chi nhánh
     * */
    function getActionAffiliates($id,$array_id)
    {
        $this->db->select('jobs_affiliates_id,jobs_affiliates_name');
        $this->db->where_in('jobs_city_id',$array_id);
        $data = $this->db->get($this->_table_jobs_affiliates);

        return $data->result();
    }
    /**
        Lấy toàn bộ thông tin nhân viên thuộc phòng đó
     */
    function getActionsEmployees($id,$array_id)
    {
        $sql = "SELECT first_name,a.person_id FROM ".$this->_table_employees.' AS a,'.$this->_table_people." AS b
                WHERE a.person_id = b.person_id AND a.deleted = 0 AND a.department_id IN ($array_id)";
        $data = $this->db->query($sql);

        return $data->result_array();
    }
    
    /*
     * Lấy thông tin toàn bộ nhân viên còn thời hạn hợp đồng
     */
    
    function getActionEmployeesHasContractAll(){
    	$this->db->select('e.person_id,e.department_id,p.first_name');
    	$this->db->from('employees e');
    	$this->db->join('people p','p.person_id = e.person_id','inner');
    	$this->db->join('hopdong h','e.person_id = h.id_employess','inner');
    	$this->db->where('e.deleted',0);
    	$this->db->where('h.date_end >=',date('Y-m-d H:i:s'));
    	$query = $this->db->get();
//    	var_dump($this->db->last_query());
    	return $query->result_array();
    }
    
    
    /*
     *  Lấy thông tin nhân viên thuộc phòng đó và có hợp đồng
     */
    
    
    function getActionsEmployeesHasContract($array_id){
    	
        $this->db->from('jobs_department');
        $this->db->join('people','jobs_department.person_id=people.person_id','inner');
        $this->db->where('department_id',$array_id);
        $query=$this->db->get();
        return $query->result_array();
    }
    
    /*
     * Lấy thông tin đầy đủ nhân viên thuộc phòng đó và có hợp đồng
     */
    function getActionEmployees($id){
    	$this->db->select('p.first_name,e.person_id,e.department_id,d.jobs_affiliates_id,a.jobs_city_id,c.jobs_regions_id');
    	$this->db->from('employees e');
    	$this->db->join('people p','p.person_id = e.person_id','inner');
    	$this->db->join('hopdong h','e.person_id = h.id_employess','inner');
    	$this->db->join('jobs_department d','d.department_id = e.department_id','inner');
    	$this->db->join('jobs_affiliates a','a.jobs_affiliates_id = d.jobs_affiliates_id','inner');
    	$this->db->join('jobs_city c','c.jobs_city_id = a.jobs_city_id','inner');
    	$this->db->join('jobs_regions r','r.jobs_regions_id = c.jobs_regions_id','inner');
    	$this->db->where('e.person_id',$id);
    	$query = $this->db->get();
    	return $query->row_array();
    }

     /*
     * Function return jobs success
     * */
    public function get_jobs_expired($person_id = 1,$limit = 10000, $offset =0, $col='jobs_important',$order = 'DESC')
    {
        $date = $this->get_jobs_date_expired($person_id,$limit, $offset, $col,$order);
        //$data = $this->get_jobs_id_expired($person_id,$limit, $offset, $col,$order);

        foreach($date AS $date){

            $sql = "SELECT * FROM "
                .$this->_table_employees_jobs.','.$this->_table_jobs.','.$this->_table_people.",".$this->_table_employees.",$this->_table_jobs_report
                 WHERE (".$this->_table_employees_jobs.".person_id = ".$this->_table_people.".person_id AND "
                .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
                .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND "
                .$this->_table_jobs_report.".employees_jobs_id = ".$this->_table_employees_jobs.".employees_jobs_id AND "
                .$this->_table_employees_jobs.".person_id = ".$person_id." AND ".$this->_table_employees.".deleted = 0
                 AND jobs_reports_result != 100 AND ". strtotime(date('Y-m-d'))." >=".strtotime($date['jobs_end_date']).
                ") ORDER BY ".$col." ".$order." LIMIT ".$offset.','.$limit;


             $data = $this->db->query($sql);
        }
        //echo $sql;
        return $data;

    }
     /*
     * Lấy thông tin ngày thực hiện cảnh báo công việc hết hạn
     * */
    public function get_jobs_date_expired($person_id = 1,$limit = 10000, $offset =0, $col='jobs_important',$order = 'DESC')
    {
        $sql = "SELECT jobs_end_date,jobs_start_date,.$this->_table_jobs.jobs_id FROM "
                .$this->_table_employees_jobs.','.$this->_table_jobs.','.$this->_table_people.",".$this->_table_employees."
                 WHERE ".$this->_table_employees_jobs.".person_id = ".$this->_table_people.".person_id AND "
                .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
                .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND "
                .$this->_table_employees_jobs.".person_id = ".$person_id." AND ".$this->_table_employees.".deleted = 0".
                " ORDER BY ".$col." ".$order." LIMIT ".$offset.','.$limit;

        $data = $this->db->query($sql);

        return $data->result_array();

    }
    public function get_jobs_id_expired($person_id = 1,$limit = 10000, $offset =0, $col='jobs_important',$order = 'DESC')
    {
        $sql = "SELECT $this->_table_jobs.jobs_id FROM "
            .$this->_table_employees_jobs.','.$this->_table_jobs.','.$this->_table_people.",".$this->_table_employees."
             WHERE ".$this->_table_employees_jobs.".person_id = ".$this->_table_people.".person_id AND "
            .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
            .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND "
            .$this->_table_employees_jobs.".person_id = ".$person_id." AND ".$this->_table_employees.".deleted = 0".
            " ORDER BY ".$col." ".$order." LIMIT ".$offset.','.$limit;

        $data = $this->db->query($sql);

        return $data->result_array();

    }
    /*
     * Function return jobs success
     * */
    public function get_jobs_near_expired($person_id = 1,$limit = 10000, $offset =0, $col='jobs_name',$order = 'DESC',$config_number = 1 )
    {

       $sql = "SELECT * FROM "
              .$this->_table_employees_jobs.','.$this->_table_jobs.','.$this->_table_people.",".$this->_table_employees.",$this->_table_jobs_report
              WHERE ".$this->_table_employees_jobs.".person_id = ".$this->_table_people.".person_id AND "
              .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
              .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND "
              .$this->_table_employees_jobs.".employees_jobs_id = ".$this->_table_jobs_report.".employees_jobs_id AND "
              .$this->_table_employees_jobs.".person_id = ".$person_id." AND ".$this->_table_employees.".deleted = 0
              AND ".floor(abs(strtotime($this->_table_jobs.'jobs_end_date')."-".strtotime(date('Y-m-d')))/(60 * 60 * 24)).
              "= $config_number ORDER BY ".$col." ".$order." LIMIT ".$offset.','.$limit;
       //echo $sql;
       $data = $this->db->query($sql);

       return $data;
    }
    /**
        Function lấy thông tin cấu hình cảnh báo ngày hết hạn
     */
    public function get_jobs_date_near_expired($person_id = 1,$limit = 10000, $offset =0, $col='jobs_name',$order = 'DESC',$config_number = 1 )
    {

        $sql = "SELECT * FROM "
            .$this->_table_employees_jobs.','.$this->_table_jobs.','.$this->_table_people.",".$this->_table_employees.",$this->_table_jobs_report
              WHERE ".$this->_table_employees_jobs.".person_id = ".$this->_table_people.".person_id AND "
            .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
            .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND "
            .$this->_table_employees_jobs.".employees_jobs_id = ".$this->_table_jobs_report.".employees_jobs_id AND "
            .$this->_table_employees_jobs.".person_id = ".$person_id." AND ".$this->_table_employees.".deleted = 0
             ORDER BY ".$col." ".$order." LIMIT ".$offset.','.$limit;
        echo $sql;
        $data = $this->db->query($sql);

        return $data;
    }
     /*
         * Function return jobs start
         * */
        public function get_jobs_start($person_id = 1,$limit = 10000, $offset =0, $col='jobs_important',$order = 'DESC')
        {
            $sql = "SELECT * FROM "
                .$this->_table_employees_jobs.','.$this->_table_jobs.','.$this->_table_people.",".$this->_table_employees.",$this->_table_jobs_report
                WHERE ".$this->_table_employees_jobs.".person_id = ".$this->_table_people.".person_id AND "
                .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
                .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND "
                .$this->_table_employees_jobs.".employees_jobs_id = ".$this->_table_jobs_report.".employees_jobs_id AND "
                .$this->_table_employees_jobs.".person_id = ".$person_id." AND ".$this->_table_employees.".deleted = 0
                 AND $this->_table_jobs_report.jobs_reports_result = '0' ".
                " ORDER BY ".$col." ".$order." LIMIT ".$offset.','.$limit;

            $data = $this->db->query($sql);

            return $data;
        }
/*
         * Function return jobs start
         * */
        public function get_jobs_doing($person_id = 1,$limit = 10000, $offset =0, $col='jobs_important',$order = 'DESC')
        {

            $sql = "SELECT * FROM "
                .$this->_table_employees_jobs.','.$this->_table_jobs.','.$this->_table_people.",".$this->_table_employees."
                WHERE ".$this->_table_employees_jobs.".person_id = ".$this->_table_people.".person_id AND "
                .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
                .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND "
                .$this->_table_employees_jobs.".person_id = ".$person_id." AND ".$this->_table_employees.".deleted = 0 ".
                " ORDER BY ".$col." ".$order." LIMIT ".$offset.','.$limit;
            $data = $this->db->query($sql);

            return $data;
        }

    function get_jobs_parent($person_id)
    {
        if($person_id == 1){
            $sql = "SELECT a.jobs_id,jobs_name,jobs_parent,employees_jobs_parent_id FROM ".$this->_table_jobs." AS a,".$this->_table_employees_jobs.
                   " AS b WHERE a.jobs_id = b.jobs_id GROUP BY a.jobs_id,jobs_name,jobs_parent ";
            $query = $this->db->query($sql);
        }else{

            $sql = "SELECT a.jobs_id,jobs_name,jobs_parent,employees_jobs_parent_id FROM ".$this->_table_jobs." AS a,".$this->_table_employees_jobs.
                " AS b WHERE a.jobs_id = b.jobs_id AND b.person_id = ".$person_id." GROUP BY a.jobs_id,jobs_name,jobs_parent ";
            $query = $this->db->query($sql);
        }

        return $query->result();
    }

    /*
  Returns all the employees
  */
    function get_my_jobs_all($person_id,$limit = 10000, $offset =0, $col='jobs_important',$order = 'DESC')
    {
        $sql = "SELECT * FROM ".$this->_table_jobs." WHERE person_id = $person_id ORDER BY ".$col." ".$order." LIMIT $offset,$limit ";
        $data = $this->db->query($sql);

        return $data;
    }
  /*
  Returns all the employees
  */
    function get_my_manager_jobs_all($person_id,$limit = 10000, $offset =0, $col='jobs_important',$order = 'DESC')
    {
        $sql = "SELECT * FROM ".$this->_table_employees_jobs." WHERE employees_jobs_parent_id = $person_id ORDER BY ".$col." ".$order." LIMIT $offset,$limit ";
        $data = $this->db->query($sql);

        return $data;
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
    /*
     * Function show information for manager
     * */
    function get_jobs_manager($person_id = 1,$limit = 10000, $offset =0, $col='jobs_important',$order = 'DESC')
    {
        $sql = "SELECT * FROM "
            .$this->_table_employees_jobs.','.$this->_table_jobs.','.$this->_table_people.",".$this->_table_employees."
             WHERE ".$this->_table_employees_jobs.".person_id = ".$this->_table_people.".person_id AND "
            .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
            .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND "
            .$this->_table_employees_jobs.".employees_jobs_parent_id = ".$person_id." AND ".$this->_table_employees.".deleted = 0".
            " ORDER BY ".$col." ".$order." LIMIT ".$offset.','.$limit;

        $data = $this->db->query($sql);

        return $data;
    }
    /*
     * Function show get parent jobs
    */
    public function get_parent_jobs($person_id =1 ,$limit = 10000, $offset =0, $col='last_name',$order = 'DESC')
    {
        $sql = " SELECT first_name,b.employees_jobs_parent_id
                 FROM ".$this->_table_people ." AS a,".$this->_table_employees_jobs." AS b,".$this->_table_employees." AS c
                 WHERE b.person_id = c.person_id AND a.person_id = b.employees_jobs_parent_id AND deleted = 0 ".
                 "GROUP BY first_name,b.employees_jobs_parent_id ";

        $query = $this->db->query($sql);
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

    function get_manager_employees($person_id = 1,$limit = 10000, $offset =0, $col='first_name',$order = 'DESC')
    {
         $sql = "SELECT first_name,last_name,a.person_id,parent_id
                 FROM ".$this->_table_employees." AS a,".$this->_table_people."
                 AS b WHERE (a.parent_id = ".$person_id ." AND deleted = 0 AND a.person_id = b.person_id )
                 OR (a.person_id = ".$person_id ." AND deleted = 0 AND a.person_id = b.person_id )
                 GROUP BY first_name,last_name,a.person_id,parent_id ORDER BY $col ". $order ." LIMIT $offset,$limit";

        $data = $this->db->query($sql);
        return $data->result_array();
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

            if(empty($array_id)){
                $sql = "SELECT first_name,last_name,$this->_table_employees.person_id
                    FROM ".$this->_table_people.','.$this->_table_employees .','.$this->_table_permissions.'
                    WHERE '.$this->_table_people .'.person_id = '.$this->_table_employees.'.person_id'."
                           AND ".$this->_table_permissions.".person_id = ".$this->_table_employees.'.person_id' ."
                           AND module_id = 'jobs'
                           AND $this->_table_employees.deleted = 0";

                $query = $this->db->query($sql);

            }else{
                $sql = "SELECT first_name,last_name,$this->_table_employees.person_id
                    FROM ".$this->_table_people.','.$this->_table_employees .','.$this->_table_permissions.'
                    WHERE '.$this->_table_people .'.person_id = '.$this->_table_employees.'.person_id '."
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
    function get_search_employees_suggestions($search,$person_id,$limit=10000)
    {
        $this->db->from($this->_table_people);
        $this->db->join($this->_table_employees,$this->_table_people.'.person_id ='. $this->_table_employees.'.person_id ');
        $this->db->where(($this->_table_employees.'.parent_id = '.$person_id." AND deleted = 0")."
        OR (".$this->_table_employees.'.person_id = '.$person_id." AND deleted = 0".")" );
        $this->db->like("first_name",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->group_by("first_name");
        $this->db->order_by("first_name", "DESC");
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
            if($this->db->insert($this->_table_employees_jobs,$item_data))
            {
                return true;
            }
            return false;
        }

        $this->db->where('employees_jobs_id', $employee_jobs_id);
        return $this->db->update($this->_table_employees_jobs,$item_data);
    }
    function get_jobs_employees_parent($person_id)
    {
        $sql = "SELECT parent_id FROM ".$this->_table_employees ." WHERE person_id = ".$person_id.' AND deleted = 0 LIMIT 0,1';
        $data = $this->db->query($sql);

        return $data->result_array();
    }
    function get_one()
    {
        $sql = "SELECT jobs_id FROM ".$this->_table_jobs.' ORDER BY jobs_id DESC LIMIT 0,1';

        $result = $this->db->query($sql);
        return $result->result_array();
    }
    public function checkName($jobs_name,$id)
    {
        if(empty($id) OR $id == -1){
            $this->db->where("jobs_name LIKE '".$this->db->escape_like_str($jobs_name)."'");
        }else{
            $this->db->where("jobs_name LIKE '".$this->db->escape_like_str($jobs_name)."' AND jobs_id != ".$id);
        }

        $result = $this->db->get($this->_table_jobs);
        return $result->num_rows();
    }
    /*
    Inserts or updates an employee
    */
    function save_one(&$item_data,$jobs_id = '',$person_id)
    {
        if($this->checkName($item_data['jobs_name'],$jobs_id) == 0){
            $parent_id = $this->get_jobs_employees_parent($person_id);
            if(empty($jobs_id))
            {
                if($this->db->insert($this->_table_jobs,$item_data))
                {
                    $query = $this->get_one();
                    $jobs_id = $query[0]['jobs_id'];
                    $data = array('jobs_id'=>$jobs_id,'person_id'=>$person_id,'employees_jobs_parent_id'=> $parent_id[0]['parent_id'],'employees_jobs_date'=>$item_data['jobs_start_date'],'employees_jobs_content'=>$item_data['jobs_content'],'employees_jobs_expired'=>'');

                    if($this->db->insert($this->_table_employees_jobs,$data)){
                        return true;
                    }
                }
                return false;
            }
            $this->db->from($this->_table_jobs);
            $this->db->where($this->_table_jobs.'.jobs_id',$jobs_id);
            if($this->db->update($this->_table_jobs,$item_data)){
                $query = $this->get_one();
                $jobs_id = $query[0]['jobs_id'];
                $data = array('person_id'=>$person_id,'employees_jobs_parent_id'=> $parent_id[0]['parent_id'],'employees_jobs_date'=>$item_data['jobs_start_date'],'employees_jobs_content'=>$item_data['jobs_content'],'employees_jobs_expired'=>'');

                $this->db->from($this->_table_employees_jobs);
                $this->db->where($this->_table_employees_jobs.'.jobs_id',$jobs_id);
                if($this->db->update($this->_table_employees_jobs,$data)){
                    return true;
                }
            }
        }

        return false;

    }
    function count_all_my_jobs($person_id)
    {
        $this->db->from($this->_table_jobs);
        $this->db->where('person_id',$person_id);

        return $this->db->count_all_results();
    }
     function count_all_my_manager_jobs($person_id)
    {
        $this->db->from($this->_table_employees_jobs);
        $this->db->where('employees_jobs_parent_id',$person_id);

        return $this->db->count_all_results();
    }
    function get_jobs_info($jobs_id)
    {
        $this->db->from($this->_table_jobs);
        $this->db->where('jobs_id',$jobs_id);
        $query = $this->db->get();

        return $query->row();

    }

    function get_jobs_status_info()
    {
        $sql = "SELECT * FROM ".$this->_table_jobs_status;
        $query = $this->db->query($sql);
        return $query->result();
    }

    function get_jobs_success_one($person_id, $limit = 10000, $offset =0, $col='jobs_important',$order = 'DESC')
    {
        $sql = "SELECT * FROM ".$this->_table_jobs." WHERE person_id = $person_id ORDER BY ".$col." ".$order." LIMIT $offset,$limit ";
        $data = $this->db->query($sql);

        return $data;
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
    function get_search_my_suggestions($search, $person_id = '',$limit=10000)
    {
        $this->db->from($this->_table_jobs);
        $this->db->join($this->_table_employees_jobs,$this->_table_employees_jobs.'.jobs_id ='. $this->_table_jobs.'.jobs_id');
        $this->db->where($this->_table_employees_jobs.'.person_id = '.$person_id);
        $this->db->like("jobs_name",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
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

    function get_search_manager_suggestions($search, $person_id,$limit=10000)
    {
        $this->db->from($this->_table_jobs);
        $this->db->join($this->_table_employees_jobs,$this->_table_employees_jobs.'.jobs_id ='. $this->_table_jobs.'.jobs_id');
        $this->db->where($this->_table_employees_jobs.'.employees_jobs_parent_id = '.$person_id);
        $this->db->like("jobs_name",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
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

        $this->db->from($this->_table_employees_jobs);
        $this->db->join('jobs',$this->_table_employees_jobs.'.jobs_id = jobs.jobs_id');
        $this->db->like("jobs_name",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("jobs_name", "DESC");
        $by_jobs_name = $this->db->get();
        foreach($by_jobs_name->result() as $row)
        {
            $suggestions[]=array('label'=> $row->jobs_name);
        }

        $this->db->from($this->_table_employees_jobs);
        $this->db->join('jobs',$this->_table_employees_jobs.'.jobs_id = jobs.jobs_id');
        $this->db->like("jobs_content",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("jobs_content", "DESC");
        $by_jobs_content = $this->db->get();
        foreach($by_jobs_content->result() as $row)
        {
            $suggestions[]=array('label'=> $row->jobs_content);
        }

        $this->db->from($this->_table_employees_jobs);
        $this->db->join('jobs',$this->_table_employees_jobs.'.jobs_id = jobs.jobs_id');
        $this->db->like("jobs_start_date",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("jobs_start_date", "DESC");
        $by_jobs_start_date = $this->db->get();
        foreach($by_jobs_start_date->result() as $row)
        {
            $suggestions[]=array('label'=> $row->jobs_start_date);
        }

        $this->db->from($this->_table_employees_jobs);
        $this->db->join('jobs',$this->_table_employees_jobs.'.jobs_id = jobs.jobs_id');
        $this->db->like("jobs_end_date",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("jobs_end_date", "DESC");
        $by_jobs_end_date = $this->db->get();
        foreach($by_jobs_end_date->result() as $row)
        {
            $suggestions[]=array('label'=> $row->jobs_end_date);
        }
        //only return $limit suggestions
        if(count($suggestions) > $limit)
        {
            $suggestions = array_slice($suggestions, 0, $limit);
        }

        return $suggestions;

    }

    function my_search($search, $person_id, $limit=2,$offset=0,$column='jobs_important',$orderby='DESC')
    {
        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->from($this->_table_jobs);
            $this->db->join($this->_table_employees_jobs,$this->_table_jobs.'.jobs_id = '.$this->_table_employees_jobs.".jobs_id");
            $this->db->where("jobs_name LIKE '%".$this->db->escape_like_str($search)."%' AND employees_jobs_parent_id = ".$person_id);
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);
            return $this->db->get();
        }
        else
        {
            $this->db->from($this->_table_jobs);
            $this->db->join($this->_table_employees_jobs,$this->_table_jobs.'.jobs_id = '.$this->_table_employees_jobs.".jobs_id");
            $this->db->where("jobs_name LIKE '%".$this->db->escape_like_str($search)."%' AND employees_jobs_parent_id = ".$person_id);
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);
            return $this->db->get();
        }
    }


    /*
    Preform a search on employees
    */
    function search($search, $limit=20,$offset=0,$column='last_name',$orderby='DESC')
    {
        if ($this->config->item('speed_up_search_queries'))
        {

            $this->db->from('jobs,jobs_employees,employees,people');
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
        else
        {
            $this->db->from('jobs,jobs_employees,employees,people');
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
    function search_my_count_all($search,$person_id, $limit=10000,$offset=0)
    {
        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->from($this->_table_jobs);
            $this->db->join($this->_table_employees_jobs,$this->_table_jobs.'.jobs_id = '.$this->_table_employees_jobs.".jobs_id");
            $this->db->where("jobs_name LIKE '%".$this->db->escape_like_str($search)."%' AND employees_jobs_parent_id = ".$person_id);
            $this->db->limit($limit);
            $this->db->offset($offset);
            $result=$this->db->get();
            return $result->num_rows();
        }
        else
        {
            $this->db->from($this->_table_jobs);
            $this->db->join($this->_table_employees_jobs,$this->_table_jobs.'.jobs_id = '.$this->_table_employees_jobs.".jobs_id");
            $this->db->where("jobs_name LIKE '%".$this->db->escape_like_str($search)."%' AND employees_jobs_parent_id = ".$person_id);
            $this->db->limit($limit);
            $this->db->offset($offset);
            $result=$this->db->get();
            return $result->num_rows();
        }
    }
    function one_search($search, $person_id, $limit=2,$offset=0,$column='first_name',$orderby='DESC')
    {
        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->from($this->_table_people);
            $this->db->join($this->_table_employees,$this->_table_people.'.person_id = '.$this->_table_employees.".person_id");
            $this->db->where(("first_name LIKE '%".$this->db->escape_like_str($search)."%' AND parent_id = ".$person_id)."
            OR ("."first_name LIKE '%".$this->db->escape_like_str($search)."%' AND $this->_table_employees.person_id = ".$person_id.")");
            $this->db->group_by($column);
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);
            return $this->db->get();
        }
        else
        {
            $sql = "SELECT * FROM ".$this->_table_people.",".$this->_table_employees ."
               WHERE $this->_table_people.person_id = $this->_table_employees.person_id AND first_name LIKE '%".$this->db->escape_like_str($search)."%' AND parent_id = ".$person_id ;
            $this->db->from($this->_table_people);
            $this->db->join($this->_table_employees,$this->_table_people.'.person_id = '.$this->_table_employees.".person_id");
            $this->db->where(("first_name LIKE '%".$this->db->escape_like_str($search)."%' AND parent_id = ".$person_id)."
            OR ("."first_name LIKE '%".$this->db->escape_like_str($search)."%' AND $this->_table_employees.person_id = ".$person_id.")");
            $this->db->group_by($column);
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);
            return $this->db->get();
        }
    }

    function search_one_count_all($search,$person_id, $limit=10000,$offset=0,$column='first_name',$orderby='DESC')
    {
        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->join($this->_table_employees,$this->_table_people.'.person_id = '.$this->_table_employees.".person_id");
            $this->db->where(("first_name LIKE '%".$this->db->escape_like_str($search)."%' AND parent_id = ".$person_id)."
            OR ("."first_name LIKE '%".$this->db->escape_like_str($search)."%' AND $this->_table_employees.person_id = ".$person_id.")");
            $this->db->group_by($column);
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);
            $result=$this->db->get();

            return $result->num_rows();
        }
        else
        {
            $this->db->join($this->_table_employees,$this->_table_people.'.person_id = '.$this->_table_employees.".person_id");
            $this->db->where(("first_name LIKE '%".$this->db->escape_like_str($search)."%' AND parent_id = ".$person_id)."
            OR ("."first_name LIKE '%".$this->db->escape_like_str($search)."%' AND $this->_table_employees.person_id = ".$person_id.")");
            $this->db->group_by($column);
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);
            $result=$this->db->get();

            return $result->num_rows();
        }
    }
    
    function get_info_one_file_emp($jobs_id = -1)
	{
		//$table_contract = $this->db->dbprefix('jobs');
                $sql = "SELECT jobs_url_file FROM ".$this->_table_employees_jobs." WHERE jobs_id = $jobs_id";
                $data = $this->db->query($sql);

                return $data->row();
    }
    
    function save_approve($item,$jobs_id)
    {
        $this->db->where('jobs_id',$jobs_id);
        if( $this->db->update($this->_table_jobs,$item)){
            return true;
        }
        return false;
    }
    function search_count_all($search, $limit=10000)
    {
        if ($this->config->item('speed_up_search_queries'))
        {

            $this->db->from('jobs,jobs_employees,employees,people');
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
        else
        {
            $this->db->from('jobs,jobs_employees,employees,people');
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

}

