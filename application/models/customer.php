<?php

class Customer extends Person {

    //check trùng tên
    function getname($id) {
        if ($id > 0) {
            $this->db->select('people.first_name');
            $this->db->where('customers.person_id !=', $id);
            $this->db->where('customers.deleted', 0);
            $this->db->join('people', 'people.person_id = customers.person_id');
            $this->db->from('customers');
            $query = $this->db->get();
        } elseif ($id = -1) {
            $this->db->select('people.first_name');
            $this->db->where('deleted', 0);
            $this->db->join('people', 'people.person_id = customers.person_id');
            $this->db->from('customers');
            $query = $this->db->get();
        }
        foreach ($query->result_array() as $q) {
            $result[] = $q;
        }
        return $result;
    }

    /*
      Inserts or updates a customer
     */

    function save(&$person_data, &$customer_data, $customer_id = false) {
        $success = false;
        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();
        if (parent::save($person_data, $customer_id)) {
            if (!$customer_id or ! $this->exists($customer_id)) {
                $customer_data['person_id'] = $person_data['person_id'];
                $success = $this->db->insert('customers', $customer_data);
            } else {
                $this->db->where('person_id', $customer_id);
                $success = $this->db->update('customers', $customer_data);
            }
        }

        $this->db->trans_complete();
        return $success;
    }

    /*
      Determines if a given person_id is a customer
     */

    function get_city($data) {
        $this->db->where('id_city', $data);
        $query = $this->db->get('cities');
        return $query->result_array();
    }

    function finddateregister() {
        $this->db->from('people');
        $this->db->join('customers', 'customers.person_id = people.person_id');
        $this->db->where('year(register_date)', date('Y'));
        $this->db->where('month(register_date)', date('m'));
        $this->db->where('day(register_date)', date('d'));
        $this->db->where('deleted', 0);
        //$this->db->order_by('people.name asc');
        $this->db->limit(10);
        $query = $this->db->get();
        return $query->result_array();
    }

    function exists($person_id) {
        $this->db->from('customers');
        $this->db->join('people', 'people.person_id = customers.person_id');
        $this->db->where('deleted', 0);
        $this->db->where('customers.person_id', $person_id);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }

    function account_number_exists($account_number) {
        $this->db->from('customers');
        $this->db->where('account_number', $account_number);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }

