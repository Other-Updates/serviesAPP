<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Commission extends MX_Controller {

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
		$this->load->model('commission/commission_model');
		$this->load->model('customer/agent_model');
		$this->load->model('master_style/master_model');
		
		if($this->input->post())
		{
			$input=$this->input->post();
			
			if($input['balance']==0)
			{
				$input['commission']['complete_status']=1;	
			}
			else
				$input['commission']['complete_status']=0;
				
			$insert_id=$this->commission_model->insert_commission($input['commission']);	
			
			$this->commission_model->update_commission1($input['commission']['receipt_list']);	
			
			if($input['balance']==0)
			{
				$input['commission']['complete_status']=1;
				$this->commission_model->update_commission(array('complete_status'=>$input['receipt']['complete_status']),$input['commission']['receipt_list']);	
			}
			else
				$input['commission']['complete_status']=0;
			
			$input['commission_bill']['comm_id']=$insert_id;
			//print_r($insert_id);
			//print_r($input);
			$insert_id=$this->commission_model->insert_commission_bill($input['commission_bill']);	
			
			redirect($this->config->item('base_url').'commission/commission_list');
		}	
	
		$data['all_agent']=$this->agent_model->get_agent();
		$this->template->write_view('content', 'commission/index',$data);
        $this->template->render();       
	}
	public function commission_list()
	{
		$this->load->model('commission/commission_model');
		$data['all_receipt']=$this->commission_model->get_all_commission();
		//echo "<pre>";
		//print_r($data);
		//exit;
		$this->template->write_view('content', 'commission_list',$data);
        $this->template->render(); 
	}
	public function get_package_by_customer_id()
	{
		$this->load->model('package/package_model');
		$c_id=$this->input->get('c_id');
		$data['package']=$this->package_model->get_package_by_customer($c_id);

		$this->load->view('package/package_info',$data);
	}
	public function get_all_pending_receipt()
	{
		$this->load->model('commission/commission_model');
		$this->load->model('customer/customer_model');
		$c_id=$this->input->get('c_id');
		$data['pending_inv']=$this->commission_model->get_all_pending_receipt($c_id);
		$data['agent_info']=$this->customer_model->get_customer_with_agent($c_id);
		$table='<select  name="commission[receipt_list]"  id="receipt_list" class="form-control"><option value="">Select</option>';
	    if(isset($data['pending_inv']) && !empty($data['pending_inv']))
		{
			foreach($data['pending_inv'] as $val)
			{
				$table=$table."<option value='".$val['id']."'>".$val['receipt_no']."</option>";
			}
		}
		
		$table=$table.'</select>';
		echo $table;
	}
	public function get_receipt_details()
	{
		$this->load->model('commission/commission_model');
		$this->load->model('customer/customer_model');
		$c_id=$this->input->get('c_id');
		$data['pending_inv']=$this->commission_model->get_invoice_for_receipt($this->input->get('r_id'));
		//echo "<pre>";
		//print_r($data['pending_inv']);
		//exit;
		$data['agent_info']=$this->customer_model->get_customer1($this->input->get('a_id'));
		$total=0;$table='';
	    if(isset($data['pending_inv']) && !empty($data['pending_inv']))
		{
			$i=1;
			foreach($data['pending_inv'][0]['inv_details'] as $val)
			{
				$total=$total+$val['org_value'];
				$table=$table.'<tr><td>'.$i.'</td><td>'.$val['inv_no'].'</td><td>'.date('d-M-Y',strtotime($val['inv_date'])).'</td><td>'.$val['org_value'].'</td></tr>';
				$i++;
			}
			$table=$table.'<tr><td colspan="3" class="text_right">Total Invoice Value</td><td><input name="commission[total_inv_value]" type="text" readonly class="form-control" value="'.round($total,2).'" /></td></tr>';
			
			$table=$table.'<tr><td colspan="3" class="text_right">Total Discount Value</td><td><input  name="commission[total_dis_value]"  type="text" readonly class="form-control" value="'.round($data['pending_inv'][0]['total_discount'][0]['total_discount'],2).'" /></td></tr>';
			
			$table=$table.'<tr><td colspan="3" class="text_right">Net Receipt Value</td><td><input  name="commission[net_receipt_val]"  type="text" readonly class="form-control"  id="net_val" value="'.round($total-$data['pending_inv'][0]['total_discount'][0]['total_discount'],2).'" /></td></tr>';
			
			
			$comm_val=round($total-$data['pending_inv'][0]['total_discount'][0]['total_discount'],2)*($data['pending_inv'][0]['agent_comm']/100);
			
			$table=$table.'
			<tr>
				<td colspan="3" class="text_right">
				Agent Commission
				<input type="text" id="comm_per" class="dot_val"  name="commission[agent_comm]"  value="'.$data['pending_inv'][0]['agent_comm'].'"  autocomplete="off"  name="receipt[debit_per]"  style="width:70px;" >
				</td>
				<td>
				<input type="text" id="comm_val"  name="commission[agent_comm_value]"  class="form-control dot_val" value="'.round($comm_val,2).'" autocomplete="off"/>
				</td>
			</tr>';
			
			$table=$table.'<tr><td  colspan="3" class="text_right">Paid Value</td><td><input id="paid" class="form-control dot_val"  name="commission_bill[bill_amount]"  type="text" autocomplete="off"/></td></tr>';
			
			$table=$table.'<tr><td  colspan="3" class="text_right">Balance</td><td><input class="form-control dot_val" name="balance"  id="balance" type="text" autocomplete="off"/></td></tr>';
			
			
			
			$table=$table.'<tr><td colspan="3"></td><td><input type="submit" class="btn btn-success submit" value="Pay"> </td></tr>';
		}
		else
		{
			$table=$table.'<tr>Invoice Not Created Yet</tr>';
		}
		
		echo $table;
		
	}
	
	public function update_commission($r_id)
	{
	
			
			
		
		$this->load->model('commission/commission_model');
		
		if($this->input->post())
		{
			$input=$this->input->post();
			
			if($input['balance']==0)
			{
				$input['receipt']['complete_status']=1;
				$insert_id=$this->commission_model->update_commission(array('complete_status'=>$input['receipt']['complete_status']),$r_id);	
			}
			
			$this->commission_model->insert_commission_bill($input['commission_bill']);	
			
			redirect($this->config->item('base_url').'commission/commission_list');
		}
		$data['receipt_details']=$this->commission_model->get_commission_by_id($r_id);

		$this->template->write_view('content', 'update_commission',$data);
        $this->template->render(); 
		
		
	}
	public function view_commission($r_id)
	{
		$this->load->model('commission/commission_model');
		$data['receipt_details']=$this->commission_model->get_commission_by_id($r_id);

		$this->template->write_view('content', 'view_commission',$data);
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
	public function checking_payment_checkno()
	{
		
		$this->load->model('receipt/receipt_model');
		$input=$this->input->post('value1');
		 //print_r($input); exit;
		$validation=$this->receipt_model->checking_payment_checkno($input);
		
		$i=0;
		if($validation)
		{
			$i=1;
		}
		if($i==1)
		{
			echo "Check/DD No Already Exist";
		}
	}
	public function update_checking_payment_checkno()
	{
		
		$this->load->model('receipt/receipt_model');
		$input=$this->input->post('value1');
		 //print_r($input); exit;
		$validation=$this->receipt_model->update_checking_payment_checkno($input);
		
		$i=0;
		if($validation)
		{
			$i=1;
		}
		if($i==1)
		{
			echo "Check/DD No Already Exist";
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
