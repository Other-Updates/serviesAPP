<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_links extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'users/login');
        }
        $main_module = 'masters';
        $access_arr = array(
            'manage_links/index' => array('add', 'edit', 'delete', 'view'),
            'manage_links/add' => array('add'),
            'manage_links/edit' => array('edit'),
            'manage_links/delete' => array('delete'),
            'manage_links/change_status' => 'no_restriction'
        );

        $this->load->model('manage_links/links_model');
    }

    function index() {

        $data = array();
        $data['links'] = $this->links_model->get_all_links();

        $this->template->write_view('content', 'manage_links/index', $data);
        $this->template->render();
    }

    function add() {
        if ($this->input->post()) {
            $input = $this->input->post();
            $insert_id = $this->links_model->insert_links($input['link']);
            if (isset($insert_id) && !empty($insert_id)) {
                $input = $this->input->post();
                if (isset($input['link_name']) && !empty($input['link_name'])) {
                    $insert_arrs = array();
                    foreach ($input['link_name'] as $key => $val) {
                        $inserts['link_id'] = $insert_id;
                        $inserts['link_data'] = $val;
                        $inserts['description'] = $input['description'][$key];
                        $insert_arrs[] = $inserts;
                    }
                    $this->links_model->insert_link_datas($insert_arrs);
                }
            }
            redirect($this->config->item('base_url') . 'manage_links');
        }
    }

    function edit($id) {
        $data = array();

        if ($this->input->post()) {
            $input = $this->input->post();
            $input['link']['updated_date'] = date('Y-m-d H:i:s');
            $this->links_model->update_links($input['link'], $id);
            if (isset($input['link_name']) && !empty($input['link_name'])) {
                $insert_arrs = array();
                foreach ($input['link_name'] as $key => $val) {
                    $inserts['link_id'] = $id;
                    $inserts['link_data'] = $val;
                    $inserts['description'] = $input['description'][$key];
                    $insert_arrs[] = $inserts;
                }
                $this->links_model->delete_link_datas_byid($id);
                $this->links_model->insert_link_datas($insert_arrs);
            }
            redirect($this->config->item('base_url') . 'manage_links');
        }

        $data['links_details'] = $this->links_model->get_links_by_id($id);
        $this->template->write_view('content', 'manage_links/update_links', $data);
        $this->template->render();
    }

    function delete($id) {
        $data = array('is_deleted' => 1);
        $id = $this->input->POST('value1');

        $delete = $this->links_model->delete_links($id, $data);
        if ($delete == 1) {
            $this->session->set_flashdata('flashSuccess', 'Link successfully deleted!');
            echo '1';
            exit;
        } else {
            $this->session->set_flashdata('flashError', 'Operation Failed!');
            echo '0';
            exit;
        }
    }

    function change_status() {
        $post_data = $this->input->post();

        if (count($post_data['projects_checkbox']) > 0) {
            $updatestatus = $this->links_model->update_links_staus($post_data);
        }
        $this->session->set_flashdata('flashSuccess', 'Status successfully updated!');
        redirect($this->config->item('base_url') . 'manage_links');
    }

}
