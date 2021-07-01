<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Retun_report_model extends CI_Model {

    private $table_name1 = 'sales_order';
    private $erp_product = 'erp_product';
    private $customer = 'customer';
    private $erp_invoice = 'erp_invoice';
    private $erp_invoice_details = 'erp_invoice_details';
    private $erp_receipt_bill = 'erp_receipt_bill';
    private $payment_report = 'payment_report';
    var $joinTable2 = 'erp_category c';
    var $joinTable3 = 'erp_product p';

    function __construct() {
        parent::__construct();
    }

    public function get_all_invoice_list() {
        $this->db->select('tab_2.id as customer,tab_2.name,tab_2.state_id,tab_2.email_id,tab_1.id,tab_1.inv_id,tab_1.total_qty,tab_1.tax,tab_1.tax_label,'
                . 'tab_1.net_total,tab_1.created_date,tab_1.remarks,tab_1.subtotal_qty,tab_1.estatus,tab_1.customer_po');

        $this->db->join($this->erp_invoice_details . ' AS tab_3', 'tab_3.in_id = tab_1.id', 'LEFT');
        $this->db->join($this->customer . ' AS tab_2', 'tab_2.id = tab_1.customer', 'LEFT');

        $this->db->group_by('tab_1.id');
        $this->db->where('tab_1.estatus', 1);
        $this->db->where('tab_1.is_gst', 1);

        $query = $this->db->get($this->erp_invoice . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    public function get_all_customer() {
        $this->db->select('tab_1.*');

        $this->db->where('tab_1.status', 1);
        $query = $this->db->get($this->customer . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    public function get_all_product() {
        $productIds = array();
        $this->db->select('DISTINCT(product_id)');
        $product_query = $this->db->get('erp_invoice_details')->result_array();
        $productIds = array_map(function($product_query) {
            return $product_query['product_id'];
        }, $product_query);
        if (!empty($productIds))
            $this->db->where_in('id', $productIds);
        $this->db->where('erp_product.status', 1);
        $this->db->where('erp_product.is_deleted', 0);
        $query = $this->db->get($this->erp_product)->result_array();

        return $query;
    }

    function get_all_gstvalues() {
        $gst_values = array();
        $this->db->select('erp_invoice_details.tax, erp_invoice_details.gst');
        $this->db->distinct('erp_invoice_details.tax, erp_invoice_details.gst');
        $invoice_details_query = $this->db->get($this->erp_invoice_details)->result_array();
        if (!empty($invoice_details_query)) {
            foreach ($invoice_details_query as $value) {

                if (!in_array($value['tax'], $gst_values)) {
                    array_push($gst_values, $value['tax']);
                }
                if (!in_array($value['gst'], $gst_values)) {
                    array_push($gst_values, $value['gst']);
                }
            }
            $gst_values = array_filter($gst_values);
        }

        $this->db->select('erp_product.cgst, erp_product.sgst');
        $this->db->distinct('erp_product.cgst, erp_product.sgst');
        $this->db->where('erp_product.status', 1);

        $product_query = $this->db->get($this->erp_product)->result_array();
        if (!empty($product_query)) {
            foreach ($product_query as $value) {

                if (!in_array($value['cgst'], $gst_values)) {
                    array_push($gst_values, $value['cgst']);
                }
                if (!in_array($value['sgst'], $gst_values)) {
                    array_push($gst_values, $value['sgst']);
                }
            }
            $gst_values = array_filter($gst_values);
        }

        return $gst_values;
    }

    public function get_invoice_datatables($serch_data) {

        if (!empty($serch_data['from_date']))
            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
        if (!empty($serch_data['to_date']))
            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
        if ($serch_data['from_date'] == '1970-01-01')
            $serch_data['from_date'] = '';
        if ($serch_data['to_date'] == '1970-01-01')
            $serch_data['to_date'] = '';
        $invoiceIds = array();
        if (!empty($serch_data['gst']) && $serch_data['gst'] != '' && $serch_data['gst'] != 'Select GST') {
            $invoice_ids = array();
            $where_gst = '(erp_invoice_details.tax="' . $serch_data['gst'] . '" OR erp_invoice_details.gst = "' . $serch_data['gst'] . '")';

            $this->db->select('erp_invoice_details.*');
            $this->db->join('erp_invoice', 'erp_invoice_details.in_id=erp_invoice.id');
            $this->db->where('erp_invoice.estatus', 1);

            $this->db->where($where_gst);
            if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select Invoice ID') {
                $this->db->where($this->erp_invoice . '.inv_id', $serch_data['inv_id']);
            }
            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select Customer') {
                $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);
            }
            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }

            $invoices = $this->db->get('erp_invoice_details')->result_array();

            $inv_all_details = array();
            $count = 1;
            if (!empty($invoices)) {
                /* Search Particular products in that GST % From the Invoice */
                foreach ($invoices as $invoices_values) {
                    $invoice_id = $invoices_values['in_id'];
                    $tax = $invoices_values['tax'];
                    $per_cost = $invoices_values['per_cost'];
                    $quantity = $invoices_values['quantity'];
                    $gst = $invoices_values['gst'];
                    $cgst = ($tax / 100) * ($per_cost * $quantity);
                    $sgst = ($gst / 100) * ($per_cost * $quantity);
                    if (!isset($inv_all_details[$invoice_id]['quantity'])) {
                        $inv_all_details[$invoice_id]['in_id'] = $invoice_id;
                        $inv_all_details[$invoice_id]['quantity'] = $quantity;
                        $inv_all_details[$invoice_id]['cgst'] = $cgst;
                        $inv_all_details[$invoice_id]['sgst'] = $sgst;
                    } else {
                        $inv_all_details[$invoice_id]['quantity'] = $inv_all_details[$invoice_id]['quantity'] + $quantity;
                        $inv_all_details[$invoice_id]['cgst'] = $inv_all_details[$invoice_id]['cgst'] + ($cgst);
                        $inv_all_details[$invoice_id]['sgst'] = $inv_all_details[$invoice_id]['sgst'] + $sgst;
                    }
                }

                $invoiceIds = array_map(function($invoices) {
                    return $invoices['in_id'];
                }, $invoices);

                if (!empty($invoiceIds)) {

                    $invoiceIds = array_unique($invoiceIds);
                    $this->db->where_in($this->erp_invoice . '.id', $invoiceIds);
                } else {
                    $this->db->where($this->erp_invoice . '.id', -1);
                }
            } else {
                $this->db->where($this->erp_invoice . '.id', -1);
            }
        }

        if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select Invoice ID') {
            $this->db->where($this->erp_invoice . '.inv_id', $serch_data['inv_id']);
        }
        if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select Customer') {
            $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);
        }
        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        }

        $this->db->select('customer.id as customer,customer.name,customer.state_id, customer.name,customer.email_id,erp_invoice.id,erp_invoice.inv_id,erp_invoice.total_qty,erp_invoice.tax,erp_invoice.tax_label,'
                . 'erp_invoice.net_total,erp_invoice.created_date,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,erp_invoice.is_gst');



        $this->db->where('erp_invoice.estatus', 1);
        $this->db->where('erp_invoice.is_gst', 1);

        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $this->db->join('erp_invoice_details', 'erp_invoice_details.in_id=erp_invoice.id');
        $this->db->group_by('erp_invoice.id');

        $column_order = array(null, 'erp_invoice.inv_id', 'customer.name', 'erp_invoice.total_qty', null, null, 'erp_invoice.subtotal_qty', 'erp_invoice.net_total', null, null, null, null, null, null, null,);
        $column_search = array('customer.name', 'erp_invoice.inv_id', 'erp_invoice.net_total');
        $order = array('erp_invoice.id' => 'DESC');
        $i = 0;
        foreach ($column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $like = "" . $item . " LIKE '%" . $_POST['search']['value'] . "%'";
                    //$this->db->like($item, $_POST['search']['value']);
                } else {
                    //$query = $this->db->or_like($item, $_POST['search']['value']);
                    $like .= " OR " . $item . " LIKE '%" . $_POST['search']['value'] . "%'" . "";
                }
            }
            $i++;
        }
        if ($like) {
            $where = "(" . $like . " )";
            $this->db->where($where);
        }
        if (isset($_POST['order']) && $column_order[$_POST['order']['0']['column']] != null) { // here order processing
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }


        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_invoice')->result_array();



        $i = 0;
