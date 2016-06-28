<?php
$time_out = time()-120;// 
					//Delete from session where time<$time_out
					 $current_ss = $this->session->userdata('session_id');  
					//$session_id = $this->session->userdata('session_id');
					// $current_ss = $this->CI->db->where('session_id', $this->CI->input->session_id());  
					$current_ip;
					$current_ss ;//Select from sessions where sid=session_id()
					if($current_ss!=$current_ip)
					{
					$this->form_validation->set_message('login_check', lang('login_invalid_sessions'));
					return false;
					}

?>