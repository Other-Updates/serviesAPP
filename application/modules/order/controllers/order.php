<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Order extends MX_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->database();
        $this->load->library('form_validation');
        $this->load->model('master_category/master_category_model');
        $this->load->model('master_style/master_model');
        $this->load->model('master_brand/master_brand_model');
        $this->load->model('order/Gen_model');
        $this->load->model('customer/customer_model');
        $this->load->model('enquiry/enquiry_model');
    }

    public function index() {
        if ($this->input->post()) {
            $input = $this->input->post();
            $input['quotation']['notification_date'] = date('Y-m-d');
            $input['quotation']['delivery_schedule'] = date('Y-m-d');
            $user_info = $this->user_auth->get_from_session('user_info');
            $input['quotation']['created_by'] = $user_info[0]['id'];
            $input['quotation']['created_date'] = date('Y-m-d H:i');
            $data["last_id"] = $this->master_model->get_last_id('qno_code');
            $enq_id = $data['last_id'][0]['value'];
            $input['quotation']['q_no'] = $enq_id;
            // echo "<pre>"; print_r($input); exit;
            $insert_id = $this->Gen_model->insert_quotation($input['quotation']);
            if (isset($insert_id) && !empty($insert_id)) {
                $input = $this->input->post();
                if (isset($input['categoty']) && !empty($input['categoty'])) {
                    $insert_arr = array();
                    foreach ($input['categoty'] as $key => $val) {

                        $insert['q_id'] = $insert_id;
                        $insert['category'] = $val;
                        $insert['sub_category'] = $input['sub_categoty'][$key];
                        $insert['brand'] = $input['brand'][$key];
                        $insert['quantity'] = $input['quantity'][$key];
                        $insert['per_cost'] = $input['per_cost'][$key];
                        $insert['tax'] = $input['tax'][$key];
                        $insert['sub_total'] = $input['sub_total'][$key];
                        $insert['created_date'] = date('Y-m-d H:i');
                        $insert_arr[] = $insert;
                    }

                    $this->Gen_model->insert_quotation_details($insert_arr);
                }
            }
            $insert_id++;
            $inc['type'] = 'qno_code';
            $inc['value'] = 'QNO000' . $insert_id;
            $this->Gen_model->update_increment($inc);
            $datas["quotation"] = $details = $this->Gen_model->get_all_quotation();
            redirect($this->config->item('base_url') . 'quotation/quotation_list', $datas);
        }
        $data["last_id"] = $this->master_model->get_last_id('qno_code');

        $data["category"] = $details = $this->master_category_model->get_all_category();
        $data["brand"] = $this->master_brand_model->get_brand();
        $this->template->write_view('content', 'quotation/index', $data);
        $this->template->render();
    }

    public function order_list() {
        $datas["quotation"] = $quotation = $this->Gen_model->get_all_order();
        $this->template->write_view('content', 'order/order_list', $datas);
        $this->template->render();
    }

    public function get_customer() {
        $atten_inputs = $this->input->get();
        $data = $this->Gen_model->get_customer($atten_inputs);
        echo '<ul id="country-list">';
        if (isset($data) && !empty($data)) {
            foreach ($data as $st_rlno) {
                if ($st_rlno['name'] != '')
                    echo '<li onClick=selectCountry("' . $st_rlno['name'] . '","' . $st_rlno['id'] . '")>' . $st_rlno['name'] . '</li>';
            }
        }
        else {
            echo '<li style="color:red;">No Data Found</li>';
        }
        echo '</ul>';
    }

    public function change_status($id, $status) {
        $this->Gen_model->change_quotation_status($id, $status);
        redirect($this->config->item('base_url') . 'order/order_list');
    }

    public function get_customer_by_id() {
        $input = $this->input->post();
        $data_customer["customer_details"] = $this->Gen_model->get_customer_by_id($input['id']);
        echo json_encode($data_customer);
    }

    public function quotation_view($id) {
        $datas["quotation"] = $quotation = $this->Gen_model->get_all_quotation_by_id($id);
        $datas["quotation_details"] = $quotation_details = $this->Gen_model->get_all_quotation_details_by_id($id);
        $datas["category"] = $category = $this->master_category_model->get_all_category();
        $datas["brand"] = $brand = $this->master_brand_model->get_brand();
        $this->template->write_view('content', 'quotation_edit', $datas);
        $this->template->render();
    }

    public function update_quotation($id) {
        $his_quo = $this->Gen_model->get_his_quotation_by_id($id);
        $his_quo[0]['org_q_id'] = $his_quo[0]['id'];
        unset($his_quo[0]['id']);
        // echo "<pre>"; print_r($his_quo[0]); exit;
        $insert_id = $this->Gen_model->insert_history_quotation($his_quo[0]);
        $input = $this->input->post();
        $input['quotation']['notification_date'] = date('Y-m-d');
        $input['quotation']['delivery_schedule'] = date('Y-m-d');
        $user_info = $this->user_auth->get_from_session('user_info');
        $input['quotation']['created_by'] = $user_info[0]['id'];
        $input['quotation']['created_date'] = date('Y-m-d H:i');
        //  echo "<pre>"; print_r($input['quotation']); exit;
        $update_id = $this->Gen_model->update_quotation($input['quotation'], $id);
        // echo $id;  echo "<pre>"; print_r($input['quotation']); exit;
        $his_quo_details['hist'] = $this->Gen_model->get_his_quotation_deteils_by_id($id);

        if (isset($update_id) && !empty($update_id)) {
            $insert_arrs = array();
            foreach ($his_quo_details['hist'] as $key) {

                $inserts = $key;
                $inserts['h_id'] = $id;
                $inserts['org_q_id'] = $his_quo[0]['org_q_id'];
                unset($inserts['id']);
                unset($inserts['q_id']);
                $insert_arrs[] = $inserts;
            }

            //echo "<pre>"; print_r($insert_arrs); exit;
            $this->Gen_model->insert_history_quotation_details($insert_arrs);

            $delete_id = $this->Gen_model->delete_quotation_deteils_by_id($id);
            $input = $this->input->post();
            if (isset($input['categoty']) && !empty($input['categoty'])) {
                $insert_arr = array();
                foreach ($input['categoty'] as $key => $val) {

                    $insert['id'] = $id;
                    $insert['q_id'] = $his_quo[0]['org_q_id'];
                    $insert['category'] = $val;
                    $insert['sub_category'] = $input['sub_categoty'][$key];
                    $insert['brand'] = $input['brand'][$key];
                    $insert['quantity'] = $input['quantity'][$key];
                    $insert['per_cost'] = $input['per_cost'][$key];
                    $insert['tax'] = $input['tax'][$key];
                    $insert['sub_total'] = $input['sub_total'][$key];
                    $insert['created_date'] = date('Y-m-d H:i');
                    $insert_arr[] = $insert;
                }
                echo "<pre>";
                print_r($insert_arr);
                exit;
                $this->Gen_model->insert_quotation_details($insert_arr);
            }
        }
        $datas["quotation"] = $quotation = $this->Gen_model->get_all_quotation();
        $this->template->write_view('content', 'quotation/quotation_list', $datas);
    }

    public function edit_gen($id) {
        $this->load->model('po/gen_model');
        $this->load->model('master_state/master_state_model');
        $this->load->model('master_style/master_model');
        $this->load->model('stock/stock_model');
        if ($this->input->post()) {
            $input = $this->input->post();
            $in_id = $id;
            $update_date = array('full_total' => $input['full_total'][0], 'net_total' => $input['net_total'], 'remarks' => $input['remarks'], 'delivery_schedule' => $input['delivery_schedule'], 'delivery_at' => $input['delivery_at'], 'mode_of_payment' => $input['mode_of_payment']);
            $s_landed = $this->master_model->get_landed_cost1($id);

            $this->gen_model->delete_all_data($id);
            $this->gen_model->update_all_data($update_date, $id);
            if (isset($input['color']) && !empty($input['color'])) {
                $s_arr = array();
                foreach ($input['color'] as $key => $val) {
                    if ($val != 'Select' && $val != 'select' && $val != '0') {
                        if (isset($input['size'][$input['style_all'][$key]][$val]) && !empty($input['size'][$input['style_all'][$key]][$val])) {
                            foreach ($input['size'][$input['style_all'][$key]][$val] as $s_id => $s_val) {
                                //$s_landed=$this->master_model->get_landed_cost($input['style_all'][$key]);

                                $s_arr[] = array('gen_id' => $in_id, 'style_id' => $input['style_all'][$key], 'lot_no' => $input['style_lot_no'][$key], 'color_id' => $val, 'size_id' => $s_id, 'qty' => $s_val, 'landed' => $s_landed[0]['landed']);
                            }
                        }
                    }
                }
            }
            $this->gen_model->insert_gen_details($s_arr);
            redirect($this->config->item('base_url') . 'po/po_list');
        }
        $data['gen_info'] = $this->gen_model->get_gen_by_id($id);
        $data['all_state'] = $this->master_state_model->get_all_state();
        $data['all_style'] = $this->master_model->get_all_lot_style();
        $data['all_color'] = $this->stock_model->get_all_color();
        $this->template->write_view('content', 'po/gen_edit', $data);
        $this->template->render();
    }

    public function view_gen($id) {
        $this->load->model('po/gen_model');
        $this->load->model('admin/admin_model');
        $this->load->model('master_state/master_state_model');
        $this->load->model('master_style/master_model');
        $this->load->model('stock/stock_model');
        $data['gen_info'] = $this->gen_model->get_gen_by_id($id);
        $data['all_state'] = $this->master_state_model->get_all_state();
        $data['all_style'] = $this->master_model->get_style();
        $data['all_color'] = $this->stock_model->get_all_color();
        $data['company_details'] = $this->admin_model->get_company_details();
        $this->template->write_view('content', 'po/gen_view', $data);
        $this->template->render();
    }

    public function send_email() {

        $this->load->library("Pdf");
        $this->load->model('po/gen_model');
        $this->load->model('admin/admin_model');
        $this->load->model('master_state/master_state_model');
        $this->load->model('master_style/master_model');
        $this->load->model('stock/stock_model');
        $id = $this->input->get();
        $data['gen_info'] = $this->gen_model->get_gen_by_id($id['po_id']);
        $data['all_state'] = $this->master_state_model->get_all_state();
        $data['all_style'] = $this->master_model->get_style();
        $data['all_color'] = $this->stock_model->get_all_color();
        $data['company_details'] = $this->admin_model->get_company_details();
        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $this->email->initialize($config);
        $this->email->from('noreply@email.com', 'IMS');
        $to_array = array('', $data['company_details'][0]['email'], $data['gen_info'][0]['email_id']);
        $this->email->to($to_array);
        //$this->email->to(',elavarasan.i2sts@gmail.com');
        $this->email->subject($data['gen_info'][0]['grn_no'] . ' Created');
        $this->email->set_mailtype("html");
        $msg1['test'] = $this->load->view('po/email_page', $data, TRUE);
        $msg1['company_details'] = $data['company_details'];

        $msg = $this->load->view('po/pdf_email_template', $msg1, TRUE);


        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf->AddPage();

        $pdf->writeHTMLCell(0, 0, '', '', $msg, 0, 1, 0, true, '', true);

        $newFile = $this->config->item('theme_path') . 'attachement/' . $data['gen_info'][0]['grn_no'] . '.pdf';

        $pdf->Output($newFile, 'F');

        $this->email->attach($this->config->item('theme_path') . 'attachement/' . $data['gen_info'][0]['grn_no'] . '.pdf');
        $this->email->message('Dear sir,<br>Kindly find the attachment for purchase order ' . $data['gen_info'][0]['grn_no']);
        $this->email->send();
    }

    //get sub category
    function get_sub_category() {
        $c_id = $this->input->get('c_id');
        $p_data = $this->master_category_model->get_all_s_cat_by_id($c_id);
        $select = '';
        $select = $select . "<select name='sub_categoty[]'><option value=''>Select</option>";
        if (isset($p_data) && !empty($p_data)) {
            foreach ($p_data as $val1) {
                $select = $select . "<option value=" . $val1['actionId'] . ">" . $val1['sub_categoryName'] . "</option>";
            }
        }

        $select = $select . "</select>";
        if (empty($p_data)) {
            $select = $select . "   <span style='color:red;'>Sub category not crerated yet...</span>";
        }
        echo $select;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */