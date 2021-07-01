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
class Grn_model extends CI_Model {

    private $erp_po = 'erp_po';
    private $gen = 'gen';
    private $gen_details = 'gen_details';
    private $erp_stock = 'erp_stock';
    private $erp_stock_history = 'erp_stock_history';
    private $erp_po_details = 'erp_po_details';
    private $erp_brand = 'erp_brand';

    function __construct() {
        parent::__construct();
    }

    public function get_all_po_for_add_gen($atten_inputs) {
        $this->db->select('*');
        $this->db->where('id', $atten_inputs['po_id']);
        $this->db->order_by('id', 'desc');
        $this->db->where('erp_po.delivery_status !=', '2');
        $this->db->where('erp_po.estatus =', '1');
        $query = $this->db->get($this->erp_po)->result_array();

        return $query;
    }

    function po_duplication($input) {
        $this->db->select('*');
        $this->db->where('po_no', $input);
        $this->db->where('delivery_status', '2');
        $this->db->where('erp_po.estatus =', '1');
        $query = $this->db->get('erp_po');

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    function get_all_po_number() {
        $this->db->select('*');
        $this->db->order_by('id', 'desc');
        $this->db->where('erp_po.estatus =', '1');
        $this->db->where('erp_po.delivery_status !=', '2');
        $query = $this->db->get($this->erp_po)->result_array();
        return $query;
    }

    public function check_po_no($po) {
        $this->db->select('grn_no');
        $this->db->like('grn_no', $po);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('gen')->result_array();
        return $query;
    }

    public function check_po_no1($po) {
        $this->db->select('grn_no');
        $this->db->like('grn_no', $po);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('gen')->result_array();
        return $query;
    }

    public function check_po_in_gen($po_no) {
        $this->db->select('id');
        $this->db->where('po_no', $po_no);
        $query = $this->db->get('gen')->result_array();
        return $query;
    }

    public function get_gen_by_id_po($po_no) {
        $this->db->select('vendor.id as vendor,vendor.tin,vendor.nick_name,vendor.state_id,vendor.store_name,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_po.id,erp_po.po_no,erp_po.total_qty,erp_po.tax,erp_po.tax_label,'
                . 'erp_po.net_total,erp_po.delivery_schedule,erp_po.mode_of_payment,erp_po.remarks,erp_po.subtotal_qty,erp_po.estatus,erp_po.created_date,erp_po.is_gst,erp_po.supplier');
        //$this->db->where('erp_po.estatus',1);
        $this->db->where('erp_po.po_no', $po_no);
        $this->db->where('erp_po.estatus =', '1');
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');
        $query = $this->db->get('erp_po');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_gen_by_po($po) {
        $this->db->select('gen.grn_no,gen.id as gen_id');
        $this->db->where('gen.po_no', $po);
        $query = $this->db->get('gen')->result_array();
        return $query;
    }

    public function get_all_po_details_by_id($po_id) {
        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_category.is_warranty,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,'
                . 'erp_po_details.category,erp_po_details.product_id,erp_po_details.brand,erp_po_details.quantity,erp_po_details.return_quantity,erp_po_details.delivery_quantity,'
                . 'erp_po_details.per_cost,erp_po_details.tax,erp_po_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,erp_product.hsn_sac,erp_product.po_add_amount as add_amount,'
                . 'erp_po_details.product_description,erp_po_details.gst,erp_po_details.igst,erp_po_details.type as po_type,erp_po_details.id as po_details_id,erp_po_details.created_date');
        $this->db->where('erp_po_details.po_id', $po_id);
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

    public function get_all_po_details_by_serial($serial_no) {
        $this->db->select('gen_details.*,,erp_category.cat_id,erp_category.categoryName,erp_category.is_warranty,erp_product.id,erp_product.product_name,erp_product.hsn_sac,erp_brand.id,erp_brand.brands,erp_product.model_no,erp_product.product_image,erp_product.type');
        $this->db->where("FIND_IN_SET('$serial_no',product_serial_no) > 0");
        $this->db->join('erp_category', 'erp_category.cat_id=gen_details.category');
        $this->db->join('erp_product', 'erp_product.id=gen_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=gen_details.brand');

        $query = $this->db->get('gen_details')->result_array();

        $i = 0;
        foreach ($query as $val) {
            $this->db->select('vendor.id as vendor,vendor.tin,vendor.nick_name,vendor.state_id,vendor.store_name,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,gen.*');
            $this->db->where('gen.id', $val['gen_id']);
            $this->db->where('gen.status =', '1');
            $this->db->join('vendor', 'vendor.id=gen.supplier');
            $query[$i]['gen'] = $this->db->get('gen')->result_array();
            $i++;
        }
        return $query;
    }

    public function insert_gen($data) {
        if ($this->db->insert($this->gen, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function update_gen($data, $id) {
        $this->db->where($this->gen . '.id', $id);
        if ($this->db->update($this->gen, $data)) {
            return true;
        }
        return false;
    }

    public function insert_gen_details($data) {
        $this->db->insert_batch($this->gen_details, $data);
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
            $quantity = $current_stock[0]['quantity'] + $check_stock['delivery_quantity'];
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
            $insert_stock['quantity'] = $check_stock['delivery_quantity'];
            $this->db->insert($this->erp_stock, $insert_stock);
        }
        //Insert Stock History
        $insert_stock_his = array();
        $insert_stock_his['ref_no'] = $po_id['po_id'];
        $insert_stock_his['type'] = 1;
        $insert_stock_his['category'] = $check_stock['category'];

        $insert_stock_his['product_id'] = $check_stock['product_id'];
        $insert_stock_his['brand'] = $check_stock['brand'];
        $insert_stock_his['quantity'] = $check_stock['delivery_quantity'];
        $insert_stock_his['created_date'] = date('Y-m-d H:i');
        //echo"<pre>"; print_r($insert_stock_his); exit;
        $this->db->insert($this->erp_stock_history, $insert_stock_his);
    }

    public function update_po_details($deliver_quantity, $id) {
        $this->db->select('*');
        $this->db->where($this->erp_po_details . '.id', $id);
        $current_delivery_qty = $this->db->get($this->erp_po_details)->result_array();
        if (isset($current_delivery_qty) && !empty($current_delivery_qty)) {
            //Update delivery qty
            $d_quantity = $deliver_quantity + $current_delivery_qty[0]['delivery_quantity'];
            $this->db->where($this->erp_po_details . '.id', $id);
            $this->db->update($this->erp_po_details, array('delivery_quantity' => $d_quantity));
        }
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

    function _get_grn_datatables_query($search_data = array()) {

        $this->db->select('gen.*');
        $this->db->select('vendor.store_name,vendor.name');
//        $this->db->order_by('gen.id', 'desc');
        $this->db->join('vendor', 'vendor.id=gen.supplier');

        $i = 0;
        $column_order = array(null, 'gen.grn_no', 'gen.po_no', 'gen.vendor_inv_no', 'vendor.name', null, 'gen.net_total', 'gen.inv_date', null);
        $column_search = array('gen.grn_no', 'gen.po_no', 'gen.vendor_inv_no', 'vendor.name', 'gen.net_total', 'gen.inv_date');
        $order = array('gen.id' => 'DESC');

        foreach ($column_search as $item) { // loop column
            if ($search_data['search']['value']) { // if datatable send POST for search
                if ($i == 0) { // first loop
                    $where .= "(";
                }
                $string = $item;
                $str_arr = explode(".", $string);
                $where .= '`' . $str_arr[0] . "`" . '.' . "`" . $str_arr[1] . "` like '%" . $search_data['search']['value'] . "%'";
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
        $this->_get_grn_datatables_query();
        $query = $this->db->get('gen');
        return $query->num_rows();
    }

    function count_all() {
        $this->_get_grn_datatables_query();
        $this->db->from('gen');
        return $this->db->count_all_results();
    }

    public function get_gen_by_id($id) {
        $this->db->select('gen.*,vendor.store_name,vendor.state_id,erp_po.is_gst');
        $this->db->where('gen.id', $id);
        $this->db->join('vendor', 'vendor.id=gen.supplier');
        $this->db->join('erp_po', 'erp_po.id=gen.po_id');
        $query = $this->db->get('gen');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_gen_datas_by_id($id) {
        $this->db->select('gen.id AS genID,gen.grn_no,gen.po_no');
        $this->db->where('gen.id', $id);
        $query = $this->db->get('gen');
        if ($query->num_rows() > 0) {
            $results = $query->result_array();
            $i = 0;
            foreach ($results as $val) {
                $this->db->select('gen_details.*,erp_brand.brands,erp_product.model_no,	erp_category.categoryName,gen.po_no,gen.grn_no');
                $this->db->where('gen_details.gen_id', $val['genID']);
                $this->db->where('gen_details.delivery_quantity !=', 0);
                $this->db->join('erp_brand', 'erp_brand.id=gen_details.brand');
                $this->db->join('erp_product', 'erp_product.id=gen_details.product_id');
                $this->db->join('gen', 'gen.id=gen_details.gen_id');
                $this->db->join('erp_category', 'erp_category.cat_id=gen_details.category');
                $result = $this->db->get('gen_details')->result_array();
                $i++;
            }
            return $result;
        }
        return false;
    }

    public function get_all_gen_details_by_id($gen_id) {
        $this->db->select('gen_details.*,erp_category.cat_id,erp_category.categoryName,erp_category.is_warranty,erp_product.id,erp_product.product_name,erp_product.hsn_sac,erp_brand.id,erp_brand.brands,erp_product.model_no,erp_product.product_image,erp_product.type');
        $this->db->where('gen_details.gen_id', $gen_id);
        $this->db->where('gen_details.delivery_quantity !=', 0);
        $this->db->join('erp_po', 'erp_po.id=gen_details.po_id');
        $this->db->join('erp_category', 'erp_category.cat_id=gen_details.category');
        $this->db->join('erp_product', 'erp_product.id=gen_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=gen_details.brand');

        $query = $this->db->get('gen_details')->result_array();

        return $query;
    }

    public function get_total_qty($po_no) {
        $this->db->select('erp_po.total_qty');
        $this->db->where('erp_po.po_no', $po_no);
        $this->db->where('erp_po.estatus =', '1');
        $query = $this->db->get('erp_po')->result_array();

        $this->db->select('SUM(total_qty) AS total_qty');
        $this->db->where('po_no', $po_no);
        $query1 = $this->db->get($this->gen)->result_array();

        if ($query[0]['total_qty'] > $query1[0]['total_qty'])
            $status = 1;
        else
            $status = 2;

        $this->db->where('erp_po.po_no', $po_no);
        $this->db->where('erp_po.estatus =', '1');
        if ($this->db->update('erp_po', array('delivery_status' => $status))) {
            return true;
        }
        return false;
    }

    public function get_grn_count() {
        $this->db->select('gen.id');
        $this->db->where('gen.status', 1);
        $this->db->where('gen.payment_status', 'Pending');
        $query = $this->db->get('gen');

        return $query->num_rows();
    }

    public function get_all_grn($po) {
        $this->db->select('gen.grn_no,gen.id');
        $query = $this->db->get('gen')->result_array();
        return $query;
    }

    public function get_pending_delivery_po() {
        $this->db->select('*');
        $this->db->where('erp_po.estatus =', '1');
        $this->db->where('erp_po.delivery_status !=', '2');
        $query = $this->db->get($this->erp_po);

        return $query->num_rows;
    }

    function get_all_serial_number() {
        $this->db->select('*');
        $this->db->order_by('id', 'desc');
        $this->db->where('gen.status =', '1');
        $query = $this->db->get(gen)->result_array();
        return $query;
    }

}
