<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Invoice extends MX_Controller {

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
	
	public function create($p_id)
	{
		
		$this->load->model('package/package_model');
		$this->load->model('invoice/invoice_model');
		$this->load->model('gen/gen_model');
		$this->load->model('sales_order/sales_order_model');
		$this->load->model('master_state/master_state_model');
		$this->load->model('master_style/master_model');
		$this->load->model('stock/stock_model');
		$this->load->model('customer/customer_model');
		$data["last_id"]=$this->master_model->get_last_id('inv_code');
		$no[1]=substr($data["last_id"][0]['value'],3);
		if(date('m')>3)
		{
			$check_no='INV'.date('y').(date('y')+1).'0001';
			$check_res=$this->invoice_model->check_so_no($check_no);
			if(empty($check_res))
			{
				$data['last_no']='INV'.date('y').(date('y')+1).'0001';
			}
			else
				$data['last_no']='INV'.date('y').(date('y')+1).str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
		}else
		{
			$check_no='INV'.(date('y')-1).date('y').'0001';
			$check_res=$this->invoice_model->check_so_no($check_no);
			if(empty($check_res))
			{
				$data['last_no']='INV'.(date('y')-1).date('y').'0001';
			}
			else
				$data['last_no']='INV'.(date('y')-1).date('y').str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
		}
		if($this->input->post())
		{
			
			$this->load->library("Pdf");
			if(date('m')>3)
			{
				$f_year=date('y').(date('y')+1);
			}
			else
			{
				$f_year=(date('y')-1).date('y');
			}
			$input=$this->input->post();
			if(isset($input['mrp_rate']) && !empty($input['mrp_rate']))
			{
				foreach($input['mrp_rate'] as $keys=>$mrp_r)
				{
					foreach($mrp_r as $s=>$m)
					{
						$this->package_model->updatepackage($keys,$s,$m);
					}	
				}
			}
			$so_list=$this->package_model->get_sales_order_by_p_id($input['invoice']['package_id']);
		//	print_r($so_list[0]['sales_order_list']);
			$arr_so=explode('-',$so_list[0]['sales_order_list']);
		//	print_r($arr_so);
			$my_data=array();
			
			if(isset($arr_so) && !empty($arr_so))
			{
				foreach($arr_so as $my_val)
				{
					
					$result_data=$this->sales_order_model->get_sales_details($my_val);
					foreach($result_data as $vals)
					{
						$sp=$this->sales_order_model->get_sp($vals['gen_id']);
						$lot_no=$this->sales_order_model->get_lot_no($vals);
						$this->sales_order_model->update_all_data(array('invoice_status'=>1),$vals['gen_id']);
						unset($vals['gen_id']);
						$vals['c_mrp']=$vals['c_mrp']-round($vals['c_mrp']*(($sp[0]['sp'])/100),2);
						$vals['qty']=-$vals['qty'];
						$vals['stock_from']='so';
						$vals['cust_id']=$input['c_ids'];
						$vals['finacial_year']=$f_year;
						$vals['lot_no']=$vals['lot_no'];
						$my_data[]=$vals;
					}
				
				}

			$this->stock_model->insert_stock_info($my_data);
			}
		
			$input['invoice']['inv_date']=date('Y-m-d',strtotime($input['invoice']['inv_date']));
			$input['invoice']['due_date']=date('Y-m-d',strtotime($input['invoice']['due_date']));
			$no[1]=substr($data["last_id"][0]['value'],3);
			
			if(date('m')>3)
			{
				$check_no='INV'.date('y').(date('y')+1).'0001';
				$check_res=$this->invoice_model->check_so_no($check_no);
				if(empty($check_res))
				{
					$data['last_no']='INV'.date('y').(date('y')+1).'0001';
				}
				else
					$data['last_no']='INV'.date('y').(date('y')+1).str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
			}else
			{
				$check_no='INV'.(date('y')-1).date('y').'0001';
				$check_res=$this->invoice_model->check_so_no($check_no);
				if(empty($check_res))
				{
					$data['last_no']='INV'.(date('y')-1).date('y').'0001';
				}
				else
					$data['last_no']='INV'.(date('y')-1).date('y').str_pad(substr($no[1],4,8)+1, 4, '0', STR_PAD_LEFT);
			}
			$input['invoice']['inv_no']=$data['last_no'];
			$input['invoice']['add_date']=date('Y-m-d');
			$inv_id=$this->invoice_model->insert_invoice($input['invoice']);
			$this->master_model->update_last_id1($data['last_no'],'inv_code');
			$this->load->model('admin/admin_model');
			$data['invoice_details']=$this->invoice_model->get_invoice_by_id($inv_id);
			$data['package_details']=$this->package_model->get_package_by_id($data['invoice_details'][0]['package_id']);
			$data['package_info']=$this->package_model->get_package_by_id1($data['invoice_details'][0]['package_id']);
			$data['company_details']=$this->admin_model->get_company_details();
			$this->load->library('email');
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			
			$this->email->from('noreply@email.com', 'Cotton Colors');
			$to_array=array('',$data['company_details'][0]['email'],$data['package_details'][0]['email_id']);
			$this->email->to($to_array); 
			$this->email->subject($data['invoice_details'][0]['inv_no'].' Created');
			$this->email->set_mailtype("html");
			//$msg1['test'] = $this->load->view('invoice/invoice_email_view',$data,TRUE);
			//$msg1['company_details']=$data['company_details'];
			//$msg = $this->load->view('po/email_template',$msg1,TRUE);
			
			
			$msg1['test'] = $this->load->view('invoice/invoice_email_view',$data,TRUE);
			$msg1['company_details']=$data['company_details'];
			
			$msg = $this->load->view('po/pdf_email_template',$msg1,TRUE);
			
			//print_r($msg);
			
			$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);    
	 
			$pdf->AddPage(); 
			
			$pdf->writeHTMLCell(0, 0, '', '', $msg, 0, 1, 0, true, '', true);  
			
			$newFile  = $this->config->item('theme_path').'attachement/'.$data['invoice_details'][0]['inv_no'].'.pdf';
			
			$pdf->Output($newFile, 'F');
		    $this->email->attach($this->config->item('theme_path').'attachement/'.$data['invoice_details'][0]['inv_no'].'.pdf');
			$this->email->message('Dear sir,<br>Kindly find the attchment for Sales Invoice '.$data['invoice_details'][0]['inv_no']);
			$this->email->send();
			redirect($this->config->item('base_url').'package/package_list');
		}	
		
		
		$this->load->model('package/package_model');
		$data['package_details']=$this->package_model->get_package_by_id($p_id);
		$data['package_info']=$this->package_model->get_package_by_id1($p_id);

		$this->template->write_view('content', 'invoice/index',$data);
        $this->template->render();           
	}
	public function package_list()
	{
		$this->load->model('package/package_model');
		$data['all_package']=$this->package_model->get_all_package();
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
	public function package_view($p_id)
	{
		$this->load->model('package/package_model');
		$data['package_details']=$this->package_model->get_package_by_id($p_id);
		$data['package_info']=$this->package_model->get_package_by_id1($p_id);
		$this->template->write_view('content', 'package/package_view',$data);
        $this->template->render();      
	}
	public function get_inv_no_list()
	{
		$atten_inputs = $this->input->get();
		$this->load->model('invoice_model');
		$data = $this->invoice_model->get_all_inv_no($atten_inputs);
		foreach($data as $st_rlno)
		{
			echo $st_rlno['inv_no']."\n";
		}	
	}
	
	public function view($inv_id)
	{
		$this->load->model('invoice/invoice_model');
		$this->load->model('package/package_model');
		$data['invoice_details']=$this->invoice_model->get_invoice_by_id($inv_id);
		$data['package_details']=$this->package_model->get_package_by_id($data['invoice_details'][0]['package_id']);
		$data['package_info']=$this->package_model->get_package_by_id1($data['invoice_details'][0]['package_id']);
		$this->template->write_view('content', 'invoice/invoice_view',$data);
        $this->template->render();  
	}
	public function send_email()
	{
		$this->load->library("Pdf");
		$this->load->model('invoice/invoice_model');
		$this->load->model('package/package_model');
		$this->load->model('admin/admin_model');
		$inv_id=$this->input->get('inv_id');
	
		$data['invoice_details']=$this->invoice_model->get_invoice_by_id($inv_id);
		$data['package_details']=$this->package_model->get_package_by_id($data['invoice_details'][0]['package_id']);
		$data['package_info']=$this->package_model->get_package_by_id1($data['invoice_details'][0]['package_id']);
		$data['company_details']=$this->admin_model->get_company_details();
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		
		$this->email->from('noreply@email.com', 'Cotton Colors');
		$to_array=array('',$data['company_details'][0]['email'],$data['package_details'][0]['email_id']);
		$this->email->to($to_array); 
		$this->email->subject($data['invoice_details'][0]['inv_no'].' Created');
		$this->email->set_mailtype("html");
		
		$msg1['test'] = $this->load->view('invoice/invoice_email_view',$data,TRUE);
		$msg1['company_details']=$data['company_details'];
		
		$msg = $this->load->view('po/pdf_email_template',$msg1,TRUE);
		
		print_r($msg);
		
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);    
 
		$pdf->AddPage(); 
		
		$pdf->writeHTMLCell(0, 0, '', '', $msg, 0, 1, 0, true, '', true);  
		
		$newFile  = $this->config->item('theme_path').'attachement/'.$data['invoice_details'][0]['inv_no'].'.pdf';
		
		$pdf->Output($newFile, 'F');
	        $this->email->attach($newFile); 
		$this->email->message('Dear sir,<br>Kindly find the attachment for Sales Invoice '.$data['invoice_details'][0]['inv_no']);
		$this->email->send();
		
		/*$msg1['test'] = $this->load->view('invoice/invoice_email_view',$data,TRUE);
		$msg1['company_details']=$data['company_details'];
		$msg = $this->load->view('po/email_template',$msg1,TRUE);
		$this->email->message($msg);
		$this->email->send();
		echo $msg;*/
	}	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */