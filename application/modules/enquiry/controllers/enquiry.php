<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Enquiry extends MX_Controller {

    function __construct() {
        parent::__construct();

        $this->load->library('session');
        $this->load->library('email');
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        
        $main_module = 'enquiry';
        $access_arr = array(
            'enquiry/index' => array('add', 'edit', 'delete', 'view'),
            'enquiry/add_enquiry' => array('add'),
            'enquiry/add_duplicate_email' => array('add', 'edit'),
            'enquiry/enquiry_edit' => array('edit'),
            'enquiry/update_enquiry' => array('edit'),
            'enquiry/enquiry_delete' => array('delete'),
            'enquiry/add_duplicate_category' => array('add', 'edit'),
            'enquiry/update_duplicate_category' => array('add', 'edit'),
            'enquiry/enquiry_list' => 'no_restriction',
            'enquiry/enquiry_view' => 'no_restriction',
            'enquiry/ajaxList' => 'no_restriction',
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
    }

    public function index() {
        $this->load->model('enquiry/enquiry_model');
        $this->load->model('enquiry/enquiry_model');
        $this->load->model('master_style/master_model');
        $this->load->model('masters/ref_increment_model');
//        $this->load->model('po/gen_model');
        $this->load->model('quotation/Gen_model');
        $this->load->model('customer/customer_model');
        $data["last_id"] = $this->ref_increment_model->get_increment_id('ERQ', 'ERQ');
        $data["staff_name"] = $this->customer_model->get_all_staff_name();
        $data["customers"] = $this->Gen_model->get_all_customers();
        $data["category"] = $this->enquiry_model->get_all_categories();

        $this->template->write_view('content', 'enquiry/index', $data);
        $this->template->render();
    }

    public function add_enquiry() {
        $this->load->model('masters/ref_increment_model');
        $this->load->model('enquiry/enquiry_model');
        $this->load->model('master_style/master_model');
        $data["last_id"] = $this->ref_increment_model->get_increment_id('ERQ', 'ERQ');
        $input = $this->input->post();

        $user_info = $this->user_auth->get_from_session('user_info');
        $input['created_by'] = $user_info[0]['id'];
        $user_info[0]['id'];
        $input['enquiry_no'] = $data["last_id"];
        $input['followup_date'] = date('Y-m-d', strtotime($input['followup_date']));
        if ($input['assigned_to'] != '') {
            $input['assigned_to'] = implode(',', $this->input->post('assigned_to'));
        }
        $insert_id = $this->enquiry_model->insert_enquiry($input);
        $customer_id = $input['customer_id'];
        if (!empty($insert_id)) {
            $customer = array(
                'mobil_number' => $input['contact_number'],
                'mobile_number_2' => $input['contact_number_2'],
                'email_id' => $input['customer_email'],
                'address1' => $input['customer_address'],
            );
            $this->enquiry_model->update_customer($customer, $customer_id);
        }
        $insert_id++;
        $this->ref_increment_model->update_increment_id('ERQ', 'ERQ');
        redirect($this->config->item('base_url') . 'enquiry/enquiry_list');
    }

    public function enquiry_list() {
        $this->load->model('enquiry/enquiry_model');
        $data['all_enquiry'] = $this->enquiry_model->get_all_enquiry();
        $this->template->write_view('content', 'enquiry_list', $data);
        $this->template->render();
    }

    public function enquiry_edit($id) {
        $this->load->model('enquiry/enquiry_model');
        $this->load->model('customer/customer_model');
        $this->load->model('quotation/Gen_model');
        $data["staff_name"] = $this->customer_model->get_all_staff_name();
        $data['all_enquiry'] = $this->enquiry_model->get_all_cust_enquiry_by_id($id);
        $data["customers"] = $this->Gen_model->get_all_customers();
        $data["category"] = $this->enquiry_model->get_all_categories();

        $this->template->write_view('content', 'enquiry_edit', $data);
        $this->template->render();
    }

    public function add_duplicate_email() {
        $this->load->model('enquiry/enquiry_model');
        $input = $this->input->get('value1');
        $validation = $this->enquiry_model->add_duplicate_email($input);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Email Already Exist";
        }
    }

    public function update_enquiry($id) {
        $this->load->model('enquiry/enquiry_model');
        $this->load->model('master_style/master_model');
        $input = $this->input->post();
        $input['followup_date'] = date('Y-m-d', strtotime($input['followup_date']));
        $user_info = $this->user_auth->get_from_session('user_info');
        $input['created_by'] = $user_info[0]['id'];
        if ($input['assigned_to'] != '') {
            $input['assigned_to'] = implode(',', $this->input->post('assigned_to'));
        }
        $insert_id = $this->enquiry_model->update_enquiry($input, $id);
        $customer_id = $input['customer_id'];
        if (!empty($insert_id)) {
            $customer = array(
                'mobil_number' => $input['contact_number'],
                'mobile_number_2' => $input['contact_number_2'],
                'email_id' => $input['customer_email'],
                'address1' => $input['customer_address'],
            );
            $this->enquiry_model->update_customer($customer, $customer_id);
        }
        redirect($this->config->item('base_url') . 'enquiry/enquiry_list');
    }

    public function enquiry_delete() {
        $this->load->model('enquiry/enquiry_model');
        $id = $this->input->POST('value1');
        $data['all_enquiry'] = $this->enquiry_model->get_all_enquiry();
        $del_id = $this->enquiry_model->delete_enquiry($id);
        redirect($this->config->item('base_url') . 'enquiry/enquiry_list', $data);
    }

    public function enquiry_view($id) {
        $this->load->model('enquiry/enquiry_model');
        $data['all_enquiry'] = $this->enquiry_model->get_all_cust_enquiry_by_id($id);
        //echo "<pre>"; print_r($data); exit;
        $this->template->write_view('content', 'enquiry_view', $data);
        $this->template->render();
    }

    function ajaxList() {
        $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
        $this->load->model('enquiry/enquiry_model');
        $this->load->model('customer/customer_model');
        $staff_name = $this->customer_model->get_all_staff_name();
        $list = $this->enquiry_model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $leads_data) {
            if ($this->user_auth->is_action_allowed('enquiry', 'enquiry', 'edit')) {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light" href="' . base_url() . 'enquiry/enquiry_edit/' . $leads_data->id . '" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-pencil"></span></a>';
            } else {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-pencil"></span></a>';
            }

            if ($this->user_auth->is_action_allowed('enquiry', 'enquiry', 'view')) {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light" href="' . base_url() . 'enquiry/enquiry_view/' . $leads_data->id . '" data-toggle="tooltip" data-placement="top" title="View"><span class="fa fa-eye"></span></a>';
            } else {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-eye"></span></a>';
            }

            if ($this->user_auth->is_action_allowed('enquiry', 'enquiry', 'delete')) {
                $delete_row = '<a onclick="delete_leads(' . $leads_data->id . ')" class="btn btn-danger btn-mini waves-effect waves-light delete_row" delete_id="test3_' . $leads_data->id . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><span class="fa fa-trash" style="color: white;"></span></a>';
            } else {
                $delete_row = '<a  class="btn btn-danger btn-mini waves-effect waves-light delete_row alerts" delete_id="test3_' . $leads_data->id . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><span class="fa fa-trash" style="color: white;"></span></a>';
            }
            $no++;

            $row = array();
            $row[] = $no;
            $row[] = $leads_data->enquiry_no;
            $row[] = $leads_data->name;
            $row[] = $leads_data->address1;
            $row[] = ($leads_data->created_date != '1970-01-01') ? date('d-M-Y', strtotime($leads_data->created_date)) : '';
            $row[] = ($leads_data->followup_date != '1970-01-01') ? date('d-M-Y', strtotime($leads_data->followup_date)) : '';
            $selected_array = explode(',', $leads_data->assigned_to);
            $mark_as_select = '';

            if (isset($selected_array) && !empty($selected_array)) {
                foreach ($selected_array as $key => $list) {
                    $mark_as_select[] = $this->enquiry_model->get_assigned_user($list);
                }
            }
            $row[] = ($mark_as_select != '') ? implode(',', $mark_as_select) : '';
            $row[] = '<p class="hide_overflow">' . $leads_data->enquiry_about . '</p>';
            if ($leads_data->status == 'leads') {
                $status = 'Pending Leads';
            } else if ($leads_data->status == 'leads_follow_up') {
                $status = 'Leads follow up';
            } else if ($leads_data->status == 'leads_rejected') {
                $status = 'Leads Rejected';
            } else if ($leads_data->status == 'quotation') {
                $status = 'Quotation';
            } else if ($leads_data->status == 'quotation_follow_up') {
                $status = 'Quotation follow up';
            } else if ($leads_data->status == 'quotation_rejected') {
                $status = 'Quotation Rejected';
            } else if ($leads_data->status == 'order_conform') {
                $status = 'Order Completed';
            }
            $quotation_id = '';
            if ($leads_data->status == "quotation" || $leads_data->status == "quotation_follow_up" || $leads_data->status == "quotation_rejected") {
                $q_ref_no = $leads_data->quotation_ref_no;
                $quotation_id = $this->enquiry_model->get_quotation_link($q_ref_no);
            }
            if ($quotation_id != '') {
                $link = '<a href="' . $this->config->item('base_url') . 'quotation/quotation_view/' . $quotation_id . '" >' . $leads_data->quotation_ref_no . '</a>';
            } else {
                $link = '';
            }
            if ($link != '') {
                $row[] = $status . '<br/>' . $link;
            } else {
                $row[] = $status;
            }
            $row[] = '<p class="hide_overflow">' . $leads_data->remarks . '</p>';
            if (($user_info[0]['role'] != 5)) {
                $row[] = $edit_row . '&nbsp;&nbsp;' . $view_row . '&nbsp;&nbsp;' . $delete_row;
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->enquiry_model->count_all(),
            "recordsFiltered" => $this->enquiry_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
