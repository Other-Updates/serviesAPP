<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Expense_category_model extends CI_Model {

    private $expense_category_table = 'erp_expense_category';
    var $primaryTable = 'erp_expense_category tab_1';
    var $selectColumn = 'tab_1.*';
    var $column_order = array('tab_1.id', 'tab_1.category_name');
    var $column_search = array('tab_1.id', 'tab_1.category_name');
    var $order = array('tab_1.id' => 'desc ');

    function __construct() {
        parent::__construct();
        /* $this->primaryTable = 'erp_expense_category c';

          $this->select_column = 'c.*';
          $this->column_order = array(null, 'c.category_name', null); //set column field database for datatable orderable
          $this->column_search = array('c.category_name'); //set column field database for datatable searchable
          $this->order = array('c.id' => 'DESC'); // default order

          $this->load->model('masters/user_model');
          $this->load->database();
          $this->where_condition = array('c.is_deleted' => '0'); */
    }

    function insert_expense($data) {
        if ($this->db->insert($this->expense_category_table, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return FALSE;
    }

    function update_expense($data, $id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->expense_category_table, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function delete_expense($id, $data) {
        $this->db->where('id', $id);
        if ($this->db->update($this->expense_category_table, $data)) {
            return 1;
        }
        return 0;
    }

    function get_expense_by_id($id) {
        $this->db->select($this->expense_category_table . '.*');
        $this->db->where($this->expense_category_table . '.id', $id);
        $this->db->where($this->expense_category_table . '.is_deleted', 0);
        $query = $this->db->get($this->expense_category_table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_all_expense() {
        $this->db->select('tab_1.*');
        $this->db->order_by('tab_1.id', DESC);
        $this->db->where('tab_1.is_deleted', 0);
        $query = $this->db->get($this->expense_category_table . ' AS tab_1');
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
        $query = $this->db->get($this->expense_category_table . ' AS tab_1');
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
        $query = $this->db->get($this->expense_category_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    /*  function get_datatables() {
      $primaryTable = $this->primaryTable;
      $select_column = $this->select_column;
      $column_order = $this->column_order;
      $column_search = $this->column_search;
      $order = $this->order;
      $where = $this->where_condition;
      $query = $this->user_model->get_datatables($select_column, $column_order, $column_search, $order, $primaryTable, $where);
      return $query;
      }

      function count_filtered() {

      $primaryTable = $this->primaryTable;
      $select_column = $this->select_column;
      $column_order = $this->column_order;
      $column_search = $this->column_search;
      $order = $this->order; // default order
      $where = $this->where_condition;
      $query = $this->user_model->count_filtered($select_column, $column_order, $column_search, $order, $primaryTable, $where);
      return $query;
      }

      function count_all() {
      $primaryTable = $this->primaryTable;
      $query = $this->user_model->count_all($primaryTable);
      return $query;
      } */

    public function get_datatables($search_data) {

        $this->db->select('tab_1.*');
        $this->db->where('tab_1.status', 1);

        $i = 0;
        foreach ($this->column_search as $item) { // loop column
            if ($search_data['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->like($item, $search_data['search']['value']);
                } else {

                    $this->db->or_like($item, $search_data['search']['value']);
                }
                $this->db->like('tab_1.is_deleted', 0);
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
        $this->db->where('tab_1.is_deleted', 0);

        $query = $this->db->get($this->expense_category_table . ' AS tab_1');
        return $query->result();
    }

    public function count_all() {
        $this->db->where('tab_1.status', 1);
        $this->db->where('tab_1.is_deleted', 0);
        $this->db->from($this->primaryTable);
        return $this->db->count_all_results();
    }

    public function count_filtered($search_data) {

        $this->db->select('tab_1.*');
        $this->db->where('tab_1.status', 1);
        $this->db->where('tab_1.is_deleted', 0);

        $i = 0;

        foreach ($this->column_search as $item) { // loop column
            if ($search_data['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->like($item, $search_data['search']['value']);
                } else {

                    $this->db->or_like($item, $search_data['search']['value']);
                }
                $this->db->like('tab_1.is_deleted', 0);
            }

            $i++;
        }

        $query = $this->db->get($this->expense_category_table . ' AS tab_1');
        return $query->num_rows();
    }

}
