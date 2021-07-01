<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    private $table_name = 'erp_user';
    private $master_user_role = 'master_user_role';
    private $erp_user_roles = 'erp_user_roles';

    function __construct() {
        parent::__construct();
        $this->primaryTable = 'erp_user u';
        $this->jointable = 'erp_user_roles ur';
        $this->select_column = 'u.*,ur.user_role';
        $this->column_order = array(null, 'u.emp_code', 'u.username', 'u.mobile_no', 'u.email_id', 'u.address', 'ur.user_role', null); //set column field database for datatable orderable
        $this->column_search = array('u.emp_code', 'u.username', 'u.mobile_no', 'u.email_id', 'u.address', 'ur.user_role'); //set column field database for datatable searchable
        $this->order = array('u.id' => 'DESC'); // default order
        $this->where_condition = array('u.status' => '1');
    }

    public function insert_user($data) {
        if ($this->db->insert($this->table_name, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
            $this->load->database();
        }
        return false;
    }

    public function state() {
        $this->db->select('*');
        $this->db->where('status', 1);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_user1($id) {
        $this->db->select($this->table_name . '.*');
        $this->db->where($this->table_name . '.id', $id);
        $this->db->where($this->table_name . '.status', 1);
        $query = $this->db->get($this->table_name)->result_array();
        $i = 0;
//        foreach ($query as $val) {
//            $this->db->select('*');
//            $this->db->where('user_id', $id);
//            $query[$i]['firm'] = $this->db->get('erp_user_firms')->result_array();
//        }
        return $query;
    }

    public function get_user() {
        $this->db->select($this->table_name . '.*');
        $this->db->select($this->erp_user_roles . '.user_role');
        $this->db->join('erp_user_roles', $this->table_name . '.role=erp_user_roles.id');
        $this->db->where($this->table_name . '.status', 1);
        $query = $this->db->get($this->table_name)->result_array();
        $i = 0;
        /* foreach ($query as $val) {
          $this->db->select('erp_user_firms.firm_id');
          $this->db->where('erp_user_firms.user_id', $val['id']);
          $result = $this->db->get('erp_user_firms')->result_array();

          foreach ($result as $res) {
          $this->db->select('erp_manage_firms.firm_name as name');
          $this->db->where('erp_manage_firms.firm_id', $res['firm_id']);
          $list = $this->db->get('erp_manage_firms')->result_array();
          $list1 = call_user_func_array('array_merge', $list);
          $query[$i]['firm_name'][] = call_user_func_array('array_merge', $list);
          }
          $i++;
          } */
        return $query;
    }

    public function get_user_name() {
        $this->db->select($this->table_name . '.id,name');
        $this->db->where($this->table_name . '.status', 1);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    public function get_user_name_by_id($id) {
        $this->db->select($this->table_name . '.id,name');
        $this->db->where($this->table_name . '.status', 1);
        $this->db->where($this->table_name . '.id', $id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    public function update_user($data, $id) {

        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data)) {
            return true;
        }
        return false;
    }

    public function delete_user($id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data = array('status' => 0))) {
            return true;
        }
        return false;
    }

    public function add_duplicate_email($input) {
        $this->db->select('*');
        $this->db->where('status', 1);
        $this->db->where('email_id', $input);
        $query = $this->db->get('erp_user');
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    public function update_duplicate_email($input, $id) {
        $this->db->select('*');
        $this->db->where('status', 1);
        $this->db->where('email_id', $input);
        $this->db->where('id !=', $id);
        $query = $this->db->get('erp_user')->result_array();
        return $query;
    }

    public function get_user_role() {
        $this->db->select('*');
        $this->db->where('status', 1);
        $query = $this->db->get('erp_user_roles')->result_array();
        return $query;
    }

    /* public function get_all_firms() {
      $this->db->select('*');
      $this->db->where('status', 1);
      $query = $this->db->get('erp_manage_firms')->result_array();
      return $query;
      }

      public function get_all_firms_by_user_id($user_id) {
      $this->db->select('erp_manage_firms.firm_id,firm_name,prefix');
      $this->db->join('erp_user_firms', 'erp_user_firms.firm_id=erp_manage_firms.firm_id');
      $this->db->where('erp_user_firms.user_id', $user_id);
      $query = $this->db->get('erp_manage_firms')->result_array();
      return $query;
      }

      public function insert_firm($data) {
      if ($this->db->insert('erp_user_firms', $data)) {
      $insert_id = $this->db->insert_id();
      return $insert_id;
      }
      return false;
      }

      public function get_user_firms($id) {
      $this->db->select('*');
      $this->db->where('user_id', $id);
      $query = $this->db->get('erp_user_firms')->result_array();
      return $query;
      }

      public function delete_user_firm($id) {
      $this->db->where('user_id', $id);
      if ($this->db->delete('erp_user_firms')) {
      return true;
      }
      return false;
      } */

    public function add_duplicate_user($input) {
        $this->db->select('*');
        $this->db->where('status', 1);
        $this->db->where('username', $input);
        $query = $this->db->get('erp_user');
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    public function update_duplicate_user($input, $id) {
        $this->db->select('*');
        $this->db->where('status', 1);
        $this->db->where('username', $input);
        $this->db->where('id !=', $id);
        $query = $this->db->get('erp_user')->result_array();
        return $query;
    }

    function get_userdata() {
        $join['joins'] = array(
            array("table_name" => "erp_user_roles", "table_alias" => "ur", "join_condition" => "u.role=ur.id", "join_type" => "left")
        );

        $primaryTable = $this->primaryTable;
        $select_column = $this->select_column;
        $column_order = $this->column_order;
        $column_search = $this->column_search;
        $order = $this->order;
        $where = $this->where_condition;
        $query = $this->get_datatables($select_column, $column_order, $column_search, $order, $primaryTable, $join, $where);
        return $query;
    }

    function count_filtered_users() {
        $join['joins'] = array(
            array("table_name" => "erp_user_roles", "table_alias" => "ur", "join_condition" => "u.role=ur.id", "join_type" => "left")
        );

        $primaryTable = $this->primaryTable;
        $select_column = $this->select_column;
        $column_order = $this->column_order;
        $column_search = $this->column_search;
        $order = $this->order; // default order
        $where = $this->where_condition;
        $query = $this->count_filtered($select_column, $column_order, $column_search, $order, $primaryTable, $join, $where);
        return $query;
    }

    function count_all_users() {
        $primaryTable = $this->primaryTable;
        $query = $this->count_all($primaryTable);
        return $query;
    }

    function _get_datatables_query($select_column = "", $column_order = "", $column_search = "", $order = "", $primaryTable = "", $join = "", $where = "") {
        //Join Table
        if ($where) {
            $this->db->where($where, false, false);
        }
        if (is_array($join) && is_array($join['joins']) && count($join['joins']) > 0) {
            foreach ($join['joins'] as $jk => $jv) {
                $this->db->join($jv['table_name'] . ' AS ' . $jv['table_alias'], $jv['join_condition'], $jv['join_type']);
            }
        }
        $this->db->from($primaryTable);

        $i = 0;

        foreach ($column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i == 0) { // first loop
                    $where_search .= "(";
                }
                $string = $item;
                $str_arr = explode(".", $string);
                $where_search .= '`' . $str_arr[0] . "`" . '.' . "`" . $str_arr[1] . "` like '%" . $_POST['search']['value'] . "%'";
                if ((count($column_search) - 1) != $i)
                    $where_search .= ' OR ';
                if ((count($column_search) - 1) == $i)
                    $where_search .= ")";
            }
            $i++;
        }
        if ($where_search != '')
            $this->db->where($where_search);
        if (isset($_POST['order']) && $column_order[$_POST['order']['0']['column']] != null) { // here order processing
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($select_column = "", $column_order = "", $column_search = "", $order = "", $primaryTable = "", $join = "", $where = "") {
        $this->db->select($select_column);
        $this->_get_datatables_query($select_column, $column_order, $column_search, $order, $primaryTable, $join, $where);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($select_column = "", $column_order = "", $column_search = "", $order = "", $primaryTable = "", $join = "", $where = "") {
        $this->_get_datatables_query($select_column, $column_order, $column_search, $order, $primaryTable, $join, $where);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all($primaryTable = "") {
        $this->db->from($primaryTable);
        return $this->db->count_all_results();
    }

}
