<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');

        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'masters';
        $access_arr = array(
            'product/index' => array('add', 'edit', 'delete', 'view'),
            'product/insert_product' => array('add'),
            'product/edit_product' => array('edit'),
            'product/update_products' => array('edit'),
            'product/delete_product' => array('delete'),
            'product/add_duplicate_product' => array('add', 'edit'),
            'product/update_duplicate_product' => array('add', 'edit'),
            'product/ajaxList' => 'no_restriction',
                /* 'product/import_products' => array('add', 'edit', 'delete', 'view'),
                  'product/ajaxList' => 'no_restriction',
                  'product/get_category_by_frim_id' => 'no_restriction',
                  'product/stock_details' => 'no_restriction',
                  'product/get_brand_by_frim_id' => 'no_restriction',
                  'product/save_barcode' => 'no_restriction',
                  'product/generate_barcode' => 'no_restriction',
                  'product/barcode_pdf' => 'no_restriction',
                  'product/check_product' => 'no_restriction', */
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }

        $this->load->model('product/product_model');
        $this->load->model('master_style/master_model');
        $this->load->model('master_category/master_category_model');
        $this->load->model('master_brand/master_brand_model');
    }

    public function index() {
        $user_info = $this->user_auth->get_from_session('user_info');
        $data["role"] = $user_info[0]['role'];
        $data["product"] = $this->product_model->get_product();
        $data["last_id"] = $this->master_model->get_last_id('m_code');
        $data["brand"] = $this->master_brand_model->get_brand();
        $data["cat"] = $this->master_category_model->get_all_category();
        $this->template->write_view('content', 'product/index', $data);
        $this->template->render();
    }

    public function insert_product() {

        if ($this->input->post()) {
            $data["product"] = $this->product_model->get_product();
            $this->load->helper('text');

            $config['upload_path'] = './attachement/product';

            $config['allowed_types'] = '*';

            $config['max_size'] = '2000';

            $this->load->library('upload', $config);

            $upload_data['file_name'] = $_FILES;
            if (isset($_FILES) && !empty($_FILES)) {
                $upload_files = $_FILES;
                if ($upload_files['admin_image'] != '') {
                    $_FILES['admin_image'] = array(
                        'name' => $upload_files['admin_image']['name'],
                        'type' => $upload_files['admin_image']['type'],
                        'tmp_name' => $upload_files['admin_image']['tmp_name'],
                        'error' => $upload_files['admin_image']['error'],
                        'size' => '2000'
                    );
                    $this->upload->do_upload('admin_image');

                    $upload_data = $this->upload->data();

                    $dest = getcwd() . "/attachement/product/" . $upload_data['file_name'];

                    $src = $this->config->item("base_url") . 'attachement/product/' . $upload_data['file_name'];
                }
            }
            $input_data['admin']['admin_image'] = $upload_data['file_name'];
            $input = array('model_no' => $this->input->post('model_no'), 'product_name' => $this->input->post('product_name'),
                'product_description' => $this->input->post('product_description'), 'product_image' => $upload_data['file_name'],
                'type' => $this->input->post('type'), 'min_qty' => $this->input->post('min_qty'), 'selling_price' => $this->input->post('selling_price'),
                'cost_price' => $this->input->post('cost_price'), 'category_id' => $this->input->post('category_id'), 'brand_id' => $this->input->post('brand_id'), 'cgst' => $this->input->post('cgst'), 'sgst' => $this->input->post('sgst'), 'igst' => $this->input->post('igst'), 'hsn_sac' => $this->input->post('hsn_sac'), 'add_amount' => $this->input->post('add_amount'), 'po_add_amount' => $this->input->post('po_add_amount'));

            $insert_id = $this->product_model->insert_product($input);
            redirect($this->config->item('base_url') . 'product/index', $data);
        }
    }

    public function edit_product($id) {
        $user_info = $this->user_auth->get_from_session('user_info');
        $data["role"] = $user_info[0]['role'];
        $data["product"] = $details = $this->product_model->get_product_by_id($id);
        $data["brand"] = $this->master_brand_model->get_brand();
        $data["cat"] = $this->master_category_model->get_all_category();
        $data['vendor_details'] = $this->product_model->get_vendor_last_po_details_by_product_id($id, $details[0]['brand_id'], $details[0]['category_id']);
        $this->template->write_view('content', 'product/update_product', $data);
        $this->template->render();
    }

    public function update_products() {
        if ($this->input->post()) {

            $id = $this->input->post('id');
            $input = array('id' => $this->input->post('id'), 'model_no' => $this->input->post('model_no'), 'product_name' => $this->input->post('product_name'),
                'product_description' => $this->input->post('product_description'), 'type' => $this->input->post('type'), 'min_qty' => $this->input->post('min_qty'),
                'selling_price' => $this->input->post('selling_price'),
                'cost_price' => $this->input->post('cost_price'), 'category_id' => $this->input->post('category_id'), 'brand_id' => $this->input->post('brand_id'), 'cgst' => $this->input->post('cgst'), 'sgst' => $this->input->post('sgst'), 'igst' => $this->input->post('igst'), 'hsn_sac' => $this->input->post('hsn_sac'), 'add_amount' => $this->input->post('add_amount'), 'po_add_amount' => $this->input->post('po_add_amount'));
            //$data["product"]=$this->product_model->get_product();
            $this->load->helper('text');
            $config['upload_path'] = './attachement/product/';
            $config['allowed_types'] = '*';
            $config['max_size'] = '2000';
            $this->load->library('upload', $config);
            $upload_data['file_name'] = $_FILES;

            if (isset($_FILES) && !empty($_FILES)) {
                $upload_files = $_FILES;
                if ($upload_files['admin_image']['name'] != '') {
                    $_FILES['admin_image'] = array(
                        'name' => $upload_files['admin_image']['name'],
                        'type' => $upload_files['admin_image']['type'],
                        'tmp_name' => $upload_files['admin_image']['tmp_name'],
                        'error' => $upload_files['admin_image']['error'],
                        'size' => '2000'
                    );
                    $this->upload->do_upload('admin_image');

                    $upload_data = $this->upload->data();

                    $dest = getcwd() . "/attachement/product/" . $upload_data['file_name'];

                    $src = $this->config->item("base_url") . 'attachement/product/' . $upload_data['file_name'];
                    $input_data['admin_image'] = $upload_data['file_name'];
                    $input = array('model_no' => $this->input->post('model_no'), 'product_name' => $this->input->post('product_name'), 'product_description' => $this->input->post('product_description'), 'product_image' => $upload_data['file_name'], 'type' => $this->input->post('type'), 'min_qty' => $this->input->post('min_qty'), 'selling_price' => $this->input->post('selling_price'), 'cost_price' => $this->input->post('cost_price'), 'category_id' => $this->input->post('category_id'), 'brand_id' => $this->input->post('brand_id'));
                }
            }
            $this->product_model->update_product($input, $id);
            redirect($this->config->item('base_url') . 'product/index');
        }
    }

    public function delete_product() {
        $data["product"] = $details = $this->product_model->get_product();
        $id = $this->input->POST('value1');
        $this->product_model->delete_product($id);
        redirect($this->config->item('base_url') . 'product/index', $data);
    }

    public function add_duplicate_product() {

        $input = $this->input->get('value1');
        $validation = $this->product_model->add_duplicate_product($input);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo"Model Number Already Exist";
        }
    }

    public function update_duplicate_product() {
        $input = $this->input->get('value1');
        $id = $this->input->get('value2');
        $validation = $this->product_model->update_duplicate_product($input, $id);

        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Model Number Already Exist";
        }
    }

    function ajaxList() {
        $user_info = $this->user_auth->get_from_session('user_info');
        $role = $user_info[0]['role'];
        $list = $this->product_model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $product_data) {
            if ($this->user_auth->is_action_allowed('masters', 'product', 'edit')) {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light" href="' . base_url() . 'product/edit_product/' . $product_data->id . '" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-pencil"></span></a>';
            } else {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-pencil"></span></a>';
            }
            if ($this->user_auth->is_action_allowed('masters', 'product', 'delete')) {
                $delete_row = '<a onclick="delete_product(' . $product_data->id . ')" class="btn btn-danger btn-mini waves-effect waves-light delete_row" delete_id="test3_' . $product_data->id . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><span class="fa fa-trash" style="color: white;"></span></a>';
            } else {
                $delete_row = '<a  class="btn btn-danger btn-mini waves-effect waves-light delete_row alerts" delete_id="test3_' . $product_data->id . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><span class="fa fa-trash" style="color: white;"></span></a>';
            }
            if ($product_data->product_image) {
                $image_path = base_url() . 'attachement/product/' . $product_data->product_image;
            } else {
                $image_path = '';
            }
            $product_image = '<img id="blah" alt=""accesskey="" class="add_staff_thumbnail" width="50px" height="50px" src="' . $image_path . '" >';

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $product_data->hsn_sac;
            $row[] = $product_data->model_no;
            $row[] = $product_data->product_name;
            $row[] = $product_data->product_description;
            $row[] = $product_data->min_qty;
            $row[] = $product_data->selling_price;
            $row[] = $product_image;
            $row[] = $edit_row . '&nbsp;&nbsp;' . $delete_row;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->product_model->count_all(),
            "recordsFiltered" => $this->product_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
