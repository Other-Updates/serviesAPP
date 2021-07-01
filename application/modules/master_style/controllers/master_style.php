<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class master_style extends MX_Controller {

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
	
	function __construct(){
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
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$this->load->model('master_colour/master_colour_model');
		$data["style"]=$this->master_model->get_style();
		$data["last_id"]=$this->master_model->get_last_id('lot_code');
		$data['all_size']=$this->stock_model->get_all_size();
	 	$data["all_color"]=$this->master_colour_model->get_colour();
		$data['all_style_type']=$this->stock_model->get_all_style_type();
		$this->load->model('master_fit/master_fit_model');
		$data["fit"]=$this->master_fit_model->get_all_fit();
		$this->load->model('customer/customer_model'); 
		$data['all_customer']=$this->customer_model->get_customer();
		//echo "<pre>";print_r($data['style']);exit;
		//last insert number
		//$no=explode("T", $data["last_id"][0]['value']);
		//$data['last_no']='LOT'.str_pad($no[1]+1, 4, '0', STR_PAD_LEFT);
		//echo "<pre>";
		//print_r($data["style"]);
		$this->template->write_view('content','master_style/index',$data);
		$this->template->render();	
	}

	public function insert_style(){
		$this->load->model('master_style/master_model');
		$input=$this->input->post();
		
		$this->load->helper('text');
			
		$config['upload_path'] = './style_image';
		
		$config['allowed_types'] = '*';
		
		$config['max_size']	= '2000';
		
		$this->load->library('upload', $config);
		$this->load->model('stock/stock_model');
		$data['all_size']=$this->stock_model->get_all_size();
		$input['style']['style_image']='default.png';
		
	
		
		if(isset($_FILES) && !empty($_FILES))
		{
			$upload_files = $_FILES;
			if($upload_files['admin_name'] !='')
			{
				$_FILES['admin_name'] = array(
				'name' => $upload_files['admin_name']['name'],
				'type' => $upload_files['admin_name']['type'],
				'tmp_name' => $upload_files['admin_name']['tmp_name'],
				'error' => $upload_files['admin_name']['error'],
				'size' => '2000'
				);
			$this->upload->do_upload('admin_name');
			
			$upload_data = $this->upload->data();
			$input['style']['style_image']=$upload_data['file_name'];
			}
			
		}
		
	
		$id=$this->master_model->insert_style($input['style']);
		//$this->master_model->update_last_id($last);
		$insert_list1=array();
		if(isset($input['style_color']) && !empty($input['style_color']))
		{
			foreach($input['style_color'] as $key=>$val)
			{
				$insert_list1[]=array('style_id'=>$id,'color_id'=>$val);
				if(isset($data['all_size']) && !empty($data['all_size']))
				{
					foreach($data['all_size'] as $all_size)
					{
						$insert_stock[]=array('style_id'=>$id,'color_id'=>$val,'size_id'=>$all_size['id']);
					}
				}
			}
		}
		$insert_list=array();
		if(isset($input['style_size']) && !empty($input['style_size']))
		{
			foreach($input['style_size'] as $key=>$val)
			{
				$insert_list[]=array('style_id'=>$id,'size_id'=>$val);
			}
		}
		$insert_list2=array();
		if(isset($input['style_customer']) && !empty($input['style_customer']))
		{
			foreach($input['style_customer'] as $key=>$val)
			{
				$insert_list2[]=array('style_id'=>$id,'customer_id'=>$val,'mrp'=>$input['style_mrp'][$key]);
			}
		}
		$this->stock_model->insert_stock_info($insert_stock);
		$this->master_model->insert_style_details($insert_list);
		$this->master_model->insert_style_color_details($insert_list1);
		$this->master_model->insert_style_mrp_details($insert_list2);
		redirect($this->config->item('base_url').'master_style/index');
	}
	public function update_style()
	{
		
		$input=$this->input->post();
		
		$this->load->helper('text');	
		$config['upload_path'] = './style_image';
		$config['allowed_types'] = '*';
		$config['max_size']	= '2000';
		$this->load->library('upload', $config);
		if(isset($_FILES) && !empty($_FILES))
		{
			$upload_files = $_FILES;
			if($upload_files['admin_name2'] !='')
			{
				$_FILES['admin_name'] = array(
				'name' => $upload_files['admin_name2']['name'],
				'type' => $upload_files['admin_name2']['type'],
				'tmp_name' => $upload_files['admin_name2']['tmp_name'],
				'error' => $upload_files['admin_name2']['error'],
				'size' => '2000'
				);
			$this->upload->do_upload('admin_name');
			
			$upload_data = $this->upload->data();
				if($upload_data['file_name']!='')
				{
					$input['style_update']['style_image']=$upload_data['file_name'];
				}
			}
		}
		
		$this->load->model('master_style/master_model');
		$this->master_model->update_style($input['style_update'],$input['style_id']);
		$this->master_model->delete_all_size($input['style_id']);
		$this->master_model->delete_all_color($input['style_id']);
		$this->master_model->delete_all_mrp($input['style_id']);
		
		
		
		$insert_list1=array();
		if(isset($input['style_color_update']) && !empty($input['style_color_update']))
		{
			foreach($input['style_color_update'] as $key=>$val)
			{
				$insert_list1[]=array('style_id'=>$input['style_id'],'color_id'=>$val);
			}
		}
		$this->master_model->insert_style_color_details($insert_list1);
		
		$insert_list=array();
		if(isset($input['style_size_update']) && !empty($input['style_size_update']))
		{
			foreach($input['style_size_update'] as $key=>$val)
			{
				$insert_list[]=array('style_id'=>$input['style_id'],'size_id'=>$val);
			}
		}
		
		$insert_list2=array();
		if(isset($input['style_customer']) && !empty($input['style_customer']))
		{
			foreach($input['style_customer'] as $key=>$val)
			{
				$insert_list2[]=array('style_id'=>$input['style_id'],'customer_id'=>$val,'mrp'=>$input['style_mrp'][$key]);
			}
		}
		$this->master_model->insert_style_mrp_details($insert_list2);
		$this->master_model->insert_style_details($insert_list);
		redirect($this->config->item('base_url').'master_style/index');
	}
	public function delete_master_style()
	{
	  $this->load->model('master_style/master_model');
	  $id=$this->input->get('value1');
	  {
		  $this->master_model->delete_master_style($id);
		  $data["style"]=$this->master_model->get_style();
		  redirect($this->config->item('base_url').'master_style/index',$input);
	  }
	}
	public function add_duplicate_stylename()
	{
		$this->load->model('master_style/master_model');	
		$input=$this->input->get('value1');
		$validation=$this->master_model->add_duplicate_stylename($input);
		$i=0; if($validation){$i=1;}if($i==1){echo"Style Name Already Exist";}

	}	
	public function update_duplicate_stylename()
	{
		$this->load->model('master_style/master_model');	
		$input=$this->input->post('value1');
		$id=$this->input->post('value2');
		$validation=$this->master_model->update_duplicate_stylename($input,$id);
		//echo $input; 
		//echo $id; 
		//exit;
		$i=0; if($validation){$i=1;}if($i==1){echo "Style Name Already Exist";}
	
	}
	public function get_lot_no()
	{
		$input=$this->input->get('style_name');
		$this->load->model('master_style/master_model');
		$count=$this->master_model->check_lot_no($input);
		if(date('m')>3)
		{
			echo date('y').(date('y')+1).str_pad($count+1, 4, '0', STR_PAD_LEFT);
		}else
		{
			echo (date('y')-1).date('y').str_pad($count+1, 4, '0', STR_PAD_LEFT);;
		}
	}

}