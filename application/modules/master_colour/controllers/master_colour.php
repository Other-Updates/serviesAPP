<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class master_colour extends MX_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	function __construct(){
		parent::__construct();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('session');
		$this->load->library('email');
                $this->load->database();
		$this->load->library('form_validation');
}
	
    public function index(){
	 $this->load->model('master_colour/master_colour_model');
	 //$data["colourcode"]=$this->master_colour_model->get_colour_code();
         $data["colour"]=$this->master_colour_model->get_colour();
	// $r=substr($data["colourcode"][0]['value'],3);
        // $data['last_no']=str_pad($r+1, 4, '0', STR_PAD_LEFT);
 	 $this->template->write_view('content','master_colour/index',$data);
         $this->template->render();	
    }

public function insert_colour(){
	$this->load->model('master_colour/master_colour_model');
	$input=array('brand'=>$this->input->post('colour'));
	$this->master_colour_model->insert_colour($input);
	$data["colour"]=$this->master_colour_model->get_colour();
	redirect($this->config->item('base_url').'master_colour/index',$data);
}
public function update_colour(){
			$this->load->model('master_colour/master_colour_model');
			$id=$this->input->post('value1');
			$input=array('brand'=>$this->input->post('value2'));
			$this->master_colour_model->update_colour($input,$id);
			$data["colour"]=$this->master_colour_model->get_colour();
		   	redirect($this->config->item('base_url').'master_colour/index',$input);
}
public function delete_master_colour(){
  $this->load->model('master_colour/master_colour_model');
  $id=$this->input->get('value1');
  {
  $this->master_colour_model->delete_master_colour($id);
  $data["colour"]=$this->master_colour_model->get_colour();
  redirect($this->config->item('base_url').'master_colour/index',$input);
  }
 }
public function add_duplicate_colorname()
{
$this->load->model('master_colour/master_colour_model');	
$input=$this->input->post('value1');
$validation=$this->master_colour_model->add_duplicate_colorname($input);
$i=0; if($validation){$i=1;}if($i==1){echo"Color Name Already Exist";}

}
public function update_duplicate_colourname()
{
$this->load->model('master_colour/master_colour_model');	
$input=$this->input->get('value1');
$id=$this->input->get('value2');
$validation=$this->master_colour_model->update_duplicate_colourname($input,$id);

$i=0; if($validation){$i=1;}if($i==1){echo "Color Name Already Exist";}

}
}