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
class  Agent_model extends CI_Model
{
    private $table_name  = 'agent';	
	function __construct()
	{
		parent::__construct();
	}
	
	public function insert_agent($data)
	{
		if ($this->db->insert($this->table_name, $data)) 
		{
			return true;
		}
		return false;
  	}
	
 	public function state()
	{
	  $this->db->select('*');
	  $this->db->where('status',1);
	  $query = $this->db->get($this->table_name);
		if ($query->num_rows() > 0) 
		{
			return $query->result_array();
		}
		return false;
	}
	
	 public function get_agent1($id)
	  {
			$this->db->select($this->table_name.'.*');
			$this->db->where($this->table_name.'.id',$id);
			$this->db->where($this->table_name.'.status',1);
			$query = $this->db->get($this->table_name)->result_array();
			return $query;
	  } 
	  
	 public function get_agent()
	 {
			$this->db->select($this->table_name.'.*');
			$this->db->where($this->table_name.'.status',1);
			$query = $this->db->get($this->table_name)->result_array();
			return $query;
	  } 
	  
	 public function update_agent($data,$id)
	   {
		  
			$this->db->where('id', $id);
			if ($this->db->update($this->table_name, $data)) 
			{
				return true;
			}
			return false;
	   }
	  
	 public function delete_agent($id)
	   {
		   $this->db->where('id', $id);
		   if ($this->db->update($this->table_name,$data=array('status'=>0)))
			{
			  return true;
			}
		   return false;
	   }	
	   	
	public function add_duplicate_email($input)
		{
			  $this->db->select('*');
			  $this->db->where('status',1);
			  $this->db->where('email_id',$input);
			  $query=$this->db->get('agent');
			  if ($query->num_rows() >= 1) 
			  {
			   return $query->result_array();
			  }
		} 
		
	public	function update_duplicate_email($input,$id)
		  {
			 $this->db->select('*');
			 $this->db->where('status',1);
			 $this->db->where('email_id',$input);
			 $this->db->where('id !=',$id);
			 $query=$this->db->get('agent')->result_array();
			 return $query;
		  }  
}