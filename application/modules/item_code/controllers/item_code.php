<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Item_code extends MX_Controller {

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
    	   $this->load->model('item_code/item_code_model');
		   $this->load->model('master_style/master_model');
		   $this->load->model('master_fit/master_fit_model');
		   $data["fit"]=$this->master_fit_model->get_all_fit();
		   $data["style"]=$this->master_model->get_style();
		   $data["detail"]=$this->item_code_model->get_all_item1();
		   $this->template->write_view('content','item_code/index',$data);
		   $this->template->render();
		  
		}
		
	public function insert_item_code()
	{
		$this->load->model('item_code/item_code_model');
		$input=$this->input->post();
		$this->item_code_model->insert_item_code($input['item']);
		redirect($this->config->item('base_url').'item_code/index');
	}
	
	public function update_item()
	{
	   $this->load->model('item_code/item_code_model');
	   $input=$this->input->post();
	   $this->item_code_model->update_item($input['item'],$input['item_id']);
	   redirect($this->config->item('base_url').'item_code/index');
	}
		
	public function delete_item_code()
	{
		$this->load->model('item_code/item_code_model');
		$id=$this->input->get('value1');
		$this->item_code_model->delete_item_code1($id);
		$data["detail"]=$this->item_code_model->get_all_size();
		echo $this->load->view('ajax_del',$data); 
		//redirect($this->config->item('base_url').'item_code/index',$data);	
	}
	public function add_duplicate_code()
	{
		$this->load->model('item_code/item_code_model');	
		$input=$this->input->get('value1');
		$validation=$this->item_code_model->add_duplicate_code($input);
		$i=0; if($validation){$i=1;}if($i==1){echo "Item Code Already Exist";}
	}		
	public function update_duplicate_code()
	{
		$this->load->model('item_code/item_code_model');	
		$input=$this->input->post('value1');
		$id=$this->input->post('value2');
		$validation=$this->item_code_model->update_duplicate_code($input,$id);
		$i=0; if($validation){$i=1;}if($i==1){echo "Item Code Already Exist";}
	}	
	public function get_image()
	{
		$input=$this->input->get();
		$this->load->model('item_code/item_code_model');
		$image=$this->item_code_model->get_image_by_style_id($input['s_id']);
		echo  '<img id="" class="add_staff_thumbnail" style="width: 164px;height: 164px;" src="'.$this->config->item('base_url').'style_image/'.$image[0]['style_image'].'"/>';
		
	}
	public function get_color()
	{
		$input=$this->input->get();
		$this->load->model('item_code/item_code_model');
		$details=$this->item_code_model->get_color_by_style_id($input['s_id']);
		$select='';
		$select=$select."<select class='form-control itemupcolor' name='item[color_id]' id='itemcolor' style=''><option value=''>Select</option>";
		if(isset($details) && !empty($details))
		{
			foreach($details as $val1)
			{		
					$select=$select."<option value=".$val1['color_id'].">".$val1['colour']."</option>";
			}
		}
		
		$select=$select."</select><span id='codeerror5' class='upcodeerror5 reset5' style='color:#F00; font-style:italic;'></span>";
		if(empty($details))
		{
			$select=$select."   <span style='color:red;'>Customer not crerated yet...</span>";
		}
		echo $select;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
