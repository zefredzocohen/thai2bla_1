<?php
class My_person extends CI_Model{
    function __construct(){
        $this->_table_employees = $this->db->dbprefix('employees');
        $this->_table_people = $this->db->dbprefix('people');
        $this->_table_status = $this->db->dbprefix('jobs_status');
        $this->_table_permissions = $this->db->dbprefix('permissions');
        $this->_table_permissions_action = $this->db->dbprefix('permissions_actions');
        $this->_table_regions = $this->db->dbprefix('regions');
    }
    /*
       BEGIBN PHẦN LÀM PHÂN QUYỀN
    */
    /*
     * Hàm lấy thông tin người đăng nhập để phân quyền phần thêm mới sửa xóa thông tin
     * */
    public function checkUpdate($field,$person_id,$controller)
    {
        $sql = "SELECT action_id FROM ".$this->_table_permissions_action." WHERE person_id = $person_id AND module_id = '$controller' AND action_id = '$field'";
        $data = $this->db->query($sql);

        return $data->num_rows();
    }

    /*
     * Hàm thực hiên quyền thêm mới người quản lý cho nhân viên
     * -> Khi chúng ta thực hiện viêc thêm mới khu vực,thành phố,chi nhánh,phòng ban nhân viên
     * */
    public function updateEmployees($parent_id='',$person_id)
    {
        $sql = "UPDATE $this->_table_employees SET parent_id = ".$parent_id.' WHERE person_id IN ('.$person_id.')';
        $data = $this->db->query($sql);

        return $data;
    }
    /*
   * Hàm thực hiên lấy toàn bộ Mã nhân viên cho người quản lý trong trương hợp đó là nhân viên thì
     * function sẽ trả ra chính thông tin nhân viên đó
   * */
    public function getChildrenId($person_id,$items = '')
    {
//        if(!$items) $items = array();
//        $sql = "SELECT person_id,parent_id,username FROM  $this->_table_employees WHERE parent_id = ".$person_id;
//        $data = mysql_query($sql);
//        while($values = mysql_fetch_assoc($data)){
//            $items[] = $values['person_id'];
//            unset($values[$person_id]);
//            $items = $this->getChildrenId($values['person_id'],$items);
//        }
//        if(empty($items) || !isset($items)){
//            $items[] = $person_id;
//        }else{
//            $items[] = $person_id;
//        }
//
//        return $items;
        
        $this->db->select('person_id');
        $this->db->from('employees');
        $query = $this->db->get();
        foreach($query->result_array() as $val){
        	$items[] = $val['person_id'];
        }//die($items[4]);
//        while($value = mysql_fetch_array($query)){
//        	$items[] = $value['person_id'];
//        }
//        var_dump($query->result_array());exit();
//        var_dump($items);exit();
        return $items;
    }
    /*
    * Hàm thực hiên lấy toàn bộ thông tin nhân viên cho user khi user đó đang nhập
     * - Nếu là quản lý thì cho xem thông tin toàn bộ nhân viên mà người này quản lý
     * - Nếu là nhân viên thì chỉ cho xem thông tin của chính nhân viên và thông tin khi đã được phân quyền
    * */
    public function getPersonId($person_id)
    {
        $result = $this->getChildrenId($person_id);
        $data = implode($result,',');
		//die($data);
        return $data;
    }
    /*
      Hàm thực hiện get inforamtion last of the table
      - Lấy person_id thực hiên việc quản lý chi nhánh cần thiết
    */

