<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Po extends MX_Controller {

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
		$this->load->model('po/gen_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$this->load->model('master_style/master_model');
		if($this->input->post())
		{
			$input=$this->input->post();
			//echo "<pre>";
			//print_r($input);
			//exit;
			$input['inv_date'] = date ('Y-m-d',strtotime($input['inv_date']) );
			$data["last_id"]=$this->master_model->get_last_id('po_code');
			
			$data["last_id"]=$this->master_model->get_last_id('po_code');
			$no[1]=substr($data["last_id"][0]['value'],3);
			if(date('m')>3)
			{
				$check_no='PO'.date('y').(date('y')+1);
				
				$check_res=$this->gen_model->check_po_no($check_no);
				if(empty($check_res))
				{
					$data['last_no']='PO'.date('y').(date('y')+1).'0001';
				}
				else
					$data['last_no']='PO'.date('y').(date('y')+1).str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
			}
			else
			{
				$check_no='PO'.(date('y')-1).date('y');
				$check_res=$this->gen_model->check_po_no($check_no);
				if(empty($check_res))
				{
					$data['last_no']='PO'.(date('y')-1).date('y').'0001';
				}
				else
				$data['last_no']='PO'.(date('y')-1).date('y').str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
			}
		
			$insert_gen=array('state'=>$input['state'],'customer'=>$input['customer'],'full_total'=>$input['full_total'][0],'grn_no'=>$data['last_no'],'org_total'=>$input['org_total'],'net_total'=>$input['net_total'],'lot_no'=>$input['lot_no'],'st'=>$input['st'],'cst'=>$input['cst'],'vat'=>$input['vat'],'remarks'=>$input['remarks'],'delivery_schedule'=>$input['delivery_schedule'],'delivery_at'=>$input['delivery_at'],'mode_of_payment'=>$input['mode_of_payment'],'inv_date'=>$input['inv_date']);
			
			$in_id=$this->gen_model->insert_gen($insert_gen);
			$this->master_model->update_last_id1($data['last_no'],'po_code');
			
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
								$s_landed=$this->master_model->get_landed_cost($input['style_all'][$key]);
								//print_r($s_landed);
								//exit;
								$s_arr[]=array('gen_id'=>$in_id,'style_id'=>$input['style_all'][$key],'color_id'=>$val,'lot_no'=>$input['style_lot_no'][$key],'size_id'=>$s_id,'qty'=>$s_val,'landed'=>$s_landed[0]['sp']);
							}
						
						}
					}
				}	
				$this->gen_model->insert_gen_details($s_arr);
			//	print_r($s_arr);
				//exit;
				redirect($this->config->item('base_url').'po/po_list');
			}
		}
		
		$data["last_id"]=$this->master_model->get_last_id('po_code');
		$no[1]=substr($data["last_id"][0]['value'],3);
		//echo $no[1];
		if(date('m')>3)
		{
			$check_no='PO'.date('y').(date('y')+1);
			
			$check_res=$this->gen_model->check_po_no($check_no);
			if(empty($check_res))
			{
				$data['last_no']='PO'.date('y').(date('y')+1).'0001';
			}
			else
				$data['last_no']='PO'.date('y').(date('y')+1).str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
		}else
		{
			$check_no='PO'.(date('y')-1).date('y');
			$check_res=$this->gen_model->check_po_no($check_no);
			if(empty($check_res))
			{
				$data['last_no']='PO'.(date('y')-1).date('y').'0001';
			}
			$data['last_no']='PO'.(date('y')-1).date('y').str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
		}
		//$data['last_no']='PO'.str_pad($no[1]+1, 4, '0', STR_PAD_LEFT);
		$data['all_state']=$this->master_state_model->get_all_state();
		$data['all_style']=$this->master_model->get_all_lot_style();
		$data['all_color']=$this->stock_model->get_all_color();
		$this->template->write_view('content', 'po/index',$data);
        $this->template->render();       
	}
	public function po_list()
	{
		$this->load->model('po/gen_model');
		$this->load->model('master_style/master_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('vendor/vendor_model');
		$data['all_style']=$this->master_model->get_all_lot_style();
		$data['all_supplier']=$this->vendor_model->get_vendor();
		$data['all_gen']=$this->gen_model->get_all_gen();
		$this->template->write_view('content', 'po/gen_list',$data);
        $this->template->render(); 
	}
	public function edit_gen($id)
	{
		$this->load->model('po/gen_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		if($this->input->post())
		{
			$input=$this->input->post();
			$in_id=$id;
			$update_date=array('full_total'=>$input['full_total'][0],'net_total'=>$input['net_total'],'remarks'=>$input['remarks'],'delivery_schedule'=>$input['delivery_schedule'],'delivery_at'=>$input['delivery_at'],'mode_of_payment'=>$input['mode_of_payment']);
			$s_landed=$this->master_model->get_landed_cost1($id);	
			
			$this->gen_model->delete_all_data($id);	
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
								//$s_landed=$this->master_model->get_landed_cost($input['style_all'][$key]);
								
								$s_arr[]=array('gen_id'=>$in_id,'style_id'=>$input['style_all'][$key],'lot_no'=>$input['style_lot_no'][$key],'color_id'=>$val,'size_id'=>$s_id,'qty'=>$s_val,'landed'=>$s_landed[0]['landed']);
							}
						
						}
					}
				}	
			}
			$this->gen_model->insert_gen_details($s_arr);
			redirect($this->config->item('base_url').'po/po_list');
		}
		$data['gen_info']=$this->gen_model->get_gen_by_id($id);
		$data['all_state']=$this->master_state_model->get_all_state();
		$data['all_style']=$this->master_model->get_all_lot_style();
		$data['all_color']=$this->stock_model->get_all_color();
		$this->template->write_view('content', 'po/gen_edit',$data);
        $this->template->render(); 
	}
	public function view_gen($id)
	{
		$this->load->model('po/gen_model');
		$this->load->model('admin/admin_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$data['gen_info']=$this->gen_model->get_gen_by_id($id);
		$data['all_state']=$this->master_state_model->get_all_state();
		$data['all_style']=$this->master_model->get_style();
		$data['all_color']=$this->stock_model->get_all_color();
		$data['company_details']=$this->admin_model->get_company_details();
		$this->template->write_view('content', 'po/gen_view',$data);
        $this->template->render(); 
	}
	public function get_all_customet()
	{
		$this->load->model('po/gen_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$update_data=$this->input->get();
		$p_data=$this->gen_model->get_all_customer_by_id($update_data['s_id']);
		
		$select='';
		$select=$select."<select class='customer class_req' name='customer'  style='width: 170px;'><option value=''>Select</option>";
		if(isset($p_data) && !empty($p_data))
		{
			foreach($p_data as $val1)
			{		
					$select=$select."<option value=".$val1['id'].">".$val1['name']."</option>";
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
		$this->load->model('po/gen_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$update_data=$this->input->get();
		$data['color']=$this->gen_model->get_all_color_details_by_id($update_data['s_id']);
		if(isset($data['color']) && !empty($data['color']))
		{
			$select='<select name="color[]"  class="color_class color_cmp"><option value="">Select</option>';
			foreach($data['color'] as $val)
			{
				 $select=$select."<option value=".$val['id'].">".$val['colour']."</option>";
			}
			$select=$select.'</select>';
		}
		echo $select;
	}
	public function get_all_style_details_by_id1()
	{
		$this->load->model('po/gen_model');
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
                $input=$input.'<div style="text-align:center;float:left;" ><p  style="margin: 0 0 0px;"  >'.$val['size'].'</p><p   style="margin: 0 0 0px;"><input type="text"  autocomplete="off" class="s_size" id="'.$val['size_id'].'"  style="width:50px;"</p></div>&nbsp;';
			}
		}
		else
			 $input='Size not created yet....';
			 
		echo $input;	 
	}
	public function get_all_style_details_by_id2()
	{
		$this->load->model('po/gen_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$update_data=$this->input->get();
		$p_data=$this->gen_model->get_all_style_details_by_id($update_data['s_id']);
		$values=$p_data[0]['mrp'];
		echo '<input type="text" readonly="readonly" style="width:70px;" value="'.$values.'" class="total_mrp1" />';
	}
	public function get_lot_no()
	{
		$this->load->model('po/gen_model');
		$lot_no=$this->input->get();
		if(date('m')>3)
		{
			$last_no='LOT '.date('y').(date('y')+1).strtoupper(substr($lot_no['s_name'],0,3));
		}
		else
		{
			$last_no='LOT '.(date('y')-1).date('y').strtoupper(substr($lot_no['s_name'],0,3));
		}
		$d_val=$this->gen_model->get_last_lot($last_no);

		if($d_val==0)
		{
			$final_no=$last_no.'0001';
		}
		else
		{
			$final_no=$last_no.str_pad($d_val+1, 4, '0', STR_PAD_LEFT);
		}
		echo $final_no;
	}
	public function search_result()
	{
		$search_data=$this->input->get();
		$this->load->model('po/gen_model');
		$data['search_data']=$search_data;
		$data['all_gen']=$this->gen_model->get_all_gen($search_data);
		$this->load->view('po/search_list',$data);
	}
	public function test_email()
	{
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		$this->email->from('noreply@email.com', 'Cotton Colors');
		$this->email->to('prince.ella@gmail.com'); 
		$this->email->subject('PO 14150001 Created');
		$this->email->set_mailtype("html");
		$data['test']=0;
		$msg = $this->load->view('po/test_email',$data,TRUE);
		$this->email->message($msg);
		$this->email->send();
		echo $msg;
	}
	public function send_email()
	{
		
	    $this->load->library("Pdf");
		$this->load->model('po/gen_model');
		$this->load->model('admin/admin_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$id=$this->input->get();
		$data['gen_info']=$this->gen_model->get_gen_by_id($id['po_id']);
		$data['all_state']=$this->master_state_model->get_all_state();
		$data['all_style']=$this->master_model->get_style();
		$data['all_color']=$this->stock_model->get_all_color();
		$data['company_details']=$this->admin_model->get_company_details();	
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		$this->email->from('noreply@email.com', 'IMS');
		$to_array=array('',$data['company_details'][0]['email'],$data['gen_info'][0]['email_id']);
		$this->email->to($to_array); 
		//$this->email->to(',elavarasan.i2sts@gmail.com'); 
		$this->email->subject($data['gen_info'][0]['grn_no'].' Created');
		$this->email->set_mailtype("html");
		$msg1['test'] = $this->load->view('po/email_page',$data,TRUE);
		$msg1['company_details']=$data['company_details'];
		
		$msg = $this->load->view('po/pdf_email_template',$msg1,TRUE);
		
		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);    
 
		$pdf->AddPage(); 
		
   		$pdf->writeHTMLCell(0, 0, '', '', $msg, 0, 1, 0, true, '', true);  
		
		$newFile  = $this->config->item('theme_path').'attachement/'.$data['gen_info'][0]['grn_no'].'.pdf';
		
		$pdf->Output($newFile, 'F');
		
		$this->email->attach($this->config->item('theme_path').'attachement/'.$data['gen_info'][0]['grn_no'].'.pdf');
		$this->email->message('Dear sir,<br>Kindly find the attachment for purchase order '.$data['gen_info'][0]['grn_no']);
		$this->email->send();
	
	}
	public function force_to_complete($from)
	{
		$this->load->model('po/gen_model');
		$this->gen_model->force_to_complete_po($this->input->post());
		if($from==1)
			redirect($this->config->item('base_url').'po/po_list');
		else
			redirect($this->config->item('base_url').'report/purchase_report');
	}
	public function get_tin()
	{	
		$this->load->model('vendor/vendor_model'); 
		$data["vendor"]=$this->vendor_model->get_vendor1($this->input->get('s_id'));
		echo $data["vendor"][0]['tin'];
	}
	public function get_tin1()
	{	
		$this->load->model('customer/customer_model');
		$data["customer"]=$this->customer_model->get_customer1($this->input->get('s_id'));
		echo $data["customer"][0]['tin'];
	}
	public function get_lot_no_by_color()
	{
		$this->load->model('po/gen_model');
		$lot_no=$this->input->get();
		$my_no=$this->input->get();
		if(date('m')>3)
		{
			$last_no='LOT'.date('y').(date('y')+1).strtoupper(substr($lot_no['s_name'],0,3)).strtoupper(substr($lot_no['c_name'],0,3));
		}
		else
		{
			$last_no='LOT'.(date('y')-1).date('y').strtoupper(substr($lot_no['s_name'],0,3)).strtoupper(substr($lot_no['c_name'],0,3));
		}
		
	
		$d_val=$this->gen_model->get_last_lot_no($last_no,$my_no);
		

		
		$ll=substr($d_val[0]['lot_no'],13,17);
		
		if(isset($ll) && !empty($ll))
		{
			$final_no=$last_no.str_pad($ll+1, 4, '0', STR_PAD_LEFT);
		}
		else
		{
			$final_no=$last_no.'0001';
		}
		echo $final_no;
	}
	public function get_baroode()
	{
		$data['code']=$this->input->post();
		$this->load->model('master_size/master_size_model');
		$all_size=$this->master_size_model->get_all_size();
		foreach($all_size as $vv)
		{
			$xx[$vv['id']]=$vv['size'];
		}
		$data['all_size']=$xx;
		$this->template->write_view('content', 'po/view_barcode',$data);
        $this->template->render();
		
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */