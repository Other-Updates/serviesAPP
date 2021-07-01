<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * master_model
 *
 * This model represents admin access. It operates the following tables:
 * admin,
 *
 * @package	i2_soft
 * @author	Elavarasan
 */
 
class Master_colour_model extends CI_Model{

   
     private $table_name	= 'erp_brand';	
	 private $table_name1	= 'increment_table';
	function __construct()
	{
		parent::__construct();

	}
	
	 function insert_colour($data){
		if ($this->db->insert($this->table_name, $data)) {
			return true;
		}
		return false;
  }
	
	function get_colour()
	{
		$this->db->select('*');
		$this->db->where('status',1);
	 	$query = $this->db->get($this->table_name)->result_array();
		return $query;
     }
  function update_colour($data,$id){
	  $this->db->where('id', $id);
	   if ($this->db->update($this->table_name, $data)) {
		return true;
	   }
	   return false;
  }
function delete_master_colour($id)
 {
  $this->db->where('id', $id);
   if ($this->db->update($this->table_name,$data=array('status'=>0))) {
    return true;
   }
   return false;
 }		
function add_duplicate_colorname($input)
 {
 $this->db->select('*');
 $this->db->where('colour',$input);
 $this->db->where('status',1);
 $query=$this->db->get('master_colour');

  if ($query->num_rows() >= 1) {
   return $query->result_array();
  }
 }		
function update_duplicate_colourname($input,$id)
 {
 //echo $input;
 //echo $id;
 //exit;
 $this->db->select('*');
 $this->db->where('colour',$input);
 $this->db->where('id !=',$id);
 $this->db->where('status',1);
 $query=$this->db->get('master_colour')->result_array();
  
  
   return $query;
  }
   function get_clr($id)
  {
	 $this->db->select('*');
	 $this->db->where('id',$id);
	 $query=$this->db->get('master_colour')->result_array();
	 return $query;
  }	
}