<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gst_return_report extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }

        $main_module = 'report';
        $access_arr = array(
            'gst_return_report/index' => array('add', 'edit', 'delete', 'view'),
            'gst_return_report/invoice_ajaxList' => 'no_restriction',
            'gst_return_report/invoice_search_result' => 'no_restriction',
            'gst_return_report/inv_excel_report' => 'no_restriction'
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            $this->user_auth->is_permission_allowed();
            redirect($this->config->item('base_url'));
        }



        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->database();
        $this->load->library('form_validation');

        $this->load->model('report/retun_report_model');
    }

    function index() {

        $data['all_inv'] = $this->retun_report_model->get_all_invoice_list();
        $data['all_supplier'] = $this->retun_report_model->get_all_customer();
        $all_gst = $this->retun_report_model->get_all_gstvalues();
        $gst = array();
        $data['all_gst'] = array();
        if (!empty($all_gst)) {
            $data['all_gst'] = $all_gst;
        }
        $this->template->write_view('content', 'report/gst_return_report', $data);
        $this->template->render();
    }

    function invoice_ajaxList() {
        $search_data = $this->input->post();


        $search_arr = array();
        $search_arr['from_date'] = $search_data['from_date'];
        $search_arr['to_date'] = $search_data['to_date'];
        $search_arr['inv_id'] = $search_data['inv_id'];
        $search_arr['customer'] = $search_data['customer'];

        $search_arr['gst'] = $search_data['gst'];

        if (empty($search_arr)) {
            $search_arr = array();
        }
        $list = $this->retun_report_model->get_invoice_datatables($search_arr);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $val) {
            if ($val['credit_days'] > 0 && $val['created_date'] != '1970-01-01') {
                $due_date = date('d-M-Y', strtotime($val['created_date'] . "+" . $val['credit_days'] . " days"));
            } else {
                $due_date = '-';
            }
            ?>

            <?php

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val['inv_id'];
            $row[] = ucfirst($val['name']);
            $row[] = round($val['total_qty']);
            $row[] = number_format(($val['erp_invoice_details'][0]['cgst']), 2);
            $row[] = number_format(($val['erp_invoice_details'][0]['sgst']), 2);
            $row[] = number_format($val['subtotal_qty'], 2);
            $row[] = number_format($val['net_total'], 2);
//            $row[] = number_format(($val['receipt_bill'][0]['receipt_paid']) + $val['advance'], 2, '.', ',');
//            $row[] = number_format($val['return_amt'], 2, '.', ',');
            $paid_amount = $val['net_total'] - $val['return_amt'];
            $received_amt = round($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'] + $val['advance'], 2);
            $balance_amt = number_format($paid_amount - ($received_amt), 2, '.', ',');
//            $row[] = $balance_amt;
            $row[] = ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '';
//            $row[] = ($val['receipt_bill'][0]['paid_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['paid_date'])) : '-';
//            $row[] = $val['credit_days'] > 0 ? $val['credit_days'] : '-';
//            $row[] = $due_date;
//            $row[] = ($val['receipt_bill'][0]['next_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['next_date'])) : '-';
//            $row[] = ($val['credit_limit'] != '') ? $val['credit_limit'] : '-';
//            $row[] = ($val['exceeded_limit'] != '') ? $val['exceeded_limit'] : '-';
            $row[] = ucfirst($val['driver_name']);
            $row[] = $val['vehicle_no'];
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->retun_report_model->count_all_invoice(),
            "recordsFiltered" => $this->retun_report_model->count_filtered_invoice($search_data),
            "data" => $data,
        );

        echo json_encode($output);
        exit;
    }

    public function invoice_search_result() {
        $search_data = $this->input->get();
        $data['search_data'] = $search_data;
        $data['quotation'] = $this->retun_report_model->get_invoice($search_data);


        $this->load->view('report/gst_return_search_list', $data);
    }

    function inv_excel_report() {
        if (isset($_GET) && $_GET['search'] != '') {
            $search = $_GET['search'];
        } else {
            $search = '';
        }
        $json = json_decode($search);
        $inv = $this->retun_report_model->get_invoice_report($json);
        $this->export_all_inv_csv($inv);
    }

    function export_all_inv_csv($query, $timezones = array()) {
        // output headers so that the file is downloaded rather than displayed

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=GST Invoice Report.csv');



        // create a file pointer connected to the output stream

        $output = fopen('php://output', 'w');
        // output the column headings
        //Order has been changes

        fputcsv($output, array('S.No', 'Invoice Id', 'Customer Name', 'Total Qty', 'CGST', 'SGST', 'Sub Total', 'Invoice Amt', 'Invoice Date', 'Driver', 'Vehicle'));
        // fetch the data
        //$rows = mysql_query($query);
        // loop over the rows, outputting them

        foreach ($query as $key => $val) {
            if ($val['credit_days'] > 0 && $val['created_date'] != '1970-01-01') {
                $due_date = date('d-M-Y', strtotime($val['created_date'] . "+" . $val['credit_days'] . " days"));
            } else {
                $due_date = '-';
            }
            $row = array($key + 1, $val['inv_id'], ucfirst($val['name']), round($val['total_qty']), number_format(($val['erp_invoice_details'][0]['cgst']), 2), number_format(($val['erp_invoice_details'][0]['sgst']), 2), number_format($val['subtotal_qty'], 2), number_format($val['net_total'], 2), ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : '', ucfirst($val['driver_name']), $val['vehicle_no']);
            fputcsv($output, $row);
        }
        exit;
    }

    function clear_cache() {
        $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
        $this->output->set_header("Pragma: no-cache");
    }

}
