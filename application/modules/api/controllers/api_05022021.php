<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require(APPPATH . '/libraries/REST_Controller.php');

class Api extends REST_Controller {

    function __construct() {
        parent::__construct();

        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('user_auth');
        $this->load->library('email');
        $this->load->database();
        $this->load->library('form_validation');
        $this->load->model('api_model');
        $this->load->model('increment_model');
        $this->load->model('admin/admin_model');
    }

    public function emp_login_post() {
        $data_input = $this->_get_custom_post_values(); // JSON Input
        if (!empty($data_input)) {
            if (!empty($data_input['password']) && !empty($data_input['username'])) {
                if (!empty($data_input['login_location'])) {
                    $username = $data_input['username'];
                    $password = $data_input['password'];

                    if ($this->user_auth->login($username, $password)) {
                        $user_data = $this->api_model->get_user_by_login($username, $password);
                        $result = 1;
                    } else {
                        $result = 0;
                    }
                    if ($result == 1) {

                        //insert employee attendance
                        $insert_att = array();

                        $insert_att['user_id'] = $user_data[0]['id'];
                        $insert_att['attendance_status'] = '1';
                        $insert_att['login_location'] = $data_input['login_location'];
                        $insert_attendance = $this->api_model->insert_emp_attendance($insert_att, $user_data[0]['id']);

                        $update_data = array();
                        $update_data['login_date'] = date('Y-m-d');
                        $this->db->where('id', $user_data[0]['id']);
                        $this->db->update('erp_user', $update_data);
                        $user_data[0]['type'] = 'employee';
                        if ($user_data[0]['admin_image'] != '') {
                            $profile_image = base_url() . 'admin_image/original/' . $user_data[0]['admin_image'];
                        } else {
                            $profile_image = '';
                        }
                        $user_data[0]['admin_image'] = $profile_image;

                        //Insert Uesr Status Logs
                        $this->admin_model->users_logs_updates('insert', 1, $user_data[0]['id']);

                        $this->response([
                            'status' => "Success",
                            'message' => 'User login successful.',
                            'data' => $user_data
                        ]);
                    } else {
                        // Set the response and exit
                        //BAD_REQUEST (400) being the HTTP response code
                        $output = array('status' => 'false', 'message' => "Incorrect Username or password.");
                        $this->response($output);
                    }
                } else {
                    $output = array('status' => 'false', 'message' => 'please enter Login Location.');
                    $this->response($output);
                }
            } else {
                // Set the response and exit
                $output = array('status' => 'false', 'message' => "Provide Username and password.");
                $this->response($output);
            }
        } else {
            $output = array('status' => 'false', 'message' => "Provide Username and password.");
            $this->response($output);
        }
    }

    public function cust_login_post() {
        $data_input = $this->_get_custom_post_values();
        if (!empty($data_input)) {
            if (!empty($data_input['password']) && !empty($data_input['mobile_number'])) {
                $mobile_number = $data_input['mobile_number'];
                $password = $data_input['password'];
                $customer_data = $this->api_model->get_customer_by_login($mobile_number, $password);
                if (!empty($customer_data[0]['id']) && $customer_data[0]['otp_verification_status'] != 1) {
                    $output = array('status' => 'error', 'message' => 'Your OTP has not been verified!Please verify');
                    $this->response($output);
                } else if (!empty($customer_data[0]['id']) && $customer_data[0]['otp_verification_status'] == 1) {
                    $customer_data[0]['type'] = 'customer';
                    if ($customer_data[0]['profile_image'] != '') {
                        $profile_image = base_url() . 'attachement/cust_image/' . $customer_data[0]['profile_image'];
                    } else {
                        $profile_image = '';
                    }
                    $customer_data[0]['profile_image'] = $profile_image;
                    $this->admin_model->users_logs_updates('insert', 2, $customer_data[0]['id']);
                    $this->response([
                        'status' => "Success",
                        'message' => 'Customer login successful.',
                        'data' => $customer_data
                    ]);
                } else {
                    $output = array('status' => 'error', 'message' => 'Incorrect Mobile Number or password.');
                    $this->response($output);
                }
            } else {
                $output = array('status' => 'false', 'message' => "Provide Mobile Number and password");
                $this->response($output);
            }
        } else {
            $output = array('status' => 'false', 'message' => "Provide Mobile Number and password.");
            $this->response($output);
        }
    }

    public function user_log_out_post() {
        $data_input = $this->_get_custom_post_values(); // JSON Input
        if (!empty($data_input)) {
            //Insert Uesr Status Logs
            $this->admin_model->users_logs_updates('update',$data_input['user_type'], $data_input['user_id']);
            $output = array('status' => 'true', 'message' => "User Logged Out Successfully.");
            $this->response($output);
        } else {
            $output = array('status' => 'false', 'message' => "Provide User Details.");
            $this->response($output);
        }
    }

