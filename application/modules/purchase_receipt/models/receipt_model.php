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
class Receipt_model extends CI_Model {

    private $table_name1 = 'receipt';
    private $table_name2 = 'receipt_bill';
    private $erp_po = 'erp_po';
    private $vendor = 'vendor';
    private $erp_company_amount = 'erp_company_amount';

    function __construct() {
        parent::__construct();
    }

    public function check_so_no($po) {
        $this->db->select('receipt_no');
        $this->db->where('receipt_no', $po);
        $query = $this->db->get('receipt')->result_array();
        return $query;
    }

    public function insert_receipt($data) {
        if ($this->db->insert($this->table_name1, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function insert_receipt_bill($data) {
        if ($this->db->insert('purchase_receipt_bill', $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function get_company() {
        $this->db->select('*');
        $query = $this->db->get($this->vendor)->result_array();
        return $query;
    }

    public function insert_agent_amount($data) {
        if ($this->db->insert($this->erp_company_amount, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function get_all_receipt($serch_data = NULL) {
        if (isset($serch_data) && !empty($serch_data)) {
            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';


            if (!empty($serch_data['q_no']) && $serch_data['q_no'] != 'Select') {

                $this->db->where($this->erp_po . '.po_no', $serch_data['q_no']);
            }
            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {
                $this->db->where($this->vendor . '.id', $serch_data['customer']);
            }

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        $this->db->select('erp_po.*');
        $this->db->select('vendor.store_name');
        $this->db->order_by('erp_po.id', 'desc');
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');
        $this->db->where('erp_po.eStatus', 1);
        $query = $this->db->get('erp_po')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date');
            $this->db->where('purchase_receipt_bill.receipt_id', $val['id']);
            $query[$i]['receipt_bill'] = $this->db->get('purchase_receipt_bill')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_receipt_by_id($id) {//echo "<pre>";
        $this->db->where('erp_po.id', $id);
        $this->db->select('erp_po.*');
        $this->db->select('vendor.name,vendor.store_name,vendor.tin');
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');
        $this->db->where('erp_po.eStatus', 1);
        $query = $this->db->get('erp_po')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('purchase_receipt_bill.receipt_id', $val['id']);
            $query[$i]['receipt_history'] = $this->db->get('purchase_receipt_bill')->result_array();
            $j = 0;
            foreach ($query[$i]['receipt_history'] as $rep) {
                if ($rep['recevier'] != 'company') {
                    $this->db->select('name');
                    $this->db->where('id', $rep['recevier_id']);
                    $recevier = $this->db->get('agent')->result_array();
                    $query[$i]['receipt_history'][$j]['recevier'] = $recevier[0]['name'];
                }
                $j++;
            }
            $i++;
        }
        $k = 0;
        foreach ($query as $val) {
            $this->db->select('gen.grn_no,gen.id AS gen_id');
            $this->db->where('gen.po_id', $val['id']);
            $query[$k]['grn_no'] = $this->db->get('gen')->result_array();
            $k++;
        }
        return $query;
    }

    public function get_receipt_by_id_for_agent($data) {//echo "<pre>";
        $this->db->select('receipt.*');
        $this->db->where_in('receipt.id', $data);
        $this->db->select('customer.store_name,selling_percent');
        $this->db->select('agent.name as agent_name');
        $this->db->join('customer', 'customer.id=' . $this->table_name1 . '.customer_id');
        $this->db->join('agent', 'agent.id=' . $this->table_name1 . '.agent_id');
        $query = $this->db->get('receipt')->result_array();
        //echo "<pre>";print_r($query);
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('receipt_bill.receipt_id', $val['id']);
            $query[$i]['receipt_history'] = $this->db->get('receipt_bill')->result_array();

            $arr = explode('-', $val['inv_list']);

            $this->db->select('invoice.inv_no,invoice.id,inv_date,org_value,total_value');
            $this->db->where('customer.id', $val['customer_id']);
            $this->db->where_in('invoice.id', $arr);
            $this->db->join('package', 'package.id=invoice.package_id');
            $this->db->join('customer', 'customer.id=package.customer');
            $query[$i]['inv_details'] = $this->db->get('invoice')->result_array();



            $i++;
        }

        return $query;
    }

    public function update_invoice($data, $id) {
        $this->db->where('id', $id);
        if ($this->db->update('erp_po', $data)) {

            return true;
        }
        return false;
    }

    public function update_invoice_status($data) {
        $this->db->where_in('id', $data);
        if ($this->db->update('invoice', array('receipt_status' => 1))) {

            return true;
        }
        return false;
    }

    public function update_receipt_id($no) {
        $this->db->where('type', 'rp_code');
        if ($this->db->update('increment_table', array('value' => $no))) {

            return true;
        }
        return false;
    }

    public function get_all_rp_no($data) {
        $this->db->select('receipt_no');
        $this->db->like('receipt_no', $data['q']);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get($this->table_name1)->result_array();
        return $query;
    }

    function checking_payment_checkno($input) {

        $this->db->select('*');
        $this->db->where('dd_no', $input);
        $query = $this->db->get('receipt_bill');

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    function update_checking_payment_checkno($input) {

        $this->db->select('*');
        $this->db->where('dd_no', $input);
        $query = $this->db->get('receipt_bill');

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    function get_purchase_receipt_datatables($search_data) {

        $this->_get_purchase_receipt_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_po')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date,remarks');
            $this->db->where('purchase_receipt_bill.receipt_id', $val['id']);
            $query[$i]['receipt_bill'] = $this->db->get('purchase_receipt_bill')->result_array();
            $i++;
        }
        $j = 0;
        foreach ($query as $val) {
            $this->db->select('erp_po_details.*');
            $this->db->where('erp_po_details.po_id', $val['id']);
            $query[$j]['po_details'] = $this->db->get('erp_po_details')->result_array();
            $j++;
        }
        $k = 0;
        foreach ($query as $val) {
            $this->db->select('remarks');
            $this->db->where('purchase_receipt_bill.receipt_id', $val['id']);
            $this->db->order_by("purchase_receipt_bill.id", "desc");
            if ($search_data['search']['value']) { // if datatable send POST for search
                $this->db->like('purchase_receipt_bill.remarks', $search_data['search']['value']);
            }
            $query[$k]['remarks'] = $this->db->get('purchase_receipt_bill')->result_array();
//            echo $this->db->last_query();
//            exit;
            $k++;
        }

        return $query;
    }

    function _get_purchase_receipt_datatables_query($serch_data = array()) {
        if (isset($serch_data) && !empty($serch_data)) {
            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';


            if (!empty($serch_data['q_no']) && $serch_data['q_no'] != 'Select') {

                $this->db->where($this->erp_po . '.po_no', $serch_data['q_no']);
            }
            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {
                $this->db->where($this->vendor . '.id', $serch_data['customer']);
            }

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        $this->db->select('erp_po.*,purchase_receipt_bill.remarks');
        $this->db->select('vendor.store_name,state_id');
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');
        $this->db->join('purchase_receipt_bill', 'purchase_receipt_bill.receipt_id=erp_po.id', 'LEFT');
        $this->db->group_by('erp_po.id');
        $this->db->where('erp_po.eStatus', 1);

        $i = 0;
        $column_order = array(null, 'erp_po.po_no', 'vendor.store_name', 'erp_po.net_total', null, null, null, null, 'purchase_receipt_bill.remarks', null, null);
        $column_search = array('erp_po.po_no', 'vendor.store_name', 'erp_po.net_total', 'purchase_receipt_bill.remarks');
        $order = array('erp_po.id' => 'DESC');

        foreach ($column_search as $item) { // loop column
            if ($serch_data['search']['value']) { // if datatable send POST for search
                if ($i == 0) { // first loop
                    $where .= "(";
                }
                $string = $item;
                $str_arr = explode(".", $string);
                $where .= '`' . $str_arr[0] . "`" . '.' . "`" . $str_arr[1] . "` like '%" . $serch_data['search']['value'] . "%'";
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
        $this->_get_purchase_receipt_datatables_query();
        $query = $this->db->get('erp_po');
        return $query->num_rows();
    }

    function count_all() {
        $this->_get_purchase_receipt_datatables_query();
        $this->db->from('erp_po');
        return $this->db->count_all_results();
    }

    public function get_all_po_details_by_id($id) {
        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,erp_product.po_add_amount as add_amount,'
                . 'erp_po_details.category,erp_po_details.product_id,erp_po_details.brand,erp_po_details.quantity,'
                . 'erp_po_details.per_cost,erp_po_details.tax,erp_po_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,'
                . 'erp_po_details.product_description,erp_po_details.gst,erp_po_details.igst,erp_po_details.delivery_quantity,erp_po_details.id as po_details_id');
        $this->db->where('erp_po_details.po_id', $id);
        $this->db->join('erp_po', 'erp_po.id=erp_po_details.po_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_po_details.category');
        $this->db->join('erp_product', 'erp_product.id=erp_po_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_po_details.brand');

        $query = $this->db->get('erp_po_details')->result_array();

        return $query;
    }

    public function get_all_po_by_id($id) {
        $this->db->select('vendor.id as vendor,vendor.store_name,vendor.state_id, vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_po.id,erp_po.po_no,erp_po.total_qty,erp_po.tax,erp_po.tax_label,'
                . 'erp_po.net_total,erp_po.delivery_schedule,erp_po.mode_of_payment,erp_po.remarks,erp_po.subtotal_qty,erp_po.estatus,erp_po.is_gst');
        $this->db->where('erp_po.id', $id);
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');
        $this->db->where('erp_po.eStatus', 1);
        $query = $this->db->get('erp_po');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

}
