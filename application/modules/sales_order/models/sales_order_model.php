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
 
class Sales_order_model extends CI_Model{

    private $table_name1	= 'sales_order';
	private $table_name2	= 'sales_order_details';
    private $table_name3	= 'customer';
	private $table_name4	= 'master_style';
	private $table_name5	= 'master_style_size';
	private $table_name6	= 'vendor';
	private $table_name7	= 'sales_order_short_qty_details';
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
		$query = $this->db->get($this->table_name3);
		if ($query->num_rows() >= 0) {
			return $query->result_array();
		}
		return false;
	}
	public function get_all_style_details_by_id($id)
	{
		$this->db->select('style_name');
		$this->db->where('df',0);
		$this->db->where('status',1);
		$this->db->where('id',$id);
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
	public function insert_short_qty_details($data)
	{
		if ($this->db->insert_batch($this->table_name7, $data)) {
			$insert_id = $this->db->insert_id();
			return $insert_id;
		}
		return false;
	}
	public function upload_salse_order_info($data)
	{
		if ($this->db->insert_batch('upload_salse_order_info', $data)) {
		
			return true;
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
				$this->db->where($this->table_name1.'.state',$serch_data['state']);
			}
			if(!empty($serch_data['customer']) && $serch_data['customer']!='Select')
			{
				$this->db->where($this->table_name1.'.customer',$serch_data['customer']);
			}
			if(!empty($serch_data['po']))
			{
				$this->db->where($this->table_name1.'.grn_no',$serch_data['po']);
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
			$this->db->where("DATE_FORMAT(".$this->table_name1.".inv_date,'%Y-%m-%d') >='".$from."' AND DATE_FORMAT(".$this->table_name1.".inv_date,'%Y-%m-%d') <= '".$to."'" );	
		}
		$this->db->select($this->table_name1.'.*');
		$this->db->select('customer.name,store_name');
		$this->db->select('master_state.state');
		$this->db->where($this->table_name1.'.status',1);
		$this->db->where($this->table_name1.'.df',0);
		$this->db->order_by($this->table_name1.'.id','desc');
		$this->db->join('customer','customer.id='.$this->table_name1.'.customer');
		$this->db->join('master_state','master_state.id='.$this->table_name1.'.state');
	 	$query = $this->db->get($this->table_name1)->result_array();
		return $query;
	}
	public function get_gen_by_id($id,$lot_no=NULL)
	{
		$this->db->select($this->table_name1.'.*');
		$this->db->select('customer.name,store_name');
		$this->db->select('master_state.state');
		$this->db->where($this->table_name1.'.status',1);
		$this->db->where($this->table_name1.'.df',0);
		$this->db->where($this->table_name1.'.id',$id);
		$this->db->join('customer','customer.id='.$this->table_name1.'.customer');
		$this->db->join('master_state','master_state.id='.$this->table_name1.'.state');
	 	$query = $this->db->get($this->table_name1)->result_array();
		$i=0;
		foreach($query as $val)
		{
			if(isset($lot_no) && !empty($lot_no))
			{
				$this->db->where_in($this->table_name2.'.lot_no',$lot_no);
			}
			$this->db->select($this->table_name2.'.style_id,color_id,lot_no');
			
			$this->db->select('master_style.style_name,mrp,style_desc');
			$this->db->select('master_colour.colour');
			$this->db->where($this->table_name2.'.gen_id',$val['id']);
			$this->db->group_by($this->table_name2.'.style_id');
			$this->db->group_by($this->table_name2.'.color_id');
			$this->db->group_by($this->table_name2.'.lot_no');
			$this->db->join('master_style','master_style.id='.$this->table_name2.'.style_id');
			$this->db->join('master_colour','master_colour.id='.$this->table_name2.'.color_id');
			$query[$i]['style_size'] = $this->db->get($this->table_name2)->result_array();
			$j=0;
			
			foreach($query[$i]['style_size'] as $val1)
			{
				if(isset($lot_no) && !empty($lot_no))
				{
					$this->db->where_in($lot_no);	
				}
				$this->db->select($this->table_name2.'.size_id,SUM(qty) as qty');
				$this->db->select($this->table_name2.'.id as s_d_id');
				$this->db->select('master_size.size');
				$this->db->where($this->table_name2.'.gen_id',$val['id']);	
				$this->db->where($this->table_name2.'.style_id',$val1['style_id']);
				$this->db->where($this->table_name2.'.color_id',$val1['color_id']);
				$this->db->where($this->table_name2.'.lot_no',$val1['lot_no']);
				$this->db->group_by($this->table_name2.'.size_id');
				$this->db->join('master_size','master_size.id='.$this->table_name2.'.size_id');
				$query[$i]['style_size'][$j]['list'] = $this->db->get($this->table_name2)->result_array();
				$j++;
			}
			
			
			$i++;
		}
		return $query;
	}
	public function get_gen_by_id1($so)
	{
		$this->db->select($this->table_name1.'.*');
		$this->db->select('customer.name,store_name');
		$this->db->select('master_state.state');
		$this->db->where($this->table_name1.'.status',1);
		$this->db->where($this->table_name1.'.df',0);
		$this->db->where($this->table_name1.'.grn_no',$so);
		$this->db->join('customer','customer.id='.$this->table_name1.'.customer');
		$this->db->join('master_state','master_state.id='.$this->table_name1.'.state');
	 	$query = $this->db->get($this->table_name1)->result_array();
	
		$i=0;
		foreach($query as $val)
		{
			$this->db->select($this->table_name2.'.style_id,color_id,lot_no,c_landed,c_mrp');
			$this->db->select('master_style.style_name,mrp');
			$this->db->select('master_colour.colour');
			$this->db->where($this->table_name2.'.gen_id',$val['id']);
			$this->db->group_by($this->table_name2.'.style_id');
			$this->db->group_by($this->table_name2.'.color_id');
			$this->db->group_by($this->table_name2.'.lot_no');
			$this->db->join('master_style','master_style.id='.$this->table_name2.'.style_id');
			$this->db->join('master_colour','master_colour.id='.$this->table_name2.'.color_id');
			$query[$i]['style_size'] = $this->db->get($this->table_name2)->result_array();
			$j=0;
			
			foreach($query[$i]['style_size'] as $val1)
			{
				$this->db->select($this->table_name2.'.size_id,SUM(qty) as qty');
				$this->db->select('master_size.size');
				$this->db->where($this->table_name2.'.gen_id',$val['id']);	
				$this->db->where($this->table_name2.'.style_id',$val1['style_id']);
				$this->db->where($this->table_name2.'.color_id',$val1['color_id']);
				$this->db->where($this->table_name2.'.lot_no',$val1['lot_no']);
				$this->db->group_by($this->table_name2.'.size_id');
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
	public function get_all_so_no($po)
	{
		$this->db->select('grn_no');
		$this->db->like('grn_no',$po['q']);
		$this->db->order_by('id','desc');
	 	$query = $this->db->get($this->table_name1)->result_array();
		return $query;  
	}
	public function get_all_so_for_expense()
	{
		$this->db->select('receipt_no,id');
	 	$query = $this->db->get('receipt')->result_array();
		return $query;  
	}
	public function get_all_salse_id()
	{
		$this->db->select('id');
		$this->db->where('package_status',0);
	 	$query = $this->db->get($this->table_name1)->result_array();
		return $query;  
	}
	public function get_sp($id)
	{
		$this->db->select('sp');
		$this->db->where('id',$id);
	 	$query = $this->db->get($this->table_name1)->result_array();
		return $query;  
	}
	public function get_sales_details($s_id)
	{
		$this->db->select('style_id,color_id,size_id,qty,gen_id,c_mrp,lot_no');
		$this->db->where('gen_id',$s_id);
	 	$query = $this->db->get($this->table_name2)->result_array();
		return $query; 
	}
	public function get_sales_details1($s_id,$st_id)
	{
		$this->db->select('style_id,color_id,size_id,qty,gen_id,c_mrp');
		$this->db->where('gen_id',$s_id);
		$this->db->where('style_id',$st_id);
	 	$query = $this->db->get($this->table_name2)->result_array();
		return $query; 
	}
	public function get_customer_mrp($c_id,$s_id)
	{
		$this->db->select('mrp');
		$this->db->where('customer_id',$c_id);
		$this->db->where('style_id',$s_id);
	 	$query = $this->db->get('master_style_mrp')->result_array();
		return $query; 
	}
	public function get_customer_mrp1($s_id)
	{
		$this->db->select('mrp');
		$this->db->where('customer_id',$c_id);
		$this->db->where('style_id',$s_id);
	 	$query = $this->db->get('master_style_mrp')->result_array();
		return $query; 
	}
	public function get_customer_mrp2($data)
	{
		$this->db->select('c_mrp');
		$this->db->where('sales_order_details.style_id',$data['style_id']);
		$this->db->where('sales_order_details.color_id',$data['color_id']);
		$this->db->where('sales_order_details.gen_id',$data['sales_order']);
		$this->db->group_by('sales_order_details.style_id');
		$query= $this->db->get('sales_order_details')->result_array();
		return $query; 
	}
	public function get_lot_no($data)
	{
		$this->db->select('lot_no');
		$this->db->where('gen_id',$data['gen_id']);
		$this->db->where('style_id',$data['style_id']);
		$this->db->where('color_id',$data['color_id']);
		$this->db->where('size_id',$data['size_id']);
	 	$query = $this->db->get($this->table_name2)->result_array();
		return $query; 
	} 
	public function get_sales_loss_report($data)
	{
		/*$this->db->select($this->table_name1.'.*');
		$this->db->where($this->table_name1.'.grn_no',$data['so_no']);
		$this->db->select('customer.name,store_name');
		$this->db->join('customer','customer.id='.$this->table_name1.'.customer');
	 	$query = $this->db->get($this->table_name1)->result_array();
	 	$i=0;
		foreach($query as $val)
		{
			$this->db->select($this->table_name7.'.*');
			//$this->db->select('master_size.size');
			$this->db->where($this->table_name7.'.gen_id',$val['id']);
			//$this->db->join('master_size','master_size.id='.$this->table_name7.'.size_id');
				//$this->db->group_by('style_id',$data['style_id']);
				//$this->db->group_by('color_id',$data['color_id']);
			$query[$i]['sales_loss'] = $this->db->get($this->table_name7)->result_array();
			$i++;
		}
		*/
		
		
		
		$this->db->select($this->table_name1.'.*');
		$this->db->select('customer.name,store_name');
		$this->db->select('master_state.state');
		$this->db->where($this->table_name1.'.status',1);
		$this->db->where($this->table_name1.'.df',0);
		if(!empty($data['so_no']))
		$this->db->where($this->table_name1.'.grn_no',$data['so_no']);
		$this->db->join('customer','customer.id='.$this->table_name1.'.customer');
		$this->db->join('master_state','master_state.id='.$this->table_name1.'.state');
	 	$query = $this->db->get($this->table_name1)->result_array();
	
		$i=0;
		foreach($query as $val)
		{
			$this->db->select($this->table_name7.'.style_id,color_id');
			$this->db->select('master_style.style_name,mrp');
			$this->db->select('master_colour.colour');
			$this->db->where($this->table_name7.'.gen_id',$val['id']);
			if(!empty($data['style']))
			$this->db->where($this->table_name7.'.style_id',$data['style']);
			if(!empty($data['color']))
			$this->db->where($this->table_name7.'.color_id',$data['color']);
			$this->db->group_by($this->table_name7.'.style_id');
			$this->db->group_by($this->table_name7.'.color_id');
			$this->db->join('master_style','master_style.id='.$this->table_name7.'.style_id');
			$this->db->join('master_colour','master_colour.id='.$this->table_name7.'.color_id');
			$query[$i]['style_size'] = $this->db->get($this->table_name7)->result_array();
			$j=0;
			
			foreach($query[$i]['style_size'] as $val1)
			{
				$this->db->select($this->table_name7.'.size_id,SUM(qty) as qty');
				$this->db->select('master_size.size');
				$this->db->where($this->table_name7.'.gen_id',$val['id']);	
				$this->db->where($this->table_name7.'.style_id',$val1['style_id']);
				$this->db->where($this->table_name7.'.color_id',$val1['color_id']);
				$this->db->group_by($this->table_name7.'.size_id');
				$this->db->join('master_size','master_size.id='.$this->table_name7.'.size_id');
				$query[$i]['style_size'][$j]['list'] = $this->db->get($this->table_name7)->result_array();
				$j++;
			}
			
			$i++;
		}
		return $query;
		
		//$query = $this->db->get('sales_order_short_qty_details')->result_array();
		//return $query;
	}
	public function get_sales_loss_report1($serch_data)
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
				
			$this->db->where("DATE_FORMAT(".$this->table_name7.".inv_date,'%Y-%m-%d') >='".$serch_data["from_date"]."' AND DATE_FORMAT(".$this->table_name7.".inv_date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
			}
			elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]!="" && isset($serch_data["to_date"]) && $serch_data["to_date"]=="")
			{
			
				$this->db->where("DATE_FORMAT(".$this->table_name7.".inv_date,'%Y-%m-%d') >='".$serch_data["from_date"]."'");
			}
			elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]=="" && isset($serch_data["to_date"]) && $serch_data["to_date"]!="")
			{
				
				$this->db->where("DATE_FORMAT(".$this->table_name7.".inv_date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
			}
			
		}
		$this->db->group_by($this->table_name7.'.customer_id');
		$this->db->select('customer.name,store_name,customer.id as customer_id,selling_percent');
		$this->db->join('customer','customer.id='.$this->table_name7.'.customer_id');
	 	$cust_query = $this->db->get($this->table_name7)->result_array();
	//	echo "<pre>";
	//	print_r($cust_query);
		$f=0;
		foreach($cust_query as $c_val)
		{
			$this->db->select('SUM(qty) as total_qty');
			$this->db->group_by($this->table_name7.'.style_id');
			$this->db->group_by($this->table_name7.'.color_id');
			$this->db->select('master_style.style_name,master_style.id as style_id');
			$this->db->select('master_colour.colour');
			$this->db->join('master_style','master_style.id='.$this->table_name7.'.style_id');
			$this->db->join('master_colour','master_colour.id='.$this->table_name7.'.color_id');
			$this->db->where($this->table_name7.'.customer_id',$c_val['customer_id']);
			$cust_query[$f]['style_list'] = $this->db->get($this->table_name7)->result_array();	
			$f++;
		}
		/*print_r($cust_query);
		exit;
		$f=0;
		foreach($cust_query as $c_val)
		{
			$this->db->select($this->table_name1.'.id as so_id');
			$this->db->where($this->table_name1.'.status',1);
			$this->db->where($this->table_name1.'.df',0);
			$this->db->where($this->table_name1.'.customer',$c_val['customer_id']);
			$cust_query[$f]['so_list'] = $this->db->get($this->table_name1)->result_array();
			$i=0;
			foreach($cust_query[$f]['so_list'] as $val)
			{
				$this->db->select($this->table_name7.'.style_id,color_id');
				$this->db->select('master_style.style_name,mrp');
				$this->db->select('master_colour.colour');
				$this->db->where($this->table_name7.'.gen_id',$val['so_id']);
				$this->db->group_by($this->table_name7.'.style_id');
				$this->db->group_by($this->table_name7.'.color_id');
				$this->db->join('master_style','master_style.id='.$this->table_name7.'.style_id');
				$this->db->join('master_colour','master_colour.id='.$this->table_name7.'.color_id');
				$cust_query[$f]['so_list'][$i]['style_size'] = $this->db->get($this->table_name7)->result_array();
				$j=0;
				if(isset($cust_query[$f]['so_list'][$i]['style_size']) && !empty($cust_query[$f]['so_list'][$i]['style_size']))
				{
					foreach($cust_query[$f]['so_list'][$i]['style_size'] as $val1)
					{
						$this->db->select($this->table_name7.'.size_id,SUM(qty) as qty');
						$this->db->select('master_size.size');
						$this->db->where($this->table_name7.'.gen_id',$val['so_id']);	
						$this->db->where($this->table_name7.'.style_id',$val1['style_id']);
						$this->db->where($this->table_name7.'.color_id',$val1['color_id']);
						$this->db->group_by($this->table_name7.'.size_id');
						$this->db->join('master_size','master_size.id='.$this->table_name7.'.size_id');
						$cust_query[$f]['so_list'][$i]['style_size'][$j]['list'] = $this->db->get($this->table_name7)->result_array();
						$j++;
					}
				}
				else
				{
					unset($cust_query[$f]['so_list'][$i]);
				}
				
				
				$i++;
			}
		}
		print_r($cust_query);
		exit;
		
		*/
	
		
		return $cust_query;
		
		//$query = $this->db->get('sales_order_short_qty_details')->result_array();
		//return $query;
	}
	
}