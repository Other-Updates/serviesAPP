<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

define('STATUS_ACTIVATED', '1');
define('STATUS_NOT_ACTIVATED', '0');

class User_auth {

    private $error = array();
    private $app_name;

    function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->database();
        // $this->ci->load->library('session');
        $this->ci->load->model('admin/admin_model');
        $this->ci->load->model('masters/user_model');
        $this->ci->load->model('masters/user_role_model');
        $this->app_name = $this->ci->config->item('application_name');
    }

    function login($username, $password) {

        if ((strlen($username) > 0) AND ( strlen($password) > 0)) {


            if ($user = $this->ci->admin_model->get_user_by_login($username, $password)) { // login ok
                if (md5($password) == $user->password) { // password ok
                    if ($user->status != 0) {  // success
                        $sections = $this->ci->user_role_model->get_user_role_permissions_by_section($user->role);
                        //print_r($sections);

                        $modules = $this->ci->user_role_model->get_user_role_permissions_by_module($user->role);
//                        echo '<pre>';
//                        print_r($modules);
//                        exit;
                        //$firms = $this->ci->user_model->get_all_firms_by_user_id($user->id);

                        $profile_image = 'default_profile_image.png';
                        if (!empty($user->admin_image))
                            $profile_image = $user->admin_image;
                        $timezone = 'Asia/kolkata';

                        $data['username'] = $username;
                        $data['password'] = $password;

                        $user_info_data = $this->ci->admin_model->login($data);
                        // $user_info_session_array = array('user_info' => $user_info_data);



                        $app = array(
                            'user_id' => $user->id,
                            'username' => $user->username,
                            'email_address' => $user->email_id,
                            'name' => $user->name,
                            'name' => $user->nick_name,
                            'user_role_id' => $user->role,
                            'profile_image' => $profile_image,
                            'status' => ($user->status == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED,
                            'sections' => $sections,
                            'modules' => $modules,
                            'user_info' => $user_info_data,
                            'is_logged_in' => 1,
                            'login_time' => date('H:i:s'),
                            'login_timestamp' => time(),
                            'timezone' => $timezone,
                            'login_ip' => $_SERVER['REMOTE_ADDR'],
                            'browser' => $_SERVER['HTTP_USER_AGENT']
                        );
                        // echo 'success';
                        //exit;
                        $this->store_in_session($app);
                        //echo '<pre>';
                        //print_r($app);
                        //exit;
                        return TRUE;
                    } else {
                        $this->error = array('not_activated' => 'auth_not_activated'); // fail - not activated
                    }
                } else {
                    $this->error = array('password' => 'auth_incorrect_password'); // fail - wrong password
                }
            } else {
                $this->error = array('login' => 'auth_incorrect_login'); // fail - wrong login
            }
        }
        return FALSE;
    }

    function logout() {
        //$this->delete_autologin();
        $this->ci->session->unset_userdata($this->app_name);
        $this->ci->session->sess_destroy();
    }

    function is_logged_in() {

        if ($this->get_from_session('is_logged_in') == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function get_user_id() {
        return $this->get_from_session('user_id');
    }

    function get_user_info() {
        return $this->get_from_session('user_info');
    }

    function get_profile_image() {
        return $this->get_from_session('profile_image');
    }

    function get_username() {
        $username = $this->get_from_session('username');
        return $username;
    }

    function get_user_nickname() {
        $username = $this->get_from_session('nickname');
        return $username;
    }

    function get_user_name() {
        $username = $this->get_from_session('name');
        return $username;
    }

    function get_email_address() {
        $email = $this->get_from_session('email_address');
        return $email;
    }

    function get_user_email() {
        $email = $this->get_from_session('email_address');
        return $email;
    }

    function get_logintime() {
        return $this->get_from_session('login_time');
    }

    function get_user_permissions() {
        return $this->get_from_session('permissions');
    }

    function get_user_role_id() {
        return $this->get_from_session('user_role_id');
    }

    /* function get_user_firms() {
      $username = $this->get_from_session('firms');
      return $username;
      } */

    function is_permission_allowed($access_array = array(), $main_module = NULL) {
        $current_class = $this->ci->router->class;
        $current_method = $this->ci->router->method;
        $user_permission = $this->get_from_session('modules');
        //echo '<pre>';
        //print_r($user_permission);
        $permission_arr = isset($access_array[$current_class . '/' . $current_method]) ? $access_array[$current_class . '/' . $current_method] : array();
        //print_r($permission_arr);
        $is_allowed = 0;
        $sub_module = ($current_class == 'reports') ? $current_method : $current_class;
        if (!empty($permission_arr) && is_array($permission_arr)) {
            foreach ($permission_arr as $list) {
                if (isset($user_permission[$main_module][$sub_module][$list]) && $user_permission[$main_module][$sub_module][$list] == 1)
                    $is_allowed = 1;
            }
        } else if ($permission_arr == 'no_restriction') {
            $is_allowed = 1;
        }

        //echo 'Is Allowed : ' . $is_allowed . '<br/>';
        return $is_allowed;
    }

    function is_module_allowed($module_key = NULL) {
        $user_permission = $this->get_from_session('modules');

        $permission_arr = isset($user_permission[$module_key]) ? $user_permission[$module_key] : array();
        $is_allowed = 0;
        if (!empty($permission_arr) && is_array($permission_arr)) {
            foreach ($permission_arr as $section) {
                if (!empty($section) && is_array($section) && array_sum($section) > 0)
                    $is_allowed = 1;
            }
        }
        return $is_allowed;
    }

    function is_section_allowed($module_key = NULL, $section_key = NULL) {
        $user_permission = $this->get_from_session('modules');
        $section = isset($user_permission[$module_key][$section_key]) ? $user_permission[$module_key][$section_key] : array();
        $is_allowed = 0;
        if (is_array($section) && !empty($section) && array_sum($section) > 0) {
            $is_allowed = 1;
        }
        return $is_allowed;
    }

    function is_action_allowed($module = NULL, $section = NULL, $action = NULL) {
        $user_permission = $this->get_from_session('modules');
        $access = isset($user_permission[$module][$section][$action]) ? $user_permission[$module][$section][$action] : array();
        $is_allowed = 0;
        if (!empty($access) && $access == 1) {
            $is_allowed = 1;
        }
        return $is_allowed;
    }

    function store_in_session($array_to_store) {

        $user_data = $this->ci->session->userdata($this->app_name);
        $app_session = json_decode(json_encode($this->cryptography('decrypt', $user_data)), true);

        if (!empty($app_session)) {
            foreach ($array_to_store as $key => $val) {
                $app_session[$key] = $val;
            }
        } else {
            $app_session = $array_to_store;
        }

        $app_session = $this->cryptography('encrypt', $app_session);
        $this->ci->session->set_userdata($this->app_name, $app_session);
    }

    function get_from_session($key) {
        //echo $this->app_name;
        //echo $key;
        $user_data = $this->ci->session->userdata($this->app_name);
        $app_session = json_decode(json_encode($this->cryptography('decrypt', $user_data)), true);
        if (isset($app_session[$key]))
            return $app_session[$key];
        else
            return NULL;
    }

    function get_all_session() {
        $user_data = $this->ci->session->userdata($this->app_name);
        $app_session = json_decode(json_encode($this->cryptography('decrypt', $user_data)), true);
        return $app_session;
    }

    function cryptography($action, $data) {
        $salt = $this->ci->config->item('salt');
        if ($action == 'encrypt') {
            $data = json_encode($data);
            return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $data, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
        } else if ($action == 'decrypt') {
            $data = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($data), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
            return json_decode($data);
        }
    }

    function create_autologin($user_id) {
        $this->ci->load->helper('cookie');
        $user = $this->ci->users_model->get_user_by_id($user_id);
        $cookie_arr = array(
            'name' => $this->ci->config->item('autologin_cookie_name'),
            'value' => serialize(array('user_id' => $user_id, 'key' => md5($user->password))),
            'expire' => $this->ci->config->item('autologin_cookie_life'),
        );
        if (set_cookie($cookie_arr)) {
            return TRUE;
        }
        return FALSE;
    }

    function delete_autologin() {
        $this->ci->load->helper('cookie');
        if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name'), TRUE)) {
            $data = unserialize($cookie);
            //Insert User Status Logs
            $this->ci->admin_model->users_logs_updates('update', 1, $data['user_id']);
            delete_cookie($this->ci->config->item('autologin_cookie_name'));
        }
    }

    function autologin() {
        if (!$this->is_logged_in() AND ! $this->is_logged_in(FALSE)) {  // not logged in (as any user)
            $this->ci->load->helper('cookie');
            if ($cookie = get_cookie($this->ci->config->item('autologin_cookie_name'), TRUE)) {
                $data = unserialize($cookie);
                if (isset($data['user_id'])) {
                    if (!is_null($user = $this->ci->users_model->get_user_by_id($data['user_id'])) && ($data['key'] == md5($user->password))) {
                        // Login user
                        $this->ci->session->set_userdata(array(
                            'user_id' => $user->id,
                            'username' => $user->username,
                            'permission' => $user->permission,
                            'status' => STATUS_ACTIVATED,
                        ));
                        //Insert User Status Logs
                        $this->ci->admin_model->users_logs_updates('insert', 1, $user->id);

                        // Renew users cookie to prevent it from expiring
                        set_cookie(array(
                            'name' => $this->ci->config->item('autologin_cookie_name'),
                            'value' => $cookie,
                            'expire' => $this->ci->config->item('autologin_cookie_life'),
                        ));
                        return TRUE;
                    }
                }
                return FALSE;
            }
        }
        return FALSE;
    }

    function simple_encrypt($text, $salt = 'billing_software') {
        return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $salt, $text, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
    }

    function simple_decrypt($text, $salt = 'billing_software') {
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $salt, base64_decode($text), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
    }

    function getUserIpAddr() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) { //if from shared
            return $_SERVER['HTTP_CLIENT_IP'];
        } else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //if from a proxy
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            return $_SERVER['REMOTE_ADDR'];
        }
    }

    function get_user_permission() {
        $user_permission = $this->ci->session->userdata('admin_permission');
        return $user_permission;
    }

    function get_curdate() {
        $timezone = new DateTimeZone("Asia/Kolkata");
        $date = new DateTime();
        $date->setTimezone($timezone);
        $cur_date_time = $date->format('H:i:s A  /  D, M jS, Y');
        $cur_date = $date->format('d-m-Y');
        return $cur_date;
    }

    function get_curdate_time() {
        $timezone = new DateTimeZone("Asia/Kolkata");
        $date = new DateTime();
        $date->setTimezone($timezone);
        $cur_date_time = $date->format('Y-d-m h:i:s');
        return $cur_date_time;
    }

}

/* End of file userauth.php */
/* Location: ./application/libraries/userauth.php */