<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class To_do_service_model extends CI_Model {

    private $user_table = 'erp_user';
    private $service_table = 'erp_service';

    function __construct() {
        parent::__construct();
    }

    function get_all_users() {
        $this->db->select('tab_1.*');
        $this->db->where('tab_1.status', 1);
        $query = $this->db->get($this->user_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return NULL;
    }

    function get_all_services() {
        $this->db->select('tab_1.*');
        //$this->db->where('status !=', 0);
        $this->db->where('service_status', 1);
        $user_info = $this->user_auth->get_from_session('user_info');
        $user_id = $user_info[0]['id'];
        if ($user_info[0]['id'] != 1) {
            $this->db->where("FIND_IN_SET('$user_id',emp_id) > 0");
//            $this->db->where('emp_id', $user_info[0]['id']);
        }
        $query = $this->db->get($this->service_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return NULL;
    }

    function get_all_services_by_id($id) {
        $this->db->select('tab_1.*');
        //$this->db->where('status !=', 0);
        $this->db->where('service_status', 1);
        $this->db->where('id', $id);
        $query = $this->db->get($this->service_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return NULL;
    }

    function get_service_images_by_id($id, $type = "") {
        $this->db->select('*');
        $this->db->where('service_id', $id);
        if ($type) {
            $this->db->where('type', $type);
        }
        $query = $this->db->get('erp_service_product_image');

        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return NULL;
    }

    function get_service_history_by_id($id) {
        $this->db->select('*');
        $this->db->where('service_id', $id);
        // $this->db->where('emp_image_upload != ', '');
        $this->db->where('work_performed != ', '');
        $this->db->where('created_date != ', '0000-00-00 00:00:00');
        $query = $this->db->get('erp_service_details');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return NULL;
    }

    function get_service_datatables($search_data) {

        $this->_get_service_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_service')->result_array();

        return $query;
    }

    function _get_service_datatables_query($serch_data = array()) {
        $this->db->select('erp_service.*');
       // $this->db->where('status !=', 0);
        $this->db->where('service_status', 1);
        $user_info = $this->user_auth->get_from_session('user_info');
        $user_id = $user_info[0]['id'];
        if ($user_info[0]['role'] != 1) {
            //$this->db->where('emp_id', $user_info[0]['id']);
            $this->db->where("FIND_IN_SET('$user_id',emp_id) > 0");
        }
        $i = 0;
        $column_order = array(null, 'erp_service.inv_no', 'erp_service.ticket_no', 'erp_service.description', 'erp_service.warrenty', 'erp_service.created_date');
        $column_search = array('erp_service.inv_no', 'erp_service.ticket_no', 'erp_service.description', 'erp_service.warrenty', 'erp_service.created_date');
        $order = array('erp_service.id' => 'DESC');

        foreach ($column_search as $item) { // loop column
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i == 0) { // first loop
                    $where .= "(";
                }
                $string = $item;
                $str_arr = explode(".", $string);

                $where .= '`' . $str_arr[0] . "`" . '.' . "`" . $str_arr[1] . "` like '%" . $_POST['search']['value'] . "%'";
                if ((count($column_search) - 1) != $i)
                    $where .= ' OR ';
                if ((count($column_search) - 1) == $i)
                    $where .= ")";
            }
            $i++;
        }

        if ($where != '')
            $this->db->where($where);
        if (isset($_POST['order']) && $column_order[$_POST['order']['0']['column']] != null) {
            $this->db->order_by($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            $order = $order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function count_filtered_service() {
        $this->_get_service_datatables_query();
        $query = $this->db->get('erp_service');
        return $query->num_rows();
    }

    function count_all_service() {
        $this->_get_service_datatables_query();
        $this->db->from('erp_service');
        return $this->db->count_all_results();
    }

    function delete_service($id) {
        $this->db->where('id', $id);
        if ($this->db->update('erp_service', $data = array('service_status' => 0))) {
            return true;
        }
        return false;
    }

    function updateservice($id, $data) {

        $this->db->where('id', $id);
        if ($this->db->update('erp_service', $data)) {
            return true;
        }
        return false;
    }

    function get_all_cust_services_by_id($id) {
        $this->db->select('*');
        //$this->db->where('status !=', 0);
        $this->db->where('service_status', 1);
        $this->db->where('id', $id);
        $query = $this->db->get($this->service_table)->result_array();

        $i = 0;
        foreach ($query as $val) {
            $this->db->select('customer.name,customer.address1,customer.email_id,customer.mobil_number,customer.mobile_number_2');
            $this->db->where('id', intval($val['customer_id']));
            $query[$i]['customer'] = $this->db->get('customer')->result_array();
            $i++;
        }
        return $query;
    }

    function insert_service_product_image($data) {

        if ($this->db->insert("erp_service_product_image", $data)) {

            $insert_id = $this->db->insert_id();

            return $insert_id;
        }

        return false;
    }

    function delete_service_images($id) {
        $this->db->where('service_id', $id);
        $this->db->where('type', 'edit');
        if ($this->db->delete('erp_service_product_image')) {
            return true;
        }
        return false;
    }

}

?>
