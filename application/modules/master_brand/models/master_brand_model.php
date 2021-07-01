<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * master_model
 *
 * This model represents admin access. It operates the following tables:
 * admin,
 *
 * @package	i2_soft
 * @author	Elavarasan
 */
class Master_brand_model extends CI_Model {

    private $table_name = 'erp_brand';
    private $table_name1 = 'increment_table';

    function __construct() {
        parent::__construct();
        $this->primaryTable = 'erp_brand b';
        $this->select_column = 'b.*';
        $this->column_order = array(null, 'b.brands', null); //set column field database for datatable orderable
        $this->column_search = array('b.brands'); //set column field database for datatable searchable
        $this->order = array('b.id' => 'DESC'); // default order
        $this->where_condition = array('b.status' => '1');
        $this->load->model('masters/user_model');
    }

    function insert_brand($data) {
        if ($this->db->insert($this->table_name, $data)) {
            return true;
        }
        return false;
    }

    function get_brand() {
        $this->db->select('*');
        $this->db->where('status', 1);
        $query = $this->db->get($this->table_name)->result_array();
        return $query;
    }

    function update_brand($data, $id) {

        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data)) {
            return true;
        }
        return false;
    }

    function delete_master_brand($id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data = array('status' => 0))) {
            return true;
        }
        return false;
    }

    function add_duplicate_brandname($input) {
        $this->db->select('*');
        $this->db->where('brands', $input);
        $this->db->where('status', 1);
        $query = $this->db->get('erp_brand');
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
        return false;
    }

    function update_duplicate_brandname($input, $id) {
        //echo $input;
        //echo $id;
        //exit;
        $this->db->select('*');
        $this->db->where('brands', $input);
        $this->db->where('id !=', $id);
        $this->db->where('status', 1);
        $query = $this->db->get('erp_brand')->result_array();


        return $query;
    }

    function get_clr($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('erp_brand')->result_array();
        return $query;
    }

    function get_datatables() {
        $primaryTable = $this->primaryTable;
        $select_column = $this->select_column;
        $column_order = $this->column_order;
        $column_search = $this->column_search;
        $order = $this->order;
        $where = $this->where_condition;
        $query = $this->user_model->get_datatables($select_column, $column_order, $column_search, $order, $primaryTable, $join = "", $where);
        return $query;
    }

    function count_filtered() {
        $primaryTable = $this->primaryTable;
        $select_column = $this->select_column;
        $column_order = $this->column_order;
        $column_search = $this->column_search;
        $order = $this->order; // default order
        $where = $this->where_condition;
        $query = $this->user_model->count_filtered($select_column, $column_order, $column_search, $order, $primaryTable, $join = "", $where);

        return $query;
    }

    function count_all() {
        $primaryTable = $this->primaryTable;
        $query = $this->user_model->count_all($primaryTable);
        return $query;
    }

}
