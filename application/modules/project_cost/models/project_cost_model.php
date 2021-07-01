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
class Project_cost_model extends CI_Model {

    private $table_name1 = 'po';
    private $table_name2 = 'po_details';
    private $table_name4 = 'master_style';
    private $table_name5 = 'master_style_size';
    private $table_name6 = 'vendor';
    private $erp_quotation = 'erp_quotation';
    private $erp_quotation_details = 'erp_quotation_details';
    private $customer = 'customer';
    private $increment_table = 'increment_table';
    private $erp_quotation_history = 'erp_quotation_history';
    private $erp_quotation_history_details = 'erp_quotation_history_details';
    private $erp_product = 'erp_product';
    private $erp_user = 'erp_user';
    private $erp_project_cost = 'erp_project_cost';
    private $erp_project_details = 'erp_project_details';
    private $erp_other_cost = 'erp_other_cost';
    private $erp_invoice_details = 'erp_invoice_details';
    private $erp_invoice = 'erp_invoice';
    private $erp_stock = 'erp_stock';
    private $erp_stock_history = 'erp_stock_history';
    private $erp_po = 'erp_po';
    private $erp_po_details = 'erp_po_details';
    private $erp_email_settings = 'erp_email_settings';
    private $receipt_bill = 'receipt_bill';
    private $erp_sales_return = 'erp_sales_return';

    function __construct() {
        parent::__construct();
    }

