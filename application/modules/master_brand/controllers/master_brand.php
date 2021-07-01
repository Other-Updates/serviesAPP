<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class master_brand extends MX_Controller {

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
            'master_brand/index' => array('add', 'edit', 'delete', 'view'),
            'master_brand/insert_brand' => array('add'),
            'master_brand/update_brand' => array('edit'),
            'master_brand/delete_master_brand' => array('delete'),
            'master_brand/add_duplicate_brandname' => array('add', 'edit'),
            'master_brand/update_duplicate_brandname' => array('add', 'edit'),
            'master_brand/ajaxList' => 'no_restriction',
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
    }

    public function index() {
        $this->load->model('master_brand/master_brand_model');
        $data["brand"] = $this->master_brand_model->get_brand();
        $this->template->write_view('content', 'master_brand/index', $data);
        $this->template->render();
    }

    public function insert_brand() {
        $this->load->model('master_brand/master_brand_model');
        $input = array('brands' => $this->input->post('brands'));
        $this->master_brand_model->insert_brand($input);
        $data["brand"] = $this->master_brand_model->get_brand();
        redirect($this->config->item('base_url') . 'master_brand/index', $data);
    }

    public function update_brand() {
        $this->load->model('master_brand/master_brand_model');
        $id = $this->input->post('value1');
        $input = array('brands' => $this->input->post('value2'));
        $this->master_brand_model->update_brand($input, $id);
        $data["brand"] = $this->master_brand_model->get_brand();
        redirect($this->config->item('base_url') . 'master_brand/index', $input);
    }

    public function delete_master_brand() {
        $this->load->model('master_brand/master_brand_model');
        $id = $this->input->get('value1'); {
            $this->master_brand_model->delete_master_brand($id);
            $data["brand"] = $this->master_brand_model->get_brand();
            redirect($this->config->item('base_url') . 'master_brand/index', $input);
        }
    }

    public function add_duplicate_brandname() {
        $this->load->model('master_brand/master_brand_model');
        $input = $this->input->post('value1');
        $validation = $this->master_brand_model->add_duplicate_brandname($input);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo"Brand Name Already Exist";
        }
    }

    public function update_duplicate_brandname() {
        $this->load->model('master_brand/master_brand_model');
        $input = $this->input->get('value1');
        $id = $this->input->get('value2');
        $validation = $this->master_brand_model->update_duplicate_brandname($input, $id);

        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Brand Name Already Exist";
        }
    }

    function ajaxList() {
        $this->load->model('master_brand/master_brand_model');
        $list = $this->master_brand_model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $brand_data) {
            if ($this->user_auth->is_action_allowed('masters', 'master_brand', 'edit')) {
                $edit_row = '<a onclick="edit_brand(' . $brand_data->id . ')" class="btn btn-primary btn-mini waves-effect waves-light" name="edit"  data-toggle="modal"  title="Edit"><span class="fa fa-pencil" style="color: white;"></span></a>';
            } else {
                $edit_row = '<a class="btn btn-primary btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-pencil"></span></a>';
            }
            if ($this->user_auth->is_action_allowed('masters', 'master_brand', 'delete')) {
                $delete_row = '<a onclick="delete_brand(' . $brand_data->id . ')" class="btn btn-danger btn-mini waves-effect waves-light delete_row" delete_id="test3_' . $brand_data->id . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><span class="fa fa-trash" style="color: white;"></span></a>';
            } else {
                $delete_row = '<a  class="btn btn-danger btn-mini waves-effect waves-light delete_row alerts" delete_id="test3_' . $brand_data->id . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><span class="fa fa-trash" style="color: white;"></span></a>';
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $brand_data->brands;
            $row[] = $edit_row . '&nbsp;&nbsp;' . $delete_row;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->master_brand_model->count_all(),
            "recordsFiltered" => $this->master_brand_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

}
