<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Project_cost extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'project_cost';
        $access_arr = array(
            'project_cost/project_cost_list' => array('add', 'edit', 'delete', 'view'),
            'project_cost/invoice_list' => array('add', 'edit', 'delete', 'view'),
            'project_cost/index' => array('add', 'edit', 'delete', 'view'),
            'project_cost/add_invoice' => array('add', 'edit', 'delete', 'view'),
            'project_cost/quotation_view' => array('add', 'edit', 'delete', 'view'),
            'project_cost/invoice_view' => array('add', 'edit', 'delete', 'view'),
            'project_cost/invoice_edit' => array('add', 'edit', 'delete', 'view'),
            'project_cost/quotation_view' => array('add', 'edit', 'delete', 'view'),
            'project_cost/quotation_edit' => array('add', 'edit', 'delete', 'view'),
            'project_cost/new_quotation' => array('add', 'edit', 'delete', 'view'),
            'project_cost/quotation_delete' => array('delete'),
            'project_cost/quotation_add' => array('add', 'edit'),
            'project_cost/invoice_add' => array('add', 'edit'),
            'project_cost/update_quotation' => array('edit'),
            'project_cost/update_project_cost' => array('edit'),
            'project_cost/update_invoice' => array('edit'),
            'project_cost/get_stock' => 'no_restriction',
            'project_cost/stock_details' => 'no_restriction',
            'project_cost/get_po' => 'no_restriction',
            'project_cost/change_status' => 'no_restriction',
            'project_cost/change_pc_status' => 'no_restriction',
            'project_cost/get_customer' => 'no_restriction',
            'project_cost/get_service' => 'no_restriction',
            'project_cost/get_customer_by_id' => 'no_restriction',
            'project_cost/get_product' => 'no_restriction',
            'project_cost/get_product_by_id' => 'no_restriction',
            'project_cost/delete_id' => 'no_restriction',
            'project_cost/delete_pc_id' => 'no_restriction',
            'project_cost/send_email' => 'no_restriction',
            'project_cost/ajaxList' => 'no_restriction',
            'project_cost/change_completed_status' => 'no_restriction',
        );
        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('master_category/master_category_model');
        $this->load->model('master_style/master_model');
        $this->load->model('master_brand/master_brand_model');
        $this->load->model('project_cost/project_cost_model');
        $this->load->model('customer/customer_model');
        $this->load->model('enquiry/enquiry_model');
        $this->load->model('admin/admin_model');
        $this->load->model('quotation/Gen_model');
        $this->load->model('sales_return/sales_return_model');
    }

    public function index() {
        if ($this->input->post()) {
            $input = $this->input->post();
            $data['company_details'] = $this->admin_model->get_company_details();
            $user_info = $this->user_auth->get_from_session('user_info');
            $input['quotation']['created_by'] = $user_info[0]['id'];
            $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));

            $insert_id = $this->project_cost_model->insert_quotation($input['quotation']);
            if (isset($insert_id) && !empty($insert_id)) {
                $input = $this->input->post();
                if (isset($input['categoty']) && !empty($input['categoty'])) {
                    $insert_arr = array();
                    foreach ($input['categoty'] as $key => $val) {
                        $insert['j_id'] = $insert_id;
                        $insert['q_id'] = $input['quotation']['q_id'];
                        $insert['category'] = $val;
                        $insert['product_id'] = $input['product_id'][$key];
                        $insert['product_description'] = $input['product_description'][$key];
                        $insert['product_type'] = $input['product_type'][$key];
                        $insert['brand'] = $input['brand'][$key];
                        $insert['quantity'] = $input['quantity'][$key];
                        $insert['per_cost'] = $input['per_cost'][$key];
                        $insert['tax'] = $input['tax'][$key];
                        $insert['gst'] = $input['gst'][$key];
                        $insert['igst'] = $input['igst'][$key];
                        $insert['sub_total'] = $input['sub_total'][$key];
                        $insert['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert;
                    }
                    $this->project_cost_model->insert_quotation_details($insert_arr);
                }
                if (isset($input['item_name']) && !empty($input['item_name'])) {
                    $insert_arrs = array();
                    foreach ($input['item_name'] as $key => $val) {
                        $inserts['j_id'] = $insert_id;
                        $inserts['item_name'] = $val;
                        $inserts['amount'] = $input['amount'][$key];
                        $inserts['type'] = $input['type'][$key];

                        $insert_arrs[] = $inserts;
                    }
                    $this->project_cost_model->insert_other_cost($insert_arrs);
                }
            }

            $agent_ser = $this->project_cost_model->get_service_cost($insert['j_id']);
            $agent_other = $this->project_cost_model->get_other_cost($insert['j_id']);
            $user_info = $this->user_auth->get_from_session('user_info');
            $receipt = $this->project_cost_model->get_receipt_id($user_info[0]['id']);
            $amount = array();
            $user_info = $this->user_auth->get_from_session('user_info');
            $input = $this->input->post();
            $int['bill_amount'] = $agent_ser[0]['service_cost'] + $agent_other[0]['other_cost'];
            if ($user_info[0]['id'] != 0) {
                $int['recevier'] = 'agent';
                $int['recevier_id'] = $user_info[0]['id'];
                $int['receiver_type'] = 'Project Cost';
                $int['receipt_id'] = $input['quotation']['job_id'];
                $int['type'] = 'debit';
                $amount = $int;
                $this->load->model('receipt/receipt_model');
                $insert_agent_cash = $this->receipt_model->insert_agent_amount($amount);
            }

            redirect($this->config->item('base_url') . 'project_cost/project_cost_list');
        }
    }

    /**     * *****************EDIT PROJECT COST***************************************** */
    public function update_project_cost() {
        $input = $this->input->post();

        $project_cost_id = trim($this->input->post('pjt_cost_id'));
        $data['company_details'] = $this->admin_model->get_company_details();
        $user_info = $this->user_auth->get_from_session('user_info');

        $input['quotation']['created_by'] = $user_info[0]['id'];
        $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));
        $insert_id = $project_cost_id;
        $this->project_cost_model->update_project($input['quotation'], $project_cost_id);
        if (isset($insert_id) && !empty($insert_id)) {
            // $this->project_cost_model->delete_project_cost($project_cost_id);
            $input = $this->input->post();
            if (isset($input['categoty']) && !empty($input['categoty'])) {
                $insert_arr = array();
                foreach ($input['categoty'] as $key => $val) {
                    $insert['j_id'] = $insert_id;
                    $insert['q_id'] = $input['quotation']['q_id'];
                    $insert['category'] = $val;
                    $insert['product_id'] = $input['product_id'][$key];
                    $insert['product_description'] = $input['product_description'][$key];
                    $insert['product_type'] = $input['product_type'][$key];
                    $insert['add_amount'] = $input['add_amount'][$key];
                    $insert['brand'] = $input['brand'][$key];
                    $insert['quantity'] = $input['quantity'][$key];
                    $insert['per_cost'] = $input['per_cost'][$key];
                    $insert['tax'] = $input['tax'][$key];
                    $insert['gst'] = $input['gst'][$key];
                    $insert['igst'] = $input['igst'][$key];
                    $insert['sub_total'] = $input['sub_total'][$key];
                    $insert['created_date'] = date('Y-m-d H:i');
                    if ($input['available_quantity'][$key] != '') {
                        if ($input['old_quantity'][$key] != $input['quantity'][$key]) {

                            if ($input['old_quantity'][$key] > $input['quantity'][$key]) {

                                $dfff = $input['old_quantity'][$key] - $input['quantity'][$key];
                                $insertss['quantity'] = $input['available_quantity'][$key] + $dfff;
                                $inv_id['diff'] = $dfff;

                                $insertss['category'] = $val;
                                $insertss['brand'] = $input['brand'][$key];
                                $insertss['product_id'] = $input['product_id'][$key];
                                $inv_id['inv_id'] = $input['quotation']['job_id'];
                                $this->project_cost_model->update_stock($insertss, $inv_id);
                            } else if ($input['old_quantity'][$key] < $input['quantity'][$key]) {

                                $dfff1 = $input['quantity'][$key] - $input['old_quantity'][$key];
                                $insertss['quantity'] = $input['available_quantity'][$key] - $dfff1;
                                $inv_id['diff'] = - $dfff1;
                                $insertss['category'] = $val;
                                $insertss['brand'] = $input['brand'][$key];
                                $insertss['product_id'] = $input['product_id'][$key];
                                $inv_id['inv_id'] = $input['quotation']['job_id'];
                                $this->project_cost_model->update_stock($insertss, $inv_id);
                            }
                        }
                    }
                    $insert_arr[] = $insert;
                }

                $this->project_cost_model->delete_pcdetails_id($project_cost_id);
                $this->project_cost_model->insert_quotation_details($insert_arr);
            }
            if (isset($input['item_name']) && !empty($input['item_name'])) {
                $insert_arrs = array();
                foreach ($input['item_name'] as $key => $val) {
                    $inserts['j_id'] = $insert_id;
                    $inserts['item_name'] = $val;
                    $inserts['amount'] = $input['amount'][$key];
                    $inserts['type'] = $input['type'][$key];
                    $insert_arrs[] = $inserts;
                }

                $this->project_cost_model->delete_othercost($project_cost_id, 'project_cost');
                $this->project_cost_model->insert_other_cost($insert_arrs);
            }
        }


        $agent_ser = $this->project_cost_model->get_service_cost($insert['j_id']);
        $agent_other = $this->project_cost_model->get_other_cost($insert['j_id']);
        $user_info = $this->user_auth->get_from_session('user_info');
        $receipt = $this->project_cost_model->get_receipt_id($user_info[0]['id']);
        $amount = array();
        $user_info = $this->user_auth->get_from_session('user_info');
        $input = $this->input->post();
        $int['bill_amount'] = $agent_ser[0]['service_cost'] + $agent_other[0]['other_cost'];
        if ($user_info[0]['id'] != 0) {
            $int['recevier'] = 'agent';
            $int['recevier_id'] = $user_info[0]['id'];
            $int['receiver_type'] = 'Project Cost';
            $int['receipt_id'] = $input['quotation']['job_id'];
            $int['type'] = 'debit';
            $amount = $int;
            $this->load->model('receipt/receipt_model');
            $insert_agent_cash = $this->receipt_model->insert_agent_amount($amount);
        }
        redirect($this->config->item('base_url') . 'project_cost/project_cost_list');
        // }
    }

    /*     * *******************EDIT PROJECT COST*************************************** */

    public function add_invoice() {
        if ($this->input->post()) {
            $user_info = $this->user_auth->get_from_session('user_info');
            $input = $this->input->post();
            $date = date('Y-m-d', strtotime($input['quotation']['warranty_from']));
            $new_date = date('Y-m-d', strtotime($input['quotation']['warranty_to']));
            $input['quotation']['warranty_from'] = $date;
            $input['quotation']['warranty_to'] = $new_date;
            //   echo "<pre>"; print_r($input); exit;
            $data['company_details'] = $this->admin_model->get_company_details();
            $user_info = $this->user_auth->get_from_session('user_info');
            $input['quotation']['created_by'] = $user_info[0]['id'];
            $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));
            $insert_id = $this->project_cost_model->insert_invoice($input['quotation']);
            $this->sales_return_model->insert_sr($input['quotation']);
            if (isset($insert_id) && !empty($insert_id)) {
                $input = $this->input->post();
                if (isset($input['categoty']) && !empty($input['categoty'])) {
                    $insert_arr = array();
                    foreach ($input['categoty'] as $key => $val) {
                        $insert['in_id'] = $insert_id;
                        $insert['q_id'] = $input['quotation']['q_id'];
                        $insert['category'] = $val;
                        $insert['product_id'] = $input['product_id'][$key];
                        $insert['product_description'] = $input['product_description'][$key];
                        $insert['product_type'] = $input['product_type'][$key];
                        $insert['brand'] = $input['brand'][$key];
                        $insert['quantity'] = $input['quantity'][$key];
                        $insert['per_cost'] = $input['per_cost'][$key];
                        $insert['tax'] = $input['tax'][$key];
                        $insert['sub_total'] = $input['sub_total'][$key];
                        $insert['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert;
                        $stock_arr = array();
                        $inv_id['inv_id'] = $input['quotation']['inv_id'];
                        $stock_arr[] = $inv_id;
                        $this->stock_details($insert, $inv_id);
                    }
                    $this->project_cost_model->insert_invoice_details($insert_arr);
                }
                if (isset($input['item_name']) && !empty($input['item_name'])) {
                    $insert_arrs = array();
                    foreach ($input['item_name'] as $key => $val) {
                        $inserts['j_id'] = $insert_id;
                        $inserts['item_name'] = $val;
                        $inserts['amount'] = $input['amount'][$key];
                        $inserts['type'] = $input['type'][$key];
                        $insert_arrs[] = $inserts;
                    }
                    $this->project_cost_model->insert_other_cost($insert_arrs);
                }
            }
            $insert_id++;
            $inc['type'] = 'inv_code';
            $inc['value'] = 'INV000' . $insert_id;
            $this->project_cost_model->update_increment2($inc);
            redirect($this->config->item('base_url') . 'project_cost/project_cost_list');
        }
    }

    public function update_invoice($id) {

        if ($this->input->post()) {
            $input = $this->input->post();
            // if ($this->project_cost_model->delete_invoice_details(trim($input['quotation']['q_id']))) {

            $user_info = $this->user_auth->get_from_session('user_info');
            $date = date('Y-m-d', strtotime($input['quotation']['warranty_from']));
            $new_date = date('Y-m-d', strtotime($input['quotation']['warranty_to']));
            $input['quotation']['warranty_from'] = $date;
            $input['quotation']['warranty_to'] = $new_date;
            if ($input['check_gst'] == 'on') {
                $input_gst['is_gst'] = '1';
            } else {
                $input_gst['is_gst'] = '0';
            }

            $input['quotation']['is_gst'] = $input_gst['is_gst'];
            $data['company_details'] = $this->admin_model->get_company_details();
            $user_info = $this->user_auth->get_from_session('user_info');
            $input['quotation']['created_by'] = $user_info[0]['id'];
            $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));
            $this->project_cost_model->update_invoice($input['quotation'], $id);
            $this->project_cost_model->update_sr($input['quotation'], $id);
            $this->project_cost_model->delete_return_inv_by_id($id);
            if (isset($id) && !empty($id)) {
                $input = $this->input->post();
                if (isset($input['categoty']) && !empty($input['categoty'])) {
                    $insert_arr = array();
                    foreach ($input['categoty'] as $key => $val) {
                        $insert['in_id'] = $id;
                        $insert['q_id'] = $input['quotation']['q_id'];
                        $insert['category'] = $val;
                        $insert['product_id'] = $input['product_id'][$key];
                        $insert['product_description'] = $input['product_description'][$key];
                        $insert['product_type'] = $input['product_type'][$key];
                        $insert['brand'] = $input['brand'][$key];
                        $insert['quantity'] = $input['quantity'][$key];
                        $insert['return_quantity'] = 0;
                        $insert['current_quantity'] = $input['quantity'][$key];
                        $insert['per_cost'] = $input['per_cost'][$key];
                        if ($input_gst['is_gst'] == '1') {
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
                        if ($input['available_quantity'][$key] != '') {
                            if ($input['old_quantity'][$key] != $input['quantity'][$key]) {

                                if ($input['old_quantity'][$key] > $input['quantity'][$key]) {

                                    $dfff = $input['old_quantity'][$key] - $input['quantity'][$key];
                                    $insertss['quantity'] = $input['available_quantity'][$key] + $dfff;
                                    $inv_id['diff'] = $dfff;

                                    $insertss['category'] = $val;
                                    $insertss['brand'] = $input['brand'][$key];
                                    $insertss['product_id'] = $input['product_id'][$key];
                                    $inv_id['inv_id'] = $input['quotation']['inv_id'];
                                    $this->project_cost_model->update_stock($insertss, $inv_id);
                                } else if ($input['old_quantity'][$key] < $input['quantity'][$key]) {

                                    $dfff1 = $input['quantity'][$key] - $input['old_quantity'][$key];
                                    $insertss['quantity'] = $input['available_quantity'][$key] - $dfff1;
                                    $inv_id['diff'] = - $dfff1;
                                    $insertss['category'] = $val;
                                    $insertss['brand'] = $input['brand'][$key];
                                    $insertss['product_id'] = $input['product_id'][$key];
                                    $inv_id['inv_id'] = $input['quotation']['inv_id'];
                                    $this->project_cost_model->update_stock($insertss, $inv_id);
                                }
                            }
                        }
                        //$stock_arr = array();
                        //$inv_id['inv_id'] = $input['quotation']['inv_id'];
                        //$stock_arr[] = $inv_id;
                        //$this->stock_details($insert, $inv_id);
                        //$this->project_cost_model->update_invoice_details($insert, $id);
                    }

                    $this->project_cost_model->delete_invoice_details($id);
                    $this->project_cost_model->insert_invoice_details($insert_arr);
                    //$this->project_cost_model->update_invoice_details($insert_arr, $id);
                }

                if (isset($input['item_name']) && !empty($input['item_name'])) {
                    $insert_arrs = array();
                    foreach ($input['item_name'] as $key => $val) {
                        $inserts['j_id'] = $id;
                        $inserts['item_name'] = $val;
                        $inserts['amount'] = $input['amount'][$key];
                        $inserts['type'] = $input['type'][$key];
                        $insert_arrs[] = $inserts;
                    }

                    $this->project_cost_model->delete_othercost($id, 'invoice');
                    //$this->project_cost_model->update_other_cost($insert_arrs);
                    $this->project_cost_model->insert_other_cost($insert_arrs);
                }
            }
//            $insert_id++;
//            $inc['type'] = 'inv_code';
//            $inc['value'] = 'INV000' . $id;
//            $this->project_cost_model->update_increment2($inc);
            redirect($this->config->item('base_url') . 'project_cost/project_cost_list');
        }
        // }
    }

    function get_stock() {
        $data = $this->input->get();
        $stock = $this->project_cost_model->get_stock($data);
        if (isset($stock) && !empty($stock)) {

            echo '<input type="text" tabindex="-1" name="available_quantity[]" style="width:70px;" class="code form-control colournamedup tabwid form-align " value="' . $stock[0]['quantity'] . '" readonly="readonly" autocomplete="off">';
        }
    }

    function stock_details($stock_info, $inv_id) {

        $this->project_cost_model->check_stock($stock_info, $inv_id);
    }

    function get_po() {
        $data = $this->input->get();
        $stock = $this->project_cost_model->get_po($data);
        if (isset($stock) && !empty($stock)) {
            echo'<input type="text"   tabindex="-1" value="' . $stock[0]['per_cost'] . '"   name="per_cost[]" style="width:70px;" class="percost required " id="price"/><span class="error_msg"></span>';
        } else {
            echo'<input type="text"   tabindex="-1"  name="per_cost[]" style="width:70px;" class="percost required" id="price"/><span class="error_msg"></span>';
        }
    }

    public function quotation_view($id) {
        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_pc_by_id($id);
        $datas["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_pc_details_by_id($id);
        $datas["in_words"] = $this->convert_number($datas["quotation"][0]['net_total']);
        //echo"<pre>"; print_r($datas); exit;
        $datas["category"] = $category = $this->master_category_model->get_all_category();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();
        $this->template->write_view('content', 'project_cost_view', $datas);
        $this->template->render();
    }

    public function quotation_edit($id) {
        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_pc_by_id($id);
        $datas["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_pc_details_by_id($id);
//        echo"<pre>";
//        print_r($datas);
//        exit;
        $datas["in_words"] = $this->convert_number($datas["quotation"][0]['net_total']);
        $datas["category"] = $category = $this->master_category_model->get_all_category();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();
        $datas["products"] = $this->Gen_model->get_product_data();
        $datas["products1"] = $this->Gen_model->get_all_product1();
        $this->template->write_view('content', 'project_cost_edit', $datas);
        $this->template->render();
    }

    public function invoice_view($id) {
        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_invoice_by_id($id);
        $datas["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_invoice_details_by_id($id);
        $datas["in_words"] = $this->convert_number($datas["quotation"][0]['net_total']);
        $datas["category"] = $category = $this->master_category_model->get_all_category();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();
        $this->template->write_view('content', 'invoice_view', $datas);
        $this->template->render();
    }

    public function invoice_edit($id) {
        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_invoice_by_id($id);
        $datas["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_invoice_details_by_id($id, $datas["quotation"]["q_id"]);
//        echo"<pre>";
//        print_r($datas);
//        exit;
        $datas["category"] = $category = $this->master_category_model->get_all_category();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();
        $datas["last_id"] = $this->master_model->get_last_id('inv_code');
        $datas["products"] = $this->Gen_model->get_product_data();
        $datas["products1"] = $this->Gen_model->get_all_product1();
        $this->template->write_view('content', 'invoice_edit', $datas);
        $this->template->render();
    }

    public function change_status($id, $status) {
        $this->project_cost_model->change_quotation_status($id, $status);
        redirect($this->config->item('base_url') . 'project_cost/project_cost_list');
    }

    public function project_cost_list() {

        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_quotation();
        $datas['company_details'] = $this->admin_model->get_company_details();
        //echo"<pre>"; print_r($datas); exit;
        $this->template->write_view('content', 'project_cost/project_cost_list', $datas);
        $this->template->render();
    }

    public function get_customer() {
        $atten_inputs = $this->input->post();
        $data = $this->project_cost_model->get_customer($atten_inputs);
        echo json_encode($data);
        exit;
//        echo '<ul id="country-list">';
//        if (isset($data) && !empty($data)) {
//            foreach ($data as $st_rlno) {
//                if ($st_rlno['name'] != '')
//                    echo '<li class="cust_class" cust_name="' . $st_rlno['name'] . '" cust_id="' . $st_rlno['id'] . '" cust_no="' . $st_rlno['mobil_number'] . '" cust_email="' . $st_rlno['email_id'] . '" cust_address="' . $st_rlno['address1'] . '">' . $st_rlno['name'] . '</li>';
//            }
//        }
//        else {
//            echo '<li style="color:red;">No Data Found</li>';
//        }
//        echo '</ul>';
    }

    public function get_service() {
        $atten_inputs = $this->input->post();
        $product_data = $this->project_cost_model->get_service($atten_inputs);
        echo json_encode($product_data);
        exit;

//        echo '<ul id="service-list">';
//        if (isset($product_data) && !empty($product_data)) {
//            foreach ($product_data as $st_rlno) {
//                if ($st_rlno['model_no'] != '')
//                    echo '<li class="ser_class" ser_cost="' . $st_rlno['cost_price'] . '"ser_sell="' . $st_rlno['cost_price'] . '" ser_type="' . $st_rlno['type'] . '" ser_id="' . $st_rlno['id'] . '" ser_no="' . $st_rlno['model_no'] . '" ser_name="' . $st_rlno['product_name'] . '" ser_description="' . $st_rlno['product_description'] . '" ser_image="' . $st_rlno['product_image'] . '"ser_cat ="' . $st_rlno['category_id'] . '"ser_brand ="' . $st_rlno['brand_id'] . '">' . $st_rlno['model_no'] . '</li>';
//            }
//        }
//        else {
//            echo '<li style="color:red;">No Data Found</li>';
//        }
//        echo '</ul>';
    }

    public function get_customer_by_id() {
        $input = $this->input->post();
        $data_customer["customer_details"] = $this->project_cost_model->get_customer_by_id($input['id']);
        echo json_encode($data_customer);
    }

    public function get_product() {
        $atten_inputs = $this->input->post();
        $product_data = $this->project_cost_model->get_product($atten_inputs);
        echo json_encode($product_data);
        exit;
    }

    public function get_product_by_id() {
        $input = $this->input->post();
        $data_customer["product_details"] = $this->project_cost_model->get_product_by_id($input['id']);
        echo json_encode($data_customer);
    }

    public function delete_id() {
        $input = $this->input->get();
        $del = $this->project_cost_model->delete_id($input['del_id']);
    }

    public function delete_pc_id() {
        $input = $this->input->get();
        $del = $this->project_cost_model->delete_pc_id($input['del_id']);
    }

    public function quotation_add($id) {
        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_quotation_by_id($id);
        $datas["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_quotation_details_by_id($id);
//        echo "<pre>";
//        print_r($datas);
//        exit;
        $datas["category"] = $category = $this->master_category_model->get_all_category();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();
        $datas["products"] = $this->Gen_model->get_all_product();
        $datas["products1"] = $this->Gen_model->get_all_product1();
        // $datas["last_id"]=$this->master_model->get_last_id('job_code');

        $this->template->write_view('content', 'project_cost_add', $datas);
        $this->template->render();
    }

    public function invoice_add($id, $q_id) {
        $id = $_GET['id'];
        $q_id = $_GET['q_id'];
        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_project_cost_by_id($id);
        $datas["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_project_details_by_id($id, $q_id);

        $datas["category"] = $category = $this->master_category_model->get_all_category();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();
        $datas["last_id"] = $this->master_model->get_last_id('inv_code');
        $datas["products"] = $this->Gen_model->get_all_product();
        $datas["products1"] = $this->Gen_model->get_all_product1();
        $this->template->write_view('content', 'invoice_add', $datas);
        $this->template->render();
    }

    public function update_quotation($id) {
        $his_quo = $this->project_cost_model->get_his_quotation_by_id($id);
        $his_quo[0]['org_q_id'] = $his_quo[0]['id'];
        unset($his_quo[0]['id']);
        //echo "<pre>"; print_r($his_quo); exit;
        $insert_id = $this->project_cost_model->insert_history_quotation($his_quo[0]);
        $input = $this->input->post();
        // echo "<pre>"; print_r($input); exit;
        $input['quotation']['notification_date'] = date('Y-m-d');
        $input['quotation']['delivery_schedule'] = date('Y-m-d');
        $user_info = $this->user_auth->get_from_session('user_info');
        $input['quotation']['created_by'] = $user_info[0]['id'];
        $input['quotation']['created_date'] = date('Y-m-d H:i:s');
        $update_id = $this->project_cost_model->update_quotation($input['quotation'], $id);
        $his_quo1 = $this->project_cost_model->get_all_history_quotation_by_id($id);
        //echo "<pre>"; print_r($his_quo1); exit;
        $his_quo_details['hist'] = $this->project_cost_model->get_his_quotation_deteils_by_id($id);
        if (isset($his_quo_details['hist']) && !empty($his_quo_details['hist'])) {
            $insert_arrs = array();
            foreach ($his_quo_details['hist'] as $key) {
                $inserts = $key;
                $inserts['h_id'] = $insert_id;
                $inserts['org_q_id'] = $his_quo1[0]['org_q_id'];
                unset($inserts['id']);
                unset($inserts['q_id']);
                $insert_arrs[] = $inserts;
            }
            // echo "<pre>"; print_r($insert_arrs); exit;
            $this->project_cost_model->insert_history_quotation_details($insert_arrs);

            $delete_id = $this->project_cost_model->delete_quotation_deteils_by_id($id);
        }
        $input = $this->input->post();
        if (isset($input['categoty']) && !empty($input['categoty'])) {
            $insert_arr = array();
            foreach ($input['categoty'] as $key => $val) {

                $insert['q_id'] = $his_quo[0]['org_q_id'];
                $insert['category'] = $val;
                $insert['product_id'] = $input['product_id'][$key];
                $insert['product_description'] = $input['product_description'][$key];
                $insert['brand'] = $input['brand'][$key];
                $insert['quantity'] = $input['quantity'][$key];
                $insert['per_cost'] = $input['per_cost'][$key];
                $insert['tax'] = $input['tax'][$key];
                $insert['sub_total'] = $input['sub_total'][$key];
                $insert['created_date'] = date('Y-m-d H:i:s');
                $insert_arr[] = $insert;
            }
            // echo "<pre>"; print_r($insert_arr); exit;
            $this->project_cost_model->insert_quotation_details($insert_arr);
        }

        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_quotation();
        redirect($this->config->item('base_url') . 'project_cost/project_cost_list');
    }

    public function quotation_delete() {
        $id = $this->input->POST('value1');
        $datas["quotation"] = $quotation = $this->project_cost_model->get_all_quotation();
        $del_id = $this->project_cost_model->delete_quotation($id);
        redirect($this->config->item('base_url') . 'project_cost/project_cost_list');
    }

    public function send_email() {

        $this->load->library("Pdf");
        $id = $this->input->get();
        $data["quotation"] = $quotation = $this->project_cost_model->get_all_invoice_by_id($id['id']);
        $data["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_invoice_details_by_id($id['id']);
        $data["category"] = $category = $this->master_category_model->get_all_category();
        $data['company_details'] = $this->admin_model->get_company_details();
        $data["brand"] = $brand = $this->master_brand_model->get_brand();
        $data["email_details"] = $email_details = $this->project_cost_model->get_all_email_details();

        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $this->email->initialize($config);
        $to_array = array($data['company_details'][0]['email'], $data['quotation'][0]['email_id']);
        $this->email->clear(TRUE);
        $this->email->to(implode(', ', $to_array));
        $this->email->from($data['email_details'][1]['value'], $data['email_details'][0]['value']);
        // $this->email->to($data['company_details'][0]['email'],$data['quotation'][0]['email_id']);
        $this->email->cc($data['email_details'][3]['value']);
        $this->email->subject($data['email_details'][2]['value']);
        $this->email->set_mailtype("html");
        $msg1['test'] = $this->load->view('project_cost/email_page', $data, TRUE);
        //$msg1['company_details']=$data['company_details'];
//        $header = $this->load->view('quotation/pdf_header_view', $data, TRUE);
        $msg = $this->load->view('project_cost/pdf_email_template', $msg1, TRUE);
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->AddPage();
//        $pdf->Header($header);
        $pdf->writeHTMLCell(0, 0, '', '', $msg, 0, 1, 0, true, '', true);
        $filename = 'Invoice-' . date('d-M-Y-H-i-s') . '.pdf';
        $newFile = $this->config->item('theme_path') . 'attachement/' . $filename;
        $pdf->Output($newFile, 'F');
        //echo "<pre>"; print_r($data); exit;
        $this->email->attach($this->config->item('theme_path') . 'attachement/' . $filename);
        $data["content_msg"] = 'Dear sir,<br>Kindly find the attachment for Invoice Details <b>' . $data['quotation'][0]['inv_id'] . '</b><br><br>Thanks<br>'
                . $data['quotation'][0]['store_name'] . '<br>
                        ' . $data['quotation'][0]['address1'] . ' <br>
                       PH - ' . $data['quotation'][0]['mobil_number'] . ' <br>
                        Email ID - ' . $data['quotation'][0]['email_id'] . ' <br>';
        $html_message = $this->load->view('quotation/quotation_send_email.php', $data, TRUE);
        $this->email->message($html_message);
        $this->email->send();
    }

    function ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
        $list = $this->project_cost_model->get_datatables($search_data);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pc_data) {
            if ($this->user_auth->is_action_allowed('project_cost', 'project_cost', 'edit')) {
                $pc_edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light" href="' . base_url() . 'project_cost/invoice_edit/' . $pc_data['inv_amount'][0]['id'] . '" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-pencil "></span></a>';
            } else {
                $pc_edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-pencil"></span></a>';
            }
            if ($this->user_auth->is_action_allowed('project_cost', 'project_cost', 'view')) {
                $pc_view_row = '<a class="btn btn-info btn-mini waves-effect waves-light" href="' . base_url() . 'project_cost/invoice_view/' . $pc_data['inv_amount'][0]['id'] . '" data-toggle="tooltip" data-placement="top" title="View"><span class="fa fa-eye"></span></a>';
            } else {
                $pc_view_row = '<a class="btn btn-info btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-eye"></span></a>';
            }
            if ($this->user_auth->is_action_allowed('project_cost', 'project_cost', 'add')) {
                $pc_add_row = '<a class="btn btn-success  btn-mini waves-effect waves-light" href="' . base_url() . 'project_cost/invoice_add?id=' . $pc_data['pc_amount'][0]['id'] . '&q_id=' . $pc_data['pc_amount'][0]['q_id'] . '" data-toggle="tooltip" data-placement="top" title="Add"><span class="fa fa-plus "></span></a>';
            } else {
                $pc_add_row = '<a class="btn btn-success btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-plus"></span></a>';
            }


            if ($this->user_auth->is_action_allowed('project_cost', 'project_cost', 'edit')) {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light" href="' . base_url() . 'project_cost/quotation_edit/' . $pc_data['pc_amount'][0]['id'] . '" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-pencil "></span></a>';
            } else {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-pencil"></span></a>';
            }
            if ($this->user_auth->is_action_allowed('project_cost', 'project_cost', 'view')) {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light" href="' . base_url() . 'project_cost/quotation_view/' . $pc_data['pc_amount'][0]['id'] . '" data-toggle="tooltip" data-placement="top" title="View"><span class="fa fa-eye"></span></a>';
            } else {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-eye"></span></a>';
            }
            if ($this->user_auth->is_action_allowed('project_cost', 'project_cost', 'add')) {
                $add_row = '<a class="btn btn-success  btn-mini waves-effect waves-light" href="' . base_url() . 'project_cost/quotation_add/' . $pc_data['id'] . '" data-toggle="tooltip" data-placement="top" title="Add"><span class="fa fa-plus "></span></a>';
            } else {
                $add_row = '<a class="btn btn-success btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-plus"></span></a>';
            }
            $no++;

            $row = array();
            $row[] = $no;
            $row[] = $pc_data['q_no'];
            $row[] = $pc_data['store_name'];
            $row[] = number_format($pc_data['net_total'], 2, '.', ',');
//            if ($user_info[0]['role'] != 4) {
            $row[] = $pc_data['inv_amount'][0]['inv_id'];
            $row[] = number_format($pc_data['inv_amount'][0]['net_total'], 2, '.', ',');
            $row[] = $pc_edit_row . '&nbsp;&nbsp;' . $pc_view_row;
//            }
            $row[] = $pc_data['job_id'];
            $row[] = number_format($pc_data['pc_amount'][0]['net_total'], 2, '.', ',');
            if ($pc_data['pc_amount'][0]['complete_status'] == 2) {
                $row[] = $view_row;
            } else {
                $row[] = $edit_row . '&nbsp;&nbsp;' . $view_row;
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->project_cost_model->count_all(),
            "recordsFiltered" => $this->project_cost_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    public function change_completed_status($id, $status) {

        $this->project_cost_model->change_completed_status($id, $status);
        redirect($this->config->item('base_url') . 'project_cost/project_cost_list');
    }

    function convert_number(float $number) {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            } else
                $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */