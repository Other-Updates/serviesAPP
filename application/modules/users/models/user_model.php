<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    private $table_name = 'erp_user';
    private $master_user_role = 'master_user_role';
    private $increment_table = 'increment_table';

    function __construct() {
        parent::__construct();
    }

    public function insert_user($data) {
        if ($this->db->insert($this->table_name, $data)) {
            return true;
        }
        return false;
    }

    public function state() {
        $this->db->select('*');
        $this->db->where('status', 1);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
    }

    public function get_user1($id) {
        $this->db->select($this->table_name . '.*');
        $this->db->where($this->table_name . '.id', $id);
        $this->db->where($this->table_name . '.status', 1);
        $query = $this->db->get($this->table_name)->result_array();
        return $query;
    }

    public function get_users() {
        $this->db->select($this->table_name . '.id');
        $this->db->where($this->table_name . '.status', 1);
        $query = $this->db->get($this->table_name)->result_array();
        return $query;
    }

    public function update_user($data, $id) {

        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data)) {
            return true;
        }
        return false;
    }

    public function delete_user($id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data = array('status' => 0))) {
            return true;
        }
        return false;
    }

    public function add_duplicate_email($input) {
        $this->db->select('*');
        $this->db->where('status', 1);
        $this->db->where('email_id', $input);
        $query = $this->db->get('erp_user');
        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    public function update_duplicate_email($input, $id) {
        $this->db->select('*');
        $this->db->where('status', 1);
        $this->db->where('email_id', $input);
        $this->db->where('id !=', $id);
        $query = $this->db->get('erp_user')->result_array();
        return $query;
    }

    public function get_user_role() {
        $this->db->select('*');
        $this->db->where('status', 1);
        $query = $this->db->get('master_user_role')->result_array();
        return $query;
    }

    public function update_increment($id) {
        $this->db->where($this->increment_table . '.id', 14);
        if ($this->db->update($this->increment_table, $id)) {
            return true;
        }
        return false;
    }

}
