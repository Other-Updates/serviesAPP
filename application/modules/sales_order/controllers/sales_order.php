<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_order extends MX_Controller {

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
	
	public function index($c_id=NULL,$files=NULL)
	{
		$data['c_id']=$c_id;
		$data['files']=$files;
		$this->load->model('gen/gen_model');
		$this->load->model('sales_order_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$data["last_id"]=$this->master_model->get_last_id('so_code');
		$no[1]=substr($data["last_id"][0]['value'],3);
			if(date('m')>3)
			{
				$check_no='SO'.date('y').(date('y')+1).'0001';
				$check_res=$this->gen_model->check_so_no($check_no);
				if(empty($check_res))
				{
					$data['last_no']='SO'.date('y').(date('y')+1).'0001';
				}
				else
					$data['last_no']='SO'.date('y').(date('y')+1).str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
			}else
			{
				$check_no='SO'.(date('y')-1).date('y').'0001';
				$check_res=$this->gen_model->check_so_no($check_no);
				if(empty($check_res))
				{
					$data['last_no']='SO'.(date('y')-1).date('y').'0001';
				}
				else
					$data['last_no']='SO'.(date('y')-1).date('y').str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
			}
			
		if($this->input->post())
		{
			$input=$this->input->post();	
			//$data["last_id"]=$this->master_model->get_last_id('so_code');
			//$no=explode("O", $data["last_id"][0]['value']);
			//$data['last_no']='SO'.str_pad($no[1]+1, 4, '0', STR_PAD_LEFT);

			$data["last_id"]=$this->master_model->get_last_id('so_code');
			$no[1]=substr($data["last_id"][0]['value'],3);
			if(date('m')>3)
			{
				$check_no='SO'.date('y').(date('y')+1).'0001';
				$check_res=$this->gen_model->check_so_no($check_no);
				if(empty($check_res))
				{
					$data['last_no']='SO'.date('y').(date('y')+1).'0001';
				}
				else
					$data['last_no']='SO'.date('y').(date('y')+1).str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
			}else
			{
				$check_no='SO'.(date('y')-1).date('y').'0001';
				$check_res=$this->gen_model->check_so_no($check_no);
				if(empty($check_res))
				{
					$data['last_no']='SO'.(date('y')-1).date('y').'0001';
				}
				else
					$data['last_no']='SO'.(date('y')-1).date('y').str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
			}
			
			if(empty($files))
				$files='-';
			
			$insert_gen=array('state'=>$input['state'],'customer'=>$input['customer'],'inv_no'=>$input['inv_no'],'inv_date'=>date ('Y-m-d',strtotime($input['inv_date'])),'full_total'=>$input['full_total'][0],'grn_no'=>$data['last_no'],'sp'=>$input['sp'],'st'=>$input['st'],'cst'=>$input['cst'],'vat'=>$input['vat'],'net_final_total'=>$input['net_final_total'],'net_value'=>$input['net_value'],'upload_file'=>$files);
			
		//	echo "<pre>";
		//	print_r($insert_gen);
		//	print_r($this->input->post());
			//	exit;
			$in_id=$this->sales_order_model->insert_gen($insert_gen);
		//	print_r($in_id);
		
			if(date('m')>3)
			{
				$f_year=date('y').(date('y')+1);
			}
			else
			{
				$f_year=(date('y')-1).date('y');
			}
			$this->master_model->update_last_id1($data['last_no'],'so_code');
			
			$check_arrays1=array();
			if(isset($input['color']) && !empty($input['color']))
			{
				$s_arr=array();$sh_arr=array();
				foreach($input['color'] as $key=>$val)
				{
					
					if($val!='Select' && $val!='select' && $val!='0' )
					{
					//	echo $input['style_code'][$key].'<br>';
					//	echo $val.'<br>';
					//	print_r($input['size'][$input['style_code'][$key]][$val]).'<br>';
						if(isset($input['size'][$input['style_code'][$key]][$val]) && !empty($input['size'][$input['style_code'][$key]][$val]))
						{
							foreach($input['size'][$input['style_code'][$key]][$val][$input['lot_no'][$key]] as $s_id=>$s_val)
							{
								$s_arr[]=array('gen_id'=>$in_id,'style_id'=>$input['style_code'][$key],'lot_no'=>$input['lot_no'][$key],'color_id'=>$val,'size_id'=>$s_id,'qty'=>$s_val,'c_mrp'=>$input['mrp'][$key],'c_landed'=>$input['landed'][$key]);
								
								$check_arrays1[$input['style_code'][$key]][$val][$s_id][]=array('gen_id'=>$in_id,'style_id'=>$input['style_code'][$key],'color_id'=>$val,'qty'=>$s_val);
								
								//print_r($input['short_size'][$input['style_code'][$key]][$val][$input['lot_no'][$key]][$s_id]);
								/*if(isset($input['short_size']) && !empty($input['short_size']))
								{
									if($input['short_size'][$input['style_code'][$key]][$val][$input['lot_no'][$key]][$s_id] > $s_val)
									{
										$sh_qty=$input['short_size'][$input['style_code'][$key]][$val][$input['lot_no'][$key]][$s_id]-$s_val;
										$sh_arr[]=array('gen_id'=>$in_id,'style_id'=>$input['style_code'][$key],'lot_no'=>$input['lot_no'][$key],'color_id'=>$val,'size_id'=>$s_id,'qty'=>$sh_qty);
										
									}
								}*/
								
									
								//$insert_stock[]=array('style_id'=>$input['style_code'][$key],'color_id'=>$val,'size_id'=>$s_id,'qty'=>-$s_val,'finacial_year'=>$f_year);
							}
						
						}
					}
				}
				//echo "<pre>";
			//	print_r($input);
				$check_arrays=array();
				if(isset($input['color']) && !empty($input['color']))
				{
					foreach($input['color'] as $key=>$val)
					{
						
						if($val!='Select' && $val!='select' && $val!='0' )
						{
							if(isset($input['short_size'][$input['style_code'][$key]][$val]) && !empty($input['short_size'][$input['style_code'][$key]][$val]))
							{
								foreach($input['short_size'][$input['style_code'][$key]][$val][$input['lot_no'][$key]] as $s_id=>$s_val)
								{
									$check_arrays[$input['style_code'][$key]][$val][$s_id]=array('gen_id'=>$in_id,'style_id'=>$input['style_code'][$key],'color_id'=>$val,'qty'=>$s_val);
								}
							
							}
						}
					}
				}
				
				//print_r($check_arrays);
				if(isset($check_arrays) && !empty($check_arrays))
				{
					foreach($check_arrays as $s_check_key=>$s_check_val)
					{
						foreach($s_check_val as $c_check_key=>$c_check_val)
						{
							
							foreach($c_check_val as $size_key=>$size_val)
							{
								
								$short_qtys=0;
								foreach($check_arrays1[$s_check_key][$c_check_key][$size_key] as $final_val)
								{
									$short_qtys=$short_qtys+$final_val['qty'];
								}
								if($size_val['qty']>$short_qtys)
								{
									$mr=$this->sales_order_model->get_customer_mrp($input['customer'],$s_check_key);
									$sh_arr[]=array('gen_id'=>$in_id,'style_id'=>$s_check_key,'customer_id'=>$input['customer'],'color_id'=>$c_check_key,'size_id'=>$size_key,'qty'=>$size_val['qty']-$short_qtys,'sp'=>$input['sp'],'mrp'=>$mr[0]['mrp'],'inv_date'=>date ('Y-m-d',strtotime($input['inv_date'])));
								}
							}
						}	
					}
				}
				//$this->stock_model->insert_stock_info($insert_stock);
				if(isset($input['update_so_color']) && !empty($input['update_so_color']))
				{
					$so_arr=array();
					foreach($input['update_so_color'] as $key=>$val)
					{
						
						if($val!='Select' && $val!='select' && $val!='0' )
						{
							//	echo $input['style_code'][$key].'<br>';
							if(isset($input['update_so_size'][$input['update_so_style'][$key]][$val]) && !empty($input['update_so_size'][$input['update_so_style'][$key]][$val]))
							{
								foreach($input['update_so_size'][$input['update_so_style'][$key]][$val] as $s_id=>$s_val)
								{
									$so_arr[]=array('so_id'=>$in_id,'style_id'=>$input['update_so_style'][$key],'color_id'=>$val,'size_id'=>$s_id,'qty'=>$s_val);
									//$insert_stock[]=array('style_id'=>$input['style_code'][$key],'color_id'=>$val,'size_id'=>$s_id,'qty'=>-$s_val,'finacial_year'=>$f_year);
								}
							
							}
						}
					}	
					//$this->stock_model->insert_stock_info($insert_stock);
					$this->sales_order_model->upload_salse_order_info($so_arr);
				}
				
				$this->sales_order_model->insert_gen_details($s_arr);
			
				if(isset($sh_arr) && !empty($sh_arr))
				$this->sales_order_model->insert_short_qty_details($sh_arr);
				redirect($this->config->item('base_url').'sales_order/sales_order_list');
			}
		}
		
		
		$data['all_state']=$this->master_state_model->get_all_state();
		$data['all_style']=$this->master_model->get_style();
		$data['all_color']=$this->stock_model->get_all_color();
		$this->template->write_view('content', 'sales_order/index',$data);
        $this->template->render();       
	}
	public function sales_order_list()
	{
		$this->load->model('gen/gen_model');
		$this->load->model('sales_order_model');
		$data['all_gen']=$this->sales_order_model->get_all_gen();
		$this->load->model('master_state/master_state_model');
		$data['all_state']=$this->master_state_model->get_all_state();
		$this->load->model('customer/customer_model');
		$data['all_customer']=$this->customer_model->get_customer();
		$this->template->write_view('content', 'gen_list',$data);
        $this->template->render(); 
	}
	public function edit_sales_order($id)
	{
		$this->load->model('gen/gen_model');
		$this->load->model('sales_order_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		if($this->input->post())
		{
			$input=$this->input->post();
			
			$in_id=$id;
			$update_date=array('full_total'=>$input['full_total'][0],'net_final_total'=>$input['net_final_total'],'net_value'=>$input['net_value']);
			$this->sales_order_model->delete_all_data($id);
			$this->sales_order_model->update_all_data($update_date,$id);
			if(date('m')>3)
			{
				$f_year=date('y').(date('y')+1);
			}
			else
			{
				$f_year=(date('y')-1).date('y');
			}
			if(isset($input['color']) && !empty($input['color']))
			{
				$s_arr=array();
				foreach($input['color'] as $key=>$val)
				{
					
					if($val!='Select' && $val!='select' && $val!='0' )
					{
						if(isset($input['size'][$input['style_code'][$key]][$val]) && !empty($input['size'][$input['style_code'][$key]][$val]))
						{
							foreach($input['size'][$input['style_code'][$key]][$val] as $s_id=>$s_val)
							{
								$s_arr[]=array('gen_id'=>$in_id,'style_id'=>$input['style_code'][$key],'color_id'=>$val,'size_id'=>$s_id,'qty'=>$s_val);
								$insert_stock[]=array('style_id'=>$input['style_code'][$key],'color_id'=>$val,'size_id'=>$s_id,'qty'=>-$s_val,'finacial_year'=>$f_year);
							}
						
						}
					}
				}	
				$this->stock_model->insert_stock_info($insert_stock);
				$this->sales_order_model->insert_gen_details($s_arr);
				redirect($this->config->item('base_url').'sales_order/sales_order_list');
			}
		}
		$data['gen_info']=$this->sales_order_model->get_gen_by_id($id);
		$data['all_state']=$this->master_state_model->get_all_state();
		$data['all_style']=$this->master_model->get_style();
		$data['all_color']=$this->stock_model->get_all_color();
		$this->template->write_view('content', 'sales_order/gen_edit',$data);
        $this->template->render(); 
	}
	public function view_sales_order($id)
	{
		
		
		if($this->input->post())
		{
			$lot_no=$this->input->post('lot_no');
			$this->load->model('gen/gen_model');
			$this->load->model('sales_order_model');
			$this->load->model('master_state/master_state_model');
			$this->load->model('master_style/master_model');
			$this->load->model('stock/stock_model');
			$data['gen_info']=$this->sales_order_model->get_gen_by_id($id,$lot_no);
			$data['all_state']=$this->master_state_model->get_all_state();
			$data['all_style']=$this->master_model->get_style();
			$data['all_color']=$this->stock_model->get_all_color();
			$data['post_data']=$this->input->post();
			$this->template->write_view('content', 'sales_order/view_barcode',$data);
			$this->template->render(); 
		}
		else
		{
			$this->load->model('gen/gen_model');
			$this->load->model('sales_order_model');
			$this->load->model('master_state/master_state_model');
			$this->load->model('master_style/master_model');
			$this->load->model('stock/stock_model');
			$data['gen_info']=$this->sales_order_model->get_gen_by_id($id);
			$data['all_state']=$this->master_state_model->get_all_state();
			$data['all_style']=$this->master_model->get_style();
			$data['all_color']=$this->stock_model->get_all_color();
			$this->template->write_view('content', 'sales_order/gen_view',$data);
			$this->template->render();
		} 
	}
	public function view_barcode($id)
	{
		$this->load->model('gen/gen_model');
		$this->load->model('sales_order_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$data['gen_info']=$this->sales_order_model->get_gen_by_id($id);
		$data['all_state']=$this->master_state_model->get_all_state();
		$data['all_style']=$this->master_model->get_style();
		$data['all_color']=$this->stock_model->get_all_color();
		$this->template->write_view('content', 'sales_order/view_barcode',$data);
        $this->template->render(); 
	}
	public function get_all_customet()
	{
		$this->load->model('gen/gen_model');
		$this->load->model('sales_order/sales_order_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$update_data=$this->input->get();
		$p_data=$this->sales_order_model->get_all_customer_by_id($update_data['s_id']);
		
		$select='';
		$select=$select."<select class='customer class_req' name='customer'  style='width: 170px;'><option value=''>Select</option>";
		if(isset($p_data) && !empty($p_data))
		{
			foreach($p_data as $val1)
			{		
					$select=$select."<option value=".$val1['id'].">".$val1['store_name']."</option>";
			}
		}
		
		$select=$select."</select>";
		if(empty($p_data))
		{
			$select=$select."   <span style='color:red;'>Customer not crerated yet...</span>";
		}
		echo $select;
	}
	public function get_all_style_details_by_id()
	{
		$this->load->model('gen/gen_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$update_data=$this->input->get();
		$p_data=$this->gen_model->get_all_style_details_by_id($update_data['s_id']);
		echo $p_data[0]['style_name'];
	}
	public function get_all_style_details_by_id1()
	{
		$this->load->model('gen/gen_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$update_data=$this->input->get();
		$data=$this->gen_model->get_all_style_details_by_id2($update_data['s_id'],$update_data['c_id'],$update_data['lotno']);
		$land=$this->gen_model->get_land($update_data['s_id'],$update_data['c_id'],$update_data['lotno']);
		//echo "<pre>";
		//print_r($land);
		$input='';
		
		if(isset($data[0]['style_size']) && !empty($data[0]['style_size']))
		{
			$input=$input.'<div style="float:left;" >';
			foreach($data[0]['style_size'] as $val)
			{
				
                $input=$input.'<div style="text-align:center;float:left; width:40px;" >
								<p  style="margin: 0 0 0px;"  >'.$val['size'].'</p>
								<p   style="margin: 0 0 0px;">
									<input type="text" tabindex="-1" class="avail_qty int_val asc_'.$update_data['s_id'].'_'.$update_data['c_id'].'_'.$val['size_id'].'" readonly="readonly" value="'.$val['avail_qty'][0]['qty'].'"  style="width:44px;background-color: rgb(192, 244, 199);"/></p>
								<p   style="margin: 0 0 0px;">
									<input type="text" autocomplete="off" class="s_size cust_qty int_val sc_'.$update_data['s_id'].'_'.$update_data['c_id'].'_'.$val['size_id'].'" id="'.$val['size_id'].'"  style="width:44px;"/></p>
							   </div>&nbsp;';
			}
			$input=$input.'</div><input type="hidden" name="landed[]" value="'.$land[0]['landed'].'">';
		}
		else
			 $input='Size not created yet....';
			 
		echo $input;	 
	}
	public function get_tax()
	{
	$this->load->model('master_state/master_state_model');
	$data=$this->master_state_model->get_state($this->input->get('s_id'));
	echo '-'.$data[0]['st'].'-'.$data[0]['cst'].'-'.$data[0]['vat'];
	}
	public function get_tax_by_customer()
	{
	$this->load->model('customer/customer_model');
	$data=$this->customer_model->get_customer1($this->input->get('s_id'));
	echo '-'.$data[0]['c_st'].'-'.$data[0]['c_cst'].'-'.$data[0]['c_vat'];
	}
	public function get_sp_percentage()
	{
		$this->load->model('customer/customer_model');
		$data=$this->input->get();
		$p_data=$this->customer_model->get_customer1($data['c_id']);
		echo '<input type="text" id="sp" tabindex="-1" readonly="readonly" value="'.$p_data[0]['selling_percent'].'" name="sp" style="width:50px;color:blue;"/>';
	}
	public function get_lot_no_by_style_id()
	{
		$this->load->model('gen/gen_model');
		$data=$this->input->get();
		$p_data=$this->gen_model->get_lot_name($data);
		
		$select='';
		$select=$select."<select  name='lot_no[]'  style='width: 70px;' class='class_req lot_no lotnoclass lot_repeat'><option value=''>Select</option>";
		if(isset($p_data) && !empty($p_data))
		{
			foreach($p_data as $val1)
			{		
					$select=$select."<option value='".$val1['lot_no']."'>".$val1['lot_no']."</option>";
			}
		}
		
		$select=$select."</select>";
		if(empty($p_data))
		{
			$select=$select."   <span style='color:red;'>No Available LOT NO...</span>";
		}
		echo $select;
	}
	public function get_so_list()
	{
		$atten_inputs = $this->input->get();
		$this->load->model('sales_order_model');
		$data = $this->sales_order_model->get_all_so_no($atten_inputs);
		foreach($data as $st_rlno)
		{
			echo $st_rlno['grn_no']."\n";
		}	
	}
	public function search_result()
	{
		$search_data=$this->input->get();
		$this->load->model('sales_order_model');
		$data['search_data']=$search_data;
		$data['all_gen']=$this->sales_order_model->get_all_gen($search_data);
		$this->load->view('sales_order/search_list',$data);
	}
	public function upload_files()
	{
		print_r($_FILES['file']["name"]);
	}
	public function upload_excel()
	{
		if($this->input->post())
		{
		$this->load->helper('text');
			
		$config['upload_path'] = './so_excel_files';
		
		$config['allowed_types'] = '*';
		
		$config['max_size']	= '2000';
		
		$this->load->library('upload', $config);
		
		if(isset($_FILES) && !empty($_FILES))
		{
			$upload_files = $_FILES;
			if($upload_files['upload_files'] !='')
			{
				$_FILES['admin_name'] = array(
				'name' => 'sales_order_format'.'_'.rand().'.xls',
				'type' => $upload_files['upload_files']['type'],
				'tmp_name' => $upload_files['upload_files']['tmp_name'],
				'error' => $upload_files['upload_files']['error'],
				'size' => '2000'
			);
			$this->upload->do_upload('admin_name');
			$upload_data = $this->upload->data();
			}
		}
		redirect($this->config->item('base_url').'sales_order/index/'.$this->input->post('customer').'/'.rawurlencode($upload_data['file_name']));
		}
	}
	public function get_size_for_upload_sales()
	{
		$this->load->model('gen/gen_model');
		$excel = new PhpExcelReader;
		$excel->read('so_excel_files/'.$_GET['files']);
		//echo "<pre>";
		//print_r($excel->sheets[0]['cells']);
		$input='';
		if(isset($excel->sheets[0]['cells']) && !empty($excel->sheets[0]['cells']))
		{
			$i=1;
			foreach($excel->sheets[0]['cells'] as $val)
			{
				if($i==1)
				{
					$first_row=$val;
				}
				else
				{
					
					$t_qty=0;
					$style_name=$col_name='';
					foreach($val as $f_key=>$f_val)
					{
						if($f_key==1)
						{
							$style_name=$f_val;
						}
						if($f_key==2)
						{
							$col_name=$f_val;
						}
						if(strtolower($style_name)==strtolower($_GET['style_text']) && strtolower($col_name)==strtolower($_GET['color_text']) && $f_key!=1 && $f_key!=2)
						{
							$check_avail=$this->gen_model->check_available($_GET['style_id'],$_GET['color_id'],$first_row[$f_key],$_GET['lot_no']);
						$input=$input.'<div style="text-align:center;float:left;" >
										<p  style="margin: 0 0 0px;"  >'.$first_row[$f_key].'</p>
										<p  style="margin: 0 0 0px;">
											<input type="text" tabindex="-1"  class="avail_qty asc_'.$_GET['style_id'].'_'.$_GET['color_id'].'_'.$check_avail[0]['size_id'].'" readonly="readonly" value="'.$check_avail[0]['avail_qty'].'"  style="width:44px;background-color: rgb(192, 244, 199);"/></p>
											<p  style="margin: 0 0 0px;">
											<input type="text" tabindex="-1" class="cust_sales_qty csc_'.$_GET['style_id'].'_'.$_GET['color_id'].'_'.$check_avail[0]['size_id'].'" readonly="readonly" value="'.$f_val.'"   style="width:44px;background-color:rgb(255, 236, 161);"/></p>
										<p  style="margin: 0 0 0px;">
											<input type="text" autocomplete="off"  class="s_size cust_qty int_val sc_'.$_GET['style_id'].'_'.$_GET['color_id'].'_'.$check_avail[0]['size_id'].'"  id="'.$check_avail[0]['size_id'].'"  style="width:44px;"/></p>
									   </div>&nbsp;';
									  
									   
						}
					}
				}
				$i++;
			}
		}
		$land=$this->gen_model->get_land($_GET['style_id'],$_GET['color_id'],$_GET['lot_no']);
		$input=$input.'<input type="hidden" name="landed[]" value="'.$land[0]['landed'].'">';
		 echo $input;
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
