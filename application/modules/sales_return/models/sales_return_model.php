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
class Sales_return_model extends CI_Model {

    private $table_name4 = 'master_style';
    private $table_name5 = 'master_style_size';
    private $vendor = 'vendor';
    private $erp_invoice = 'erp_invoice';
    private $erp_invoice_details = 'erp_invoice_details';
    private $increment_table = 'increment_table';
    private $erp_product = 'erp_product';
    private $erp_user = 'erp_user';
    private $erp_stock = 'erp_stock';
    private $erp_stock_history = 'erp_stock_history';
    private $erp_sales_return = 'erp_sales_return';
    private $erp_sales_return_details = 'erp_sales_return_details';

    function __construct() {
        parent::__construct();
    }

    public function insert_sr($data) {
        if ($this->db->insert($this->erp_sales_return, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    public function update_sr($data, $id) {
        $this->db->where($this->erp_sales_return . '.inv_id', $id);
        if ($this->db->update($this->erp_sales_return, $data)) {
            return true;
        }
        return false;
    }

    public function insert_sr_details($data) {
        $this->db->insert_batch($this->erp_sales_return_details, $data);
        return true;
    }

    public function insert_inv_details($data) {
        $this->db->insert_batch($this->erp_invoice_details, $data);
        return true;
    }

    public function update_inv($data, $id) {
        $this->db->where($this->erp_invoice . '.id', $id);
        if ($this->db->update($this->erp_invoice, $data)) {
            return true;
        }
        return false;
    }

    public function update_sales_return($data, $id) {
        $this->db->where($this->erp_sales_return . '.id', $id);
        if ($this->db->update($this->erp_sales_return, $data)) {
            return true;
        }
        return false;
    }

    public function update_invoice_details($return_qty, $id) {
        $this->db->select('*');
        $this->db->where($this->erp_invoice_details . '.id', $id);
        $current_qty = $this->db->get($this->erp_invoice_details)->result_array();
        if (isset($current_qty) && !empty($current_qty)) {
            //Update return qty
            $c_quantity = $current_qty[0]['current_quantity'] - $return_qty;
            $r_quantity = $current_qty[0]['return_quantity'] + $return_qty;
            $this->db->where($this->erp_invoice_details . '.id', $id);
            $this->db->update($this->erp_invoice_details, array('current_quantity' => $c_quantity, 'return_quantity' => $r_quantity));
        }
    }

    public function delete_inv_details($id) {
        $this->db->where('in_id', $id);
        $this->db->delete($this->erp_invoice_details);
    }

    public function check_stock($check_stock, $po_id) {
        $this->db->select('*');
        $this->db->where('category', $check_stock['category']);
        $this->db->where('product_id', $check_stock['product_id']);
        $this->db->where('brand', $check_stock['brand']);
        $current_stock = $this->db->get($this->erp_stock)->result_array();
        if (isset($current_stock) && !empty($current_stock)) {
            //Update Stock
            $quantity = $current_stock[0]['quantity'] + $check_stock['return_quantity'];
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
        $insert_stock_his['ref_no'] = $po_id['inv_id'];
        $insert_stock_his['type'] = 3;
        $insert_stock_his['category'] = $check_stock['category'];

        $insert_stock_his['product_id'] = $check_stock['product_id'];
        $insert_stock_his['brand'] = $check_stock['brand'];
        $insert_stock_his['quantity'] = $check_stock['return_quantity'];
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

    public function get_all_inv() {

        $this->db->select('customer.store_name,customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_invoice.total_qty,erp_invoice.tax,erp_invoice.tax_label,'
                . 'erp_invoice.q_id,erp_invoice.customer,erp_invoice.net_total,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.estatus,erp_invoice.customer_po,erp_invoice.warranty_from,erp_invoice.warranty_to,erp_invoice.payment_status');
        $this->db->where('erp_invoice.estatus !=', 0);
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
        $query = $this->db->get('erp_invoice')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('total_qty');
            $this->db->where('inv_id', $val['inv_id']);
            $this->db->order_by("id", "desc");
            $this->db->limit(1);
            $this->db->order_by("id", "desc");
            $this->db->limit(2);
            $query[$i]['return'] = $this->db->get('erp_sales_return')->result_array();
            $i++;
        }
        return $query;
    }

    public function get_all_inv_by_id($id) {
        $this->db->select('customer.store_name,customer.id as customer,customer.state_id, customer.name,customer.mobil_number,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_invoice.total_qty,erp_invoice.tax,erp_invoice.tax_label,'
                . 'erp_invoice.q_id,erp_invoice.net_total,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.customer_po,erp_invoice.warranty_from,erp_invoice.warranty_to,erp_invoice.payment_status,erp_invoice.is_gst');
        //$this->db->where('erp_invoice.estatus',1);
        $this->db->where('erp_invoice.id', $id);
        $this->db->join('customer', 'customer.id=erp_invoice.customer');
        $query = $this->db->get('erp_invoice');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_product_by_id($id) {
        $this->db->select('erp_product.id,erp_product.model_no,erp_product.product_name,erp_product.product_image,'
                . 'erp_po_details.product_description');
        $this->db->where('erp_po_details.id', $id);
        $this->db->join('erp_po', 'erp_po.id=erp_po_details.in_id');
        $this->db->join('erp_product', 'erp_product.id=erp_po_details.product_id');
        $query = $this->db->get('erp_po_details');
        if ($query->num_rows() >= 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_all_inv_details_by_id($id) {
        $this->db->select('erp_category.cat_id,erp_category.categoryName,erp_product.id,erp_product.product_name,erp_product.hsn_sac,erp_product.add_amount,erp_brand.id,erp_brand.brands,'
                . 'erp_invoice_details.category,erp_invoice_details.product_id,erp_invoice_details.brand,erp_invoice_details.quantity,'
                . 'erp_invoice_details.per_cost,erp_invoice_details.tax,erp_invoice_details.sub_total,erp_product.model_no,erp_product.product_image,erp_product.type,'
                . 'erp_invoice_details.product_description,erp_invoice_details.gst,erp_invoice_details.igst,erp_invoice_details.id as inv_details_id,erp_invoice_details.current_quantity');
        $this->db->where('erp_invoice_details.in_id', $id);
        $this->db->join('erp_invoice', 'erp_invoice.id=erp_invoice_details.in_id');
        $this->db->join('erp_category', 'erp_category.cat_id=erp_invoice_details.category');
        $this->db->join('erp_product', 'erp_product.id=erp_invoice_details.product_id');
        $this->db->join('erp_brand', 'erp_brand.id=erp_invoice_details.brand');

        $query = $this->db->get('erp_invoice_details')->result_array();
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
                . 'erp_quotation_history.net_total,erp_quotation_history.notification_date,erp_quotation_history.remarks,erp_quotation_history.subtotal_qty');
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

    function get_datatables($search_data) {

        $this->_get_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_invoice')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('total_qty');
            $this->db->where('inv_id', $val['inv_id']);
            $this->db->order_by("id", "desc");
            $query[$i]['return'] = $this->db->get('erp_sales_return')->result_array();
            $i++;
        }
        $k = 0;
        foreach ($query as $val) {
            $this->db->select('SUM(current_quantity) as current_quantity,SUM(return_quantity) as return_quantity');
            $this->db->where('in_id', $val['id']);
            $query[$k]['inv_details'] = $this->db->get('erp_invoice_details')->result_array();
            $k++;
        }
        $j = 0;
        foreach ($query as $val) {
            $this->db->select('erp_invoice_details.*');
            $this->db->where('in_id', $val['id']);
            $query[$j]['po_details'] = $this->db->get('erp_invoice_details')->result_array();
            $j++;
        }

        return $query;
    }

    function _get_datatables_query($serch_data = array()) {

        $this->db->select('customer.store_name,customer.name,customer.mobil_number,customer.state_id,customer.email_id,customer.address1,erp_invoice.id,erp_invoice.inv_id,erp_invoice.total_qty,erp_invoice.tax,erp_invoice.tax_label,'
                . 'erp_invoice.q_id,erp_invoice.customer,erp_invoice.net_total,erp_invoice.remarks,erp_invoice.subtotal_qty,erp_invoice.estatus,erp_invoice.estatus,erp_invoice.customer_po,erp_invoice.warranty_from,erp_invoice.warranty_to,erp_invoice.payment_status,erp_invoice.is_gst');
        $this->db->where('erp_invoice.estatus !=', 0);
        $this->db->join('customer', 'customer.id=erp_invoice.customer');

        $i = 0;
        $column_order = array(null, 'erp_invoice.inv_id', 'customer.store_name', null, null, 'erp_invoice.total_qty', 'erp_invoice.subtotal_qty', 'erp_invoice.net_total', 'erp_invoice.remarks', null);
        $column_search = array('erp_invoice.inv_id', 'customer.store_name', 'erp_invoice.total_qty', 'erp_invoice.subtotal_qty', 'erp_invoice.net_total', 'erp_invoice.remarks');
        $order = array('erp_invoice.id' => 'DESC');

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
        $query = $this->db->get('erp_invoice');
        return $query->num_rows();
    }

    function count_all() {
        $this->_get_datatables_query();
        $this->db->from('erp_invoice');
        return $this->db->count_all_results();
    }

    public function get_sales_return_count() {
        $this->db->select('erp_sales_return.id');
        $query = $this->db->get('erp_sales_return');
        return $query->num_rows();
    }

}