//        foreach ($query as $val) {
//            $this->db->select('*');
//            $this->db->where('j_id', intval($val['id']));
//            $this->db->where('type', 'invoice');
//            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();
//            $i++;
//        }
        $i2 = 0;
        foreach ($query as $val) {
            $this->db->select('SUM((tax / 100 ) * (per_cost * quantity)) as cgst, SUM((gst / 100 ) * (per_cost * quantity)) as sgst');
            $this->db->where('in_id', intval($val['id']));
            $query[$i2]['erp_invoice_details'] = $this->db->get('erp_invoice_details')->result_array();
            $i2++;
        }
        $j = 0;
//        foreach ($query as $val) {
//            $this->db->select('SUM(discount) AS receipt_discount, SUM(bill_amount) AS receipt_paid, erp_receipt_bill.due_date AS next_date, erp_receipt_bill.created_date AS paid_date');
//            $this->db->where('erp_receipt_bill.receipt_id', $val['id']);
//            $query[$j]['receipt_bill'] = $this->db->get('erp_receipt_bill')->result_array();
//            $j++;
//        }
        if (!empty($inv_all_details) && !empty($query)) {
            $query['inv_all_details'] = $inv_all_details;
        }

        $k = 0;
        foreach ($query as $val) {

//            $this->db->Select('SUM(return_amount) as return_amount');
//            $this->db->where('inv_id', $val['id']);
//            $return_details = $this->db->get('sales_return_details')->result_array();
//
//
            $query[$k]['return_amt'] = $return_details[0]['return_amount'];
//            $this->db->select('SUM(discount) AS receipt_discount, SUM(bill_amount) AS receipt_paid, erp_receipt_bill.due_date AS next_date,erp_receipt_bill.created_date AS paid_date');
//            $this->db->where('erp_receipt_bill.receipt_id', $val['id']);
//            $query[$k]['receipt_bill'] = $this->db->get('erp_receipt_bill')->result_array();
//            $this->db->select('total_qty, subtotal_qty, id, net_total');
//            $this->db->where('invoice_id', $val['id']);
//            $this->db->order_by("id", "desc");
//            $this->db->limit(1);
//            $query[$k]['return'] = $this->db->get('erp_sales_return')->result_array();
//            $this->db->select('total_qty, subtotal_qty, id, net_total');
//            $this->db->where('invoice_id', $val['id']);
//            $this->db->order_by("id", "asc");
//            $this->db->limit(1);
//            $value = $this->db->get('erp_sales_return')->result_array();
            array_push($query[$k]['return'], $value[0]);

            $k++;
        }

        return $query;
    }

    public function count_all_invoice() {
        $this->db->where('erp_invoice.estatus', 1);

        $this->db->from('erp_invoice');
        return $this->db->count_all_results();
    }

    public function count_filtered_invoice($serch_data) {
        if (!empty($serch_data['from_date']))
            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
        if (!empty($serch_data['to_date']))
            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
        if ($serch_data['from_date'] == '1970-01-01')
            $serch_data['from_date'] = '';
        if ($serch_data['to_date'] == '1970-01-01')
            $serch_data['to_date'] = '';
        $invoiceIds = array();
        if (!empty($serch_data['gst']) && $serch_data['gst'] != '' && $serch_data['gst'] != 'Select GST') {
            $invoice_ids = array();
            $where_gst = '(erp_invoice_details.tax = "' . $serch_data['gst'] . '" OR erp_invoice_details.gst = "' . $serch_data['gst'] . '")';
            //$this->db->select('erp_invoice.id');
            $this->db->select('erp_invoice_details.*');
            $this->db->join('erp_invoice', 'erp_invoice_details.in_id = erp_invoice.id');
            $this->db->where('erp_invoice.estatus', 1);
            $this->db->where('erp_invoice.is_gst', 1);
            $this->db->where($where_gst);
            if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select Invoice ID') {
                $this->db->where($this->erp_invoice . '.inv_id', $serch_data['inv_id']);
            }
            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select Customer') {
                $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);
            }
            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }

            $invoices = $this->db->get('erp_invoice_details')->result_array();

            $inv_all_details = array();
            $count = 1;
            if (!empty($invoices)) {
                /* Search Particular products in that GST % From the Invoice */
                foreach ($invoices as $invoices_values) {
                    $invoice_id = $invoices_values['in_id'];
                    $tax = $invoices_values['tax'];
                    $per_cost = $invoices_values['per_cost'];
                    $quantity = $invoices_values['quantity'];
                    $gst = $invoices_values['gst'];
                    $cgst = ($tax / 100) * ($per_cost * $quantity);
                    $sgst = ($gst / 100) * ($per_cost * $quantity);
                    if (!isset($inv_all_details[$invoice_id]['quantity'])) {
                        $inv_all_details[$invoice_id]['in_id'] = $invoice_id;
                        $inv_all_details[$invoice_id]['quantity'] = $quantity;
                        $inv_all_details[$invoice_id]['cgst'] = $cgst;
                        $inv_all_details[$invoice_id]['sgst'] = $sgst;
                    } else {
                        $inv_all_details[$invoice_id]['quantity'] = $inv_all_details[$invoice_id]['quantity'] + $quantity;
                        $inv_all_details[$invoice_id]['cgst'] = $inv_all_details[$invoice_id]['cgst'] + ($cgst);
                        $inv_all_details[$invoice_id]['sgst'] = $inv_all_details[$invoice_id]['sgst'] + $sgst;
                    }
                }

                $invoiceIds = array_map(function($invoices) {
                    return $invoices['in_id'];
                }, $invoices);

                if (!empty($invoiceIds)) {

                    $invoiceIds = array_unique($invoiceIds);
                    $this->db->where_in($this->erp_invoice . '.id', $invoiceIds);
                } else {
                    $this->db->where($this->erp_invoice . '.id', -1);
                }
            } else {
                $this->db->where($this->erp_invoice . '.id', -1);
            }
        }

        if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select Invoice ID') {
            $this->db->where($this->erp_invoice . '.inv_id', $serch_data['inv_id']);
        }
        if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select Customer') {
            $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);
        }
        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        }

        $this->db->select('customer.id as customer, customer.name, customer.state_id, customer.name, customer.email_id,  erp_invoice.id, erp_invoice.inv_id, erp_invoice.total_qty, erp_invoice.tax, erp_invoice.tax_label, '
                . 'erp_invoice.net_total, erp_invoice.created_date, erp_invoice.remarks, erp_invoice.subtotal_qty, erp_invoice.estatus, erp_invoice.customer_po');



        $this->db->where('erp_invoice.estatus', 1);
        $this->db->where('erp_invoice.is_gst', 1);
        $this->db->join('customer', 'customer.id = erp_invoice.customer');

        $this->db->join('erp_invoice_details', 'erp_invoice_details.in_id = erp_invoice.id');
        $this->db->group_by('erp_invoice.id');
        $query = $this->db->get('erp_invoice');
        return $query->num_rows();
    }

    public function get_invoice($serch_data) {

        if (!empty($serch_data['from_date']))
            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
        if (!empty($serch_data['to_date']))
            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
        if ($serch_data['from_date'] == '1970-01-01')
            $serch_data['from_date'] = '';
        if ($serch_data['to_date'] == '1970-01-01')
            $serch_data['to_date'] = '';
        $invoiceIds = array();
        if (!empty($serch_data['gst']) && $serch_data['gst'] != '' && $serch_data['gst'] != 'Select GST') {
            $invoice_ids = array();
            $where_gst = '(erp_invoice_details.tax = "' . $serch_data['gst'] . '" OR erp_invoice_details.gst = "' . $serch_data['gst'] . '")';

            $this->db->select('erp_invoice_details.*');
            $this->db->join('erp_invoice', 'erp_invoice_details.in_id = erp_invoice.id');
            $this->db->where('erp_invoice.estatus', 1);
            $this->db->where('erp_invoice.is_gst', 1);

            $this->db->where($where_gst);
            if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select Invoice ID') {
                $this->db->where($this->erp_invoice . '.inv_id', $serch_data['inv_id']);
            }
            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select Customer') {
                $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);
            }
            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }

            $invoices = $this->db->get('erp_invoice_details')->result_array();


            $inv_all_details = array();
            $count = 1;
            if (!empty($invoices)) {
                /* Search Particular products in that GST % From the Invoice */
                foreach ($invoices as $invoices_values) {
                    $invoice_id = $invoices_values['in_id'];
                    $tax = $invoices_values['tax'];
                    $per_cost = $invoices_values['per_cost'];
                    $quantity = $invoices_values['quantity'];
                    $gst = $invoices_values['gst'];
                    $cgst = ($tax / 100) * ($per_cost * $quantity);
                    $sgst = ($gst / 100) * ($per_cost * $quantity);
                    if (!isset($inv_all_details[$invoice_id]['quantity'])) {
                        $inv_all_details[$invoice_id]['in_id'] = $invoice_id;
                        $inv_all_details[$invoice_id]['quantity'] = $quantity;
                        $inv_all_details[$invoice_id]['cgst'] = $cgst;
                        $inv_all_details[$invoice_id]['sgst'] = $sgst;
                    } else {
                        $inv_all_details[$invoice_id]['quantity'] = $inv_all_details[$invoice_id]['quantity'] + $quantity;
                        $inv_all_details[$invoice_id]['cgst'] = $inv_all_details[$invoice_id]['cgst'] + ($cgst);
                        $inv_all_details[$invoice_id]['sgst'] = $inv_all_details[$invoice_id]['sgst'] + $sgst;
                    }
                }

                $invoiceIds = array_map(function($invoices) {
                    return $invoices['in_id'];
                }, $invoices);

                if (!empty($invoiceIds)) {

                    $invoiceIds = array_unique($invoiceIds);
                    $this->db->where_in($this->erp_invoice . '.id', $invoiceIds);
                } else {
                    $this->db->where($this->erp_invoice . '.id', -1);
                }
            } else {
                $this->db->where($this->erp_invoice . '.id', -1);
            }
        }

        if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select Invoice ID') {
            $this->db->where($this->erp_invoice . '.inv_id', $serch_data['inv_id']);
        }
        if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select Customer') {
            $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);
        }
        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        }

        $this->db->select('customer.id as customer, customer.name,  customer.state_id,  customer.email_id, erp_invoice.id, erp_invoice.inv_id, erp_invoice.total_qty, erp_invoice.tax, erp_invoice.tax_label, '
                . 'erp_invoice.net_total, erp_invoice.created_date, erp_invoice.remarks, erp_invoice.subtotal_qty, erp_invoice.estatus, erp_invoice.customer_po');

        $this->db->where('erp_invoice.estatus', 1);


        $this->db->join('customer', 'customer.id = erp_invoice.customer');
        $this->db->join('erp_invoice_details', 'erp_invoice_details.in_id = erp_invoice.id');
        $this->db->group_by('erp_invoice.id');
        $this->db->order_by('erp_invoice.id', 'desc');
        $query = $this->db->get('erp_invoice')->result_array();


        $i = 0;
