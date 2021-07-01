<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Death_stock_model extends CI_Model {

    private $erp_stock = 'erp_stock';
    private $erp_category = 'erp_category';
    private $erp_product = 'erp_product';
    private $erp_brand = 'erp_brand';
 private $erp_death_stock = 'erp_death_stock';
    function __construct() {
        parent::__construct();
    }

   

   

    function get_datatables($search_data) {

        $this->_get_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_stock')->result_array();

        return $query;
    }

    function _get_datatables_query($serch_data = array()) {

       
        $this->db->select('erp_product.product_name,erp_stock.quantity,erp_product.model_no,erp_stock.id ,erp_death_stock.quantity as death_qty,erp_death_stock.created_date');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_stock.category');
        $this->db->join('erp_product', 'erp_product.id=erp_stock.product_id');
  $this->db->join('erp_death_stock', 'erp_death_stock.product_id=erp_stock.product_id');
       
        $i = 0;
        $column_order = array(null, 'erp_category.categoryName',  'erp_product.model_no', 'erp_product.product_name', 'erp_stock.quantity');
        $column_search = array('erp_category.categoryName',  'erp_product.model_no', 'erp_product.product_name', 'erp_stock.quantity');
        $order = array('erp_stock.id' => 'DESC');

        foreach ($column_search as $item) { // loop column
            if ($serch_data['search']['value']) { // if datatable send POST for search
                if ($i == 0) { // first loop
                    $where .="(";
                }
                $string = $item;
                $str_arr = explode(".", $string);
                $where .= '`' . $str_arr[0] . "`" . '.' . "`" . $str_arr[1] . "` like '%" . $serch_data['search']['value'] . "%'";
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

    function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get('erp_stock');
        return $query->num_rows();
    }

    function count_all() {
        $this->_get_datatables_query();
        $this->db->from('erp_stock');
        return $this->db->count_all_results();
    }
	public function get_all_model_number() {
        $this->db->select('erp_product.id,erp_product.model_no');
        $this->db->where($this->erp_product . '.status', 1);
		 $this->db->join('erp_stock', 'erp_stock.product_id=erp_product.id');
        $query = $this->db->get($this->erp_product)->result_array();
        return $query;
    }
  public function insert_death_stock_details($data) {
        if ($this->db->insert($this->erp_death_stock, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }
 public function get_stock_details_by_id($id) {
        $this->db->select('erp_stock.*');
        $this->db->where('erp_stock.product_id', $id);
        $query = $this->db->get('erp_stock')->result_array();
       
        return $query;
    }
	function update_death_stock($data, $id) {
        $this->db->where('product_id', $id);
        if ($this->db->update($this->erp_stock, $data)) {
            return TRUE;
        }
        return FALSE;
    }
}
