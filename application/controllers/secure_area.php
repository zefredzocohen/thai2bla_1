<?php
class Secure_area extends CI_Controller
{
	var $module_id;

	/*
	Controllers that are considered secure extend Secure_area, optionally a $module_id can
	be set to also check if a user can access a particular module in the system.
	*/
	function __construct($module_id=null)
	{
		parent::__construct();
		$this->module_id = $module_id;
		$this->load->model('Employee');
		if(!$this->Employee->is_logged_in())
		{
			redirect('login');
		}

		if(!$this->Employee->has_module_permission($this->module_id,$this->Employee->get_logged_in_employee_info()->person_id))
		{
			redirect('no_access/'.$this->module_id);
		}

		//load up global data
		$logged_in_employee_info=$this->Employee->get_logged_in_employee_info();
		$data['allowed_modules_home']=$this->Module->get_allowed_modules_home($logged_in_employee_info->person_id);
		$data['allowed_modules_header']=$this->Module->get_allowed_modules_header($logged_in_employee_info->person_id);
		$data['allowed_modules']=$this->Module->get_allowed_modules($logged_in_employee_info->person_id);
		$data['user_info']=$logged_in_employee_info;

		//change pass
		$employee_id2['person_id']=$this->Employee->get_logged_in_employee_info()->person_id;
		$employee_id=$employee_id2['person_id'];
		$data['user_info2']=$this->Employee->get_info_one_hit($employee_id);

		$data['person_info']= $this->Employee->getInfoOne($logged_in_employee_info->person_id);
		$data['suspended_sales'] = $this->Sale->get_all_suspended()->result_array();
		$data['payment_date'] = $this->Sale->get_all_suspended_web()->result_array();
		//$data['customer'] = $this->Customer->findBirthDate();
		$data['register_date'] = $this->Customer->finddateregister();
		/* phan lam bao cao no */
		$data['suspends_date'] = $this->Inventory->find_suspends_date();
		/* end phan lam bao cao no */
		$data['warning_reports'] = $this->Jobs_projects->findnewreport();
		$items = array();
		$allitems = $this->Customer->findAllItem();
		foreach ($allitems as $allitem){
			if ($allitem['quantity'] <= $allitem['reorder_level']){
				$items[]= $allitem['item_id'];
			}
		}
		$data['items'] = $items;
		$this->load->vars($data);
	}
	function save_change_pass($employee_id){
		$checkPass = $this->input->post('password');
        if(!empty($checkPass)){
            $person_data['password']= md5($this->input->post('password'));
		}
		if($this->Employee->save_change_pass($person_data, $employee_id)){
            echo json_encode(array(
            	'success'=>true,
            	'message'=>'Đổi mật khẩu thành công !',
            ));
        }
	}

	function check_action_permission($action_id)
	{
		if (!$this->Employee->has_module_action_permission($this->module_id, $action_id, $this->Employee->get_logged_in_employee_info()->person_id))
		{
			redirect('no_access/'.$this->module_id);
		}else{
			return 1;
		}
	}
}
?>
