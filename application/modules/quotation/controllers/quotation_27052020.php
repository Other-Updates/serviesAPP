<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Quotation extends MX_Controller {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'quotation';
        $access_arr = array(
            'quotation/quotation_view' => array('add', 'edit', 'delete', 'view'),
            'quotation/search_result' => array('add', 'edit', 'delete', 'view'),
            'quotation/quotation_list' => 'no_restriction',
            'quotation/index' => array('add', 'edit', 'delete', 'view'),
            'quotation/update_quotation' => array('edit'),
            'quotation/delete_id' => array('delete'),
            'quotation/quotation_edit' => array('add', 'edit'),
            'quotation/quotation_delete' => array('delete'),
            'quotation/change_status' => 'no_restriction',
            'quotation/get_customer' => 'no_restriction',
            'quotation/get_customer_by_id' => 'no_restriction',
            'quotation/get_product' => 'no_restriction',
            'quotation/get_product_by_id' => 'no_restriction',
            'quotation/get_service' => 'no_restriction',
            'quotation/history_view' => 'no_restriction',
            'quotation/send_email' => 'no_restriction',
            'quotation/search_result' => 'no_restriction',
            'quotation/ajaxList' => 'no_restriction',
            'quotation/is_project_name_available' => 'no_restriction',
            'quotation/get_product_data' => 'no_restriction',
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            $this->user_auth->is_permission_allowed();
            redirect($this->config->item('base_url'));
        }

        $this->load->model('master_category/master_category_model');
        $this->load->model('master_style/master_model');
        $this->load->model('master_brand/master_brand_model');
        $this->load->model('quotation/Gen_model');
        $this->load->model('customer/customer_model');
        $this->load->model('enquiry/enquiry_model');
        $this->load->model('admin/admin_model');
        $this->load->model('api/increment_model');
        $this->load->model('api/notification_model');
        $this->load->model('project_cost/project_cost_model');
        $this->load->model('sales_return/sales_return_model');
        if (isset($_GET['notification']))
            $this->notification_model->update_notification(array('status' => 1), $_GET['notification']);
    }

    public function search_result() {
        $search_data = $this->input->get();
        $this->load->model('quotation/gen_model');
        $data['search_data'] = $search_data;
        $data['all_gen'] = $this->gen_model->get_all_quotation($search_data);
        $this->load->view('quotation/search_list', $data);
    }

    public function index() {
        $this->load->model('masters/ref_increment_model');
        $this->load->model('expense/expense_model');
        if ($this->input->post()) {
            $input = $this->input->post();


            if ($input['check_gst'] == 'on') {
                $input_gst['is_gst'] = '1';
            } else {
                $input_gst['is_gst'] = '0';
            }

            $input['quotation']['is_gst'] = $input_gst['is_gst'];
            // echo "<pre>"; print_r($input); exit;
            $data['company_details'] = $this->admin_model->get_company_details();
            /* if ($input['quotation']['notification_date'] != "")
              $input['quotation']['notification_date'] = date('Y-m-d', strtotime($input['quotation']['notification_date']));
              if ($input['quotation']['delivery_schedule'] != "")
              $input['quotation']['delivery_schedule'] = date('Y-m-d', strtotime($input['quotation']['delivery_schedule'])); */

            $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
            $input['quotation']['created_by'] = $user_info[0]['id'];
            $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));
            $input['quotation']['referred_by'] = trim($input['quotation']['referred_by']);

            $insert_id = $this->Gen_model->insert_quotation($input['quotation']);

            $get_advance = $input['quotation']['advance'];
            if ($get_advance != '') {
                $get_company_amount = $this->expense_model->getCompanyAmt();

                $amount = $get_company_amount[0]['company_amount'] + $get_advance;
                //Update balance sheet
                $user_info = $this->user_auth->get_from_session('user_info');
                $get_exp_category = $this->expense_model->get_expense_category_by_name('sales');
                $balance_data = [
                    "user_id" => $user_info[0]['id'],
                    "cat_id" => $get_exp_category[0]['id'],
                    "mode" => 'credit',
                    "amount" => $get_advance,
                    "company_amount" => $get_company_amount[0]['company_amount'],
                    "balance" => $amount,
                    "q_id" => $insert_id,
                    "created_at" => date('Y-m-d', strtotime($input['quotation']['created_date'])),
                    "remarks" => 'Advance Amount -' . $input['quotation']['q_no'],
                ];

                $this->expense_model->insert_balance_sheet($balance_data);
                $this->expense_model->update_company_amt($amount);
            }

            /* $notification = array();
              if (isset($input['quotation']['notification_date']) && !empty($input['quotation']['notification_date'])) {
              $notification = array();
              $notification['notification_date'] = $input['quotation']['notification_date'];
              $notification['type'] = 'quotation';
              $notification['link'] = 'quotation/quotation_list';
              $notification['Message'] = date('d-M-Y', strtotime($input['quotation']['notification_date'])) . ' is Quotation review date';
              $this->notification_model->insert_notification($notification);
              } */
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
                        $insert['type'] = $input['type'][$key];
                        $insert['brand'] = $input['brand'][$key];
                        $insert['quantity'] = $input['quantity'][$key];
                        $insert['per_cost'] = $input['per_cost'][$key];
                        $insert['project_cost_per_cost'] = $input['project_cost_per_cost'][$key];
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
                        $insert['project_cost_sub_total'] = $input['project_cost_sub_total'][$key];
                        $insert['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert;
                    }

                    $this->Gen_model->insert_quotation_details($insert_arr);
                }
            }
            $insert_id++;
