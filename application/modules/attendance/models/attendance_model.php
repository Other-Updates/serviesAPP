<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Attendance_model extends CI_Model {

    private $table_name = 'erp_user';
    var $primaryTable = 'erp_user tab_1';
    var $selectColumn = 'tab_1.*';
    var $column_order = array('tab_1.id', 'tab_1.emp_code', 'tab_1.name');
    var $column_search = array('tab_1.id', 'tab_1.emp_code', 'tab_1.name');
    var $order = array('tab_1.id' => 'desc ');

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_datatables($search_data) {

        $this->db->select('tab_1.*');
        $this->db->where('tab_1.status =', 1);

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

        $this->db->select('tab_1.*');
        $this->db->where('tab_1.status =', 1);
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

}
