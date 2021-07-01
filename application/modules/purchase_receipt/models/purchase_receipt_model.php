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
 
class Purchase_receipt_model extends CI_Model{

	private $table_name1	= 'purchase_receipt';
	private $table_name2	= 'purchase_receipt_bill';
	private $table_name3	= 'po';
	private $table_name4	= 'expense_fixed';
	private $table_name5	= 'expense_variable';
	private $table_name6	= 'sales_order';
	private $table_name7	= 'commission';
/*	private $table_name3	= 'customer';
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
	 	$query = $this->db->get('purchase_receipt')->result_array();
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
	public function insert_receipt_gen($data)
	{
		if ($this->db->insert_batch('purchase_receipt_grn', $data)) {
			$insert_id = $this->db->insert_id();
			
			return $insert_id;
		}
		return false;
	}
	public function get_all_receipt($serch_data=NULL)
	{
		$this->db->select('purchase_receipt.*');
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
			if(!empty($serch_data['inv_no']) && $serch_data['inv_no']!='Select')
			{
				$this->db->where($this->table_name1.'.inv_no',$serch_data['inv_no']);
			}
			if(!empty($serch_data['pi_no']))
			{
				$this->db->where($this->table_name1.'.receipt_no',$serch_data['pi_no']);
			}
			if(isset($serch_data["from_date"]) && $serch_data["from_date"]!="" && isset($serch_data["to_date"]) && $serch_data["to_date"]!="")
			{
				
			$this->db->where("DATE_FORMAT(".$this->table_name1.".inv_date,'%Y-%m-%d') >='".$serch_data["from_date"]."' AND DATE_FORMAT(".$this->table_name1.".inv_date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
			}
			elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]!="" && isset($serch_data["to_date"]) && $serch_data["to_date"]=="")
			{
			
				$this->db->where("DATE_FORMAT(".$this->table_name1.".inv_date,'%Y-%m-%d') >='".$serch_data["from_date"]."'");
			}
			elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]=="" && isset($serch_data["to_date"]) && $serch_data["to_date"]!="")
			{
				
				$this->db->where("DATE_FORMAT(".$this->table_name1.".inv_date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
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
			$this->db->or_where("DATE_FORMAT(".$this->table_name1.".inv_date,'%Y-%m-%d') >='".$from."' AND DATE_FORMAT(".$this->table_name1.".inv_date,'%Y-%m-%d') <= '".$to."'" );	
			
		}
		$this->db->join('vendor','vendor.id='.$this->table_name1.'.customer_id');
	 	$query = $this->db->get('purchase_receipt')->result_array();
		/*$i=0;
		foreach($query as $val)
		{
			$this->db->select('SUM(discount) AS receipt_balance,SUM(bill_amount) AS receipt_paid');
			$this->db->where('purchase_receipt_bill.receipt_id',$val['id']);
			$query[$i]['receipt_bill'] = $this->db->get('purchase_receipt_bill')->result_array();	
			$i++;
		}*/
		return $query;
	}
	public function get_receipt_by_id($id)
	{//echo "<pre>";
		$this->db->select('purchase_receipt.*');
		$this->db->where('purchase_receipt.id',$id);
		$this->db->select('vendor.store_name');
		//$this->db->select('agent.name as agent_name');
		$this->db->join('vendor','vendor.id='.$this->table_name1.'.customer_id');
		//$this->db->join('agent','agent.id='.$this->table_name1.'.agent_id');
	 	$query = $this->db->get('purchase_receipt')->result_array();
		$i=0;
		foreach($query as $val)
		{
			$this->db->select('*');
			$this->db->where('purchase_receipt_bill.receipt_id',$val['id']);
			$query[$i]['receipt_history'] = $this->db->get('purchase_receipt_bill')->result_array();	
		
			$arr=explode('-',$val['inv_list']);
			
			$this->db->select('*');
			$this->db->where('vendor.id',$val['customer_id']);
			$this->db->where_in('po.id',$arr);
			$this->db->join('vendor','vendor.id=po.customer');
			$query[$i]['inv_details'] = $this->db->get('po')->result_array();
			
			
			
			$i++;
		}
		
		return $query;
	}
	public function get_receipt_by_gen($id)
	{//echo "<pre>";
		$this->db->select('purchase_receipt.*');
		$this->db->where('purchase_receipt.id',$id);
		$this->db->select('vendor.store_name');
		//$this->db->select('agent.name as agent_name');
		$this->db->join('vendor','vendor.id='.$this->table_name1.'.customer_id');
		//$this->db->join('agent','agent.id='.$this->table_name1.'.agent_id');
	 	$query = $this->db->get('purchase_receipt')->result_array();
		$i=0;
		foreach($query as $val)
		{
			
			$this->db->select('po.grn_no as po_no');
			$this->db->select('gen.grn_no,total_value,total_qty,gen.inv_date as due_date');
			$this->db->where('pr_id',$val['id']);
			$this->db->join('po','po.id=purchase_receipt_grn.po_id');
			$this->db->join('gen','gen.id=purchase_receipt_grn.gen_id');
			$query[$i]['inv_details'] = $this->db->get('purchase_receipt_grn')->result_array();
			
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
		if(isset($data) && !empty($data))
		{
			foreach($data['inv_no'] as $val)
			{
				
				if(isset($data['ren'][$val]) && !empty($data['ren'][$val]))
				{
					$this->db->where_in('id',$data['ren'][$val]);
					$this->db->update('gen', array('inv_status'=>1));
					$this->db->select('*');
					$this->db->where('po.id',$val);
					$this->db->where('gen.inv_status',0);
					$this->db->join('gen','gen.po_no=po.grn_no');
					$query = $this->db->get('po')->result_array();
					if(count($query)==0)
					{
						$this->db->where('id',$val);
						$this->db->update('po', array('purchase_receipt_status'=>1));
					}
				}
			}
		}
	}	
	public function update_receipt_id($no)
	{
		$this->db->where('type','pr_code');
		if ($this->db->update('increment_table', array('value'=>$no))) {
			
			return true;
		}
		return false;
	}
	
	public function get_all_pr_no($data)
	{
		$this->db->select('receipt_no');
		$this->db->like('receipt_no',$data['q']);
		$this->db->order_by('id','desc');
	 	$query = $this->db->get('purchase_invoice_receipt')->result_array();
		return $query;
	}
	public function get_invoice_for_purchase_receipt($id)
	{
		$this->db->select('po.*');
		$this->db->select('vendor.payment_terms');
		$this->db->where('customer',$id);
		$this->db->join('vendor','vendor.id=po.customer');
		$this->db->where('delivery_status !=',0);
		$this->db->where('purchase_receipt_status',0);
		
	 	$query = $this->db->get('po')->result_array();
		return $query;
	}
	public function get_invoice_for_receipt($c_id)
	{
		
		$this->db->select('vendor.*');
		$this->db->select('po.*');
		$this->db->where('purchase_receipt_status',0);
			$this->db->where('delivery_status !=',0);
		$this->db->where('vendor.id',$c_id);
		$this->db->join('vendor','vendor.id=po.customer');
	 	$query = $this->db->get('po')->result_array();
		return $query;  
	}
	public function get_invoice_for_receipt1($data)
	{
		if(isset($data['inv_id']) && !empty($data['inv_id']))
		{
		$this->db->select('*');
		$this->db->where('purchase_receipt_status',0);
		$this->db->where('customer',$data['c_id']);
		$this->db->where_in('po.id',$data['inv_id']);
	 	$query = $this->db->get('po')->result_array();
		return $query;  	
		}
	}
	public function get_po_grn1($serch_data=NULL)
	{
		if(isset($serch_data['po']) && !empty($serch_data['po']))
		{
			$this->db->where('po.grn_no',$serch_data['po']);	
		}
		if(isset($serch_data['style']) && !empty($serch_data['style']))
		{
			$this->db->where('po_details.style_id',$serch_data['style']);	
		}
		$this->db->select('po.id as po_id,full_total as po_qty,net_total as landed_value,grn_no');
		
		$this->db->group_by('po_details.gen_id');
		$this->db->order_by('po.id','desc');
		$this->db->join('po_details','po_details.gen_id=po.id');
		$this->db->join('master_style','master_style.id=po_details.style_id');
		
	 	$query = $this->db->get('po')->result_array();
		$k=0;
		//echo "<pre>";
		//print_r($query);
		foreach($query as $val)
		{
			$this->db->select('gen.po_no,SUM(gen_details.qty) as grn_qty,gen.id as grn_id,gen.grn_no');
			$this->db->where('po_no',$query[$k]['grn_no']);
			if(isset($serch_data['style']) && !empty($serch_data['style']))
			{
				$this->db->where('gen_details.style_id',$serch_data['style']);	
			}
			if(isset($serch_data['color']) && !empty($serch_data['color']))
			{	
				$this->db->where('gen_details.color_id',$serch_data['color']);	
			}
			$this->db->group_by('gen_details.gen_id');
			$this->db->join('gen_details','gen_details.gen_id=gen.id');
	 		$query[$k]['gen_details'] = $this->db->get('gen')->result_array();
			//print_r($query[$k]['gen_details']);
			$i=0;
			$so_arr=array();
			foreach($query[$k]['gen_details'] as $val)
			{
				//echo "<pre>";
				//print_r($val);
				$this->db->select('style_id,color_id,lot_no,size_id');
				$this->db->where('gen_id',$val['grn_id']);
				if(isset($serch_data['style']) && !empty($serch_data['style']))
				{
					$this->db->where('gen_details.style_id',$serch_data['style']);	
				}
				if(isset($serch_data['color']) && !empty($serch_data['color']))
				{	
					$this->db->where('gen_details.color_id',$serch_data['color']);	
				}
				$this->db->group_by('style_id');
				$this->db->group_by('color_id');
				$this->db->group_by('lot_no');
				$this->db->group_by('size_id');
				$query_qty = $this->db->get('gen_details')->result_array();
				
				$s_total=0;
				foreach($query_qty as $val1)
				{
					//print_r($val1);
					$this->db->select('SUM(qty) as soqty');
					$this->db->select('master_style.style_name');
					$this->db->select('master_colour.colour');
					$this->db->where('style_id',$val1['style_id']);
					$this->db->where('color_id',$val1['color_id']);
					$this->db->where('lot_no',$val1['lot_no']);
					//$this->db->where('size_id',$val1['size_id']);
					$this->db->join('master_style','master_style.id=sales_order_details.style_id');
					$this->db->join('master_colour','master_colour.id=sales_order_details.color_id');
					$s_arr = $this->db->get('sales_order_details')->result_array();
					$so_arr[$val1['style_id']][$val1['color_id']]=$s_arr;
				}
				$query[$k]['gen_details'][$i]['sales_qty']=$s_total;
				$i++;
			}
			$query[$k]['salse_order']=$so_arr;
			
			$k++;
		}
		//echo "<pre>";
		//print_r($query);
		return $query;
		//exit;
	}
	public function get_po_grn($serch_data=NULL)
	{
		if(isset($serch_data) && !empty($serch_data))
		{
			$serch_data['from_date']=date('Y-m-d',strtotime($serch_data['from_date']));
			$serch_data['to_date']=date('Y-m-d',strtotime($serch_data['to_date']));
			if($serch_data['from_date']=='1970-01-01')
			$serch_data['from_date']='';
			if($serch_data['to_date']=='1970-01-01')
			$serch_data['to_date']='';
			if(!empty($serch_data['po']))
			{
				$this->db->where($this->table_name3.'.grn_no',$serch_data['po']);
			}
			if(isset($serch_data["from_date"]) && $serch_data["from_date"]!="" && isset($serch_data["to_date"]) && $serch_data["to_date"]!="")
			{
				
			$this->db->where("DATE_FORMAT(".$this->table_name3.".inv_date,'%Y-%m-%d') >='".$serch_data["from_date"]."' AND DATE_FORMAT(".$this->table_name3.".inv_date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
			}
			elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]!="" && isset($serch_data["to_date"]) && $serch_data["to_date"]=="")
			{
			
				$this->db->where("DATE_FORMAT(".$this->table_name3.".inv_date,'%Y-%m-%d') >='".$serch_data["from_date"]."'");
			}
			elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]=="" && isset($serch_data["to_date"]) && $serch_data["to_date"]!="")
			{
				
				$this->db->where("DATE_FORMAT(".$this->table_name3.".inv_date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
			}
		}
		$this->db->select('id as po_id,full_total as po_qty,net_total as landed_value,customer,grn_no');
	 	$query = $this->db->get('po')->result_array();
		
		$i=0;
		foreach($query as $val)
		{	
			$this->db->select('style_id,color_id,lot_no,size_id');
			$this->db->where('gen_id',$val['po_id']);
			$this->db->group_by('style_id');
			$this->db->group_by('color_id');
			$this->db->group_by('lot_no');
			$this->db->group_by('size_id');
			if(!empty($serch_data['style']))
			{
				$this->db->where('style_id',$serch_data['style']);
			}
			$query_qty = $this->db->get('po_details')->result_array();
			$s_total=0;$j=0;
			foreach($query_qty as $val1)
			{
				
				$this->db->select('sales_order_details.qty,sales_order_details.style_id,master_style.sp,sales_order.sp as customer_sp,sales_order.st,sales_order.cst,sales_order.vat,master_style_mrp.mrp as customer_mrp');
				$this->db->where('sales_order_details.style_id',$val1['style_id']);
				$this->db->where('color_id',$val1['color_id']);
				$this->db->where('lot_no',$val1['lot_no']);
				$this->db->where('size_id',$val1['size_id']);
				$this->db->where('master_style_mrp.style_id',$val1['style_id']);
				if(!empty($serch_data['customer']))
				{
					$this->db->where('sales_order.customer',$serch_data['customer']);
				}
				$this->db->join('master_style','master_style.id=sales_order_details.style_id');
				$this->db->join('sales_order','sales_order.id=sales_order_details.gen_id');
				$this->db->join('master_style_mrp','master_style_mrp.customer_id=sales_order.customer');
				$s_arr = $this->db->get('sales_order_details')->result_array();
				$query[$i]['sales_order'][$j]=$s_arr;
				$j++;
			}
			
			$i++;
		}
		return $query;
	}
	public function get_pl($serch_data=NULL)
	{
		if(isset($serch_data) && !empty($serch_data))
		{
			$serch_data['from_date']=date('Y-m-d',strtotime($serch_data['from_date']));
			$serch_data['to_date']=date('Y-m-d',strtotime($serch_data['to_date']));
			if($serch_data['from_date']=='1970-01-01')
			$serch_data['from_date']='';
			if($serch_data['to_date']=='1970-01-01')
			$serch_data['to_date']='';
			if(!empty($serch_data['customer']))
			{
				$this->db->where($this->table_name6.'.customer',$serch_data['customer']);
			}
			if(isset($serch_data["from_date"]) && $serch_data["from_date"]!="" && isset($serch_data["to_date"]) && $serch_data["to_date"]!="")
			{
				
			$this->db->where("DATE_FORMAT(".$this->table_name6.".inv_date,'%Y-%m-%d') >='".$serch_data["from_date"]."' AND DATE_FORMAT(".$this->table_name6.".inv_date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
			}
			elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]!="" && isset($serch_data["to_date"]) && $serch_data["to_date"]=="")
			{
			
				$this->db->where("DATE_FORMAT(".$this->table_name6.".inv_date,'%Y-%m-%d') >='".$serch_data["from_date"]."'");
			}
			elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]=="" && isset($serch_data["to_date"]) && $serch_data["to_date"]!="")
			{
				
				$this->db->where("DATE_FORMAT(".$this->table_name6.".inv_date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
			}
			if(isset($serch_data["f_year"]) && $serch_data["f_year"]!="")
			{
				
			$this->db->where("DATE_FORMAT(".$this->table_name6.".inv_date,'%Y-%m-%d') >='".'20'.substr($serch_data['f_year'],0,2).'-04-01'."' AND DATE_FORMAT(".$this->table_name6.".inv_date,'%Y-%m-%d') <= '".'20'.substr($serch_data['f_year'],2,4).'-03-31'."'" );
			}
		}
		$this->db->select('*');
		$this->db->order_by('id','desc');
	 	$query = $this->db->get('sales_order')->result_array();
		$i=0;
		//echo "<pre>";
		foreach($query as $val1)
		{	
			if(isset($serch_data) && !empty($serch_data))
			{
				if(!empty($serch_data['style']))
				{
					//echo "enter";
					$this->db->where('sales_order_details.style_id',$serch_data['style']);
				}
			}
			$this->db->select('SUM(qty) AS s_qty');
			$this->db->where('sales_order_details.gen_id',$val1['id']);
			$query[$i]['salse_details'] = $this->db->get('sales_order_details')->result_array();
			if($query[$i]['salse_details'][0]['s_qty']==0)
			{
				unset($query[$i]);
			}
			$i++;
		}
		return $query;
	}
	public function get_all_so_per_month($data)
	{
		$this->db->where("DATE_FORMAT(sales_order.inv_date,'%Y-%m')",date('Y-m',strtotime($data)));
		$this->db->select('sum(full_total) as total_qty_per_month');
		$so_qty=$this->db->get('sales_order')->result_array();
		
		$this->db->where("DATE_FORMAT(expense_fixed.exp_date,'%Y-%m')",date('Y-m',strtotime($data)));
		$this->db->select('sum(exp_value) as fixed_exp');
		$f_exp=$this->db->get('expense_fixed')->result_array();
		
		$this->db->where("DATE_FORMAT(expense_variable.date,'%Y-%m')",date('Y-m',strtotime($data)));
		$this->db->select('sum(exp_amount) as var_exp');
		$this->db->join('expense_variable_detaills','expense_variable_detaills.exp_var_id=expense_variable.id');
		$v_exp=$this->db->get('expense_variable')->result_array();
		
		
		$this->db->where("DATE_FORMAT(commission_bill.created_date,'%Y-%m')",date('Y-m',strtotime($data)));
		$this->db->select('sum(bill_amount) as comm_exp');
		$c_exp=$this->db->get('commission_bill')->result_array();
		
		
		$r_arr=array();
		
		$r_arr['so_qty']=$so_qty[0]['total_qty_per_month'];
		$r_arr['f_exp']=$f_exp[0]['fixed_exp'];
		$r_arr['v_exp']=$v_exp[0]['var_exp'];
		$r_arr['c_exp']=$c_exp[0]['comm_exp'];
		
		return $r_arr;
	}
	public function tax_val($serch_data=NULL)
	{
		if(isset($serch_data) && !empty($serch_data))
			{
				$serch_data['from_date']=date('Y-m-d',strtotime($serch_data['from_date']));
				$serch_data['to_date']=date('Y-m-d',strtotime($serch_data['to_date']));
				if($serch_data['from_date']=='1970-01-01')
				$serch_data['from_date']='';
				if($serch_data['to_date']=='1970-01-01')
				$serch_data['to_date']='';
				if(isset($serch_data["from_date"]) && $serch_data["from_date"]!="" && isset($serch_data["to_date"]) && $serch_data["to_date"]!="")
				{
					
				$this->db->where("DATE_FORMAT(".$this->table_name4.".exp_date,'%Y-%m-%d') >='".$serch_data["from_date"]."' AND DATE_FORMAT(".$this->table_name4.".exp_date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
				}
				elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]!="" && isset($serch_data["to_date"]) && $serch_data["to_date"]=="")
				{
				
					$this->db->where("DATE_FORMAT(".$this->table_name4.".exp_date,'%Y-%m-%d') >='".$serch_data["from_date"]."'");
				}
				elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]=="" && isset($serch_data["to_date"]) && $serch_data["to_date"]!="")
				{
					
					$this->db->where("DATE_FORMAT(".$this->table_name4.".exp_date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
				}
			}
			$this->db->select('SUM(exp_value) AS fixed_exp');
			$query[0]['fixed_exp'] = $this->db->get('expense_fixed')->result_array();
			
			
			if(isset($serch_data) && !empty($serch_data))
			{
				$serch_data['from_date']=date('Y-m-d',strtotime($serch_data['from_date']));
				$serch_data['to_date']=date('Y-m-d',strtotime($serch_data['to_date']));
				if($serch_data['from_date']=='1970-01-01')
				$serch_data['from_date']='';
				if($serch_data['to_date']=='1970-01-01')
				$serch_data['to_date']='';
				if(isset($serch_data["from_date"]) && $serch_data["from_date"]!="" && isset($serch_data["to_date"]) && $serch_data["to_date"]!="")
				{
					
				$this->db->where("DATE_FORMAT(".$this->table_name5.".date,'%Y-%m-%d') >='".$serch_data["from_date"]."' AND DATE_FORMAT(".$this->table_name5.".date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
				}
				elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]!="" && isset($serch_data["to_date"]) && $serch_data["to_date"]=="")
				{
				
					$this->db->where("DATE_FORMAT(".$this->table_name5.".date,'%Y-%m-%d') >='".$serch_data["from_date"]."'");
				}
				elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]=="" && isset($serch_data["to_date"]) && $serch_data["to_date"]!="")
				{
					
					$this->db->where("DATE_FORMAT(".$this->table_name5.".date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
				}
			}
			$this->db->select('SUM(expense_variable_detaills.exp_amount) AS var_exp');
			$this->db->join('expense_variable_detaills','expense_variable_detaills.exp_var_id=expense_variable.id');
			$query[0]['var_exp'] = $this->db->get('expense_variable')->result_array();
			
			
			if(isset($serch_data) && !empty($serch_data))
			{
				$serch_data['from_date']=date('Y-m-d',strtotime($serch_data['from_date']));
				$serch_data['to_date']=date('Y-m-d',strtotime($serch_data['to_date']));
				if($serch_data['from_date']=='1970-01-01')
				$serch_data['from_date']='';
				if($serch_data['to_date']=='1970-01-01')
				$serch_data['to_date']='';
				if(isset($serch_data["from_date"]) && $serch_data["from_date"]!="" && isset($serch_data["to_date"]) && $serch_data["to_date"]!="")
				{
					
				$this->db->where("DATE_FORMAT(".$this->table_name7.".created_date,'%Y-%m-%d') >='".$serch_data["from_date"]."' AND DATE_FORMAT(".$this->table_name7.".created_date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
				}
				elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]!="" && isset($serch_data["to_date"]) && $serch_data["to_date"]=="")
				{
				
					$this->db->where("DATE_FORMAT(".$this->table_name7.".created_date,'%Y-%m-%d') >='".$serch_data["from_date"]."'");
				}
				elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]=="" && isset($serch_data["to_date"]) && $serch_data["to_date"]!="")
				{
					
					$this->db->where("DATE_FORMAT(".$this->table_name7.".created_date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
				}
			}
			$this->db->select('SUM(agent_comm_value) AS comm_val');
			$query[0]['commission'] = $this->db->get('commission')->result_array();
			
			
			return $query;
	}
	public function get_po_style_color($po_no)
	{
			//echo "<pre>";
			$this->db->select('SUM(qty) as style_color');
			$this->db->select('po_details.*');
			$this->db->select('master_style.style_name as po_style');
			$this->db->select('master_colour.colour as po_color');
			$this->db->where('po.grn_no',$po_no);
			$this->db->group_by('po_details.style_id');
			$this->db->group_by('po_details.color_id');
			$this->db->join('po_details','po_details.gen_id=po.id');
			$this->db->join('master_style','master_style.id=po_details.style_id');
			$this->db->join('master_colour','master_colour.id=po_details.color_id');
			$query = $this->db->get('po')->result_array();
			//print_r($query);
			//exit;
			return $query;
	}
	public function get_f_year()
	{
			$this->db->select('finacial_year');
			$this->db->group_by('stock_info.finacial_year');
			$query = $this->db->get('stock_info')->result_array();
			return $query;
	}
	
	public function get_grn_po_style_color($po_no)
	{
		//echo "<pre>";
			$this->db->select('SUM(qty) as style_color');
			$this->db->select('gen_details.*');
			$this->db->select('master_style.style_name as po_style');
			$this->db->select('master_colour.colour as po_color');
			$this->db->where('gen.grn_no',$po_no);
			$this->db->group_by('gen_details.style_id');
			$this->db->group_by('gen_details.color_id');
			$this->db->join('gen_details','gen_details.gen_id=gen.id');
			$this->db->join('master_style','master_style.id=gen_details.style_id');
			$this->db->join('master_colour','master_colour.id=gen_details.color_id');
			$query = $this->db->get('gen')->result_array();
	
			return $query;
	}

	public function get_po_vs_so($po)
	{
			$this->db->select('*');
			$this->db->where('po_details.gen_id',$po);
			$this->db->group_by('po_details.style_id');
			$this->db->group_by('po_details.color_id');
			$this->db->group_by('po_details.lot_no');
			$query = $this->db->get('po_details')->result_array();
			
			foreach($query as $val1)
			{	
				$this->db->select('gen_id,SUM(qty) AS s_qty');
				$this->db->select('sales_order_details.*');
				$this->db->select('sales_order.grn_no AS s_no');
				$this->db->select('master_style.style_name as po_style');
				$this->db->select('master_colour.colour as po_color');
				$this->db->where('sales_order_details.style_id',$val1['style_id']);
				$this->db->where('sales_order_details.color_id',$val1['color_id']);
				$this->db->where('sales_order_details.lot_no',$val1['lot_no']);
				$this->db->group_by('sales_order_details.gen_id');
				$this->db->join('sales_order','sales_order.id=sales_order_details.gen_id');
				$this->db->join('master_style','master_style.id=sales_order_details.style_id');
				$this->db->join('master_colour','master_colour.id=sales_order_details.color_id');
				$s_arr[] = $this->db->get('sales_order_details')->result_array();
			}
			return $s_arr;
			
	}

	
	function checking_invoice_billno($input)
 {
	
 $this->db->select('*');
 $this->db->where('inv_no',$input);
 $query=$this->db->get('purchase_receipt');

  if ($query->num_rows() >= 1) {
   return $query->result_array();
  }
 }	
 public function get_all_size($where)
 {
	$this->db->select('po_details.qty');
	$this->db->select('master_size.size');
 	$this->db->where($where);
	$this->db->order_by('po_details.size_id','asc');
	$this->db->join('master_size','master_size.id=po_details.size_id');
 	$query=$this->db->get('po_details');

 	if ($query->num_rows() >= 1) {
 	  return $query->result_array();
  	}
 }	
  public function get_all_size1($where)
 {
	$this->db->select('gen_details.qty');
	$this->db->select('master_size.size');
 	$this->db->where($where);
	$this->db->join('master_size','master_size.id=gen_details.size_id');
 	$query=$this->db->get('gen_details');

 	if ($query->num_rows() >= 1) {
 	  return $query->result_array();
  	}
 }	
  public function get_all_size2($where)
 {

	$this->db->select('sales_order_details.qty');
	$this->db->select('master_size.size');
 	$this->db->where($where);
	$this->db->join('master_size','master_size.id=sales_order_details.size_id');
 	$query=$this->db->get('sales_order_details');

 	if ($query->num_rows() >= 1) {
 	  return $query->result_array();
  	}
 }	
 	function get_so_landed($id)
	{
		$this->db->select('qty,c_landed');
		$this->db->where('gen_id',$id);
		$query=$this->db->get('sales_order_details');
	
		if ($query->num_rows() >= 1) {
		  return $query->result_array();
		}
	}
	public function get_all_pi_list($data)
	{
		$this->db->select('receipt_no');
		$this->db->like('receipt_no',$data['q']);
		$this->db->order_by('id','desc');
	 	$query = $this->db->get('purchase_receipt')->result_array();
		return $query;
	}
	public function get_all_inv_list($data)
	{
		$this->db->select('inv_no');
		$this->db->like('inv_no',$data['q']);
		$this->db->order_by('id','desc');
	 	$query = $this->db->get('purchase_receipt')->result_array();
		return $query;
	}
}