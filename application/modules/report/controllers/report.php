<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'report';
        $access_arr = array(
            'report/cashinhand' => 'no_restriction',
            'report/search_cahsinhand' => 'no_restriction',
            'report/conversion_list' => 'no_restriction',
            'report/search_conversion_list' => 'no_restriction',
            'report/profit_list' => 'no_restriction',
            'report/search_profit_list' => 'no_restriction',
            'report/quotation_report' => 'no_restriction',
            'report/quotation_search_result' => 'no_restriction',
            'report/outstanding_report' => 'no_restriction',
            'report/outstanding_search_result' => 'no_restriction',
            'report/customer_report' => 'no_restriction',
            'report/employee_report' => 'no_restriction',
            'report/purchase_report' => 'no_restriction',
            'report/purchase_search_result' => 'no_restriction',
            'report/purchase_receipt' => 'no_restriction',
            'report/purchase_receipt_search_result' => 'no_restriction',
            'report/stock_report' => 'no_restriction',
            'report/stock_search_result' => 'no_restriction',
            'report/pc_report' => 'no_restriction',
            'report/pc_search_result' => 'no_restriction',
            'report/invoice_report' => 'no_restriction',
            'report/invoice_search_result' => 'no_restriction',
            'report/quotation_ajaxList' => 'no_restriction',
            'report/outstanding_ajaxList' => 'no_restriction',
            'report/customer_ajaxList' => 'no_restriction',
            'report/employee_ajaxList' => 'no_restriction',
            'report/po_ajaxList' => 'no_restriction',
            'report/stock_ajaxList' => 'no_restriction',
            'report/invoice_ajaxList' => 'no_restriction',
            'report/profit_ajaxList' => 'no_restriction',
            'report/conversion_ajaxList' => 'no_restriction',
            'report/purchase_receipt_ajaxList' => 'no_restriction',
            'report/grn_ajaxList' => 'no_restriction',
            'report/grn_report' => 'no_restriction',
            'report/service_ratio_report' => 'no_restriction',
            'report/service_ratio_ajaxList' => 'no_restriction',
            'report/monthly_attendance_report' => 'no_restriction',
            'report/monthly_attendance_ajaxList' => 'no_restriction',
            'report/daily_cash_book_report' => 'no_restriction',
            'report/daily_cash_book_ajaxList' => 'no_restriction',
            'report/service_material_report' => 'no_restriction',
            'report/service_material_ajaxList' => 'no_restriction',
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            $this->user_auth->is_permission_allowed();
            redirect($this->config->item('base_url'));
        }

        $this->load->model('quotation/gen_model');
        $this->load->library('form_validation');
        $this->load->model('purchase_order/purchase_order_model');
        $this->load->model('stock/stock_model');
        $this->load->model('master_category/master_category_model');
        $this->load->model('product/product_model');
        $this->load->model('master_brand/master_brand_model');
        $this->load->model('customer/agent_model');
        $this->load->model('project_cost/project_cost_model');
        $this->load->model('admin/admin_model');
        $this->load->model('report_model');
        $this->load->model('agent/agent_model');
        $this->load->model('grn/grn_model');
    }

    function cashinhand() {
        $this->load->model('receipt/receipt_model');
        $data['all_agent'] = $this->agent_model->get_agent();
        $data['amount'] = $this->receipt_model->get_all_amount();
        // $data['company_amount'] =$this->admin_model->get_company_amount();
        $data['credit'] = $this->admin_model->amount_credit();
        $data['debit'] = $this->admin_model->amount_debit();
        $data['company_amount'] = $data['credit'][0]['credit'] - $data['debit'][0]['debit'];
        $this->template->write_view('content', 'cashinhand', $data);
        $this->template->render();
    }

    function search_cahsinhand() {
        $this->load->model('agent/agent_model');
        $this->load->model('receipt/receipt_model');
        // $data['company_amount'] =$this->admin_model->get_company_amount();
        $search_data = $this->input->get();
        // echo"<pre>"; print_r($search_data); exit;
        if (isset($search_data['agent']) && !empty($search_data['agent']) && $search_data['agent'] != 'Select' && $search_data['cah_option'] == 'agent') {
            $data['credit'] = $this->admin_model->amount_credit_agent($search_data['agent']);
            $data['debit'] = $this->admin_model->amount_debit_agent($search_data['agent']);
            $data['company_amount'] = $data['credit'][0]['credit'] - $data['debit'][0]['debit'];
            $data['search_data'] = $search_data;
            $data['amount'] = $this->receipt_model->get_all_receipt_cash($search_data);
            $this->load->view('report/search_cashinhand', $data);
        }
        if ($search_data['agent'] == 'Select') {
            $data['credit'] = $this->admin_model->amount_credit_agent_all();
            $data['debit'] = $this->admin_model->amount_debit_agent_all();

            $data['company_amount'] = $data['credit'][0]['credit'] - $data['debit'][0]['debit'];

            $data['search_data'] = $search_data;
            $data['amount'] = $this->receipt_model->get_all_receipt_cash($search_data);
            $this->load->view('report/search_cashinhand', $data);
        }
        if ($search_data['cah_option'] == 'company' && $search_data['agent'] == 'Select') {
            $this->load->model('receipt/receipt_model');
            $data['all_agent'] = $this->agent_model->get_agent();
            $data['amount'] = $this->receipt_model->get_all_amount();
            // $data['company_amount'] =$this->admin_model->get_company_amount();
            $data['credit'] = $this->admin_model->amount_credit();
            $data['debit'] = $this->admin_model->amount_debit();
            $data['company_amount'] = $data['credit'][0]['credit'] - $data['debit'][0]['debit'];
//            $this->load->view('report/search_cashinhand_company', $data);
        }
    }

    public function conversion_list() {
        $this->load->model('project_cost/project_cost_model');
        $datas["quotation"] = $quotation = $this->report_model->get_all_quotation_report();
        $datas['pc_count'] = $datas["quotation"][0]['pc_total'][0]['id'];
        $datas['td_count'] = $datas["quotation"][0]['quo_total'][0]['id'];
        $datas['percentage'] = ($datas["quotation"][0]['pc_total'][0]['id'] / $datas["quotation"][0]['quo_total'][0]['id']) * 100;

        $this->template->write_view('content', 'report/conversion_list', $datas);
        $this->template->render();
    }

    public function search_conversion_list() {
        $this->load->model('project_cost/project_cost_model');
        $search_data = $this->input->get();
        $data['search_data'] = $search_data;
        $datas["quotation"] = $quotation = $this->report_model->get_all_quotation_report($search_data);
        $datas["quotation"][0]['percentage'] = ($datas["quotation"][0]['count'] / $datas["quotation"][0]['count']) * 100;
        // echo"<pre>"; print_r($datas); exit;
        $datas['company_details'] = $this->admin_model->get_company_details();
        $this->load->view('report/search_conversion_list', $datas);
    }

    public function profit_list() {
        $this->load->model('project_cost/project_cost_model');
        $datas["quotation"] = $quotation = $this->report_model->get_all_profit_report();
        $datas['all_company'] = $this->gen_model->get_all_customers();
        $datas['company_details'] = $this->admin_model->get_company_details();
        // echo"<pre>"; print_r($datas); exit;
        $this->template->write_view('content', 'report/profit_list', $datas);
        $this->template->render();
    }

    public function search_profit_list() {
        $this->load->model('project_cost/project_cost_model');
        $search_data = $this->input->get();
        $data['search_data'] = $search_data;
        $datas["quotation"] = $quotation = $this->report_model->get_all_profit_report($search_data);
        $datas['company_details'] = $this->admin_model->get_company_details();
        $this->load->view('report/search_profit_list', $datas);
    }

    function quotation_report() {
        $data['all_style'] = $this->gen_model->get_all_quotation();
        $data['all_supplier'] = $this->gen_model->get_all_customers();
        $data['quotation'] = $this->gen_model->get_all_quotation();
        $this->template->write_view('content', 'report/quotation_list', $data);
        $this->template->render();
    }

    public function quotation_search_result() {
        $search_data = $this->input->get();
        $data['search_data'] = $search_data;
        $data['quotation'] = $this->gen_model->get_all_quotation($search_data);

        $this->load->view('report/search_quotation_list', $data);
    }

    function outstanding_report() {

        $data['all_supplier'] = $this->gen_model->get_all_customers();
        $data['quotation'] = $this->gen_model->get_all_quotation();
        $this->template->write_view('content', 'report/outstanding_list', $data);
        $this->template->render();
    }

    public function outstanding_search_result() {
        $search_data = $this->input->get();
        $data['search_data'] = $search_data;
        $data['quotation'] = $this->gen_model->get_all_quotation($search_data);

        $this->load->view('report/search_outstanding_list', $data);
    }

    function customer_report() {
        $this->template->write_view('content', 'report/customer_list', $data);
        $this->template->render();
    }

    function employee_report() {
        $this->template->write_view('content', 'report/employee_list', $data);
        $this->template->render();
    }

    function purchase_report() {
        $data['all_style'] = $this->purchase_order_model->get_all_po();
        $data['all_supplier'] = $this->purchase_order_model->get_all_customers();
        $data['po'] = $this->purchase_order_model->get_all_po();
        $this->template->write_view('content', 'report/purchase_order_list', $data);
        $this->template->render();
    }

    public function purchase_search_result() {
        $search_data = $this->input->get();
        $data['search_data'] = $search_data;
        $data['po'] = $this->purchase_order_model->get_all_po($search_data);
        $this->load->view('report/search_purchase_order_list', $data);
    }

    function purchase_receipt() {
        $this->load->model('purchase_receipt/receipt_model');
        $data['all_style'] = $this->receipt_model->get_all_receipt();
        $data['all_supplier'] = $this->receipt_model->get_company();
        $data['all_receipt'] = $this->receipt_model->get_all_receipt();
        $this->template->write_view('content', 'report/receipt_list', $data);
        $this->template->render();
    }

    public function purchase_receipt_search_result() {
        $search_data = $this->input->get();
        $data['search_data'] = $search_data;
        $this->load->model('purchase_receipt/receipt_model');
        $data['all_receipt'] = $this->receipt_model->get_all_receipt($search_data);
        $this->load->view('report/search_purchase_receipt_list', $data);
    }

    function stock_report() {
        $data['product'] = $this->product_model->get_product();
        $data['brand'] = $this->master_brand_model->get_brand();
        $data['cat'] = $this->master_category_model->get_all_category();
        //echo"<pre>"; print_r($data); exit;
        $data['stock'] = $this->stock_model->get_all_stock();
        $this->template->write_view('content', 'report/stock_list', $data);
        $this->template->render();
    }

    public function stock_search_result() {
        $search_data = $this->input->get();
        $data['search_data'] = $search_data;
        $data['stock'] = $this->stock_model->get_all_stock($search_data);
        $this->load->view('report/search_stock_list', $data);
    }

    function pc_report() {

        $data['all_style'] = $this->project_cost_model->get_all_project_cost();
        $data['all_supplier'] = $this->project_cost_model->get_customer();
        $data['quotation'] = $this->project_cost_model->get_all_project_cost();
        $this->template->write_view('content', 'report/pc_list', $data);
        $this->template->render();
    }

    public function pc_search_result() {
        $search_data = $this->input->get();
        $data['search_data'] = $search_data;
        $data['quotation'] = $this->project_cost_model->get_all_project_cost($search_data);
        $this->load->view('report/pc_search_list', $data);
    }

    function invoice_report() {

        $data['all_style'] = $this->project_cost_model->get_invoice();
        $data['all_supplier'] = $this->project_cost_model->get_customer();
        $data['quotation'] = $this->project_cost_model->get_invoice();
        $this->template->write_view('content', 'report/invoice_list', $data);
        $this->template->render();
    }

    public function invoice_search_result() {
        $search_data = $this->input->get();
        $data['search_data'] = $search_data;
        $data['quotation'] = $this->project_cost_model->get_invoice($search_data);
        $this->load->view('report/invoice_search_list', $data);
    }

    public function quotation_ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $search_arr = array();
        $search_arr['from_date'] = $search_data['from_date'];
        $search_arr['to_date'] = $search_data['to_date'];
        $search_arr['q_no'] = $search_data['q_no'];
        $search_arr['customer'] = $search_data['customer'];

        if (empty($search_arr)) {
            $search_arr = array();
        }
        $list = $this->report_model->get_quotation_datatables($search_arr);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $val) {
            $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light" href="' . base_url() . 'quotation/quotation_view/' . $val['id'] . '" data-toggle="tooltip" data-placement="top" title="View"><span class="fa fa-eye"></span></a>';
            if ($val['estatus'] == 1) {
                $status = '<span class="label label-danger">Pending</span>';
            } else if ($val['estatus'] == 2) {
                $status = '<span class="label label-success">Completed</span>';
            } else if ($val['estatus'] == 4) {
                $status = '<span class="label label-info">Order Approved</span>';
            } else if ($val['estatus'] == 5) {
                $status = '<span class="label label-warning">Order Reject</span>';
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val['q_no'];
            $row[] = $val['name'];
            $row[] = $val['total_qty'];
            $row[] = number_format($val['tax_details'][0]['tot_tax'], 2);
            $row[] = number_format($val['subtotal_qty'], 2);
            $row[] = number_format($val['net_total'], 2);
            $row[] = $val['mode_of_payment'];
            $row[] = ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '';
            $row[] = $status;
            $row[] = $view_row;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->report_model->count_all_quotation(),
            "recordsFiltered" => $this->report_model->count_filtered_quotation(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    public function outstanding_ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $search_arr = array();
        $search_arr['from_date'] = $search_data['from_date'];
        $search_arr['to_date'] = $search_data['to_date'];
        $search_arr['customer'] = $search_data['customer'];

        if (empty($search_arr)) {
            $search_arr = array();
        }
        $list = $this->report_model->get_outstanding_datatables($search_arr);
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
                    $cgst_val = $vals['gst'];

                    if ($sr_data['is_gst'] == 1) {
                        $net_total = $qty * $per_cost;
                        $final_sub__total = $qty * $per_cost + (($qty * $per_cost) * $gst_val / 100) + (($qty * $per_cost) * $cgst_val / 100);
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
//            if ($sr_data['payment_status'] == 'Pending' || $final_net_total < $sr_data['receipt_bill'][0]['receipt_paid']) {
//                $row[] = '<a href="#" data-toggle="tooltip" class=" ahref" title="In-Complete"><span class="fa fa-thumbs-down blue">&nbsp;</span></a>';
//            } else {
//                $row[] = '<a href="#" data-toggle="tooltip" class="tooltips ahref" title="Complete"><span class="fa fa-thumbs-up green">&nbsp;</span></a>';
//            }
            if ($sr_data['payment_status'] == 'Pending' || $final_net_total < $sr_data['receipt_bill'][0]['receipt_paid']) {

                $status = '<span class="label label-danger">Pending</span>';
            } else {

                $status = '<span class="label label-success">Completed</span>';
            }
            $row[] = $status;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->report_model->count_all_outstanding(),
            "recordsFiltered" => $this->report_model->count_outstanding_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    function customer_ajaxList() {

        $list = $this->report_model->get_customer_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $cust_data) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = 'CUST_ID_' . $cust_data->id;
            $row[] = $cust_data->name;
            $row[] = $cust_data->store_name;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->report_model->count_all_customer(),
            "recordsFiltered" => $this->report_model->count_filtered_customer(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    function employee_ajaxList() {

        $list = $this->report_model->get_employee_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $emp_data) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $emp_data->emp_code;
            $row[] = ucfirst($emp_data->name);
            $row[] = $emp_data->mobile_no;
            $row[] = ucfirst($emp_data->user_role);
            $row[] = $emp_data->email_id;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->report_model->count_all_employee(),
            "recordsFiltered" => $this->report_model->count_filtered_employee(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    public function po_ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $search_arr = array();
        $search_arr['from_date'] = $search_data['from_date'];
        $search_arr['to_date'] = $search_data['to_date'];
        $search_arr['po_no'] = $search_data['po_no'];
        $search_arr['supplier'] = $search_data['supplier'];

        if (empty($search_arr)) {
            $search_arr = array();
        }
        $list = $this->report_model->get_po_datatables($search_arr);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $val) {
            $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light" href="' . base_url() . 'purchase_order/po_view/' . $val['id'] . '" data-toggle="tooltip" data-placement="top" title="View"><span class="fa fa-eye"></span></a>';

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val['po_no'];
            //$grn_no = array();
            //$grn_id = array();
            $link = "";
            foreach ($val['grn_no'] as $value) {
                $grn_id = $value["gen_id"];
                $grn_no = $value["grn_no"];
                $link .= '<a href="' . $this->config->item('base_url') . 'grn/grn_view/' . $grn_id . '" >' . $grn_no . '</a>' . ' ';
            }
            $row[] = $link;
//            $row[] = $grn_no;
            $row[] = $val['store_name'];
            $row[] = $val['total_qty'];
            $row[] = number_format($val['subtotal_qty'], 2);
            $row[] = number_format($val['net_total'], 2);
            $row[] = $val['mode_of_payment'];
            $row[] = $val['remarks'];
            $row[] = $view_row;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->report_model->count_all_po(),
            "recordsFiltered" => $this->report_model->count_filtered_po(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    public function stock_ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $search_arr = array();
        $search_arr['brand'] = $search_data['brand'];
        $search_arr['product'] = $search_data['product'];
        $search_arr['category'] = $search_data['category'];

        if (empty($search_arr)) {
            $search_arr = array();
        }
        $list = $this->report_model->get_stock_datatables($search_arr);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $val) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val['categoryName'];
            $row[] = $val['brands'];
            $row[] = $val['model_no'];
            $row[] = $val['product_name'];
            $row[] = $val['quantity'];
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->report_model->count_all_stock(),
            "recordsFiltered" => $this->report_model->count_filtered_stock(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    public function invoice_ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $search_arr = array();
        $search_arr['from_date'] = $search_data['from_date'];
        $search_arr['to_date'] = $search_data['to_date'];
        $search_arr['inv_id'] = $search_data['inv_id'];
        $search_arr['customer'] = $search_data['customer'];

        if (empty($search_arr)) {
            $search_arr = array();
        }
        $list = $this->report_model->get_inv_datatables($search_arr);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $val) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val['inv_id'];
            $row[] = $val['name'];
            $row[] = $val['total_qty'];
            $row[] = $val['tax'];
            $row[] = number_format($val['subtotal_qty'], 2);
            $row[] = number_format($val['net_total'], 2);
            $row[] = ($val['created_date'] != '0000-00-00') ? date('d-M-Y', strtotime($val['created_date'])) : '';
            $row[] = $val['remarks'];
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->report_model->count_all_inv(),
            "recordsFiltered" => $this->report_model->count_filtered_inv(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    public function profit_ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $search_arr = array();
        $search_arr['from_date'] = $search_data['from_date'];
        $search_arr['to_date'] = $search_data['to_date'];
        $search_arr['company_name'] = $search_data['company_name'];

        if (empty($search_arr)) {
            $search_arr = array();
        }
        $list = $this->report_model->get_profit_datatables($search_arr);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $val) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val['q_no'];
            $row[] = $val['name'];
            $row[] = number_format($val['net_total'], 2);
            if (isset($val['pc_amount']) && !empty($val['pc_amount'])) {
                if (isset($val['inv_amount']) && !empty($val['inv_amount'])) {
                    $row[] = $val['inv_amount'][0]['inv_id'];
                    $row[] = ($val['inv_amount'][0]['created_date'] != '0000-00-00') ? date('d-M-Y', strtotime($val['inv_amount'][0]['created_date'])) : '';
                    $row[] = number_format($val['inv_amount'][0]['net_total'], 2);
                } else {
                    $row[] = '';
                    $row[] = '';
                    $row[] = '';
                }
            } else {
                $row[] = '';
                $row[] = '';
                $row[] = '';
            }
            if (isset($val['pc_amount']) && !empty($val['pc_amount'])) {
                $row[] = $val['pc_amount'][0]['job_id'];
                $row[] = $val['pc_amount'][0]['net_total'];
                if ($val['inv_amount'][0]['net_total'] != '')
                    $row[] = number_format((((float) ((($val['inv_amount'][0]['net_total'] - $val['receipt_bill'][0]['receipt_discount'])) - (float) $val['pc_amount'][0]['net_total']) * 100) / (float) $val['pc_amount'][0]['net_total']), 2, '.', ',') . '%';
                if ($val['inv_amount'][0]['net_total'] != '')
                    $profit_amt = number_format((($val['inv_amount'][0]['net_total'] - $val['receipt_bill'][0]['receipt_discount']) - $val['pc_amount'][0]['net_total']), 2, '.', ',');
                if ($profit_amt >= 0) {
                    $row[] = $profit_amt;
                } else {
                    $row[] = '<span class="text-danger">' . $profit_amt . '</span>';
                }
            } else {
                $row[] = '';
                $row[] = '';
                $row[] = '';
                $row[] = '';
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->report_model->count_all_profit(),
            "recordsFiltered" => $this->report_model->count_filtered_profit(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    public function conversion_ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $search_arr = array();
        $search_arr['from_date'] = $search_data['from_date'];
        $search_arr['to_date'] = $search_data['to_date'];

        if (empty($search_arr)) {
            $search_arr = array();
        }

        $list = $this->report_model->get_conversion_datatables($search_arr);

        if ($list[0]['count'] != 0) {
            $list = $list;
        } else {
            $list = [];
        }

        $data = array();
        $no = $_POST['start'];
        if($list[0]['id'] != null){
            foreach ($list as $val) {

                $no++;
                $row = array();
                $row[] = $no;
                $row[] = $val['q_no'];
                $row[] = $val['name'];
                $row[] = number_format($val['net_total'], 2);
                $row[] = ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '';
                if (isset($val['job_id']) && !empty($val['job_id'])) {
                    $row[] = $val['job_id'];
                    $row[] = number_format($val['pcamount'], 2);
                } else {
                    $row[] = '';
                    $row[] = '';
                }

                $data[] = $row;
            }
         }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->report_model->count_all_conversion($search_arr),
            "recordsFiltered" => $this->report_model->count_filtered_conversion($search_arr),
            "data" => $data,
            "quo_total" => $list[0]['quoation_total'],
            "job_total" => $list[0]['job_total'],
        );
        echo json_encode($output);
        exit;
    }

    public function purchase_receipt_ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $search_arr = array();
        $search_arr['from_date'] = $search_data['from_date'];
        $search_arr['to_date'] = $search_data['to_date'];
        $search_arr['q_no'] = $search_data['q_no'];
        $search_arr['customer'] = $search_data['customer'];

        if (empty($search_arr)) {
            $search_arr = array();
        }

        $list = $this->report_model->get_purchase_receipt_datatables($search_arr);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $val) {

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val['po_no'];
            $row[] = $val['store_name'];
            $cgst = 0;
            $sgst = 0;
            $over_all_net_total = $over_all_net = 0;
            if (isset($val['po_details']) && !empty($val['po_details'])) {
                foreach ($val['po_details'] as $vals) {

                    $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['delivery_quantity']);

                    $gst_type = $val['state_id'];
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

                    if ($val['is_gst'] == 1) {
                        $net_total = $deliver_qty * $per_cost;
                        $final_sub__total = $deliver_qty * $per_cost + (($deliver_qty * $per_cost) * $gst_val / 100) + (($deliver_qty * $per_cost) * $cgst_val / 100);
                    } else {
                        $net_total = $deliver_qty * ($per_cost);
                        $final_sub__total = $deliver_qty * ($per_cost);
                    }
                    $over_all_net += $final_sub__total;
                    if ($over_all_net > 0) {
                        $over_all_net_total = $over_all_net + $val['tax'];
                    } else {
                        $over_all_net_total = $over_all_net;
                    }
                }
            }

            $net_total = $over_all_net_total;
            $row[] = number_format($net_total, 2);
            $row[] = number_format($val['receipt_bill'][0]['receipt_paid'], 2, '.', ',');
            $row[] = number_format($val['receipt_bill'][0]['receipt_discount'], 2, '.', ',');
            $row[] = number_format(($net_total - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'])), 2, '.', ',');
            $row[] = ($val['receipt_bill'][0]['next_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['next_date'])) : '';
            if ($val['payment_status'] == 'Pending') {
                $status = '<a href="#" data-toggle="modal" class=" ahref" title="In-Complete"><span class="fa fa-thumbs-down blue">&nbsp;</span></a>';
            } else {
                $status = '<a href="#" data-toggle="modal" class=" ahref" title="Complete"><span class="fa fa-thumbs-up green">&nbsp;</span></a>';
            }
            $row[] = $status;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->report_model->count_all_purchase_receipt(),
            "recordsFiltered" => $this->report_model->count_filtered_purchase_receipt(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    public function grn_report() {
        $data = array();
        $data['all_style'] = $this->purchase_order_model->get_all_po();
        $data['all_supplier'] = $this->purchase_order_model->get_all_customers();
        $data['all_grn'] = $this->grn_model->get_all_grn();
        $this->template->write_view('content', 'report/grn_report', $data);
        $this->template->render();
    }

    function grn_ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $search_arr = array();
        $search_arr['from_date'] = $search_data['from_date'];
        $search_arr['to_date'] = $search_data['to_date'];
        $search_arr['po_no'] = $search_data['po_no'];
        $search_arr['grn_no'] = $search_data['grn_no'];
        $search_arr['supplier'] = $search_data['supplier'];

        if (empty($search_arr)) {
            $search_arr = array();
        }
        $list = $this->report_model->get_grn_datatables($search_arr);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $grn_data) {
            if ($this->user_auth->is_action_allowed('goods_receive_note', 'goods_receive_note', 'view')) {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light" href="' . base_url() . 'grn/grn_view/' . $grn_data['id'] . '" data-toggle="tooltip" data-placement="top" title="View"><span class="fa fa-eye"></span></a>';
            } else {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-eye"></span></a>';
            }
            $no++;

            $row = array();
            $row[] = $no;
            $row[] = $grn_data['grn_no'];
            $row[] = $grn_data['po_no'];
            $row[] = $grn_data['name'];
            $row[] = number_format($grn_data['deliver'][0]['delivery_qty']);
            $row[] = number_format($grn_data['net_total'], 2, '.', ',');
            $row[] = ($grn_data['inv_date'] != '') ? date('d-M-Y', strtotime($grn_data['inv_date'])) : '-';
            $row[] = $view_row;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->report_model->count_all_grn(),
            "recordsFiltered" => $this->report_model->count_filtered_grn(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    public function service_ratio_report() {
        $datas["service"] = $this->report_model->get_all_service_report();
        $datas['pending_count'] = $datas["service"][0]['pending_total'][0]['id'];
        $datas['completed_count'] = $datas["service"][0]['completed_total'][0]['id'];
        $datas['service_percentage'] = ($datas["service"][0]['completed_total'][0]['id'] / $datas["service"][0]['total_service'][0]['id']) * 100;

        $this->template->write_view('content', 'report/service_ratio_list', $datas);
        $this->template->render();
    }

    function service_ratio_ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $search_arr = array();
        $search_arr['from_date'] = $search_data['from_date'];
        $search_arr['to_date'] = $search_data['to_date'];

        if (empty($search_arr)) {
            $search_arr = array();
        }
        $list = $this->report_model->get_service_datatables($search_arr);

        $data = array();
        $no = $_POST['start'];
        if($list[0]['id'] != null){
            foreach ($list as $val) {

                $no++;

                $row = array();
                $row[] = $no;
                $row[] = $val['inv_no'];
                $row[] = $val['ticket_no'];
                $row[] = ucfirst($val['description']);
                $row[] = $val['warrenty'];
                $row[] = ($val['created_date'] != '') ? date('d-M-Y', strtotime($val['created_date'])) : '-';
                if ($val['status'] == 2) {
                    $status = '<span class="label label-danger">Pending</span>';
                } else {
                    $status = '<span class="label label-success">Completed</span>';
                }
                $row[] = $status;
                $data[] = $row;
            }
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->report_model->count_all_service($search_arr),
            "recordsFiltered" => $this->report_model->count_filtered_service($search_arr),
            "data" => $data,
            "total_service" => $list[0]['total_service'],
            "completed_service" => $list[0]['completed_service'],
            "pending_service" => $list[0]['pending_service'],
        );
        echo json_encode($output);
        exit;
    }

    function monthly_attendance_report() {
        $post_data = $this->input->post();

        $start_date = date('Y-m-01');
        $end_date = date('Y-m-d');
        if ($post_data != "") {
            if ($post_data['start_date'] != "") {
                $start_date = date('Y-m-d', strtotime($post_data['start_date']));
            }
            if ($post_data['end_date'] != "") {
                $end_date = date('Y-m-d', strtotime($post_data['end_date']));
            }
        }
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['employee'] = $this->report_model->get_all_employee_attendance();
        $data['monthly_reports'] = $this->report_model->get_all_monthly_reports($start_date, $end_date);

        $this->template->write_view('content', 'report/monthly_attendance_report', $data);
        $this->template->render();
    }

    function monthly_attendance_ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $search_arr = array();
        $search_arr['from_date'] = $search_data['start_date'];
        $search_arr['to_date'] = $search_data['end_date'];

        if (empty($search_arr)) {
            $search_arr = array();
        }

        $list = $this->report_model->get_monthly_attendance_datatables($search_arr);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $val) {

            $no++;

            $row = array();
            $row[] = $no;
            $row[] = $val['emp_code'];
            $row[] = $val['name'];
            foreach ($val['monthly_works'] as $key1 => $att_data) {
                $row[] = $att_data['month_attenance'];
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->report_model->count_all_monthly_attendance(),
            "recordsFiltered" => $this->report_model->count_filtered_monthly_attendance(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    function daily_cash_book_report() {
        $data = array();
        $data['all_category'] = $this->report_model->get_all_expense_cat();
        $this->template->write_view('content', 'report/daily_cash_book_report', $data);
        $this->template->render();
    }

    function daily_cash_book_ajaxList() {

        $search_data = array();
        $search_data = $this->input->post();
        $search_arr = array();
        $search_arr['category'] = $search_data['category'];

        if (empty($search_arr)) {
            $search_arr = array();
        }
        $list = $this->report_model->get_daily_cash_book_datatables($search_arr);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $val) {

            $no++;

            $row = array();
            $row[] = $no;

            $row[] = ($val['created_at'] != '') ? date('d-M-Y', strtotime($val['created_at'])) : '-';
            $row[] = ucfirst($val['remarks']);
            $row[] = ucfirst($val['category_name']);
            $exp_amount = number_format($val['exp_amount'] ? $val['exp_amount'] : '0.00', 2);
            if ($val['exp_mode'] == 'credit') {
                $row[] = '<span class="text-success">' . $exp_amount . '</span>';
            } else if ($val['exp_mode'] == 'debit') {
                $row[] = '<span class="text-danger">' . $exp_amount . '</span>';
            }
            if ($val['exp_mode'] == 'credit') {
                $mode = 'Income';
            } else if ($val['exp_mode'] == 'debit') {
                $mode = 'Expense';
            }
            $row[] = $mode;

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->report_model->count_all_daily_cash_book(),
            "recordsFiltered" => $this->report_model->count_filtered_daily_cash_book(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    function service_material_report() {
        $data = array();

        $this->template->write_view('content', 'report/service_material_report', $data);
        $this->template->render();
    }

    function service_material_ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $search_arr = array();
        $search_arr['from_date'] = $search_data['from_date'];
        $search_arr['to_date'] = $search_data['to_date'];

        if (empty($search_arr)) {
            $search_arr = array();
        }
        $list = $this->report_model->get_servcie_material_datatables($search_arr);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $val) {

            $no++;

            $row = array();
            $row[] = $no;
            $row[] = $val['dc_no'];
            $row[] = $val['invoice_no'];
            $row[] = $val['project'];
            $row[] = ucfirst($val['service_type']);
            $row[] = $val['total_qty'];
            $row[] = ($val['created_date'] != '') ? date('d-M-Y', strtotime($val['created_date'])) : '-';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->report_model->count_all_service_material(),
            "recordsFiltered" => $this->report_model->count_filtered_service_material(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
