<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Email_api extends MX_Controller {

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
		$this->load->model('email_api/email_api_model');
			$data['all_before']=$this->email_api_model->get_all_before_po_notification();
			
		$this->load->model('email_api/email_api_model');
			$data['before_two_days']=$this->email_api_model->get_before_two_days_po_notification();
			
		$this->load->model('email_api/email_api_model');
			$data['all_after']=$this->email_api_model->get_all_after_po_notification();		
			
			
		$this->load->model('admin/admin_model');
			$data['company_details']=$this->admin_model->get_company_details();	
		
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		$this->email->from('noreply@email.com', 'Sneha Apparels');
	
		if(isset($data['all_before']) && !empty($data['all_before']))
		{
			foreach($data['all_before'] as $val)
			{
				$this->email->to('',$data['company_details'][0]['email'],$val['email_id']); 
				$this->email->subject($val['grn_no'].' Delivery Notification');
				$this->email->set_mailtype("html");
				$po['po_info']=$val;
				$po['from']=1;
				$msg1['test'] = $this->load->view('email_api/index',$po,TRUE);
				$msg1['company_details']=$data['company_details'];
				$msg = $this->load->view('po/email_template',$msg1,TRUE);
				//echo $msg;
				$this->email->message($msg);
				$this->email->send();
			}
		}
		if(isset($data['before_two_days']) && !empty($data['before_two_days']))
		{
			foreach($data['before_two_days'] as $val)
			{
				$this->email->to('',$data['company_details'][0]['email'],$val['email_id']); 
				$this->email->subject($val['grn_no'].' Delivery Notification');
				$this->email->set_mailtype("html");
				$po['po_info']=$val;
				$po['from']=2;
				$msg1['test'] = $this->load->view('email_api/index',$po,TRUE);
				$msg1['company_details']=$data['company_details'];
				$msg = $this->load->view('po/email_template',$msg1,TRUE);
				//echo $msg;
				$this->email->message($msg);
				$this->email->send();
			}
		}
		if(isset($data['all_after']) && !empty($data['all_after']))
		{
			foreach($data['all_after'] as $val)
			{
				$this->email->to('',$data['company_details'][0]['email'],$val['email_id']); 
				$this->email->subject($val['grn_no'].' Delivery Notification');
				$this->email->set_mailtype("html");
				$po['po_info']=$val;
				$po['from']=3;
				$msg1['test'] = $this->load->view('email_api/index',$po,TRUE);
				$msg1['company_details']=$data['company_details'];
				$msg = $this->load->view('po/email_template',$msg1,TRUE);
				//echo $msg;
				$this->email->message($msg);
				$this->email->send();
			}
		} 
		//$this->template->write_view('content', 'email_api/index',$data);
        //$this->template->render();       
	}
	public function purchase_email_reminder()
	{
		$this->load->model('email_api/email_api_model');
			$data['all_before']=$this->email_api_model->get_all_before_two_days_notification();
			
		$this->load->model('email_api/email_api_model');
			$data['before_two_days']=$this->email_api_model->get_all_before_on_day_notification();	
			
		$this->load->model('admin/admin_model');
			$data['company_details']=$this->admin_model->get_company_details();	
		
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		$this->email->from('noreply@email.com', 'Sneha Apparels');
		if(isset($data['all_before']) && !empty($data['all_before']))
		{
			foreach($data['all_before'] as $val)
			{
				$this->email->to('',$data['company_details'][0]['email']); 
				$this->email->subject($val['receipt_no'].' Payment Notification');
				$this->email->set_mailtype("html");
				$po['po_info']=$val;
				$po['from']=1;
				$po['company_details']=$data['company_details'];
				$msg1['test'] = $this->load->view('email_api/purchase_reminder',$po,TRUE);
				$msg1['company_details']=$data['company_details'];
				$msg = $this->load->view('po/email_template',$msg1,TRUE);
				//echo $msg;
				$this->email->message($msg);
				$this->email->send();
			}
		}
		if(isset($data['before_two_days']) && !empty($data['before_two_days']))
		{
			foreach($data['before_two_days'] as $val)
			{
				$this->email->to('',$data['company_details'][0]['email']); 
				$this->email->subject($val['receipt_no'].' Payment Notification');
				$this->email->set_mailtype("html");
				$po['po_info']=$val;
				$po['from']=2;
				$po['company_details']=$data['company_details'];
				$msg1['test'] = $this->load->view('email_api/purchase_reminder',$po,TRUE);
				$msg1['company_details']=$data['company_details'];
				$msg = $this->load->view('po/email_template',$msg1,TRUE);
				//echo $msg;
				$this->email->message($msg);
				$this->email->send();
			}
		}
		//$this->template->write_view('content', 'email_api/index',$data);
        //$this->template->render();       
	}
	public function payment_email_reminder()
	{
		$this->load->model('email_api/email_api_model');
			$data['all_before']=$this->email_api_model->get_all_before_two_days_notification_payment();
			
		$this->load->model('email_api/email_api_model');
			$data['before_two_days']=$this->email_api_model->get_all_before_on_day_notification_payment();	
			
		$this->load->model('admin/admin_model');
			$data['company_details']=$this->admin_model->get_company_details();	
			
		$this->load->library('email');
		$config['protocol'] = 'sendmail';
		$config['mailpath'] = '/usr/sbin/sendmail';
		$config['charset'] = 'iso-8859-1';
		$config['wordwrap'] = TRUE;
		$this->email->initialize($config);
		$this->email->from('noreply@email.com', 'Sneha Apparels');
		if(isset($data['all_before']) && !empty($data['all_before']))
		{
			foreach($data['all_before'] as $val)
			{
				$this->email->to('',$data['company_details'][0]['email'],$val['email_id']); 
				$this->email->subject($val['receipt_no'].' Payment Notification');
				$this->email->set_mailtype("html");
				$po['po_info']=$val;
				$po['from']=1;
				$po['pay_from']=1;
				$po['company_details']=$data['company_details'];
				$msg1['test'] = $this->load->view('email_api/purchase_reminder',$po,TRUE);
				$msg1['company_details']=$data['company_details'];
				$msg = $this->load->view('po/email_template',$msg1,TRUE);
				echo $msg;
				$this->email->message($msg);
				$this->email->send();
			}
		}
		if(isset($data['before_two_days']) && !empty($data['before_two_days']))
		{
			foreach($data['before_two_days'] as $val)
			{
				$this->email->to('',$data['company_details'][0]['email'],$val['email_id']); 
				$this->email->subject($val['receipt_no'].' Payment Notification');
				$this->email->set_mailtype("html");
				$po['po_info']=$val;
				$po['from']=2;
				$po['pay_from']=1;
				$po['company_details']=$data['company_details'];
				$msg1['test'] = $this->load->view('email_api/purchase_reminder',$po,TRUE);
				$msg1['company_details']=$data['company_details'];
				$msg = $this->load->view('po/email_template',$msg1,TRUE);
				echo $msg;
				$this->email->message($msg);
				$this->email->send();
			}
		}
		//$this->template->write_view('content', 'email_api/index',$data);
        //$this->template->render();       
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
