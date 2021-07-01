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
class Purchase_return_model extends CI_Model {

    private $table_name4 = 'master_style';
    private $table_name5 = 'master_style_size';
    private $vendor = 'vendor';
    private $erp_po = 'erp_po';
    private $erp_po_details = 'erp_po_details';
    private $increment_table = 'increment_table';
    private $erp_product = 'erp_product';
    private $erp_user = 'erp_user';
    private $erp_stock = 'erp_stock';
    private $erp_stock_history = 'erp_stock_history';
    private $erp_pr = 'erp_pr';
    private $erp_pr_details = 'erp_pr_details';
    private $gen_details = 'gen_details';
    var $joinTable1 = 'vendor v';
    var $joinTable2 = 'erp_pr pr';
    var $primaryTable = 'erp_po po';
    var $selectcolumn = 'v.id as vendor, v.store_name,v.name,v.mobil_number,v.email_id,v.address1,erp_po.id,po.po_no,po.total_qty,po.tax,po.tax_label,'
            . 'po.net_total,po.delivery_schedule,po.mode_of_payment,po.remarks,po.subtotal_qty,po.estatus';
    var $column_order = array(null, 'po.po_no', 'v.store_name', null, null, 'po.total_qty', 'po.net_total', 'po.mode_of_payment', 'po.remraks', null);
    var $column_search = array('po.po_no', 'v.store_name', 'po.total_qty', 'po.net_total', 'po.mode_of_payment', 'po.remraks');
    var $order = array('po.id' => 'DESC'); // default order

    function __construct() {
        parent::__construct();
    }

