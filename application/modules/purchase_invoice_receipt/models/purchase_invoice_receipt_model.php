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
 
class Purchase_invoice_receipt_model extends CI_Model{

	private $table_name1	= 'purchase_invoice_receipt';
	private $table_name2	= 'purchase_invoice_receipt_bill';
/*	private $table_name2	= 'sales_order_details';
	private $table_name3	= 'customer';
	private $table_name4	= 'master_style';
	private $table_name5	= 'master_style_size';
	private $table_name6	= 'vendor';
	private $table_name7	= 'package';
	private $table_name8	= 'package_details';*/
	function __construct()
	{
		parent::__construct();

	}
	public function check_so_no($po)
	{
		$this->db->select('receipt_no');
		$this->db->where('receipt_no',$po);
	 	$query = $this->db->get('purchase_invoice_receipt')->result_array();
		return $query; 
	}
	public function insert_receipt($data)
	{
		if ($this->db->insert($this->table_name1, $data)) {
			$insert_id = $this->db->insert_id();
			
			return $insert_id;
		}
		return false;
	}
	public function insert_receipt_bill($data)
	{
		if ($this->db->insert($this->table_name2, $data)) {
			$insert_id = $this->db->insert_id();
			
			return $insert_id;
		}
		return false;
	}
	public function get_all_receipt($serch_data=NULL)
	{
		$this->db->select('purchase_invoice_receipt.*');
		$this->db->select('vendor.store_name');
		$this->db->order_by('id','desc');
		if(isset($serch_data) && !empty($serch_data))
		{
		
			$serch_data['from_date']=date('Y-m-d',strtotime($serch_data['from_date']));
			$serch_data['to_date']=date('Y-m-d',strtotime($serch_data['to_date']));
			if($serch_data['from_date']=='1970-01-01')
			$serch_data['from_date']='';
			if($serch_data['to_date']=='1970-01-01')
			$serch_data['to_date']='';
			if(!empty($serch_data['supplier']) && $serch_data['supplier']!='Select')
			{
				$this->db->where('vendor.id',$serch_data['supplier']);
			}
			if(!empty($serch_data['pr']))
			{
				$this->db->where($this->table_name1.'.receipt_no',$serch_data['pr']);
			}
			if(isset($serch_data["from_date"]) && $serch_data["from_date"]!="" && isset($serch_data["to_date"]) && $serch_data["to_date"]!="")
			{
				
			$this->db->where("DATE_FORMAT(".$this->table_name1.".created_date,'%Y-%m-%d') >='".$serch_data["from_date"]."' AND DATE_FORMAT(".$this->table_name1.".created_date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
			}
			elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]!="" && isset($serch_data["to_date"]) && $serch_data["to_date"]=="")
			{
			
				$this->db->where("DATE_FORMAT(".$this->table_name1.".created_date,'%Y-%m-%d') >='".$serch_data["from_date"]."'");
			}
			elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]=="" && isset($serch_data["to_date"]) && $serch_data["to_date"]!="")
			{
				
				$this->db->where("DATE_FORMAT(".$this->table_name1.".created_date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
			}
			
		}
		else
		{
			$from_y=$to_y=0;
			if(date('m')>3)
			{
				$from_y=date('Y');
				$to_y=date('Y')+1;
			}
			else
			{
				$from_y=date('Y')-1;
				$to_y=date('Y');
			}
			$from=$from_y.'-04-01';
			$to=$to_y.'-03-31';
			$this->db->where($this->table_name1.".complete_status !=",1);	
			$this->db->or_where("DATE_FORMAT(".$this->table_name1.".created_date,'%Y-%m-%d') >='".$from."' AND DATE_FORMAT(".$this->table_name1.".created_date,'%Y-%m-%d') <= '".$to."'" );	
			
		}
		$this->db->join('vendor','vendor.id='.$this->table_name1.'.customer_id');
	 	$query = $this->db->get('purchase_invoice_receipt')->result_array();
		$i=0;
		foreach($query as $val)
		{
			$this->db->select('SUM(discount) AS receipt_balance,SUM(bill_amount) AS receipt_paid');
			$this->db->where('purchase_invoice_receipt_bill.receipt_id',$val['id']);
			$query[$i]['receipt_bill'] = $this->db->get('purchase_invoice_receipt_bill')->result_array();	
			$i++;
		}
		return $query;
	}
	public function get_receipt_by_id($id)
	{//echo "<pre>";
		$this->db->select('purchase_invoice_receipt.*');
		$this->db->where('purchase_invoice_receipt.id',$id);
		$this->db->select('vendor.store_name');
		$this->db->join('vendor','vendor.id='.$this->table_name1.'.customer_id');
	 	$query = $this->db->get('purchase_invoice_receipt')->result_array();
		
		$i=0;
		foreach($query as $val)
		{
			$this->db->select('*');
			$this->db->where('purchase_invoice_receipt_bill.receipt_id',$val['id']);
			$query[$i]['receipt_history'] = $this->db->get('purchase_invoice_receipt_bill')->result_array();	
		
			$arr=explode('-',$val['inv_list']);
			
			$this->db->select('*');
			$this->db->where('vendor.id',$val['customer_id']);
			$this->db->where_in('purchase_receipt.id',$arr);
			$this->db->join('vendor','vendor.id=purchase_receipt.customer_id');
			$query[$i]['inv_details'] = $this->db->get('purchase_receipt')->result_array();
			$i++;
		}
		//echo "<pre>";
		//print_r($query);
		return $query;
	}
	public function get_receipt_by_id_for_agent($data)
	{//echo "<pre>";
		$this->db->select('receipt.*');
		$this->db->where_in('receipt.id',$data);
		$this->db->select('customer.store_name,selling_percent');
		$this->db->select('agent.name as agent_name');
		$this->db->join('customer','customer.id='.$this->table_name1.'.customer_id');
		$this->db->join('agent','agent.id='.$this->table_name1.'.agent_id');
	 	$query = $this->db->get('receipt')->result_array();
		//echo "<pre>";print_r($query);
		
		$i=0;
		foreach($query as $val)
		{
			$this->db->select('*');
			$this->db->where('receipt_bill.receipt_id',$val['id']);
			$query[$i]['receipt_history'] = $this->db->get('receipt_bill')->result_array();	
		
			$arr=explode('-',$val['inv_list']);
			
			$this->db->select('invoice.inv_no,invoice.id,inv_date,org_value,total_value');
			$this->db->where('customer.id',$val['customer_id']);
			$this->db->where_in('invoice.id',$arr);
			$this->db->join('package','package.id=invoice.package_id');
			$this->db->join('customer','customer.id=package.customer');
			$query[$i]['inv_details'] = $this->db->get('invoice')->result_array();
			
			
			
			$i++;
		}
		
		return $query;
	}
	public function update_receipt($data,$id)
	{
		$this->db->where('id',$id);
		if ($this->db->update($this->table_name1, $data)) {
			
			return true;
		}
		return false;
	}
	public function update_invoice_status($data)
	{
		$this->db->where_in('id',$data);
		if ($this->db->update('purchase_receipt', array('complete_status'=>1))) {
			
			return true;
		}
		return false;
	}	
	public function update_receipt_id($no)
	{
		$this->db->where('type','pi_code');
		if ($this->db->update('increment_table', array('value'=>$no))) {
			
			return true;
		}
		return false;
	}
	public function get_all_rp_no($data)
	{
		$this->db->select('receipt_no');
		$this->db->like('receipt_no',$data['q']);
		$this->db->order_by('id','desc');
	 	$query = $this->db->get($this->table_name1)->result_array();
		return $query;
	}
	public function get_invoice_for_receipt($c_id)
	{
		$this->db->select('purchase_receipt.*,purchase_receipt.id as p_id');
		$this->db->select('vendor.*');
		$this->db->where('complete_status',0);
		$this->db->where('vendor.id',$c_id);
		$this->db->join('vendor','vendor.id=purchase_receipt.customer_id');
	 	$query = $this->db->get('purchase_receipt')->result_array();
		return $query;  
	}
	public function get_invoice_for_receipt1($data)
	{
		//echo "<pre>";
		//print_r($data);
		if(isset($data['inv_id']) && !empty($data['inv_id']))
		{
			$this->db->select('*');
			$this->db->where('purchase_receipt.complete_status',0);
			$this->db->where('vendor.id',$data['c_id']);
			$this->db->where_in('purchase_receipt.id',$data['inv_id']);
			$this->db->join('vendor','vendor.id=purchase_receipt.customer_id');
			$query = $this->db->get('purchase_receipt')->result_array();
			return $query;  	
		}
	}
	function checking_invoice_checkno($input)
 {
	
 $this->db->select('*');
 $this->db->where('dd_no',$input);
 $query=$this->db->get('purchase_invoice_receipt_bill');

  if ($query->num_rows() >= 1) {
   return $query->result_array();
  }
 }
 function update_checking_invoice_checkno($input)
 {
	
 $this->db->select('*');
 $this->db->where('dd_no',$input);
 $query=$this->db->get('purchase_invoice_receipt_bill');

  if ($query->num_rows() >= 1) {
   return $query->result_array();
  }
 }	
 function get_inv_no($id)
 {
	 $this->db->select('receipt_no');
	$this->db->where('id',$id);
	$query=$this->db->get('purchase_receipt');
	
	if ($query->num_rows() >= 1) {
	return $query->result_array();
	}
 }			
}