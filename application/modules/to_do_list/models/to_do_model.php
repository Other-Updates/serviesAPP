<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class To_do_model extends CI_Model {

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
        $this->db->where('status', 2);
        $this->db->where('service_status !=', 0);
        $user_info = $this->user_auth->get_from_session('user_info');
        $user_id = $user_info[0]['id'];
        if ($user_info[0]['role'] != 1) {
            //$this->db->where('emp_id', $user_info[0]['id']);
            $this->db->where("FIND_IN_SET('$user_id',emp_id) > 0");
        }
        $query = $this->db->get($this->service_table . ' AS tab_1');
        if ($query->num_rows() > 0) {
            return $query->result_array();
        }

        return NULL;
    }

    function update_service_assigned($data, $id) {
        $this->db->where('id', $id);
        if ($this->db->update($this->service_table, $data)) {
            return TRUE;
        }
        return FALSE;
    }

    function get_service_datatables($search_data) {

        $this->_get_service_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_service')->result_array();
        //echo $this->db->last_query();
        //exit;

        return $query;
    }

    function _get_service_datatables_query($serch_data = array()) {
        $this->db->select('erp_service.*');
        $this->db->where('status', 2);
        $this->db->where('service_status !=', 0);
        if (isset($serch_data) && !empty($serch_data)) {
            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';
            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(erp_service.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(erp_service.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(erp_service.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {
                $this->db->where("DATE_FORMAT(erp_service.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }

        $user_info = $this->user_auth->get_from_session('user_info');
        $user_id = $user_info[0]['id'];
        //echo $user_info[0]['role'];
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

    function get_leads_datatables($search_data) {

        $this->_get_leads_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_enquiry')->result_array();

        return $query;
    }

    function _get_leads_datatables_query($serch_data = array()) {
        $user_info = $this->user_auth->get_from_session('user_info');
        $this->db->select('erp_enquiry.*,customer.name,customer.address1,customer.email_id,customer.mobil_number,customer.mobile_number_2');
        if ($user_info[0]['role'] == 5) {
            $this->db->where('erp_enquiry.created_by', $user_info[0]['id']);
            $this->db->where('erp_enquiry.enquiry_status', 1);
        } else {
            $this->db->where('erp_enquiry.enquiry_status', 1);
        }
        if (isset($serch_data) && !empty($serch_data)) {
            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';
            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(erp_enquiry.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(erp_enquiry.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(erp_enquiry.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {
                $this->db->where("DATE_FORMAT(erp_enquiry.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        $this->db->join('customer', 'customer.id=erp_enquiry.customer_id', 'LEFT');
        $i = 0;
        $column_order = array(null, 'erp_enquiry.enquiry_no', 'erp_enquiry.customer_name', 'erp_enquiry.customer_address', 'erp_enquiry.created_date', 'erp_enquiry.followup_date', 'erp_enquiry.assigned_to', 'erp_enquiry.enquiry_about', 'erp_enquiry.status', 'erp_enquiry.remarks');
        $column_search = array('erp_enquiry.enquiry_no', 'erp_enquiry.customer_name', 'erp_enquiry.customer_address', 'erp_enquiry.created_date', 'erp_enquiry.followup_date', 'erp_enquiry.assigned_to', 'erp_enquiry.enquiry_about', 'erp_enquiry.status', 'erp_enquiry.remarks');
        $order = array('erp_enquiry.id' => 'DESC');

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

    function count_filtered_leads() {
        $this->_get_leads_datatables_query();
        $query = $this->db->get('erp_enquiry');
        return $query->num_rows();
    }

    function count_all_leads() {
        $this->_get_leads_datatables_query();
        $this->db->from('erp_enquiry');
        return $this->db->count_all_results();
    }

    function get_project_datatables($search_data) {

        $this->_get_project_datatables_query($search_data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get('erp_project_cost')->result_array();

        return $query;
    }

    function _get_project_datatables_query($serch_data = array()) {
        $this->db->select('erp_project_cost.*');
        $this->db->where('estatus', 1);
        if (isset($serch_data) && !empty($serch_data)) {
            if (!empty($serch_data['from_date']))
                $serch_data['from_date'] = date('Y-m-d', strtotime($serch_data['from_date']));
            if (!empty($serch_data['to_date']))
                $serch_data['to_date'] = date('Y-m-d', strtotime($serch_data['to_date']));
            if ($serch_data['from_date'] == '1970-01-01')
                $serch_data['from_date'] = '';
            if ($serch_data['to_date'] == '1970-01-01')
                $serch_data['to_date'] = '';
            if (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {

                $this->db->where("DATE_FORMAT(erp_project_cost.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "' AND DATE_FORMAT(erp_project_cost.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] != "" && isset($serch_data["to_date"]) && $serch_data["to_date"] == "") {

                $this->db->where("DATE_FORMAT(erp_project_cost.created_date,'%Y-%m-%d') >='" . $serch_data["from_date"] . "'");
            } elseif (isset($serch_data["from_date"]) && $serch_data["from_date"] == "" && isset($serch_data["to_date"]) && $serch_data["to_date"] != "") {
                $this->db->where("DATE_FORMAT(erp_project_cost.created_date,'%Y-%m-%d') <= '" . $serch_data["to_date"] . "'");
            }
        }
        $i = 0;
        $column_order = array(null, 'erp_project_cost.job_id', 'erp_project_cost.total_qty', 'erp_service.net_total', null);
        $column_search = array('erp_project_cost.job_id', 'erp_project_cost.total_qty', 'erp_service.net_total');
        $order = array('erp_project_cost.id' => 'DESC');

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

    function count_filtered_project() {
        $this->_get_project_datatables_query();
        $query = $this->db->get('erp_project_cost');
        return $query->num_rows();
    }

    function count_all_project() {
        $this->_get_project_datatables_query();
        $this->db->from('erp_project_cost');
        return $this->db->count_all_results();
    }

}
