<?php
class Cost extends CI_Model
{
function exists($item_id,$name_id)
	{
		$this->db->from('chiphiuocluong');
		$this->db->where('item_id',$item_id);
		$this->db->where('name_id',$name_id);
		$query = $this->db->get();

		return true;
	}
    function save(&$cost_data,$id_cost){
        if (!$this->exists_idcost($id_cost)){
            $query = $this->db->insert('costs',$cost_data);
            if($query){
                return true;
            }else return false ;
        }else{
            $this->db->where('id_cost', $id_cost);
            $query = $this->db->update('costs',$cost_data);
            if($query){
                    return true;
            }else return false ;
        }
    }
	function exists_idcost($id_cost)
	{
		$this->db->from('costs');
		$this->db->where('id_cost',$id_cost);
		$query = $this->db->get();

		return ($query->num_rows()==1);
	}
	function count_all()
	{
		$this->db->from('costs');
		$this->db->where('deleted',0);
		return $this->db->count_all_results();
	}
	
	function get_all($limit = 10000, $offset = 0, $col = 'id_cost', $order = 'desc') {
        $this->db->from('costs');
        $this->db->where('deleted', 0);
        $this->db->order_by($col, $order);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

	function get_info($id_cost){
		$this->db->from('costs');
		$this->db->where('id_cost',$id_cost);
		
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
			$fields = $this->db->list_fields('costs');

			foreach ($fields as $field)
			{
				$item_obj->$field='';
			}

			return $item_obj;
		}
	} 
function search($search, $limit = 20, $offset = 0, $column = 'id_cost', $orderby = 'desc') {

        $this->db->from('costs');
        if ($search != null) {
            $this->db->where("( month(date) = '" . $search . "') ");
            $this->db->where('deleted', 0);
        } else {
            $this->db->where('deleted', 0);
        }
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);

        return $this->db->get();
    }

    function search_count_all($search) {

        $this->db->from('costs');
        if ($search != null) {
            $this->db->where("( month(date) = '" . $search . "') ");
            $this->db->where('deleted', 0);
        } else {
            $this->db->where('deleted', 0);
        }


        $result = $this->db->get();
        return $result->num_rows();
    }
