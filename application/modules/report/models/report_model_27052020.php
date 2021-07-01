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
class Report_model extends CI_Model {

    private $table_name1 = 'sales_order';
    private $table_name2 = 'sales_order_details';
    private $table_name3 = 'customer';
    private $table_name4 = 'master_style';
    private $table_name5 = 'master_style_size';
    private $table_name6 = 'vendor';
    private $erp_quotation = 'erp_quotation';
    private $erp_quotation_details = 'erp_quotation_details';
    private $vendor = 'vendor';
    private $erp_po = 'erp_po';
    private $erp_stock = 'erp_stock';
    private $erp_invoice = 'erp_invoice';
    private $erp_grn = 'gen';
    private $customer = 'customer';
    private $erp_user = 'erp_user';
    private $erp_user_roles = 'erp_user_roles';
    private $erp_service = 'erp_service';
    private $erp_attendance = 'erp_attendance';
    private $erp_inward_outward_dc = 'erp_inward_outward_dc_details';
    private $erp_service_dc = 'erp_service_dc';

    function __construct() {
        parent::__construct();
    }

    function get_all_receipt() {
        if (isset($serch_data) && !empty($serch_data)) {
            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';
            if (!empty($serch_data['state']) && $serch_data['state'] != 'Select') {
                $this->db->where($this->table_name1 . '.state', $serch_data['state']);
            }
            if (!empty($serch_data['supplier']) && $serch_data['supplier'] != 'Select') {
                $this->db->where($this->table_name1 . '.customer', $serch_data['supplier']);
            }
            if (!empty($serch_data['po'])) {
                $this->db->where($this->table_name1 . '.grn_no', $serch_data['po']);
            }
            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {
                $this->db->where("DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {
                $this->db->where("DATE_FORMAT(" . $this->table_name1 . ".inv_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["style"]) && $serch_data["style"] != "Select") {

                $this->db->where('master_style.id', $serch_data["style"]);
            }
        }
        $this->db->select($this->table_name1 . '.*');
        $this->db->select('vendor.name,store_name');
        $this->db->select('master_style.style_name');
        $this->db->select('master_state.state');
        $this->db->where($this->table_name1 . '.status', 1);
        $this->db->where($this->table_name1 . '.df', 0);
        $this->db->order_by($this->table_name1 . '.id', 'desc');
        $this->db->group_by('po_details.gen_id');
        $this->db->join('po_details', 'po_details.gen_id=' . $this->table_name1 . '.id');
        $this->db->join('master_style', 'master_style.id=po_details.style_id');
        $this->db->join('vendor', 'vendor.id=' . $this->table_name1 . '.customer');
        $this->db->join('master_state', 'master_state.id=' . $this->table_name1 . '.state');
        $query = $this->db->get('erp_invoice')->result_array();
        return $query;
    }

    public function get_all_quotation_report($serch_data) {
        $this->db->select('erp_quotation.id,customer.id as customer, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'
                . 'erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus,erp_quotation.created_date');
        $this->db->where('erp_quotation.estatus !=', 0);
        $this->db->join('customer', 'customer.id=erp_quotation.customer');
        if (isset($serch_data) && !empty($serch_data)) {

            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';
            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(erp_quotation.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(erp_quotation.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {
                $this->db->where("DATE_FORMAT(erp_quotation.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {
                $this->db->where("DATE_FORMAT(erp_quotation.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        $query = $this->db->get('erp_quotation')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('q_id', intval($val['id']));
            $query[$i]['pc_amount'] = $this->db->get('erp_project_cost')->result_array();

            $i++;
        }
        $c = 0;
        $Count = COUNT($query);
        $query[$c]['count'] = $Count;

        $j = 0;
        $this->db->select('COUNT(erp_quotation.id) as id');
        $this->db->where('erp_quotation.estatus !=', 0);
        $query[$j]["quo_total"] = $this->db->get('erp_quotation')->result_array();
        $k = 0;
        $this->db->select('COUNT(erp_project_cost.id) as id');
        $query[$k]["pc_total"] = $this->db->get('erp_project_cost')->result_array();
        return $query;
    }

    function get_all_project_name() {
        $this->db->select('erp_quotation.project_name,erp_quotation.id');
        $this->db->where('erp_quotation.estatus !=', 0);
        $this->db->where('erp_quotation.type =', 'direct');
        $query = $this->db->get('erp_quotation')->result_array();
        return $query;
    }

    function get_all_profit_report($serch_data) {

        $this->db->select('erp_quotation.id,customer.id as customer, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'
                . 'erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus,erp_quotation.project_name');
        $this->db->where('erp_quotation.estatus !=', 0);
        $this->db->join('customer', 'customer.id=erp_quotation.customer');
        $query = $this->db->get('erp_quotation')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('q_id', intval($val['id']));
            $query[$i]['pc_amount'] = $this->db->get('erp_project_cost')->result_array();
            $i++;
        }
        $j = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            if (isset($serch_data) && !empty($serch_data)) {
                if (!empty($serch_data['from_date']))
                    $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
                if (!empty($serch_data['to_date']))
                    $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
                if ($serch_data['from_date'] == '1970-01-01')
                    $serch_data['from_date'] = '';
                if ($serch_data['to_date'] == '1970-01-01')
                    $serch_data['to_date'] = '';
                if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                    $this->db->where("DATE_FORMAT(erp_sales_return.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(erp_sales_return.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
                } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                    $this->db->where("DATE_FORMAT(erp_sales_return.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
                } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {
                    $this->db->where("DATE_FORMAT(erp_sales_return.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
                }
            }
            $this->db->where('q_id', intval($val['pc_amount'][0]['q_id']));
            $query[$j]['inv_amount'] = $this->db->get('erp_sales_return')->result_array();
            if (empty($query[$j]['inv_amount']))
                unset($query[$j]);
            $j++;
        }
        $k = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(discount) AS receipt_discount');
            $this->db->where('receipt_bill.receipt_id', $val['id']);
            $query[$k]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();
            $k++;
        }
        return $query;
    }

    function get_quotation_datatables($search_data) {

        $this->_get_quotation_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_quotation')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select(' sum(sub_total - ( per_cost * quantity )) as tot_tax');
            $this->db->where($this->erp_quotation_details . '.q_id', $val['id']);
            $query[$i]['tax_details'] = $this->db->get($this->erp_quotation_details)->result_array();
            $i++;
        }

        return $query;
    }

    function _get_quotation_datatables_query($serch_data = array()) {
        if (isset($serch_data) && !empty($serch_data)) {
            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';


            if (!empty($serch_data['q_no']) && $serch_data['q_no'] != 'Select Quotation.NO') {

                $this->db->where($this->erp_quotation . '.q_no', $serch_data['q_no']);
            }
            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select Company Name') {
                $this->db->where($this->erp_quotation . '.customer', $serch_data['customer']);
            }

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_quotation . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_quotation . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_quotation . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_quotation . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        $this->db->select('customer.id as customer,customer.store_name, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.id,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'
                . 'erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus,erp_quotation.validity,erp_quotation.created_date');
        $this->db->where('erp_quotation.estatus !=', 0);
        $this->db->where('erp_quotation.type =', 1);
        $this->db->join('customer', 'customer.id=erp_quotation.customer');

        $i = 0;
        $column_order = array(null, 'erp_quotation.q_no', 'customer.name', 'erp_quotation.total_qty', null, 'erp_quotation.subtotal_qty', 'erp_quotation.net_total', 'erp_quotation.mode_of_payment', 'erp_quotation.created_date', null);
        $column_search = array('erp_quotation.q_no', 'customer.name', 'erp_quotation.total_qty', 'erp_quotation.subtotal_qty', 'erp_quotation.net_total', 'erp_quotation.mode_of_payment', 'erp_quotation.created_date');
        $order = array('erp_quotation.id' => 'DESC');

        foreach ($column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i == 0) { // first loop
                    $where .= "(";
                }
                $string = $item;
                $str_arr = explode(".", $string);

                $where .= '`' . $str_arr[0] . "`" . '.' . "`" . $str_arr[1] . "` like '%" . $_POST['search']['value'] . "%'";
                if ((count($column_search) - 1) != $i)
                    $where .= ' OR ';
                if ((count($column_search) - 1) == $i)
                    $where .= ")";
            }
            $i++;
        }

        if ($where != '')
            $this->db->where($where);
        if (isset($_POST['order']) && $column_order[$_POST['order']['0']['column']] != null) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_quotation() {
        $this->_get_quotation_datatables_query();
        $query = $this->db->get('erp_quotation');
        return $query->num_rows();
    }

    function count_all_quotation() {
        $this->_get_quotation_datatables_query();
        $this->db->from('erp_quotation');
        return $this->db->count_all_results();
    }

    public function get_customer_datatables($search_data) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.status', 1);
        $column_order = array(null, 'tab_1.id', 'tab_1.name', 'tab_1.store_name');
        $column_search = array('tab_1.id', 'tab_1.name', 'tab_1.store_name');
        $order = array('tab_1.id' => 'DESC');

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

        $this->db->join('erp_active_users', 'erp_active_users.user_id = tab_1.id AND erp_active_users.user_type = 2');
        $this->db->where('erp_active_users.logged_out_date is NULL', NULL, FALSE);
        $this->db->group_by('erp_active_users.user_id');
        $query = $this->db->get($this->customer . ' AS tab_1');
        return $query->result();
    }

    public function count_all_customer() {
        $this->db->where('tab_1.status', 1);
        $this->db->join('erp_active_users', 'erp_active_users.user_id = tab_1.id AND erp_active_users.user_type = 2');
        $this->db->where('erp_active_users.logged_out_date is NULL', NULL, FALSE);
        $this->db->group_by('erp_active_users.user_id');
        $this->db->from($this->customer . ' As tab_1');
        return $this->db->count_all_results();
    }

    public function count_filtered_customer($search_data) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.status', 1);
        $column_order = array(null, 'tab_1.id', 'tab_1.name', 'tab_1.store_name');
        $column_search = array('tab_1.id', 'tab_1.name', 'tab_1.store_name');
        $order = array('tab_1.id' => 'DESC');

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
        $this->db->join('erp_active_users', 'erp_active_users.user_id = tab_1.id AND erp_active_users.user_type = 2');
        $this->db->where('erp_active_users.logged_out_date is NULL', NULL, FALSE);
        $this->db->group_by('erp_active_users.user_id');
        $query = $this->db->get($this->customer . ' AS tab_1');
        return $query->num_rows();
    }

    public function get_employee_datatables($search_data) {
        $this->db->select('tab_1.*,tab_2.user_role');
         $this->db->where('tab_1.status', 1);
        $this->db->join($this->erp_user_roles . ' AS tab_2', 'tab_2.id = tab_1.role', 'LEFT');
        $column_order = array(null, 'tab_1.id', 'tab_1.emp_code', 'tab_1.name', 'tab_1.mobile_no', 'tab_2.user_role', 'tab_1.email_id');
        $column_search = array('tab_1.id', 'tab_1.emp_code', 'tab_1.name', 'tab_1.mobile_no', 'tab_2.user_role', 'tab_1.email_id');
        $order = array('tab_1.id' => 'DESC');

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

        $this->db->join('erp_active_users', 'erp_active_users.user_id = tab_1.id AND erp_active_users.user_type = 1');
        $this->db->where('erp_active_users.logged_out_date is NULL', NULL, FALSE);
        $this->db->group_by('erp_active_users.user_id');
        $query = $this->db->get($this->erp_user . ' AS tab_1');
        return $query->result();
    }

    public function count_all_employee() {
        $this->db->where('tab_1.status', 1);
        $this->db->join('erp_active_users', 'erp_active_users.user_id = tab_1.id AND erp_active_users.user_type = 1');
        $this->db->where('erp_active_users.logged_out_date is NULL', NULL, FALSE);
        $this->db->group_by('erp_active_users.user_id');
        $this->db->from($this->erp_user . ' AS tab_1');
        return $this->db->count_all_results();
    }

    public function count_filtered_employee($search_data) {
        $this->db->select('tab_1.*,tab_2.user_role');
        $this->db->join($this->erp_user_roles . ' AS tab_2', 'tab_2.id = tab_1.role', 'LEFT');
        $this->db->where('tab_1.status', 1);
        $column_order = array(null, 'tab_1.id', 'tab_1.emp_code', 'tab_1.name', 'tab_2.user_role', 'tab_1.email_id');
        $column_search = array('tab_1.id', 'tab_1.emp_code', 'tab_1.name', 'tab_2.user_role', 'tab_1.email_id');
        $order = array('tab_1.id' => 'DESC');

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
        $this->db->join('erp_active_users', 'erp_active_users.user_id = tab_1.id AND erp_active_users.user_type = 1');
        $this->db->where('erp_active_users.logged_out_date is NULL', NULL, FALSE);
        $this->db->group_by('erp_active_users.user_id');
        $query = $this->db->get($this->erp_user . ' AS tab_1');
        return $query->num_rows();
    }

    function get_po_datatables($search_data) {

        $this->_get_po_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_po')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('gen.grn_no,gen.id AS gen_id');
            $this->db->where('gen.po_id', $val['id']);
            $query[$i]['grn_no'] = $this->db->get('gen')->result_array();
            $i++;
        }
        return $query;
    }

