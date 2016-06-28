<?php
class Jobs_reports extends Employee
{
    public function __construct(){
        parent::__construct();
        $this->_table_employees_jobs = $this->db->dbprefix('jobs_employees');
        $this->_table_jobs_report = $this->db->dbprefix('jobs_report');
        $this->_table_people = $this->db->dbprefix('people');
        $this->_table_permissions = $this->db->dbprefix('permissions');
        $this->_table_permissions_action = $this->db->dbprefix('permissions_actions');
        $this->_table_jobs = $this->db->dbprefix('jobs');
        $this->_table_employees = $this->db->dbprefix('employees');
        $this->_table_department = $this->db->dbprefix('jobs_department');
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
        if($person_id == 1){
            $sql = "SELECT jobs_reports_id FROM ".$this->_table_employees_jobs." AS a,".$this->_table_jobs_report." AS b, ".$this->_table_employees." AS c
                    WHERE a.employees_jobs_id = b.employees_jobs_id AND a.person_id = c.person_id AND deleted = 0 ";
            $this->db->query($sql);

            return $this->db->count_all_results();
        }else{
            $sql = "SELECT jobs_reports_id FROM ".$this->_table_employees_jobs." AS a,".$this->_table_jobs_report." AS b, ".$this->_table_employees." AS c
                    WHERE a.employees_jobs_id = b.employees_jobs_id AND a.person_id = c.person_id AND deleted = 0 AND a.person_id = ".$person_id;
            $this->db->query($sql);

            return $this->db->count_all_results();
        }
    }
     /* ByAuthor: @SnguyenOne
     * - Function: count_all()
     * - Description: Get total record of the table $_table_employees_jobs
     * - Param : param :$person_id is validator
     * - Return : number round this table
     *
     * */

    public function count_all_success($person_id)
    {
        if($person_id == 1){
            $sql = "SELECT jobs_reports_id FROM ".$this->_table_employees_jobs." AS a,".$this->_table_jobs_report." AS b, ".$this->_table_employees." AS c
                    WHERE a.employees_jobs_id = b.employees_jobs_id AND a.person_id = c.person_id AND deleted = 0 AND jobs_reports_status = 1";
            $this->db->query($sql);

            return $this->db->count_all_results();
        }else{
            $sql = "SELECT jobs_reports_id FROM ".$this->_table_employees_jobs." AS a,".$this->_table_jobs_report." AS b, ".$this->_table_employees." AS c
                    WHERE a.employees_jobs_id = b.employees_jobs_id AND a.person_id = c.person_id AND deleted = 0 AND a.person_id = ".$person_id ." AND jobs_reports_status = 1";
            $this->db->query($sql);

            return $this->db->count_all_results();
        }
    }
    /* ByAuthor: @SnguyenOne
     * - Function: count_all()
     * - Description: Get total record of the table $_table_employees_jobs
     * - Param : param :$person_id is validator
     * - Return : number round this table
     *
     * */

