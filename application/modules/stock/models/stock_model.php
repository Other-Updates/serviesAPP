<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stock_model extends CI_Model {

    private $erp_stock = 'erp_stock';
    private $erp_category = 'erp_category';
    private $erp_product = 'erp_product';
    private $erp_brand = 'erp_brand';

    function __construct() {
        parent::__construct();
    }

    public function get_all_stock($serch_data) {

        if (isset($serch_data) && !empty($serch_data)) {

            if (!empty($serch_data['category']) && $serch_data['category'] != 'Select') {

                $this->db->where($this->erp_stock . '.category', $serch_data['category']);
            }
            if (!empty($serch_data['brand']) && $serch_data['brand'] != 'Select') {
                $this->db->where($this->erp_stock . '.brand', $serch_data['brand']);
            }
            if (!empty($serch_data['model_no']) && $serch_data['model_no'] != 'Select') {
                $this->db->where($this->erp_stock . '.product_id', $serch_data['model_no']);
            }
        }
        $this->db->select('erp_category.categoryName,erp_product.product_name,erp_brand.brands,erp_stock.quantity,erp_product.model_no');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_stock.category');
        $this->db->join('erp_product', 'erp_product.id=erp_stock.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_stock.brand');
        $query = $this->db->get('erp_stock');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_stock_by_id($id) {
        $this->db->select('erp_stock.*');
        $this->db->where('erp_stock.id', $id);
        $query = $this->db->get('erp_stock')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('erp_po_details.quantity,erp_po.po_no,erp_po.supplier');
            $this->db->select('vendor.store_name,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1');
            $this->db->where('erp_po_details.product_id', $val['product_id']);
            $this->db->where('erp_po_details.category', $val['category']);
            $this->db->where('erp_po_details.brand', $val['brand']);
            $this->db->join('erp_po', 'erp_po.id=erp_po_details.po_id');
            $this->db->join('vendor', 'vendor.id=erp_po.supplier');
            $this->db->join('erp_product', 'erp_product.id=erp_po_details.product_id');
            $this->db->order_by('erp_po.id', 'desc');
            $query[$i]['stock_details'] = $this->db->get('erp_po_details')->result_array();
            $i++;
        }
        return $query;
    }

    function get_datatables($search_data) {

        $this->_get_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_stock')->result_array();

        return $query;
    }

    function _get_datatables_query($serch_data = array()) {

        if (isset($serch_data) && !empty($serch_data)) {

            if (!empty($serch_data['category']) && $serch_data['category'] != 'Select') {

                $this->db->where($this->erp_stock . '.category', $serch_data['category']);
            }
            if (!empty($serch_data['brand']) && $serch_data['brand'] != 'Select') {
                $this->db->where($this->erp_stock . '.brand', $serch_data['brand']);
            }
            if (!empty($serch_data['model_no']) && $serch_data['model_no'] != 'Select') {
                $this->db->where($this->erp_stock . '.product_id', $serch_data['model_no']);
            }
        }
        $this->db->select('erp_category.categoryName,erp_product.product_name,erp_brand.brands,IF(erp_stock.quantity <=0,"0",erp_stock.quantity) as quantity,erp_product.model_no,erp_stock.id',false);
        $this->db->join('erp_category', 'erp_category.cat_id=erp_stock.category');
        $this->db->join('erp_product', 'erp_product.id=erp_stock.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_stock.brand');
        $this->db->order_by('erp_stock.product_sales_count', DESC);
        $i = 0;
        $column_order = array(null, 'erp_category.categoryName', 'erp_brand.brands', 'erp_product.model_no', 'erp_product.product_name', 'erp_stock.quantity');
        $column_search = array('erp_category.categoryName', 'erp_brand.brands', 'erp_product.model_no', 'erp_product.product_name', 'erp_stock.quantity');
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

}