//        foreach ($query as $val) {
//            $this->db->select('*');
//            $this->db->where('j_id', intval($val['id']));
//            $this->db->where('type', 'invoice');
//            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();
//            $i++;
//        }



        $i2 = 0;
        foreach ($query as $val) {
            $this->db->select('SUM((tax / 100 ) * (per_cost * quantity)) as cgst, SUM((gst / 100 ) * (per_cost * quantity)) as sgst');
            $this->db->where('in_id', intval($val['id']));
            $query[$i2]['erp_invoice_details'] = $this->db->get('erp_invoice_details')->result_array();
            $i2++;
        }



        $j = 0;
//        foreach ($query as $val) {
//            $this->db->select('SUM(discount) AS receipt_discount, SUM(bill_amount) AS receipt_paid, MAX(due_date) AS next_date, MAX(created_date) AS paid_date');
//            $this->db->where('erp_receipt_bill.receipt_id', $val['id']);
//            $query[$j]['receipt_bill'] = $this->db->get('erp_receipt_bill')->result_array();
//            $j++;
//        }

        if (!empty($inv_all_details) && !empty($query)) {
            $query['inv_all_details'] = $inv_all_details;
        }

        $k = 0;
        foreach ($query as $val) {

//            $this->db->Select('SUM(return_amount) as return_amount');
//            $this->db->where('inv_id', $val['id']);
//            $return_details = $this->db->get('sales_return_details')->result_array();
//
//
            $query[$k]['return_amt'] = $return_details[0]['return_amount'];
//            $this->db->select('SUM(discount) AS receipt_discount, SUM(bill_amount) AS receipt_paid, MAX(due_date) AS next_date');
//            $this->db->where('erp_receipt_bill.receipt_id', $val['id']);
//            $query[$k]['receipt_bill'] = $this->db->get('erp_receipt_bill')->result_array();
//            $this->db->select('total_qty, subtotal_qty, id, net_total');
//            $this->db->where('invoice_id', $val['id']);
//            $this->db->order_by("id", "desc");
//            $this->db->limit(1);
//            $query[$k]['return'] = $this->db->get('erp_sales_return')->result_array();
            //$query[$i]['return'] = 0;
            //  echo $this->db->last_query();
            //  echo '<br> ----------------------------------<br>';
//            $this->db->select('total_qty, subtotal_qty, id, net_total');
//            $this->db->where('invoice_id', $val['id']);
//            $this->db->order_by("id", "asc");
//            $this->db->limit(1);
//            $value = $this->db->get('erp_sales_return')->result_array();
            array_push($query[$k]['return'], $value[0]);
            // array_push($query[$i]['return'], 0);
            $k++;
            // echo $this->db->last_query() . '<br />';
        }

        return $query;
    }

    public function get_invoice_report($serch_data = array()) {

        if ($serch != NULL && $serch != '') {
            $serch_data['inv_id'] = $serch[0]->inv_id;
            $serch_data['customer'] = $serch[1]->customer;
            $serch_data['product'] = $serch[2]->product;
            $serch_data['driver'] = $serch[3]->driver;
            $serch_data['vehicle'] = $serch[4]->vehicle_no;
            $serch_data['from_date'] = $serch[5]->from;
            $serch_data['to_date'] = $serch[6]->to;
            $serch_data['overdue'] = $serch[7]->overdue;
            $serch_data['gst_sales_report'] = $serch[8]->gst_sales_report;
        }

        if (!empty($serch_data['from_date']))
            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
        if (!empty($serch_data['to_date']))
            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
        if ($serch_data['from_date'] == '1970-01-01')
            $serch_data['from_date'] = '';
        if ($serch_data['to_date'] == '1970-01-01')
            $serch_data['to_date'] = '';
        $invoiceIds = array();
        if (!empty($serch_data['gst']) && $serch_data['gst'] != '' && $serch_data['gst'] != 'Select GST') {
            $invoice_ids = array();
            $where_gst = '(erp_invoice_details.tax = "' . $serch_data['gst'] . '" OR erp_invoice_details.gst = "' . $serch_data['gst'] . '")';

            $this->db->select('erp_invoice_details.*');
            $this->db->join('erp_invoice', 'erp_invoice_details.in_id = erp_invoice.id');
            $this->db->where('erp_invoice.estatus', 1);
            $this->db->where('erp_invoice.is_gst', 1);

            $this->db->where($where_gst);
            if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select Invoice ID') {
                $this->db->where($this->erp_invoice . '.inv_id', $serch_data['inv_id']);
            }
            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select Customer') {
                $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);
            }
            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }

            $invoices = $this->db->get('erp_invoice_details')->result_array();


            $inv_all_details = array();
            $count = 1;
            if (!empty($invoices)) {
                /* Search Particular products in that GST % From the Invoice */
                foreach ($invoices as $invoices_values) {
                    $invoice_id = $invoices_values['in_id'];
                    $tax = $invoices_values['tax'];
                    $per_cost = $invoices_values['per_cost'];
                    $quantity = $invoices_values['quantity'];
                    $gst = $invoices_values['gst'];
                    $cgst = ($tax / 100) * ($per_cost * $quantity);
                    $sgst = ($gst / 100) * ($per_cost * $quantity);
                    if (!isset($inv_all_details[$invoice_id]['quantity'])) {
                        $inv_all_details[$invoice_id]['in_id'] = $invoice_id;
                        $inv_all_details[$invoice_id]['quantity'] = $quantity;
                        $inv_all_details[$invoice_id]['cgst'] = $cgst;
                        $inv_all_details[$invoice_id]['sgst'] = $sgst;
                    } else {
                        $inv_all_details[$invoice_id]['quantity'] = $inv_all_details[$invoice_id]['quantity'] + $quantity;
                        $inv_all_details[$invoice_id]['cgst'] = $inv_all_details[$invoice_id]['cgst'] + ($cgst);
                        $inv_all_details[$invoice_id]['sgst'] = $inv_all_details[$invoice_id]['sgst'] + $sgst;
                    }
                }

                $invoiceIds = array_map(function($invoices) {
                    return $invoices['in_id'];
                }, $invoices);

                if (!empty($invoiceIds)) {

                    $invoiceIds = array_unique($invoiceIds);
                    $this->db->where_in($this->erp_invoice . '.id', $invoiceIds);
                } else {
                    $this->db->where($this->erp_invoice . '.id', -1);
                }
            } else {
                $this->db->where($this->erp_invoice . '.id', -1);
            }
        }

        if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select') {
            $this->db->where($this->erp_invoice . '.inv_id', $serch_data['inv_id']);
        }
        if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select Customer') {
            $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);
        }
        if (!empty($serch_data['driver']) && $serch_data['driver'] != 'Select') {
            $this->db->where($this->erp_invoice . '.driver', $serch_data['driver']);
        }
        if (!empty($serch_data['vehicle']) && $serch_data['vehicle'] != 'Select') {
            $this->db->where($this->erp_invoice . '.vehicle_no', $serch_data['vehicle']);
        }
        if (!empty($serch_data['product']) && $serch_data['product'] != 'Select') {
            $this->db->where($this->erp_invoice_details . '.product_id', $serch_data['product']);
        }
        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        }

        $this->db->select('customer.id as customer, customer.name,customer.state_id,  customer.email_id,  erp_invoice.id, erp_invoice.inv_id, erp_invoice.total_qty, erp_invoice.tax, erp_invoice.tax_label, '
                . 'erp_invoice.net_total, erp_invoice.created_date, erp_invoice.remarks, erp_invoice.subtotal_qty, erp_invoice.estatus, erp_invoice.customer_po');

        $this->db->where('erp_invoice.estatus', 1);
        $this->db->where('erp_invoice.is_gst', 1);

        $this->db->join('customer', 'customer.id = erp_invoice.customer');
        $this->db->join('erp_invoice_details', 'erp_invoice_details.in_id = erp_invoice.id');
        $this->db->order_by('erp_invoice.id', 'desc');
        $this->db->group_by('erp_invoice.id');

        $query = $this->db->get('erp_invoice')->result_array();




        $i = 0;
