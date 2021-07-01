<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Notification_model extends CI_Model {

    private $table_name1 = 'erp_notification';

    function __construct() {
        date_default_timezone_set('Asia/Kolkata');
        parent::__construct();
    }

    public function insert_notification($data)
    {
        if ($this->db->insert($this->table_name1, $data)) {
                return true;
        }
        return false;
    }
    public function update_notification($data,$id)
    {
        $this->db->where('id',$id);
        if ($this->db->update($this->table_name1, $data)) {

                return true;
        }
        return false;
    }
    public function all_notification()
    {
        $this->db->select('*');
        $this->db->where('status',0);
        $this->db->order_by("notification_date",'asc');
        return $this->db->get($this->table_name1)->result_array();
    }

}

?>