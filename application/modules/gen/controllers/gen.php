<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gen extends MX_Controller {

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
		$this->load->model('gen_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		if(date('m')>3)
		{
			$f_year=date('y').(date('y')+1);	
		}else
		{
			$f_year=(date('y')-1).date('y');
		}
		if($this->input->post())
		{
			$input=$this->input->post();
			echo '<pre>';
			$data["last_id"]=$this->master_model->get_last_id('grn_code');
			$no[1]=substr($data["last_id"][0]['value'],3);
			if(date('m')>3)
			{
				$check_no='GRN'.date('y').(date('y')+1);
				$check_res=$this->gen_model->check_po_no1($check_no);
				if(empty($check_res))
				{
					$data['last_no']='GRN'.date('y').(date('y')+1).'0001';
				}
				else
					$data['last_no']='GRN'.date('y').(date('y')+1).str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
			}else
			{
				$check_no='GRN'.(date('y')-1).date('y');
				$check_res=$this->gen_model->check_po_no($check_no);
				if(empty($check_res))
				{
					$data['last_no']='GRN'.(date('y')-1).date('y').'0001';
				}
				$data['last_no']='GRN'.(date('y')-1).date('y').str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
			}
	
			$insert_gen=array('grn_no'=>$data['last_no'],'po_no'=>$input['po_no'],'total_qty'=>$input['full_total'][0],'total_value'=>$input['net_total'],'inv_date'=>date('Y-m-d'));
			
			$lot_no=$this->gen_model->get_lot_by_po($input['po_no']);
			$in_id=$this->gen_model->insert_gen($insert_gen);

			$total_qty=$this->gen_model->get_total_qty($input['po_no']);

			$this->master_model->update_last_id1($data['last_no'],'grn_code');
			$s_arr=$insert_stock=array();
			if(isset($input['color']) && !empty($input['color']))
			{
				
				
				foreach($input['color'] as $key=>$val)
				{
					
					if($val!='Select' && $val!='select' && $val!='0' )
					{
					
						if(isset($input['size'][$input['style_all'][$key]][$val]) && !empty($input['size'][$input['style_all'][$key]][$val]))
						{
							foreach($input['size'][$input['style_all'][$key]][$val] as $s_id=>$s_val)
							{
								$s_arr[]=array('gen_id'=>$in_id,'style_id'=>$input['style_all'][$key],'lot_no'=>$input['style_lot_no'][$key],'color_id'=>$val,'size_id'=>$s_id,'qty'=>$s_val);				
								//$update_data=array('style_id'=>$input['style_all'][$key],'color_id'=>$val,'size_id'=>$s_id,'qty'=>$s_val);
								//$this->stock_model->update_stock_info($update_data);
								$insert_stock[]=array('style_id'=>$input['style_all'][$key],'color_id'=>$val,'size_id'=>$s_id,'qty'=>$s_val,'finacial_year'=>$f_year,'lot_no'=>$input['style_lot_no'][$key],'location'=>$input['location'][$key]);
								
							}
						
						}
					}
				}	
			}	
			$this->stock_model->insert_stock_info($insert_stock);
			$this->gen_model->insert_gen_details($s_arr);
			redirect($this->config->item('base_url').'gen/gen_list');
			
		}
		
		$data["last_id"]=$this->master_model->get_last_id('grn_code');
		//last insert number
		//$no=explode("N", $data["last_id"][0]['value']);
		$no[1]=substr($data["last_id"][0]['value'],4);
		$data['last_no']='GRN'.str_pad($no[1]+1, 4, '0', STR_PAD_LEFT);
		$data['all_state']=$this->master_state_model->get_all_state();
		$data['all_style']=$this->master_model->get_style();
		$data['all_color']=$this->stock_model->get_all_color();
		$this->template->write_view('content', 'gen/index',$data);
        $this->template->render();       
	}
	public function gen_list()
	{
		$this->load->model('gen/gen_model');
		$this->load->model('master_state/master_state_model');
		$data['all_state']=$this->master_state_model->get_all_state();
		
		$this->load->model('master_style/master_model');
		$data['all_style']=$this->master_model->get_all_lot_style();
		
		
		
		$this->load->model('vendor/vendor_model');
		$data['all_supplier']=$this->vendor_model->get_vendor();
		$data['all_gen']=$this->gen_model->get_all_gen();
		$this->template->write_view('content', 'gen/gen_list',$data);
        $this->template->render(); 
	}
	public function edit_gen($id)
	{
		$this->load->model('gen_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$data['gen_info']=$this->gen_model->get_gen_by_id($id);
		if(date('m')>3)
		{
			$f_year=date('y').(date('y')+1);	
		}else
		{
			$f_year=(date('y')-1).date('y');
		}
		if($this->input->post())
		{
			$input=$this->input->post();
			
			$in_id=$id;
			$update_date=array('total_qty'=>$input['full_total'][0]+$data['gen_info'][0]['total_qty'],'total_value'=>$input['net_total']+$data['gen_info'][0]['total_value']);
		
			$this->gen_model->update_all_data($update_date,$id);
			
			if(isset($input['color']) && !empty($input['color']))
			{
				$s_arr=array();
				foreach($input['color'] as $key=>$val)
				{
					if($val!='Select' && $val!='select' && $val!='0' )
					{
						if(isset($input['size'][$input['style_all'][$key]][$val]) && !empty($input['size'][$input['style_all'][$key]][$val]))
						{
							foreach($input['size'][$input['style_all'][$key]][$val] as $s_id=>$s_val)
							{
								$s_arr[]=array('gen_id'=>$in_id,'style_id'=>$input['style_all'][$key],'color_id'=>$val,'size_id'=>$s_id,'qty'=>$s_val);
								//$update_data=array('style_id'=>$input['style_all'][$key],'color_id'=>$val,'size_id'=>$s_id,'qty'=>$s_val);
								$insert_stock[]=array('style_id'=>$input['style_all'][$key],'color_id'=>$val,'size_id'=>$s_id,'qty'=>$s_val,'finacial_year'=>$f_year);
								//$this->stock_model->update_stock_info($update_data);						
							}
						
						}
					}
				}	
			}	
			$this->stock_model->insert_stock_info($insert_stock);
			$this->gen_model->insert_gen_details($s_arr);
			redirect($this->config->item('base_url').'gen/gen_list');
			
		}
		
		$data['all_state']=$this->master_state_model->get_all_state();
		$data['all_style']=$this->master_model->get_style();
		$data['all_color']=$this->stock_model->get_all_color();
		$this->template->write_view('content', 'gen/gen_edit',$data);
        $this->template->render(); 
	}
	public function view_gen($id)
	{
		$this->load->model('gen_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$data['gen_info']=$this->gen_model->get_gen_by_id($id);
		$data['all_state']=$this->master_state_model->get_all_state();
		$data['all_style']=$this->master_model->get_style();
		$data['all_color']=$this->stock_model->get_all_color();
		$this->template->write_view('content', 'gen/gen_view',$data);
        $this->template->render(); 
	}
	public function get_all_customet()
	{
		$this->load->model('gen_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$update_data=$this->input->get();
		$p_data=$this->gen_model->get_all_customer_by_id1($update_data['s_id']);
		$select='';
		if(isset($p_data) && !empty($p_data))
		{
			$select=$select."<select class='customer ".$p_data[0]['st']." ".$p_data[0]['cst']." ".$p_data[0]['vat']." form-control' name='customer'  style='width: 170px;'><option value=''>Select</option>";
			foreach($p_data as $val1)
			{		
					$select=$select."<option value=".$val1['id'].">".$val1['store_name']."</option>";
			}
		}
		
		$select=$select."</select>";
		if(empty($p_data))
		{
			$select=$select."   <span style='color:red;'>Supplier not crerated yet...</span>";
		}
		echo $select;
	}
	public function get_all_style_details_by_id()
	{
		$this->load->model('gen_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$update_data=$this->input->get();
		$p_data=$this->gen_model->get_all_style_details_by_id($update_data['s_id']);
		echo $p_data[0]['style_name'];
	}
	public function get_all_style_details_by_id1()
	{
		$this->load->model('gen_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$update_data=$this->input->get();
		$data=$this->gen_model->get_all_style_details_by_id1($update_data['s_id']);
		$input='';
		
		if(isset($data[0]['style_size']) && !empty($data[0]['style_size']))
		{
			foreach($data[0]['style_size'] as $val)
			{
                $input=$input.'<div style="text-align:center;float:left;" ><p  style="margin: 0 0 0px;"  >'.$val['size'].'</p><p   style="margin: 0 0 0px;"><input type="text"  autocomplete="off" class="s_size int_val" id="'.$val['size_id'].'"  style="width:50px;"</p></div>&nbsp;';
			}
		}
		else
			 $input='Size not created yet....';
			 
		echo $input;	 
	}
	public function get_all_style_details_by_id2()
	{
		$this->load->model('gen_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$update_data=$this->input->get();
		$p_data=$this->gen_model->get_all_style_details_by_id($update_data['s_id']);
		$values=$p_data[0]['sp'];
		echo '<input type="text" style="width:70px;"  autocomplete="off"  tabindex="-1" value="'.$values.'" class="total_mrp1" />';
	}
	public function get_all_style_details_by_id3()
	{
		$this->load->model('gen_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$update_data=$this->input->get();
	
		if(isset($update_data['c_id']) && !empty($update_data['c_id']))
		$p_data=$this->gen_model->get_all_style_details_by_id($update_data['s_id'],$update_data['c_id']);
		if(isset($p_data[0]['customer_mrp']) && !empty($p_data[0]['customer_mrp']))
		$values=$p_data[0]['customer_mrp'];
		else
		$values=0;
		
		echo '<input type="text" style="width:50px;" name="mrp[]" readonly="readonly" tabindex="-1" value="'.$values.'" class="total_mrp1 class_req" />';

	}
	public function get_po_list()
	{
		$atten_inputs = $this->input->get();
			
		$this->load->model('gen/gen_model');
		$data = $this->gen_model->get_all_po_for_add_gen($atten_inputs);
		foreach($data as $st_rlno)
		{
			echo $st_rlno['grn_no']."\n";
		}	
	}
	public function get_po_list_inv()
	{
		$atten_inputs = $this->input->get();
			
		$this->load->model('gen/gen_model');
		$data = $this->gen_model->get_all_po_for_add_gen1($atten_inputs);
		foreach($data as $st_rlno)
		{
			echo $st_rlno['grn_no']."\n";
		}	
	}
	public function get_po_no_list()
	{
		$atten_inputs = $this->input->get();
			
		$this->load->model('gen/gen_model');
		$data = $this->gen_model->get_all_po_no($atten_inputs);
		foreach($data as $st_rlno)
		{
			echo $st_rlno['po_no']."\n";
		}	
	}
	public function get_grn_no_list()
	{
		$atten_inputs = $this->input->get();
			
		$this->load->model('gen/gen_model');
		$data = $this->gen_model->get_all_grn_no($atten_inputs);
		foreach($data as $st_rlno)
		{
			echo $st_rlno['grn_no']."\n";
		}	
	}
	public function view_po()
	{
		$input=$this->input->get();
		$this->load->model('po/gen_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$this->load->model('gen_model');
		//$data["last_id"]=$this->master_model->get_last_id('grn_code');
		//last insert number
	//	$no[1]=substr($data["last_id"][0]['value'],4);
		$data["from"]=0;
		$data["last_id"]=$this->master_model->get_last_id('grn_code');

		$no[1]=substr($data["last_id"][0]['value'],3);
		if(date('m')>3)
		{
			$check_no='GRN'.date('y').(date('y')+1);
			$check_res=$this->gen_model->check_po_no1($check_no);
			if(empty($check_res))
			{
				$data['last_no']='GRN'.date('y').(date('y')+1).'0001';
			}
			else
				$data['last_no']='GRN'.date('y').(date('y')+1).str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
		}else
		{
			$check_no='GRN'.(date('y')-1).date('y');
			$check_res=$this->gen_model->check_po_no($check_no);
			if(empty($check_res))
			{
				$data['last_no']='GRN'.(date('y')-1).date('y').'0001';
			}
			$data['last_no']='GRN'.(date('y')-1).date('y').str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
		}
		$data['check']=$this->gen_model->check_po_in_gen($input['po']);
		
		if(isset($data['check']) && !empty($data['check']))
		{
			$this->load->model('po/gen_model');
			$this->load->model('master_state/master_state_model');
			$this->load->model('master_style/master_model');
			$this->load->model('stock/stock_model');
			$data['gen_info']=$this->gen_model->get_gen_by_id_po($input['po']);
			$data['gen_no']=$this->gen_model->get_gen_by_po($input['po']);
			$data['all_state']=$this->master_state_model->get_all_state();
			$data['all_style']=$this->master_model->get_style();
			$data['all_color']=$this->stock_model->get_all_color();
			echo $this->load->view('po/gen_edit_view_only',$data);
		}
		else
		{
			$data['gen_info']=$this->gen_model->get_gen_by_id_po($input['po']);
			$data['all_state']=$this->master_state_model->get_all_state();
			$data['all_style']=$this->master_model->get_style();
			$data['all_color']=$this->stock_model->get_all_color();
			$this->load->view('po/gen_edit_only',$data);
		}
	}
	public function barcode_scanner_grn()
	{
		$input=$this->input->post();
		$this->load->model('po/gen_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$this->load->model('gen_model');
		//$data["last_id"]=$this->master_model->get_last_id('grn_code');
		//last insert number
	//	$no[1]=substr($data["last_id"][0]['value'],4);
		
		$data["last_id"]=$this->master_model->get_last_id('grn_code');
		$data["from"]=1;
		$no[1]=substr($data["last_id"][0]['value'],3);
		if(date('m')>3)
		{
			$check_no='GRN'.date('y').(date('y')+1);
			$check_res=$this->gen_model->check_po_no1($check_no);
			if(empty($check_res))
			{
				$data['last_no']='GRN'.date('y').(date('y')+1).'0001';
			}
			else
				$data['last_no']='GRN'.date('y').(date('y')+1).str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
		}else
		{
			$check_no='GRN'.(date('y')-1).date('y');
			$check_res=$this->gen_model->check_po_no($check_no);
			if(empty($check_res))
			{
				$data['last_no']='GRN'.(date('y')-1).date('y').'0001';
			}
			$data['last_no']='GRN'.(date('y')-1).date('y').str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
		}
		$data['check']=$this->gen_model->check_po_in_gen($input['po']);
		
		if(isset($data['check']) && !empty($data['check']))
		{
			$this->load->model('po/gen_model');
			$this->load->model('master_state/master_state_model');
			$this->load->model('master_style/master_model');
			$this->load->model('stock/stock_model');
			$data['gen_info']=$this->gen_model->get_gen_by_id_po($input['po']);
			$data['gen_no']=$this->gen_model->get_gen_by_po($input['po']);
			$data['all_state']=$this->master_state_model->get_all_state();
			$data['all_style']=$this->master_model->get_style();
			$data['all_color']=$this->stock_model->get_all_color();
			//echo $this->load->view('po/gen_edit_view_only',$data);
			$this->template->write_view('content', 'po/gen_edit_view_only',$data);
       		$this->template->render(); 
		}
		else
		{
			$data['gen_info']=$this->gen_model->get_gen_by_id_po($input['po']);
			$data['all_state']=$this->master_state_model->get_all_state();
			$data['all_style']=$this->master_model->get_style();
			$data['all_color']=$this->stock_model->get_all_color();
			//$this->load->view('po/gen_edit_only',$data);
			$this->template->write_view('content', 'po/gen_edit_only',$data);
       		$this->template->render(); 
		}
	}
	public function view_po1()
	{
		$input=$this->input->get();
		$this->load->model('po/gen_model');

		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$data['gen_info']=$this->gen_model->get_gen_by_id_po($input['po']);

		$data['gen_no']=$this->gen_model->get_gen_by_po($input['po']);

		$data['all_state']=$this->master_state_model->get_all_state();
		$data['all_style']=$this->master_model->get_style();
		$data['all_color']=$this->stock_model->get_all_color();
		echo $this->load->view('po/gen_edit_view_only',$data);
	}
	public function view_po2()
	{
		$input=$this->input->get();
		$this->load->model('po/gen_model');

		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$data['gen_info']=$this->gen_model->get_gen_by_id_po($input['po']);

		$data['gen_no']=$this->gen_model->get_gen_by_po1($input['po'],$input['grn_no_id']);

		$data['all_state']=$this->master_state_model->get_all_state();
		$data['all_style']=$this->master_model->get_style();
		$data['all_color']=$this->stock_model->get_all_color();
		echo $this->load->view('po/gen_view_only',$data);
	}
	public function search_result()
	{
		$search_data=$this->input->get();
		$this->load->model('gen/gen_model');
		$data['search_data']=$search_data;
		$data['all_gen']=$this->gen_model->get_all_gen($search_data);
		$this->load->view('gen/search_list',$data);
	}
	
   public function po_duplication()
   {
	  
		$this->load->model('gen/gen_model');	
		$input=$this->input->post('value1');
		//print_r($input);exit;
		$validation=$this->gen_model->po_duplication($input);
		$i=0; if($validation){$i=1;}if($i==1){echo "PO Already Delivered";}
	
   }	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
