<?php
class Jobs_city extends Employee
{
     public function __construct(){
        parent::__construct();
        $this->_table_cities = $this->db->dbprefix('cities');
        $this->_table_employees = $this->db->dbprefix('employees');
        $this->_table_people = $this->db->dbprefix('people');
        
        $this->_table_regions = $this->db->dbprefix('jobs_regions');
        $this->_table_city = $this->db->dbprefix('jobs_city');
        $this->_table_affiliates = $this->db->dbprefix('jobs_affiliates');
		$this->_table_department = $this->db->dbprefix('jobs_department');
     }

    /* ByAuthor: @SnguyenOne
     * - Function: count_all()
     * - Description: Get total record of the table $_table_employees_jobs
     * - Param : param :$person_id is validator
     * - Return : number round this table
     *
     * */
	
    function checkUpdate($person_id,$module_id)
    {
        return parent::checkUpdate('add_update',$person_id,$module_id);
    }

    function get_all2($person_id,$limit = 10000, $offset =0, $col ='jobs_city_name',$order = 'DESC')
    {
        $data = parent::getPersonId($person_id);
        $sql = "SELECT c.*,p.first_name FROM ".$this->_table_city." c INNER JOIN ".$this->_table_people. " p ON c.person_id=p.person_id WHERE c.person_id IN($data) ORDER BY ".$col." ".$order." LIMIT $offset,$limit ";
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

    function get_regions_info()
    {
        $this->db->select('jobs_regions_id,jobs_regions_name');
        //$this->db->where('jobs_regions_id','1');
        $query = $this->db->get($this->_table_regions);

        return $query->result();
    }
    /*
     * Hàm thực hiện lấy toàn bộ thông tin các tình thành phố
     * */
    function getAllCity()
    {
        $sql = "SELECT id_city,name FROM ".$this->_table_cities;
        $data = $this->db->query($sql);

        return $data->result();
    }

    /** get all table status for update */
    function get_city($jobs_city_id)
    {
        $sql = "SELECT * FROM ".$this->_table_city. "
                WHERE jobs_city_id = ".$jobs_city_id;
        $query = $this->db->query($sql);

        return $query->row();
    }

    /*
        Author By: @SnguyenOne
     *  Function: Manager Save
     *  Description: Thực hiện phần quyền cho các nhân viên quản lý thành phố
     *  Param : $item_data and $jobs_city_id
     * */
    public function save2(&$item_data,$jobs_city_id = -1)
    {
        $region_info = parent::getInformationPerson('jobs_regions','jobs_regions_id',$item_data['jobs_regions_id']);
        $checkPerson = parent::getInformationPerson('jobs_city','person_id',$item_data['person_id']);
        //3. Trong trường hợp nhân viên quản lý thành phố chính là nhân viên đang quản lý 1 thành phố khác
        //Kiểm tra xem thông tin nhân viên nhân viên có quản lý
        $city_info = parent::getInformationPerson('jobs_city','person_id',$item_data['person_id']);

        if($jobs_city_id == -1){//Phần thêm mới thông tin thành phố
            $itemInfoId = parent::getInformationPerson('jobs_regions','person_id',$item_data['person_id']);
            if(count($itemInfoId) > 0){
                $itemOne = parent::getTable('jobs_regions','jobs_regions_id',$item_data['jobs_regions_id'],$item_data['person_id']);
                if($itemOne == 1){
                    parent::callInsertPermission('city',$item_data['person_id'],1);
                    if($this->db->insert($this->_table_city,$item_data)){
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
                //2.Insert toàn quyền cho nhân viên quản lý khu vực
                parent::callInsertPermission('city',$region_info->person_id,1);
                parent::callInsertPermission('employees',$item_data['person_id'],1);
                //1.Thực hiện insert quyền xem (search) cho nhân viên quản lý thành phố này
                parent::callInsertPermission('city',$item_data['person_id'],0);
                if($this->db->insert($this->_table_city,$item_data)){
                    return true;
                }
            }else{
                $city_info_one = parent::getOneInformationPerson('jobs_city','jobs_regions_id','person_id',$item_data['person_id']);
                if($city_info_one->jobs_regions_id == $item_data['jobs_regions_id']){
                    /*
                       * Thực hiện insert binh thường vào table city do nhân viên quản lý khu vực
                       *  đã tồn tại tức đã có quyền thực hiện trên thành phố
                       * */
                    if($this->db->insert($this->_table_city,$item_data)){
                        return true;
                    }
                }else{
                    /*
                     * Thực hiện lấy id 2 người quản lý khu vực này và tiến hành so sánh nếu chúng trùng nhau thì thực hiện thêm mới thông tin
                     * */
                    $info_regions_manager = parent::getInformationPerson('jobs_regions','jobs_regions_id',$city_info_one->jobs_regions_id);
                    $info_regions_insert = parent::getInformationPerson('jobs_regions','jobs_regions_id',$item_data['jobs_regions_id']);
                    if($info_regions_insert->person_id == $info_regions_manager->person_id ){
                        if($this->db->insert($this->_table_city,$item_data)){
                            return true;
                        }
                    }else{
                        return false;
                    }
                }
            }
        }else{//Phần update thông tin thành phố
            /*
           $info_regions_manager = parent::getInformationPerson('jobs_regions','jobs_regions_id',$itemInfo->jobs_regions_id);
           $info_regions_insert = parent::getInformationPerson('jobs_regions','jobs_regions_id',$item_data['jobs_regions_id']);*/
          /*  if($info_regions_manager->person_id == $info_regions_insert->person_id){*/
                $itemInfo = parent::getInformationPerson('jobs_city','jobs_city_id',$jobs_city_id);
                $itemInfoId = parent::getInformationPerson('jobs_regions','person_id',$item_data['person_id']);
                $itemInfoManager = parent::getInformationPerson('jobs_regions','person_id',$itemInfo->person_id);

                if(count($itemInfoId) > 0){
                    $itemOne = parent::getTable('jobs_regions','jobs_regions_id',$item_data['jobs_regions_id'],$item_data['person_id']);
                    if($itemOne == 1){
                        //Thực hiện update thông tin
                        $item = parent::getInformationPerson('jobs_city','jobs_city_id',$jobs_city_id);
                        //Kiểm tra xem nhân viên quản lý khu vực có còn quản lý 1 thành phố nào khác nữa hay không nếu không thì thực hiện xóa quyền cho quản lý của nhân viên này
                        $_info_one = parent::getInformationPerson('jobs_regions','jobs_regions_id',$item->jobs_regions_id);
                        $items_info = parent::getCountInformation('jobs_city','jobs_city_id',$jobs_city_id,'jobs_regions_id');
                        $dem = 0;
                        foreach($items_info AS $values){
                            $regionsPerson = parent::getInformationPerson('jobs_regions','jobs_regions_id',$values->jobs_regions_id);
                            if($regionsPerson->person_id == $_info_one->person_id){
                                $dem ++;
                            }
                        }
                        if($dem == 0){
                            parent::callDeletePermission('city',$_info_one->person_id);
                        }
                        //Xóa bỏ toàn bộ quyền của nhân viên mới nếu nhân viên không còn làm quản lý của bất thành phố nào nũa
                        $result = parent::getCountInformation('jobs_city','jobs_city_id',$jobs_city_id,'person_id',$item->person_id);
                        if($result == 0){
                            if(count($itemInfoManager) > 0){
                                parent::callDeletePermission('city',$item->person_id);
                                parent::callDeletePermission('employees',$item->person_id);
                            }else{
                                parent::updateEmployees(0,$item->person_id);
                                parent::callDeletePermission('city',$item->person_id);
                                parent::callDeletePermission('employees',$item->person_id);
                           }

                        }
                        //Lấy toàn bộ person_id quản lý chi nhánh thuộc thành phố đang thực hiên update người quản lý mới cho chi nhánh con của thành phố
                        $person_id_city = parent::getInformationPerson('jobs_affiliates','jobs_city_id',$jobs_city_id,1);
                        parent::updateEmployees($item_data['person_id'],$person_id_city);
                        //Thực hiện insert thông tin nhân viên và quyền của người đó cho thành phố
                        parent::callInsertPermission('city',$item_data['person_id'],1);
                        parent::callInsertPermission('employees',$item_data['person_id'],1);

                        $this->db->where('jobs_city_id', $jobs_city_id);
                        return $this->db->update($this->_table_city,$item_data);
                    }else{
                        return false;
                    }
                }else{
                    $item = parent::getInformationPerson('jobs_city','jobs_city_id',$jobs_city_id);
                    /*
                     * Kiểm tra xem còn có 1 thành phố nào thuộc khu vực này nữa không
                     * nếu không thì xóa bỏ quyền cảu người quản lý khu vực đối với thành phố
                     * */
                    $_info_one = parent::getInformationPerson('jobs_regions','jobs_regions_id',$item->jobs_regions_id);
                    $items_info = parent::getCountInformation('jobs_city','jobs_city_id',$jobs_city_id,'jobs_regions_id');
                    $dem = 0;
                    foreach($items_info AS $values){
                        $regionsPerson = parent::getInformationPerson('jobs_regions','jobs_regions_id',$values->jobs_regions_id);
                        if($regionsPerson->person_id == $_info_one->person_id){
                            $dem ++;
                        }
                    }
                    if($dem == 0){
                        parent::callDeletePermission('city',$_info_one->person_id);
                    }
                    /*
                     * Khi thực hiện việc update nhân viên quản lý thành phố nếu nhân viên này không còn quản lý bất cứ
                     * thành phố nào khác thì chúng ta thực hiện xóa bỏ quyền của nhân viên này
                     * */
                    $itemInfoOne = parent::getInformationPerson('jobs_regions','person_id',$item->person_id);
                    $result = parent::getCountInformation('jobs_city','jobs_city_id',$jobs_city_id,'person_id',$item->person_id);
                    if($result == 0){
                        if(count($itemInfoOne) > 0){
                            parent::callDeletePermission('city',$item->person_id);
                        }else{
                            parent::updateEmployees(0,$item->person_id);
                            parent::callDeletePermission('city',$item->person_id);
                            parent::callDeletePermission('employees',$item->person_id);
                        }
                    }
                    //Lấy toàn bộ person_id quản lý chi nhánh thuộc thành phố đang thực hiên update người quản lý mới cho chi nhánh con của thành phố
                    $person_id_city = parent::getInformationPerson('jobs_affiliates','jobs_city_id',$jobs_city_id,1);
                    parent::updateEmployees($item_data['person_id'],$person_id_city);
                    //Hàm thực hiện xóa bỏ quyền quản lý nhân viên cũ update lại quyền cho nhân viên mới
                    $_info = parent::getInformationPerson('jobs_regions','jobs_regions_id',$item_data['jobs_regions_id']);
                    if(count($itemInfoOne) > 0){
                        parent::updateEmployees($_info->person_id,$item_data['person_id']);
                        parent::callInsertPermission('city',$_info->person_id,1);
                        parent::callInsertPermission('city',$item_data['person_id'],0);
                    }else{
                        parent::updateEmployees($_info->person_id,$item_data['person_id']);
                        parent::callInsertPermission('city',$_info->person_id,1);
                        parent::callInsertPermission('employees',$item_data['person_id'],1);
                        parent::callInsertPermission('city',$item_data['person_id'],0);
                    }

                    $this->db->where('jobs_city_id', $jobs_city_id);
                    return $this->db->update($this->_table_city,$item_data);
                }
          /*}*/
        }
        return false;
    }

    function delete_list2($city_id = -1,$regions_id = '')
    {
        if(empty($regions_id)){
            $this->db->trans_start();
            $dem = 0;
            if(is_array($city_id)){
                foreach($city_id AS $values){
                 /*
                * Xủ lý xóa bỏ thông tin mảng thành viên khi xóa thông tin khu vực thì xóa bỏ toàn bộ quyền của nhân viên với khu vực đó
                * */
                    $items = parent::getInformationPerson('jobs_city','jobs_city_id',$values);
                    $itemsRegions = parent::getInformationPerson('jobs_regions','person_id',$items->person_id);
                    $result = parent::getCountInformation('jobs_city','jobs_city_id',$values,'person_id',$items->person_id);
                    $_info_one = parent::getInformationPerson('jobs_regions','jobs_regions_id',$items->jobs_regions_id);
                    $items_info = parent::getCountInformation('jobs_city','jobs_city_id',$values,'jobs_regions_id');
                    if(is_array($items_info)){
                        foreach($items_info AS $v){
                            $regionsPerson = parent::getInformationPerson('jobs_regions','jobs_regions_id',$v->jobs_regions_id);
                            if($regionsPerson->person_id == $_info_one->person_id){
                                $dem ++;
                            }
                        }
                    }
                    if($dem == 0){
                        parent::callDeletePermission('city',$_info_one->person_id);
                    }
                    if($result == 0){
                        if(count($itemsRegions) > 0){
                            parent::callDeletePermission('city',$items->person_id);
                        }else{
                            parent::updateEmployees(0,$items->person_id);
                            parent::callDeletePermission('city',$items->person_id);
                            parent::callDeletePermission('employees',$items->person_id);
                        }
                    }
                }
            }else{

                $items = parent::getInformationPerson('jobs_city','jobs_city_id',$city_id);
                $itemsRegions = parent::getInformationPerson('jobs_regions','person_id',$items->person_id);
                $result = parent::getCountInformation('jobs_city','jobs_city_id',$city_id,'person_id',$items->person_id);
                $_info_one = parent::getInformationPerson('jobs_regions','jobs_regions_id',$items->jobs_regions_id);
                $items_info = parent::getCountInformation('jobs_city','jobs_city_id',$city_id,'jobs_regions_id');
                if(is_array($items_info)){
                    foreach($items_info AS $v){
                        $regionsPerson = parent::getInformationPerson('jobs_regions','jobs_regions_id',$v->jobs_regions_id);
                        if($regionsPerson->person_id == $_info_one->person_id){
                            $dem ++;
                        }
                    }
                }
                if($dem == 0){
                    parent::callDeletePermission('city',$_info_one->person_id);
                }
                if($result == 0){
                    if(count($itemsRegions) > 0){
                        parent::callDeletePermission('city',$items->person_id);
                    }else{
                        parent::updateEmployees(0,$items->person_id);
                        parent::callDeletePermission('city',$items->person_id);
                        parent::callDeletePermission('employees',$items->person_id);
                    }
                }
            }
            $this->db->where_in('jobs_city_id',$city_id);

            if($this->db->delete($this->_table_city)){
                $this->db->trans_complete();
                return true;
            }else{
                $this->db->trans_complete();
                return false;
            }
        }else{
            $this->db->trans_start();
            $dem = 0;
            $city_id = parent::getInformationPerson('jobs_city','jobs_regions_id',$regions_id);

            if(is_array($city_id)){
                foreach($city_id AS $values){
                    /*
                   * Xủ lý xóa bỏ thông tin mảng thành viên khi xóa thông tin khu vực thì xóa bỏ toàn bộ quyền của nhân viên với khu vực đó
                   * */
                    $items = parent::getInformationPerson('jobs_city','jobs_city_id',$values->jobs_city_id);
                    $itemsRegions = parent::getInformationPerson('jobs_regions','person_id',$items->person_id);
                    $result = parent::getCountInformation('jobs_city','jobs_city_id',$values->jobs_city_id,'person_id',$items->person_id);
                    $_info_one = parent::getInformationPerson('jobs_regions','jobs_regions_id',$items->jobs_regions_id);
                    $items_info = parent::getCountInformation('jobs_city','jobs_city_id',$values->jobs_city_id,'jobs_regions_id');

                    foreach($items_info AS $v){
                        $regionsPerson = parent::getInformationPerson('jobs_regions','jobs_regions_id',$v->jobs_regions_id);
                        if($regionsPerson->person_id == $_info_one->person_id){
                            $dem ++;
                        }
                    }
                    if($dem == 0){
                        parent::callDeletePermission('city',$_info_one->person_id);
                    }
                    if($result == 0){
                        if(count($itemsRegions) > 0){
                            parent::callDeletePermission('city',$items->person_id);
                        }else{
                            parent::updateEmployees(0,$items->person_id);
                            parent::callDeletePermission('city',$items->person_id);
                            parent::callDeletePermission('employees',$items->person_id);
                        }
                    }
                }
            }else{
                $items = parent::getInformationPerson('jobs_city','jobs_city_id',$city_id->jobs_city_id);
                $itemsRegions = parent::getInformationPerson('jobs_regions','person_id',$items->person_id);
                $result = parent::getCountInformation('jobs_city','jobs_city_id',$city_id->jobs_city_id,'person_id',$items->person_id);
                $_info_one = parent::getInformationPerson('jobs_regions','jobs_regions_id',$items->jobs_regions_id);
                $items_info = parent::getCountInformation('jobs_city','jobs_city_id',$city_id->jobs_city_id,'jobs_regions_id');
                foreach($items_info AS $v){
                    $regionsPerson = parent::getInformationPerson('jobs_regions','jobs_regions_id',$v->jobs_regions_id);
                    if($regionsPerson->person_id == $_info_one->person_id){
                        $dem ++;
                    }
                }
                if($dem == 0){
                    parent::callDeletePermission('city',$_info_one->person_id);
                }
                if($result == 0){
                    if(count($itemsRegions) > 0){
                        parent::callDeletePermission('city',$items->person_id);
                    }else{
                        parent::updateEmployees(0,$items->person_id);
                        parent::callDeletePermission('city',$items->person_id);
                        parent::callDeletePermission('employees',$items->person_id);
                    }
                }
            }
            $this->db->where_in('jobs_regions_id',$regions_id);

            if($this->db->delete($this->_table_city)){
                $this->Jobs_affiliates->delete_list('',$city_id);
                $this->db->trans_complete();
                return true;
            }else{
                $this->db->trans_complete();
                return false;
            }
        }
    }
    
    //hung audi
	public function save(&$item_data,$jobs_city_id = -1)
    {
        $region_info = parent::getInformationPerson('jobs_regions','jobs_regions_id',$item_data['jobs_regions_id']);
        $checkPerson = parent::getInformationPerson('jobs_city','person_id',$item_data['person_id']);
        //3. Trong trường hợp nhân viên quản lý thành phố chính là nhân viên đang quản lý 1 thành phố khác
        //Kiểm tra xem thông tin nhân viên nhân viên có quản lý
        $city_info = parent::getInformationPerson('jobs_city','person_id',$item_data['person_id']);

        if($jobs_city_id == -1){//Phần thêm mới thông tin thành phố
            $itemInfoId = parent::getInformationPerson('jobs_regions','person_id',$item_data['person_id']);
            if(count($itemInfoId) > 0){
                $itemOne = parent::getTable('jobs_regions','jobs_regions_id',$item_data['jobs_regions_id'],$item_data['person_id']);
                if($itemOne == 1){
                    //parent::callInsertPermission('city',$item_data['person_id'],1);
                    parent::callInsertPermission('affiliates',$item_data['person_id'],1);
                    parent::callInsertPermission('department',$item_data['person_id'],1);
                     
                    if($this->db->insert($this->_table_city,$item_data)){
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
                //2.Insert toàn quyền cho nhân viên quản lý khu vực
                //parent::callInsertPermission('city',$region_info->person_id,1);
                parent::callInsertPermission('affiliates',$region_info->person_id,1);
                parent::callInsertPermission('department',$region_info->person_id,1);
                
                parent::callInsertPermission('employees',$item_data['person_id'],1);
                //1.Thực hiện insert quyền xem (search) cho nhân viên quản lý thành phố này
                //parent::callInsertPermission('city',$item_data['person_id'],0);
                parent::callInsertPermission('affiliates',$item_data['person_id'],1);
                parent::callInsertPermission('department',$item_data['person_id'],1);
                
                if($this->db->insert($this->_table_city,$item_data)){
                    return true;
                }
            }else{
                $city_info_one = parent::getOneInformationPerson('jobs_city','jobs_regions_id','person_id',$item_data['person_id']);
                if($city_info_one->jobs_regions_id == $item_data['jobs_regions_id']){
                    /*
                       * Thực hiện insert binh thường vào table city do nhân viên quản lý khu vực
                       *  đã tồn tại tức đã có quyền thực hiện trên thành phố
                       * */
                    if($this->db->insert($this->_table_city,$item_data)){
                        return true;
                    }
                }else{
                    /*
                     * Thực hiện lấy id 2 người quản lý khu vực này và tiến hành so sánh nếu chúng trùng nhau thì thực hiện thêm mới thông tin
                     * */
                    $info_regions_manager = parent::getInformationPerson('jobs_regions','jobs_regions_id',$city_info_one->jobs_regions_id);
                    $info_regions_insert = parent::getInformationPerson('jobs_regions','jobs_regions_id',$item_data['jobs_regions_id']);
                    if($info_regions_insert->person_id == $info_regions_manager->person_id ){
                        if($this->db->insert($this->_table_city,$item_data)){
                            return true;
                        }
                    }else{
                        return false;
                    }
                }
            }
        }else{//Phần update thông tin thành phố
            /*
           $info_regions_manager = parent::getInformationPerson('jobs_regions','jobs_regions_id',$itemInfo->jobs_regions_id);
           $info_regions_insert = parent::getInformationPerson('jobs_regions','jobs_regions_id',$item_data['jobs_regions_id']);*/
          /*  if($info_regions_manager->person_id == $info_regions_insert->person_id){*/
                $itemInfo = parent::getInformationPerson('jobs_city','jobs_city_id',$jobs_city_id);
                $itemInfoId = parent::getInformationPerson('jobs_regions','person_id',$item_data['person_id']);
                $itemInfoManager = parent::getInformationPerson('jobs_regions','person_id',$itemInfo->person_id);

                if(count($itemInfoId) > 0){
                    $itemOne = parent::getTable('jobs_regions','jobs_regions_id',$item_data['jobs_regions_id'],$item_data['person_id']);
                    if($itemOne == 1){
                        //Thực hiện update thông tin
                        $item = parent::getInformationPerson('jobs_city','jobs_city_id',$jobs_city_id);
                        //Kiểm tra xem nhân viên quản lý khu vực có còn quản lý 1 thành phố nào khác nữa hay không nếu không thì thực hiện xóa quyền cho quản lý của nhân viên này
                        $_info_one = parent::getInformationPerson('jobs_regions','jobs_regions_id',$item->jobs_regions_id);
                        $items_info = parent::getCountInformation('jobs_city','jobs_city_id',$jobs_city_id,'jobs_regions_id');
                        $dem = 0;
                        foreach($items_info AS $values){
                            $regionsPerson = parent::getInformationPerson('jobs_regions','jobs_regions_id',$values->jobs_regions_id);
                            if($regionsPerson->person_id == $_info_one->person_id){
                                $dem ++;
                            }
                        }
                        if($dem == 0){
                            //parent::callDeletePermission('city',$_info_one->person_id);
                            parent::callDeletePermission('affiliates',$_info_one->person_id);
                            parent::callDeletePermission('department',$_info_one->person_id);
                        }
                        //Xóa bỏ toàn bộ quyền của nhân viên mới nếu nhân viên không còn làm quản lý của bất thành phố nào nũa
                        $result = parent::getCountInformation('jobs_city','jobs_city_id',$jobs_city_id,'person_id',$item->person_id);
                        if($result == 0){
                            if(count($itemInfoManager) > 0){
                                //parent::callDeletePermission('city',$item->person_id);
                                parent::callDeletePermission('affiliates',$item->person_id);
                                parent::callDeletePermission('department',$item->person_id);
                                parent::callDeletePermission2('employees',$item->person_id);
                            }else{
                                parent::updateEmployees(0,$item->person_id);
                                //parent::callDeletePermission('city',$item->person_id);
                                parent::callDeletePermission('affiliates',$item->person_id);
                                parent::callDeletePermission('department',$item->person_id);
                                parent::callDeletePermission2('employees',$item->person_id);
                           }

                        }
                        //Lấy toàn bộ person_id quản lý chi nhánh thuộc thành phố đang thực hiên update người quản lý mới cho chi nhánh con của thành phố
                        $person_id_city = parent::getInformationPerson('jobs_affiliates','jobs_city_id',$jobs_city_id,1);
                        parent::updateEmployees($item_data['person_id'],$person_id_city);
                        //Thực hiện insert thông tin nhân viên và quyền của người đó cho thành phố
                        //parent::callInsertPermission('city',$item_data['person_id'],1);
                        parent::callInsertPermission('affiliates',$item_data['person_id'],1);
                        parent::callInsertPermission('department',$item_data['person_id'],1);
                        parent::callInsertPermission('employees',$item_data['person_id'],1);

                        $this->db->where('jobs_city_id', $jobs_city_id);
                        return $this->db->update($this->_table_city,$item_data);
                    }else{
                        return false;
                    }
                }else{
                    $item = parent::getInformationPerson('jobs_city','jobs_city_id',$jobs_city_id);
                    /*
                     * Kiểm tra xem còn có 1 thành phố nào thuộc khu vực này nữa không
                     * nếu không thì xóa bỏ quyền cảu người quản lý khu vực đối với thành phố
                     * */
                    $_info_one = parent::getInformationPerson('jobs_regions','jobs_regions_id',$item->jobs_regions_id);
                    $items_info = parent::getCountInformation('jobs_city','jobs_city_id',$jobs_city_id,'jobs_regions_id');
                    $dem = 0;
                    foreach($items_info AS $values){
                        $regionsPerson = parent::getInformationPerson('jobs_regions','jobs_regions_id',$values->jobs_regions_id);
                        if($regionsPerson->person_id == $_info_one->person_id){
                            $dem ++;
                        }
                    }
                    if($dem == 0){
                        //parent::callDeletePermission('city',$_info_one->person_id);
                        parent::callDeletePermission('affiliates',$_info_one->person_id);
                        parent::callDeletePermission('department',$_info_one->person_id);
                    }
                    /*
                     * Khi thực hiện việc update nhân viên quản lý thành phố nếu nhân viên này không còn quản lý bất cứ
                     * thành phố nào khác thì chúng ta thực hiện xóa bỏ quyền của nhân viên này
                     * */
                    $itemInfoOne = parent::getInformationPerson('jobs_regions','person_id',$item->person_id);
                    $result = parent::getCountInformation('jobs_city','jobs_city_id',$jobs_city_id,'person_id',$item->person_id);
                    if($result == 0){
                        if(count($itemInfoOne) > 0){
                            //parent::callDeletePermission('city',$item->person_id);
                            parent::callDeletePermission('affiliates',$item->person_id);
                            parent::callDeletePermission('department',$item->person_id);
                            
                        }else{
                            parent::updateEmployees(0,$item->person_id);
                            //parent::callDeletePermission('city',$item->person_id);
                            parent::callDeletePermission('affiliates',$item->person_id);
                            parent::callDeletePermission('department',$item->person_id);
                            parent::callDeletePermission2('employees',$item->person_id);
                        }
                    }
                    //Lấy toàn bộ person_id quản lý chi nhánh thuộc thành phố đang thực hiên update người quản lý mới cho chi nhánh con của thành phố
                    $person_id_city = parent::getInformationPerson('jobs_affiliates','jobs_city_id',$jobs_city_id,1);
                    parent::updateEmployees($item_data['person_id'],$person_id_city);
                    //Hàm thực hiện xóa bỏ quyền quản lý nhân viên cũ update lại quyền cho nhân viên mới
                    $_info = parent::getInformationPerson('jobs_regions','jobs_regions_id',$item_data['jobs_regions_id']);
                    if(count($itemInfoOne) > 0){
                        parent::updateEmployees($_info->person_id,$item_data['person_id']);
                        //parent::callInsertPermission('city',$_info->person_id,1);
                        parent::callInsertPermission('affiliates',$_info->person_id,1);
                        parent::callInsertPermission('department',$_info->person_id,1);
                        
                        //parent::callInsertPermission('city',$item_data['person_id'],0);
                        parent::callInsertPermission('affiliates',$item_data['person_id'],1);
                        parent::callInsertPermission('department',$item_data['person_id'],1);
                    }else{
                        parent::updateEmployees($_info->person_id,$item_data['person_id']);
                        //parent::callInsertPermission('city',$_info->person_id,1);
                        parent::callInsertPermission('affiliates',$_info->person_id,1);
                        parent::callInsertPermission('department',$_info->person_id,1);
                        
                        //parent::callInsertPermission('city',$item_data['person_id'],0);
                        parent::callInsertPermission('affiliates',$item_data['person_id'],1);
                        parent::callInsertPermission('department',$item_data['person_id'],1);
                        
                        parent::callInsertPermission('employees',$item_data['person_id'],1);
                    }

                    $this->db->where('jobs_city_id', $jobs_city_id);
                    return $this->db->update($this->_table_city,$item_data);
                }
          /*}*/
        }
        return false;
    }

    function delete_list($city_id = -1,$regions_id = '')
    {
        if(empty($regions_id)){
            $this->db->trans_start();
            $dem = 0;
            if(is_array($city_id)){//nhieu id
                foreach($city_id AS $values){
                 /*
                * Xủ lý xóa bỏ thông tin mảng thành viên khi xóa thông tin khu vực thì xóa bỏ toàn bộ quyền của nhân viên với khu vực đó
                * */
                    $items = parent::getInformationPerson('jobs_city','jobs_city_id',$values);
                    $itemsRegions = parent::getInformationPerson('jobs_regions','person_id',$items->person_id);
                    $result = parent::getCountInformation('jobs_city','jobs_city_id',$values,'person_id',$items->person_id);
                    $_info_one = parent::getInformationPerson('jobs_regions','jobs_regions_id',$items->jobs_regions_id);
                    $items_info = parent::getCountInformation('jobs_city','jobs_city_id',$values,'jobs_regions_id');
                    if(is_array($items_info)){
                        foreach($items_info AS $v){
                            $regionsPerson = parent::getInformationPerson('jobs_regions','jobs_regions_id',$v->jobs_regions_id);
                            if($regionsPerson->person_id == $_info_one->person_id){
                                $dem ++;
                            }
                        }
                    }
                    if($dem == 0){
                        //parent::callDeletePermission('city',$_info_one->person_id);
                        parent::callDeletePermission('affiliates',$_info_one->person_id);
                        parent::callDeletePermission('department',$_info_one->person_id);
                    }
                    if($result == 0){
                        if(count($itemsRegions) > 0){
                            //parent::callDeletePermission('city',$items->person_id);
                            parent::callDeletePermission('affiliates',$items->person_id);
                            parent::callDeletePermission('department',$items->person_id);
                        }else{
                            parent::updateEmployees(0,$items->person_id);
                            //parent::callDeletePermission('city',$items->person_id);
                            parent::callDeletePermission('affiliates',$items->person_id);
                            parent::callDeletePermission('department',$items->person_id);
                            parent::callDeletePermission2('employees',$items->person_id);
                        }
                    }
                }
            }else{

                $items = parent::getInformationPerson('jobs_city','jobs_city_id',$city_id);
                $itemsRegions = parent::getInformationPerson('jobs_regions','person_id',$items->person_id);
                $result = parent::getCountInformation('jobs_city','jobs_city_id',$city_id,'person_id',$items->person_id);
                $_info_one = parent::getInformationPerson('jobs_regions','jobs_regions_id',$items->jobs_regions_id);
                $items_info = parent::getCountInformation('jobs_city','jobs_city_id',$city_id,'jobs_regions_id');
                if(is_array($items_info)){
                    foreach($items_info AS $v){
                        $regionsPerson = parent::getInformationPerson('jobs_regions','jobs_regions_id',$v->jobs_regions_id);
                        if($regionsPerson->person_id == $_info_one->person_id){
                            $dem ++;
                        }
                    }
                }
                if($dem == 0){
                    parent::callDeletePermission('city',$_info_one->person_id);
                }
                if($result == 0){
                    if(count($itemsRegions) > 0){
                        //parent::callDeletePermission('city',$items->person_id);
                        parent::callDeletePermission('affiliates',$items->person_id);
                        parent::callDeletePermission('department',$items->person_id);
                    }else{
                        parent::updateEmployees(0,$items->person_id);
                       //parent::callDeletePermission('city',$items->person_id);
                        parent::callDeletePermission('affiliates',$items->person_id);
                        parent::callDeletePermission('department',$items->person_id);
                        parent::callDeletePermission2('employees',$items->person_id);
                    }
                }
            }
            $this->db->where_in('jobs_city_id',$city_id);

            if($this->db->delete($this->_table_city)){
                $this->db->trans_complete();
                return true;
            }else{
                $this->db->trans_complete();
                return false;
            }
        }else{// 1 id
            $this->db->trans_start();
            $dem = 0;
            $city_id = parent::getInformationPerson('jobs_city','jobs_regions_id',$regions_id);

            if(is_array($city_id)){
                foreach($city_id AS $values){
                    /*
                   * Xủ lý xóa bỏ thông tin mảng thành viên khi xóa thông tin khu vực thì xóa bỏ toàn bộ quyền của nhân viên với khu vực đó
                   * */
                    $items = parent::getInformationPerson('jobs_city','jobs_city_id',$values->jobs_city_id);
                    $itemsRegions = parent::getInformationPerson('jobs_regions','person_id',$items->person_id);
                    $result = parent::getCountInformation('jobs_city','jobs_city_id',$values->jobs_city_id,'person_id',$items->person_id);
                    $_info_one = parent::getInformationPerson('jobs_regions','jobs_regions_id',$items->jobs_regions_id);
                    $items_info = parent::getCountInformation('jobs_city','jobs_city_id',$values->jobs_city_id,'jobs_regions_id');

                    foreach($items_info AS $v){
                        $regionsPerson = parent::getInformationPerson('jobs_regions','jobs_regions_id',$v->jobs_regions_id);
                        if($regionsPerson->person_id == $_info_one->person_id){
                            $dem ++;
                        }
                    }
                    if($dem == 0){
                        //parent::callDeletePermission('city',$_info_one->person_id);
                        parent::callDeletePermission('affiliates',$_info_one->person_id);
                        parent::callDeletePermission('department',$_info_one->person_id);
                    }
                    if($result == 0){
                        if(count($itemsRegions) > 0){
                            //parent::callDeletePermission('city',$items->person_id);
                            parent::callDeletePermission('affiliates',$items->person_id);
                            parent::callDeletePermission('department',$items->person_id);
                        }else{
                            parent::updateEmployees(0,$items->person_id);
                            //parent::callDeletePermission('city',$items->person_id);
                            parent::callDeletePermission('affiliates',$items->person_id);
                            parent::callDeletePermission('department',$items->person_id);
                            parent::callDeletePermission2('employees',$items->person_id);
                        }
                    }
                }
            }else{
                $items = parent::getInformationPerson('jobs_city','jobs_city_id',$city_id->jobs_city_id);
                $itemsRegions = parent::getInformationPerson('jobs_regions','person_id',$items->person_id);
                $result = parent::getCountInformation('jobs_city','jobs_city_id',$city_id->jobs_city_id,'person_id',$items->person_id);
                $_info_one = parent::getInformationPerson('jobs_regions','jobs_regions_id',$items->jobs_regions_id);
                $items_info = parent::getCountInformation('jobs_city','jobs_city_id',$city_id->jobs_city_id,'jobs_regions_id');
                foreach($items_info AS $v){
                    $regionsPerson = parent::getInformationPerson('jobs_regions','jobs_regions_id',$v->jobs_regions_id);
                    if($regionsPerson->person_id == $_info_one->person_id){
                        $dem ++;
                    }
                }
                if($dem == 0){
                    //parent::callDeletePermission('city',$_info_one->person_id);
                    parent::callDeletePermission('affiliates',$_info_one->person_id);
                    parent::callDeletePermission('department',$_info_one->person_id);
                }
                if($result == 0){
                    if(count($itemsRegions) > 0){
                        //parent::callDeletePermission('city',$items->person_id);
                        parent::callDeletePermission('affiliates',$items->person_id);
                        parent::callDeletePermission('department',$items->person_id);
                    }else{
                        parent::updateEmployees(0,$items->person_id);
                        //parent::callDeletePermission('city',$items->person_id);
                        parent::callDeletePermission('affiliates',$items->person_id);
                        parent::callDeletePermission('department',$items->person_id);
                        parent::callDeletePermission2('employees',$items->person_id);
                    }
                }
            }
            $this->db->where_in('jobs_regions_id',$regions_id);

            if($this->db->delete($this->_table_city)){
                $this->Jobs_affiliates->delete_list('',$city_id);
                $this->db->trans_complete();
                return true;
            }else{
                $this->db->trans_complete();
                return false;
            }
        }
    }
    
    
    function checkRegionsName($city_name,$city_id)
    {
        if(empty($city_id) OR $city_id == -1){
            $this->db->where('jobs_city_name LIKE "'.$this->db->escape_like_str($city_name).'"');
        }else{
            $this->db->where("jobs_city_name LIKE '".$this->db->escape_like_str($city_name)."' AND jobs_city_id != ".$city_id);
        }

        $result = $this->db->get($this->_table_city);
 
        return $result->num_rows();
    } 
    
//hung audi 28-3

	function get_all($jobs_regions_id,$person_id,$limit = 10000, $offset =0, $col ='jobs_city_name',$order = 'DESC')
    {//die($jobs_regions_id);
    	if( $person_id == 1){
    		$data = parent::getPersonId($person_id);
        	$sql = "SELECT c.*,p.first_name FROM ".$this->_table_city." c INNER JOIN ".$this->_table_people. " p ON c.person_id=p.person_id 
        		WHERE c.person_id IN($data) 
        		ORDER BY ".$col." ".$order." LIMIT $offset,$limit ";
    	}else{
 	        $data = parent::getPersonId($person_id);
	        $sql = "SELECT c.*,p.first_name FROM ".$this->_table_city." c INNER JOIN ".$this->_table_people. " p ON c.person_id=p.person_id 
	        	WHERE c.jobs_regions_id = $jobs_regions_id
	        	ORDER BY ".$col." ".$order." LIMIT $offset,$limit ";
    	}
        $data = $this->db->query($sql);
        return $data;
    }
    public function count_all($jobs_regions_id, $person_id)
    {
    	if( $person_id == 1){
	        $data = parent::getPersonId($person_id);
	        $this->db->where_in($data);
	        $this->db->from($this->_table_city);
    	}else{
 	        $this->db->from($this->_table_city);
 	        $this->db->where("jobs_regions_id", $jobs_regions_id);
    	}

        return $this->db->count_all_results();

    }
    /*
     Get search suggestions to find status
     */
   function get_search_suggestions($jobs_regions_id, $person_id,$search,$limit=10000)
    {
    	if( $person_id == 1){
	        $this->db->from($this->_table_city);
	        $this->db->like("jobs_city_name",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
	        $this->db->order_by("jobs_city_name", "DESC");
    	}else{
    		$this->db->from($this->_table_city);
	        $this->db->where("jobs_regions_id", $jobs_regions_id);
	        $this->db->like("jobs_city_name",$search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
	        $this->db->order_by("jobs_city_name", "DESC");
    		
    	}
        $by_jobs_name = $this->db->get();
        foreach($by_jobs_name->result() as $row)
        {
            $suggestions[]=array('label'=> $row->jobs_city_name);
        }

        //only return $limit suggestions
         //begin dungbv
                $this->db->from($this->_table_city);
                $this->db->join('people','jobs_city.person_id=people.person_id','inner');
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
    function search($jobs_regions_id, $person_id,$search, $limit=50,$offset=0,$column='jobs_city_name',$orderby='ASC')
    {
        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->from($this->_table_city);
            $this->db->join('people','jobs_city.person_id=people.person_id','inner');
            $this->db->where("jobs_city_name LIKE '%".$this->db->escape_like_str($search)."%' or CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%'");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);

            return $this->db->get();
        }
        else
        {
        	if( $person_id == 1){
        		$this->db->from($this->_table_city);
                        $this->db->join('people','jobs_city.person_id=people.person_id','inner');
	            $this->db->where("jobs_city_name LIKE '%".$this->db->escape_like_str($search)."%'  or CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%'");
	            $this->db->order_by($column, $orderby);
	            $this->db->limit($limit);
	            $this->db->offset($offset);
        	}else{
        		$this->db->from($this->_table_city);
                        $this->db->join('people','jobs_city.person_id=people.person_id','inner');

	            $this->db->where("jobs_city_name LIKE '%".$this->db->escape_like_str($search)."%'  or CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%'");
	            $this->db->where("jobs_regions_id", $jobs_regions_id);
	            $this->db->order_by($column, $orderby);
	            $this->db->limit($limit);
	            $this->db->offset($offset);
        	}
            return $this->db->get();
        }
    }


    function search_count_all($jobs_regions_id, $person_id,$search, $limit=10000)
    {
        if ($this->config->item('speed_up_search_queries'))
        {
            $this->db->from($this->_table_city);
            $this->db->where("jobs_city_name LIKE '%".$this->db->escape_like_str($search)."%'");
            $this->db->order_by("jobs_city_name", "DESC");

            $result=$this->db->get();
            return $result->num_rows();
        }
        else
        {
        	if( $person_id == 1){
	            $this->db->from($this->_table_city);
	            $this->db->where("jobs_city_name LIKE '%".$this->db->escape_like_str($search)."%'");
	            $this->db->order_by("jobs_city_name", "DESC");
        	}else{
        		$this->db->from($this->_table_city);
	            $this->db->where("jobs_regions_id", $jobs_regions_id);
	            $this->db->where("jobs_city_name LIKE '%".$this->db->escape_like_str($search)."%'");
	            $this->db->order_by("jobs_city_name", "DESC");
        	}
            $result=$this->db->get();
            return $result->num_rows();
        }
    }
    function get_city_id($person_id)
    {
        $sql = "SELECT * FROM ".$this->_table_city. "
                WHERE person_id = ".$person_id;
        $query = $this->db->query($sql);
    	return $query;
    }
	
}

