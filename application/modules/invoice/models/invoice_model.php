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
class Invoice_model extends CI_Model {

    private $table_name1 = 'sales_order';
    private $table_name2 = 'sales_order_details';
    private $table_name3 = 'customer';
    private $table_name4 = 'master_style';
    private $table_name5 = 'master_style_size';
    private $table_name6 = 'vendor';
    private $table_name7 = 'package';
    private $table_name8 = 'package_details';
    private $table_name9 = 'invoice';

    function __construct() {
        parent::__construct();
    }

    public function check_so_no($po) {
        $this->db->select('inv_no');
        $this->db->where('inv_no', $po);
        $query = $this->db->get('invoice')->result_array();
        return $query;
    }

    public function insert_invoice($data) {
        if ($this->db->insert($this->table_name9, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function get_invoice_by_id($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('invoice')->result_array();
        return $query;
    }

    public function get_all_invoice($serch_data = NULL) {

        if (isset($serch_data) && !empty($serch_data)) {
            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';


            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {

                $this->db->where('package.customer', $serch_data['customer']);
            }
            if (!empty($serch_data['ps_no'])) {
                $this->db->where('package.package_slip', $serch_data['ps_no']);
            }
            if (!empty($serch_data['inv_no'])) {
                $this->db->where($this->table_name9 . '.inv_no', $serch_data['inv_no']);
            }
            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->table_name9 . ".inv_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->table_name9 . ".inv_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->table_name9 . ".inv_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->table_name9 . ".inv_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        } else {
            $from_y = $to_y = 0;
            if (date('m') > 3) {
                $from_y = date('Y');
                $to_y = date('Y') + 1;
            } else {
                $from_y = date('Y') - 1;
                $to_y = date('Y');
            }
            $from = $from_y . '-04-01';
            $to = $to_y . '-03-31';
            $this->db->where($this->table_name9 . ".receipt_status !=", 1);
            $this->db->or_where("DATE_FORMAT(" . $this->table_name9 . ".inv_date,'%Y-%m-%d') >='" . $from . "' AND DATE_FORMAT(" . $this->table_name9 . ".inv_date,'%Y-%m-%d') <= '" . $to . "'");
        }
        $this->db->select('invoice.*');
        $this->db->select('package.package_slip');
        $this->db->select('customer.name,store_name');
        $this->db->order_by('invoice.id', 'desc');
        $this->db->join('package', 'package.id=invoice.package_id');
        $this->db->join('customer', 'customer.id=package.customer');
        $query = $this->db->get('invoice')->result_array();
        return $query;
    }

    public function get_all_ps_no($po) {
        $this->db->select('package_slip');
        $this->db->like('package_slip', $po['q']);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get($this->table_name7)->result_array();
        return $query;
    }

    public function get_invoice_for_receipt($c_id) {
        $this->db->select('invoice.inv_no,invoice.id,inv_date,org_value,total_value');
        $this->db->where('receipt_status', 0);
        $this->db->where('customer.id', $c_id);
        $this->db->join('package', 'package.id=invoice.package_id');
        $this->db->join('customer', 'customer.id=package.customer');
        $query = $this->db->get($this->table_name9)->result_array();
        return $query;
    }

    public function get_invoice_for_receipt1($data) {
        if (isset($data['inv_id']) && !empty($data['inv_id'])) {
            $this->db->select('invoice.inv_no,invoice.id,inv_date,org_value,total_value');
            $this->db->where('receipt_status', 0);
            $this->db->where('customer.id', $data['c_id']);
            $this->db->where_in('invoice.id', $data['inv_id']);
            $this->db->join('package', 'package.id=invoice.package_id');
            $this->db->join('customer', 'customer.id=package.customer');
            $query = $this->db->get($this->table_name9)->result_array();
            return $query;
        }
    }

    public function get_pending_receipt_count() {
        $this->db->select('erp_invoice.id');
        $this->db->where('erp_invoice.payment_status', 'Pending');
        $this->db->where('erp_invoice.estatus', 1);
        $query = $this->db->get('erp_invoice');

        return $query->num_rows();
    }

}
