<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class To_do_list extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'to_do_list';
        $access_arr = array(
            'to_do_list/index' => array('add', 'edit', 'delete', 'view'),
            'to_do_list/update_employee_assigned' => 'no_restriction',
            'to_do_list/service_ajaxList' => 'no_restriction',
            'to_do_list/leads_ajaxList' => 'no_restriction',
            'to_do_list/project_ajaxList' => 'no_restriction',
        );
        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('to_do_list/to_do_model');
    }

    public function index() {
        $data['users'] = $this->to_do_model->get_all_users();
        $data['service'] = $this->to_do_model->get_all_services();


        $this->template->write_view('content', 'index', $data);
        $this->template->render();
    }

    public function update_employee_assigned() {

        $employee_id = $this->input->post('employee_id');
        $service_id = $this->input->post('service_id');
        if (!empty($service_id)) {
            foreach ($service_id as $key => $value) {
                $data['emp_id'] = $employee_id;
                $update_service = $this->to_do_model->update_service_assigned($data, $value);
            }
        }
        if ($update_service) {
            echo 1;
        } else {
            echo 0;
            exit;
        }
    }

    function service_ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $list = $this->to_do_model->get_service_datatables($search_data);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $val) {

            $no++;

            $row = array();
            $row[] = $no;
            // $row[] = $val['inv_no'];
            $row[] = $val['ticket_no'];
            $row[] = ucfirst($val['description']);
            // $row[] = $val['warrenty'];
            $row[] = ($val['created_date'] != '') ? date('d-M-Y', strtotime($val['created_date'])) : '-';
            if ($val['status'] == 2) {
                $status = '<span class="label label-danger">Pending</span>';
            } else {
                $status = '<span class="label label-success">Completed</span>';
            }
            $row[] = $status;
            $row[] = '<input type="checkbox" class="assign_service" />';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->to_do_model->count_all_service(),
            "recordsFiltered" => $this->to_do_model->count_filtered_service(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    function leads_ajaxList() {
        $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
        $this->load->model('enquiry/enquiry_model');
        $this->load->model('customer/customer_model');
        $staff_name = $this->customer_model->get_all_staff_name();
        $search_data = array();
        $search_data = $this->input->post();
        $list = $this->to_do_model->get_leads_datatables($search_data);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $leads_data) {
            $no++;

            $row = array();
            $row[] = $no;
            $row[] = $leads_data['enquiry_no'];
            $row[] = $leads_data['name'];
            $row[] = $leads_data['address1'];
            $row[] = ($leads_data['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($leads_data['created_date'])) : '';
            $row[] = ($leads_data['followup_date'] != '1970-01-01') ? date('d-M-Y', strtotime($leads_data['followup_date'])) : '';
            $selected_array = explode(',', $leads_data['assigned_to']);
            $mark_as_select = '';

            if (isset($selected_array) && !empty($selected_array)) {
                foreach ($selected_array as $key => $list) {
                    $mark_as_select[] = $this->enquiry_model->get_assigned_user($list);
                }
            }
            $row[] = ($mark_as_select != '') ? implode(',', $mark_as_select) : '';
            $row[] = '<p class="hide_overflow">' . $leads_data['enquiry_about'] . '</p>';
            if ($leads_data['status'] == 'leads') {
                $status = 'Pending Leads';
            } else if ($leads_data['status'] == 'leads_follow_up') {
                $status = 'Leads follow up';
            } else if ($leads_data['status'] == 'leads_rejected') {
                $status = 'Leads Rejected';
            } else if ($leads_data['status'] == 'quotation') {
                $status = 'Quotation';
            } else if ($leads_data['status'] == 'quotation_follow_up') {
                $status = 'Quotation follow up';
            } else if ($leads_data['status'] == 'quotation_rejected') {
                $status = 'Quotation Rejected';
            } else if ($leads_data['status'] == 'order_conform') {
                $status = 'Order Completed';
            }
            $quotation_id = '';
            if ($leads_data['status'] == "quotation" || $leads_data['status'] == "quotation_follow_up" || $leads_data['status'] == "quotation_rejected") {
                $q_ref_no = $leads_data['quotation_ref_no'];
                $quotation_id = $this->enquiry_model->get_quotation_link($q_ref_no);
            }
            if ($quotation_id != '') {
                $link = '<a href="' . $this->config->item('base_url') . 'quotation/quotation_view/' . $quotation_id . '" >' . $leads_data['quotation_ref_no'] . '</a>';
            } else {
                $link = '';
            }
            if ($link != '') {
                $row[] = $status . '<br/>' . $link;
            } else {
                $row[] = $status;
            }

            $row[] = '<p class="hide_overflow">' . $leads_data['remarks'] . '</p>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->to_do_model->count_all_leads(),
            "recordsFiltered" => $this->to_do_model->count_filtered_leads(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    function project_ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $list = $this->to_do_model->get_project_datatables($search_data);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $val) {
            $no++;

            $row = array();
            $row[] = $no;
            $row[] = $val['job_id'];
            $row[] = $val['total_qty'];
            $row[] = number_format($val['net_total'], 2, '.', ',');
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->to_do_model->count_all_project(),
            "recordsFiltered" => $this->to_do_model->count_filtered_project(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

}
