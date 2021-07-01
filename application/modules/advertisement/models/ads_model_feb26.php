<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ads_model extends CI_Model {

    private $ads = 'erp_advertisement';
    private $ads_details = 'erp_advertisement_details';

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->client_id = $this->user_auth->get_user_id();
    }

    function insert_ads($data) {
        if ($this->db->insert($this->ads, $data)) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }
        return FALSE;
    }

    function update_ads($data, $id) {
        $this->db->where($this->ads . '.id', $id);
        if ($this->db->update($this->ads, $data)) {
            return true;
        }
        return FALSE;
    }

    function delete_ads($id, $data) {
        $this->db->where($this->ads . '.id', $id);
        if ($this->db->update($this->ads, $data)) {
            return true;
        }
        return FALSE;
    }

    function delete_ads_details($id) {
        $this->db->where($this->ads_details . '.ads_id', $id);
        if ($this->db->delete($this->ads_details)) {
            return true;
        }
        return FALSE;
    }

    function delete_ads_details_by_detail_id($id) {
        $this->db->where($this->ads_details . '.id', $id);
        if ($this->db->delete($this->ads_details)) {
            return true;
        }
        return FALSE;
    }

    function update_ads_details_by_detail_id($data, $id) {
        $this->db->where($this->ads_details . '.id', $id);
        if ($this->db->update($this->ads_details, $data)) {
            return true;
        }
        return FALSE;
    }

    public function update_device_staus($data) {
        $action = $data['action'];

        $id = $data['device_checkbox'];

        if (count($id) > 0) {
            for ($i = 0; $i < count($id); $i++) {
                $this->db->where('id', $id[$i]);
                $this->db->update($this->device_table, ['status' => $action]);
            }
        }
        return true;
    }

    function insert_add_details($data) {
        if ($this->db->insert($this->ads_details, $data)) {
            $insert_id = $this->db->insert_id();

            return $insert_id;
        }
        return FALSE;
    }

    function insert_batch_ads_zone_assign($data) {
        if ($this->db->insert_batch($this->ads_zone_assign, $data)) {
            return true;
        }
        return FALSE;
    }

    function get_all_ads() {
        $this->db->select('tab_1.*');
        $this->db->order_by('tab_1.id', DESC);
        $this->db->where('tab_1.is_deleted', 0);
        $query = $this->db->get($this->ads . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return NULL;
    }

    public function update_ads_staus($data) {
        $action = $data['action'];
        $id = $data['projects_checkbox'];

        if (count($id) > 0) {
            $this->db->where('id', $id);
            $this->db->update($this->ads, ['status' => $action]);
            if ($action == 1) {
                $this->db->where_not_in('id', $id);
                $this->db->update($this->ads, ['status' => 0]);
            }
        }
        return true;
    }

    function get_ads_by_id($id) {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.id', $id);
        $query = $this->db->get($this->ads . ' AS tab_1');
        if ($query->num_rows() > 0) {
            $add_details = $query->result_array();
            return $add_details;
        }
    }

    function get_ads_content_by_id($id) {
        $this->db->select($this->ads_details . ".*");
        $this->db->where($this->ads_details . '.ads_id', $id);
        $this->db->where($this->ads_details . '.is_deleted', 0);
        $query = $this->db->get($this->ads_details);

        if ($query->num_rows() > 0) {
            $add_details = $query->result_array();

            return $add_details;
        }
        return NULL;
    }

    function delete_ads_content_records($id, $type) {
        $this->db->where($this->ads_details . '.file_type', $type);
        $this->db->where($this->ads_details . '.ads_id', $id);
        if ($this->db->delete($this->ads_details, $data)) {
            return true;
        }
        return FALSE;
    }

}
