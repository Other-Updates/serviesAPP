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
    private $increment_table = 'increment_table';
    private $erp_company_amount = 'erp_company_amount';
    private $erp_invoice = 'erp_invoice';

    /* private $table_name3	= 'customer';
      private $table_name4	= 'master_style';
      private $table_name5	= 'master_style_size';
      private $table_name6	= 'vendor';
      private $table_name7	= 'package';
      private $table_name8	= 'package_details'; */

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

    public function insert_agent_amount($data) {
        if ($this->db->insert($this->erp_company_amount, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function insert_receipt_bill($data) {
        if ($this->db->insert($this->table_name2, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function update_increment($id) {
        $this->db->where($this->increment_table . '.id', 8);
        if ($this->db->update($this->increment_table, $id)) {
            return true;
        }
        return false;
    }

    public function get_all_amount($serch_data = NULL) {
        $this->db->select('erp_company_amount.*,agent.name,receipt_bill.receipt_no,erp_quotation.job_id');
        $this->db->where($this->erp_company_amount . '.recevier', 1);
        $this->db->join('agent', 'agent.id=erp_company_amount.recevier_id', 'left');
        $this->db->join('receipt_bill', 'receipt_bill.id=erp_company_amount.receipt_id', 'left');
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_company_amount.receipt_id', 'left');
        $query = $this->db->get('erp_company_amount')->result_array();
        return $query;
    }

    public function get_all_receipt($serch_data = NULL) {
        $this->db->select('erp_invoice.*');
        $this->db->select('customer.name,customer.store_name');
        // $this->db->select('erp_quotation.advance');
        $this->db->order_by('erp_invoice.id', 'desc');
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');
        $query = $this->db->get('erp_invoice')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date');
            $this->db->where('receipt_bill.receipt_id', $val['id']);
            $query[$i]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_receipt_cash($serch_data = NULL) {
        if (isset($serch_data) && !empty($serch_data)) {
            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';
            if (!empty($serch_data['cah_option']) && $serch_data['cah_option'] != 'Select') {
                $this->db->where('erp_company_amount.recevier', $serch_data['cah_option']);
            }
            if (!empty($serch_data['agent']) && $serch_data['agent'] != 'Select') {
                $this->db->where('agent.id', $serch_data['agent']);
            }
            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {
                $this->db->where("DATE_FORMAT(erp_company_amount.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(erp_company_amount.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {
                $this->db->where("DATE_FORMAT(erp_company_amount.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {
                $this->db->where("DATE_FORMAT(erp_company_amount.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        $this->db->select('erp_company_amount.*,agent.name');
        $this->db->join('agent', 'agent.id=erp_company_amount.recevier_id', 'left');
        $query = $this->db->get('erp_company_amount')->result_array();
        return $query;
    }

    public function get_receipt_by_id($id) {
        $this->db->select('erp_invoice.*');
        $this->db->where('erp_invoice.id', $id);
        $this->db->select('customer.name,customer.store_name');
        //  $this->db->select('erp_quotation.advance');
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');
        $query = $this->db->get('erp_invoice')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('receipt_bill.receipt_id', $val['id']);
            $query[$i]['receipt_history'] = $this->db->get('receipt_bill')->result_array();
            $j = 0;
            foreach ($query[$i]['receipt_history'] as $rep) {
                if ($rep['recevier'] != 'company') {
                    $this->db->select('name');
                    $this->db->where('id', $rep['recevier_id']);
                    $recevier = $this->db->get('erp_user')->result_array();
                    $query[$i]['receipt_history'][$j]['recevier'] = $recevier[0]['name'];
                }
                $j++;
            }
            $i++;
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
        if ($this->db->update('erp_invoice', $data)) {

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

    function get_datatables($search_data) {

        $this->_get_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_invoice')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date');
            $this->db->where('receipt_bill.receipt_id', $val['id']);
            $query[$i]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();
            $i++;
        }
        $j = 0;
        foreach ($query as $val) {
            $this->db->select('erp_invoice_details.*');
            $this->db->where('erp_invoice_details.in_id', $val['id']);
            $query[$j]['po_details'] = $this->db->get('erp_invoice_details')->result_array();
            $j++;
        }


        return $query;
    }

    function _get_datatables_query($serch_data = array()) {

        $this->db->select('erp_invoice.*');
        $this->db->select('customer.name,customer.store_name,customer.state_id');
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');

        $i = 0;
        $column_order = array(null, 'erp_invoice.inv_id', 'customer.store_name', 'erp_invoice.net_total', 'erp_invoice.advance', null, null, null, null, null, null);
        $column_search = array('erp_invoice.inv_id', 'customer.store_name', 'erp_invoice.net_total', 'erp_invoice.advance');
        $order = array('erp_invoice.id' => 'DESC');

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
        $this->_get_datatables_query();
        $query = $this->db->get('erp_invoice');
        return $query->num_rows();
    }

    function count_all() {
        $this->_get_datatables_query();
        $this->db->from('erp_invoice');
        return $this->db->count_all_results();
    }

    public function get_all_inv_by_id($id) {
        $this->db->select('customer.store_name,customer.id as customer,customer.state_id,customer.tin, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_invoice.total_qty,erp_invoice.tax,erp_invoice.tax_label,'
                . 'erp_invoice.q_id,erp_invoice.net_total,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,erp_invoice.warranty_from,erp_invoice.warranty_to,erp_invoice.payment_status,erp_invoice.is_gst');
        //$this->db->where('erp_invoice.estatus',1);
        $this->db->where('erp_invoice.id', $id);
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
        $query = $this->db->get('erp_invoice');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_inv_details_by_id($id) {
        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,'
                . 'erp_invoice_details.category,erp_invoice_details.product_id,erp_invoice_details.brand,erp_invoice_details.quantity,'
                . 'erp_invoice_details.per_cost,erp_invoice_details.tax,erp_invoice_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,erp_product.add_amount,'
                . 'erp_invoice_details.product_description,erp_invoice_details.gst,erp_invoice_details.igst,erp_invoice_details.id as inv_details_id,erp_invoice_details.current_quantity');
        $this->db->where('erp_invoice_details.in_id', $id);
        $this->db->join('erp_invoice', 'erp_invoice.id=erp_invoice_details.in_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_invoice_details.category');
        $this->db->join('erp_product', 'erp_product.id=erp_invoice_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_invoice_details.brand');

        $query = $this->db->get('erp_invoice_details')->result_array();
        return $query;
    }

    public function get_pending_receipt_count() {
        $this->db->select('erp_invoice.id');
        $this->db->where('erp_invoice.payment_status', 'Pending');
        $this->db->where('erp_invoice.estatus', 1);
        $query = $this->db->get('erp_invoice');

        return $query->num_rows();
    }

    public function get_inv_details($id) {
        $this->db->select('erp_invoice.*');
        $this->db->where('erp_invoice.id', $id);
        $query = $this->db->get('erp_invoice');
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

}
