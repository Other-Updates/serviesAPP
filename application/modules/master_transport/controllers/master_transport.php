<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_transport extends MX_Controller {

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
	
	public function index()
	{
    	   $this->load->model('master_transport/master_transport_model');
		   $data["detail"]=$this->master_transport_model->get_all_transport();
		   $this->template->write_view('content','master_transport/index',$data);
		   $this->template->render();  
	}
		
		
	public function insert_master_transport()
	{
		$this->load->model('master_transport/master_transport_model');
		$input=array('transport_name'=>$this->input->post('transport'));
		$this->master_transport_model->insert_master_transport($input);
		redirect($this->config->item('base_url').'master_transport/index');
	}
	
	public function update_master_transport()
	{
   		$this->load->model('master_transport/master_transport_model');
   		$id=$this->input->post('id');
	   $input=array('transport_name'=>$this->input->post('up_men'));
	   $this->master_transport_model->update_transport($input,$id);
	   redirect($this->config->item('base_url').'master_transport/index');
 
	}
	
	public function delete_master_transport()
	{
		$this->load->model('master_transport/master_transport_model');
		$id=$this->input->post('hidin');
		$this->master_transport_model->delete_master_transport($id);
		redirect($this->config->item('base_url').'master_transport/index');

	}
public function add_duplicate_category()
		{
		$this->load->model('master_category/master_category_model');	
		$input=$this->input->get('value1');
		$validation=$this->master_category_model->add_duplicate_category($input);
		//echo $input;exit;
		$i=0; if($validation){$i=1;}if($i==1){echo "Category Name already Exist";}
	
		}		
	public function update_duplicate_category()
		{
		$this->load->model('master_category/master_category_model');	
		$input=$this->input->post('value1');
		$id=$this->input->post('value2');
		$validation=$this->master_category_model->update_duplicate_category($input,$id);
		//echo $input; echo $id; exit;
		$i=0; if($validation){$i=1;}if($i==1){echo "Category Name already Exist";}
	
		}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
