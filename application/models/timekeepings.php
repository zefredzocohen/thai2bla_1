<?php
class Timekeepings extends CI_Model
{
    function __construct() {
        parent::__construct();
        $this->_table_employees = $this->db->dbprefix('employees');
        $this->_table_people = $this->db->dbprefix('people');
        $this->_table_positions = $this->db->dbprefix('jobs_positions');
        $this->_table_hopdong = $this->db->dbprefix('hopdong');
        $this->_table_timekeeping = $this->db->dbprefix('timekeeping');
        $this->_table_salary_config = $this->db->dbprefix('salary_config');
        $this->_table_department = $this->db->dbprefix('jobs_department');
        $this->_table_regions = $this->db->dbprefix('jobs_regions');
        $this->_table_affiliates = $this->db->dbprefix('jobs_affiliates');
        $this->_table_city= $this->db->dbprefix('jobs_city');
        $this->_table_salarystatic = $this->db->dbprefix('salarystatic');
        $this->_table_welfare_rewards = $this->db->dbprefix('welfare_rewards');
        $this->_table_salary = $this->db->dbprefix('salary');
        $this->_table_salary_option = $this->db->dbprefix('salary_option');
    }
    function exists($id)
    {
       $this->db->from('timekeeping');
       $this->db->where('id',$id);
       $query = $this->db->get();

       return ($query->num_rows()==1);
    }
	// bang cham cong
    public function get_date_contract($employees_id)
    {
        $this->db->select('date_start,date_end');
        $this->db->where('id_employees',$$employees_id);
        $this->db->from('hopdong');
         return   $this->db->result_array();
    }
    public function get_chucvu_info($employees_id){
        $this->db->select('jobs_positions_name');
        $this->db->where('person_id',$employees_id);
        $this->db->from('jobs_positions');
        return $this->db->get()->row();
    }
    public function get_all_employees(){
         $query=$this->db->get('people');
         return $this->db->result_array();

    }
    /*
     * *************************************************
     *  PHẦN LÀM THÔNG TIN CHO TÍNH LƯƠNG              *
     * * ***********************************************
     * */
    /*
     *  Lấy tất cả thông tin bảng lương
     * */
    function getAllPersonSalary($year,$month,$department_id,$person_id,$employees_id = '')
    {
        if(empty($department_id)){
            if(empty($person_id)){
               if(empty($employees_id)){
                     $sql = "SELECT b.person_id,a.first_name,b.em_salary_basic,b.em_wage_level_coverage,b.em_social_insurance,b.hs_salary,b.check_petrol,b.check_phone FROM ".$this->_table_people." AS a,$this->_table_employees AS b,
                     $this->_table_hopdong AS c,$this->_table_positions AS d,$this->_table_timekeeping AS e
                     WHERE a.person_id = b.person_id AND b.deleted = 0  AND b.positions_id = d.jobs_positions_id AND a.person_id = c.id_employess AND c.id_employess = e.person_id AND day_keeping LIKE '".$year."-".$month."-%' GROUP BY b.person_id ORDER BY a.first_name";
               }else{
                     $sql = "SELECT b.person_id,a.first_name,b.em_salary_basic,b.em_wage_level_coverage,b.em_social_insurance,b.hs_salary,b.check_petrol,b.check_phone FROM ".$this->_table_people." AS a,$this->_table_employees AS b,$this->_table_hopdong AS c,$this->_table_positions AS d,$this->_table_timekeeping AS e
                     WHERE a.person_id = b.person_id AND b.deleted = 0 AND a.person_id = $employees_id AND b.positions_id = d.jobs_positions_id AND a.person_id = c.id_employess AND c.id_employess = e.person_id AND day_keeping LIKE '".$year."-".$month."-%' GROUP BY b.person_id ORDER BY a.first_name";
               }
            }else{
                $sql = "SELECT b.person_id,a.first_name,b.em_salary_basic,b.em_wage_level_coverage,b.em_social_insurance,b.hs_salary,b.check_petrol,b.check_phone  FROM ".$this->_table_people." AS a,$this->_table_employees AS b,$this->_table_hopdong AS c,$this->_table_positions AS d,$this->_table_timekeeping AS e
                 WHERE a.person_id = b.person_id AND b.deleted = 0  AND b.positions_id = d.jobs_positions_id AND a.person_id = c.id_employess AND a.person_id = $person_id AND c.id_employess = e.person_id AND day_keeping LIKE '".$year."-".$month."-%' GROUP BY b.person_id ORDER BY a.first_name";
            }
        }else{
            if(empty($person_id)){
                $sql = "SELECT b.person_id,a.first_name,b.em_salary_basic,b.em_wage_level_coverage,b.em_social_insurance ,b.hs_salary,b.check_petrol,b.check_phone  FROM ".$this->_table_people." AS a,$this->_table_employees AS b,$this->_table_hopdong AS c,$this->_table_positions AS d,$this->_table_timekeeping AS e
                 WHERE a.person_id = b.person_id AND b.deleted = 0  AND b.positions_id = d.jobs_positions_id AND a.person_id = c.id_employess AND b.department_id = $department_id AND c.id_employess = e.person_id AND day_keeping LIKE '".$year."-".$month."-%'  GROUP BY b.person_id ORDER BY a.first_name ";
            }else{
                $sql = "SELECT b.person_id,a.first_name,b.em_salary_basic,b.em_wage_level_coverage,b.em_social_insurance ,b.hs_salary,b.check_petrol,b.check_phone  FROM ".$this->_table_people." AS a,$this->_table_employees AS b,$this->_table_hopdong AS c,$this->_table_positions AS d,$this->_table_timekeeping AS e
                 WHERE a.person_id = b.person_id AND b.deleted = 0 AND b.positions_id = d.jobs_positions_id AND a.person_id = c.id_employess AND b.department_id = $department_id AND c.id_employess = e.person_id AND day_keeping LIKE '".$year."-".$month."-%' AND a.person_id = $person_id  GROUP BY b.person_id ORDER BY a.first_name ";
            }
        }
        $data = $this->db->query($sql);
        return $data->result();
    }

