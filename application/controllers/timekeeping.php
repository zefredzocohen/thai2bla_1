<?php
	require_once ("secure_area.php");
	require_once ("interfaces/idata_controller.php");
	
class Timekeeping extends Secure_area
{	
	function __construct(){
		parent::__construct('');
        $this->_item = $this->session->userdata('person_id');
        $this->load->model('jobs_department');
		$this->load->model('jobs_affiliates');
        
	}

	function index()
	{		
        $this->check_action_permission('search');
		$config['base_url'] = site_url('timekeeping/sorting');
		$config['total_rows'] = $this->Timekeepings->count_all();
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();		
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['get_form_width_static']=$this->get_form_width_static();
		$data['total_rows'] = $this->Timekeepings->count_all();
		$data['per_page'] = $config['per_page'];
		$data['manage_table']=get_timekeeping_manage_table($this->Timekeepings->get_all($data['per_page']),$this);
		
		$this->load->view('timekeeping/manage',$data);		
	}
    /*
     *  TOÀN BỘ PHẦN LÀM TÍNH LƯƠNG
     * */
    public function payrolls()
    {
        $this->check_action_permission('add_update');
        $date = explode('-', date('d-m-Y'));
        $month =  $this->input->post('month');
        if($month<=9 && $month >=1) $month = '0'.$month;
        $year = $this->input->post('year');
        
        $data['person_info'] = $this->Timekeepings->getAllPersonSalary($year == '' ? $date[0] : $year ,$month == '' ? $date[1] : $month,'','');
        $data['salary_info'] = $this->Timekeepings->getAllSalary($year,$month);
        $data['rewards_info'] = $this->Timekeepings->getWelfareRewards();
        
        // Lấy thông tin từ bảng config
        $data['config_phone_support'] = $this->Timekeepings->getConfigSalary('config_phone_support');
        $data['meals'] = $this->Timekeepings->getConfigSalary('meals');
        $data['gasoline'] = $this->Timekeepings->getConfigSalary('gasoline');
        
        $data['salarycongfig_info'] = $this->Timekeepings->getSalaryConfig($year,$month);
       /* $data['manager_info'] = $this->Timekeepings->getPersonManager($this->_item,$year == '' ? $date[0] : $year ,$month == '' ? $date[1] : $month );
        $data['manager_name'] = $this->Timekeepings->getManagerName($this->_item,$year == '' ? $date[0] : $year ,$month == '' ? $date[1] : $month );
        $data['parent_name'] = $this->Timekeepings->getParentName($this->_item,$year == '' ? $date[0] : $year ,$month == '' ? $date[1] : $month );*/
        $data['salary_option'] = $this->Timekeepings->getTableSalaryOption();
        $data['department_info'] = $this->Timekeepings->getDepartment();
        $data['employees_info'] = $this->Timekeepings->getEmployees();
        $data['department_info'] = $this->Timekeepings->getDepartment();
        $data['person_id'] = $this->_item;
       /* if( $this->check_action_permission('add_update')){*/
            $this->load->view('timekeeping/salary/payrolls',$data);
       /* }else{
            $this->load->view('timekeeping/salary/payrolls_admin',$data);
        }*/
    }
    /*
     * Hàm thực hiện upload thông tin vào các table liên quan đến tính lương
     * */
    public function updateTable()
    {
        $string = array(',','.','-');
        $person_id = str_replace($string,'',$this->input->post('person_id'));
        $em_salary_basic = str_replace($string,'',$this->input->post('em_salary_basic'));
        $em_wage_level_coverage = str_replace($string,'',$this->input->post('em_wage_level_coverage'));
        $total_x150 = str_replace($string,'',$this->input->post('total_x150'));
        $total_x200 = str_replace($string,'',$this->input->post('total_x200'));
        $total_x300 = str_replace($string,'',$this->input->post('total_x300'));
        $pc_lunch = str_replace($string,'',$this->input->post('pc_lunch'));
        $pc_seniority = str_replace($string,'',$this->input->post('pc_seniority'));
        $pc_position = str_replace($string,'',$this->input->post('pc_position'));
        $pc_project = str_replace($string,'',$this->input->post('pc_project'));
        $pc_computer = str_replace($string,'',$this->input->post('pc_computer'));
        $pc_petrol_phone = str_replace($string,'',$this->input->post('pc_petrol_phone'));
        $pc_other_support = str_replace($string,'',$this->input->post('pc_other_support'));
        $money_amount_owed = str_replace($string,'',$this->input->post('money_amount_owed'));
        $money_custody = str_replace($string,'',$this->input->post('money_custody'));
        $money_advance = str_replace($string,'',$this->input->post('money_advance'));
        $total_real_wages = str_replace($string,'',$this->input->post('total_real_wages'));
        $expected_salary_1 = str_replace($string,'',$this->input->post('expected_salary_1'));
        $expected_salary_2 = str_replace($string,'',$this->input->post('expected_salary_2'));
        $account_complete_again = str_replace($string,'',$this->input->post('$account_complete_again'));
		
        //Thục hiện update employees nhân viên
        $hs_salary = $this->Timekeepings->getHS_Salary($person_id);
        $em_salary_basic = $em_salary_basic/$hs_salary->hs_salary;
        $this->Timekeepings->updateEmployees($person_id,$em_salary_basic,$em_wage_level_coverage);
        $this->Timekeepings->updateSalaryOption($person_id,$total_x150,$total_x200,$total_x300);

        $data = array(
            'person_id'=>"$person_id",
            'pc_lunch'=>"$pc_lunch",
            'pc_seniority'=>"$pc_seniority",
            'pc_computer'=>"$pc_computer",
            'pc_position'=>"$pc_position",
            'pc_project'=>"$pc_project",
            'pc_petrol_phone'=>"$pc_petrol_phone",
            'pc_other_support'=>"$pc_other_support",
        );
        $this->Timekeepings->updateWelfareRewards($data);
        $month = $this->input->post('month');
        if($month<=9 && $month >=1) $month = '0'.$month;
        $year = $this->input->post('year');
        $items = array(
            "person_id"=>$person_id,
            "date_salary"=>$year.'-'.$month,
            "money_amount_owed"=>$money_amount_owed,
            "money_custody"=>$money_custody,
            "money_advance"=>$money_advance,
            "total_real_wages"=>$total_real_wages,
            "expected_salary_1"=>$expected_salary_1,
            "expected_salary_2"=>$expected_salary_2,
            "account_complete_again"=>$account_complete_again,
        );
        
        $this->Timekeepings->actionSalary($items);

        $data['person_info'] = $this->Timekeepings->getAllPersonSalary($year,$month,'','');
        $data['salary_info'] = $this->Timekeepings->getAllSalary($year,$month);
        $data['rewards_info'] = $this->Timekeepings->getWelfareRewards();
        $data['salarycongfig_info'] = $this->Timekeepings->getSalaryConfig($year,$month);
        $data['salary_option'] = $this->Timekeepings->getTableSalaryOption();
        $data['department_info'] = $this->Timekeepings->getDepartment();
        $data['employees_info'] = $this->Timekeepings->getEmployees();
        $this->load->view('timekeeping/salary/salary_td',$data);
    }

