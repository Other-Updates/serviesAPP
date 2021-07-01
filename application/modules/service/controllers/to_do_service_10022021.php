<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class To_do_service extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'services';
        $access_arr = array(
            'to_do_service/index' => array('add', 'edit', 'delete', 'view'),
            'to_do_service/service_ajaxList' => 'no_restriction',
            'to_do_service/service_delete' => 'no_restriction',
            'to_do_service/service_edit' => 'no_restriction',
            'to_do_service/update_service' => 'no_restriction',
            'to_do_service/service_view' => 'no_restriction',
        );
        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
        $this->load->model('service/to_do_service_model');
    }

    public function index() {
        $data['service'] = $this->to_do_service_model->get_all_services();

        $this->template->write_view('content', 'service_index', $data);
        $this->template->render();
    }

    public function service_edit($id) {
        $this->load->model('customer/customer_model');
        $data["staff_name"] = $this->customer_model->get_all_staff_name();
        $data['edit_service'] = $this->to_do_service_model->get_all_services_by_id($id);
        $data['service_images_employee'] = $this->to_do_service_model->get_service_images_by_id($id, "edit");
        $data['service_history'] = $this->to_do_service_model->get_service_history_by_id($id);
        $data['service_images_customer'] = $this->to_do_service_model->get_service_images_by_id($id, "add");
        $this->template->write_view('content', 'service/service_edit', $data);
        $this->template->render();
    }

    public function service_view($id) {

        $data['service'] = $this->to_do_service_model->get_all_cust_services_by_id($id);
        $data['service_images_employee'] = $this->to_do_service_model->get_service_images_by_id($id, "edit");
        $data['service_images_customer'] = $this->to_do_service_model->get_service_images_by_id($id, "add");

        $this->template->write_view('content', 'service/emp_service_view', $data);
        $this->template->render();
    }

    function service_ajaxList() {
        $list = $this->to_do_service_model->get_service_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $val) {
            if ($this->user_auth->is_action_allowed('services', 'to_do_service', 'edit')) {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light" href="' . base_url() . 'service/to_do_service/service_edit/' . $val['id'] . '" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-pencil"></span></a>';
            } else {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-pencil"></span></a>';
            }

            if ($this->user_auth->is_action_allowed('services', 'to_do_service', 'view')) {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light" href="' . base_url() . 'service/to_do_service/service_view/' . $val['id'] . '" data-toggle="tooltip" data-placement="top" title="View"><span class="fa fa-eye"></span></a>';
            } else {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-eye"></span></a>';
            }

            if ($this->user_auth->is_action_allowed('services', 'to_do_service', 'delete')) {
                $delete_row = '<a onclick="delete_service(' . $val['id'] . ')" class="btn btn-danger btn-mini waves-effect waves-light delete_row" delete_id="test3_' . $val['id'] . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><span class="fa fa-trash" style="color: white;"></span></a>';
            } else {
                $delete_row = '<a  class="btn btn-danger btn-mini waves-effect waves-light delete_row alerts" delete_id="test3_' . $val['id'] . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><span class="fa fa-trash" style="color: white;"></span></a>';
            }

            $no++;

            $row = array();
            $row[] = $no;
            $row[] = $val['inv_no'];
            $row[] = $val['ticket_no'];
            $row[] = ($val['description']);
            $row[] = ucfirst($val['warrenty']);
            $row[] = ($val['created_date'] != '') ? date('d-M-Y', strtotime($val['created_date'])) : '-';
            if ($val['status'] == 2) {
                $status = '<span class="label label-danger">Pending</span>';
            } else if($val['status'] == 1) {
                $status = '<span class="label label-success">Completed</span>';
            } else {
                $status = '<span class="label label-warning">In-Progress</span>';
            }
            $row[] = $status;
            $row[] = $edit_row . '&nbsp;&nbsp;' . $view_row . '&nbsp;&nbsp;' . $delete_row;
            ;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->to_do_service_model->count_all_service(),
            "recordsFiltered" => $this->to_do_service_model->count_filtered_service(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    public function service_delete() {

        $id = $this->input->POST('value1');
        $data['service'] = $this->to_do_service_model->get_all_services();
        $del_id = $this->to_do_service_model->delete_service($id);
        redirect($this->config->item('base_url') . 'service/to_do_service', $data);
    }

    public function update_service($id) {
        $input = $this->input->post();

        if ($input['emp_id'] != '') {
            $input['emp_id'] = implode(',', $this->input->post('emp_id'));
        }


        $this->to_do_service_model->updateservice($id, $input);

        if (!empty($_FILES['service_image']['name'][0] != '')) {

            $total = count($_FILES['service_image']['name']);

            if ($total > 0) {

                $this->to_do_service_model->delete_service_images($id);

                for ($i = 0; $i < $total; $i++) {

                    //Get the temp file path
                    $tmpFilePath = $_FILES['service_image']['tmp_name'][$i];

                    //Make sure we have a file path
                    if ($tmpFilePath != "") {
                        $upload_path = 'attachement/service_image/';

                        $filename = $_FILES['service_image']['name'][$i];
                        $profile_image = NULL;
                        $config['upload_path'] = $upload_path;
                        $allowed_types = array('jpg', 'jpeg', 'png');
                        $config['allowed_types'] = implode('|', $allowed_types);
                        $config['max_size'] = '10000';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!empty($_FILES['service_image']['name'][$i])) {
                            $_FILES['upload_service_image'] = array(
                                'name' => $_FILES['service_image']['name'][$i],
                                'type' => $_FILES['service_image']['type'][$i],
                                'tmp_name' => $_FILES['service_image']['tmp_name'][$i],
                                'error' => $_FILES['service_image']['error'][$i],
                                'size' => $_FILES['service_image']['size'][$i]
                            );

                            //print_r($_FILES['upload_service_image']);

                            $random_hash = substr(str_shuffle(time()), 0, 3) . strrev(mt_rand(100000, 999999));
                            $extension = pathinfo($_FILES['service_image']['name'][$i], PATHINFO_EXTENSION);
                            $config['file_name'] = 'PSI_' . $random_hash . '.' . $extension;
                            $this->upload->initialize($config);

                            if (!$this->upload->do_upload('upload_service_image')) {
                                $error = array('error' => $this->upload->display_errors());
                            } else {
                                $data = array('upload_data' => $this->upload->data());
                            }
                        }
                        if ($data) {
                            $insert_image['service_id'] = $id;
                            $insert_image['img_path'] = base_url() . 'attachement/service_image/' . $config['file_name'];
                            $insert_image['created_date'] = date('Y-m-d H:i:s');
                            $insert_image['type'] = "edit";
                            $insert_document = $this->to_do_service_model->insert_service_product_image($insert_image);
                            $supporting_doc_status[$i] = "success";
                        } else {
                            $supporting_doc_status[$i] = "failed";
                        }
                    }
                }
            }
        }

        redirect($this->config->item('base_url') . 'service/to_do_service');
    }

}

?>