    /*
     * Hàm lấy thông tin theo các hệ số lương của nhân viên
     * */
    function getHS_Salary($person_id)
    {
        $sql = 'SELECT hs_salary FROM '.$this->_table_employees. " WHERE person_id = $person_id";
        $data = $this->db->query($sql);

        return $data->row();
    }
    /*
     *  Hàm lấy thông tin phụ cấp xăng xe điện thoại trong bảng config
     * */
    function getConfigSalary($key)
    {
        $query = $this->db->get_where('app_config', array('key' => $key), 1);
        if($query->num_rows()==1){
            return $query->row()->value;
        }
        return null;
    }


    /*
     * get all information from _table_welfare_rewards
     * */
    function getWelfareRewards()
    {
        $sql = "SELECT * FROM ".$this->_table_welfare_rewards;
        $data = $this->db->query($sql);

        return $data->result();
    }
    /*
     * get all information from salary
     * */
    function getAllSalary($year,$month)
    {
        $sql = "SELECT * FROM ".$this->_table_salary ." WHERE date_salary LIKE '%".$year."-".$month."%'";
        $data = $this->db->query($sql);

        return $data->result();
    }
    /*
     * Lấy ngày công của nhân viên trong table salaryconfig
     * */
    function getSalaryConfig($year,$month)
    {
        $sql = "SELECT person_id,total_all,total_x150,total_x200,total_x300 FROM ".$this->_table_salarystatic ." WHERE year_months LIKE '%".$year."-".$month."%'";
        $data = $this->db->query($sql);

        return $data->result();
    }
    /*
     * Hàm lấy thông tin từ bảng cấu hình hệ thống
     * */
    function getTableSalaryOption()
    {
        $sql = "SELECT * FROM ".$this->_table_salary_option;
        $data = $this->db->query($sql);

        return $data->row();
    }
    /*
     * Hàm thực hiện update thông tin lương nhân viên theo nội dung nhập vào
     * */
    public function updateEmployees($person_id,$em_salary_basic,$em_wage_level_coverage)
    {
        $sql = "UPDATE $this->_table_employees SET em_salary_basic='".$em_salary_basic."',em_wage_level_coverage='".$em_wage_level_coverage."' WHERE person_id = $person_id";
        $this->db->query($sql);
    }
     /*
         * Hàm thực hiện update thông tin lương nhân viên theo nội dung nhập vào
         * */
     public function updateSalaryOption($person_id,$total_x150,$total_x200,$total_x300)
     {
            $sql = "UPDATE $this->_table_salarystatic SET total_x150='".$total_x150."',total_x200 ='".$total_x200."',total_x300='".$total_x300."' WHERE person_id = $person_id";
            $this->db->query($sql);
     }
     /*
        * Hàm thực hiện update thông tin lương nhân viên theo nội dung nhập vào
     * */
    public function updateWelfareRewards($data)
    {
        $this->db->where('person_id',$data['person_id']);
        $this->db->update($this->_table_welfare_rewards,$data);
    }
    /*
     * Function delete thông tin phần tính lương
     * */
    public function deleteSalary($person_id,$date)
    {
        $this->db->where('person_id',$person_id);
        $this->db->where('date_salary',$date);
        $this->db->delete($this->_table_salary);
    }
    public function actionSalary($items)
    {
        $this->deleteSalary($items['person_id'],$items['date_salary']);
        $this->db->insert($this->_table_salary,$items);
    }
    /*
     * Hàm thực hiện insert toàn bộ thông tin lương của nhân viên tháng trước
     * */
    function saveSalary($items)
    {
        $this->db->where('person_id',$items['person_id']);
        $this->db->where('date_salary',$items['date_salary']);
        $this->db->update($this->_table_salary,$items);
    }
    function saveSalaryCommnet($items)
    {
        $this->db->where('date_salary',$items['date_salary']);
        $this->db->update($this->_table_salary,$items);
    }
    /*
     *  Hàm lấy thông tin duyệt trong tháng năm của admin
     * */
    function getPersonManager($id,$year,$month)
    {
       $sql = "SELECT b.person_id,first_name,comment_manager,comment,date_parent_manager,date_parent,parent_manager_id,parent_id,status FROM ".$this->_table_salary." AS a,$this->_table_people AS b
               WHERE $id = b.person_id AND date_salary LIKE '%".$year."-".$month."%' AND (parent_manager_id = $id OR parent_id = $id) GROUP BY b.person_id";
       $data = $this->db->query($sql);
       return $data->row();
    }
    function getManagerName($id,$year,$month)
    {
        $result = $this-> getPersonManager($id,$year,$month);
        $sql = "SELECT first_name FROM ".$this->_table_people ." WHERE person_id = $result->parent_manager_id";
        $data = $this->db->query($sql);

        return $data->row();
    }
    function getParentName($id,$year,$month)
    {
        $result = $this-> getPersonManager($id,$year,$month);
        $sql = "SELECT first_name FROM ".$this->_table_people ." WHERE person_id = $result->parent_id";
        $data = $this->db->query($sql);

        return $data->row();
    }

