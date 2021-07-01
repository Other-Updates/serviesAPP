<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Advertisement extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'users/login');
        }
        $main_module = 'masters';
        $access_arr = array(
            'advertisement/index' => array('add', 'edit', 'delete', 'view'),
            'advertisement/add' => array('add'),
            'advertisement/edit' => array('edit'),
            'advertisement/delete' => array('delete'),
            'advertisement/is_group_name_available' => 'no_restriction',
            'advertisement/get_region_by_state_id' => 'no_restriction',
            'advertisement/update_status' => 'no_restriction',
            'advertisement/change_status' => 'no_restriction'
        );

        $this->load->model('advertisement/ads_model');
    }

    function index() {
        $data = array();
        $data['title'] = 'Masters - Manage Advertisement';
        $data['ads'] = $this->ads_model->get_all_ads();
        $this->template->write_view('content', 'advertisement/index', $data);
        $this->template->render();
    }

    function change_status() {
        $post_data = $this->input->post();

        if (count($post_data['projects_checkbox']) > 0) {
            $updatestatus = $this->ads_model->update_ads_staus($post_data);
        }
        $this->session->set_flashdata('flashSuccess', 'Status successfully updated!');
        redirect($this->config->item('base_url') . 'advertisement');
    }

    function add() {

        $data = array();
        $data['title'] = 'Masters - Add New Advertisement';
        if ($this->input->post('ads', TRUE)) {
            $ads_data = $this->input->post('ads');
            $input_data = $this->input->post();
            $insert_ads['name'] = $ads_data['ads_name'];
            //insert ads
            $insert_id = $this->ads_model->insert_ads($insert_ads);
            //Add details add
            $total_ads_data = count($input_data['ads_sort_order']);
            for ($i = 0; $i < $total_ads_data; $i++) {
                $add_details['ads_id'] = $insert_id;
                $file_type = $input_data['adds_file_type'][$i];
                $add_details['file_type'] = $file_type;
                $add_details['sort_order'] = $input_data['ads_sort_order'][$i];

                if ($file_type == 1) {
                    $config['upload_path'] = './attachement/advertisements/images/';
                    $file_link = $this->config->item('base_url') . "attachement/advertisements/images/";
                    $allowed_types = array('jpg', 'jpeg', 'png');
                    $config['allowed_types'] = implode('|', $allowed_types);
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    $file_paths = "attachement/advertisements/images/";
                    $_FILES['data'] = array(
                        'name' => $_FILES['ads_data_image']['name'][$i],
                        'type' => $_FILES['ads_data_image']['type'][$i],
                        'tmp_name' => $_FILES['ads_data_image']['tmp_name'][$i],
                        'error' => $_FILES['ads_data_image']['error'][$i],
                        'size' => $_FILES['ads_data_image']['size'][$i]
                    );
                    $random_hash = substr(str_shuffle(time()), 0, 3) . strrev(mt_rand(100000, 999999));
                    $extension = pathinfo($_FILES['data']['name'], PATHINFO_EXTENSION);
                    $config['file_name'] = 'ADD' . $random_hash . '.' . $extension;
                    $this->upload->initialize($config);
                    $this->upload->do_upload('data');
                    $upload_data = $this->upload->data();
                    $add_details['ads_data'] = $upload_data['file_name'];
                    $add_details['ads_data_path'] = $file_paths;
                    $add_details['ads_data_link'] = $file_link . "" . $upload_data['file_name'];
                } else {
                    $add_details['ads_data'] = $input_data['ads_data'][$i];
                    $add_details['ads_data_link'] = null;
                    $add_details['ads_data_path'] = null;
                }

                $this->ads_model->insert_add_details($add_details);
            }
            if ($insert_id) {
                $this->session->set_flashdata('flashSuccess', 'New Ads successfully added!');
                redirect($this->config->item('base_url') . 'advertisement');
            }
        }

        $this->template->write_view('content', 'advertisement/add_ads', $data);
        $this->template->render();
    }

    function compareDeepValue($val1, $val2) {
        return strcmp($val1['value'], $val2['value']);
    }

    function edit($id) {
        $data = array();
        $data['title'] = 'Masters - Add New Advertisement';
        if ($this->input->post('ads', TRUE)) {
            $ads_data = $this->input->post('ads');
            $input_data = $this->input->post();

            $insert_ads['name'] = $ads_data['ads_name'];
            //update ads
            $this->ads_model->update_ads($insert_ads, $id);
            //Add details add
            $total_ads_data = count($input_data['ads_delete']);
            for ($i = 0; $i < $total_ads_data; $i++) {
                $add_details['ads_id'] = $id;
                $file_type = $input_data['adds_file_type'][$i];
                $add_details['file_type'] = $file_type;
                $add_details['sort_order'] = $input_data['ads_sort_order'][$i];
                //Delete data
                if ($input_data['ads_delete'][$i]['is_delete'] == 1) {
                    $this->ads_model->delete_ads_details_by_detail_id($input_data['ads_remove_id'][$i]['is_delete']);
                } else {
                    if ($file_type == 1) {
                        if ($_FILES['ads_data_image']['name'][$i] != '') {
                            $config['upload_path'] = './attachement/advertisements/images/';
                            $file_link = $this->config->item('base_url') . "attachement/advertisements/images/";
                            $allowed_types = array('jpg', 'jpeg', 'png');
                            $config['allowed_types'] = implode('|', $allowed_types);
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            $file_paths = "attachement/advertisements/images/";
                            $_FILES['data'] = array(
                                'name' => $_FILES['ads_data_image']['name'][$i],
                                'type' => $_FILES['ads_data_image']['type'][$i],
                                'tmp_name' => $_FILES['ads_data_image']['tmp_name'][$i],
                                'error' => $_FILES['ads_data_image']['error'][$i],
                                'size' => $_FILES['ads_data_image']['size'][$i]
                            );
                            $random_hash = substr(str_shuffle(time()), 0, 3) . strrev(mt_rand(100000, 999999));
                            $extension = pathinfo($_FILES['data']['name'], PATHINFO_EXTENSION);
                            $config['file_name'] = 'ADD' . $random_hash . '.' . $extension;
                            $this->upload->initialize($config);
                            $this->upload->do_upload('data');
                            $upload_data = $this->upload->data();
                            $add_details['ads_data'] = $upload_data['file_name'];
                            $add_details['ads_data_path'] = $file_paths;
                            $add_details['ads_data_link'] = $file_link . "" . $upload_data['file_name'];
                        } else {
                            unset($add_details['ads_data']);
                            unset($add_details['ads_data_link']);
                            unset($add_details['ads_data_path']);
                        }
                    } elseif ($file_type == 3) {
                        $add_details['ads_data'] = $input_data['ads_data'][$i];
                        $add_details['ads_data_link'] = null;
                        $add_details['ads_data_path'] = null;
                    }

                    //update ads data
                    if ($input_data['ads_delete'][$i]['is_delete'] == 0 && $input_data['ads_remove_id'][$i]['is_delete'] != '') {
                        $this->ads_model->update_ads_details_by_detail_id($add_details, $input_data['ads_remove_id'][$i]['is_delete']);
                    }
                    if ($input_data['ads_delete'][$i]['is_delete'] == 0 && $input_data['ads_remove_id'][$i]['is_delete'] == '') {
                        $this->ads_model->insert_add_details($add_details);
                    }
                }
            }

            if ($id) {
                $this->session->set_flashdata('flashSuccess', 'Ads successfully updated!');
                redirect($this->config->item('base_url') . 'advertisement');
            }
        }
        $data['ads_details'] = $this->ads_model->get_ads_by_id($id);
        $data['ads_content_details'] = $this->ads_model->get_ads_content_by_id($id);
        $this->template->write_view('content', 'advertisement/update_ads', $data);
        $this->template->render();
    }

    function delete($id) {
        $data = array('is_deleted' => 1);
        $id = $this->input->POST('value1');

        $delete = $this->ads_model->delete_ads($id, $data);
        if ($delete == 1) {
            $this->session->set_flashdata('flashSuccess', 'Ads successfully deleted!');
            echo '1';
            exit;
        } else {
            $this->session->set_flashdata('flashError', 'Operation Failed!');
            echo '0';
            exit;
        }
    }

    public function update_status() {
        $post_data = $this->input->post();
        if (count($post_data['ads_checkbox']) > 0) {
            $updatestatus = $this->ads_model->update_ads_staus($post_data);
        }
        $this->session->set_flashdata('flashSuccess', 'Status successfully updated!');
        redirect($this->config->item('base_url') . 'advertisement');
    }

    public function addRow() {
        $data = array();
        echo $this->load->view('advertisement/add_row', $data, TRUE);
        exit;
    }

}