    public function customer_log_out_post() {
        $data_input = $this->_get_custom_post_values(); // JSON Input
        if (!empty($data_input)) {
            //Insert User Status Logs
            $this->admin_model->users_logs_updates('update', $data_input['user_type'], $data_input['user_id']);
            $output = array('status' => 'true', 'message' => "Customer Logged Out Successfully.");
            $this->response($output);
        } else {
            $output = array('status' => 'false', 'message' => "Provide Customer Details.");
            $this->response($output);
        }
    }

    function customer_register_post() {
        $data_input = $this->_get_custom_post_values();
        if (!empty($data_input)) {
            $customer = array();
            $customer['password'] = md5($data_input['password']);
            $customer['email_id'] = $data_input['email_id'];
            $customer['name'] = $data_input['name'];
            $customer['mobil_number'] = $data_input['mobile_number'];
            $customer['state_id'] = "31";
            $customer['otp_pincode'] = mt_rand(1000, 9999);
            $is_mobile_number_exists = $this->api_model->is_mobile_number_exists($customer['mobil_number']);
            if ($is_mobile_number_exists) {
                $output = array('status' => 'false', 'message' => "The given mobile number already exists.");
                $this->response($output);
                exit;
            }
            $is_email_id_exists = $this->api_model->is_email_id_exists($customer['email_id']);
            if ($is_email_id_exists) {
                $output = array('status' => 'false', 'message' => "The given email already exists.");
                $this->response($output);
                exit;
            }
            $insert = $this->api_model->insert_customer_details($customer);
            if (!empty($insert) && $insert != 0) {
                $this->customer_mail($insert);
            }
            if (!empty($insert) && $insert != 0) {
                $customer_details = $this->api_model->get_customer_details_by_insert_id($insert);
                $this->response([
                    'status' => "Success",
                    'message' => 'The customer has been registered successfully.',
                    'customer_data' => $customer_details
                ]);
            } else {
                $output = array('status' => 'false', 'message' => "Incorrect Credentials, please try again.");
                $this->response($output);
            }
        } else {
            $output = array('status' => 'false', 'message' => "Provide complete customer info to add.");
            $this->response($output);
        }
    }

    function customer_mail($insert) {

        $data = array();
        $this->load->library('email');
        $config = array(
            'protocol' => 'mail',
            'charset' => 'utf-8',
            'wordwrap' => FALSE,
            'mailtype' => 'html'
        );
        $this->email->initialize($config);
        $data['customer'] = $this->api_model->get_customer_details_by_id($insert);
        $message = 'Hi ' . ucfirst($data['customer'][0]['name']) . ',<br/>';
        $message .= 'Greetings! One Time Password is generated for your account (USER NAME: ' . ucfirst($data['customer'][0]['name']) . ') at Incredible Solutions. Your OTP password is: <b>' . $data['customer'][0]['otp_pincode'] . '</b>. Thank You!<br/>';
        $message .= '<br/><br/>Regards,<br/> Incredible Solutions Team.';
        $email_id = $data['customer'][0]['email_id'];
        $this->email->from('ftwoftesting@gmail.com', 'Incredible Solutions');
        $this->email->to($email_id);
        $this->email->subject('Incredible Solutions - OTP Password Generation');
        $data["content_msg"] = $message;
        $html_message = $this->load->view('customer/otp_send_email.php', $data, TRUE);
        $this->email->message($html_message);
        $this->email->send();
        $this->email->print_debugger();
    }

    function verify_otp_password_post() {

        $data_input = $this->_get_custom_post_values();
        if (!empty($data_input)) {
            if (!empty($data_input['email_id']) && !empty($data_input['otp'])) {
                $email_id = $data_input['email_id'];
                $otp = $data_input['otp'];
                $otp_verification = $this->api_model->check_otp_by_email_id($email_id, $otp);
                $otp_created_time = $otp_verification[0]['created_date'];
                $date = new DateTime($otp_created_time);
                $date->add(new DateInterval('P0DT0H5M0S'));
                $expire_date = $date->format('Y-m-d');
                $verification_date = date('Y-m-d');

                if ($verification_date > $expire_date && $otp_verification[0]['otp_verification_status'] != 3) {
                    $update_data['otp_verification_status'] = 2;
                    $this->db->where('email_id', $email_id);
                    $this->db->where('otp_pincode', $otp);
                    $this->db->update('customer', $update_data);
                    $output = array('status' => 'false', 'message' => "Your OTP time was expired! Please try again.");
                    $this->response($output);
                } elseif (!empty($otp_verification) && $otp_verification != 0) {
                    $update_data['otp_verification_status'] = 1;
                    $this->db->where('email_id', $email_id);
                    $this->db->where('otp_pincode', $otp);
                    $this->db->update('customer', $update_data);
                    $output = array('status' => 'success', 'message' => 'Thank you! Your OTP code has been verified.', 'Customer ID' => $otp_verification[0]['id']);
                    $this->response($output);
                } else {
                    $output = array('status' => 'false', 'message' => 'Verification code incorrect, please try again.');
                    $this->response($output);
                }
            } else {
                $output = array('status' => 'false', 'message' => 'Incorrect Credentials, please try again.');
                $this->response($output);
            }
        } else {
            $output = array('status' => 'false', 'message' => 'Please enter the verification OTP code and Email ID.');
            $this->response($output);
        }
    }