    /***************************************************
     *     PHẦN LÀM THÔNG TIN CHO CHẤM CÔNG            *
     * * ***********************************************
     * Function thực hiện lấy ngày tích lũy phép tháng trước(total_vacation) của nhân viên đó lifetek_salarystatic
     * */
    function getRowSalarystatic($year,$month,$person_id)
    {
        if($month == 1){
            $year = $year - 1;
            $month = '12';
        }else{
            $month = $month - 1;
        }

        $sql = "SELECT person_id,total_vacation FROM ".$this->_table_salarystatic ." WHERE person_id = $person_id AND year_months LIKE '%".$year."-".$month."%'";
        $data = $this->db->query($sql);

        return $data->row();
    }
    /*
     * Hàm thực hiện kiểm tra thông tin dữ liệu chấm công đã tồn tại hay chưa trong table timekeeping
     */
    function deleteSalarystatic($year_month,$person_id)
    {
        $this->db->where(array('person_id'=>$person_id,'year_months'=>''.$year_month.''));
        if($this->db->delete($this->_table_salarystatic)){
            return true;
        }
    }
    /*
     * Function getInformation SUM cho các tr??ng h?p X,X/2,X/2:T/2...
     */
    function getCountX($year,$month,$param,$person_id)
    {
        $sql = "SELECT a.person_id FROM $this->_table_timekeeping AS a, $this->_table_salary_config AS b
                   WHERE a.salaryconfig_id = b.id AND day_keeping LIKE '".$year."-".$month."-%' AND person_id = $person_id AND b.name LIKE '$param' ";

        $data = $this->db->query($sql);

        return $data->num_rows();
    }
    /*
     * Function thực hiện insert toàn bộ thông tin chấm công của nhân viên với
     * person_id tương ứng sau khi thực hiện xóa toàn bộ thông tin của nhân viên này trong table timekeeping
     * */
    function actionInsertSalarystatic($data){
       if($this->deleteSalarystatic($data['year_months'],$data['person_id'])){
           $this->db->insert($this->_table_salarystatic,$data);
       }
    }

    /*
    * Function thực hiên delete tất cả các thông tin của person_id đã lưu trong table lifetek_salarystatic
    * */

