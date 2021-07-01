<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Grn extends MX_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('email');
        $this->load->library('Ciqrcode');
        $this->load->database();
        $this->load->library('form_validation');
    }

    public function index() {
        $this->load->model('grn/grn_model');
        $this->load->model('stock/stock_model');
        $this->load->model('master_style/master_model');
        $this->load->model('masters/ref_increment_model');
        $input = $this->input->post();

        if ($input) {
            $user_info = $this->user_auth->get_from_session('user_info');
            $input['gen']['created_by'] = $user_info[0]['id'];
            $input['gen']['grn_no'] = $input['grn_no'];
            $insert_id = $this->grn_model->insert_gen($input['gen']);

            $total_qty = $this->grn_model->get_total_qty($input['po_no']);
            if (isset($insert_id) && !empty($insert_id)) {
                $input = $this->input->post();
                if (isset($input['categoty']) && !empty($input['categoty'])) {
                    $insert_arr = array();
                    foreach ($input['categoty'] as $key => $val) {
                        if (!empty($input['product_serial_no'][$key])) {
                            $increment = '';
                            $insert['product_serial_no'] = $input['product_serial_no'][$key];
                            $increment = explode(",", $insert['product_serial_no']);
                        } else {
                            $increment = '';
                            for ($i = 0; $i < $input['deliver_quantity'][$key]; $i++) {
                                $last_id = $this->ref_increment_model->get_increment_id('GRNSERIAL', 'IS');
                                $increment[] = $last_id;
                                $this->ref_increment_model->update_increment_id('GRNSERIAL', 'IS');
                            }
                            $insert['product_serial_no'] = implode(',', $increment);
                        }
                        $insert['gen_id'] = $insert_id;
                        $insert['po_id'] = $input['gen']['po_id'];
                        $insert['category'] = $val;
                        $insert['product_id'] = $input['product_id'][$key];
                        $insert['product_description'] = $input['product_description'][$key];
                        $insert['type'] = $input['type'][$key];
                        $insert['brand'] = $input['brand'][$key];
                        $insert['quantity'] = $input['quantity'][$key];
                        $insert['return_quantity'] = 0;
                        $insert['delivery_quantity'] = $input['deliver_quantity'][$key];
                        $insert['current_quantity'] = $input['deliver_quantity'][$key];
                        $insert['per_cost'] = $input['per_cost'][$key];
                        if ($input['gen']['is_gst'] == 1) {
                            if ($input['hsn_sac'][$key] != '')
                                $insert['hsn_sac'] = $input['hsn_sac'][$key];
                        } else {
                            $insert['add_amount'] = $input['add_amount'][$key];
                        }
                        $insert['tax'] = $input['tax'][$key];
                        $insert['gst'] = $input['gst'][$key];
                        $insert['igst'] = $input['igst'][$key];
                        $insert['sub_total'] = $input['sub_total'][$key];
                        $insert['created_date'] = date('Y-m-d H:i');
                        //QR code
                        if (!empty($insert['product_serial_no'])) {
                            $this->load->library('ciqrcode');
                            foreach ($increment as $key1 => $val1) {
                                $qr_image = $val1 . '.png';
                                $params['data'] = $val1;
                                $params['level'] = 'H';
                                $params['size'] = 8;
                                $params['savename'] = FCPATH . "attachement/grn_qr_code/" . $qr_image;
                                if ($this->ciqrcode->generate($params)) {
                                    $datas['img_url'] = $qr_image;
                                }
                            }
                        }
                        $insert['qr_code'] = $datas['img_url'];
                        $insert_arr[] = $insert;
                        $stock_arr = array();
                        $po_id['po_id'] = $input['gen']['po_no'];
                        $stock_arr[] = $po_id;
                        $this->stock_details($insert, $po_id);
                        $this->grn_model->update_po_details($input['deliver_quantity'][$key], $input['po_details_id'][$key]);
                    }
                    $this->grn_model->insert_gen_details($insert_arr);
                }
            }
            $this->ref_increment_model->update_increment_ref_code($input['po_no']);
        }
        $data["po_number"] = $this->grn_model->get_all_po_number();
        $this->template->write_view('content', 'grn/index', $data);
        $this->template->render();
    }

    function stock_details($stock_info, $po_id) {
        $this->load->model('grn/grn_model');
        $this->grn_model->check_stock($stock_info, $po_id);
    }

    public function grn_list() {
        $data = array();

        $this->template->write_view('content', 'grn/grn_list', $data);
        $this->template->render();
    }

    public function get_po_list() {
        $this->load->model('grn/grn_model');
        $atten_inputs = $this->input->post();
        $data = $this->grn_model->get_all_po_for_add_gen($atten_inputs);
        echo json_encode($data);
        exit;
    }

    public function po_duplication() {

        $this->load->model('grn/grn_model');
        $input = $this->input->post('value1');
        //print_r($input);exit;
        $validation = $this->grn_model->po_duplication($input);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "PO Already Delivered";
        }
    }

    public function view_po() {
        $input = $this->input->get();
        $this->load->model('masters/ref_increment_model');
        $this->load->model('master_style/master_model');
        $this->load->model('grn/grn_model');
        $data["from"] = 0;
        $data['gen_info'] = $po_data = $this->grn_model->get_gen_by_id_po($input['po']);
        $data["po_details"] = $po_details = $this->grn_model->get_all_po_details_by_id($po_data[0]['id']);
        $po_id = $po_data[0]['po_no'];
        $last_no = $this->ref_increment_model->get_increment_ref_code($po_id);
        $final_id = 'GRN/' . $last_no;
        $data['last_no'] = $final_id;

        $this->load->view('grn/grn_edit_only', $data);
    }

    function get_serial_number() {
        $input = $this->input->get();
        $this->load->model('grn/grn_model');

        $data["gen_details"] = $this->grn_model->get_all_po_details_by_serial($input['serial_no']);

        $this->load->view('grn/view_serial_number', $data);
    }

    function ajaxList() {
        $this->load->model('grn/grn_model');
        $search_data = array();
        $search_data = $this->input->post();
        $list = $this->grn_model->get_grn_datatables($search_data);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $grn_data) {
            if ($this->user_auth->is_action_allowed('goods_receive_note', 'goods_receive_note', 'view')) {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light" href="' . base_url() . 'grn/grn_view/' . $grn_data['id'] . '" data-toggle="tooltip" data-placement="top" title="View"><span class="fa fa-eye"></span></a>';
            } else {
                $view_row = '<a class="btn btn-info btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-eye"></span></a>';
            }
            $no++;

            $row = array();
            $row[] = $no;
            $row[] = $grn_data['grn_no'];
            $row[] = $grn_data['po_no'];
            $row[] = $grn_data['vendor_inv_no'];
            $row[] = $grn_data['name'];
            $row[] = number_format($grn_data['deliver'][0]['delivery_qty']);
            $row[] = number_format($grn_data['net_total'], 2, '.', ',');
            $row[] = ($grn_data['inv_date'] != '') ? date('d-M-Y', strtotime($grn_data['inv_date'])) : '-';
            $row[] = $view_row;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->grn_model->count_all(),
            "recordsFiltered" => $this->grn_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

    public function grn_view($id) {
        $input = $this->input->get();
        $this->load->model('grn/grn_model');

        $data['gen'] = $po_data = $this->grn_model->get_gen_by_id($id);
        $data["po_details"] = $po_details = $this->grn_model->get_all_gen_details_by_id($po_data[0]['id']);
        $data["in_words"] = $this->convert_number($data["gen"][0]['net_total']);

        $this->template->write_view('content', 'grn/grn_view', $data);
        $this->template->render();
    }

    public function view_barcode($id) {
        $input = $this->input->get();
        $this->load->model('grn/grn_model');
        $data['gen'] = $po_data = $this->grn_model->get_gen_datas_by_id($id);

        $this->template->write_view('content', 'grn/view_barcode', $data);
        $this->template->render();
    }

    function convert_number(float $number) {
        $decimal = round($number - ($no = floor($number)), 2) * 100;
        $hundred = null;
        $digits_length = strlen($no);
        $i = 0;
        $str = array();
        $words = array(0 => '', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five', 6 => 'six',
            7 => 'seven', 8 => 'eight', 9 => 'nine',
            10 => 'ten', 11 => 'eleven', 12 => 'twelve',
            13 => 'thirteen', 14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty', 90 => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_length) {
            $divider = ($i == 2) ? 10 : 100;
            $number = floor($no % $divider);
            $no = floor($no / $divider);
            $i += $divider == 10 ? 1 : 2;
            if ($number) {
                $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
                $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
                $str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural . ' ' . $hundred : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural . ' ' . $hundred;
            } else
                $str[] = null;
        }
        $Rupees = implode('', array_reverse($str));
        $paise = ($decimal) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
        return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
    }

    public function generate_product_serial_number() {
        for ($i = 1; $i < 10; $i++) {
            $key = strtoupper(substr(sha1(microtime() . $i), rand(0, 5), 15));
            $serial = implode("-", str_split($key, 5));
        }

        return $serial;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
