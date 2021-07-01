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
class Service_model extends CI_Model {

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

    function __construct() {
        parent::__construct();
    }

    public function insert_quotation($data) {
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

    public function insert_other_cost($data) {
        $this->db->insert_batch($this->erp_other_cost, $data);
        return true;
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
        $this->db->select('name,id,mobil_number,email_id,address1');
        $this->db->where($this->customer . '.status', 1);
        $this->db->where($this->customer . '.id', $atten_inputs['cust_id']);
        //$this->db->like($this->customer . '.name', $atten_inputs['q']);
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

    public function get_all_quotation_no() {
        $this->db->select('q_no,id');
        $query = $this->db->get($this->erp_quotation)->result_array();
        return $query;
    }

    public function get_all_quotations() {
        $this->db->select('erp_invoice.q_id,erp_quotation.id,erp_quotation.q_no,erp_invoice.inv_id,erp_invoice.id as invoice_id,erp_invoice.customer');
        $this->db->join('erp_invoice', 'erp_invoice.q_id=erp_quotation.id');
        $this->db->order_by('erp_quotation.id', 'desc');
        $query = $this->db->get($this->erp_quotation)->result_array();
        return $query;
    }

    public function get_invoice($id) {
        $this->db->select('q_no,id');
        $query = $this->db->get($this->erp_quotation)->result_array();
        return $query;
    }

    public function get_product($atten_inputs) {
        $this->db->select('erp_product.id,erp_product.model_no,erp_product.product_name,erp_product.product_description,erp_product.product_image,erp_product.type,erp_product.cost_price,erp_product.selling_price,erp_product.category_id,erp_product.brand_id,erp_product.cgst,erp_product.sgst,erp_product.igst,erp_product.hsn_sac,erp_product.add_amount,'
                . ' CASE WHEN erp_stock.quantity > 0 THEN erp_stock.quantity ELSE 0 END AS quantity', FALSE);
        $this->db->where($this->erp_product . '.status', 1);
        $this->db->where($this->erp_product . '.type', 1);
        $this->db->where($this->erp_product . '.id', $atten_inputs['model_number_id']);
        $this->db->join('erp_stock', 'erp_stock.product_id = erp_product.id', 'left');
        $query = $this->db->get($this->erp_product)->result_array();
        return $query;
    }

    public function get_service($atten_inputs) {
        $this->db->select('id,model_no,product_name,product_description,product_image,type,cost_price,selling_price,brand_id,category_id,brand_id,cgst,sgst,igst,hsn_sac,erp_product.add_amount');
        $this->db->where($this->erp_product . '.status', 1);
        $this->db->where($this->erp_product . '.type', 2);
        $this->db->where($this->erp_product . '.id', $atten_inputs['model_number_id']);
        //  $this->db->like($this->erp_product . '.model_no', $atten_inputs['s']);
        $query = $this->db->get($this->erp_product)->result_array();
        return $query;
    }

    public function get_product_by_id($id) {
        $this->db->select('model_no,product_name,product_description,product_image');
        $this->db->where($this->erp_product . '.id', $id);
        return $this->db->get($this->erp_product)->result_array();
    }

    public function get_all_pc_by_id($id) {

        $this->db->select('erp_invoice.inv_id,customer.store_name,erp_project_cost.job_id, customer.name,customer.mobil_number,customer.email_id,customer.address1,customer.state_id,erp_quotation.id,erp_quotation.q_no,erp_project_cost.total_qty,erp_project_cost.tax,erp_quotation.ref_name,erp_project_cost.tax_label,'
                . 'erp_project_cost.created_date,erp_project_cost.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_project_cost.remarks,erp_project_cost.subtotal_qty,erp_project_cost.estatus,erp_project_cost.id as jo_id,erp_quotation.customer,erp_project_cost.is_gst');
        //$this->db->where('erp_quotation.estatus',1);
        $this->db->where('erp_project_cost.q_id', $id);
        $this->db->join('customer', 'customer.id=erp_project_cost.customer', 'left');
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_project_cost.q_id');
        $this->db->join('erp_invoice', 'erp_invoice.q_id=erp_project_cost.q_id');
        $query = $this->db->get('erp_project_cost')->result_array();

//        $this->db->select('customer.store_name,customer.id as customer, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_project_cost.id,erp_project_cost.job_id,erp_quotation.q_no,erp_project_cost.total_qty,erp_project_cost.tax,erp_quotation.ref_name,erp_project_cost.tax_label,'
//                . 'erp_project_cost.net_total,erp_project_cost.remarks,erp_project_cost.subtotal_qty,erp_project_cost.estatus');
//        //$this->db->where('erp_project_cost.estatus',1);
//        $this->db->where('erp_project_cost.q_id', $id);
//        $this->db->join('erp_quotation', 'erp_quotation.id=erp_project_cost.q_id');
//        $this->db->join('customer', 'customer.id=erp_project_cost.customer');
//        $query = $this->db->get('erp_project_cost')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('j_id', intval($val['jo_id']));
            $this->db->where('type =', project_cost);
            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_pc_details_by_id($id) {
        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,erp_product.cost_price,'
                . 'erp_project_details.category,erp_project_details.product_id,erp_project_details.brand,erp_project_details.quantity,'
                . 'erp_project_details.per_cost,erp_project_details.tax,erp_project_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.hsn_sac,erp_product.add_amount,'
                . 'erp_project_details.product_description,erp_product.type,erp_project_details.igst,erp_project_details.gst');
        $this->db->where('erp_project_details.q_id', intval($id));
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_project_details.q_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_project_details.category');
        $this->db->join('erp_product', 'erp_product.id=erp_project_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_project_details.brand');

        $query = $this->db->get('erp_project_details')->result_array();

        $is = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('category', $val['category']);
            $this->db->where('product_id', $val['product_id']);
            $this->db->where('brand', $val['brand']);
            $query[$is]['stock'] = $this->db->get('erp_stock')->result_array();
            $is++;
        }

        return $query;
    }

    public function get_all_pc_service($id) {
        $this->db->select('erp_quotation.*,customer.store_name,customer.id as customer, customer.name,customer.mobil_number,customer.email_id,customer.address1,customer.state_id,erp_project_cost.id,erp_project_cost.job_id,erp_project_cost.total_qty,erp_project_cost.tax,erp_project_cost.tax_label,'
                . 'erp_project_cost.net_total,erp_project_cost.remarks,erp_project_cost.subtotal_qty,erp_project_cost.estatus,erp_project_cost.is_gst');
        //$this->db->where('erp_project_cost.estatus',1);
        $this->db->where('erp_project_cost.q_id', intval($id));
        $this->db->join('customer', 'customer.id=erp_project_cost.customer');
        $this->db->join('erp_quotation', 'erp_quotation.id= erp_project_cost.q_id');
        $query = $this->db->get('erp_project_cost')->result_array();

        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('j_id', intval($val['id']));
            $this->db->where('type =', 'project_cost');
            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();
            $i++;
        }
        $j = 0;
        foreach ($query as $val) {
            $this->db->select('nick_name');
            $this->db->where('id', $val['ref_name']);
            $query[$j]['nickname'] = $this->db->get('erp_user')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_pc_details_service($id) {
        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,erp_project_details.category,erp_project_details.product_id,erp_project_details.brand,erp_project_details.quantity,'
                . 'erp_project_details.per_cost,erp_project_details.tax,erp_project_details.sub_total,erp_product.model_no,erp_product.product_image,'
                . 'erp_project_details.product_description,erp_product.type,erp_project_details.igst,erp_project_details.gst');
        $this->db->where('erp_project_details.q_id', intval($id));
        $this->db->join('erp_category', 'erp_category.cat_id=erp_project_details.category');
        $this->db->join('erp_product', 'erp_product.id=erp_project_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_project_details.brand');
        $query = $this->db->get('erp_project_details')->result_array();
        return $query;
    }

    public function get_all_invoice_by_id($id) {
        $this->db->select('customer.store_name,customer.id as customer, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_invoice.total_qty,erp_invoice.tax,erp_invoice.tax_label,'
                . 'erp_invoice.q_id,erp_invoice.net_total,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,erp_invoice.warranty_from,erp_invoice.warranty_to');
        //$this->db->where('erp_invoice.estatus',1);
        $this->db->where('erp_invoice.q_id', intval($id));
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

    public function get_all_inv_by_id($id) {
        $this->db->select('customer.store_name,customer.id as customer,customer.state_id, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_invoice.total_qty,erp_invoice.tax,erp_invoice.tax_label,'
                . 'erp_invoice.q_id,erp_invoice.net_total,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,erp_invoice.warranty_from,erp_invoice.warranty_to,erp_quotation.ref_name,erp_quotation.q_no,erp_invoice.is_gst');
        //$this->db->where('erp_invoice.estatus',1);
        $this->db->where('erp_invoice.q_id', intval($id));
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');
        $query = $this->db->get('erp_invoice')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('j_id', intval($val['id']));
            $this->db->where('type', 'invoice');
            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();
            $i++;
        }
        $j = 0;
        foreach ($query as $val) {
            $this->db->select('nick_name');
            $this->db->where('id', $val['ref_name']);
            $query[$j]['nickname'] = $this->db->get('erp_user')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_inv_details_by_id($id) {
        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,erp_product.hsn_sac,erp_product.add_amount,'
                . 'erp_invoice_details.category,erp_invoice_details.product_id,erp_invoice_details.brand,erp_invoice_details.quantity,'
                . 'erp_invoice_details.per_cost,erp_invoice_details.tax,erp_invoice_details.igst,erp_invoice_details.gst,erp_invoice_details.sub_total,erp_product.model_no,erp_product.product_image,'
                . 'erp_invoice_details.product_description,erp_product.type');
        $this->db->where('erp_invoice_details.q_id', intval($id));
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice_details.q_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_invoice_details.category');
        $this->db->join('erp_product', 'erp_product.id=erp_invoice_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_invoice_details.brand');

        $query = $this->db->get('erp_invoice_details');

        if ($query->num_rows() >= 0) {
            return $query->result_array();
            // echo"<pre>"; print_r($query->result_array()); exit;
        }
        return false;
    }

    public function get_all_invoice_details_by_id($id) {
        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,'
                . 'erp_invoice_details.category,erp_invoice_details.product_id,erp_invoice_details.brand,erp_invoice_details.quantity,'
                . 'erp_invoice_details.per_cost,erp_invoice_details.tax,erp_invoice_details.sub_total,erp_product.model_no,erp_product.product_image,'
                . 'erp_invoice_details.product_description,erp_product.type');
        $this->db->where('erp_invoice_details.in_id', intval($id));
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice_details.q_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_invoice_details.category');
        $this->db->join('erp_product', 'erp_product.id=erp_invoice_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_invoice_details.brand');

        $query = $this->db->get('erp_invoice_details');

        if ($query->num_rows() >= 0) {
            return $query->result_array();
            // echo"<pre>"; print_r($query->result_array()); exit;
        }
        return false;
    }

    public function get_all_quotation() {
        $this->db->select('customer.store_name,customer.id as customer, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.id,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'
                . 'erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus,erp_quotation.validity');
//                $this->db->select('customer.id as customer,customer.name,erp_quotation.id,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.net_total,erp_quotation.delivery_schedule,'
//                        . 'erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus');
        $this->db->where('erp_quotation.estatus !=', 0);
        $this->db->where('erp_quotation.type =', 2);
        $this->db->order_by('erp_quotation.id', 'desc');
        $this->db->join('customer', 'customer.id=erp_quotation.customer');
        $query = $this->db->get('erp_quotation');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_quotation_by_id($id) {
        $this->db->select('erp_invoice.inv_id,customer.store_name,customer.id as customer,erp_project_cost.job_id, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.id,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'
                . 'erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus');
        //$this->db->where('erp_quotation.estatus',1);
        $this->db->where('erp_quotation.id', $id);
        $this->db->join('customer', 'customer.id=erp_quotation.customer');
        $this->db->join('erp_project_cost', 'erp_project_cost.q_id=erp_quotation.id');
        $this->db->join('erp_invoice', 'erp_invoice.q_id=erp_quotation.id');
        $query = $this->db->get('erp_quotation');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_product_by_id($id) {
        $this->db->select('erp_product.id,erp_product.model_no,erp_product.product_name,erp_product.product_image,erp_product.cost_price'
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
                . 'erp_quotation_details.category,erp_quotation_details.product_id,erp_quotation_details.brand,erp_quotation_details.quantity,'
                . 'erp_quotation_details.per_cost,erp_quotation_details.tax,erp_quotation_details.sub_total,erp_product.model_no,erp_product.product_image,'
                . 'erp_quotation_details.product_description,erp_quotation_details.type,erp_product.type as product_type');
        $this->db->where('erp_quotation_details.q_id', $id);
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_quotation_details.q_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_quotation_details.category');
        $this->db->join('erp_product', 'erp_product.id=erp_quotation_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_quotation_details.brand');

        $query = $this->db->get('erp_quotation_details')->result_array();
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
            $this->db->update($this->erp_stock, array('quantity' => $quantity));
        } else {
            //Insert Stcok
            $quantity = $available_stock[0]['quantity'] - $check_stock['quantity'];
            $this->db->where('category', $check_stock['category']);
            $this->db->where('product_id', $check_stock['product_id']);
            $this->db->where('brand', $check_stock['brand']);
            $this->db->update($this->erp_stock, array('quantity' => $quantity));
        }
        //Insert Stock History
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

    public function get_id($id) {
        $this->db->select('id');
        $this->db->where($this->erp_project_cost . '.q_id', $id);
        return $this->db->get($this->erp_project_cost)->result_array();
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

    public function delete_quotation($id) {
        $this->db->where('q_id', $id);
        $this->db->delete($this->erp_project_cost);
    }

    public function delete_quotation_deteils_by_id($id) {
        $this->db->where('q_id', $id);
        $this->db->delete($this->erp_project_details);
    }

    public function change_quotation_status($id, $status) {
        $this->db->where($this->erp_quotation . '.id', $id);
        if ($this->db->update($this->erp_quotation, array('estatus' => $status))) {
            return true;
        }
        return false;
    }

    public function update_quotation($data, $id) {
        $this->db->where($this->erp_project_cost . '.q_id', $id);
        if ($this->db->update($this->erp_project_cost, $data)) {
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

    public function get_gen_by_id($id) {
        $this->db->select($this->table_name1 . '.*,' . $this->table_name1 . '.id as po_id');
        $this->db->select('vendor.name,store_name,address1,address2,city,pincode,mobil_number,email_id,tin');
        $this->db->select('master_state.state');
        $this->db->where($this->table_name1 . '.status', 1);
        $this->db->where($this->table_name1 . '.df', 0);
        $this->db->where($this->table_name1 . '.id', $id);
        $this->db->join('vendor', 'vendor.id=' . $this->table_name1 . '.customer');
        $this->db->join('master_state', 'master_state.id=' . $this->table_name1 . '.state');
        $query = $this->db->get($this->table_name1)->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select($this->table_name2 . '.style_id,color_id,lot_no,landed');
            $this->db->select('master_style.style_name,mrp,sp,style_desc');
            $this->db->select('master_colour.colour');
            $this->db->where($this->table_name2 . '.gen_id', $val['id']);
            $this->db->group_by($this->table_name2 . '.style_id');
            $this->db->group_by($this->table_name2 . '.color_id');
            $this->db->join('master_style', 'master_style.id=' . $this->table_name2 . '.style_id');
            $this->db->join('master_colour', 'master_colour.id=' . $this->table_name2 . '.color_id');
            $query[$i]['style_size'] = $this->db->get($this->table_name2)->result_array();
            $j = 0;
            foreach ($query[$i]['style_size'] as $val1) {
                $this->db->select($this->table_name2 . '.size_id,qty');
                $this->db->select($this->table_name2 . '.id');
                $this->db->select('master_size.size');
                $this->db->where($this->table_name2 . '.gen_id', $val['id']);
                $this->db->where($this->table_name2 . '.style_id', $val1['style_id']);
                $this->db->where($this->table_name2 . '.color_id', $val1['color_id']);
                $this->db->order_by($this->table_name2 . '.size_id', 'asc');
                $this->db->join('master_size', 'master_size.id=' . $this->table_name2 . '.size_id');
                $query[$i]['style_size'][$j]['list'] = $this->db->get($this->table_name2)->result_array();
                $j++;
            }


            $i++;
        }
        return $query;
    }

    public function get_gen_by_id_po($id) {
        $this->db->select($this->table_name1 . '.*');
        $this->db->select('vendor.name,store_name');
        $this->db->select('master_state.state');
        $this->db->where($this->table_name1 . '.status', 1);
        $this->db->where($this->table_name1 . '.df', 0);
        $this->db->where($this->table_name1 . '.grn_no', $id);
        $this->db->join('vendor', 'vendor.id=' . $this->table_name1 . '.customer');
        $this->db->join('master_state', 'master_state.id=' . $this->table_name1 . '.state');
        $query = $this->db->get($this->table_name1)->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select($this->table_name2 . '.style_id,color_id,lot_no,landed');
            $this->db->select('master_style.style_name,mrp,sp');
            $this->db->select('master_colour.colour');
            $this->db->where($this->table_name2 . '.gen_id', $val['id']);
            $this->db->group_by($this->table_name2 . '.style_id');
            $this->db->group_by($this->table_name2 . '.color_id');
            $this->db->join('master_style', 'master_style.id=' . $this->table_name2 . '.style_id');
            $this->db->join('master_colour', 'master_colour.id=' . $this->table_name2 . '.color_id');
            $query[$i]['style_size'] = $this->db->get($this->table_name2)->result_array();
            $j = 0;
            foreach ($query[$i]['style_size'] as $val1) {
                $this->db->select($this->table_name2 . '.size_id,qty');
                $this->db->select($this->table_name2 . '.id');
                $this->db->select('master_size.size');
                $this->db->where($this->table_name2 . '.gen_id', $val['id']);
                $this->db->where($this->table_name2 . '.style_id', $val1['style_id']);
                $this->db->where($this->table_name2 . '.color_id', $val1['color_id']);
                $this->db->order_by($this->table_name2 . '.size_id', 'asc');
                $this->db->join('master_size', 'master_size.id=' . $this->table_name2 . '.size_id');
                $query[$i]['style_size'][$j]['list'] = $this->db->get($this->table_name2)->result_array();
                $j++;
            }


            $i++;
        }
        return $query;
    }

    public function delete_all_data($id) {
        $this->db->where($this->table_name2 . '.gen_id', $id);
        if ($this->db->delete($this->table_name2)) {
            return true;
        }
        return false;
    }

    public function update_all_data($data, $id) {
        $this->db->where($this->table_name1 . '.id', $id);
        if ($this->db->update($this->table_name1, $data)) {
            return true;
        }
        return false;
    }

    public function get_gen_by_po($po) {
        $this->db->select('gen.grn_no,gen.id as gen_id');
        $this->db->where('gen.po_no', $po);
        $query = $this->db->get('gen')->result_array();
        return $query;
    }

    public function get_gen_by_po1($po, $id) {
        $this->db->select('gen.grn_no,gen.id as gen_id,inv_date');
        $this->db->where('gen.po_no', $po);
        $this->db->where('gen.id', $id);
        $query = $this->db->get('gen')->result_array();
        return $query;
    }

    public function get_size_val($where) {
        $this->db->select('SUM(gen_details.qty) as avail_qty');
        $this->db->where('gen.po_no', $where['po_no']);
        $this->db->where('gen_details.style_id', $where['style_id']);
        $this->db->where('gen_details.color_id', $where['color_id']);
        $this->db->where('gen_details.size_id', $where['size_id']);
        $this->db->join('gen', 'gen.id=gen_details.gen_id');
        $query = $this->db->get('gen_details')->result_array();
        return $query;
    }

    public function get_size_val_old($where) {
        $this->db->select('SUM(gen_details.qty) as avail_qty');
        $this->db->where($where);
        $query = $this->db->get('gen_details')->result_array();
        return $query;
    }

    public function check_po_no($po) {
        $this->db->select('grn_no');
        $this->db->like('grn_no', $po);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get($this->table_name1)->result_array();
        return $query;
    }

    public function get_all_po_for_expense() {
        $this->db->select('grn_no,id');
        $query = $this->db->get($this->table_name1)->result_array();
        return $query;
    }

    public function check_po_no1($po) {
        $this->db->select('grn_no');
        $this->db->like('grn_no', $po);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('gen')->result_array();
        return $query;
    }

    public function check_po_no2($data) {
        $this->db->select('grn_no');
        $this->db->like('grn_no', $data['q']);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('po')->result_array();
        return $query;
    }

    public function get_last_lot($lot_no) {
        $this->db->select('lot_no');
        $this->db->like('lot_no', $lot_no);
        $query = $this->db->get($this->table_name1);
        return $query->num_rows();
    }

    public function check_po_in_gen($po_no) {
        $this->db->select('id');
        $this->db->where('po_no', $po_no);
        $query = $this->db->get('gen')->result_array();
        return $query;
    }

    public function force_to_complete_po($data) {
        $this->db->where('id', $data['update_id']);
        $query = $this->db->update('po', array('complete_remarks' => $data['complete_remarks'], 'delivery_status' => 2));
    }

    public function get_last_lot_no($lot_no, $my) {
        $this->db->select('lot_no');
        $this->db->like('lot_no', $lot_no);
        $this->db->group_by('style_id');
        $this->db->where('style_id', $my['s_id']);
        $this->db->where('color_id', $my['c_id']);
        $this->db->group_by('gen_id');
        $this->db->group_by('color_id');
        $this->db->order_by('po_details.id', 'desc');
        $query = $this->db->get('po_details');
        return $query->result_array();
    }

    public function change() {
        $this->db->select('*');
        $query = $this->db->get('po')->result_array();
        $j = 0;
        foreach ($query as $val) {
            $this->db->select('sum(qty) as po_qty,landed');
            $this->db->where($this->table_name2 . '.gen_id', $val['id']);
            $this->db->group_by('gen_id');
            $po_details = $this->db->get($this->table_name2)->result_array();
            $total = 0;
            foreach ($po_details as $ss) {
                $total = $total + ($ss['po_qty'] * $ss['landed']);
            }
            $tax = round($total + ($total * (5.5 / 100)), 2);
            $this->db->where($this->table_name1 . '.id', $val['id']);
            $this->db->update($this->table_name1, array('org_total' => $total, 'net_total' => $tax));

            $this->db->where('gen.po_no', $val['grn_no']);
            $this->db->update('gen', array('total_value' => $total));
            $j++;
        }
    }

    /* public function get_check()
      {
      $this->db->select('sum(qty) as stock_qty,lot_no');
      $this->db->where('stock_from','so');
      $this->db->group_by('lot_no');
      $query = $this->db->get('stock_info')->result_array();
      $j=0;
      //echo "<pre>";
      foreach($query as $val)
      {
      $this->db->select('sum(qty) as po_qty,landed,lot_no');
      $this->db->where($this->table_name2.'.lot_no',$val['lot_no']);
      $this->db->group_by('lot_no');
      $po_details = $this->db->get($this->table_name2)->result_array();

      $t=$t+($po_details[0]['landed']*$po_details[0]['po_qty']);
      $j++;
      }
      echo $t;
      exit;
      } */

    function get_datatables($search_data) {

        $this->_get_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_quotation')->result_array();

        return $query;
    }

    function _get_datatables_query($serch_data = array()) {

        $this->db->select('customer.store_name,customer.id as customer, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.id,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'
                . 'erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus,erp_quotation.validity');
        $this->db->where('erp_quotation.estatus !=', 0);
        $this->db->where('erp_quotation.type =', 2);
        $this->db->join('customer', 'customer.id=erp_quotation.customer');

        $i = 0;
        $column_order = array(null, 'erp_quotation.q_no', 'customer.store_name', 'erp_quotation.total_qty', 'erp_quotation.subtotal_qty', 'erp_quotation.net_total', 'erp_quotation.mode_of_payment', 'erp_quotation.validity', 'erp_quotation.remarks');
        $column_search = array('erp_quotation.q_no', 'customer.store_name', 'erp_quotation.total_qty', 'erp_quotation.subtotal_qty', 'erp_quotation.net_total', 'erp_quotation.mode_of_payment', 'erp_quotation.validity', 'erp_quotation.remarks');
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

    function get_service_repair_count() {
        $this->db->select('id');
//                $this->db->select('customer.id as customer,customer.name,erp_quotation.id,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.net_total,erp_quotation.delivery_schedule,'
//                        . 'erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus');
        $this->db->where('service_status',1);
        $this->db->where('erp_service.status', 2);
        // $this->db->order_by('erp_quotation.id', 'desc');
        // $this->db->join('customer', 'customer.id=erp_quotation.customer');
        $query = $this->db->get('erp_service');
        return $query->num_rows();
    }

}
