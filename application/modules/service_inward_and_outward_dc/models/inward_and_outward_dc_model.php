<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inward_and_outward_dc_model extends CI_Model {

    private $erp_inward_outward_dc = 'erp_inward_outward_dc_details';
    private $erp_service_dc = 'erp_service_dc';

    function __construct() {
        parent::__construct();
    }

    public function insert_service_dc($data) {
        if ($this->db->insert($this->erp_service_dc, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function insert_inward_outward_dc_details($data) {

        $this->db->insert_batch($this->erp_inward_outward_dc, $data);
        return true;
    }

    function get_datatables($search_data) {

        $this->_get_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_service_dc')->result_array();
        return $query;
    }

    function _get_datatables_query($serch_data = array()) {
        $this->db->select('erp_service_dc.*,erp_invoice.inv_id as invoice_no,erp_invoice.created_date as inv_date');
        $this->db->join('erp_invoice', 'erp_invoice.id=erp_service_dc.inv_id', 'LEFT');
        $i = 0;
        $column_order = array(null, 'erp_service_dc.dc_no', null, 'erp_service_dc.project', 'erp_service_dc.service_type', 'erp_service_dc.total_qty', 'erp_service_dc.created_date', null);
        $column_search = array('erp_service_dc.dc_no', 'erp_service_dc.project', 'erp_service_dc.service_type', 'erp_service_dc.total_qty', 'erp_service_dc.created_date');
        $order = array('erp_service_dc.id' => 'DESC');

        foreach ($column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i == 0) { // first loop
                    $where .= "(";
                }
                $string = $item;
                $str_arr = explode(".", $string);

                $where .= '`' . $str_arr[0] . "`" . '.' . "`" . $str_arr[1] . "` like '%" . $_POST['search']['value'] . "%'";
                if ((count($column_search) - 1) != $i)
                    $where .= ' OR ';
                if ((count($column_search) - 1) == $i)
                    $where .= ")";
            }
            $i++;
        }
        if ($where != '')
            $this->db->where($where);
        if (isset($_POST['order']) && $column_order[$_POST['order']['0']['column']] != null) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get('erp_service_dc');
        return $query->num_rows();
    }

    function count_all() {
        $this->_get_datatables_query();
        $this->db->from('erp_service_dc');
        return $this->db->count_all_results();
    }

    public function get_all_invoice_by_id($id) {
        $this->db->select('customer.id as customer,customer.state_id,customer.store_name, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_invoice.total_qty,erp_invoice.tax,erp_invoice.tax_label,'
                . 'erp_invoice.net_total,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,erp_invoice.warranty_from,erp_invoice.warranty_to,erp_invoice.created_date,erp_invoice.q_id,erp_invoice.id,erp_invoice.is_gst,erp_invoice.advance');
        $this->db->where('erp_invoice.id', $id);
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
        $query = $this->db->get('erp_invoice')->result_array();
        return $query;
    }

    public function get_all_invoice_details_by_id($id) {
        $this->db->select('erp_product.id,erp_product.product_name,'
                . 'erp_invoice_details.category,erp_invoice_details.product_id,erp_invoice_details.brand,erp_invoice_details.quantity,'
                . 'erp_invoice_details.per_cost,erp_invoice_details.tax,erp_invoice_details.sub_total,erp_product.model_no,erp_product.product_image,'
                . 'erp_invoice_details.product_description,erp_product.type,erp_invoice_details.gst,erp_invoice_details.igst,erp_invoice_details.created_date');
        $this->db->where('erp_invoice_details.in_id', intval($id));
        $this->db->join('erp_product', 'erp_product.id=erp_invoice_details.product_id');

        $query = $this->db->get('erp_invoice_details')->result_array();

        $i = 0;
        foreach ($query as $val) {
            $this->db->select('erp_stock.quantity');
            $this->db->where('product_id', $val['product_id']);
            $query[$i]['stock'] = $this->db->get('erp_stock')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_service_dc_by_id($id) {
        $this->db->select('erp_invoice.inv_id as invoice_no,erp_service_dc.*,customer.id as customer,customer.state_id,customer.store_name, customer.name,customer.mobil_number,customer.email_id,customer.address1');
        $this->db->where('erp_service_dc.id', $id);
        $this->db->join('customer', 'customer.id=erp_service_dc.customer');
        $this->db->join('erp_invoice', 'erp_invoice.id=erp_service_dc.inv_id', 'LEFT');
        $query = $this->db->get('erp_service_dc')->result_array();
        return $query;
    }

    public function get_all_service_dc_details_by_id($id) {
        $this->db->select('erp_inward_outward_dc_details.*,erp_product.id,erp_product.product_name,erp_product.model_no,'
                . 'erp_product.type');
        $this->db->where('erp_inward_outward_dc_details.service_dc_id', intval($id));
        $this->db->join('erp_product', 'erp_product.id=erp_inward_outward_dc_details.product_id');
        $query = $this->db->get('erp_inward_outward_dc_details')->result_array();

        return $query;
    }

    public function get_all_service_odc_by_id($id) {
        $this->db->select('erp_service_dc.*,vendor.id as vendor,vendor.state_id,vendor.store_name,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1');
        $this->db->where('erp_service_dc.id', $id);
        $this->db->join('vendor', 'vendor.id=erp_service_dc.supplier');
        $query = $this->db->get('erp_service_dc')->result_array();
        return $query;
    }

}
