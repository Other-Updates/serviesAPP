<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * master_model
 *
 * This model represents admin access. It operates the following tables:
 * admin,
 *
 * @package	i2_soft
 * @author	Elavarasan
 */
class Master_model extends CI_Model {

    private $table_name = 'master_style';
    private $table_name1 = 'increment_table';
    private $table_name2 = 'master_style_size';
    private $table_name3 = 'master_style_color';
    private $table_name4 = 'master_style_mrp';
    private $increment_table = 'increment';
    private $prefix_list = array(
        'emp_code' => 'EMP',
    );

    function __construct() {
        parent::__construct();
    }

    function insert_style($data) {
        if ($this->db->insert($this->table_name, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return false;
    }

    function insert_style_details($data) {
        if ($this->db->insert_batch($this->table_name2, $data)) {
            $insert_id = $this->db->insert_id();

            return true;
        }
        return false;
    }

    function insert_style_color_details($data) {
        if ($this->db->insert_batch($this->table_name3, $data)) {
            $insert_id = $this->db->insert_id();

            return true;
        }
        return false;
    }

    function insert_style_mrp_details($data) {
        if ($this->db->insert_batch($this->table_name4, $data)) {
            return true;
        }
        return false;
    }

    function get_style() {
        $this->db->select($this->table_name . '.*');
        $this->db->select('master_fit.master_fit');
        $this->db->select('master_style_type.style_type,master_style_type.id as style_type_id');
        $this->db->where($this->table_name . '.status', 1);
        $this->db->order_by($this->table_name . '.id', 'desc');
        $this->db->join('master_style_type', 'master_style_type.id=' . $this->table_name . '.style_type');
        $this->db->join('master_fit', 'master_fit.id=' . $this->table_name . '.fit');
        $query = $this->db->get($this->table_name)->result_array();

        $this->db->select('customer.id,store_name,name');
        $customer = $this->db->get('customer')->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select($this->table_name2 . '.*');
            $this->db->select('master_size.size');
            $this->db->where($this->table_name2 . '.style_id', $val['id']);
            $this->db->join('master_size', 'master_size.id=' . $this->table_name2 . '.size_id');
            $query[$i]['style_size'] = $this->db->get($this->table_name2)->result_array();

            $this->db->select($this->table_name3 . '.*');
            $this->db->select('master_colour.colour');
            $this->db->where($this->table_name3 . '.style_id', $val['id']);
            $this->db->join('master_colour', 'master_colour.id=' . $this->table_name3 . '.color_id');
            $query[$i]['style_color'] = $this->db->get($this->table_name3)->result_array();
            foreach ($customer as $cus) {
                $this->db->select($this->table_name4 . '.mrp');
                $this->db->where($this->table_name4 . '.style_id', $val['id']);
                $this->db->where($this->table_name4 . '.customer_id', $cus['id']);
                $query[$i]['style_mrp'][$cus['id']] = $this->db->get($this->table_name4)->result_array();
                $query[$i]['style_mrp'][$cus['id']]['customer_name'] = $cus['store_name'];
            }
            $i++;
        }
        return $query;
    }

    function get_all_lot_style() {
        $this->db->select($this->table_name . '.*');
        $this->db->group_by($this->table_name . '.style_name');
        $this->db->where($this->table_name . '.status', 1);
        $query = $this->db->get($this->table_name)->result_array();
        return $query;
    }

    function update_style($data, $id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data)) {
            return true;
        }
        return false;
    }

    function update_style_detail($data) {
        if ($this->db->update($this->table_name2, $data)) {
            $update_id = $this->db->update_id();

            return true;
        }
        return false;
    }

    function update_last_id($id) {
        $data = array('value' => $id);
        $this->db->where('type', 'lot_code');
        if ($this->db->update($this->table_name1, $data)) {
            return true;
        }
        return false;
    }

    function update_last_id1($value, $type) {
        $data = array('value' => $value);
        $this->db->where('type', $type);
        if ($this->db->update($this->table_name1, $data)) {
            return true;
        }
        return false;
    }

    function delete_master_style($id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data = array('status' => 0))) {
            return true;
        }
        return false;
    }

    function delete_all_size($style_id) {
        $this->db->where('style_id', $style_id);
        if ($this->db->delete($this->table_name2)) {
            return true;
        }
        return false;
    }

    function delete_all_color($style_id) {
        $this->db->where('style_id', $style_id);
        if ($this->db->delete($this->table_name3)) {
            return true;
        }
        return false;
    }

    function delete_all_mrp($style_id) {
        $this->db->where('style_id', $style_id);
        if ($this->db->delete($this->table_name4)) {
            return true;
        }
        return false;
    }

    function add_duplicate_stylename($input) {
        //print_r($input); exit;
        $this->db->select('*');
        $this->db->where('style_name', $input);
        $this->db->where('status', 1);
        $query = $this->db->get('master_style');

        if ($query->num_rows() >= 1) {
            return $query->result_array();
        }
    }

    function update_duplicate_stylename($input, $id) {
        //echo $input;
        //echo $id;
        //exit;
        $this->db->select('*');
        $this->db->where('style_name', $input);
        $this->db->where('id !=', $id);
        $this->db->where('status', 1);
        $query = $this->db->get('master_style')->result_array();


        return $query;
    }

    function get_last_id($type) {
        $this->db->select('*');
        $this->db->where('type', $type);
        $query = $this->db->get('increment_table')->result_array();
        return $query;
    }

    function check_lot_no($style_name) {
        $this->db->select('*');
        $this->db->where('style_name', $style_name);
        $query = $this->db->get('master_style')->num_rows();
        return $query;
    }

    function get_landed_cost($id) {
        $this->db->select('*');
        $this->db->where('id', $id);
        $query = $this->db->get('master_style')->result_array();
        return $query;
    }

    function get_landed_cost1($id) {
        $this->db->select('landed');
        $this->db->where('gen_id', $id);
        $this->db->group_by('landed');
        $query = $this->db->get('po_details')->result_array();
        return $query;
    }

    function get_style_name($name) {
        $this->db->select('id');
        $this->db->where('style_name', $name);
        $this->db->where('status', 1);
        $query = $this->db->get('master_style')->result_array();
        return $query;
    }

    function get_color_name($name) {
        $this->db->select('id');
        $this->db->where('colour', $name);
        $this->db->where('status', 1);
        $query = $this->db->get('master_colour')->result_array();
        return $query;
    }

    function get_ids_with_all($where) {
        $this->db->select('id');
        $this->db->where($where);
        $this->db->where('status', 1);
        $query = $this->db->get('po_details')->result_array();
        return $query;
    }

    function get_increment_details($type) {

        $this->db->where('type', $type);
        $query = $this->db->get($this->increment_table);
        if ($query->num_rows() == 0) {
            $this->insert_increment_code($type);
            $result = $this->get_new_increment_code($type);
        } else {
            $result = $query->result_array();
        }
        $entry_number = '';
        $inc_data['increment_id'] = str_pad($result['0']['last_increment_id'], 4, '0', STR_PAD_LEFT);
        $inc_data['increment_code'] = $result['0']['code'];
        return $inc_data;
    }

    function update_increment_code($type) {
        $last_id = $this->get_last_increment_code_id($type);
        $data = array();
        $data['last_increment_id'] = $last_id + 1;
        $this->db->where('type', $type);
        if ($this->db->update($this->increment_table, $data)) {
            return true;
        }

        return false;
    }

    function get_last_increment_code_id($type) {
        $this->db->where('type', $type);
        $query = $this->db->get($this->increment_table);
        if ($query->num_rows() > 0) {
            $result = $query->result_array();
            return $result['0']['last_increment_id'];
        }
        return FALSE;
    }

    function insert_increment_code($type) {
        $data = array();
        $data['type'] = $type;
        $data['code'] = $this->prefix_list[$type];
        $data['last_increment_id'] = 1;
        $this->db->where('type', $type);
        if ($this->db->insert($this->increment_table, $data)) {
            return true;
        }
        return false;
    }

    function get_new_increment_code($type) {
        $this->db->where('type', $type);
        $query = $this->db->get($this->increment_table);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

}