//            $inc['type'] = 'qno_code';
//            $inc['type'] = 'job_code';
//            $inc['value'] = 'JOB000' . $insert_id;
//            $this->project_cost_model->update_increment($inc);
            $this->ref_increment_model->update_increment_id('JOB', 'JOB');
            $datas["quotation"] = $details = $this->Gen_model->get_all_quotation();
            redirect($this->config->item('base_url') . 'quotation/quotation_list', $datas);
        }
        $data['gno'] = $this->increment_model->get_increment_id('IS');
        $data["category"] = $details = $this->master_category_model->get_all_category();
        $data["brand"] = $this->master_brand_model->get_brand();
        $data["nick_name"] = $this->Gen_model->get_all_nick_name();
        $data['company_details'] = $this->admin_model->get_company_details();
        $data["last_id"] = $this->ref_increment_model->get_increment_id('JOB', 'JOB');
//        $data["last_id"] = $this->master_model->get_last_id('job_code');
        $data["products"] = $this->Gen_model->get_product_data();
        $data["products1"] = $this->Gen_model->get_all_product1();
        $data["customers"] = $this->Gen_model->get_all_customers();
        $this->template->write_view('content', 'quotation/index', $data);
        $this->template->render();
    }

    public function quotation_view($id) {
        $datas["quotation"] = $quotation = $this->Gen_model->get_all_quotation_by_id($id);
        $datas["in_words"] = $this->convert_number($datas["quotation"][0]['net_total']);
        $datas["quotation_details"] = $quotation_details = $this->Gen_model->get_all_quotation_details_by_id($id);
        $datas["category"] = $category = $this->master_category_model->get_all_category();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();

        $this->template->write_view('content', 'quotation_view', $datas);
        $this->template->render();
    }

    public function delete_id() {
        $input = $this->input->get();
        $del = $this->Gen_model->delete_id($input['del_id']);
    }

    public function change_status($id, $status) {
        $this->load->model('expense/expense_model');
        $this->load->model('masters/ref_increment_model');
        $this->Gen_model->change_quotation_status($id, $status);
        if ($this->input->post()) {
            $input = $this->input->post();


            //Update Balance Sheet Data
            $get_advance = $input['quotation']['advance'];
            if ($input['quo_old_amount'] == '') {
                if ($get_advance != '') {
                    $get_company_amount = $this->expense_model->getCompanyAmt();

                    $amount = $get_company_amount[0]['company_amount'] + $get_advance;
                    //Update balance sheet
                    $user_info = $this->user_auth->get_from_session('user_info');
                    $get_exp_category = $this->expense_model->get_expense_category_by_name('sales');
                    $balance_data = [
                        "user_id" => $user_info[0]['id'],
                        "cat_id" => $get_exp_category[0]['id'],
                        "mode" => 'credit',
                        "amount" => $get_advance,
                        "company_amount" => $get_company_amount[0]['company_amount'],
                        "balance" => $amount,
                        "q_id" => $id,
                        "created_at" => date('Y-m-d', strtotime($input['quotation']['created_date'])),
                        "remarks" => 'Advance Amount -' . $input['quotation']['q_no'],
                    ];

                    $this->expense_model->insert_balance_sheet($balance_data);
                    $this->expense_model->update_company_amt($amount);
                }
            } else {
                if ($get_advance != '') {
                    $get_company_amount = $this->expense_model->getCompanyAmt();
                    if ($input['quo_old_amount'] != $get_advance) {
                        if ($input['quo_old_amount'] > $get_advance) {
                            $dfff = $input['quo_old_amount'] - $get_advance;
                            $totbalance = (- $dfff);
                        } else if ($input['quo_old_amount'] < $get_advance) {
                            $dfff1 = $get_advance - $input['quo_old_amount'];
                            $totbalance = $dfff1;
                        }
                    } else {
                        $totbalance = 0;
                    }
                }

                $amount = $get_company_amount[0]['company_amount'] + $totbalance;

                $get_exp_category = $this->expense_model->get_expense_category_by_name('sales');
                $user_info = $this->user_auth->get_from_session('user_info');
                $balance_data = [
                    "user_id" => $user_info[0]['id'],
                    "cat_id" => $get_exp_category[0]['id'],
                    "mode" => 'credit',
                    "amount" => $input['quotation']['advance'],
                    "company_amount" => $get_company_amount[0]['company_amount'],
                    "balance" => $amount,
                    "q_id" => $id,
                    "created_at" => $input['created_at'],
                    "remarks" => 'Advance Amount -' . $input['quotation']['q_no'],
                ];

                $update = $this->expense_model->update_balance_sheet_by_qid($balance_data, $id);
                $this->expense_model->update_company_amt($amount);
            }

            //Project cost
            $data['company_details'] = $this->admin_model->get_company_details();
            $user_info = $this->user_auth->get_from_session('user_info');
            $input['quotation']['created_by'] = $user_info[0]['id'];
            $input['quotation']['q_id'] = $id;
            $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));
            if ($input['check_gst'] == 'on') {
                $input_gst['is_gst'] = '1';
            } else {
                $input_gst['is_gst'] = '0';
            }

            $input['quotation']['net_total'] = $input['quotation']['project_cost_net_total'];
            $input['quotation']['subtotal_qty'] = $input['quotation']['project_cost_subtotal_qty'];
            $input['quotation']['is_gst'] = $input_gst['is_gst'];
            unset($input['quotation']['ref_name']);
            unset($input['quotation']['referred_by']);
            unset($input['quotation']['warranty']);
            unset($input['quotation']['q_no']);
            unset($input['quotation']['project_name']);
            unset($input['quotation']['mode_of_payment']);
            unset($input['quotation']['validity']);
            unset($input['quotation']['inv_id']);
            unset($input['quotation']['project_cost_net_total']);
            unset($input['quotation']['project_cost_subtotal_qty']);

            $insert_id = $this->project_cost_model->insert_quotation($input['quotation']);
            //Project Cost details
            if (isset($insert_id) && !empty($insert_id)) {
                if (isset($input['categoty']) && !empty($input['categoty'])) {
                    $insert_arr = array();
                    foreach ($input['categoty'] as $key => $val) {
                        $insert['j_id'] = $insert_id;
                        $insert['q_id'] = $id;
                        $insert['category'] = $val;
                        $insert['product_id'] = $input['product_id'][$key];
                        $insert['product_description'] = $input['product_description'][$key];
                        $insert['product_type'] = $input['type'][$key];
                        $insert['brand'] = $input['brand'][$key];
                        $insert['quantity'] = $input['quantity'][$key];
                        $insert['per_cost'] = $input['project_cost_per_cost'][$key];
                        if ($input_gst['is_gst'] == '1') {
                            if ($input['hsn_sac'][$key] != '')
                                $insert['hsn_sac'] = $input['hsn_sac'][$key];
                        } else {
                            $insert['add_amount'] = $input['add_amount'][$key];
                        }
                        $insert['tax'] = $input['tax'][$key];
                        $insert['gst'] = $input['gst'][$key];
                        $insert['igst'] = $input['igst'][$key];
                        $insert['sub_total'] = $input['project_cost_sub_total'][$key];
                        $insert['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert;
                        $stock_arr = array();
                        $inv_id['inv_id'] = $input['quotation']['job_id'];
                        $stock_arr[] = $inv_id;
                        $this->project_cost_model->check_stock($insert, $inv_id);
                    }
                    $this->project_cost_model->insert_quotation_details($insert_arr);
                }
            }

            $agent_ser = $this->project_cost_model->get_service_cost($insert['j_id']);
            $agent_other = $this->project_cost_model->get_other_cost($insert['j_id']);
            $user_info = $this->user_auth->get_from_session('user_info');
            $receipt = $this->project_cost_model->get_receipt_id($user_info[0]['id']);
            $amount = array();
            $user_info = $this->user_auth->get_from_session('user_info');
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
            //Invoice
            $input = $this->input->post();
            $user_info = $this->user_auth->get_from_session('user_info');
            $input['quotation']['created_by'] = $user_info[0]['id'];
            $input['quotation']['q_id'] = $id;
            $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));
            if ($input['check_gst'] == 'on') {
                $input_gst['is_gst'] = '1';
            } else {
                $input_gst['is_gst'] = '0';
            }
            $input['quotation']['is_gst'] = $input_gst['is_gst'];
            unset($input['quotation']['ref_name']);
            unset($input['quotation']['referred_by']);
            unset($input['quotation']['warranty']);
            unset($input['quotation']['q_no']);
            unset($input['quotation']['project_name']);
            unset($input['quotation']['mode_of_payment']);
            unset($input['quotation']['validity']);
            unset($input['quotation']['inv_id']);
            unset($input['quotation']['project_cost_net_total']);
            unset($input['quotation']['project_cost_subtotal_qty']);
            unset($input['quotation']['job_id']);
