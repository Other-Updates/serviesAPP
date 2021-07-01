<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expense extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->clear_cache();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url'));
        }
        $main_module = 'expense';
        $access_arr = array(
            'expense/index' => array('add', 'edit', 'delete', 'view'),
            'expense/add' => array('add'),
            'expense/edit' => array('edit'),
            'expense/delete' => array('delete'),
            'expense/is_expense_category_available' => array('add', 'edit'),
            'expense/edit_is_expense_category_available' => array('add', 'edit'),
            'expense/get_company_amount' => 'no_restriction',
            'expense/expenses_ajaxList' => 'no_restriction',
            'expense/company_amount' => array('add', 'edit', 'delete', 'view'),
            'expense/update_company_amount' => array('add', 'edit', 'delete', 'view'),
            'expense/get_expense_categories' => 'no_restriction',
            'expense/update_petty_cash_amount' => 'no_restriction',
            'expense/petty_cash_ajaxList' => 'no_restriction',
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }

        $this->load->model('expense/expense_model');
    }

    function index() {

        $data = array();
        $data['expense'] = $this->expense_model->get_all_expense();
        $data['category'] = $this->expense_model->get_all_expense_category();
        $this->template->write_view('content', 'expense/expense', $data);
        $this->template->render();
    }

    function add() {
        $data = array();
        if ($this->input->post()) {
            $input = $this->input->post('exp');
            $company_amt = $input['company_amount'];
            $expense_amt = $input['exp_amount'];
            $mode = $input['exp_mode'];
            if ($mode == 'credit') {
                $balance = ($company_amt + $expense_amt);
            } elseif ($mode == 'debit') {
                $balance = ($company_amt - $expense_amt);
            }
            $input['balance'] = $balance;
            $input['created_at'] = date('Y-m-d H:i:s');
            $input['exp_date'] = date('Y-m-d', strtotime($input['exp_date']));
            $insert = $this->expense_model->insert_expense($input);
            $user_info = $this->user_auth->get_from_session('user_info');
            $balance_data = [
                "user_id" => $user_info[0]['id'],
                "cat_id" => $input['exp_cat_type'],
//                "type" => $input['exp_type'],
                "mode" => $input['exp_mode'],
                "amount" => $input['exp_amount'],
                "company_amount" => $input['company_amount'],
                "balance" => $balance,
                "created_at" => $input['created_at'],
                "exp_id" => $insert,
                "q_id" => '',
                "remarks" => $input['remarks'],
            ];
            $this->expense_model->insert_balance_sheet($balance_data);
            $this->expense_model->update_company_amt($balance);
            if (!empty($insert) && $insert != 0) {
                $this->session->set_flashdata('flashSuccess', 'New Expense successfully added!');
                redirect($this->config->item('base_url') . 'expense/expense');
            }
        }
    }

    function edit($id) {
        $data = array();
        $company_amt = $this->input->post('company_amount_details');
//        $expense_type = $this->input->post('exp_type');

        if ($this->input->post('exp', TRUE)) {
            $input = $this->input->post('exp');

            $expense_amt = $input['exp_amount'];
            $bal_amt = $input['balance'];
            $mode = $input['exp_mode'];
            if ($mode == 'credit') {
                if ($input['exp_amount'] != '') {
                    if ($input['old_amount'] != $input['exp_amount']) {
                        if ($input['old_amount'] > $input['exp_amount']) {
                            $dfff = $input['old_amount'] - $input['exp_amount'];
                            $totbalance = (- $dfff);
                        } else if ($input['old_amount'] < $input['exp_amount']) {
                            $dfff1 = $input['exp_amount'] - $input['old_amount'];
                            $totbalance = $dfff1;
                        }
                    }
                }
                $balance = ($bal_amt + $totbalance);
                $update_company_amt = $company_amt + $totbalance;
            } elseif ($mode == 'debit') {
                if ($input['exp_amount'] != '') {
                    if ($input['old_amount'] != $input['exp_amount']) {
                        if ($input['old_amount'] > $input['exp_amount']) {
                            $dfff = $input['old_amount'] - $input['exp_amount'];
                            $totbalance = (-$dfff);
                        } else if ($input['old_amount'] < $input['exp_amount']) {
                            $dfff1 = $input['exp_amount'] - $input['old_amount'];
                            $totbalance = $dfff1;
                        }
                    }
                }
                $balance = ($bal_amt - $totbalance);
                $update_company_amt = $company_amt - $totbalance;
            }
            $input['balance'] = $balance;
            $input['updated_at'] = date('Y-m-d H:i:s');
            $input['exp_date'] = date('Y-m-d', strtotime($input['exp_date']));
            unset($input['old_amount']);
            $update = $this->expense_model->update_expense($input, $id);
            $user_info = $this->user_auth->get_from_session('user_info');
            $balance_data = [
                "user_id" => $user_info[0]['id'],
                "cat_id" => $input['exp_cat_type'],
//                "type" => $input['exp_type'],
                "mode" => $input['exp_mode'],
                "amount" => $input['exp_amount'],
                "company_amount" => $input['company_amount'],
                "balance" => $balance,
                "created_at" => $input['created_at'],
                "remarks" => $input['remarks'],
            ];


            $update = $this->expense_model->update_balance_sheet($balance_data, $id);
            $this->expense_model->update_company_amt($update_company_amt);
            if (!empty($update) && $update != 0) {
                $this->session->set_flashdata('flashSuccess', 'Expense successfully updated!');
                redirect($this->config->item('base_url') . 'expense/expense');
            }
        }
        $data['expense'] = $this->expense_model->get_expense_by_id($id);
        $data['category'] = $this->expense_model->get_expense_category_basedon_expense_type();
        $data['company_amount'] = $this->expense_model->getCompanyAmt();
        $this->template->write_view('content', 'expense/update_expense', $data);
        $this->template->render();
    }

    function delete($id) {
        $data = array('is_deleted' => 1);
        $id = $this->input->post('id');
        $delete = $this->expense_model->delete_expense($id, $data);
        if ($delete == 1) {
            redirect($this->config->item('base_url') . 'expense/expense');
            echo '1';
        } else {
            $this->session->set_flashdata('flashError', 'Operation Failed!');
            echo '0';
        }
    }

    function is_expense_category_available() {
        $exp_category = $this->input->post('exp_category');
        $data = $this->expense_model->is_expense_category_available($exp_category);
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
        $data = $this->expense_model->edit_is_expense_category_available($exp_category, $id);
        if (!empty($data[0]['id'])) {
            echo 'yes';
            exit;
        } else {
            echo 'no';
            exit;
        }
    }

    public function get_company_amount() {
        $data = $this->expense_model->getCompanyAmt();
        echo json_encode($data);
        exit;
    }

    function expenses_ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $list = $this->expense_model->get_datatables($search_data);


        $data = array();
        $no = $_POST['start'];
        foreach ($list as $ass) {
            if ($this->user_auth->is_action_allowed('expense', 'expense', 'edit')) {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light" href="' . base_url() . 'expense/edit/' . $ass->id . '" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-pencil"></span></a>';
            } else {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-pencil"></span></a>';
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = ($ass->exp_date != '' && $ass->exp_date != '0000-00-00 00:00:00') ? date('d-M-Y', strtotime($ass->exp_date)) : '-';
            $row[] = ucfirst($ass->remarks);
            $row[] = ucfirst($ass->category_name);
            $exp_amount = number_format($ass->exp_amount ? $ass->exp_amount : '0.00', 2);
            $row[] = $exp_amount;
            if ($ass->exp_mode == 'credit') {
                $mode = 'Income';
            } else if ($ass->exp_mode == 'debit') {
                $mode = 'Expense';
            }
            $row[] = $mode;

            $row[] = $edit_row;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->expense_model->count_all(),
            "recordsFiltered" => $this->expense_model->count_filtered($search_data),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    function clear_cache() {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

    function company_amount() {
        $data = array();
        $data['petty_cash'] = $this->expense_model->get_petty_cash_datas();
        $this->template->write_view('content', 'expense/company_amount');
        $this->template->render();
    }

    function update_company_amount() {
        $company_amount = $this->input->post('company_amount');
        $this->expense_model->update_company_amt($company_amount);

        $data['company_amount'] = $this->expense_model->get_company_amount();
        $input_comp['receiver_type'] = "Opening Company Amount";
        $input_comp['type'] = "credit";
        $input_comp['recevier'] = "company";
        $input_comp['bill_amount'] = $data['company_amount'][0]['company_amount'];
        $this->load->model('receipt/receipt_model');
        $insert_agent_cash = $this->receipt_model->insert_agent_amount($input_comp);
        redirect($this->config->item('base_url') . 'expense/company_amount', $data);
    }

    public function update_petty_cash_amount() {
        $data = array();
        if ($this->input->post()) {
            $input = $this->input->post();
            if ($input['company_type'] == 'add') {
                $mode = 'credit';
            } else {
                $mode = 'debit';
            }
            $balance = $input['company_amount'];
            //Insert Petty cash Amount
//            $input_comp['receiver_type'] = "Opening Company Amount";
//            $input_comp['type'] = $mode;
//            $input_comp['recevier'] = "company";
//            $input_comp['bill_amount'] = $input['company_amount'];
//            $this->load->model('receipt/receipt_model');
//            $insert_agent_cash = $this->receipt_model->insert_agent_amount($input_comp);

            $user_info = $this->user_auth->get_from_session('user_info');
            $insert_data = [
                "user_id" => $user_info[0]['id'],
                "mode" => $mode,
                "amount" => $input['amount'],
                "created_at" => date("Y-m-d H:i:s"),
                "remarks" => $input['remarks'],
            ];
            $insert = $this->expense_model->insert_petty_cash($insert_data);

            if (!empty($insert) && $insert != 0) {
                $this->session->set_flashdata('flashSuccess', 'Petty Cash Amount successfully added!');
                redirect($this->config->item('base_url') . 'expense/company_amount');
            }
        }
    }

    function get_expense_categories() {
        //$exp_type = $this->input->post('exp_type');


        $data = $this->expense_model->get_expense_category_basedon_expense_type();
        if (!empty($data)) {
            echo json_encode($data);
        }
    }

    function petty_cash_ajaxList() {
        $list = $this->expense_model->get_pett_cash_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $val) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = ($val['created_at'] != '') ? date('d-M-Y', strtotime($val['created_at'])) : '-';
            if ($val['mode'] == 'credit') {
                $mode = 'Income';
            } else if ($val['mode'] == 'debit') {
                $mode = 'Expense';
            }
            $row[] = $mode;
            if ($val['mode'] == 'credit') {
                $row[] = $val['amount'];
            } else if ($val['mode'] == 'debit') {
                $row[] = '-' . $val['amount'];
            }

            $row[] = ucfirst($val['remarks']);

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->expense_model->count_all_petty_cash(),
            "recordsFiltered" => $this->expense_model->count_filtered_petty_cash(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

}
