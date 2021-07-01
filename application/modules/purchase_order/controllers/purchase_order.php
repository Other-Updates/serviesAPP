<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Purchase_order extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'purchase_order';
        $access_arr = array(
            'purchase_order/purchase_order_list' => array('add', 'edit', 'delete', 'view'),
            'purchase_order/index' => array('add', 'edit', 'delete', 'view'),
            'purchase_order/po_view' => array('add', 'edit', 'delete', 'view'),
            'purchase_order/po_delete' => array('delete'),
            'purchase_order/po_edit' => array('add', 'edit'),
            'purchase_order/update_po' => array('edit'),
            'purchase_order/change_status' => 'no_restriction',
            'purchase_order/get_customer' => 'no_restriction',
            'purchase_order/get_customer_by_id' => 'no_restriction',
            'purchase_order/get_product' => 'no_restriction',
            'purchase_order/get_product_by_id' => 'no_restriction',
            'purchase_order/history_view' => 'no_restriction',
            'purchase_order/stock_details' => 'no_restriction',
            'purchase_order/ajaxList' => 'no_restriction',
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
        $this->load->model('purchase_order/purchase_order_model');
        $this->load->model('purchase_return/purchase_return_model');
    }

    public function index() {
        $this->load->model('masters/ref_increment_model');
        if ($this->input->post()) {
            $input = $this->input->post();

            $user_info = $this->user_auth->get_from_session('user_info');
            $data['company_details'] = $this->admin_model->get_company_details();
//            $input['po']['delivery_schedule'] = date('Y-m-d');
            $input['po']['created_by'] = $user_info[0]['id'];
            $input['po']['created_date'] = date('Y-m-d', strtotime($input['po']['created_date']));
            if ($input['check_gst'] == 'on') {
                $input_gst['is_gst'] = '1';
            } else {
                $input_gst['is_gst'] = '0';
            }
            $input['po']['is_gst'] = $input_gst['is_gst'];
            $insert_id = $this->purchase_order_model->insert_po($input['po']);
//            $this->purchase_return_model->insert_pr($input['po']);
            if (isset($insert_id) && !empty($insert_id)) {
                $input = $this->input->post();
                if (isset($input['categoty']) && !empty($input['categoty'])) {
                    $insert_arr = array();
                    foreach ($input['categoty'] as $key => $val) {
                        $insert['po_id'] = $insert_id;
                        $insert['category'] = $val;
                        $insert['product_id'] = $input['product_id'][$key];
                        $insert['product_description'] = $input['product_description'][$key];
                        $insert['type'] = $input['type'][$key];
                        $insert['brand'] = $input['brand'][$key];
                        $insert['quantity'] = $input['quantity'][$key];
                        $insert['return_quantity'] = 0;
                        $insert['delivery_quantity'] = 0;
                        $insert['per_cost'] = $input['per_cost'][$key];
                        if ($input_gst['is_gst'] == '1') {
                            if ($input['hsn_sac'][$key] != '')
                                $insert['hsn_sac'] = $input['hsn_sac'][$key];
                        } else {
                            $insert['add_amount'] = $input['add_amount'][$key];
                        }
                        $old_cost_price = $input['old_cost_price'][$key];
                        $corrected_cost_price = $input['per_cost'][$key] - $input['add_amount'][$key];
                        if ($corrected_cost_price != $old_cost_price) {
                            $product_id = $input['product_id'][$key];
                            $product_cp['cost_price'] = $input['per_cost'][$key];
                            $update = $this->purchase_order_model->update_product_cost($product_cp, $product_id);
                        }
                        $insert['tax'] = $input['tax'][$key];
                        $insert['gst'] = $input['gst'][$key];
                        $insert['igst'] = $input['igst'][$key];
                        $insert['sub_total'] = $input['sub_total'][$key];
                        $insert['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert;
//                        $stock_arr = array();
//                        $po_id['po_id'] = $input['po']['po_no'];
//                        $stock_arr[] = $po_id;
//                        $this->stock_details($insert, $po_id);
                    }

                    $this->purchase_order_model->insert_po_details($insert_arr);
                }
            }
            $this->ref_increment_model->update_increment_id('PO', 'PO');
//            $insert_id++;
//            $inc['type'] = 'po_code';
//            $inc['value'] = 'PO000' . $insert_id;
//            $this->purchase_order_model->update_increment($inc);
            redirect($this->config->item('base_url') . 'purchase_order/purchase_order_list');
        }
        $data["po"] = $details = $this->purchase_order_model->get_all_po();
//        $data["last_id"] = $this->master_model->get_last_id('po_code');
        $data["last_id"] = $this->ref_increment_model->get_increment_id('PO', 'PO');


        $data["category"] = $details = $this->master_category_model->get_all_category();
        $data["brand"] = $this->master_brand_model->get_brand();
        $data['company_details'] = $this->admin_model->get_company_details();
        $data["products"] = $this->purchase_order_model->get_all_product();
        $datas["products1"] = $this->purchase_order_model->get_all_product1();
        $data["customers"] = $this->purchase_order_model->get_all_customers();
        $this->template->write_view('content', 'purchase_order/index', $data);
        $this->template->render();
    }

    function stock_details($stock_info, $po_id) {

        $this->purchase_order_model->check_stock($stock_info, $po_id);
    }

    public function po_view($id) {
        $datas["po"] = $po = $this->purchase_order_model->get_all_po_by_id($id);
        $datas["in_words"] = $this->convert_number($datas["po"][0]['net_total']);
        $datas["po_details"] = $po_details = $this->purchase_order_model->get_all_po_details_by_id($id);
        $datas["category"] = $category = $this->master_category_model->get_all_category();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();
        $this->template->write_view('content', 'purchase_order_view', $datas);
        $this->template->render();
    }

    public function change_status($id, $status) {
        //echo $id; echo $status; exit;
        $this->purchase_order_model->change_po_status($id, $status);
        redirect($this->config->item('base_url') . 'purchase_order/purchase_order_list');
    }

    public function purchase_order_list() {
        $datas["po"] = $po = $this->purchase_order_model->get_all_po();
        $datas['company_details'] = $this->admin_model->get_company_details();
        // echo "<pre>"; print_r($datas); exit;
        $this->template->write_view('content', 'purchase_order/purchase_order_list', $datas);
        $this->template->render();
    }

    public function get_customer() {
        $atten_inputs = $this->input->post();
        $data = $this->purchase_order_model->get_customer($atten_inputs);
        echo json_encode($data);
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
        $data_customer["customer_details"] = $this->purchase_order_model->get_customer_by_id($input['id']);
        echo json_encode($data_customer);
    }

    public function get_product() {
        $atten_inputs = $this->input->post();
        $product_data = $this->purchase_order_model->get_product($atten_inputs);
        echo json_encode($product_data);
//        echo '<ul id="product-list">';
//        if (isset($product_data) && !empty($product_data)) {
//            foreach ($product_data as $st_rlno) {
//                if ($st_rlno['model_no'] != '')
//                    echo '<li class="pro_class" pro_cost="' . $st_rlno['cost_price'] . '" pro_type="' . $st_rlno['type'] . '" pro_id="' . $st_rlno['id'] . '" mod_no="' . $st_rlno['model_no'] . '" pro_name="' . $st_rlno['product_name'] . '" pro_description="' . $st_rlno['product_description'] . '" pro_image="' . $st_rlno['product_image'] . '"pro_cat ="' . $st_rlno['category_id'] . '"pro_brand ="' . $st_rlno['brand_id'] . '">' . $st_rlno['model_no'] . '</li>';
//            }
//        }
//        else {
//            echo '<li style="color:red;">No Data Found</li>';
//        }
//        echo '</ul>';
    }

    public function get_product_by_id() {
        $input = $this->input->post();
        $data_customer["product_details"] = $this->purchase_order_model->get_product_by_id($input['id']);
        echo json_encode($data_customer);
    }

    public function po_edit($id) {
        $datas["po"] = $po = $this->purchase_order_model->get_all_po_by_id($id);
        $datas["po_details"] = $po_details = $this->purchase_order_model->get_all_po_details_by_id($id);
        $datas["category"] = $category = $this->master_category_model->get_all_category();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["products"] = $this->purchase_order_model->get_all_product();
        $datas["customers"] = $this->purchase_order_model->get_all_customers();
        $this->template->write_view('content', 'purchase_order_edit', $datas);
        $this->template->render();
    }

    public function update_po($id) {

        $user_info = $this->user_auth->get_from_session('user_info');
        $input = $this->input->post();
        //echo '<pre>';print_r($input);exit;
        if ($input['check_gst'] == 'on') {
            $input_gst['is_gst'] = 1;
        } else {
            $input_gst['is_gst'] = 0;
        }
        $input['po']['is_gst'] = $input_gst['is_gst'];

//        $input['po']['delivery_schedule'] = date('Y-m-d');
        $input['po']['created_by'] = $user_info[0]['id'];
        $input['po']['created_date'] = date('Y-m-d H:i:s');
        $update_id = $this->purchase_order_model->update_po($input['po'], $id);
        $delete_id = $this->purchase_order_model->delete_po_deteils_by_id($id);
        $input = $this->input->post();

        if (isset($input['categoty']) && !empty($input['categoty'])) {
            $insert_arr = array();
            foreach ($input['categoty'] as $key => $val) {

                $insert['po_id'] = $id;
                $insert['category'] = $val;
                $insert['product_id'] = $input['product_id'][$key];
                $insert['product_description'] = $input['product_description'][$key];
                $insert['brand'] = $input['brand'][$key];
                $insert['quantity'] = $input['quantity'][$key];
                $insert['return_quantity'] = 0;
                $insert['delivery_quantity'] = 0;
                $insert['per_cost'] = $input['per_cost'][$key];
                if ($input_gst['is_gst'] == '1') {
                    if ($input['hsn_sac'][$key] != '')
                        $insert['hsn_sac'] = $input['hsn_sac'][$key];
                } else {
                    $insert['add_amount'] = $input['add_amount'][$key];
                }
                if ($input['old_unit_price'][$key] != $input['per_cost'][$key]) {
                    $old_cost_price = $input['old_cost_price'][$key];
                    $corrected_cost_price = $input['per_cost'][$key] - $input['add_amount'][$key];

                    if ($corrected_cost_price != $old_cost_price) {
                        $product_id = $input['product_id'][$key];
                        $product_cp['cost_price'] = $input['per_cost'][$key];
                        $update = $this->purchase_order_model->update_product_cost($product_cp, $product_id);
                    }
                }
                $insert['tax'] = $input['tax'][$key];
                $insert['gst'] = $input['gst'][$key];
                $insert['igst'] = $input['igst'][$key];
                $insert['sub_total'] = $input['sub_total'][$key];
                $insert['created_date'] = date('Y-m-d H:i');
                $insert_arr[] = $insert;
            }
            // echo "<pre>"; print_r($insert_arr); exit;
            $this->purchase_order_model->insert_po_details($insert_arr);
        }

        $datas["po"] = $po = $this->purchase_order_model->get_all_po();
        redirect($this->config->item('base_url') . 'purchase_order/purchase_order_list', $datas);
    }

    public function po_delete() {
        $id = $this->input->POST('value1');
        $datas["po"] = $po = $this->purchase_order_model->get_all_po();
        $del_id = $this->purchase_order_model->delete_po($id);
        redirect($this->config->item('base_url') . 'purchase_order/purchase_order_list', $datas);
    }

    public function history_view($id) {
        $datas["his_quo"] = $his_quo = $this->purchase_order_model->all_history_quotations($id);
        $this->template->write_view('content', 'history_view', $datas);
        $this->template->render();
    }

    function ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $list = $this->purchase_order_model->get_datatables($search_data);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $po_data) {

            if ($this->user_auth->is_action_allowed('purchase_order', 'purchase_order', 'view')) {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light" href="' . base_url() . 'purchase_order/po_view/' . $po_data['id'] . '" data-toggle="tooltip" data-placement="top" title="View"><span class="fa fa-eye"></span></a>';
            } else {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-eye"></span></a>';
            }
            if ($this->user_auth->is_action_allowed('purchase_order', 'purchase_order', 'edit')) {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light" href="' . base_url() . 'purchase_order/po_edit/' . $po_data['id'] . '" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-pencil"></span></a>';
            } else {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-pencil"></span></a>';
            }
            if ($this->user_auth->is_action_allowed('purchase_order', 'purchase_order', 'delete')) {
                $delete_row = '<a onclick="delete_po(' . $po_data['id'] . ')" class="btn btn-danger btn-mini waves-effect waves-light delete_row" delete_id="test3_' . $po_data['id'] . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><span class="fa fa-trash" style="color: white;"></span></a>';
            } else {
                $delete_row = '<a  class="btn btn-danger btn-mini waves-effect waves-light delete_row alerts" delete_id="test3_' . $po_data['id'] . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><span class="fa fa-trash" style="color: white;"></span></a>';
            }
            $no++;

            $row = array();
            $row[] = $no;
            $row[] = $po_data['po_no'];
            $row[] = $po_data['store_name'];
            $row[] = $po_data['name'];
            $row[] = $po_data['total_qty'];
            $row[] = number_format($po_data['subtotal_qty'], 2);
            $row[] = number_format($po_data['net_total'], 2);
            $row[] = $po_data['gen_details'][0]['delivery_qty'];
            $row[] = number_format($po_data['gen_details'][0]['delivery_amount'], 2);
            $row[] = $po_data['pr_details'][0]['return_qty'];
            $row[] = number_format($po_data['pr_details'][0]['return_amount'], 2);
            $row[] = ($po_data['mode_of_payment'] != '') ? $po_data['mode_of_payment'] : '-';
            $row[] = ($po_data['remarks'] != '') ? '<p class="hide_overflow">' . $po_data['remarks'] . '</p>' : '-';
            if ($po_data['gen_details'][0]['delivery_qty'] != '') {
                $row[] = $view_row;
            } else {
                $row[] = $edit_row . '&nbsp;&nbsp;' . $view_row . '&nbsp;&nbsp;' . $delete_row;
            }
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->purchase_order_model->count_all(),
            "recordsFiltered" => $this->purchase_order_model->count_filtered(),
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
