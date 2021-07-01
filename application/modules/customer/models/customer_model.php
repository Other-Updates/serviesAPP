<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Admin_model
 *
 * This model represents admin access. It operates the following tables:
 * admin,
 *
 * @package	i2_soft
 * @author	Elavarasan
 */
class Customer_model extends CI_Model {

    private $table_name = 'customer';
    private $table_name1 = 'master_state';
    private $table_name2 = 'agent';
    private $erp_user = 'erp_user';

    function __construct() {
        parent::__construct();
        $this->primaryTable = 'customer c';
        $this->jointable = 'master_state ms';
        $this->jointable1 = 'erp_user u';
        $this->select_column = 'c.*,ms.state,u.name AS staff_name';
        $this->column_order = array(null, null, 'c.store_name', 'c.name', 'c.mobil_number', 'c.city', 'c.tin', 'c.email_id', 'u.name', null); //set column field database for datatable orderable
        $this->column_search = array('c.store_name', 'c.name', 'c.mobil_number', 'c.city', 'c.tin', 'c.email_id', 'u.name'); //set column field database for datatable searchable
        $this->order = array('c.id' => 'DESC'); // default order
        $this->where_condition = array('c.status' => '1');
        $this->load->model('masters/user_model');
    }

    function insert_customer($data) {
        if ($this->db->insert($this->table_name, $data)) {
            return true;
        }
        return false;
    }

    function insert_state($data) {
        if ($this->db->insert($this->table_name1, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    function state() {
        $this->db->select('*');
        $this->db->where('status', 1);
        $query = $this->db->get($this->table_name1);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    function get_customer1($id) {
        $this->db->select($this->table_name . '.*');
//        $this->db->select('master_state.state,master_state.id as m_s_id,st,cst,vat');
        $this->db->where($this->table_name . '.id', $id);
        $this->db->where($this->table_name . '.status', 1);
//        $this->db->join('master_state', 'master_state.id=' . $this->table_name . '.state_id');
        $query = $this->db->get($this->table_name)->result_array();
        return $query;
    }

    function get_customer() {
        $this->db->select($this->table_name . '.*');
        $this->db->where($this->table_name . '.status', 1);
        $query = $this->db->get($this->table_name)->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('master_state.state');
            $this->db->where('master_state.id', intval($val['state_id']));
            $query[$i]['state'] = $this->db->get('master_state')->result_array();
            $i++;
        }
        $j = 0;
        foreach ($query as $val) {
            $this->db->select('erp_user.username as staff_name');
            $this->db->where('erp_user.id', intval($val['staff_id']));
            $query[$j]['staff_name'] = $this->db->get('erp_user')->result_array();
            $j++;
        }

        return $query;
    }

    function update_customer($data, $id) {

        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data)) {

            return true;
        }
        return false;
    }

    function delete_customer($id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data = array('status' => 0))) {
            return true;
        }
        return false;
    }

    function add_duplicate_email($input) {

        $this->db->select('*');
        $this->db->where('status', 1);
        $this->db->where('email_id', $input);
        $query = $this->db->get('customer');
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    function update_duplicate_email($input, $id) {
        $this->db->select('*');
        $this->db->where('status', 1);
        $this->db->where('email_id', $input);
        $this->db->where('id !=', $id);
        $query = $this->db->get('customer')->result_array();
        return $query;
    }

    function get_customer_by_id($id) {
        $this->db->select($this->table_name . '.store_name');
        $this->db->where($this->table_name . '.id', $id);
        $query = $this->db->get($this->table_name)->result_array();
        return $query;
    }

    function get_customer_with_agent($id) {
        $this->db->select($this->table_name . '.*');
        $this->db->select('agent.name as agentname');
        $this->db->where($this->table_name . '.id', $id);
        $this->db->where($this->table_name . '.status', 1);
        $this->db->join('agent', 'agent.id=' . $this->table_name . '.agent_name');
        $query = $this->db->get($this->table_name)->result_array();
        return $query;
    }

    public function get_all_staff_name() {
        $this->db->select('*');
        $this->db->where($this->erp_user . '.status', 1);
        $this->db->order_by('name');
        $query = $this->db->get($this->erp_user)->result_array();
        return $query;
    }

    function get_datatables() {
        $join['joins'] = array(
            array("table_name" => "master_state", "table_alias" => "ms", "join_condition" => "ms.id=c.state_id", "join_type" => "left"),
            array("table_name" => "erp_user", "table_alias" => "u", "join_condition" => "u.id=c.staff_id", "join_type" => "left"),
        );

        $primaryTable = $this->primaryTable;
        $select_column = $this->select_column;
        $column_order = $this->column_order;
        $column_search = $this->column_search;
        $order = $this->order;
        $where = $this->where_condition;
        $query = $this->user_model->get_datatables($select_column, $column_order, $column_search, $order, $primaryTable, $join, $where);
        return $query;
    }

    function count_filtered() {
        $join['joins'] = array(
            array("table_name" => "master_state", "table_alias" => "ms", "join_condition" => "ms.id=c.state_id", "join_type" => "left"),
            array("table_name" => "erp_user", "table_alias" => "u", "join_condition" => "u.id=c.staff_id", "join_type" => "left"),
        );
        $primaryTable = $this->primaryTable;
        $select_column = $this->select_column;
        $column_order = $this->column_order;
        $column_search = $this->column_search;
        $order = $this->order; // default order
        $where = $this->where_condition;
        $query = $this->user_model->count_filtered($select_column, $column_order, $column_search, $order, $primaryTable, $join, $where);
        return $query;
    }

    function count_all() {
        $primaryTable = $this->primaryTable;
        $query = $this->user_model->count_all($primaryTable);
        return $query;
    }

    function is_mobile_number_available($mobile, $id = '') {

        $this->db->select($this->table_name . '.id');
        $this->db->where($this->table_name . '.status', 1);
        $this->db->where('LCASE(mobil_number)', strtolower($mobile));
        if (!empty($id))
            $this->db->where('id !=', $id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return NULL;
    }

    public function check_duplicate_email($input) {
        $this->db->select('*');
        $this->db->where('status', 1);
        $this->db->where('email_id', $input['email']);
        $query = $this->db->get('customer');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    public function check_duplicate_mobile_num($input) {
        $this->db->select('*');
        $this->db->where('status', 1);
        $this->db->where('mobil_number', $input['number']);
        $query = $this->db->get('customer');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
    }

    function insert_customer_data($data) {
        if ($this->db->insert($this->table_name, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

}