    public function loadSalary()
    {
        $date = explode('-', date('d-m-Y'));
        $month =  $this->input->post('month');
         if($month<=9 && $month >=1) $month = '0'.$month;
        $year = $this->input->post('year');
        if($this->check_action_permission('add_update')){
            $department_id = $this->input->post('department_id');
            $employees_id = $this->input->post('employees_id');
            $data['person_info'] = $this->Timekeepings->getAllPersonSalary($year,$month,$department_id,$employees_id);
        }else{
            $data['person_info'] = $this->Timekeepings->getAllPersonSalary($year,$month,'','',''); /*Giang: 31/3/2014 */
        }
        $data['manager_info'] = $this->Timekeepings->getPersonManager($this->_item,$year == '' ? $date[0] : $year ,$month == '' ? $date[1] : $month );
        $data['salary_info'] = $this->Timekeepings->getAllSalary($year,$month);
        $data['rewards_info'] = $this->Timekeepings->getWelfareRewards();
        $data['salarycongfig_info'] = $this->Timekeepings->getSalaryConfig($year,$month);
        $data['salary_option'] = $this->Timekeepings->getTableSalaryOption();
        $data['department_info'] = $this->Timekeepings->getDepartment();
        $data['employees_info'] = $this->Timekeepings->getEmployees();
      /*  if($this->check_action_permission('add_update')){*/
            // if($this->_item != 1 )
            if($data['manager_info']->status == 1){
                $this->load->view('timekeeping/salary/salary_admin',$data);
            }else{
                $this->load->view('timekeeping/salary/salary_td',$data);
            }
            /*   else
                   $this->load->view('timekeeping/salary/salary_admin',$data);*/
//        }else{
//            $this->load->view('timekeeping/salary/salary_one',$data);
//        }
    }
    public function saveSalary()
    {
        $string = array(',','.');
        $month =  $this->input->post('month');
        if($month<=9 && $month >=1) $month = '0'.$month;
        $year = $this->input->post('year');

        echo $year.$month;

        $submit_manager =  $this->input->post('submit_manager');
        $reset_manager =  $this->input->post('reset_manager');
        if(isset($submit_manager)){
            $comment_manager = $this->input->post('comment_manager');
            $data = array(
                'comment_manager'=>$comment_manager,
                'status' =>1,
                'parent_manager_id'=>$this->_item,
                'date_parent_manager'=>date('Y-m-d'),
                'date_salary'=>$year.'-'.$month,
            );

            $this->Timekeepings->saveSalaryCommnet($data);
            echo '1';
        }else if(isset($reset_manager)){
            $comment_manager = $this->input->post('comment_manager');
            $data = array(
                'comment_manager'=>$comment_manager,
                'status' =>0,
                'parent_manager_id'=>$this->_item,
                'date_parent_manager'=>date('Y-m-d'),
                'date_salary'=>$year.'-'.$month,
            );

            $this->Timekeepings->saveSalaryCommnet($data);
            echo '3';
        }else{
            $tong_tien_thuc_linh = str_replace($string,'',$this->input->post('tong_tien_thuc_linh'));
            foreach($tong_tien_thuc_linh AS $key=>$values)
            {
                $data = array(
                    'item'=>$values."#".$year.'-'.$month);
                $item['item_'.$key] = explode('#',$data['item']);
                $array = array(
                    'person_id'=>$item['item_'.$key][1],
                    'total_actual'=>$item['item_'.$key][0],
                    'debt_salary'=>$item['item_'.$key][2],
                    'date_salary'=>$item['item_'.$key][3],
                );

                $this->Timekeepings->saveSalary($array);
            }
            echo '2';
        }

    }


