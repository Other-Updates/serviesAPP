<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Attendance extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->clear_cache();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url'));
        }
        $main_module = 'attendance';
        $access_arr = array(
            'attendance/index' => array('add', 'edit', 'delete', 'view'),
            'attendance/add' => array('add'),
            'attendance/edit' => array('edit'),
            'attendance/delete' => array('delete'),
            'attendance/is_attendance_category_available' => array('add', 'edit'),
            'attendance/edit_is_attendance_category_available' => array('add', 'edit'),
            'attendance/get_company_amount' => 'no_restriction',
            'attendance/attendance_ajaxList' => 'no_restriction'
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }

        $this->load->model('attendance/attendance_model');
    }

    function index() {

        $data = array();
//        $data['attendance'] = $this->attendance_model->get_all_attendance();
//        $data['category'] = $this->attendance_model->get_all_attendance_category();
        $this->template->write_view('content', 'attendance/attendance', $data);
        $this->template->render();
    }

    function attendance_ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $list = $this->attendance_model->get_datatables($search_data);




        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ass) {
            if ($this->user_auth->is_action_allowed('attendance', 'attendance', 'edit')) {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light" href="' . base_url() . 'attendance/edit/' . $ass->id . '" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-pencil"></span></a>';
            } else {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-pencil"></span></a>';
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $ass->emp_code;
            $row[] = ucfirst($ass->name);
            $today = date('Y-m-d 00:00:00');
            if ($ass->login_date != '' && $ass->login_date == $today) {
                $status = '<span class="label label-success">Present</span>';
            } else {
                $status = '<span class="label label-danger">Absent</span>';
            }
            $row[] = $status;
//            $row[] = ucfirst($ass->exp_mode);
//            $row[] = number_format($ass->exp_amount ? $ass->exp_amount : '0.00', 2);
//            $row[] = ($ass->created_at != '' && $ass->created_at != '0000-00-00 00:00:00') ? date('d-M-Y', strtotime($ass->created_at)) : '-';
//            $row[] = $edit_row;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->attendance_model->count_all(),
            "recordsFiltered" => $this->attendance_model->count_filtered($search_data),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    function clear_cache() {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

}
