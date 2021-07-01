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
class Master_category_model extends CI_Model {

    private $defect_type = "erp_category";
    private $defect_corrective_action = "erp_sub_category";
    private $defect_type_corrective_action = "erp_category_sub_category";

    //private $table_name	= 'master_category';
    function __construct() {
        parent::__construct();
        $this->primaryTable = 'erp_category c';
        $this->select_column = 'c.*';
        $this->column_order = array(null, 'c.categoryName', null); //set column field database for datatable orderable
        $this->column_search = array('c.categoryName'); //set column field database for datatable searchable
        $this->order = array('c.cat_id' => 'DESC'); // default order
        $this->where_condition = array('c.eStatus' => '1');
        $this->load->model('masters/user_model');
    }

    function insert_master_category($data) {
        $this->db->insert($this->table_name, $data);
    }

    public function get_all_category() {
        $this->db->select('*');
        $this->db->where('eStatus', 1);
        $query = $this->db->get($this->defect_type);
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
        return false;
    }

    public function update_category($data, $id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data)) {
            return true;
        }
        return false;
    }

    function delete_master_category($id) {
        //print_r($id);exit;
        $this->db->where('cat_id', $id);
        if ($this->db->update($this->defect_type, $data = array('eStatus' => 0))) {
            return true;
        }
        return false;
    }

    function add_duplicate_category($input) {
        $this->db->select('*');
        $this->db->where('categoryName', $input);
        $this->db->where('eStatus', 1);
        $query = $this->db->get('erp_category');
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    function update_duplicate_category($input, $id) {
        $this->db->select('*');
        $this->db->where('categoryName', $input);
        $this->db->where('cat_id !=', $id);
        $this->db->where('eStatus', 1);
        $query = $this->db->get('erp_category')->result_array();


        return $query;
    }

    function insert_defect($data) {
        if ($this->db->insert($this->defect_type, $data)) {
            $insert_id = $this->db->insert_id();
            //$this->db->last_query(); exit();
            return $insert_id;
        }
        return FALSE;
    }

    function update_defect($data) {
        //  echo "<pre>"; print_r($data); exit;
        $this->db->where('cat_id', $data['cat_id']);
        $this->db->update($this->defect_type, $data);
        return true;
    }

    function get_all_corrective_action() {
        $this->db->select('*');
        $this->db->where('status', 1);
        $query = $this->db->get($this->defect_corrective_action)->result_array();
        return $query;
    }

    function get_all_action_by_id($defectType_id) {
        $this->db->select('actionId');
        $this->db->where($this->defect_type_corrective_action . '.cat_id', $defectType_id);
        $query = $this->db->get($this->defect_type_corrective_action)->result_array();
        return $query;
    }

    function get_all_s_cat_by_id($defectType_id) {
        $this->db->select('erp_sub_category.actionId,erp_sub_category.sub_categoryName');
        $this->db->where($this->defect_type_corrective_action . '.cat_id', $defectType_id);
        $this->db->join('erp_sub_category', 'erp_sub_category.actionId=' . $this->defect_type_corrective_action . '.actionId');
        $query = $this->db->get($this->defect_type_corrective_action)->result_array();
        return $query;
    }

    function get_all_defect_type_data($defectType_id) {
        $this->db->where($this->defect_type . '.cat_id', $defectType_id);
        $query = $this->db->get($this->defect_type)->result_array();
        return $query;
    }

    function insert_action($data) {
        //echo"<pre>"; print_r($data); exit;
        if ($this->db->insert($this->defect_corrective_action, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return FALSE;
    }

    function insert_defect_type_corrective_action($data, $defect_id) {
        $this->db->where('cat_id', $defect_id);
        $this->db->delete($this->defect_type_corrective_action);

        if ($this->db->insert_batch($this->defect_type_corrective_action, $data)) {
            return true;
        }
        return FALSE;
    }

    function update_defect_type_corrective_action($data) {

        $this->db->where('defectTypeId', $data['defectTypeId']);
        $this->db->where('actionId', $data['actionId']);
        $q = $this->db->get($this->defect_type_corrective_action);

        if ($q->num_rows() > 0) {
            $this->db->where('defectTypeId', $data['defectTypeId']);
            $this->db->update($this->defect_type_corrective_action, $data);
            return true;
        } else {
            $this->db->insert($this->defect_type_corrective_action, $data);
            return true;
        }

        return FALSE;
    }

    function update_action_by_ids($id, $data) {
        $this->db->where('actionId', $id);
        $this->db->update($this->defect_corrective_action, $data);
        return true;
    }

    public function delete_action_by_ids($id) {
        $this->db->where('actionId', $id);
        //$this->db->where('addBy',$this->session->userdata('iUserId'));
        $this->db->delete($this->defect_corrective_action);
        return true;
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
