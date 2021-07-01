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
 
class Buying_model extends CI_Model{

   
    private $table_name1	= 'buying';	
	function __construct()
	{
		parent::__construct();

	}
	public function insert_buying($data)
	{
		if ($this->db->insert($this->table_name1, $data)) {
			$insert_id = $this->db->insert_id();
			
			return $insert_id;
		}
		return false;
	}
	public function get_all_buying_details($data)
	{
		$this->db->select($this->table_name1.'.*');
		$this->db->select('master_season.season');
		$this->db->select('master_style.style_name');
		$this->db->select('master_colour.colour');
		$this->db->select('master_fit.master_fit');
		$this->db->where($this->table_name1.'.status',1);
		$this->db->where($data);
		$this->db->group_by($this->table_name1.'.style_id');
		$this->db->group_by($this->table_name1.'.color_id');
		$this->db->join('master_season','master_season.id='.$this->table_name1.'.season_id');
		$this->db->join('master_style','master_style.id='.$this->table_name1.'.style_id');
		$this->db->join('master_colour','master_colour.id='.$this->table_name1.'.color_id');
		$this->db->join('master_fit','master_fit.id='.$this->table_name1.'.fit_id');
		$query = $this->db->get($this->table_name1);
		if ($query->num_rows() >= 0) {
			return $query->result_array();
		}
		return false;
	}
}