    /*
     *  END PHẦN CHẤM CÔNG
     * */
	//load form them and sua
	function view($id=-1)
	{
		$this->check_action_permission('add_update');
		if($id == -1)
		{
			$data['jobs_city']=$this->Timekeepings->get_all_city();
			$data['jobs_position']=$this->Timekeepings->get_all_positions();
			$data['salaryconfig']=$this->Timekeepings->get_all_salaryconfig();
            $data['employees_info']= $this->Jobs_employees->getActionEmployeesHasContractAll();
            if($id != -1){

                $data['all_info']= $this->Timekeepings->get_all_information($id);
            }
            $data['name_peron_info']= $this->Jobs_department->get_person_info();
            $data['city_info']= $this->Jobs_department->get_city_action();
            $data['affiliates_info']= $this->Jobs_department->get_affiliates_name();
            $data['regions_info']= $this->Jobs_department->get_regions_info();
            $data['department_info'] = $this->Jobs_department->get_department_name();
            $data['salaryconfig_info'] = $this->Timekeepings->get_all_salary_config();
			
                       
			$this->load->view("timekeeping/form",$data);
		}
		elseif($id == -2){
            $data['company']=$this->Appconfig->get_name_company();
            $data['salarystatic']=$this->Timekeepings->get_all_day_salarystatic();
            $data['department_info'] = $this->Timekeepings->getDepartment();
            $data['employees_info'] = $this->Timekeepings->getEmployees();

            $this->load->view("timekeeping/timekeeping/formstatistics",$data);
		}
		else
		{
            $data['jobs_city']=$this->Timekeepings->get_all_city();
            $data['jobs_position']=$this->Timekeepings->get_all_positions();
            $data['salaryconfig']=$this->Timekeepings->get_all_salaryconfig();
            $data['employees_info']= $this->Jobs_employees->getActionEmployeesHasContractAll();
            if($id != -1){

                $data['all_info']= $this->Timekeepings->get_all_information($id);
            }
            $data['name_peron_info']= $this->Jobs_department->get_person_info();
            $data['city_info']= $this->Jobs_department->get_city_action();
            $data['affiliates_info']= $this->Jobs_department->get_affiliates_name();
            $data['regions_info']= $this->Jobs_department->get_regions_info();
            $data['department_info'] = $this->Jobs_department->get_department_name();
            $data['salaryconfig_info'] = $this->Timekeepings->get_all_salary_config();
			$data['item_info']= $this->Timekeepings->get_info($id);
			
			$this->load->view("timekeeping/form",$data);
			
		}
	}
    function loadRegions($id = -1)
    {
    	
        $regions_id = $this->input->post('jobs_regions_id');
		
        $data['city_info'] = $this->Jobs_employees->getAllCity($regions_id);
        $items = array();
        foreach( $data['city_info'] AS $key => $values){
            $items[] = $values->jobs_city_id;
        }
       
        $data['affiliates_info']= $this->Jobs_employees->getActionAffiliates($id,$items);
        $item_department = array();

        foreach( $data['affiliates_info'] AS $values){
            $item_department[]= $values->jobs_affiliates_id;
        }
        $item_department = implode($item_department,',');
        $data['department_info'] =  $this->Jobs_employees->getActionsDepartment($id,$item_department);

        $item_employees = array();
		 
        foreach($data['department_info'] AS $values){
            $item_employees[]=$values->department_id;
        }
        $item_employees = implode($item_employees,',');
        $data['employees_info'] =  $this->Jobs_employees->getActionsEmployeesHasContract($id,$item_employees);
        $this->load->view("timekeeping/action/form_action_regions",$data);
    }
    function loadCity($id = -1)
    {
        $city_id = $this->input->post('jobs_city_id');

        $data['affiliates_info']= $this->Jobs_employees->getActionAffiliates($id,$city_id);
        $item_department = array();

        foreach( $data['affiliates_info'] AS $values){
            $item_department[]= $values->jobs_affiliates_id;
        }
        $item_department = implode($item_department,',');
        $data['department_info'] =  $this->Jobs_employees->getActionsDepartment($id,$item_department);

        $item_employees = array();

        foreach($data['department_info'] AS $values){
            $item_employees[]=$values->department_id;
        }
        $item_employees = implode($item_employees,',');
        $data['employees_info'] =  $this->Jobs_employees->getActionsEmployeesHasContract($id,$item_employees);

        $this->load->view("timekeeping/action/form_action_city",$data);
    }
    function loadAffiliates($id = -1)
    {
        $affiliates_id = $this->input->post('jobs_affiliates_id');

        $data['department_info'] =  $this->Jobs_employees->getActionsDepartment($id,$affiliates_id);
        $item_employees = array();

        foreach($data['department_info'] AS $values){
            $item_employees[]=$values->department_id;
        }
        $item_employees = implode($item_employees,',');
        $data['employees_info'] =  $this->Jobs_employees->getActionsEmployeesHasContract($id,$item_employees);

        $this->load->view("timekeeping/action/form_action_affiliates",$data);
    }
    function loadDepartment($id = -1)
    {
        $department_id = $this->input->post('department_id');
        $data['employees_info'] =  $this->Jobs_employees->getActionsEmployeesHasContract($id,$department_id);

        $this->load->view("timekeeping/action/form_action_department",$data);
    }
    
    function loadEmployees($id = -1){
    	$person_id = $this->input->post('person_id');
		$data['regions_info']= $this->Jobs_department->get_regions_info();
    	$data['employees_info'] =  $this->Jobs_employees->getActionEmployees($person_id);
    	$data['department_info'] =  $this->jobs_department->get_department_name();
    	$data['affiliates_info']= $this->Jobs_department->get_affiliates_name();
    	$data['city_info'] = $this->jobs_affiliates->get_city_info();
    	$data['employees_all'] = $this->Jobs_employees->getActionEmployeesHasContractAll();
    	$this->load->view("timekeeping/action/form_action_employees",$data);
    }

    /**
        TOÀN BỘ PHẦN LÀM CHẤM CÔNG
     */
        /*
         *  Hàm thực hiện load thông tin chấm công lên
         * */
        public function timekeepings()
        {
            $data['company']=$this->Appconfig->get_name_company();
            $data['salarystatic']=$this->Timekeepings->get_all_day_salarystatic();
            $data['department_info'] = $this->Timekeepings->getDepartment();
            $data['employees_info'] = $this->Jobs_employees->getActionEmployeesHasContractAll();

            $this->load->view("timekeeping/timekeeping/formstatistics",$data);
        }
    /*
     * Function từ ngày tháng năm =>thú trong tuần với PHP
     * */
        function getThu($m,$d,$y)
        {
            $date = cal_to_jd(CAL_GREGORIAN,$m,$d,$y);
            $day=jddayofweek($date,0);
            switch($day){
                case 0 :
                    $thu = "CN";break;
                case 1:
                    $thu = 'T2';break;
                case 2:
                    $thu = 'T3';break;
                case 3:
                    $thu = 'T4';break;
                case 4:
                    $thu = 'T5';break;
                case 5:
                    $thu = 'T6';break;
                case 6:
                    $thu = 'T7';break;
            }
            return $thu;
        }

