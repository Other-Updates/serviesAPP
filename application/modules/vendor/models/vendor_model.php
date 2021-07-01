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
class Vendor_model extends CI_Model {

    private $table_name = 'vendor';
    private $table_name1 = 'master_state';

    function __construct() {
        parent::__construct();
        $this->primaryTable = 'vendor v';
        $this->joinTable = 'master_state ms';
        $this->select_column = 'v.id,ms.state,v.name,v.store_name,v.city,v.mobil_number,v.email_id,v.bank_name,v.bank_branch,v.account_num,v.ifsc,v.tin';
        $this->column_order = array(null, null, 'v.store_name', 'v.name', 'v.mobil_number', 'v.city', 'v.tin', 'v.email_id', null); //set column field database for datatable orderable
        $this->column_search = array('v.store_name', 'v.name', 'v.mobil_number', 'v.city', 'v.tin', 'v.email_id'); //set column field database for datatable searchable
        $this->order = array('v.id' => 'DESC'); // default order
        $this->where_condition = array('v.status' => '1');
        $this->load->model('masters/user_model');
    }

    function datatables() {
        $join['joins'] = array(
            array("table_name" => "master_state", "table_alias" => "ms", "join_condition" => "ms.id=v.state_id", "join_type" => "left"),
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

    function count() {
        $primaryTable = $this->primaryTable;
        $query = $this->user_model->count_all($primaryTable);
        return $query;
    }

    function count_filter() {
        $join['joins'] = array(
            array("table_name" => "master_state", "table_alias" => "ms", "join_condition" => "ms.id=v.state_id", "join_type" => "left"),
        );
        $primaryTable = $this->primaryTable;
        $select_column = $this->select_column;
        $column_order = $this->column_order;
        $column_search = $this->column_search;
        $order = $this->order;
        $where = $this->where_condition;
        $query = $this->user_model->count_filtered($select_column, $column_order, $column_search, $order, $primaryTable, $join, $where);
        return $query;
    }

    function insert_vendor($data) {

        if ($this->db->insert($this->table_name, $data)) {
            return true;
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

    function get_vendor1($id) {
        $this->db->select($this->table_name . '.*');
        $this->db->select('master_state.state');
        $this->db->where($this->table_name . '.id', $id);
        $this->db->where($this->table_name . '.status', 1);
        $this->db->join('master_state', 'master_state.id=' . $this->table_name . '.state_id');
        $query = $this->db->get($this->table_name)->result_array();
        return $query;
    }

    function get_vendor() {
        $this->db->select($this->table_name . '.*');
        $this->db->select('master_state.state');
        $this->db->where($this->table_name . '.status', 1);
        $this->db->join('master_state', 'master_state.id=' . $this->table_name . '.state_id');
        $query = $this->db->get($this->table_name)->result_array();
        return $query;
    }

    function update_vendor($data, $id) {

        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data)) {
            return true;
        }
        return false;
    }

    function delete_vendor($id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data = array('status' => 0))) {
            return true;
        }
        return false;
    }

    function add_duplicate_mail($input) {

        $this->db->select('*');
        $this->db->where('status', 1);
        $this->db->where('email_id', $input);
        $query = $this->db->get(' vendor');
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    function update_duplicate_mail($input, $id) {
        $this->db->select('*');
        $this->db->where('status', 1);
        $this->db->where('email_id', $input);
        $this->db->where('id !=', $id);
        $query = $this->db->get('vendor')->result_array();
        return $query;
    }

    function is_mobile_number_available($mobile, $id = '') {

        $this->db->select($this->table_name . '.id');
        $this->db->where($this->table_name . '.status', 1);
        $this->db->where('LCASE(mobil_number)', strtolower($mobile));
//        $this->db->or_where('LCASE(mobile_number_2)', strtolower($mobile));
//        $this->db->or_where('LCASE(mobile_number_3)', strtolower($mobile));
        if (!empty($id))
            $this->db->where('id !=', $id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return NULL;
    }

}
