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
 
class Master_fit_model extends CI_Model{

   
     private $table_name	= 'master_user_role';	
	  private $table_name1	= 'expense';	
	 function __construct()
	{
		parent::__construct();

	}
	
	
	function insert_master_fit($data)
	{
            $this->db->insert($this->table_name, $data);
	}
	
	
	function insert_master_expense($data)
	{
		$this->db->insert($this->table_name1, $data);
	}
	
	
	public function get_all_fit()
	{
		$this->db->select('*');
		$this->db->where('status',1);
		$query = $this->db->get($this->table_name);
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	
	public function get_all_expense_fixed()
	{
		$this->db->select('*');
		$this->db->where('status',1);
		$this->db->where('expense_type','fixed');
		$query = $this->db->get($this->table_name1);
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
	}
	
	
	
	public function get_all_expense_variable()
	{
		$this->db->select('*');
		$this->db->where('status',1);
		$this->db->where('expense_type','variable');
		$query = $this->db->get($this->table_name1);
		if ($query->num_rows() >= 1) {
			return $query->result_array();
		}
		return false;
		
	}
	
	public function update_fit($data,$id)
	{
   $this->db->where('id', $id);
    if ($this->db->update($this->table_name, $data)) {
  return true;
    }
    return false;
  }
  
  public function update_expense_one($data,$id)
	{
   $this->db->where('id', $id);
    if ($this->db->update($this->table_name1, $data)) {
  return true;
    }
    return false;
  }
	
	function delete_master_fit($id)
	{
		//print_r($id);exit;
		$this->db->where('id', $id);
			if ($this->db->update($this->table_name,$data=array('status'=>0))) {
				return true;
			}
			return false;
	}
	
	function delete_master_expense($id)
	{
		//print_r($id);exit;
		$this->db->where('id', $id);
			if ($this->db->update($this->table_name1,$data=array('status'=>0))) {
				return true;
			}
			return false;
	}
	
	
	function add_duplicate_fit($input)
    {
 
		  $this->db->select('*');
		  $this->db->where('master_fit',$input);
		  $this->db->where('status',1);
		  $query=$this->db->get('master_fit');
		   
		  if ($query->num_rows() >= 1) 
		  {
		   return $query->result_array();
	      }
	}
 
   function update_duplicate_fit($input,$id)
   {
		 $this->db->select('*');
		 $this->db->where('master_fit',$input);
		 $this->db->where('id !=',$id);
		  $this->db->where('status',1);
		 $query=$this->db->get('master_fit')->result_array();
         return $query;
   }  
   function add_duplicate_expense_fixed($input)
    {
 			
		  $this->db->select('*');
		  $this->db->where('expense',$input['expense']);
		  $this->db->where('expense_type',$input['c_id']);
		  $this->db->where('status',1);
		  $query=$this->db->get('expense');
		   
		  if ($query->num_rows() >= 1) 
		  {
		   return $query->result_array();
	      }
	}
	 function add_duplicate_expense_variable($input)
    {
 			
		  $this->db->select('*');
		  $this->db->where('expense',$input['expense']);
		  $this->db->where('expense_type',$input['c_id']);
		  $this->db->where('status',1);
		  $query=$this->db->get('expense');
		   
		  if ($query->num_rows() >= 1) 
		  {
		   return $query->result_array();
	      }
	}
  function update_duplicate_expense_fixed($input,$id,$exp_type)
   {
		 $this->db->select('*');
		 $this->db->where('expense',$input);
		 $this->db->where('expense_type',$exp_type);
		 $this->db->where('id !=',$id);
		  $this->db->where('status',1);
		 $query=$this->db->get('expense')->result_array();
         return $query;
   }  
   function update_duplicate_expense_varaible($input,$id,$exp_type)
   {
		 $this->db->select('*');
		 $this->db->where('expense',$input);
		 $this->db->where('expense_type',$exp_type);
		 $this->db->where('id !=',$id);
		  $this->db->where('status',1);
		 $query=$this->db->get('expense')->result_array();
         return $query;
   }  
}