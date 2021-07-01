<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Package extends MX_Controller {

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
		$this->load->model('package/package_model');
		$this->load->model('gen/gen_model');
		$this->load->model('sales_order/sales_order_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$this->load->model('customer/customer_model');
		$data["last_id"]=$this->master_model->get_last_id('ps_code');
		$no[1]=substr($data["last_id"][0]['value'],3);
		if(date('m')>3)
		{
			$check_no='PS'.date('y').(date('y')+1).'0001';
			$check_res=$this->package_model->check_so_no($check_no);
			if(empty($check_res))
			{
				$data['last_no']='PS'.date('y').(date('y')+1).'0001';
			}
			else
				$data['last_no']='PS'.date('y').(date('y')+1).str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
		}else
		{
			$check_no='PS'.(date('y')-1).date('y').'0001';
			$check_res=$this->package_model->check_so_no($check_no);
			if(empty($check_res))
			{
				$data['last_no']='PS'.(date('y')-1).date('y').'0001';
			}
			else
				$data['last_no']='PS'.(date('y')-1).date('y').str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
		}
		if($this->input->post())
		{
			$input=$this->input->post();
			
			$salse_id=$this->sales_order_model->get_all_salse_id();
			$input['package']['ship_date']=date('Y-m-d',strtotime($input['package']['ship_date']));
			$order_list='';
			if(isset($input['sales_order']) && !empty($input['sales_order']))
			{
				$i=0;
				foreach($input['sales_order'] as $key=>$val)
				{
					$this->sales_order_model->update_all_data(array('package_status'=>1),$val);
					if($i==0)
					{
						$order_list=$order_list.$val;
						$i=1;
					}
					else
						$order_list=$order_list.'-'.$val;
				}
			}
			$input['package']['sales_order_list']=$order_list;
			if(date('m')>3)
			{
				$check_no='PS'.date('y').(date('y')+1).'0001';
				$check_res=$this->package_model->check_so_no($check_no);
				if(empty($check_res))
				{
					$data['last_no']='PS'.date('y').(date('y')+1).'0001';
				}
				else
					$data['last_no']='PS'.date('y').(date('y')+1).str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
			}else
			{
				$check_no='PS'.(date('y')-1).date('y').'0001';
				$check_res=$this->package_model->check_so_no($check_no);
				if(empty($check_res))
				{
					$data['last_no']='PS'.(date('y')-1).date('y').'0001';
				}
				else
					$data['last_no']='PS'.(date('y')-1).date('y').str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
			}
			$input['package']['package_slip']=$data['last_no'];
			$insert_id=$this->package_model->insert_package($input['package']);
			$this->master_model->update_last_id1($data['last_no'],'ps_code');
			$s_arr=array();
			if(isset($input['style']) && !empty($input['style']))
			{
				foreach($input['style'] as $key=>$val)
				{
					foreach($input['size_name'][$val.$input['color'][$key].$input['corton'][$key]] as $keys=>$vals)
					{
						$s_arr[]=array('package_id'=>$insert_id,'style_id'=>$val,'color_id'=>$input['color'][$key],'corton_no'=>$input['corton'][$key],'size'=>$vals,'qty'=>$input['size'][$val.$input['color'][$key].$input['corton'][$key]][$keys]);
					}
				}
			}
			$this->package_model->insert_package_details($s_arr);
			redirect($this->config->item('base_url').'package/package_list');
		}	
		
		
		$data['all_customer']=$this->customer_model->get_customer();
		$data['all_state']=$this->master_state_model->get_all_state();
		$data['all_style']=$this->master_model->get_style();
		$data['all_color']=$this->stock_model->get_all_color();
		$this->load->model('master_transport/master_transport_model');
		$data["all_transport"]=$this->master_transport_model->get_all_transport();
		$this->template->write_view('content', 'package/index',$data);
        $this->template->render();       
	}
	public function package_list()
	{
		$this->load->model('package/package_model');
		$data['all_package']=$this->package_model->get_all_package();
		$this->load->model('customer/customer_model');
		$data['all_customer']=$this->customer_model->get_customer();
		$this->template->write_view('content', 'package_list',$data);
        $this->template->render(); 
	}
	public function get_package_by_customer_id()
	{
		$this->load->model('package/package_model');
		$c_id=$this->input->get('c_id');
		$data['package']=$this->package_model->get_package_by_customer($c_id);

		$this->load->view('package/package_info',$data);
	}
	public function get_package_by_customer_id1()
	{
		$this->load->model('package/package_model');
		$c_id=$this->input->get('c_id');
		$data['pending_so']=$this->package_model->get_pending_sales_order($c_id);
		
		$table='<table>';
	    if(isset($data['pending_so']) && !empty($data['pending_so']))
		{
			foreach($data['pending_so'] as $val)
			{
				$table=$table."<tr><td><input type='checkbox' name='sales_order[]' class='so_id'  value='".$val['id']."' />&nbsp;&nbsp;".$val['grn_no']."</td><td></td></tr>";
			}
		}
		else
		{
			$table=$table.'<tr>Sales Order Not Created Yet</tr>';
		}
		$table=$table.'</table>';
		echo $table;
	}
	public function package_view($p_id)
	{
		$this->load->model('package/package_model');
		$data['package_details']=$this->package_model->get_package_by_id($p_id);
		$data['package_info']=$this->package_model->get_package_details($p_id);
		$this->template->write_view('content', 'package/package_view',$data);
        $this->template->render();      
	}
	public function get_ps_no_list()
	{
		$atten_inputs = $this->input->get();
		$this->load->model('package_model');
		$data = $this->package_model->get_all_ps_no($atten_inputs);
		foreach($data as $st_rlno)
		{
			echo $st_rlno['package_slip']."\n";
		}	
	}
	public function get_inv_no_list()
	{
		$atten_inputs = $this->input->get();
		$this->load->model('package_model');
		$data = $this->package_model->get_all_inv_no($atten_inputs);
		foreach($data as $st_rlno)
		{
			echo $st_rlno['inv_no']."\n";
		}	
	}
	
	public function search_result()
	{
		$search_data=$this->input->get();
		$this->load->model('package/package_model');
		$data['search_data']=$search_data;
		$data['all_package']=$this->package_model->get_all_package($search_data);
		$this->load->model('customer/customer_model');
		$data['all_customer']=$this->customer_model->get_customer();
		$this->load->view('package/search_list',$data);
	}
	public function get_package_by_so()	
	{
		$this->load->model('package/package_model');
		$c_id=$this->input->get('c_id');
		$so_id=$this->input->get('so_id');
		if(count($so_id)!=1)
		{
			$x=$this->package_model->get_check_solor_mrp($so_id);
			if($x==0)
			{
				$data['package']=$this->package_model->get_package_by_so($c_id,$so_id);
				$this->load->view('package/package_info',$data);
			}
			else
			{
				echo $x;	
			}
		}
		else
		{
			$data['package']=$this->package_model->get_package_by_so($c_id,$so_id);
			$this->load->view('package/package_info',$data);
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
