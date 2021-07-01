<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Vendor extends MX_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        /* $this->load->library('session');
          $this->load->library('email');
          $this->load->database();
          $this->load->library('form_validation'); */
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'masters';
        $access_arr = array(
            'vendor/index' => array('add', 'edit', 'delete', 'view'),
            'vendor/insert_vendor' => array('add'),
            'vendor/edit_vendor' => array('edit'),
            'vendor/update_vendor' => array('edit'),
            'vendor/delete_vendor' => array('delete'),
            'vendor/add_duplicate_mail' => array('add', 'edit'),
            'vendor/update_duplicate_mail' => array('add', 'edit'),
            'vendor/ajaxList' => 'no_restriction',
            'vendor/is_mobile_number_available' => 'no_restriction',
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('masters/user_model');
    }

    public function index() {
        $this->load->model('vendor/vendor_model');
        $data["vendor"] = $this->vendor_model->get_vendor();
        $data['all_state'] = $this->vendor_model->state();
        //echo "<pre>";print_r($data);exit;
        $this->template->write_view('content', 'vendor/index', $data);
        $this->template->render();
    }

    public function insert_vendor() {
        $this->load->model('vendor/vendor_model');
        $input_data = array(
            'name' => $this->input->post('name'),
            'store_name' => $this->input->post('store'),
            'address1' => $this->input->post('address1'),
            'address2' => $this->input->post('address2'),
            'city' => $this->input->post('city'),
            'pincode' => $this->input->post('pin'),
            'mobil_number' => $this->input->post('number'),
            'mobile_number_2' => $this->input->post('number2'),
            'mobile_number_3' => $this->input->post('number3'),
            'email_id' => $this->input->post('mail'),
            'bank_name' => $this->input->POST('bank'),
            'bank_branch' => $this->input->POST('branch'),
            'account_num' => $this->input->POST('acnum'),
            /* 'selling_percent'=>$this->input->post('percentage'), */
            'state_id' => $this->input->post('state_id'),
            'payment_terms' => $this->input->post('payment_terms'),
            'tin' => $this->input->post('tin'),
            'ifsc' => $this->input->post('ifsc'),
            'nick_name' => $this->input->post('nick_name')
        );
        $this->vendor_model->insert_vendor($input_data);
        $data["vendor"] = $this->vendor_model->get_vendor();
        redirect($this->config->item('base_url') . 'vendor/index', $data);
    }

    public function edit_vendor($id) {
        $this->load->model('vendor/vendor_model');
        $data['all_state'] = $this->vendor_model->state();
        $data["vendor"] = $this->vendor_model->get_vendor1($id);
        $this->template->write_view('content', 'vendor/update_vendor', $data);
        $this->template->render();
    }

    public function update_vendor() {
        $this->load->model('vendor/vendor_model');
        $data['all_state'] = $this->vendor_model->state();
        $id = $this->input->post('id');
        $data["vendor"] = $this->vendor_model->get_vendor();
        $input = array('name' => $this->input->post('name'), 'store_name' => $this->input->post('store'), 'address1' => $this->input->post('address1'),
            'address2' => $this->input->post('address2'), 'city' => $this->input->post('city'),
            'pincode' => $this->input->post('pin'), 'mobil_number' => $this->input->post('number'), 'mobile_number_2' => $this->input->post('number2'), 'mobile_number_3' => $this->input->post('number3'), 'email_id' => $this->input->post('mail'),
            'bank_name' => $this->input->POST('bank'), 'bank_branch' => $this->input->POST('branch'), 'account_num' => $this->input->POST('acnum'),
            /* 'selling_percent'=>$this->input->post('percentage'), */ 'state_id' => $this->input->post('state_id'), 'payment_terms' => $this->input->post('payment_terms'), 'tin' => $this->input->post('tin'), 'ifsc' => $this->input->post('ifsc'), 'nick_name' => $this->input->post('nick_name'));

        $this->vendor_model->update_vendor($input, $id);
        $this->template->write_view('content', 'vendor/update_vendor', $data);
        redirect($this->config->item('base_url') . 'vendor/');
    }

    public function delete_vendor() {
        $this->load->model('vendor/vendor_model');

        $id = $this->input->POST('value1'); {
            $this->vendor_model->delete_vendor($id);
            $data["vendor"] = $this->vendor_model->get_vendor();
            redirect($this->config->item('base_url') . 'vendor/index', $data);
        }
    }

    public function add_duplicate_mail() {
        $this->load->model('vendor/vendor_model');
        $input = $this->input->get('value1');
        $validation = $this->vendor_model->add_duplicate_mail($input);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Email Already Exist";
        }
    }

    public function update_duplicate_mail() {
        $this->load->model('vendor/vendor_model');
        $input = $this->input->post('value1');
        $id = $this->input->post('value2');
        $validation = $this->vendor_model->update_duplicate_mail($input, $id);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Email already Exist";
        }
    }

    function ajaxList() {
        $this->load->model('vendor/vendor_model');
        $list = $this->vendor_model->datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $vendor) {
            if ($this->user_auth->is_action_allowed('masters', 'vendor', 'edit')) {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light" href="' . base_url() . 'vendor/edit_vendor/' . $vendor->id . '" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-pencil"></span></a>';
            } else {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-pencil"></span></a>';
            }
            if ($this->user_auth->is_action_allowed('masters', 'vendor', 'delete')) {
                $delete_row = '<a onclick="delete_vendor(' . $vendor->id . ')" class="btn btn-danger btn-mini waves-effect waves-light delete_row" delete_id="test3_' . $vendor->id . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><span class="fa fa-trash" style="color: white;"></span></a>';
            } else {
                $delete_row = '<a  class="btn btn-danger btn-mini waves-effect waves-light delete_row alerts" delete_id="test3_' . $vendor->id . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><span class="fa fa-trash" style="color: white;"></span></a>';
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = 'VENDOR_ID_' . $vendor->id;
            $row[] = $vendor->store_name;
            $row[] = $vendor->name;
            $row[] = $vendor->mobil_number;
            $row[] = $vendor->city;
            $row[] = $vendor->tin;
            $row[] = $vendor->email_id;
//            $bank_details = '<strong>NAME:</strong>' . $vendor->bank_name . '<br />
//                        <strong>BRANCH:</strong>' . $vendor->bank_branch . '.<br />
//                        <strong>A/C:</strong>' . $vendor->account_num . '.<br />
//                        <strong>IFSC CODE:</strong>' . $vendor->ifsc . '.<br />';
//            $row[] = $bank_details;
            $row[] = $edit_row . '&nbsp;&nbsp;' . $delete_row;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->vendor_model->count(),
            "recordsFiltered" => $this->vendor_model->count_filter(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    public function test_google() {
        $this->template->write_view('content', 'vendor/test_google');
        $this->template->render();
    }

    function is_mobile_number_available() {
        $this->load->model('vendor/vendor_model');
        $mobile = $this->input->post('mobile');
        $id = $this->input->post('id');
        $result = $this->vendor_model->is_mobile_number_available($mobile, $id);
        if (!empty($result[0]['id'])) {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
