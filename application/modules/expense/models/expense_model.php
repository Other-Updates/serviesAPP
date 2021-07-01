<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expense_model extends CI_Model {

    private $table_name = 'erp_expense';
    private $expense_category = 'erp_expense_category';
    private $company_details = 'company_details';
    private $balance_sheet = 'erp_balance_sheet';
    var $joinTable2 = 'erp_expense_category tab_4';
    var $primaryTable = 'erp_expense tab_1';
    var $selectColumn = 'tab_1.*,tab_4.category_name';
    var $column_order = array('tab_1.id', 'tab_1.exp_date', 'tab_1.remarks', 'tab_4.category_name', 'tab_1.exp_amount', 'tab_1.exp_mode');
    var $column_search = array('tab_1.id', 'tab_1.exp_date', 'tab_1.remarks', 'tab_4.category_name', 'tab_1.exp_amount', 'tab_1.exp_mode');
    var $order = array('tab_1.id' => 'desc ');

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insert_expense($data) {
        if ($this->db->insert($this->table_name, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return FALSE;
    }

    function update_expense($data, $id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function delete_expense($id, $data) {
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data)) {
            return 1;
        }
        return 0;
    }

    function get_expense_by_id($id) {
        $this->db->select($this->table_name . '.*');
        $this->db->where($this->table_name . '.id', $id);
        $this->db->where($this->table_name . '.is_deleted', 0);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_all_expense_category() {
        $this->db->select('tab_1.*');
        $this->db->order_by('tab_1.id', DESC);
        $this->db->where('tab_1.is_deleted', 0);
        $this->db->where('tab_1.status', 1);
        $query = $this->db->get($this->expense_category . ' AS tab_1');


        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_all_expense() {
        $this->db->select('tab_1.*,tab_2.category_name');
        $this->db->order_by('tab_1.id', DESC);
        $this->db->where('tab_1.is_deleted', 0);
        $this->db->join($this->expense_category . ' AS tab_2', 'tab_2.id = tab_1.exp_cat_type');
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function is_expense_category_available($exp_category) {
        $this->db->select('tab_1.*');
        $this->db->where('LCASE(tab_1.category_name)', strtolower($exp_category));
        $this->db->where('tab_1.status', 1);
        $this->db->where('tab_1.is_deleted', 0);
        $query = $this->db->get($this->table_name . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
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

    public function update_company_amt($datas) {

        $this->db->where('id', 1);
        if ($this->db->update($this->company_details, array('company_amount' => $datas))) {
            return true;
        }
        return false;
    }

    public function update_balance_sheet($input, $id) {
        $this->db->where('exp_id', $id);
        if ($this->db->update($this->balance_sheet, $input)) {
            return true;
        }
        return false;
    }

    public function update_balance_sheet_by_qid($input, $id) {
        $this->db->where('q_id', $id);
        if ($this->db->update($this->balance_sheet, $input)) {
            return true;
        }
        return false;
    }

    public function get_datatables($search_data) {

        $this->db->select('tab_1.*,,tab_4.category_name');
        $this->db->join($this->expense_category . ' AS tab_4', 'tab_4.id = tab_1.exp_cat_type', 'LEFT');


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
                $this->db->where("DATE_FORMAT(tab_1.created_at,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }

            if (!empty($search_data['cat_id']) && $search_data['cat_id'] != 'Select') {

                $this->db->where('tab_1.exp_cat_type', $search_data['cat_id']);
            }
        }

        $i = 0;

        foreach ($this->column_search as $item) { // loop column
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
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get($this->table_name . ' AS tab_1');
        return $query->result();
    }

    public function count_all() {
        $this->db->from($this->primaryTable);
        return $this->db->count_all_results();
    }

    public function count_filtered($search_data) {

        $this->db->select('tab_1.*,,tab_4.category_name');
        $this->db->join($this->expense_category . ' AS tab_4', 'tab_4.id = tab_1.exp_cat_type', 'LEFT');


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
                $this->db->where("DATE_FORMAT(tab_1.created_at,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }

            if (!empty($search_data['cat_id']) && $search_data['cat_id'] != 'Select') {

                $this->db->where('tab_1.exp_cat_type', $search_data['cat_id']);
            }
        }

        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if ($search_data['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->like($item, $search_data['search']['value']);
                } else {
                    $this->db->or_like($item, $search_data['search']['value']);
                }
            }
            $i++;
        }
        $query = $this->db->get($this->table_name . ' AS tab_1');

        return $query->num_rows();
    }

    function get_company_amount() {
        $this->db->select('company_amount');
        $query = $this->db->get('company_details')->result_array();
        return $query;
    }

    function get_expense_category_basedon_expense_type() {
        $this->db->select('tab_1.id,tab_1.category_name');

        $this->db->where('tab_1.is_deleted', 0);
        $this->db->where('tab_1.status', 1);
        //$this->db->where('tab_1.exp_type',$exp_type);
        $query = $this->db->get($this->expense_category . ' AS tab_1');


        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_expense_category_by_name($cat_name) {
        $this->db->select('tab_1.id,tab_1.category_name');
        $this->db->where('tab_1.status', 1);
        $this->db->where('tab_1.comments', $cat_name);
        $query = $this->db->get($this->expense_category . ' AS tab_1');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    public function insert_petty_cash($data) {
        if ($this->db->insert('erp_petty_cash_amount', $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return FALSE;
    }

    function get_petty_cash_datas() {
        $this->db->select('*');
        $this->db->where('status', 1);
        $query = $this->db->get('erp_petty_cash_amount');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_pett_cash_datatables($search_data) {

        $this->_get_petty_cash_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_petty_cash_amount')->result_array();

        return $query;
    }

    function _get_petty_cash_datatables_query($serch_data = array()) {
        $this->db->select('erp_petty_cash_amount.*');
        $this->db->where('status', 1);
        $i = 0;
        $column_order = array(null, 'erp_petty_cash_amount.created_at', 'erp_petty_cash_amount.mode', 'erp_petty_cash_amount.amount', 'erp_petty_cash_amount.remarks');
        $column_search = array('erp_petty_cash_amount.created_at', 'erp_petty_cash_amount.mode', 'erp_petty_cash_amount.amount', 'erp_petty_cash_amount.remarks');
        $order = array('erp_petty_cash_amount.id' => 'DESC');

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

    function count_filtered_petty_cash() {
        $this->_get_petty_cash_datatables_query();
        $query = $this->db->get('erp_petty_cash_amount');
        return $query->num_rows();
    }

    function count_all_petty_cash() {
        $this->_get_petty_cash_datatables_query();
        $this->db->from('erp_petty_cash_amount');
        return $this->db->count_all_results();
    }

}
