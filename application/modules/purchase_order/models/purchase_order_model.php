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
class Purchase_order_model extends CI_Model {

    private $table_name4 = 'master_style';
    private $vendor = 'vendor';
    private $erp_po = 'erp_po';
    private $erp_po_details = 'erp_po_details';
    private $increment_table = 'increment_table';
    private $erp_product = 'erp_product';
    private $erp_user = 'erp_user';
    private $erp_stock = 'erp_stock';
    private $erp_stock_history = 'erp_stock_history';

    function __construct() {
        parent::__construct();
    }

    public function insert_po($data) {
        if ($this->db->insert($this->erp_po, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
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
            $quantity = $check_stock['quantity'] + $current_stock[0]['quantity'];
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
            $insert_stock['quantity'] = $check_stock['quantity'];
            $this->db->insert($this->erp_stock, $insert_stock);
        }
        //Insert Stock History
        $insert_stock_his = array();
        $insert_stock_his['ref_no'] = $po_id['po_id'];
        $insert_stock_his['type'] = 1;
        $insert_stock_his['category'] = $check_stock['category'];

        $insert_stock_his['product_id'] = $check_stock['product_id'];
        $insert_stock_his['brand'] = $check_stock['brand'];
        $insert_stock_his['quantity'] = $check_stock['quantity'];
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

    public function get_customer($atten_inputs) {
        $this->db->select('name,id,mobil_number,email_id,address1,store_name,state_id,nick_name');
        $this->db->where($this->vendor . '.status', 1);
        $this->db->where($this->vendor . '.id', $atten_inputs['cust_id']);
        // $this->db->like($this->vendor . '.store_name', $atten_inputs['q']);
        $query = $this->db->get($this->vendor)->result_array();
        return $query;
    }

    public function get_customer_by_id($id) {
        $this->db->select('name,mobil_number,email_id,address1');
        $this->db->where($this->vendor . '.id', $id);
        return $this->db->get($this->vendor)->result_array();
    }

    public function get_product($atten_inputs) {
        $this->db->select('erp_product.id,model_no,product_name,product_description,product_image,type,cost_price,category_id,brand_id,cgst,sgst,igst,hsn_sac,po_add_amount as add_amount,'
                . ' CASE WHEN erp_stock.quantity > 0 THEN erp_stock.quantity ELSE 0 END AS quantity', FALSE);
        $this->db->where($this->erp_product . '.status', 1);
        $this->db->where($this->erp_product . '.type', 1);
        $this->db->where($this->erp_product . '.id', $atten_inputs['model_number_id']);
        $this->db->join('erp_stock', 'erp_stock.product_id = erp_product.id', 'left');
        // $this->db->like($this->erp_product . '.model_no', $atten_inputs['q']);
        $query = $this->db->get($this->erp_product)->result_array();
        return $query;
    }

    public function get_product_by_id($id) {
        $this->db->select('model_no,product_name,product_description,product_image');
        $this->db->where($this->erp_product . '.id', $id);
        return $this->db->get($this->erp_product)->result_array();
    }

    public function get_all_po($serch_data) {
        if (isset($serch_data) && !empty($serch_data)) {
            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';


            if (!empty($serch_data['po_no']) && $serch_data['po_no'] != 'Select') {

                $this->db->where($this->erp_po . '.po_no', $serch_data['po_no']);
            }
            if (!empty($serch_data['supplier']) && $serch_data['supplier'] != 'Select') {
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
        $this->db->select('vendor.id as vendor,vendor.store_name,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_po.id,erp_po.po_no,erp_po.total_qty,erp_po.tax,erp_po.tax_label,'
                . 'erp_po.net_total,erp_po.delivery_schedule,erp_po.mode_of_payment,erp_po.remarks,erp_po.subtotal_qty,erp_po.estatus,erp_po.created_date');
        $this->db->where('erp_po.estatus !=', 0);
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');
        $query = $this->db->get('erp_po');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_po_by_id($id) {
        $this->db->select('vendor.id as vendor,vendor.tin,vendor.state_id,vendor.store_name,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_po.id,erp_po.po_no,erp_po.total_qty,erp_po.tax,erp_po.tax_label,'
                . 'erp_po.net_total,erp_po.delivery_schedule,erp_po.mode_of_payment,erp_po.remarks,erp_po.subtotal_qty,erp_po.estatus,erp_po.created_date,erp_po.is_gst');
        $this->db->where('erp_po.estatus', 1);
        $this->db->where('erp_po.id', $id);
        $this->db->left_join('vendor', 'vendor.id=erp_po.supplier','left');
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
        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_brand.id,erp_brand.brands,erp_product.hsn_sac,erp_product.po_add_amount as add_amount,'
                . 'erp_po_details.category,erp_po_details.product_id,erp_po_details.brand,erp_po_details.quantity,'
                . 'erp_po_details.per_cost,erp_po_details.tax,erp_po_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,'
                . 'erp_po_details.product_description,erp_po_details.gst,erp_po_details.igst');
        $this->db->where('erp_po_details.po_id', $id);
        $this->db->join('erp_po', 'erp_po.id=erp_po_details.po_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_po_details.category');
        $this->db->join('erp_product', 'erp_product.id=erp_po_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_po_details.brand');

        $query = $this->db->get('erp_po_details')->result_array();

        $i = 0;
        foreach ($query as $val) {
            $this->db->select('erp_stock.quantity');
//            $this->db->where('product_id', $val['product_id']);
            $this->db->where('category', $val['category']);
            $this->db->where('product_id', $val['product_id']);
            $this->db->where('brand', $val['brand']);
            $query[$i]['stock'] = $this->db->get('erp_stock')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_quotation_history_by_id($id) {
        $this->db->select('vendor.id,vendor.store_name,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_quotation_history.q_no,erp_quotation_history.total_qty,erp_quotation_history.tax,erp_quotation_history.ref_name,erp_quotation_history.tax_label,'
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

    public function delete_po_deteils_by_id($id) {
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

    public function update_po($data, $id) {
        $this->db->where($this->erp_po . '.id', $id);
        if ($this->db->update($this->erp_po, $data)) {
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

    public function get_all_product() {
        $this->db->select('*');
        $this->db->where($this->erp_product . '.type', 1);
        $query = $this->db->get('erp_product')->result_array();
        return $query;
    }

    public function get_all_product1() {
        $this->db->select('*');
        $this->db->where($this->erp_product . '.type', 2);
        $query = $this->db->get('erp_product')->result_array();
        return $query;
    }

    public function get_all_customers() {
        $this->db->select('name,id,mobil_number,email_id,address1,store_name,tin');
        $this->db->where($this->vendor . '.status', 1);
        $query = $this->db->get($this->vendor)->result_array();
        return $query;
    }

    public function update_product_cost($data, $id) {
        $this->db->where($this->erp_product . '.id', $id);
        if ($this->db->update($this->erp_product, $data)) {
            return true;
        }
        return false;
    }

    function get_datatables($search_data) {

        $this->_get_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_po')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(gen.total_qty) as delivery_qty,SUM(gen.net_total) as delivery_amount');
            $this->db->where('gen.po_id', $val['id']);
            $query[$i]['gen_details'] = $this->db->get('gen')->result_array();
            $i++;
        }
        $j = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(erp_pr.total_qty) as return_qty,SUM(erp_pr.net_total) as return_amount');
            $this->db->where('erp_pr.po_id', $val['id']);
            $query[$j]['pr_details'] = $this->db->get('erp_pr')->result_array();
            $j++;
        }
        return $query;
    }

    function _get_datatables_query($serch_data = array()) {

        $this->db->select('vendor.id as vendor,vendor.store_name,vendor.name,vendor.mobil_number,vendor.email_id,vendor.address1,erp_po.id,erp_po.po_no,erp_po.total_qty,erp_po.tax,erp_po.tax_label,'
                . 'erp_po.net_total,erp_po.delivery_schedule,erp_po.mode_of_payment,erp_po.remarks,erp_po.subtotal_qty,erp_po.estatus,erp_po.created_date');
        $this->db->where('erp_po.estatus !=', 0);
        $this->db->join('vendor', 'vendor.id=erp_po.supplier');

        $i = 0;
        $column_order = array(null, 'erp_po.po_no', 'vendor.store_name', 'vendor.name', 'erp_po.total_qty', 'erp_po.subtotal_qty', 'erp_po.net_total', null, null, null, null, 'erp_po.mode_of_payment', 'erp_po.remarks', null);
        $column_search = array('erp_po.po_no', 'vendor.store_name', 'vendor.name', 'erp_po.total_qty', 'erp_po.subtotal_qty', 'erp_po.net_total', 'erp_po.mode_of_payment', 'erp_po.remarks');
        $order = array('erp_po.id' => 'DESC');

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
        $this->_get_datatables_query();
        $query = $this->db->get('erp_po');
        return $query->num_rows();
    }

    function count_all() {
        $this->_get_datatables_query();
        $this->db->from('erp_po');
        return $this->db->count_all_results();
    }

    public function get_purchase_order_count() {
        $this->db->select('erp_po.id');
        $this->db->where('erp_po.estatus', 1);
        $this->db->where('erp_po.payment_status', 'Pending');
        $query = $this->db->get('erp_po');

        return $query->num_rows();
    }

}
