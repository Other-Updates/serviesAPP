<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Agent extends MX_Controller {

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
            'agent/index' => array('add', 'edit', 'delete', 'view'),
            'agent/insert_agent' => array('add'),
            'agent/edit_agent' => array('edit'),
            'agent/update_agent' => array('edit'),
            'agent/delete_agent' => array('delete'),
            'agent/add_duplicate_email' => array('add', 'edit'),
            'agent/update_duplicate_email' => array('add', 'edit'),
            'agent/pay' => 'no_restriction'
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('users/user_model');
        $this->load->model('admin/admin_model');
    }

    public function index() {
        $this->load->model('agent/agent_model');
        $data["agent"] = $this->agent_model->get_agent();
        $data['all_state'] = $this->agent_model->state();
        $data['user'] = $user = $this->user_model->get_user_role();
        $this->template->write_view('content', 'agent/index', $data);
        $this->template->render();
    }

    public function insert_agent() {
        $this->load->model('agent/agent_model');
        $input_data = array('name' => $this->input->post('name'), 'address1' => $this->input->post('address1'), 'role' => $this->input->post('role'),
            'address2' => $this->input->post('address2'), 'city' => $this->input->post('city'),
            'pincode' => $this->input->post('pin'), 'mobil_number' => $this->input->post('number'), 'email_id' => $this->input->post('mail'),
            'bank_name' => $this->input->POST('bank'), 'bank_branch' => $this->input->POST('branch'), 'account_num' => $this->input->POST('acnum'),
            'ifsc' => $this->input->post('ifsc'), 'password' => md5($this->input->POST('password')), 'username' => $this->input->POST('username'));
        $this->agent_model->insert_agent($input_data);
        $data["agent"] = $this->agent_model->get_agent();
        redirect($this->config->item('base_url') . 'agent/index', $data);
    }

    public function edit_agent($id) {
        $this->load->model('agent/agent_model');
        $data['company_amount'] = $this->admin_model->get_company_amount();
//        $data['credit'] = $this->admin_model->amount_credit();
//        $data['debit'] = $this->admin_model->amount_debit();
//        $data['amount'] = $data['debit'][0]['debit']-$data['credit'][0]['credit'];
        $data['cash_credit'] = $this->admin_model->get_agent_cash($id);
        $data['cash_debit'] = $this->admin_model->get_agent_debit($id);
        $data['amount'] = $data['cash_credit'][0]['credit'] - $data['cash_debit'][0]['debit'];
        $data['all_state'] = $this->agent_model->state();
        $data["agent"] = $this->agent_model->get_agent1($id);
        $data['user'] = $user = $this->user_model->get_user_role();
        // echo"<pre>"; print_r($amount); exit;
        //echo"<pre>"; print_r($data); exit;
        $this->template->write_view('content', 'agent/update_agent', $data);
        $this->template->render();
    }

    public function pay($id) {
        $this->input->POST();
        $this->load->model('agent/agent_model');
        $data['cash_credit'] = $this->admin_model->get_agent_cash($id);
        $data['cash_debit'] = $this->admin_model->get_agent_debit($id);
        $data['amount'] = $data['cash_credit'][0]['credit'] - $data['cash_debit'][0]['debit'];
        $this->input->POST();
        $amount = array('recevier_id' => $id, 'bill_amount' => $this->input->post('company_amount'), 'receiver_type' => 'Advance Amount',
            'recevier' => 'agent', 'type' => 'credit');
        $this->load->model('receipt/receipt_model');
        $amount1 = array('recevier_id' => $id, 'bill_amount' => $this->input->post('company_amount'), 'receiver_type' => 'Advance Amount',
            'recevier' => 'company', 'type' => 'debit');
        // echo"<pre>"; print_r($amount); exit;
        $insert_agent_cash1 = $this->receipt_model->insert_agent_amount($amount1);
        $insert_agent_cash = $this->receipt_model->insert_agent_amount($amount);
        // $cash = $this->admin_model->get_cash();
        $company_amount = $this->admin_model->get_company_amount();
        $amount = $company_amount[0]['value'] - $this->input->post('company_amount');
        $this->admin_model->update_company_amount($amount);
    }

    public function update_agent() {
        $this->load->model('agent/agent_model');
        $id = $this->input->POST('id');
        $input = array('name' => $this->input->post('name'), 'address1' => $this->input->post('address1'), 'role' => $this->input->post('role'),
            'address2' => $this->input->post('address2'), 'city' => $this->input->post('city'),
            'pincode' => $this->input->post('pin'), 'mobil_number' => $this->input->post('number'), 'email_id' => $this->input->post('mail'),
            'bank_name' => $this->input->POST('bank'), 'bank_branch' => $this->input->POST('branch'), 'account_num' => $this->input->POST('acnum'),
            'ifsc' => $this->input->post('ifsc'), 'username' => $this->input->POST('username'));

        $pass = $this->input->POST('password');
        if (isset($pass) && !empty($pass))
            $input['password'] = md5($pass);

        $this->agent_model->update_agent($input, $id);
        $data['all_state'] = $this->agent_model->state();
        $data["agent"] = $this->agent_model->get_agent();
        $this->template->write_view('content', 'agent/update_agent', $data);
        redirect($this->config->item('base_url') . 'agent/');
    }

    public function delete_agent() {
        $this->load->model('agent/agent_model');
        $data["agent"] = $this->agent_model->get_agent();
        $id = $this->input->POST('value1');
        $this->agent_model->delete_agent($id);
        redirect($this->config->item('base_url') . 'agent/index', $data);
    }

    public function add_duplicate_email() {
        $this->load->model('agent/agent_model');
        $input = $this->input->get('value1');
        $validation = $this->agent_model->add_duplicate_email($input);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Email Already Exist";
        }
    }

    public function update_duplicate_email() {
        $this->load->model('agent/agent_model');
        $input = $this->input->post('value1');
        $id = $this->input->post('value2');
        $validation = $this->agent_model->update_duplicate_email($input, $id);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Email already Exist";
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
