<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Cron_model extends CI_Model {

    private $table_name = 'erp_active_users';

    function __construct() {

        parent::__construct();

    }

    function auto_logout() {
        $current_date_time = date('Y-m-d H:i:s');
        
        $data['logged_out_date'] = $current_date_time;
        $this->db->where('logged_out_date is NULL', NULL, FALSE);
        $this->db->update($this->table_name, $data);
        return true;
    }

}

