<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Receipt extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'receipt';
        $access_arr = array(
            'receipt/index' => array('add', 'edit', 'delete', 'view'),
            'receipt/receipt_list' => array('add', 'edit', 'delete', 'view'),
            'receipt/manage_receipt' => 'no_restriction',
            'receipt/ajaxList' => 'no_restriction',
            'receipt/view_receipt' => array('add', 'edit', 'delete', 'view'),
            'receipt/update_checking_payment_checkno' => 'no_restriction',
        );
        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('customer/agent_model');
        $this->load->model('api/notification_model');
        $this->load->model('admin/admin_model');
        $this->load->model('api/notification_model');
        $this->load->model('master_style/master_model');
        if (isset($_GET['notification']))
            $this->notification_model->update_notification(array('status' => 1), $_GET['notification']);
    }

    public function index() {
        $this->load->model('receipt/receipt_model');
        $this->load->model('customer/customer_model');
        $this->load->model('customer/agent_model');
        $this->load->model('master_style/master_model');
        $data["last_id"] = $this->master_model->get_last_id('rp_code');
        $no[1] = substr($data["last_id"][0]['value'], 3);
        if (date('m') > 3) {
            $check_no = 'RP' . date('y') . (date('y') + 1) . '0001';
            $check_res = $this->receipt_model->check_so_no($check_no);
            if (empty($check_res)) {
                $data['last_no'] = 'RP' . date('y') . (date('y') + 1) . '0001';
            } else
                $data['last_no'] = 'RP' . date('y') . (date('y') + 1) . str_pad(substr($no[1], 4, 8) + 1, 4, '0', STR_PAD_LEFT);
        }else {
            $check_no = 'RP' . (date('y') - 1) . date('y') . '0001';
            $check_res = $this->receipt_model->check_so_no($check_no);
            if (empty($check_res)) {
                $data['last_no'] = 'RP' . (date('y') - 1) . date('y') . '0001';
            } else
                $data['last_no'] = 'RP' . (date('y') - 1) . date('y') . str_pad(substr($no[1], 4, 8) + 1, 4, '0', STR_PAD_LEFT);
        }
        if ($this->input->post()) {
            $input = $this->input->post();
            $this->receipt_model->update_invoice_status($input['inv_no']);
            if ($input['balance'] == 0)
                $input['receipt']['complete_status'] = 1;
            else
                $input['receipt']['complete_status'] = 0;
            $input['receipt']['due_date'] = date('Y-m-d', strtotime($input['receipt']['due_date']));


            $data["last_id"] = $this->master_model->get_last_id('rp_code');
            $no[1] = substr($data["last_id"][0]['value'], 3);
            if (date('m') > 3) {
                $check_no = 'RP' . date('y') . (date('y') + 1) . '0001';
                $check_res = $this->receipt_model->check_so_no($check_no);
                if (empty($check_res)) {
                    $data['last_no'] = 'RP' . date('y') . (date('y') + 1) . '0001';
                } else
                    $data['last_no'] = 'RP' . date('y') . (date('y') + 1) . str_pad(substr($no[1], 4, 8) + 1, 4, '0', STR_PAD_LEFT);
            }else {
                $check_no = 'RP' . (date('y') - 1) . date('y') . '0001';
                $check_res = $this->receipt_model->check_so_no($check_no);
                if (empty($check_res)) {
                    $data['last_no'] = 'RP' . (date('y') - 1) . date('y') . '0001';
                } else
                    $data['last_no'] = 'RP ' . (date('y') - 1) . date('y') . str_pad(substr($no[1], 4, 8) + 1, 4, '0', STR_PAD_LEFT);
            }
            $this->receipt_model->update_receipt_id($data['last_no']);
            $input['receipt']['receipt_no'] = $data['last_no'];
            if (isset($input['inv_no']) && !empty($input['inv_no'])) {
                $i = 0;
                $order_list = '';
                foreach ($input['inv_no'] as $key => $val) {

                    if ($i == 0) {
                        $order_list = $order_list . $val;
                        $i = 1;
                    } else
                        $order_list = $order_list . '-' . $val;
                }
            }
            $input['receipt']['inv_list'] = $order_list;


            $insert_id = $this->receipt_model->insert_receipt($input['receipt']);
            $input['receipt_bill']['receipt_id'] = $insert_id;

            $insert_id = $this->receipt_model->insert_receipt_bill($input['receipt_bill']);

            redirect($this->config->item('base_url') . 'receipt/receipt_list');
        }


        $data['all_customer'] = $this->customer_model->get_customer();
        $data['all_agent'] = $this->agent_model->get_agent();
        $this->template->write_view('content', 'receipt/index', $data);
        $this->template->render();
    }

    public function receipt_list() {
        $this->load->model('receipt/receipt_model');
        $data['all_receipt'] = $this->receipt_model->get_all_receipt();
        $this->template->write_view('content', 'receipt_list', $data);
        $this->template->render();
    }

    public function manage_receipt($r_id) {
        $this->load->model('masters/ref_increment_model');
        $this->load->model('receipt/receipt_model');
        $this->load->model('expense/expense_model');
        $this->load->model('customer/customer_model');
        if ($this->input->post()) {
            $input = $this->input->post();

            if ($input['balance'] == 0 || $input['balance'] == 0.00 || $input['balance'] == '0.00')
                $receipt_status = 'Completed';
            else
                $receipt_status = 'Pending';
            if (isset($input['receipt_bill']['due_date']) && !empty($input['receipt_bill']['due_date']))
                $input['receipt_bill']['due_date'] = date('Y-m-d', strtotime($input['receipt_bill']['due_date']));
            else
                $input['receipt_bill']['due_date'] = '';
            $input['receipt_bill']['created_date'] = date('Y-m-d', strtotime($input['receipt_bill']['created_date']));

            $balance = $input['balance'];
            $inv_details = $this->receipt_model->get_inv_details($input['receipt_bill']['receipt_id']);
            $paid_amount = round($input['receipt_bill']['discount'] + $input['receipt_bill']['bill_amount'], 2) + $inv_details[0]['paid_amount'];


            $this->receipt_model->update_invoice(array('payment_status' => $receipt_status, 'paid_amount' => $paid_amount, 'balance' => $balance), $input['receipt_bill']['receipt_id']);
            $insert_id = $this->receipt_model->insert_receipt_bill($input['receipt_bill']);
            $this->ref_increment_model->update_increment_ref_code($input['inv_id']);
            //insert notification
            $notification = array();
            if (isset($input['receipt_bill']['due_date']) && !empty($input['receipt_bill']['due_date'])) {
                $notification = array();
                $notification['notification_date'] = $input['receipt_bill']['due_date'];
                $notification['type'] = 'payment';
                $notification['link'] = 'receipt/receipt_list';
                $notification['Message'] = date('d-M-Y', strtotime($input['receipt_bill']['due_date'])) . ' is due date for payment';
                $this->notification_model->insert_notification($notification);
            }
            $input_comp = $this->input->post();
            if (!empty($input_comp['receipt_bill'])) {

                unset($input_comp['receipt_bill']['terms']);
                unset($input_comp['receipt_bill']['ac_no']);
                unset($input_comp['receipt_bill']['branch']);
                unset($input_comp['receipt_bill']['dd_no']);
                unset($input_comp['receipt_bill']['reference_number']);
                unset($input_comp['receipt_bill']['due_date']);
                unset($input_comp['receipt_bill']['discount_per']);
                unset($input_comp['receipt_bill']['discount']);
                unset($input_comp['receipt_bill']['remarks']);
                unset($input_comp['balance']);
                $input_comp['receipt_bill']['receiver_type'] = "Sales Reciver";
                $input_comp['receipt_bill']['type'] = "credit";
                $input_comp['receipt_bill']['receipt_id'] = $input_comp['receipt_bill']['receipt_no'];
                unset($input_comp['receipt_bill']['receipt_no']);
                // echo"<pre>"; print_r($input_comp); exit;
                $insert_agent_cash = $this->receipt_model->insert_agent_amount($input_comp['receipt_bill']);
                if ($input_comp['receipt_bill']['recevier'] == 'company') {
                    $get_company_amount = $this->expense_model->getCompanyAmt();
                    $amount = $get_company_amount[0]['company_amount'] + $input_comp['receipt_bill']['bill_amount'];
                    //Update balance sheet
                    $user_info = $this->user_auth->get_from_session('user_info');
                    $get_exp_category = $this->expense_model->get_expense_category_by_name('sales');
                    $balance_data = [
                        "user_id" => $user_info[0]['id'],
                        "cat_id" => $get_exp_category[0]['id'],
                        "mode" => 'credit',
                        "amount" => $input_comp['receipt_bill']['bill_amount'],
                        "company_amount" => $get_company_amount[0]['company_amount'],
                        "balance" => $amount,
                        "created_at" => date('Y-m-d', strtotime($input['receipt_bill']['created_date'])),
                        "remarks" => $input['receipt_bill']['remarks'],
                    ];
                    $insert = $this->expense_model->insert_balance_sheet($balance_data);
                    $this->expense_model->update_company_amt($amount);
                }
            }

            redirect($this->config->item('base_url') . 'receipt/receipt_list');
        }
//        $data['all_agent'] = $this->agent_model->get_agent();
        $data["staff_name"] = $this->customer_model->get_all_staff_name();
        $data['receipt_details'] = $this->receipt_model->get_receipt_by_id($r_id);
        $data["last_id"] = $this->ref_increment_model->get_increment_ref_code($data['receipt_details'][0]['inv_id']);
        $data["po"] = $po = $this->receipt_model->get_all_inv_by_id($r_id);
        $data['po_details'] = $po_details = $this->receipt_model->get_all_inv_details_by_id($r_id);

        $cgst = 0;
        $sgst = 0;
        $over_all_net_total = $over_all_net = 0;
        if (isset($po_details) && !empty($po_details)) {
            foreach ($po_details as $vals) {

                $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['current_quantity']);

                $gst_type = $po[0]['state_id'];
                if ($gst_type != '') {
                    if ($gst_type == 31) {

                        $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * $vals['current_quantity']);
                    } else {
                        $sgst1 = ($vals['igst'] / 100 ) * ($vals['per_cost'] * $vals['current_quantity']);
                    }
                }
                $cgst += $cgst1;
                $sgst += $sgst1;

                $qty = $vals['current_quantity'];
                $per_cost = $vals['per_cost'];
                $gst_val = $vals['tax'];
                if ($gst_type == 31)
                    $c_i_gst_val = $vals['gst'];
                else
                    $c_i_gst_val = $vals['igst'];
                if ($po[0]['is_gst'] == 1) {
                    $net_total = $qty * $per_cost;
                    $final_sub__total = $qty * $per_cost + (($qty * $per_cost) * $gst_val / 100) + (($qty * $per_cost) * $c_i_gst_val / 100);
                } else {
                    $net_total = $qty * ($per_cost);
                    $final_sub__total = $qty * ($per_cost);
                }

                $over_all_net += $final_sub__total;
                $over_all_net_total = $over_all_net + $po[0]['tax'];
            }
        }

        $data['over_all_net_total'] = $over_all_net_total;

        $this->template->write_view('content', 'update_receipt', $data);
        $this->template->render();
    }

    public function view_receipt($r_id) {
        $this->load->model('receipt/receipt_model');
        if ($this->input->post()) {
            $input = $this->input->post();

            if ($input['balance'] == 0 || $input['balance'] == 0.00 || $input['balance'] == '0.00')
                $receipt_status = 'Completed';
            else
                $receipt_status = 'Pending';

            $this->receipt_model->update_invoice(array('payment_status' => $receipt_status), $input['receipt_bill']['receipt_id']);
            $this->receipt_model->insert_receipt_bill($input['receipt_bill']);
            redirect($this->config->item('base_url') . 'receipt/receipt_list');
        }
        $data['all_agent'] = $this->agent_model->get_agent();
        $data['receipt_details'] = $this->receipt_model->get_receipt_by_id($r_id);

        $data["po"] = $po = $this->receipt_model->get_all_inv_by_id($r_id);
        $data['po_details'] = $po_details = $this->receipt_model->get_all_inv_details_by_id($r_id);

        $cgst = 0;
        $sgst = 0;
        $over_all_net_total = $over_all_net = 0;
        if (isset($po_details) && !empty($po_details)) {
            foreach ($po_details as $vals) {

                $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['current_quantity']);

                $gst_type = $po[0]['state_id'];
                if ($gst_type != '') {
                    if ($gst_type == 31) {

                        $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * $vals['current_quantity']);
                    } else {
                        $sgst1 = ($vals['igst'] / 100 ) * ($vals['per_cost'] * $vals['current_quantity']);
                    }
                }
                $cgst += $cgst1;
                $sgst += $sgst1;

                $qty = $vals['current_quantity'];
                $per_cost = $vals['per_cost'];
                $gst_val = $vals['tax'];
                if ($gst_type == 31)
                    $c_i_gst_val = $vals['gst'];
                else
                    $c_i_gst_val = $vals['igst'];

                if ($po[0]['is_gst'] == 1) {
                    $net_total = $qty * $per_cost;
                    $final_sub__total = $qty * $per_cost + (($qty * $per_cost) * $gst_val / 100) + (($qty * $per_cost) * $c_i_gst_val / 100);
                } else {
                    $net_total = $qty * ($per_cost);
                    $final_sub__total = $qty * ($per_cost);
                }

                $over_all_net += $final_sub__total;
                $over_all_net_total = $over_all_net + $po[0]['tax'];
            }
        }

        $data['over_all_net_total'] = $over_all_net_total;
        $this->template->write_view('content', 'view_receipt', $data);
        $this->template->render();
    }

    function ajaxList() {
        $this->load->model('receipt/receipt_model');
        $search_data = array();
        $search_data = $this->input->post();
        $list = $this->receipt_model->get_datatables($search_data);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $sr_data) {
            if ($this->user_auth->is_action_allowed('receipt', 'receipt', 'edit')) {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light" href="' . base_url() . 'receipt/manage_receipt/' . $sr_data['id'] . '" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-pencil"></span></a>';
            } else {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-pencil"></span></a>';
            }
            if ($this->user_auth->is_action_allowed('receipt', 'receipt', 'view')) {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light" href="' . base_url() . 'receipt/view_receipt/' . $sr_data['id'] . '" data-toggle="tooltip" data-placement="top" title="View"><span class="fa fa-eye"></span></a>';
            } else {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-eye"></span></a>';
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $sr_data['inv_id'];
            $row[] = $sr_data['store_name'];

            $cgst = 0;
            $sgst = 0;
            $over_all_net_total = $over_all_net = 0;
            if (isset($sr_data['po_details']) && !empty($sr_data['po_details'])) {
                foreach ($sr_data['po_details'] as $vals) {

                    $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['current_quantity']);

                    $gst_type = $sr_data['state_id'];
                    if ($gst_type != '') {
                        if ($gst_type == 31) {

                            $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * $vals['current_quantity']);
                        } else {
                            $sgst1 = ($vals['igst'] / 100 ) * ($vals['per_cost'] * $vals['current_quantity']);
                        }
                    }
                    $cgst += $cgst1;
                    $sgst += $sgst1;

                    $qty = $vals['current_quantity'];
                    $per_cost = $vals['per_cost'];
                    $gst_val = $vals['tax'];
                    if ($gst_type == 31)
                        $c_i_gst_val = $vals['gst'];
                    else
                        $c_i_gst_val = $vals['igst'];
                    if ($sr_data['is_gst'] == 1) {
                        $net_total = $qty * $per_cost;
                        $final_sub__total = $qty * $per_cost + (($qty * $per_cost) * $gst_val / 100) + (($qty * $per_cost) * $c_i_gst_val / 100);
                    } else {
                        $net_total = $qty * ($per_cost);
                        $final_sub__total = $qty * ($per_cost);
                    }

                    $over_all_net += $final_sub__total;
                    $over_all_net_total = $over_all_net + $sr_data['tax'];
                }
            }

            $final_net_total = $over_all_net_total;

            $row[] = number_format($final_net_total, 2, '.', ',');
            $row[] = number_format($sr_data['advance'] + $sr_data['receipt_bill'][0]['receipt_paid'], 2, '.', ',');
            $row[] = number_format($sr_data['receipt_bill'][0]['receipt_discount'], 2, '.', ',');
            $row[] = number_format(($final_net_total - ($sr_data['receipt_bill'][0]['receipt_paid'] + $sr_data['advance'] + $sr_data['receipt_bill'][0]['receipt_discount']) > 0) ? $final_net_total - ($sr_data['receipt_bill'][0]['receipt_paid'] + $sr_data['advance'] + $sr_data['receipt_bill'][0]['receipt_discount']) : '0.00', 2, '.', ',');
            $row[] = ($sr_data['receipt_bill'][0]['next_date'] != '' && $sr_data['receipt_bill'][0]['next_date'] != '0000-00-00') ? date('d-M-Y', strtotime($sr_data['receipt_bill'][0]['next_date'])) : '-';
            if ($sr_data['payment_status'] == 'Pending' || $final_net_total < $sr_data['receipt_bill'][0]['receipt_paid']) {
                $row[] = '<a href="#" data-toggle="tooltip" class=" ahref" title="In-Complete"><span class="fa fa-thumbs-down blue">&nbsp;</span></a>';
            } else {
                $row[] = '<a href="#" data-toggle="tooltip" class="tooltips ahref" title="Complete"><span class="fa fa-thumbs-up green">&nbsp;</span></a>';
            }
            if ($sr_data['payment_status'] == 'Pending' || $final_net_total < $sr_data['receipt_bill'][0]['receipt_paid']) {
                $row[] = $edit_row . '&nbsp;&nbsp;' . $view_row;
            } else {
                $row[] = $view_row;
            }

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->receipt_model->count_all(),
            "recordsFiltered" => $this->receipt_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    public function update_checking_payment_checkno() {

        $this->load->model('receipt/receipt_model');
        $input = $this->input->post('value1');
        //print_r($input); exit;
        $validation = $this->receipt_model->update_checking_payment_checkno($input);

        $i = 0;
        if ($validation) {
            $i = 1;
        }
        if ($i == 1) {
            echo "Check/DD No Already Exist";
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
