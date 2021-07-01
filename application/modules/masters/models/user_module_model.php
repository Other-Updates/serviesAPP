<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_module_model extends CI_Model {

    private $table_name = 'erp_user_modules';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insert_user_module($data) {
        if ($this->db->insert($this->table_name, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return FALSE;
    }

    function update_user_module($data, $id) {
        $data['updated_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function delete_user_module($id) {
        $this->db->where('id', $id);
        if ($this->db->delete($this->table_name)) {
            return TRUE;
        }
        return FALSE;
    }

    function get_user_module_by_id($id) {
        $this->db->select($this->table_name . '.*');
        $this->db->where($this->table_name . '.id', $id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_all_user_modules() {
        $this->db->select($this->table_name . '.*');
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_user_module_by_name($user_module_name) {
        $this->db->select($this->table_name . '.*');
        $this->db->where('LCASE(user_module_name)', strtolower($user_module_name));
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function is_user_module_name_available($user_module_name, $id = NULL) {
        $this->db->select($this->table_name . '.id');
        $this->db->where('LCASE(user_module_name)', strtolower($user_module_name));
        if (!empty($id))
            $this->db->where('id !=', $id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function insert_all_user_modules() {
        $this->delete_all_user_modules();

        $module_array = array(
            array('user_module_name' => 'Dashboard', 'user_module_key' => 'dashboard'),
            array('user_module_name' => 'Masters', 'user_module_key' => 'masters'),
            array('user_module_name' => 'Enquiry', 'user_module_key' => 'enquiry'),
            array('user_module_name' => 'Quotation', 'user_module_key' => 'quotation'),
            array('user_module_name' => 'Purchase Order', 'user_module_key' => 'purchase_order'),
            array('user_module_name' => 'Purchase Return', 'user_module_key' => 'purchase_return'),
            array('user_module_name' => 'Purchase Receipt', 'user_module_key' => 'purchase_receipt'),
            array('user_module_name' => 'Stock', 'user_module_key' => 'stock'),
            array('user_module_name' => 'Job', 'user_module_key' => 'project_cost'),
            array('user_module_name' => 'Sales Return', 'user_module_key' => 'sales_return'),
            array('user_module_name' => 'Receipt', 'user_module_key' => 'receipt'),
            array('user_module_name' => 'Service and Repair', 'user_module_key' => 'service'),
            array('user_module_name' => 'Reports', 'user_module_key' => 'reports'),
        );
        if (!empty($module_array)) {
            foreach ($module_array as $list) {
                $insert = $this->db->insert($this->table_name, $list);
            }
        }
        return FALSE;
    }

    function delete_all_user_modules() {
        $SQL = 'TRUNCATE TABLE erp_user_modules';
        if ($this->db->query($SQL)) {
            return TRUE;
        }
        return FALSE;
    }

}