//        foreach ($query as $val) {
//            $this->db->select('*');
//            $this->db->where('j_id', intval($val['id']));
//            $this->db->where('type', 'invoice');
//            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();
//            $i++;
//        }



        $i2 = 0;
        foreach ($query as $val) {
            $this->db->select('SUM((tax / 100 ) * (per_cost * quantity)) as cgst, SUM((gst / 100 ) * (per_cost * quantity)) as sgst');
            $this->db->where('in_id', intval($val['id']));
            $query[$i2]['erp_invoice_details'] = $this->db->get('erp_invoice_details')->result_array();
            $i2++;
        }



        $j = 0;
//        foreach ($query as $val) {
//            $this->db->select('SUM(discount) AS receipt_discount, SUM(bill_amount) AS receipt_paid, MAX(due_date) AS next_date, MAX(created_date) AS paid_date');
//            $this->db->where('erp_receipt_bill.receipt_id', $val['id']);
//            $query[$j]['receipt_bill'] = $this->db->get('erp_receipt_bill')->result_array();
//            $j++;
//        }

        if (!empty($inv_all_details) && !empty($query)) {
            $query['inv_all_details'] = $inv_all_details;
        }

        $k = 0;
        foreach ($query as $val) {

//            $this->db->Select('SUM(return_amount) as return_amount');
//            $this->db->where('inv_id', $val['id']);
//            $return_details = $this->db->get('sales_return_details')->result_array();
//
//
            $query[$k]['return_amt'] = $return_details[0]['return_amount'];
//            $this->db->select('SUM(discount) AS receipt_discount, SUM(bill_amount) AS receipt_paid, MAX(due_date) AS next_date');
//            $this->db->where('erp_receipt_bill.receipt_id', $val['id']);
//            $query[$k]['erp_receipt_bill'] = $this->db->get('erp_receipt_bill')->result_array();
//            $this->db->select('total_qty, subtotal_qty, id, net_total');
//            $this->db->where('invoice_id', $val['id']);
//            $this->db->order_by("id", "desc");
//            $this->db->limit(1);
//            $query[$k]['return'] = $this->db->get('erp_sales_return')->result_array();
            //$query[$i]['return'] = 0;
            //  echo $this->db->last_query();
            //  echo '<br> ----------------------------------<br>';
//            $this->db->select('total_qty, subtotal_qty, id, net_total');
//            $this->db->where('invoice_id', $val['id']);
//            $this->db->order_by("id", "asc");
//            $this->db->limit(1);
//            $value = $this->db->get('erp_sales_return')->result_array();
            array_push($query[$k]['return'], $value[0]);
            // array_push($query[$i]['return'], 0);
            $k++;
            // echo $this->db->last_query() . '<br />';
        }

        return $query;
    }

}
