<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sales_return extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'sales_return';
        $access_arr = array(
            'sales_return/index' => array('add', 'edit', 'delete', 'view'),
            'sales_return/po_view' => array('add', 'edit', 'delete', 'view'),
            'sales_return/change_status' => array('add', 'edit', 'delete', 'view'),
            'sales_return/sales_return_list' => array('add', 'edit', 'delete', 'view'),
            'sales_return/get_customer' => array('add', 'edit'),
            'sales_return/get_customer_by_id' => array('add', 'edit'),
            'sales_return/get_product' => array('add', 'edit'),
            'sales_return/get_product_by_id' => 'no_restriction',
            'sales_return/po_edit' => 'no_restriction',
            'sales_return/stock_details' => 'no_restriction',
            'sales_return/update_po' => 'no_restriction',
            'sales_return/make_return' => 'no_restriction',
            'sales_return/po_delete' => 'no_restriction',
            'sales_return/history_view' => 'no_restriction',
            'sales_return/ajaxList' => 'no_restriction',
        );
        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }

        $this->load->model('master_category/master_category_model');
        $this->load->model('master_style/master_model');
        $this->load->model('master_brand/master_brand_model');
        $this->load->model('quotation/Gen_model');
        $this->load->model('customer/customer_model');
        $this->load->model('enquiry/enquiry_model');
        $this->load->model('admin/admin_model');
        $this->load->model('sales_return/sales_return_model');
    }

    public function index() {

        $datas["po"] = $po = $this->sales_return_model->get_all_inv();
        $datas['company_details'] = $this->admin_model->get_company_details();

        $this->template->write_view('content', 'sales_return/sales_return_list', $datas);
        $this->template->render();
    }

    public function po_view($id) {
        $datas["po"] = $po = $this->sales_return_model->get_all_inv_by_id($id);
        $datas["po_details"] = $po_details = $this->sales_return_model->get_all_inv_details_by_id($id);
        $datas["category"] = $category = $this->master_category_model->get_all_category();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();

        $this->template->write_view('content', 'sales_return_view', $datas);
        $this->template->render();
    }

    public function change_status($id, $status) {
        //echo $id; echo $status; exit;
        $this->sales_return_model->change_po_status($id, $status);
        redirect($this->config->item('base_url') . 'sales_return/sales_return_list');
    }

    public function sales_return_list() {

    }

    public function get_customer() {
        $atten_inputs = $this->input->get();
        $data = $this->sales_return_model->get_customer($atten_inputs);
        echo '<ul id="country-list">';
        if (isset($data) && !empty($data)) {
            foreach ($data as $st_rlno) {
                if ($st_rlno['name'] != '')
                    echo '<li class="cust_class" cust_name="' . $st_rlno['name'] . '" cust_id="' . $st_rlno['id'] . '" cust_no="' . $st_rlno['mobil_number'] . '" cust_email="' . $st_rlno['email_id'] . '" cust_address="' . $st_rlno['address1'] . '">' . $st_rlno['name'] . '</li>';
            }
        }
        else {
            echo '<li style="color:red;">No Data Found</li>';
        }
        echo '</ul>';
    }

    public function get_customer_by_id() {
        $input = $this->input->post();
        $data_customer["customer_details"] = $this->sales_return_model->get_customer_by_id($input['id']);
        echo json_encode($data_customer);
    }

    public function get_product() {
        $atten_inputs = $this->input->get();
        $product_data = $this->sales_return_model->get_product($atten_inputs);

        echo '<ul id="product-list">';
        if (isset($product_data) && !empty($product_data)) {
            foreach ($product_data as $st_rlno) {
                if ($st_rlno['model_no'] != '')
                    echo '<li class="pro_class" pro_cost="' . $st_rlno['cost_price'] . '" pro_type="' . $st_rlno['type'] . '" pro_id="' . $st_rlno['id'] . '" mod_no="' . $st_rlno['model_no'] . '" pro_name="' . $st_rlno['product_name'] . '" pro_description="' . $st_rlno['product_description'] . '" pro_image="' . $st_rlno['product_image'] . '">' . $st_rlno['model_no'] . '</li>';
            }
        }
        else {
            echo '<li style="color:red;">No Data Found</li>';
        }
        echo '</ul>';
    }

    public function get_product_by_id() {
        $input = $this->input->post();
        $data_customer["product_details"] = $this->sales_return_model->get_product_by_id($input['id']);
        echo json_encode($data_customer);
    }

    public function po_edit($id) {
        $datas["po"] = $po = $this->sales_return_model->get_all_inv_by_id($id);
        $datas["po_details"] = $po_details = $this->sales_return_model->get_all_inv_details_by_id($id);
        // echo "<pre>";
        // print_r($datas);
        // exit;
        $datas["category"] = $category = $this->master_category_model->get_all_category();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $this->template->write_view('content', 'sales_return_edit', $datas);
        $this->template->render();
    }

    function stock_details($stock_info, $po_id) {

        $this->sales_return_model->check_stock($stock_info, $po_id);
    }

    public function update_po($id) {
        $input = $this->input->post();
        //echo "<pre>";
        //print_r($input);
        // exit;
        $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
        $input['po']['created_by'] = $user_info[0]['id'];
        $input['po']['created_date'] = date('Y-m-d H:i:s');
        $update = $this->sales_return_model->update_inv($input['po'], $id);
        $insert_id = $this->sales_return_model->insert_sr($input['po']);
        //$insert_id=1;
        if (isset($update) && !empty($update)) {
            $input = $this->input->post();
            if (isset($input['categoty']) && !empty($input['categoty'])) {
                $insert_arr1 = array();
                foreach ($input['categoty'] as $key => $val) {

                    $insert1['in_id'] = $id;
                    $insert1['q_id'] = $input['po']['q_id'];
                    $insert1['category'] = $val;
                    $insert1['product_id'] = $input['product_id'][$key];
                    $insert1['product_description'] = $input['product_description'][$key];
                    $insert1['brand'] = $input['brand'][$key];
                    $insert1['quantity'] = $input['quantity'][$key] - $input['return_quantity'][$key];
                    $insert1['per_cost'] = $input['per_cost'][$key];
                    $insert1['tax'] = $input['tax'][$key];
                    $insert1['gst'] = $input['gst'][$key];
                    $insert1['igst'] = $input['igst'][$key];
                    $insert1['sub_total'] = $input['sub_total'][$key];
                    $insert1['created_date'] = date('Y-m-d H:i');
                    $insert_arr1[] = $insert1;
                }
                //  echo "<pre>"; print_r($insert_arr1); exit;
                $this->sales_return_model->delete_inv_details($id);
                $this->sales_return_model->insert_inv_details($insert_arr1);
            }
        }
        if (isset($insert_id) && !empty($insert_id)) {
            $input = $this->input->post();
            if (isset($input['categoty']) && !empty($input['categoty'])) {
                $insert_arr = array();
                foreach ($input['categoty'] as $key => $val) {

                    $insert['in_id'] = $id;
                    $insert['q_id'] = $input['po']['q_id'];
                    $insert['category'] = $val;
                    $insert['product_id'] = $input['product_id'][$key];
                    $insert['product_description'] = $input['product_description'][$key];
                    $insert['brand'] = $input['brand'][$key];
                    $insert['return_quantity'] = $input['return_quantity'][$key];
                    $insert['per_cost'] = $input['per_cost'][$key];
                    $insert['tax'] = $input['tax'][$key];
                    $insert['gst'] = $input['gst'][$key];
                    $insert['igst'] = $input['igst'][$key];
                    $insert['sub_total'] = $input['sub_total'][$key];
                    $insert['created_date'] = date('Y-m-d H:i');
                    $insert_arr[] = $insert;
                    $stock_arr = array();
                    $po_id['inv_id'] = $input['po']['inv_id'];
                    $stock_arr[] = $po_id;
                    $this->stock_details($insert, $po_id);
                }
                //echo "<pre>"; print_r($insert_arr); exit;
                $this->sales_return_model->insert_sr_details($insert_arr);
            }
        }
        // $datas["po"]= $po =$this->purchase_return_model->get_all_po();
        redirect($this->config->item('base_url') . 'sales_return/index');
    }

    public function po_delete() {
        $id = $this->input->POST('value1');
        $datas["po"] = $po = $this->sales_return_model->get_all_po();
        $del_id = $this->sales_return_model->delete_po($id);
        redirect($this->config->item('base_url') . 'sales_return/sales_return_list', $datas);
    }

    public function history_view($id) {
        $datas["his_quo"] = $his_quo = $this->sales_return_model->all_history_quotations($id);
        $this->template->write_view('content', 'history_view', $datas);
        $this->template->render();
    }

    function ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $list = $this->sales_return_model->get_datatables($search_data);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $sr_data) {
            if ($this->user_auth->is_action_allowed('sales_return', 'sales_return', 'edit')) {
                $edit_row = '<a class="btn btn-info btn-mini waves-effect waves-light" href="' . base_url() . 'sales_return/po_edit/' . $sr_data['id'] . '" data-toggle="tooltip" data-placement="top" title="Edit"><span>Make Return</span></a>';
            } else {
                $edit_row = '<a class="btn btn-info btn-mini waves-effect waves-light alerts" href=""><span>Make Return</span></a>';
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $sr_data['inv_id'];
            $row[] = $sr_data['store_name'];

            $cgst = 0;
            $sgst = 0;

            $sub_total = $over_all_net_total = $over_all_net = 0;
            if (isset($sr_data['po_details']) && !empty($sr_data['po_details'])) {
                foreach ($sr_data['po_details'] as $vals) {

                    $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['current_quantity']);

                    $gst_type = $sr_data['state_id'];
                    if ($gst_type != '') {
                        if ($gst_type == 31) {

                            $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * $vals['current_quantity']);
                        } else {
                            $sgst1 = ($vals['igst'] / 100 ) * ($vals['per_cost'] * $vals['current_quantity']);
                        }
                    }
                    $cgst += $cgst1;
                    $sgst += $sgst1;

                    $qty = $vals['current_quantity'];
                    $per_cost = $vals['per_cost'];
                    $gst_val = $vals['tax'];
                    $cgst_val = $vals['gst'];
                    if ($sr_data['is_gst'] == 1) {
                        $net_total = $qty * ($per_cost);
                    } else {
                        $net_total = $qty * ($per_cost);
                    }
                    $sub_total += $net_total;
                    if ($sr_data['is_gst'] == 1) {
                        $final_sub__total = $qty * $per_cost + (($qty * $per_cost) * $gst_val / 100) + (($qty * $per_cost) * $cgst_val / 100);
                    } else {
                        $final_sub__total = $qty * ($per_cost);
                    }
                    $over_all_net += $final_sub__total;
                    $over_all_net_total = $over_all_net + $sr_data['tax'];
                }
            }
            $final_net_total = $over_all_net_total;

            if (isset($sr_data['return'][1]) && !empty($sr_data['return'][1])) {
                $row[] = $sr_data['return'][1]['total_qty'];
                $row[] = ($sr_data['inv_details'][0]['return_quantity']);
            } else {
                $row[] = $sr_data['total_qty'];
                $row[] = $sr_data['inv_details'][0]['return_quantity'];
            }
            $row[] = $sr_data['inv_details'][0]['current_quantity'];
            $row[] = number_format($sub_total, 2, '.', ',');
            $row[] = number_format($final_net_total, 2, '.', ',');
            $row[] = $sr_data['remarks'];
            $row[] = $edit_row;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->sales_return_model->count_all(),
            "recordsFiltered" => $this->sales_return_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    public function make_return($id) {
        $input = $this->input->post();

        if (!empty($input)) {
            $sr_id = $id;
            //Update Invoice
            $datas['remarks'] = $input['po']['remarks'];
            $this->sales_return_model->update_inv($datas, $sr_id);

            // ERP Sales return..
            $data['net_total'] = $input['po']['net_total'];
            $data['subtotal_qty'] = $input['po']['subtotal_qty'];
            $this->sales_return_model->update_sales_return($data, $id);

            foreach ($input['categoty'] as $key => $val) {
                //Update Inv Details
                $return_quantity = $input['return_quantity'][$key];
                $this->sales_return_model->update_invoice_details($input['return_quantity'][$key], $input['inv_details_id'][$key]);

                //Insert Sales return details
                $insert['in_id'] = $id;
                $insert['q_id'] = $input['po']['q_id'];
                $insert['category'] = $val;
                $insert['product_id'] = $input['product_id'][$key];
                $insert['product_description'] = $input['product_description'][$key];
                $insert['brand'] = $input['brand'][$key];
                $insert['return_quantity'] = $input['return_quantity'][$key];
                $insert['per_cost'] = $input['per_cost'][$key];
                if ($input['check_gst'] == '1') {
                    if ($input['hsn_sac'][$key] != '')
                        $insert['hsn_sac'] = $input['hsn_sac'][$key];
                } else {
                    $insert['add_amount'] = $input['add_amount'][$key];
                }
                $insert['tax'] = $input['tax'][$key];
                $insert['gst'] = $input['gst'][$key];
                $insert['igst'] = $input['igst'][$key];
                $insert['sub_total'] = $input['sub_total'][$key];
                $insert['created_date'] = date('Y-m-d H:i');
                $insert_arr[] = $insert;
                $stock_arr = array();
                $po_id['inv_id'] = $input['po']['inv_id'];
                $stock_arr[] = $po_id;
                $this->stock_details($insert, $po_id);
            }
            $this->sales_return_model->insert_sr_details($insert_arr);
        }
        redirect($this->config->item('base_url') . 'sales_return/index');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */