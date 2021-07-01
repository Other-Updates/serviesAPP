<?php
	$this->load->helper('file');
$this->load->helper('download');
$this->load->library('zip');

//load database
$this->load->dbutil();

//create format
$db_format=array('format'=>'zip','filename'=>'backup.sql');

$backup=& $this->dbutil->backup($db_format);

// file name

$dbname='backup-on-'.date('d-m-y H:i').'.zip';
$save = './db_back_up/'.$db_name;

// write file

write_file($save,$backup);

// and force download
force_download($dbname,$backup);
	 
?>