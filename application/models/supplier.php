<?php

class Supplier extends Person {

    function get_supplier($acc_num) {
        $this->db->where('account_number', $acc_num);
        $query = $this->db->get('suppliers');
        return $query->row_array();
    }

    //check trùng mã nhà cung cấp
    function get_account($id) {
        if ($id > 0) {
            $this->db->select('account_number');
            $this->db->where('person_id !=', $id);
            $this->db->where('deleted', 0);
            $this->db->from('suppliers');
            $query = $this->db->get();
        } elseif ($id = -1) {
            $this->db->select('account_number');
            $this->db->where('deleted', 0);
            $this->db->from('suppliers');
            $query = $this->db->get();
        }
        foreach ($query->result_array() as $q) {
            $result[] = $q;
        }
        return $result;
    }

    //check trùng tên
    function getname($id) {
        if ($id > 0) {
            $this->db->select('company_name');
            $this->db->where('person_id !=', $id);
            $this->db->where('deleted', 0);
            $this->db->from('suppliers');
            $query = $this->db->get();
        } elseif ($id = -1) {
            $this->db->select('company_name');
            $this->db->where('deleted', 0);
            $this->db->from('suppliers');
            $query = $this->db->get();
        }
        foreach ($query->result_array() as $q) {
            $result[] = $q;
        }
        return $result;
    }

    /*
      Determines if a given person_id is a customer
     */

