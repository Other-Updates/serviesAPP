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
 
class Package_model extends CI_Model{

	private $table_name1	= 'sales_order';
	private $table_name2	= 'sales_order_details';
	private $table_name3	= 'customer';
	private $table_name4	= 'master_style';
	private $table_name5	= 'master_style_size';
	private $table_name6	= 'vendor';
	private $table_name7	= 'package';
	private $table_name8	= 'package_details';
	function __construct()
	{
		parent::__construct();

	}
	public function get_package_by_customer($c_id)
	{
		$this->db->select($this->table_name1.'.customer');
		$this->db->select($this->table_name1.'.id as so_id');
		$this->db->select('customer.name,store_name');
		$this->db->select('master_state.state');
		$this->db->select('master_style.style_name,master_style.id as style_id');
		$this->db->where($this->table_name1.'.status',1);
		$this->db->where($this->table_name1.'.df',0);
		$this->db->where($this->table_name1.'.package_status',0);
		$this->db->where($this->table_name1.'.customer',$c_id);
		$this->db->group_by('sales_order_details.style_id');
		$this->db->join('customer','customer.id='.$this->table_name1.'.customer');
		$this->db->join('master_state','master_state.id='.$this->table_name1.'.state');
		$this->db->join('sales_order_details','sales_order_details.gen_id='.$this->table_name1.'.id');
		$this->db->join('master_style','master_style.id=sales_order_details.style_id');
	 	$query = $this->db->get($this->table_name1)->result_array();
		
		$this->db->select('sales_order_details.gen_id');
		$this->db->where($this->table_name1.'.status',1);
		$this->db->where($this->table_name1.'.df',0);
		$this->db->where($this->table_name1.'.package_status',0);
		$this->db->where($this->table_name1.'.customer',$c_id);
		$this->db->group_by('sales_order_details.gen_id');
		$this->db->join('sales_order_details','sales_order_details.gen_id='.$this->table_name1.'.id');
	 	$list_query = $this->db->get($this->table_name1)->result_array();
	
		$arr_chek=array();
		foreach($list_query as $chec_gen)
		{
			$arr_chek[]=$chec_gen['gen_id'];
		}
	
		$i=0;
		foreach($query as $val)
		{
			$this->db->select('sales_order_details.color_id');
			$this->db->select('master_colour.colour');
			$this->db->where($this->table_name2.'.style_id',$val['style_id']);
			$this->db->group_by($this->table_name2.'.color_id');
			$this->db->where($this->table_name1.'.package_status',0);
			$this->db->where_in($this->table_name1.'.id',$arr_chek);
			$this->db->join('sales_order_details','sales_order_details.gen_id='.$this->table_name1.'.id');
			$this->db->join('master_colour','master_colour.id='.$this->table_name2.'.color_id');
			$query[$i]['style_color'] = $this->db->get($this->table_name1)->result_array();
			$j=0;
			foreach($query[$i]['style_color'] as $val1)
			{
				$this->db->select('sales_order_details.size_id,SUM(qty) as total_qty');
				$this->db->select('master_size.size');
				$this->db->where($this->table_name2.'.style_id',$val['style_id']);
				$this->db->where($this->table_name2.'.color_id',$val1['color_id']);
				$this->db->where_in($this->table_name1.'.id',$arr_chek);
				$this->db->group_by($this->table_name2.'.size_id');
				$this->db->where($this->table_name1.'.package_status',0);
				$this->db->join('sales_order_details','sales_order_details.gen_id='.$this->table_name1.'.id');
				$this->db->join('master_size','master_size.id='.$this->table_name2.'.size_id');
				$query[$i]['style_color'][$j]['size'] = $this->db->get($this->table_name1)->result_array();
				
				$j++;
			}	
			$i++;
		}
		return $query;
	}
	public function get_package_by_so($c_id,$so_id)
	{
		$this->db->select($this->table_name1.'.customer');
		$this->db->select('customer.name,store_name');
		$this->db->select('master_state.state');
		$this->db->select('master_style.style_name,master_style.id as style_id');
		$this->db->where($this->table_name1.'.status',1);
		$this->db->where($this->table_name1.'.df',0);
		$this->db->where($this->table_name1.'.package_status',0);
		$this->db->where($this->table_name1.'.customer',$c_id);
		$this->db->where_in($this->table_name1.'.id',$so_id);
		$this->db->group_by('sales_order_details.style_id');
		$this->db->join('customer','customer.id='.$this->table_name1.'.customer');
		$this->db->join('master_state','master_state.id='.$this->table_name1.'.state');
		$this->db->join('sales_order_details','sales_order_details.gen_id='.$this->table_name1.'.id');
		$this->db->join('master_style','master_style.id=sales_order_details.style_id');
	 	$query = $this->db->get($this->table_name1)->result_array();
		
		$i=0;
		foreach($query as $val)
		{
			$this->db->select('sales_order_details.color_id');
			$this->db->select('master_colour.colour');
			$this->db->where($this->table_name2.'.style_id',$val['style_id']);
			$this->db->group_by($this->table_name2.'.color_id');
			$this->db->where_in($this->table_name1.'.id',$so_id);
			$this->db->join('sales_order_details','sales_order_details.gen_id='.$this->table_name1.'.id');
			$this->db->join('master_colour','master_colour.id='.$this->table_name2.'.color_id');
			$query[$i]['style_color'] = $this->db->get($this->table_name1)->result_array();
			$j=0;
			foreach($query[$i]['style_color'] as $val1)
			{
				$this->db->select('sales_order_details.size_id,SUM(qty) as total_qty');
				$this->db->select('master_size.size');
				$this->db->where($this->table_name2.'.style_id',$val['style_id']);
				$this->db->where($this->table_name2.'.color_id',$val1['color_id']);
				$this->db->group_by($this->table_name2.'.size_id');
				$this->db->where_in($this->table_name1.'.id',$so_id);
				$this->db->join('sales_order_details','sales_order_details.gen_id='.$this->table_name1.'.id');
				$this->db->join('master_size','master_size.id='.$this->table_name2.'.size_id');
				$query[$i]['style_color'][$j]['size'] = $this->db->get($this->table_name1)->result_array();
				
				$j++;
			}	
			$i++;
		}
		return $query;
	}
	public function check_so_no($po)
	{
		$this->db->select('package_slip');
		$this->db->where('package_slip',$po);
	 	$query = $this->db->get('package')->result_array();
		return $query; 
	}
	public function insert_package($data)
	{
		if ($this->db->insert($this->table_name7, $data)) {
			$insert_id = $this->db->insert_id();
			
			return $insert_id;
		}
		return false;
	}

