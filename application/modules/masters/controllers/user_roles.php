<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_roles extends MX_Controller {

    function __construct() {
        parent::__construct();
        //if (!$this->user_auth->is_logged_in()) {
        //redirect($this->config->item('base_url') . 'admin');
        // }
        $main_module = 'masters';
        $access_arr = array(
            'user_roles/index' => array('add', 'edit', 'delete', 'view'),
            'user_roles/add' => array('add'),
            'user_roles/user_permissions' => array('add', 'edit'),
            'user_roles/user_role_edit' => array('add', 'edit'),
            'user_roles/user_role_delete' => array('add', 'delete'),
            'user_roles/insert_user_role_permissions' => 'no_restriction',
            'user_roles/add_duplicate_user' => array('add', 'edit'),
            'user_roles/update_duplicate_user' => array('add', 'edit')
        );

        //if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
        // redirect($this->config->item('base_url'));
        //}
        $this->load->model('masters/user_role_model');
        $this->load->model('masters/user_module_model');
        $this->load->model('masters/user_section_model');

        /* $this->load->helper('form');
          $this->load->helper('url');
          $this->load->library('session');
          $this->load->library('email');
          $this->load->database();
          $this->load->library('form_validation'); */
    }

    public function index() {
        $data['user_roles'] = $this->user_role_model->get_all_user_roles();
        $this->template->write_view('content', 'masters/user_roles', $data);
        $this->template->render();
    }

    public function add() {
        $input = $this->input->post('user_role');
        if ($input['user_role'] != '') {
            $this->user_role_model->insert_user_role($input);
            $data['user_roles'] = $this->user_role_model->get_all_user_roles();
            redirect($this->config->item('base_url') . 'masters/user_roles');
        } else {
            $data['user_roles'] = $this->user_role_model->get_all_user_roles();
            $this->template->write_view('content', 'masters/user_roles', $data);
            $this->template->render();
        }
    }

    public function user_role_edit($id) {
        $input = $this->input->post();
        if (!empty($input)) {
            $this->user_role_model->update_user_role($input, $id);
            redirect($this->config->item('base_url') . 'masters/user_roles');
        }
        $data['role'] = $this->user_role_model->get_user_role_by_id($id);
        $this->template->write_view('content', 'masters/update_user_role', $data);
        $this->template->render();
    }

    public function user_permissions($role) {
        $data = array();
        $data['title'] = 'User Roles - Permissions';

        if ($this->input->post('permissions', TRUE)) {
            $permissions = $this->input->post('permissions');
            $grand_all = $this->input->post('grand_all');
            $grand_all = !empty($grand_all) ? $grand_all : 0;
            //echo '<pre>'; print_r($this->input->post()); exit;
            $user_role = array('grand_all' => $grand_all);
            $this->user_role_model->update_user_role($user_role, $role);
            if (!empty($permissions)) {
                $this->user_role_model->delete_user_permission_by_role($role);
                foreach ($permissions as $module_id => $sections) {
                    if (!empty($sections)) {
                        foreach ($sections as $section_id => $item) {
                            $permission_arr = array(
                                'user_role_id' => $role,
                                'module_id' => $module_id,
                                'section_id' => $section_id,
                                'acc_all' => !empty($item['acc_all']) ? 1 : 0,
                                'acc_view' => !empty($item['acc_view']) ? 1 : 0,
                                'acc_add' => !empty($item['acc_add']) ? 1 : 0,
                                'acc_edit' => !empty($item['acc_edit']) ? 1 : 0,
                                'acc_delete' => !empty($item['acc_delete']) ? 1 : 0,
                                'created_date' => date('Y-m-d H:i:s')
                            );
                            $this->user_role_model->insert_user_permission($permission_arr);
                        }
                    }
                }
            }
            $this->session->set_flashdata('flashSuccess', 'User Role Permissions successfully updated!');
            redirect($this->config->item('base_url') . 'masters/user_roles');
        }

        $data['user_role_id'] = $role;
        $data['user_role'] = $this->user_role_model->get_user_role_by_id($role);
        $data['user_sections'] = $this->user_section_model->get_all_user_sections_with_modules();
        $user_permissions = $this->user_role_model->get_user_permissions_by_role($role);
        $user_permissions_arr = array();
        if (!empty($user_permissions)) {
            foreach ($user_permissions as $key => $value) {
                $user_permissions_arr[$value['module_id']][$value['section_id']] = array('acc_all' => $value['acc_all'], 'acc_view' => $value['acc_view'], 'acc_add' => $value['acc_add'], 'acc_edit' => $value['acc_edit'], 'acc_delete' => $value['acc_delete']);
            }
        }
        $data['user_permissions'] = $user_permissions_arr;
        $this->template->write_view('content', 'masters/user_permissions', $data);
        $this->template->render();
    }

    public function insert_user_role_permissions() {
        $this->user_module_model->insert_all_user_modules();
        $this->user_section_model->insert_all_user_sections();
    }

    public function add_duplicate_user() {

        $input = $this->input->get('value1');
        $validation = $this->user_role_model->add_duplicate_user($input);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Role Already Exist";
        }
    }

    public function update_duplicate_user() {

        $input = $this->input->post('value1');
        $id = $this->input->post('value2');
//        echo $input;
//        echo $id;
//        exit;
        $validation = $this->user_role_model->update_duplicate_user($input, $id);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Role already Exist";
        }
    }

    function delete_user_role() {
        $data = array('is_deleted' => 1);
        $id = $this->input->post('id');

        $delete = $this->user_role_model->delete_user_role($id, $data);
        if ($delete == 1) {
            redirect($this->config->item('base_url') . 'masters/user_roles');
            echo '1';
            exit;
        } else {
            $this->session->set_flashdata('flashError', 'Operation Failed!');
            echo '0';
            exit;
        }
    }

}