    function _get_po_datatables_query($serch_data = array()) {

        if (isset($serch_data) && !empty($serch_data)) {
            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';


            if (!empty($serch_data['po_no']) && $serch_data['po_no'] != 'Select PO NO') {

                $this->db->where($this->erp_po . '.po_no', $serch_data['po_no']);
            }
            if (!empty($serch_data['supplier']) && $serch_data['supplier'] != 'Select Company Name') {
                $this->db->where($this->vendor . '.store_name', $serch_data['supplier']);
            }

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        $this->db->select('vendor.id as vendor, vendor.store_name, vendor.name, vendor.mobil_number, vendor.email_id, vendor.address1, erp_po.id, erp_po.po_no, erp_po.total_qty, erp_po.tax, erp_po.tax_label, '
                . 'erp_po.net_total, erp_po.delivery_schedule, erp_po.mode_of_payment, erp_po.remarks, erp_po.subtotal_qty, erp_po.estatus, erp_po.created_date');
        $this->db->where('erp_po.estatus !=', 0);
        $this->db->join('vendor', 'vendor.id = erp_po.supplier');

        $i = 0;
        $column_order = array(null, 'erp_po.po_no', 'vendor.store_name', 'erp_po.total_qty', 'erp_po.subtotal_qty', 'erp_po.net_total', 'erp_po.mode_of_payment', 'erp_po.remarks', null);
        $column_search = array('erp_po.po_no', 'vendor.store_name', 'erp_po.total_qty', 'erp_po.subtotal_qty', 'erp_po.net_total', 'erp_po.mode_of_payment', 'erp_po.remarks');
        $order = array('erp_po.id' => 'DESC');

        foreach ($column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i == 0) { // first loop
                    $where .= "(";
                }
                $string = $item;
                $str_arr = explode(".", $string);
                $where .= '`' . $str_arr[0] . "`" . '.' . "`" . $str_arr[1] . "` like '%" . $_POST['search']['value'] . "%'";
                if ((count($column_search) - 1) != $i)
                    $where .= ' OR ';
                if ((count($column_search) - 1) == $i)
                    $where .= ")";
            }
            $i++;
        }
        if ($where != '')
            $this->db->where($where);
        if (isset($_POST['order']) && $column_order[$_POST['order']['0']['column']] != null) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_po() {
        $this->_get_po_datatables_query();
        $query = $this->db->get('erp_po');
        return $query->num_rows();
    }