    function exists($person_id) {
        $this->db->from('suppliers');
        $this->db->join('people', 'people.person_id = suppliers.person_id');
        $this->db->where('suppliers.person_id', $person_id);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    /*
      Returns all the suppliers
     */

    function get_all($limit = 10000, $offset = 0, $col = 'lifetek_suppliers.person_id', $order = 'desc') {
        $people = $this->db->dbprefix('people');
        $suppliers = $this->db->dbprefix('suppliers');
        $data = $this->db->query("SELECT * 
						FROM " . $people . "
						STRAIGHT_JOIN " . $suppliers . " ON 										                       
						" . $people . ".person_id = " . $suppliers . ".person_id
						WHERE deleted =0 ORDER BY " . $col . " " . $order . " 
						LIMIT  " . $offset . "," . $limit);

        return $data;
    }

    function account_number_exists($account_number) {
        $this->db->from('suppliers');
        $this->db->where('account_number', $account_number);
        $query = $this->db->get();

        return ($query->num_rows() == 1);
    }

    function count_all() {
        $this->db->from('suppliers');
        $this->db->where('deleted', 0);
        return $this->db->count_all_results();
    }

    /*
      Gets information about a particular supplier
     */

    function get_info($supplier_id) {
        $this->db->from('suppliers');
        $this->db->join('people', 'people.person_id = suppliers.person_id');
        $this->db->where('suppliers.person_id', $supplier_id);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $supplier_id is NOT an supplier
            $person_obj = parent::get_info(-1);

            //Get all the fields from supplier table
            $fields = $this->db->list_fields('suppliers');

            //append those fields to base parent object, we we have a complete empty object
            foreach ($fields as $field) {
                $person_obj->$field = '';
            }

            return $person_obj;
        }
    }

    /*
      Gets information about multiple suppliers
     */

    function get_multiple_info($suppliers_ids) {
        $this->db->from('suppliers');
        $this->db->join('people', 'people.person_id = suppliers.person_id');
        $this->db->where_in('suppliers.person_id', $suppliers_ids);
        $this->db->order_by("last_name", "asc");
        return $this->db->get();
    }

    /*
      Inserts or updates a suppliers
     */

    function save(&$person_data, &$supplier_data, $supplier_id = false) {
        $success = false;
        //Run these queries as a transaction, we want to make sure we do all or nothing
        $this->db->trans_start();

        if (parent::save($person_data, $supplier_id)) {
            if (!$supplier_id or ! $this->exists($supplier_id)) {
                $supplier_data['person_id'] = $person_data['person_id'];
                $success = $this->db->insert('suppliers', $supplier_data);
            } else {
                $this->db->where('person_id', $supplier_id);
                $success = $this->db->update('suppliers', $supplier_data);
            }
        }

        $this->db->trans_complete();
        return $success;
    }

    /*
      Deletes one supplier
     */

    function delete($supplier_id) {
        $this->db->where('person_id', $supplier_id);
        return $this->db->update('suppliers', array('deleted' => 1));
    }

    /*
      Deletes a list of suppliers
     */

    function delete_list($supplier_ids) {
        $this->db->where_in('person_id', $supplier_ids);
        return $this->db->update('suppliers', array('deleted' => 1));
    }

    /*
      Get search suggestions to find suppliers
     */

    function get_search_suggestions($search, $limit = 25) {
        $suggestions = array();

        $this->db->from('suppliers');
        $this->db->join('people', 'suppliers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("company_name", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("company_name", "asc");
        $by_company_name = $this->db->get();
        foreach ($by_company_name->result() as $row) {
            if ($row->company_name != '') {
                $suggestions[] = array('label' => $row->company_name);
            }
        }


        $this->db->from('suppliers');
        $this->db->join('people', 'suppliers.person_id=people.person_id');

        if ($this->config->item('speed_up_search_queries')) {
            $this->db->where("(first_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
				last_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
				CONCAT(`first_name`,' ',`last_name`) LIKE '" . $this->db->escape_like_str($search) . "%') and deleted=0");
        } else {
            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
        }
        $this->db->order_by("last_name", "asc");
        $by_name = $this->db->get();
        foreach ($by_name->result() as $row) {
            if ($row->first_name != '' || $row->last_name != '') {
                $suggestions[] = array('label' => $row->first_name . ' ' . $row->last_name);
            }
        }

        $this->db->from('suppliers');
        $this->db->join('people', 'suppliers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("email", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("email", "asc");
        $by_email = $this->db->get();
        foreach ($by_email->result() as $row) {
            if ($row->email != '') {
                $suggestions[] = array('label' => $row->email);
            }
        }

        $this->db->from('suppliers');
        $this->db->join('people', 'suppliers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("phone_number", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("phone_number", "asc");
        $by_phone = $this->db->get();
        foreach ($by_phone->result() as $row) {
            if ($row->phone_number != '') {
                $suggestions[] = array('label' => $row->phone_number);
            }
        }

        $this->db->from('suppliers');
        $this->db->join('people', 'suppliers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("account_number", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("account_number", "asc");
        $by_account_number = $this->db->get();
        foreach ($by_account_number->result() as $row) {
            if ($row->account_number != '') {
                $suggestions[] = array('label' => $row->account_number);
            }
        }

        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    /*
      Get search suggestions to find suppliers
     */

    function get_suppliers_search_suggestions($search, $limit = 25) {
        $suggestions = array();

        $this->db->from('suppliers');
        $this->db->join('people', 'suppliers.person_id=people.person_id');
        $this->db->where('deleted', 0);
        $this->db->like("company_name", $search, $this->config->item('speed_up_search_queries') ? 'after' : 'both');
        $this->db->order_by("company_name", "asc");
        $by_company_name = $this->db->get();
        foreach ($by_company_name->result() as $row) {
            $suggestions[] = array('value' => $row->person_id, 'label' => $row->company_name, 'person_name' => $row->first_name . ' ' . $row->last_name);
        }


//		$this->db->from('suppliers');
//		$this->db->join('people','suppliers.person_id=people.person_id');	
//		
//		if ($this->config->item('speed_up_search_queries'))
//		{
//			$this->db->where("(first_name LIKE '".$this->db->escape_like_str($search)."%' or 
//			last_name LIKE '".$this->db->escape_like_str($search)."%' or 
//			CONCAT(`first_name`,' ',`last_name`) LIKE '".$this->db->escape_like_str($search)."%') and deleted=0");
//		}
//		else
//		{
//			$this->db->where("(first_name LIKE '%".$this->db->escape_like_str($search)."%' or 
//			last_name LIKE '%".$this->db->escape_like_str($search)."%' or 
//			CONCAT(`first_name`,' ',`last_name`) LIKE '%".$this->db->escape_like_str($search)."%') and deleted=0");			
//		}
//		
//		$this->db->order_by("last_name", "asc");		
//		$by_name = $this->db->get();
//		foreach($by_name->result() as $row)
//		{
//			$suggestions[]=array('value' => $row->person_id, 'label' => $row->company_name, 'person_name' => $row->first_name.' '.$row->last_name);	
//		}
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    /*
      Perform a search on suppliers
     */

    function search($search, $limit = 20, $offset = 0, $column = 'last_name', $orderby = 'asc') {
        if ($this->config->item('speed_up_search_queries')) {
            $query = "
			select *
			from (
	           	(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('suppliers') . ".company_name, " . $this->db->dbprefix('suppliers') . ".deleted, " . $this->db->dbprefix('suppliers') . ".account_number
	           	from " . $this->db->dbprefix('suppliers') . "
	           	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('suppliers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
	           	where first_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
	           	order by `" . $column . "` " . $orderby . " limit " . $this->db->escape($limit) . ") union

			 	(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('suppliers') . ".company_name, " . $this->db->dbprefix('suppliers') . ".deleted, " . $this->db->dbprefix('suppliers') . ".account_number
	           	from " . $this->db->dbprefix('suppliers') . "
	           	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('suppliers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
	           	where last_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
	           	order by `" . $column . "` " . $orderby . " limit " . $this->db->escape($limit) . ") union

				(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('suppliers') . ".company_name, " . $this->db->dbprefix('suppliers') . ".deleted, " . $this->db->dbprefix('suppliers') . ".account_number
	         	from " . $this->db->dbprefix('suppliers') . "
	          	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('suppliers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
	          	where email like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
	          	order by `" . $column . "` " . $orderby . " limit " . $this->db->escape($limit) . ") union

				(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('suppliers') . ".company_name, " . $this->db->dbprefix('suppliers') . ".deleted, " . $this->db->dbprefix('suppliers') . ".account_number
	        	from " . $this->db->dbprefix('suppliers') . "
	        	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('suppliers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
	        	where phone_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
	        	order by `" . $column . "` " . $orderby . " limit " . $this->db->escape($limit) . ") union

				(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('suppliers') . ".company_name, " . $this->db->dbprefix('suppliers') . ".deleted, " . $this->db->dbprefix('suppliers') . ".account_number
	      		from " . $this->db->dbprefix('suppliers') . "
	      		join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('suppliers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
	      		where company_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
	      		order by `" . $column . "` " . $orderby . " limit " . $this->db->escape($limit) . ") union

				(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('suppliers') . ".company_name, " . $this->db->dbprefix('suppliers') . ".deleted, " . $this->db->dbprefix('suppliers') . ".account_number
	    		from " . $this->db->dbprefix('suppliers') . "
	    		join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('suppliers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
	    		where CONCAT(`first_name`,' ',`last_name`)  like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
	    		order by `" . $column . "` " . $orderby . " limit " . $this->db->escape($limit) . ") union

				(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('suppliers') . ".company_name, " . $this->db->dbprefix('suppliers') . ".deleted, " . $this->db->dbprefix('suppliers') . ".account_number
	    		from " . $this->db->dbprefix('suppliers') . "
	    		join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('suppliers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
	    		where account_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
	    		order by `" . $column . "` " . $orderby . " limit " . $this->db->escape($limit) . ")
			) as search_results
			order by `" . $column . "` " . $orderby . " limit " . $this->db->escape((int) $offset) . ', ' . $this->db->escape((int) $limit);

            return $this->db->query($query);
        } else {
            $this->db->from('suppliers');
            $this->db->join('people', 'suppliers.person_id=people.person_id');
            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			company_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			account_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
            $this->db->order_by($column, $orderby);
            $this->db->limit($limit);
            $this->db->offset($offset);
            return $this->db->get();
        }
    }

    function search_count_all($search, $limit = 10000) {
        if ($this->config->item('speed_up_search_queries')) {
            $query = "
			select *
			from (
	           	(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('suppliers') . ".company_name, " . $this->db->dbprefix('suppliers') . ".deleted, " . $this->db->dbprefix('suppliers') . ".account_number
	           	from " . $this->db->dbprefix('suppliers') . "
	           	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('suppliers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
	           	where first_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
	           	order by `last_name` asc limit " . $this->db->escape($limit) . ") union

			 	(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('suppliers') . ".company_name, " . $this->db->dbprefix('suppliers') . ".deleted, " . $this->db->dbprefix('suppliers') . ".account_number
	           	from " . $this->db->dbprefix('suppliers') . "
	           	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('suppliers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
	           	where last_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
	           	order by `last_name` asc limit " . $this->db->escape($limit) . ") union

				(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('suppliers') . ".company_name, " . $this->db->dbprefix('suppliers') . ".deleted, " . $this->db->dbprefix('suppliers') . ".account_number
	         	from " . $this->db->dbprefix('suppliers') . "
	          	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('suppliers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
	          	where email like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
	          	order by `last_name` asc limit " . $this->db->escape($limit) . ") union

				(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('suppliers') . ".company_name, " . $this->db->dbprefix('suppliers') . ".deleted, " . $this->db->dbprefix('suppliers') . ".account_number
	        	from " . $this->db->dbprefix('suppliers') . "
	        	join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('suppliers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
	        	where phone_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
	        	order by `last_name` asc limit " . $this->db->escape($limit) . ") union

				(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('suppliers') . ".company_name, " . $this->db->dbprefix('suppliers') . ".deleted, " . $this->db->dbprefix('suppliers') . ".account_number
	      		from " . $this->db->dbprefix('suppliers') . "
	      		join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('suppliers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
	      		where company_name like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
	      		order by `last_name` asc limit " . $this->db->escape($limit) . ") union

				(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('suppliers') . ".company_name, " . $this->db->dbprefix('suppliers') . ".deleted, " . $this->db->dbprefix('suppliers') . ".account_number
	    		from " . $this->db->dbprefix('suppliers') . "
	    		join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('suppliers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
	    		where CONCAT(`first_name`,' ',`last_name`)  like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
	    		order by `last_name` asc limit " . $this->db->escape($limit) . ") union

				(select " . $this->db->dbprefix('people') . ".*, " . $this->db->dbprefix('suppliers') . ".company_name, " . $this->db->dbprefix('suppliers') . ".deleted, " . $this->db->dbprefix('suppliers') . ".account_number
	    		from " . $this->db->dbprefix('suppliers') . "
	    		join " . $this->db->dbprefix('people') . " ON " . $this->db->dbprefix('suppliers') . ".person_id = " . $this->db->dbprefix('people') . ".person_id
	    		where account_number like '" . $this->db->escape_like_str($search) . "%' and deleted = 0
	    		order by `last_name` asc limit " . $this->db->escape($limit) . ")
			) as search_results
			order by `last_name` asc limit " . $this->db->escape($limit);

            $result = $this->db->query($query);
            return $result->num_rows();
        } else {
            $this->db->from('suppliers');
            $this->db->join('people', 'suppliers.person_id=people.person_id');
            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			company_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			email LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			phone_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			account_number LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
            $this->db->order_by("last_name", "asc");
            $this->db->limit($limit);
            $result = $this->db->get();
            return $result->num_rows();
        }
    }

    function find_supplier_id($search) {
        if ($search) {
            $this->db->select("suppliers.person_id");
            $this->db->from('suppliers');
            $this->db->join('people', 'suppliers.person_id=people.person_id');
            $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			last_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			company_name LIKE '%" . $this->db->escape_like_str($search) . "%' or 
			email LIKE '%" . $this->db->escape_like_str($search) . "%') and deleted=0");
            $this->db->order_by("last_name", "asc");
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                return $query->row()->person_id;
            }
        }

        return null;
    }

    //hung audi 8-4-15
    //cost search
    function get_supplier_search_cost() {
        $suggestions = array();

        $this->db->from('suppliers');
        $this->db->join('people', 'suppliers.person_id=people.person_id');
        if ($this->config->item('speed_up_search_queries')) {
            $this->db->where("company_name LIKE '" . $this->db->escape_like_str($search) . "%' 
			and deleted=0");
        } else {
            $this->db->where("company_name LIKE '%" . $this->db->escape_like_str($search) . "%' 
            and deleted=0");
        }
        $this->db->order_by("company_name", "asc");
        $by_name = $this->db->get()->result();

        foreach ($by_name as $row) {
            $suggestions[] = array(
                'value' => $row->person_id,
                'label' => $row->company_name,
                'account_number' => $row->account_number,
                'cost_phone' => $row->phone_number,
            );
        }
        //only return $limit suggestions
        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

    //hung audi 9-4-15
    function get_info_supplier($supplier_id) {
        $this->db->from('suppliers');
        $this->db->join('people', 'people.person_id = suppliers.person_id');
        $this->db->join('cities', 'people.city = cities.id_city');
        $this->db->where('suppliers.person_id', $supplier_id);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->row();
        } else {
            //Get empty base parent object, as $supplier_id is NOT an supplier
            $person_obj = parent::get_info(-1);

            //Get all the fields from supplier table
            $fields = $this->db->list_fields('suppliers');

            //append those fields to base parent object, we we have a complete empty object
            foreach ($fields as $field) {
                $person_obj->$field = '';
            }

            return $person_obj;
        }
    }

    //        Loi Tran
    function get_all_supplier() {
        $this->db->join('people', 'suppliers.person_id = people.person_id');
        $this->db->order_by("company_name", "asc");
        $this->db->where('suppliers.deleted',0);
        $result = $this->db->get('suppliers');
        if ($result->num_rows() > 0) {
            return $result->result_array();
        } else
            return null;
    }

//        end Loi
    //Hưng Audi 19-10-15 ~~~ vấn vương kỷ niệm
    function get_person_search_cost($search, $limit = 1000) {
        $suggestions = array();
        //suppliers
        $this->db->join('people', 'suppliers.person_id=people.person_id');
        $this->db->where("company_name LIKE '%" . $this->db->escape_like_str($search) . "%' and deleted=0");
        $this->db->order_by("company_name", "asc");
        $by_name = $this->db->get('suppliers')->result();

        foreach ($by_name as $row) {
            $suggestions[] = array(
                'value' => $row->person_id,
                'label' => $row->company_name,
            );
        }
        //customers
        $this->db->join('people', 'customers.person_id=people.person_id');
        $this->db->where("(first_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
			last_name LIKE '" . $this->db->escape_like_str($search) . "%' or 
			CONCAT(`first_name`,' ',`last_name`) LIKE '" . $this->db->escape_like_str($search) . "%') and deleted=0");
        $this->db->order_by("first_name", "asc");
        $by_name = $this->db->get('customers')->result();

        foreach ($by_name as $row) {
            $suggestions[] = array(
                'value' => $row->person_id,
                'label' => $row->first_name . ' ' . $row->last_name,
            );
        }
        //employees
        $this->db->from('employees');
        $this->db->join('people', 'employees.person_id=people.person_id');
        $this->db->where("(first_name LIKE '%" . $this->db->escape_like_str($search)
                . "%' or last_name LIKE '%" . $this->db->escape_like_str($search)
                . "%' or CONCAT(`first_name`,' ',`last_name`) LIKE '%" . $this->db->escape_like_str($search)
                . "%') and deleted=0");
        $this->db->order_by("first_name", "asc");
        $by_name = $this->db->get()->result();

        foreach ($by_name as $row) {
            $suggestions[] = array(
                'value' => $row->person_id,
                'label' => $row->first_name . ' ' . $row->last_name,
            );
        }

        if (count($suggestions > $limit)) {
            $suggestions = array_slice($suggestions, 0, $limit);
        }
        return $suggestions;
    }

}

?>