    function resend_otp_post() {
        $data_input = $this->_get_custom_post_values();
        if (!empty($data_input)) {
            if (!empty($data_input['email_id'])) {
                $email_id = $data_input['email_id'];
                $otp["otp_pincode"] = mt_rand(1000, 9999);
                $resent_otp = $otp["otp_pincode"];
                $update_otp = $this->api_model->update_customer_details($email_id, $otp);

                if (!empty($update_otp)) {
                    $cust_id = $this->api_model->get_customer_by_email_id($email_id);
                }
                if (!empty($cust_id) && $cust_id != 0) {
                    $this->resend_otp_mail($cust_id[0]['id']);
                }
                if (!empty($cust_id) && $cust_id != 0) {
                    $update_data['otp_verification_status'] = 3;
                    $this->db->where('email_id', $email_id);
                    $this->db->where('otp_pincode', $resent_otp);
                    $this->db->update('customer', $update_data);
                    $this->response([
                        'status' => "Success",
                        'message' => 'Your OTP has been resent successfully. Please check your email.'
                    ]);
                } else {
                    $output = array('status' => 'false', 'message' => "Incorrect Credentials, please try again.");
                    $this->response($output);
                }
            } else {
                $output = array('status' => 'false', 'message' => 'Incorrect Email ID, please try again.');
                $this->response($output);
            }
        } else {
            $output = array('status' => 'false', 'message' => 'Please enter the Email ID.');
            $this->response($output);
        }
    }

    function resend_otp_mail($id) {
        $data = array();
        $this->load->library('email');
        $config = array(
            'protocol' => 'mail',
            'charset' => 'utf-8',
            'wordwrap' => FALSE,
            'mailtype' => 'html'
        );
        $this->email->initialize($config);
        $data['customer'] = $this->api_model->get_customer_details_by_id($id);
        $message = 'Hi ' . ucfirst($data['customer'][0]['name']) . ',<br/>';
        $message .= 'Greetings! One Time Password is regenerated for your account (USER NAME: ' . ucfirst($data['customer'][0]['name']) . ') at Incredible Solutions. Your OTP password is: <b>' . $data['customer'][0]['otp_pincode'] . '</b>. Thank You!<br/>';
        $message .= '<br/><br/>Regards,<br/> Incredible Solutions Team.';
        $email_id = $data['customer'][0]['email_id'];
        $this->email->from('ftwoftesting@gmail.com', 'Incredible Solutions');
        $this->email->to($email_id);
        $this->email->subject('Incredible Solutions - OTP Password Generation');
        $this->email->message($message);
        $this->email->send();
        $this->email->print_debugger();
    }

    function verify_resend_otp_post() {
        $data_input = $this->_get_custom_post_values();
        if (!empty($data_input)) {
            if (!empty($data_input['email_id']) && !empty($data_input['otp'])) {
                $email_id = $data_input['email_id'];
                $otp = $data_input['otp'];
                $otp_verification = $this->api_model->check_resent_otp_by_email_id($email_id, $otp);
                $otp_created_time = $otp_verification[0]['created_date'];
                $date = new DateTime($otp_created_time);
                $date->add(new DateInterval('P0DT0H5M0S'));
                $expire_date = $date->format('Y-m-d');
                $verification_date = date('Y-m-d');

                if ($verification_date > $expire_date && $otp_verification[0]['otp_verification_status'] != 3) {
                    $update_data['otp_verification_status'] = 2;
                    $this->db->where('email_id', $email_id);
                    $this->db->where('otp_pincode', $otp);
                    $this->db->update('customer', $update_data);
                    $output = array('status' => 'false', 'message' => "Your OTP time was expired! Please try again.");
                    $this->response($output);
                } elseif (!empty($otp_verification) && $otp_verification != 0) {
                    $update_data['otp_verification_status'] = 1;
                    $this->db->where('email_id', $email_id);
                    $this->db->where('otp_pincode', $otp);
                    $this->db->update('customer', $update_data);
                    $output = array('status' => 'success', 'message' => 'Thank you! Your OTP code has been verified.', 'Customer ID' => $otp_verification[0]['id']);
                    $this->response($output);
                } else {
                    $output = array('status' => 'false', 'message' => 'Verification code incorrect, please try again.');
                    $this->response($output);
                }
            } else {
                $output = array('status' => 'false', 'message' => 'Incorrect Credentials, please try again.');
                $this->response($output);
            }
        } else {
            $output = array('status' => 'false', 'message' => 'Please enter the verification OTP code and Email ID.');
            $this->response($output);
        }
    }

