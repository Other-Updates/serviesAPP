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
class Gen_model extends CI_Model {

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
    private $erp_email_settings = 'erp_email_settings';
    private $erp_user = 'erp_user';

    function __construct() {
        parent::__construct();
        $this->primaryTable = 'erp_quotation q';
        $this->joinTable = 'customer c';
        $this->joinTable1 = 'erp_user u';
        $this->select_column = 'u.nick_name,u.name as user_name,c.id as customer,c.store_name, c.name,c.mobil_number,c.email_id,c.address1,q.id,q.q_no,q.total_qty,q.tax,q.ref_name,q.tax_label,'
                . 'q.net_total,q.mode_of_payment,q.remarks,q.subtotal_qty,q.estatus,q.validity,q.created_date,q.project_name,q.referred_by';
        $this->column_order = array(null, 'q.q_no', 'q.project_name', 'q.referred_by', 'c.store_name', 'q.total_qty', 'q.net_total', 'q.created_date', null, null); //set column field database for datatable orderable
        $this->column_search = array('q.q_no', 'q.project_name', 'q.referred_by', 'c.store_name', 'q.total_qty', 'q.net_total', 'q.created_date'); //set column field database for datatable searchable
        $this->order = array('q.id' => 'DESC'); // default order
        $this->where_condition = array('q.type' => 1, 'q.estatus !=' => '0');
        $this->load->model('masters/user_model');
    }