    function count_all_po() {
        $this->_get_po_datatables_query();
        $this->db->from('erp_po');
        return $this->db->count_all_results();
    }

    function get_stock_datatables($search_data) {

        $this->_get_stock_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_stock')->result_array();
        return $query;
    }

    function _get_stock_datatables_query($serch_data = array()) {

        if (isset($serch_data) && !empty($serch_data)) {

            if (!empty($serch_data['category']) && $serch_data['category'] != 'Select Category') {

                $this->db->where($this->erp_stock . '.category', $serch_data['category']);
            }
            if (!empty($serch_data['brand']) && $serch_data['brand'] != 'Select Brand') {
                $this->db->where($this->erp_stock . '.brand', $serch_data['brand']);
            }
            if (!empty($serch_data['model_no']) && $serch_data['model_no'] != 'Select Model No') {
                $this->db->where($this->erp_stock . '.product_id', $serch_data['model_no']);
            }
        }
        $this->db->select('erp_category.categoryName,erp_product.product_name,erp_brand.brands,erp_stock.quantity,erp_product.model_no');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_stock.category');
        $this->db->join('erp_product', 'erp_product.id=erp_stock.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_stock.brand');

        $i = 0;
        $column_order = array(null, 'erp_category.categoryName', 'erp_brand.brands', 'erp_product.model_no', 'erp_product.product_name', 'erp_stock.quantity');
        $column_search = array('erp_category.categoryName', 'erp_brand.brands', 'erp_product.model_no', 'erp_product.product_name', 'erp_stock.quantity');
        $order = array('erp_stock.id' => 'DESC');

        foreach ($column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i == 0) { // first loop
                    $where .= "(";
                }
                $string = $item;
                $str_arr = explode(".", $string);
                $where .= '`' . $str_arr[0] . "`" . '.' . "`" . $str_arr[1] . "` like '%" . $_POST['search']['value'] . "%'";
                if ((count($column_search) - 1) != $i)
                    $where .= ' OR ';
                if ((count($column_search) - 1) == $i)
                    $where .= ")";
            }
            $i++;
        }
        if ($where != '')
            $this->db->where($where);
        if (isset($_POST['order']) && $column_order[$_POST['order']['0']['column']] != null) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_stock() {
        $this->_get_stock_datatables_query();
        $query = $this->db->get('erp_stock');
        return $query->num_rows();
    }

    function count_all_stock() {
        $this->_get_stock_datatables_query();
        $this->db->from('erp_stock');
        return $this->db->count_all_results();
    }

    function get_inv_datatables($search_data) {

        $this->_get_inv_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_invoice')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('j_id', intval($val['id']));
            $this->db->where('type', 'invoice');
            $query[$i]['other_cost'] = $this->db->get('erp_other_cost')->result_array();
            $i++;
        }
        return $query;
    }

    function _get_inv_datatables_query($serch_data = array()) {

        if (!empty($serch_data['from_date']))
            $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
        if (!empty($serch_data['to_date']))
            $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
        if ($serch_data['from_date'] == '1970-01-01')
            $serch_data['from_date'] = '';
        if ($serch_data['to_date'] == '1970-01-01')
            $serch_data['to_date'] = '';

        if (!empty($serch_data['inv_id']) && $serch_data['inv_id'] != 'Select Invoice ID') {

            $this->db->where($this->erp_invoice . '.inv_id', $serch_data['inv_id']);
        }
        if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select Company Name') {
            $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);
        }

        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        }

        $this->db->select('customer.id as customer,customer.store_name, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_quotation.q_no,erp_invoice.total_qty,erp_invoice.tax,erp_quotation.ref_name,erp_invoice.tax_label,'
                . 'erp_invoice.net_total,erp_invoice.created_date,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,erp_invoice.warranty_from,erp_invoice.warranty_to');

        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');
        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $i = 0;
        $column_order = array(null, 'erp_invoice.inv_id', 'customer.name', 'erp_invoice.total_qty', 'erp_invoice.tax', 'erp_invoice.subtotal_qty', 'erp_invoice.net_total', 'erp_invoice.created_date', 'erp_invoice.remarks');
        $column_search = array('erp_invoice.inv_id', 'customer.name', 'erp_invoice.total_qty', 'erp_invoice.tax', 'erp_invoice.subtotal_qty', 'erp_invoice.net_total', 'erp_invoice.created_date', 'erp_invoice.remarks');
        $order = array('erp_invoice.id' => 'DESC');

        foreach ($column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i == 0) { // first loop
                    $where .= "(";
                }
                $string = $item;
                $str_arr = explode(".", $string);
                $where .= '`' . $str_arr[0] . "`" . '.' . "`" . $str_arr[1] . "` like '%" . $_POST['search']['value'] . "%'";
                if ((count($column_search) - 1) != $i)
                    $where .= ' OR ';
                if ((count($column_search) - 1) == $i)
                    $where .= ")";
            }
            $i++;
        }
        if ($where != '')
            $this->db->where($where);
        if (isset($_POST['order']) && $column_order[$_POST['order']['0']['column']] != null) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_inv() {
        $this->_get_inv_datatables_query();
        $query = $this->db->get('erp_invoice');
        return $query->num_rows();
    }

    function count_all_inv() {
        $this->_get_inv_datatables_query();
        $this->db->from('erp_invoice');
        return $this->db->count_all_results();
    }

    function get_profit_datatables($serch_data) {

        $this->_get_profit_datatables_query($serch_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_quotation')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('q_id', intval($val['id']));
            $query[$i]['pc_amount'] = $this->db->get('erp_project_cost')->result_array();
            $i++;
        }
        $j = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            if (isset($serch_data) && !empty($serch_data)) {
                if (!empty($serch_data['from_date']))
                    $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
                if (!empty($serch_data['to_date']))
                    $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
                if ($serch_data['from_date'] == '1970-01-01')
                    $serch_data['from_date'] = '';
                if ($serch_data['to_date'] == '1970-01-01')
                    $serch_data['to_date'] = '';
                if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                    $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
                } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                    $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
                } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {
                    $this->db->where("DATE_FORMAT(erp_invoice.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
                }
            }
            $this->db->where('q_id', intval($val['pc_amount'][0]['q_id']));
            $query[$j]['inv_amount'] = $this->db->get('erp_invoice')->result_array();
