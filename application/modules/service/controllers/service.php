<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Service extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'service';
        $access_arr = array(
            'service/index' => array('add', 'edit', 'delete', 'view'),
            'service/add_invoice' => array('add', 'edit', 'delete', 'view'),
            'service/get_service' => array('add', 'edit', 'delete', 'view'),
            'service/quotation_view' => array('add', 'edit', 'delete', 'view'),
            'service/invoice_view' => array('add', 'edit', 'delete', 'view'),
            'service/get_customer_by_id' => array('add', 'edit'),
            // 'service/get_product' => array('add', 'edit'),
            'service/change_status' => 'no_restriction',
            'service/service_list' => 'no_restriction',
            'service/stock_details' => 'no_restriction',
            'service/service_view' => 'no_restriction',
            'service/get_customer' => 'no_restriction',
            'service/get_product' => 'no_restriction',
            'service/get_product_by_id' => 'no_restriction',
            'service/get_invoice' => 'no_restriction',
            'service/project_cost_add' => 'no_restriction',
            'service/project_cost_update' => 'no_restriction',
            'service/paid_service_add' => 'no_restriction',
            'service/update_quotation' => 'no_restriction',
            'service/quotation_delete' => 'no_restriction',
            'service/history_view' => 'no_restriction',
            'service/project_cost_warranty_service' => 'no_restriction',
            'service/ajaxList' => 'no_restriction',
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
        $this->load->model('service/service_model');
        $this->load->model('api/increment_model');
    }

    public function index() {
        if ($this->input->post()) {
            $input = $this->input->post();

            $data['company_details'] = $this->admin_model->get_company_details();
            $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
            $input['quotation']['created_by'] = $user_info[0]['id'];
            $input['quotation']['created_date'] = date('Y-m-d H:i');
//            if ($input['check_gst'] == 'on') {
//                $input_gst['is_gst'] = '1';
//            } else {
//                $input_gst['is_gst'] = '0';
//            }
            $input['quotation']['is_gst'] = $input_gst['is_gst'];
            //$this->service_model->delete_quotation( $input['quotation']['q_id']);
            $this->service_model->delete_quotation_deteils_by_id($input['quotation']['q_id']);
            $this->service_model->update_quotation($input['quotation'], $input['quotation']['q_id']);
            $insert_id = $this->service_model->get_id($input['quotation']['q_id']);
            //   echo"<pre>"; print_r($insert_id[0]['id']); exit;
            if (isset($insert_id) && !empty($insert_id)) {
                $input = $this->input->post();

                if (isset($input['categoty']) && !empty($input['categoty'])) {
                    $insert_arr = array();
                    foreach ($input['categoty'] as $key => $val) {
                        $insert['j_id'] = $insert_id[0]['id'];
                        $insert['q_id'] = $input['quotation']['q_id'];
                        $insert['category'] = $val;
                        $insert['product_id'] = $input['product_id'][$key];
                        $insert['product_description'] = $input['product_description'][$key];
                        $insert['brand'] = $input['brand'][$key];
                        $insert['quantity'] = $input['quantity'][$key];
                        $insert['per_cost'] = $input['per_cost'][$key];
//                        if ($input_gst['is_gst'] == '1') {
//                            if ($input['hsn_sac'][$key] != '')
//                                $insert['hsn_sac'] = $input['hsn_sac'][$key];
//                        } else {
                        $insert['add_amount'] = $input['add_amount'][$key];
//                        }
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

                    $this->service_model->insert_quotation_details($insert_arr);
                }
                if (isset($input['item_name']) && !empty($input['item_name'])) {
                    $insert_arrs = array();
                    foreach ($input['item_name'] as $key => $val) {
                        $inserts['j_id'] = $insert_id[0]['id'];
                        $inserts['item_name'] = $val;
                        $inserts['amount'] = $input['amount'][$key];
                        $inserts['type'] = $input['type'][$key];

                        $insert_arrs[] = $inserts;
                    }
                    $this->service_model->insert_other_cost($insert_arrs);
                }
            }
            // $insert_id++;
            //$inc['type'] = 'job_code';
            // $inc['value'] = 'JOB000' . $insert_id;
            // $this->service_model->update_increment($inc);
            redirect($this->config->item('base_url') . 'service/service_list');
        }
    }

    public function add_invoice() {
        if ($this->input->post()) {
            $input = $this->input->post();
            $date = date('Y-m-d', strtotime($input['quotation']['warranty_from']));
            $new_date = date('Y-m-d', strtotime($input['quotation']['warranty_to']));
            $input['quotation']['warranty_from'] = $date;
            $input['quotation']['warranty_to'] = $new_date;
            // echo "<pre>"; print_r($input); exit;
            $data['company_details'] = $this->admin_model->get_company_details();
            $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
            $input['quotation']['created_by'] = $user_info[0]['id'];
            $input['quotation']['created_date'] = date('Y-m-d H:i');
            $insert_id = $this->service_model->insert_invoice($input['quotation']);
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
                    $this->service_model->insert_invoice_details($insert_arr);
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
                    $this->service_model->insert_other_cost($insert_arrs);
                }
            }
            $insert_id++;
            $inc['type'] = 'inv_code';
            $inc['value'] = 'INV000' . $insert_id;
            $this->service_model->update_increment2($inc);
            redirect($this->config->item('base_url') . 'service/service_list');
        }
    }

    function stock_details($stock_info, $inv_id) {

        $this->service_model->check_stock($stock_info, $inv_id);
    }

    public function get_service() {
        $atten_inputs = $this->input->post();
        $product_data = $this->service_model->get_service($atten_inputs);
        echo json_encode($product_data);
        exit;
//        echo '<ul id="service-list">';
//        if (isset($product_data) && !empty($product_data)) {
//            foreach ($product_data as $st_rlno) {
//                if ($st_rlno['model_no'] != '')
//                    echo '<li class="ser_class" ser_cost="' . $st_rlno['cost_price'] . '"ser_sell="' . $st_rlno['selling_price'] . '" ser_type="' . $st_rlno['type'] . '" ser_id="' . $st_rlno['id'] . '" ser_no="' . $st_rlno['model_no'] . '" ser_name="' . $st_rlno['product_name'] . '" ser_description="' . $st_rlno['product_description'] . '" ser_image="' . $st_rlno['product_image'] . '"ser_cat ="' . $st_rlno['category_id'] . '"ser_brand ="' . $st_rlno['brand_id'] . '">' . $st_rlno['model_no'] . '</li>';
//            }
//        }
//        else {
//            echo '<li style="color:red;">No Data Found</li>';
//        }
//        echo '</ul>';
    }

    public function quotation_view($id) {
        $datas["quotation"] = $quotation = $this->service_model->get_all_pc_by_id($id);
        $datas["quotation_details"] = $quotation_details = $this->service_model->get_all_pc_details_by_id($id);
        $datas["category"] = $category = $this->service_model->get_all_category();
        $datas['company_details'] = $this->service_model->get_company_details();
        $datas["brand"] = $brand = $this->service_model->get_brand();
        $this->template->write_view('content', 'project_cost_view', $datas);
        $this->template->render();
    }

    public function invoice_view($id) {
        $datas["quotation"] = $quotation = $this->service_model->get_all_invoice_by_id($id);
        $datas["quotation_details"] = $quotation_details = $this->service_model->get_all_invoice_details_by_id($id);
        //echo "<pre>"; print_r($datas); exit;
        $datas["category"] = $category = $this->service_model->get_all_category();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();
        $this->template->write_view('content', 'invoice_view', $datas);
        $this->template->render();
    }

    public function change_status($id, $status) {
        $this->service_model->change_quotation_status($id, $status);
        redirect($this->config->item('base_url') . 'service/service_list');
    }

    public function service_list() {

        $datas["quotation"] = $quotation = $this->service_model->get_all_quotation();
        $datas['company_details'] = $this->admin_model->get_company_details();
        //echo "<pre>"; print_r($datas); exit;
        $this->template->write_view('content', 'service/service_list', $datas);
        $this->template->render();
    }

    public function service_view($id) {

        $datas["quotation"] = $quotation = $this->service_model->get_all_inv_by_id($id);
        $datas["quotation_details"] = $quotation_details = $this->service_model->get_all_inv_details_by_id($id);
        $datas["in_words"] = $this->convert_number($datas["quotation"][0]['net_total']);
        $datas["category"] = $category = $this->master_category_model->get_all_category();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();

        $this->template->write_view('content', 'service_view', $datas);
        $this->template->render();
    }

    public function get_customer() {
        $atten_inputs = $this->input->post();
        $data = $this->service_model->get_customer($atten_inputs);
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

    public function get_customer_by_id() {
        $input = $this->input->post();
        $data_customer["customer_details"] = $this->service_model->get_customer_by_id($input['id']);
        echo json_encode($data_customer);
    }

    public function get_product() {
        $atten_inputs = $this->input->post();
        $product_data = $this->service_model->get_product($atten_inputs);
        echo json_encode($product_data);
        exit;
//        echo '<ul id="product-list">';
//        if (isset($product_data) && !empty($product_data)) {
//            foreach ($product_data as $st_rlno) {
//                if ($st_rlno['model_no'] != '')
//                    echo '<li class="pro_class" pro_cost="' . $st_rlno['cost_price'] . '"pro_sell="' . $st_rlno['selling_price'] . '" pro_id="' . $st_rlno['id'] . '" mod_no="' . $st_rlno['model_no'] . '" pro_name="' . $st_rlno['product_name'] . '" pro_description="' . $st_rlno['product_description'] . '" pro_image="' . $st_rlno['product_image'] . '"pro_cat ="' . $st_rlno['category_id'] . '"pro_brand ="' . $st_rlno['brand_id'] . '">' . $st_rlno['model_no'] . '</li>';
//            }
//        }
//        else {
//            echo '<li style="color:red;">No Data Found</li>';
//        }
//        echo '</ul>';
    }

    public function get_product_by_id() {
        $input = $this->input->post();
        $data_customer["product_details"] = $this->service_model->get_product_by_id($input['id']);
        echo json_encode($data_customer);
    }

    public function get_invoice() {
        $input = $this->input->get();

        $data["invoice"] = $invoice = $this->service_model->get_all_invoice_by_id($input['q_id']);

        $url = $this->config->item('base_url') . 'service/project_cost_add/' . $input['q_id'];

        $urls = $this->config->item('base_url') . 'service/project_cost_warranty_service/' . $input['q_id'];

        $url1 = $this->config->item('base_url') . 'service/service_list/';
        $completed_url = $this->config->item('base_url') . 'service/paid_service_add/';
        $date = Date($invoice[0]['warranty_to']) - Date($invoice[0]['warranty_from']);
        $current_date = date("Y-m-d");
        $warranty_to_date = Date($invoice[0]['warranty_to']);
//        if ($date == 1) {
        if (strtotime($warranty_to_date) > strtotime($current_date)) {
            echo '<table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" ><tr> <th colspan="2">  Free Warranty Service is Avaliable </th> </tr>';
            echo '<tr><td class="text-left">Warranty From</td><td> <input type="text"  name="available_quantity[]" style="width: 175px;" class="code form-control colournamedup tabwid form-control " value="' . $invoice[0]['warranty_from'] . '" readonly="readonly" ></td></tr>';
            echo '<tr><td class="text-left">Warranty To </td><td><input type="text" name="available_quantity[]" style="width: 175px;" class="code form-control colournamedup tabwid form-control " value="' . $invoice[0]['warranty_to'] . '" readonly="readonly" ></td></tr></table>';

            echo '<table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" ><tr> <td style="text-align: left;" colspan="2" ><b> Customer Details: </b></br><b>Contact Person: </b>' . $invoice[0]['name'] . ' </br><b>Company: </b>' . $invoice[0]['store_name'] . ' </br><b>Mobile Number: </b>' . $invoice[0]['mobil_number'] . ' </br><b>Email: </b>' . $invoice[0]['email_id'] . ' </br><b>Address: </b>' . $invoice[0]['address1'] . ' </br></td> </tr>';

            echo '<table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" ><tr align="center"> <td align="center" colspan="2" > Free Warranty Service is Avaliable <b>' . $input['q_no'] . ' </b></td> </tr>';
            echo ' <tr> <td align="center"  colspan="2"> <a href= "' . $urls . '" class="btn btn-success btn-sm m-10">Continue</a> ';
            echo '  <a href= "' . $url1 . '" class="btn btn-inverse btn-sm"><span class="glyphicon"></span> Back</a> </td></tr></table>';
            //$datas["quotation"] = $quotation = $this->service_model->get_all_quotation_by_id($input['q_id']);
            //$datas["quotation_details"] = $quotation_details = $this->service_model->get_all_quotation_details_by_id($input['q_id']);
            /* $datas["quotation"] = $quotation = $this->service_model->get_all_pc_by_id($input['q_id']);
              $datas["quotation_details"] = $quotation_details = $this->service_model->get_all_pc_details_by_id($input['q_id']);

              $datas["job_id"] = $job_id = $this->service_model->get_all_quotations();
              $datas["category"] = $category = $this->master_category_model->get_all_category();
              $datas['company_details'] = $this->admin_model->get_company_details();
              $datas["brand"] = $brand = $this->master_brand_model->get_brand();
              $datas["last_id"] = $this->master_model->get_last_id('job_code');
              $datas["products"] = $this->Gen_model->get_all_product();
              $datas["products1"] = $this->Gen_model->get_all_product1();
              $datas["customers"] = $this->Gen_model->get_all_customers();

              $this->load->view('warranty_service', $datas); */
        } else {

            echo '<table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" ><tr align="center"> <td align="center" colspan="2" > Warranty Period is Completed <b>' . $input['q_no'] . ' </b></td> </tr>';

            echo '<table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" ><tr> <td style="text-align: left;" colspan="2" ><b> Customer Details: </b></br><b>Contact Person: </b>' . $invoice[0]['name'] . ' </br><b>Company: </b>' . $invoice[0]['store_name'] . ' </br><b>Mobile Number: </b>' . $invoice[0]['mobil_number'] . ' </br><b>Email: </b>' . $invoice[0]['email_id'] . ' </br><b>Address: </b>' . $invoice[0]['address1'] . ' </br></td> </tr>';

            echo ' <tr> <td align="center"  colspan="2"> <a href= "' . $completed_url . '" class="btn btn-success btn-sm m-10"><span class="glyphicon"></span>Spot Billing</a> ';
            echo '  <a href= "' . $url1 . '" class="btn btn-inverse btn-sm"> Back</a> </td></tr></table>';
        }
    }

    public function project_cost_add($id) {

        //  $datas["quotation"] = $quotation = $this->service_model->get_all_quotation_by_id($id);
        // $datas["quotation_details"] = $quotation_details = $this->service_model->get_all_quotation_details_by_id($id);
        $datas["quotation"] = $quotation = $this->service_model->get_all_pc_by_id($id);
        $datas["quotation_details"] = $quotation_details = $this->service_model->get_all_pc_details_by_id($id);
//        echo "<pre>";
//        print_r($datas);
//        exit;
        $datas["job_id"] = $job_id = $this->service_model->get_all_quotations();
        $datas["category"] = $category = $this->master_category_model->get_all_category();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();
        $datas["products"] = $this->Gen_model->get_all_product();
        $datas["products1"] = $this->Gen_model->get_all_product1();
        $datas["customers"] = $this->Gen_model->get_all_customers();

        $datas["last_id"] = $this->master_model->get_last_id('job_code');
        $this->template->write_view('content', 'warranty_service', $datas);
        $this->template->render();
    }

    public function project_cost_warranty_service($id) {

        //  $datas["quotation"] = $quotation = $this->service_model->get_all_quotation_by_id($id);
        // $datas["quotation_details"] = $quotation_details = $this->service_model->get_all_quotation_details_by_id($id);
        $datas["quotation"] = $quotation = $this->service_model->get_all_pc_by_id($id);
        $datas["quotation_details"] = $quotation_details = $this->service_model->get_all_pc_details_by_id($id);
//        echo "<pre>";
//        print_r($datas);
//        exit;
        $datas["job_id"] = $job_id = $this->service_model->get_all_quotations();
        $datas["category"] = $category = $this->master_category_model->get_all_category();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();
        $datas["products"] = $this->Gen_model->get_all_product();
        $datas["products1"] = $this->Gen_model->get_all_product1();
        $datas["customers"] = $this->Gen_model->get_all_customers();

        $datas["last_id"] = $this->master_model->get_last_id('job_code');
        $this->template->write_view('content', 'warranty_service1', $datas);
        $this->template->render();
    }

    public function project_cost_update($id) {
        $this->load->model('grn/grn_model');
        $datas["job_id"] = $job_id = $this->service_model->get_all_quotations();
        $datas["products"] = $this->Gen_model->get_all_product();
        $datas["products1"] = $this->Gen_model->get_all_product1();
        $datas["customers"] = $this->Gen_model->get_all_customers();
        $data["serial_number"] = $this->grn_model->get_all_po_number();
        // echo '<pre>';
        //print_r($datas);
        // exit;
        $this->template->write_view('content', 'project_cost_add', $datas);
        $this->template->render();
    }

    public function paid_service_add() {
        $this->load->model('masters/ref_increment_model');
        $this->load->model('sales_return/sales_return_model');
        if ($this->input->post()) {
            $input = $this->input->post();

            if ($input) {
                if ($input['check_gst'] == 'on') {
                    $input_gst['is_gst'] = '1';
                } else {
                    $input_gst['is_gst'] = '0';
                }
                $job_id = $input['quotation']['job_id'];

                $data['company_details'] = $this->admin_model->get_company_details();
                $input['quotation']['is_gst'] = $input_gst['is_gst'];
                $input['quotation']['notification_date'] = date('Y-m-d');
                $input['quotation']['delivery_schedule'] = date('Y-m-d');
                $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
                $input['quotation']['created_by'] = $user_info[0]['id'];
                $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));
                $input['quotation']['estatus'] = 2;
                $insert_id = $this->Gen_model->insert_quotation($input['quotation']);
//                $insert_idss = $insert_id + 1;
//                $inc['type'] = 'job_code';
//                $inc['value'] = 'JOB000' . $insert_idss;
//                $this->service_model->update_increment($inc);
                //$this->ref_increment_model->update_increment_id('JOB', 'JOB');
                $datas["quotation"] = $quotation = $this->project_cost_model->get_all_quotation_by_id($insert_id);
                $datas["quotation_details"] = $quotation_details = $this->project_cost_model->get_all_pc_details_by_id($id);
                //$input=$this->input->post();
                // echo "<pre>"; print_r($input); exit;
                $datas["category"] = $category = $this->master_category_model->get_all_category();
                $datas['company_details'] = $this->admin_model->get_company_details();
                $datas["brand"] = $brand = $this->master_brand_model->get_brand();
                $datas["quotation"][0]['q_id'] = $datas["quotation"][0]['id'];
                $datas["quotation"][0]['job_id'] = $job_id;
                $datas["quotation"][0]['is_gst'] = $input_gst['is_gst'];
                unset($datas['quotation'][0]['delivery_schedule']);
                unset($datas['quotation'][0]['id']);
                unset($datas['quotation'][0]['mode_of_payment']);
                unset($datas['quotation'][0]['email_id']);
                unset($datas['quotation'][0]['address1']);
                unset($datas['quotation'][0]['name']);
                unset($datas['quotation'][0]['q_no']);
                unset($datas['quotation'][0]['other_cost']);
                unset($datas['quotation'][0]['ref_name']);
                unset($datas['quotation'][0]['nick_name']);
                unset($datas['quotation'][0]['store_name']);
                unset($datas['quotation'][0]['mobil_number']);
                $insert_id1 = $this->project_cost_model->insert_quotation($datas["quotation"][0]);
                if (isset($insert_id1) && !empty($insert_id1)) {
                    $input = $this->input->post();
                    if (isset($input['categoty']) && !empty($input['categoty'])) {
                        $insert_arrs = array();
                        foreach ($input['categoty'] as $key => $val) {
                            $inserts['j_id'] = $insert_id1;
                            $inserts['q_id'] = $datas["quotation"][0]['q_id'];
                            $inserts['category'] = $val;
                            $inserts['product_id'] = $input['product_id'][$key];
                            $inserts['product_description'] = $input['product_description'][$key];
                            $inserts['product_type'] = $input['product_type'][$key];
                            $inserts['brand'] = $input['brand'][$key];
                            $inserts['quantity'] = $input['quantity'][$key];
                            $inserts['per_cost'] = $input['per_cost'][$key];
                            if ($input_gst['is_gst'] == '1') {
                                if ($input['hsn_sac'][$key] != '')
                                    $inserts['hsn_sac'] = $input['hsn_sac'][$key];
                            } else {
                                $inserts['add_amount'] = $input['add_amount'][$key];
                            }
                            $inserts['tax'] = $input['tax'][$key];
                            $inserts['gst'] = $input['gst'][$key];
                            $inserts['igst'] = $input['igst'][$key];
                            $inserts['sub_total'] = $input['sub_total'][$key];
                            $inserts['created_date'] = date('Y-m-d H:i');
                            $insert_arrs[] = $inserts;
                        }
                        //   echo "<pre>"; print_r($insert_arrs); exit;
                        $this->project_cost_model->insert_quotation_details($insert_arrs);
                    }
                }
                //$insert_id1++;
                //$inc['type'] = 'job_code';
                //$inc['value'] = 'JOB000' . $insert_id1;
                // $this->service_model->update_increment($inc);
                $this->ref_increment_model->update_increment_id('JOB', 'JOB');
            }
            $this->increment_model->update_increment_id('IS');

            if (isset($insert_id) && !empty($insert_id)) {
                $input = $this->input->post();
                if (isset($input['categoty']) && !empty($input['categoty'])) {

                    $insert_arr = array();
                    foreach ($input['categoty'] as $key => $val) {
                        $insert['q_id'] = $insert_id;
                        $insert['category'] = $val;
                        $insert['product_id'] = $input['product_id'][$key];
                        $insert['product_description'] = $input['product_description'][$key];
                        $insert['type'] = $input['product_type'][$key];
                        $insert['brand'] = $input['brand'][$key];
                        $insert['quantity'] = $input['quantity'][$key];
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
                    }

                    $this->Gen_model->insert_quotation_details($insert_arr);
                }
            }
            //$insert_id++;
            $inc['type'] = 'qno_code';


            // $inc['type'] = 'job_code';
            //$inc['value'] = 'JOB000' . $insert_id;
            // $this->project_cost_model->update_increment($inc);

            $insertdata['q_id'] = $insert_id;
            $insertdata['customer'] = $input['quotation']['customer'];
            $insertdata['total_qty'] = $input["quotation"]['total_qty'];
            $insertdata['tax_label'] = $input["quotation"]['tax_label'];
            $insertdata['tax'] = $input["quotation"]['tax'];
            $insertdata['advance'] = 0;
            $insertdata['subtotal_qty'] = $input["quotation"]['subtotal_qty'];
            $insertdata['net_total'] = $input["quotation"]['net_total'];
            $insertdata['remarks'] = $input["quotation"]['remarks'];
            $user_info = $this->user_auth->get_from_session('user_info');
            $insertdata['created_by'] = $user_info[0]['id'];
            $insertdata['is_gst'] = $datas["quotation"][0]['is_gst'];
            $insertdata['inv_id'] = $this->ref_increment_model->get_increment_id('INV', 'INV');
            $date = date('Y-m-d', strtotime($input['quotation']['created_date']));
            $new_date = date('Y-m-d', strtotime('+1 year', strtotime($input['quotation']['created_date'])));
            $insertdata['warranty_from'] = $date;
            $insertdata['warranty_to'] = $new_date;

            $insert1_id = $this->project_cost_model->insert_invoice($insertdata);
            $this->sales_return_model->insert_sr($insertdata);
            if ($input['check_gst'] == 'on') {
                $input_gst['is_gst'] = '1';
            } else {
                $input_gst['is_gst'] = '0';
            }

            if (isset($insert1_id) && !empty($insert1_id)) {
                if (isset($input['categoty']) && !empty($input['categoty'])) {
                    $insert_arr = array();
                    foreach ($input['categoty'] as $key => $val) {
                        $insert1['in_id'] = $insert1_id;
                        $insert1['q_id'] = $insert_id;
                        $insert1['category'] = $val;
                        $insert1['product_id'] = $input['product_id'][$key];
                        $insert1['product_description'] = $input['product_description'][$key];
                        $insert1['product_type'] = $input['product_type'][$key];
                        $insert1['brand'] = $input['brand'][$key];
                        $insert1['quantity'] = $input['quantity'][$key];
                        $insert1['return_quantity'] = 0;
                        $insert1['current_quantity'] = $input['quantity'][$key];
                        $insert1['per_cost'] = $input['per_cost'][$key];
                        if ($input_gst['is_gst'] == '1') {
                            if ($input['hsn_sac'][$key] != '')
                                $insert1['hsn_sac'] = $input['hsn_sac'][$key];
                        } else {
                            $insert1['add_amount'] = $input['add_amount'][$key];
                        }
                        $insert1['tax'] = $input['tax'][$key];
                        $insert1['gst'] = $input['gst'][$key];
                        $insert1['igst'] = $input['igst'][$key];
                        $insert1['sub_total'] = $input['sub_total'][$key];
                        $insert1['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert1;
                        $stock_arr = array();
                        $inv_id['inv_id'] = $insertdata['inv_id'];
                        $stock_arr[] = $inv_id;
                        $this->project_cost_model->check_stock($insert1, $inv_id);
                    }

                    $this->project_cost_model->insert_invoice_details($insert_arr);
                }
                if (isset($input['item_name']) && !empty($input['item_name'])) {
                    $insert_arrs1 = array();
                    foreach ($input['item_name'] as $key => $val) {
                        $inserts1['j_id'] = $insert1_id;
                        $inserts1['item_name'] = $val;
                        $inserts1['amount'] = $input['amount'][$key];
                        $inserts1['type'] = $input['type'][$key];
                        $insert_arrs1[] = $inserts1;
                    }

                    $this->project_cost_model->insert_other_cost($insert_arrs1);
                }
            }

            $this->ref_increment_model->update_increment_id('INV', 'INV');
            redirect($this->config->item('base_url') . 'service/service_list', $datas);
        }
        $datas["quotation"] = $details = $this->Gen_model->get_all_quotation();
        $data['gno'] = $this->increment_model->get_increment_id('IS');
        $data["category"] = $details = $this->master_category_model->get_all_category();
        $data["brand"] = $this->master_brand_model->get_brand();
        $data["nick_name"] = $this->Gen_model->get_all_nick_name();
        $data['company_details'] = $this->admin_model->get_company_details();
        $data["last_id"] = $this->ref_increment_model->get_increment_id('JOB', 'JOB');
        $data["products"] = $this->Gen_model->get_all_product();
        $data["products1"] = $this->Gen_model->get_all_product1();
        $data["customers"] = $this->Gen_model->get_all_customers();
        $this->template->write_view('content', 'service/paid_service', $data);
        $this->template->render();
    }

    public function update_quotation($id) {
        $his_quo = $this->service_model->get_his_quotation_by_id($id);
        $his_quo[0]['org_q_id'] = $his_quo[0]['id'];
        unset($his_quo[0]['id']);
        //echo "<pre>"; print_r($his_quo); exit;
        $insert_id = $this->service_model->insert_history_quotation($his_quo[0]);
        $input = $this->input->post();
        // echo "<pre>"; print_r($input); exit;
        $input['quotation']['notification_date'] = date('Y-m-d');
        $input['quotation']['delivery_schedule'] = date('Y-m-d');
        $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
        $input['quotation']['created_by'] = $user_info[0]['id'];
        $input['quotation']['created_date'] = date('Y-m-d H:i:s');
        $update_id = $this->service_model->update_quotation($input['quotation'], $id);
        $his_quo1 = $this->service_model->get_all_history_quotation_by_id($id);
        //echo "<pre>"; print_r($his_quo1); exit;
        $his_quo_details['hist'] = $this->service_model->get_his_quotation_deteils_by_id($id);
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
            $this->service_model->insert_history_quotation_details($insert_arrs);

            $delete_id = $this->service_model->delete_quotation_deteils_by_id($id);
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
            $this->service_model->insert_quotation_details($insert_arr);
        }

        $datas["quotation"] = $quotation = $this->service_model->get_all_quotation();
        redirect($this->config->item('base_url') . 'service/service_list');
    }

    public function quotation_delete() {
        $id = $this->input->POST('value1');
        $datas["quotation"] = $quotation = $this->service_model->get_all_quotation();
        $del_id = $this->service_model->delete_quotation($id);
        redirect($this->config->item('base_url') . 'service/service_list');
    }

    public function history_view($id) {
        $datas["his_quo"] = $his_quo = $this->service_model->all_history_quotations($id);
        $this->template->write_view('content', 'history_view', $datas);
        $this->template->render();
    }

    public function ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $list = $this->service_model->get_datatables($search_data);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $val) {
            if ($this->user_auth->is_action_allowed('service', 'service', 'view')) {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light" href="' . base_url() . 'service/service_view/' . $val['id'] . '" data-toggle="tooltip" data-placement="top" title="View"><span class="fa fa-eye"></span></a>';
            } else {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-eye"></span></a>';
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val['q_no'];
            $row[] = $val['store_name'];
            $row[] = $val['total_qty'];
            $row[] = number_format($val['subtotal_qty'], 2);
            $row[] = number_format($val['net_total'], 2);
            $row[] = $val['mode_of_payment'];
            $row[] = $val['validity'];
            $row[] = $val['remarks'];
            $row[] = $view_row;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->service_model->count_all(),
            "recordsFiltered" => $this->service_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
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