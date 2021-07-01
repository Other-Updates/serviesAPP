<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Admin_model
 *
 * This model represents admin access. It operates the following tables:
 * admin,
 *
 * @package	i2_soft
 * @author	Elavarasan
 */
class Admin_model extends CI_Model {

    private $table_name = 'admin';
    private $table_name1 = 'company_details';
    private $table_name2 = 'po';
    private $table_name3 = 'sales_order';
    private $table_name4 = 'package';
    private $table_name5 = 'invoice';
    private $erp_user = 'erp_user';
    private $agent_user = 'agent';
    private $erp_company_amount = 'erp_company_amount';
    private $erp_email_settings = 'erp_email_settings';
    private $erp_invoice = 'erp_invoice';
    private $erp_service = 'erp_service';
    private $erp_balance_sheet = 'erp_balance_sheet';
    private $company_details = 'company_details';

    function __construct() {
        parent::__construct();
        date_default_timezone_set("Asia/Calcutta");
    }

    public function get_user_by_login($username, $password) {
        $this->db->select('tab_1.*');
        $this->db->where('username', $username);
        $this->db->where('password', md5($password));
        $query = $this->db->get($this->erp_user . ' AS tab_1');
        if ($query->num_rows() >= 1) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    public function login($data) {

        $this->db->select('username,id,role');
        $this->db->where('username', $data['username']);
        $this->db->where('password', md5($data['password']));
        $query = $this->db->get($this->erp_user);
        if ($query->num_rows() >= 1) {

            return $query->result_array();
        } else {
            $this->db->select('username,id,role');
            $this->db->where('username', $data['username']);
            $this->db->where('password', md5($data['password']));
            $query1 = $this->db->get($this->agent_user);
            if ($query1->num_rows() >= 0) {
                return $query1->result_array();
            }
        }

        return false;
    }

    public function get_admin($role, $id) {

        $this->db->select('*');
        $this->db->where('role', $role);
        $this->db->where('id', $id);
        $query = $this->db->get($this->erp_user);
        if ($query->num_rows() >= 1) {

            return $query->result_array();
        } else {
            $this->db->select('*');
            $this->db->where('role', $role);
            $this->db->where('id', $id);
            $query1 = $this->db->get($this->agent_user);

            if ($query1->num_rows() >= 0) {
                return $query1->result_array();
            }
        }

        return false;
    }

    function update_profile($data, $role, $id) {

        $this->db->where('id', $id);
        $this->db->where('role', $role);
        $this->db->update($this->erp_user, $data);
        $this->db->where('id', $id);
        $this->db->where('role', $role);
        $this->db->update($this->agent_user, $data);
    }

    function insert_company_details($data) {
        $this->db->where('id', 1);
        if ($this->db->update($this->table_name1, $data)) {

            return true;
        }
        return false;
    }

    function get_company_details() {
        $this->db->select('*');
        $query = $this->db->get($this->table_name1)->result_array();
        return $query;
    }

    function get_company_amount() {
        $this->db->select('value');
        $this->db->where("(type='company_amount')");
        $query = $this->db->get($this->erp_email_settings)->result_array();
        return $query;
    }

    function update_company_amount($data) {
        $update_array = array('value' => $data);
        $this->db->where("type", "company_amount");
        if ($this->db->update($this->erp_email_settings, $update_array)) {
            return true;
        }
        return false;
    }

    function amount_credit() {
        $this->db->select('SUM(bill_amount) as credit');
        $this->db->where($this->erp_company_amount . '.type', 1);
        $this->db->where($this->erp_company_amount . '.recevier', 1);
        $query = $this->db->get($this->erp_company_amount)->result_array();
        return $query;
    }

    function amount_debit() {
        $this->db->select('SUM(bill_amount) as debit');
        $this->db->where($this->erp_company_amount . '.type', 2);
        $this->db->where($this->erp_company_amount . '.recevier', 1);
        $query = $this->db->get($this->erp_company_amount)->result_array();
        return $query;
    }

    function amount_credit_agent($id) {
        $this->db->select('SUM(bill_amount) as credit');
        $this->db->where($this->erp_company_amount . '.type', 1);
        $this->db->where($this->erp_company_amount . '.recevier', 2);
        $this->db->where($this->erp_company_amount . '.recevier_id', $id);
        $query = $this->db->get($this->erp_company_amount)->result_array();
        return $query;
    }

    function amount_debit_agent($id) {
        $this->db->select('SUM(bill_amount) as debit');
        $this->db->where($this->erp_company_amount . '.type', 2);
        $this->db->where($this->erp_company_amount . '.recevier', 2);
        $this->db->where($this->erp_company_amount . '.recevier_id', $id);
        $query = $this->db->get($this->erp_company_amount)->result_array();
        return $query;
    }

    function amount_credit_agent_all() {
        $this->db->select('SUM(bill_amount) as credit');
        $this->db->where($this->erp_company_amount . '.type', 1);
        $this->db->where($this->erp_company_amount . '.recevier', 2);
        $query = $this->db->get($this->erp_company_amount)->result_array();
        return $query;
    }

    function amount_debit_agent_all() {
        $this->db->select('SUM(bill_amount) as debit');
        $this->db->where($this->erp_company_amount . '.type', 2);
        $this->db->where($this->erp_company_amount . '.recevier', 2);
        $query = $this->db->get($this->erp_company_amount)->result_array();
        return $query;
    }

    function get_agent_cash($id) {
        $this->db->select('SUM(bill_amount) as credit');
        $this->db->where($this->erp_company_amount . '.recevier_id', $id);
        $this->db->where($this->erp_company_amount . '.type', 1);
        $this->db->where($this->erp_company_amount . '.recevier', 2);
        $query = $this->db->get($this->erp_company_amount)->result_array();
        return $query;
    }

    function get_cash() {
        $this->db->select('SUM(bill_amount) as cash');
        $this->db->where("(receiver_type='Advance Amount')");
        $this->db->where($this->erp_company_amount . '.type', 1);
        $query = $this->db->get($this->erp_company_amount)->result_array();
        return $query;
    }

    function get_purchase_cost() {
        $this->db->select('SUM(bill_amount) as purchase_cost');
        $this->db->where("(receiver_type='Purchase Cost')");
        $this->db->where($this->erp_company_amount . '.type', 2);
        $query = $this->db->get($this->erp_company_amount)->result_array();
        return $query;
    }

    function get_agent_debit($id) {
        $this->db->select('SUM(bill_amount) as debit');
        $this->db->where($this->erp_company_amount . '.recevier_id', $id);
        $this->db->where($this->erp_company_amount . '.type', 2);
        $this->db->where($this->erp_company_amount . '.recevier', 2);
        $query = $this->db->get($this->erp_company_amount)->result_array();
        return $query;
    }

    function get_purchase_report($from_date, $to_date) {
        $this->db->select('SUM(full_total) AS total_qty,SUM(net_total) AS total_val');
        $this->db->where("DATE_FORMAT(" . $this->table_name2 . ".inv_date,'%Y-%m-%d') >='" . $from_date . "' AND DATE_FORMAT(" . $this->table_name2 . ".inv_date,'%Y-%m-%d') <= '" . $to_date . "'");
        $this->db->where($this->table_name2 . '.status', 1);
        $this->db->where($this->table_name2 . '.df', 0);
        $query = $this->db->get($this->table_name2)->result_array();

        $current_day = date("N");
        $days_to_friday = 7 - $current_day;
        $days_from_monday = $current_day - 1;
        $monday = date("Y-m-d", strtotime("- {$days_from_monday} Days"));
        $sunday = date("Y-m-d", strtotime("+ {$days_to_friday} Days"));

        $this->db->select('SUM(net_total) AS this_week_total_val');
        $this->db->where("DATE_FORMAT(" . $this->table_name2 . ".inv_date,'%Y-%m-%d') >='" . $monday . "' AND DATE_FORMAT(" . $this->table_name2 . ".inv_date,'%Y-%m-%d') <= '" . $sunday . "'");
        $this->db->where($this->table_name2 . '.status', 1);
        $this->db->where($this->table_name2 . '.df', 0);
        $query['last_week'] = $this->db->get($this->table_name2)->result_array();
        return $query;
    }

    function get_sales_report($from_date, $to_date) {
        $this->db->select('SUM(full_total) AS total_qty,SUM(net_final_total) AS total_val');
        $this->db->where("DATE_FORMAT(" . $this->table_name3 . ".inv_date,'%Y-%m-%d') >='" . $from_date . "' AND DATE_FORMAT(" . $this->table_name3 . ".inv_date,'%Y-%m-%d') <= '" . $to_date . "'");
        $this->db->where($this->table_name3 . '.status', 1);
        $this->db->where($this->table_name3 . '.df', 0);
        $query = $this->db->get($this->table_name3)->result_array();

        $current_day = date("N");
        $days_to_friday = 7 - $current_day;
        $days_from_monday = $current_day - 1;
        $monday = date("Y-m-d", strtotime("- {$days_from_monday} Days"));
        $sunday = date("Y-m-d", strtotime("+ {$days_to_friday} Days"));

        $this->db->select('SUM(net_final_total) AS this_week_total_val');
        $this->db->where("DATE_FORMAT(" . $this->table_name3 . ".inv_date,'%Y-%m-%d') >='" . $monday . "' AND DATE_FORMAT(" . $this->table_name3 . ".inv_date,'%Y-%m-%d') <= '" . $sunday . "'");
        $this->db->where($this->table_name3 . '.status', 1);
        $this->db->where($this->table_name3 . '.df', 0);
        $query['last_week'] = $this->db->get($this->table_name3)->result_array();
        return $query;
    }

    function get_package_report($from_date, $to_date) {
        $this->db->select('SUM(total_value) AS total_qty');
        $this->db->where("DATE_FORMAT(" . $this->table_name5 . ".add_date,'%Y-%m-%d') >='" . $from_date . "' AND DATE_FORMAT(" . $this->table_name5 . ".add_date,'%Y-%m-%d') <= '" . $to_date . "'");
        $this->db->where($this->table_name5 . '.status', 1);
        $query = $this->db->get($this->table_name5)->result_array();

        $current_day = date("N");
        $days_to_friday = 7 - $current_day;
        $days_from_monday = $current_day - 1;
        $monday = date("Y-m-d", strtotime("- {$days_from_monday} Days"));
        $sunday = date("Y-m-d", strtotime("+ {$days_to_friday} Days"));

        $this->db->select('SUM(total_value) AS this_week_total_val');
        $this->db->where("DATE_FORMAT(" . $this->table_name5 . ".add_date,'%Y-%m-%d') >='" . $monday . "' AND DATE_FORMAT(" . $this->table_name5 . ".add_date,'%Y-%m-%d') <= '" . $sunday . "'");
        $this->db->where($this->table_name5 . '.status', 1);
        $query['last_week'] = $this->db->get($this->table_name5)->result_array();
        return $query;
    }

    function get_qty_chart() {
        $list_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
        $result = array();
        foreach ($list_array as $val) {
            if ($val < 10)
                $date = (date('Y')) . '-' . str_pad($val, 2, '0', STR_PAD_LEFT);
            else
                $date = (date('Y')) . '-' . $val;

            $this->db->select('SUM(net_total) AS total_qty');
            $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m')", $date);
            $query = $this->db->get('erp_invoice')->result_array();

            if (!empty($query[0]['total_qty']))
                $result[$val] = $query[0]['total_qty'];
            else
                $result[$val] = 0;
        }
        return $result;
    }

    function get_qty_chart1() {
        $list_array = array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15);
        $result = array();
        foreach ($list_array as $val) {
            if (date('m') > 3) {
                if ($val == '13') {
                    $date = (date('Y') + 1) . '-' . str_pad(1, 1, '0', STR_PAD_LEFT);
                } elseif ($val == '14') {
                    $date = (date('Y') + 1) . '-' . str_pad(2, 1, '0', STR_PAD_LEFT);
                } elseif ($val == '15') {
                    $date = (date('Y') + 1) . '-' . str_pad(3, 1, '0', STR_PAD_LEFT);
                } else {
                    if ($val < 10)
                        $date = date('Y') . '-' . str_pad($val, 2, '0', STR_PAD_LEFT);
                    else
                        $date = date('Y') . '-' . $val;
                }
            }
            else {
                if ($val == '13') {
                    $date = date('Y') . '-0' . str_pad(1, 1, '0', STR_PAD_LEFT);
                } elseif ($val == '14') {
                    $date = date('Y') . '-0' . str_pad(2, 1, '0', STR_PAD_LEFT);
                } elseif ($val == '15') {
                    $date = date('Y') . '-0' . str_pad(3, 1, '0', STR_PAD_LEFT);
                } else {
                    if ($val < 10)
                        $date = (date('Y') - 1) . '-' . str_pad($val, 2, '0', STR_PAD_LEFT);
                    else
                        $date = (date('Y') - 1) . '-' . $val;
                }
            }

            $this->db->select('SUM(full_total) AS total_qty');
            $this->db->where("DATE_FORMAT(" . $this->table_name3 . ".inv_date,'%Y-%m')", $date);
            $this->db->where($this->table_name3 . '.status', 1);
            $this->db->where($this->table_name3 . '.df', 0);
            $query = $this->db->get($this->table_name3)->result_array();
            if (!empty($query[0]['total_qty']))
                $result[$val] = $query[0]['total_qty'];
            else
                $result[$val] = 0;
        }
        return $result;
    }

    function get_dashboard_report() {
        $user_info = $this->user_auth->get_from_session('user_info');
        $this->db->select('enquiry_no,customer_name,created_date');
        if ($user_info[0]['role'] == 5) {
            $this->db->where('created_by', $user_info[0]['id']);
            $this->db->where('erp_enquiry.status', 'leads');
            $this->db->order_by('erp_enquiry.created_date', 'desc');
            $query['enquiry'] = $this->db->get('erp_enquiry')->result_array();
        } else {
            $this->db->where('erp_enquiry.status', 'leads');
            $this->db->order_by('erp_enquiry.created_date', 'desc');
            $query['enquiry'] = $this->db->get('erp_enquiry')->result_array();
        }

        $this->db->select('inv_id,net_total,customer.store_name,erp_invoice.id');
        $this->db->where('erp_invoice.payment_status', 'Pending');
        $this->db->order_by('erp_invoice.created_date', 'desc');
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
        $query['receipt'] = $this->db->get('erp_invoice')->result_array();

        $this->db->select('erp_product.model_no,erp_product.product_name,erp_product.min_qty,erp_stock.quantity,erp_category.categoryName,erp_brand.brands');
        $this->db->join('erp_product', 'erp_product.id=erp_stock.product_id AND erp_product.min_qty >= erp_stock.quantity');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_stock.category');
        $this->db->join('erp_brand', 'erp_brand.id=erp_stock.brand');
        $this->db->where('erp_product.min_qty >',0);
        $query['stock'] = $this->db->get('erp_stock')->result_array();

        $this->db->select('erp_service.ticket_no,erp_service.description,erp_service.created_date,customer.name as customer_name');
         $this->db->join('customer', 'customer.id=erp_service.customer_id');
        $this->db->where('erp_service.status', 2);
        $query['service'] = $this->db->get('erp_service')->result_array();


        return $query;
    }

