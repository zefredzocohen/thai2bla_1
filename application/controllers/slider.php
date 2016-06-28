<?php
require_once ("secure_area.php");
require_once ("interfaces/idata_controller.php");
class Slider extends Secure_area
{
    function __construct()
    {
        parent::__construct('slider');
        $this->load->library('sale_lib');
        $this->load->library('receiving_lib');
        //$this->load->model('Category');
    }
    function index()
    {
        //$config['base_url'] = site_url('categories/sorting');
        $config['total_rows'] = $this->Sliders->count_all();
        $config['per_page'] = $this->config->item('number_of_items_per_page') ? (int)$this->config->item('number_of_items_per_page') : 20;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $data['controller_name']=strtolower(get_class());

        $data['form_width']=$this->get_form_width();

        //$data['total_rows'] = $this->Slide->count_all();
        $data['per_page'] = $config['per_page'];
        $data['manage_table']=get_slides_manage_table($this->Sliders->get_all($data['per_page']),$this);

        $data['manage_table_slider_cooker']=get_slide_manage_table($this->Sliders->get_by_id($data['per_page']),$this);
        $this->load->view('slider/manage',$data);
    }

    function view($id_cat = -1) {
        $this->check_action_permission('add_update');
        $data = array();
        $data['item_info'] = $this->Sliders->get_info($id_cat);
        $this->load->view("slider/form", $data);
    }

    function save($id=-1)
    {
        $this->check_action_permission('add_update');
        $chuoi = $this->input->post('name_item');
        $str = $this->Sliders->vn_str_filter("$chuoi");
        $str = str_replace(" ", "-", $str); // replate khoang trang = dau -
        $str = strtolower($str); // bo viet hoa
        // if ($this->input->post("submit")) {
            $item_data = array(
                'name'        => $this->input->post("name"),
                'img'         => $this->input->post('img'),
                'description' => $this->input->post('description'),
                'active'      => $this->input->post('active'),
                'url'         => $str,
            );

            if (!file_exists('upload/slider'))
                mkdir('upload/slider', 777);

            /* Upload image */
            $config['upload_path'] = './upload/slider/tmp';
            $config['allowed_types'] = 'gif|jpg|png';
            if ($_FILES['img']['size'] == 0 ){
                $img = $this->get_image(get_slide_manage_table($this->Sliders->get_by_id($data['per_page']),$this));
                if(file_exists($img))$item_data['img']=$img;
            }
            else{
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('img')) {
                    $data_img = $this->upload->data();
                    // chưa tồn tại 
                    if (!file_exists('upload/slider/tmp'))mkdir('upload/slider/tmp', 777);
                    copy ('upload/slider/tmp/'.$data_img['file_name'],'upload/slider/'.$data_img['file_name']);
                    unlink('upload/slider/tmp/'.$data_img['file_name']);
                    $item_data['img'] = 'upload/slider/'.$data_img['file_name'];
                }
            }
            

            if($this->Sliders->save($item_data,$id))
            {
                //New item
                if($id==-1)
                {
                    echo json_encode(array('success'=>true,'message'=>lang('items_successful_adding').' '.
                    $item_data['name'],'id'=>$item_data['id']));
                    $id = $item_data['id'];
                }

                else //previous item
                {
                    echo json_encode(array('success'=>true,'message'=>lang('items_successful_updating').' '.
                    $item_data['name'],'id'=>$id));
                }

            }
            else//failure
            {
                echo json_encode(array('success'=>false,'message'=>lang('items_error_adding_updating').' '.
                $item_data['name'],'id'=>-1));
            }
        // }

    }

    function get_form_width()
    {
        return 550;
    }

    function search() {
        $this->check_action_permission('search');
        $search = $this->input->post('search');
        $cat_service = $this->input->post('cat');
        //$per_page= 50;
        $per_page = $this->config->item('number_of_items_per_page') ? (int) $this->config->item('number_of_items_per_page') : 20;

        $search_data = $this->Sliders->search($search, $cat_service, $per_page, $this->input->post('offset') ? $this->input->post('offset') : 0, $this->input->post('order_col') ? $this->input->post('order_col') : 'id_cat', $this->input->post('order_dir') ? $this->input->post('order_dir') : 'desc');
        $config['base_url'] = site_url('categories/search');
        $config['total_rows'] = $this->Sliders->search_count_all($search, $cat_service);
        $config['per_page'] = $per_page;
        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['manage_table'] = get_news_category_manage_table_data_rows($search_data, $this);

        echo json_encode(array('manage_table' => $data['manage_table'], 'pagination' => $data['pagination']));
    }

    function delete() {
        $this->check_action_permission('delete');
        $categories_to_delete = $this->input->post('ids');
        $this->Sliders->delete_list($categories_to_delete);
        echo json_encode(array('success' => true, 'message' => 'Bạn đã xóa thành công slider ' . $msg));
    }
    function get_image($table){
        if(preg_match("/<img(.+?)src=(.+?)(jpg|png|gif|bmp)/i", $table,$_img)){
//            return $table;
            $_img =  preg_replace("/['|\"]/", "",$_img[2].$_img[3]);
            $_url  = preg_replace("/\//","\\/",  base_url());
            $_img = preg_replace("/". $_url   ."/", "", $_img);
            return $_img;
        }
        else{
            return 'no ';
        }
    }
}
 ?>
