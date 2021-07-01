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
 
class Gen_model extends CI_Model{

    private $table_name1	= 'gen';
	private $table_name2	= 'gen_details';
    private $table_name3	= 'customer';
	private $table_name4	= 'master_style';
	private $table_name5	= 'master_style_size';
	private $table_name6	= 'vendor';
	private $table_name7	= 'po';
	private $table_name8	= 'stock_info';
	private $table_name9	= 'po_details';
	function __construct()
	{
		parent::__construct();

	}
	public function get_all_customer_by_id($id)
	{ 
		$this->db->select('*');
		$this->db->where('df',0);
		$this->db->where('status',1);
		$this->db->where('state_id',$id);
		$query = $this->db->get($this->table_name6);
		if ($query->num_rows() >= 0) {
			return $query->result_array();
		}
		return false;
	}
	public function get_all_customer_by_id1($id)
	{ 
		$this->db->select($this->table_name6.'.*');
		$this->db->select('master_state.vat,st,cst');
		$this->db->where($this->table_name6.'.df',0);
		$this->db->where($this->table_name6.'.status',1);
		$this->db->where('state_id',$id);
		$this->db->join('master_state','master_state.id='.$this->table_name6.'.state_id');
		$query = $this->db->get($this->table_name6);
		if ($query->num_rows() >= 0) {
			return $query->result_array();
		}
		return false;
	}
	public function check_so_no($po)
	{
		$this->db->select('grn_no');
		$this->db->where('grn_no',$po);
	 	$query = $this->db->get('sales_order')->result_array();
		return $query; 
	}
	public function get_all_style_details_by_id($id,$c_id=NULL)
	{
		
		$this->db->select($this->table_name4.'.style_name,master_style.mrp,master_style.sp');
		
		$this->db->where('df',0);
		$this->db->where($this->table_name4.'.status',1);
		$this->db->where($this->table_name4.'.id',$id);
		if(isset($c_id) && !empty($c_id))
		{
			$this->db->select('master_style_mrp.mrp as customer_mrp');
			$this->db->where('master_style_mrp.style_id',$id);
			$this->db->where('master_style_mrp.customer_id',$c_id);
			$this->db->join('master_style_mrp','master_style_mrp.style_id='.$this->table_name4.'.id');
		}
		$query = $this->db->get($this->table_name4);
		if ($query->num_rows() >= 0) {
			return $query->result_array();
		}
		return false;
	}
	public function get_all_style_details_by_id1($id)
	{
		$this->db->select($this->table_name4.'.*');
		$this->db->select('master_style_type.style_type');
		$this->db->where($this->table_name4.'.status',1);
		$this->db->where($this->table_name4.'.id',$id);
		$this->db->join('master_style_type','master_style_type.id='.$this->table_name4.'.style_type');
	 	$query = $this->db->get($this->table_name4)->result_array();
		$i=0;
		foreach($query as $val)
		{
			$this->db->select($this->table_name5.'.*');
			$this->db->select('master_size.size');
			$this->db->where($this->table_name5.'.style_id',$val['id']);
			$this->db->join('master_size','master_size.id='.$this->table_name5.'.size_id');
			$query[$i]['style_size'] = $this->db->get($this->table_name5)->result_array();
			$i++;
		}
		return $query;
	}
	public function get_land($id,$c_id,$lot_no)
	{
		$this->db->select('landed');
		$this->db->where('style_id',$id);
		$this->db->where('color_id',$c_id);
		$this->db->where('lot_no',$lot_no);
		$query=$this->db->get('po_details')->result_array();
		return $query;
	}
	public function get_land1($id,$c_id)
	{
		$this->db->select('sp');
		$this->db->where('id',$id);
		$query=$this->db->get('master_style')->result_array();
		return $query;
	}
	public function get_all_style_details_by_id2($id,$c_id,$lot_no)
	{
		$this->db->select($this->table_name4.'.*');
		$this->db->select('master_style_type.style_type');
		$this->db->where($this->table_name4.'.status',1);
		$this->db->where($this->table_name4.'.id',$id);
		$this->db->join('master_style_type','master_style_type.id='.$this->table_name4.'.style_type');
	 	$query = $this->db->get($this->table_name4)->result_array();
		$i=0;
	//	echo "<pre>";
		foreach($query as $val)
		{
			$this->db->select($this->table_name5.'.*');
			$this->db->select('master_size.size');
			$this->db->where($this->table_name5.'.style_id',$val['id']);
			$this->db->join('master_size','master_size.id='.$this->table_name5.'.size_id');
			$query[$i]['style_size'] = $this->db->get($this->table_name5)->result_array();
			$j=0;
		//	print_r($query[$i]['style_size']);
			foreach($query[$i]['style_size'] as $val1)
			{
				$sum=0;
				$this->db->select('SUM(qty) AS qty');
				$this->db->where($this->table_name8.'.style_id',$id);
				$this->db->where($this->table_name8.'.color_id',$c_id);
				$this->db->where($this->table_name8.'.size_id',$val1['size_id']);
				$this->db->where($this->table_name8.'.lot_no',$lot_no);
				$query[$i]['style_size'][$j]['avail_qty'] = $this->db->get($this->table_name8)->result_array();
				
				$this->db->select('SUM(qty) AS qty');
				$this->db->where('sales_order_details.style_id',$id);
				$this->db->where('sales_order_details.color_id',$c_id);
				$this->db->where('sales_order_details.size_id',$val1['size_id']);
				$this->db->where('sales_order_details.lot_no',$lot_no);
				$this->db->where('sales_order.invoice_status',0);
				$this->db->join('sales_order_details','sales_order_details.gen_id=sales_order.id');
				$sum = $this->db->get('sales_order')->result_array();
				
				
			/*	
				echo $id.'<br>';
				echo $c_id.'<br>';
				echo $val1['size_id'].'<br>';
				echo $lot_no.'<br>';
				echo $query[$i]['style_size'][$j]['avail_qty'][0]['qty'].'<br>';
				echo $sum[0]['qty'].'<br>';
				echo '<br>';*/
				
				$query[$i]['style_size'][$j]['avail_qty'][0]['qty']=$query[$i]['style_size'][$j]['avail_qty'][0]['qty']-$sum[0]['qty'];
				$j++;
			}
			$i++;
		}
		/*echo "<pre>";
		print_r($query);
		exit;*/
		return $query;
	}
	public function get_lot_name($data)
	{
		$this->db->select($this->table_name2.'.lot_no');
		$this->db->where($this->table_name2.'.status',1);
		$this->db->where($this->table_name2.'.style_id',$data['s_id']);
		$this->db->where($this->table_name2.'.color_id',$data['c_id']);
		$this->db->group_by($this->table_name2.'.lot_no');
	 	$query = $this->db->get($this->table_name2)->result_array();
		//echo "<pre>";
		//print_r($query);
		$i=0;
		foreach($query as $val1)
			{
				$sum=0;
				$this->db->select('SUM(qty) AS qty');
				$this->db->where($this->table_name8.'.style_id',$data['s_id']);
				$this->db->where($this->table_name8.'.color_id',$data['c_id']);
				$this->db->where($this->table_name8.'.lot_no',$val1['lot_no']);
				$query1 = $this->db->get($this->table_name8)->result_array();
				//echo $val1['lot_no'].'<br>';
				//print_r($query1);
				$this->db->select('SUM(qty) AS qty');
				$this->db->where('sales_order_details.style_id',$data['s_id']);
				$this->db->where('sales_order_details.color_id',$data['c_id']);
				$this->db->where('sales_order_details.lot_no',$val1['lot_no']);
				$this->db->where('sales_order.invoice_status',0);
				$this->db->join('sales_order_details','sales_order_details.gen_id=sales_order.id');
				$query2 = $this->db->get('sales_order')->result_array();
				//print_r($query2);
				//print_r('<br>');
				$check=$query1[0]['qty']-$query2[0]['qty'];
				if($check<=0)
				{
					unset($query[$i]);
				}
				$i++;
			}
		return $query;
	}
	public function insert_gen($data)
	{
		if ($this->db->insert($this->table_name1, $data)) {
			$insert_id = $this->db->insert_id();
			
			return $insert_id;
		}
		return false;
	}
	public function insert_gen_details($data)
	{
		if ($this->db->insert_batch($this->table_name2, $data)) {
			$insert_id = $this->db->insert_id();
			
			return $insert_id;
		}
		return false;
	}
	public function get_all_gen($serch_data=NULL)
	{
		if(isset($serch_data) && !empty($serch_data))
		{
			$serch_data['from_date']=date('Y-m-d',strtotime($serch_data['from_date']));
			$serch_data['to_date']=date('Y-m-d',strtotime($serch_data['to_date']));
			if($serch_data['from_date']=='1970-01-01')
			$serch_data['from_date']='';
			if($serch_data['to_date']=='1970-01-01')
			$serch_data['to_date']='';
			
			if(!empty($serch_data['state'])  && $serch_data['state']!='Select')
			{
				$this->db->where('master_state.id',$serch_data['state']);
			}
			if(!empty($serch_data['supplier']) && $serch_data['supplier']!='Select')
			{
				$this->db->where('vendor.id',$serch_data['supplier']);
			}
			if(!empty($serch_data['po']))
			{
				$this->db->where($this->table_name1.'.po_no',$serch_data['po']);
			}
			if(!empty($serch_data['grn']))
			{
				$this->db->where($this->table_name1.'.grn_no',$serch_data['grn']);
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
			elseif(isset($serch_data["style"]) && $serch_data["style"]!="")
			{
				
				$this->db->where('master_style.id',$serch_data["style"]);
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
			$this->db->where("DATE_FORMAT(".$this->table_name1.".inv_date,'%Y-%m-%d') >='".$from."' AND DATE_FORMAT(".$this->table_name1.".inv_date,'%Y-%m-%d') <= '".$to."'" );	
		}
		$this->db->select($this->table_name1.'.grn_no as grn');
		$this->db->select('po.*');
		$this->db->select($this->table_name1.'.*,'.$this->table_name1.'.id as gen_id');
		$this->db->select('vendor.name,store_name');
		$this->db->select('master_state.state');
		$this->db->select('master_style.style_name');
		$this->db->where($this->table_name1.'.status',1);
		$this->db->where($this->table_name1.'.df',0);
		$this->db->order_by($this->table_name1.'.id','desc');
		
		$this->db->group_by('gen_details.gen_id');
		$this->db->join('gen_details','gen_details.gen_id='.$this->table_name1.'.id');
		$this->db->join('master_style','master_style.id=gen_details.style_id');
		
		$this->db->join('po','po.grn_no='.$this->table_name1.'.po_no');
		$this->db->join('vendor','vendor.id=po.customer');
		$this->db->join('master_state','master_state.id=po.state');
	 	$query = $this->db->get($this->table_name1)->result_array();
		return $query;
	}
	public function get_gen_by_id($id)
	{
		$this->db->select($this->table_name1.'.*,'.$this->table_name1.'.id as gen_id');
		$this->db->select('po.*');
		$this->db->select('vendor.name');
		$this->db->select('master_state.state');
		$this->db->where($this->table_name1.'.status',1);
		$this->db->where($this->table_name1.'.df',0);
		$this->db->where($this->table_name1.'.id',$id);
		$this->db->join('po','po.grn_no='.$this->table_name1.'.po_no');
		$this->db->join('vendor','vendor.id=po.customer');
		$this->db->join('master_state','master_state.id=po.state');
	 	$query = $this->db->get($this->table_name1)->result_array();
		$i=0;
		foreach($query as $val)
		{
			$this->db->select($this->table_name2.'.style_id,color_id');
			$this->db->select('master_style.style_name,mrp');
			$this->db->select('master_colour.colour');
			$this->db->where($this->table_name2.'.gen_id',$val['gen_id']);
			$this->db->group_by($this->table_name2.'.style_id');
			$this->db->group_by($this->table_name2.'.color_id');
			$this->db->join('master_style','master_style.id='.$this->table_name2.'.style_id');
			$this->db->join('master_colour','master_colour.id='.$this->table_name2.'.color_id');
			$query[$i]['style_size'] = $this->db->get($this->table_name2)->result_array();
			$j=0;
			foreach($query[$i]['style_size'] as $val1)
			{
				$this->db->select($this->table_name2.'.size_id,qty');
				$this->db->select('master_size.size');
				$this->db->where($this->table_name2.'.gen_id',$val['gen_id']);
				$this->db->where($this->table_name2.'.style_id',$val1['style_id']);
				$this->db->where($this->table_name2.'.color_id',$val1['color_id']);
				$this->db->join('master_size','master_size.id='.$this->table_name2.'.size_id');
				$query[$i]['style_size'][$j]['list'] = $this->db->get($this->table_name2)->result_array();
				$j++;
			}
			
			
			$i++;
		}
		
		return $query;
	}
	public function delete_all_data($id)
	{
		$this->db->where($this->table_name2.'.gen_id',$id);
		if ($this->db->delete($this->table_name2)) {
			return true;
		}
		return false;
	}
	public function update_all_data($data,$id)
	{
		$this->db->where($this->table_name1.'.id',$id);
		if ($this->db->update($this->table_name1,$data)) {
			return true;
		}
		return false;
	}
	public function get_all_po($atten_inputs)
	{

		$this->db->select('*');			
		$this->db->like('grn_no',$atten_inputs['q']);  
		$this->db->order_by('id','desc'); 			
		$query= $this->db->get($this->table_name7)->result_array();	
		return $query;	
	}
	public function get_all_po_for_add_gen($atten_inputs)
	{

		$this->db->select('*');			
		$this->db->like('grn_no',$atten_inputs['q']); 
		$this->db->order_by('id','desc');
		$this->db->where('po.delivery_status !=',2);		
		$query= $this->db->get($this->table_name7)->result_array();
		$i=0;
		
		foreach($query as $val)
		{
			$cancel_status='';
			if($val['delivery_status']==0)
			{
			   $date = strtotime($val['delivery_schedule']);
			   $date = strtotime("+10 day", $date);
			   
			   if(strtotime(date('d-m-Y', $date)) < strtotime(date('d-m-Y')))
				   $cancel_status='true';
			   else
				   $cancel_status='false';
			}
			else
				$cancel_status='false';
			
			if($cancel_status=='true')
			{	
				unset($query[$i]);
			}
			$i++;
		}
		return $query;	
	}
	public function get_all_po_for_add_gen1($atten_inputs)
	{

		$this->db->select('*');			
		$this->db->like('grn_no',$atten_inputs['q']); 
		$this->db->order_by('id','desc');	
		$query= $this->db->get($this->table_name7)->result_array();
		$i=0;
		
		foreach($query as $val)
		{
			$cancel_status='';
			if($val['delivery_status']==0)
			{
			   $date = strtotime($val['delivery_schedule']);
			   $date = strtotime("+10 day", $date);
			   
			   if(strtotime(date('d-m-Y', $date)) < strtotime(date('d-m-Y')))
				   $cancel_status='true';
			   else
				   $cancel_status='false';
			}
			else
				$cancel_status='false';
			
			if($cancel_status=='true')
			{	
				unset($query[$i]);
			}
			$i++;
		}
		return $query;	
	}
	public function get_all_po_no($atten_inputs)
	{

		$this->db->select('*');			
		$this->db->like('po_no',$atten_inputs['q']);
		$this->db->group_by('po_no');   	
		$this->db->order_by('id','desc');		
		$query= $this->db->get($this->table_name1)->result_array();	
		return $query;	
	}
	public function get_all_grn_no($atten_inputs)
	{

		$this->db->select('*');			
		$this->db->like('grn_no',$atten_inputs['q']);   
		$this->db->order_by('id','desc');			
		$query= $this->db->get($this->table_name1)->result_array();	
		return $query;	
	}
	
	public function get_total_qty($p_id)
	{
		$this->db->select('po.full_total');
		$this->db->where('po.grn_no',$p_id);
	 	$query = $this->db->get('po')->result_array();

		$this->db->select('SUM(total_qty) AS total_qty');			
		$this->db->where('po_no',$p_id);   			
		$query1=$this->db->get($this->table_name1)->result_array();	
		
		if($query[0]['full_total']>$query1[0]['total_qty'])
			$status=1;
		else
			$status=2;
			
		$this->db->where('po.grn_no',$p_id);
		if ($this->db->update('po',array('delivery_status'=>$status))) {
			return true;
		}
		return false;
	}	
	public function get_all_color_details_by_id($s_id)
	{
		$this->db->select('master_colour.id,master_colour.colour');
		$this->db->where('master_style_color.status',1);
		$this->db->where('master_style_color.style_id',$s_id);
		$this->db->join('master_colour','master_colour.id=master_style_color.color_id');
		$query = $this->db->get('master_style_color');
		if ($query->num_rows() >= 0) {
			return $query->result_array();
		}
		return false;
	}
	public function check_available($id,$c_id,$size_name,$lot_no)
	{
		 $this->db->select('id');
		 $this->db->where('size',$size_name);
		 $size=$this->db->get('master_size')->result_array();
	//	 print_r($size_name);
		$this->db->select('SUM(qty) AS qty');
		$this->db->where($this->table_name8.'.style_id',$id);
		$this->db->where($this->table_name8.'.color_id',$c_id);
		$this->db->where($this->table_name8.'.lot_no',$lot_no);
		
		$this->db->where($this->table_name8.'.size_id',$size[0]['id']);
		$query = $this->db->get($this->table_name8)->result_array();
		 
		
		$this->db->select('SUM(qty) AS qty');
		$this->db->where('sales_order_details.style_id',$id);
		$this->db->where('sales_order_details.color_id',$c_id);
		
		$this->db->where('sales_order_details.size_id',$size[0]['id']);
		$this->db->where('sales_order_details.lot_no',$lot_no);
		$this->db->where('sales_order.invoice_status',0);
		$this->db->join('sales_order_details','sales_order_details.gen_id=sales_order.id');
		$sum = $this->db->get('sales_order')->result_array();
		$query[0]['avail_qty']=$query[0]['qty']-$sum[0]['qty'];
		
		$query[0]['size_id']=$size[0]['id'];
		
		return $query;
	}
	public function check_available1($size_name)
	{
		 $this->db->select('id as size_id');
		 $this->db->where('size',$size_name);
		 $size=$this->db->get('master_size')->result_array();
		return $size;
	}
	public function get_lot_by_po($p_no)
	{
		$this->db->select('po.lot_no');
		$this->db->where('po.grn_no',$p_no);
		$query = $this->db->get('po');
		
		$this->db->where('po.grn_no',$p_no);
		$this->db->update('po',array('purchase_receipt_status'=>0));
		
		if ($query->num_rows() >= 0) {
			return $query->result_array();
		}
		return false;
	}
	public function get_gen_info($p_no)
	{
		$this->db->select('grn_no,total_value,id,total_qty,inv_date as due_date');
		$this->db->where('po_no',$p_no);
		$this->db->where('inv_status',0);
		$query = $this->db->get('gen');
		if ($query->num_rows() >= 0) {
			return $query->result_array();
		}
		return false;
	}
	public function get_all_where_for_style($data)
	{
		$this->db->select('landed');
		$this->db->where('style_id',$data['s_id']);
		$this->db->where('color_id',$data['c_id']);
		$this->db->where('lot_no',$data['lotno']);
		$this->db->group_by('lot_no');
		$query = $this->db->get('po_details');
		if ($query->num_rows() >= 0) {
			return $query->result_array();
		}
		return false;
	}
	public function check_po_no($po)
	{
		$this->db->select('grn_no');
		$this->db->like('grn_no',$po);
		$this->db->order_by('id','desc');
	 	$query = $this->db->get('gen')->result_array();
		return $query; 
	}
        public function check_po_no1($po)
	{
		$this->db->select('grn_no');
		$this->db->like('grn_no',$po);
		$this->db->order_by('id','desc');
	 	$query = $this->db->get('gen')->result_array();
		return $query; 
	}
	function po_duplication($input)
    {
 
		  $this->db->select('*');
		  $this->db->where('grn_no',$input);
		  $this->db->where('delivery_status',2);
		  $query=$this->db->get('po');
		   
		  if ($query->num_rows() >= 1) 
		  {
		   return $query->result_array();
	      }
	}
	
}