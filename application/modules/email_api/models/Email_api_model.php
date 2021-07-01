<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin_model
 *
 * This model represents admin access. It operates the following tables:
 * admin,
 *
 * @package	i2_soft
 * @author	Elavarasan
 */
 
class Email_api_model extends CI_Model{

    private $table_name1	= 'po';
	private $table_name2	= 'po_details';
    private $table_name3	= 'customer';
	private $table_name4	= 'master_style';
	private $table_name5	= 'master_style_size';
	private $table_name6	= 'vendor';
	private $table_name7	= 'purchase_receipt';
	private $table_name8	= 'purchase_receipt_bill';
	private $table_name9	= 'receipt';
	private $table_name10	= 'purchase_receipt_bill';
	function __construct()
	{
		parent::__construct();

	}
	public function get_all_before_po_notification()
	{ 
		$this->db->select($this->table_name1.'.*');
		$this->db->select('vendor.store_name,email_id');
		$this->db->where($this->table_name1.'.df',0);
		$this->db->where($this->table_name1.'.status',1);
		$this->db->where('delivery_status',0);
		$this->db->or_where('delivery_status',1);
		$this->db->join('vendor','vendor.id='.$this->table_name1.'.customer');
		$query = $this->db->get($this->table_name1)->result_array();
		$cur_date='';
		$i=0;
		foreach($query as $val)
		{
			$date =$val['delivery_schedule'];
			$date = strtotime($date);
			$date = strtotime("-1 day", $date);
			//echo date('d-m-Y', $date);
			if( date('d-m-Y', $date)!=date('d-m-Y'))
				unset($query[$i]);
			
			
			$i++;	
		}
		return $query;
	}
	public function get_before_two_days_po_notification()
	{ 
		$this->db->select($this->table_name1.'.*');
		$this->db->select('vendor.store_name,email_id');
		$this->db->where($this->table_name1.'.df',0);
		$this->db->where($this->table_name1.'.status',1);
		$this->db->where('delivery_status',0);
		$this->db->join('vendor','vendor.id='.$this->table_name1.'.customer');
		$query = $this->db->get($this->table_name1)->result_array();
		$cur_date='';
		$i=0;
		foreach($query as $val)
		{
			$date =$val['delivery_schedule'];
			$date = strtotime($date);
			$date = strtotime("+7 day", $date);
		//	echo date('d-m-Y', $date);
			if( date('d-m-Y', $date)!=date('d-m-Y'))
				unset($query[$i]);
				
			$i++;			
		}
		return $query;
	}
	public function get_all_after_po_notification()
	{ 
		$this->db->select($this->table_name1.'.*');
		$this->db->select('vendor.store_name,email_id');
		$this->db->where($this->table_name1.'.df',0);
		$this->db->where($this->table_name1.'.status',1);
		$this->db->where('delivery_status',0);
		$this->db->join('vendor','vendor.id='.$this->table_name1.'.customer');
		$query = $this->db->get($this->table_name1)->result_array();
		$cur_date='';
		$i=0;
		foreach($query as $val)
		{
			$date =$val['delivery_schedule'];
			$date = strtotime($date);
			$date = strtotime("+10 day", $date);
			if( date('d-m-Y', $date)!=date('d-m-Y'))
				unset($query[$i]);
			
			$i++;		
		}
		return $query;
	}
	public function get_all_before_two_days_notification()
	{ 
		$this->db->select($this->table_name7.'.*');
		$this->db->where('complete_status',0);
		$query = $this->db->get($this->table_name7)->result_array();
		$cur_date='';
		$i=0;
		foreach($query as $val)
		{
			$this->db->select('SUM(discount) AS total_dis,SUM(bill_amount) AS total_paid');
			$this->db->where($this->table_name8.'.receipt_id',$val['id']);
			$query[$i]['paid_amt'] = $this->db->get($this->table_name8)->result_array();
		
		
			$date =$val['due_date'];
			$date = strtotime($date);
			$date = strtotime("-2 day", $date);
			//echo date('d-m-Y', $date);
			if( date('d-m-Y', $date)!=date('d-m-Y'))
				unset($query[$i]);
			
			
			$i++;	
		}
		return $query;
	}
	public function get_all_before_on_day_notification()
	{ 
		$this->db->select($this->table_name7.'.*');
		$this->db->where('complete_status',0);
		$query = $this->db->get($this->table_name7)->result_array();
		$cur_date='';
		$i=0;
		foreach($query as $val)
		{
			$this->db->select('SUM(discount) AS total_dis,SUM(bill_amount) AS total_paid');
			$this->db->where($this->table_name8.'.receipt_id',$val['id']);
			$query[$i]['paid_amt'] = $this->db->get($this->table_name8)->result_array();
			
			$date =$val['due_date'];
			$date = strtotime($date);
			$date = strtotime("0 day", $date);
			//echo date('d-m-Y', $date);
			if( date('d-m-Y', $date)!=date('d-m-Y'))
				unset($query[$i]);
			
			
			$i++;	
		}
		return $query;
	}
	public function get_all_before_two_days_notification_payment()
	{ 
		$this->db->select($this->table_name9.'.*');
		$this->db->select('customer.email_id,customer.store_name');
		$this->db->where('complete_status',0);
		$this->db->join('customer','customer.id='.$this->table_name9.'.customer_id');
		$query = $this->db->get($this->table_name9)->result_array();
		$cur_date='';
		$i=0;
		foreach($query as $val)
		{
			$this->db->select('SUM(discount) AS total_dis,SUM(bill_amount) AS total_paid');
			$this->db->where($this->table_name10.'.receipt_id',$val['id']);
			$query[$i]['paid_amt'] = $this->db->get($this->table_name10)->result_array();
		
		
			$date =$val['due_date'];
			$date = strtotime($date);
			$date = strtotime("-2 day", $date);
			//echo date('d-m-Y', $date);
			if( date('d-m-Y', $date)!=date('d-m-Y'))
				unset($query[$i]);
			
			
			$i++;	
		}
		return $query;
	}
	public function get_all_before_on_day_notification_payment()
	{ 
		$this->db->select($this->table_name9.'.*');
		$this->db->select('customer.email_id,customer.store_name');
		$this->db->where('complete_status',0);
		$this->db->join('customer','customer.id='.$this->table_name9.'.customer_id');
		$query = $this->db->get($this->table_name9)->result_array();
		$cur_date='';
		$i=0;
		foreach($query as $val)
		{
			$this->db->select('SUM(discount) AS total_dis,SUM(bill_amount) AS total_paid');
			$this->db->where($this->table_name10.'.receipt_id',$val['id']);
			$query[$i]['paid_amt'] = $this->db->get($this->table_name10)->result_array();
			
			$date =$val['due_date'];
			$date = strtotime($date);
			$date = strtotime("0 day", $date);
			//echo date('d-m-Y', $date);
			if( date('d-m-Y', $date)!=date('d-m-Y'))
				unset($query[$i]);
			
			
			$i++;	
		}
		return $query;
	}

}