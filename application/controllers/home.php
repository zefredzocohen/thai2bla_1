<?php

require_once ("secure_area.php");

class Home extends Secure_area {

    function __construct() {
        parent::__construct();
    }

    function index() {
        $this->send_mail_auto_birthday();
        $data = array();
        $data['suspended_sales'] = $this->Sale->get_all_suspended()->result_array();
        $data['payment_date'] = $this->Sale->get_all_suspended_web()->result_array();
        $data['customer'] = $this->Customer->findBirthDate();
        $data['register_date'] = $this->Customer->finddateregister();
        $data['suspends_date'] = $this->Inventory->find_suspends_date();
        $this->load->view("home");
    }

    function logout() {
        $this->Employee->logout();
    }

    function send_mail_auto_birthday() {
        if ($this->config->item('check_auto_birthday')) {
            $cus_info = $this->Customer->auto_birthday();
            foreach ($cus_info as $item) {
                $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.googlemail.com',
                    'smtp_port' => 465,
                    'smtp_user' => $this->config->item('email'),
                    'smtp_pass' => $this->config->item('pass_email'),
                    'charset' => 'utf-8',
                    'mailtype' => 'html'
                );
                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from($this->config->item('email'), $this->config->item('company'));
                $mail_info = $this->Customer->get_info_mail($this->config->item('mail_template_birthday'));
                $this->email->subject($mail_info->mail_title);
                $list_email_insert = array();
                $list_email_update = array();
                $list_id_update = array();
                $list_id_insert = array();
                $content = $mail_info->mail_content;
                //Thong tin khach hang duoc gui mail           
                $content = str_replace('__FIRST_NAME__', $item['first_name'], $content);
                $content = str_replace('__LAST_NAME__', $item['last_name'], $content);
                $content = str_replace('__PHONE_NUMBER__', $item['phone_number'], $content);
                $content = str_replace('__EMAIL__', $item['email'], $content);
                //Thong tin chu ky cong ty gui mail
                $content = str_replace('__NAME_COMPANY__', '<b>' . $this->config->item('company') . '</b>', $content);
                $content = str_replace('__ADDRESS_COMPANY__', $this->config->item('address'), $content);
                $content = str_replace('__EMAIL_COMPANY__', $this->config->item('email'), $content);
                $content = str_replace('__FAX_COMPANY__', $this->config->item('fax'), $content);
                $content = str_replace('__WEBSITE_COMPANY__', $this->config->item('website'), $content);
                $this->email->message($content);
                $this->email->to($item['email']);
                //Check xem khach hang nay da duoc gui mail chua
                //Truong hop qua trinh gui mail trc do bi loi thi insert vao database voi active = 0
                //Con gui thanh cong se insert vao database voi active = 1
                $result = $this->Customer->get_customer_mail_auto($item['person_id']);
                if ($result) {
                    if ($result['active'] == 0) {
                        if ($this->email->send()) {
                            $data = array(
                                'active' => 1,
                            );
                            $this->Customer->update_customer_mail_auto($item['person_id'], $data);
                            $data_history = array(
                                'person_id' => $item['person_id'],
                                'employee_id' => 1,
                                'title' => $mail_info->mail_title,
                                'content' => $content,
                                'time' => date('Y-m-d H:i:s'),
                                'note' => 'Gửi lại',
                                'status' => 1,
                            );
                            $this->Customer->add_mail_history($data_history);
                        }
                    }
                } else {
                    if ($this->email->send()) {
                        $data = array(
                            'people_id' => $item['person_id'],
                            'year' => date('Y'),
                            'active' => 1,
                        );
                        $this->Customer->insert_customer_mail_auto($data);
                        $data_history = array(
                            'person_id' => $item['person_id'],
                            'employee_id' => 1,
                            'title' => $mail_info->mail_title,
                            'content' => $content,
                            'time' => date('Y-m-d H:i:s'),
                            'status' => 1,
                        );
                        $this->Customer->add_mail_history($data_history);
                    } else {
                        $data = array(
                            'people_id' => $item['person_id'],
                            'year' => date('Y'),
                            'active' => 0,
                        );
                        $this->Customer->insert_customer_mail_auto($data);
                        $data_history = array(
                            'person_id' => $item['person_id'],
                            'employee_id' => 1,
                            'title' => $mail_info->mail_title,
                            'content' => $content,
                            'time' => date('Y-m-d H:i:s'),
                            'note' => 'Gửi lại',
                            'status' => 0,
                        );
                        $this->Customer->add_mail_history($data_history);
                        redirect("home");
                    }
                }
            }
        }
    }

    //change pass
    function form_change_pass($employee_id) {
        $data['user_info'] = $this->Employee->get_employee_info($employee_id);
        $this->load->view("employees/form_change_pass", $data);
    }

    function save_change_pass($employee_id) {
        $checkPass = $this->input->post('password');
        if (!empty($checkPass)) {
            $person_data['password'] = md5($this->input->post('password'));
        }
        if ($this->Employee->save_change_pass($person_data, $employee_id)) {
            echo json_encode(array('success' => true, 'message' => 'Đổi mật khẩu thành công !', 'person_id' => $employee_id));
        }
        redirect('home');
    }

    function checkpass_old($employee_id) {
        $user_info2 = $this->Employee->get_info_in_table_employee($employee_id);
        $pass_old = $this->input->post('password_old');
        if (md5($pass_old) == $user_info2->password) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    function checkpass_same($employee_id) {
        $user_info2 = $this->Employee->get_info_in_table_employee($employee_id);
        $pass_old = $this->input->post('password');
        if (md5($pass_old) == $user_info2->password) {
            echo json_encode(false);
        } else {
            echo json_encode(true);
        }
    }

}

?>