<?php
class mail {

    private $error = array();

    function __construct()
    {
	    $this->ci = & get_instance(); 
        //$this->ci->load->library('mail');
    }
    
    function sendmail($to, $msg, $subject) {
     
        
        $this->ci->load->library('mail');
        $config['protocol']    = 'ssmtp';
        $config['smtp_host']    = 'ssl://ssmtp.googlemail.com';
        $config['smtp_user']    = 'ftwoftesting@gmail.com';
        $config['smtp_pass']    = 'MotivationS';
        $config['smtp_port']    =  465;
        $config['smtp_crypto']  = 'ssl';
        $config['smtp_timeout'] = "";
        $config['mailtype']     = "html";
        $config['charset']      = "iso-8859-1";
        $config['newline']      = '\r\n';
        $config['wordwrap']     = TRUE;
        $config['validate']     = FALSE;
        $this->ci->email->initialize($config);
        $this->ci->email->set_newline("\r\n");
        $this->ci->email->from('ftwoftesting@gmail.com', 'ftwoftesting');
        $this->ci->email->to($to);
        $this->ci->email->subject($subject);
        $this->ci->email->message($msg);
        echo  $this->ci->email->print_debugger();
        echo 'enter-1';
        print_r($config);
        if ($this->ci->email->send()) {
            return 1;
        } else {
            return 0;
        }
    }

}