<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class links_model extends CI_Model {

    private $erp_links = 'erp_links';
    private $erp_link_details = 'erp_link_details';

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function insert_links($data) {
        if ($this->db->insert($this->erp_links, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return FALSE;
    }

    function update_links($data, $id) {
        $this->db->where($this->erp_links . '.id', $id);
        if ($this->db->update($this->erp_links, $data)) {
            return true;
        }
        return FALSE;
    }

    function delete_links($id, $data) {
        $this->db->where($this->erp_links . '.id', $id);
        if ($this->db->update($this->erp_links, $data)) {
            return true;
        }
        return FALSE;
    }

    public function insert_link_datas($data) {

        $this->db->insert_batch($this->erp_link_details, $data);
        return true;
    }

    function get_all_links() {
        $this->db->select('erp_links.*');
        $this->db->order_by('erp_links.id', DESC);
        $this->db->where('erp_links.is_deleted', 0);
        $query = $this->db->get($this->erp_links);
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    public function delete_link_datas_byid($id) {
        $this->db->where('link_id', $id);
        $this->db->delete($this->erp_link_details);
        return true;
    }

    function get_links_by_id($id) {
        $this->db->select('erp_links.*');
        $this->db->where('erp_links.id', $id);
        $this->db->where('erp_links.is_deleted', 0);
        $query = $this->db->get($this->erp_links)->result_array();
        $i = 0;
        foreach ($query as $val) {
            $this->db->select('*');
            $this->db->where('link_id', intval($val['id']));
            $query[$i]['link_datas'] = $this->db->get('erp_link_details')->result_array();
            $i++;
        }
        return $query;
    }

    public function update_links_staus($data) {
        $action = $data['action'];
        $id = $data['projects_checkbox'];

        if (count($id) > 0) {
            $this->db->where('id', $id);
            $this->db->update($this->erp_links, ['status' => $action]);
            if ($action == 1) {
                $this->db->where_not_in('id', $id);
                $this->db->update($this->erp_links, ['status' => 0]);
            }
        }
        return true;
    }

}
