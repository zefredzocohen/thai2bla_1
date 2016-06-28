<?php
require_once ("secure_area.php");
class setting extends Secure_area
{
    function __construct()
    {
            parent::__construct('setting');
    }

    function index()
    {	
        $data['controller_name']=strtolower(get_class());
        $data['payment_options']= array(
            lang('sales_cash') => lang('sales_cash'),
            lang('sales_check') => lang('sales_check'),
            lang('sales_giftcard') => lang('sales_giftcard'),
            lang('sales_debit') => lang('sales_debit'),
            lang('sales_credit') => lang('sales_credit')
        );
        foreach($this->Appconfig->get_additional_payment_types() as $additional_payment_type){
            $data['payment_options'][$additional_payment_type] = $additional_payment_type;
        }
        $data['list_mail_template'] = $this->Customer->get_all_mail_template();
        $list_mail_template = array();
        foreach($data['list_mail_template'] as $item){
            $list_mail_template[$item['mail_id']] = $item['mail_title'];
        }
        $data['list_mail_template'] = $list_mail_template;
        $this->load->view("config", $data);
    }

    function save()
    {       
        if(!empty($_FILES["company_logo"]) && $_FILES["company_logo"]["error"] == UPLOAD_ERR_OK && ($_SERVER['HTTP_HOST'] !='demo.phppointofsale.com' && $_SERVER['HTTP_HOST'] !='demo.phppointofsalestaging.com'))
        {
            $allowed_extensions = array('png', 'jpg', 'jpeg', 'gif','bmp');
            $extension = strtolower(end(explode('.', $_FILES["company_logo"]["name"])));
            if (in_array($extension, $allowed_extensions)){
                $config['image_library'] = 'gd2';
                $config['source_image']	= $_FILES["company_logo"]["tmp_name"];
                $config['create_thumb'] = FALSE;
                $config['maintain_ratio'] = TRUE;
                $config['width']	 = 170;
                $config['height']	= 60;
                $this->load->library('image_lib', $config); 
                $this->image_lib->resize();
                $company_logo = $this->Appfile->save($_FILES["company_logo"]["name"], file_get_contents($_FILES["company_logo"]["tmp_name"]), $this->config->item('company_logo'));
            }
        }elseif($this->input->post('delete_logo')){
            $this->Appfile->delete($this->config->item('company_logo'));
        }
        $this->load->helper('directory');
        $valid_languages = directory_map(APPPATH.'language/', 1);
        if (isset($company_logo))
        {	
            $config = array(
                'upload_path' => './images/logoreport',
                'allowed_types' => 'gif|jpg|png|bmp|jpeg',
            );
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('company_logo')) 
        {
            $error = array(
                'errors' => $this->upload->display_errors(),
            );
        } else {
            $file_data_report_logo = $this->upload->data();
        }
        $batch_save_data = array(
            'report_logo'=>$file_data_report_logo['file_name'],
            'company'=>$this->input->post('company'),
            'address'=>$this->input->post('address'),
            'phone'=>$this->input->post('phone'),
            'email'=>$this->input->post('email'),
            'gasoline'=>$this->input->post('gasoline'),
            'meals'=>$this->input->post('meals'),
            'config_phone_support'=>$this->input->post('phone_support'),
            'stock_alert_email'=>$this->input->post('stock_alert_email'),
            'fax'=>$this->input->post('fax'),
            'website'=>$this->input->post('website'),
            'default_tax_1_rate'=>$this->input->post('default_tax_1_rate'),
            'default_tax_1_name'=>$this->input->post('default_tax_1_name'),
            'default_tax_2_rate'=>$this->input->post('default_tax_2_rate'),
            'default_tax_2_name'=>$this->input->post('default_tax_2_name'),
            'default_tax_2_cumulative' => $this->input->post('default_tax_2_cumulative') ? 1 : 0,
            'currency_symbol'=>$this->input->post('currency_symbol'),
            'currency_symbol_possition'=>$this->input->post('currency_symbol_possition'),
            'return_policy'=>$this->input->post('return_policy'),
            'language'=>in_array($this->input->post('language'), $valid_languages) ? $this->input->post('language') : 'english',
            'timezone'=>$this->input->post('timezone'),
            'date_format'=>$this->input->post('date_format'),
            'time_format'=>$this->input->post('time_format'),
            'print_excel' => $this->input->post('print_excel'),					///////////////////
            'print_after_sale'=>$this->input->post('print_after_sale') ? 1 : 0,
            'hide_signature'=>$this->input->post('hide_signature') ? 1 : 0,
            'delivery'=>$this->input->post('delivery') ? 1 : 0,
            'cong_no'=>$this->input->post('cong_no') ? 1 : 0,
            'disable_confirmation_sale'=>$this->input->post('disable_confirmation_sale') ? 1 : 0,
            'track_cash' => $this->input->post('track_cash') ? 1 : 0,
            'mailchimp_api_key'=>$this->input->post('mailchimp_api_key'),
            'amazon_secret_key'=>$this->input->post('amazon_secret_key'),
            'amazon_access_key'=>$this->input->post('amazon_access_key'),
            'number_of_items_per_page'=>$this->input->post('number_of_items_per_page'),
            'additional_payment_types' => $this->input->post('additional_payment_types'),
            'hide_suspended_sales_in_reports' => $this->input->post('hide_suspended_sales_in_reports') ? 1 : 0,
            'speed_up_search_queries' => $this->input->post('speed_up_search_queries') ? 1 : 0,
            'receive_stock_alert' => $this->input->post('receive_stock_alert') ? 1 : 0,
            'enable_credit_card_processing'=>$this->input->post('enable_credit_card_processing') ? 1 : 0,
            'merchant_id'=>$this->input->post('merchant_id'),
            'merchant_password'=>$this->input->post('merchant_password'),
            'default_payment_type'=> $this->input->post('default_payment_type'),
            //Create by San
            'mail_template_birthday' => $this->input->post('mail_template_birthday'),
            'mail_template_contact' => $this->input->post('mail_template_contact'),
            'mail_template_calendar' => $this->input->post('mail_template_calendar'),
            'email_cc'=>$this->input->post('email_cc'),
            'expired_contract' => $this->input->post('expired_contract'),
            'pass_email'    => $this->input->post('pass_email'),
            'title_contract'    => $this->input->post('title_contract'),
            'brandname' => $this->input->post('brandname'),
            'user_sms' => $this->input->post('user_sms'),
            'pass_sms' => $this->input->post('pass_sms'),
        	'corp_master_account' => $this->input->post('corp_master_account'),
        	'corp_number_account' => $this->input->post('corp_number_account'),
        	'corp_bank_name' => $this->input->post('corp_bank_name'),
        	'corp_bank_affiliate' => $this->input->post('corp_bank_affiliate'),
        	'private_master_account' => $this->input->post('private_master_account'),
        	'private_number_account' => $this->input->post('private_number_account'),
        	'private_bank_name' => $this->input->post('private_bank_name'),
        	'private_bank_affiliate' => $this->input->post('private_bank_affiliate'),
            );             
        }else {
            $batch_save_data = array(
                'company'=>$this->input->post('company'),
                'address'=>$this->input->post('address'),
                'phone'=>$this->input->post('phone'),
                'email'=>$this->input->post('email'),
                'gasoline'=>$this->input->post('gasoline'),
                'meals'=>$this->input->post('meals'),
                'config_phone_support'=>$this->input->post('phone_support'),
                'stock_alert_email'=>$this->input->post('stock_alert_email'),
                'fax'=>$this->input->post('fax'),
                'website'=>$this->input->post('website'),
                'default_tax_1_rate'=>$this->input->post('default_tax_1_rate'),
                'default_tax_1_name'=>$this->input->post('default_tax_1_name'),
                'default_tax_2_rate'=>$this->input->post('default_tax_2_rate'),
                'default_tax_2_name'=>$this->input->post('default_tax_2_name'),
                'default_tax_2_cumulative' => $this->input->post('default_tax_2_cumulative') ? 1 : 0,
                'currency_symbol'=>$this->input->post('currency_symbol'),
                'currency_symbol_possition'=>$this->input->post('currency_symbol_possition'),
                'return_policy'=>$this->input->post('return_policy'),
                'language'=>in_array($this->input->post('language'), $valid_languages) ? $this->input->post('language') : 'english',
                'timezone'=>$this->input->post('timezone'),
                'date_format'=>$this->input->post('date_format'),
                'time_format'=>$this->input->post('time_format'),
                'print_excel'=>$this->input->post('print_excel'),
                'print_after_sale'=>$this->input->post('print_after_sale') ? 1 : 0,
                'hide_signature'=>$this->input->post('hide_signature') ? 1 : 0,
                'delivery'=>$this->input->post('delivery') ? 1 : 0,
                'cong_no'=>$this->input->post('cong_no') ? 1 : 0,
                'disable_confirmation_sale'=>$this->input->post('disable_confirmation_sale') ? 1 : 0,
                'track_cash' => $this->input->post('track_cash') ? 1 : 0,
                'mailchimp_api_key'=>$this->input->post('mailchimp_api_key'),
                'amazon_secret_key'=>$this->input->post('amazon_secret_key'),
                'amazon_access_key'=>$this->input->post('amazon_access_key'),
                'number_of_items_per_page'=>$this->input->post('number_of_items_per_page'),
                'additional_payment_types' => $this->input->post('additional_payment_types'),
                'hide_suspended_sales_in_reports' => $this->input->post('hide_suspended_sales_in_reports') ? 1 : 0,
                'speed_up_search_queries' => $this->input->post('speed_up_search_queries') ? 1 : 0,
                'receive_stock_alert' => $this->input->post('receive_stock_alert') ? 1 : 0,
                'enable_credit_card_processing'=>$this->input->post('enable_credit_card_processing') ? 1 : 0,
                'merchant_id'=>$this->input->post('merchant_id'),
                'merchant_password'=>$this->input->post('merchant_password'),
                'default_payment_type'=> $this->input->post('default_payment_type'),
                //Create by San
                'email_cc'=>$this->input->post('email_cc'),
                'mail_template_birthday' => $this->input->post('mail_template_birthday'),
                'mail_template_contact' => $this->input->post('mail_template_contact'),
                'mail_template_calendar' => $this->input->post('mail_template_calendar'),
                'expired_contract' => $this->input->post('expired_contract'),
                'pass_email'    => $this->input->post('pass_email'),
                'title_contract'    => $this->input->post('title_contract'),
                'brandname' => $this->input->post('brandname'),
                'user_sms' => $this->input->post('user_sms'),
                'pass_sms' => $this->input->post('pass_sms'),
            	'corp_master_account' => $this->input->post('corp_master_account'),
	        	'corp_number_account' => $this->input->post('corp_number_account'),
	        	'corp_bank_name' => $this->input->post('corp_bank_name'),
	        	'corp_bank_affiliate' => $this->input->post('corp_bank_affiliate'),
	        	'private_master_account' => $this->input->post('private_master_account'),
	        	'private_number_account' => $this->input->post('private_number_account'),
	        	'private_bank_name' => $this->input->post('private_bank_name'),
	        	'private_bank_affiliate' => $this->input->post('private_bank_affiliate'),
            );
        }
        if (isset($company_logo))
        {
            $batch_save_data['company_logo'] = $company_logo;
        }
        elseif($this->input->post('delete_logo'))
        {
            $batch_save_data['company_logo'] = 0;
        }
        if($this->input->post('check_auto_birthday')){
            $batch_save_data['check_auto_birthday'] = 1;
        }else{
            $batch_save_data['check_auto_birthday'] = 0;
        }
        if($this->input->post('check_auto_contact')){
            $batch_save_data['check_auto_contact'] = 1;
        }else{
            $batch_save_data['check_auto_contact'] = 0;
        }
        if($this->input->post('check_auto_calendar')){
            $batch_save_data['check_auto_calendar'] = 1;
        }else{
            $batch_save_data['check_auto_calendar'] = 0;
        }        
        if(($_SERVER['HTTP_HOST'] !='demo.phppointofsale.com' && $_SERVER['HTTP_HOST'] !='demo.phppointofsalestaging.com') && $this->Appconfig->batch_save($batch_save_data))
        {
            echo json_encode(array('success'=>true,'message'=>lang('config_saved_successfully')));
        }
        else
        {
            echo json_encode(array('success'=>false,'message'=>lang('config_saved_unsuccessfully')));
        }
    }

    function backup()
    {
        $this->load->dbutil();
        $prefs = array(
            'format'      => 'txt',             // gzip, zip, txt
            'add_drop'    => FALSE,              // Whether to add DROP TABLE statements to backup file
            'add_insert'  => TRUE,              // Whether to add INSERT data to backup file
            'newline'     => "\n"               // Newline character used in backup file
        );
        $backup =&$this->dbutil->backup($prefs);
        $backup = 'SET FOREIGN_KEY_CHECKS = 0;'."\n".$backup."\n".'SET FOREIGN_KEY_CHECKS = 1;';
        force_download('lifetek_point_of_sale.sql', $backup);
    }

    function optimize()
    {
        $this->load->dbutil();
        $this->dbutil->optimize_database();
        echo json_encode(array('success'=>true,'message'=>lang('config_database_optimize_successfully')));
    }   
}
?>