    public function leads_list_post() {
        $data_input = $this->_get_custom_post_values(); // JSON Input
        if (!empty($data_input)) {
            if (!empty($data_input['customer_id'])) {
                $customer_id = $data_input['customer_id'];
                $leads_list = $this->api_model->get_all_leads_lists($customer_id);
                if (!empty($leads_list)) {
                    foreach ($leads_list as $key => $leads_val) {
                        if ($leads_val['category_image'] != '') {
                            $category_image = base_url() . 'attachement/category/' . $leads_val['category_image'];
                        } else {
                            $category_image = '';
                        }
                        $leads_list[$key]['category_image'] = $category_image;
                    }
                    $output = array('status' => 'success', 'message' => 'Leads List', 'data' => $leads_list);
                    $this->response($output);
                } else {
                    $output = array('status' => 'false', 'message' => 'Data Not Found');
                    $this->response($output);
                }
            } else {
                $output = array('status' => 'false', 'message' => 'Incorrect Customer ID, please try again.');
                $this->response($output);
            }
        } else {
            $output = array('status' => 'false', 'message' => 'Please enter the Customer ID.');
            $this->response($output);
        }
    }

    public function pending_leads_post() {
        $data_input = $this->_get_custom_post_values(); // JSON Input
        if (!empty($data_input)) {
            if (!empty($data_input['customer_id'])) {
                $customer_id = $data_input['customer_id'];
                $pending_leads = $this->api_model->get_pending_leads($customer_id);
                if (!empty($pending_leads)) {
                    $output = array('status' => 'success', 'message' => 'Pending Leads', 'data' => $pending_leads);
                    $this->response($output);
                } else {
                    $output = array('status' => 'false', 'message' => 'Data Not Found');
                    $this->response($output);
                }
            } else {
                $output = array('status' => 'false', 'message' => 'Incorrect Customer ID, please try again.');
                $this->response($output);
            }
        } else {
            $output = array('status' => 'false', 'message' => 'Please enter the Customer ID.');
            $this->response($output);
        }
    }

    public function pending_services_post() {
        $data_input = $this->_get_custom_post_values(); // JSON Input
        if (!empty($data_input)) {
            if (!empty($data_input['customer_id'])) {
                $customer_id = $data_input['customer_id'];
                $pending_services = $this->api_model->get_pending_services($customer_id);
                if (!empty($pending_services)) {
                    $output = array('status' => 'success', 'message' => 'Pending Services', 'data' => $pending_services);
                    $this->response($output);
                } else {
                    $output = array('status' => 'false', 'message' => 'Data Not Found');
                    $this->response($output);
                }
            } else {
                $output = array('status' => 'false', 'message' => 'Incorrect Customer ID, please try again.');
                $this->response($output);
            }
        } else {
            $output = array('status' => 'false', 'message' => 'Please enter the Customer ID.');
            $this->response($output);
        }
    }

