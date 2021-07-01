<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expense_category extends MX_Controller {

    function __construct() {
        parent::__construct();

        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url'));
        }
        $main_module = 'masters';
        $access_arr = array(
            'expense_category/index' => array('add', 'edit', 'delete', 'view'),
            'expense_category/add' => array('add'),
            'expense_category/edit' => array('edit'),
            'expense_category/delete' => array('delete'),
            'expense_category/is_expense_category_available' => array('add', 'edit'),
            'expense_category/edit_is_expense_category_available' => array('add', 'edit'),
            'expense_category/ajaxList' => 'no_restriction'
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }

        $this->load->model('masters/expense_category_model');
    }

    function index() {

        $data = array();
        $data['expense_category'] = $this->expense_category_model->get_all_expense();

        $this->template->write_view('content', 'masters/expense_category', $data);
        $this->template->render();
    }

    function add() {
        $data = array();
        if ($this->input->post('exp', TRUE)) {
            $expense = $this->input->post('exp');
            $expense['created_date'] = date('Y-m-d H:i:s');
            $insert = $this->expense_category_model->insert_expense($expense);
            if (!empty($insert) && $insert != 0) {
                $this->session->set_flashdata('flashSuccess', 'New Expense successfully added!');
                redirect($this->config->item('base_url') . 'masters/expense_category');
            }
        }
    }

    function edit($id) {
        $data = array();
        if ($this->input->post('exp', TRUE)) {
            $expense = $this->input->post('exp');


            $update = $this->expense_category_model->update_expense($expense, $id);
            if (!empty($update) && $update != 0) {
                $this->session->set_flashdata('flashSuccess', 'Expense successfully updated!');
                redirect($this->config->item('base_url') . 'masters/expense_category');
            }
        }
        $data['expense'] = $this->expense_category_model->get_expense_by_id($id);
        $this->template->write_view('content', 'masters/update_expense', $data);
        $this->template->render();
    }

    function delete($id) {
        $data = array('is_deleted' => 1);
        $id = $this->input->post('id');
        $delete = $this->expense_category_model->delete_expense($id, $data);
        if ($delete == 1) {
            redirect($this->config->item('base_url') . 'masters/expense_category');
            echo '1';
            exit;
        } else {
            $this->session->set_flashdata('flashError', 'Operation Failed!');
            echo '0';
            exit;
        }
    }

    function is_expense_category_available() {
        $exp_category = $this->input->post('exp_category');
        $data = $this->expense_category_model->is_expense_category_available($exp_category);
        if (!empty($data[0]['id'])) {
            echo 'yes';
            exit;
        } else {
            echo 'no';
            exit;
        }
    }

    function edit_is_expense_category_available() {
        $exp_category = $this->input->post('exp_category');
        $id = $this->input->post('id');
        $data = $this->expense_category_model->edit_is_expense_category_available($exp_category, $id);
        if (!empty($data[0]['id'])) {
            echo 'yes';
            exit;
        } else {
            echo 'no';
            exit;
        }
    }

    function ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $list = $this->expense_category_model->get_datatables($search_data);
        //print_r($list); exit;

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $cust_data) {
            if($cust_data->category_name != 'purchase return' && $cust_data->category_name != 'purchase receipt'){
            if ($this->user_auth->is_action_allowed('masters', 'expense_category', 'edit')) {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light" href="' . base_url() . 'masters/expense_category/edit/' . $cust_data->id . '" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-pencil"></span></a>';
            } else {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-pencil"></span></a>';
            }
            if ($this->user_auth->is_action_allowed('masters', 'expense_category', 'delete')) {
                $delete_row = '<a onclick="delete_expense(' . $cust_data->id . ')" class="btn btn-danger btn-mini waves-effect waves-light delete_row delete_yes" delete_id="test3_' . $cust_data->id . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><span class="fa fa-trash" style="color: white;"></span></a>';
            } 
            } else {
                $delete_row = '<span class="btn btn-secondary btn-mini waves-effect waves-light test"><span class="fa fa-ban"></span></span>';
            }
            $no++;
            $row = array();
            $row[] = $no;

            $row[] = ucfirst($cust_data->category_name);
            if($cust_data->category_name != 'purchase_return' && $cust_data->category_name != 'purchase_receipt'){
            $row[] = $edit_row . '&nbsp;&nbsp;' . $delete_row;
        } else {
            $row[]= $delete_row;
        }
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->expense_category_model->count_all(),
            "recordsFiltered" => $this->expense_category_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

}