    public function pending_inv_balance() {
        $this->db->select('erp_invoice.*');
        $this->db->select('customer.name,customer.store_name,customer.state_id');
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');
        $this->db->order_by('erp_invoice.id', 'desc');
//        $this->db->limit(10);
        $query = $this->db->get('erp_invoice')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date');
            $this->db->where('receipt_bill.receipt_id', $val['id']);
            $query[$i]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();
            $i++;
        }
        $j = 0;
        foreach ($query as $val) {
            $this->db->select('erp_invoice_details.*');
            $this->db->where('erp_invoice_details.in_id', $val['id']);
            $query[$j]['po_details'] = $this->db->get('erp_invoice_details')->result_array();
            $j++;
        }
        return $query;
    }

    public function get_pending_invoice() {

        $this->db->select('erp_invoice.id,erp_invoice.customer,customer.name,customer.store_name,SUM(erp_invoice.net_total) as net_total,SUM(erp_invoice.balance) as balance');
        $this->db->where('erp_invoice.payment_status', 'Pending');
        $this->db->where('erp_invoice.estatus', 1);
        $this->db->group_by('erp_invoice.customer');
        $this->db->order_by('erp_invoice.created_date', 'desc');
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
//        $this->db->limit(10);
        $query = $this->db->get('erp_invoice')->result_array();


        $i = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date,MAX(created_date) AS paid_date');
            $this->db->where('receipt_bill.receipt_id', $val['id']);
            $receipt_bill = $this->db->get('receipt_bill')->row_array();
            $received_amt = round($receipt_bill['receipt_paid'] + $receipt_bill['receipt_discount'], 2);
            $query[$i]['balance_amt'] = number_format($val['net_total'] - ($received_amt), 2, '.', ',');

            $i++;
        }
        return $query;
    }

    function getPayementdata($year,$frommonth, $toyear, $tomonth){
        $list_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
        $month_names = array("Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec");

        $result = array();
        foreach ($list_array as $key => $val) {
            if ($val < 10) {
                $date = $year . '-' . str_pad($val, 2, '0', STR_PAD_LEFT);
            } else {
                $date = $year . '-' . $val;
            }

            $monthName = date("M", mktime(0, 0, 0, $val, 10));

            $this->db->select('SUM(tab_2.net_total) AS Amount');
            $this->db->where('tab_2.estatus', 1);
            $this->db->where('tab_2.payment_status', 'Completed');
            $this->db->where("DATE_FORMAT(tab_2.created_date,'%Y-%m')", $date);
            $total_payment = $this->db->get($this->erp_invoice . ' AS tab_2')->result_array();

            $payment = ($total_payment[0]['Amount'] != '') ? $total_payment[0]['Amount'] : "0.00";

            $result[$key]['month'] = $monthName;

            $result[$key]['payment'] = $payment;
        }

        return $result;
    }

    function get_pending_invdata() {
        $year = date('Y');
        $list_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
        $month_names = array("Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec");

        $result = array();
        foreach ($list_array as $key => $val) {
            if ($val < 10) {
                $date = $year . '-' . str_pad($val, 2, '0', STR_PAD_LEFT);
            } else {
                $date = $year . '-' . $val;
            }

            $monthName = date("M", mktime(0, 0, 0, $val, 10));

            $this->db->select('SUM(tab_2.net_total) AS Amount');
            $this->db->where('tab_2.estatus', 1);
            $this->db->where('tab_2.payment_status', 'Pending');
            $this->db->where("DATE_FORMAT(tab_2.created_date,'%Y-%m')", $date);
            $total_payment = $this->db->get($this->erp_invoice . ' AS tab_2')->result_array();

            $payment = ($total_payment[0]['Amount'] != '') ? $total_payment[0]['Amount'] : "0.00";

            $result[$key]['payment'] = $payment;
        }

        return $result;
    }

    function get_Servicedata() {
        $this->db->select('tab_1 .*');
        $this->db->where('tab_1.service_status', 1);
        $this->db->where('tab_1.status !=', 0);
        $user_info = $this->user_auth->get_from_session('user_info');
        $user_id = $user_info[0]['id'];
        if ($user_info[0]['role'] != 1) {
            $this->db->where("FIND_IN_SET('$user_id',tab_1.emp_id) > 0");
        }
        $total_service = $this->db->get($this->erp_service . ' AS tab_1')->num_rows();

        $this->db->select('tab_1 .*');
        $this->db->where('tab_1.status', 2);
        $this->db->where('tab_1.service_status', 1);
        if ($user_info[0]['role'] != 1) {
            $this->db->where("FIND_IN_SET('$user_id',tab_1.emp_id) > 0");
        }
        $pending_service = $this->db->get($this->erp_service . ' AS tab_1')->num_rows();

        $this->db->select('tab_1 .*');
        $this->db->where('tab_1.status', 1);
        $this->db->where('tab_1.service_status', 1);
        if ($user_info[0]['role'] != 1) {
            $this->db->where("FIND_IN_SET('$user_id',tab_1.emp_id) > 0");
        }
        $completed_service = $this->db->get($this->erp_service . ' AS tab_1')->num_rows();
        $this->db->select('tab_1 .*');
        $this->db->where('tab_1.status', 0);
        $this->db->where('tab_1.service_status', 1);
        if ($user_info[0]['role'] != 1) {
            $this->db->where("FIND_IN_SET('$user_id',tab_1.emp_id) > 0");
        }
        $inprogress_service = $this->db->get($this->erp_service . ' AS tab_1')->num_rows();
        $result['completed_per'] = round(($completed_service / ($total_service)) * 100);
        $result['pending_per'] = round(($pending_service / ($total_service)) * 100);
        $result['inprogress_per'] = round(($inprogress_service / ($total_service)) * 100);
        $result['pending'] = $pending_service;
        $result['completed'] = $completed_service;
        $result['inprogress'] = $inprogress_service;
        return $result;
    }

    function getServicedata($year) {
        $list_array = array(01, 02, 03, 04, 05, 06, 07, 08, 09, 10, 11, 12);
        $month_names = array("Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec");
        $result = array();
        foreach ($list_array as $key => $val) {
            $dateFrom = $year.'-'.$val.'-'.'01';
            $dateTo = $year.'-'.$val.'-'.'31';
            if ($val < 10) {
                $date = $year . '-' . str_pad($val, 2, '0', STR_PAD_LEFT);
            } else {
                $date = $year . '-' . $val;
            }

            $monthName = date("M", mktime(0, 0, 0, $val, 10));
            $this->db->select('tab_1 .*');
            $this->db->where('tab_1.status', 2);
            $this->db->where('tab_1.service_status', 1);
            $this->db->where("DATE_FORMAT(tab_1.created_date,'%Y-%m')", $date);
           // $where ="( DATE(tab_1.created_date) >= '".$dateFrom."' AND  DATE(tab_1.created_date) <= '".$dateTo."')";
          //  $this->db->where($where);
            $pending_service = $this->db->get($this->erp_service . ' AS tab_1');
           
            $this->db->select('tab_1 .*');
            $this->db->where('tab_1.status', 1);
            $this->db->where('tab_1.service_status', 1);
            $this->db->where("DATE_FORMAT(tab_1.created_date,'%Y-%m')", $date);
           // $where ="( DATE(tab_1.created_date) >= '".$dateFrom."' AND  DATE(tab_1.created_date) <= '".$dateTo."')";
           // $this->db->where($where);
            $completed_service = $this->db->get($this->erp_service . ' AS tab_1');
            
            $this->db->select('tab_1 .*');
            $this->db->where('tab_1.status', 0);
            $this->db->where('tab_1.service_status', 1);
            $this->db->where("DATE_FORMAT(tab_1.created_date,'%Y-%m')", $date);
            //$where ="( DATE(tab_1.created_date) >= '".$dateFrom."' AND  DATE(tab_1.created_date) <= '".$dateTo."')";
            //$this->db->where($where);
            $inprogress = $this->db->get($this->erp_service . ' AS tab_1');



            $result[$key]['month'] = $monthName;
            $result[$key]['pending'] = $pending_service->num_rows();
            $result[$key]['completed'] = $completed_service->num_rows();
            $result[$key]['inprogress'] = $inprogress->num_rows();
        }

        return $result;
    }

    function getpettyCash_pieChart() {
        $status_names = array("Credited Amount", "Debited Amount", "Opening Balance", "Company Amount");
        //        $result = array();

        $this->db->select('SUM(tab_1.amount) AS debit_Amount');
        $this->db->where('tab_1.mode', 'debit');
        $total_payment = $this->db->get($this->erp_balance_sheet . ' AS tab_1')->result_array();
        $debit_Amount = ($total_payment[0]['debit_Amount'] != '') ? $total_payment[0]['debit_Amount'] : "0.00";
        //
        $this->db->select('SUM(tab_1.amount) AS credit_Amount');
        $this->db->where('tab_1.mode', 'credit');
        $total_payment = $this->db->get($this->erp_balance_sheet . ' AS tab_1')->result_array();
        $credit_Amount = ($total_payment[0]['credit_Amount'] != '') ? $total_payment[0]['credit_Amount'] : "0.00";

        $this->db->select('tab_1.opening_balance');
        $company = $this->db->get($this->company_details . ' AS tab_1')->result_array();
        $opening_balance = ($company[0]['opening_balance'] != '') ? $company[0]['opening_balance'] : "0.00";

        $this->db->select('tab_1.company_amount');
        $company = $this->db->get($this->company_details . ' AS tab_1')->result_array();
        $company_amount = ($company[0]['company_amount'] != '') ? $company[0]['company_amount'] : "0.00";

        $result['label'] = $status_names;

        foreach ($status_names as $key => $status) {
            if ($status == "Credited Amount")
                $count = $credit_Amount;
            if ($status == "Debited Amount")
                $count = $debit_Amount;
            if ($status == "Opening Balance")
                $count = $opening_balance;
            if ($status == "Company Amount")
                $count = $company_amount;
            $result['data'][$key] = [$count];
        }

        return $result;
    }

   
    function get_leads_quo_pc_datas($year) {
        $list_array = array('leads', 'leads_follow_up', 'leads_rejected', 'quotation', 'quotation_follow_up', 'quotation_rejected', 'order_conform');
        $status_array = array("Leads", "Leads Followup", "Leads Rejected", "Quotation", "Quotation Followup", "Quotation Rejected", "Order Conform");
        $result = array();
        foreach ($list_array as $key => $val) {
            if ($val < 10) {
                $date = $year . '-' . str_pad($val, 2, '0', STR_PAD_LEFT);
            } else {
                $date = $year . '-' . $val;
            }

            // $monthName = date("M", mktime(0, 0, 0, $val, 10));
            $this->db->select('erp_enquiry .*');
            $this->db->where('erp_enquiry.enquiry_status', 1);
            $this->db->where('erp_enquiry.status', $val);
            // $this->db->where("DATE_FORMAT(erp_enquiry.created_date,'%Y-%m')", $date);
            $leads = $this->db->get('erp_enquiry');

            // $this->db->select('erp_quotation .*');
            // $this->db->where('erp_quotation.estatus !=', 0);
            // $this->db->where("DATE_FORMAT(erp_quotation.created_date,'%Y-%m')", $date);
            // $quotation = $this->db->get('erp_quotation');

            // $this->db->select('erp_project_cost .*');
            // $this->db->where("DATE_FORMAT(erp_project_cost.created_date,'%Y-%m')", $date);
            // $project_cost = $this->db->get('erp_project_cost');


            $result[$key]['month'] = $status_array[$key];
            $result[$key]['leads'] = $leads->num_rows();
            // $result[$key]['quotation'] = $quotation->num_rows();
            // $result[$key]['project_cost'] = $project_cost->num_rows();
        }

        return $result;
    }

    function users_logs_updates($insert_type, $user_type, $id) {
        $current_date_time = date('Y-m-d H:i:s');
        if ($insert_type == "insert") {
            $data['user_type'] = $user_type;
            $data['user_id'] = $id;
            $data['logged_in_date'] = $current_date_time;
            $this->db->insert('erp_active_users', $data);
        } else {
            $data['logged_out_date'] = $current_date_time;
            $this->db->where('user_id', $id);
            $this->db->where('user_type', $user_type);
            $this->db->where('logged_out_date is NULL', NULL, FALSE);
            $this->db->update('erp_active_users', $data);
        }
    }

    function get_user_activation_list() {
        $this->db->select('ua.user_id,ua.logged_in_date,ua.logged_out_date,ua.user_type,erp_user.name as user_name,erp_user.admin_image as user_image,erp_user.status,customer.name as customer_name,customer.profile_image as customer_image,customer.store_name');
        $this->db->join('erp_user', 'erp_user.id = ua.user_id AND ua.user_type = 1', 'LEFT', FALSE);
        $this->db->join('customer', 'customer.id = ua.user_id AND ua.user_type = 2', 'LEFT', FALSE);
        $this->db->where('ua.logged_out_date is NULL', NULL, FALSE);
        $this->db->group_by('ua.user_id,ua.user_type');
        $query = $this->db->get('erp_active_users as ua')->result_array();

        return $query;
    }

    function get_user_count_list() {
        $this->db->select('ua.user_id,ua.logged_in_date,ua.logged_out_date,ua.user_type,erp_user.name as user_name,erp_user.admin_image as user_image');
        $this->db->join('erp_user', 'erp_user.id = ua.user_id AND ua.user_type = 1', 'LEFT', FALSE);
        $this->db->where('ua.user_type =', '1');
        $this->db->where('erp_user.status =', '1');
        $this->db->where('ua.logged_out_date is NULL', NULL, FALSE);
        $this->db->group_by('ua.user_id');
        $query = $this->db->get('erp_active_users as ua')->result_array();

        return $query;
    }

    function get_quo_conversion_data($year) {
        $list_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
        $month_names = array("Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec");

        $result = array();
        foreach ($list_array as $key => $val) {
            if ($val < 10) {
                $date = $year . '-' . str_pad($val, 2, '0', STR_PAD_LEFT);
            } else {
                $date = $year . '-' . $val;
            }

            $monthName = date("M", mktime(0, 0, 0, $val, 10));

            $this->db->select('COUNT(erp_quotation.id) AS quo_count');
            $this->db->where('erp_quotation.estatus !=', 0);
            $this->db->where("DATE_FORMAT(erp_quotation.created_date,'%Y-%m')", $date);
            $query = $this->db->get('erp_quotation')->result_array();

            $this->db->select('COUNT(erp_project_cost.id) AS pc_count');
            $this->db->where("DATE_FORMAT(erp_project_cost.created_date,'%Y-%m')", $date);
            $this->db->where('job_id !=', '');
            $pc_count = $this->db->get('erp_project_cost')->result_array();

            $result[$key]['month'] = $monthName;
            if ($query[0]['quo_count'] != "") {
                $result[$key]['quotation'] = $query[0]['quo_count'];
            } else {
                $result[$key]['quotation'] = '';
            }
            if ($pc_count[0]['pc_count'] != "") {
                $result[$key]['project_cost'] = $pc_count[0]['pc_count'];
            } else {
                $result[$key]['project_cost'] = '';
            }
        }
        return $result;
    }

    function get_all_profit_amount($year) {

        $list_array = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
        $month_names = array("Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec");

        $result = array();
        foreach ($list_array as $key => $val) {
            if ($val < 10) {
                $date = $year . '-' . str_pad($val, 2, '0', STR_PAD_LEFT);
            } else {
                $date = $year . '-' . $val;
            }

            $monthName = date("M", mktime(0, 0, 0, $val, 10));

            $this->db->select('SUM(erp_project_cost.net_total) As pc_total');
            $this->db->where("DATE_FORMAT(erp_project_cost.created_date,'%Y-%m')", $date);
            $pc_amt = $this->db->get('erp_project_cost')->result_array();

            $this->db->select('SUM(erp_invoice.net_total) As inv_total');
            $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m')", $date);
            $inv_amt = $this->db->get('erp_invoice')->result_array();

            $this->db->select('SUM(discount) AS receipt_discount');
            $this->db->where("DATE_FORMAT(receipt_bill.created_date,'%Y-%m')", $date);
            $rec_amt = $this->db->get('receipt_bill')->result_array();

            $profit_amt = number_format((($inv_amt[0]['inv_total'] - $rec_amt[0]['receipt_discount']) - $pc_amt[0]['pc_total']), 2, '.', ',');
            $result[$key]['month'] = $monthName;
            if ($profit_amt != "" && $profit_amt != '0.00') {
                $result[$key]['profit_amount'] = $profit_amt;
            } else {
                $result[$key]['profit_amount'] = '';
            }
            if ($inv_amt[0]['inv_total'] != "") {
                $result[$key]['inv_amount'] = $inv_amt[0]['inv_total'];
            } else {
                $result[$key]['inv_amount'] = '';
            }
        }
        return $result;
    }

}
