<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Service_inward_and_outward_dc extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'service_inward_and_outward_dc';
        $access_arr = array(
            'service_inward_and_outward_dc/index' => array('add', 'edit', 'delete', 'view'),
            'service_inward_and_outward_dc/add_inward_dc' => array('add'),
            'service_inward_and_outward_dc/add_outward_dc' => array('add'),
            'service_inward_and_outward_dc/add_dc' => array('add'),
            'service_inward_and_outward_dc/view_invoice' => array('add', 'edit', 'delete', 'view'),
            'service_inward_and_outward_dc/inward_and_outward_ajaxList' => 'no_restriction',
            'service_inward_and_outward_dc/dc_view' => 'no_restriction',
        );
        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('service_inward_and_outward_dc/inward_and_outward_dc_model');
        $this->load->model('service/service_model');
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
        $this->load->model('masters/ref_increment_model');
        $this->load->model('purchase_order/purchase_order_model');
    }

    public function index() {

        $this->template->write_view('content', 'index', $data);
        $this->template->render();
    }

    public function add_inward_dc() {

        if ($this->input->post()) {
            $input = $this->input->post();

            $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
            $input['quotation']['created_by'] = $user_info[0]['id'];
            $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));

            $insert_id = $this->inward_and_outward_dc_model->insert_service_dc($input['quotation']);

            if (isset($insert_id) && !empty($insert_id)) {
                $input = $this->input->post();
                if (isset($input['product_id']) && !empty($input['product_id'])) {
                    $insert_arr = array();
                    foreach ($input['product_id'] as $key => $val) {
                        $insert['service_dc_id'] = $insert_id;
                        $insert['product_id'] = $val;
                        $insert['product_description'] = $input['product_description'][$key];
                        $insert['product_type'] = $input['product_type'][$key];
                        if ($input['quantity'][$key]) {
                            $insert['quantity'] = $input['quantity'][$key];
                        } else {
                            $insert['quantity'] = 0;
                        }
                        $insert['dc_quantity'] = $input['dc_quantity'][$key];
                        $insert['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert;
                    }

                    $this->inward_and_outward_dc_model->insert_inward_outward_dc_details($insert_arr);
                }
            }
            $this->ref_increment_model->update_increment_id('DC', 'DC');
            redirect($this->config->item('base_url') . 'service_inward_and_outward_dc');
        }
        $data["last_id"] = $this->ref_increment_model->get_increment_id('DC', 'DC');
        $data["category"] = $details = $this->master_category_model->get_all_category();
        $data["brand"] = $this->master_brand_model->get_brand();
        $data["nick_name"] = $this->Gen_model->get_all_nick_name();
        $data['company_details'] = $this->admin_model->get_company_details();
        $data["products"] = $this->Gen_model->get_product_data();
        $data["products1"] = $this->Gen_model->get_all_product1();
        $data["customers"] = $this->Gen_model->get_all_customers();
        $data["invoice"] = $this->service_model->get_all_quotations();

        $this->template->write_view('content', 'add_inward_dc', $data);
        $this->template->render();
    }

    public function add_outward_dc() {
        if ($this->input->post()) {
            $input = $this->input->post();

            $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
            $input['quotation']['created_by'] = $user_info[0]['id'];
            $input['quotation']['created_date'] = date('Y-m-d', strtotime($input['quotation']['created_date']));

            $insert_id = $this->inward_and_outward_dc_model->insert_service_dc($input['quotation']);

            if (isset($insert_id) && !empty($insert_id)) {
                $input = $this->input->post();
                if (isset($input['product_id']) && !empty($input['product_id'])) {
                    $insert_arr = array();
                    foreach ($input['product_id'] as $key => $val) {
                        $insert['service_dc_id'] = $insert_id;
                        $insert['product_id'] = $val;
                        $insert['product_description'] = $input['product_description'][$key];
                        $insert['product_type'] = $input['product_type'][$key];
                        $insert['quantity'] = 0;
                        $insert['dc_quantity'] = $input['dc_quantity'][$key];
                        $insert['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert;
                    }

                    $this->inward_and_outward_dc_model->insert_inward_outward_dc_details($insert_arr);
                }
            }
            $this->ref_increment_model->update_increment_id('DC', 'DC');
            redirect($this->config->item('base_url') . 'service_inward_and_outward_dc');
        }

        $data["last_id"] = $this->ref_increment_model->get_increment_id('ODC', 'ODC');
        $data["category"] = $details = $this->master_category_model->get_all_category();
        $data["brand"] = $this->master_brand_model->get_brand();
        $data['company_details'] = $this->admin_model->get_company_details();
        $data["products"] = $this->purchase_order_model->get_all_product();
        $datas["products1"] = $this->purchase_order_model->get_all_product1();
        $data["customers"] = $this->purchase_order_model->get_all_customers();

        $this->template->write_view('content', 'add_outward_dc', $data);
        $this->template->render();
    }

    public function view_invoice() {

        $input = $this->input->get();
        $data['service_type'] = $input['type'];
        $data['quotation'] = $invoice = $this->inward_and_outward_dc_model->get_all_invoice_by_id($input['q_id']);
        $data["quotation_details"] = $invoice_details = $this->inward_and_outward_dc_model->get_all_invoice_details_by_id($invoice[0]['id']);

        $this->load->view('service_inward_and_outward_dc/invoice_tr_view', $data);
    }

    function dc_view($id, $type) {
        if ($type == 'inward') {
            $data['quotation'] = $invoice = $this->inward_and_outward_dc_model->get_all_service_dc_by_id($id);
        } else {
            $data['quotation'] = $invoice = $this->inward_and_outward_dc_model->get_all_service_odc_by_id($id);
        }
        $data["quotation_details"] = $invoice_details = $this->inward_and_outward_dc_model->get_all_service_dc_details_by_id($id);

        $this->template->write_view('content', 'dc_service_view', $data);
        $this->template->render();
    }

    function inward_and_outward_ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $list = $this->inward_and_outward_dc_model->get_datatables($search_data);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $val) {
            if ($this->user_auth->is_action_allowed('service_inward_and_outward_dc', 'service_inward_and_outward_dc', 'view')) {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light" href="' . base_url() . 'service_inward_and_outward_dc/dc_view/' . $val['id'] . '/' . $val['service_type'] . '" data-toggle="tooltip" data-placement="top" title="View"><span class="fa fa-eye"></span></a>';
            } else {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-eye"></span></a>';
            }
            $no++;

            $row = array();
            $row[] = $no;
            $row[] = $val['dc_no'];
            $row[] = $val['invoice_no'];
            $row[] = $val['project'];
            $row[] = ucfirst($val['service_type']);
            $row[] = $val['total_qty'];
            $row[] = ($val['created_date'] != '') ? date('d-M-Y', strtotime($val['created_date'])) : '-';
            $row[] = $view_row;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->inward_and_outward_dc_model->count_all(),
            "recordsFiltered" => $this->inward_and_outward_dc_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

}
