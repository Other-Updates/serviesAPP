<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Master_fit extends MX_Controller {

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
    		$this->load->model('master_fit/master_fit_model');
		   $data["detail"]=$this->master_fit_model->get_all_fit();
		   $this->template->write_view('content','master_fit/index',$data);
		   $this->template->render();
		  
		}
		
	public function insert_master_fit()
	{
		$this->load->model('master_fit/master_fit_model');
		$input=array('user_role'=>$this->input->post('fit'),'permission'=>$this->input->post('permission'));              
		if($input['user_role'] != '')
		{
		 $this->master_fit_model->insert_master_fit($input);
		$data["detail"]=$this->master_fit_model->get_all_fit();
		redirect($this->config->item('base_url').'master_fit/index',$data);
		}
		else
		{
		$data["detail"]=$this->master_fit_model->get_all_fit();
		 $this->template->write_view('content','master_fit/index',$data);
		   $this->template->render();
		}
	}
	
	
	public function update_fit()
	{
		
   $this->load->model('master_fit/master_fit_model');
   $id=$this->input->post('value1');
   $input=array('user_role'=>$this->input->post('value2'),'permission'=>$this->input->post('value3'));
    //echo"<pre>"; print_r($input); exit;
   $this->master_fit_model->update_fit($input,$id);
   $data["detail"]=$this->master_fit_model->get_all_fit();
   redirect($this->config->item('base_url').'master_fit/index',$data);
 
}
  
	
	public function delete_master_fit()
	{
		$this->load->model('master_fit/master_fit_model');
		$id=$this->input->get('value1');
		
		{
		$this->master_fit_model->delete_master_fit($id);
		$data["detail"]=$this->master_fit_model->get_all_fit();
		redirect($this->config->item('base_url').'master_fit/index',$data);
		}
	}
   public function add_duplicate_fit()
   {
		$this->load->model('master_fit/master_fit_model');	
		$input=$this->input->get('value1');
		$validation=$this->master_fit_model->add_duplicate_fit($input);
		$i=0; if($validation){$i=1;}if($i==1){echo "Fit Name Already Exist";}
	
   }	
   public function update_duplicate_fit()
	{
		$this->load->model('master_fit/master_fit_model');	
		$input=$this->input->post('value1');
		$id=$this->input->post('value2');
		$validation=$this->master_fit_model->update_duplicate_fit($input,$id);
		$i=0; if($validation){$i=1;}if($i==1){echo "Fit Name already Exist";}
	
	}		
	


   public function expense_index()
	{
    	   $this->load->model('master_fit/master_fit_model');
		   $data["details"]=$this->master_fit_model->get_all_expense_fixed();
		  // print_r($data);exit;
		    $data["variable"]=$this->master_fit_model->get_all_expense_variable();
		   $this->template->write_view('content','master_fit/expense_index',$data);
		   $this->template->render();
		  
		}
		public function insert_master_expense()
		{
		$this->load->model('master_fit/master_fit_model');
		$input=array('expense'=>$this->input->post('expense'),'expense_type'=>$this->input->post('expense_type'));
		if($input['expense'] != '')
		{
		$this->master_fit_model->insert_master_expense($input);
		$data["details"]=$this->master_fit_model->get_all_expense_fixed();
		
			
	
		redirect($this->config->item('base_url').'master_fit/expense_index',$data);
		}
		else
		{
		$data["details"]=$this->master_fit_model->get_all_expense_fixed();
		
		 $this->template->write_view('content','master_fit/expense_index',$data);
		   $this->template->render();
		}
			
		}
		public function delete_master_expense()
	{
		$this->load->model('master_fit/master_fit_model');
		$id=$this->input->get('value1');
		
		{
		$this->master_fit_model->delete_master_expense($id);
		$data["details"]=$this->master_fit_model->get_all_expense_fixed();
		$data["variable"]=$this->master_fit_model->get_all_expense_variable();
		redirect($this->config->item('base_url').'master_fit/index',$data);
		}
	}
	
	public function update_expense()
	{
     $this->load->model('master_fit/master_fit_model');
     $id=$this->input->get('value1');
     $input=array('expense'=>$this->input->get('value2'));
     $this->master_fit_model->update_expense_one($input,$id);
     $data["details"]=$this->master_fit_model->get_all_expense_fixed();
     $data["variable"]=$this->master_fit_model->get_all_expense_variable();
     redirect($this->config->item('base_url').'master_fit/index',$data);
    }
	 public function add_duplicate_expense_fixed()
   {
		$this->load->model('master_fit/master_fit_model');	
		$input=$this->input->get();
		//print_r($input); exit;
		$validation=$this->master_fit_model->add_duplicate_expense_fixed($input);
		$i=0; if($validation){$i=1;}if($i==1){echo "Expense Already Exist";}
	
   }	
    public function add_duplicate_expense_variable()
   {
		$this->load->model('master_fit/master_fit_model');	
		$input=$this->input->get();
		//print_r($input); exit;
		$validation=$this->master_fit_model->add_duplicate_expense_variable($input);
		$i=0; if($validation){$i=1;}if($i==1){echo "Expense Already Exist";}
	
   }	
   public function update_duplicate_expense_fixed()
	{
		$this->load->model('master_fit/master_fit_model');	
		$input=$this->input->post('value1');
		$id=$this->input->post('value2');
		$exp_type=$this->input->post('value3');
		$validation=$this->master_fit_model->update_duplicate_expense_fixed($input,$id,$exp_type);
		$i=0; if($validation){$i=1;}if($i==1){echo "Expense Name already Exist";}
	
	}	
	 public function update_duplicate_expense_varaible()
	{
		$this->load->model('master_fit/master_fit_model');	
		$input=$this->input->post('value1');
		$id=$this->input->post('value2');
		$exp_type=$this->input->post('value3');
		$validation=$this->master_fit_model->update_duplicate_expense_varaible($input,$id,$exp_type);
		$i=0; if($validation){$i=1;}if($i==1){echo "Expense Name already Exist";}
	
	}			
   
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
