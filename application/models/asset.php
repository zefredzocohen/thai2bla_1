<?php 
   class Asset extends CI_Model
   {
   	
   	public function __construct()
   	{
   	   parent::__construct();
   	}

   	public function count_all()
   	{
   		$query=$this->db->get('assets');
		return $query->num_rows();
   	}
	public function get_all_info(){
		$query=$this->db->get('assets');
		return $query->result_array();	
	}
	public function update_value_asset($id,$value_remain){
		$this->db->where('id',$id);
		$this->db->update('assets',array('value_remain'=>$value_remain));
	}
	public function get_all($limit=10000,$offset=0)
	{
		  $this->db->from('assets');
		  $this->db->limit($limit);
		  $this->db->offset($offset);
		  return  $this->db->get();		 
	}

	public function search_count_all($search, $limit=10000)
	{	
			$this->db->from('assets');		
			$this->db->where("name LIKE '%".$this->db->escape_like_str($search)."%'  ");		
			$this->db->order_by("name", "asc");
			$result=$this->db->get();				
			return $result->num_rows();
	}
	public function search($search, $limit=20,$offset=0,$column='name',$orderby='asc')
	{
			$this->db->from('assets');
			$this->db->where("name LIKE '%".$this->db->escape_like_str($search)."%'  ");	
			$this->db->order_by($column, $orderby);
			$this->db->limit($limit);
			$this->db->offset($offset);
			return $this->db->get();	
	}
	public function get_data()
	{
		$query=$this->db->get('assets');
		return $query->row_array();
	}
 	public  function get_list_group_type()
 	{
            $this->db->select(array('id', 'name'));
            $this->db->from('groups_asset');
            $this->db->distinct();
            $this->db->order_by("name", "asc");
            return $this->db->get();
     }
	public  function get_list_ppkh_type()
 	{
            $this->db->select(array('id', 'name'));
            $this->db->from('ppkh');
            $this->db->distinct();
            $this->db->order_by("name", "asc");
            return $this->db->get();
     }
    public function exists($custometype_id)
	{
		$this->db->from('assets');	
		$this->db->where('id',$custometype_id);
		$query = $this->db->get();	
		return ($query->num_rows()==1);
	}

	
	public function save(&$var_data,$var_id=false)
	{
		if (!$var_id or !$this->exists($var_id))
		{
			if($this->db->insert('assets',$var_data))
			{
				$var_data['id']=$this->db->insert_id();
				return true;
			}
			return false;
		}
		$this->db->where('id', $var_id);

		return $this->db->update('assets',$var_data);
	}

	public 	function get_info($customertype_id)
	{
		$this->db->from('assets');
		$this->db->where('id',$customertype_id);
		$query = $this->db->get();
		if($query->num_rows()==1)
		{
			return $query->row();
		}
		else
		{
			$customertype_obj=new stdClass();
			$fields = $this->db->list_fields('assets');
			foreach ($fields as $field)
			{
				$customertype_obj->$field='';
			}
			return $customertype_obj;
		}

	}
	public function delete_list($var_id)
	{
		$this->db->where_in('id',$var_id);
		return $this->db->delete('assets');
 	}
	function get_tkdu_search($search,$limit=25){
		$suggestions = array();

		$this->db->from('tkdu');
		$this->db->like('name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
		$this->db->order_by("name", "asc");
		$by_name = $this->db->get();
		foreach($by_name->result() as $row)
		{
			$suggestions[]=array('value' => $row->id,'name'=>$row->name,'label' => $row->id.' '.$row->name);
		}
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}
		return $suggestions;
	}
        
    //15-9-15 Hưng Audi
    function get_search_suggestions($search,$limit=25){
        $suggestions = array();		
        $this->db->from('assets');		
        $this->db->like("name",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("name", "asc");		
        $by_company_name = $this->db->get();
        foreach($by_company_name->result() as $row){
            $info_asset = $this->get_info($row->id);
            
            $so_thang_kh = 12*$info_asset->ky_khauhao;
            $date_kh = strtotime($info_asset->date_kh);
            $han_kh = date('Y-m-d', strtotime("+$so_thang_kh month", $date_kh));
            $date_now = date('Y-m-d');
            //date
            $ts1 = strtotime($info_asset->date_kh);
            $ts2 = strtotime($date_now);
            $day1 = date('d', $ts1);
            $day2 = date('d', $ts2);
            $subtract_day = $day2 - $day1;
            $month_now = date('m', $ts2);
            $month3 = $subtract_day > 0 ? $month_now : $month_now - 1;
            $date_now2 = strtotime(date('Y-m-d'));
            $your_date = strtotime(date("Y-$month3-$day1"));
            $datediff = floor(($date_now2 - $your_date)/(60*60*24));      
            
            //month
            $year1 = date('Y', $ts1);
            $year2 = date('Y', $ts2);
            $month1 = date('m', $ts1);
            $month2 = date('m', $ts2);
            $depreciat_month = $day2 > $day1 
                    ? (($year2 - $year1) * 12) + ($month2 - $month1) 
                    : (($year2 - $year1) * 12) + ($month2 - 1 - $month1);

            $suggestions[]=array(
                'value'             => $row->id, 
                'asset_number'      => $row->asset_number,
                'label'             => $row->name,
                'cost_money'        => $row->value_remain/$row->ky_khauhao/26,
                'quantity'          => $row->quantity,
                'depreciat_month'   => $row->ky_khauhao * 12,
                'price'             => $row->value,
                'tk_no'             => $row->tktk,
                'tk_co'             => $row->tktk,
                'han_kh'            => $han_kh,
                'date_now'          => date('Y-m-d'),
                'asset_money'       => $row->value_remain/365 * $datediff,
                'asset_money_remain'=> $row->value_remain - ( $row->value_remain/12 * $depreciat_month + $row->value_remain/365 * $datediff )
            );		
        }		
        if(count($suggestions > $limit)){
                $suggestions = array_slice($suggestions, 0,$limit);
        }
        return $suggestions;
    }
    //Hưng Audi 0000 Oct 31
    // hello Halloween (^_^) 
    function save_allocate($var_data, $var_id) {
        return $this->db->where('id', $var_id)
                        ->update('assets', $var_data);
    }
    function get_assets_halloween($halloween_time) {
        $halloween_time_H = "$halloween_time-31";
        $sql = $this->db->where("han_khauhao >=", $halloween_time)
                        ->where("date_kh <=", $halloween_time_H)
                        ->where("allocate", 0)
                        ->get("assets")
                        ->result();
        foreach($sql as $row){
            $suggestions[]=array(
                'id' => $row->id,
                'name' => $row->name,
                'money' => number_format($row->value / $row->ky_khauhao),
                'tkcp' => $row->tkcp,
                'tkkh' => $row->tkkh,
                'han_khauhao' => date('d-m-Y', strtotime($row->han_khauhao))
            );
        }
        if(count($suggestions > $limit)){
                $suggestions = array_slice($suggestions, 0,$limit);
        }
        return $suggestions;
    }
    
} 
?>