    function deletePerson($person_id,$day)
    {
        $sql = "DELETE FROM ".$this->_table_timekeeping ." WHERE day_keeping = '".$day."' AND person_id = $person_id";
        if($this->db->query($sql)){
            return true;
        }else{
            $this->db->query($sql);
            return true;
        }
    }
    /*
     * Hàm thực hiện chèn thông tin vào trong table time keeping
     * */
    function actionTimeKeeping($item)
    {
       if(!empty($item['salaryconfig_id'])){
           if($this->deletePerson($item['person_id'],$item['day_keeping'])){
               $this->db->insert($this->_table_timekeeping,$item);
           }
      }
    }

    /**
     * Function get information employees
     */
   function getPersonId($year,$month)
   {
       $sql = "SELECT b.person_id,first_name,date_start,date_end,jobs_positions_name,b.day_keeping,a.em_on_vacation,m.total_vacation FROM ".$this->_table_employees." AS a,$this->_table_timekeeping AS b,$this->_table_people AS c,$this->_table_hopdong AS d, $this->_table_positions AS f,$this->_table_salary_config,$this->_table_salarystatic AS m
                WHERE (a.person_id = b.person_id AND c.person_id = a.person_id AND a.person_id = d.id_employess AND a.positions_id = f.jobs_positions_id AND a.deleted = 0 AND day_keeping LIKE '".$year."-".$month."-%')
                OR (a.person_id = b.person_id AND m.person_id = b.person_id AND c.person_id = a.person_id AND a.person_id = d.id_employess AND a.positions_id = f.jobs_positions_id AND a.deleted = 0 AND day_keeping LIKE '".$year."-".$month."-%' AND m.year_months LIKE '%".$year."-".($month - 1)."%') GROUP BY b.person_id";
       $data = $this->db->query($sql);

       return $data->result();
   }
   /*
    *   Hàm lấy tất cả thông tin nhân viên trong công ty
    * */
   
