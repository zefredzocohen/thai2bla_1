<?php
class Jobs_department extends Employee
{
    public function __construct(){
        parent::__construct();
        $this->_table_department = $this->db->dbprefix('jobs_department');
        $this->_table_affiliatest = $this->db->dbprefix('jobs_affiliates');
        $this->_table_city = $this->db->dbprefix('jobs_city');
        $this->_table_employees = $this->db->dbprefix('employees');
        $this->_table_people = $this->db->dbprefix('people');
        $this->_table_regions = $this->db->dbprefix('jobs_regions');
    }

    /* ByAuthor: @SnguyenOne
     * - Function: count_all()
     * - Description: Get total record of the table $_table_employees_jobs
     * - Param : param :$person_id is validator
     * - Return : number round this table
     *
     * */

    
    function get_regions_info()
    {
        $this->db->select('jobs_regions_id,jobs_regions_name');
        //$this->db->where('jobs_regions_id','1');
        $query = $this->db->get($this->_table_regions);

        return $query->result();
    }
    /*
     * Lấy toàn bộ thông tin của các chi nhánh
     * */
	function get_all2($person_id,$limit = 10000, $offset = 0, $col='department_name',$order = 'DESC')
    {//die('ss');
    	if( $person_id == 1){
			$data = parent::getPersonId($person_id);
	        $sql = "SELECT d.*,p.first_name 
	        FROM ".$this->_table_department." d INNER JOIN ".$this->_table_people. " p 
	        ON d.person_id=p.person_id 
	        ORDER BY ".$col." ".$order." LIMIT $offset,$limit ";
		}else{
	        $data = parent::getPersonId($person_id);
	        $sql = "SELECT d.*,p.first_name 
	        FROM ".$this->_table_department." d 
	        INNER JOIN ".$this->_table_people. " p ON d.person_id=p.person_id 
	        
	        
	        ORDER BY ".$col." ".$order." LIMIT $offset,$limit ";
		}
	    $data = $this->db->query($sql);
        return $data;
    }
    
    
    
    
    
    
    /*
   * Hàm lấy toàn bộ thông tin chi thành phố chi và khu vực mà chi nhánh đang trực thuộc
   * */
    function getCityAffiliates($id)
    {
        $sql = "SELECT b.jobs_city_id,b.jobs_city_name,c.jobs_regions_id,c.jobs_regions_name,a.jobs_affiliates_id,a.jobs_affiliates_name
                FROM $this->_table_department AS e,".$this->_table_affiliatest." AS a,$this->_table_city AS b, $this->_table_regions AS c
                WHERE e.department_id = $id AND a.jobs_affiliates_id = e.jobs_affiliates_id AND a.jobs_city_id = b.jobs_city_id AND b.jobs_regions_id = c.jobs_regions_id";
        $data = $this->db->query($sql);

        return $data->row();
    }
    function getRegionPerson()
    {
        $sql = "SELECT person_id FROM ".$this->_table_regions;
        $data = $this->db->query($sql);
        $items = array();
        foreach($data->result() AS $values){
            $items[] = $values->person_id;
        }
        $result = implode($items,',');

        return $result;
    }
    function getRegionCity()
    {
        $sql = "SELECT person_id FROM ".$this->_table_city;
        $data = $this->db->query($sql);
        $items = array();
        foreach($data->result() AS $values){
            $items[] = $values->person_id;
        }
        $result = implode($items,',');

        return $result;
    }
    function get_person_info()
    {
        $itemsRegions = $this->getRegionPerson();
        $itemsCity = $this->getRegionCity();
            $sql = "SELECT a.person_id,first_name,last_name
            FROM ".$this->_table_employees.' AS a ,'.$this->_table_people ." AS b
            WHERE a.person_id = b.person_id AND a.person_id != 1 AND a.deleted = 0 GROUP BY a.person_id,first_name,last_name ";

        $query = $this->db->query($sql);

        return $query->result();
    }
    /*
     * Lấy thông tin các phòng ban mà bạn chọn
     * */
    function get_department_name($id = -1)
    {
        if(empty($id) or $id == -1){
            $sql = "SELECT department_name,department_id FROM ".$this->_table_department;
        }else{
            $sql = "SELECT department_name,department_id FROM ".$this->_table_department ." WHERE jobs_affiliates_id = ". $id;
        }

        $data = $this->db->query($sql);

        return $data->result();
    }

    function get_city_info($id)
    {
        $sql = "SELECT a.jobs_city_id,jobs_city_name
                FROM ".$this->_table_city." AS a,".$this->_table_affiliatest." AS b,".$this->_table_department ." AS c
                WHERE a.jobs_city_id = b.jobs_city_id AND
               b.jobs_affiliates_id = c.jobs_affiliates_id AND c.jobs_affiliates_id  = $id";

       $query = $this->db->query($sql);

        return $query->row();
    }
    /**
        Get information for của chi nhánh mà văn phòng thuộc
     */
    function get_affiliates()
    {
       $this->db->select('jobs_affiliates_id,jobs_affiliates_name');
       //$this->db->where('jobs_affiliates_status','1');
       $query = $this->db->get($this->_table_affiliatest);

        return $query->result();
    }
    /*
     * Lấy thông tin thành phố mà chi nhánh thuộc
     * Nếu ta truyền tham biến thì Miền select lựa chon được các thông tin của thành phố thuộc miền đó
     * */
    function get_city_action($regions_id = '')
    {
        $this->db->select('jobs_city_id,jobs_city_name');
        if(!empty($regions_id)){
            $this->db->where('jobs_regions_id',$regions_id);
            $query = $this->db->get($this->_table_city);
        }else{
            $query = $this->db->get($this->_table_city);
        }
        return $query->result();
    }
    /**
        Lấy toàn bộ thông tin chi nhánh trong hệ thống
     */
    function get_affiliates_name($city_id = '')
    {
        $this->db->select('jobs_affiliates_id,jobs_affiliates_name');
        if(!empty($city_id)){
            $this->db->where('jobs_city_id',$city_id);
            $query = $this->db->get($this->_table_affiliatest);
        }else{
            $query = $this->db->get($this->_table_affiliatest);
        }
        return $query->result();
    }
    /*
     * Function lấy thông tin các con của 1 chi nhánh
     *
     * */
    function getChildren($id_affiliates)
    {
        $this->db->select('department_id');
        $this->db->where('jobs_affiliates_parent_id',$id_affiliates);

        $data = $this->db->get($this->_table_department);
        return $data->result_array();

    }

    /**
        Lấy thông tin cha cho các dữ liệu hiển thị trong table chi nhánh
     */
    function get_parent_affiliates($affiliates_id)
    {
         $query = $this->db->get($this->_table_department);
         return $query->row();
    }


    /** get all table status for update */
    function get_row($department_id)
    {
        $sql = "SELECT * FROM ".$this->_table_department. "
                WHERE department_id = ".$department_id;
        $query = $this->db->query($sql);

        return $query->row();
    }

