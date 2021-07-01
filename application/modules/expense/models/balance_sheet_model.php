<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Balance_sheet_model extends CI_Model {

    private $table_name = 'erp_expense';
    private $expense_category = 'erp_expense_category';
    private $company_details = 'company_details';
    private $balance_sheet = 'erp_balance_sheet';
    var $joinTable2 = 'erp_expense_category tab_4';
    var $primaryTable = 'erp_expense tab_1';
    var $selectColumn = 'tab_1.*,tab_4.category_name';
    var $column_order = array('tab_1.id', 'tab_4.category_name', 'tab_1.exp_mode', 'tab_1.exp_amount');
    var $column_search = array('tab_1.id', 'tab_4.category_name', 'tab_1.exp_mode', 'tab_1.exp_amount');
    var $order = array('tab_1.id' => 'desc');

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function edit_is_expense_category_available($exp_category, $id) {
        $this->db->select('tab_1.*');
        $this->db->where('LCASE(tab_1.category_name)', strtolower($exp_category));
        $this->db->where('tab_1.status', 1);
        $this->db->where('tab_1.is_deleted', 0);
        $this->db->where('tab_1.id !=', $id);
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    public function getCompanyAmt() {
        $this->db->select('company_amount, opening_balance');
        $query = $this->db->get('company_details')->result_array();
        return $query;
    }

    public function insert_balance_sheet($data) {
        if ($this->db->insert($this->balance_sheet, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return FALSE;
    }

    public function update_company_amt($data) {
        $data['company_amount'] = $data;
        $this->db->where('id', 1);
        if ($this->db->update($this->company_details, array('company_amount' => $data))) {
            return true;
        }
        return false;
    }

    public function update_balance_sheet($input, $id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->balance_sheet, $input)) {
            return true;
        }
        return false;
    }

    public function get_balance_datatables($search_data) {
        $this->db->select('tab_2.opening_balance,tab_1.*,tab_4.category_name');
        $this->db->join($this->company_details . ' AS tab_2', 'tab_2.id = tab_1.firm_id', 'LEFT');
        $this->db->join($this->expense_category . ' AS tab_4', 'tab_4.id = tab_1.cat_id', 'LEFT');

        if (isset($search_data) && !empty($search_data)) {
            if (!empty($search_data['from_date']))
                $search_data['from_date'] = date('Y-m-d', strtotime($search_data['from_date']));
            if (!empty($search_data['to_date']))
                $search_data['to_date'] = date('Y-m-d', strtotime($search_data['to_date']));
            if ($search_data['from_date'] == '1970-01-01')
                $search_data['from_date'] = '';
            if ($search_data['to_date'] == '1970-01-01')
                $search_data['to_date'] = '';
            if (isset($search_data["from_date"]) && $search_data["from_date"] != "" && isset($search_data["to_date"]) && $search_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(tab_1.created_at,'%Y-%m-%d') >='" . $search_data["from_date"] . "' AND DATE_FORMAT(tab_1.created_at,'%Y-%m-%d') <= '" . $search_data["to_date"] . "'");
            } elseif (isset($search_data["from_date"]) && $search_data["from_date"] != "" && isset($search_data["to_date"]) && $search_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(tab_1.created_at,'%Y-%m-%d') >='" . $search_data["from_date"] . "'");
            } elseif (isset($search_data["from_date"]) && $search_data["from_date"] == "" && isset($search_data["to_date"]) && $search_data["to_date"] != "") {
                $this->db->where("DATE_FORMAT(tab_1.created_at,'%Y-%m-%d') <= '" . $search_data["to_date"] . "'");
            }
//            else {
//                $this->db->where('DATE(tab_1.created_at) = DATE(NOW())');
//            }
            if (!empty($search_data['firm_id']) && $search_data['firm_id'] != 'Select') {

                $this->db->where('tab_1.firm_id', $search_data['firm_id']);
            }
            if (!empty($search_data['exp_cat_type']) && $search_data['exp_cat_type'] != 'Select') {

                $this->db->where('tab_1.cat_id', $search_data['exp_cat_type']);
            }
        }

        $i = 0;
        $column_order = array('tab_1.id', 'tab_1.type', 'tab_2.opening_balance', 'tab_1.amount', 'tab_1.balance', 'tab_1.created_at');
        $column_search = array('tab_1.id', 'tab_1.type', 'tab_2.opening_balance', 'tab_1.amount', 'tab_1.balance', 'tab_1.created_at');
        $order = array('tab_1.id' => 'ASC');
        foreach ($column_search as $item) { // loop column
            if ($search_data['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->like($item, $search_data['search']['value']);
                } else {
                    $this->db->or_like($item, $search_data['search']['value']);
                }
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get($this->balance_sheet . ' AS tab_1');


        return $query->result();
    }

    public function count_all_balance() {

        $this->db->from($this->balance_sheet);
        return $this->db->count_all_results();
    }

    public function count_filtered_balance($search_data) {

        $this->db->select('tab_2.opening_balance,tab_1.*,tab_4.category_name');
        $this->db->join($this->company_details . ' AS tab_2', 'tab_2.id = tab_1.firm_id', 'LEFT');
        $this->db->join($this->expense_category . ' AS tab_4', 'tab_4.id = tab_1.cat_id', 'LEFT');



        if (isset($search_data) && !empty($search_data)) {
            if (!empty($search_data['from_date']))
                $search_data['from_date'] = date('Y-m-d', strtotime($search_data['from_date']));
            if (!empty($search_data['to_date']))
                $search_data['to_date'] = date('Y-m-d', strtotime($search_data['to_date']));
            if ($search_data['from_date'] == '1970-01-01')
                $search_data['from_date'] = '';
            if ($search_data['to_date'] == '1970-01-01')
                $search_data['to_date'] = '';
            if (isset($search_data["from_date"]) && $search_data["from_date"] != "" && isset($search_data["to_date"]) && $search_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(tab_1.created_at, '%Y-%m-%d') >='" . $search_data["from_date"] . "' AND DATE_FORMAT(tab_1.created_at, '%Y-%m-%d') <= '" . $search_data["to_date"] . "'");
            } elseif (isset($search_data["from_date"]) && $search_data["from_date"] != "" && isset($search_data["to_date"]) && $search_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(tab_1.created_at, '%Y-%m-%d') >='" . $search_data["from_date"] . "'");
            } elseif (isset($search_data["from_date"]) && $search_data["from_date"] == "" && isset($search_data["to_date"]) && $search_data["to_date"] != "") {
                $this->db->where("DATE_FORMAT(tab_1.created_at, '%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
//            else {
//                $this->db->where('DATE(tab_1.created_at) = DATE(NOW())');
//            }
            if (!empty($search_data['firm_id']) && $search_data['firm_id'] != 'Select') {
                $this->db->where('tab_1.firm_id', $search_data['firm_id']);
            }
        }
        $i = 0;
        $column_search = array('tab_1.id', 'tab_1.type', 'tab_2.opening_balance', 'tab_1.amount', 'tab_1.balance', 'tab_1.created_at');
        foreach ($column_search as $item) { // loop column
            if ($search_data['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->like($item, $search_data['search']['value']);
                } else {
                    $this->db->or_like($item, $search_data['search']['value']);
                }
            }
            $i++;
        }
        $query = $this->db->get($this->balance_sheet . ' AS tab_1');

        return $query->num_rows();
    }

    public function get_balance_datas($search_data) {
        $this->db->select('tab_2.opening_balance,tab_1.*,tab_4.category_name');
        $this->db->join($this->company_details . ' AS tab_2', 'tab_2.id = tab_1.firm_id', 'LEFT');
        $this->db->join($this->expense_category . ' AS tab_4', 'tab_4.id = tab_1.cat_id', 'LEFT');


        $this->db->order_by('tab_1.id', 'desc');

        if (isset($search_data) && !empty($search_data)) {
            if (!empty($search_data['from_date']))
                $search_data['from_date'] = date('Y-m-d', strtotime($search_data['from_date']));
            if (!empty($search_data['to_date']))
                $search_data['to_date'] = date('Y-m-d', strtotime($search_data['to_date']));
            if ($search_data['from_date'] == '1970-01-01')
                $search_data['from_date'] = '';
            if ($search_data['to_date'] == '1970-01-01')
                $search_data['to_date'] = '';
            if (isset($search_data["from_date"]) && $search_data["from_date"] != "" && isset($search_data["to_date"]) && $search_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(tab_1.created_at, '%Y-%m-%d') >='" . $search_data["from_date"] . "' AND DATE_FORMAT(tab_1.created_at, '%Y-%m-%d') <= '" . $search_data["to_date"] . "'");
            } elseif (isset($search_data["from_date"]) && $search_data["from_date"] != "" && isset($search_data["to_date"]) && $search_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(tab_1.created_at, '%Y-%m-%d') >='" . $search_data["from_date"] . "'");
            } elseif (isset($search_data["from_date"]) && $search_data["from_date"] == "" && isset($search_data["to_date"]) && $search_data["to_date"] != "") {
                $this->db->where("DATE_FORMAT(tab_1.created_at, '%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
            if (!empty($search_data['firm_id']) && $search_data['firm_id'] != 'Select') {

                $this->db->where('tab_1.firm_id', $search_data['firm_id']);
            }
        }

        $query = $this->db->get($this->balance_sheet . ' AS tab_1');
        return $query->result_array();
    }

}