    /* giang 4/4/2014 */
   function getAllPerson($department_id,$employees_id,$year,$month)
   {
   	if(empty($department_id)){
            if(empty($employees_id)){
                $sql = " SELECT a.person_id,first_name,date_start,date_end,b.day_keeping,jobs_positions_name,em_on_vacation,b.description
                 FROM $this->_table_employees AS a,$this->_table_timekeeping AS b,$this->_table_people AS c,$this->_table_hopdong AS d, $this->_table_positions AS f
                 WHERE c.person_id = a.person_id AND a.person_id = d.id_employess AND f.jobs_positions_id = a.positions_id AND b.deleted=0 AND a.person_id=b.person_id AND a.deleted = 0 AND day_keeping LIKE '".$year."-".$month."-%'
                 GROUP BY a.person_id ORDER BY a.person_id ASC";
            }else{
                $sql = " SELECT a.person_id,first_name,date_start,date_end,b.day_keeping,jobs_positions_name,em_on_vacation,b.description
                 FROM $this->_table_employees AS a,$this->_table_timekeeping AS b,$this->_table_people AS c,$this->_table_hopdong AS d, $this->_table_positions AS f
                 WHERE c.person_id = a.person_id AND a.person_id = d.id_employess AND f.jobs_positions_id = a.positions_id AND b.deleted=0 AND a.person_id=b.person_id AND a.person_id = $employees_id AND a.deleted = 0 AND day_keeping LIKE '".$year."-".$month."-%'
                 GROUP BY a.person_id ORDER BY a.person_id ASC";
            }

        }else{
            if(empty($employees_id)){
                $sql = " SELECT a.person_id,first_name,date_start,date_end,b.day_keeping,jobs_positions_name,em_on_vacation,b.description
                 FROM $this->_table_employees AS a,$this->_table_timekeeping AS b,$this->_table_people AS c,$this->_table_hopdong AS d, $this->_table_positions AS f
                 WHERE c.person_id = a.person_id  AND a.person_id = d.id_employess AND f.jobs_positions_id = a.positions_id  AND a.deleted = 0 AND b.deleted=0 AND a.person_id=b.person_id AND a.department_id = $department_id AND day_keeping LIKE '".$year."-".$month."-%'
                 GROUP BY a.person_id ORDER BY a.person_id ASC";
            }else{
                $sql = " SELECT a.person_id,first_name,date_start,date_end,b.day_keeping,jobs_positions_name,em_on_vacation,b.description
                 FROM $this->_table_employees AS a,$this->_table_timekeeping AS b,$this->_table_people AS c,$this->_table_hopdong AS d, $this->_table_positions AS f
                 WHERE c.person_id = a.person_id AND a.person_id = d.id_employess AND f.jobs_positions_id = a.positions_id AND a.deleted = 0 AND b.deleted=0 AND a.person_id=b.person_id AND a.department_id = $department_id AND a.person_id = $employees_id AND day_keeping LIKE '".$year."-".$month."-%'
                 GROUP BY a.person_id ORDER BY a.person_id ASC";
            }
        }
       $data = $this->db->query($sql);

       return $data->result();
   }
   /*
    * Hàm lấy thông tin theo ngày tháng lấy toàn bộ thông tin đã chấm công trong ngày tháng năm
    * */
   
  
    function getAllPersonDate($year,$month,$department_id,$employees_id)
    {
        if(empty($department_id)){
            if(empty($employees_id)){
                $sql = " SELECT a.person_id,first_name,date_start,date_end,b.day_keeping,jobs_positions_name,em_on_vacation,b.description
                 FROM $this->_table_employees AS a,$this->_table_timekeeping AS b,$this->_table_people AS c,$this->_table_hopdong AS d, $this->_table_positions AS f
                 WHERE c.person_id = a.person_id AND a.person_id = d.id_employess AND f.jobs_positions_id = a.positions_id AND b.deleted=0 AND a.person_id=b.person_id AND a.deleted = 0 AND day_keeping LIKE '".$year."-".$month."-%'
                 GROUP BY a.person_id ORDER BY a.person_id ASC";
            }else{
                $sql = " SELECT a.person_id,first_name,date_start,date_end,b.day_keeping,jobs_positions_name,em_on_vacation,b.description
                 FROM $this->_table_employees AS a,$this->_table_timekeeping AS b,$this->_table_people AS c,$this->_table_hopdong AS d, $this->_table_positions AS f
                 WHERE c.person_id = a.person_id AND a.person_id = d.id_employess AND f.jobs_positions_id = a.positions_id AND b.deleted=0 AND a.person_id=b.person_id AND a.person_id = $employees_id AND a.deleted = 0 AND day_keeping LIKE '".$year."-".$month."-%'
                 GROUP BY a.person_id ORDER BY a.person_id ASC";
            }

        }else{
            if(empty($employees_id)){
                $sql = " SELECT a.person_id,first_name,date_start,date_end,b.day_keeping,jobs_positions_name,em_on_vacation,b.description
                 FROM $this->_table_employees AS a,$this->_table_timekeeping AS b,$this->_table_people AS c,$this->_table_hopdong AS d, $this->_table_positions AS f
                 WHERE c.person_id = a.person_id  AND a.person_id = d.id_employess AND f.jobs_positions_id = a.positions_id  AND a.deleted = 0 AND b.deleted=0 AND a.person_id=b.person_id AND a.department_id = $department_id AND day_keeping LIKE '".$year."-".$month."-%'
                 GROUP BY a.person_id ORDER BY a.person_id ASC";
            }else{
                $sql = " SELECT a.person_id,first_name,date_start,date_end,b.day_keeping,jobs_positions_name,em_on_vacation,b.description
                 FROM $this->_table_employees AS a,$this->_table_timekeeping AS b,$this->_table_people AS c,$this->_table_hopdong AS d, $this->_table_positions AS f
                 WHERE c.person_id = a.person_id AND a.person_id = d.id_employess AND f.jobs_positions_id = a.positions_id AND a.deleted = 0 AND b.deleted=0 AND a.person_id=b.person_id AND a.department_id = $department_id AND a.person_id = $employees_id AND day_keeping LIKE '".$year."-".$month."-%'
                 GROUP BY a.person_id ORDER BY a.person_id ASC";
            }
        }
        
        $data = $this->db->query($sql);

        return $data->result();
    }
    
    
    
    /*
     * Hàm thực hiện lấy toàn bộ thông tin nhân viên theo phòng ban hoặc không
     * */
    function getEmployees($department_id)
    {
        if(empty($department_id)){
            $sql = "SELECT first_name,a.person_id,a.department_id
                    FROM ".$this->_table_employees ." AS a,$this->_table_people AS b,$this->_table_hopdong AS c,$this->_table_positions AS d WHERE a.person_id = b.person_id AND a.person_id = c.id_employess AND a.positions_id = d.jobs_positions_id AND a.deleted = 0 AND c.deleted = 0 GROUP BY a.person_id";
        }else{
            $sql = "SELECT first_name,a.person_id,a.department_id
                    FROM ".$this->_table_employees ." AS a,$this->_table_people AS b,$this->_table_hopdong AS c,$this->_table_positions AS d WHERE a.person_id = b.person_id AND a.person_id = c.id_employess AND a.positions_id = d.jobs_positions_id AND a.deleted = 0 AND c.deleted = 0 AND department_id = $department_id GROUP BY a.person_id";
        }
        $data = $this->db->query($sql);
        return $data->result();
    }
    