        /*
         *  Function default get all information of chấm công
         * */
        function loadDefault()
        {
            $this->check_action_permission('add_update');
            $date = explode('-', date('d-m-Y'));
            $month = $this->input->post('month') == '' ? $date[1] : $this->input->post('month');
            $year = $this->input->post('year') == '' ? $date[0] : $this->input->post('year');
             if($month<=9 && $month >=1) $month = '0'.$month;
            $department_id = $this->input->post('department_id');
            $employees_id = $this->input->post('employees_id');

            $this->showDefaultDate($year,$month,$department_id,$employees_id);

        }
        function loadUpdate()
        {
            $this->check_action_permission('add_update');
            $person_id = $this->input->post('person_id');
            $description = $this->input->post('description');
            $values = $this->input->post('value') == '' ? '' : $this->input->post('value');

            $date = explode('-', date('d-m-Y'));
            $month = $this->input->post('month') == '' ? $date[1] : $this->input->post('month');
            if($month<=9 && $month >=1) $month = '0'.$month;
            $year = $this->input->post('year') == '' ? $date[0] : $this->input->post('year');
            $department_id = $this->input->post('department_id');
            $employees_id = $this->input->post('employees_id');

            $day = $this->input->post('date');
            $item = array(
                   'person_id'=>$person_id,
                   'day_keeping'=>$day,
                   'salaryconfig_id'=>$values,
                   'description' => $description == '' ? '' : $description ,
                   'deleted'=> 0
             );
            $this->Timekeepings->actionTimeKeeping($item);
			/* giang 4/4/1013 */
            $this->showDefaultDate($year,$month,$department_id,$employees_id);
//           if($month == $date[1] && $year == $date[0] ){
//               $this->showDefault($year,$month,$department_id,$employees_id);
//               
//           }else{
//               $this->showDefaultDate($year,$month,$department_id,$employees_id);
//           }
			/* giang 4/4/1013 */


        }
        function getEmployees()
        {
            $department_id = $this->input->post('department_id');
            $data['employees_info']= $this->Timekeepings->getEmployees($department_id);
            $this->load->view("timekeeping/timekeeping/select_employees",$data);
        }
        