    public function insert_pr($data) {

        if ($this->db->insert($this->erp_pr, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function insert_pr_details($data) {
        $this->db->insert_batch($this->erp_pr_details, $data);
        return true;
    }

    public function insert_po_details($data) {
        $this->db->insert_batch($this->erp_po_details, $data);
        return true;
    }

    public function check_stock($check_stock, $po_id) {
        $this->db->select('*');
        $this->db->where('category', $check_stock['category']);
        $this->db->where('product_id', $check_stock['product_id']);
        $this->db->where('brand', $check_stock['brand']);
        $current_stock = $this->db->get($this->erp_stock)->result_array();
        if (isset($current_stock) && !empty($current_stock)) {
            //Update Stock
            $quantity = $current_stock[0]['quantity'] - $check_stock['return_quantity'];
            $this->db->where('category', $check_stock['category']);
            $this->db->where('product_id', $check_stock['product_id']);
            $this->db->where('brand', $check_stock['brand']);
            $this->db->update($this->erp_stock, array('quantity' => $quantity));
        } else {
            //Insert Stcok
            $insert_stock = array();
            $insert_stock['category'] = $check_stock['category'];
            $insert_stock['product_id'] = $check_stock['product_id'];
            $insert_stock['brand'] = $check_stock['brand'];
            $insert_stock['quantity'] = $check_stock['return_quantity'];
            $this->db->insert($this->erp_stock, $insert_stock);
        }
        //Insert Stock History
        $insert_stock_his = array();
        $insert_stock_his['ref_no'] = $po_id['po_id'];
        $insert_stock_his['type'] = 3;
        $insert_stock_his['category'] = $check_stock['category'];

        $insert_stock_his['product_id'] = $check_stock['product_id'];
        $insert_stock_his['brand'] = $check_stock['brand'];
        $insert_stock_his['quantity'] = -$check_stock['return_quantity'];
        $insert_stock_his['created_date'] = date('Y-m-d H:i');
        //echo"<pre>"; print_r($insert_stock_his); exit;
        $this->db->insert($this->erp_stock_history, $insert_stock_his);
    }

    public function insert_stock_details($data) {

        $this->db->insert_batch($this->erp_stock, $data);
        return true;
    }

    public function insert_stock_history($data) {
        $this->db->insert_batch($this->erp_stock_history, $data);
        return true;
    }

    public function get_stock_details() {
        $this->db->select('*');
        return $this->db->get($this->erp_stock)->result_array();
    }

    public function update_increment($id) {
        $this->db->where($this->increment_table . '.id', 5);
        if ($this->db->update($this->increment_table, $id)) {
            return true;
        }
        return false;
    }

    public function update_po($data, $id) {
        $this->db->where($this->erp_po . '.id', $id);
        if ($this->db->update($this->erp_po, $data)) {
            return true;
        }
        return false;
    }

    public function get_customer($atten_inputs) {
        $this->db->select('name,id,mobil_number,email_id,address1');
        $this->db->where($this->vendor . '.status', 1);
        $this->db->like($this->vendor . '.name', $atten_inputs['q']);
        $query = $this->db->get($this->vendor)->result_array();
        return $query;
    }

    public function get_customer_by_id($id) {
        $this->db->select('name,mobil_number,email_id,address1');
        $this->db->where($this->vendor . '.id', $id);
        return $this->db->get($this->vendor)->result_array();
    }

    public function get_product($atten_inputs) {
        $this->db->select('id,model_no,product_name,product_description,product_image,type,cost_price');
        $this->db->where($this->erp_product . '.status', 1);
        $this->db->where($this->erp_product . '.type', 1);
        $this->db->like($this->erp_product . '.model_no', $atten_inputs['q']);
        $query = $this->db->get($this->erp_product)->result_array();
        return $query;
    }

    public function get_product_by_id($id) {
        $this->db->select('model_no,product_name,product_description,product_image');
        $this->db->where($this->erp_product . '.id', $id);
        return $this->db->get($this->erp_product)->result_array();
    }

    public function get_all_po($serch_data) {

        $this->db->select('vendor.id as vendor, vendor.store_name,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_po.id,erp_po.po_no,erp_po.total_qty,erp_po.tax,erp_po.tax_label,'
                . 'erp_po.net_total,erp_po.delivery_schedule,erp_po.mode_of_payment,erp_po.remarks,erp_po.subtotal_qty,erp_po.estatus');
        $this->db->where('erp_po.estatus !=', 0);
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');
        $query = $this->db->get('erp_po')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('total_qty');
            $this->db->where('po_no', $val['po_no']);
            $this->db->order_by("id", "desc");
            $this->db->limit(1);
            $this->db->order_by("id", "desc");
            $this->db->limit(2);
            $query[$i]['return'] = $this->db->get('erp_pr')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_po_by_id($id) {
        $this->db->select('vendor.id as vendor,vendor.store_name,vendor.state_id, vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_po.id,erp_po.po_no,erp_po.total_qty,erp_po.tax,erp_po.tax_label,'
                . 'erp_po.net_total,erp_po.delivery_schedule,erp_po.mode_of_payment,erp_po.remarks,erp_po.subtotal_qty,erp_po.estatus,erp_po.is_gst');
        //$this->db->where('erp_po.estatus',1);
        $this->db->where('erp_po.id', $id);
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');
        $query = $this->db->get('erp_po');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_product_by_id($id) {
        $this->db->select('erp_product.id,erp_product.model_no,erp_product.product_name,erp_product.product_image,'
                . 'erp_po_details.product_description');
        $this->db->where('erp_po_details.id', $id);
        $this->db->join('erp_po', 'erp_po.id=erp_po_details.po_id');
        $this->db->join('erp_product', 'erp_product.id=erp_po_details.product_id');
        $query = $this->db->get('erp_po_details');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_po_details_by_id($id) {
        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,'
                . 'erp_po_details.category,erp_po_details.product_id,erp_po_details.brand,erp_po_details.quantity,'
                . 'erp_po_details.per_cost,erp_po_details.tax,erp_po_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,'
                . 'erp_po_details.product_description,erp_po_details.gst,erp_po_details.igst,erp_po_details.delivery_quantity,erp_po_details.id as po_details_id');
        $this->db->where('erp_po_details.po_id', $id);
        $this->db->join('erp_po', 'erp_po.id=erp_po_details.po_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_po_details.category');
        $this->db->join('erp_product', 'erp_product.id=erp_po_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_po_details.brand');

        $query = $this->db->get('erp_po_details')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('quantity');
            $this->db->where('category', $val['category']);
            $this->db->where('product_id', $val['product_id']);
            $this->db->where('brand', $val['brand']);
            $this->db->order_by('quantity', 'desc');
            $this->db->limit(1);
            $query[$i]['stock'] = $this->db->get('erp_stock')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_quotation_history_by_id($id) {
        $this->db->select('vendor.id,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_quotation_history.q_no,erp_quotation_history.total_qty,erp_quotation_history.tax,erp_quotation_history.ref_name,erp_quotation_history.tax_label,'
                . 'erp_quotation_history.net_total,erp_quotation_history.delivery_schedule,erp_quotation_history.notification_date,erp_quotation_history.mode_of_payment,erp_quotation_history.remarks,erp_quotation_history.subtotal_qty');
        $this->db->where('erp_quotation_history.eStatus', 1);
        $this->db->where('erp_quotation_history.id', $id);
        $this->db->join('vendor', 'vendor.id=erp_quotation_history.vendor');
        $query = $this->db->get('erp_quotation_history');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function delete_po_details($id) {
        $this->db->where('po_id', $id);
        $this->db->delete($this->erp_po_details);
    }

    public function change_po_status($id, $status) {
        $this->db->where($this->erp_po . '.id', $id);
        if ($this->db->update($this->erp_po, array('estatus' => $status))) {
            return true;
        }
        return false;
    }

    public function delete_po($id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->erp_po, $data = array('estatus' => 0))) {
            return true;
        }
        return false;
    }

    function get_purchase_return_datatables($search_data) {

        $this->_get_purchase_return_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_pr')->result_array();

        return $query;
    }

    function _get_purchase_return_datatables_query($serch_data = array()) {

        $this->db->select('vendor.id as vendor,vendor.state_id, vendor.store_name,vendor.name,erp_pr.*');
        $this->db->select('SUM(erp_pr.total_qty) as return_qty,SUM(erp_pr.net_total) as return_amount');
        $this->db->select('(gen.total_qty) as delivery_qty,(gen.net_total) as delivery_amount');
        $this->db->where('erp_pr.estatus !=', 0);
        $this->db->group_by('gen_id');
        $this->db->join('vendor', 'vendor.id=erp_pr.supplier');
        $this->db->join('gen', 'gen.id=erp_pr.gen_id', 'left');

        $i = 0;
        $column_order = array(null, 'erp_pr.grn_no', 'vendor.store_name', 'gen.total_qty', 'gen.net_total', 'erp_pr.total_qty', 'erp_pr.net_total', null);
        $column_search = array('erp_pr.grn_no', 'vendor.store_name', 'gen.total_qty', 'gen.net_total', 'erp_pr.total_qty', 'erp_pr.net_total');
        $order = array('erp_pr.id' => 'DESC');

        foreach ($column_search as $item) { // loop column
            if ($serch_data['search']['value']) { // if datatable send POST for search
                if ($i == 0) { // first loop
                    $where .= "(";
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
        $this->_get_purchase_return_datatables_query();
        $query = $this->db->get('erp_pr');
        return $query->num_rows();
    }

    function count_all() {
        $this->_get_purchase_return_datatables_query();
        $this->db->from('erp_pr');
        return $this->db->count_all_results();
    }

    public function update_po_details($return_qty, $po_id, $categoty, $brand) {
        $this->db->select('*');
        $this->db->where($this->erp_po_details . '.po_id', $po_id);
        $this->db->where($this->erp_po_details . '.category', $categoty);
        $this->db->where($this->erp_po_details . '.brand', $brand);
        $current_qty = $this->db->get($this->erp_po_details)->result_array();
        if (isset($current_qty) && !empty($current_qty)) {
            //Update delivery qty
            $d_quantity = $current_qty[0]['delivery_quantity'] - $return_qty;
            $r_quantity = $current_qty[0]['return_quantity'] + $return_qty;
            $this->db->where($this->erp_po_details . '.po_id', $po_id);
            $this->db->where($this->erp_po_details . '.category', $categoty);
            $this->db->where($this->erp_po_details . '.brand', $brand);
            $this->db->update($this->erp_po_details, array('delivery_quantity' => $d_quantity, 'return_quantity' => $r_quantity));
        }
    }

    public function get_gen_details_based_on_cat($purchase_order_id, $categoty, $brand) {
        $this->db->select('gen_details.*');
        $this->db->where($this->gen_details . '.po_id', $purchase_order_id);
        $this->db->where($this->gen_details . '.category', $categoty);
        $this->db->where($this->gen_details . '.brand', $brand);
        return $this->db->get($this->gen_details)->result_array();
    }

    public function update_gen_details($purchase_order_id, $categoty, $brand, $data) {
        $this->db->where($this->gen_details . '.po_id', $purchase_order_id);
        $this->db->where($this->gen_details . '.category', $categoty);
        $this->db->where($this->gen_details . '.brand', $brand);
        if ($this->db->update($this->gen_details, $data)) {
            return true;
        }
        return false;
    }

    public function get_erp_pr($pr_id) {
        $this->db->select('erp_pr.*');
        $this->db->where($this->erp_pr . '.id', $pr_id);
        $query = $this->db->get($this->erp_pr)->result_array();

        return $query;
    }

    public function update_erp_pr($erp_pr_id, $data) {
        $this->db->where($this->erp_pr . '.id', $erp_pr_id);
        if ($this->db->update($this->erp_pr, $data)) {
            return true;
        }
        return false;
    }

    function get_all_grn_number() {
        $this->db->select('*');
        $this->db->order_by('id', 'desc');
        $this->db->where('gen.total_qty !=', '0');
        $query = $this->db->get('gen')->result_array();
        return $query;
    }

    public function get_all_grn_list($atten_inputs) {
        $keyword = $atten_inputs;
        $this->db->select('gen.id,gen.grn_no as value');
        $this->db->where("gen.grn_no LIKE '%$keyword%'");
        $this->db->order_by('id', 'desc');
        $this->db->where('gen.total_qty !=', '0');
        $query = $this->db->get('gen')->result_array();

        return $query;
    }

    public function get_all_grn_by_id($id) {
        $this->db->select('vendor.id as vendor,vendor.store_name,vendor.state_id, vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,gen.id,gen.po_id,,gen.po_no,gen.grn_no,,gen.total_qty,gen.tax,gen.tax_label,'
                . 'gen.net_total,gen.remarks,gen.subtotal_qty,gen.status,gen.is_gst');
        //$this->db->where('erp_po.estatus',1);
        $this->db->where('gen.id', $id);
        $this->db->join('vendor', 'vendor.id=gen.supplier');
        $query = $this->db->get('gen');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_grn_details_by_id($id) {
        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_product.hsn_sac,erp_brand.id,erp_brand.brands,'
                . 'gen_details.category,gen_details.product_id,gen_details.brand,gen_details.quantity,'
                . 'gen_details.per_cost,gen_details.tax,gen_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,erp_product.po_add_amount,'
                . 'gen_details.product_description,gen_details.gst,gen_details.igst,gen_details.id as gen_details_id,gen_details.current_quantity');
        $this->db->where('gen_details.gen_id', $id);
        $this->db->join('gen', 'gen.id=gen_details.gen_id');
        $this->db->join('erp_category', 'erp_category.cat_id=gen_details.category');
        $this->db->join('erp_product', 'erp_product.id=gen_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=gen_details.brand');

        $query = $this->db->get('gen_details')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('quantity');
            $this->db->where('category', $val['category']);
            $this->db->where('product_id', $val['product_id']);
            $this->db->where('brand', $val['brand']);
            $this->db->order_by('quantity', 'desc');
            $this->db->limit(1);
            $query[$i]['stock'] = $this->db->get('erp_stock')->result_array();
            $i++;
        }
        return $query;
    }

    public function update_gen_data($return_qty, $id) {
        $this->db->select('*');
        $this->db->where('gen_details' . '.id', $id);
        $current_qty = $this->db->get('gen_details')->result_array();
        if (isset($current_qty) && !empty($current_qty)) {
            //Update return qty
            $c_quantity = $current_qty[0]['current_quantity'] - $return_qty;
            $r_quantity = $current_qty[0]['return_quantity'] + $return_qty;
            $this->db->where('gen_details' . '.id', $id);
            $this->db->update('gen_details', array('current_quantity' => $c_quantity, 'return_quantity' => $r_quantity));
        }
    }

    public function get_all_pr_by_id($id) {
        $this->db->select('vendor.id as vendor,vendor.tin,vendor.store_name,vendor.state_id, vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_pr.*');
        $this->db->select('SUM(erp_pr.total_qty) as return_qty,SUM(erp_pr.net_total) as return_amount,SUM(erp_pr.subtotal_qty) as subtotal_qty');
        $this->db->select('(gen.total_qty) as delivery_qty,(gen.net_total) as delivery_amount');
        $this->db->where('erp_pr.estatus !=', 0);
        $this->db->where('erp_pr.gen_id', $id);
        $this->db->join('vendor', 'vendor.id=erp_pr.supplier');
        $this->db->join('gen', 'gen.id=erp_pr.gen_id', 'left');
        $query = $this->db->get('erp_pr');

        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_purchase_return_details($id) {

        $this->db->select('vendor.id as vendor,vendor.store_name,vendor.state_id, vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_pr.*,'
                . 'erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,'
                . 'erp_pr_details.category,erp_pr_details.product_id,erp_pr_details.brand,'
                . 'erp_pr_details.per_cost,erp_pr_details.tax,erp_pr_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,'
                . 'erp_pr_details.product_description,erp_pr_details.gst,erp_pr_details.igst,erp_pr_details.return_quantity,erp_pr_details.id as pr_details_id');
        $this->db->join('erp_pr_details', 'erp_pr_details.pr_id=erp_pr.id');
        $this->db->join('erp_product', 'erp_product.id=erp_pr_details.product_id');
        $this->db->join('vendor', 'vendor.id=erp_pr.supplier');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_pr_details.category');
        $this->db->join('erp_brand', 'erp_brand.id=erp_pr_details.brand');
        $this->db->where('erp_pr.id', $id);
        $this->db->where('erp_pr_details.return_quantity !=', 0);
        $query = $this->db->get('erp_pr')->result_array();

        return $query;
    }

    public function get_all_pr_details_by_id($id) {
        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_product.hsn_sac,erp_product.po_add_amount,erp_brand.id,erp_brand.brands,'
                . 'erp_pr_details.category,erp_pr_details.product_id,erp_pr_details.brand,'
                . 'erp_pr_details.per_cost,erp_pr_details.tax,erp_pr_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,'
                . 'erp_pr_details.product_description,erp_pr_details.gst,erp_pr_details.igst,erp_pr_details.id as pr_details_id');
        $this->db->select('SUM(erp_pr_details.return_quantity) as return_quantity');
        $this->db->where('erp_pr_details.gen_id', $id);
        $this->db->where('erp_pr_details.return_quantity !=', 0);
        $this->db->group_by('erp_pr_details.product_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_pr_details.category');
        $this->db->join('erp_product', 'erp_product.id=erp_pr_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_pr_details.brand');

        $query = $this->db->get('erp_pr_details')->result_array();
        return $query;
    }

    public function get_pr_count() {
        $this->db->select('erp_pr.id');
        $this->db->where('erp_pr.estatus', 1);
        $this->db->where('erp_pr.payment_status', 'Pending');
        $query = $this->db->get('erp_pr');
        return $query->num_rows();
    }

}
