<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Purchase_return extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'purchase_return';
        $access_arr = array(
            'purchase_return/purchase_order_list' => array('add', 'edit', 'delete', 'view'),
            'purchase_return/index' => array('add', 'edit', 'delete', 'view'),
            'purchase_return/po_view' => array('add', 'edit', 'delete', 'view'),
            'purchase_return/po_delete' => array('delete'),
            'purchase_return/po_edit' => array('add', 'edit'),
            'purchase_return/update_po' => array('edit'),
            'purchase_return/change_status' => 'no_restriction',
            'purchase_return/get_customer' => 'no_restriction',
            'purchase_return/get_customer_by_id' => 'no_restriction',
            'purchase_return/get_product' => 'no_restriction',
            'purchase_return/get_product_by_id' => 'no_restriction',
            'purchase_return/history_view' => 'no_restriction',
            'purchase_return/stock_details' => 'no_restriction',
            'purchase_return/ajaxList' => 'no_restriction',
            'purchase_return/get_grn_list' => 'no_restriction',
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
        $this->load->model('purchase_return/purchase_return_model');
    }

    public function index() {
//        $datas["po"] = $po = $this->purchase_return_model->get_all_po();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["grn_no"] = $this->purchase_return_model->get_all_grn_number();
        //  echo "<pre>"; print_r($this->session->userdata('user_info')); print_r($this->user_info[0]['id']); exit;
        $this->template->write_view('content', 'purchase_return/purchase_return_list', $datas);
        $this->template->render();
    }

    public function get_grn_list() {
        $atten_inputs = $this->input->post('grn_no');
        $data = $this->purchase_return_model->get_all_grn_list($atten_inputs);
        echo json_encode($data);
        exit;
    }

    public function po_view($id) {
        $datas["po"] = $po = $this->purchase_return_model->get_all_pr_by_id($id);
        $datas["in_words"] = $this->convert_number($datas["po"][0]['return_amount']);
        $datas["po_details"] = $po_details = $this->purchase_return_model->get_all_pr_details_by_id($id);
        $datas["category"] = $category = $this->master_category_model->get_all_category();
        $datas['company_details'] = $this->admin_model->get_company_details();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();
        $datas["purchase_return_details"] = $this->purchase_return_model->get_purchase_return_details($id);
//        echo '<pre>';
//        print_r($datas);
//        exit;
        $this->template->write_view('content', 'purchase_return_view', $datas);
        $this->template->render();
    }

    public function change_status($id, $status) {
        //echo $id; echo $status; exit;
        $this->purchase_return_model->change_po_status($id, $status);
        redirect($this->config->item('base_url') . 'purchase_return/purchase_return_list');
    }

    public function purchase_return_list() {

    }

    public function get_customer() {
        $atten_inputs = $this->input->get();
        $data = $this->purchase_return_model->get_customer($atten_inputs);
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
        $data_customer["customer_details"] = $this->purchase_return_model->get_customer_by_id($input['id']);
        echo json_encode($data_customer);
    }

    public function get_product() {
        $atten_inputs = $this->input->get();
        $product_data = $this->purchase_return_model->get_product($atten_inputs);

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
        $data_customer["product_details"] = $this->purchase_return_model->get_product_by_id($input['id']);
        echo json_encode($data_customer);
    }

    public function po_edit($id) {
        $datas["po"] = $po = $this->purchase_return_model->get_all_grn_by_id($id);
        $datas["po_details"] = $po_details = $this->purchase_return_model->get_all_grn_details_by_id($id);
        //echo "<pre>"; print_r($datas); exit;
        $datas["category"] = $category = $this->master_category_model->get_all_category();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();
        $datas['company_details'] = $this->admin_model->get_company_details();

        $this->template->write_view('content', 'purchase_return_edit', $datas);
        $this->template->render();
    }

    function stock_details($stock_info, $po_id) {

        $this->purchase_return_model->check_stock($stock_info, $po_id);
    }

    public function update_po($id) {
        if ($this->input->post()) {
            $input = $this->input->post();
            $purchase_order_id = $input['purchase_order_id'];

            // Insert ERP PR
            $user_info = $this->user_auth->get_from_session('user_info');
            $input['po']['created_by'] = $user_info[0]['id'];
            $input['po']['created_date'] = date('Y-m-d', strtotime($input['po']['created_date']));
            $input['po']['po_id'] = $input['purchase_order_id'];
            $insert_id = $this->purchase_return_model->insert_pr($input['po']);

            //Update po
            $datas['remarks'] = $input['po']['remarks'];
            $this->purchase_return_model->update_po($datas, $purchase_order_id);

            if (isset($insert_id) && !empty($insert_id)) {
                $input = $this->input->post();
                if (isset($input['categoty']) && !empty($input['categoty'])) {
                    $insert_arr = array();
                    foreach ($input['categoty'] as $key => $val) {
                        //Update Gen Details
                        $this->purchase_return_model->update_gen_data($input['return_quantity'][$key], $input['gen_details_id'][$key]);

                        //Update po Details
                        $return_quantity = $input['return_quantity'][$key];
                        $this->purchase_return_model->update_po_details($input['return_quantity'][$key], $purchase_order_id, $input['categoty'][$key], $input['brand'][$key]);

                        //Insert Pr details
                        $insert['po_id'] = $purchase_order_id;
                        $insert['pr_id'] = $insert_id;
                        $insert['gen_id'] = $input['po']['gen_id'];
                        $insert['category'] = $val;
                        $insert['product_id'] = $input['product_id'][$key];
                        $insert['product_description'] = $input['product_description'][$key];
                        $insert['brand'] = $input['brand'][$key];
                        $insert['return_quantity'] = $input['return_quantity'][$key];
                        $insert['per_cost'] = $input['per_cost'][$key];
                        if ($input['po']['is_gst'] == '1') {
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
                        $po_id['po_id'] = $input['po']['grn_no'];
                        $stock_arr[] = $po_id;
                        $this->stock_details($insert, $po_id);
                    }
                    $this->purchase_return_model->insert_pr_details($insert_arr);
                }
            }
            redirect($this->config->item('base_url') . 'purchase_return/index');
        }
    }

    public function po_delete() {
        $id = $this->input->POST('value1');
        $datas["po"] = $po = $this->purchase_return_model->get_all_po();
        $del_id = $this->purchase_return_model->delete_po($id);
        redirect($this->config->item('base_url') . 'purchase_return/purchase_return_list', $datas);
    }

    public function history_view($id) {
        $datas["his_quo"] = $his_quo = $this->purchase_return_model->all_history_quotations($id);
        $this->template->write_view('content', 'history_view', $datas);
        $this->template->render();
    }

    function ajaxList1() {
        $search_data = array();
        $search_data = $this->input->post();
        $list = $this->purchase_return_model->get_purchase_return_datatables($search_data);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pr_data) {
            if ($this->user_auth->is_action_allowed('purchase_return', 'purchase_return', 'edit')) {
                $edit_row = '<a class="btn btn-info btn-mini waves-effect waves-light" href="' . base_url() . 'purchase_return/po_edit/' . $pr_data['id'] . '" data-toggle="tooltip" data-placement="top" title="Edit"><span>Make Return</span></a>';
            } else {
                $edit_row = '<a class="btn btn-info btn-mini waves-effect waves-light alerts" href=""><span>Make Return</span></a>';
            }

            $no++;

            $row = array();
            $row[] = $no;
            $row[] = $pr_data['po_no'];
            $row[] = $pr_data['store_name'];
            $row[] = $pr_data['total_qty'];

            $cgst = 0;
            $sgst = 0;
            $sub_total = $over_all_net_total = $over_all_net = 0;
            if (isset($pr_data['po_details']) && !empty($pr_data['po_details'])) {
                foreach ($pr_data['po_details'] as $vals) {

                    $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['delivery_quantity']);

                    $gst_type = $pr_data['state_id'];
                    if ($gst_type != '') {
                        if ($gst_type == 31) {

                            $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * $vals['delivery_quantity']);
                        } else {
                            $sgst1 = ($vals['igst'] / 100 ) * ($vals['per_cost'] * $vals['delivery_quantity']);
                        }
                    }
                    $cgst += $cgst1;
                    $sgst += $sgst1;

                    $deliver_qty = $vals['delivery_quantity'];
                    $per_cost = $vals['per_cost'];
                    $gst_val = $vals['tax'];
                    $cgst_val = $vals['gst'];
                    if ($pr_data['is_gst'] == 1) {
                        $net_total = $deliver_qty * $per_cost;
                    } else {
                        $net_total = $deliver_qty * ($per_cost);
                    }
                    $sub_total += $net_total;
                    if ($pr_data['is_gst'] == 1) {
                        $final_sub__total = $deliver_qty * $per_cost + (($deliver_qty * $per_cost) * $gst_val / 100) + (($deliver_qty * $per_cost) * $cgst_val / 100);
                    } else {
                        $final_sub__total = $deliver_qty * ($per_cost);
                    }
                    $over_all_net += $final_sub__total;
                    $over_all_net_total = $over_all_net + $pr_data['tax'];
                }
            }

            $net_total = $over_all_net_total;
            if (isset($pr_data['deliver'][0]['delivery_quantity']) && !empty($pr_data['deliver'][0]['delivery_quantity'])) {
                $row[] = $pr_data['return'][0]['return_quantity'];
                $row[] = $pr_data['deliver'][0]['delivery_quantity'] - $pr_data['return'][0]['return_quantity'];
                $row[] = $pr_data['deliver'][0]['delivery_quantity'];
                $row[] = number_format($sub_total, 2);
                $row[] = number_format($net_total, 2);
            } else {
                $row[] = $pr_data['return'][0]['return_quantity'];
                $row[] = '';
                $row[] = $pr_data['deliver'][0]['delivery_quantity'];
                $row[] = number_format(0, 2);
                $row[] = number_format(0, 2);
            }

            $row[] = ($pr_data['mode_of_payment'] != '') ? $pr_data['mode_of_payment'] : '-';
            $row[] = ($pr_data['remarks'] != '') ? '<p class="hide_overflow">' . $pr_data['remarks'] . '</p>' : '-';
            $row[] = $edit_row;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->purchase_return_model->count_all(),
            "recordsFiltered" => $this->purchase_return_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    public function ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $list = $this->purchase_return_model->get_purchase_return_datatables($search_data);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $val) {
            if ($this->user_auth->is_action_allowed('purchase_return', 'purchase_return', 'view')) {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light" href="' . base_url() . 'purchase_return/po_view/' . $val['gen_id'] . '" data-toggle="tooltip" data-placement="top" title="View"><span class="fa fa-eye"></span></a>';
            } else {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-eye"></span></a>';
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val['grn_no'];
            $row[] = $val['store_name'];
            $row[] = $val['delivery_qty'];
            $row[] = number_format($val['delivery_amount'], 2);
            $row[] = number_format($val['return_qty']);
            $row[] = number_format($val['return_amount'], 2);
            $row[] = $view_row;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->purchase_return_model->count_all(),
            "recordsFiltered" => $this->purchase_return_model->count_filtered(),
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
