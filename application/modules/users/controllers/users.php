<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Users extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'masters';
        $access_arr = array(
            'users/index' => array('add', 'edit', 'delete', 'view'),
            'users/insert_user' => array('add'),
            'users/edit_user' => array('edit'),
            'users/update_user' => array('edit'),
            'users/delete_user' => array('delete'),
            'users/add_duplicate_email' => array('add', 'edit'),
            'users/update_duplicate_email' => array('add', 'edit'),
            'users/ajaxList' => 'no_restriction',
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
    }

    public function index() {
        $this->load->model('masters/user_model');
        $this->load->model('master_style/master_model');
        $data["agent"] = $this->user_model->get_user();
        $data['all_state'] = $this->user_model->state();
        $data['user'] = $user = $this->user_model->get_user_role();
        $get_inc_details = $this->master_model->get_increment_details('emp_code');
        $data['emp_code'] = $get_inc_details['increment_code'] . '-' . $get_inc_details['increment_id'];
        $this->template->write_view('content', 'users/index', $data);
        $this->template->render();
    }

    public function insert_user() {
        $this->load->model('users/user_model');
        $this->load->model('master_style/master_model');
        $get_inc_details = $this->master_model->get_increment_details('emp_code');
        $data['emp_code'] = $get_inc_details['increment_code'] . '-' . $get_inc_details['increment_id'];
        if ($this->input->post()) {
            $this->load->helper('text');

            $config['upload_path'] = './attachement/sign';

            $config['allowed_types'] = '*';

            $config['max_size'] = '2000';

            $this->load->library('upload', $config);

            $upload_data['file_name'] = $_FILES;
            if (isset($_FILES) && !empty($_FILES)) {
                $upload_files = $_FILES;
                if ($upload_files['signature'] != '') {
                    $_FILES['signature'] = array(
                        'name' => $upload_files['signature']['name'],
                        'type' => $upload_files['signature']['type'],
                        'tmp_name' => $upload_files['signature']['tmp_name'],
                        'error' => $upload_files['signature']['error'],
                        'size' => '2000'
                    );
                    $this->upload->do_upload('signature');

                    $upload_data = $this->upload->data();

                    $dest = getcwd() . "/attachement/sign/" . $upload_data['file_name'];

                    $src = $this->config->item("base_url") . 'attachement/sign/' . $upload_data['file_name'];
                }
            }
            $increment_details = $this->master_model->get_increment_details('emp_code');
            $input['emp_code'] = $increment_details['increment_code'] . '-' . $increment_details['increment_id'];
            $input_data['signature'] = $upload_data['file_name'];
            $input_data = array('name' => $this->input->post('name'), 'address' => $this->input->post('address1'), 'nick_name' => $this->input->post('nick_name'),
                'mobile_no' => $this->input->post('number'), 'email_id' => $this->input->post('mail'),
                'password' => md5($this->input->POST('pass')), 'username' => $this->input->POST('user_name'), 'role' => $this->input->POST('role'), 'signature' => $upload_data['file_name'], 'emp_code' => $input['emp_code'], 'bank_name' => $this->input->POST('bank'), 'bank_branch' => $this->input->POST('branch'), 'account_num' => $this->input->POST('acnum'), 'ifsc' => $this->input->post('ifsc'), 'id_proof_no' => $this->input->post('id_proof_no'), 'id_proof_type' => $this->input->post('id_proof_type'));
            //echo "<pre>";print_r($input_data);exit;
            $insert_id = $this->user_model->insert_user($input_data);
            if ($insert_id) {
                $this->master_model->update_increment_code('emp_code');
            }
            $insert_id++;
            $data["agent"] = $this->user_model->get_user();
            redirect($this->config->item('base_url') . 'users/index', $data);
        }
    }

    public function edit_user($id) {
        $this->load->model('users/user_model');
        $data['all_state'] = $this->user_model->state();
        $data['user'] = $user = $this->user_model->get_user_role();
        $data["agent"] = $this->user_model->get_user1($id);
        $this->template->write_view('content', 'users/update_user', $data);
        $this->template->render();
    }

    public function update_user() {
        $this->load->model('users/user_model');
        $id = $this->input->POST('id');
        if ($this->input->post()) {
            $this->load->helper('text');

            $config['upload_path'] = './attachement/sign';

            $config['allowed_types'] = '*';

            $config['max_size'] = '2000';

            $this->load->library('upload', $config);


            $input_data = array('name' => $this->input->post('name'), 'address' => $this->input->post('address1'), 'nick_name' => $this->input->post('nick_name'),
                'mobile_no' => $this->input->post('number'), 'email_id' => $this->input->post('mail'), 'username' => $this->input->POST('username'), 'role' => $this->input->POST('role'), 'bank_name' => $this->input->POST('bank'), 'bank_branch' => $this->input->POST('branch'), 'account_num' => $this->input->POST('acnum'), 'ifsc' => $this->input->post('ifsc'), 'id_proof_no' => $this->input->post('id_proof_no'), 'id_proof_type' => $this->input->post('id_proof_type'));

            $pass = $this->input->POST('pass');
            if (isset($pass) && !empty($pass))
                $input_data['password'] = md5($pass);

            $upload_data['file_name'] = $_FILES;
            if (isset($_FILES) && !empty($_FILES)) {
                $upload_files = $_FILES;
                if ($upload_files['signature']['name'] != '') {
                    $_FILES['signature'] = array(
                        'name' => $upload_files['signature']['name'],
                        'type' => $upload_files['signature']['type'],
                        'tmp_name' => $upload_files['signature']['tmp_name'],
                        'error' => $upload_files['signature']['error'],
                        'size' => '2000'
                    );
                    $this->upload->do_upload('signature');

                    $upload_data = $this->upload->data();

                    $dest = getcwd() . "/attachement/sign/" . $upload_data['file_name'];

                    $src = $this->config->item("base_url") . 'attachement/sign/' . $upload_data['file_name'];
                    $input_data['signature'] = $upload_data['file_name'];
                }
            }
            //echo "<pre>";print_r($input_data);exit;
            $this->user_model->update_user($input_data, $id);
            $data['all_state'] = $this->user_model->state();
            $data["agent"] = $this->user_model->get_user();
            $this->template->write_view('content', 'users/update_user', $data);
            redirect($this->config->item('base_url') . 'users/');
        }
    }

    public function delete_user() {
        $this->load->model('users/user_model');
        $data["agent"] = $this->user_model->get_user();
        $id = $this->input->POST('value1');
        $this->user_model->delete_user($id);
        redirect($this->config->item('base_url') . 'users/index', $data);
    }

    public function add_duplicate_email() {
        $this->load->model('users/user_model');
        $input = $this->input->get('value1');
        $validation = $this->user_model->add_duplicate_email($input);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Email Already Exist";
        }
    }

    public function update_duplicate_email() {
        $this->load->model('users/user_model');
        $input = $this->input->post('value1');
        $id = $this->input->post('value2');
        // echo $input; echo $id; exit;
        $validation = $this->user_model->update_duplicate_email($input, $id);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Email already Exist";
        }
    }

    function ajaxList() {
        $this->load->model('masters/user_model');
        $list = $this->user_model->get_userdata();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $user_data) {
            if ($this->user_auth->is_action_allowed('masters', 'users', 'edit')) {
                $edit_row = '<a class="btn btn-round btn-primary btn-mini waves-effect waves-light" href="' . base_url() . 'users/edit_user/' . $user_data->id . '" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-pencil"></span></a>';
            } else {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-pencil"></span></a>';
            }
            if ($this->user_auth->is_action_allowed('masters', 'users', 'delete')) {
                $delete_row = '<a onclick="delete_user(' . $user_data->id . ')" class="btn btn-round btn-danger btn-mini waves-effect waves-light delete_row" delete_id="test3_' . $user_data->id . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><span class="fa fa-trash" style="color: white;"></span></a>';
            } else {
                $delete_row = '<a  class="btn btn-round btn-danger btn-mini waves-effect waves-light delete_row alerts" delete_id="test3_' . $user_data->id . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><span class="fa fa-trash" style="color: white;"></span></a>';
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $user_data->emp_code;
//            $row[] = $user_data->nick_name;
            $row[] = $user_data->username;
            $row[] = $user_data->mobile_no;
            $row[] = $user_data->email_id;
//            $row[] = $user_data->address;
            $row[] = $user_data->user_role;
            $row[] = $edit_row . '&nbsp;&nbsp;' . $delete_row;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->user_model->count_all_users(),
            "recordsFiltered" => $this->user_model->count_filtered_users(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
