<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Api_model extends CI_Model {

    private $erp_user = 'erp_user';
    private $customer = 'customer';
    private $erp_enquiry = 'erp_enquiry';
    private $erp_invoice = 'erp_invoice';
    private $increment_table = 'increment_table';
    private $service_table = 'erp_service';
    private $ads = 'erp_advertisement';
    private $ads_details = 'erp_advertisement_details';
    private $product_image_table = 'erp_service_product_image';
    private $erp_links = 'erp_links';
    private $erp_link_details = 'erp_link_details';
    private $service_detail_table = 'erp_service_details';

    function __construct() {
        parent::__construct();
    }

    public function get_user_by_login($username, $password) {

        $this->db->select('tab_1.*');
        $this->db->where('username', $username);
        $this->db->where('password', md5($password));
        $this->db->where('status', 1);
        $query = $this->db->get($this->erp_user . ' AS tab_1');
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
        return false;
    }

    public function get_customer_by_login($mobile_number, $password) {

        $this->db->select('tab_1.*');
        $this->db->where('tab_1.password', md5($password));
        $this->db->where('tab_1.status', 1);
        $where = '(tab_1.mobile_number_2 = "' . $mobile_number . '" OR tab_1.mobile_number_3 = "' . $mobile_number . '" OR tab_1.mobil_number = "' . $mobile_number . '")';
        $this->db->where($where);
        $query = $this->db->get($this->customer . ' AS tab_1');
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
        return false;
    }

    function insert_customer_details($data) {
        if ($this->db->insert('customer', $data)) {
            $customer_id = $this->db->insert_id();
            return $customer_id;
        }
        return FALSE;
    }

    function get_customer_details_by_insert_id($customer_id) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.id', $customer_id);
        $query = $this->db->get($this->customer . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function is_email_id_exists($email_id) {
        $this->db->where('tab_1.email_id', $email_id);
        $this->db->where('tab_1.status', 1);
        $query = $this->db->get($this->customer . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function is_mobile_number_exists($mobile_number) {
        $this->db->where('tab_1.mobil_number', $mobile_number);
        $this->db->where('tab_1.status', 1);
        $query = $this->db->get($this->customer . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_customer_details_by_id($customer_id) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.id', $customer_id);
        $query = $this->db->get($this->customer . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function check_otp_by_email_id($email_id, $otp) {

        $this->db->where('tab_1.email_id', $email_id);
        $this->db->where('tab_1.otp_pincode', $otp);
        $this->db->where('tab_1.otp_verification_status', 0);
        $query = $this->db->get($this->customer . ' AS tab_1');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    function check_resent_otp_by_email_id($email_id, $otp) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.email_id', $email_id);
        $this->db->where('tab_1.otp_pincode', $otp);
        $this->db->where('tab_1.otp_verification_status', 3);
        $query = $this->db->get($this->customer . ' AS tab_1');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return 0;
        }
    }

    function update_customer_details($email_id, $data) {
        $this->db->where('email_id', $email_id);
        if ($this->db->update($this->customer, $data)) {
            return true;
        }
        return false;
    }

    function get_customer_by_email_id($email_id) {
        $this->db->select($this->customer . '.id');
        $this->db->where($this->customer . '.email_id', $email_id);
        $query = $this->db->get($this->customer);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_all_leads_lists($customer_id) {
        $this->db->select('erp_enquiry.*,erp_category.categoryName,erp_category.category_image');
        $this->db->where('erp_enquiry.customer_id', $customer_id);
        $this->db->where('erp_enquiry.enquiry_status', 1);
        $this->db->join('erp_category', 'erp_category.cat_id=' . $this->erp_enquiry . '.cat_id');
        $query = $this->db->get('erp_enquiry')->result_array();
        return $query;
    }

    function get_pending_leads($customer_id) {
        $this->db->select('enquiry_no,enquiry_about,created_date');
        $this->db->where('erp_enquiry.customer_id', $customer_id);
        $status = array('leads', 'leads_follow_up', 'quotation_follow_up', 'quotation');
        $this->db->where_in('erp_enquiry.status', $status);
        $this->db->where_in('erp_enquiry.enquiry_status', 1);
        $this->db->order_by('erp_enquiry.created_date', 'desc');
        $query = $this->db->get('erp_enquiry')->result_array();
        return $query;
    }

     function get_non_completed_leads($customer_id) {
        $this->db->select('enquiry_no,enquiry_about,created_date,status');
        $this->db->where('erp_enquiry.customer_id', $customer_id);
        $this->db->where('erp_enquiry.status !=', 'order_conform');
        $this->db->where_in('erp_enquiry.enquiry_status', 1);
        $this->db->order_by('erp_enquiry.created_date', 'desc');
        $query = $this->db->get('erp_enquiry')->result_array();
        return $query;
    }

    function get_pending_services($customer_id) {
        $this->db->select('q_no,remarks,notification_date');
        $this->db->where('erp_quotation.estatus', '1');
        $this->db->where('erp_quotation.type =', 2);
        $this->db->where('erp_quotation.customer', $customer_id);
        $this->db->order_by('erp_quotation.id', 'desc');
        $query = $this->db->get('erp_quotation')->result_array();
        return $query;
    }

    public function get_all_categories() {
        $this->db->select('*');
        $this->db->where('is_checked', 1);
        $this->db->where('eStatus', 1);
        $query = $this->db->get('erp_category')->result_array();
        return $query;
    }

    public function get_customer($cust_id) {
        $this->db->select('name,id,mobil_number,email_id,address1,mobile_number_2');
        $this->db->where($this->customer . '.status', 1);
        $this->db->where($this->customer . '.id', $cust_id);
        $query = $this->db->get($this->customer)->result_array();
        return $query;
    }

    public function insert_leads($data) {
        if ($this->db->insert('erp_enquiry', $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
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

    public function update_leads($data, $id) {
        $this->db->where($this->erp_enquiry . '.id', $id);
        if ($this->db->update($this->erp_enquiry, $data)) {
            return true;
        }
        return false;
    }

    public function get_leads_data_by_id($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get($this->erp_enquiry)->result_array();
        return $query;
    }

    public function get_service_list($id, $type, $from_date, $to_date) {

        $from_date = str_replace('/', '-', $from_date);
        $to_date = str_replace('/', '-', $to_date);
        $formated_from_date = date('Y-m-d', strtotime($from_date));
        $formated_to_date = date('Y-m-d', strtotime($to_date));
        $this->db->select('erp_service.*,erp_user.name as attendant,erp_user.mobile_no as attendant_mobile_no');
        $this->db->join('erp_user', 'erp_user.id=erp_service.emp_id', 'LEFT');
        $this->db->where('erp_service.service_status', 1);
        if ($type == 'employee') {
            $this->db->select('erp_invoice.id as invid,erp_invoice.net_total,erp_invoice.warranty_from,erp_invoice.warranty_to');
//            $this->db->where('erp_service.emp_id', $id);
            $this->db->where("FIND_IN_SET('$id',emp_id) > 0");
            if (isset($from_date) && $from_date != '' && isset($to_date) && $to_date != '') {
                $this->db->where('DATE_FORMAT(erp_service.created_date, "%Y-%m-%d")>=', $formated_from_date);
                $this->db->where('DATE_FORMAT(erp_service.created_date, "%Y-%m-%d")<=', $formated_to_date);
            }
//        $this->db->group_up('erp_service.inv_no');
            $this->db->join('erp_invoice', 'erp_invoice.inv_id=erp_service.inv_no', 'LEFT');
        } else if ($type == 'customer') {
            // $this->db->select('*');
            $this->db->where('erp_service.customer_id', $id);
        }
        $query = $this->db->get($this->service_table)->result_array();
        if (!empty($query)) {
            foreach ($query as $keys => $result) {
                $this->db->select('tab_1.*');
                $this->db->where('tab_1.service_id', $result['id']);
                $this->db->where('tab_1.type', 'add');
                $img_query = $this->db->get($this->product_image_table . ' AS tab_1');
                $query[$keys]['customer_image_upload'] = $img_query->result_array();

                //Get History
                $this->db->select('tab_1.service_id,tab_1.emp_id,tab_2.name,tab_2.mobile_no,tab_1.work_performed,tab_1.created_date');
                $this->db->select('(CASE WHEN tab_1.work_status = "1" THEN "Completed" ELSE "Pending" END) AS work_status',false);
                $this->db->select('GROUP_CONCAT(tab_1.emp_image_upload) as emp_image',false);
                $this->db->join($this->erp_user.' AS tab_2','tab_1.emp_id = tab_2.id','left');
                $this->db->where('tab_1.service_id',$result['id']);
                $this->db->group_by('tab_1.created_date');
                $this->db->order_by('tab_1.created_date','desc');
                $query[$keys]['service_history'] = $this->db->get($this->service_detail_table.' AS tab_1')->result_array();
            }
            foreach ($query as $key1 => $result) {
                $this->db->select('tab_1.*');
                $this->db->where('tab_1.service_id', $result['id']);
                $this->db->where('tab_1.type', 'edit');
                $img_query = $this->db->get($this->product_image_table . ' AS tab_1');
                $query[$key1]['employee_image_upload'] = $img_query->result_array();
            }
        }
        if ($type == 'employee') {
            $i = 0;
            foreach ($query as $val) {
                $this->db->select('erp_category.cat_id, erp_category.categoryName, erp_product.id, erp_product.product_name, erp_brand.id, erp_brand.brands, '
                        . 'erp_invoice_details.category, erp_invoice_details.product_id, erp_invoice_details.brand, erp_invoice_details.quantity, '
                        . 'erp_invoice_details.per_cost, erp_invoice_details.tax, erp_invoice_details.sub_total, erp_product.model_no, erp_product.product_image, '
                        . 'erp_invoice_details.product_description, erp_product.type, erp_invoice_details.gst, erp_invoice_details.igst');
                $this->db->where('erp_invoice_details.in_id', intval($val['invid']));
                $this->db->join('erp_quotation', 'erp_quotation.id = erp_invoice_details.q_id');
                $this->db->join('erp_category', 'erp_category.cat_id = erp_invoice_details.category');
                $this->db->join('erp_product', 'erp_product.id = erp_invoice_details.product_id');
                $this->db->join('erp_brand', 'erp_brand.id = erp_invoice_details.brand');
                $this->db->join('erp_invoice', 'erp_invoice.id = erp_invoice_details.in_id');
                $query[$i]['invoice_details'] = $this->db->get('erp_invoice_details')->result_array();
                $i++;
            }
        }

        return $query;
    }

    public function get_service_pending_list($id, $type, $from_date, $to_date) {

        $from_date = str_replace('/', '-', $from_date);
        $to_date = str_replace('/', '-', $to_date);
        $formated_from_date = date('Y-m-d', strtotime($from_date));
        $formated_to_date = date('Y-m-d', strtotime($to_date));
        $this->db->select('erp_service.*,erp_user.name as attendant,erp_user.mobile_no as attendant_mobile_no');
        $this->db->join('erp_user', 'erp_user.id=erp_service.emp_id', 'LEFT');
        $this->db->where('erp_service.service_status', 1);

        if ($type == 'employee') {
            $this->db->select('erp_invoice.id as invid,erp_invoice.net_total,erp_invoice.warranty_from,erp_invoice.warranty_to');
//            $this->db->where('erp_service.emp_id', $id);
            $this->db->where("FIND_IN_SET('$id',emp_id) > 0");
            $this->db->where('erp_service.status', 2);
            if (isset($from_date) && $from_date != '' && isset($to_date) && $to_date != '') {
                $this->db->where('DATE_FORMAT(erp_service.created_date, "%Y-%m-%d")>=', $formated_from_date);
                $this->db->where('DATE_FORMAT(erp_service.created_date, "%Y-%m-%d")<=', $formated_to_date);
            }

            $this->db->join('erp_invoice', 'erp_invoice.inv_id=erp_service.inv_no', 'LEFT');
        } else if ($type == 'customer') {
            $this->db->where('erp_service.customer_id', $id);
            $this->db->where('erp_service.status', 2);
        }

        $query = $this->db->get($this->service_table)->result_array();

        if (!empty($query)) {
            foreach ($query as $keys => $result) {
                $this->db->select('tab_1.*');
                $this->db->where('tab_1.service_id', $result['id']);
                $this->db->where('tab_1.type', 'add');
                $img_query = $this->db->get($this->product_image_table . ' AS tab_1');
                $query[$keys]['customer_image_upload'] = $img_query->result_array();
            }
            foreach ($query as $key1 => $result) {
                $this->db->select('tab_1.*');
                $this->db->where('tab_1.service_id', $result['id']);
                $this->db->where('tab_1.type', 'edit');
                $img_query = $this->db->get($this->product_image_table . ' AS tab_1');
                $query[$key1]['employee_image_upload'] = $img_query->result_array();
            }
        }
        if ($type == 'employee') {
            $i = 0;
            foreach ($query as $val) {
                $this->db->select('erp_category.cat_id, erp_category.categoryName, erp_product.id, erp_product.product_name, erp_brand.id, erp_brand.brands, '
                        . 'erp_invoice_details.category, erp_invoice_details.product_id, erp_invoice_details.brand, erp_invoice_details.quantity, '
                        . 'erp_invoice_details.per_cost, erp_invoice_details.tax, erp_invoice_details.sub_total, erp_product.model_no, erp_product.product_image, '
                        . 'erp_invoice_details.product_description, erp_product.type, erp_invoice_details.gst, erp_invoice_details.igst');
                $this->db->where('erp_invoice_details.in_id', intval($val['invid']));
                $this->db->join('erp_quotation', 'erp_quotation.id = erp_invoice_details.q_id');
                $this->db->join('erp_category', 'erp_category.cat_id = erp_invoice_details.category');
                $this->db->join('erp_product', 'erp_product.id = erp_invoice_details.product_id');
                $this->db->join('erp_brand', 'erp_brand.id = erp_invoice_details.brand');
                $this->db->join('erp_invoice', 'erp_invoice.id = erp_invoice_details.in_id');
                $query[$i]['invoice_details'] = $this->db->get('erp_invoice_details')->result_array();


//                $query[$i]['invoice_details'][$i]['product_img_path'] = base_url() . 'attachement/product/' . $query[$i]['invoice_details'][$i]['product_image'];
                $i++;
            }
        }

        return $query;
    }


      public function get_service_not_completed_list($id, $type, $from_date, $to_date) {

        $from_date = str_replace('/', '-', $from_date);
        $to_date = str_replace('/', '-', $to_date);
        $formated_from_date = date('Y-m-d', strtotime($from_date));
        $formated_to_date = date('Y-m-d', strtotime($to_date));
        $this->db->select('erp_service.*,erp_user.name as attendant,erp_user.mobile_no as attendant_mobile_no');
        $this->db->join('erp_user', 'erp_user.id=erp_service.emp_id', 'LEFT');
        $this->db->where('erp_service.service_status', 1);

        if ($type == 'employee') {
            $this->db->select('erp_invoice.id as invid,erp_invoice.net_total,erp_invoice.warranty_from,erp_invoice.warranty_to');
//            $this->db->where('erp_service.emp_id', $id);
            $this->db->where("FIND_IN_SET('$id',emp_id) > 0");
            $this->db->where('erp_service.status !=', 1);
            if (isset($from_date) && $from_date != '' && isset($to_date) && $to_date != '') {
                $this->db->where('DATE_FORMAT(erp_service.created_date, "%Y-%m-%d")>=', $formated_from_date);
                $this->db->where('DATE_FORMAT(erp_service.created_date, "%Y-%m-%d")<=', $formated_to_date);
            }

            $this->db->join('erp_invoice', 'erp_invoice.inv_id=erp_service.inv_no', 'LEFT');
        } else if ($type == 'customer') {
            $this->db->where('erp_service.customer_id', $id);
            $this->db->where('erp_service.status !=', 1);
        }

        $query = $this->db->get($this->service_table)->result_array();

        if (!empty($query)) {
            foreach ($query as $keys => $result) {
                $this->db->select('tab_1.*');
                $this->db->where('tab_1.service_id', $result['id']);
                $this->db->where('tab_1.type', 'add');
                $img_query = $this->db->get($this->product_image_table . ' AS tab_1');
                $query[$keys]['customer_image_upload'] = $img_query->result_array();
            }
            foreach ($query as $key1 => $result) {
                $this->db->select('tab_1.*');
                $this->db->where('tab_1.service_id', $result['id']);
                $this->db->where('tab_1.type', 'edit');
                $img_query = $this->db->get($this->product_image_table . ' AS tab_1');
                $query[$key1]['employee_image_upload'] = $img_query->result_array();
            }
        }
        if ($type == 'employee') {
            $i = 0;
            foreach ($query as $val) {
                $this->db->select('erp_category.cat_id, erp_category.categoryName, erp_product.id, erp_product.product_name, erp_brand.id, erp_brand.brands, '
                        . 'erp_invoice_details.category, erp_invoice_details.product_id, erp_invoice_details.brand, erp_invoice_details.quantity, '
                        . 'erp_invoice_details.per_cost, erp_invoice_details.tax, erp_invoice_details.sub_total, erp_product.model_no, erp_product.product_image, '
                        . 'erp_invoice_details.product_description, erp_product.type, erp_invoice_details.gst, erp_invoice_details.igst');
                $this->db->where('erp_invoice_details.in_id', intval($val['invid']));
                $this->db->join('erp_quotation', 'erp_quotation.id = erp_invoice_details.q_id');
                $this->db->join('erp_category', 'erp_category.cat_id = erp_invoice_details.category');
                $this->db->join('erp_product', 'erp_product.id = erp_invoice_details.product_id');
                $this->db->join('erp_brand', 'erp_brand.id = erp_invoice_details.brand');
                $this->db->join('erp_invoice', 'erp_invoice.id = erp_invoice_details.in_id');
                $query[$i]['invoice_details'] = $this->db->get('erp_invoice_details')->result_array();
                $i++;
            }
        }

        return $query;
    }

    public function get_last_service_token() {
        $this->db->select('ticket_no');
        $this->db->order_by('erp_service.id', 'desc');
        $query = $this->db->get($this->service_table)->result_array();
        $result = explode("-", $query[0]['ticket_no']);
        return $result[1];
    }

    public function insert_service($data) {
        if ($this->db->insert($this->service_table, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function insert_service_image($data) {
        if ($this->db->insert_batch($this->product_image_table, $data)) {
            return true;
        }
        return false;
    }

    public function delete_service_image($id, $type) {
        $this->db->where('service_id', $id);
        $this->db->where('type', $type);
        $this->db->delete($this->product_image_table);
        return true;
    }

    public function update_service($data, $id) {
        $this->db->where('id', $id);
        if ($this->db->update('erp_service', $data)) {
            return true;
        }
        return false;
    }

    function get_service_data_by_id($id) {
        $this->db->select('erp_service.*');
        $this->db->where('erp_service.id', $id);
        $this->db->where('erp_service.service_status', 1);
        $query = $this->db->get('erp_service');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    public function get_pending_service_list($customer_id) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.customer_id', $customer_id);
        $this->db->where('tab_1.status', 2);
        $query = $this->db->get($this->service_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }


       public function get_not_completed_service_list($customer_id) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.customer_id', $customer_id);
        $this->db->where('tab_1.status !=', 1);
        $query = $this->db->get($this->service_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function update_customer($data, $id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->customer, $data)) {
            return true;
        }
        return false;
    }

    public function update_user($data, $id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->erp_user, $data)) {
            return true;
        }
        return false;
    }

    function get_customer_data_by_id($id) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.id', $id);
        $query = $this->db->get($this->customer . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_user_data_by_id($id) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.id', $id);
        $query = $this->db->get($this->erp_user . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_adverstisment_details_bkp() {
        $this->db->select('tab_1.*');
        $this->db->order_by('tab_1.id', 'DESC');
        $this->db->where('tab_2.is_deleted', 0);
        $this->db->join($this->ads . ' AS tab_2', 'tab_2.id = tab_1.ads_id', 'LEFT');
        $query = $this->db->get($this->ads_details . ' AS tab_1');
        if ($query->num_rows() > 0) {
            $ads_data = $query->result_array();
            $ads_datas = array();
            foreach ($ads_data as $key => $result) {
                $id = $result['id'];
                $this->db->select('*');
                $this->db->where('tab_2.ads_id', $id);
                $ads_details = $this->db->get($this->ads_details . ' AS tab_2')->result_array();

                $ads_datas['ads_details'] = $ads_details;
            }

            return $ads_datas;
        }
    }

    function get_adverstisment_details() {
        $this->db->select('tab_1.*');
        $this->db->order_by('tab_1.id', 'DESC');
        $this->db->where('tab_1.is_deleted', 0);
        $this->db->where('tab_1.status', 1);
        $query = $this->db->get($this->ads . ' AS tab_1')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('tab_2.id,tab_2.ads_id,tab_2.file_type,tab_2.ads_data,ifnull(tab_2.ads_data_path,"") as ads_data_path,ifnull(tab_2.ads_data_link,"") as ads_data_link,tab_2.sort_order,tab_2.status,tab_2.is_deleted,tab_2.created_at,tab_2.updated_at',false);
            $this->db->where('tab_2.ads_id', intval($val['id']));
            $this->db->order_by("tab_2.sort_order","asc");
            $query[$i]['ads_details'] = $this->db->get($this->ads_details . ' AS tab_2')->result_array();
            $i++;
        }
        return $query;
    }

    function get_link_details() {
        $this->db->select('erp_links.*');
        $this->db->order_by('erp_links.id', 'DESC');
        $this->db->where('erp_links.is_deleted', 0);
        $this->db->where('erp_links.status', 1);
        $query = $this->db->get($this->erp_links)->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('erp_link_details.*');
            $this->db->where('link_id', intval($val['id']));
            $query[$i]['link_datas'] = $this->db->get('erp_link_details')->result_array();
            $i++;
        }
        return $query;
    }

    function get_all_invoice_id($customer_id) {
        $this->db->select($this->erp_invoice . '.id, inv_id');
        $this->db->where($this->erp_invoice . '.customer', $customer_id);
        $query = $this->db->get($this->erp_invoice);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_invoice_details_by_id($inv_id) {
        $this->db->select('customer.id as customer,customer.state_id,customer.store_name, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_quotation.q_no,erp_invoice.total_qty,erp_invoice.tax,erp_quotation.ref_name,erp_invoice.tax_label,'
                . 'erp_invoice.net_total,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,erp_invoice.warranty_from,erp_invoice.warranty_to,erp_invoice.created_date,erp_invoice.q_id,erp_invoice.id,erp_invoice.is_gst,erp_invoice.advance');
        $this->db->where($this->erp_invoice . '.inv_id', $inv_id);
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
        $query = $this->db->get($this->erp_invoice)->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,'
                    . 'erp_invoice_details.category,erp_invoice_details.product_id,erp_invoice_details.brand,erp_invoice_details.quantity,'
                    . 'erp_invoice_details.per_cost,erp_invoice_details.tax,erp_invoice_details.sub_total,erp_product.model_no,erp_product.product_image,'
                    . 'erp_invoice_details.product_description,erp_product.type,erp_invoice_details.gst,erp_invoice_details.igst');
            $this->db->where('erp_invoice_details.in_id', intval($val['id']));
            $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice_details.q_id');
            $this->db->join('erp_category', 'erp_category.cat_id=erp_invoice_details.category');
            $this->db->join('erp_product', 'erp_product.id=erp_invoice_details.product_id');
            $this->db->join('erp_brand', 'erp_brand.id=erp_invoice_details.brand');
            $query[$i]['invoice_details'] = $this->db->get('erp_invoice_details')->result_array();
            $i++;
        }
        return $query;
    }

    function get_all_attendant_details_by_invno($customer_id) {
        $this->db->select('erp_service.id,erp_service.inv_no,erp_service.emp_id as attendant_id,erp_service.created_date,erp_service.status,erp_service.work_performed');
        $this->db->select('erp_user' . '.name');
        $this->db->where('erp_service.customer_id', $customer_id);
        // $this->db->where('erp_service.inv_no', $inv_no['']);
        // $this->db->where('erp_service.emp_id !=', '');
        $this->db->where('erp_service.service_status', 1);
        $this->db->join('erp_user', 'erp_service.emp_id=erp_user.id', 'LEFT');
        $query = $this->db->get('erp_service')->result_array();
        if (!empty($query)) {
            foreach ($query as $keys => $result) {
                $this->db->select('erp_service_product_image.*');
                $this->db->where('erp_service_product_image.service_id', $result['id']);
                $this->db->where('erp_service_product_image.type', 'edit');
                $img_query = $this->db->get($this->product_image_table);
                $query[$keys]['employee_image_upload'] = $img_query->result_array();
            }
        }
        return $query;
    }

    function get_project_link_by_invno($inv_no) {
        $this->db->select('erp_invoice.q_id,inv_id');
        $this->db->where('erp_invoice.inv_id', $inv_no);
        $query = $this->db->get('erp_invoice')->result_array();

        if (!empty($query)) {
            foreach ($query as $keys => $result) {
                $this->db->select('erp_project_cost.link_1,link_2,link_3,link_4');
                $this->db->where('erp_project_cost.q_id', $result['q_id']);
                $query[$keys]['link_details'] = $this->db->get('erp_project_cost')->result_array();
            }
        }
        return $query;
    }

    public function insert_emp_attendance($data, $user_id) {
        $this->db->select('*');
        $this->db->where('user_id', $user_id);
        $this->db->where('DATE(erp_attendance.created_date)=', date('Y-m-d'));
        $get_user = $this->db->get('erp_attendance')->result_array();

        if ($get_user) {

            $this->db->where('id', $get_user[0]['id']);
            $this->db->where('DATE(erp_attendance.created_date)=', date('Y-m-d'));
            $update_data['attendance_status'] = $data['attendance_status'];
            $update_data['updated_date'] = date("Y-m-d H:i:s");
            $update_data['login_location'] = $data['login_location'];
            $upadte = $this->db->update('erp_attendance', $update_data);

            return $get_user[0]['id'];
        } else {

            $this->db->insert('erp_attendance', $data);
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
    }

    public function service_history($service_id,$type,$is_image_upload) {
        $this->db->select('tab_1.id as service_id,tab_1.emp_id,tab_1.work_performed,tab_1.description,tab_1.status as work_status,tab_1.updated_date as created_date');
        if ($is_image_upload == '1') {
            $this->db->select('tab_2.img_path as emp_image_upload',false);
            $this->db->join($this->product_image_table.' AS tab_2','tab_1.id = tab_2.service_id and tab_2.type="'.$type.'"','left');
        }
        $this->db->where('tab_1.id',$service_id);
        $this->db->where('tab_1.service_status','1');
        $query = $this->db->get($this->service_table.' AS tab_1')->result_array();
        if(count($query) > 0) {
            $insert_data = $query;
            $this->db->insert_batch($this->service_detail_table,$insert_data);
        }
        return True;
    }

    public function get_service_history($customer_id='',$employee_id='',$service_id='',$type) {
        $current_status = $service_history = $history = array();
        $this->db->select('erp_service.id as service_id,erp_service.emp_id as emp_id,erp_user.name as name,erp_user.mobile_no as mobile_no,erp_service.work_performed');
        $this->db->select('if(erp_service.updated_date!="0000-00-00 00:00:00",date_format(erp_service.updated_date,,"%d/%m/%Y %H:%i"),date_format(erp_service.created_date,,"%d/%m/%Y %H:%i")) as created_date',false);
        $this->db->select('(CASE WHEN erp_service.status = "1" THEN "Completed" WHEN erp_service.status = "2" THEN "Pending" ELSE "In-Progress" END) AS work_status',false);
        $this->db->select('erp_service_product_image.img_path as emp_image');
        $this->db->join('erp_user', 'erp_user.id=erp_service.emp_id', 'LEFT');
        $this->db->join('erp_service_product_image', 'erp_service.id=erp_service_product_image.service_id and erp_service_product_image.type="edit"', 'LEFT');
        $this->db->where('erp_service.service_status', 1);
        $this->db->where('erp_service.id', $service_id);
        if ($type == 'employee') {
            $this->db->where("FIND_IN_SET('$employee_id',erp_service.emp_id) > 0");
        } else if ($type == 'customer') {
            $this->db->where('erp_service.customer_id', $customer_id);
        }
        $current_status = $this->db->get($this->service_table)->result_array();
        $this->db->select('tab_1.service_id,tab_1.emp_id,tab_2.name,tab_2.mobile_no,tab_1.work_performed,date_format(tab_1.created_date,"%d/%m/%Y %H:%i") as created_date',false);
        $this->db->select('(CASE WHEN tab_1.work_status = "1" THEN "Completed" WHEN tab_1.work_status = "2" THEN "Pending" ELSE "In-Progress" END) AS work_status',false);
        $this->db->select('GROUP_CONCAT(tab_1.emp_image_upload) as emp_image',false);
        $this->db->join($this->erp_user.' AS tab_2','tab_1.emp_id = tab_2.id','left');
        $this->db->where('tab_1.service_id',$service_id);
        $this->db->where('tab_1.created_date !=','0000-00-00 00:00:00');
        $this->db->where('tab_1.work_performed !=','');
        $this->db->group_by('tab_1.created_date');
        $this->db->order_by('tab_1.created_date','desc');
        $service_history = $this->db->get($this->service_detail_table.' AS tab_1')->result_array();
        $history = array_merge($current_status,$service_history);
        return $history;
    }

}