//            $inv_id = $this->master_model->get_last_id('inv_code');
            $input['quotation']['inv_id'] = $this->ref_increment_model->get_increment_id('INV', 'INV');
            $date = date('Y-m-d', strtotime($input['quotation']['created_date']));
            $new_date = date('Y-m-d', strtotime('+1 year', strtotime($input['quotation']['created_date'])));
            $input['quotation']['warranty_from'] = $date;
            $input['quotation']['warranty_to'] = $new_date;
            $input['quotation']['net_total'] = $input['quotation']['net_total'];
            $input['quotation']['subtotal_qty'] = $input['quotation']['subtotal_qty'];
            $input['quotation']['balance'] = $input['quotation']['net_total'];
            $insert1_id = $this->project_cost_model->insert_invoice($input['quotation']);
            unset($input['quotation']['balance']);
            $this->sales_return_model->insert_sr($input['quotation']);
            if (isset($insert1_id) && !empty($insert1_id)) {
                if (isset($input['categoty']) && !empty($input['categoty'])) {
                    $insert_arr = array();
                    foreach ($input['categoty'] as $key => $val) {
                        $insert1['in_id'] = $insert1_id;
                        $insert1['q_id'] = $id;
                        $insert1['category'] = $val;
                        $insert1['product_id'] = $input['product_id'][$key];
                        $insert1['product_description'] = $input['product_description'][$key];
                        $insert1['product_type'] = $input['type'][$key];
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
                        $inv_id['inv_id'] = $input['quotation']['inv_id'];
                        $stock_arr[] = $inv_id;
                       // $this->project_cost_model->check_stock($insert1, $inv_id);
                        $update_sales_count = $this->project_cost_model->update_sales_count($insert1);
                    }
                    $this->project_cost_model->insert_invoice_details($insert_arr);
                }
            }
            $this->ref_increment_model->update_increment_id('INV', 'INV');

            redirect($this->config->item('base_url') . 'quotation/quotation_list');
        }
    }

    public function quotation_list() {
        $datas["quotation"] = $quotation = $this->Gen_model->get_all_quotation();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $this->template->write_view('content', 'quotation/quotation_list', $datas);
        $this->template->render();
    }

    public function get_customer() {
        $atten_inputs = $this->input->post();
        $data = $this->Gen_model->get_customer($atten_inputs);
        echo json_encode($data);
        exit;

//        echo '<ul id="country-list">';
//        if (isset($data) && !empty($data)) {
//            foreach ($data as $st_rlno) {
//                if ($st_rlno['store_name'] != '')
//                    echo '<li class="cust_class" cust_name="' . $st_rlno['store_name'] . '" cust_id="' . $st_rlno['id'] . '" cust_no="' . $st_rlno['mobil_number'] . '" cust_email="' . $st_rlno['email_id'] . '" cust_address="' . $st_rlno['address1'] . '">' . $st_rlno['store_name'] . '</li>';
//            }
//        }
//        else {
//            echo '<li style="color:red;">No Data Found</li>';
//        }
//        echo '</ul>';
    }

    public function get_customer_by_id() {
        $input = $this->input->post();
        $data_customer["customer_details"] = $this->Gen_model->get_customer_by_id($input['id']);
        echo json_encode($data_customer);
    }

    public function get_product() {
        $atten_inputs = $this->input->post();
        $product_data = $this->Gen_model->get_product($atten_inputs);
        echo json_encode($product_data);
        exit;
//        echo '<ul id="product-list">';
//        if (isset($product_data) && !empty($product_data)) {
//            foreach ($product_data as $st_rlno) {
//                if ($st_rlno['model_no'] != '')
//                    echo '<li class="pro_class" pro_cost="' . $st_rlno['cost_price'] . '"pro_sell="' . $st_rlno['selling_price'] . '" pro_type="' . $st_rlno['type'] . '" pro_id="' . $st_rlno['id'] . '" mod_no="' . $st_rlno['model_no'] . '" pro_name="' . $st_rlno['product_name'] . '" pro_description="' . $st_rlno['product_description'] . '" pro_image="' . $st_rlno['product_image'] . '"pro_cat ="' . $st_rlno['category_id'] . '"pro_brand ="' . $st_rlno['brand_id'] . '">' . $st_rlno['model_no'] . '</li>';
//            }
//        }
//        else {
//            echo '<li style="color:red;">No Data Found</li>';
//        }
//        echo '</ul>';
    }

    public function get_product_by_id() {
        $input = $this->input->post();
        $data_customer["product_details"] = $this->Gen_model->get_product_by_id($input['id']);
        echo json_encode($data_customer);
    }

    public function get_service() {
        $atten_inputs = $this->input->post();
        $product_data = $this->Gen_model->get_service($atten_inputs);
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

    public function quotation_edit($id) {
        $datas["quotation"] = $quotation = $this->Gen_model->get_all_quotation_by_id($id);
        $datas["quotation_details"] = $quotation_details = $this->Gen_model->get_all_quotation_details_by_id($id);
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["category"] = $category = $this->master_category_model->get_all_category();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();
        $datas["nick_name"] = $this->Gen_model->get_all_nick_name();
        $datas["products"] = $this->Gen_model->get_product_data();
        $datas["products1"] = $this->Gen_model->get_all_product1();
        $datas["customers"] = $this->Gen_model->get_all_customers();
        $this->template->write_view('content', 'quotation_edit', $datas);
        $this->template->render();
    }

    public function update_quotation($id) {
        $this->load->model('expense/expense_model');
        $his_quo = $this->Gen_model->get_his_quotation_by_id($id);
        $his_quo[0]['org_q_id'] = $his_quo[0]['id'];
        $his_quo[0]['is_gst'] = $his_quo[0]['is_gst'];
        unset($his_quo[0]['id']);
        //echo "<pre>"; print_r($his_quo); exit;
        $insert_id = $this->Gen_model->insert_history_quotation($his_quo[0]);
        $input = $this->input->post();

        /* if ($input['quotation']['notification_date'] != "")
          $input['quotation']['notification_date'] = date('Y-m-d', strtotime($input['quotation']['notification_date']));
          if ($input['quotation']['delivery_schedule'] != "")
          $input['quotation']['delivery_schedule'] = date('Y-m-d', strtotime($input['quotation']['delivery_schedule'])); */
        if ($input['check_gst'] == 'on') {
            $input_gst['is_gst'] = 1;
        } else {
            $input_gst['is_gst'] = 0;
        }
        $input['quotation']['is_gst'] = $input_gst['is_gst'];
        $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
        $input['quotation']['created_by'] = $user_info[0]['id'];
        $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));
        $input['quotation']['referred_by'] = trim($input['quotation']['referred_by']);
        unset($input['quotation']['job_id']);
        $update_id = $this->Gen_model->update_quotation($input['quotation'], $id);

        //Update Balance Sheet Data
        $get_advance = $input['quotation']['advance'];
        if ($input['quo_old_amount'] == '') {
            if ($get_advance != '') {
                $get_company_amount = $this->expense_model->getCompanyAmt();

                $amount = $get_company_amount[0]['company_amount'] + $get_advance;
                //Update balance sheet
                $user_info = $this->user_auth->get_from_session('user_info');
                $get_exp_category = $this->expense_model->get_expense_category_by_name('sales');
                $balance_data = [
                    "user_id" => $user_info[0]['id'],
                    "cat_id" => $get_exp_category[0]['id'],
                    "mode" => 'credit',
                    "amount" => $get_advance,
                    "company_amount" => $get_company_amount[0]['company_amount'],
                    "balance" => $amount,
                    "q_id" => $id,
                    "created_at" => date('Y-m-d', strtotime($input['quotation']['created_date'])),
                    "remarks" => 'Advance Amount -' . $input['quotation']['q_no'],
                ];

                $this->expense_model->insert_balance_sheet($balance_data);
                $this->expense_model->update_company_amt($amount);
            }
        } else {
            if ($get_advance != '') {
                $get_company_amount = $this->expense_model->getCompanyAmt();
                if ($input['quo_old_amount'] != $get_advance) {
                    if ($input['quo_old_amount'] > $get_advance) {
                        $dfff = $input['quo_old_amount'] - $get_advance;
                        $totbalance = (- $dfff);
                    } else if ($input['quo_old_amount'] < $get_advance) {
                        $dfff1 = $get_advance - $input['quo_old_amount'];
                        $totbalance = $dfff1;
                    }
                } else {
                    $totbalance = 0;
                }
            }

            $amount = $get_company_amount[0]['company_amount'] + $totbalance;

            $get_exp_category = $this->expense_model->get_expense_category_by_name('sales');
            $user_info = $this->user_auth->get_from_session('user_info');
            $balance_data = [
                "user_id" => $user_info[0]['id'],
                "cat_id" => $get_exp_category[0]['id'],
                "mode" => 'credit',
                "amount" => $input['quotation']['advance'],
                "company_amount" => $get_company_amount[0]['company_amount'],
                "balance" => $amount,
                "q_id" => $id,
                "created_at" => $input['created_at'],
                "remarks" => 'Advance Amount -' . $input['quotation']['q_no'],
            ];

            $update = $this->expense_model->update_balance_sheet_by_qid($balance_data, $id);
            $this->expense_model->update_company_amt($amount);
        }

        /* $notification = array();
          if (isset($input['quotation']['notification_date']) && !empty($input['quotation']['notification_date'])) {
          $notification = array();
          $notification['notification_date'] = $input['quotation']['notification_date'];
          $notification['type'] = 'quotation';
          $notification['link'] = 'quotation/quotation_list';
          $notification['Message'] = date('d-M-Y', strtotime($input['quotation']['notification_date'])) . ' is Quotation review date';
          $this->notification_model->insert_notification($notification);
          } */
        $his_quo1 = $this->Gen_model->get_all_history_quotation_by_id($id);
        //echo "<pre>"; print_r($his_quo1); exit;
        $his_quo_details['hist'] = $this->Gen_model->get_his_quotation_deteils_by_id($id);
        if (isset($his_quo_details['hist']) && !empty($his_quo_details['hist'])) {
            $insert_arrs = array();
            foreach ($his_quo_details['hist'] as $key) {
                $inserts = $key;
                $inserts['h_id'] = $insert_id;
                $inserts['org_q_id'] = $his_quo1[0]['org_q_id'];
                $inserts['is_gst'] = $his_quo1[0]['is_gst'];
                $inserts['created_date'] = date("Y-m-d H:i:s");
                unset($inserts['id']);
                unset($inserts['q_id']);
                $insert_arrs[] = $inserts;
            }

            $this->Gen_model->insert_history_quotation_details($insert_arrs);

            $delete_id = $this->Gen_model->delete_quotation_deteils_by_id($id);
        }
        $input = $this->input->post();
        if (isset($input['categoty']) && !empty($input['categoty'])) {
            $insert_arr = array();
            foreach ($input['categoty'] as $key => $val) {

                $insert['q_id'] = $his_quo[0]['org_q_id'];
                $insert['category'] = $val;
                $insert['product_id'] = $input['product_id'][$key];
                $insert['product_description'] = (!empty($input['product_description'][$key]) ? $input['product_description'][$key] : '');
                $insert['brand'] = $input['brand'][$key];
                $insert['quantity'] = $input['quantity'][$key];
                $insert['per_cost'] = $input['per_cost'][$key];
                $insert['project_cost_per_cost'] = $input['project_cost_per_cost'][$key];
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
                $insert['project_cost_sub_total'] = $input['project_cost_sub_total'][$key];
                $insert['created_date'] = date('Y-m-d H:i:s');
                $insert_arr[] = $insert;
            }
            $this->Gen_model->insert_quotation_details($insert_arr);
        }

        $datas["quotation"] = $quotation = $this->Gen_model->get_all_quotation();
        redirect($this->config->item('base_url') . 'quotation/quotation_list', $datas);
    }

    public function quotation_delete() {
        $id = $this->input->POST('value1');
        $datas["quotation"] = $quotation = $this->Gen_model->get_all_quotation();
        $del_id = $this->Gen_model->delete_quotation($id);
        redirect($this->config->item('base_url') . 'quotation/quotation_list', $datas);
    }

    public function history_view($id) {
        $datas["his_quo"] = $his_quo = $this->Gen_model->all_history_quotations($id);
        $this->template->write_view('content', 'history_view', $datas);
        $this->template->render();
    }

    public function send_email() {

        $this->load->library("Pdf");
        $id = $this->input->get();
        $data["quotation"] = $quotation = $this->Gen_model->get_all_quotation_by_id($id['id']);
        $data["in_words"] = $this->convert_number($data["quotation"][0]['net_total']);
        $data["quotation_details"] = $quotation_details = $this->Gen_model->get_all_quotation_details_by_id($id['id']);
        $data["category"] = $category = $this->master_category_model->get_all_category();
        $data['company_details'] = $this->admin_model->get_company_details();
        $data["brand"] = $brand = $this->master_brand_model->get_brand();
        $data["email_details"] = $email_details = $this->Gen_model->get_all_email_details();

        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $this->email->initialize($config);

        $to_array = array($data['company_details'][0]['email'], $data['quotation'][0]['email_id']);
        //echo '<pre>'; print_r($to_array); exit;
        $this->email->clear(TRUE);
        $this->email->to(implode(', ', $to_array));
        $this->email->from($data['email_details'][1]['value'], $data['email_details'][0]['value']);
        $this->email->cc($data['email_details'][3]['value']);
        $this->email->subject($data['email_details'][2]['value']);
        $this->email->set_mailtype("html");

        $msg1['test'] = $this->load->view('quotation/email_page', $data, TRUE);
        //$msg1['company_details']=$data['company_details'];
        //echo "<pre>"; print_r($msg1); exit;
//        $header = $this->load->view('quotation/pdf_header_view', $data, TRUE);
        $msg = $this->load->view('quotation/pdf_email_template', $msg1, TRUE);
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->AddPage();
//        $pdf->Header($header);
        $pdf->writeHTMLCell(0, 0, '', '', $msg, 0, 1, 0, true, '', true);
        $filename = 'Quotation-' . date('d-M-Y-H-i-s') . '.pdf';
        $newFile = $this->config->item('theme_path') . 'attachement/' . $filename;
        $pdf->Output($newFile, 'F');
        //echo "<pre>"; print_r($msg1); exit;
        $this->email->attach($this->config->item('theme_path') . 'attachement/' . $filename);
        $data["content_msg"] = 'Dear sir,<br>Kindly find the attachment for Quotation Details <b>' . $data['quotation'][0]['q_no'] . '</b><br><br>Thanks<br>'
                . $data['quotation'][0]['store_name'] . '<br>
                        ' . $data['quotation'][0]['address1'] . ' <br>
                       PH - ' . $data['quotation'][0]['mobil_number'] . ' <br>
                        Email ID - ' . $data['quotation'][0]['email_id'] . ' <br>';
        $html_message = $this->load->view('quotation/quotation_send_email.php', $data, TRUE);
        $this->email->message($html_message);
        $this->email->send();
    }

    //get sub category
    function get_sub_category() {
        $c_id = $this->input->get('c_id');
        $p_data = $this->master_category_model->get_all_s_cat_by_id($c_id);
        $select = '';
        $select = $select . "<select name='sub_categoty[]'><option value=''>Select</option>";
        if (isset($p_data) && !empty($p_data)) {
            foreach ($p_data as $val1) {
                $select = $select . "<option value=" . $val1['actionId'] . ">" . $val1['sub_categoryName'] . "</option>";
            }
        }

        $select = $select . "</select>";
        if (empty($p_data)) {
            $select = $select . "   <span style='color:red;'>Sub category not crerated yet...</span>";
        }
        echo $select;
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

    function ajaxList() {
        $list = $this->Gen_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $quo_data) {
            if ($this->user_auth->is_action_allowed('quotation', 'quotation', 'edit')) {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light" href="' . base_url() . 'quotation/quotation_edit/' . $quo_data->id . '" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-pencil"></span></a>';
            } else {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-pencil"></span></a>';
            }

            if ($this->user_auth->is_action_allowed('quotation', 'quotation', 'view')) {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light" href="' . base_url() . 'quotation/quotation_view/' . $quo_data->id . '" data-toggle="tooltip" data-placement="top" title="View"><span class="fa fa-eye"></span></a>';
            } else {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-eye"></span></a>';
            }

            if ($this->user_auth->is_action_allowed('quotation', 'quotation', 'delete')) {
                $delete_row = '<a onclick="delete_quotation(' . $quo_data->id . ')" class="btn btn-danger btn-mini waves-effect waves-light delete_row" delete_id="test3_' . $quo_data->id . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><span class="fa fa-trash" style="color: white;"></span></a>';
            } else {
                $delete_row = '<a  class="btn btn-danger btn-mini waves-effect waves-light delete_row alerts" delete_id="test3_' . $quo_data->id . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><span class="fa fa-trash" style="color: white;"></span></a>';
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $quo_data->q_no;
            $row[] = $quo_data->project_name;
            //$row[] = $quo_data->user_name . '-' . $quo_data->nick_name;
            $row[] = $quo_data->referred_by;
            $row[] = $quo_data->store_name;
            $row[] = $quo_data->total_qty;
            $row[] = number_format($quo_data->net_total, 2);
            $row[] = ($quo_data->created_date != '1970-01-01') ? date('d-M-Y', strtotime($quo_data->created_date)) : '';

            if ($quo_data->estatus == '1') {
                $status = '<span class="label label-danger">Pending</span>';
            } else if ($quo_data->estatus == '2') {
                $status = '<span class="label label-success">Completed</span>';
            } else if ($quo_data->estatus == '4') {
                $status = '<span class=" label label-success">Order Approved</span>';
            } else if ($quo_data->estatus == '5') {
                $status = '<span class="label label-warning">Order Reject</span>';
            }
            $row[] = $status;
            if ($quo_data->estatus == '2') {
                $row[] = $view_row;
            } else {
                if (($user_info[0]['role'] != 3)) {
                    $action = $edit_row . '&nbsp;&nbsp;';
                }
                $action .= $view_row . '&nbsp;&nbsp;';
                if (($user_info[0]['role'] != 3)) {
                    $action .= $delete_row;
                }
                $row[] = $action;
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Gen_model->count_all(),
            "recordsFiltered" => $this->Gen_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    function is_project_name_available() {
        $project_name = $this->input->post('project_name');
        $id = $this->input->post('id');
        $result = $this->Gen_model->is_project_name_available($project_name, $id);
        if (!empty($result[0]['id'])) {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    public function get_product_data() {

        $input = $this->input->post();
        $products = $this->Gen_model->get_product_data($input);
        echo json_encode($products);
        exit;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */