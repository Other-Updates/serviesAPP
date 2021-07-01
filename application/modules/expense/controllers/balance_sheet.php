<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Balance_sheet extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->clear_cache();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url'));
        }
        $main_module = 'report';
        $access_arr = array(
            'balance_sheet/index' => array('add', 'edit', 'delete', 'view'),
            'balance_sheet/balancesheet_ajaxList' => 'no_restriction',
            'balance_sheet/getall_balance_entries' => 'no_restriction',
            'balance_sheet/get_company_amount' => 'no_restriction'
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }

        $this->load->model('expense/balance_sheet_model');
        $this->load->model('expense/expense_model');
    }

    function index() {
        $data = array();
//        $data['balance_list'] = $this->balance_sheet_model->get_all_balance();
        $data['category'] = $this->expense_model->get_all_expense_category();
        $this->template->write_view('content', 'expense/balance_list', $data);
        $this->template->render();
    }

    function balancesheet_ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();


        $list = $this->balance_sheet_model->get_balance_datatables($search_data);

        $get_company_bal = $this->balance_sheet_model->getCompanyAmt();
        $com_bal = '';
        if (!empty($get_company_bal))
            $com_bal[] = [1, "Opening Balance", "-", "0.00", $get_company_bal[0]['opening_balance'], $get_company_bal[0]['opening_balance'], "Opening Company Amount"];

        $data = array();
        $no = $_POST['start'];
        if ($com_bal) {
            $no = $_POST['start'] + 1;
        }
        foreach ($list as $ass) {
            $no++;
            $row = array();
            $row[] = $no;
//            $row[] = $ass->company_amount;
//            $row[] = ucfirst($ass->type);
            $row[] = ucfirst($ass->category_name);
//            $row[] = $ass->opening_balance;
            $row[] = ($ass->created_at != '' && $ass->created_at != '0000-00-00 00:00:00') ? date('d-M-Y', strtotime($ass->created_at)) : '-';
            if ($ass->mode == 'debit' && ($ass->amount > 0)) {
                $debit_amount = ($ass->amount);
            } elseif ($ass->mode == 'credit' && ($ass->amount < 0)) {
                $debit_amount = (abs($ass->amount));
            } else {
                $debit_amount = '0.00';
            }
            $row[] = number_format($debit_amount, 2);
            if ($ass->mode == 'credit' && ($ass->amount > 0)) {
                $credit_amount = ($ass->amount);
            } elseif ($ass->mode == 'debit' && ($ass->amount < 0)) {
                $credit_amount = (abs($ass->amount));
            } else {
                $credit_amount = '0.00';
            }
            $row[] = number_format($credit_amount, 2);
            $row[] = number_format($ass->balance ? $ass->balance : '0.00', 2);
            $row[] = $ass->remarks;
            $data[] = $row;
        }

        if ($com_bal) {
            $data = array_merge($com_bal, $data);
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->balance_sheet_model->count_all_balance(),
            "recordsFiltered" => $this->balance_sheet_model->count_filtered_balance($search_data),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    function getall_balance_entries() {
        $search_data = array();
        $search_data = $this->input->get();
        $balance_data = $this->balance_sheet_model->get_balance_datas($search_data);
        $this->export_all_balance_data_csv($balance_data);
    }

    function export_all_balance_data_csv($query, $timezones = array()) {

        // output headers so that the file is downloaded rather than displayed
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=Balance List.csv');
        // create a file pointer connected to the output stream
        $output = fopen('php://output', 'w');

        // output the column headings
        //Order has been changes
        fputcsv($output, array('S.No', 'Type', 'Created Date', 'Debit Amt', 'Credit Amt', 'Balance'));

        // fetch the data
        //$rows = mysql_query($query);
        // loop over the rows, outputting them

        foreach ($query as $key => $value) {

            $type = 'Sales';



            if ($value['mode'] == 'debit' && ($value['amount'] > 0)) {
                $debit_amount = ($value['amount']);
            } elseif ($value['mode'] == 'credit' && ($value['amount'] < 0)) {
                $debit_amount = (abs($value['amount']));
            } else {
                $debit_amount = '0.00';
            }
            if ($value['mode'] == 'credit' && ($value['amount'] > 0)) {
                $credit_amount = ($value['amount']);
            } elseif ($value['mode'] == 'debit' && ($value['amount'] < 0)) {
                $credit_amount = (abs($value['amount']));
            } else {
                $credit_amount = '0.00';
            }
            if ($key == 0) {
                $get_company_bal = $this->balance_sheet_model->getCompanyAmt();
                $com_bal = '';
                if (!empty($get_company_bal)) {
                    $row = array(1, "Opening Balance", "-", "-", $get_company_bal[0]['opening_balance'], $get_company_bal[0]['opening_balance']);

                    fputcsv($output, $row);
                    $key = 1;
                }
            }
            $row = array($key + 1, $value['type'], ($value['created_at'] != '1970-01-01') ? date('d-M-Y', strtotime($value['created_at'])) : '', number_format($debit_amount, 2), number_format($credit_amount, 2), number_format($value['balance'] ? $value['balance'] : '0.00', 2));
            fputcsv($output, $row);
        }
        exit;
    }

    public function get_company_amount() {
        $data = $this->expense_model->getCompanyAmt();
        echo json_encode($data);
        exit;
    }

    function clear_cache() {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

}