	public function insert_package_details($data)
	{
		if ($this->db->insert_batch($this->table_name8, $data)) {

			return true;
		}
		return false;
	}
	public function get_all_package($serch_data=NULL)
	{
		if(isset($serch_data) && !empty($serch_data))
		{
			
			$serch_data['from_date']=date('Y-m-d',strtotime($serch_data['from_date']));
			$serch_data['to_date']=date('Y-m-d',strtotime($serch_data['to_date']));
			if($serch_data['from_date']=='1970-01-01')
			$serch_data['from_date']='';
			if($serch_data['to_date']=='1970-01-01')
			$serch_data['to_date']='';
			
			
			if(!empty($serch_data['customer']) && $serch_data['customer']!='Select')
			{
				$this->db->where($this->table_name7.'.customer',$serch_data['customer']);
			}
			if(!empty($serch_data['ps_no']))
			{
				$this->db->where($this->table_name7.'.package_slip',$serch_data['ps_no']);
			}
			if(isset($serch_data["from_date"]) && $serch_data["from_date"]!="" && isset($serch_data["to_date"]) && $serch_data["to_date"]!="")
			{
				
			$this->db->where("DATE_FORMAT(".$this->table_name7.".ship_date,'%Y-%m-%d') >='".$serch_data["from_date"]."' AND DATE_FORMAT(".$this->table_name7.".ship_date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
			}
			elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]!="" && isset($serch_data["to_date"]) && $serch_data["to_date"]=="")
			{
			
				$this->db->where("DATE_FORMAT(".$this->table_name7.".ship_date,'%Y-%m-%d') >='".$serch_data["from_date"]."'");
			}
			elseif(isset($serch_data["from_date"]) && $serch_data["from_date"]=="" && isset($serch_data["to_date"]) && $serch_data["to_date"]!="")
			{
				
				$this->db->where("DATE_FORMAT(".$this->table_name7.".ship_date,'%Y-%m-%d') <= '".$serch_data["to_date"]."'" );
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
			$this->db->where("DATE_FORMAT(".$this->table_name7.".ship_date,'%Y-%m-%d') >='".$from."' AND DATE_FORMAT(".$this->table_name7.".ship_date,'%Y-%m-%d') <= '".$to."'" );	
		}
		$this->db->select($this->table_name7.'.*');
		$this->db->select('customer.name,store_name');
		$this->db->where($this->table_name7.'.status',1);
		$this->db->order_by($this->table_name7.'.id','desc');
		$this->db->join('customer','customer.id='.$this->table_name7.'.customer');
	 	$query = $this->db->get($this->table_name7)->result_array();
		$i=0;
		foreach($query as $val)
		{
			$this->db->select('inv_no,id as inv_id');
			$this->db->where('invoice.package_id',$val['id']);
			$query[$i]['inv_no'] = $this->db->get('invoice')->result_array();	
			$i++;
		}
		return $query;
	}
	public function get_package_by_id($id)
	{
		$this->db->select($this->table_name7.'.*');
		$this->db->select('master_state.state');
		$this->db->select('customer.name,store_name,address1,address2,city,pincode,mobil_number,email_id,c_st as st,c_cst as cst,c_vat as vat,agent_name,agent_comm,payment_terms,selling_percent,tin');
		$this->db->where($this->table_name7.'.status',1);
		$this->db->where($this->table_name7.'.id',$id);
		$this->db->join('customer','customer.id='.$this->table_name7.'.customer');
		$this->db->join('master_state','master_state.id=customer.state_id');
	 	$query1 = $this->db->get($this->table_name7)->result_array();
		return $query1;
	}
	public function get_package_by_id1($id)
	{
		$this->db->select($this->table_name7.'.*');
		$this->db->select('customer.name,store_name');
		$this->db->where($this->table_name7.'.status',1);
		$this->db->where($this->table_name7.'.status',1);
		$this->db->where($this->table_name7.'.id',$id);
		$this->db->join('customer','customer.id='.$this->table_name7.'.customer');
	 	$query1 = $this->db->get($this->table_name7)->result_array();
		$s_order=explode('-',$query1[0]['sales_order_list']);
		$this->db->select($this->table_name1.'.customer');
		$this->db->select('customer.name');
		$this->db->select('master_state.state');
		$this->db->select('master_style.style_name,master_style.id as style_id,mrp');
		$this->db->where($this->table_name1.'.status',1);
		$this->db->where($this->table_name1.'.df',0);
		$this->db->where_in($this->table_name1.'.id',$s_order);
		$this->db->where($this->table_name1.'.customer',$query1[0]['customer']);
		$this->db->group_by('sales_order_details.style_id');
		$this->db->join('customer','customer.id='.$this->table_name1.'.customer');
		$this->db->join('master_state','master_state.id='.$this->table_name1.'.state');
		$this->db->join('sales_order_details','sales_order_details.gen_id='.$this->table_name1.'.id');
		$this->db->join('master_style','master_style.id=sales_order_details.style_id');
	 	$query = $this->db->get($this->table_name1)->result_array();
	
		$i=0;
		foreach($query as $val)
		{
			$this->db->select('sales_order_details.color_id');
			$this->db->select('master_colour.colour');
			$this->db->where($this->table_name2.'.style_id',$val['style_id']);
			$this->db->group_by($this->table_name2.'.color_id');
			$this->db->where_in($this->table_name1.'.id',$s_order);
			$this->db->join('sales_order_details','sales_order_details.gen_id='.$this->table_name1.'.id');
			$this->db->join('master_colour','master_colour.id='.$this->table_name2.'.color_id');
			$query[$i]['style_color'] = $this->db->get($this->table_name1)->result_array();
			$query[$i]['sales_order'] = $s_order;
			$j=0;
			foreach($query[$i]['style_color'] as $val1)
			{
				$this->db->select('sales_order_details.size_id,c_mrp,SUM(qty) as total_qty');
				$this->db->select('master_size.size');
				$this->db->where($this->table_name2.'.style_id',$val['style_id']);
				$this->db->where($this->table_name2.'.color_id',$val1['color_id']);
				$this->db->group_by($this->table_name2.'.size_id');
				$this->db->where_in($this->table_name1.'.id',$s_order);
				$this->db->join('sales_order_details','sales_order_details.gen_id='.$this->table_name1.'.id');
				$this->db->join('master_size','master_size.id='.$this->table_name2.'.size_id');
				$query[$i]['style_color'][$j]['size'] = $this->db->get($this->table_name1)->result_array();
				
				$j++;
			}	
			$i++;
		}
		return $query;
		
	}
	public function get_package_details($id)
	{
		$this->db->select('package_details.*');
		$this->db->select('customer.name,store_name');
		$this->db->select('master_style.style_name');
		$this->db->where($this->table_name7.'.status',1);
		$this->db->where($this->table_name7.'.id',$id);
		$this->db->group_by('package_details.style_id');
		//$this->db->group_by('package_details.color_id');
		//$this->db->group_by('package_details.corton_no');
		$this->db->join('customer','customer.id='.$this->table_name7.'.customer');
		$this->db->join('package_details','package_details.package_id='.$this->table_name7.'.id');
		$this->db->join('master_style','master_style.id=package_details.style_id');
	 	$query1 = $this->db->get($this->table_name7)->result_array();
		
		/*$s_order=explode('-',$query1[0]['sales_order_list']);
		$this->db->select($this->table_name1.'.customer');
		$this->db->select('customer.name');
		$this->db->select('master_state.state');
		$this->db->select('master_style.style_name,master_style.id as style_id,mrp');
		$this->db->where($this->table_name1.'.status',1);
		$this->db->where($this->table_name1.'.df',0);
		$this->db->where_in($this->table_name1.'.id',$s_order);
		$this->db->where($this->table_name1.'.customer',$query1[0]['customer']);
		$this->db->group_by('sales_order_details.style_id');
		$this->db->join('customer','customer.id='.$this->table_name1.'.customer');
		$this->db->join('master_state','master_state.id='.$this->table_name1.'.state');
		$this->db->join('sales_order_details','sales_order_details.gen_id='.$this->table_name1.'.id');
		$this->db->join('master_style','master_style.id=sales_order_details.style_id');
	 	$query = $this->db->get($this->table_name1)->result_array();*/
		$i=0;
		foreach($query1 as $val)
		{
			$this->db->select('package_details.color_id,corton_no');
			$this->db->select('master_colour.colour');
			$this->db->where($this->table_name8.'.package_id',$val['package_id']);
			$this->db->where($this->table_name8.'.style_id',$val['style_id']);
			$this->db->group_by($this->table_name8.'.color_id');
			$this->db->group_by($this->table_name8.'.corton_no');
			$this->db->join('master_colour','master_colour.id='.$this->table_name8.'.color_id');
			$query1[$i]['style_color'] = $this->db->get($this->table_name8)->result_array();
			$j=0;
			foreach($query1[$i]['style_color'] as $val1)
			{
				$this->db->select($this->table_name8.'.size as size_id');
				$this->db->select($this->table_name8.'.qty');
				$this->db->select('master_size.size');
				
				$this->db->where($this->table_name8.'.package_id',$val['package_id']);
				$this->db->where($this->table_name8.'.style_id',$val['style_id']);
				$this->db->where($this->table_name8.'.color_id',$val1['color_id']);
				$this->db->where($this->table_name8.'.corton_no',$val1['corton_no']);
				$this->db->order_by($this->table_name8.'.size','asc');
				$this->db->join('master_size','master_size.id='.$this->table_name8.'.size');
				$query1[$i]['style_color'][$j]['size'] = $this->db->get($this->table_name8)->result_array();
				$j++;
			}	
			$i++;
		}
		return $query1;
	}
	public function get_corton_no($p_id,$s_id,$c_id)
	{
		$this->db->select('corton_no');
		$this->db->where($this->table_name8.'.status',1);
		$this->db->where($this->table_name8.'.package_id',$p_id);
		$this->db->where($this->table_name8.'.style_id',$s_id);
		$this->db->where($this->table_name8.'.color_id',$c_id);
	 	$query = $this->db->get($this->table_name8)->result_array();
		return $query;
	}
	public function get_all_ps_no($po)
	{
		$this->db->select('package_slip');
		$this->db->like('package_slip',$po['q']);
		$this->db->order_by('id','desc');
	 	$query = $this->db->get($this->table_name7)->result_array();
		return $query;  
	}
	public function get_all_inv_no($po)
	{
		$this->db->select('inv_no');
		$this->db->like('inv_no',$po['q']);
		$this->db->order_by('id','desc');
	 	$query = $this->db->get('invoice')->result_array();
		return $query;  
	}
	public function get_sales_order_by_p_id($p_id)
	{
		$this->db->select('sales_order_list');
		$this->db->where('id',$p_id);
	 	$query = $this->db->get($this->table_name7)->result_array();
		return $query;  
	}
	public function get_pending_sales_order($c_id)
	{
		$this->db->select($this->table_name1.'.grn_no,id');
		$this->db->where($this->table_name1.'.package_status',0);
		$this->db->where($this->table_name1.'.customer',$c_id);
	 	$query = $this->db->get($this->table_name1)->result_array();
		///echo "<pre>";
	//print_r(count($query));
		/*$i=0;
		foreach($query as $val)
		{
			$this->db->select('style_id,c_mrp,gen_id,color_id');
			$this->db->group_by($this->table_name2.'.style_id');
			$this->db->group_by($this->table_name2.'.color_id');
			$this->db->group_by($this->table_name2.'.c_mrp');
			$this->db->where($this->table_name2.'.gen_id',$val['id']);
			$style_mrp= $this->db->get($this->table_name2)->result_array();
			//print_r($query[$i]['style_mrp']);
			
			foreach($query as $val1)
			{
				
					$this->db->select('style_id,c_mrp,gen_id,color_id');
					$this->db->group_by($this->table_name2.'.style_id');
					$this->db->group_by($this->table_name2.'.color_id');
					$this->db->group_by($this->table_name2.'.c_mrp');
					$this->db->where($this->table_name2.'.gen_id',$val1['id']);
					$st_mrp = $this->db->get($this->table_name2)->result_array();	
					foreach($style_mrp as $check)
					{
						//print_r($check);
						//echo "++++++++++++++++++++++++";
						foreach($st_mrp as $check1)
						{
							//print_r($check1);
							if($check['style_id']==$check1['style_id'] &&  $check['c_mrp']!=$check1['c_mrp'])
							{
								
								//print_r($check['gen_id'].'<br>');
							//	print_r($check1['gen_id'].'<br>----');
								if(count($query)!=1)
								unset($query[$i]);
								
							}
						}
						//echo "--------------------------";
					}
				
			}
			$i++;	
		}*/
		return $query;
	}
	public function get_check_solor_mrp($so_id)
	{
		$i=0;
		foreach($so_id as $val)
		{
			$this->db->select('style_id,c_mrp,gen_id,color_id');
			$this->db->group_by($this->table_name2.'.style_id');
			$this->db->group_by($this->table_name2.'.color_id');
			$this->db->group_by($this->table_name2.'.c_mrp');
			$this->db->where($this->table_name2.'.gen_id',$val);
			$style_mrp= $this->db->get($this->table_name2)->result_array();
			//print_r($query[$i]['style_mrp']);
			
			foreach($so_id as $val1)
			{
				
					$this->db->select('style_id,c_mrp,gen_id,color_id');
					$this->db->group_by($this->table_name2.'.style_id');
					$this->db->group_by($this->table_name2.'.color_id');
					$this->db->group_by($this->table_name2.'.c_mrp');
					$this->db->where($this->table_name2.'.gen_id',$val1);
					$st_mrp = $this->db->get($this->table_name2)->result_array();	
					foreach($style_mrp as $check)
					{
						//print_r($check);
						//echo "++++++++++++++++++++++++";
						foreach($st_mrp as $check1)
						{
							//print_r($check1);
							if($check['style_id']==$check1['style_id'] && $check['color_id']==$check1['color_id'] &&  $check['c_mrp']!=$check1['c_mrp'])
							{
								$i=1;
							}
						}
						//echo "--------------------------";
					}
				
			}
		}
		return $i;
	}
	public function updatepackage($p,$s,$mrp)
	{
		$this->db->where('package_id',$p);
		$this->db->where('style_id',$s);
		if ($this->db->update('package_details', array('p_c_mrp'=>$mrp))) {
			
			return true;
		}
		return false;
	}
	public function get_p_mrp($p,$s)
	{
		$this->db->select('p_c_mrp');
		$this->db->where('package_id',$p);
		$this->db->where('style_id',$s);
		$query = $this->db->get('package_details')->result_array();
		return $query;
	}
	public function get_all_lrno_for_expense()
	{
		$this->db->group_by('lr_no');
		$this->db->select($this->table_name7.'.lr_no,id');
	 	$query1 = $this->db->get($this->table_name7)->result_array();
		return $query1;
	}
		
}