        function getAllThu()
        {
            $this->check_action_permission('add_update');
            $date = explode('-', date('d-m-Y'));
            $month = $this->input->post('month') == '' ? $date[1] : $this->input->post('month');
            $year = $this->input->post('year') == '' ? $date[0] : $this->input->post('year');

            $data['thu_01'] = $this->getThu($month,'1',$year);
            $data['thu_02'] = $this->getThu($month,'2',$year);
            $data['thu_03'] = $this->getThu($month,'3',$year);
            $data['thu_04'] = $this->getThu($month,'4',$year);
            $data['thu_05'] = $this->getThu($month,'5',$year);
            $data['thu_06'] = $this->getThu($month,'6',$year);
            $data['thu_07'] = $this->getThu($month,'7',$year);
            $data['thu_08'] = $this->getThu($month,'8',$year);
            $data['thu_09'] = $this->getThu($month,'9',$year);
            $data['thu_10'] = $this->getThu($month,'10',$year);
            $data['thu_11'] = $this->getThu($month,'11',$year);
            $data['thu_12'] = $this->getThu($month,'12',$year);
            $data['thu_13'] = $this->getThu($month,'13',$year);
            $data['thu_14'] = $this->getThu($month,'14',$year);
            $data['thu_15'] = $this->getThu($month,'15',$year);
            $data['thu_16'] = $this->getThu($month,'16',$year);
            $data['thu_17'] = $this->getThu($month,'17',$year);
            $data['thu_18'] = $this->getThu($month,'18',$year);
            $data['thu_19'] = $this->getThu($month,'19',$year);
            $data['thu_20'] = $this->getThu($month,'20',$year);
            $data['thu_21'] = $this->getThu($month,'21',$year);
            $data['thu_22'] = $this->getThu($month,'22',$year);
            $data['thu_23'] = $this->getThu($month,'23',$year);
            $data['thu_24'] = $this->getThu($month,'24',$year);
            $data['thu_25'] = $this->getThu($month,'25',$year);
            $data['thu_26'] = $this->getThu($month,'26',$year);
            $data['thu_27'] = $this->getThu($month,'27',$year);
            $data['thu_28'] = $this->getThu($month,'28',$year);
            $data['thu_29'] = $this->getThu($month,'29',$year);
            $data['thu_30'] = $this->getThu($month,'30',$year);
            $data['thu_31'] = $this->getThu($month,'31',$year);
            $data['date_info'] = $data;
            $this->load->view("timekeeping/timekeeping/day_of_week",$data);

        }
        /*
         *  Func hiền thị thông các trường theo ngày tháng năm thông tin chấm công
         * */
        function showDefaultDate($year,$month,$department_id,$employees_id)
        {
        	
            $data['day_month'] = $year.'-'.$month;
            $data['kepping_info'] = $this->Timekeepings->getAllPersonDate($year,$month,$department_id,$employees_id);
            $data['total_vacation'] = $this->Timekeepings->getAllSalaryConfig($year,$month);
            $data['description_info'] = $this->Timekeepings->getDescription();
            $data['data_salary'] = $this->Timekeepings->getNameSalaryConfig();
            $data['count_x'] = $this->Timekeepings->getCount($year,$month,'X',$department_id,$employees_id);
            $data['count_x_2'] = $this->Timekeepings->getCount($year,$month,'X/2',$department_id,$employees_id);
            $data['count_k_2_x_2'] = $this->Timekeepings->getCount($year,$month,'K/2:X/2',$department_id,$employees_id);
            $data['count_l_2_x_2'] = $this->Timekeepings->getCount($year,$month,'L/2:X/2',$department_id,$employees_id);
            $data['count_p_2_x_2'] = $this->Timekeepings->getCount($year,$month,'P/2:X/2',$department_id,$employees_id);
            $data['count_ts_2_x_2'] = $this->Timekeepings->getCount($year,$month,'TS/2:X/2',$department_id,$employees_id);
            $data['count_o_2_x_2'] = $this->Timekeepings->getCount($year,$month,'O/2:X/2',$department_id,$employees_id);
            $data['count_kl_2_x_2'] = $this->Timekeepings->getCount($year,$month,'KL/2:X/2',$department_id,$employees_id);
            $data['count_t_2_x_2'] = $this->Timekeepings->getCount($year,$month,'T/2:X/2',$department_id,$employees_id);

            $data['count_h'] = $this->Timekeepings->getCount($year,$month,'H',$department_id,$employees_id);
            $data['count_h_2'] = $this->Timekeepings->getCount($year,$month,'H/2',$department_id,$employees_id);

            $data['count_k'] = $this->Timekeepings->getCount($year,$month,'K',$department_id,$employees_id);
            $data['count_k_2'] = $this->Timekeepings->getCount($year,$month,'K/2',$department_id,$employees_id);

            $data['count_t'] = $this->Timekeepings->getCount($year,$month,'T',$department_id,$employees_id);
            $data['count_t_2'] = $this->Timekeepings->getCount($year,$month,'T/2',$department_id,$employees_id);

            $data['count_l'] = $this->Timekeepings->getCount($year,$month,'L',$department_id,$employees_id);
            $data['count_l_2'] = $this->Timekeepings->getCount($year,$month,'L/2',$department_id,$employees_id);

            $data['count_ts'] = $this->Timekeepings->getCount($year,$month,'TS',$department_id,$employees_id);
            $data['count_ts_2'] = $this->Timekeepings->getCount($year,$month,'TS/2',$department_id,$employees_id);

            $data['count_p'] = $this->Timekeepings->getCount($year,$month,'P',$department_id,$employees_id);
            $data['count_p_2'] = $this->Timekeepings->getCount($year,$month,'P/2',$department_id,$employees_id);
            $data['count_p_2_kl_2'] = $this->Timekeepings->getCount($year,$month,'P/2:KL/2',$department_id,$employees_id);

            $data['count_o'] = $this->Timekeepings->getCount($year,$month,'O',$department_id,$employees_id);
            $data['count_o_2'] = $this->Timekeepings->getCount($year,$month,'O/2',$department_id,$employees_id);

            $data['count_kl'] = $this->Timekeepings->getCount($year,$month,'KL',$department_id,$employees_id);
            $data['count_kl_2'] = $this->Timekeepings->getCount($year,$month,'KL/2',$department_id,$employees_id);

            $data['count_x150'] = $this->Timekeepings->getCount($year,$month,'X150',$department_id,$employees_id);
            $data['count_x150_2'] = $this->Timekeepings->getCount($year,$month,'X150/2',$department_id,$employees_id);

            $data['count_x200'] = $this->Timekeepings->getCount($year,$month,'X200',$department_id,$employees_id);
            $data['count_x200_2'] = $this->Timekeepings->getCount($year,$month,'X200/2',$department_id,$employees_id);

            $data['count_x300'] = $this->Timekeepings->getCount($year,$month,'X300',$department_id,$employees_id);
            $data['count_x300_2'] = $this->Timekeepings->getCount($year,$month,'X300/2',$department_id,$employees_id);

            $data['count_nb'] = $this->Timekeepings->getCount($year,$month,'NB',$department_id,$employees_id);

            $data['date_info01'] = $this->Timekeepings->getInfo($year,$month,'01');
            $data['date_info02'] = $this->Timekeepings->getInfo($year,$month,'02');
            $data['date_info03'] = $this->Timekeepings->getInfo($year,$month,'03');
            $data['date_info04'] = $this->Timekeepings->getInfo($year,$month,'04');
            $data['date_info05'] = $this->Timekeepings->getInfo($year,$month,'05');
            $data['date_info06'] = $this->Timekeepings->getInfo($year,$month,'06');
            $data['date_info07'] = $this->Timekeepings->getInfo($year,$month,'07');
            $data['date_info08'] = $this->Timekeepings->getInfo($year,$month,'08');
            $data['date_info09'] = $this->Timekeepings->getInfo($year,$month,'09');
            $data['date_info10'] = $this->Timekeepings->getInfo($year,$month,10);
            $data['date_info11'] = $this->Timekeepings->getInfo($year,$month,11);
            $data['date_info12'] = $this->Timekeepings->getInfo($year,$month,12);
            $data['date_info13'] = $this->Timekeepings->getInfo($year,$month,13);
            $data['date_info14'] = $this->Timekeepings->getInfo($year,$month,14);
            $data['date_info15'] = $this->Timekeepings->getInfo($year,$month,15);
            $data['date_info16'] = $this->Timekeepings->getInfo($year,$month,16);
            $data['date_info17'] = $this->Timekeepings->getInfo($year,$month,17);
            $data['date_info18'] = $this->Timekeepings->getInfo($year,$month,18);
            $data['date_info19'] = $this->Timekeepings->getInfo($year,$month,19);
            $data['date_info20'] = $this->Timekeepings->getInfo($year,$month,20);
            $data['date_info21'] = $this->Timekeepings->getInfo($year,$month,21);
            $data['date_info22'] = $this->Timekeepings->getInfo($year,$month,22);
            $data['date_info23'] = $this->Timekeepings->getInfo($year,$month,23);
            $data['date_info24'] = $this->Timekeepings->getInfo($year,$month,24);
            $data['date_info25'] = $this->Timekeepings->getInfo($year,$month,25);
            $data['date_info26'] = $this->Timekeepings->getInfo($year,$month,26);
            $data['date_info27'] = $this->Timekeepings->getInfo($year,$month,27);
            $data['date_info28'] = $this->Timekeepings->getInfo($year,$month,28);
            $data['date_info29'] = $this->Timekeepings->getInfo($year,$month,29);
            $data['date_info30'] = $this->Timekeepings->getInfo($year,$month,30);
            $data['date_info31'] = $this->Timekeepings->getInfo($year,$month,31);
			
            $this->load->view("timekeeping/timekeeping/table_tr",$data);

        }
        function showDefault($year,$month,$department_id,$employees_id)
        {
            $data['day_month'] = $year.'-'.$month;
            $data['kepping_info'] = $this->Timekeepings->getAllPerson($department_id,$employees_id,$year,$month);
            $data['total_vacation'] = $this->Timekeepings->getAllSalaryConfig($year,$month);
            $data['description_info'] = $this->Timekeepings->getDescription();
            $data['data_salary'] = $this->Timekeepings->getNameSalaryConfig();

            $data['count_x'] = $this->Timekeepings->getCount($year,$month,'X',$department_id,$employees_id);
            $data['count_x_2'] = $this->Timekeepings->getCount($year,$month,'X/2',$department_id,$employees_id);
            $data['count_k_2_x_2'] = $this->Timekeepings->getCount($year,$month,'K/2:X/2',$department_id,$employees_id);
            $data['count_l_2_x_2'] = $this->Timekeepings->getCount($year,$month,'L/2:X/2',$department_id,$employees_id);
            $data['count_p_2_x_2'] = $this->Timekeepings->getCount($year,$month,'P/2:X/2',$department_id,$employees_id);
            $data['count_ts_2_x_2'] = $this->Timekeepings->getCount($year,$month,'TS/2:X/2',$department_id,$employees_id);
            $data['count_o_2_x_2'] = $this->Timekeepings->getCount($year,$month,'O/2:X/2',$department_id,$employees_id);
            $data['count_kl_2_x_2'] = $this->Timekeepings->getCount($year,$month,'KL/2:X/2',$department_id,$employees_id);
            $data['count_t_2_x_2'] = $this->Timekeepings->getCount($year,$month,'T/2:X/2',$department_id,$employees_id);

            $data['count_h'] = $this->Timekeepings->getCount($year,$month,'H',$department_id,$employees_id);
            $data['count_h_2'] = $this->Timekeepings->getCount($year,$month,'H/2',$department_id,$employees_id);

            $data['count_k'] = $this->Timekeepings->getCount($year,$month,'K',$department_id,$employees_id);
            $data['count_k_2'] = $this->Timekeepings->getCount($year,$month,'K/2',$department_id,$employees_id);

            $data['count_t'] = $this->Timekeepings->getCount($year,$month,'T',$department_id,$employees_id);
            $data['count_t_2'] = $this->Timekeepings->getCount($year,$month,'T/2',$department_id,$employees_id);

            $data['count_l'] = $this->Timekeepings->getCount($year,$month,'L',$department_id,$employees_id);
            $data['count_l_2'] = $this->Timekeepings->getCount($year,$month,'L/2',$department_id,$employees_id);

            $data['count_ts'] = $this->Timekeepings->getCount($year,$month,'TS',$department_id,$employees_id);
            $data['count_ts_2'] = $this->Timekeepings->getCount($year,$month,'TS/2',$department_id,$employees_id);

            $data['count_p'] = $this->Timekeepings->getCount($year,$month,'P',$department_id,$employees_id);
            $data['count_p_2'] = $this->Timekeepings->getCount($year,$month,'P/2',$department_id,$employees_id);
            $data['count_p_2_kl_2'] = $this->Timekeepings->getCount($year,$month,'P/2:KL/2',$department_id,$employees_id);

            $data['count_o'] = $this->Timekeepings->getCount($year,$month,'O',$department_id,$employees_id);
            $data['count_o_2'] = $this->Timekeepings->getCount($year,$month,'O/2',$department_id,$employees_id);

            $data['count_kl'] = $this->Timekeepings->getCount($year,$month,'KL',$department_id,$employees_id);
            $data['count_kl_2'] = $this->Timekeepings->getCount($year,$month,'KL/2',$department_id,$employees_id);

            $data['count_x150'] = $this->Timekeepings->getCount($year,$month,'X150',$department_id,$employees_id);
            $data['count_x150_2'] = $this->Timekeepings->getCount($year,$month,'X150/2',$department_id,$employees_id);

            $data['count_x200'] = $this->Timekeepings->getCount($year,$month,'X200',$department_id,$employees_id);
            $data['count_x200_2'] = $this->Timekeepings->getCount($year,$month,'X200/2',$department_id,$employees_id);

            $data['count_x300'] = $this->Timekeepings->getCount($year,$month,'X300',$department_id,$employees_id);
            $data['count_x300_2'] = $this->Timekeepings->getCount($year,$month,'X300/2',$department_id,$employees_id);

            $data['count_nb'] = $this->Timekeepings->getCount($year,$month,'NB',$department_id,$employees_id);


            $data['date_info01'] = $this->Timekeepings->getInfo($year,$month,'01');
            $data['date_info02'] = $this->Timekeepings->getInfo($year,$month,'02');
            $data['date_info03'] = $this->Timekeepings->getInfo($year,$month,'03');
            $data['date_info04'] = $this->Timekeepings->getInfo($year,$month,'04');
            $data['date_info05'] = $this->Timekeepings->getInfo($year,$month,'05');
            $data['date_info06'] = $this->Timekeepings->getInfo($year,$month,'06');
            $data['date_info07'] = $this->Timekeepings->getInfo($year,$month,'07');
            $data['date_info08'] = $this->Timekeepings->getInfo($year,$month,'08');
            $data['date_info09'] = $this->Timekeepings->getInfo($year,$month,'09');
            $data['date_info10'] = $this->Timekeepings->getInfo($year,$month,10);
            $data['date_info11'] = $this->Timekeepings->getInfo($year,$month,11);
            $data['date_info12'] = $this->Timekeepings->getInfo($year,$month,12);
            $data['date_info13'] = $this->Timekeepings->getInfo($year,$month,13);
            $data['date_info14'] = $this->Timekeepings->getInfo($year,$month,14);
            $data['date_info15'] = $this->Timekeepings->getInfo($year,$month,15);
            $data['date_info16'] = $this->Timekeepings->getInfo($year,$month,16);
            $data['date_info17'] = $this->Timekeepings->getInfo($year,$month,17);
            $data['date_info18'] = $this->Timekeepings->getInfo($year,$month,18);
            $data['date_info19'] = $this->Timekeepings->getInfo($year,$month,19);
            $data['date_info20'] = $this->Timekeepings->getInfo($year,$month,20);
            $data['date_info21'] = $this->Timekeepings->getInfo($year,$month,21);
            $data['date_info22'] = $this->Timekeepings->getInfo($year,$month,22);
            $data['date_info23'] = $this->Timekeepings->getInfo($year,$month,23);
            $data['date_info24'] = $this->Timekeepings->getInfo($year,$month,24);
            $data['date_info25'] = $this->Timekeepings->getInfo($year,$month,25);
            $data['date_info26'] = $this->Timekeepings->getInfo($year,$month,26);
            $data['date_info27'] = $this->Timekeepings->getInfo($year,$month,27);
            $data['date_info28'] = $this->Timekeepings->getInfo($year,$month,28);
            $data['date_info29'] = $this->Timekeepings->getInfo($year,$month,29);
            $data['date_info30'] = $this->Timekeepings->getInfo($year,$month,30);
            $data['date_info31'] = $this->Timekeepings->getInfo($year,$month,31);

            $this->load->view("timekeeping/timekeeping/table_tr",$data);

        }