    public function count_all_error($person_id)
    {
        if($person_id == 1){
            $sql = "SELECT jobs_reports_id FROM ".$this->_table_employees_jobs." AS a,".$this->_table_jobs_report." AS b, ".$this->_table_employees." AS c
                    WHERE a.employees_jobs_id = b.employees_jobs_id AND a.person_id = c.person_id AND deleted = 0 AND jobs_reports_status = 0";
            $this->db->query($sql);

            return $this->db->count_all_results();
        }else{
            $sql = "SELECT jobs_reports_id FROM ".$this->_table_employees_jobs." AS a,".$this->_table_jobs_report." AS b, ".$this->_table_employees." AS c
                    WHERE a.employees_jobs_id = b.employees_jobs_id AND a.person_id = c.person_id AND deleted = 0 AND a.person_id = ".$person_id ." AND jobs_reports_status = 0";
            $this->db->query($sql);

            return $this->db->count_all_results();
        }
    }
    /**
        Function get information Exel
         * NAME TABLE : jobs_report,jobs,jobs_employees,employees,department
     *    Đơn vị - jobs_department :   lấy thông tin department_name
     *    Nội dung công việc, ngày bắt đầu, ngày kết thúc - jobs :jobs_content,jobs_start_date,jobs_end_date
     *    Ngày hoàn thành công việc - jobs_report{ jobs_reports_date if(jobs_reports_result == 100) echo jobs_reports_date
     *    Ngày phê duyệt - jobs_report: jobs_report_date_manager
     *    Tiến độ công việc : jobs_reports_result
     *    Tự đánh giá : Nội dung tụ đánh giá của nhân viên : jobs_reports_content
     *    Cấp trên trực tiếp đánh giá : jobs_reports_comment
     */
     function getReportExel($person_id,$start_date,$end_date)
     {
         $data = $this->getDateReport($person_id);
         foreach($data AS $data){

             $sql = "SELECT * FROM ".$this->_table_jobs_report." AS a,"
                                    .$this->_table_employees_jobs." AS b,"
                                    .$this->_table_employees." AS c,"
                                    .$this->_table_department." AS d,"
                                    .$this->_table_jobs." AS e ".
                 " WHERE
                        a.employees_jobs_id = b.employees_jobs_id AND
                        b.jobs_id = e.jobs_id AND
                        b.person_id = c.person_id AND
                        c.department_id = d.department_id AND
                        b.person_id =".$person_id." AND
                        c.deleted = 0 AND
                        ".strtotime($end_date)."<=".strtotime($data['jobs_end_date']) ." AND
                         ".strtotime($start_date).">=".strtotime($data['jobs_start_date']);
             ;
             $data = $this->db->query($sql);
         }


         echo $sql;
         return $data->result_array();
     }
     public function getDateReport($person_id)
     {
         $sql = "SELECT jobs_end_date,jobs_start_date FROM ".$this->_table_jobs_report." AS a,"
             .$this->_table_employees_jobs." AS b,"
             .$this->_table_employees." AS c,"
             .$this->_table_department." AS d,"
             .$this->_table_jobs." AS e ".
             " WHERE
                    a.employees_jobs_id = b.employees_jobs_id AND
                    b.jobs_id = e.jobs_id AND
                    b.person_id = c.person_id AND
                    c.department_id = d.department_id AND
                    b.person_id =".$person_id." AND
                    c.deleted = 0 ";

         $data = $this->db->query($sql);

         return $data->result_array();
     }
       /*
     * Khái báo var trong class
     */

    /* ByAuthor: @SnguyenOne
     * - Function: count_all_manager()
     * - Description: Get total record of the table $_table_employees_jobs
     * - Param : param :$person_id is validator
     * - Return : number round this table
     *
     * */

    public function count_all_manager($person_id)
    {
        if($person_id == 1){
            $sql = "SELECT jobs_reports_id FROM ".$this->_table_employees_jobs." AS a,".$this->_table_jobs_report." AS b, ".$this->_table_employees." AS c
                    WHERE a.employees_jobs_id = b.employees_jobs_id AND a.person_id = c.person_id AND deleted = 0 ";
            $this->db->query($sql);

            return $this->db->count_all_results();
        }else{
            $sql = "SELECT jobs_reports_id FROM ".$this->_table_employees_jobs." AS a,".$this->_table_jobs_report." AS b, ".$this->_table_employees." AS c
                    WHERE a.employees_jobs_id = b.employees_jobs_id AND a.person_id = c.person_id AND deleted = 0 AND a.employees_jobs_parent_id = ".$person_id;
            $this->db->query($sql);

            return $this->db->count_all_results();
        }
    }