    public function get_all_checked_categories_get() {
        $category_list = $this->api_model->get_all_categories();
        if (!empty($category_list)) {
            foreach ($category_list as $key => $cat_val) {
                if ($cat_val['category_image'] != '') {
                    $category_image = base_url() . 'attachement/category/' . $cat_val['category_image'];
                } else {
                    $category_image = '';
                }
                $category_list[$key]['category_image'] = $category_image;
            }
            $output = array('status' => 'success', 'message' => 'Category list successfully found', 'category' => $category_list);
            $this->response($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Category list Not Found');
            $this->response($output);
        }
    }

    public function add_leads_post() {
        $data_input = $this->_get_custom_post_values(); // JSON Input
        if (!empty($data_input)) {
            $this->load->model('masters/ref_increment_model');
            $data["last_id"] = $this->ref_increment_model->get_increment_id('ERQ', 'ERQ');
            $insert['enquiry_no'] = $data["last_id"];
            $insert['customer_id'] = $customer_id = $data_input['customer_id'];
            $insert['cat_id'] = $data_input['cat_id'];
            $insert['contact_number'] = $data_input['contact_1'];
            $insert['contact_number_2'] = $data_input['contact_2'];
            $insert['enquiry_about'] = $data_input['description'];
            $insert['followup_date'] = date('Y-m-d', strtotime($data_input['followup_date']));
            //get customer data
            $cust_data = $this->api_model->get_customer($customer_id);
            $insert['customer_name'] = $cust_data[0]['name'];
            $insert['customer_email'] = $cust_data[0]['email_id'];
            $insert['customer_address'] = $cust_data[0]['address1'];
            $insert['status'] = 'leads';
            $insert_leads = $this->api_model->insert_leads($insert);
            //update enquiry code
            $this->ref_increment_model->update_increment_id('ERQ', 'ERQ');
            if (!empty($insert_leads)) {
                //update customer data
                $input = array(
                    'mobil_number' => $data_input['contact_1'],
                    'mobile_number_2' => $data_input['contact_2'],
                );
                $this->api_model->update_customer($input, $customer_id);
                $output = array('status' => 'success', 'message' => 'Leads added successfully', 'Leads Code' => $data["last_id"]);
                $this->response($output);
            } else {
                $output = array('status' => 'false', 'message' => 'Leads not added');
                $this->response($output);
            }
        } else {
            $output = array('status' => 'false', 'message' => 'Please enter leads data.');
            $this->response($output);
        }
    }

    public function edit_leads_post() {
        $data_input = $this->_get_custom_post_values(); // JSON Input
        if (!empty($data_input)) {
            $this->load->model('master_style/master_model');
            $id = $data_input['leads_id'];
            $insert['customer_id'] = $customer_id = $data_input['customer_id'];
            $insert['cat_id'] = $data_input['cat_id'];
            $insert['contact_number'] = $data_input['contact_1'];
            $insert['contact_number_2'] = $data_input['contact_2'];
            $insert['enquiry_about'] = $data_input['description'];
            $insert['followup_date'] = date('Y-m-d', strtotime($data_input['followup_date']));
            //get customer data
            $cust_data = $this->api_model->get_customer($customer_id);
            $insert['customer_name'] = $cust_data[0]['name'];
            $insert['customer_email'] = $cust_data[0]['email_id'];
            $insert['customer_address'] = $cust_data[0]['address1'];
            $update_leads = $this->api_model->update_leads($insert, $id);

            if (!empty($update_leads)) {
                //update customer data
                $input = array(
                    'mobil_number' => $data_input['contact_1'],
                    'mobile_number_2' => $data_input['contact_2'],
                );
                $this->api_model->update_customer($input, $customer_id);

                $leads_data = $this->api_model->get_leads_data_by_id($id);
                $output = array('status' => 'success', 'message' => 'Leads updated successfully', 'Leads Data' => $leads_data);
                $this->response($output);
            } else {
                $output = array('status' => 'false', 'message' => 'Leads not updated');
                $this->response($output);
            }
        } else {
            $output = array('status' => 'false', 'message' => 'Please enter leads data.');
            $this->response($output);
        }
    }

    function get_leads_number_get() {
        $this->load->model('masters/ref_increment_model');
        $data["last_id"] = $this->ref_increment_model->get_increment_id('ERQ', 'ERQ');
        if (!empty($data)) {
            $enq_id = $data['last_id'];
            $output = array('status' => 'success', 'message' => 'Leads Number successfully found', 'Leads Number' => $enq_id);
            $this->response($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Leads Number Not Found');
            $this->response($output);
        }
    }

    function get_service_list_post() {

        $data_input = $this->_get_custom_post_values(); // JSON Input
        $customer_id = $data_input['customer_id'];
        $employee_id = $data_input['emp_id'];
        if (!empty($data_input['service_type'])) {
            $type = $data_input['service_type'];

            if ($type == 'customer') {
                $data["service"] = $this->api_model->get_service_list($customer_id, $type);
            } else if ($type == 'employee') {
                $from_date = $data_input['from_date'];
                $to_date = $data_input['to_date'];
                $data["service"] = $this->api_model->get_service_list($employee_id, $type, $from_date, $to_date);
            }
            if (!empty($data["service"])) {
                $output = array('status' => 'success', 'message' => 'Service List successfully found', 'data' => $data["service"]);
                $this->response($output);
            } else {
                $output = array('status' => 'false', 'message' => 'Service List Not Found');
                $this->response($output);
            }
        } else {
            $output = array('status' => 'false', 'message' => 'please enter Service Type.');
            $this->response($output);
        }
    }

    function get_service_pending_list_post() {
        $data_input = $this->_get_custom_post_values(); // JSON Input
        $customer_id = $data_input['customer_id'];
        $employee_id = $data_input['emp_id'];
        if (!empty($data_input['service_type'])) {
            $type = $data_input['service_type'];

            if ($type == 'customer') {
                $data["service"] = $this->api_model->get_service_pending_list($customer_id, $type);
            } else if ($type == 'employee') {
                $from_date = $data_input['from_date'];
                $to_date = $data_input['to_date'];
                $data["service"] = $this->api_model->get_service_pending_list($employee_id, $type, $from_date, $to_date);
            }
            if (!empty($data["service"])) {
                $output = array('status' => 'success', 'message' => 'Service List successfully found', 'data' => $data["service"]);
                $this->response($output);
            } else {
                $output = array('status' => 'false', 'message' => 'Service List Not Found');
                $this->response($output);
            }
        } else {
            $output = array('status' => 'false', 'message' => 'please enter Service Type.');
            $this->response($output);
        }
    }

    public function add_service_post() {
        $this->load->model('masters/ref_increment_model');
        $data_input = $this->_get_custom_post_values(); // JSON Input
        if (!empty($data_input)) {
            if (!empty($data_input['service_type'])) {
                $insert['customer_id'] = $data_input['customer_id'];
                $insert['ticket_no'] = $data_input['ticket_no'];
                $insert['description'] = $data_input['description'];
                $insert['created_date'] = date('Y-m-d');
                if ($data_input['service_type'] == 'warranty') {
                    $insert['inv_no'] = $data_input['inv_no'];
                    $insert['warrenty'] = $data_input['warranty'];
                } else {
                    $last_id = $this->ref_increment_model->get_increment_id('INV', 'INV');
                    $insert['inv_no'] = $last_id;
                    $insert['warrenty'] = 'Not available';
                }
                $insert_id = $this->api_model->insert_service($insert);
                $attachment_list = $_FILES;
                $this->ref_increment_model->update_increment_id('INV', 'INV');
                if (!empty($insert_id) && !empty($attachment_list)) {
                    $this->api_service_image_upload($insert_id);
                }
                if (!empty($insert_id)) {
                    $output = array('status' => 'success', 'message' => 'Service added successfully');
                    $this->response($output);
                } else {
                    $output = array('status' => 'false', 'message' => 'Service not added');
                    $this->response($output);
                }
            } else {
                $output = array('status' => 'false', 'message' => 'Please enter service Type.');
                $this->response($output);
            }
        } else {
            $output = array('status' => 'false', 'message' => 'Please enter service data.');
            $this->response($output);
        }
    }

    public function api_service_image_upload($insert_id) {
        $service_id = $insert_id;
        $upload_list = array();
        if (!empty($_FILES)) {
            $attachment_list = $_FILES;
            if (!empty($attachment_list)) {
                foreach ($attachment_list as $file_name => $file_list) {
                    if (!empty($_FILES[$file_name]['name'])) {
                        $filesCount = count($_FILES[$file_name]['name']);
                        $filename = $_FILES[$file_name]['name'];
                        for ($i = 0; $i < $filesCount; $i++) {
                            $random_hash = substr(str_shuffle(time()), 0, 3) . strrev(mt_rand(100000, 999999));
                            $extension = pathinfo($filename[$i], PATHINFO_EXTENSION);
                            $name = 'PI_' . $random_hash . '.' . $extension;
                            $upload_path = 'attachement/service_image/' . $name;
                            move_uploaded_file($_FILES[$file_name]['tmp_name'][$i], $upload_path);
                            $uploadData[$i]['service_id'] = $service_id;
                            $uploadData[$i]['product_image'] = $filename[$i];
                            $uploadData[$i]['img_path'] = base_url() . 'attachement/service_image/' . $name;
                            $uploadData[$i]['created_date'] = date('Y-m-d H:i:s');
                            $uploadData[$i]['type'] = 'add';
                        }
                        if (!empty($uploadData)) {
                            $insert = $this->api_model->insert_service_image($uploadData);
                        }
                    }
                }
            }
        }
    }

    public function edit_service_image_upload($service_id,$created_date='') {
        $upload_list = array();
        if (!empty($_FILES)) {
            $attachment_list = $_FILES;
            if (!empty($attachment_list)) {
                foreach ($attachment_list as $file_name => $file_list) {
                    if (!empty($_FILES[$file_name]['name'])) {
                        $filesCount = count($_FILES[$file_name]['name']);
                        $filename = $_FILES[$file_name]['name'];
                        for ($i = 0; $i < $filesCount; $i++) {
                            $random_hash = substr(str_shuffle(time()), 0, 3) . strrev(mt_rand(100000, 999999));
                            $extension = pathinfo($filename[$i], PATHINFO_EXTENSION);
                            $name = 'PI_' . $random_hash . '.' . $extension;
                            $upload_path = 'attachement/emp_service/' . $name;
                            move_uploaded_file($_FILES[$file_name]['tmp_name'][$i], $upload_path);
                            $uploadData[$i]['service_id'] = $service_id;
                            $uploadData[$i]['product_image'] = $filename[$i];
                            $uploadData[$i]['img_path'] = base_url() . 'attachement/emp_service/' . $name;
                            $uploadData[$i]['created_date'] = ($created_date != '' ? $created_date : date('Y-m-d H:i:s'));
                            $uploadData[$i]['type'] = 'edit';
                        }
                        if (!empty($uploadData)) {
                            $this->api_model->delete_service_image($service_id, 'edit');
                            $insert = $this->api_model->insert_service_image($uploadData);
                        }
                    }
                }
            }
        }
    }

    public function service_history($service_id,$is_image_upload) {
        $type = 'edit';
        $insert = $this->api_model->service_history($service_id,$type,$is_image_upload);
    }

    public function edit_service_post() {
        $data_input = $this->_get_custom_post_values(); // JSON Input
        if (!empty($data_input)) {
            if (!empty($data_input['service_id'])) {
                $id = $data_input['service_id'];
                $is_image_upload = 0;
                $created_date = date('Y-m-d H:i:s');
                $update['work_performed'] = $data_input['work_performed'];
                $update['status'] = $data_input['status'];
                $update['updated_date'] = $created_date;
                if (!empty($_FILES)) {
                    $is_image_upload = 1;
                }
                $this->service_history($id,$is_image_upload);
                $this->edit_service_image_upload($id,$created_date);

                $update_service = $this->api_model->update_service($update, $id);
                $service_data = $this->api_model->get_service_data_by_id($id);
                if (!empty($update_service)) {
                    $output = array('status' => 'success', 'message' => 'Service updated successfully', 'data' => $service_data);
                    $this->response($output);
                } else {
                    $output = array('status' => 'false', 'message' => 'Service not updated');
                    $this->response($output);
                }
            } else {
                $output = array('status' => 'false', 'message' => 'please enter Service ID.');
                $this->response($output);
            }
        } else {
            $output = array('status' => 'false', 'message' => 'Please enter Service data.');
            $this->response($output);
        }
    }

    function get_pending_service_list_post() {
        $data_input = $this->_get_custom_post_values(); // JSON Input
        $customer_id = $data_input['customer_id'];
        $data["pending"] = $this->api_model->get_pending_service_list($customer_id);
        if (!empty($data["pending"])) {
            $output = array('status' => 'success', 'message' => 'Service List successfully found', 'data' => $data["pending"]);
            $this->response($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Service List Not Found');
            $this->response($output);
        }
    }

    public function update_customer_profile_post() {
        $data_input = $this->_get_custom_post_values(); // JSON Input
        if (!empty($data_input)) {
            $id = $data_input['customer_id'];
            $update['name'] = $data_input['name'];
            $update['email_id'] = $data_input['email_id'];
            $update['mobil_number'] = $data_input['mobile_number'];
            $password = $data_input['password'];
            if (isset($password) && !empty($password)) {
                $update['password'] = md5($password);
            } else {
                $update['password'] = '';
            }
            $update_customer = $this->api_model->update_customer($update, $id);
            $customer_data = $this->api_model->get_customer_data_by_id($id);
            if (!empty($update_customer)) {
                $output = array('status' => 'success', 'message' => 'Customer updated successfully', 'data' => $customer_data);
                $this->response($output);
            } else {
                $output = array('status' => 'false', 'message' => 'Customer not updated');
                $this->response($output);
            }
        } else {
            $output = array('status' => 'false', 'message' => 'Please enter Customer data.');
            $this->response($output);
        }
    }

    function get_adverstisment_details_get() {
        $data["ads"] = $this->api_model->get_adverstisment_details();
        if (!empty($data["ads"])) {
            $output = array('status' => 'success', 'message' => 'Ads Details Successfully Found', 'data' => $data["ads"]);
            $this->response($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Ads Details Not Found');
            $this->response($output);
        }
    }

    function get_link_details_get() {
        $data["links"] = $this->api_model->get_link_details();
        if (!empty($data["links"])) {
            $output = array('status' => 'success', 'message' => 'Link Details Successfully Found', 'data' => $data["links"]);
            $this->response($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Link Details Not Found');
            $this->response($output);
        }
    }

    public function api_customer_image_upload_post() {
        $upload_list = array();
        if (!empty($_FILES)) {
            $attachment_list = $_FILES;
            if (!empty($attachment_list)) {
                foreach ($attachment_list as $file_name => $file_list) {
                    if (!empty($_FILES[$file_name]['name'])) {
                        $new_file_name = $_FILES[$file_name]['name'];
                        $file_name_array = explode('_', $new_file_name);

                        $customer_id = $file_name_array[0];

                        $upload_path = 'attachement/cust_image/' . $new_file_name;
                        move_uploaded_file($_FILES[$file_name]['tmp_name'], $upload_path);

                        $update_data['profile_image'] = $new_file_name;
                        $update = $this->api_model->update_customer($update_data, $customer_id);
                    }
                }
                header('content-type:application/json');
                $output = array('status' => 'success', 'message' => 'Image uploaded successfully!', 'data' => $update_data);
                $this->response($output);
            } else {
                header('content-type:application/json');

                $output = array('status' => 'error', 'message' => 'Invalid data');
                $this->response($output);
            }
        }
        exit;
    }

    public function get_all_invoice_id_post() {
        $data_input = $this->_get_custom_post_values(); // JSON Input
        if (!empty($data_input)) {
            if (!empty($data_input['customer_id'])) {
                $customer_id = $data_input['customer_id'];
                $incoice_id_list = $this->api_model->get_all_invoice_id($customer_id);

                if (!empty($incoice_id_list)) {
                    $output = array('status' => 'success', 'message' => 'Invoice Id', 'data' => $incoice_id_list);
                    $this->response($output);
                } else {
                    $output = array('status' => 'false', 'message' => 'Data Not Found');
                    $this->response($output);
                }
            } else {
                $output = array('status' => 'false', 'message' => 'Incorrect Customer ID, please try again.');
                $this->response($output);
            }
        } else {
            $output = array('status' => 'false', 'message' => 'Please enter the Customer ID.');
            $this->response($output);
        }
    }

    public function get_invoice_details_by_id_post() {
        $data_input = $this->_get_custom_post_values(); // JSON Input
        if (!empty($data_input)) {
            if (!empty($data_input['inv_id'])) {
                $inv_id = $data_input['inv_id'];
                $invoice_details_list = $this->api_model->get_invoice_details_by_id($inv_id);
                if (!empty($invoice_details_list)) {
                    $date = date("Y-m-d");
                    if ($invoice_details_list[0]['warranty_to'] > $date) {
                        $invoice_details_list[0]['warranty'] = 'Available';
                    } else {
                        $invoice_details_list[0]['warranty'] = 'Not available';
                    }
                    //Get token number
                    $get_token_number = $this->api_model->get_last_service_token();
                    if ($get_token_number != '') {
                        $invoice_details_list[0]['ticket_no'] = $get_token_number;
                    } else {
                        $invoice_details_list[0]['ticket_no'] = '';
                    }
                    $output = array('status' => 'success', 'message' => 'Invoice Id', 'data' => $invoice_details_list);
                    $this->response($output);
                } else {
                    $output = array('status' => 'false', 'message' => 'Data Not Found');
                    $this->response($output);
                }
            } else {
                $output = array('status' => 'false', 'message' => 'Incorrect Invoice ID, please try again.');
                $this->response($output);
            }
        } else {
            $output = array('status' => 'false', 'message' => 'Please enter the Invoice ID.');
            $this->response($output);
        }
    }

    public function update_employee_profile_post() {
        $data_input = $this->_get_custom_post_values(); // JSON Input
        if (!empty($data_input)) {
            $id = $data_input['emp_id'];
            $update['username'] = $data_input['username'];
            $update['email_id'] = $data_input['email_id'];
            $update['mobile_no'] = $data_input['mobile_number'];
            $password = $data_input['password'];
            if (isset($password) && !empty($password)) {
                $update['password'] = md5($password);
            } else {
                $update['password'] = '';
            }

            $update_user = $this->api_model->update_user($update, $id);
            $user_data = $this->api_model->get_user_data_by_id($id);
            if (!empty($update_user)) {
                $output = array('status' => 'success', 'message' => 'Employee updated successfully', 'data' => $user_data);
                $this->response($output);
            } else {
                $output = array('status' => 'false', 'message' => 'Employee not updated');
                $this->response($output);
            }
        } else {
            $output = array('status' => 'false', 'message' => 'Please enter Employee data.');
            $this->response($output);
        }
    }

    public function api_employee_image_upload_post() {

        $upload_list = array();
        if (!empty($_FILES)) {
            $attachment_list = $_FILES;
            if (!empty($attachment_list)) {
                foreach ($attachment_list as $file_name => $file_list) {
                    if (!empty($_FILES[$file_name]['name'])) {
                        $new_file_name = $_FILES[$file_name]['name'];
                        $file_name_array = explode('_', $new_file_name);
                        $emp_id = $file_name_array[0];
                        $upload_path = 'admin_image/original/' . $new_file_name;
                        move_uploaded_file($_FILES[$file_name]['tmp_name'], $upload_path);

                        $update_data['admin_image'] = $new_file_name;
                        $update = $this->api_model->update_user($update_data, $emp_id);
                    }
                }
                header('content-type:application/json');
                $output = array('status' => 'success', 'message' => 'Image uploaded successfully!', 'data' => $update_data);
                $this->response($output);
            } else {
                header('content-type:application/json');

                $output = array('status' => 'error', 'message' => 'Invalid data');
                $this->response($output);
            }
        }
        exit;
    }

    public function get_all_attendant_details_by_invno_post() {
        $data_input = $this->_get_custom_post_values(); // JSON Input
        if (!empty($data_input)) {
            if (!empty($data_input['customer_id'])) {
                $customer_id = $data_input['customer_id'];
                $inv_no = $data_input['inv_no'];
                $attendant_list = $this->api_model->get_all_attendant_details_by_invno($customer_id, $inv_no);

                if (!empty($attendant_list)) {
                    $output = array('status' => 'success', 'message' => 'Attendant Details', 'data' => $attendant_list);
                    $this->response($output);
                } else {
                    $output = array('status' => 'false', 'message' => 'Data Not Found');
                    $this->response($output);
                }
            } else {
                $output = array('status' => 'false', 'message' => 'Incorrect Customer ID, please try again.');
                $this->response($output);
            }
        } else {
            $output = array('status' => 'false', 'message' => 'Please enter the Customer ID.');
            $this->response($output);
        }
    }

    function get_last_ticket_number_get() {
        $data['token_number'] = $this->api_model->get_last_service_token();
        if (!empty($data["token_number"])) {
            $output = array('status' => 'success', 'message' => 'Ticket number Successfully Found', 'data' => $data['token_number']);
            $this->response($output);
        } else {
            $output = array('status' => 'error', 'message' => 'Ticket number Not Found');
            $this->response($output);
        }
    }

    public function get_project_link_by_invno_post() {
        $data_input = $this->_get_custom_post_values(); // JSON Input
        if (!empty($data_input)) {
            if (!empty($data_input['inv_no'])) {
                $inv_no = $data_input['inv_no'];
                $project_link_list = $this->api_model->get_project_link_by_invno($inv_no);

                if (!empty($project_link_list)) {
                    $output = array('status' => 'success', 'message' => 'Project Link Details', 'data' => $project_link_list);
                    $this->response($output);
                } else {
                    $output = array('status' => 'false', 'message' => 'Data Not Found');
                    $this->response($output);
                }
            } else {
                $output = array('status' => 'false', 'message' => 'Incorrect Invoice Number, please try again.');
                $this->response($output);
            }
        } else {
            $output = array('status' => 'false', 'message' => 'Please enter the Invoice Number.');
            $this->response($output);
        }
    }

}