// xo chu khi nhap gtri search
	function get_search_suggestions($search,$limit=25)
	{
		$suggestions = array();
		$this->db->from('costs');
		$this->db->join('people','costs.cost_customer=people.person_id');	
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
		$this->db->order_by("last_name", "asc");		
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=array('label' => $row->first_name.' '.$row->last_name);		
		}
		
		$this->db->from('costs');
		$this->db->join('people','costs.cost_employees=people.person_id');	
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
		$this->db->order_by("last_name", "asc");		
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=array('label' => $row->first_name.' '.$row->last_name);		
		}
		
		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;

	}
	
	function delete_list($cost_to_delete){
		$this->db->where_in('id_cost',$cost_to_delete);
		return $this->db->update('costs', array('deleted' => 1));
	}
	function find_export($start_date, $end_date) {
        $this->db->where('date >= ', $start_date);
        $this->db->where('date <= ', $end_date);
        $this->db->where('deleted', 0);
        $result = $this->db->get('costs');
        //var_dump($this->db->last_query());exit();
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }
	function find_export_tkdu($start_date,$end_date,$tk_du){
		$this->db->where('date >= ',$start_date);
		$this->db->where('date <= ',$end_date);
		$this->db->where('deleted', 0);
		$this->db->where('tk_du', $tk_du);
		$result=$this->db->get('costs');				
		if($result->num_rows()>0){
			return $result->result_array();
			}
		else return null;
	}
	function find_export_dongtiens($start_date,$end_date,$dongtiens01){
		$this->db->where('date >= ',$start_date);
		$this->db->where('date <= ',$end_date);
		$this->db->where('deleted', 0);
		$this->db->where_in('tk_du', $dongtiens01);
		$result=$this->db->get('costs');				
		if($result->num_rows()>0){
			return $result->result_array();
			}
		else return null;
	}
	function find_export_excel($start_date,$end_date){
		$this->db->from('costs');
		$this->db->where('date >= ',$start_date);
		$this->db->where('date <= ',$end_date);
		$this->db->where('deleted', 0);			
		return $this->db->get();
	}
	function find_export_excel_tkdu($start_date,$end_date,$tkdu){
		$this->db->from('costs');
		$this->db->where('date >= ',$start_date);
		$this->db->where('date <= ',$end_date);
		$this->db->where('deleted', 0);			
		$this->db->where('tk_du',$tkdu);		
		return $this->db->get();
	}
	function get_info_option(){
		$this->db->select('cost_id,cost_name');
      	$query = $this->db->get('cost_select');
		if($query->num_rows()>0){
      	return $query->result_array();
		} else {
			return null ;
		}
	}
	function get_info_name($id_cost){
		$this->db->where('cost_id',$id_cost);
		
		$query = $this->db->get('cost_select');

		if($query->num_rows()>0)
		{
			return $query->row();
		}
	}
	function find_sale_id($sale_id){
		$this->db->where('id_sale',$sale_id);		
		$query = $this->db->get('costs');
		if($query->num_rows()>0)
		{
			return true;
		} else return false ;
	}
	function delete_sale_id($sale_id){	
		$this->db->delete('costs', array('id_sale' => $sale_id)); 
	}
	function delete_receiving_id($receiving_id){	
		$this->db->delete('costs', array('id_receiving' => $receiving_id)); 
	}
	function save_customer_cost($cost_data){
            if($this->db->insert('costs',$cost_data)){
                return true;
            }else{
                return false;
            }
	}
	function cleanup()
	{
		return $this->db->delete('costs',array('deleted' => 1));
	}
	function get_string_number($amount)
	{
		 if($amount <=0)
        {
            return $textnumber="Tiền phải là số nguyên dương lớn hơn số 0";
        }
        $Text=array("không", "một", "hai", "ba", "bốn", "năm", "sáu", "bảy", "tám", "chín");
        $TextLuythua =array("","nghìn", "triệu", "tỷ", "ngàn tỷ", "triệu tỷ", "tỷ tỷ");
        $textnumber = "";
        $length = strlen($amount);
       
        for ($i = 0; $i < $length; $i++)
        $unread[$i] = 0;
       
        for ($i = 0; $i < $length; $i++)
        {              
            $so = substr($amount, $length - $i -1 , 1);               
           
            if ( ($so == 0) && ($i % 3 == 0) && ($unread[$i] == 0)){
                for ($j = $i+1 ; $j < $length ; $j ++)
                {
                    $so1 = substr($amount,$length - $j -1, 1);
                    if ($so1 != 0)
                        break;
                }                      
                      
                if (intval(($j - $i )/3) > 0){
                    for ($k = $i ; $k <intval(($j-$i)/3)*3 + $i; $k++)
                        $unread[$k] =1;
                }
            }
        }
       
        for ($i = 0; $i < $length; $i++)
        {       
            $so = substr($amount,$length - $i -1, 1);      
            if ($unread[$i] ==1)
            continue;
           
            if ( ($i% 3 == 0) && ($i > 0))
            $textnumber = $TextLuythua[$i/3] ." ". $textnumber;    
           
            if ($i % 3 == 2 )
            $textnumber = 'trăm ' . $textnumber;
           
            if ($i % 3 == 1)
            $textnumber = 'mươi ' . $textnumber;
           
           
            $textnumber = $Text[$so] ." ". $textnumber;
        }
       
        //Phai de cac ham replace theo dung thu tu nhu the nay
        $textnumber = str_replace("không mươi", "lẻ", $textnumber);
        $textnumber = str_replace("lẻ không", "", $textnumber);
        $textnumber = str_replace("mươi không", "mươi", $textnumber);
        $textnumber = str_replace("một mươi", "mười", $textnumber);
        $textnumber = str_replace("mươi năm", "mươi lăm", $textnumber);
        $textnumber = str_replace("mươi một", "mươi mốt", $textnumber);
        $textnumber = str_replace("mười năm", "mười lăm", $textnumber);
        return ucfirst($textnumber."đồng chẵn");
}
	function get_tongtien_tra($id_sale){
            $this->db->where('sale_id',$id_sale);		
            $query = $this->db->get('sales_payments');
            if($query->num_rows()>0)
            {
                return $query->result_array();
            } else return false ;
	}
 	public function get_name_cost_select($id) {
        $this->db->where('cost_id', $id);
        $query = $this->db->get('cost_select');
        $data['result'] = $query->row_array();
        return $data['result']['cost_name'];
    }
    
    //bc thu
     public function get_date_thu_new($start_date,$end_date)
     {
			
        //$query = $this->db->query('SELECT costs. * , cost_select. *  FROM costs LEFT JOIN cost_select ON cost_select.cost_id = costs.name WHERE tien_thu AND costs.date >= "'.$start_date.'" AND costs.date <= "'.$end_date.'" AND deleted =0');  
        $this->db->select('costs.* , cost_select.*');
        $this->db->from('costs');
        $this->db->join('cost_select','cost_select.cost_id = costs.name','left');
        $this->db->where('tien_thu > ',0);
        $this->db->where('deleted',0);
        $this->db->where('costs.date >= ',$start_date);
        $this->db->where('costs.date <= ',$end_date );
        $query = $this->db->get();
        //var_dump($this->db->last_query());exit();  
        if ($query->num_rows()>0) {
            return $query->result_array();
        } else {
            return null;
        }
     }
    //bc chi
 	public function get_date_chi_new($start_date,$end_date)
     {

           //$query = $this->db->query('SELECT `phppos_costs`. * , `phppos_cost_select`. *  FROM ( `phppos_costs`)LEFT JOIN `phppos_cost_select` ON `phppos_cost_select`.`cost_id` = `phppos_costs`.`name`WHERE `tien_chi`AND `phppos_costs`.`date` >= "'.$start_date.'" AND `phppos_costs`.`date` <= "'.$end_date.'" AND `deleted` =0');  
        
           $this->db->select('costs.*, cost_select.*');
           $this->db->from('costs');;
           $this->db->join('cost_select','cost_select.cost_id = costs.name','left');
           $this->db->where('tien_chi >',0);
           $this->db->where('deleted',0);
           $this->db->where('costs.date >= ',$start_date);
	       $this->db->where('costs.date <= ',$end_date );
	       $query = $this->db->get();
          //var_dump($this->db->last_query());exit();
           if ($query->num_rows()>0) {
             return $query->result_array();
           } else {
              return null;
           }
     }
     //Created by Loi
     function find_export_by_employee($start_date, $end_date, $employee_id) {
        $this->db->where('date >= ', $start_date);
        $this->db->where('date <= ', $end_date);
        $this->db->where('deleted', 0);
        $this->db->where('cost_employees',$employee_id);
        $this->db->order_by('date','desc');
        $result = $this->db->get('costs');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
     }
     function find_export_by_employee_chi($start_date, $end_date, $employee_id) {
        $this->db->where('date >= ', $start_date);
        $this->db->where('date <= ', $end_date);
        $this->db->where('deleted', 0);
        $this->db->where('cost_employees',$employee_id);
        $result = $this->db->get('costs');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
     }
     function find_export_by_employee_thu($start_date, $end_date, $employee_id) {
        $this->db->where('date >= ', $start_date);
        $this->db->where('date <= ', $end_date);
        $this->db->where('deleted', 0);
        $this->db->where('cost_employees',$employee_id);
        $result = $this->db->get('costs');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
     }
     function find_export_excel_by_employee($start_date,$end_date,$employeed_id){
		$this->db->from('costs');
		$this->db->where('date >= ',$start_date);
		$this->db->where('date <= ',$end_date);
		$this->db->where('deleted', 0);	
                $this->db->where('cost_employees',$employeed_id);
                $this->db->order_by('date','desc');
		return $this->db->get();
     }
     function find_export_excel_by_employee_thu($start_date,$end_date,$employeed_id){
		$this->db->from('costs');
		$this->db->where('date >= ',$start_date);
		$this->db->where('date <= ',$end_date);
		$this->db->where('deleted', 0);	
                $this->db->where('cost_employees',$employeed_id);
		return $this->db->get();
     }
     function find_export_excel_by_employee_chi($start_date,$end_date,$employeed_id){
		$this->db->from('costs');
		$this->db->where('date >= ',$start_date);
		$this->db->where('date <= ',$end_date);
		$this->db->where('deleted', 0);	
                $this->db->where('cost_employees',$employeed_id);
		return $this->db->get();
     }
     function get_max_id(){
         $this->db->select_max('id_cost');
         $query=$this->db->get('costs');
         return $query->row_array();
         }
    function get_cong_no_ncc($supplier_id){
        $this->db->from('receivings');
        $this->db->where('supplier_id',$supplier_id);
        $this->db->where('suspended',1);
        $this->db->order_by('receiving_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    
   
    
    function get_payment_by_recv_id($receiving_id){
        $this->db->from('receivings_tam');
        $this->db->where('id_receiving',$receiving_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_receiving_item_by_id($receiving_id){
        $this->db->from('receivings_items');
        $this->db->where('receiving_id',$receiving_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_cong_no_khach_hang($customer_id){
        $this->db->from('sales');
        $this->db->where('customer_id',$customer_id);
        $this->db->where('suspended',1);
        $this->db->order_by('sale_time','desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_payment_by_sale_id($receiving_id){
        $this->db->from('sales_tam');
        $this->db->where('id_sale',$receiving_id);
        $query = $this->db->get();
        return $query->result_array();
    }
     function get_sale_item_by_id($sale_id){
        $this->db->from('sales_items');
        $this->db->where('sale_id',$sale_id);
        $query = $this->db->get();
        return $query->result_array();
    }
    function get_account_money($start_date, $end_date,$acc_id,$acc_child) {
        $this->db->where('tk_no', $acc_id);
        $this->db->where('date >=', $start_date);
        $this->db->where('date <=', $end_date);
        $this->db->where('deleted', 0);
        $this->db->or_where('tk_co',$acc_id);
        $this->db->where('date >=', $start_date);
        $this->db->where('date <=', $end_date);
        $this->db->where('deleted', 0);        
        foreach ($acc_child as $acc_ch){
            $this->db->or_where('tk_no',$acc_ch['id']);
            $this->db->where('date >=', $start_date);
            $this->db->where('date <=', $end_date);
            $this->db->where('deleted', 0);
            $this->db->or_where('tk_co',$acc_ch['id']);
            $this->db->where('date >=', $start_date);
            $this->db->where('date <=', $end_date);
            $this->db->where('deleted', 0);
        }        
        $result = $this->db->get('costs');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }
    
    function get_account_money_all($start_date, $end_date,$acc_id,$acc_child,$supplier) {
        $this->db->where('tk_no', $acc_id);
        $this->db->where('date >=', $start_date);
        $this->db->where('date <=', $end_date);
        $this->db->where('deleted', 0);
        $this->db->or_where('tk_co',$acc_id);
        $this->db->where('date >=', $start_date);
        $this->db->where('date <=', $end_date);
        $this->db->where('deleted', 0);
        $this->db->group_by('supplier_id');
        foreach ($acc_child as $acc_ch){
            $this->db->or_where('tk_no',$acc_ch['id']);
            $this->db->where('date >=', $start_date);
            $this->db->where('date <=', $end_date);
            $this->db->where('deleted', 0);
            $this->db->or_where('tk_co',$acc_ch['id']);
            $this->db->where('date >=', $start_date);
            $this->db->where('date <=', $end_date);
            $this->db->where('deleted', 0);
        }
        $this->db->where('supplier_id',$supplier);
        $result = $this->db->get('costs');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }
    
    function get_cost_all_supplier() {
        //$this->db->where('supplier_id !=',0);
        $this->db->where('deleted', 0);   
        $result = $this->db->get('costs');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }
    
    function get_no_111($id_cost,$acc_id,$acc_arr){ 
        $this->db->where('tk_no', $acc_id);
        $this->db->where('id_cost <=',$id_cost);
        $this->db->where('deleted', 0);        
        foreach ($acc_arr as $acc_arr1){
            $this->db->or_where('tk_no', $acc_arr1['id']);
            $this->db->where('id_cost <=',$id_cost);
            $this->db->where('deleted', 0);
        }
        $result = $this->db->get('costs');
         if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }    
    function get_co_111($id_cost,$acc_id,$acc_arr){
        $this->db->where('tk_co', $acc_id);
        $this->db->where('id_cost <=',$id_cost);
        $this->db->where('deleted', 0);        
        foreach ($acc_arr as $acc_arr1){
            $this->db->or_where('tk_co', $acc_arr1['id']);
            $this->db->where('id_cost <=',$id_cost);
            $this->db->where('deleted', 0);
        }
        $result = $this->db->get('costs');
         if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }
    function get_no_dau_ky_acc($start_date,$acc_id,$acc_arr){
        $this->db->where('tk_no', $acc_id);
        $this->db->where('date <',$start_date);
        $this->db->where('deleted', 0);        
        foreach ($acc_arr as $acc_arr1){
            $this->db->or_where('tk_no', $acc_arr1['id']);
            $this->db->where('date <',$start_date);
            $this->db->where('deleted', 0);
        }
        $result = $this->db->get('costs');
         if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }
    function get_co_dau_ky_acc($start_date,$acc_id,$acc_arr){
        $this->db->where('tk_co', $acc_id);
        $this->db->where('date <',$start_date);
        $this->db->where('deleted', 0);        
        foreach ($acc_arr as $acc_arr1){
            $this->db->or_where('tk_co', $acc_arr1['id']);
            $this->db->where('date <',$start_date);
            $this->db->where('deleted', 0);
        }
        $result = $this->db->get('costs');
         if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }
    function get_customer_id($start_date,$end_date){
        $this->db->select('id_customer');
        $this->db->where('date >=',$start_date);
        $this->db->where('date <=',$end_date);
        $this->db->group_by('id_customer');
        $result = $this->db->get('costs');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null; 
    }
    function get_supplier_id($start_date,$end_date){
        $this->db->select('supplier_id');
        $this->db->where('date >=',$start_date);
        $this->db->where('date <=',$end_date);
        $this->db->group_by('supplier_id');
        $result = $this->db->get('costs');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null; 
    }
    function get_account_data($start_date, $end_date,$acc_id,$thu_chi){
        $this->db->where('date >=',$start_date);
        $this->db->where('date <=',$end_date);
        $this->db->where('deleted', 0);
        if($thu_chi == 0 ){
            $this->db->where('tk_no', 111);
            $this->db->or_where('tk_no', 112);
            $this->db->where('date >=',$start_date);
            $this->db->where('date <=',$end_date);
            foreach ($acc_id as $id){
                $this->db->or_where('tk_no',$id['id']);
                $this->db->where('date >=',$start_date);
                $this->db->where('date <=',$end_date);
            } 
        }elseif($thu_chi==1){
            $this->db->where('tk_co', 111);
            $this->db->or_where('tk_co', 112);
            $this->db->where('date >=',$start_date);
            $this->db->where('date <=',$end_date);
            foreach ($acc_id as $id){
                $this->db->or_where('tk_co',$id['id']);
                $this->db->where('date >=',$start_date);
                $this->db->where('date <=',$end_date);
            }
        }        
        $result = $this->db->get('costs');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }
    function get_child_acc(){
        $this->db->where('id_parent',111);
        $this->db->or_where('id_parent',112);
        $result = $this->db->get('tkdu');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;        
    }
    function get_data_by_acc_id($start_date,$end_date,$acc_id){
        $this->db->where('date >=',$start_date);
        $this->db->where('date <=',$end_date);
        $this->db->where('deleted', 0);
        $this->db->where('tk_no',$acc_id);
        $this->db->or_where('tk_co',$acc_id);
        $result = $this->db->get('costs');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }
    function get_child_acc_by_id($acc_id){
        $this->db->where('id_parent',$acc_id);
        $result = $this->db->get('tkdu');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;        
    }
     //End Loi
	 //tong hop thu chi dungbv
      function export_cost($start_date, $end_date) {
        $this->db->where('date >= ', $start_date);
        $this->db->where('date <= ', $end_date);
        $this->db->where('deleted', 0);
        $this->db->order_by('date','desc');
        $result = $this->db->get('costs');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
     }
     function export_cost_chi($start_date, $end_date ) {
        $this->db->where('date >= ', $start_date);
        $this->db->where('date <= ', $end_date);
        $this->db->where('deleted', 0);
        $this->db->where('money >',0);
        $this->db->where('form_cost',1);
        $this->db->order_by('date','desc');
        $result = $this->db->get('costs');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
     }
     function export_cost_thu($start_date, $end_date) {
        $this->db->where('date >= ', $start_date);
        $this->db->where('date <= ', $end_date);
        $this->db->where('deleted', 0);
        $this->db->where('money >',0);
        $this->db->where('form_cost',0);
        $this->db->order_by('date','desc');
        $result = $this->db->get('costs');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
     }
     
      function cost_export_excel($start_date,$end_date){
		$this->db->from('costs');
		$this->db->where('date >= ',$start_date);
		$this->db->where('date <= ',$end_date);
		$this->db->where('deleted', 0);	
                $this->db->order_by('date','desc');
		return $this->db->get();
     }
     function cost_export_excel_thu($start_date,$end_date){
		$this->db->from('costs');
		$this->db->where('date >= ',$start_date);
		$this->db->where('date <= ',$end_date);
		$this->db->where('deleted', 0);	
                $this->db->where('form_cost',0);
                $this->db->order_by('date','desc');
		return $this->db->get();
     }
     function cost_export_excel_chi($start_date,$end_date){
		$this->db->from('costs');
		$this->db->where('date >= ',$start_date);
		$this->db->where('date <= ',$end_date);
		$this->db->where('deleted', 0);	
                $this->db->where('form_cost', 1);
                $this->db->order_by('date','desc');
		return $this->db->get();
     }
     //end dungnv
     
    //Hưng Audi Sep 17
    function get_info_max($asset_id){
        return $this->db->select_max('date')
                        ->where('asset_id', $asset_id)
                        ->get('costs')->row();
    }  
    //Hưng Audi Sep 23
    function get_info_by_export_store_id($export_store_id){
        return $this->db->where('export_store_id', $export_store_id)
                        ->get('costs')->row();
    }
    
    //Oct 12 Hưng Audi
    function insert_cost_detail($data) {
        $this->db->insert('cost_detail', $data);
    }   
    function get_cost_detail($id_cost) {
        return $this->db->where('id_cost', $id_cost)
                        ->get('cost_detail')->result_array();
    }
    function get_cost_detail2($id_cost) {
        return $this->db->where('id_cost', $id_cost)
                        ->join('sales', 'sales.sale_id = cost_detail.sale_id')
                        ->get('cost_detail')->result_array();
    }    
    function get_info_cost_detail_recv($id_cost, $receiving_id) {
        return $this->db->where('id_cost', $id_cost)
                        ->where('receiving_id', $receiving_id)
                        ->get('cost_detail')->row();
    }
    function get_info_cost_detail_sale($id_cost, $sale_id) {
        return $this->db->where('id_cost', $id_cost)
                        ->where('sale_id', $sale_id)
                        ->get('cost_detail')->row();
    }
    function update_receivings_tam($data, $id_cost) {
        $this->db->where('id_cost', $id_cost)
                ->update('receivings_tam', $data);
    }
    function update_sales_tam($data, $id_cost) {
        $this->db->where('id_cost', $id_cost)
                ->update('sales_tam', $data);
    }
    
    function save_sale_payment($data){
        $this->db->insert('sales_payments',$data);
    }


    //hoa don dich vu by No Name
    //10-11-15 10h11'15s
    function count_all_order_service(){
		$this->db->from('order_service');
		$this->db->where('delete',0);
                $this->db->where('stt',0);
		return $this->db->count_all_results();
	}
        
        function count_all_order_service_bh(){
		$this->db->from('order_service');
		$this->db->where('delete',0);
                $this->db->where('stt',1);
		return $this->db->count_all_results();
	}
        
	function get_all_order_service($limit = 10000, $offset = 0, $col = 'id', $order = 'desc') {
            $this->db->where('stt',0);
        return $this->db->where('delete', 0)
                        ->order_by($col, $order)
                        ->limit($limit)
                        ->offset($offset)
                        ->get('order_service');
    }
    
    function get_all_order_service_bh($limit = 10000, $offset = 0, $col = 'id', $order = 'desc') {
            $this->db->where('stt',1);
        return $this->db->where('delete', 0)
                        ->order_by($col, $order)
                        ->limit($limit)
                        ->offset($offset)
                        ->get('order_service');
    }
    
    function delete_list_order_service($bAbY){
		$this->db->where_in('id', $bAbY);
		return $this->db->update('order_service', array('delete' => 1));
	}
        
        function delete_list_order_service_bh($bAbY){
		$this->db->where_in('id', $bAbY);
		return $this->db->update('order_service', array('delete' => 1));
	}
    function get_info_order_service($bAbY_id){
                    $this->db->where('stt',0);
		return $this->db->where('id',$bAbY_id)
                        ->where('delete',0)
                        ->get('order_service')
                        ->row();
	} 
        
         function get_info_order_service_bh($bAbY_id){
                    $this->db->where('stt',1);
		    $this->db->where('id',$bAbY_id);
                    $this->db->where('delete',0);
                    return $this->db->get('order_service')->row();
                        
	} 
    
        /* --;{(@  --;{(@  --;{(@  --;{(@  --;{(@  --;{(@  --;{(@  --;{(@
         * HAPPY WOMEN'S DAY VIETNAM 20/10/15  
         * from Hưng Audi 
         */
    //order_service
    function save_order_service(&$bAbY_data,$bAbY_id=false){
		if (!$bAbY_id or !$this->exists_order_service($bAbY_id)){
			if($this->db->insert('order_service',$bAbY_data)){
				$bAbY_data['id']=$this->db->insert_id();
				return true;
			}
			return false;
		}
		return $this->db->where('id', $bAbY_id)
                        ->where('delete', 0)
                        ->update('order_service',$bAbY_data);
	}   
    function exists_order_service($bAbY_id){
		return $this->db->where('id',$bAbY_id)
                        ->where('delete', 0)
                        ->get('order_service')
                        ->num_rows()==1;
	}
    
    //chungtu_detail
    function save_chungtu_detail_order_service($data, $chungtu_id) {
        $this->delete_chungtu_detail_order_service($chungtu_id);
        foreach ($data as $r) {
            $this->db->insert('chungtu_detail', $r);
        }
        return true;
    }
    
    function save_chungtu_detail_order_service_bh($data, $chungtu_id) {
        $this->delete_chungtu_detail_order_service($chungtu_id);
        foreach ($data as $r) {
            $this->db->insert('chungtu_detail', $r);
        }
        return true;
    }
    
    function delete_chungtu_detail_order_service($chungtu_id) {
        return $this->db->where('mark', 1)
                        ->delete('chungtu_detail', array('chungtu_id' => $chungtu_id));
    }
    function get_chungtu_detail_order_service($chungtu_id) {
        return $this->db->where('chungtu_id', $chungtu_id)
                        ->where('mark', 1)
                        ->get('chungtu_detail');
    }
    
    //say gOObye Hưng Audi
    function save_recv_cost_tkdu($data) {
        $this->db->insert('recv_cost_tkdu', $data);
    }
    
    function save_sale_cost_tkdu($data) {
        $this->db->insert('sale_cost_tkdu', $data);
    }
    function get_recv_cost_tkdu($supplier_id, $start_date, $end_date) {
        return $this->db->where('supplier_id', $supplier_id)
                        ->where('date >=', $start_date)
                        ->where('date <=', $end_date)
                        ->get('recv_cost_tkdu')->result();
    }
    
     function get_sale_cost_tkdu($customer_id, $start_date, $end_date) {
        return $this->db->where('customer_id', $customer_id)
                        ->where('date >=', $start_date)
                        ->where('date <=', $end_date)
                        ->where('stt',0)
                        ->get('sale_cost_tkdu')->result();
    }
    
    function get_all_supplier() {
        return $this->db->get('suppliers')->result_array();
    }
}
?>