<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class master_style_type extends MX_Controller {

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
    		$this->load->model('master_style_type/master_style_type_model');
		   $data["detail"]=$this->master_style_type_model->get_all_fit();
		   $this->template->write_view('content','master_style_type/index',$data);
		   $this->template->render();
		  
		}
		
	public function insert_master_style_type()
	{
		$this->load->model('master_style_type/master_style_type_model');
		$input=array('style_type'=>$this->input->post('style_type'));
		if($input['style_type'] !='')
		{
		$this->master_style_type_model->insert_master_style_type($input);
		$data["detail"]=$this->master_style_type_model->get_all_fit();
		redirect($this->config->item('base_url').'master_style_type/index',$data);
		}
		else
		{
		$data["detail"]=$this->master_style_type_model->get_all_fit();
		 $this->template->write_view('content','master_style_type/index',$data);
		   $this->template->render();	
		}
		
	}
	
	public function update_fit(){
   $this->load->model('master_style_type/master_style_type_model');
   $id=$this->input->post('value1');
  // print_r($id);exit;
   $input=array('style_type'=>$this->input->post('value2'));
   $this->master_style_type_model->update_fit($input,$id);
   $data["detail"]=$this->master_style_type_model->get_all_fit();
   redirect($this->config->item('base_url').'master_style_type/index',$data);
 
}
	
	public function delete_master_style_type()
	{
		$this->load->model('master_style_type/master_style_type_model');
		$id=$this->input->get('value1');
		
		{
		$this->master_style_type_model->delete_master_style_type($id);
		$data["detail"]=$this->master_style_type_model->get_all_fit();
		redirect($this->config->item('base_url').'master_style_type/index',$data);
		}
	}
	public function add_duplicate_product()
	{
		$this->load->model('master_style_type/master_style_type_model');	
		$input=$this->input->get('value1');
		$validation=$this->master_style_type_model->add_duplicate_product($input);
		$i=0; if($validation){$i=1;}if($i==1){echo "Product Already Exist";}
	
	}
	public function update_duplicate_product()
	{
		$this->load->model('master_style_type/master_style_type_model');	
		$input=$this->input->get('value1');
		$id=$this->input->get('value2');
		$validation=$this->master_style_type_model->update_duplicate_product($input,$id);
		$i=0; if($validation){$i=1;}if($i==1){echo "Product Already Exist";}
	
	}		
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