//            if (empty($query[$j]['inv_amount']))
//                unset($query[$j]);
            $j++;
            $k = 0;
            foreach ($query as $val) {
                $this->db->select('SUM(discount) AS receipt_discount');
                $this->db->where('receipt_bill.receipt_id', $val['id']);
                $query[$k]['receipt_bill'] = $this->db->get('receipt_bill')->result_array();
                $k++;
            }
        }

        return $query;
    }

    function _get_profit_datatables_query($serch_data = array()) {
        if (isset($serch_data) && !empty($serch_data)) {
            if (!empty($serch_data['company_name']) && $serch_data['company_name'] != 'Select Company Name') {
                $this->db->where($this->erp_quotation . '.customer', $serch_data['company_name']);
            }
        }
        $this->db->select('erp_quotation.id, customer.id as customer, customer.name, customer.mobil_number, customer.email_id, customer.address1, erp_quotation.q_no, erp_quotation.total_qty, erp_quotation.tax, erp_quotation.ref_name, erp_quotation.tax_label, '
                . 'erp_quotation.net_total, erp_quotation.delivery_schedule, erp_quotation.notification_date, erp_quotation.mode_of_payment, erp_quotation.remarks, erp_quotation.subtotal_qty, erp_quotation.estatus');
        $this->db->where('erp_quotation.estatus !=', 0);
        $this->db->join('customer', 'customer.id = erp_quotation.customer');

        $i = 0;
        $column_order = array(null, 'erp_quotation.q_no', 'customer.name', 'erp_quotation.net_total', null, null, null, null, null, null, null);
        $column_search = array('erp_quotation.q_no', 'customer.name', 'erp_quotation.net_total');
        $order = array('erp_quotation.id' => 'DESC');

        foreach ($column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i == 0) { // first loop
                    $where .= "(";
                }
                $string = $item;
                $str_arr = explode(".", $string);
                $where .= '`' . $str_arr[0] . "`" . '.' . "`" . $str_arr[1] . "` like '%" . $_POST['search']['value'] . "%'";
                if ((count($column_search) - 1) != $i)
                    $where .= ' OR ';
                if ((count($column_search) - 1) == $i)
                    $where .= ")";
            }
            $i++;
        }
        if ($where != '')
            $this->db->where($where);
        if (isset($_POST['order']) && $column_order[$_POST['order']['0']['column']] != null) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_profit() {
        $this->_get_profit_datatables_query();
        $query = $this->db->get('erp_quotation');
        return $query->num_rows();
    }

    function count_all_profit() {
        $this->_get_profit_datatables_query();
        $this->db->from('erp_quotation');
        return $this->db->count_all_results();
    }

    function get_conversion_datatables($serch_data) {

        $this->_get_conversion_datatables_query($serch_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_quotation')->result_array();

        $this->_get_conversion_datatables_query($serch_data, 'count');
        $query_count = $this->db->get('erp_quotation')->result_array();

        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('q_id', intval($val['id']));
            $query[$i]['pc_amount'] = $this->db->get('erp_project_cost')->result_array();
            $i++;
        }
        $count = 0;
        foreach ($query_count as $val) {
            $this->db->select('*');
            $this->db->where('q_id', intval($val['id']));
            $this->db->where('job_id !=', '');
            $pc_amt = $this->db->get('erp_project_cost')->result_array();
            if (!empty($pc_amt)) {
                $count++;
            }
        }
        $query[0]['quoation_total'] = count($query_count);
        $query[0]['job_total'] = $count;
        $c = 0;
        $Count = COUNT($query);
        $query[$c]['count'] = $Count;

        $j = 0;
        $this->db->select('COUNT(erp_quotation.id) as id');
        $query[$j]["quo_total"] = $this->db->get('erp_quotation')->result_array();
        $k = 0;
        $this->db->select('COUNT(erp_project_cost.id) as id');
        $query[$k]["pc_total"] = $this->db->get('erp_project_cost')->result_array();
        return $query;
    }

    function _get_conversion_datatables_query($serch_data = array(), $type = null) {
        if ($type == null) {
            $this->db->select('erp_quotation.id,customer.id as customer, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_quotation.q_no,erp_quotation.total_qty,erp_quotation.tax,erp_quotation.ref_name,erp_quotation.tax_label,'
                    . 'erp_quotation.net_total,erp_quotation.delivery_schedule,erp_quotation.notification_date,erp_quotation.mode_of_payment,erp_quotation.remarks,erp_quotation.subtotal_qty,erp_quotation.estatus,erp_quotation.created_date,erp_project_cost.job_id,erp_project_cost.net_total as pcamount');
        } else {
            $this->db->select('erp_quotation.id');
        }
        $this->db->where('erp_quotation.estatus !=', 0);
        $this->db->join('customer', 'customer.id=erp_quotation.customer');
        $this->db->join('erp_project_cost', 'erp_project_cost.q_id=erp_quotation.id','left');

        if (isset($serch_data) && !empty($serch_data)) {

            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';
            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(erp_quotation.created_date, '%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(erp_quotation.created_date, '%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {
                $this->db->where("DATE_FORMAT(erp_quotation.created_date, '%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {
                $this->db->where("DATE_FORMAT(erp_quotation.created_date, '%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        $i = 0;
        $column_order = array(null, 'erp_quotation.q_no', 'customer.name', 'erp_quotation.net_total', 'erp_quotation.created_date', 'erp_project_cost.job_id','erp_project_cost.net_total', null, null, null, null);
        $column_search = array('erp_quotation.q_no', 'customer.name', 'erp_quotation.net_total','erp_quotation.created_date','erp_project_cost.job_id','erp_project_cost.net_total');
        $order = array('erp_quotation.id' => 'DESC');

        foreach ($column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i == 0) { // first loop
                    $where .= "(";
                }
                $string = $item;
                $str_arr = explode(".", $string);
                if($str_arr[1] == 'created_date')
                    $value= date('Y-m-d',strtotime($_POST['search']['value']));
                else 
                    $value= $_POST['search']['value'];
                $where .= '`' . $str_arr[0] . "`" . '.' . "`" . $str_arr[1] . "` like '%" . $value . "%'";
                if ((count($column_search) - 1) != $i)
                    $where .= ' OR ';
                if ((count($column_search) - 1) == $i)
                    $where .= ")";
            }
            $i++;
        }
        if ($where != '')
            $this->db->where($where);
        $this->db->group_by('erp_quotation.id');
        if (isset($_POST['order']) && $column_order[$_POST['order']['0']['column']] != null) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_conversion($search_data=array()) {
        $this->_get_conversion_datatables_query($search_data);
        $query = $this->db->get('erp_quotation');
        return $query->num_rows();
    }

    function count_all_conversion($search_data=array()) {
        $this->_get_conversion_datatables_query($search_data);
        $this->db->from('erp_quotation');
        return $this->db->count_all_results();
    }

    function get_purchase_receipt_datatables($search_data) {

        $this->_get_purchase_receipt_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_po')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(discount) AS receipt_discount,SUM(bill_amount) AS receipt_paid,MAX(due_date) AS next_date');
            $this->db->where('purchase_receipt_bill.receipt_id', $val['id']);
            $query[$i]['receipt_bill'] = $this->db->get('purchase_receipt_bill')->result_array();
            $i++;
        }
        $j = 0;
        foreach ($query as $val) {
            $this->db->select('erp_po_details.*');
            $this->db->where('erp_po_details.po_id', $val['id']);
            $query[$j]['po_details'] = $this->db->get('erp_po_details')->result_array();
            $j++;
        }
        return $query;
    }

    function _get_purchase_receipt_datatables_query($serch_data = array()) {

        if (isset($serch_data) && !empty($serch_data)) {
            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';


            if (!empty($serch_data['q_no']) && $serch_data['q_no'] != 'Select PO NO') {

                $this->db->where($this->erp_po . '.po_no', $serch_data['q_no']);
            }
            if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select Company Name') {
                $this->db->where($this->vendor . '.id', $serch_data['customer']);
            }

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_po . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        $this->db->select('erp_po.*');
        $this->db->select('vendor.store_name');
        $this->db->order_by('erp_po.id', 'desc');
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');

        $i = 0;
        $column_order = array(null, 'erp_po.po_no', 'vendor.store_name', 'erp_po.net_total', null, null, null, null, null);
        $column_search = array('erp_po.po_no', 'vendor.store_name', 'erp_po.net_total');
        $order = array('erp_po.id' => 'DESC');

        foreach ($column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i == 0) { // first loop
                    $where .= "(";
                }
                $string = $item;
                $str_arr = explode(".", $string);
                $where .= '`' . $str_arr[0] . "`" . '.' . "`" . $str_arr[1] . "` like '%" . $_POST['search']['value'] . "%'";
                if ((count($column_search) - 1) != $i)
                    $where .= ' OR ';
                if ((count($column_search) - 1) == $i)
                    $where .= ")";
            }
            $i++;
        }
        if ($where != '')
            $this->db->where($where);
        if (isset($_POST['order']) && $column_order[$_POST['order']['0']['column']] != null) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_purchase_receipt() {
        $this->_get_purchase_receipt_datatables_query();
        $query = $this->db->get('erp_po');
        return $query->num_rows();
    }

    function count_all_purchase_receipt() {
        $this->_get_purchase_receipt_datatables_query();
        $this->db->from('erp_po');
        return $this->db->count_all_results();
    }

    function get_grn_datatables($search_data) {
        $this->_get_grn_datatables_query($search_data);

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('gen')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(delivery_quantity) AS delivery_qty');
            $this->db->where('gen_details.gen_id', $val['id']);
            $query[$i]['deliver'] = $this->db->get('gen_details')->result_array();
            $i++;
        }
        return $query;
    }

    function _get_grn_datatables_query($serch_data = array()) {

        if (isset($serch_data) && !empty($serch_data)) {
            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';


            if (!empty($serch_data['po_no']) && $serch_data['po_no'] != 'Select PO NO') {

                $this->db->where('gen.po_no', $serch_data['po_no']);
            }
            if (!empty($serch_data['grn_no']) && $serch_data['grn_no'] != 'Select GRN NO') {

                $this->db->where('gen.grn_no', $serch_data['grn_no']);
            }
            if (!empty($serch_data['supplier']) && $serch_data['supplier'] != 'Select Vendor') {
                $this->db->where($this->vendor . '.name', $serch_data['supplier']);
            }

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_grn . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_grn . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_grn . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_grn . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        $this->db->select('gen.*');
        $this->db->select('vendor.store_name,vendor.name');
//        $this->db->order_by('gen.id', 'desc');
        $this->db->join('vendor', 'vendor.id=gen.supplier');

        $i = 0;
        $column_order = array(null, 'gen.grn_no', 'gen.po_no', 'vendor.name', null, 'gen.net_total', 'gen.inv_date', null);
        $column_search = array('gen.grn_no', 'gen.po_no', 'vendor.name', 'gen.net_total', 'gen.inv_date');
        $order = array('gen.id' => 'DESC');

        foreach ($column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i == 0) { // first loop
                    $where .= "(";
                }
                $string = $item;
                $str_arr = explode(".", $string);
                $where .= '`' . $str_arr[0] . "`" . '.' . "`" . $str_arr[1] . "` like '%" . $_POST['search']['value'] . "%'";
                if ((count($column_search) - 1) != $i)
                    $where .= ' OR ';
                if ((count($column_search) - 1) == $i)
                    $where .= ")";
            }
            $i++;
        }
        if ($where != '')
            $this->db->where($where);

        if (isset($_POST['order']) && $column_order[$_POST['order']['0']['column']] != null) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_grn() {
        $this->_get_grn_datatables_query();
        $query = $this->db->get('gen');
        return $query->num_rows();
    }

    function count_all_grn() {
        $this->_get_grn_datatables_query();
        $this->db->from('gen');
        return $this->db->count_all_results();
    }

    function get_outstanding_datatables($search_data) {

        $this->_get_outstanding_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
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

    function _get_outstanding_datatables_query($serch_data = array()) {

        $this->db->select('erp_invoice.*');
        $this->db->select('customer.name,customer.store_name,customer.state_id');
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
        $this->db->join('erp_quotation', 'erp_quotation.id=erp_invoice.q_id');
        if (!empty($serch_data['customer']) && $serch_data['customer'] != 'Select Company Name') {
            $this->db->where($this->erp_invoice . '.customer', $serch_data['customer']);
        }

        if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
        } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

            $this->db->where("DATE_FORMAT(" . $this->erp_invoice . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
        }
        $i = 0;
        $column_order = array(null, 'erp_invoice.inv_id', 'customer.store_name', 'erp_invoice.net_total', 'erp_invoice.advance', 'erp_invoice.payment_status', null, null, null, null, null, null);
        $column_search = array('erp_invoice.inv_id', 'customer.store_name', 'erp_invoice.net_total', 'erp_invoice.advance', 'erp_invoice.payment_status');
        $order = array('erp_invoice.id' => 'DESC');

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
    }

    function count_outstanding_filtered() {
        $this->_get_outstanding_datatables_query();
        $query = $this->db->get('erp_invoice');
        return $query->num_rows();
    }

    function count_all_outstanding() {
        $this->_get_outstanding_datatables_query();
        $this->db->from('erp_invoice');
        return $this->db->count_all_results();
    }

    function get_service_datatables($search_data) {

        $this->_get_service_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_service')->result_array();

        $this->_get_service_datatables_query($search_data, 'count');
        $query_count = $this->db->get('erp_service')->result_array();

        $user_info = $this->user_auth->get_from_session('user_info');
        $user_id = $user_info[0]['id'];
        $pending_count = 0;
        foreach ($query_count as $val) {
            $this->db->select('*');
            $this->db->where('id', intval($val['id']));
            $this->db->where('erp_service.status', 2);
            $this->db->where('erp_service.service_status', 1);
            if ($user_info[0]['role'] != 1) {
                $this->db->where("FIND_IN_SET('$user_id',erp_service.emp_id) > 0");
            }
            $pending_service = $this->db->get('erp_service')->result_array();
            if (!empty($pending_service)) {
                $pending_count++;
            }
        }
        $count = 0;
        foreach ($query_count as $val) {
            $this->db->select('*');
            $this->db->where('id', intval($val['id']));
            $this->db->where('erp_service.status', 1);
            $this->db->where('erp_service.service_status', 1);
            if ($user_info[0]['role'] != 1) {
                $this->db->where("FIND_IN_SET('$user_id',erp_service.emp_id) > 0");
            }
            $completed_service = $this->db->get('erp_service')->result_array();
            if (!empty($completed_service)) {
                $count++;
            }
        }
        $query[0]['total_service'] = count($query_count);
        $query[0]['completed_service'] = $count;
        $query[0]['pending_service'] = $pending_count;

        return $query;
    }

    function _get_service_datatables_query($serch_data = array(), $type = null) {
        if (isset($serch_data) && !empty($serch_data)) {
            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_service . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_service . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_service . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_service . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        if ($type == null) {
            $this->db->select('erp_service.*');
        } else {
            $this->db->select('erp_service.id');
        }

        $this->db->where('erp_service.status !=', 0);
        $this->db->where('erp_service.service_status', 1);
        $user_info = $this->user_auth->get_from_session('user_info');
        $user_id = $user_info[0]['id'];
        if ($user_info[0]['role'] != 1) {
            $this->db->where("FIND_IN_SET('$user_id',erp_service.emp_id) > 0");
        }

        $i = 0;
        $column_order = array(null, 'erp_service.inv_no', 'erp_service.ticket_no', 'erp_service.description', 'erp_service.warrenty', 'erp_service.created_date');
        $column_search = array('erp_service.inv_no', 'erp_service.ticket_no', 'erp_service.description', 'erp_service.warrenty', 'erp_service.created_date');
        $order = array('erp_service.id' => 'DESC');

        foreach ($column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if(strtotime($_POST['search']['value']))
                    $value = date('Y-m-d',strtotime($_POST['search']['value']));
                else
                    $value = $_POST['search']['value'];    
                if ($i == 0) { // first loop
                    $where .= "(";
                }
                $string = $item;
                $str_arr = explode(".", $string);

                $where .= '`' . $str_arr[0] . "`" . '.' . "`" . $str_arr[1] . "` like '%" . $value . "%'";
                if ((count($column_search) - 1) != $i)
                    $where .= ' OR ';
                if ((count($column_search) - 1) == $i)
                    $where .= ")";
            }
            $i++;
        }

        if ($where != '')
            $this->db->where($where);
        if (isset($_POST['order']) && $column_order[$_POST['order']['0']['column']] != null) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_service($search_data=array()) {
        $this->_get_service_datatables_query($search_data);
        $query = $this->db->get('erp_service');
        return $query->num_rows();
    }

    function count_all_service($search_data=array()) {
        $this->_get_service_datatables_query($search_data);
        $this->db->from('erp_service');
        return $this->db->count_all_results();
    }

    function get_all_service_report() {
        $user_info = $this->user_auth->get_from_session('user_info');
        $user_id = $user_info[0]['id'];
        $this->db->select('erp_service.*');
        $this->db->where('status !=', 0);
        $this->db->where('erp_service.service_status', 1);

        if ($user_info[0]['role'] != 1) {
            $this->db->where("FIND_IN_SET('$user_id',emp_id) > 0");
        }
        $query = $this->db->get('erp_service')->result_array();
        $j = 0;
        $this->db->select('COUNT(erp_service.id) as id');
        $this->db->where('erp_service.status', 2);
        $this->db->where('erp_service.service_status', 1);
        if ($user_info[0]['role'] != 1) {
            $this->db->where("FIND_IN_SET('$user_id',emp_id) > 0");
        }
        $query[$j]["pending_total"] = $this->db->get('erp_service')->result_array();
        $k = 0;
        $this->db->select('COUNT(erp_service.id) as id');
        $this->db->where('erp_service.service_status', 1);
        if ($user_info[0]['role'] != 1) {
            $this->db->where("FIND_IN_SET('$user_id',emp_id) > 0");
        }
        $this->db->where('erp_service.status', 1);
        $query[$k]["completed_total"] = $this->db->get('erp_service')->result_array();
        $l = 0;
        $this->db->select('COUNT(erp_service.id) as id');
        $this->db->where('status !=', 0);
        $this->db->where('erp_service.service_status', 1);
        if ($user_info[0]['role'] != 1) {
            $this->db->where("FIND_IN_SET('$user_id',emp_id) > 0");
        }
        $query[$l]["total_service"] = $this->db->get('erp_service')->result_array();

        return $query;
    }

    function get_all_employee_attendance() {
        $this->db->select('erp_user.*,erp_attendance.attendance_status');
        $this->db->where('erp_user.status', 1);
        $this->db->join('erp_attendance', 'erp_attendance.user_id=erp_user.id', 'LEFT');
        $query = $this->db->get('erp_user')->result_array();
        return $query;
    }

    function get_monthly_attendance_datatables($search_data) {
        $monthly_reports = [];
        $this->_get_monthly_att_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $monthly_reports = $this->db->get('erp_user')->result_array();
        $start_date = date('Y-m-01');
        $end_date = date('Y-m-d');
        if ($search_data != "") {
            if ($search_data['from_date'] != "") {
                $start_date = date('Y-m-d', strtotime($search_data['from_date']));
            }
            if ($search_data['to_date'] != "") {
                $end_date = date('Y-m-d', strtotime($search_data['to_date']));
            }
        }

        if (count($monthly_reports) > 0) {
            foreach ($monthly_reports as $key => $user_data) {

                $s_date = date('d-m-Y', strtotime($start_date));
                $std_dt = $end_date . " 00:00:00";
                $exclude_date = new DateTime($std_dt . ' +1 day');
                $e_date = $exclude_date->format('d-m-Y');

                $start = new DateTime($s_date . ' 00:00:00');
                $end = new DateTime($e_date . ' 00:00:00');
                $interval = new DateInterval('P1D');
                $period = new DatePeriod($start, $interval, $end);
                $days_array = "";
                foreach ($period as $date) {
                    $days_array[] = $date->format('d-m-Y');
                }
                $current_day = "";
                for ($d = 0; $d <= count($days_array) - 1; $d++) {
                    $current_day[] = explode("-", $days_array[$d]);
                    $day_array[] = $current_day[0];
                }

                $periods = "";
                foreach ($current_day as $key1 => $dates) {
                    $periods[$key1]['date'] = $dates[0];
                    $periods[$key1]['month'] = $dates[1];
                    $periods[$key1]['year'] = $dates[2];
                    $check_date = $dates[2] . "-" . $dates[1] . "-" . $dates[0];

                    $current_date = date('Y-m-d H:i');
                    $explode_current_date = explode(' ', $current_date);
                    $currenct_time = $explode_current_date[1];
                    $explode_currenct_time = explode(':', $currenct_time);
                    $currenct_hr = $explode_currenct_time[0];
                    $currenct_mins = $explode_currenct_time[1];
                    $check_date_name = $dates[2] . $dates[1] . $dates[0] . $currenct_hr . $currenct_mins;

                    $datetime = DateTime::createFromFormat('YmdHi', $check_date_name);
                    $day_name = $datetime->format('D');
                    $periods[$key1]['day_name'] = $day_name;

                    $this->db->where('user_id', $user_data['id']);
                    $this->db->where('DATE(erp_attendance.created_date)=', $check_date);
                    $attendance_details = $this->db->get('erp_attendance')->result_array();

                    if (count($attendance_details) > 0) {
                        $check_attend = $this->check_attendance($attendance_details[0]['status']);
                        $periods[$key1]['month_attenance'] = $check_attend;
                    } else {
                        $periods[$key1]['month_attenance'] = 'A';
                    }
                }

                $monthly_reports[$key]['monthly_works'] = $periods;
            }

            return $monthly_reports;
        }
    }

    function _get_monthly_att_datatables_query($serch_data = array()) {

        $this->db->select('erp_user.*');
        $this->db->where('erp_user.status', 1);
        $i = 0;
        $column_order = array(null, 'erp_user.emp_code', 'erp_user.name');
        $column_search = array('erp_user.emp_code', 'erp_user.name');
        $order = array('erp_user.id' => 'DESC');

        foreach ($column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i == 0) { // first loop
                    $where .= "(";
                }
                $string = $item;
                $str_arr = explode(".", $string);

                $where .= '`' . $str_arr[0] . "`" . '.' . "`" . $str_arr[1] . "` like '%" . $_POST['search']['value'] . "%'";
                if ((count($column_search) - 1) != $i)
                    $where .= ' OR ';
                if ((count($column_search) - 1) == $i)
                    $where .= ")";
            }
            $i++;
        }

        if ($where != '')
            $this->db->where($where);
        if (isset($_POST['order']) && $column_order[$_POST['order']['0']['column']] != null) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_monthly_attendance() {
        $this->_get_monthly_att_datatables_query();
        $query = $this->db->get('erp_user');
        return $query->num_rows();
    }

    function count_all_monthly_attendance() {
        $this->_get_monthly_att_datatables_query();
        $this->db->from('erp_user');
        return $this->db->count_all_results();
    }

    function get_all_monthly_reports($start_date, $end_date) {
        $monthly_reports = [];
        $this->db->select('erp_user.id,erp_user.emp_code,erp_user.name');
        $this->db->where('erp_user.status', 1);
        $this->db->order_by('erp_user.id', 'desc');
        $monthly_reports = $this->db->get('erp_user')->result_array();
        if (count($monthly_reports) > 0) {
            foreach ($monthly_reports as $key => $user_data) {

                $s_date = date('d-m-Y', strtotime($start_date));
                $std_dt = $end_date . " 00:00:00";
                $exclude_date = new DateTime($std_dt . ' +1 day');
                $e_date = $exclude_date->format('d-m-Y');

                $start = new DateTime($s_date . ' 00:00:00');
                $end = new DateTime($e_date . ' 00:00:00');
                $interval = new DateInterval('P1D');
                $period = new DatePeriod($start, $interval, $end);
                $days_array = "";
                foreach ($period as $date) {
                    $days_array[] = $date->format('d-m-Y');
                }
                $current_day = "";
                for ($d = 0; $d <= count($days_array) - 1; $d++) {
                    $current_day[] = explode("-", $days_array[$d]);
                    $day_array[] = $current_day[0];
                }
                $periods = "";
                foreach ($current_day as $key1 => $dates) {
                    $periods[$key1]['date'] = $dates[0];
                    $periods[$key1]['month'] = $dates[1];
                    $periods[$key1]['year'] = $dates[2];
                    $check_date = $dates[2] . "-" . $dates[1] . "-" . $dates[0];

                    $current_date = date('Y-m-d H:i');
                    $explode_current_date = explode(' ', $current_date);
                    $currenct_time = $explode_current_date[1];
                    $explode_currenct_time = explode(':', $currenct_time);
                    $currenct_hr = $explode_currenct_time[0];
                    $currenct_mins = $explode_currenct_time[1];
                    $check_date_name = $dates[2] . $dates[1] . $dates[0] . $currenct_hr . $currenct_mins;

                    $datetime = DateTime::createFromFormat('YmdHi', $check_date_name);
                    $day_name = $datetime->format('D');
                    $periods[$key1]['day_name'] = $day_name;

                    $this->db->where('user_id', $user_data['id']);
                    $this->db->where('DATE(erp_attendance.created_date)=', $check_date);
                    $attendance_details = $this->db->get('erp_attendance')->result_array();

                    if (count($attendance_details) > 0) {
                        $check_attend = $this->check_attendance($attendance_details[0]['status']);
                        $periods[$key1]['month_attenance'] = $check_attend;
                        if ($attendance_details[0]['login_location'] == '') {
                            $periods[$key1]['location'] = '-';
                        } else {
                            $periods[$key1]['location'] = $attendance_details[0]['login_location'];
                        }
                    } else {
                        $periods[$key1]['month_attenance'] = 'A';
                        $periods[$key1]['location'] = '-';
                    }
                }

                $monthly_reports[$key]['monthly_works'] = $periods;
            }

            return $monthly_reports;
        }
    }

    function check_attendance($status) {

        if ($status == '1') {
            $data['month_attenance'] = "P";
            return 'P';
        } else {
            $data['month_attenance'] = "A";
            return 'A';
        }
    }

    function get_daily_cash_book_datatables($search_data) {

        $this->_get_daily_cash_book_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_expense')->result_array();

        return $query;
    }

    function _get_daily_cash_book_datatables_query($serch_data = array()) {
        if (isset($serch_data) && !empty($serch_data)) {
            if (!empty($serch_data['category']) && $serch_data['category'] != 'Select Category') {
                $this->db->where('erp_expense_category.category_name', $serch_data['category']);
            }
        }
        $this->db->select('erp_expense.*,erp_expense_category.category_name');
        $this->db->join('erp_expense_category', 'erp_expense_category.id = erp_expense.exp_cat_type', 'LEFT');

        $i = 0;
        $column_order = array(null, 'erp_expense.created_at', 'erp_expense.remarks', 'erp_expense_category.category_name', 'erp_expense.exp_amount', 'erp_expense.exp_mode',);
        $column_search = array('erp_expense.created_at', 'erp_expense.remarks', 'erp_expense_category.category_name', 'erp_expense.exp_amount', 'erp_expense.exp_mode',);
        $order = array('erp_expense.id' => 'DESC');

        foreach ($column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i == 0) { // first loop
                    $where .= "(";
                }
                $string = $item;
                $str_arr = explode(".", $string);

                $where .= '`' . $str_arr[0] . "`" . '.' . "`" . $str_arr[1] . "` like '%" . $_POST['search']['value'] . "%'";
                if ((count($column_search) - 1) != $i)
                    $where .= ' OR ';
                if ((count($column_search) - 1) == $i)
                    $where .= ")";
            }
            $i++;
        }

        if ($where != '')
            $this->db->where($where);
        if (isset($_POST['order']) && $column_order[$_POST['order']['0']['column']] != null) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_daily_cash_book() {
        $this->_get_daily_cash_book_datatables_query();
        $query = $this->db->get('erp_expense');
        return $query->num_rows();
    }

    function count_all_daily_cash_book() {
        $this->_get_daily_cash_book_datatables_query();
        $this->db->from('erp_expense');
        return $this->db->count_all_results();
    }

    function get_all_expense_cat() {
        $this->db->select('erp_expense_category.*');
        $this->db->order_by('erp_expense_category.id', DESC);
        $this->db->where('erp_expense_category.is_deleted', 0);
        $this->db->where('erp_expense_category.status', 1);
        $query = $this->db->get('erp_expense_category');


        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_servcie_material_datatables($search_data) {

        $this->_get_service_material_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_service_dc')->result_array();

        return $query;
    }

    function _get_service_material_datatables_query($serch_data = array()) {
        if (isset($serch_data) && !empty($serch_data)) {
            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';

            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_service_dc . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(" . $this->erp_service_dc . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_service_dc . ".created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(" . $this->erp_service_dc . ".created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        $this->db->select('erp_service_dc.*,erp_invoice.inv_id as invoice_no,erp_invoice.created_date as inv_date');
        $this->db->join('erp_invoice', 'erp_invoice.id=erp_service_dc.inv_id', 'LEFT');
        $i = 0;
        $column_order = array(null, 'erp_service_dc.dc_no', null, 'erp_service_dc.project', 'erp_service_dc.service_type', 'erp_service_dc.total_qty', 'erp_service_dc.created_date');
        $column_search = array('erp_service_dc.dc_no', 'erp_service_dc.project', 'erp_service_dc.service_type', 'erp_service_dc.total_qty', 'erp_service_dc.created_date');
        $order = array('erp_service_dc.id' => 'DESC');

        foreach ($column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i == 0) { // first loop
                    $where .= "(";
                }
                $string = $item;
                $str_arr = explode(".", $string);

                $where .= '`' . $str_arr[0] . "`" . '.' . "`" . $str_arr[1] . "` like '%" . $_POST['search']['value'] . "%'";
                if ((count($column_search) - 1) != $i)
                    $where .= ' OR ';
                if ((count($column_search) - 1) == $i)
                    $where .= ")";
            }
            $i++;
        }

        if ($where != '')
            $this->db->where($where);
        if (isset($_POST['order']) && $column_order[$_POST['order']['0']['column']] != null) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_service_material() {
        $this->_get_service_material_datatables_query();
        $query = $this->db->get('erp_service_dc');
        return $query->num_rows();
    }

    function count_all_service_material() {
        $this->_get_service_material_datatables_query();
        $this->db->from('erp_service_dc');
        return $this->db->count_all_results();
    }

}
