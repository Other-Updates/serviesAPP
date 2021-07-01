<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product_model extends CI_Model {

    private $table_name = 'erp_product';
    private $increment_table = 'increment_table';

    function __construct() {
        parent::__construct();
        $this->primaryTable = 'erp_product p';
        $this->select_column = 'p.*';
        $this->column_order = array(null, 'p.hsn_sac', 'p.model_no', 'p.product_name', 'p.product_description', 'p.min_qty', 'p.selling_price', null, null); //set column field database for datatable orderable
        $this->column_search = array('p.hsn_sac', 'p.model_no', 'p.product_name', 'p.product_description', 'p.min_qty', 'p.selling_price'); //set column field database for datatable searchable
        $this->order = array('p.id' => 'DESC'); // default order
        $this->where_condition = array('p.status' => '1');
        $this->load->model('masters/user_model');
    }

    public function insert_product($data) {
        if ($this->db->insert($this->table_name, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return false;
    }

    public function update_increment($data) {
        $this->db->where($this->increment_table . '.id', 13);
        if ($this->db->update($this->increment_table, $data)) {
            return true;
        }
        return false;
    }

    public function get_product() {
        $this->db->select($this->table_name . '.*');
        $query = $this->db->get($this->table_name)->result_array();
        return $query;
    }

    public function get_product_by_id($id) {
        $this->db->select($this->table_name . '.*');
        $this->db->where($this->table_name . '.id', $id);
        $query = $this->db->get($this->table_name)->result_array();
        return $query;
    }

    public function update_product($data, $id) {

        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data)) {
            return true;
        }
        return false;
    }

    public function delete_product($id) {
        $this->db->where('id', $id);
        if ($this->db->delete('erp_product')) {
            return true;
        }
        return false;
    }

    function add_duplicate_product($input) {
        $this->db->select('*');
        $this->db->where('model_no', $input);
        $this->db->where('status', 1);
        $query = $this->db->get('erp_product');

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    function update_duplicate_product($input, $id) {

        $this->db->select('*');
        $this->db->where('model_no', $input);
        $this->db->where('id !=', $id);
        $this->db->where('status', 1);
        $query = $this->db->get('erp_product')->result_array();
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

    function get_vendor_last_po_details_by_product_id($id, $brand_id, $cat_id) {
        $this->db->select('erp_po_details.quantity,erp_po.po_no,erp_po.supplier');
        $this->db->select('vendor.store_name,vendor.name');
        $this->db->where('erp_po_details.product_id', $id);
        $this->db->where('erp_po_details.category', $cat_id);
        $this->db->where('erp_po_details.brand', $brand_id);
        $this->db->join('erp_po', 'erp_po.id=erp_po_details.po_id');
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');
        $this->db->join('erp_product', 'erp_product.id=erp_po_details.product_id');
        $this->db->order_by('erp_po.id', 'desc');
        $query = $this->db->get('erp_po_details');

        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

}
