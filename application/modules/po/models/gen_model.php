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

    private $table_name1	= 'po';
	private $table_name2	= 'po_details';
    private $table_name3	= 'customer';
	 private $table_name4	= 'master_style';
	  private $table_name5	= 'master_style_size';
	   private $table_name6	= 'vendor';
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
	public function get_all_style_details_by_id($style_name)
	{
		$this->db->select('style_name,mrp,lot_no,id as style_id');
		$this->db->where('df',0);
		$this->db->where('status',1);
		$this->db->where('style_name',$style_name);
		$query = $this->db->get($this->table_name4);
		if ($query->num_rows() >= 0) {
			return $query->result_array();
		}
		return false;
	}
	public function get_location($where)
	{
		$this->db->select('location');
		$this->db->where($where);
	 	$query = $this->db->get('stock_info')->result_array();
		return $query; 
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
	//public function get_all_style_details_by_id($id)
//	{
//		$this->db->select('style_name,mrp');
//		$this->db->where('df',0);
//		$this->db->where('status',1);
//		$this->db->where('id',$id);
//		$query = $this->db->get($this->table_name4);
//		if ($query->num_rows() >= 0) {
//			return $query->result_array();
//		}
//		return false;
//	}
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
			if(!empty($serch_data['supplier']) && $serch_data['supplier']!='Select')
			{
				$this->db->where($this->table_name1.'.customer',$serch_data['supplier']);
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
			elseif(isset($serch_data["style"]) && $serch_data["style"]!="Select")
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
		$this->db->select($this->table_name1.'.*');
		$this->db->select('vendor.name,store_name');
		$this->db->select('master_style.style_name');
		$this->db->select('master_state.state');
		$this->db->where($this->table_name1.'.status',1);
		$this->db->where($this->table_name1.'.df',0);
		$this->db->order_by($this->table_name1.'.id','desc');
		$this->db->group_by('po_details.gen_id');
		$this->db->join('po_details','po_details.gen_id='.$this->table_name1.'.id');
		$this->db->join('master_style','master_style.id=po_details.style_id');
		$this->db->join('vendor','vendor.id='.$this->table_name1.'.customer');
		$this->db->join('master_state','master_state.id='.$this->table_name1.'.state');
	 	$query = $this->db->get($this->table_name1)->result_array();
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
				
			$query[$i]['cancel_status']=$cancel_status;
			$i++;
		}
		return $query;
	}
	public function get_gen_by_id($id)
	{
		$this->db->select($this->table_name1.'.*,'.$this->table_name1.'.id as po_id');
		$this->db->select('vendor.name,store_name,address1,address2,city,pincode,mobil_number,email_id,tin');
		$this->db->select('master_state.state');
		$this->db->where($this->table_name1.'.status',1);
		$this->db->where($this->table_name1.'.df',0);
		$this->db->where($this->table_name1.'.id',$id);
		$this->db->join('vendor','vendor.id='.$this->table_name1.'.customer');
		$this->db->join('master_state','master_state.id='.$this->table_name1.'.state');
	 	$query = $this->db->get($this->table_name1)->result_array();
		$i=0;
		foreach($query as $val)
		{
			$this->db->select($this->table_name2.'.style_id,color_id,lot_no,landed');
			$this->db->select('master_style.style_name,mrp,sp,style_desc');
			$this->db->select('master_colour.colour');
			$this->db->where($this->table_name2.'.gen_id',$val['id']);
			$this->db->group_by($this->table_name2.'.style_id');
			$this->db->group_by($this->table_name2.'.color_id');
			$this->db->join('master_style','master_style.id='.$this->table_name2.'.style_id');
			$this->db->join('master_colour','master_colour.id='.$this->table_name2.'.color_id');
			$query[$i]['style_size'] = $this->db->get($this->table_name2)->result_array();
			$j=0;
			foreach($query[$i]['style_size'] as $val1)
			{
				$this->db->select($this->table_name2.'.size_id,qty');
				$this->db->select($this->table_name2.'.id');
				$this->db->select('master_size.size');
				$this->db->where($this->table_name2.'.gen_id',$val['id']);
				$this->db->where($this->table_name2.'.style_id',$val1['style_id']);
				$this->db->where($this->table_name2.'.color_id',$val1['color_id']);
				$this->db->order_by($this->table_name2.'.size_id','asc');
				$this->db->join('master_size','master_size.id='.$this->table_name2.'.size_id');
				$query[$i]['style_size'][$j]['list'] = $this->db->get($this->table_name2)->result_array();
				$j++;
			}
			
			
			$i++;
		}
		return $query;
	}
	public function get_gen_by_id_po($id)
	{
		$this->db->select($this->table_name1.'.*');
		$this->db->select('vendor.name,store_name');
		$this->db->select('master_state.state');
		$this->db->where($this->table_name1.'.status',1);
		$this->db->where($this->table_name1.'.df',0);
		$this->db->where($this->table_name1.'.grn_no',$id);
		$this->db->join('vendor','vendor.id='.$this->table_name1.'.customer');
		$this->db->join('master_state','master_state.id='.$this->table_name1.'.state');
	 	$query = $this->db->get($this->table_name1)->result_array();
		$i=0;
		foreach($query as $val)
		{
			$this->db->select($this->table_name2.'.style_id,color_id,lot_no,landed');
			$this->db->select('master_style.style_name,mrp,sp');
			$this->db->select('master_colour.colour');
			$this->db->where($this->table_name2.'.gen_id',$val['id']);
			$this->db->group_by($this->table_name2.'.style_id');
			$this->db->group_by($this->table_name2.'.color_id');
			$this->db->join('master_style','master_style.id='.$this->table_name2.'.style_id');
			$this->db->join('master_colour','master_colour.id='.$this->table_name2.'.color_id');
			$query[$i]['style_size'] = $this->db->get($this->table_name2)->result_array();
			$j=0;
			foreach($query[$i]['style_size'] as $val1)
			{
				$this->db->select($this->table_name2.'.size_id,qty');
				$this->db->select($this->table_name2.'.id');
				$this->db->select('master_size.size');
				$this->db->where($this->table_name2.'.gen_id',$val['id']);
				$this->db->where($this->table_name2.'.style_id',$val1['style_id']);
				$this->db->where($this->table_name2.'.color_id',$val1['color_id']);
				$this->db->order_by($this->table_name2.'.size_id','asc');
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
	public function get_gen_by_po($po)
	{
		$this->db->select('gen.grn_no,gen.id as gen_id');
		$this->db->where('gen.po_no',$po);
	 	$query = $this->db->get('gen')->result_array();
		return $query; 
	}
	public function get_gen_by_po1($po,$id)
	{
		$this->db->select('gen.grn_no,gen.id as gen_id,inv_date');
		$this->db->where('gen.po_no',$po);
		$this->db->where('gen.id',$id);
	 	$query = $this->db->get('gen')->result_array();
		return $query;
	}
	public function get_size_val($where)
	{
		$this->db->select('SUM(gen_details.qty) as avail_qty');
		$this->db->where('gen.po_no',$where['po_no']);
		$this->db->where('gen_details.style_id',$where['style_id']);
		$this->db->where('gen_details.color_id',$where['color_id']);
		$this->db->where('gen_details.size_id',$where['size_id']);
		$this->db->join('gen','gen.id=gen_details.gen_id');
	 	$query = $this->db->get('gen_details')->result_array();
		return $query; 
	}
	public function get_size_val_old($where)
	{
		$this->db->select('SUM(gen_details.qty) as avail_qty');
		$this->db->where($where);
	 	$query = $this->db->get('gen_details')->result_array();
		return $query; 
	}
	public function check_po_no($po)
	{
		$this->db->select('grn_no');
		$this->db->like('grn_no',$po);
		$this->db->order_by('id','desc');
	 	$query = $this->db->get($this->table_name1)->result_array();
		return $query; 
	}
	public function get_all_po_for_expense()
	{
		$this->db->select('grn_no,id');
	 	$query = $this->db->get($this->table_name1)->result_array();
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
	public function check_po_no2($data)
	{
		$this->db->select('grn_no');
		$this->db->like('grn_no',$data['q']);
		$this->db->order_by('id','desc');
	 	$query = $this->db->get('po')->result_array();
		return $query; 
	}
	public function get_last_lot($lot_no)
	{
		$this->db->select('lot_no');
		$this->db->like('lot_no',$lot_no);
	 	$query = $this->db->get($this->table_name1);
		return $query->num_rows(); 
	}
	public function check_po_in_gen($po_no)
	{
		$this->db->select('id');
		$this->db->where('po_no',$po_no);
	 	$query = $this->db->get('gen')->result_array();
		return $query; 
	}
	public function force_to_complete_po($data)
	{
		$this->db->where('id',$data['update_id']);
	 	$query = $this->db->update('po',array('complete_remarks'=>$data['complete_remarks'],'delivery_status'=>2));
	}
	public function get_last_lot_no($lot_no,$my)
	{
		$this->db->select('lot_no');
		$this->db->like('lot_no',$lot_no);
		$this->db->group_by('style_id');
		$this->db->where('style_id',$my['s_id']);
		$this->db->where('color_id',$my['c_id']);
		$this->db->group_by('gen_id');
		$this->db->group_by('color_id');
		$this->db->order_by('po_details.id','desc');
	 	$query = $this->db->get('po_details');
		return $query->result_array(); 
	}
	public function change()
	{
		$this->db->select('*');
	 	$query = $this->db->get('po')->result_array();
		$j=0;
		foreach($query as $val)
		{
			$this->db->select('sum(qty) as po_qty,landed');
			$this->db->where($this->table_name2.'.gen_id',$val['id']);
			$this->db->group_by('gen_id');
			$po_details = $this->db->get($this->table_name2)->result_array();
			$total=0;
			foreach($po_details as $ss)
			{
				$total=$total+($ss['po_qty']*$ss['landed']);
			}
			$tax=round($total+($total*(5.5/100)),2);
			$this->db->where($this->table_name1.'.id',$val['id']);
			$this->db->update($this->table_name1,array('org_total'=>$total,'net_total'=>$tax));
			
			$this->db->where('gen.po_no',$val['grn_no']);
			$this->db->update('gen',array('total_value'=>$total));
			$j++;
		}
	}
	/*public function get_check()
	{
		$this->db->select('sum(qty) as stock_qty,lot_no');
		$this->db->where('stock_from','so');
		$this->db->group_by('lot_no');
	 	$query = $this->db->get('stock_info')->result_array();
		$j=0;
		//echo "<pre>";
		foreach($query as $val)
		{
			$this->db->select('sum(qty) as po_qty,landed,lot_no');
			$this->db->where($this->table_name2.'.lot_no',$val['lot_no']);
			$this->db->group_by('lot_no');
			$po_details = $this->db->get($this->table_name2)->result_array();
			
			$t=$t+($po_details[0]['landed']*$po_details[0]['po_qty']);
			$j++;
		}
		echo $t;
		exit;
	}*/
}