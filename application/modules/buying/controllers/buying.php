<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Buying extends MX_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('email');
	    $this->load->database();
		$this->load->library('form_validation');
			
	}
	public function add_buying()
	{
		$this->load->model('stock/stock_model');
		$this->load->model('buying/buying_model');
		if($this->input->post())
		{
			$this->buying_model->insert_buying($this->input->post());
			redirect($this->config->item('base_url').'buying/add_buying?send=success');
		}
		$data['all_style']=$this->stock_model->get_all_style();
		$data['all_color']=$this->stock_model->get_all_color();
		$data['all_fit']=$this->stock_model->get_all_fit();
		$data['all_season']=$this->stock_model->get_all_season();
		$this->template->write_view('content', 'buying/add_buying',$data);
        $this->template->render();       
	}
	public function update_buying()
	{
		$this->load->model('stock/stock_model');
		$this->load->model('buying/buying_model');
		$data['all_style']=$this->stock_model->get_all_style();
		$data['all_color']=$this->stock_model->get_all_color();
		$data['all_fit']=$this->stock_model->get_all_fit();
		$data['all_season']=$this->stock_model->get_all_season();
		$this->template->write_view('content', 'buying/update_buying',$data);
        $this->template->render();       
	}
	public function update_buying_details()
	{
		$this->load->model('stock/stock_model');
		$this->load->model('buying/buying_model');
		$update_data=$this->input->get();
		$data['buying_info']=$this->buying_model->get_all_buying_details($update_data);
		$data['all_style']=$this->stock_model->get_all_style();
		$data['all_color']=$this->stock_model->get_all_color();
		$data['all_fit']=$this->stock_model->get_all_fit();
		$data['all_season']=$this->stock_model->get_all_season();
		$data['stock_info']=$this->stock_model->view_stock_details();
		$data['all_size']=$this->stock_model->get_all_size();
		echo $this->load->view('buying/buying_info',$data,TRUE); 
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