    /* giang 4/4/2014 */

    /*
     * Function getAll chú ý của nhân viên trong tháng năm đó
     *
     * */
    function getDescription()
    {
        $sql = "SELECT person_id,description FROM ".$this->_table_timekeeping;
        $data = $this->db->query($sql);

        return $data->result();
    }
    /*
     * Function get All information  of total_vacation in the table salaryconfig
     * */
   function getAllSalaryConfig($year,$month)
   {
       if($month == "01"){
           $year = $year - 1;
           $month = '12';
       }else{
           $month = $month - 1;
       }

        $sql = "SELECT person_id,total_vacation FROM ". $this->_table_salarystatic ." WHERE year_months LIKE '%".$year."-".$month."%' GROUP BY person_id";
        $data = $this->db->query($sql);

        return $data->result();
   }

    /*
     * Function getInformation SUM cho các tr??ng h?p X,X/2,X/2:T/2...
     */

   function getCount($year,$month,$param,$department_id,$employees_id)
   {
       $item = array();
       foreach($this->getAllPerson($department_id,$employees_id,$year,$month) AS $key=>$values){

           $sql = "SELECT a.person_id FROM $this->_table_timekeeping AS a, $this->_table_salary_config AS b
                   WHERE a.salaryconfig_id = b.id AND a.person_id = $values->person_id AND a.deleted = 0 AND day_keeping
                   LIKE '".$year."-".$month."-%' AND b.name = '$param'";

           $data = $this->db->query($sql);
           $item[$key] = $data->num_rows();
       }
       return $item;
   }

   /*
        Function show all thông tin các thông tin chấm công trong ngày tháng năm lựa chọn
    *
    *
    function getCountDate($year,$month,$param)
    {
        $item = array();
        foreach($this->getAllPersonDate($year,$month,$department_id) AS $key=>$values){

            $sql = "SELECT a.person_id FROM $this->_table_timekeeping AS a, $this->_table_salary_config AS b
                   WHERE a.salaryconfig_id = b.id AND a.person_id = $values->person_id AND day_keeping
                   LIKE '".$year."-".$month."-%' AND b.name = '$param'";

            $data = $this->db->query($sql);
            $item[$key] = $data->num_rows();
        }
        return $item;
    }*/

    //Get Table information for day_kepping
   function getInfo($year,$month,$date)
   {
      $sql = "SELECT a.person_id,a.salaryconfig_id,b.name,a.day_keeping FROM $this->_table_timekeeping AS a, $this->_table_salary_config AS b
               WHERE a.salaryconfig_id = b.id AND day_keeping LIKE '".$year."-".$month."-".$date."%'";
      $data = $this->db->query($sql);

      return $data->result();
   }
    /***************************************************
     *  END PHẦN LÀM THÔNG TIN CHO CHẤM CÔNG           *
     * * ************************************************/

   //Function get information for table SalaryConfig
   function getNameSalaryConfig()
   {
       $sql = "SELECT id,name,description FROM " .$this->_table_salary_config ;
       $data = $this->db->query($sql);

       return $data->result();
   }
   // Ham  lay thong tin phong ban
   public function getDepartment(){
      $sql = "SELECT department_id,department_name FROM ".$this->_table_department;
      $data = $this->db->query($sql);
      return $data->result();
   }

   //end table chấm công

	function get_all($limit=25, $offset=0,$col='day_keeping',$order='desc')
	{
		$this->db->from('timekeeping');
		$this->db->where('deleted',0);
		$this->db->order_by($col, $order);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();

	}

	public  function get_all_city()
	{
	 $query = $this->db->get('jobs_city');
	 if($query->num_rows()>0)
	 {
	  return $query->result_array();
	 }

	 else return null;
	}

	public  function get_all_salaryconfig()
	{
            $query = $this->db->get('salary_config');
            if($query->num_rows()>0)return $query->result_array();
            else return null;
	}
	function get_all_day_salarystatic(){
        $query = $this->db->get('timekeeping');
        if($query->num_rows()>0)
        {
            return $query->result_array();
        }
        else return null;
     }