    //phan lam
    function findBirthDate() {
        $this->db->from('people');
        $this->db->join('customers', 'customers.person_id = people.person_id');
        $this->db->where('month(birth_date)', date('m'));
        // $this->db->or_where('month(birth_date)-1',date('m'));
        $this->db->where('day(birth_date) >=', date('d'));
        $this->db->where('deleted', 0);
        $this->db->order_by('people.birth_date desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function findBirthPerson($id) {
        $this->db->where_in('person_id', $id);
        // $this->db->order_by('birth_date desc');
        $query = $this->db->get('customers');
        return $query->result_array();
    }

    function findPerson($id) {
        $this->db->where('person_id', $id);
        $query = $this->db->get('people');
        return $query->result_array();
    }

    function findAllItem() {
        $this->db->where('deleted', 0);
        $this->db->where('service', 0);
        $query = $this->db->get('items');
        return $query->result_array();
    }

    //end phan lam
    //phan lam

    function findperinmonth($start_mon, $start_day, $end_mon, $end_day) {
        $this->db->from('customers');
        $this->db->join('people', 'people.person_id = customers.person_id');
        $this->db->where('day(birth_date) >= ', $start_day);
        $this->db->where('day(birth_date) <= ', $end_day);
        return $this->db->get();
    }

    //end phan lam
    /*
      Returns all the customers
     */
//    function get_all($limit=10000, $offset=0,$col='last_name',$order='asc')
//    {
//        $people=$this->db->dbprefix('people');
//        $customers=$this->db->dbprefix('customers');  
//        $data=$this->db->query("SELECT * 
//            FROM ".$people."
//            STRAIGHT_JOIN ".$customers." ON 									                       
//            ".$people.".person_id = ".$customers.".person_id
//            WHERE deleted =0 ORDER BY ".$col." ". $order." 
//            LIMIT  ".$offset.",".$limit);
//        
//        return $data;
//    }    
    //end phan lam
    /*
      Returns all the customers

     */

    function get_all($limit = 10000, $offset = 0, $col = 'lifetek_customers.person_id', $order = 'desc') {
        $people = $this->db->dbprefix('people');
        $customers = $this->db->dbprefix('customers');
        $data = $this->db->query("SELECT * 
            FROM " . $people . "
            STRAIGHT_JOIN " . $customers . " ON 									                       
            " . $people . ".person_id = " . $customers . ".person_id
            WHERE deleted =0 ORDER BY " . $col . " " . $order . " 
            LIMIT  " . $offset . "," . $limit);
        return $data;
    }

    function count_all() {
        $this->db->from('customers');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }

    /*
      Gets information about a particular customer
     */

    function get_option() {
        $this->db->select('id_city,name');
        $query = $this->db->get('cities');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    function get_info($customer_id) {
        $this->db->from('customers');
        $this->db->join('people', 'people.person_id = customers.person_id');
        $this->db->where('customers.person_id', $customer_id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $customer_id is NOT an customer
            $person_obj = parent::get_info(-1);
            //Get all the fields from customer table
            $fields = $this->db->list_fields('customers');
            //append those fields to base parent object, we we have a complete empty object
            foreach ($fields as $field) {
                $person_obj->$field = '';
            }
            return $person_obj;
        }
    }

    // l?y thông tin t? b?ng omc_customer //
    function omc_get_info($customer_id) {
        $this->db->from('omc_customer');
        //$this->db->join('people', 'people.person_id = customers.person_id');
        $this->db->where('omc_customer.customer_id', $customer_id);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $customer_id is NOT an customer
            $person_obj = parent::get_info(-1);

            //Get all the fields from customer table
            $fields = $this->db->list_fields('omc_customer');

            //append those fields to base parent object, we we have a complete empty object
            foreach ($fields as $field) {
                $person_obj->$field = '';
            }

            return $person_obj;
        }
    }

    /*
      Gets information about multiple customers
     */

    function get_multiple_info($customer_ids) {
        $this->db->from('customers');
        $this->db->join('people', 'people.person_id = customers.person_id');
        $this->db->where_in('customers.person_id', $customer_ids);
        $this->db->order_by("last_name", "asc");
        return $this->db->get();
    }

    /*
      Deletes one customer
     */

    function delete($customer_id) {
        $this->db->where('person_id', $customer_id);
        return $this->db->update('customers', array('deleted' => 1));
    }

    /*
      Deletes a list of customers
     */

    function delete_list($customer_ids) {
        $this->db->where_in('person_id', $customer_ids);
        return $this->db->update('customers', array('deleted' => 1));
    }

    public function get_customner_search_suggestions_contract($employee_id, $search, $limit = 25) {
        $suggestions = array();
        $this->db->from('customers');
        $this->db->where('deleted', 0);
        if ($employee_id != 1) {
            $this->db->where('employee_id', $employee_id);
        }
        $this->db->join('people', 'customers.person_id=people.person_id');
        $this->db->like('first_name', $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("first_name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('value' => $row->first_name, 'label' => $row->first_name, 'id' => $row->person_id);
        }
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    /*
      Get search suggestions to find customers
     */

    function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();

        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');

        if ($this->config->item('speed_up_search_queries')) {
            $this->db->where("(first_name LIKE '" . $this->db->escape_like_str($search) . "%' ) and deleted=0");
        } else {
            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' ) and deleted=0");
        }

        $this->db->order_by("first_name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('label' => $row->first_name);
        }

        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("email", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("email", "asc");
        $by_email = $this->db->get();
        foreach ($by_email->result() as $row) {
            $suggestions[] = array('label' => $row->email);
        }

        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("phone_number", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("phone_number", "asc");
        $by_phone = $this->db->get();
        foreach ($by_phone->result() as $row) {
            $suggestions[] = array('label' => $row->phone_number);
        }

        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("account_number", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("account_number", "asc");
        $by_account_number = $this->db->get();
        foreach ($by_account_number->result() as $row) {
            $suggestions[] = array('label' => $row->account_number);
        }

        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("company_name", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("company_name", "asc");
        $by_company_name = $this->db->get();
        foreach ($by_company_name->result() as $row) {
            $suggestions[] = array('label' => $row->company_name);
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    /*
      Get search suggestions to find customers
     */

    function get_customer_search_suggestions($search, $limit = 25) {
        $suggestions = array();

        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');

        if ($this->config->item('speed_up_search_queries')) {
            $this->db->where("(first_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
				CONCAT(`first_name`,' ',`last_name`) LIKE '" . $this->db->escape_like_str($search) . "%') and deleted=0");
        } else {
            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        }
        $this->db->order_by("last_name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            $suggestions[] = array('value' => $row->person_id, 'label' => $row->first_name . ' ' . $row->last_name);
        }

        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("account_number", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("account_number", "asc");
        $by_account_number = $this->db->get();
        foreach ($by_account_number->result() as $row) {
            $suggestions[] = array('value' => $row->person_id, 'label' => $row->account_number);
        }

        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("email", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("email", "asc");
        $by_email = $this->db->get();
        foreach ($by_email->result() as $row) {
            $suggestions[] = array('value' => $row->person_id, 'label' => $row->email);
        }

        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("phone_number", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("phone_number", "asc");
        $by_phone_number = $this->db->get();
        foreach ($by_phone_number->result() as $row) {
            $suggestions[] = array('value' => $row->person_id, 'label' => $row->phone_number);
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    /*
      Preform a search on customers
     */

    function search($search, $type_customer = '', $limit = 20, $offset = 0, $column = 'last_name', $orderby = 'asc') {
        if ($type_customer)
            $type_customer_id = "and type_customer = $type_customer ";
        else
            $type_customer_id = '';
        if ($this->config->item('speed_up_search_queries')) {
            $query = "select * from (
                    (select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
                            , " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
                    from " . $this->db->dbprefix('customers') . "
                    join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
                    where first_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                    order by `" . $column . "` " . $orderby . ") union

                    (select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
                            , " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
                    from " . $this->db->dbprefix('customers') . "
                    join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
                    where last_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                    order by `" . $column . "` " . $orderby . ") union

                    (select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
                            , " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
                    from " . $this->db->dbprefix('customers') . "
                    join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
                    where email like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                    order by `" . $column . "` " . $orderby . ") union

                    (select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
                            , " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
                    from " . $this->db->dbprefix('customers') . "
                    join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
                    where phone_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                    order by `" . $column . "` " . $orderby . ") union

                    (select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
                            , " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
                    from " . $this->db->dbprefix('customers') . "
                    join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
                    where account_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                    order by `" . $column . "` " . $orderby . ") union

                    (select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
                            , " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
                    from " . $this->db->dbprefix('customers') . "
                    join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
                    where CONCAT(`first_name`,' ',`last_name`)  like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
                    order by `" . $column . "` " . $orderby . ")
                    ) as search_results
                    order by `" . $column . "` " . $orderby . " limit " . (int) $offset . "," . $this->db->escape((int) $limit);
            return $this->db->query($query);
        } else {
            $this->db->from('customers');
            $this->db->join('people', 'customers.person_id=people.person_id');
            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                account_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                company_name LIKE '%" . $this->db->escape_like_str($search) . "%' ) $type_customer_id and deleted=0");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);
            return $this->db->get();
        }
    }

    function search_count_all($search, $type_customer = '', $limit = 10000) {
        if ($type_customer)
            $type_customer_id = "and type_customer = $type_customer ";
        else
            $type_customer_id = '';
        if ($this->config->item('speed_up_search_queries')) {
            $query = "
				select *
				from (
		           	(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
					, " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
		           	from " . $this->db->dbprefix('customers') . "
		           	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
		           	where first_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
		           	order by `last_name` asc limit " . $this->db->escape($limit) . ") union

				 	(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
					, " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
		           	from " . $this->db->dbprefix('customers') . "
		           	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
		           	where last_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
		           	order by `last_name` asc limit " . $this->db->escape($limit) . ") union

					(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
					, " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
		         	from " . $this->db->dbprefix('customers') . "
		          	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
		          	where email like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
		          	order by `last_name` asc limit " . $this->db->escape($limit) . ") union

					(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
					, " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
		        	from " . $this->db->dbprefix('customers') . "
		        	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
		        	where phone_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
		        	order by `last_name` asc limit " . $this->db->escape($limit) . ") union

					(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
					, " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
		      		from " . $this->db->dbprefix('customers') . "
		      		join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
		      		where account_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
		      		order by `last_name` asc limit " . $this->db->escape($limit) . ") union

					(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
					, " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
		    		from " . $this->db->dbprefix('customers') . "
		    		join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
		    		where CONCAT(`first_name`,' ',`last_name`)  like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
		    		order by `last_name` asc limit " . $this->db->escape($limit) . ")
				) as search_results
				order by `last_name` asc limit " . $this->db->escape($limit);
            $result = $this->db->query($query);
            return $result->num_rows();
        } else {
            $this->db->from('customers');
            $this->db->join('people', 'customers.person_id=people.person_id');
            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			account_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			company_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') $type_customer_id and deleted=0");
            $this->db->order_by("last_name", "asc");
            $this->db->limit($limit);
            $result = $this->db->get();
            return $result->num_rows();
        }
    }

    function find_code_city($start_date, $end_date) {
        $this->db->select('id_city_code');
        $this->db->distinct('id_city_code');
        $this->db->where('id_city_code > ', 0);
        $this->db->where('deleted', 0);
        $this->db->where('date >= ', $start_date);
        $this->db->where('date <= ', $end_date);
        $result = $this->db->get('sales_inventory');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }

    function find_customer111($code_city) {
        $this->db->select('id_customer');
        $this->db->distinct('id_customer');
        $this->db->where('id_city_code', $code_city);
        $this->db->where('deleted', 0);
        $result = $this->db->get('sales_inventory');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }

    function find_customer($code_city, $start_date, $end_date) {
        $this->db->select('id_customer');
        $this->db->distinct('id_customer');
        $this->db->where('id_city_code', $code_city);
        $this->db->where('deleted', 0);
        $this->db->where('date >= ', $start_date);
        $this->db->where('date <= ', $end_date);
        $result = $this->db->get('sales_inventory');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }

    function find_sale_id_customer($id_customer, $start_date, $end_date) {
        $this->db->select('id_sale');
        $this->db->distinct('id_sale');
        $this->db->where('id_customer', $id_customer);
        $this->db->where('deleted', 0);
        $this->db->where('date >= ', $start_date);
        $this->db->where('date <= ', $end_date);
        $result = $this->db->get('sales_inventory');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }

    function find_sale_id_customer_cuoiky($id_customer, $end_date) {
        $this->db->select('id_sale');
        $this->db->distinct('id_sale');
        $this->db->where('id_customer', $id_customer);
        $this->db->where('deleted', 0);
        $this->db->where('date > ', $end_date);
        $result = $this->db->get('sales_inventory');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }

    function find_sale_id_customer_dauky($id_customer, $start_date) {
        $this->db->select('id_sale');
        $this->db->distinct('id_sale');
        $this->db->where('id_customer', $id_customer);
        $this->db->where('deleted', 0);
        $this->db->where('date < ', $start_date);
        $result = $this->db->get('sales_inventory');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }

    function find_pay_type_congno($id_customer, $start_date, $end_date, $id_sale) {
        $this->db->select('pay_type');
        $this->db->distinct('pay_type');
        $this->db->where('id_customer', $id_customer);
        $this->db->where('date >= ', $start_date);
        $this->db->where('date <= ', $end_date);
        $this->db->where('id_sale', $id_sale);
        $result = $this->db->get('sales_inventory');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }

    function find_pay_type_congno_cuoiky($id_customer, $end_date, $id_sale) {
        $this->db->select('pay_type');
        $this->db->distinct('pay_type');
        $this->db->where('id_customer', $id_customer);
        $this->db->where('date > ', $end_date);
        $this->db->where('id_sale', $id_sale);
        $result = $this->db->get('sales_inventory');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }

    function find_pay_type_congno_dauky($id_customer, $start_date, $id_sale) {
        $this->db->select('pay_type');
        $this->db->distinct('pay_type');
        $this->db->where('id_customer', $id_customer);
        $this->db->where('date < ', $start_date);
        $this->db->where('id_sale', $id_sale);
        $result = $this->db->get('sales_inventory');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }

    function find_tien_congno($id_customer, $start_date, $end_date, $id_sale, $pay_type) {
        $this->db->select_max('pay_amount');
        $this->db->where('id_customer', $id_customer);
        $this->db->where('date >= ', $start_date);
        $this->db->where('date <= ', $end_date);
        $this->db->where('id_sale', $id_sale);
        $this->db->where('pay_type', $pay_type);
        $result = $this->db->get('sales_inventory');

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }

    function find_tien_congno_cuoky($id_customer, $end_date, $id_sale, $pay_type) {
        $this->db->select_max('pay_amount');
        $this->db->where('id_customer', $id_customer);
        $this->db->where('date > ', $end_date);
        $this->db->where('id_sale', $id_sale);
        $this->db->where('pay_type', $pay_type);
        $result = $this->db->get('sales_inventory');

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }

    function find_tien_congno_dauky($id_customer, $start_date, $id_sale, $pay_type) {
        $this->db->select_max('pay_amount');
        $this->db->where('id_customer', $id_customer);
        $this->db->where('date < ', $start_date);
        $this->db->where('id_sale', $id_sale);
        $this->db->where('pay_type', $pay_type);
        $result = $this->db->get('sales_inventory');

        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }

    function update_birth_date($data) {
        $this->db->select('birth_date');
        $this->db->update('people', $data);
    }

    function update_company($data) {
        $this->db->select('birth_date_1');
        $this->db->update('customers', $data);
    }

    function get_city_name($data) {
        $this->db->where('id_city', $data);
        $query = $this->db->get('cities');
        return $query->row();
    }

    function cleanup() {
        $customer_data = array('account_number' => null);
        $this->db->where('deleted', 1);
        return $this->db->update('customers', $customer_data);
    }

    /**
     * Functions manage email_template
     */
    function exists_mail($mail_id) {
        $this->db->from('mail_template');
        $this->db->where('mail_template.mail_id', $mail_id);
        $query = $this->db->get();
        return ($query->num_rows() == 1);
    }

    function get_all_mail($limit = 10000, $offset = 0, $col = 'mail_id', $order = 'asc') {
        $this->db->from('mail_template');
        $this->db->where('deleted', 0);
        $this->db->order_by($col, $order);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function count_all_mail() {
        $this->db->from('mail_template');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }

    /*
      Gets information about a particular customer
     */

    function get_info_mail($mail_id) {
        $this->db->from('mail_template');
        $this->db->where('mail_id', $mail_id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $customer_id is NOT an customer
            $mail_obj = parent::get_info(-1);

            //Get all the fields from customer table
            $fields = $this->db->list_fields('mail_template');

            //append those fields to base parent object, we we have a complete empty object
            foreach ($fields as $field) {
                $mail_obj->$field = '';
            }

            return $mail_obj;
        }
    }

    /*
      Gets information about multiple customers
     */

    function get_multiple_mail_info($mail_ids) {
        $this->db->from('mail_template');
        $this->db->where_in('mail_template.mail_id', $mail_ids);
        $this->db->order_by("mail_id", "asc");
        return $this->db->get();
    }

    /*
      Inserts or updates a customer
     */

    function save_mail(&$mail_data, $mail_id = false) {
        if (!$mail_id or ! $this->exists_mail($mail_id)) {
            if ($this->db->insert('mail_template', $mail_data)) {
                $mail_data['$mail_id'] = $this->db->insert_id();

                return true;
            }
            return false;
        }

        $this->db->where('mail_id', $mail_id);
        return $this->db->update('mail_template', $mail_data);
    }

    /*
      Deletes one customer
     */

    function delete_mail($mail_id) {
        $this->db->where('mail_id', $mail_id);
        return $this->db->update('mail_template', array('deleted' => 1));
    }

    /*
      Deletes a list of mail template
     */

    function delete_mail_list($mail_ids) {
        $this->db->where_in('mail_id', $mail_ids);
        return $this->db->update('mail_template', array('deleted' => 1));
    }

    function get_Customer_type() {
        $query = $this->db->get('customer_type');
        return $query->result_array();
    }

    function get_info_typeCustomer($id) {
        $this->db->where('id', $id);
        $query = $this->db->get('customer_type');
        return $query->row();
    }

    public function get_select_dropdown() {
        $this->db->from('customers');
        $this->db->join('people', 'people.person_id = customers.person_id');
        $this->db->where('customers.deleted', 0);
        $this->db->order_by("last_name", "asc");
        return $this->db->get()->result_array();
    }

    function get_all_mail_template() {
        $this->db->where("deleted", 0);
        $this->db->order_by("mail_title", "ASC");
        $query = $this->db->get("mail_template");
        return $query->result_array();
    }

//        Created by San
    function auto_birthday() {
        $this->db->from('people');
        $this->db->join('customers', 'customers.person_id = people.person_id');
        $this->db->where('month(birth_date)', date('m'));
        $this->db->where('day(birth_date)', date('d'));
        $this->db->where('deleted', 0);
        $this->db->order_by('people.birth_date desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_customer_mail_auto($people_id) {
        $this->db->where("people_id", $people_id);
        $this->db->where("year", date('Y'));
        $query = $this->db->get("mail_auto");
        return $query->row_array();
    }

    function update_customer_mail_auto($people_id, $data) {
        $this->db->where("people_id", $people_id);
        $this->db->where("year", date('Y'));
        $this->db->update("mail_auto", $data);
    }

    function insert_customer_mail_auto($data) {
        $this->db->insert("mail_auto", $data);
    }

    function get_info_person_by_id($id) {
        $this->db->where('person_id', $id);
        $query = $this->db->get('people');
        return $query->row_array();
    }

//    function get_all_by_employee_id($employee_id, $limit = 10000, $offset = 0, $col = 'lifetek_customers.person_id', $order = 'desc') {
//        $people = $this->db->dbprefix('people');
//        $customers = $this->db->dbprefix('customers');
//        $employees = $this->db->dbprefix('employees');
//        if ($employee_id == 1) {
//            $data = $this->db->query("SELECT *, $customers.company_name
//                FROM " . $people . "
//                STRAIGHT_JOIN " . $customers . " ON 									                       
//                " . $people . ".person_id = " . $customers . ".person_id
//                WHERE " . $customers . ".deleted =0 ORDER BY " . $col . " " . $order . " 
//                LIMIT  " . $offset . "," . $limit);
//        } else {
//            $data = $this->db->query("SELECT *,$customers.company_name
//                FROM " . $people . "
//                STRAIGHT_JOIN " . $customers . " ON 									                       
//                " . $people . ".person_id = " . $customers . ".person_id
//                WHERE " . $customers . ".deleted =0 AND employee_id=" . $employee_id . " ORDER BY " . $col . " " . $order . " 
//                LIMIT  " . $offset . "," . $limit);
//        }
//        return $data;
//    }
    
    
       
//hai zero
// add them 4 tru?ng d? l?c: l?c theo th?i gian và doanh thu
    function get_all_by_employee_id($employee_id, $limit = 10000, $offset = 0, $col = 'lifetek_customers.person_id', $order = 'desc',$start_date='',$end_date='',$start_money='',$end_money='') {
        $people = $this->db->dbprefix('people');
        $customers = $this->db->dbprefix('customers');
        $sales = $this->db->dbprefix('sales');
        // loc theo thoi gian
        if($start_date!=''){
            $where_start_date   = ' and sale_time  >= "'.$start_date.'"';
        }else $where_start_date   ='';
        if($end_date!=''){
            $where_end_date     = ' and sale_time  <= "'.$end_date.'"';
        }else $where_end_date     ='';
        
//        $result = $this->db->get('sales')->result_array();
//        if(count($result)==0){
        if(trim($start_date)==''&&trim($end_date)==''&&trim($start_money)==''&&trim($end_money)==''){
            if ($employee_id == 1) {
//            $data = $this->db->query("SELECT *, $customers.company_name
//                FROM " . $people . "
//                STRAIGHT_JOIN " . $customers . " ON 									                       
//                " . $people . ".person_id = " . $customers . ".person_id
//                WHERE " . $customers . ".deleted =0 ORDER BY " . $col . " " . $order . " 
//                LIMIT  " . $offset . "," . $limit);
            
            
            $data = $this->db->query("SELECT *, $customers.company_name
                FROM " . $customers . "
                STRAIGHT_JOIN " . $people . " ON 									                       
                " . $people . ".person_id = " . $customers . ".person_id
                
                WHERE " . $customers . ".deleted =0 ".$where_start_date.' '.$where_end_date.' '.$group_having." ORDER BY " . $col . " " . $order . " 
                LIMIT  " . $offset . "," . $limit);
        } 
            else {
                
                $data = $this->db->query("SELECT *,$customers.company_name
                    FROM " . $people . "
                    STRAIGHT_JOIN " . $customers . " ON 									                       
                    " . $people . ".person_id = " . $customers . ".person_id
                    WHERE " . $customers . ".deleted =0 AND ".$where_start_date.' AND '.$where_end_date.' AND '.$customers."employee_id=" . $employee_id 
                        .' '.$group_having." ORDER BY " . $col . " " . $order . " 
                    LIMIT  " . $offset . "," . $limit);

            }
        }
        else{
            if ($employee_id == 1) {
$group_having = ' GROUP BY (customer_id) ';
                if($start_money!=''&&$end_money!=''){
                        $group_having .= '
                    having sum(later_cost_price)>="'.$start_money.'" and  sum(later_cost_price)>="'.$end_money.'"' ;
                    }elseif ($start_money!='') {
                        $group_having = '
                    having sum(later_cost_price)>="'.$start_money.'" ' ;
                    }elseif ($end_money !='') {
                        $group_having = '
                    having  sum(later_cost_price)<="'.$end_money.'"' ;
                    }



                $data = $this->db->query("SELECT *, $customers.company_name
                    FROM " . $customers . "
                    STRAIGHT_JOIN " . $people . " ON 									                       
                    " . $people . ".person_id = " . $customers . ".person_id
                    STRAIGHT_JOIN " . $sales . " ON 									                       
                    " . $customers . ".person_id = " . $sales . ".customer_id
                    WHERE " . $customers . ".deleted =0 ".$where_start_date.' '.$where_end_date.' '.$group_having." ORDER BY " . $col . " " . $order . " 
                    LIMIT  " . $offset . "," . $limit);
            } 
            else {
                $group_having = ' GROUP BY (customer_id) ';
                if($start_money!=''&&$end_money!=''){
                        $group_having = '
                    having sum(later_cost_price)>="'.$start_money.'" and  sum(later_cost_price)>="'.$end_money.'"' ;
                    }elseif ($start_money!='') {
                        $group_having = '
                    having sum(later_cost_price)>="'.$start_money.'" ' ;
                    }elseif ($end_money !='') {
                        $group_having = '
                    having  sum(later_cost_price)<="'.$end_money.'"' ;
                    }
                $data = $this->db->query("SELECT *,$customers.company_name
                    FROM " . $people . "
                    STRAIGHT_JOIN " . $customers . " ON 									                       
                    " . $people . ".person_id = " . $customers . ".person_id
                    STRAIGHT_JOIN " . $sales . " ON 									                       
                    " . $customers . ".person_id = " . $sales . ".customer_id
                    WHERE " . $customers . ".deleted =0 AND ".$where_start_date.' AND '.$where_end_date.' AND '.$customers."employee_id=" . $employee_id 
                        .' '.$group_having." ORDER BY " . $col . " " . $order . " 
                    LIMIT  " . $offset . "," . $limit);

            }
        }
//        return $this->db->last_query();
        return $data;;
    }
    
    
    
    

    function count_all_by_employee_id($employee_id) {
        if ($employee_id == 1) {
            $this->db->from('customers');
            $this->db->where('deleted', 0);
        } else {
            $this->db->from('customers');
            $this->db->where('deleted', 0);
            $this->db->where('employee_id', $employee_id);
        }
        return $this->db->count_all_results();
    }

    
//hai zero
// add them 4 tru?ng d? l?c: l?c theo th?i gian và doanh thu
    function search_by_employee_id($employee_id, $search, $employees, $type_customer, $limit = 20, $offset = 0, $column = 'last_name', $orderby = 'asc',$start_date='',$end_date='',$start_money='',$end_money='') {
       
        if ($type_customer)
            $type_customer_id = " and type_customer = $type_customer ";
        else
            $type_customer_id = '';
        if ($employee_id == 1) {
            $where_employee = "";
        } else {
            $where_employee = " AND lifetek_customers.employee_id=" . $employee_id . " ";
        }
        // loc theo thoi gian
        if($start_date!=''){
            $where_start_date   = ' and sale_time  >= "'.$start_date.'"';
        }else $where_start_date   ='';
        if($end_date!=''){
            $where_end_date     = ' and sale_time  <= "'.$end_date.'"';
        }else $where_end_date     ='';
        
        if ($this->config->item('speed_up_search_queries')) {
            $query = "select * from (
                (select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
                        , " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
                from " . $this->db->dbprefix('customers') . "
                join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
                where first_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0" . $where_employee . "
                order by `" . $column . "` " . $orderby . ") union

                (select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
                        , " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
                from " . $this->db->dbprefix('customers') . "
                join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
                where last_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0" . $where_employee . "
                order by `" . $column . "` " . $orderby . ") union

                (select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
                        , " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
                from " . $this->db->dbprefix('customers') . "
                join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
                where email like '" . $this->db->escape_like_str($search) . "%' and deleted = 0" . $where_employee . "
                order by `" . $column . "` " . $orderby . ") union

                (select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
                        , " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
                from " . $this->db->dbprefix('customers') . "
                join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
                where phone_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0" . $where_employee . "
                order by `" . $column . "` " . $orderby . ") union

                (select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
                        , " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
                from " . $this->db->dbprefix('customers') . "
                join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
                where account_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0" . $where_employee . "
                order by `" . $column . "` " . $orderby . ") union

                (select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
                        , " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
                from " . $this->db->dbprefix('customers') . "
                join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
                where CONCAT(`first_name`,' ',`last_name`)  like '" . $this->db->escape_like_str($search) . "%' and deleted = 0" . $where_employee . "
                order by `" . $column . "` " . $orderby . ")
                ) as search_results
                order by `" . $column . "` " . $orderby . " limit " . (int) $offset . "," . $this->db->escape((int) $limit);
            return $this->db->query($query);
        }
        else{
            if(trim($start_date)==''&&trim($end_date)==''&&trim($start_money)==''&&trim($end_money)==''){
//            echo 'TRUONG HOP 1';
            if ($employee_id == 1) {
                if ($employees)
                    $employee = " and lifetek_customers.employee_id = $employees";
                else
                    $employee = "";
                $this->db->from('customers');
                $this->db->join('people', 'customers.person_id=people.person_id');
                $this->db->where("(CONCAT(first_name,' ',last_name) LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                account_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                company_name LIKE '%" . $this->db->escape_like_str($search) . "%' ) $employee $type_customer_id  and lifetek_customers.deleted=0");
                
                
                $this->db->order_by($column, $orderby);
                $this->db->limit($limit);
                $this->db->offset($offset);
//                $this->db->get();
//                return $this->db->last_query();;
                return $this->db->get();
            }else {
                $this->db->from('customers');
                $this->db->join('people', 'customers.person_id=people.person_id');
                $this->db->where("(CONCAT(first_name,' ',last_name) LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                account_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                company_name LIKE '%" . $this->db->escape_like_str($search) . "%' ) $type_customer_id and lifetek_customers.deleted=0");
                $this->db->where('lifetek_customers.employee_id', $employee_id);
                $this->db->order_by($column, $orderby);
                $this->db->limit($limit);
//                $this->db->get();
//                return $this->db->last_query();;
                $this->db->offset($offset);
                return $this->db->get();
            }
        }
            else {
                    if ($employee_id == 1) {
                    if ($employees)
                        $employee = " and lifetek_customers.employee_id = $employees";
                    else
                        $employee = "";
                    $this->db->from('customers');
                    $this->db->join('people', 'customers.person_id=people.person_id');
                    $this->db->join('sales', 'customers.person_id=sales.customer_id');
                    $this->db->where("(CONCAT(first_name,' ',last_name) LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                    email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                    phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                    account_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                    company_name LIKE '%" . $this->db->escape_like_str($search) . "%' ) $employee $type_customer_id $where_start_date $where_end_date and lifetek_customers.deleted=0");
                    $this->db->group_by('customer_id');
                if($start_money!=''&&$end_money!=''){
                    $this->db->having('sum(later_cost_price)>="'.$start_money.'" and sum(later_cost_price)<="'.$end_money.'"', null, false);
                }elseif ($start_money!='') {
                    $this->db->having('sum(later_cost_price)>="'.$start_money.'" ', null, false);
                }elseif ($end_money !='') {
                    $this->db->having('sum(later_cost_price)<="'.$end_money.'" ', null, false);
                }
                    
                    $this->db->order_by($column, $orderby);
                    $this->db->limit($limit);
                    $this->db->offset($offset);
//                    $this->db->get();
//                    return $this->db->last_query();;
                    return $this->db->get();
                }else {
                    $this->db->from('customers');
                    $this->db->join('people', 'customers.person_id=people.person_id');
                    $this->db->join('sales', 'customers.person_id=sales.customer_id');
                    $this->db->where("(CONCAT(first_name,' ',last_name) LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                    email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                    phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                    account_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                    company_name LIKE '%" . $this->db->escape_like_str($search) . "%' ) $type_customer_id $where_start_date $where_end_date  and lifetek_customers.deleted=0");
                    $this->db->where('lifetek_customers.employee_id', $employee_id);
                    $this->db->group_by('customer_id');
                    if($start_money!=''&&$end_money!=''){
                    $this->db->having('sum(later_cost_price)>="'.$start_money.'" and sum(later_cost_price)<="'.$end_money.'"', null, false);
                }elseif ($start_money!='') {
                    $this->db->having('sum(later_cost_price)>="'.$start_money.'" ', null, false);
                }elseif ($end_money !='') {
                    $this->db->having('sum(later_cost_price)<="'.$end_money.'" ', null, false);
                }

                    $this->db->order_by($column, $orderby);
                    $this->db->limit($limit);
    //                $this->db->get();
    //                return $this->db->last_query();;
                    $this->db->offset($offset);
                    return $this->db->get();
                }
            }
        }
       
    }
    
    
    

    //hai zero
// add them 4 tru?ng d? l?c: l?c theo th?i gian và doanh thu
    function search_count_all_by_employee_id($employee_id, $search, $employees = '', $type_customer = '', $limit = 10000,$start_date='',$end_date='',$start_money='',$end_money='') {
        if ($type_customer)
            $type_customer_id = "and type_customer = $type_customer ";
        else
            $type_customer_id = '';
        if ($employee_id == 1) {
            $where_employee = "";
        } else {
            $where_employee = " AND employee_id=" . $employee_id . " ";
        }
        // loc theo thoi gian
        if($start_date!=''){
            $where_start_date   = ' and sale_time  >= "'.$start_date.'"';
        }else $where_start_date   ='';
        if($end_date!=''){
            $where_end_date     = ' and sale_time  <= "'.$end_date.'"';
        }else $where_end_date     ='';
        
        if ($this->config->item('speed_up_search_queries')) {
            $query = "
            select *
            from (
            (select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
                    , " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
            from " . $this->db->dbprefix('customers') . "
            join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
            where first_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0" . $where_employee . "
            order by `last_name` asc limit " . $this->db->escape($limit) . ") union

                    (select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
                    , " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
            from " . $this->db->dbprefix('customers') . "
            join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
            where last_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0" . $where_employee . "
            order by `last_name` asc limit " . $this->db->escape($limit) . ") union

                    (select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
                    , " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
            from " . $this->db->dbprefix('customers') . "
            join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
            where email like '" . $this->db->escape_like_str($search) . "%' and deleted = 0" . $where_employee . "
            order by `last_name` asc limit " . $this->db->escape($limit) . ") union

                    (select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
                    , " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
            from " . $this->db->dbprefix('customers') . "
            join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
            where phone_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0" . $where_employee . "
            order by `last_name` asc limit " . $this->db->escape($limit) . ") union

                    (select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
                    , " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
            from " . $this->db->dbprefix('customers') . "
            join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
            where account_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0" . $where_employee . "
            order by `last_name` asc limit " . $this->db->escape($limit) . ") union

                    (select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('customers') . ".account_number
                    , " . $this->db->dbprefix('customers') . ".taxable, " . $this->db->dbprefix('customers') . ".deleted
            from " . $this->db->dbprefix('customers') . "
            join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('customers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
            where CONCAT(`first_name`,' ',`last_name`)  like '" . $this->db->escape_like_str($search) . "%' and deleted = 0" . $where_employee . "
            order by `last_name` asc limit " . $this->db->escape($limit) . ")
            ) as search_results
            order by `last_name` asc limit " . $this->db->escape($limit);
            $result = $this->db->query($query);
            return $result->num_rows();
        } else {
            if(trim($start_date)==''&&trim($end_date)==''&&trim($start_money)==''&&trim($end_money)==''){
                 if ($employee_id == 1) {
                if ($employees && $employees != 1)
                    $employee = " and employee_id = $employees and employee_id!=1";
                else
                    $employee = "";
                $this->db->from('customers');
                $this->db->join('people', 'customers.person_id=people.person_id');
                $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                account_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                company_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') $employee $type_customer_id and lifetek_customers.deleted=0");
                
                $this->db->order_by("last_name", "asc");
                $this->db->limit($limit);
                $result = $this->db->get();
                return $result->num_rows();
//                                return $this->db->last_query();;
            }else {
                $this->db->from('customers');
                $this->db->join('people', 'customers.person_id=people.person_id');
                $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or
                account_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                company_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') $type_customer_id $where_start_date $where_end_date  and lifetek_customers.deleted=0");
                
                
                
                $this->db->where("employee_id", $employee_id);
                $this->db->order_by("last_name", "asc");
                $this->db->limit($limit);
                $result = $this->db->get();
                return $result->num_rows();
//                return $this->db->last_query();;
            }
            }
            else{
            if ($employee_id == 1) {
                if ($employees && $employees != 1)
                    $employee = " and employee_id = $employees and employee_id!=1";
                else
                    $employee = "";
                $this->db->from('customers');
                $this->db->join('people', 'customers.person_id=people.person_id');
                $this->db->join('sales', 'customers.person_id=sales.customer_id');
                $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                account_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                company_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') $employee $type_customer_id $where_start_date $where_end_date and lifetek_customers.deleted=0");
                $this->db->group_by('customer_id');
                if($start_money!=''&&$end_money!=''){
                    $this->db->having('sum(later_cost_price)>="'.$start_money.'" and sum(later_cost_price)<="'.$end_money.'"', null, false);
                }elseif ($start_money!='') {
                    $this->db->having('sum(later_cost_price)>="'.$start_money.'" ', null, false);
                }elseif ($end_money !='') {
                    $this->db->having('sum(later_cost_price)<="'.$end_money.'" ', null, false);
                }
                
                $this->db->order_by("last_name", "asc");
                $this->db->limit($limit);
                $result = $this->db->get();
                return $result->num_rows();
//                                return $this->db->last_query();;
            }else {
                $this->db->from('customers');
                $this->db->join('people', 'customers.person_id=people.person_id');
                $this->db->join('sales', 'customers.person_id=sales.customer_id');
                $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or
                account_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                company_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
                CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') $type_customer_id $where_start_date $where_end_date  and lifetek_customers.deleted=0");
                
                $this->db->group_by('customer_id');
                if($start_money!=''&&$end_money!=''){
                    $this->db->having('sum(later_cost_price)>="'.$start_money.'" and sum(later_cost_price)<="'.$end_money.'"', null, false);
                }elseif ($start_money!='') {
                    $this->db->having('sum(later_cost_price)>="'.$start_money.'" ', null, false);
                }elseif ($end_money !='') {
                    $this->db->having('sum(later_cost_price)<="'.$end_money.'" ', null, false);
                }
                
                
                $this->db->where("employee_id", $employee_id);
                $this->db->order_by("last_name", "asc");
                $this->db->limit($limit);
                $result = $this->db->get();
                return $result->num_rows();
//                return $this->db->last_query();;
            }
            }
        }
    }

    function get_search_suggestions_by_employee_id($employee_id, $search, $limit = 25) {
        $suggestions = array();
        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');
        if ($this->config->item('speed_up_search_queries')) {
            $this->db->where("(first_name LIKE '" . $this->db->escape_like_str($search) . "%' ) and deleted=0");
        } else {
            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' ) and deleted=0");
        }
        if ($employee_id != 1) {
            $this->db->where('employee_id', $employee_id);
        }
        $this->db->order_by("first_name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            if ($row->first_name != '' || $row->last_name != '') {
                $suggestions[] = array('label' => $row->first_name . ' ' . $row->last_name);
            }
        }

        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        if ($employee_id != 1) {
            $this->db->where('employee_id', $employee_id);
        }
        $this->db->like("email", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("email", "asc");
        $by_email = $this->db->get();
        foreach ($by_email->result() as $row) {
            if ($row->email != '') {
                $suggestions[] = array('label' => $row->email);
            }
        }

        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        if ($employee_id != 1) {
            $this->db->where('employee_id', $employee_id);
        }
        $this->db->like("phone_number", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("phone_number", "asc");
        $by_phone = $this->db->get();
        foreach ($by_phone->result() as $row) {
            if ($row->phone_number != '') {
                $suggestions[] = array('label' => $row->phone_number);
            }
        }

        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        if ($employee_id != 1) {
            $this->db->where('employee_id', $employee_id);
        }
        $this->db->like("account_number", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("account_number", "asc");
        $by_account_number = $this->db->get();
        foreach ($by_account_number->result() as $row) {
            if ($row->account_number != '') {
                $suggestions[] = array('label' => $row->account_number);
            }
        }

        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        if ($employee_id != 1) {
            $this->db->where('employee_id', $employee_id);
        }
        $this->db->like("company_name", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("company_name", "asc");
        $by_company_name = $this->db->get();

        foreach ($by_company_name->result() as $row) {
            if ($row->company_name != '') {
                $suggestions[] = array('label' => $row->company_name);
            }
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    //Add mail birthday in history
    function add_mail_history($data) {
        $this->db->insert("mail_history", $data);
    }

    //get history send mail by customer_id
    function get_all_mail_history($customer_id, $resultsPerPage, $page_limit) {
        $this->db->where('person_id', $customer_id);
        $this->db->limit($resultsPerPage, $page_limit);
        $query = $this->db->get("mail_history");
        return $query->result_array();
    }

    function count_mail_history($id_customer, $resultsPerPage, $page_limit) {//sales
        $this->db->where('person_id', $customer_id);
        $this->db->limit($resultsPerPage, $page_limit);
        $query = $this->db->get("mail_history");
        return $query->num_rows();
    }

    function get_total_mail_history($id_customer) {//sales
        $this->db->where('person_id', $id_customer);
        $query = $this->db->get("mail_history");
        return $query->num_rows();
    }

    //gui mail 6
    function find_mail_history_customer2($id_customer, $page_limit, $resultsPerPage) {
        $sql = "select * from lifetek_mail_history 
			where person_id = " . $id_customer . " ORDER BY id DESC
			limit $page_limit,$resultsPerPage
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else
            return null;
    }

    function get_row6($id_customer, $page_limit, $resultsPerPage) {//sales
        $sql = "select * from lifetek_mail_history 
			where person_id = " . $id_customer . "
			limit $page_limit,$resultsPerPage
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else
            return null;
    }

    function get_total_row6($id_customer) {//sales
        $sql = "select * from lifetek_mail_history 
			where person_id = " . $id_customer . " 
			";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else
            return null;
    }

    //get info mail history by id
    function get_info_mail_history($id) {
        $this->db->where('id', $id);
        $query = $this->db->get("mail_history");
        return $query->row_array();
    }

    //remove mail history
    function delete_mail_history($id) {
        $this->db->where("id", $id);
        $this->db->delete("mail_history");
    }

    //lay thong tin khach hang (Chi lay ten)
    function get_info_customer_thu_chi($search, $limit = 25) {
        $suggestions = array();

        //name & company
        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');
        if ($this->config->item('speed_up_search_queries')) {
            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
            	company_name LIKE '%" . $this->db->escape_like_str($search) . "%' or
				CONCAT(`first_name`,' ',`last_name`) LIKE '" . $this->db->escape_like_str($search) . "%') and deleted=0");
        } else {
            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
            company_name LIKE '%" . $this->db->escape_like_str($search) . "%' or
			CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        }
        $this->db->order_by("last_name", "asc");
        $by_name = $this->db->get()->result();
        foreach ($by_name as $row) {
            if ($row->company_name != '') {
                $lable = $row->company_name . ' - ' . $row->first_name . ' ' . $row->last_name;
            } else {
                $lable = $row->first_name . ' ' . $row->last_name;
            }
            if ($row->first_name) {
                $suggestions[] = array(
                    'value' => $row->person_id,
                    'label' => $lable,
                    'cost_phone' => $row->phone_number,
                    'cost_company' => $row->company_name,
                );
            }
        }
        //mail
        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("email", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("email", "asc");
        $by_email = $this->db->get();
        foreach ($by_email->result() as $row) {
            if ($row->email) {
                $suggestions[] = array(
                    'value' => $row->person_id,
                    'label' => $row->email
                );
            }
        }
        //phone
        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("phone_number", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("phone_number", "asc");
        $by_email = $this->db->get();
        foreach ($by_email->result() as $row) {
            if ($row->phone_number) {
                $suggestions[] = array(
                    'value' => $row->person_id,
                    'label' => $row->phone_number
                );
            }
        }
        //address
        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("address_1", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("address_1", "asc");
        $by_email = $this->db->get();
        foreach ($by_email->result() as $row) {
            if ($row->address_1) {
                $suggestions[] = array(
                    'value' => $row->person_id,
                    'label' => $row->address_1
                );
            }
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    //hung audi 9-4-15
    //world
    function get_option1() {
        $this->db->where('type', 0);
        $this->db->where('delete', 0);
        $query = $this->db->get('cities');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    //city
    function get_option2() {
        $this->db->where('type', 1);
        $query = $this->db->get('cities');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    function get_info_customer($customer_id) {
        $this->db->from('customers');
        $this->db->join('people', 'people.person_id = customers.person_id');
        $this->db->where('customers.person_id', $customer_id);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $supplier_id is NOT an supplier
            $person_obj = parent::get_info(-1);

            //Get all the fields from supplier table
            $fields = $this->db->list_fields('customers');

            //append those fields to base parent object, we we have a complete empty object
            foreach ($fields as $field) {
                $person_obj->$field = '';
            }

            return $person_obj;
        }
    }

    //hung audi 22-4-15
    function get_info2($customer_id) {
        $this->db->from('customers');
        $this->db->join('people', 'people.person_id = customers.person_id');
        $this->db->where('customers.person_id', $customer_id);
        return $query = $this->db->get();
    }

    //SMS
    function get_all_sms($limit = 10000, $offset = 0, $col = 'id', $order = 'DESC') {
        $this->db->from('sms');
        $this->db->where('deleted', 0);
        $this->db->order_by($col, $order);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function count_all_sms() {
        $this->db->from('sms');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }

    function get_info_sms($id) {
        $this->db->from('sms');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $customer_id is NOT an customer
            $person_obj = parent::get_info(-1);
            //Get all the fields from customer table
            $fields = $this->db->list_fields('sms');
            //append those fields to base parent object, we we have a complete empty object
            foreach ($fields as $field) {
                $person_obj->$field = '';
            }
            return $person_obj;
        }
    }

    function exists_sms($id) {
        $this->db->where('id', $id);
        $query = $this->db->get("sms");
        return ($query->num_rows() == 1);
    }

    function save_sms(&$sms_data, $id = false) {
        if (!$id or ! $this->exists_sms($id)) {
            if ($this->db->insert('sms', $sms_data)) {
                $sms_data['id'] = $this->db->insert_id();
                return true;
            }
            return false;
        }
        $this->db->where('id', $id);
        return $this->db->update('sms', $sms_data);
    }

    function save_message($data) {
        $this->db->insert("message", $data);
    }

    //get all history send SMS
    function get_history_sms($id_customer, $page_limit, $resultsPerPage) {
        $this->db->where('id_cus', $id_customer);
        $this->db->order_by('id', 'DESC');
        $this->db->limit($resultsPerPage, $page_limit);
        $query = $this->db->get("message");
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return null;
        }
    }

    function get_total_row_history_sms($id_customer) {
        $this->db->where("id_cus", $id_customer);
        $query = $this->db->get("message");
        return $query->num_rows();
    }

    function get_row_history_sms($id_customer, $page_limit, $resultsPerPage) {//sales
        $this->db->where('id_cus', $id_customer);
        $this->db->order_by('id', 'DESC');
        $this->db->limit($resultsPerPage, $page_limit);
        $query = $this->db->get("message");
        if ($query->num_rows() > 0) {
            return $query->num_rows();
        } else {
            return null;
        }
    }

    function delete_sms_list($sms_ids) {
        $this->db->where_in('id', $sms_ids);
        return $this->db->update('sms', array('deleted' => 1));
    }

    function search_sms($search, $limit = 20, $offset = 0, $column = 'id', $orderby = 'desc') {
        $this->db->from('sms');
        $this->db->like('title', $search);
        $this->db->where('deleted', 0);
        $this->db->order_by($column, $orderby);
        $this->db->limit($limit);
        $this->db->offset($offset);
        return $this->db->get();
    }

    function search_count_sms($search, $limit = 10000) {
        $this->db->from('sms');
        $this->db->like('title', $search);
        $this->db->where('deleted', 0);
        $result = $this->db->get();
        return $result->num_rows();
    }

    function get_search_suggestions_sms($search, $limit = 25) {
        $this->db->from('sms');
        $this->db->where('deleted', 0);
        $this->db->like('title', $search);
        $this->db->order_by("id", "asc");
        $sms = $this->db->get();

        foreach ($sms->result() as $row) {
            $suggestions[] = array('label' => $row->title);
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function get_table_number_sms() {
        $this->db->select_max("id");
        $query = $this->db->get("number_sms");
        return $query->row_array();
    }

    function get_info_id_max_of_table_number_sms($id_max) {
        $this->db->where("id", $id_max);
        $query = $this->db->get("number_sms");
        return $query->row_array();
    }

    function update_number_sms($id, $data) {
        $this->db->where('id', $id);
        $this->db->update("number_sms", $data);
    }

    //        By Loi
    function phone_number_exists($phone_number, $person_id) {
        if ($person_id) {
            $this->db->join('customers', 'people.person_id = customers.person_id');
            $this->db->where('phone_number', $phone_number);
            $this->db->where("people.person_id !=", $person_id);
            $this->db->where('customers.deleted', 0);
            $query = $this->db->get('people');
        } else {
            $this->db->join('customers', 'people.person_id = customers.person_id');
            $this->db->where('phone_number', $phone_number);
            $this->db->where('customers.deleted', 0);
            $query = $this->db->get('people');
        }
        return $query->num_rows() > 0;
    }

    function get_all_customer() {
        $this->db->join('people', 'customers.person_id = people.person_id');
        $query = $this->db->get('customers');
        return $query->result_array();
    }

//        end Loi
    //hung audi 29-6-15
    function get_customer_search_reports($search, $limit = 25) {
        $suggestions = array();
        $suggestions[0] = array(
            'value' => 0,
            'label' => 'Khách l?'
        );
        //name & company
        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');
        if ($this->config->item('speed_up_search_queries')) {
            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
            	company_name LIKE '%" . $this->db->escape_like_str($search) . "%' or
				CONCAT(`first_name`,' ',`last_name`) LIKE '" . $this->db->escape_like_str($search) . "%') and deleted=0");
        } else {
            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
            company_name LIKE '%" . $this->db->escape_like_str($search) . "%' or
			CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        }
        $this->db->order_by("last_name", "asc");
        $by_name = $this->db->get()->result();
        foreach ($by_name as $row) {
            if ($row->company_name != '') {
                $lable = $row->company_name . ' - ' . $row->first_name . ' ' . $row->last_name;
            } else {
                $lable = $row->first_name . ' ' . $row->last_name;
            }
            if ($row->first_name) {
                $suggestions[] = array(
                    'value' => $row->person_id,
                    'label' => $lable,
                    'cost_phone' => $row->phone_number,
                );
            }
        }
        //mail
        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("email", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("email", "asc");
        $by_email = $this->db->get();
        foreach ($by_email->result() as $row) {
            if ($row->email) {
                $suggestions[] = array(
                    'value' => $row->person_id,
                    'label' => $row->email
                );
            }
        }
        //phone
        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("phone_number", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("phone_number", "asc");
        $by_email = $this->db->get();
        foreach ($by_email->result() as $row) {
            if ($row->phone_number) {
                $suggestions[] = array(
                    'value' => $row->person_id,
                    'label' => $row->phone_number
                );
            }
        }
        //address
        $this->db->from('customers');
        $this->db->join('people', 'customers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("address_1", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("address_1", "asc");
        $by_email = $this->db->get();
        foreach ($by_email->result() as $row) {
            if ($row->address_1) {
                $suggestions[] = array(
                    'value' => $row->person_id,
                    'label' => $row->address_1
                );
            }
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    function get_list_customer() {
        $this->db->join('people', 'customers.person_id = people.person_id');
        $this->db->where("deleted", 0);
        $query = $this->db->get('customers');
        return $query->result();
    }
   
    function get_customer_money_cost($customer_id, $id_sale){
        $this->db->where('id_customer',$customer_id);
        $this->db->where('id_sale',$id_sale);
        $this->db->where('deleted',0);
        $this->db->where('form_cost',0);
        $this->db->select_max('id_cost'); 
        return $this->db->get('costs');
    }
    
    function get_supplier_id_money_cost($supplier_id){
        $this->db->where('supplier_id',$supplier_id);
        $this->db->where('deleted',0);
        $this->db->where('payment_type !=',0);
        $this->db->where('form_cost',1);
        return $this->db->get('costs');
    }
    
}

?>