        //Hàm luu thông tin các trường dữ liệu trong tháng-năm lưu thông tin trong table salaryconfig
        function getAllSalarystatic()
        {
            $date = explode('-', date('d-m-Y'));
            $month = $this->input->post('month');
             if($month<=9 && $month >=1) $month = '0'.$month;
            $year =  $this->input->post('year');
            $person_id = $this->input->post('person_id');
            $count_all = $this->input->post('count_all');

            $total_vacation = $this->Timekeepings->getRowSalarystatic($year,$month,$person_id);

            $total_p =  $this->Timekeepings->getCountX($year,$month,'P',$person_id)
                + 1/2 *$this->Timekeepings->getCountX($year,$month,'P/2',$person_id)
                + 1/2 *  $this->Timekeepings->getCountX($year,$month,'P/2:X/2',$person_id)
                + 1/2 * $this->Timekeepings->getCountX($year,$month,'P/2:KL/2',$person_id);

            $total_x =  $this->Timekeepings->getCountX($year,$month,'X',$person_id)
                + 1/2 *$this->Timekeepings->getCountX($year,$month,'X/2',$person_id)
                + 1/2 * $this->Timekeepings->getCountX($year,$month,'K/2:X/2',$person_id)
                + 1/2 * $this->Timekeepings->getCountX($year,$month,'L/2:X/2',$person_id)
                + 1/2 *  $this->Timekeepings->getCountX($year,$month,'P/2:X/2',$person_id)
                + 1/2 *  $this->Timekeepings->getCountX($year,$month,'TS/2:X/2',$person_id)
                + 1/2 *  $this->Timekeepings->getCountX($year,$month,'O/2:X/2',$person_id)
                + 1/2 *  $this->Timekeepings->getCountX($year,$month,'KL/2:X/2',$person_id)
                + 1/2 *  $this->Timekeepings->getCountX($year,$month,'T/2:X/2',$person_id);

            $total_t = $this->Timekeepings->getCountX($year,$month,'T',$person_id)
                + 1/2 *  $this->Timekeepings->getCountX($year,$month,'T/2:X/2',$person_id)
                + 1/2 * $this->Timekeepings->getCountX($year,$month,'T/2',$person_id);

            $total_x150 = $this->Timekeepings->getCountX($year,$month,'X150',$person_id)
                + 1/2 *  $this->Timekeepings->getCountX($year,$month,'X150/2',$person_id);

            $total_x200 = $this->Timekeepings->getCountX($year,$month,'X200',$person_id)
                + 1/2 *  $this->Timekeepings->getCountX($year,$month,'X200/2',$person_id);

            $total_x300 = $this->Timekeepings->getCountX($year,$month,'X300',$person_id)
                + 1/2 *  $this->Timekeepings->getCountX($year,$month,'X300/2',$person_id);

            $total_k = $this->Timekeepings->getCountX($year,$month,'K',$person_id)
                + 1/2 * $this->Timekeepings->getCountX($year,$month,'K/2:X/2',$person_id)
                + 1/2 *  $this->Timekeepings->getCountX($year,$month,'K/2',$person_id);

            $total_l = $this->Timekeepings->getCountX($year,$month,'L',$person_id)
                + 1/2 * $this->Timekeepings->getCountX($year,$month,'L/2:X/2',$person_id)
                + 1/2 * $this->Timekeepings->getCountX($year,$month,'L/2',$person_id);

            $total_nb = $this->Timekeepings->getCountX($year,$month,'NB',$person_id);

            $total_all = $total_nb + $total_l + $total_k + $total_t +$total_p + $total_x;

            $data = array(
                'total_x' => $total_x,

                'total_h' => $this->Timekeepings->getCountX($year,$month,'H',$person_id)
                    + 1/2 * $this->Timekeepings->getCountX($year,$month,'H/2',$person_id),

                'total_k' => $total_k,

                'total_t' => $total_t,

                'total_l' => $total_l,

                'total_x150' => $total_x150,
                'total_x200' => $total_x200,
                'total_x300' => $total_x300,

                'total_ts' => $this->Timekeepings->getCountX($year,$month,'TS',$person_id)
                    + 1/2 *  $this->Timekeepings->getCountX($year,$month,'TS/2:X/2',$person_id)
                    + 1/2 * $this->Timekeepings->getCountX($year,$month,'TS/2',$person_id),

                'total_p' => $total_p,

                'total_o' => $this->Timekeepings->getCountX($year,$month,'O',$person_id)
                    + 1/2 *  $this->Timekeepings->getCountX($year,$month,'O/2:X/2',$person_id)
                    + 1/2 * $this->Timekeepings->getCountX($year,$month,'O/2',$person_id),

                'total_kl' => $this->Timekeepings->getCountX($year,$month,'KL',$person_id)
                    + 1/2 *  $this->Timekeepings->getCountX($year,$month,'KL/2:X/2',$person_id)
                    + 1/2 *  $this->Timekeepings->getCountX($year,$month,'KL/2',$person_id),

                'total_nb' => $total_nb,
                'total_c' => 0,
                'total_vacation' => $total_vacation->total_vacation + $total_p,
                'person_id' => $person_id,
                'year_months' => $year.'-'.$month,
                'total_all'=> $total_all
            );
            $this->Timekeepings->actionInsertSalarystatic($data);
        }
        /*
         *  END PHẦN CHẤM CÔNG
         * */
       /* function loadInfo()
        {
             $this->check_action_permission('add_update');
             $date = explode('-', date('d-m-Y'));
             $month = $this->input->post('month') == '' ? $date[1] : $this->input->post('month');
              if($month<=9 && $month >=1) $month = '0'.$month;
             $year = $this->input->post('year') == '' ? $date[0] : $this->input->post('year');
            // $department_id = $this->input->post('department_id') == '' ? '' : $this->input->post('department_id');
             $this->showDefault($year,$month,$department_id);
        }*/