    function getLastRow($table,$name_field)
    {
        $sql = "SELECT * FROM ".$table." ORDER BY $name_field DESC LIMIT 1 ";
        $data = $this->db->query($sql);

        return $data->row();
    }
    /*
     * Hàm lấy thông tin check xem đây có phải là nhân viên quản lý cấp trên hay không
     * */
    function getTable($table,$name,$conditions = '',$person_id,$status = 0)
    {
        $this->_table = $this->db->dbprefix($table);
        $sql = "SELECT * FROM ".$this->_table." WHERE $name = $conditions AND person_id = $person_id";
        $data = $this->db->query($sql);
        if($status == 1)
            return $data->row();
        else
            return $data->num_rows();
    }
    /*
     * Hàm thực hiện lấy thông tin nhà quản lý cấp cớ sở của chức năng hiện tại đang thi hành
     * */
    function getOneInformationPerson($table,$field = 'jobs_regions_id',$name,$conditions = '')
    {
        $this->_table = $this->db->dbprefix($table);
        $sql = "SELECT $field FROM ".$this->_table." WHERE $name = $conditions ";
        $data = $this->db->query($sql);

        return $data->row();
    }

    /*
     * Hàm thực hiện lấy thông tin person_id theo @param truyền vào
     * */
    function getInformationPerson($table,$name,$conditions = '',$status = 0)
    {
        $this->_table = $this->db->dbprefix($table);
        $this->db->where_in($name,$conditions);
        $data = $this->db->get($this->_table);
        if($data->num_rows() == 1){
            return $data->row();
        }else{
            if($status == 1){
                $items = $data->result();
                $array = array();
                foreach($items AS $values){
                    $array[] = $values->person_id;
                }
                $result = implode($array,',');

                return $result;
            }else{
                return $data->result();
            }
        }
    }
    /*
   * Hàm thực kiểm tra xem với id định xóa nếu nhân viên quản lý còn có quyền quản lý
     *  thì ta sẽ không thực hiện xoa quyền nhân viên đó trong bảng phân quyền và không update lại thông tin người quản lý trong bảng employees
   * */
    function getCountInformation($table,$field,$id,$field_conditions='',$conditions = '')
    {
        $this->_table = $this->db->dbprefix($table);
        if(empty($field_conditions) || empty($conditions)){
            $sql = "SELECT person_id,$field_conditions,$id FROM ". $this->_table." WHERE $field != $id ";
            $data = $this->db->query($sql);
            return $data->result();
        }else{
            $sql = "SELECT person_id FROM ". $this->_table." WHERE $field != $id AND $field_conditions = $conditions";
            $data = $this->db->query($sql);
            return $data->num_rows();
        }
    }

    /*
     * Function action update table permissions for employees_manager
     * */
    function checkInsertPermission($name_module,$person_id)
    {
        $this->_table_permissions =  $this->db->dbprefix('permissions');
        $sql = "SELECT person_id FROM ".$this->_table_permissions." WHERE person_id = ".$person_id. " AND module_id = '$name_module'";
        $data = $this->db->query($sql);

        return $data->num_rows();
    }
    function insertPermission($name_module,$person_id)
    {
        $num = $this->checkInsertPermission($name_module,$person_id);
        if(empty($num)){
            if(is_array($person_id)){
                foreach($person_id AS $value){
                    $data = array(
                        'module_id'=>$name_module,
                        'person_id'=>$value
                    );
                }
                $this->db->insert($this->_table_permissions,$data);
            }else{
                $data = array(
                    'module_id'=>$name_module,
                    'person_id'=>$person_id
                );
                $this->db->insert($this->_table_permissions,$data);
            }
        }
    }
    /*
       * Function action update table permissions_actions for employees_manager
       * */
    function checkInsertPermissionAction($name_module,$person_id)
    {
        $sql = "SELECT person_id 
        	FROM ".$this->_table_permissions_action." 
        	WHERE person_id = ".$person_id. " 
        		AND module_id = '$name_module'";
        $data = $this->db->query($sql);

        return $data->num_rows();
    }
    /*
     * Hàm thực hiện xóa bỏ thông tin phân quyền nhân viên khii thực hiên update
     * trong các khu vực,chi nhánh,thành phố,phòng ban
     * */
    function deletePermission($name_module,$person_id)
    {
        $this->db->where_in('module_id',$name_module);
        $this->db->where_in('person_id',$person_id);

        $this->db->delete($this->_table_permissions);
    }
    /*
    * Hàm gọi thông tin cần xóa trong các hàm xủ lý xóa thông tin phân quyền cho nhân viên
    *
    * */
    function callDeletePermission($name_module,$person_id)
    {
        $this->deletePermissionAction($name_module,$person_id);
        $this->deletePermission($name_module,$person_id);
    }
	
