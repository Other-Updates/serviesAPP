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
 
class Item_code_model extends CI_Model{

   
     private $table_name	= 'item_code';	
	   private $table_name1	= 'master_style';	
	   private $table_name2	= 'master_style_color';	
	 function __construct()
	{
		parent::__construct();

	}
	
	
	function insert_item_code($data)
	{
		$this->db->insert($this->table_name, $data);
	}
	
	
	public function get_all_item()
	{
		$this->db->select('*');
		$this->db->where('status',1);
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	public function get_all_item1()
	{
		$this->db->select($this->table_name.'.id,item_code,fabric_type,pattern');
		$this->db->where($this->table_name.'.status',1);
		$this->db->select('master_fit.id as fit_id,master_fit.master_fit');
		$this->db->select('master_colour.id as color_id,master_colour.colour');
		$this->db->select('master_style.id as style_id,master_style.style_name,style_image');
		$this->db->join('master_fit','master_fit.id='.$this->table_name.'.fit');
		$this->db->join('master_style','master_style.id='.$this->table_name.'.style_no');
		$this->db->join('master_colour','master_colour.id='.$this->table_name.'.color_id');
		$query = $this->db->get($this->table_name)->result_array();
		$i=0;
		foreach($query as $val)
		{
			$this->db->select($this->table_name2.'.*');
			$this->db->select('master_colour.colour');
			$this->db->where($this->table_name2.'.style_id',$val['style_id']);
			$this->db->join('master_colour','master_colour.id='.$this->table_name2.'.color_id');
			$query[$i]['style_color'] = $this->db->get($this->table_name2)->result_array();
			$i++;
		}
		return $query;
	}
	public function get_color_by_style_id($s_id)
	{	
		$this->db->select($this->table_name2.'.*');
		$this->db->select('master_colour.colour');
		$this->db->where($this->table_name2.'.style_id',$s_id);
		$this->db->join('master_colour','master_colour.id='.$this->table_name2.'.color_id');
		$query = $this->db->get($this->table_name2)->result_array();
		return $query;
	}
	public function update_item($data,$id)
	{
   $this->db->where('id', $id);
    if ($this->db->update($this->table_name, $data)) {
  return true;
    }
    return false;
  }
	
	function delete_item_code1($id)
	{
	
		
		
		$this->db->where('id', $id);
			if ($this->db->update($this->table_name,$data=array('status'=>0))) {
				return true;
			}
			return false;
	}
function add_duplicate_code($input)
 {
 $this->db->select('*');
 $this->db->where('item_code',$input);
  $this->db->where('status',1);
 $query=$this->db->get('item_code');

  
  if ($query->num_rows() >= 1) {
   return $query->result_array();
  }
 }
 function update_duplicate_code($input,$id)
 {
 $this->db->select('*');
 $this->db->where('item_code',$input);
 $this->db->where('id !=',$id);
 $this->db->where('status',1);
 $query=$this->db->get('item_code')->result_array();
  
  
   return $query;
  }	
  	public function get_image_by_style_id($id)
	{
		$this->db->select('style_image');
		$this->db->where('id',$id);
		$query = $this->db->get($this->table_name1);
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
}