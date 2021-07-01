<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Stock extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'stock';
        $access_arr = array(
            'stock/index' => array('add', 'edit', 'delete', 'view'),
            'stock/ajaxList' => 'no_restriction',
            'stock/stock_view' => 'no_restriction',
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }


        $this->load->model('stock/stock_model');
        $this->load->model('api/notification_model');
        if (isset($_GET['notification']))
            $this->notification_model->update_notification(array('status' => 1), $_GET['notification']);
    }

    public function index() {
        $datas["stock"] = $po = $this->stock_model->get_all_stock();
        $this->template->write_view('content', 'stock/stock_list', $datas);
        $this->template->render();
    }

    public function ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $list = $this->stock_model->get_datatables($search_data);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $val) {

            if ($this->user_auth->is_action_allowed('stock', 'stock', 'view')) {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light" href="' . base_url() . 'stock/stock_view/' . $val['id'] . '" data-toggle="tooltip" data-placement="top" title="View"><span class="fa fa-eye"></span></a>';
            } else {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-eye"></span></a>';
            }
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $val['categoryName'];
            $row[] = $val['brands'];
            $row[] = $val['model_no'];
            $row[] = $val['product_name'];
            $row[] = $val['quantity'];
            $row[] = $view_row;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->stock_model->count_all(),
            "recordsFiltered" => $this->stock_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    function stock_view($id) {
        $datas["stock"] = $po = $this->stock_model->get_all_stock_by_id($id);

        $this->template->write_view('content', 'stock/stock_view', $datas);
        $this->template->render();
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
