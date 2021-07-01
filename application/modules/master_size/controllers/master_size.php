<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_size extends MX_Controller {

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
    		$this->load->model('master_size/master_size_model');
		   $data["detail"]=$this->master_size_model->get_all_size();
		   $this->template->write_view('content','master_size/index',$data);
		   $this->template->render();
		  
		}
		
		
	public function insert_master_size()
	{
		$this->load->model('master_size/master_size_model');
		$input=array('size'=>$this->input->post('size'));
		 if($input['size'] != '')
  {
		$this->master_size_model->insert_master_size($input);
		$data["detail"]=$this->master_size_model->get_all_size();
		redirect($this->config->item('base_url').'master_size/index',$data);
  }
  else
  {
	$data["detail"]=$this->master_size_model->get_all_size();
	$this->template->write_view('content','master_size/index',$data);
    $this->template->render();  
  }
		
	}
	
	public function update_size(){
   $this->load->model('master_size/master_size_model');
   $id=$this->input->post('value1');
  // print_r($id);exit;
   $input=array('size'=>$this->input->post('value2'));
   $this->master_size_model->update_size($input,$id);
   $data["detail"]=$this->master_size_model->get_all_size();
   redirect($this->config->item('base_url').'master_size/index',$data);
 
}
	
	public function delete_master_size()
	{
		$this->load->model('master_size/master_size_model');
		$id=$this->input->get('value1');
		
		{
		$this->master_size_model->delete_master_size($id);
		$data["detail"]=$this->master_size_model->get_all_size();
		redirect($this->config->item('base_url').'master_size/index',$data);
		}
	}
	
	public function checking_master_size()
	{
		$this->load->model('master_size/master_size_model');
		$size=$this->input->post('value1');
		$data=$this->master_size_model->checking_master_size($size);
		$i=0;
		if($data)
		{
			$i=1;
		}
		if($i==1)
		{
			echo "Size Already Exist";
		}
	}
	public function update_duplicate_size()
		{
		$this->load->model('master_size/master_size_model');	
		$input=$this->input->post('value1');
		$id=$this->input->post('value2');
		$validation=$this->master_size_model->update_duplicate_size($input,$id);
		//echo $input; echo $id; exit;
		$i=0; if($validation){$i=1;}if($i==1){echo "Size Already Exist";}
	
		}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
