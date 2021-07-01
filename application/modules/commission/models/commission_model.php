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
 
class Commission_model extends CI_Model{

	private $table_name1	= 'commission';
	private $table_name2	= 'commission_bill';
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
	 	$query = $this->db->get('receipt')->result_array();
		return $query; 
	}
	public function insert_commission($data)
	{
		if ($this->db->insert($this->table_name1, $data)) {
			$insert_id = $this->db->insert_id();
			
			return $insert_id;
		}
		return false;
	}
	public function insert_commission_bill($data)
	{
		if ($this->db->insert($this->table_name2, $data)) {
			$insert_id = $this->db->insert_id();
			
			return $insert_id;
		}
		return false;
	}
	public function get_all_commission($serch_data=NULL)
	{
		$this->db->select('commission.*');
		$this->db->select('receipt.receipt_no');
		$this->db->order_by('id','desc');
		$this->db->select('agent.name as agent_name');
		if(isset($serch_data) && !empty($serch_data))
		{
		
			$serch_data['from_date']=date('Y-m-d',strtotime($serch_data['from_date']));
			$serch_data['to_date']=date('Y-m-d',strtotime($serch_data['to_date']));
			if($serch_data['from_date']=='1970-01-01')
			$serch_data['from_date']='';
			if($serch_data['to_date']=='1970-01-01')
			$serch_data['to_date']='';
			if(!empty($serch_data['agent']) && $serch_data['agent']!='Select')
			{
				$this->db->where('agent.id',$serch_data['agent']);
			}
			if(!empty($serch_data['r_no']))
			{
				$this->db->where('receipt.receipt_no',$serch_data['r_no']);
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
		$this->db->join('receipt','receipt.id='.$this->table_name1.'.receipt_list');
		$this->db->join('agent','agent.id='.$this->table_name1.'.agent_id');
	 	$query = $this->db->get('commission')->result_array();
		$i=0;
		foreach($query as $val)
		{
			$this->db->select('SUM(bill_amount) AS comm_paid');
			$this->db->where('commission_bill.comm_id',$val['id']);
			$query[$i]['commission_bill'] = $this->db->get('commission_bill')->result_array();	
			$i++;
		}
		return $query;
	}
	public function get_commission_by_id($id)
	{//echo "<pre>";
		$this->db->select('commission.*');
		$this->db->where('commission.id',$id);
		$this->db->select('receipt.receipt_no');
		$this->db->select('agent.name as agent_name');
		$this->db->join('agent','agent.id='.$this->table_name1.'.agent_id');
		$this->db->join('receipt','receipt.id='.$this->table_name1.'.receipt_list');
	 	$query = $this->db->get('commission')->result_array();
		$i=0;
		foreach($query as $val)
		{
			$this->db->select('*');
			$this->db->where('commission_bill.comm_id',$val['id']);
			$query[$i]['receipt_history'] = $this->db->get('commission_bill')->result_array();	
		
			$arr=explode('-',$val['receipt_list']);
			
			$this->db->select('invoice.inv_no,invoice.id,inv_date,org_value,total_value');
			$this->db->where_in('invoice.id',$arr);
			$query[$i]['inv_details'] = $this->db->get('invoice')->result_array();
			
			
			
			$i++;
		}
		
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
			$i++;
		}
		
		return $query;
	}
	public function update_commission($data,$id)
	{
		
		$this->db->select('receipt_list');
		$this->db->where('id',$id);
	 	$query = $this->db->get($this->table_name1)->result_array();
		$this->db->where('id',$query[0]['receipt_list']);
		$this->db->update('receipt', array('commission_status'=>1));
	
		$this->db->where('id',$id);
		if ($this->db->update($this->table_name1, $data)) {
			
			return true;
		}
		return false;
	}
	public function update_commission1($id)
	{
		$this->db->where('id',$id);
		$this->db->update('receipt', array('commission_status'=>1));
	}
	public function update_invoice_status($data)
	{
		$this->db->where_in('id',$data);
		if ($this->db->update('invoice', array('receipt_status'=>1))) {
			
			return true;
		}
		return false;
	}	
	public function update_receipt_id($no)
	{
		$this->db->where('type','rp_code');
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
	function get_all_pending_receipt($a_id)
	{
		$this->db->select('receipt_no,id');
		$this->db->where('agent_id',$a_id);
		$this->db->where('complete_status',1);
		$this->db->where('commission_status',0);
		$this->db->order_by('id','desc');
	 	$query = $this->db->get('receipt')->result_array();
		return $query;
	}
	function get_invoice_for_receipt($r_id)
	{
		$this->db->select('*');
		$this->db->where('id',$r_id);
	 	$query = $this->db->get('receipt')->result_array();
		$i=0;
		foreach($query as $val)
		{
			$this->db->select('SUM(discount) as total_discount');
			$this->db->where_in('receipt_bill.receipt_id',$val['id']);
			$query[$i]['total_discount'] = $this->db->get('receipt_bill')->result_array();
			
			
			$arr=explode('-',$val['inv_list']);
			$this->db->select('invoice.inv_no,invoice.id,inv_date,org_value,total_value');
			$this->db->where_in('invoice.id',$arr);
			$query[$i]['inv_details'] = $this->db->get('invoice')->result_array();
			$i++;
		}
		return $query;
	}
	function checking_payment_checkno($input)
	 {
		
	 $this->db->select('*');
	 $this->db->where('dd_no',$input);
	 $query=$this->db->get('receipt_bill');
	
	  if ($query->num_rows() >= 1) {
	   return $query->result_array();
	  }
	 }
 function update_checking_payment_checkno($input)
 {
	
 $this->db->select('*');
 $this->db->where('dd_no',$input);
 $query=$this->db->get('receipt_bill');

  if ($query->num_rows() >= 1) {
   return $query->result_array();
  }
 }
}