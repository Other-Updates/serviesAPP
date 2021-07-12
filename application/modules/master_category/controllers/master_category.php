<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_category extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');

        if (!$this->user_auth->is_logged_in()) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $main_module = 'masters';
        $access_arr = array(
            'master_category/index' => array('add', 'edit', 'delete', 'view'),
            'master_category/insert_master_category' => array('add'),
            'master_category/save_defect' => array('add'),
            'master_category/update_category' => array('edit'),
            'master_category/update_categories' => array('edit'),
            'master_category/delete_master_category' => array('delete'),
            'master_category/add_duplicate_category' => array('add', 'edit'),
            'master_category/update_duplicate_category' => array('add', 'edit'),
            'master_category/save_defect' => 'no_restriction',
            'master_category/update_cat' => 'no_restriction',
            'master_category/save_action' => 'no_restriction',
            'master_category/delete_action_by_id' => 'no_restriction',
            'master_category/edit_action_by_id' => 'no_restriction',
            'master_category/ajaxList' => 'no_restriction',
        );

        if (!$this->user_auth->is_permission_allowed($access_arr, $main_module)) {
            redirect($this->config->item('base_url'));
        }
    }

    function redirect_function($url) {
        ?>
        <script>
            window.location.href = "<?php echo $url; ?>";
        </script>
        <?php
    }

    public function index() {
        $this->load->model('master_category/master_category_model');
        $data['corrective_action'] = $corrective_action = $this->master_category_model->get_all_corrective_action();
        //   echo"<pre>"; print_r($data); exit;
        $data["detail"] = $details = $this->master_category_model->get_all_category();
        $this->template->write_view('content', 'master_category/index', $data);
        $this->template->render();
    }

    public function insert_master_category() {
        $this->load->model('master_category/master_category_model');
        $input = array('category' => $this->input->post('category'));
        if ($input['category'] != '') {
            $this->master_category_model->insert_master_category($input);
            $data["detail"] = $this->master_category_model->get_all_category();
            redirect($this->config->item('base_url') . 'master_category/index', $data);
        } else {
            $data["detail"] = $this->master_category_model->get_all_category();
            $this->template->write_view('content', 'master_category/index', $data);
            $this->template->render();
        }
    }

    public function update_category() {
        $this->load->model('master_category/master_category_model');
        $data = $this->input->post();
        $action_ids = $data['actionId'];
        unset($data["actionId"]);
        unset($data["sub_categoryName"]);
        // echo"<pre>"; print_r($data); exit;
        $config['upload_path'] = './attachement/category';
        $config['allowed_types'] = '*';
        $config['max_size'] = '2000';
        $this->load->library('upload', $config);
        $upload_data['file_name'] = $_FILES;

        if (isset($_FILES) && !empty($_FILES)) {
            $upload_files = $_FILES;
            if ($upload_files['category_image'] != '') {
                $_FILES['category_image'] = array(
                    'name' => $upload_files['category_image']['name'],
                    'type' => $upload_files['category_image']['type'],
                    'tmp_name' => $upload_files['category_image']['tmp_name'],
                    'error' => $upload_files['category_image']['error'],
                    'size' => '2000'
                );
                $this->upload->do_upload('category_image');
                $upload_data = $this->upload->data();
                $dest = getcwd() . "/attachement/category/" . $upload_data['file_name'];
                $src = $this->config->item("base_url") . 'attachement/category/' . $upload_data['file_name'];
            }
        }
        $data['category_image'] = $upload_data['file_name'];
        if ($data['is_checked'] == 'on') {
            $is_checked = 1;
        } else {
            $is_checked = 0;
        }
        $data['is_checked'] = $is_checked;
        $this->master_category_model->update_defect($data);
        $insert_id = $data['cat_id'];
        if (isset($insert_id) && !empty($insert_id)) {
            if (isset($action_ids) && !empty($action_ids)) {
                foreach ($action_ids as $key) {
                    $datas[] = array('cat_id' => $insert_id, 'actionId' => $key);
                }
                $defect_type_id = $this->master_category_model->insert_defect_type_corrective_action($datas, $insert_id);
            }
        }
        $url = $this->config->item('base_url') . "master_category/index";
        $this->redirect_function($url);
    }

    public function delete_master_category() {
        $this->load->model('master_category/master_category_model');
        $id = $this->input->get('value1');
        //echo "<pre>"; print_r($id); exit;
        $this->master_category_model->delete_master_category($id);
        $data["detail"] = $this->master_category_model->get_all_category();
        redirect($this->config->item('base_url') . 'master_category/index', $data);
    }

    public function add_duplicate_category() {
        $this->load->model('master_category/master_category_model');
        $input = $this->input->get('value1');
        $validation = $this->master_category_model->add_duplicate_category($input);
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Category Name already Exist";
        }
    }

    public function update_duplicate_category() {
        $this->load->model('master_category/master_category_model');
        $input = $this->input->post('value1');
        $id = $this->input->post('value2');
        $validation = $this->master_category_model->update_duplicate_category($input, $id);
        //echo $input; echo $id; exit;
        $i = 0;
        if ($validation) {
            $i = 1;
        }if ($i == 1) {
            echo "Category Name already Exist";
        }
    }

    function save_defect() {
        $this->load->model('master_category/master_category_model');
        $data = $this->input->post();
        $action_ids = $data['actionId'];
        unset($data["actionId"]);
        unset($data["sub_categoryName"]);
        $this->load->helper('text');
        $config['upload_path'] = './attachement/category';
        $config['allowed_types'] = '*';
        $config['max_size'] = '2000';
        $this->load->library('upload', $config);
        $upload_data['file_name'] = $_FILES;
        if (isset($_FILES) && !empty($_FILES)) {
            $upload_files = $_FILES;
            if ($upload_files['category_image'] != '') {
                $_FILES['category_image'] = array(
                    'name' => $upload_files['category_image']['name'],
                    'type' => $upload_files['category_image']['type'],
                    'tmp_name' => $upload_files['category_image']['tmp_name'],
                    'error' => $upload_files['category_image']['error'],
                    'size' => '2000'
                );
                $this->upload->do_upload('category_image');
                $upload_data = $this->upload->data();
                $dest = getcwd() . "/attachement/category/" . $upload_data['file_name'];
                $src = $this->config->item("base_url") . 'attachement/category/' . $upload_data['file_name'];
            }
        }
        $data['category_image'] = $upload_data['file_name'];
        if ($data['is_checked'] == 'on') {
            $is_checked = 1;
        } else {
            $is_checked = 0;
        }
        $data['is_checked'] = $is_checked;
        $insert_id = $this->master_category_model->insert_defect($data);
        if (isset($insert_id) && !empty($insert_id)) {
            if (isset($action_ids) && !empty($action_ids)) {
                foreach ($action_ids as $key) {
                    $datas[] = array('cat_id' => $insert_id, 'actionId' => $key);
                }
                $defect_type_id = $this->master_category_model->insert_defect_type_corrective_action($datas, $insert_id);
            }
        }
        $url = $this->config->item('base_url') . "master_category/index";
        $this->redirect_function($url);
    }

    function update_cat($id) {
        $this->load->model('master_category/master_category_model');
        $data['defect_type'] = $defect_type = $this->master_category_model->get_all_defect_type_data($id);
        //echo"<pre>";print_r($defect_type);exit;
        $this->template->write_view('content', 'master_category/edit_category', $data);
        $this->template->render();
    }

    function save_action() {
        $this->load->model('master_category/master_category_model');
        $datas = $this->input->post();
        $data = $datas['sub_categoryName'];

        if (isset($datas) && !empty($datas)) {
            //echo"<pre>"; print_r($datas); exit;
            $insert_id = $this->master_category_model->insert_action($datas);
            echo "<tbody><tr><td><input type='checkbox' name='actionId[]' value='$insert_id'></td>
            <td class='edit_name hide_edit'><input type='text' id='$insert_id' value='$data' disabled /></td>
            <td class='text-right'><a href='javascript:void(0);' class='edit_corrective_action' maze='$data' id='$insert_id' hijacked='yes'><i class='fa fa-edit'></i></a> &nbsp; <a id='$insert_id' class='delete_corrective_action' data-original-title='Delete' hijacked='yes'><i class='fa fa-close'></i></a></td>
        </tr><tbody>";
            $this->skip_template_view();
        }
    }

    function delete_action_by_id($id) {
        $this->load->model('master_category/master_category_model');
        $datas = $this->input->post();

        //$user_id= $this->session->userdata('iUserId');
        echo $this->master_category_model->delete_action_by_ids($datas['del_id']);
        $this->skip_template_view();
    }

    function edit_action_by_id($id) {
        $this->load->model('master_category/master_category_model');
        $datas = $this->input->post();
        $id = $datas['actionId'];
        //echo"<pre>"; print_r($datas); exit;
        unset($datas['actionId']);

        echo $this->master_category_model->update_action_by_ids($id, $datas);
        $this->skip_template_view();
    }

    function ajaxList() {
        $this->load->model('master_category/master_category_model');
        $list = $this->master_category_model->get_datatables();

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $category_data) {
            if ($this->user_auth->is_action_allowed('masters', 'master_category', 'edit')) {
                $edit_row = '<a class="btn btn-round btn-primary btn-mini waves-effect waves-light" href="' . base_url() . 'master_category/update_cat/' . $category_data->cat_id . '" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-pencil"></span></a>';
            } else {
                $edit_row = '<a class="btn btn-round btn-primary btn-mini waves-effect waves-light alerts" href=""><span class="fa fa-pencil"></span></a>';
            }
            if ($this->user_auth->is_action_allowed('masters', 'master_category', 'delete')) {
                $delete_row = '<a onclick="delete_category(' . $category_data->cat_id . ')" class="btn btn-round btn-danger btn-mini waves-effect waves-light delete_row" delete_id="test3_' . $category_data->cat_id . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><span class="fa fa-trash" style="color: white;"></span></a>';
            } else {
                $delete_row = '<a  class="btn btn-round btn-danger btn-mini waves-effect waves-light delete_row alerts" delete_id="test3_' . $category_data->cat_id . '" data-toggle="modal" name="delete" title="In-Active" id="delete"><span class="fa fa-trash" style="color: white;"></span></a>';
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $category_data->categoryName;
            $row[] = $category_data->category_image;
            $row[] = $edit_row . '&nbsp;&nbsp;' . $delete_row;
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->master_category_model->count_all(),
            "recordsFiltered" => $this->master_category_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
        exit;
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