	public function get_affliate(){
		$id_jobs=$this->input->post("jobcity");
		$this->db->where("jobs_city_id",$id_jobs);
		$query=$this->db->get("jobs_affiliates");
		$reuslt=$query->result_array();
		echo json_encode($reuslt);

	}
	public function get_department(){
		$id_department=$this->input->post("departmentcity");
		$this->db->where("jobs_affiliates_id",$id_department);
		$query=$this->db->get("jobs_department");
		$reuslt=$query->result_array();
		echo json_encode($reuslt);
	}
	
	public function get_position(){
		$id_position=$this->input->post("position");
		$this->db->where("department_id",$id_position);
		$query=$this->db->get("jobs_positions");
		$reuslt=$query->result_array();
		echo json_encode($reuslt);
	}
	
	public function get_first_name(){
	  $ma_chucvu=$this->input->post('machucvu');
	  $query=$this->Timekeepings->get_info_first_name($ma_chucvu);
	  $tennhanvien=$query->result_array();
	  echo json_encode($tennhanvien);
 	}
 
	function get_info($id=-1)
	{
		echo json_encode($this->Timekeepings->get_info($id));
	}
	
	function save($id=-1)
	{
		$this->check_action_permission('add_update');		
		$item_data = array(
			'day_keeping'=>date('Y-m-d', strtotime($this->input->post('day_keeping'))) == '' ? date('Y-m-d') : date('Y-m-d', strtotime($this->input->post('day_keeping')))  ,
			'person_id'=>$this->input->post('person_id'),
			'salaryconfig_id'=>$this->input->post('salaryconfig'),
			'description'=>''
        );

		if($this->Timekeepings->save($item_data,$id))
		{
			//New item
			if($id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>lang('timekeeping_successful_adding').' '.
				$item_data['name'],'id'=>$item_data['id']));
				$id = $item_data['id'];
			}
			
