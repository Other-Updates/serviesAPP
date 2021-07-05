<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends MX_Controller {

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
//        $this->load->helper('form');
//        $this->load->helper('url');
//        $this->load->library('session');
//        $this->load->library('user_auth');
//        $this->load->library('email');
//        $this->load->database();
//        $this->load->library('form_validation');
    }

    public function index() {
        $this->load->model('admin/admin_model');

        $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
        $data["admin"] = $this->admin_model->get_admin($user_info[0]['role'], $user_info[0]['id']);
        if ($this->input->post()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            if ($this->user_auth->login($username, $password)) {

                //$data = $this->admin_model->login($this->input->post());
                //if (isset($data) && !empty($data)) {
                //$this->session->set_userdata('user_info', $data);
                //$session_array = array('user_info' => $data);
                //$this->user_auth->store_in_session($session_array);

                $user_info = $this->user_auth->get_from_session('user_info');

                //Insert Uesr Status Logs
                $this->admin_model->users_logs_updates('insert', 1, $user_info[0]['id']);


                redirect($this->config->item('base_url') .'service/to_do_service');
            } else
                redirect($this->config->item('base_url') . 'admin?login=fail');
        }
        if (empty($this->user_auth->get_user_id())) {
            $this->template->set_master_template('../../themes/' . $this->config->item("active_template") . '/template_login.php');
            $this->template->write_view('content', 'admin/index');
            $this->template->render();
        } else {
            $data['report'] = $this->admin_model->get_dashboard_report();
            //get pending invoice amount
            $invoice = $this->admin_model->pending_inv_balance($search_data);

            foreach ($invoice as $key => $sr_data) {
                $cgst = 0;
                $sgst = 0;
                $over_all_net_total = $over_all_net = 0;
                if (isset($sr_data['po_details']) && !empty($sr_data['po_details'])) {
                    foreach ($sr_data['po_details'] as $vals) {

                        $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['current_quantity']);

                        $gst_type = $sr_data['state_id'];
                        if ($gst_type != '') {
                            if ($gst_type == 31) {

                                $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * $vals['current_quantity']);
                            } else {
                                $sgst1 = ($vals['igst'] / 100 ) * ($vals['per_cost'] * $vals['current_quantity']);
                            }
                        }
                        $cgst += $cgst1;
                        $sgst += $sgst1;

                        $qty = $vals['current_quantity'];
                        $per_cost = $vals['per_cost'];
                        $add_amount = $vals['add_amount'];
                        $gst_val = $vals['tax'];
                        $cgst_val = $vals['gst'];
                        if ($sr_data['is_gst'] == 1) {
                            $net_total = $qty * $per_cost;
                            $final_sub__total = $qty * $per_cost + (($qty * $per_cost) * $gst_val / 100) + (($qty * $per_cost) * $cgst_val / 100);
                        } else {
                            $net_total = $qty * ($per_cost + $add_amount);
                            $final_sub__total = $qty * ($per_cost + $add_amount);
                        }

                        $over_all_net += $final_sub__total;
                        $over_all_net_total = $over_all_net + $sr_data['tax'];
                    }
                }
                $final_net_total = $over_all_net_total;
                $invoice[$key]['balance_amount'] = number_format(($final_net_total - ($sr_data['receipt_bill'][0]['receipt_paid'] + $sr_data['advance'] + $sr_data['receipt_bill'][0]['receipt_discount']) > 0) ? $sr_data['net_total'] - ($sr_data['receipt_bill'][0]['receipt_paid'] + $sr_data['advance'] + $sr_data['receipt_bill'][0]['receipt_discount']) : '0.00', 2, '.', ',');
            }
            $data['pending_invoice'] = $invoice;
            $data['service'] = $this->admin_model->get_Servicedata();
            $get_pending_inv = $this->admin_model->get_pending_invdata();
            $get_pending_invdatas = array_map(function ($get_pending_inv) {
                return $get_pending_inv['payment'];
            }, ($get_pending_inv));

            $data['get_pending_inv'] = implode(',', $get_pending_invdatas);

            $this->template->write_view('content', 'admin/dashboard', $data);
            $this->template->render();
        }
        /* if (empty($this->session->userdata['user_info'][0]['id'])) {
          $this->template->set_master_template('../../themes/' . $this->config->item("active_template") . '/template_login.php');
          $this->template->write_view('content', 'admin/index');
          $this->template->render();
          } else {

          //echo '<pre>';
          $data['report'] = $this->admin_model->get_dashboard_report();

          // print_r($amount);
          //exit;
          $this->template->write_view('content', 'admin/dashboard', $data);
          $this->template->render();
          } */

        /* $this->load->model('admin/admin_model');
          $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
          $data['admin'] = $this->admin_model->get_admin($user_info[0]['role'], $user_info[0]['id']);
          if ($this->input->post()) {
          $username = $this->input->post('username');
          $password = $this->input->post('password');
          if ($this->user_auth->login($username, $password)) {
          $login_data = $this->admin_model->login($this->input->post());
          $session_array = array('user_info' => $login_data);
          $this->user_auth->store_in_session($session_array);
          redirect($this->config->item('base_url') . 'admin/dashboard');
          } else
          redirect($this->config->item('base_url') . 'admin?login=fail');
          }
          if (empty($this->user_auth->get_user_id())) {
          $this->template->set_master_template('../../themes/' . $this->config->item("active_template") . '/template_login.php');
          $this->template->write_view('content', 'admin/index');
          $this->template->render();
          } else {
          $data['report'] = $this->admin_model->get_dashboard_report();
          $this->template->write_view('content', 'admin/dashboard', $data);
          $this->template->render();
          } */
    }

    public function dashboard() {
        $this->load->model('admin/admin_model');
        $date = '';
        if (date('m') > 3) {
            $from_date = date('Y') . '-04-01';
            $to_date = (date('Y') + 1) . '-03-31';
        } else {
            $from_date = (date('Y') - 1) . '-04-01';
            $to_date = date('Y') . '-03-31';
        }
        $data['service'] = $this->admin_model->get_Servicedata();
        $get_pending_inv = $this->admin_model->get_pending_invdata();
        $get_pending_invdatas = array_map(function ($get_pending_inv) {
            return $get_pending_inv['payment'];
        }, ($get_pending_inv));
        $data['get_pending_inv'] = implode(',', $get_pending_invdatas);
        $data['report'] = $this->admin_model->get_dashboard_report();
        $data['cash_credit'] = $this->admin_model->get_agent_cash($this->user_auth->get_from_session('user_id'));
        $data['cash_debit'] = $this->admin_model->get_agent_debit($this->user_auth->get_from_session('user_id'));
        // $data['cash_credit'] = $this->admin_model->get_agent_cash($this->session->userdata['user_info'][0]['id']);
        //$data['cash_debit'] = $this->admin_model->get_agent_debit($this->session->userdata['user_info'][0]['id']);
        $data['amount'] = $data['cash_credit'][0]['credit'] - $data['cash_debit'][0]['debit'];
        $data['user_activation'] = $this->admin_model->get_user_activation_list();
//get pending invoice amount
        $invoice = $this->admin_model->pending_inv_balance($search_data);
        foreach ($invoice as $key => $sr_data) {
            $cgst = 0;
            $sgst = 0;
            $over_all_net_total = $over_all_net = 0;
            if (isset($sr_data['po_details']) && !empty($sr_data['po_details'])) {
                foreach ($sr_data['po_details'] as $vals) {

                    $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['current_quantity']);

                    $gst_type = $sr_data['state_id'];
                    if ($gst_type != '') {
                        if ($gst_type == 31) {

                            $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * $vals['current_quantity']);
                        } else {
                            $sgst1 = ($vals['igst'] / 100 ) * ($vals['per_cost'] * $vals['current_quantity']);
                        }
                    }
                    $cgst += $cgst1;
                    $sgst += $sgst1;

                    $qty = $vals['current_quantity'];
                    $per_cost = $vals['per_cost'];
                    $add_amount = $vals['add_amount'];
                    $gst_val = $vals['tax'];
                    $cgst_val = $vals['gst'];
                    if ($sr_data['is_gst'] == 1) {
                        $net_total = $qty * $per_cost;
                        $final_sub__total = $qty * $per_cost + (($qty * $per_cost) * $gst_val / 100) + (($qty * $per_cost) * $cgst_val / 100);
                    } else {
                        $net_total = $qty * ($per_cost + $add_amount);
                        $final_sub__total = $qty * ($per_cost + $add_amount);
                    }

                    $over_all_net += $final_sub__total;
                    $over_all_net_total = $over_all_net + $sr_data['tax'];
                }
            }
            $final_net_total = $over_all_net_total;
            $invoice[$key]['balance_amount'] = number_format(($final_net_total - ($sr_data['receipt_bill'][0]['receipt_paid'] + $sr_data['advance'] + $sr_data['receipt_bill'][0]['receipt_discount']) > 0) ? $sr_data['net_total'] - ($sr_data['receipt_bill'][0]['receipt_paid'] + $sr_data['advance'] + $sr_data['receipt_bill'][0]['receipt_discount']) : '0.00', 2, '.', ',');
        
        }
        $data['pending_invoice'] = $invoice;
        $this->template->write_view('content', 'admin/dashboard', $data);
        $this->template->render();
    }

    public function example() {
        $this->template->write_view('content', 'admin/example');
        $this->template->render();
    }

    public function logout() {
        $user_info = $this->user_auth->get_from_session('user_info');
        //Insert Uesr Status Logs
        $this->admin_model->users_logs_updates('update', 1, $user_info[0]['id']);

        $this->session->sess_destroy();

        redirect($this->config->item('base_url') . 'admin/');
    }

    public function update_profile() {
        $this->load->model('admin/admin_model');
        if ($this->input->post()) {
            $conpany_details = $this->input->post('company');
            $this->admin_model->insert_company_details($conpany_details);
            $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
            $data["admin"] = $this->admin_model->get_admin($user_info[0]['role'], $user_info[0]['id']);

            $this->load->helper('text');

            $config['upload_path'] = './admin_image/original';

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

                    $dest = getcwd() . "/admin_image/original/" . $upload_data['file_name'];

                    $src = $this->config->item("base_url") . 'admin_image/original/' . $upload_data['file_name'];
                }
            }
            $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
            $id = $user_info[0]['id'];
            $role = $user_info[0]['role'];
            $password = $this->input->post('password');
            $input_data['admin']['admin_image'] = $upload_data['file_name'];
            $input = array();
            $input['username'] = $this->input->post('admin_name');
            if (isset($password) && !empty($password)) {
                $pass = md5($password);
                $input['password'] = $pass;
            }
            if (isset($upload_data['file_name']) && !empty($upload_data['file_name'])) {
                $input['admin_image'] = $upload_data['file_name'];
            }
            if (isset($input) && !empty($input))
                $this->admin_model->update_profile($input, $role, $id);
            redirect($this->config->item('base_url') . 'admin/dashboard');
        }
        $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
        $data["admin"] = $this->admin_model->get_admin($user_info[0]['role'], $user_info[0]['id']);
        //  echo"<pre>"; print_r($data); exit;
        $data['company_details'] = $this->admin_model->get_company_details();
        $this->template->write_view('content', 'admin/update_profile', $data);
        $this->template->render();
    }

    public function back_up() {
        $this->load->view('admin/back_up');
        exit;
    }

    function get_payment_data() {
        $year = $this->input->post('year');
        $frommonth = $this->input->post('frommonth');
        $toyear = $this->input->post('toyear');
        $tomonth = $this->input->post('tomonth');
        $data = $this->admin_model->getPayementdata($year,$frommonth, $toyear, $tomonth);

        print_r(json_encode($data, true));
    }

    function get_conversion_data() {
        $year = $this->input->post('year');
        $data = $this->admin_model->get_quo_conversion_data($year);
        print_r(json_encode($data, true));
    }

    function get_profit_loss_data() {
        $year = $this->input->post('year');
        $data = $this->admin_model->get_all_profit_amount($year);
        print_r(json_encode($data, true));
    }

    function get_service_details() {
        $year = $this->input->post('year');
        $frommonth = $this->input->post('frommonth');
        $toyear = $this->input->post('toyear');
        $tomonth = $this->input->post('tomonth');
        $data['service'] = $this->getServicedata($year);

        print_r(json_encode($data, true));
    }

    function pettyCashpieChart() {
        $data = $this->admin_model->getpettyCash_pieChart();
        print_r(json_encode($data, true));
    }

    function get_leads_quo_pc_details() {
        $year = $this->input->post('year');
        $data['laeds_quo_pc'] = $this->admin_model->get_leads_quo_pc_datas($year);

        print_r(json_encode($data, true));
    }

    function general_info() {

        $this->template->write_view('content', 'admin/general_info');
        $this->template->render();
    }

}