    public function count_all_manager_success($person_id)
    {
        if($person_id == 1){
            $sql = "SELECT jobs_reports_id FROM ".$this->_table_employees_jobs." AS a,".$this->_table_jobs_report." AS b, ".$this->_table_employees." AS c
                    WHERE a.employees_jobs_id = b.employees_jobs_id AND a.person_id = c.person_id AND deleted = 0  AND b.jobs_reports_status = 1 ";
            $this->db->query($sql);

            return $this->db->count_all_results();
        }else{
            $sql = "SELECT jobs_reports_id FROM ".$this->_table_employees_jobs." AS a,".$this->_table_jobs_report." AS b, ".$this->_table_employees." AS c
                    WHERE a.employees_jobs_id = b.employees_jobs_id AND a.person_id = c.person_id AND deleted = 0 AND b.jobs_reports_status = 1 AND a.employees_jobs_parent_id = ".$person_id;
            $this->db->query($sql);

            return $this->db->count_all_results();
        }
    }
    /* ByAuthor: @SnguyenOne
   * - Function: count_all_manager_error()
   * - Description: Get total record of the table $_table_employees_jobs
   * - Param : param :$person_id is validator
   * - Return : number round this table
   *   * */
    public function count_all_manager_error($person_id)
    {
        if($person_id == 1){
            $sql = "SELECT jobs_reports_id FROM ".$this->_table_employees_jobs." AS a,".$this->_table_jobs_report." AS b, ".$this->_table_employees." AS c
                    WHERE a.employees_jobs_id = b.employees_jobs_id AND a.person_id = c.person_id AND deleted = 0  AND b.jobs_reports_status = 0 ";
            $this->db->query($sql);

            return $this->db->count_all_results();
        }else{
            $sql = "SELECT jobs_reports_id FROM ".$this->_table_employees_jobs." AS a,".$this->_table_jobs_report." AS b, ".$this->_table_employees." AS c
                    WHERE a.employees_jobs_id = b.employees_jobs_id AND a.person_id = c.person_id AND deleted = 0 AND b.jobs_reports_status = 0 OR jobs_reports_status ='' AND a.employees_jobs_parent_id = ".$person_id;
            $this->db->query($sql);


            return $this->db->count_all_results();
        }
    }
    public function count_number_manager_error($person_id)
    {
        if($person_id == 1){
            $sql = "SELECT jobs_reports_id FROM ".$this->_table_employees_jobs." AS a,".$this->_table_jobs_report." AS b, ".$this->_table_employees." AS c
                    WHERE a.employees_jobs_id = b.employees_jobs_id AND a.person_id = c.person_id AND deleted = 0  AND b.jobs_reports_status = 0 ";
            $result = $this->db->query($sql);

            return $result->num_rows();
        }else{
            $sql = "SELECT jobs_reports_id FROM ".$this->_table_employees_jobs." AS a,".$this->_table_jobs_report." AS b, ".$this->_table_employees." AS c
                    WHERE a.employees_jobs_id = b.employees_jobs_id AND a.person_id = c.person_id AND deleted = 0 AND b.jobs_reports_status = 0 AND a.employees_jobs_parent_id = ".$person_id;
            $result = $this->db->query($sql);

            return $result->num_rows();
        }
    }
     public function count_number_manager_success($person_id)
        {
            if($person_id == 1){
                $sql = "SELECT jobs_reports_id FROM ".$this->_table_employees_jobs." AS a,".$this->_table_jobs_report." AS b, ".$this->_table_employees." AS c
                        WHERE a.employees_jobs_id = b.employees_jobs_id AND a.person_id = c.person_id AND deleted = 0  AND b.jobs_reports_status = 1 ";
                $result = $this->db->query($sql);

                return $result->num_rows();
            }else{
                $sql = "SELECT jobs_reports_id FROM ".$this->_table_employees_jobs." AS a,".$this->_table_jobs_report." AS b, ".$this->_table_employees." AS c
                        WHERE a.employees_jobs_id = b.employees_jobs_id AND a.person_id = c.person_id AND deleted = 0 AND b.jobs_reports_status = 1 AND a.employees_jobs_parent_id = ".$person_id;
                $result = $this->db->query($sql);

                return $result->num_rows();
            }
        }

