<?php
require_once ("secure_area.php");
class Templates extends secure_area
{
public $model_name = "Template" ;
public function __construct()
	{
		parent::__construct();
	}
public function index()
	{
		//$this->check_action_permission('search');
		$model = $this->model_name;
		$config['base_url'] = site_url('templates/sorting');
		$config['total_rows'] = $this->$model->count_all();
		$data['result_array']=$this->$model->get_all($data['per_page']);
		$config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 10; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['controller_name']=strtolower(get_class());
		$data['form_width']=$this->get_form_width();
		$data['per_page'] = $config['per_page'];
		$data['manage_table']=get_template_manage_table($this->$model->get_all($data['per_page']),$this);	
		$this->load->view('templates/manage',$data);		
	}
public function sorting()
	{
		//$this->check_action_permission('search');
		$model = $this->model_name;
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		if ($search)
		{
			$config['total_rows'] = $this->$model->search_count_all($search);
			$table_data = $this->$model->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'last_name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		else
		{
			$config['total_rows'] = $this->$model->count_all();
			$table_data = $this->$model->get_all($per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		}
		$config['base_url'] = site_url('templates/sorting');
		$config['per_page'] = $per_page; 
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_template_manage_table_data_rows($table_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));	
		
	}
function search()
	{
		$this->check_action_permission('search');
		$model = $this->model_name;
		$search=$this->input->post('search');
		$per_page=$this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
		$search_data=$this->$model->search($search,$per_page,$this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'name' ,$this->input->post('order_dir') ? $this->input->post('order_dir'): 'asc');
		$config['base_url'] = site_url('templates/search');
		$config['total_rows'] = $this->$model->search_count_all($search);
		$config['per_page'] = $per_page ;
		$this->pagination->initialize($config);				
		$data['pagination'] = $this->pagination->create_links();
		$data['manage_table']=get_template_manage_table_data_rows($search_data,$this);
		echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
	}
	
public function view($var_id=-1)
	{
		$model = $this->model_name;
		$list_group_type = array('' => 'Chọn loại thiết bị');
        foreach ($this->$model->get_list_group_type()->result_array() as $list_type) {
            $list_group_type[$list_type['id']] = $list_type['name'];
        }
		$data['list_group_type'] = $list_group_type;
		$list_ppkh_type = array('' => 'Chọn phương pháp khấu hao');
        foreach ($this->$model->get_list_ppkh_type()->result_array() as $list_type) {
            $list_ppkh_type[$list_type['id']] = $list_type['name'];
        }
		$data['list_ppkh_type'] = $list_ppkh_type;
		$data['var_info']= $this->$model->get_info($var_id);
		$this->load->view("templates/form",$data);
	}	
public function save($var_id=-1)
	{
		$model = $this->model_name;
		$cat = $this->input->post('category');
		$primary = $this->input->post('primary');
		if($primary==1){
			$this->$model->set_null_primary($cat);
		}
		/* up load file */
		if ($_FILES["file_up"]["error"] > 0)
		{
			echo "Return Code: " . $_FILES["file_up"]["error"] . "<br />";
		}
	  else
		{
		if (file_exists("templates/" . $_FILES["file_up"]["name"]))
		  {
		  echo $_FILES["file_up"]["name"] . " da ton tai file tren server. ";
		  }
		else
		  {  
		  move_uploaded_file($_FILES["file_up"]["tmp_name"],
		  "templates/" . $_FILES["file_up"]["name"]);	
		  $link = "templates/" . $_FILES["file_up"]["name"];
		  } 
		}
		/*end up load file */
		$var_data=array(
		'name'=> $this->input->post('name'),
		'name_cus'=> $this->input->post('name_cus'),
		'add_cus'=> $this->input->post('add_cus'),
		'phone_cus'=> $this->input->post('phone_cus'),
		'code_tax'=> $this->input->post('code_tax'),
		'company_cus'=> $this->input->post('company_cus'),
		'row'=> $this->input->post('row'),
		'primary'=> $primary,
		'category'=> $cat,
		'link'=>$link
		);
		if( $this->$model->save($var_data,$var_id))
		{
		if($var_id==-1)
			{
				echo json_encode(array('success'=>true,'message'=>lang('common_successful_adding').' '.
				$var_data['name'],'id'=>$var_data['id']));
				$var_id = $var_data['id'];
			}
			else //previous giftcard
			{
				
				echo json_encode(array('success'=>true,'message'=>lang('common_successful_updating').' '.
				$var_data['name'],'id'=>$var_id));
			}
		}
		else//failure
		{
			echo json_encode(array('success'=>false,'message'=>lang('giftcards_error_adding_updating').' '.
			$customertype_data['name'],'id'=>-1));
		}
	}
	function get_row()
	{
		$model = $this->model_name;	
		$item_id = $this->input->post('row_id');
		$data_row=get_item_data_row($this->Item->get_info($item_id),$this);
		echo $data_row;
	}
	public function delete()
	{
		$model = $this->model_name;	
		$id=$this->input->post('ids');
		if($this->$model->delete_list($id))
		{
			echo json_encode(array('success'=>true,'message'=>lang('giftcards_successful_deleted')));
		}
		else
		{
		echo json_encode(array('success'=>false,'message'=>lang('giftcards_cannot_be_deleted')));
			echo 'that bai';
		}
	}
public function get_form_width()
	{			
		return 550;
	}
}

?>