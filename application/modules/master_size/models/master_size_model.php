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
 
class Master_size_model extends CI_Model{

   
     private $table_name	= 'master_size';	
	 function __construct()
	{
		parent::__construct();

	}
	
	
	function insert_master_size($data)
	{
		$this->db->insert($this->table_name, $data);
	}
	
	
	public function get_all_size()
	{
		$this->db->select('*');
		$this->db->where('status',1);
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	
	public function update_size($data,$id)
	{
   $this->db->where('id', $id);
    if ($this->db->update($this->table_name, $data)) {
  return true;
    }
    return false;
  }
	
	function delete_master_size($id)
	{
		//print_r($id);exit;
		$this->db->where('id', $id);
			if ($this->db->update($this->table_name,$data=array('status'=>0))) {
				return true;
			}
			return false;
	}
	function checking_master_size($size)
	{
		$this->db->select('*');
		$this->db->where('size',$size);
		$this->db->where('status',1);
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	
	}
	 function update_duplicate_size($input,$id)
 {
 //echo $input;
 //echo $id;
 //exit;
 $this->db->select('*');
 $this->db->where('size',$input);
 $this->db->where('id !=',$id);
 $this->db->where('status',1);
 $query=$this->db->get('master_size')->result_array();
  
  
   return $query;
  }
	
}