    public function insert_quotation($data) {
        $data['net_total'] = $data['subtotal_qty'] + $data['tax'];

        if ($this->db->insert($this->erp_project_cost, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function insert_quotation_details($data) {
        $this->db->insert_batch($this->erp_project_details, $data);
        return true;
    }

    public function insert_invoice($data) {
        if ($this->db->insert($this->erp_invoice, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function insert_invoice_details($data) {
        $this->db->insert_batch($this->erp_invoice_details, $data);
        return true;
    }

    public function update_invoice_details($data, $id) {
        $this->db->where($this->erp_invoice_details . '.in_id', $id);
        if ($this->db->update($this->erp_invoice_details, $data)) {
            return true;
        }
        return false;
    }

    public function insert_other_cost($data) {

        $this->db->insert_batch($this->erp_other_cost, $data);
        return true;
    }

    public function get_all_email_details() {
        $this->db->select('*');
        $this->db->where("(type='inv_sender' OR type='inv_email' OR type='inv_subject' OR type='inv_cc_email')");
        $query = $this->db->get($this->erp_email_settings)->result_array();
        return $query;
    }

    public function update_invoice($data, $id) {

        $this->db->where($this->erp_invoice . '.id', $id);
        if ($this->db->update($this->erp_invoice, $data)) {
            return true;
        }
        return false;
    }

    public function update_project($data, $id) {
        $this->db->where($this->erp_project_cost . '.id', $id);
        if ($this->db->update($this->erp_project_cost, $data)) {
            return true;
        }
        return false;
    }

    public function update_increment($id) {
        $this->db->where($this->increment_table . '.id', 6);
        if ($this->db->update($this->increment_table, $id)) {
            return true;
        }
        return false;
    }

    public function update_increment2($id) {
        $this->db->where($this->increment_table . '.id', 7);
        if ($this->db->update($this->increment_table, $id)) {
            return true;
        }
        return false;
    }

    public function get_customer($atten_inputs) {
        $this->db->select('name,store_name,id,mobil_number,email_id,address1');
        $this->db->where($this->customer . '.status', 1);
        $this->db->like($this->customer . '.name', $atten_inputs['q']);
        $query = $this->db->get($this->customer)->result_array();
        return $query;
    }

    public function get_customer_by_id($id) {
        $this->db->select('name,mobil_number,email_id,address1');
        $this->db->where($this->customer . '.id', $id);
        return $this->db->get($this->customer)->result_array();
    }

    public function get_all_nick_name() {
        $this->db->select('*');
        $this->db->where($this->erp_user . '.status', 1);
        $query = $this->db->get($this->erp_user)->result_array();
        return $query;
    }

    public function get_service_cost($id) {
        $this->db->select('SUM(sub_total) as service_cost');
        $this->db->where($this->erp_project_details . '.j_id', $id);
        $this->db->where($this->erp_project_details . '.product_type', 2);
        return $this->db->get($this->erp_project_details)->result_array();
    }

    public function get_other_cost($id) {
        $this->db->select('SUM(amount) as other_cost');
        $this->db->where($this->erp_other_cost . '.j_id', $id);
        return $this->db->get($this->erp_other_cost)->result_array();
    }

    public function get_receipt_id($id) {
        $this->db->select('receipt_id');
        $this->db->where($this->receipt_bill . '.recevier_id', $id);
        return $this->db->get($this->receipt_bill)->result_array();
    }

    public function get_all_quotation_no() {
        $this->db->select('q_no,id');
        $query = $this->db->get($this->erp_quotation)->result_array();
        return $query;
    }

    public function get_product($atten_inputs) {
        $this->db->select('id,model_no,product_name,product_description,product_image,cost_price,selling_price,category_id,brand_id');
        $this->db->where($this->erp_product . '.status', 1);
        $this->db->where($this->erp_product . '.type', 1);
        $this->db->where($this->erp_product . '.id', $atten_inputs['model_number_id']);
        //$this->db->like($this->erp_product . '.model_no', $atten_inputs['q']);
        $query = $this->db->get($this->erp_product)->result_array();
        return $query;
    }

    public function get_service($atten_inputs) {
        $this->db->select('id,model_no,product_name,product_description,product_image,type,cost_price,category_id,brand_id');
        $this->db->where($this->erp_product . '.status', 1);
        $this->db->where($this->erp_product . '.type', 2);
        $this->db->where($this->erp_product . '.id', $atten_inputs['model_number_id']);
        //$this->db->like($this->erp_product . '.model_no', $atten_inputs['s']);
        $query = $this->db->get($this->erp_product)->result_array();
        return $query;
    }

    public function get_product_by_id($id) {
        $this->db->select('model_no,product_name,product_description,product_image,cost_price');
        $this->db->where($this->erp_product . '.id', $id);
        return $this->db->get($this->erp_product)->result_array();
    }

    public function get_all_project_cost($serch_data) {
        if (!empty($serch_data['from_date']))
            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
        if (!empty($serch_data['to_date']))
            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
        if ($serch_data['from_date'] == '1970-01-01')
            $serch_data['from_date'] = '';
        if ($serch_data['to_date'] == '1970-01-01')
            $serch_data['to_date'] = '';

        if (!empty($serch_data['job_id']) && $serch_data['job_id'] != 'Select') {

            $this->db->where($this->erp_project_cost . '.job_id', $serch_data['job_id']);
        }
        if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {
            $this->db->where($this->erp_project_cost . '.customer', $serch_data['customer']);
        }

        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_project_cost . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_project_cost . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_project_cost . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_project_cost . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        }

        $this->db->select('customer.id as customer,customer.store_name, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_project_cost.id,erp_project_cost.job_id,erp_quotation.q_no,erp_project_cost.total_qty,erp_project_cost.tax,erp_quotation.ref_name,erp_project_cost.tax_label,'
                . 'erp_project_cost.net_total,erp_project_cost.created_date,erp_project_cost.remarks,erp_project_cost.subtotal_qty,erp_project_cost.estatus');

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_project_cost.q_id');
        $this->db->join('customer', 'customer.id=erp_project_cost.customer');
        $query = $this->db->get('erp_project_cost')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('j_id', intval($val['id']));
            $this->db->where('type =', project_cost);
            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();
            $i++;
        }
        $j = 0;
        foreach ($query as $val) {
            $this->db->select(' sum(sub_total - ( per_cost * quantity )) as tot_tax');
            $this->db->where($this->erp_project_details . '.j_id', $val['id']);
            $query[$j]['tax_details'] = $this->db->get($this->erp_project_details)->result_array();
            $j++;
        }
        return $query;
    }

    public function get_invoice($serch_data) {
        if (!empty($serch_data['from_date']))
            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
        if (!empty($serch_data['to_date']))
            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
        if ($serch_data['from_date'] == '1970-01-01')
            $serch_data['from_date'] = '';
        if ($serch_data['to_date'] == '1970-01-01')
            $serch_data['to_date'] = '';

        if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select') {

            $this->db->where($this->erp_invoice . '.inv_id', $serch_data['inv_id']);
        }
        if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {
            $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);
        }

        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        }

        $this->db->select('customer.id as customer,customer.store_name, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_quotation.q_no,erp_invoice.total_qty,erp_invoice.tax,erp_quotation.ref_name,erp_invoice.tax_label,'
                . 'erp_invoice.net_total,erp_invoice.created_date,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,erp_invoice.warranty_from,erp_invoice.warranty_to');

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
        $query = $this->db->get('erp_invoice')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('j_id', intval($val['id']));
            $this->db->where('type', 'invoice');
            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_pc_by_id($id) {
        $this->db->select('erp_user.nick_name,customer.id as customer,customer.store_name,customer.tin, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_project_cost.id,erp_project_cost.job_id,erp_quotation.q_no,erp_project_cost.total_qty,erp_project_cost.tax,erp_quotation.ref_name,erp_project_cost.tax_label,'
                . 'erp_project_cost.net_total,erp_project_cost.remarks,erp_project_cost.subtotal_qty,erp_project_cost.estatus,erp_project_cost.created_date,erp_project_cost.q_id,erp_project_cost.id,erp_project_cost.advance,customer.bank_name,customer.bank_branch,customer.ifsc,customer.account_num');
        //$this->db->where('erp_project_cost.estatus',1);
        $this->db->where('erp_project_cost.id', $id);
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_project_cost.q_id');
        $this->db->join('erp_user', 'erp_user.id=erp_quotation.ref_name');
        $this->db->join('customer', 'customer.id=erp_project_cost.customer');
        $query = $this->db->get('erp_project_cost')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('j_id', intval($val['id']));
            $this->db->where('type =', project_cost);
            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_pc_details_by_id($id) {
        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_product.hsn_sac,erp_product.add_amount,erp_product.po_add_amount,erp_brand.id,erp_brand.brands,'
                . 'erp_project_details.category,erp_project_details.product_id,erp_project_details.brand,erp_project_details.quantity,'
                . 'erp_project_details.per_cost,erp_project_details.tax,erp_project_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,'
                . 'erp_project_details.product_description,erp_product.type');
        $this->db->where('erp_project_details.j_id', intval($id));
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_project_details.q_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_project_details.category');
        $this->db->join('erp_product', 'erp_product.id=erp_project_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_project_details.brand');

        $query = $this->db->get('erp_project_details')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('erp_stock.quantity');
            $this->db->where('category', $val['category']);
            $this->db->where('product_id', $val['product_id']);
            $this->db->where('brand', $val['brand']);
            $query[$i]['stock'] = $this->db->get('erp_stock')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_invoice_by_id($id) {
        $this->db->select('erp_user.nick_name,customer.id as customer,customer.tin,customer.state_id,customer.store_name, customer.name,customer.mobil_number,customer.email_id,customer.address1,customer.tin,erp_invoice.id,erp_invoice.inv_id,erp_quotation.q_no,erp_invoice.total_qty,erp_invoice.tax,erp_quotation.ref_name,erp_invoice.tax_label,'
                . 'erp_invoice.net_total,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,erp_invoice.warranty_from,erp_invoice.warranty_to,erp_invoice.created_date,erp_invoice.q_id,erp_invoice.id,erp_invoice.is_gst,erp_invoice.advance,customer.bank_name,customer.bank_branch,customer.ifsc,customer.account_num');
        //$this->db->where('erp_invoice.estatus',1);
        $this->db->where('erp_invoice.id', $id);
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
        $this->db->join('erp_user', 'erp_user.id=erp_quotation.ref_name');
        $query = $this->db->get('erp_invoice')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('j_id', intval($val['id']));
            $this->db->where('type', 'invoice');
            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_invoice_details_by_id($id) {
        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_product.hsn_sac,erp_product.add_amount,erp_brand.id,erp_brand.brands,'
                . 'erp_invoice_details.category,erp_invoice_details.product_id,erp_invoice_details.brand,erp_invoice_details.quantity,'
                . 'erp_invoice_details.per_cost,erp_invoice_details.tax,erp_invoice_details.sub_total,erp_product.model_no,erp_product.product_image,'
                . 'erp_invoice_details.product_description,erp_product.type,erp_invoice_details.gst,erp_invoice_details.igst');
        $this->db->where('erp_invoice_details.in_id', intval($id));
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice_details.q_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_invoice_details.category');
        $this->db->join('erp_product', 'erp_product.id=erp_invoice_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_invoice_details.brand');

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

    public function get_all_quotation() {
        $this->db->select('erp_user.nick_name,erp_quotation.id,customer.id as customer,customer.store_name, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'
                . 'erp_quotation.job_id,erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus,erp_quotation.created_date');
        $this->db->where('erp_quotation.estatus =', 2);
        $this->db->join('customer', 'customer.id=erp_quotation.customer');
        $this->db->join('erp_user', 'erp_user.id=erp_quotation.ref_name');
        $query = $this->db->get('erp_quotation')->result_array();

        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('q_id', intval($val['id']));
            $query[$i]['pc_amount'] = $this->db->get('erp_project_cost')->result_array();
            $i++;
        }

        $j = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('q_id', intval($val['pc_amount'][0]['q_id']));
            $query[$j]['inv_amount'] = $this->db->get('erp_invoice')->result_array();
            $j++;
        }

        return $query;
    }

    public function get_all_quotation_by_id($id) {
        $this->db->select('erp_user.nick_name,customer.id as customer,customer.store_name,customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.id,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'
                . 'erp_quotation.job_id,erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus,erp_quotation.created_date,erp_quotation.created_by,erp_quotation.advance');
        //$this->db->where('erp_quotation.estatus',2);
        $this->db->where('erp_quotation.id', $id);
        $this->db->join('customer', 'customer.id=erp_quotation.customer');
        $this->db->join('erp_user', 'erp_user.id=erp_quotation.ref_name');
        $query = $this->db->get('erp_quotation');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_project_cost_by_id($id) {
        $this->db->select('erp_user.nick_name,customer.id as customer,customer.store_name,customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_project_cost.id,erp_project_cost.job_id,erp_quotation.q_no,erp_project_cost.total_qty,erp_project_cost.tax,erp_quotation.ref_name,erp_project_cost.tax_label,'
                . 'erp_project_cost.net_total,erp_project_cost.remarks,erp_project_cost.subtotal_qty,erp_project_cost.estatus,erp_project_cost.q_id');
        //$this->db->where('erp_project_cost.estatus',1);
        $this->db->where('erp_project_cost.id', $id);
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_project_cost.q_id');
        $this->db->join('customer', 'customer.id=erp_project_cost.customer');
        $this->db->join('erp_user', 'erp_user.id=erp_quotation.ref_name');
        $query = $this->db->get('erp_project_cost');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_product_by_id($id) {
        $this->db->select('erp_product.id,erp_product.model_no,erp_product.product_name,erp_product.product_image,'
                . 'erp_quotation_details.product_description');
        $this->db->where('erp_quotation.id', $id);
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_quotation_details.q_id');
        $this->db->join('erp_product', 'erp_product.id=erp_quotation_details.product_id');
        $query = $this->db->get('erp_quotation_details');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_quotation_details_by_id($id) {
        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,erp_product.cost_price,'
                . 'erp_quotation_details.id as p_id,erp_quotation_details.category,erp_quotation_details.product_id,erp_quotation_details.brand,erp_quotation_details.quantity,'
                . 'erp_quotation_details.per_cost,erp_quotation_details.tax,erp_quotation_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,'
                . 'erp_quotation_details.product_description,erp_product.type');
        $this->db->where('erp_quotation_details.q_id', $id);
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_quotation_details.q_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_quotation_details.category');
        $this->db->join('erp_product', 'erp_product.id=erp_quotation_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_quotation_details.brand');

        $query = $this->db->get('erp_quotation_details')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('per_cost');
            $this->db->where('category', $val['category']);
            $this->db->where('product_id', $val['product_id']);
            $this->db->where('brand', $val['brand']);
            $this->db->order_by('per_cost', 'desc');
            $this->db->limit(1);
            $query[$i]['po'] = $this->db->get('erp_po_details')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_project_details_by_id($id, $q_id) {
        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,erp_product.cost_price,'
                . 'erp_quotation_details.id as p_id,erp_quotation_details.category,erp_quotation_details.product_id,erp_quotation_details.brand,erp_quotation_details.quantity,'
                . 'erp_quotation_details.per_cost,erp_quotation_details.tax,erp_quotation_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,'
                . 'erp_quotation_details.product_description,erp_product.type');
        $this->db->where('erp_quotation_details.q_id', $q_id);
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_quotation_details.q_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_quotation_details.category');
        $this->db->join('erp_product', 'erp_product.id=erp_quotation_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_quotation_details.brand');
        $query = $this->db->get('erp_quotation_details')->result_array();
//        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,'
//                . 'erp_project_details.category,erp_project_details.product_id,erp_project_details.brand,erp_project_details.quantity,erp_project_details.q_id,'
//                . 'erp_quotation_details.per_cost,erp_project_details.tax,erp_project_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,'
//                . 'erp_quotation_details.product_description');
//        $this->db->where('erp_project_details.j_id', $id);
//        $this->db->where('erp_project_details.q_id', $q_id);
//        $this->db->join('erp_quotation_details', 'erp_quotation_details.q_id = erp_project_details.q_id');
//        $this->db->join('erp_category', 'erp_category.cat_id=erp_project_details.category');
//        $this->db->join('erp_product', 'erp_product.id=erp_project_details.product_id');
//        $this->db->join('erp_brand', 'erp_brand.id=erp_project_details.brand');
//        $query = $this->db->get('erp_project_details')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('category', $val['category']);
            $this->db->where('product_id', $val['product_id']);
            $this->db->where('brand', $val['brand']);
            $query[$i]['stock'] = $this->db->get('erp_stock')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_stock($data) { //echo "<pre>"; print_r($data); exit;
        $this->db->select('quantity');
        $this->db->where('category', $data['cat_id']);
        $this->db->where('product_id', $data['model_no']);
        $this->db->where('brand', $data['brand_id']);
        $available_stock = $this->db->get($this->erp_stock)->result_array();

        return $available_stock;
    }

    public function get_po($data) { //echo "<pre>"; print_r($data); exit;
        $this->db->select('per_cost');
        $this->db->where('category', $data['cat_id']);
        $this->db->where('product_id', $data['model_no']);
        $this->db->where('brand', $data['brand_id']);
        $available_stock = $this->db->get($this->erp_po_details)->result_array();
        // echo "<pre>"; print_r($available_stock); exit;
        return $available_stock;
    }

    public function update_stock($check_stock, $inv_id) {
        if ($check_stock['quantity'] < 0) {
            //Update Stock
            $quantity = 0;
            $this->db->where('category', $check_stock['category']);
            $this->db->where('product_id', $check_stock['product_id']);
            $this->db->where('brand', $check_stock['brand']);
            //min stock notification
            $this->db->update($this->erp_stock, array('quantity' => $quantity));
            $this->check_min_qty($check_stock['category'], $check_stock['brand'], $check_stock['product_id'], $quantity);
        }
        $this->db->where('category', $check_stock['category']);
        $this->db->where('product_id', $check_stock['product_id']);
        $this->db->where('brand', $check_stock['brand']);
        //min stock notification
        $this->db->update($this->erp_stock, array('quantity' => $check_stock['quantity']));
        $this->check_min_qty($check_stock['category'], $check_stock['brand'], $check_stock['product_id'], $check_stock['quantity']);
        if (!empty($inv_id['diff'])) {
            $insert_stock_his = array();
            $insert_stock_his['ref_no'] = $inv_id['inv_id'];
            $insert_stock_his['type'] = 2;
            $insert_stock_his['category'] = $check_stock['category'];
            $insert_stock_his['product_id'] = $check_stock['product_id'];
            $insert_stock_his['brand'] = $check_stock['brand'];
            $insert_stock_his['quantity'] = $inv_id['diff'];
            $insert_stock_his['created_date'] = date('Y-m-d H:i');
            $this->db->insert($this->erp_stock_history, $insert_stock_his);
        }
    }

    public function check_stock($check_stock, $inv_id) {
        $this->db->select('*');
        $this->db->where('category', $check_stock['category']);
        $this->db->where('product_id', $check_stock['product_id']);
        $this->db->where('brand', $check_stock['brand']);
        $available_stock = $this->db->get($this->erp_stock)->result_array();

        $ava_quantity = $available_stock[0]['quantity'] - $check_stock['quantity'];
        if ($ava_quantity < 0) {
            //Update Stock
            $quantity = $ava_quantity - $ava_quantity;
            $this->db->where('category', $check_stock['category']);
            $this->db->where('product_id', $check_stock['product_id']);
            $this->db->where('brand', $check_stock['brand']);
            //min stock notification
            $this->db->update($this->erp_stock, array('quantity' => $quantity));
            $this->check_min_qty($check_stock['category'], $check_stock['brand'], $check_stock['product_id'], $quantity);
        } else {
            //Insert Stcok

            $quantity = $available_stock[0]['quantity'] - $check_stock['quantity'];
            $this->db->where('category', $check_stock['category']);
            $this->db->where('product_id', $check_stock['product_id']);
            $this->db->where('brand', $check_stock['brand']);
            $this->db->update($this->erp_stock, array('quantity' => $quantity));
            $this->check_min_qty($check_stock['category'], $check_stock['brand'], $check_stock['product_id'], $quantity);
        }
        //Insert Stock History

        if ($check_stock['product_type'] == 'product') {
            $insert_stock_his = array();
            $insert_stock_his['ref_no'] = $inv_id['inv_id'];
            $insert_stock_his['type'] = 2;
            $insert_stock_his['category'] = $check_stock['category'];
            $insert_stock_his['product_id'] = $check_stock['product_id'];
            $insert_stock_his['brand'] = $check_stock['brand'];
            $insert_stock_his['quantity'] = -$check_stock['quantity'];
            $insert_stock_his['created_date'] = date('Y-m-d H:i');
            $this->db->insert($this->erp_stock_history, $insert_stock_his);
        }
    }

    public function update_sales_count($check_stock) {
        $this->db->select('*');
        $this->db->where('category', $check_stock['category']);
        $this->db->where('product_id', $check_stock['product_id']);
        $this->db->where('brand', $check_stock['brand']);
        $available_stock = $this->db->get($this->erp_stock);
        if ($available_stock->num_rows() >= 0) {
            $result = $available_stock->result_array();
            $total_sales_count = $result[0]['product_sales_count'];


            //Update Stock
            $quantity = $total_sales_count + $check_stock['quantity'];
            $this->db->where('category', $check_stock['category']);
            $this->db->where('product_id', $check_stock['product_id']);
            $this->db->where('brand', $check_stock['brand']);

            $this->db->update($this->erp_stock, array('product_sales_count' => $quantity));
        }
        return false;
    }

    public function check_min_qty($cat_id, $brand, $p_id, $quantity) {
        $this->db->select('min_qty,product_name');
        $this->db->where('erp_product.id', $p_id);
        $qty = $this->db->get('erp_product')->result_array();

        $this->db->select('quantity');
        $this->db->where('erp_stock.category', $cat_id);
        $this->db->where('erp_stock.brand', $brand);
        $this->db->where('erp_stock.product_id', $p_id);
        $stock = $this->db->get('erp_stock')->result_array();

        if ($stock[0]['quantity'] <= $qty[0]['min_qty']) {
            $notification = array();
            $notification['notification_date'] = date('Y-m-d');
            $notification['type'] = 'min_qty';
            $notification['link'] = 'stock/';
            $notification['Message'] = $qty[0]['product_name'] . ' is in minimum stock';
            if ($this->db->insert('erp_notification', $notification)) {
                return true;
            }
        }
    }

    public function get_all_quotation_history_by_id($id) {
        $this->db->select('customer.id,customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation_history.q_no,erp_quotation_history.total_qty,erp_quotation_history.tax,erp_quotation_history.ref_name,erp_quotation_history.tax_label,'
                . 'erp_quotation_history.net_total,erp_quotation_history.delivery_schedule,erp_quotation_history.notification_date,erp_quotation_history.mode_of_payment,erp_quotation_history.remarks,erp_quotation_history.subtotal_qty');
        $this->db->where('erp_quotation_history.eStatus', 1);
        $this->db->where('erp_quotation_history.id', $id);
        $this->db->join('customer', 'customer.id=erp_quotation_history.customer');
        $query = $this->db->get('erp_quotation_history');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_quotation_history_details_by_id($id) {
        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_brand.id,erp_brand.brands,'
                . ' erp_product.id,erp_product.model_no,erp_product.product_name,erp_product.product_image,erp_quotation_history_details.product_description,'
                . 'erp_quotation_history_details.category,erp_quotation_history_details.product_id,erp_quotation_history_details.brand,erp_quotation_history_details.quantity,'
                . 'erp_quotation_history_details.per_cost,erp_quotation_history_details.tax,erp_quotation_history_details.sub_total');
        $this->db->where('erp_quotation_history.id', $id);
        $this->db->join('erp_quotation_history', 'erp_quotation_history.id=erp_quotation_history_details.h_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_quotation_history_details.category');
        $this->db->join('erp_product', 'erp_product.id=erp_quotation_history_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_quotation_history_details.brand');
        $query = $this->db->get('erp_quotation_history_details');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_his_quotation_by_id($id) {
        $this->db->select('*');
        $this->db->where($this->erp_quotation . '.id', $id);
        return $this->db->get($this->erp_quotation)->result_array();
    }

    public function get_all_history_quotation_by_id($id) {
        $this->db->select('*');
        $this->db->where($this->erp_quotation_history . '.org_q_id', $id);
        return $this->db->get($this->erp_quotation_history)->result_array();
    }

    public function insert_history_quotation($data) {
        if ($this->db->insert($this->erp_quotation_history, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return false;
    }

    public function insert_history_quotation_details($data) {
        $this->db->insert_batch($this->erp_quotation_history_details, $data);
        return true;
    }

    public function get_his_quotation_deteils_by_id($id) {
        $this->db->select('*');
        $this->db->where($this->erp_quotation_details . '.q_id', $id);
        return $this->db->get($this->erp_quotation_details)->result_array();
    }

    public function delete_quotation_deteils_by_id($id) {
        $this->db->where('q_id', $id);
        $this->db->delete($this->erp_quotation_details);
    }

    public function delete_id($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->erp_quotation_details);
    }

    public function delete_pc_id($id) {
        $this->db->where('q_id', $id);
        $this->db->delete($this->erp_project_details);
        return true;
    }

    public function delete_pcdetails_id($id) {
        $this->db->where('j_id', $id);
        $this->db->delete($this->erp_project_details);
        return true;
    }

    public function delete_othercost($id, $type) {
        $this->db->where('j_id', $id);
        $this->db->where('type', $type);
        $this->db->delete($this->erp_other_cost);
        return true;
    }

    public function delete_project_cost($id) {
        $this->db->where('id', $id);
        $this->db->delete($this->erp_project_cost);
        return true;
    }

    public function delete_invoice($id) {
        $this->db->where('q_id', $id);
        $this->db->delete($this->erp_invoice);
        return true;
    }

    public function delete_invoice_details($id) {
        $this->db->where('in_id', $id);
        $this->db->delete($this->erp_invoice_details);
        return true;
    }

    public function change_quotation_status($id, $status) {
        $this->db->where($this->erp_quotation . '.id', $id);
        if ($this->db->update($this->erp_quotation, array('estatus' => $status))) {
            return true;
        }
        return false;
    }

    public function update_quotation($data, $id) {
        $this->db->where($this->erp_quotation . '.id', $id);
        if ($this->db->update($this->erp_quotation, $data)) {
            return true;
        }
        return false;
    }

    public function delete_quotation($id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->erp_quotation, $data = array('estatus' => 0))) {
            return true;
        }
        return false;
    }

    public function all_history_quotations($id) {
        $this->db->select('*');
        $this->db->where('erp_quotation_history.org_q_id', $id);
        $this->db->order_by('created_date', 'desc');
        $query = $this->db->get('erp_quotation_history')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where($this->erp_quotation_history_details . '.h_id', $val['id']);
            $query[$i]['history_details'] = $this->db->get($this->erp_quotation_history_details)->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_customer_by_id($id) {
        $this->db->select('*');
        $this->db->where('df', 0);
        $this->db->where('status', 1);
        $this->db->where('state_id', $id);
        $query = $this->db->get($this->table_name6);
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_style_details_by_id($style_name) {
        $this->db->select('style_name,mrp,lot_no,id as style_id');
        $this->db->where('df', 0);
        $this->db->where('status', 1);
        $this->db->where('style_name', $style_name);
        $query = $this->db->get($this->table_name4);
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_location($where) {
        $this->db->select('location');
        $this->db->where($where);
        $query = $this->db->get('stock_info')->result_array();
        return $query;
    }

    public function get_all_color_details_by_id($s_id) {
        $this->db->select('master_colour.id,master_colour.colour');
        $this->db->where('master_style_color.status', 1);
        $this->db->where('master_style_color.style_id', $s_id);
        $this->db->join('master_colour', 'master_colour.id=master_style_color.color_id');
        $query = $this->db->get('master_style_color');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_style_details_by_id1($id) {
        $this->db->select($this->table_name4 . '.*');
        $this->db->select('master_style_type.style_type');
        $this->db->where($this->table_name4 . '.status', 1);
        $this->db->where($this->table_name4 . '.id', $id);
        $this->db->join('master_style_type', 'master_style_type.id=' . $this->table_name4 . '.style_type');
        $query = $this->db->get($this->table_name4)->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select($this->table_name5 . '.*');
            $this->db->select('master_size.size');
            $this->db->where($this->table_name5 . '.style_id', $val['id']);
            $this->db->join('master_size', 'master_size.id=' . $this->table_name5 . '.size_id');
            $query[$i]['style_size'] = $this->db->get($this->table_name5)->result_array();
            $i++;
        }
        return $query;
    }

    public function insert_gen($data) {
        if ($this->db->insert($this->table_name1, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function insert_gen_details($data) {
        if ($this->db->insert_batch($this->table_name2, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function get_all_gen($serch_data = NULL) {
        if (isset($serch_data) && !empty($serch_data)) {
            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';
            if (!empty($serch_data['state']) && $serch_data['state'] != 'Select') {
                $this->db->where($this->table_name1 . '.state', $serch_data['state']);
            }
            if (!empty($serch_data['supplier']) && $serch_data['supplier'] != 'Select') {
                $this->db->where($this->table_name1 . '.customer', $serch_data['supplier']);
            }
            if (!empty($serch_data['po'])) {
                $this->db->where($this->table_name1 . '.grn_no', $serch_data['po']);
            }
            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {
                $this->db->where("DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {
                $this->db->where("DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["style"]) && $serch_data["style"] != "Select") {

                $this->db->where('master_style.id', $serch_data["style"]);
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
            $this->db->where("DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') >='" . $from . "' AND DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') <= '" . $to . "'");
        }
        $this->db->select($this->table_name1 . '.*');
        $this->db->select('vendor.name,store_name');
        $this->db->select('master_style.style_name');
        $this->db->select('master_state.state');
        $this->db->where($this->table_name1 . '.status', 1);
        $this->db->where($this->table_name1 . '.df', 0);
        $this->db->order_by($this->table_name1 . '.id', 'desc');
        $this->db->group_by('po_details.gen_id');
        $this->db->join('po_details', 'po_details.gen_id=' . $this->table_name1 . '.id');
        $this->db->join('master_style', 'master_style.id=po_details.style_id');
        $this->db->join('vendor', 'vendor.id=' . $this->table_name1 . '.customer');
        $this->db->join('master_state', 'master_state.id=' . $this->table_name1 . '.state');
        $query = $this->db->get($this->table_name1)->result_array();
        $i = 0;

        foreach ($query as $val) {
            $cancel_status = '';
            if ($val['delivery_status'] == 0) {
                $date = strtotime($val['delivery_schedule']);
                $date = strtotime("+10 day", $date);

                if (strtotime(date('d-m-Y', $date)) < strtotime(date('d-m-Y')))
                    $cancel_status = 'true';
                else
                    $cancel_status = 'false';
            } else
                $cancel_status = 'false';

            $query[$i]['cancel_status'] = $cancel_status;
            $i++;
        }
        return $query;
    }

    function get_datatables($search_data) {

        $this->_get_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_quotation')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('q_id', intval($val['id']));
            $query[$i]['pc_amount'] = $this->db->get('erp_project_cost')->result_array();
            $i++;
        }

        $j = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('q_id', intval($val['pc_amount'][0]['q_id']));
            $query[$j]['inv_amount'] = $this->db->get('erp_invoice')->result_array();
            $j++;
        }

        return $query;
    }

    function _get_datatables_query($serch_data = array()) {

        $this->db->select('erp_user.nick_name,erp_quotation.id,customer.id as customer,customer.store_name, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'
                . 'erp_quotation.job_id,erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus,erp_quotation.created_date');
        $this->db->where('erp_quotation.estatus =', 2);
        $this->db->join('customer', 'customer.id=erp_quotation.customer');
        $this->db->join('erp_user', 'erp_user.id=erp_quotation.ref_name');

        $i = 0;
        $column_order = array(null, 'erp_quotation.q_no', 'customer.store_name', 'erp_quotation.net_total', null, null, null, 'erp_quotation.job_id', null, null);
        $column_search = array('erp_quotation.q_no', 'customer.store_name', 'erp_quotation.net_total', 'erp_quotation.job_id');
        $order = array('erp_quotation.id' => 'DESC');

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
        $query = $this->db->get('erp_quotation');
        return $query->num_rows();
    }

    function count_all() {
        $this->_get_datatables_query();
        $this->db->from('erp_quotation');
        return $this->db->count_all_results();
    }

    public function update_sr($data, $id) {
        $this->db->where($this->erp_sales_return . '.id', $id);
        if ($this->db->update($this->erp_sales_return, $data)) {
            return true;
        }
        return false;
    }

    public function delete_return_inv_by_id($id) {
        $this->db->where('in_id', $id);
        $this->db->delete('erp_sales_return_details');
    }

    public function get_all_quotation_count($id) {
        $this->db->select('erp_quotation.id');
        $this->db->where('erp_quotation.estatus =', 2);
        $query = $this->db->get('erp_quotation');

        return $query->num_rows();
    }

    public function get_pending_project_count($id) {
        $this->db->select('erp_project_cost.id');
        $this->db->where('erp_project_cost.complete_status =', 1);
        $query = $this->db->get('erp_project_cost');

        return $query->num_rows();
    }

    public function change_completed_status($id, $status) {
        $this->db->where($this->erp_project_cost . '.id', $id);
        if ($this->db->update($this->erp_project_cost, array('complete_status' => $status))) {
            return true;
        }
        return false;
    }

    public function get_pcdetails_by_productid($q_id,$j_id,$productids){
        $this->db->select('erp_project_details.*,if(erp_stock.quantity < 0,0,erp_stock.quantity) as available_quantity',false);
        $this->db->where('erp_project_details.q_id =', $q_id);
        $this->db->where('erp_project_details.j_id =', $j_id);
        $this->db->where('erp_project_details.product_id not in ('.$productids.')');
        $this->db->join('erp_stock', 'erp_stock.product_id=erp_project_details.product_id');
        $query = $this->db->get('erp_project_details')->result_array();
        return $query;
    }
    public function get_stock_history_by_id($job_id,$productid){
        $this->db->select('*');
        $this->db->where('ref_no =', $job_id);
        if($productid!='')
            $this->db->where('product_id =',$productid);
        $query = $this->db->get('erp_stock_history');
        return $query->num_rows();
    }

}
