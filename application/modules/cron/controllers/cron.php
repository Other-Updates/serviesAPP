<?php



if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Cron extends MX_Controller {



    function __construct() {

        parent::__construct();

        $this->load->database();

        $this->load->model('cron/cron_model');
    }

    public function logout() {
        $this->cron_model->auto_logout();
        echo 'Logout Successfully';
    }


}

