<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Death_stock extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'stock';
        $access_arr = array(
            'death_stock/index' => array('add', 'edit', 'delete', 'view'),
			'death_stock/add' => array('add'),
            'death_stock/ajaxList' => 'no_restriction',
            'death_stock/validate_quantity' => 'no_restriction',
            'death_stock/stock_view' => 'no_restriction',
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }


        $this->load->model('stock/death_stock_model');
        $this->load->model('api/notification_model');
        if (isset($_GET['notification']))
            $this->notification_model->update_notification(array('status' => 1), $_GET['notification']);
    }

    public function index() {
        
        $this->template->write_view('content', 'stock/death_stock_list', $datas);
        $this->template->render();
    }
	
    function add() {
        $data = array();
        if ($this->input->post()) {
            $input = $this->input->post('stock');
            $input['created_date'] = date('Y-m-d', strtotime($input['created_date']));
			$insert = $this->death_stock_model->insert_death_stock_details($input);
          $product_id=$input['product_id'];
            $get_stock_details= $this->death_stock_model->get_stock_details_by_id($product_id);
            $available_stock=$get_stock_details[0]['quantity'];
			$death_stock= $available_stock-$input['quantity'];
			$update['quantity']=$death_stock;
			 $this->death_stock_model->update_death_stock($update, $product_id);
            if (!empty($insert) && $insert != 0) {
                $this->session->set_flashdata('flashSuccess', 'New Death stock successfully added!');
                redirect($this->config->item('base_url') . 'stock/death_stock');
            }
        }
		$data["model_number"] = $this->death_stock_model->get_all_model_number();
		$this->template->write_view('content', 'stock/add_death_stock', $data);
        $this->template->render();
		
    }
    public function validate_quantity() {
        $product_id = $this->input->post('product_id');
        $quantity = $this->input->post('quantity');
        $get_stock_details= $this->death_stock_model->get_stock_details_by_id($product_id);
        $available_stock=$get_stock_details[0]['quantity'];
        $output = array();
        if($quantity>$available_stock){
            $output['result'] = 'fail';
            $output['message'] = 'Quantity Should Be Less Than Or Equal to Stock Quantity.';
        }
        else{
            $output['result'] = 'success';
            $output['message'] = 'Quantity Available.';
        }
        echo json_encode($output);
        exit;
    }
    public function ajaxList() {
        $search_data = array();
        $search_data = $this->input->post();
        $list = $this->death_stock_model->get_datatables($search_data);



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
            $row[] = $val['product_name'];
           
            $row[] = $val['model_no'];
            
            $row[] = $val['quantity'];
			 $row[] = $val['death_qty'];
			$row[] = ($val['created_date'] != '' && $val['created_date'] != '0000-00-00 00:00:00') ? date('d-M-Y', strtotime($val['created_date'])) : '-';
           
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->death_stock_model->count_all(),
            "recordsFiltered" => $this->death_stock_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