	function get_all_positions($limit = 10000, $offset =0, $col='jobs_positions_name',$order = 'DESC')

         {
		$this->db->from('jobs_positions');
		$this->db->order_by($col, $order);
		$this->db->limit($limit);
		$this->db->offset($offset);
		return $this->db->get();
        }

	/*function get_all_employees($limit=10000, $offset=0,$col='last_name',$order='asc')
	{
		$employees=$this->db->dbprefix('employees');
		$people=$this->db->dbprefix('people');
		$data=$this->db->query("SELECT *
						FROM ".$people."
						STRAIGHT_JOIN ".$employees." ON
						".$people.".person_id = ".$employees.".person_id
						WHERE deleted =0 ORDER BY ".$col." ". $order."
						LIMIT  ".$offset.",".$limit);

		return $data;
	}*/

	function count_all()
	{
		$this->db->from('timekeeping');
		$this->db->where('deleted',0);
		return $this->db->count_all_results();
	}

	 public  function get_info_first_name($em_chucvu)
	 {
	  $this->db->select('people.first_name,people.person_id,employees.em_chucvu');
			$this->db->from('people');
			$this->db->join('employees', 'people.person_id = employees.person_id');
			$this->db->where('employees.em_chucvu',$em_chucvu);
			return $this->db->get();

	 }
	function save(&$item_data,$id=false)
	{
		if (!$id or !$this->exists($id))
		{
			if($this->db->insert('timekeeping',$item_data))
			{
				$item_data['id']=$this->db->insert_id();
				return true;
			}
			return false;
		}

		$this->db->where('id',$id);
		return $this->db->update('timekeeping',$item_data);

	}