    /*
     * Hàm thực hiện xóa quyền nhân viên quản lý khi nhân viên đó bị đình chỉ công tác
     * */
    function deletePermissionAction($name_module,$person_id)
    {//del all
        $this->db->where_in('module_id',$name_module);
        $this->db->where_in('person_id',$person_id);
        $this->db->delete($this->_table_permissions_action);
    }
    /*
     * Hàm thực hiện gọi phần thêm mới phân quyền nhân viên
     * */
    public function callInsertPermission($name_module,$person_id,$status = 0)
    {
        if($status == 0){
            $this->insertPermission($name_module,$person_id);
            $this->insertPermissionAction($name_module,$person_id);
        }else{
            $this->insertPermission($name_module,$person_id);
            $this->insertAllPermissionAction($name_module,$person_id);
        }

    }
    /*
      * Hàm thực hiện thêm mới thông tin quyền nhân viên khi thực hiên thêm mới
      * update các thông tin quản lý trong quản lý khu vực
      * */
    function insertAllPermissionAction($name_module,$person_id)
    {
        $num = $this->checkInsertPermissionAction($name_module,$person_id);
        $data = array('add_update','delete','search');
        if(empty($num) || $num == 1){

            if(is_array($person_id)){
                foreach($person_id AS $value){
                    for($i = 0; $i<=2; $i++){
                        $array = array(
                            'module_id'=>$name_module,
                            'person_id'=>$value,
                            'action_id'=>$data[$i]
                        );
                        $this->db->insert($this->_table_permissions_action,$array);
                    }
                }
            }else{
                for($i = 0; $i<=2; $i++){
                    $array = array(
                        'module_id'=>$name_module,
                        'person_id'=>$person_id,
                        'action_id'=>$data[$i]
                    );
                    $this->db->insert($this->_table_permissions_action,$array);
                }
            }
        }
    }

    function insertPermissionAction($name_module,$person_id)
    {
        $num = $this->checkInsertPermissionAction($name_module,$person_id);
        if(empty($num)){
            //$data = array('add_update','delete','search');
            if(is_array($person_id)){
                foreach($person_id AS $value){
                        $array = array(
                            'module_id'=>$name_module,
                            'person_id'=>$value,
                            'action_id'=>'search'
                        );
                        $this->db->insert($this->_table_permissions_action,$array);
                }
            }else{
                for($i = 0; $i<=2; $i++){
                    $array = array(
                        'module_id'=>$name_module,
                        'person_id'=>$person_id,
                        'action_id'=>'search'
                    );
                    $this->db->insert($this->_table_permissions_action,$array);
                }
            }
        }
    }

	//hung audi 30-03-15
	function callDeletePermission2($name_module,$person_id)
    {
    		$this->deletePermissionAction2($name_module,$person_id);
    		$this->deletePermissionAction3($name_module,$person_id);
    		
    }
	function deletePermissionAction2($name_module,$person_id)
    {
        $this->db->where_in('module_id',$name_module);
        $this->db->where_in('person_id',$person_id);
        $this->db->where_in('action_id','search');
        $this->db->delete($this->_table_permissions_action);
    }
	function deletePermissionAction3($name_module,$person_id)
    {
        $this->db->where_in('module_id',$name_module);
        $this->db->where_in('person_id',$person_id);
        $this->db->where_in('action_id','delete');
        $this->db->delete($this->_table_permissions_action);
    }
    
    
    /*
        END PHẦN LÀM PHÂN QUYỀN
     */
    /*Determines whether the given person exists*/
}