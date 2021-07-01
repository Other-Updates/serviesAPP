<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email extends MX_Controller {

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
            'email/index' => array('add', 'edit', 'delete', 'view'),
            'email/insert_email' => 'no_restriction',
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('email/email_model');
        $this->load->model('admin/admin_model');
    }

    public function index() {
        $this->load->model('email/email_model');
        $data["emails"] = $this->email_model->get_quotation_emails();
        $this->template->write_view('content', 'email/index', $data);
        $this->template->render();
    }

    public function insert_email() {
        $input = $this->input->post();
        $this->email_model->delete_email();
        if (isset($input['type']) && !empty($input['type'])) {
            $insert_arr = array();
            foreach ($input['type'] as $key => $val) {
                $insert['type'] = $val;
                $insert['label'] = $input['label'][$key];
                $insert['value'] = $input['value'][$key];
                $insert_arr[] = $insert;
            }

            $this->email_model->insert_email($insert_arr);
            /*  $data['company_amount'] = $this->admin_model->get_company_amount();
              $input_comp['receiver_type'] = "Opening Company Amount";
              $input_comp['type'] = "credit";
              $input_comp['recevier'] = "company";
              $input_comp['bill_amount'] = $data['company_amount'][0]['value'];
              $this->load->model('receipt/receipt_model');
              $insert_agent_cash = $this->receipt_model->insert_agent_amount($input_comp); */
        }

        redirect($this->config->item('base_url') . 'email/index');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
