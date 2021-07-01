<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customer extends MX_Controller {

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
//		$this->load->library('session');
//		$this->load->library('email');
//                $this->load->database();
//		$this->load->library('form_validation');
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'masters';
        $access_arr = array(
            'customer/index' => array('add', 'edit', 'delete', 'view'),
            'customer/insert_customer' => array('add'),
            'customer/edit_customer' => array('edit'),
            'customer/update_customer' => array('edit'),
            'customer/delete_customer' => array('delete'),
            'customer/add_duplicate_email' => array('add', 'edit'),
            'customer/update_duplicate_email' => array('add', 'edit'),
            'customer/import_customers' => array('add', 'edit', 'delete', 'view'),
            'customer/add_state' => array('add', 'edit'),
            'customer/ajaxList' => 'no_restriction',
            'customer/is_mobile_number_available' => 'no_restriction',
            'customer/add_customers' => 'no_restriction',
            'customer/check_duplicate_email' => 'no_restriction',
            'customer/check_duplicate_mobile_number' => 'no_restriction',
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
    }

    public function index() {
        $this->load->model('customer/customer_model');
        $this->load->model('customer/agent_model');
        $data["customer"] = $this->customer_model->get_customer();
        $data['all_state'] = $this->customer_model->state();
        $data['all_agent'] = $this->agent_model->get_agent();
        $data["staff_name"] = $this->customer_model->get_all_staff_name();
//        echo "<pre>";
//        print_r($data["customer"]);
//        exit;
        $this->template->write_view('content', 'customer/index', $data);
        $this->template->render();
    }

    public function insert_customer() {
        $this->load->model('customer/customer_model');
        $input_data = array(
            'name' => $this->input->post('name'),
            'store_name' => $this->input->post('store'),
            'address1' => $this->input->post('address1'),
            'address2' => $this->input->post('address2'),
            'city' => $this->input->post('city'),
            //'pincode'=>$this->input->post('pin'),
            'mobil_number' => $this->input->post('number'),
            'mobile_number_2' => $this->input->post('number2'),
            'mobile_number_3' => $this->input->post('number3'),
            'email_id' => $this->input->post('mail'),
            'bank_name' => $this->input->POST('bank'),
            'bank_branch' => $this->input->POST('branch'),
            'account_num' => $this->input->POST('acnum'),
            //'selling_percent'=>$this->input->post('percentage'),
            'state_id' => $this->input->post('state_id'),
            'ifsc' => $this->input->post('ifsc'),
            //'c_st'=>$this->input->post('st'),
            //'c_cst'=>$this->input->post('cst'),
            //'c_vat'=>$this->input->post('vat'),
            'staff_id' => $this->input->post('staff_name'),
            //'agent_comm'=>$this->input->post('agent_comm'),
            'payment_terms' => $this->input->post('payment_terms'),
            'otp_verification_status' => 1,
            'password' => md5($this->input->POST('password')),
            'tin' => $this->input->post('tin')
        );

        $this->customer_model->insert_customer($input_data);
        $data["customer"] = $this->customer_model->get_customer();
        redirect($this->config->item('base_url') . 'customer/index', $data);
    }

    public function edit_customer($id) {
        $this->load->model('customer/customer_model');
        $this->load->model('customer/agent_model');
        $data['all_state'] = $this->customer_model->state();
        $data["customer"] = $this->customer_model->get_customer1($id);
        $data['all_agent'] = $this->agent_model->get_agent();
        $data["staff_name"] = $this->customer_model->get_all_staff_name();
        $this->template->write_view('content', 'customer/update_customer', $data);
        $this->template->render();
    }

    public function update_customer() {
        $this->load->model('customer/customer_model');
        $id = $this->input->POST('id');
        $pass = $this->input->POST('password');
        if (isset($pass) && !empty($pass)) {
            $input_data['password'] = md5($pass);
        } else {
            $input_data['password'] = '';
        }
        $input = array(
            'name' => $this->input->post('name'),
            'store_name' => $this->input->post('store'),
            'address1' => $this->input->post('address1'),
            'address2' => $this->input->post('address2'),
            'city' => $this->input->post('city'),
            //'pincode'=>$this->input->post('pin'),
            'mobil_number' => $this->input->post('number'),
            'mobile_number_2' => $this->input->post('number2'),
            'mobile_number_3' => $this->input->post('number3'),
            'email_id' => $this->input->post('mail'),
            'bank_name' => $this->input->POST('bank'),
            'bank_branch' => $this->input->POST('branch'),
            'account_num' => $this->input->POST('acnum'),
            //'selling_percent'=>$this->input->post('percentage'),
            'state_id' => $this->input->post('state_id'),
            'ifsc' => $this->input->post('ifsc'),
            //'c_st'=>$this->input->post('st'),
            //'c_cst'=>$this->input->post('cst'),
            //'c_vat'=>$this->input->post('vat'),
            'staff_id' => $this->input->post('staff_name'),
            //'agent_comm'=>$this->input->post('agent_comm'),
            'payment_terms' => $this->input->post('payment_terms'),
            'password' => $input_data['password'],
            'tin' => $this->input->post('tin')
        );
        // echo "<pre>"; print_r($input_data); exit;
        $this->customer_model->update_customer($input, $id);
        redirect($this->config->item('base_url') . 'customer/');
    }

    public function delete_customer() {
        $this->load->model('customer/customer_model');
        $data["customer"] = $this->customer_model->get_customer();
        $id = $this->input->POST('value1'); {
            $this->customer_model->delete_customer($id);

            redirect($this->config->item('base_url') . 'customer/index', $data);
        }
    }

    public function add_duplicate_email() {
        $this->load->model('customer/customer_model');
        $input = $this->input->get('value1');
        $validation = $this->customer_model->add_duplicate_email($input);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Email Already Exist";
        }
    }

    public function update_duplicate_email() {
        $this->load->model('customer/customer_model');
        $input = $this->input->post('value1');
        $id = $this->input->post('value2');
        $validation = $this->customer_model->update_duplicate_email($input, $id);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Email already Exist";
        }
    }

    public function add_state() {
        $this->load->model('customer/customer_model');
        $input = $this->input->get();
        $insert_id = $this->customer_model->insert_state($input);
        echo $insert_id;
    }

    function ajaxList() {
        $this->load->model('customer/customer_model');
        $list = $this->customer_model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $cust_data) {
            if ($this->user_auth->is_action_allowed('masters', 'customer', 'edit')) {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light" href="' . base_url() . 'customer/edit_customer/' . $cust_data->id . '" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-pencil"></span></a>';
            } else {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-pencil"></span></a>';
            }
            if ($this->user_auth->is_action_allowed('masters', 'customer', 'delete')) {
                $delete_row = '<a onclick="delete_customer(' . $cust_data->id . ')" class="btn btn-danger btn-mini waves-effect waves-light delete_row" delete_id="test3_' . $cust_data->id . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><span class="fa fa-trash" style="color: white;"></span></a>';
            } else {
                $delete_row = '<a  class="btn btn-danger btn-mini waves-effect waves-light delete_row alerts" delete_id="test3_' . $cust_data->id . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><span class="fa fa-trash" style="color: white;"></span></a>';
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = 'CUST_ID_' . $cust_data->id;
            $row[] = $cust_data->store_name;
            $row[] = $cust_data->name;
            $row[] = $cust_data->mobil_number;
            $row[] = $cust_data->city;
            $row[] = $cust_data->tin;
            $row[] = $cust_data->email_id;
            $row[] = $cust_data->staff_name;

            $row[] = $edit_row . '&nbsp;&nbsp;' . $delete_row;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->customer_model->count_all(),
            "recordsFiltered" => $this->customer_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    function is_mobile_number_available() {
        $this->load->model('customer/customer_model');
        $mobile = $this->input->post('mobile');
        $id = $this->input->post('id');
        $result = $this->customer_model->is_mobile_number_available($mobile, $id);
        if (!empty($result[0]['id'])) {
            echo 'yes';
        } else {
            echo 'no';
        }
    }

    public function check_duplicate_mobile_number() {
        $this->load->model('customer/customer_model');
        $input = $this->input->post();
        $validation = $this->customer_model->check_duplicate_mobile_num($input);
        if ($validation) {
            echo "Mobile Number Already Exist";
        }
    }

    public function check_duplicate_email() {
        $this->load->model('customer/customer_model');
        $input = $this->input->post();
        $validation = $this->customer_model->check_duplicate_email($input);
        if ($validation) {
            echo "Email Already Exist";
        }
    }

    public function add_customers() {
        $this->load->model('customer/customer_model');
        $input_data = array(
            'store_name' => $this->input->post('cus_store'),
            'address1' => $this->input->post('cus_address'),
            'mobil_number' => $this->input->post('cus_num'),
            'mobile_number_2' => $this->input->post('cus_num_2'),
            'email_id' => $this->input->post('cus_email'),
            'name' => $this->input->post('cus_name'),
            'state_id' => '31',
        );
        $id = $this->customer_model->insert_customer_data($input_data);

        echo $id;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
