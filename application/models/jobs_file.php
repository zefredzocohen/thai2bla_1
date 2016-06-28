<?php
class Jobs_file extends Employee
{
    public function __construct(){
        parent::__construct();
        $this->_table_department = $this->db->dbprefix('jobs_department');
        $this->_table_employees = $this->db->dbprefix('employees');
        $this->_table_people = $this->db->dbprefix('people');
        $this->_table_file = $this->db->dbprefix('jobs_file');
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
        $data = $this->db->get($this->_table_file);

        return $data->num_rows();

    }

    /*
     * Lấy toàn bộ thông tin của các chi nhánh
     * */
    function get_all($limit = 10000, $offset = 0, $col='jobs_file_title',$order = 'DESC')
    {
        $sql = "SELECT * FROM ".$this->_table_file." ORDER BY ".$col." ".$order." LIMIT $offset,$limit ";

        $data = $this->db->query($sql);
        return $data;
    }

    function get_person_info()
    {
        $sql = "SELECT a.person_id,first_name,last_name
            FROM ".$this->_table_employees.' AS a ,'.$this->_table_people ." AS b
            WHERE a.person_id = b.person_id AND a.deleted = 0 GROUP BY a.person_id,first_name,last_name ";
        $query = $this->db->query($sql);

        return $query->result();
    }
    /*
     * Lấy thông tin tất cả các tài liệu chủa phòng ban do người này quản lý
     * */
    function getPerson($person_id)
    {
        $sql = 'SELECT person_id FROM '.$this->_table_employees." WHERE parent_id = ".$person_id;
        $data = $this->db->query($sql);

        return $data->result();
    }
    /*
     *  Hàm lấy toàn bộ file của nhân viên do người này quản lý
     * */

    function getAllFileManager($person_id,$limit = 10000, $offset = 0, $col='jobs_file_title',$order = 'DESC')
    {
        $item = $this->getPerson($person_id);
        $data = array();
        foreach($item AS $key => $values){
            $data[] = $values->person_id;
        }
        $data[] = $person_id;
        $id = implode($data,',');

        $sql = "SELECT * FROM ".$this->_table_file. " WHERE person_id IN ($id) ORDER BY ".$col." ".$order." LIMIT $offset,$limit ";
        $result = $this->db->query($sql);

        return $result;
    }
    /*
     * Lấy tên của  nhân viên upload file này lên
     * */
    function getNamePersonUploadFile($person_id)
    {
        $sql = "SELECT person_id,first_name FROM ".$this->_table_people ." WHERE person_id = ".$person_id;
        $data = $this->db->query($sql);

        return $data->row();
    }
    /*
     * Lấy tên phong mà nhân viên này thuộc
     * */
    function getNameDepartmentUploadFile($person_id)
    {
	    if(!empty($person_id)){
			    $sql = "SELECT a.department_id,department_name FROM ".$this->_table_employees." AS a,$this->_table_department AS b
                WHERE a.department_id = b.department_id AND deleted = 0 AND a.person_id = ".$person_id;
		}else{
			    $sql = "SELECT a.department_id,department_name FROM ".$this->_table_employees." AS a,$this->_table_department AS b
                WHERE a.department_id = b.department_id AND deleted = 0 ";
		}
        $data = $this->db->query($sql);

        return $data->row();
    }



    /** get all table status for update */
    function get_row($jobs_file_id)
    {
        $sql = "SELECT * FROM ".$this->_table_file. "
                WHERE jobs_file_id = ".$jobs_file_id;
        $query = $this->db->query($sql);

        return $query->row();
    }
function get_info_one_more_file($id = -1)
	{
	$table_contract = $this->db->dbprefix('jobs_file');
        $sql = "SELECT  jobs_file_name FROM ".$table_contract ." WHERE jobs_file_id = $id";
        $data = $this->db->query($sql);

        return $data->row();
    }
    function save(&$item_data,$jobs_file_id = -1)
    {
        if($jobs_file_id == -1)
        {
            if($this->db->insert($this->_table_file,$item_data))
            {
                return true;
            }
            return false;
        }

        $this->db->where('jobs_file_id', $jobs_file_id);
        return $this->db->update($this->_table_file,$item_data);

    }

    function delete_list($id = -1)
    {
        $this->db->trans_start();
        $this->db->where_in('jobs_file_id',$id);

        if($this->db->delete($this->_table_file)){
            $this->db->trans_complete();
            return true;
        }else{
            $this->db->trans_complete();
            return false;
        }

    }

   /*
    Get search suggestions to find status
    */
    function get_search_suggestions($search,$limit=10000)
    {
        $this->db->from($this->_table_file);
        $this->db->like("jobs_file_title",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("jobs_file_title", "DESC");
        $by_jobs_name = $this->db->get();
        foreach($by_jobs_name->result() as $row)
        {
            $suggestions[]=array('label'=> $row->jobs_file_title);
        }

        //only return $limit suggestions
        if(count($suggestions )> $limit)
        {
            $suggestions = array_slice($suggestions, 0,$limit);
        }
        return $suggestions;

    }
    function search($search, $limit=50,$offset=0,$column='jobs_file_title',$orderby='ASC')
    {
        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->from($this->_table_file);
            $this->db->where("jobs_file_title LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);

            return $this->db->get();
        }
        else
        {
            $this->db->from($this->_table_file);
            $this->db->where("jobs_file_title LIKE '%".$this->db->escape_like_str($search)."%'");
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
            $this->db->from($this->_table_file);
            $this->db->where("jobs_file_title LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by("jobs_file_title", "DESC");

            $result=$this->db->get();
            return $result->num_rows();
        }
        else
        {
            $this->db->from($this->_table_file);
            $this->db->where("jobs_file_title LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by("jobs_file_title", "DESC");

            $result=$this->db->get();
            return $result->num_rows();
        }
    }
    /*
     * Function get information for checkName đã được sử dụng hay chưa
     * Trong đó có 2 trường hợp là
     *  - Insert : Thì mỗi khi họ thay đổi thông tin trong input nếu như tên đã được sủ dụng
     *  - Update : Thì mỗi khi họ thay đổi thông tin trong input nếu như tên đã được sủ dụng biến
     *  $jobs_file_id có ý nghia tương tự như việc chúng ta đang ở trạng thái nào
     * */
    function checkRegionsName($jobs_file_title,$jobs_file_id)
    {
        if(empty($jobs_file_id) OR $jobs_file_id == -1){
            $this->db->where("jobs_file_title LIKE '".$this->db->escape_like_str($jobs_file_title)."'");
        }else{
            $this->db->where("jobs_file_title LIKE '".$this->db->escape_like_str($jobs_file_title)."' AND jobs_file_id != ".$jobs_file_id);
        }

        $result = $this->db->get($this->_table_file);
        return $result->num_rows();
    }

}