	//lay thong tin form :)
	function get_info($id)
	{
		//$this->db->select('id,name , parentid');
		$this->db->from('timekeeping');
		$this->db->where('id',$id);
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
			$fields = $this->db->list_fields('timekeeping');

			foreach ($fields as $field)
			{
				$item_obj->$field='';
			}

			return $item_obj;
		}
	}


	//sorting goi
	function search_count_all($search, $cat='')
	{		if($cat) $cat_id = "and id = $cat ";
            else $cat_id = '';
		if ($this->config->item('speed_up_search_queries'))
		{
			$query = "
			select *
			from (
			         (select *
			         from ".$this->db->dbprefix('timekeeping')."
			         where day_keeping like '".$this->db->escape_like_str($search)."%' and deleted = 0
			         order by `day_keeping` )
					union
			         (select *
			         from ".$this->db->dbprefix('timekeeping')."
			         where id like '".$this->db->escape_like_str($search)."%' and deleted = 0
			         order by `day_keeping`)
					union
			         (select *
			         from ".$this->db->dbprefix('timekeeping')."
			         where description like '".$this->db->escape_like_str($search)."%' and deleted = 0
			         order by `day_keeping` )
			) as search_results
			order by `day_keeping`";
			$result=$this->db->query($query);
			return $result->num_rows();
		}
		else
		{
			$this->db->from('timekeeping');
			$this->db->where("(day_keeping LIKE '%".$this->db->escape_like_str($search)."%' or
			id LIKE '%".$this->db->escape_like_str($search)."%' or
			day_keeping LIKE '%".$this->db->escape_like_str($search)."%' or
			description LIKE '%".$this->db->escape_like_str($search)."%') $cat_id and deleted=0");
			$this->db->order_by("day_keeping", "asc");
			$result=$this->db->get();
			return $result->num_rows();
		}
	}

	/// - tim kiem

	function search($search ,$cat='', $limit=20,$offset=0,$column='day_keeping',$orderby='asc')
	{
			if($cat) $cat_id = "and id = $cat ";
            else $cat_id = '';
		if ($this->config->item('speed_up_search_queries'))
		{

			$query = "
			select *
			from (
			         (select *
			         from ".$this->db->dbprefix('timekeeping')."
			         where day_keeping like '".$this->db->escape_like_str($search)."%' and deleted = 0
			         order by `".$column."`)
					union
			         (select *
			         from ".$this->db->dbprefix('timekeeping')."
			         where id like '".$this->db->escape_like_str($search)."%' and deleted = 0
			         order by `".$column."`)
					union
			         (select *
			         from ".$this->db->dbprefix('timekeeping')."
			         where description like '".$this->db->escape_like_str($search)."%' and deleted = 0
			         order by `".$column."`)
					union
			         (select *
			         from ".$this->db->dbprefix('timekeeping')."
			         where description like '".$this->db->escape_like_str($search)."%' and deleted = 0
			         order by `".$column."`)
			) as search_results
			order by `".$column."` limit ".$offset.','.$limit;
			return $this->db->query($query);
		}

		else
		{
		$str_search = str_replace( array('_', '@', '#', '$', '%') , ' ', $search );

			$search_terms_array=explode(" ", $this->db->escape_like_str($str_search));

			//to keep track of which search term of the array we're looking at now
			$search_name_criteria_counter=0;
			$sql_search_name_criteria = '';
			//loop through array of search terms
			foreach ($search_terms_array as $x){

				$sql_search_name_criteria.=
				($search_name_criteria_counter > 0 ? " AND " : "").
				"day_keeping LIKE '%".$this->db->escape_like_str($x)."%'";

				$search_name_criteria_counter++;
			}

			$this->db->from('timekeeping');
			$this->db->where("((".
			$sql_search_name_criteria. ") or
			id LIKE '%".$this->db->escape_like_str($search)."%' or
			description LIKE '%".$this->db->escape_like_str($search)."%') $cat_id and deleted=0");
			//location LIKE '%".$this->db->escape_like_str($search)."%') $cat_id and deleted=0");
			$this->db->order_by($column, $orderby);
			$this->db->limit($limit);
			$this->db->offset($offset);
			return $this->db->get();
		}

	}
	// xo chu khi nhap gtri search
	function get_search_suggestions($search,$limit=25)
	{
		$suggestions = array();

		$this->db->from('timekeeping');
		$this->db->like('day_keeping', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("day_keeping", "asc");
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=array('label' => $row->day_keeping);
		}

		$this->db->from('timekeeping');
		$this->db->like('id', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("id", "asc");
		$by_item_number = $this->db->get();
		foreach($by_item_number->result() as $row)
		{
			$suggestions[]=array('label' => $row->id);
		}

		$this->db->from('timekeeping');
		$this->db->like('description', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->where('deleted',0);
		$this->db->order_by("description", "asc");
		$by_item_number = $this->db->get();
		foreach($by_item_number->result() as $row)
		{
			$suggestions[]=array('label' => $row->description);
		}
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

		$this->db->from('timekeeping');
		$this->db->where('deleted',0);
		$this->db->like('day_keeping', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("day_keeping", "asc");
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=array('value' => $row->id, 'label' => $row->day_keeping);
		}

		$this->db->from('timekeeping');
		$this->db->where('deleted',0);
		$this->db->like('id', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("id", "asc");
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}

	function delete_list($id)
	{
		/* giang 4/4/2014 */
//		if(!$id){
		$this->db->where_in('id',$id);
//		}
		/* giang 4/4/2014 */
		return $this->db->update('timekeeping', array('deleted' => 1));
 	}
	function cleanup()
	{
		$item_data = array('id' => null);
		$this->db->where('deleted', 1);
		return $this->db->update('timekeeping',$item_data);
	}

    function get_all_salary_config($id = -1)
    {
        $table = $this->db->dbprefix('salary_config');
        $sql = "SELECT  * FROM ".$table;
        $data = $this->db->query($sql);

        return $data->result_array();
    }

    function get_info_employees()
    {
        $sql = "SELECT a.person_id,first_name FROM ".$this->_table_employees." AS a,$this->_table_people AS b WHERE a.person_id = b.person_id AND deleted = 0";
        $data = $this->db->query($sql);

        return $data->result();
    }
    function get_one_info($id)
    {
        $sql = "SELECT person_id FROM ".$this->_table_timekeeping ." WHERE id = $id";
        $data = $this->db->query($sql);

        return $data->row();
    }
    function get_all_information($id = -1)
    {
        $person_id = $this->get_one_info($id);
        $sql = "SELECT a.person_id,first_name,a.department_id,r.jobs_regions_id,e.jobs_city_id,d.jobs_affiliates_id
                FROM ".$this->_table_employees." AS a,$this->_table_people AS b ,$this->_table_department AS c,$this->_table_affiliates AS d,$this->_table_city AS e,$this->_table_regions AS r
                WHERE a.person_id = b.person_id AND a.person_id = $person_id->person_id  AND a.department_id = c.department_id AND c.jobs_affiliates_id = d.jobs_affiliates_id AND d.jobs_city_id = e.jobs_city_id AND e.jobs_regions_id = r.jobs_regions_id";
        $data = $this->db->query($sql);

        return $data->row();
    }
}