			else //previous item
			{
				echo json_encode(array('success'=>true,'message'=>lang('timekeeping_successful_updating').' '.
				$item_data['name'],'id'=>$id));
			}

		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>lang('timekeeping_error_adding_updating').' '.
			$item_data['name'],'id'=>-1));
		}

	}
	
	function sorting()
	{
		$this->check_action_permission('search');
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		if ($search)
		{
			$config['total_rows'] = $this->Timekeepings->search_count_all($search);
			$table_data = $this->Timekeepings->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'day_keeping' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		else
		{
			$config['total_rows'] = $this->Timekeepings->count_all();
			$table_data = $this->Timekeepings->get_all($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'day_keeping' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		$config['base_url'] = site_url('timekeeping/sorting');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_timekeeping_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
	}
		
	function search()
	{
		$this->check_action_permission('search');
		$search=$this->input->post('search');
		
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		
		$search_data=$this->Timekeepings->search($search,$cat,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'day_keeping' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		$config['base_url'] = site_url('timekeeping/search');
		
		$config['total_rows'] = $this->Timekeepings->search_count_all($search);
		$config['per_page'] = $per_page ;
		$this->pagination->initialize($config);				
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_timekeeping_manage_table_data_rows($search_data,$this);

		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
		
		
	}
	
	/// - tro nhung tu tuowng tu trong he thong co san maf ng dung mun tim
	function suggest()
	{
		$suggestions = $this->Timekeepings->get_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}
	
	function item_search()
	{
		$suggestions = $this->Timekeepings->get_category_search_suggestions($this->input->get('term'),100);
		echo json_encode($suggestions);
	}
	function get_row()
	{
		$id_cat = $this->input->post('row_id');
		$data_row=get_item_data_row($this->Timekeepings->get_info($id),$this);
		echo $data_row;
	}

	//delete
	function delete()
	{

		$this->check_action_permission('delete');		
		$categories_to_delete=$this->input->post('ids');
		$select_inventory=$this->get_select_inventory();
		$total_rows= $select_inventory ? $this->Timekeepings->count_all() : count($categories_to_delete);
		//clears the total inventory selection
		$this->clear_select_inventory();
		if($this->Timekeepings->delete_list($categories_to_delete))
		{
			
			echo json_encode(array('success'=>true,'message'=>lang('timekeeping_successful_deleted').' '.
			$total_rows.' '.lang('timekeeping_one_or_multiple')));
		}
		else
		{
			echo json_encode(array('success'=>false,'message'=>lang('timekeeping_cannot_be_deleted')));
		}
	}
	
	
	function get_select_inventory() 
	{
		return $this->session->userdata('select_inventory') ? $this->session->userdata('select_inventory') : 0;
	}
	
	function clear_select_inventory() 	
	{
		$this->session->unset_userdata('select_inventory');
		
	}
	
	function get_info_employees()
	{
		return $this->Timekeepings->get_info_employees();
	}
    function get_all_salary_config()
	{
		return $this->Timekeepings->get_all_salary_config();
	}
	function get_form_width()
	{
		return 455;
	}
	function get_form_width_static()
    {
        return 1200;
    }
}
?>