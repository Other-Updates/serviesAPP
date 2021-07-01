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
class enquiry_model extends CI_Model {

    private $erp_enquiry = 'erp_enquiry';
    private $increment_table = 'increment_table';
    private $erp_user = 'erp_user';
    private $erp_category = 'erp_category';
    private $customer = 'customer';

    function __construct() {
        parent::__construct();
        $this->primaryTable = 'erp_enquiry e';
        $this->joinTable = 'customer c';
        $this->select_column = 'e.*,c.name,c.address1,c.email_id,c.mobil_number,c.mobile_number_2';
        $this->column_order = array(null, 'e.enquiry_no', 'e.customer_name', 'e.customer_address', 'e.created_date', 'e.followup_date', 'e.assigned_to', 'e.enquiry_about', 'e.status', 'e.remarks', null); //set column field database for datatable orderable
        $this->column_search = array('e.enquiry_no', 'e.customer_name', 'e.customer_address', 'e.created_date', 'e.followup_date', 'e.assigned_to', 'e.enquiry_about', 'e.status', 'e.remarks'); //set column field database for datatable searchable
        $this->order = array('e.id' => 'DESC'); // default order
        $user_info = $this->user_auth->get_from_session('user_info');
        if ($user_info[0]['role'] == 5) {
            $this->where_condition = array('e.created_by' => $user_info[0]['id'], 'enquiry_status' => 1);
        } else {
            $this->where_condition = array('enquiry_status' => 1);
        }
        $this->load->model('masters/user_model');
    }

    public function insert_enquiry($data) {

        if ($this->db->insert($this->erp_enquiry, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function update_enquiry_no($data, $id) {
        $this->db->where($this->erp_enquiry . '.id', $id);
        if ($this->db->update($this->erp_enquiry, $data)) {
            return true;
        }
        return false;
    }

    public function update_increment($id) {
        $this->db->where($this->increment_table . '.id', 11);
        if ($this->db->update($this->increment_table, $id)) {
            return true;
        }
        return false;
    }

    public function add_duplicate_email($input) {
        $this->db->select('*');
        $this->db->where('status', 1);
        $this->db->where('customer_email', $input);
        $query = $this->db->get($this->erp_enquiry);
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    public function get_all_enquiry() {
        $this->db->select('*');
        $user_info = $this->user_auth->get_from_session('user_info');
        if ($user_info[0]['role'] == 5) {
            $this->db->where('created_by', $user_info[0]['id']);
            $query = $this->db->get($this->erp_enquiry)->result_array();
        } else {
            $query = $this->db->get($this->erp_enquiry)->result_array();
        }
        return $query;
    }

    public function get_all_categories() {
        $this->db->select('*');
        $this->db->where('is_checked', 1);
        $this->db->where('eStatus', 1);
        $query = $this->db->get($this->erp_category)->result_array();
        return $query;
    }

    public function get_all_enquiry_by_id($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get($this->erp_enquiry)->result_array();
        return $query;
    }

    public function get_all_enquiry_details($id) {
        $this->db->select('*');
        $this->db->where('created_by', $id);
        $user_info = $this->user_auth->get_from_session('user_info');
        if ($user_info[0]['role'] == 5) {

        }
        $query = $this->db->get($this->erp_enquiry)->result_array();
        return $query;
    }

    public function update_enquiry($data, $id) {
        $this->db->where($this->erp_enquiry . '.id', $id);
        if ($this->db->update($this->erp_enquiry, $data)) {
            return true;
        }
        return false;
    }

    public function delete_enquiry($id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->erp_enquiry, $data = array('enquiry_status' => 0))) {
            return true;
        }
        return false;
    }

    function get_datatables() {
        $join['joins'] = array(
            array("table_name" => "customer", "table_alias" => "c", "join_condition" => "c.id=e.customer_id", "join_type" => "left"),
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

    function count_all() {
        $primaryTable = $this->primaryTable;
        $query = $this->user_model->count_all($primaryTable);
        return $query;
    }

    function count_filtered() {
        $join['joins'] = array(
            array("table_name" => "customer", "table_alias" => "c", "join_condition" => "c.id=e.customer_id", "join_type" => "left"),
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

    function get_assigned_user($id) {
        $this->db->select('erp_user.name');
        $this->db->where('erp_user.id', $id);
        $query = $this->db->get($this->erp_user)->result_array();

        return $query[0]['name'];
    }

    public function get_all_customers() {
        $this->db->select('name, id, mobil_number, email_id, address1, store_name, tin, credit_days, credit_limit, temp_credit_limit, approved_by');
        $this->db->where($this->customer . '.status', 1);
        $this->db->where_in($this->customer . '.firm_id', $firm_id);
        $query = $this->db->get($this->customer)->result_array();
        return $query;
    }

    public function get_quotation_link($q_no) {
        $q_no = trim($q_no);
        $this->db->select('id');
        $this->db->where('q_no', $q_no);
        $query = $this->db->get('erp_quotation')->result_array();

        return $query[0]['id'];
    }

    public function get_all_cust_enquiry_by_id($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get($this->erp_enquiry)->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('customer.name,customer.address1,customer.email_id,customer.mobil_number,customer.mobile_number_2');
            $this->db->where('id', intval($val['customer_id']));
            $query[$i]['customer'] = $this->db->get('customer')->result_array();
            $i++;
        }
        return $query;
    }

    public function update_customer($data, $id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->customer, $data)) {
            return true;
        }
        return false;
    }

    public function get_pending_leads_count() {
        $this->db->select('*');
        $where = '(erp_enquiry.status = "leads_follow_up" OR erp_enquiry.status = "quotation_follow_up")';
        $this->db->where($where);
        $this->db->where('enquiry_status', 1);
        $query = $this->db->get($this->erp_enquiry);

        return $query->num_rows();
    }

}
