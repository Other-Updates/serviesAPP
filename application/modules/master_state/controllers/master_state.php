<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_state extends MX_Controller {

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
    		$this->load->model('master_state/master_state_model');
		   $data["detail"]=$this->master_state_model->get_all_state();
		   $this->template->write_view('content','master_state/index',$data);
		   $this->template->render();
		  
		}
		
		
		
	public function insert_master_state()
	{
		$this->load->model('master_state/master_state_model');
		$input=array('state'=>$this->input->post('state'),'st'=>$this->input->post('st'),'cst'=>$this->input->post('cst'),'vat'=>$this->input->post('vat'));
		//print_r($input);exit;
		 if($input['state'] != '')
  {
		$this->master_state_model->insert_master_state($input);
		$data["detail"]=$this->master_state_model->get_all_state();
		redirect($this->config->item('base_url').'master_state/index',$data);
  }
  else
  {
		$data["detail"]=$this->master_state_model->get_all_state();
		$this->template->write_view('content','master_state/index',$data);
	    $this->template->render();
	  
  }
		
	}
	
	public function update_state(){
   $this->load->model('master_state/master_state_model');
   $id=$this->input->post('value1');
   $input=array('state'=>$this->input->post('value2'),'st'=>$this->input->post('value3'),'cst'=>$this->input->post('value4'),'vat'=>$this->input->post('value5'));
  //  print_r($input);exit;exit;
   $this->master_state_model->update_state($input,$id);
   $data["detail"]=$this->master_state_model->get_all_state();
   redirect($this->config->item('base_url').'master_state/index',$data);
 
}
	
	public function delete_master_state()
	{
		$this->load->model('master_state/master_state_model');
		$id=$this->input->get('value1');
		
		{
		$this->master_state_model->delete_master_state($id);
		$data["detail"]=$this->master_state_model->get_all_state();
		redirect($this->config->item('base_url').'master_state/index',$data);
		}
	}
public function add_duplicate_state()
		{
		$this->load->model('master_state/master_state_model');	
		$input=$this->input->get('value1');
		$validation=$this->master_state_model->add_duplicate_state($input);
		//echo $input;exit;
		$i=0; if($validation){$i=1;}if($i==1){echo "State Name already Exist";}
	
		}		
	public function update_duplicate_state()
		{
		$this->load->model('master_state/master_state_model');	
		$input=$this->input->post('value1');
		$id=$this->input->post('value2');
		$validation=$this->master_state_model->update_duplicate_state($input,$id);
		//echo $input; echo $id; exit;
		$i=0; if($validation){$i=1;}if($i==1){echo "State Name already Exist";}
	
		}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
