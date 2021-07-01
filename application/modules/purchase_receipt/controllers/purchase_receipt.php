<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Purchase_receipt extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'purchase_receipt';
        $access_arr = array(
            'purchase_receipt/receipt_list' => array('add', 'edit', 'delete', 'view'),
            'purchase_receipt/index' => array('add', 'edit', 'delete', 'view'),
            'purchase_receipt/view_receipt' => array('add', 'edit', 'delete', 'view'),
            'purchase_receipt/manage_receipt' => array('add', 'edit'),
            'purchase_receipt/ajaxList' => 'no_restriction',
        );
        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('api/notification_model');
        $this->load->model('customer/agent_model');
        $this->load->model('admin/admin_model');
        $this->load->model('customer/agent_model');
        if (isset($_GET['notification']))
            $this->notification_model->update_notification(array('status' => 1), $_GET['notification']);
    }

    public function index() {
        $this->load->model('purchase_receipt/receipt_model');
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
            //echo "<pre>";

            $insert_id = $this->receipt_model->insert_receipt($input['receipt']);
            $input['receipt_bill']['receipt_id'] = $insert_id;
            //print_r($insert_id);
            //print_r($input);
            $insert_id = $this->receipt_model->insert_receipt_bill($input['receipt_bill']);

            redirect($this->config->item('base_url') . 'receipt/receipt_list');
        }


        $data['all_customer'] = $this->customer_model->get_customer();
        $data['all_agent'] = $this->agent_model->get_agent();
        $this->template->write_view('content', 'receipt/index', $data);
        $this->template->render();
    }

    public function receipt_list() {
        $this->load->model('purchase_receipt/receipt_model');
        $data['all_receipt'] = $this->receipt_model->get_all_receipt();
        $this->template->write_view('content', 'receipt_list', $data);
        $this->template->render();
    }

    public function manage_receipt($r_id) {
        $this->load->model('purchase_receipt/receipt_model');
        $this->load->model('expense/expense_model');
        if ($this->input->post()) {
            $input = $this->input->post();
            if ($input['balance'] == 0 || $input['balance'] == 0.00 || $input['balance'] == '0.00')
                $receipt_status = 'Completed';
            else
                $receipt_status = 'Pending';
            $input['receipt_bill']['due_date'] = date('Y-m-d', strtotime($input['receipt_bill']['due_date']));
            $input['receipt_bill']['created_date'] = date('Y-m-d', strtotime($input['receipt_bill']['created_date']));
            $this->receipt_model->update_invoice(array('payment_status' => $receipt_status), $input['receipt_bill']['receipt_id']);
            $this->receipt_model->insert_receipt_bill($input['receipt_bill']);
            //insert notification
            $notification = array();
            if (isset($input['receipt_bill']['due_date']) && !empty($input['receipt_bill']['due_date'])) {
                $notification = array();
                $notification['notification_date'] = $input['receipt_bill']['due_date'];
                $notification['type'] = 'purchase_payment';
                $notification['link'] = 'purchase_receipt/receipt_list';
                $notification['Message'] = date('d-M-Y', strtotime($input['receipt_bill']['due_date'])) . '-We have to pay amount for Supplier';
                $this->notification_model->insert_notification($notification);
            }

            $input_comp = $this->input->post();
            if (!empty($input_comp['receipt_bill'])) {
                unset($input_comp['receipt_bill']['receipt_no']);
                unset($input_comp['receipt_bill']['terms']);
                unset($input_comp['receipt_bill']['ac_no']);
                unset($input_comp['receipt_bill']['branch']);
                unset($input_comp['receipt_bill']['dd_no']);
                unset($input_comp['receipt_bill']['reference_number']);
                unset($input_comp['receipt_bill']['due_date']);
                unset($input_comp['receipt_bill']['discount_per']);
                unset($input_comp['receipt_bill']['discount']);
                unset($input_comp['balance']);
                unset($input_comp['receipt_bill']['remarks']);
                $input_comp['receipt_bill']['receiver_type'] = "Purchase Cost";
                $input_comp['receipt_bill']['type'] = "debit";
                //echo"<pre>"; print_r($input_comp); exit;

                $insert_agent_cash = $this->receipt_model->insert_agent_amount($input_comp['receipt_bill']);
                $get_company_amount = $this->expense_model->getCompanyAmt();
//                $purchase_cost = $this->admin_model->get_purchase_cost();
                $amount = $get_company_amount[0]['company_amount'] - ($input['receipt_bill']['bill_amount']);

                //Update balance sheet
                $user_info = $this->user_auth->get_from_session('user_info');
                $get_exp_category = $this->expense_model->get_expense_category_by_name('purchase');
                $balance_data = [
                    "user_id" => $user_info[0]['id'],
                    "cat_id" => $get_exp_category[0]['id'],
                    "mode" => 'debit',
                    "amount" => $input['receipt_bill']['bill_amount'],
                    "company_amount" => $get_company_amount[0]['company_amount'],
                    "balance" => $amount,
                    "created_at" => date('Y-m-d', strtotime($input['receipt_bill']['created_date'])),
                    "remarks" => $input['receipt_bill']['remarks'],
                ];
                $insert = $this->expense_model->insert_balance_sheet($balance_data);
                $this->expense_model->update_company_amt($amount);
            }
            redirect($this->config->item('base_url') . 'purchase_receipt/receipt_list');
        }
        $data['all_agent'] = $this->agent_model->get_agent();
        $data['receipt_details'] = $this->receipt_model->get_receipt_by_id($r_id);
        $data["po"] = $po = $this->receipt_model->get_all_po_by_id($r_id);
        $data['po_details'] = $po_details = $this->receipt_model->get_all_po_details_by_id($r_id);

        $cgst = 0;
        $sgst = 0;
        $over_all_net_total = $over_all_net = 0;
        if (isset($po_details) && !empty($po_details)) {
            foreach ($po_details as $vals) {

                $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['delivery_quantity']);

                $gst_type = $po[0]['state_id'];
                if ($gst_type != '') {
                    if ($gst_type == 31) {

                        $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * $vals['delivery_quantity']);
                    } else {
                        $sgst1 = ($vals['igst'] / 100 ) * ($vals['per_cost'] * $vals['delivery_quantity']);
                    }
                }
                $cgst += $cgst1;
                $sgst += $sgst1;

                $deliver_qty = $vals['delivery_quantity'];
                $per_cost = $vals['per_cost'];
                $gst_val = $vals['tax'];
                $cgst_val = $vals['gst'];
                if ($po[0]['is_gst'] == 1) {
                    $net_total = $deliver_qty * $per_cost;
                } else {
                    $net_total = $deliver_qty * ($per_cost);
                }

                if ($po[0]['is_gst'] == 1) {
                    $final_sub__total = $deliver_qty * $per_cost + (($deliver_qty * $per_cost) * $gst_val / 100) + (($deliver_qty * $per_cost) * $cgst_val / 100);
                } else {
                    $final_sub__total = $deliver_qty * ($per_cost);
                }

                $over_all_net += $final_sub__total;
                if ($over_all_net > 0) {
                    $over_all_net_total = $over_all_net + $po[0]['tax'];
                } else {
                    $over_all_net_total = $over_all_net;
                }
            }
        }

        $data['over_all_net_total'] = $over_all_net_total;
        $this->template->write_view('content', 'update_receipt', $data);
        $this->template->render();
    }

    public function view_receipt($r_id) {
        $this->load->model('purchase_receipt/receipt_model');
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
        $data["po"] = $po = $this->receipt_model->get_all_po_by_id($r_id);
        $data['po_details'] = $po_details = $this->receipt_model->get_all_po_details_by_id($r_id);
        $cgst = 0;
        $sgst = 0;
        $over_all_net_total = $over_all_net = 0;
        if (isset($po_details) && !empty($po_details)) {
            foreach ($po_details as $vals) {

                $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['delivery_quantity']);

                $gst_type = $po[0]['state_id'];
                if ($gst_type != '') {
                    if ($gst_type == 31) {

                        $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * $vals['delivery_quantity']);
                    } else {
                        $sgst1 = ($vals['igst'] / 100 ) * ($vals['per_cost'] * $vals['delivery_quantity']);
                    }
                }
                $cgst += $cgst1;
                $sgst += $sgst1;

                $deliver_qty = $vals['delivery_quantity'];
                $per_cost = $vals['per_cost'];
                $gst_val = $vals['tax'];
                $cgst_val = $vals['gst'];

                if ($po[0]['is_gst'] == 1) {
                    $net_total = $deliver_qty;
                    $final_sub__total = $deliver_qty * $per_cost + (($deliver_qty * $per_cost) * $gst_val / 100) + (($deliver_qty * $per_cost) * $cgst_val / 100);
                } else {
                    $net_total = $deliver_qty * ($per_cost);
                    $final_sub__total = $deliver_qty * ($per_cost);
                }

                $over_all_net += $final_sub__total;
                if ($over_all_net > 0) {
                    $over_all_net_total = $over_all_net + $po[0]['tax'];
                } else {
                    $over_all_net_total = $over_all_net;
                }
            }
        }

        $data['over_all_net_total'] = $over_all_net_total;

        $this->template->write_view('content', 'view_receipt', $data);
        $this->template->render();
    }

    function ajaxList() {
        $this->load->model('purchase_receipt/receipt_model');
        $search_data = array();
        $search_data = $this->input->post();
        $list = $this->receipt_model->get_purchase_receipt_datatables($search_data);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pr_data) {
            if ($pr_data['payment_status'] == 'Pending') {
                if ($this->user_auth->is_action_allowed('purchase_receipt', 'purchase_receipt', 'edit')) {
                    $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light" href="' . base_url() . 'purchase_receipt/manage_receipt/' . $pr_data['id'] . '" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-pencil "></span></a>';
                } else {
                    $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-pencil"></span></a>';
                }
            }
            if ($this->user_auth->is_action_allowed('purchase_receipt', 'purchase_receipt', 'view')) {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light" href="' . base_url() . 'purchase_receipt/view_receipt/' . $pr_data['id'] . '" data-toggle="tooltip" data-placement="top" title="View"><span class="fa fa-eye"></span></a>';
            } else {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-eye"></span></a>';
            }
            $no++;

            $row = array();
            $row[] = $no;
            $row[] = $pr_data['po_no'];
            $row[] = $pr_data['store_name'];
            $cgst = 0;
            $sgst = 0;
            $over_all_net_total = $over_all_net = 0;
            if (isset($pr_data['po_details']) && !empty($pr_data['po_details'])) {
                foreach ($pr_data['po_details'] as $vals) {

                    $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['delivery_quantity']);

                    $gst_type = $pr_data['state_id'];
                    if ($gst_type != '') {
                        if ($gst_type == 31) {

                            $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * $vals['delivery_quantity']);
                        } else {
                            $sgst1 = ($vals['igst'] / 100 ) * ($vals['per_cost'] * $vals['delivery_quantity']);
                        }
                    }
                    $cgst += $cgst1;
                    $sgst += $sgst1;

                    $deliver_qty = $vals['delivery_quantity'];
                    $per_cost = $vals['per_cost'];
                    $gst_val = $vals['tax'];
                    $cgst_val = $vals['gst'];

                    if ($pr_data['is_gst'] == 1) {
                        $net_total = $deliver_qty * $per_cost;
                        $final_sub__total = $deliver_qty * $per_cost + (($deliver_qty * $per_cost) * $gst_val / 100) + (($deliver_qty * $per_cost) * $cgst_val / 100);
                    } else {
                        $net_total = $deliver_qty * ($per_cost);
                        $final_sub__total = $deliver_qty * ($per_cost);
                    }
                    $over_all_net += $final_sub__total;
                    if ($over_all_net > 0) {
                        $over_all_net_total = $over_all_net + $pr_data['tax'];
                    } else {
                        $over_all_net_total = $over_all_net;
                    }
                }
            }

            $net_total = $over_all_net_total;
            $row[] = number_format($net_total, 2, '.', ',');
            $row[] = number_format($pr_data['receipt_bill'][0]['receipt_paid'], 2, '.', ',');
            $row[] = number_format($pr_data['receipt_bill'][0]['receipt_discount'], 2, '.', ',');
            $row[] = number_format(($net_total - ($pr_data['receipt_bill'][0]['receipt_paid'] + $pr_data['receipt_bill'][0]['receipt_discount']) > 0) ? $net_total - ($pr_data['receipt_bill'][0]['receipt_paid'] + $pr_data['receipt_bill'][0]['receipt_discount']) : '0.00', 2, '.', ',');
            $row[] = ($pr_data['receipt_bill'][0]['next_date'] != '') ? date('d-M-Y', strtotime($pr_data['receipt_bill'][0]['next_date'])) : '-';
            $row[] = ($pr_data['remarks'][0]['remarks'] != '') ? '<p class="hide_overflow">' . ucfirst($pr_data['remarks'][0]['remarks']) . '</p>' : '-';
            if ($pr_data['payment_status'] == 'Pending') {
                $payment_status = '<a href="#" data-toggle="tooltip" class=" ahref" title="In-Complete"><span class="fa fa-thumbs-down blue">&nbsp;</span></a>';
            } else {
                $payment_status = '<a href="#" data-toggle="tooltip" class=" ahref" title="Complete"><span class="fa fa-thumbs-up green">&nbsp;</span></a>';
            }
            $row[] = $payment_status;
            if ($pr_data['payment_status'] == 'Pending') {
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

}
