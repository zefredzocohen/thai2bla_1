<?php
class Em_culture extends Employee
{
    public function __construct(){
        parent::__construct();
        $this->_table_posions = $this->db->dbprefix('jobs_positions');
        $this->_table_employees = $this->db->dbprefix('employees');
        $this->_table_people = $this->db->dbprefix('people');

    }

    /* ByAuthor: @SnguyenOne
     * - Function: count_all()
     * - Description: Get total record of the table $_table_employees_jobs
     * - Param : param :$person_id is validator
     * - Return : number round this table
     *
     * */

    public function count_all()
    {
        $this->db->from($this->_table_posions);

        return $this->db->count_all_results();

    }
    /*
     * Lấy toàn bộ thông tin của các chi nhánh
     * */
    function get_all($limit = 10000, $offset = 0, $col='jobs_positions_name',$order = 'DESC')
    {
        $sql = "SELECT * FROM ".$this->_table_posions." ORDER BY ".$col." ".$order." LIMIT $offset,$limit ";
        $data = $this->db->query($sql);
        return $data;
    }
    /**
        Lấy thông tin cho thao tác sửa xóa dữ liệu
     */
    function get_info($id = -1)
    {
        $this->db->where('jobs_positions_id = '.$id);
        $data = $this->db->get($this->_table_posions);

        return $data->row();
    }
    /*
     *  Lấy thông tin cho vị trí
     * */
    function get_person()
    {
        $sql = "SELECT a.person_id,first_name,last_name
        FROM ".$this->_table_people.' AS a,'.$this->_table_employees." AS b WHERE a.person_id = b.person_id AND deleted = 0";
        $data = $this->db->query($sql);

        return $data->result();
    }
    function get_person_info()
    {
        $sql = "SELECT a.person_id,first_name,last_name
                FROM ".$this->_table_employees.' AS a ,'.$this->_table_people ." AS b
                WHERE a.person_id = b.person_id AND a.deleted = 0 GROUP BY a.person_id,first_name,last_name ";
        $query = $this->db->query($sql);

        return $query->result();
    }


    function save(&$item_data,$jobs_affiliates_id = -1)
    {
        if($jobs_affiliates_id == -1)
        {
            if($this->db->insert($this->_table_posions,$item_data))
            {
                return true;
            }
            return false;
        }

        $this->db->where('jobs_positions_id', $jobs_affiliates_id);
        return $this->db->update($this->_table_posions,$item_data);

    }
    /**
        Lấy tên nhân viên cho chưc danh
     */

    function get_name_info($id)
    {
        $sql = "SELECT first_name
                FROM ".$this->_table_employees.' AS a,'.$this->_table_people." AS b,".$this->_table_posions." AS c
                WHERE a.person_id = b.person_id AND b.person_id = c.person_id AND c.person_id = $id AND deleted = 0
                ";
        $data = $this->db->query($sql);

        return $data->row();

    }

    function delete_list($id = -1,$city_id = '')
    {
        if(empty($regions_id)){
            $this->db->trans_start();
            $this->db->where_in('jobs_positions_id',$id);

            if($this->db->delete($this->_table_posions)){
                $this->db->trans_complete();
                return true;
            }else{
                $this->db->trans_complete();
                return false;
            }
        }else{
            $this->db->trans_start();
            $this->db->where_in('jobs_city_id',$city_id);
            //$this->db->Jobs_affiliates->delete_list('',$city_id);
            if($this->db->delete($this->_table_posions)){
                $this->db->trans_complete();
                return true;
            }else{
                $this->db->trans_complete();
                return false;
            }
        }

    }

   /*
    Get search suggestions to find status
    */
    function get_search_suggestions($search,$limit=10000)
    {
        $this->db->from($this->_table_posions);
        $this->db->like("jobs_positions_name",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("jobs_positions_name", "DESC");
        $by_jobs_name = $this->db->get();
        foreach($by_jobs_name->result() as $row)
        {
            $suggestions[]=array('label'=> $row->jobs_positions_name);
        }

        //only return $limit suggestions
        if(count($suggestions )> $limit)
        {
            $suggestions = array_slice($suggestions, 0,$limit);
        }
        return $suggestions;

    }
    function search($search, $limit=50,$offset=0,$column='jobs_positions_name',$orderby='ASC')
    {
        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->from($this->_table_posions);
            $this->db->where("jobs_positions_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);

            return $this->db->get();
        }
        else
        {
            $this->db->from($this->_table_posions);
            $this->db->where("jobs_positions_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);

            return $this->db->get();
        }
    }

    function search_count_all($search, $limit=10000)
    {
        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->from($this->_table_posions);
            $this->db->where("jobs_positions_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by("jobs_positions_name", "DESC");

            $result=$this->db->get();
            return $result->num_rows();
        }
        else
        {
            $this->db->from($this->_table_posions);
            $this->db->where("jobs_positions_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by("jobs_positions_name", "DESC");

            $result=$this->db->get();
            return $result->num_rows();
        }
    }
    /*
     * Function get information for checkName đã được sử dụng hay chưa
     * Trong đó có 2 trường hợp là
     *  - Insert : Thì mỗi khi họ thay đổi thông tin trong input nếu như tên đã được sủ dụng
     *  - Update : Thì mỗi khi họ thay đổi thông tin trong input nếu như tên đã được sủ dụng biến
     *  $jobs_affiliates_id có ý nghia tương tự như việc chúng ta đang ở trạng thái nào
     * */
    function checkRegionsName($jobs_positions_name,$jobs_affiliates_id)
    {
        if(empty($jobs_affiliates_id) OR $jobs_affiliates_id == -1){
            $this->db->where("jobs_positions_name LIKE '".$this->db->escape_like_str($jobs_positions_name)."'");
        }else{
            $this->db->where("jobs_positions_name LIKE '".$this->db->escape_like_str($jobs_positions_name)."' AND jobs_positions_id != ".$jobs_affiliates_id);
        }

        $result = $this->db->get($this->_table_posions);
        return $result->num_rows();
    }

}

