<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_type_model extends CI_Model {

    private $table_name = 'erp_user_roles';
    private $user_permission_table = 'erp_user_role_permissions';
    private $user_modules_table = 'erp_user_modules';
    private $user_sections_table = 'erp_user_sections';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insert_user_type($data) {
        if ($this->db->insert($this->table_name, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return FALSE;
    }

    function update_user_type($data, $id) {
        $data['updated_date'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        if ($this->db->update($this->table_name, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function delete_user_type($id) {
        $this->db->where('id', $id);
        if ($this->db->delete($this->table_name)) {
            return TRUE;
        }
        return FALSE;
    }

    function get_user_type_by_id($id) {
        $this->db->select($this->table_name . '.*');
        $this->db->where($this->table_name . '.id', $id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_all_user_types() {
        $this->db->select($this->table_name . '.*');
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_user_type_by_name($user_type_name) {
        $this->db->select($this->table_name . '.*');
        $this->db->where('LCASE(user_type_name)', strtolower($user_type_name));
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function is_user_type_available($user_type_name, $id = NULL) {
        $this->db->select($this->table_name . '.id');
        $this->db->where('LCASE(user_type_name)', strtolower($user_type_name));
        if (!empty($id))
            $this->db->where('id !=', $id);
        $query = $this->db->get($this->table_name);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function insert_user_permission($data) {
        if ($this->db->insert($this->user_permission_table, $data)) {
            $sal_id = $this->db->insert_id();
            return true;
        }
        return false;
    }

    function delete_user_permission_by_type($type) {
        $this->db->where('user_type_id', $type);
        if ($this->db->delete($this->user_permission_table)) {
            if ($this->db->affected_rows() > 0) {
                return true;
            }
        }
        return false;
    }

    function get_user_permissions_by_type($user_type_id) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.user_type_id', $user_type_id);
        $query = $this->db->get($this->user_permission_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    function get_user_type_permissions_by_section($user_type_id) {
        $this->db->select('tab_1.*,tab_2.user_section_name,tab_2.user_section_key,tab_3.user_module_key');
        $this->db->join($this->user_sections_table . ' AS tab_2', 'tab_2.id = tab_1.section_id', 'LEFT');
        $this->db->join($this->user_modules_table . ' AS tab_3', 'tab_3.id = tab_1.module_id', 'LEFT');
        $this->db->where('tab_1.user_type_id', $user_type_id);
        $query = $this->db->get($this->user_permission_table . ' AS tab_1');
        $result = $query->result_array();
        $permissions = array();
        if (!empty($result)) {
            foreach ($result as $key => $value) {
                $permissions[$value['user_module_key'] . '|' . $value['user_section_key']] = array('all' => $value['acc_all'], 'view' => $value['acc_view'], 'add' => $value['acc_add'], 'edit' => $value['acc_edit'], 'delete' => $value['acc_delete']);
            }
        }
        return $permissions;
    }

    function get_user_type_permissions_by_module($user_type_id) {
        $this->db->select('tab_1.*,tab_2.user_module_name,tab_2.user_module_key,tab_3.user_section_name,tab_3.user_section_key');
        $this->db->join($this->user_modules_table . ' AS tab_2', 'tab_2.id = tab_1.module_id', 'LEFT');
        $this->db->join($this->user_sections_table . ' AS tab_3', 'tab_3.id = tab_1.section_id', 'LEFT');
        $this->db->where('tab_1.user_type_id', $user_type_id);
        $query = $this->db->get($this->user_permission_table . ' AS tab_1');
        $result = $query->result_array();
        $permissions = array();
        if (!empty($result)) {
            foreach ($result as $key => $value) {
                $permissions[$value['user_module_key']][$value['user_section_key']] = array('all' => $value['acc_all'], 'view' => $value['acc_view'], 'add' => $value['acc_add'], 'edit' => $value['acc_edit'], 'delete' => $value['acc_delete']);
            }
        }
        return $permissions;
    }

}