    public function save2(&$item_data,$department_id = -1)
    {
        $region_info = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$item_data['jobs_affiliates_id']);
        $checkPerson = parent::getInformationPerson('jobs_department','person_id',$item_data['person_id']);
        //3. Trong trường hợp nhân viên quản lý thành phố chính là nhân viên đang quản lý 1 thành phố khác
        //Kiểm tra xem thông tin nhân viên nhân viên có quản lý
        $city_info = parent::getInformationPerson('jobs_department','person_id',$item_data['person_id']);

        if($department_id == -1){//Phần thêm mới thông tin thành phố
            $itemInfoId = parent::getInformationPerson('jobs_affiliates','person_id',$item_data['person_id']);
            if(count($itemInfoId) > 0){
                $itemOne = parent::getTable('jobs_affiliates','jobs_affiliates_id',$item_data['jobs_affiliates_id'],$item_data['person_id'],1);
                if(count($itemOne) == 1){
                    parent::callInsertPermission('department',$item_data['person_id'],1);
                    //Thêm quyền quản lý phong bàn cho người quản lý thành phố
                    $infoPersonCity = parent::getInformationPerson('jobs_city','jobs_city_id',$itemOne->jobs_city_id);
                    parent::callInsertPermission('department',$infoPersonCity->person_id,1);
                    $infoPersonRegions = parent::getInformationPerson('jobs_regions','jobs_regions_id',$infoPersonCity->jobs_regions_id);
                    parent::callInsertPermission('department',$infoPersonRegions->person_id,1);

                    if($this->db->insert($this->_table_department,$item_data)){
                        return true;
                    }
                }else{
                    return false;
                }
            }else if(count($checkPerson) == 0){
                /**
                 * Khi thực hiện thêm mới lấy person_id nhân viên quản lý nếu không có trong bảng table city chúng ta
                 * sẽ thực hiện insert thông tin bt
                 *
                -  Thực hiện :
                 *  1 . Insert quyền nhân viên quản lý thành phố : search và
                 *  2 . Insert nhân viên quản lý khu vực toàn quyền : add_update,delete,search
                 *  3 . Update parent_id của người quản lý thành phố bằng person_id người quản lý khu vực
                 */
                //3.Update table employees
                parent::updateEmployees($region_info->person_id ,$item_data['person_id']);
                //Thêm quyền quản lý phong bàn cho người quản lý thành phố
                $infoPersonCity = parent::getInformationPerson('jobs_city','jobs_city_id',$region_info->jobs_city_id);
                parent::callInsertPermission('department',$infoPersonCity->person_id,1);
                $infoPersonRegions = parent::getInformationPerson('jobs_regions','jobs_regions_id',$infoPersonCity->jobs_regions_id);
                parent::callInsertPermission('department',$infoPersonRegions->person_id,1);

                //2.Insert toàn quyền cho nhân viên quản lý khu vực
                parent::callInsertPermission('department',$region_info->person_id,1);
                parent::callInsertPermission('employees',$item_data['person_id'],1);
                //1.Thực hiện insert quyền xem (search) cho nhân viên quản lý thành phố này
                parent::callInsertPermission('department',$item_data['person_id'],0);
                if($this->db->insert($this->_table_department,$item_data)){
                    return true;
                }
            }else{
                $city_info_one = parent::getOneInformationPerson('jobs_department','jobs_affiliates_id','person_id',$item_data['person_id']);
                if($city_info_one->jobs_affiliates_id == $item_data['jobs_affiliates_id']){
                    /*
                       * Thực hiện insert binh thường vào table city do nhân viên quản lý khu vực
                       *  đã tồn tại tức đã có quyền thực hiện trên thành phố
                       * */
                    if($this->db->insert($this->_table_department,$item_data)){
                        return true;
                    }
                }else{
                    /*
                     * Thực hiện lấy id 2 người quản lý khu vực này và tiến hành so sánh nếu chúng trùng nhau thì thực hiện thêm mới thông tin
                     * */
                    $info_regions_manager = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$city_info_one->jobs_affiliates_id);
                    $info_regions_insert = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$item_data['jobs_affiliates_id']);
                    if($info_regions_insert->person_id == $info_regions_manager->person_id ){
                        if($this->db->insert($this->_table_department,$item_data)){
                            return true;
                        }
                    }else{
                        return false;
                    }
                }
            }
        }else{//Phần update thông tin thành phố

            $itemInfo = parent::getInformationPerson('jobs_department','department_id',$department_id);
            $itemInfoId = parent::getInformationPerson('jobs_affiliates','person_id',$item_data['person_id']);
            $itemInfoManager = parent::getInformationPerson('jobs_affiliates','person_id',$itemInfo->person_id);

            if(count($itemInfoId) > 0){
                $itemOne = parent::getTable('jobs_affiliates','jobs_affiliates_id',$item_data['jobs_affiliates_id'],$item_data['person_id']);
                if($itemOne == 1){
                    //Thực hiện update thông tin
                    $item = parent::getInformationPerson('jobs_department','department_id',$department_id);
                    //Kiểm tra xem nhân viên quản lý khu vực có còn quản lý 1 thành phố nào khác nữa hay không nếu không thì thực hiện xóa quyền cho quản lý của nhân viên này
                    $_info_one = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$item->jobs_affiliates_id);
                    $items_info = parent::getCountInformation('jobs_department','department_id',$department_id,'jobs_affiliates_id');
                    //Lấy id người quản lý phong bàn cho người quản lý thành phố
                    $infoPersonCity = parent::getInformationPerson('jobs_city','jobs_city_id',$region_info->jobs_city_id);
                    $infoPersonRegions = parent::getInformationPerson('jobs_regions','jobs_regions_id',$infoPersonCity->jobs_regions_id);

                    $dem = 0;
                    foreach($items_info AS $values){
                        $regionsPerson = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$values->jobs_affiliates_id);
                        if($regionsPerson->person_id == $_info_one->person_id){
                            $dem ++;
                        }
                    }
                    if($dem == 0){
                        parent::callDeletePermission('department',$_info_one->person_id);
                        parent::callDeletePermission('department',$infoPersonCity->person_id);
                        parent::callDeletePermission('department',$infoPersonRegions->person_id);
                    }
                    //Xóa bỏ toàn bộ quyền của nhân viên mới nếu nhân viên không còn làm quản lý của bất thành phố nào nũa
                    $result = parent::getCountInformation('jobs_department','jobs_affiliates_id',$department_id,'person_id',$item->person_id);
                    if($result == 0){
                        if(count($itemInfoManager) > 0){
                            parent::callDeletePermission('department',$item->person_id);
                            parent::callDeletePermission('employees',$item->person_id);
                        }else{
                            parent::updateEmployees(0,$item->person_id);
                            parent::callDeletePermission('department',$item->person_id);
                            parent::callDeletePermission('employees',$item->person_id);
                        }

                    }
                    //Lấy toàn bộ person_id quản lý chi nhánh thuộc thành phố đang thực hiên update người quản lý mới cho chi nhánh con của thành phố
                    $person_id_city = parent::getInformationPerson('employees','parent_id',$item->person_id,1);
                    parent::updateEmployees($item_data['person_id'],$person_id_city);
                    //Thực hiện insert thông tin nhân viên và quyền của người đó cho thành phố
                    parent::callInsertPermission('department',$item_data['person_id'],1);
                    parent::callInsertPermission('employees',$item_data['person_id'],1);

                    $this->db->where('department_id', $department_id);
                    return $this->db->update($this->_table_department,$item_data);
                }else{
                    return false;
                }
            }else{
                $item = parent::getInformationPerson('jobs_department','department_id',$department_id);
                /*
                 * Kiểm tra xem còn có 1 thành phố nào thuộc khu vực này nữa không
                 * nếu không thì xóa bỏ quyền cảu người quản lý khu vực đối với thành phố
                 * */
                $_info_one = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$item->jobs_affiliates_id);
                $items_info = parent::getCountInformation('jobs_department','department_id',$department_id,'jobs_affiliates_id');
                //Lấy id người quản lý phong bàn cho người quản lý thành phố
                $infoPersonCity = parent::getInformationPerson('jobs_city','jobs_city_id',$region_info->jobs_city_id);
                $infoPersonRegions = parent::getInformationPerson('jobs_regions','jobs_regions_id',$infoPersonCity->jobs_regions_id);
                $dem = 0;
                foreach($items_info AS $values){
                    $regionsPerson = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$values->jobs_affiliates_id);
                    if($regionsPerson->person_id == $_info_one->person_id){
                        $dem ++;
                    }
                }
                if($dem == 0){
                    parent::callDeletePermission('department',$_info_one->person_id);
                    parent::callDeletePermission('department',$infoPersonCity->person_id);
                    parent::callDeletePermission('department',$infoPersonRegions->person_id);
                }
                /*
                 * Khi thực hiện việc update nhân viên quản lý thành phố nếu nhân viên này không còn quản lý bất cứ
                 * thành phố nào khác thì chúng ta thực hiện xóa bỏ quyền của nhân viên này
                 * */
                $itemInfoOne = parent::getInformationPerson('jobs_affiliates','person_id',$item->person_id);
                $result = parent::getCountInformation('jobs_department','department_id',$department_id,'person_id',$item->person_id);
                if($result == 0){
                    if(count($itemInfoOne) > 0){
                        parent::callDeletePermission('department',$item->person_id);
                    }else{
                        parent::updateEmployees(0,$item->person_id);
                        parent::callDeletePermission('department',$item->person_id);
                        parent::callDeletePermission('employees',$item->person_id);
                    }
                }
                //Lấy toàn bộ person_id quản lý chi nhánh thuộc thành phố đang thực hiên update người quản lý mới cho chi nhánh con của thành phố
                $person_id_city = parent::getInformationPerson('employees','parent_id',$item->person_id,1);
                parent::updateEmployees($item_data['person_id'],$person_id_city);
                //Hàm thực hiện xóa bỏ quyền quản lý nhân viên cũ update lại quyền cho nhân viên mới
                $_info = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$item_data['jobs_affiliates_id']);
                if(count($itemInfoOne) > 0){
                    parent::updateEmployees($_info->person_id,$item_data['person_id']);
                    parent::callInsertPermission('department',$_info->person_id,1);
                    parent::callInsertPermission('department',$item_data['person_id'],0);
                    parent::callInsertPermission('department',$infoPersonCity->person_id,1);
                    parent::callInsertPermission('department',$infoPersonRegions->person_id,1);
                }else{
                    parent::updateEmployees($_info->person_id,$item_data['person_id']);
                    parent::callInsertPermission('department',$_info->person_id,1);
                    parent::callInsertPermission('department',$infoPersonCity->person_id,1);
                    parent::callInsertPermission('department',$infoPersonRegions->person_id,1);
                    parent::callInsertPermission('employees',$item_data['person_id'],1);
                    parent::callInsertPermission('department',$item_data['person_id'],0);
                }

                $this->db->where('department_id', $department_id);
                return $this->db->update($this->_table_department,$item_data);
            }
        }
        return false;
    }


    function delete_list2($department_id = -1,$jobs_affiliates_id = '')
    {
        if(empty($jobs_affiliates_id)){
            $this->db->trans_start();
            $dem = 0;
            if(is_array($department_id)){
                foreach ($department_id AS $values){
                    /*
                   * Xủ lý xóa bỏ thông tin mảng thành viên khi xóa thông tin khu vực thì xóa bỏ toàn bộ quyền của nhân viên với khu vực đó
                   * */
                    $items = parent::getInformationPerson('jobs_department','department_id',$values);
                    $itemsRegions = parent::getInformationPerson('jobs_affiliates','person_id',$items->person_id);
                    $result = parent::getCountInformation('jobs_department','department_id',$values,'person_id',$items->person_id);
                    $_info_one = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$items->jobs_affiliates_id);
                    $items_info = parent::getCountInformation('jobs_department','department_id',$values,'jobs_affiliates_id');
                    //Lấy id người quản lý phong bàn cho người quản lý thành phố
                    $infoPersonCity = parent::getInformationPerson('jobs_city','jobs_city_id',$_info_one->jobs_city_id);
                    $infoPersonRegions = parent::getInformationPerson('jobs_regions','jobs_regions_id',$infoPersonCity->jobs_regions_id);

                    if(is_array($items_info)){
                        foreach($items_info AS $v){
                            $regionsPerson = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$v->jobs_affiliates_id);
                            if($regionsPerson->person_id == $_info_one->person_id){
                                $dem ++;
                            }
                        }
                    }
                    if($dem == 0){
                        parent::callDeletePermission('department',$_info_one->person_id);
                        parent::callDeletePermission('department',$infoPersonCity->person_id);
                        parent::callDeletePermission('department',$infoPersonRegions->person_id);
                    }
                    if($result == 0){
                        if(count($itemsRegions) > 0){
                            parent::callDeletePermission('department',$items->person_id);
                        }else{
                            parent::updateEmployees(0,$items->person_id);
                            parent::callDeletePermission('department',$items->person_id);
                            parent::callDeletePermission('employees',$items->person_id);
                        }
                    }
                }
            }else{

                $items = parent::getInformationPerson('jobs_department','department_id',$department_id);
                $itemsRegions = parent::getInformationPerson('jobs_affiliates','person_id',$items->person_id);
                $result = parent::getCountInformation('jobs_department','department_id',$department_id,'person_id',$items->person_id);
                $_info_one = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$items->jobs_affiliates_id);
                $items_info = parent::getCountInformation('jobs_department','department_id',$department_id,'jobs_affiliates_id');
                //Lấy id người quản lý phong bàn cho người quản lý thành phố
                $infoPersonCity = parent::getInformationPerson('jobs_city','jobs_city_id',$_info_one->jobs_city_id);
                $infoPersonRegions = parent::getInformationPerson('jobs_regions','jobs_regions_id',$infoPersonCity->jobs_regions_id);
                if(is_array($items_info)){
                    foreach($items_info AS $v){
                        $regionsPerson = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$v->jobs_affiliates_id);
                        if($regionsPerson->person_id == $_info_one->person_id){
                            $dem ++;
                        }
                    }
                }
                if($dem == 0){
                    parent::callDeletePermission('department',$_info_one->person_id);
                    parent::callDeletePermission('department',$infoPersonCity->person_id);
                    parent::callDeletePermission('department',$infoPersonRegions->person_id);
                }
                if($result == 0){
                    if(count($itemsRegions) > 0){
                        parent::callDeletePermission('department',$items->person_id);
                    }else{
                        parent::updateEmployees(0,$items->person_id);
                        parent::callDeletePermission('department',$items->person_id);
                        parent::callDeletePermission('employees',$items->person_id);
                    }
                }
            }
            $this->db->where_in('department_id',$department_id);

            if($this->db->delete($this->_table_department)){
                $this->db->trans_complete();
                return true;
            }else{
                $this->db->trans_complete();
                return false;
            }
        }else{
            $this->db->trans_start();
            $dem = 0;
            if(is_array($department_id)){
                foreach ($department_id AS $values){
                    /*
                   * Xủ lý xóa bỏ thông tin mảng thành viên khi xóa thông tin khu vực thì xóa bỏ toàn bộ quyền của nhân viên với khu vực đó
                   * */
                    $items = parent::getInformationPerson('jobs_department','department_id',$values);
                    $itemsRegions = parent::getInformationPerson('jobs_affiliates','person_id',$items->person_id);
                    $result = parent::getCountInformation('jobs_department','department_id',$values,'person_id',$items->person_id);
                    $_info_one = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$items->jobs_affiliates_id);
                    $items_info = parent::getCountInformation('jobs_department','department_id',$values,'jobs_affiliates_id');
                    //Lấy id người quản lý phong bàn cho người quản lý thành phố
                    $infoPersonCity = parent::getInformationPerson('jobs_city','jobs_city_id',$_info_one->jobs_city_id);
                    $infoPersonRegions = parent::getInformationPerson('jobs_regions','jobs_regions_id',$infoPersonCity->jobs_regions_id);

                    if(is_array($items_info)){
                        foreach($items_info AS $v){
                            $regionsPerson = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$v->jobs_affiliates_id);
                            if($regionsPerson->person_id == $_info_one->person_id){
                                $dem ++;
                            }
                        }
                    }
                    if($dem == 0){
                        parent::callDeletePermission('department',$_info_one->person_id);
                        parent::callDeletePermission('department',$infoPersonCity->person_id);
                        parent::callDeletePermission('department',$infoPersonRegions->person_id);
                    }
                    if($result == 0){
                        if(count($itemsRegions) > 0){
                            parent::callDeletePermission('department',$items->person_id);
                        }else{
                            parent::updateEmployees(0,$items->person_id);
                            parent::callDeletePermission('department',$items->person_id);
                            parent::callDeletePermission('employees',$items->person_id);
                        }
                    }
                }
            }else{

                $items = parent::getInformationPerson('jobs_department','department_id',$department_id);
                $itemsRegions = parent::getInformationPerson('jobs_affiliates','person_id',$items->person_id);
                $result = parent::getCountInformation('jobs_department','department_id',$department_id,'person_id',$items->person_id);
                $_info_one = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$items->jobs_affiliates_id);
                $items_info = parent::getCountInformation('jobs_department','department_id',$department_id,'jobs_affiliates_id');
                //Lấy id người quản lý phong bàn cho người quản lý thành phố
                $infoPersonCity = parent::getInformationPerson('jobs_city','jobs_city_id',$_info_one->jobs_city_id);
                $infoPersonRegions = parent::getInformationPerson('jobs_regions','jobs_regions_id',$infoPersonCity->jobs_regions_id);
                if(is_array($items_info)){
                    foreach($items_info AS $v){
                        $regionsPerson = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$v->jobs_affiliates_id);
                        if($regionsPerson->person_id == $_info_one->person_id){
                            $dem ++;
                        }
                    }
                }
                if($dem == 0){
                    parent::callDeletePermission('department',$_info_one->person_id);
                    parent::callDeletePermission('department',$infoPersonCity->person_id);
                    parent::callDeletePermission('department',$infoPersonRegions->person_id);
                }
                if($result == 0){
                    if(count($itemsRegions) > 0){
                        parent::callDeletePermission('department',$items->person_id);
                    }else{
                        parent::updateEmployees(0,$items->person_id);
                        parent::callDeletePermission('department',$items->person_id);
                        parent::callDeletePermission('employees',$items->person_id);
                    }
                }
            }
            $this->db->where_in('department_id',$department_id);
            if($this->db->delete($this->_table_department)){
                $this->Employee->delete_list('',$department_id);
                $this->db->trans_complete();
                return true;
            }else{
                $this->db->trans_complete();
                return false;
            }
        }
    }
    
    ///hung audi
	public function save(&$item_data,$department_id = -1)
    {
        $region_info = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$item_data['jobs_affiliates_id']);
        $checkPerson = parent::getInformationPerson('jobs_department','person_id',$item_data['person_id']);
        //3. Trong trường hợp nhân viên quản lý thành phố chính là nhân viên đang quản lý 1 thành phố khác
        //Kiểm tra xem thông tin nhân viên nhân viên có quản lý
        $city_info = parent::getInformationPerson('jobs_department','person_id',$item_data['person_id']);

        if($department_id == -1){//Phần thêm mới thông tin thành phố
            $itemInfoId = parent::getInformationPerson('jobs_affiliates','person_id',$item_data['person_id']);
            if(count($itemInfoId) > 0){
                $itemOne = parent::getTable('jobs_affiliates','jobs_affiliates_id',$item_data['jobs_affiliates_id'],$item_data['person_id'],1);
                if(count($itemOne) == 1){
                    //parent::callInsertPermission('department',$item_data['person_id'],1);
                    parent::callInsertPermission('employees',$item_data['person_id'],1);
                    //Thêm quyền quản lý phong bàn cho người quản lý thành phố
                    $infoPersonCity = parent::getInformationPerson('jobs_city','jobs_city_id',$itemOne->jobs_city_id);
                    //parent::callInsertPermission('department',$infoPersonCity->person_id,1);
                    parent::callInsertPermission('employees',$infoPersonCity->person_id,1);
                    $infoPersonRegions = parent::getInformationPerson('jobs_regions','jobs_regions_id',$infoPersonCity->jobs_regions_id);
                    //parent::callInsertPermission('department',$infoPersonRegions->person_id,1);
                    parent::callInsertPermission('employees',$infoPersonRegions->person_id,1);
                    
                    if($this->db->insert($this->_table_department,$item_data)){
                        return true;
                    }
                }else{
                    return false;
                }
            }else if(count($checkPerson) == 0){
                /**
                 * Khi thực hiện thêm mới lấy person_id nhân viên quản lý nếu không có trong bảng table city chúng ta
                 * sẽ thực hiện insert thông tin bt
                 *
                -  Thực hiện :
                 *  1 . Insert quyền nhân viên quản lý thành phố : search và
                 *  2 . Insert nhân viên quản lý khu vực toàn quyền : add_update,delete,search
                 *  3 . Update parent_id của người quản lý thành phố bằng person_id người quản lý khu vực
                 */
                //3.Update table employees
                parent::updateEmployees($region_info->person_id ,$item_data['person_id']);
                //Thêm quyền quản lý phong bàn cho người quản lý thành phố
                $infoPersonCity = parent::getInformationPerson('jobs_city','jobs_city_id',$region_info->jobs_city_id);
                //parent::callInsertPermission('department',$infoPersonCity->person_id,1);
                parent::callInsertPermission('employees',$infoPersonCity->person_id,1);
                $infoPersonRegions = parent::getInformationPerson('jobs_regions','jobs_regions_id',$infoPersonCity->jobs_regions_id);
                //parent::callInsertPermission('department',$infoPersonRegions->person_id,1);
                parent::callInsertPermission('employees',$infoPersonRegions->person_id,1);
                
                //2.Insert toàn quyền cho nhân viên quản lý khu vực
                //parent::callInsertPermission('department',$region_info->person_id,1);
                parent::callInsertPermission('employees',$region_info->person_id,1);
                parent::callInsertPermission('employees',$item_data['person_id'],1);
                //1.Thực hiện insert quyền xem (search) cho nhân viên quản lý thành phố này
                //parent::callInsertPermission('department',$item_data['person_id'],0);
                if($this->db->insert($this->_table_department,$item_data)){
                    return true;
                }
            }else{
                $city_info_one = parent::getOneInformationPerson('jobs_department','jobs_affiliates_id','person_id',$item_data['person_id']);
                if($city_info_one->jobs_affiliates_id == $item_data['jobs_affiliates_id']){
                    /*
                       * Thực hiện insert binh thường vào table city do nhân viên quản lý khu vực
                       *  đã tồn tại tức đã có quyền thực hiện trên thành phố
                       * */
                    if($this->db->insert($this->_table_department,$item_data)){
                        return true;
                    }
                }else{
                    /*
                     * Thực hiện lấy id 2 người quản lý khu vực này và tiến hành so sánh nếu chúng trùng nhau thì thực hiện thêm mới thông tin
                     * */
                    $info_regions_manager = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$city_info_one->jobs_affiliates_id);
                    $info_regions_insert = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$item_data['jobs_affiliates_id']);
                    if($info_regions_insert->person_id == $info_regions_manager->person_id ){
                        if($this->db->insert($this->_table_department,$item_data)){
                            return true;
                        }
                    }else{
                        return false;
                    }
                }
            }
        }else{//Phần update thông tin thành phố

            $itemInfo = parent::getInformationPerson('jobs_department','department_id',$department_id);
            $itemInfoId = parent::getInformationPerson('jobs_affiliates','person_id',$item_data['person_id']);
            $itemInfoManager = parent::getInformationPerson('jobs_affiliates','person_id',$itemInfo->person_id);

            if(count($itemInfoId) > 0){
                $itemOne = parent::getTable('jobs_affiliates','jobs_affiliates_id',$item_data['jobs_affiliates_id'],$item_data['person_id']);
                if($itemOne == 1){
                    //Thực hiện update thông tin
                    $item = parent::getInformationPerson('jobs_department','department_id',$department_id);
                    //Kiểm tra xem nhân viên quản lý khu vực có còn quản lý 1 thành phố nào khác nữa hay không nếu không thì thực hiện xóa quyền cho quản lý của nhân viên này
                    $_info_one = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$item->jobs_affiliates_id);
                    $items_info = parent::getCountInformation('jobs_department','department_id',$department_id,'jobs_affiliates_id');
                    //Lấy id người quản lý phong bàn cho người quản lý thành phố
                    $infoPersonCity = parent::getInformationPerson('jobs_city','jobs_city_id',$region_info->jobs_city_id);
                    $infoPersonRegions = parent::getInformationPerson('jobs_regions','jobs_regions_id',$infoPersonCity->jobs_regions_id);

                    $dem = 0;
                    foreach($items_info AS $values){
                        $regionsPerson = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$values->jobs_affiliates_id);
                        if($regionsPerson->person_id == $_info_one->person_id){
                            $dem ++;
                        }
                    }
                    if($dem == 0){
                        //parent::callDeletePermission('department',$_info_one->person_id);
                        //parent::callDeletePermission('department',$infoPersonCity->person_id);
                        //parent::callDeletePermission('department',$infoPersonRegions->person_id);
                        parent::callDeletePermission2('employees',$_info_one->person_id);
                        parent::callDeletePermission2('employees',$infoPersonCity->person_id);
                        parent::callDeletePermission2('employees',$infoPersonRegions->person_id);
                        
                    }
                    //Xóa bỏ toàn bộ quyền của nhân viên mới nếu nhân viên không còn làm quản lý của bất thành phố nào nũa
                    $result = parent::getCountInformation('jobs_department','jobs_affiliates_id',$department_id,'person_id',$item->person_id);
                    if($result == 0){
                        if(count($itemInfoManager) > 0){
                            //parent::callDeletePermission('department',$item->person_id);
                            parent::callDeletePermission2('employees',$item->person_id);
                        }else{
                            parent::updateEmployees(0,$item->person_id);
                            //parent::callDeletePermission('department',$item->person_id);
                            parent::callDeletePermission2('employees',$item->person_id);
                        }

                    }
                    //Lấy toàn bộ person_id quản lý chi nhánh thuộc thành phố đang thực hiên update người quản lý mới cho chi nhánh con của thành phố
                    $person_id_city = parent::getInformationPerson('employees','parent_id',$item->person_id,1);
                    parent::updateEmployees($item_data['person_id'],$person_id_city);
                    //Thực hiện insert thông tin nhân viên và quyền của người đó cho thành phố
                    //parent::callInsertPermission('department',$item_data['person_id'],1);
                    parent::callInsertPermission('employees',$item_data['person_id'],1);

                    $this->db->where('department_id', $department_id);
                    return $this->db->update($this->_table_department,$item_data);
                }else{
                    return false;
                }
            }else{
                $item = parent::getInformationPerson('jobs_department','department_id',$department_id);
                /*
                 * Kiểm tra xem còn có 1 thành phố nào thuộc khu vực này nữa không
                 * nếu không thì xóa bỏ quyền cảu người quản lý khu vực đối với thành phố
                 * */
                $_info_one = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$item->jobs_affiliates_id);
                $items_info = parent::getCountInformation('jobs_department','department_id',$department_id,'jobs_affiliates_id');
                //Lấy id người quản lý phong bàn cho người quản lý thành phố
                $infoPersonCity = parent::getInformationPerson('jobs_city','jobs_city_id',$region_info->jobs_city_id);
                $infoPersonRegions = parent::getInformationPerson('jobs_regions','jobs_regions_id',$infoPersonCity->jobs_regions_id);
                $dem = 0;
                foreach($items_info AS $values){
                    $regionsPerson = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$values->jobs_affiliates_id);
                    if($regionsPerson->person_id == $_info_one->person_id){
                        $dem ++;
                    }
                }
                if($dem == 0){
                    //parent::callDeletePermission('department',$_info_one->person_id);
                    //parent::callDeletePermission('department',$infoPersonCity->person_id);
                    //parent::callDeletePermission('department',$infoPersonRegions->person_id);
                    parent::callDeletePermission2('employees',$_info_one->person_id);
                    parent::callDeletePermission2('employees',$infoPersonCity->person_id);
                    parent::callDeletePermission2('employees',$infoPersonRegions->person_id);
                    
                }
                /*
                 * Khi thực hiện việc update nhân viên quản lý thành phố nếu nhân viên này không còn quản lý bất cứ
                 * thành phố nào khác thì chúng ta thực hiện xóa bỏ quyền của nhân viên này
                 * */
                $itemInfoOne = parent::getInformationPerson('jobs_affiliates','person_id',$item->person_id);
                $result = parent::getCountInformation('jobs_department','department_id',$department_id,'person_id',$item->person_id);
                if($result == 0){
                    if(count($itemInfoOne) > 0){
                        parent::callDeletePermission2('employees',$item->person_id);
                    }else{
                        parent::updateEmployees(0,$item->person_id);
                        //parent::callDeletePermission('department',$item->person_id);
                        parent::callDeletePermission2('employees',$item->person_id);
                    }
                }
                //Lấy toàn bộ person_id quản lý chi nhánh thuộc thành phố đang thực hiên update người quản lý mới cho chi nhánh con của thành phố
                $person_id_city = parent::getInformationPerson('employees','parent_id',$item->person_id,1);
                parent::updateEmployees($item_data['person_id'],$person_id_city);
                //Hàm thực hiện xóa bỏ quyền quản lý nhân viên cũ update lại quyền cho nhân viên mới
                $_info = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$item_data['jobs_affiliates_id']);
                if(count($itemInfoOne) > 0){
                    parent::updateEmployees($_info->person_id,$item_data['person_id']);
                    //parent::callInsertPermission('department',$_info->person_id,1);
                    //parent::callInsertPermission('department',$item_data['person_id'],0);
                    //parent::callInsertPermission('department',$infoPersonCity->person_id,1);
                    //parent::callInsertPermission('department',$infoPersonRegions->person_id,1);
                    
                    parent::callInsertPermission('employees',$_info->person_id,1);
                    parent::callInsertPermission('employees',$item_data['person_id'],1);
                    parent::callInsertPermission('employees',$infoPersonCity->person_id,1);
                    parent::callInsertPermission('employees',$infoPersonRegions->person_id,1);
                }else{
                    parent::updateEmployees($_info->person_id,$item_data['person_id']);
                    //parent::callInsertPermission('department',$_info->person_id,1);
                    //parent::callInsertPermission('department',$infoPersonCity->person_id,1);
                    //parent::callInsertPermission('department',$infoPersonRegions->person_id,1);
                    //parent::callInsertPermission('department',$item_data['person_id'],0);
                    
                    parent::callInsertPermission('employees',$_info->person_id,1);
                    parent::callInsertPermission('employees',$infoPersonCity->person_id,1);
                    parent::callInsertPermission('employees',$infoPersonRegions->person_id,1);
                    

                    parent::callInsertPermission('employees',$item_data['person_id'],1);
                }

                $this->db->where('department_id', $department_id);
                return $this->db->update($this->_table_department,$item_data);
            }
        }
        return false;
    }


    function delete_list($department_id = -1,$jobs_affiliates_id = '')
    {
        if(empty($jobs_affiliates_id)){
            $this->db->trans_start();
            $dem = 0;
            if(is_array($department_id)){
                foreach ($department_id AS $values){
                    /*
                   * Xủ lý xóa bỏ thông tin mảng thành viên khi xóa thông tin khu vực thì xóa bỏ toàn bộ quyền của nhân viên với khu vực đó
                   * */
                    $items = parent::getInformationPerson('jobs_department','department_id',$values);
                    $itemsRegions = parent::getInformationPerson('jobs_affiliates','person_id',$items->person_id);
                    $result = parent::getCountInformation('jobs_department','department_id',$values,'person_id',$items->person_id);
                    $_info_one = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$items->jobs_affiliates_id);
                    $items_info = parent::getCountInformation('jobs_department','department_id',$values,'jobs_affiliates_id');
                    //Lấy id người quản lý phong bàn cho người quản lý thành phố
                    $infoPersonCity = parent::getInformationPerson('jobs_city','jobs_city_id',$_info_one->jobs_city_id);
                    $infoPersonRegions = parent::getInformationPerson('jobs_regions','jobs_regions_id',$infoPersonCity->jobs_regions_id);

                    if(is_array($items_info)){
                        foreach($items_info AS $v){
                            $regionsPerson = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$v->jobs_affiliates_id);
                            if($regionsPerson->person_id == $_info_one->person_id){
                                $dem ++;
                            }
                        }
                    }
                    if($dem == 0){
                        /*parent::callDeletePermission('department',$_info_one->person_id);
                        parent::callDeletePermission('department',$infoPersonCity->person_id);
                        parent::callDeletePermission('department',$infoPersonRegions->person_id);
						*/
                        parent::callDeletePermission2('employees',$_info_one->person_id);
                        parent::callDeletePermission2('employees',$infoPersonCity->person_id);
                        parent::callDeletePermission2('employees',$infoPersonRegions->person_id);
                    
                    }
                    if($result == 0){
                        if(count($itemsRegions) > 0){
                            //parent::callDeletePermission('department',$items->person_id);
                            parent::callDeletePermission2('employees',$items->person_id);
                        }else{
                            parent::updateEmployees(0,$items->person_id);
                            //parent::callDeletePermission('department',$items->person_id);
                            parent::callDeletePermission2('employees',$items->person_id);
                        }
                    }
                }
            }else{

                $items = parent::getInformationPerson('jobs_department','department_id',$department_id);
                $itemsRegions = parent::getInformationPerson('jobs_affiliates','person_id',$items->person_id);
                $result = parent::getCountInformation('jobs_department','department_id',$department_id,'person_id',$items->person_id);
                $_info_one = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$items->jobs_affiliates_id);
                $items_info = parent::getCountInformation('jobs_department','department_id',$department_id,'jobs_affiliates_id');
                //Lấy id người quản lý phong bàn cho người quản lý thành phố
                $infoPersonCity = parent::getInformationPerson('jobs_city','jobs_city_id',$_info_one->jobs_city_id);
                $infoPersonRegions = parent::getInformationPerson('jobs_regions','jobs_regions_id',$infoPersonCity->jobs_regions_id);
                if(is_array($items_info)){
                    foreach($items_info AS $v){
                        $regionsPerson = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$v->jobs_affiliates_id);
                        if($regionsPerson->person_id == $_info_one->person_id){
                            $dem ++;
                        }
                    }
                }
                if($dem == 0){
                    /*parent::callDeletePermission('department',$_info_one->person_id);
                    parent::callDeletePermission('department',$infoPersonCity->person_id);
                    parent::callDeletePermission('department',$infoPersonRegions->person_id);
                    */
                    parent::callDeletePermission2('employees',$_info_one->person_id);
                    parent::callDeletePermission2('employees',$infoPersonCity->person_id);
                    parent::callDeletePermission2('employees',$infoPersonRegions->person_id);
                    
                }
                if($result == 0){
                    if(count($itemsRegions) > 0){
                        //parent::callDeletePermission('department',$items->person_id);
                        parent::callDeletePermission2('employees',$items->person_id);
                    }else{
                        parent::updateEmployees(0,$items->person_id);
                        //parent::callDeletePermission('department',$items->person_id);
                        parent::callDeletePermission2('employees',$items->person_id);
                    }
                }
            }
            $this->db->where_in('department_id',$department_id);

            if($this->db->delete($this->_table_department)){
                $this->db->trans_complete();
                return true;
            }else{
                $this->db->trans_complete();
                return false;
            }
        }else{
            $this->db->trans_start();
            $dem = 0;
            if(is_array($department_id)){
                foreach ($department_id AS $values){
                    /*
                   * Xủ lý xóa bỏ thông tin mảng thành viên khi xóa thông tin khu vực thì xóa bỏ toàn bộ quyền của nhân viên với khu vực đó
                   * */
                    $items = parent::getInformationPerson('jobs_department','department_id',$values);
                    $itemsRegions = parent::getInformationPerson('jobs_affiliates','person_id',$items->person_id);
                    $result = parent::getCountInformation('jobs_department','department_id',$values,'person_id',$items->person_id);
                    $_info_one = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$items->jobs_affiliates_id);
                    $items_info = parent::getCountInformation('jobs_department','department_id',$values,'jobs_affiliates_id');
                    //Lấy id người quản lý phong bàn cho người quản lý thành phố
                    $infoPersonCity = parent::getInformationPerson('jobs_city','jobs_city_id',$_info_one->jobs_city_id);
                    $infoPersonRegions = parent::getInformationPerson('jobs_regions','jobs_regions_id',$infoPersonCity->jobs_regions_id);

                    if(is_array($items_info)){
                        foreach($items_info AS $v){
                            $regionsPerson = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$v->jobs_affiliates_id);
                            if($regionsPerson->person_id == $_info_one->person_id){
                                $dem ++;
                            }
                        }
                    }
                    if($dem == 0){
                        /*parent::callDeletePermission('department',$_info_one->person_id);
                        parent::callDeletePermission('department',$infoPersonCity->person_id);
                        parent::callDeletePermission('department',$infoPersonRegions->person_id);
                        */
                        parent::callDeletePermission2('employees',$_info_one->person_id);
                        parent::callDeletePermission2('employees',$infoPersonCity->person_id);
                        parent::callDeletePermission2('employees',$infoPersonRegions->person_id);
                        
                    }
                    if($result == 0){
                        if(count($itemsRegions) > 0){
                            //parent::callDeletePermission('department',$items->person_id);
                            parent::callDeletePermission2('employees',$items->person_id);
                        }else{
                            parent::updateEmployees(0,$items->person_id);
                            //parent::callDeletePermission('department',$items->person_id);
                            parent::callDeletePermission2('employees',$items->person_id);
                        }
                    }
                }
            }else{

                $items = parent::getInformationPerson('jobs_department','department_id',$department_id);
                $itemsRegions = parent::getInformationPerson('jobs_affiliates','person_id',$items->person_id);
                $result = parent::getCountInformation('jobs_department','department_id',$department_id,'person_id',$items->person_id);
                $_info_one = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$items->jobs_affiliates_id);
                $items_info = parent::getCountInformation('jobs_department','department_id',$department_id,'jobs_affiliates_id');
                //Lấy id người quản lý phong bàn cho người quản lý thành phố
                $infoPersonCity = parent::getInformationPerson('jobs_city','jobs_city_id',$_info_one->jobs_city_id);
                $infoPersonRegions = parent::getInformationPerson('jobs_regions','jobs_regions_id',$infoPersonCity->jobs_regions_id);
                if(is_array($items_info)){
                    foreach($items_info AS $v){
                        $regionsPerson = parent::getInformationPerson('jobs_affiliates','jobs_affiliates_id',$v->jobs_affiliates_id);
                        if($regionsPerson->person_id == $_info_one->person_id){
                            $dem ++;
                        }
                    }
                }
                if($dem == 0){
                    /*parent::callDeletePermission('department',$_info_one->person_id);
                    parent::callDeletePermission('department',$infoPersonCity->person_id);
                    parent::callDeletePermission('department',$infoPersonRegions->person_id);
                    */
                    parent::callDeletePermission2('employees',$_info_one->person_id);
                    parent::callDeletePermission2('employees',$infoPersonCity->person_id);
                    parent::callDeletePermission2('employees',$infoPersonRegions->person_id);
                    
                }
                if($result == 0){
                    if(count($itemsRegions) > 0){
                        //parent::callDeletePermission('department',$items->person_id);
                        parent::callDeletePermission2('employees',$items->person_id);
                    }else{
                        parent::updateEmployees(0,$items->person_id);
                        //parent::callDeletePermission('department',$items->person_id);
                        parent::callDeletePermission2('employees',$items->person_id);
                    }
                }
            }
            $this->db->where_in('department_id',$department_id);
            if($this->db->delete($this->_table_department)){
                $this->Employee->delete_list('',$department_id);
                $this->db->trans_complete();
                return true;
            }else{
                $this->db->trans_complete();
                return false;
            }
        }
    }
    //end ha
    
    /*
     * Function get information for checkName đã được sử dụng hay chưa
     * Trong đó có 2 trường hợp là
     *  - Insert : Thì mỗi khi họ thay đổi thông tin trong input nếu như tên đã được sủ dụng
     *  - Update : Thì mỗi khi họ thay đổi thông tin trong input nếu như tên đã được sủ dụng biến
     *  $department_id có ý nghia tương tự như việc chúng ta đang ở trạng thái nào
     * */
   
     public function checkDepartmentName($department_name,$department_id)
    {
        if(empty($department_id) OR $department_id == -1){
            $this->db->where("department_name LIKE '".$this->db->escape_like_str($department_name)."'");
        }else{
            $this->db->where("department_name LIKE '".$this->db->escape_like_str($department_name)."' AND department_id != ".$department_id);
        }

        $result = $this->db->get($this->_table_department);
        return $result->num_rows();
    }
    
	
    
    //hung audi 28-3
	
	function get_all($jobs_affiliates_id, $person_id,$limit = 10000, $offset = 0, $col='department_name',$order = 'DESC')
    {  
    	if( $person_id == 1){
			$data = parent::getPersonId($person_id);
	        $sql = "SELECT d.*,p.first_name 
	        FROM ".$this->_table_department." d INNER JOIN ".$this->_table_people. " p 
	        ON d.person_id=p.person_id 
	        ORDER BY ".$col." ".$order." LIMIT $offset,$limit ";
		}else{
	        $data = parent::getPersonId($person_id);
	        $sql = "SELECT d.*,p.first_name 
	        FROM ".$this->_table_department." d 
	        INNER JOIN ".$this->_table_people. " p ON d.person_id=p.person_id 
	        INNER JOIN $this->_table_affiliates a ON a.jobs_affiliates_id = d.jobs_affiliates_id
	        WHERE a.jobs_affiliates_id IN ($jobs_affiliates_id)
	        ORDER BY ".$col." ".$order." LIMIT $offset,$limit ";
		}
		
	    $data = $this->db->query($sql);
        return $data;
    }
	public function count_all($jobs_affiliates_id,$person_id)
    {
    	if( $person_id == 1){
    		$data = parent::getPersonId($person_id);
	        $this->db->where_in($data);
	        $this->db->from($this->_table_department);
    	}else{
	        $this->db->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id");
		    $this->db->where("$this->_table_affiliates.jobs_affiliates_id in ($jobs_affiliates_id)");
	        $this->db->from($this->_table_department);
    	}

        return $this->db->count_all_results();
    }
   /*
    Get search suggestions to find status
    */
    function get_search_suggestions($jobs_affiliates_id, $person_id, $search,$limit=10000)
    {
    	if( $person_id == 1){
	        $this->db->from($this->_table_department);
	        $this->db->like("department_name",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
	        $this->db->order_by("department_name", "DESC");
    	}else{    
        
	        $this->db->from($this->_table_department);
	        $this->db->like("department_name",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
	        $this->db->join($this->_table_affiliates, "$this->_table_department.jobs_affiliates_id = $this->_table_affiliates.jobs_affiliates_id");
	        $this->db->where("$this->_table_affiliates.jobs_affiliates_id in ($jobs_affiliates_id)");
	        $this->db->order_by("department_name", "DESC");
    	}
        $by_jobs_name = $this->db->get();
        foreach($by_jobs_name->result() as $row)
        {
            $suggestions[]=array('label'=> $row->department_name);
        }

        //only return $limit suggestions
        $this->db->from('jobs_department');
                $this->db->join('people','jobs_department.person_id=people.person_id','inner');
                if ($this->config->item('speed_up_search_queries')) {
	            $this->db->where("(first_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
				last_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
				CONCAT(`first_name`,' ',`last_name`) LIKE '" . $this->db->escape_like_str($search) . "%')");
	        } else {
	            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
				last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
				CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%')");
	        }
            
                $by_name_employee=$this->db->get();
                foreach($by_name_employee->result() as $row)
		{
			$suggestions[]=array('label' => $row->first_name .' '.$row->last_name);
		}
                //end dungbv
        if(count($suggestions )> $limit)
        {
            $suggestions = array_slice($suggestions, 0,$limit);
        }
        return $suggestions;

    }
    function search($jobs_affiliates_id, $person_id, $search, $limit=50,$offset=0,$column='department_name',$orderby='ASC')
    {
        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->from('jobs_department d');
            $this->db->join('people p','p.person_id=d.person_id','left');
            
            $this->db->where("d.department_name LIKE '%".$this->db->escape_like_str($search)."%' or CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%'");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);

            return $this->db->get();
        }
        else
        {
        	if( $person_id == 1){
        		$this->db->from('jobs_department d');
	            $this->db->join('people p','p.person_id=d.person_id','left');
	            $this->db->where("d.department_name LIKE '%".$this->db->escape_like_str($search)."%' or CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%'");
	            $this->db->order_by($column, $orderby);
	            $this->db->limit($limit);
	            $this->db->offset($offset);
        	}else{
        		$this->db->from('jobs_department d');
	            $this->db->join('people p','p.person_id=d.person_id','left');
	            $this->db->join("$this->_table_affiliates a",'a.jobs_affiliates_id=d.jobs_affiliates_id');
	            $this->db->where("d.department_name LIKE '%".$this->db->escape_like_str($search)."%' or CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%'");
	            $this->db->where("a.jobs_affiliates_id in ($jobs_affiliates_id)");
	            $this->db->order_by($column, $orderby);
	            $this->db->limit($limit);
	            $this->db->offset($offset);
        	}
            return $this->db->get();
        }
    }

    function search_count_all($jobs_affiliates_id, $person_id, $search, $limit=10000)
    {
        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->from($this->_table_department);
            $this->db->where("department_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by("department_name", "DESC");

            $result=$this->db->get();
            return $result->num_rows();
        }
        else
        {
        	if( $person_id == 1){
	            $this->db->from($this->_table_department);
	            $this->db->where("department_name LIKE '%".$this->db->escape_like_str($search)."%'");
	            $this->db->order_by("department_name", "DESC");
        	}else{
        		$this->db->from("$this->_table_department d");
	            $this->db->join("$this->_table_affiliates a",'a.jobs_affiliates_id=d.jobs_affiliates_id');
	            $this->db->where("a.jobs_affiliates_id in ($jobs_affiliates_id)");
	            $this->db->where("d.department_name LIKE '%".$this->db->escape_like_str($search)."%'");
	            $this->db->order_by("d.department_name", "DESC");
        	}
            $result=$this->db->get();
            return $result->num_rows();
        }
    } 
    function get_dep_id($person_id)
    {
        $sql = "SELECT * FROM ".$this->_table_department. "
                WHERE person_id = ".$person_id;
        $query = $this->db->query($sql);
		return $query;
    }
	function get_dep($jobs_regions_id){
	    $jobs_citys= $this->Employee->get_city_id2($jobs_regions_id)->result(); 
	    
	    foreach ( $jobs_citys as $jobs_city){
	    	$jobs_city_id[] = $jobs_city->jobs_city_id;
	    }
    	$jobs_city_ids = implode($jobs_city_id,',');
    	$jobs_affiliates_ids= $this->Jobs_affiliates->get_all($jobs_city_ids)->result();
    	
    	foreach ($jobs_affiliates_ids as $jobs_affiliates_id){
    		$jobs_affiliates_id2[]= $jobs_affiliates_id->jobs_affiliates_id;
    	}
    	$jobs_affiliates_id3=implode($jobs_affiliates_id2, ','); 
    	return $jobs_affiliates_id3;
    }
	function get_dep2($jobs_city_ids){
    	$jobs_affiliates_ids= $this->Jobs_affiliates->get_all($jobs_city_ids)->result();
    	
    	foreach ($jobs_affiliates_ids as $jobs_affiliates_id){
    		$jobs_affiliates_id2[]= $jobs_affiliates_id->jobs_affiliates_id;
    	}
    	$jobs_affiliates_id3=implode($jobs_affiliates_id2, ','); 
    	return $jobs_affiliates_id3;
    }
}

