<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ref_increment_model extends CI_Model {

    private $increment_table = 'increment';

    function __construct() {
        date_default_timezone_set('Asia/Kolkata');
        parent::__construct();
    }

    function get_increment_id($type, $code) {
        $prefix = '';
        if ($type == 'GRNSERIAL') {
            $prefix = date('y') . "-" . date('m');
        } else {
            $prefix = date('y') . "/" . date('m');
        }
        $this->db->where('type', $type);
        $this->db->where('prefix', $prefix);
        $query = $this->db->get($this->increment_table);

        if ($query->num_rows() == 1) {
            $res = $query->result_array();
        } else {
            $res = $this->insert_increment_id($type, $code);
        }
        $entry_number = '';
        if ($type == 'INV') {
            $entry_number = "IS/" . $res['0']['code'] . "/" . $res['0']['prefix'] . "-" . $res['0']['last_increment_id'];
        } else if ($type == 'REC') {
            $entry_number = "IS/" . $res['0']['code'] . "/" . $res['0']['prefix'] . "-" . $res['0']['last_increment_id'];
        } else if ($type == 'PO') {
            $entry_number = 'IS' . "//" . $res['0']['prefix'] . "-" . $res['0']['last_increment_id'];
        } else if ($type == 'GRNSERIAL') {
            $entry_number = $res['0']['code'] . "-" . $res['0']['prefix'] . "-" . $res['0']['last_increment_id'];
        } elseif ($type == 'DC' || $type == 'ODC') {
            $entry_number = "IS/" . $res['0']['code'] . "/" . $res['0']['prefix'] . "-" . $res['0']['last_increment_id'];
        } else if ($type == 'DCSERIAL') {
            $entry_number = $res['0']['code'] . "/" . $res['0']['prefix'] . "-" . $res['0']['last_increment_id'];
        } else {
            $entry_number = $res['0']['code'] . "/" . $res['0']['prefix'] . "-" . $res['0']['last_increment_id'];
        }
        return $entry_number;
    }

    function insert_increment_id($type, $code) {
        $data = array();
        $data['prefix'] = '';
        if ($type == 'GRNSERIAL') {
            $data['prefix'] = date('y') . "-" . date('m');
        } else {
            $data['prefix'] = date('y') . "/" . date('m');
        }
        $data['type'] = $type;
        $data['code'] = $code;
        $data['last_increment_id'] = '001';
        if ($this->db->insert($this->increment_table, $data)) {
            $id = $this->db->insert_id();
            $this->db->where('id', $id);
            $query = $this->db->get($this->increment_table);
            return $query->result_array();
        }
        return false;
    }

    function update_increment_id($type, $code) {
        $prefix = '';
        if ($type == 'GRNSERIAL') {
            $prefix = date('y') . "-" . date('m');
        } else {
            $prefix = date('y') . "/" . date('m');
        }
        $last_id = $this->get_increment_id($type, $code);
        $inc_arr = explode("-", $last_id);
        if ($type == 'GRNSERIAL') {
            $str = $inc_arr[3];
        } else {
            $str = $inc_arr[1];
        }
        $str = $str + 1;
        $str = sprintf('%1$03d', $str);
        $data = array();
        $data["last_increment_id"] = $str;
        $this->db->where('type', $type);
        $this->db->where('prefix', $prefix);

        if ($this->db->update($this->increment_table, $data)) {
            return true;
        }
        return false;
    }

    function get_increment_ref_code($type) {
        $this->db->where('type', $type);
        $query = $this->db->get($this->increment_table);
        if ($query->num_rows() == 0) {
            $this->insert_increment_code($type);
            $result = $this->get_new_increment_code($type);
        } else {
            $result = $query->result_array();
        }
        $entry_number = '';
        $inc_data['increment_id'] = str_pad($result['0']['last_increment_id'], 3, '0', STR_PAD_LEFT);
        $inc_data['increment_code'] = $result['0']['code'];
        $entry_number = $inc_data['increment_code'] . "/" . $inc_data['increment_id'];

        return $entry_number;
    }

    function insert_increment_code($type) {
        $data = array();
        $data['type'] = $type;
        $data['last_increment_id'] = 1;
        $data['code'] = $type;
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

    function update_increment_ref_code($type) {
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

}

?>