    public function insert_quotation($data) {
        if ($this->db->insert($this->erp_quotation, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function insert_quotation_details($data) {
        $this->db->insert_batch($this->erp_quotation_details, $data);
        return true;
    }

    public function update_increment($id) {
        $this->db->where($this->increment_table . '.id', 12);
        if ($this->db->update($this->increment_table, $id)) {
            return true;
        }
        return false;
    }

    public function get_customer($atten_inputs) {
        $this->db->select('name,id,mobil_number,email_id,address1,store_name,state_id,mobile_number_2');
        $this->db->where($this->customer . '.status', 1);
        $this->db->where($this->customer . '.id', $atten_inputs['cust_id']);
        // $this->db->like($this->customer . '.store_name', $atten_inputs['q']);
        $query = $this->db->get($this->customer)->result_array();
        return $query;
    }

    public function get_all_email_details() {
        $this->db->select('*');
        $this->db->where("(type='q_sender' OR type='q_email' OR type='q_subject' OR type='q_cc_email')");
        // $this->db->where($this->erp_email_settings.'.type','q_email');
        $query = $this->db->get($this->erp_email_settings)->result_array();
        return $query;
    }

    public function get_customer_by_id($id) {
        $this->db->select('name,mobil_number,email_id,address1,store_name');
        $this->db->where($this->customer . '.id', $id);
        return $this->db->get($this->customer)->result_array();
    }

    public function get_customer_ref_name($ref_id) {
        $this->db->select('name,nick_name');
        $this->db->where($this->customer . '.id', $ref_id);
        $query = $this->db->get($this->customer)->result_array();
        $name = $query[0]['name'];
        $nickname = $query[0]['nick_name'];
        return $name . '-' . $nickname;
    }

    public function get_all_nick_name() {
        $this->db->select('*');
        $this->db->where($this->erp_user . '.status', 1);
        $query = $this->db->get($this->erp_user)->result_array();
        return $query;
    }

    public function get_product_bkp($atten_inputs) {
        $this->db->select('id,model_no,product_name,product_description,product_image,type,cost_price,selling_price,category_id,brand_id,cgst,sgst,igst');
        $this->db->where($this->erp_product . '.status', 1);
        $this->db->where($this->erp_product . '.type', 1);
        $this->db->where($this->erp_product . '.id', $atten_inputs['model_number_id']);
        // $this->db->like($this->erp_product . '.model_no', $atten_inputs['q']);
        $query = $this->db->get($this->erp_product)->result_array();
        return $query;
    }

    public function get_product($atten_inputs) {
        $this->db->select('erp_product.id,erp_product.model_no,erp_product.product_name,erp_product.product_description,erp_product.product_image,erp_product.type,erp_product.cost_price,erp_product.selling_price,erp_product.category_id,erp_product.brand_id,erp_product.cgst,erp_product.sgst,erp_product.igst,erp_product.hsn_sac,erp_product.add_amount,erp_product.po_add_amount,'
                . ' CASE WHEN erp_stock.quantity > 0 THEN erp_stock.quantity ELSE 0 END AS quantity', FALSE);
        $this->db->where($this->erp_product . '.status', 1);
        $this->db->where($this->erp_product . '.type', 1);
        $this->db->where($this->erp_product . '.id', $atten_inputs['model_number_id']);
        $this->db->join('erp_stock', 'erp_stock.product_id = erp_product.id', 'left');
        $query = $this->db->get($this->erp_product)->result_array();
        return $query;
    }

    public function get_service($atten_inputs) {
        $this->db->select('id,model_no,product_name,product_description,product_image,type,cost_price,selling_price,brand_id,category_id,brand_id,cgst,sgst,igst,hsn_sac,erp_product.add_amount,erp_product.po_add_amount');
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

    public function get_all_quotation($serch_data) {

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

                $this->db->where($this->erp_quotation . '.q_no', $serch_data['q_no']);
            }
            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select') {
                $this->db->where($this->erp_quotation . '.customer', $serch_data['customer']);
            }

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_quotation . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_quotation . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_quotation . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_quotation . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        $this->db->select('customer.id as customer,customer.store_name, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.id,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'
                . 'erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus,erp_quotation.validity,erp_quotation.created_date');
//                $this->db->select('customer.id as customer,customer.name,erp_quotation.id,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.net_total,erp_quotation.delivery_schedule,'
//                        . 'erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus');
        $this->db->where('erp_quotation.estatus !=', 0);
        $this->db->where('erp_quotation.type =', 1);
        $this->db->order_by('erp_quotation.id', 'desc');
        $this->db->join('customer', 'customer.id=erp_quotation.customer');
        $query = $this->db->get('erp_quotation')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select(' sum(sub_total - ( per_cost * quantity )) as tot_tax');
            $this->db->where($this->erp_quotation_details . '.q_id', $val['id']);
            $query[$i]['tax_details'] = $this->db->get($this->erp_quotation_details)->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_quotation_by_id($id) {
        $this->db->select('erp_user.nick_name,customer.state_id,customer.id as customer,customer.store_name,customer.name,customer.mobil_number,customer.email_id,customer.address1,customer.tin,erp_quotation.id,erp_quotation.referred_by,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'
                . 'erp_quotation.job_id,erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus,erp_quotation.validity,erp_quotation.created_date,erp_quotation.advance,erp_quotation.project_name,erp_quotation.is_gst,erp_quotation.warranty,erp_quotation.project_cost_net_total,erp_quotation.project_cost_subtotal_qty,erp_quotation.referred_by');
        //$this->db->where('erp_quotation.estatus',1);
        $this->db->where('erp_quotation.id', $id);
        $this->db->join('customer', 'customer.id=erp_quotation.customer','left',false);
        $this->db->join('erp_user', 'erp_user.id=erp_quotation.ref_name','left',false);
        $query = $this->db->get('erp_quotation');
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
        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,erp_product.hsn_sac,'
                . 'erp_quotation_details.id as del_id,erp_quotation_details.category,erp_quotation_details.product_id,erp_quotation_details.brand,erp_quotation_details.quantity,'
                . 'erp_quotation_details.per_cost,erp_quotation_details.tax,erp_quotation_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.add_amount,'
                . 'erp_quotation_details.product_description,erp_product.type,erp_quotation_details.gst,erp_quotation_details.igst,erp_quotation_details.project_cost_sub_total,erp_quotation_details.project_cost_per_cost');
        $this->db->where('erp_quotation_details.q_id', $id);
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_quotation_details.q_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_quotation_details.category');
        $this->db->join('erp_product', 'erp_product.id=erp_quotation_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_quotation_details.brand');
        $this->db->order_by('erp_quotation_details.id', 'ASC');
        $query = $this->db->get('erp_quotation_details')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('erp_stock.quantity');
//            $this->db->where('product_id', $val['product_id']);
            $this->db->where('category', $val['category']);
            $this->db->where('product_id', $val['product_id']);
            $this->db->where('brand', $val['brand']);
            $query[$i]['stock'] = $this->db->get('erp_stock')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_quotation_history_by_id($id) {
        $this->db->select('erp_user.nick_name,customer.state_id,customer.store_name,customer.id,customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation_history.q_no,erp_quotation_history.total_qty,erp_quotation_history.tax,erp_quotation_history.ref_name,erp_quotation_history.tax_label,'
                . 'erp_quotation_history.net_total,erp_quotation_history.delivery_schedule,erp_quotation_history.notification_date,erp_quotation_history.mode_of_payment,erp_quotation_history.remarks,erp_quotation_history.subtotal_qty,erp_quotation_history.validity,erp_quotation_history.created_date,erp_quotation.project_name,erp_quotation.is_gst,erp_quotation.referred_by');
        $this->db->where('erp_quotation_history.eStatus', 1);
        $this->db->where('erp_quotation_history.id', $id);
        $this->db->join('customer', 'customer.id=erp_quotation_history.customer');
        $this->db->join('erp_user', 'erp_user.id=erp_quotation_history.ref_name');
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_quotation_history.org_q_id');
        $query = $this->db->get('erp_quotation_history');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_quotation_history_details_by_id($id) {
        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_brand.id,erp_brand.brands,'
                . ' erp_product.id,erp_product.model_no,erp_product.hsn_sac,erp_product.add_amount,erp_product.product_name,erp_product.product_image,erp_quotation_history_details.product_description,erp_product.type,'
                . 'erp_quotation_history_details.category,erp_quotation_history_details.product_id,erp_quotation_history_details.brand,erp_quotation_history_details.quantity,'
                . 'erp_quotation_history_details.per_cost,erp_quotation_history_details.tax,erp_quotation_history_details.sub_total,erp_product.type,erp_quotation_history_details.gst,erp_quotation_history_details.igst');
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

    public function get_all_gen($serch_data = NULL) {

        if (isset($serch_data) && !empty($serch_data)) {
            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';


            if (!empty($serch_data['q_no']) && $serch_data['q_no'] != '') {

                $this->db->where($this->erp_quotation . 'q_no', $serch_data['q_no']);
            }
            if (!empty($serch_data['po'])) {
                $this->db->where($this->erp_quotation . '.q_no', $serch_data['po']);
            }

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_quotation . ".inv_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_quotation . ".inv_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_quotation . ".inv_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["style"]) && $serch_data["style"] != "") {

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
            $this->db->where("DATE_FORMAT(" . $this->erp_quotation . ".inv_date,'%Y-%m-%d') >='" . $from . "' AND DATE_FORMAT(" . $this->erp_quotation . ".inv_date,'%Y-%m-%d') <= '" . $to . "'");
        }

        $this->db->select('*');
        $this->db->select('customer.name');
        $this->db->order_by($this->erp_quotation . '.id', 'desc');
        $this->db->join('erp_quotation', 'erp_quotation.q_no=' . $this->erp_quotation . '.q_no');
        $this->db->join('customer', 'customer.id=erp_quotation.customer');
        $query = $this->db->get($this->erp_quotation)->result_array();
        return $query;
    }

    public function get_all_product() {
        $this->db->select('erp_product.*');
        $this->db->where($this->erp_product . '.type', 1);
        $query = $this->db->get('erp_product')->result_array();
        return $query;
    }

    public function get_product_data($atten_inputs) {
        //echo '<pre>hi';print_r($atten_inputs);
        $this->db->select('erp_product.*');
        $this->db->join('erp_stock', 'erp_stock.product_id = erp_product.id', 'left');
        $keyword = $atten_inputs['pro'];
        $this->db->where("erp_product.model_no LIKE '%$keyword%'");
        $this->db->where($this->erp_product . '.status', 1);
        $this->db->where($this->erp_product . '.type', 1);
        $this->db->where('erp_stock.quantity >', 0.00);
        $query = $this->db->get($this->erp_product)->result_array();
        //echo $this->db->last_query();exit;
        return $query;
    }
    public function get_product_data1($atten_inputs=NULL) {
        $this->db->select('erp_product.*');
        //$this->db->join('erp_stock', 'erp_stock.product_id = erp_product.id', 'left');
        if($atten_inputs != NULL){
            $keyword = $atten_inputs['pro'];
            $this->db->where("erp_product.model_no LIKE '%$keyword%'");
        }
        $this->db->where($this->erp_product . '.status', 1);
        $this->db->where($this->erp_product . '.type', 1);
        //$this->db->where('erp_stock.quantity >', 0.00);
        $query = $this->db->get($this->erp_product)->result_array();
        return $query;
    }

    public function get_all_product1() {
        $this->db->select('*');
        $this->db->where($this->erp_product . '.type', 2);
        $query = $this->db->get('erp_product')->result_array();
        return $query;
    }

    public function get_all_customers() {
        $this->db->select('name,id,mobil_number,email_id,address1,store_name,tin,mobile_number_2');
        $this->db->where($this->customer . '.status', 1);
        $query = $this->db->get($this->customer)->result_array();
        return $query;
    }

    function get_datatables() {
        $join['joins'] = array(
            array("table_name" => "customer", "table_alias" => "c", "join_condition" => "c.id=q.customer", "join_type" => "left"),
            array("table_name" => "erp_user", "table_alias" => "u", "join_condition" => "u.id = q.ref_name", "join_type" => "left")
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
            array("table_name" => "customer", "table_alias" => "c", "join_condition" => "c.id=q.customer", "join_type" => "left"),
            array("table_name" => "erp_user", "table_alias" => "u", "join_condition" => "u.id = q.ref_name", "join_type" => "left")
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

    function is_project_name_available($project_name) {
        $this->db->select($this->erp_quotation . '.id');
        $this->db->where($this->erp_quotation . '.estatus', 1);
        $this->db->where('LCASE(project_name)', strtolower($project_name));
        if (!empty($id))
            $this->db->where('id !=', $id);
        $query = $this->db->get($this->erp_quotation);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function convert_number(float $number) {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            } else
                $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    }

    public function get_pending_quotation_count() {
        $this->db->select('erp_quotation.id');
        $this->db->where('erp_quotation.estatus', 1);
        $query = $this->db->get('erp_quotation');
        return $query->num_rows();
    }

}