    /*
   Returns all the employees
   */
    function get_all($person_id,$limit = 10000, $offset =0, $col='jobs_important',$order = 'DESC')
    {
        if($person_id == 1){
            $sql = "SELECT * FROM "
                .$this->_table_employees_jobs.','.$this->_table_jobs.','.$this->_table_people.','.$this->_table_employees.",".$this->_table_jobs_report."
                WHERE ".$this->_table_employees_jobs.".person_id = ".$this->_table_people.".person_id AND "
                .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
                .$this->_table_employees_jobs .".employees_jobs_id = ".$this->_table_jobs_report .".employees_jobs_id AND "
                .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND ".$this->_table_employees.".deleted = 0
                ORDER BY ".$col." ".$order." LIMIT ".$offset.','.$limit ;

            $data = $this->db->query($sql);

        }else{

            $sql = "SELECT * FROM "
                .$this->_table_employees_jobs.','.$this->_table_jobs.','.$this->_table_people.",".$this->_table_employees.",".$this->_table_jobs_report."
                WHERE ".$this->_table_employees_jobs.".person_id = ".$this->_table_people.".person_id AND "
                .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
                .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND "
                .$this->_table_employees_jobs.".employees_jobs_id = ".$this->_table_jobs_report.".employees_jobs_id AND "
                .$this->_table_employees_jobs.".person_id = ".$person_id." AND ".$this->_table_employees.".deleted = 0".
                " ORDER BY ".$col." ".$order." LIMIT ".$offset.','.$limit;

            $data = $this->db->query($sql);
        }
       
        return $data;
    }
    /*
   Returns all the employees
   */
    function get_all_success($person_id,$limit = 10000, $offset =0, $col='jobs_important',$order = 'DESC')
    {
        if($person_id == 1){
            $sql = "SELECT * FROM "
                .$this->_table_employees_jobs.','.$this->_table_jobs.','.$this->_table_people.','.$this->_table_employees.",".$this->_table_jobs_report."
                WHERE ".$this->_table_employees_jobs.".person_id = ".$this->_table_people.".person_id AND "
                .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
                .$this->_table_employees_jobs .".employees_jobs_id = ".$this->_table_jobs_report .".employees_jobs_id AND "
                .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND ".$this->_table_employees.".deleted = 0
                AND jobs_reports_status = 1 ORDER BY ".$col." ".$order." LIMIT ".$offset.','.$limit ;

            $data = $this->db->query($sql);

        }else{

            $sql = "SELECT * FROM "
                .$this->_table_employees_jobs.','.$this->_table_jobs.','.$this->_table_people.",".$this->_table_employees.",".$this->_table_jobs_report."
                WHERE ".$this->_table_employees_jobs.".person_id = ".$this->_table_people.".person_id AND "
                .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
                .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND "
                .$this->_table_employees_jobs.".employees_jobs_id = ".$this->_table_jobs_report.".employees_jobs_id AND "
                .$this->_table_employees_jobs.".person_id = ".$person_id." AND ".$this->_table_employees.".deleted = 0  AND jobs_reports_status = 1 ".
                " ORDER BY ".$col." ".$order." LIMIT ".$offset.','.$limit;

            $data = $this->db->query($sql);
        }

        return $data;
    }
      /*
   Returns all the employees
   */
    function get_all_error($person_id,$limit = 10000, $offset =0, $col='jobs_important',$order = 'DESC')
    {
        if($person_id == 1){
            $sql = "SELECT * FROM "
                .$this->_table_employees_jobs.','.$this->_table_jobs.','.$this->_table_people.','.$this->_table_employees.",".$this->_table_jobs_report."
                WHERE ".$this->_table_employees_jobs.".person_id = ".$this->_table_people.".person_id AND "
                .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
                .$this->_table_employees_jobs .".employees_jobs_id = ".$this->_table_jobs_report .".employees_jobs_id AND "
                .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND ".$this->_table_employees.".deleted = 0
                AND jobs_reports_status = 0 ORDER BY ".$col." ".$order." LIMIT ".$offset.','.$limit ;

            $data = $this->db->query($sql);

        }else{

            $sql = "SELECT * FROM "
                .$this->_table_employees_jobs.','.$this->_table_jobs.','.$this->_table_people.",".$this->_table_employees.",".$this->_table_jobs_report."
                WHERE ".$this->_table_employees_jobs.".person_id = ".$this->_table_people.".person_id AND "
                .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
                .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND "
                .$this->_table_employees_jobs.".employees_jobs_id = ".$this->_table_jobs_report.".employees_jobs_id AND "
                .$this->_table_employees_jobs.".person_id = ".$person_id." AND ".$this->_table_employees.".deleted = 0  AND jobs_reports_status = 0 ".
                " ORDER BY ".$col." ".$order." LIMIT ".$offset.','.$limit;

            $data = $this->db->query($sql);
        }

        return $data;
    }
    /*
     * Function get_all_jobs_report
     * Description : get all jobs of the manager
     * Return :
     * */
    public function get_all_jobs_report_manager($person_id = 1 ,$limit = 10000, $offset =0, $col='last_name',$order = 'DESC')
    {
        if($person_id == 1){
            $sql = "SELECT * FROM ".$this->_table_jobs.' AS a,'.$this->_table_employees_jobs.' AS b,'.$this->_table_jobs_report.' AS c,'.$this->_table_employees.' AS d,'.$this->_table_people .' AS e'.
                " WHERE a.jobs_id = b.jobs_id AND b.employees_jobs_id = c.employees_jobs_id
                 AND b.person_id = d.person_id AND d.person_id = e.person_id AND deleted = 0
                 ORDER BY ".$col." ".$order ." LIMIT ".$offset.','.$limit;
            $query = $this->db->query($sql);
        }else{
            $sql = "SELECT * FROM ".$this->_table_jobs.' AS a,'.$this->_table_employees_jobs.' AS b,'.$this->_table_jobs_report.' AS c,'.$this->_table_employees.' AS d,'.$this->_table_people .' AS e'.
                " WHERE a.jobs_id = b.jobs_id AND b.employees_jobs_id = c.employees_jobs_id
                 AND b.person_id = d.person_id AND d.person_id = e.person_id AND deleted = 0 AND b.employees_jobs_parent_id = ".$person_id ."
                 ORDER BY ".$col." ".$order ." LIMIT ".$offset.','.$limit;
            $query = $this->db->query($sql);
        }

        return $query;
    }
    /*
         * Function get_all_jobs_report
         * Description : get all jobs of the manager
         * Return :
    * */
        public function get_all_jobs_report_manager_success($person_id = 1 ,$limit = 10000, $offset =0, $col='last_name',$order = 'DESC')
        {
            if($person_id == 1){
                $sql = " SELECT * FROM ".$this->_table_jobs.' AS a,'.$this->_table_employees_jobs.' AS b,'.$this->_table_jobs_report.' AS c,'.$this->_table_employees.' AS d,'.$this->_table_people .' AS e'.
                    " WHERE a.jobs_id = b.jobs_id AND b.employees_jobs_id = c.employees_jobs_id
                     AND b.person_id = d.person_id AND d.person_id = e.person_id AND deleted = 0 AND c.jobs_reports_status = 1
                     ORDER BY ".$col." ".$order ." LIMIT ".$offset.','.$limit;
                $query = $this->db->query($sql);
            }else{
                $sql = "SELECT * FROM ".$this->_table_jobs.' AS a,'.$this->_table_employees_jobs.' AS b,'.$this->_table_jobs_report.' AS c,'.$this->_table_employees.' AS d,'.$this->_table_people .' AS e'.
                    " WHERE a.jobs_id = b.jobs_id AND b.employees_jobs_id = c.employees_jobs_id
                     AND b.person_id = d.person_id AND d.person_id = e.person_id AND deleted = 0 AND b.employees_jobs_parent_id = ".$person_id ."
                     AND c.jobs_reports_status = 1 ORDER BY ".$col." ".$order ." LIMIT ".$offset.','.$limit;

                $query = $this->db->query($sql);
            }

            return $query;
        }
    /*
      * Function get_all_jobs_report
      * Description : get all jobs of the manager
      * Return :
    * */
   public function get_all_jobs_report_parent($person_id)
   {
        if($person_id == 1){
                $sql = " SELECT DISTINCT employees_jobs_parent_id FROM ".$this->_table_jobs.' AS a,'.$this->_table_employees_jobs.' AS b,'.$this->_table_jobs_report.' AS c,'.$this->_table_employees.' AS d,'.$this->_table_people .' AS e'.
                    " WHERE a.jobs_id = b.jobs_id AND b.employees_jobs_id = c.employees_jobs_id
                     AND b.person_id = d.person_id AND d.person_id = e.person_id AND deleted = 0 ";
                $query = $this->db->query($sql);
        }else{
                $sql = "SELECT DISTINCT employees_jobs_parent_id FROM ".$this->_table_jobs.' AS a,'.$this->_table_employees_jobs.' AS b,'.$this->_table_jobs_report.' AS c,'.$this->_table_employees.' AS d,'.$this->_table_people .' AS e'.
                    " WHERE a.jobs_id = b.jobs_id AND b.employees_jobs_id = c.employees_jobs_id
                     AND b.person_id = d.person_id AND d.person_id = e.person_id AND deleted = 0 AND b.employees_jobs_parent_id = ".$person_id ."";

                $query = $this->db->query($sql);
        }

        return $query->row_array();
    }
        /*
         * Function get_all_jobs_report
         * Description : get all jobs of the manager
         * Return :
         * */
    public function get_all_jobs_report_manager_error($person_id = 1 ,$limit = 10000, $offset =0, $col='last_name',$order = 'DESC')
    {
            if($person_id == 1){
                $sql = " SELECT * FROM ".$this->_table_jobs.' AS a,'.$this->_table_employees_jobs.' AS b,'.$this->_table_jobs_report.' AS c,'.$this->_table_employees.' AS d,'.$this->_table_people .' AS e'.
                    " WHERE a.jobs_id = b.jobs_id AND b.employees_jobs_id = c.employees_jobs_id
                     AND b.person_id = d.person_id AND d.person_id = e.person_id AND deleted = 0 AND c.jobs_reports_status = 0
                     ORDER BY ".$col." ".$order ." LIMIT ".$offset.','.$limit;
                $query = $this->db->query($sql);
            }else{
                $sql = "SELECT * FROM ".$this->_table_jobs.' AS a,'.$this->_table_employees_jobs.' AS b,'.$this->_table_jobs_report.' AS c,'.$this->_table_employees.' AS d,'.$this->_table_people .' AS e'.
                    " WHERE a.jobs_id = b.jobs_id AND b.employees_jobs_id = c.employees_jobs_id
                     AND b.person_id = d.person_id AND d.person_id = e.person_id AND deleted = 0 AND b.employees_jobs_parent_id = ".$person_id ."
                     AND c.jobs_reports_status = 0 ORDER BY ".$col." ".$order ." LIMIT ".$offset.','.$limit;
                $query = $this->db->query($sql);
            }

            return $query;
    }
    /* ByAuthor: @SnguyenOne
     * - Function: count_all()
     * - Description: Get total record of the table $_table_employees_jobs
     * - Param : param :$person_id is validator
     * - Return : number round this table
     *
     * */
    public function get_parent_jobs($person_id =1 ,$limit = 10000, $offset =0, $col='last_name',$order = 'DESC')
    {
        $sql = " SELECT first_name AS parent_name
                 FROM ".$this->_table_people ." AS a,".$this->_table_employees_jobs." AS b,".$this->_table_employees." AS c
                 WHERE b.person_id = c.person_id AND a.person_id = b.parent_id AND deleted = 0 "."
                 ORDER BY ".$col."".$order ." LIMIT ".$offset.','.$limit;

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
    function get_report_info($person_id)
    {
        $sql = "SELECT jobs_name,a.jobs_id,a.employees_jobs_id FROM ".$this->_table_employees_jobs.' AS a,'.$this->_table_jobs.
               " AS c WHERE a.jobs_id = c.jobs_id AND a.person_id = ".$person_id ."
               GROUP BY jobs_name,a.jobs_id,a.employees_jobs_id " ;

        $query = $this->db->query($sql);

        return $query->result_array();
    }
    function get_jobs_report_info($jobs_report_id)
    {
        $sql = "SELECT a.*,b.jobs_id FROM ".$this->_table_jobs_report." AS a,".$this->_table_employees_jobs." AS b
                WHERE jobs_reports_id = ".$jobs_report_id." AND a.employees_jobs_id = b.employees_jobs_id ";
        $query = $this->db->query($sql);

        return $query->row();
    }
    function get_jobs_employees_info($jobs_id)
    {
        $sql = "SELECT * FROM ".$this->_table_employees_jobs." WHERE employees_jobs_id = ".$jobs_id ;

        $query = $this->db->query($sql);
        return $query->row();
    }

    /*
    Inserts or updates an employee
    */
    function save(&$item_data,$jobs_reports_id = false)
    {
        if($jobs_reports_id==-1)
        {
            if($this->db->insert($this->_table_jobs_report,$item_data))
            {
                return true;
            }
            return false;
        }

        $this->db->where('jobs_reports_id', $jobs_reports_id);
        return $this->db->update($this->_table_jobs_report,$item_data);
    }

    function save_manager(&$item_data,$jobs_reports_id = false,$jobs_id = '')
    {
         if($jobs_reports_id != -1){
             if($item_data['jobs_status_id'] != '' ){
                 $sql = "UPDATE $this->_table_jobs
                  SET jobs_status_id = ".$item_data['jobs_status_id']. ",jobs_important = ".$item_data['jobs_ important']."
                  WHERE jobs_id = ".$jobs_id;
                  $this->db->query($sql);
             }

             unset($item_data['jobs_status_id']);
             unset($item_data['jobs_important']);
             $this->db->where('jobs_reports_id', $jobs_reports_id);
             return $this->db->update($this->_table_jobs_report,$item_data);
         }
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
    function delete_list($jobs_reports_id)
    {
        $this->db->trans_start();

        $this->db->where_in('jobs_reports_id',$jobs_reports_id);
        //Delete permissions
        if($this->db->delete($this->_table_jobs_report)){
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

        $this->db->from('jobs_employees');
        $this->db->join('jobs_report','jobs_employees.employees_jobs_id = jobs_report.employees_jobs_id');
        $this->db->like("jobs_reports_name",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("jobs_reports_name", "DESC");
        $by_jobs_name = $this->db->get();
        foreach($by_jobs_name->result() as $row)
        {
            $suggestions[]=array('label'=> $row->jobs_reports_name);
        }

        $this->db->from('jobs_employees');
        $this->db->join('jobs','jobs_employees.jobs_id = jobs.jobs_id');
        $this->db->like("jobs_name",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("jobs_name", "DESC");
        $by_jobs_name = $this->db->get();
        foreach($by_jobs_name->result() as $row)
        {
            $suggestions[]=array('label'=> $row->jobs_name);
        }

        $this->db->from('jobs_employees');
        $this->db->join('jobs','jobs_employees.jobs_id = jobs.jobs_id');
        $this->db->like("jobs_content",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("jobs_content", "DESC");
        $by_jobs_content = $this->db->get();
        foreach($by_jobs_content->result() as $row)
        {
            $suggestions[]=array('label'=> $row->jobs_content);
        }

        $this->db->from('jobs_employees');
        $this->db->join('jobs','jobs_employees.jobs_id = jobs.jobs_id');
        $this->db->like("jobs_start_date",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("jobs_start_date", "DESC");
        $by_jobs_start_date = $this->db->get();
        foreach($by_jobs_start_date->result() as $row)
        {
            $suggestions[]=array('label'=> $row->jobs_start_date);
        }

        $this->db->from('jobs_employees');
        $this->db->join('jobs','jobs_employees.jobs_id = jobs.jobs_id');
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



    /*
    Preform a search on employees
    */
    function search($search, $limit=20,$offset=0,$column='last_name',$orderby='asc')
    {
        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->from('jobs,jobs_employees,employees,people,jobs_report');
            $this->db->where("".$this->_table_employees_jobs.".person_id = ".$this->_table_employees.".person_id AND "
                .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
                .$this->_table_employees_jobs .".employees_jobs_id = ".$this->_table_jobs_report .".employees_jobs_id AND "
                .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND
            (first_name LIKE '%".$this->db->escape_like_str($search)."%' OR
			last_name LIKE '%".$this->db->escape_like_str($search)."%' OR
			jobs_name LIKE '%".$this->db->escape_like_str($search)."%' OR
			jobs_reports_name LIKE '%".$this->db->escape_like_str($search)."%' OR
			CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') AND deleted=0");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);

        }
        else
        {
            $this->db->from('jobs,jobs_employees,employees,people,jobs_report');
            $this->db->where("".$this->_table_employees_jobs.".person_id = ".$this->_table_employees.".person_id AND "
                .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
                .$this->_table_employees_jobs .".employees_jobs_id = ".$this->_table_jobs_report .".employees_jobs_id AND "
                .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND
            (first_name LIKE '%".$this->db->escape_like_str($search)."%' OR
			last_name LIKE '%".$this->db->escape_like_str($search)."%' OR
			jobs_name LIKE '%".$this->db->escape_like_str($search)."%' OR
			jobs_reports_name LIKE '%".$this->db->escape_like_str($search)."%' OR
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
            $this->db->from('jobs,jobs_employees,employees,people,jobs_report');
            $this->db->where("".$this->_table_employees_jobs.".person_id = ".$this->_table_employees.".person_id AND "
                .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
                .$this->_table_employees_jobs .".employees_jobs_id = ".$this->_table_jobs_report .".employees_jobs_id AND "
                .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND
            (first_name LIKE '%".$this->db->escape_like_str($search)."%' OR
			last_name LIKE '%".$this->db->escape_like_str($search)."%' OR
			jobs_name LIKE '%".$this->db->escape_like_str($search)."%' OR
			jobs_reports_name LIKE '%".$this->db->escape_like_str($search)."%' OR
			CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') AND deleted=0");
            $this->db->order_by("jobs_important", "DESC");
            $result=$this->db->get();
            return $result->num_rows();
        }
        else
        {
            $this->db->from('jobs,jobs_employees,employees,people,jobs_report');
            $this->db->where("".$this->_table_employees_jobs.".person_id = ".$this->_table_employees.".person_id AND "
                .$this->_table_employees_jobs .".jobs_id = ".$this->_table_jobs .".jobs_id AND "
                .$this->_table_employees_jobs .".employees_jobs_id = ".$this->_table_jobs_report .".employees_jobs_id AND "
                .$this->_table_employees.".person_id = ".$this->_table_people.".person_id AND
            (first_name LIKE '%".$this->db->escape_like_str($search)."%' OR
			last_name LIKE '%".$this->db->escape_like_str($search)."%' OR
			jobs_name LIKE '%".$this->db->escape_like_str($search)."%' OR
			jobs_reports_name LIKE '%".$this->db->escape_like_str($search)."%' OR
			CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') AND deleted=0");
            $this->db->order_by("jobs_important", "DESC");
            $result=$this->db->get();
            return $result->num_rows();
        }
    }

}

