<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchase_invoice_receipt extends MX_Controller {

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
		$this->load->model('purchase_invoice_receipt_model');
		$this->load->model('customer/customer_model');
		$this->load->model('customer/agent_model');
		$this->load->model('master_style/master_model');
		$data["last_id"]=$this->master_model->get_last_id('pr_code');
		$no[1]=substr($data["last_id"][0]['value'],3);
		if(date('m')>3)
		{
			$check_no='PR'.date('y').(date('y')+1).'0001';
			$check_res=$this->purchase_invoice_receipt_model->check_so_no($check_no);
			if(empty($check_res))
			{
				$data['last_no']='PR'.date('y').(date('y')+1).'0001';
			}
			else
				$data['last_no']='PR'.date('y').(date('y')+1).str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
		}else
		{
			$check_no='PR'.(date('y')-1).date('y').'0001';
			$check_res=$this->purchase_invoice_receipt_model->check_so_no($check_no);
			if(empty($check_res))
			{
				$data['last_no']='PR'.(date('y')-1).date('y').'0001';
			}
			else
				$data['last_no']='PR'.(date('y')-1).date('y').str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
		}
		if($this->input->post())
		{
			$input=$this->input->post();
			
			$this->purchase_invoice_receipt_model->update_invoice_status($input['inv_no']);
			if($input['balance']==0)
				$input['receipt']['complete_status']=1;
			else
				$input['receipt']['complete_status']=0;
			//$input['receipt']['due_date']=date('Y-m-d',strtotime($input['receipt']['due_date']));
			
			$data["last_id"]=$this->master_model->get_last_id('pi_code');
			$no[1]=substr($data["last_id"][0]['value'],3);
			if(date('m')>3)
			{
				$check_no='PR'.date('y').(date('y')+1).'0001';
				$check_res=$this->purchase_invoice_receipt_model->check_so_no($check_no);
				if(empty($check_res))
				{
					$data['last_no']='PR'.date('y').(date('y')+1).'0001';
				}
				else
					$data['last_no']='PR'.date('y').(date('y')+1).str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
			}else
			{
				$check_no='PR'.(date('y')-1).date('y').'0001';
				$check_res=$this->purchase_invoice_receipt_model->check_so_no($check_no);
				if(empty($check_res))
				{
					$data['last_no']='PR'.(date('y')-1).date('y').'0001';
				}
				else
					$data['last_no']='PR '.(date('y')-1).date('y').str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
			}
			$this->purchase_invoice_receipt_model->update_receipt_id($data['last_no']);
			
			
			
			$input['receipt']['receipt_no']=$data['last_no'];
			if(isset($input['inv_no']) && !empty($input['inv_no']))
			{
				$i=0;$order_list='';
				foreach($input['inv_no'] as $key=>$val)
				{
					
					if($i==0)
					{
						$order_list=$order_list.$val;
						$i=1;
					}
					else
						$order_list=$order_list.'-'.$val;
				}
			}
			$input['receipt']['inv_list']=$order_list;
			//echo "<pre>";
			
			$insert_id=$this->purchase_invoice_receipt_model->insert_receipt($input['receipt']);	
			$input['receipt_bill']['receipt_id']=$insert_id;
			//print_r($insert_id);
			//print_r($input);
			$insert_id=$this->purchase_invoice_receipt_model->insert_receipt_bill($input['receipt_bill']);	
			redirect($this->config->item('base_url').'purchase_invoice_receipt/purchase_invoice_receipt_list');
		}	
		
		$this->load->model('vendor/vendor_model');
		$data['all_supplier']=$this->vendor_model->get_vendor();
		$data['all_customer']=$this->customer_model->get_customer();
		$data['all_agent']=$this->agent_model->get_agent();
		$this->template->write_view('content', 'purchase_invoice_receipt/index',$data);
        $this->template->render();       
	}
	public function purchase_invoice_receipt_list()
	{
		$this->load->model('purchase_invoice_receipt_model');
		$data['all_receipt']=$this->purchase_invoice_receipt_model->get_all_receipt();
		$this->template->write_view('content', 'purchase_invoice_receipt_list',$data);
        $this->template->render(); 
	}
	public function get_package_by_customer_id()
	{
		$this->load->model('package/package_model');
		$c_id=$this->input->get('c_id');
		$data['package']=$this->package_model->get_package_by_customer($c_id);

		$this->load->view('package/package_info',$data);
	}
	public function get_all_pending_invoice()
	{
		$this->load->model('purchase_invoice_receipt_model');
		$this->load->model('customer/customer_model');
		$c_id=$this->input->get('c_id');
		$data['pending_inv']=$this->purchase_invoice_receipt_model->get_invoice_for_receipt($c_id);
		//echo "<pre>";
		//print_r($data['pending_inv']);
		///exit;
		$table='<table>';
	    if(isset($data['pending_inv']) && !empty($data['pending_inv']))
		{
			foreach($data['pending_inv'] as $val)
			{
				$table=$table."<tr><td><input type='checkbox' name='inv_no[]' class='so_id' checked='checked' value='".$val['p_id']."' />&nbsp;&nbsp;".$val['receipt_no']."</td><td></td></tr>";
			}
		}
		else
		{
			$table=$table.'<tr>Invoice Not Created Yet</tr>';
		}
		$table=$table.'</table>';
		echo $table;
	}
	public function get_invoice_view()
	{
		$this->load->model('purchase_invoice_receipt_model');
		$this->load->model('admin/admin_model');
		$c_id=$this->input->get('c_id');
		$data['pending_inv']=$this->purchase_invoice_receipt_model->get_invoice_for_receipt($c_id);
		$data['company_details']=$this->admin_model->get_company_details();
		$table='<table>';
		//echo "<pre>";
		//print_r($data);
		//exit;
	    if(isset($data['pending_inv']) && !empty($data['pending_inv']))
		{
			$i=1;
			$total=0;
			$org_value=0;
			//echo"<pre>";
			foreach($data['pending_inv'] as $val)
			{
				//print_r($val);
				$total=$total+round($val['total_amount'],2);
				$table=$table."<tr><td>".$i."</td><td>".$val['receipt_no']."</td><td>".$val['inv_no']."</td><td>".date('d-M-Y',strtotime($val['inv_date']))."</td><td>".date('d-M-Y',strtotime($val['due_date']))."</td><td  >". $val['total_amount']."</td></tr>";
				$i++;
			}
			
			
			$table=$table."<tr><td colspan='5' style='text-align: right;'>Invoice Total</td><td  style='text-align: right;'><input id='inv_amount'  class='form-control' style=' width:150px ;float:left;' type='text' readonly='readonly'  name='receipt[total_amount]' value='".round($total,2)."' /></td></tr>";
			$table=$table."<tr  style='display:none'><td colspan='5' style='text-align: right;'>Discount<input type='text' id='dis_per'  style=' width:70px ;' name='receipt_bill[discount_per]'>%</td><td  style='align: right;'><input id='discount' readonly='readonly'  class='form-control int_val' style=' width:150px ;float:left;' type='text'  name='receipt_bill[discount]' /></td></tr>";
			
			$table=$table."<tr><td colspan='5' style='text-align: right;'>Payment Terms</td><td  style='align: right;'>
								<select class='form-control' id='terms' name='receipt_bill[terms]'>
									<option value='1'>Cash</option>
									<option value='2'>DD</option>
									<option value='3'>Cheque</option>
									<option value='4'>NEFD</option>
									<option value='5'>RTGS</option>
								</select>
							   </td>
						    </tr>";
			$table=$table."<tr class='show_tr' style='display:none'><td colspan='5' style='text-align: right;'>A/C</td><td  style='align: right;'><input id='ac_no'  class='form-control' style=' width:150px ;float:left;' value='".$data['company_details'][0]['ac_no']."' type='text'  name='receipt_bill[ac_no]'  readonly='readonly' /><span id='recipterror5' style='color:#F00;'></span></td></tr>";
			$table=$table."<tr class='show_tr' style='display:none'><td colspan='5' style='text-align: right;'>Branch</td><td  style='align: right;'><input id='branch'  class='form-control' style=' width:150px ;float:left;' type='text' value='".$data['company_details'][0]['branch']."' readonly='readonly' name='receipt_bill[branch]' /><span id='recipterror6' style='color:#F00;'></span></td></tr>";
			$table=$table."<tr  class='show_tr' style='display:none'><td colspan='5' style='text-align: right;'>DD / Cheque NO</td><td  style='align: right;'><input id='dd_no'  class='form-control ddduplication' style=' width:150px ;float:left;' type='text'  name='receipt_bill[dd_no]' /><span id='recipterror7' style='color:#F00;'></span><span id='ddduperror' style='color:#F00;'></span></td></tr>";
			
			$table=$table."<tr><td colspan='5' style='text-align: right;'>Paid Amount</td><td  style='align: right;'><input id='paid'  class='form-control' type='text'  style=' width:150px ;float:left;'  name='receipt_bill[bill_amount]'  /><span id='recipterror4' style='color:#F00;'></span></td></tr>";
			
			$table=$table."<tr><td colspan='5' style='text-align: right;'>Balance</td><td  style='align: right;'><input id='balance'  class='form-control' type='text'  style=' width:150px ;float:left;'  name='balance'   value='".round($total,2)."'  readonly='readonly' /></td></tr>";
			$table=$table.'<tr><td  colspan="5"> <input  style="float: right;"   type="submit" class="btn btn-success submit" value="Pay" /> </td></tr>';
			
		}
		else
		{
			$table=$table.'<tr>Invoice Not Created Yet</tr>';
		}
		$table=$table.'</table>';
		echo $table;
		
	}
	public function get_inv()
	{
		$this->load->model('purchase_invoice_receipt_model');
		$data=$this->input->get();
		$this->load->model('admin/admin_model');
		$data['company_details']=$this->admin_model->get_company_details();
		$data['pending_inv']=$this->purchase_invoice_receipt_model->get_invoice_for_receipt1($data);
		$table='<table>';
	   if(isset($data['pending_inv']) && !empty($data['pending_inv']))
		{
			$i=1;
			$total=0;
			$org_value=0;
			//echo"<pre>";
			foreach($data['pending_inv'] as $val)
			{
				//print_r($val);
				$total=$total+round($val['total_amount'],2);
				$table=$table."<tr><td>".$i."</td><td>".$val['receipt_no']."</td><td>".$val['inv_no']."</td><td>".date('d-M-Y',strtotime($val['inv_date']))."</td><td>".date('d-M-Y',strtotime($val['due_date']))."</td><td  >". $val['total_amount']."</td></tr>";
				$i++;
			}
			
			
			$table=$table."<tr><td colspan='5' style='text-align: right;'>Invoice Total</td><td  style='text-align: right;'><input id='inv_amount'  class='form-control' style=' width:150px ;float:left;' type='text' readonly='readonly'  name='receipt[total_amount]' value='".round($total,2)."' /></td></tr>";
			$table=$table."<tr  style='display:none'><td colspan='5' style='text-align: right;'>Discount <input type='text' id='dis_per'  style=' width:70px ;' name='receipt_bill[discount_per]'>%</td><td  style='align: right;'><input id='discount'  class='form-control int_val' style=' width:150px ;float:left;' type='text' readonly='readonly'  name='receipt_bill[discount]' /></td></tr>";
			
			$table=$table."<tr><td colspan='5' style='text-align: right;'>Payment Terms</td><td  style='align: right;'>
								<select class='form-control' id='terms' name='receipt_bill[terms]'>
									<option value='1'>Cash</option>
									<option value='2'>DD</option>
									<option value='3'>Cheque</option>
									<option value='4'>NEFD</option>
									<option value='5'>RTGS</option>
								</select>
							   </td>
						    </tr>";
			$table=$table."<tr class='show_tr' style='display:none'><td colspan='5' style='text-align: right;'>A/C</td><td  style='align: right;'><input id='ac_no'  class='form-control' style=' width:150px ;float:left;' value='".$data['company_details'][0]['ac_no']."' type='text'  name='receipt_bill[ac_no]'  readonly='readonly' /><span id='recipterror5' style='color:#F00;'></span></td></tr>";
			$table=$table."<tr class='show_tr' style='display:none'><td colspan='5' style='text-align: right;'>Branch</td><td  style='align: right;'><input id='branch'  class='form-control' style=' width:150px ;float:left;' type='text' value='".$data['company_details'][0]['branch']."' readonly='readonly' name='receipt_bill[branch]' /><span id='recipterror6' style='color:#F00;'></span></td></tr>";
			$table=$table."<tr  class='show_tr' style='display:none'><td colspan='5' style='text-align: right;'>DD / Cheque NO</td><td  style='align: right;'><input id='dd_no'  class='form-control ddduplication' style=' width:150px ;float:left;' type='text'  name='receipt_bill[dd_no]' /><span id='recipterror7' style='color:#F00;'></span><span id='ddduperror' style='color:#F00;'></span></td></tr>";
			
			$table=$table."<tr><td colspan='5' style='text-align: right;'>Paid Amount</td><td  style='align: right;'><input id='paid'  class='form-control int_val' type='text'  style=' width:150px ;float:left;'  name='receipt_bill[bill_amount]'  /><span id='recipterror4' style='color:#F00;'></span></td></tr>";
			
			$table=$table."<tr><td colspan='5' style='text-align: right;'>Balance</td><td  style='align: right;'><input id='balance'  class='form-control' type='text'  style=' width:150px ;float:left;'  name='balance'   value='".round($total,2)."'  readonly='readonly' /></td></tr>";
			$table=$table.'<tr><td  colspan="5"> <input  style="float: right;"   type="submit" class="btn btn-success submit" value="Pay" /> </td></tr>';
			
		}
		else
		{
			$table=$table.'<tr>Invoice Not Created Yet</tr>';
		}
		$table=$table.'</table>';
		echo $table;
		
		
	}
	public function update_receipt($r_id)
	{
		$this->load->model('purchase_invoice_receipt/purchase_invoice_receipt_model');
		
		if($this->input->post())
		{
			$input=$this->input->post();
			if($input['balance']==0)
				$input['receipt']['complete_status']=1;
			else
				$input['receipt']['complete_status']=0;
			
			
			$insert_id=$this->purchase_invoice_receipt_model->update_receipt(array('complete_status'=>$input['receipt']['complete_status']),$r_id);	
			$input['receipt_bill']['receipt_id']=$r_id;
		
			$insert_id=$this->purchase_invoice_receipt_model->insert_receipt_bill($input['receipt_bill']);	
			
			redirect($this->config->item('base_url').'purchase_invoice_receipt/purchase_invoice_receipt_list');
		}
		$data['receipt_details']=$this->purchase_invoice_receipt_model->get_receipt_by_id($r_id);
		
		$this->template->write_view('content', 'update_purchase_invoice_receipt',$data);
        $this->template->render(); 
	}
	public function view_receipt($r_id)
	{
		$this->load->model('purchase_invoice_receipt/purchase_invoice_receipt_model');
		$data['receipt_details']=$this->purchase_invoice_receipt_model->get_receipt_by_id($r_id);
		$this->template->write_view('content', 'view_purchase_invoice_receipt',$data);
        $this->template->render(); 
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
		$data['package']=$this->package_model->get_package_by_so($c_id,$so_id);
		$this->load->view('package/package_info',$data);
	}
	public function get_rp_list()
	{
		$atten_inputs = $this->input->get();
		$this->load->model('receipt_model');
		$data = $this->receipt_model->get_all_rp_no($atten_inputs);
		foreach($data as $st_rlno)
		{
			echo $st_rlno['receipt_no']."\n";
		}	
	}
	public function search_result_for_receipt()
	{
		$get_val=$this->input->get();
		$this->load->model('receipt/receipt_model');
		$data['all_receipt']=$this->receipt_model->get_all_receipt($get_val);
		$data['search_data']=$get_val;
		echo $this->load->view('receipt/receipt_ajax_report',$data);
	}
	public function checking_invoice_checkno()
	{
		
		$this->load->model('purchase_invoice_receipt/purchase_invoice_receipt_model');
		$input=$this->input->post('value1');
		 //print_r($input); exit;
		$validation=$this->purchase_invoice_receipt_model->checking_invoice_checkno($input);
		
		$i=0;
		if($validation)
		{
			$i=1;
		}
		if($i==1)
		{
			echo "CheckNo Already Exist";
		}
	}
	public function update_checking_invoice_checkno()
	{
		
		$this->load->model('purchase_invoice_receipt/purchase_invoice_receipt_model');
		$input=$this->input->post('value1');
		 //print_r($input); exit;
		$validation=$this->purchase_invoice_receipt_model->update_checking_invoice_checkno($input);
		
		$i=0;
		if($validation)
		{
			$i=1;
		}
		if($i==1)
		{
			echo "CheckNo Already Exist";
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
