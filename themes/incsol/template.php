<!DOCTYPE html>
<html lang="en">


    <!-- Mirrored from html.phoenixcoded.net/mega-able/default/sample-page.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 01 Oct 2019 04:03:46 GMT -->
    <head>
        <?php
        $sesion_data = $this->user_auth->get_all_session();
        $logged_in = $this->user_auth->get_from_session('user_info');
        $this->load->model('admin/admin_model');
        $data["admin"] = $this->admin_model->get_admin();
        $this->load->model('enquiry/enquiry_model');
        $this->load->model('quotation/gen_model');
        $this->load->model('sales_return/sales_return_model');
        $this->load->model('invoice/invoice_model');
        $this->load->model('purchase_order/purchase_order_model');
        $this->load->model('grn/grn_model');
        $this->load->model('purchase_return/purchase_return_model');
        $this->load->model('stock/stock_model');
        $this->load->model('project_cost/project_cost_model');
        $pending_leads_count = $this->enquiry_model->get_pending_leads_count();
        $pending_quotation_count = $this->gen_model->get_pending_quotation_count();
        $sales_return_count = $this->sales_return_model->get_sales_return_count();
        $pending_delivery_po_count = $this->grn_model->get_pending_delivery_po();
        $pending_receipt_count = $this->invoice_model->get_pending_receipt_count();
        $purchase_order_count = $this->purchase_order_model->get_purchase_order_count();
        $stock_count = $this->stock_model->get_all_stock();
        $quotation_count = $this->project_cost_model->get_pending_project_count();
        ?>
        <?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
        <title><?= $this->config->item('site_title'); ?> | <?= $this->config->item('site_powered'); ?></title>
        <?php
        $cur_class = $this->router->class;
        $cur_method = $this->router->method;
        ?>
        <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 10]>
        <script src = "https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="Gradient Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
        <meta name="keywords" content="flat ui, admin Admin , Responsive, Landing, Bootstrap, App, Template, Mobile, iOS, Android, apple, creative app">
        <meta name="author" content="Phoenixcoded" />
        <!-- Favicon icon -->
        <link rel="icon" href="<?= $theme_path; ?>/assets/images/favicon.png" type="image/x-icon">
        <!--Google font    -->
        <link href="<?= $theme_path; ?>/assets/css/font-style.css?family=Roboto:400,500" rel="stylesheet">
        <!-- Required Fremwork -->
        <link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/bootstrap/css/bootstrap.min.css">
        <!-- waves.css -->
        <link rel="stylesheet" href="<?= $theme_path; ?>/assets/pages/waves/css/waves.min.css" type="text/css" media="all">
        <!-- themify-icons line icon -->
        <link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/assets/icon/themify-icons/themify-icons.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/assets/icon/font-awesome/css/font-awesome.min.css">
        <!-- Data Table Css -->
        <link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/assets/pages/data-table/css/buttons.dataTables.min.css">
        <link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
        <!-- Style.css -->
        <link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/assets/icon/icofont/css/icofont.css">
        <link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/assets/css/jquery.mCustomScrollbar.css">
        <link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/assets/css/printcss.css" media="print">
        <link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/assets/css/autocomplete.css">


        <?php
        $user_info = $this->user_auth->get_from_session('user_info');
        if (empty($user_info[0]['id'])) {
            redirect($this->config->item('base_url') . 'admin');
        }
        $this->load->model('admin/admin_model');
        $user_activation = $this->admin_model->get_user_activation_list();
        $user_count = $this->admin_model->get_user_count_list();
        ?>
        <style>
            .newClass {
                top: -12px !important;
                font-size: 11px !important;
                font-weight:600 !important;
            }
            .newClass1 {
                top: 7px !important;
                font-size: 14px !important;
                font-weight:590 !important;
            }
            .form-material select.form-control:not([size]):not([multiple]) {
                height: 36px;
                border: 0px solid #ccc;
                border-bottom:1px solid #ccc;
            }

            .main-footer {
                border-top: 1px solid rgba(67, 89, 102, 0.1);
                color: #1b1b1b;
                text-align: left !important;
                padding: 12px 17px;
                position: fixed;
                background: #ffffff;
                z-index: 99;
                font-size: 13px;
                bottom: 0px;
                left: 248px;
                right: 10px;
            }
            .new-style-form{
                top:-9px;
                font-size:11px;
                font-weight:600 !important;
            }
            .val{font-size:11px;}
            body .preloader{overflow:hidden !important;}
            @media only screen and (max-width:580px){
                .preloader img {
                    width: 55%;
                    position: absolute;
                    margin-top: 15rem;
                    z-index: 999999;
                    margin-left: -28%;
                }
                .navbar-logo .img-fluid{width: 88px !important;}
                .nav-tabs .slide{width:91%;}
            }
            .noti_scroll{
                Overflow-y:auto;
                max-height:100px;
            }
            .pcount{margin-top:5px;padding: 4px 5px; margin-right:0px;}

            .ui-menu-item .ui-menu-item-wrapper.ui-state-active {
                background: #448aff !important;
                font-weight: bold !important;
                color: #fff !important;
            }
            .remove_symbol_bd::before
            {
                display:none !important;
            }
        </style>
    </head>

    <body>
        <!-- <?php
        $data["admin"] = $this->admin_model->get_admin($user_info[0]['role'], $user_info[0]['id']);
        $data['company_details'] = $this->admin_model->get_company_details();
        ?>
         <div class="print_header print-align" style="display:none">
             <div class="print_header_logo">
                 <img class="img-fluid" src="<?= $theme_path; ?>/assets/images/printlogo.png" alt="Theme-Logo" style="width:235px"/>
             </div>
             <div class="print_header_tit ml-95">
                 <h2><?= $data['company_details'][0]['company_name'] ?></h2>
                 <p>
        <?= $data['company_details'][0]['address1'] ?>,
        <?= $data['company_details'][0]['address2'] ?>,
        <?= $data['company_details'][0]['city'] ?>,
        <?= $data['company_details'][0]['state'] ?>-
        <?= $data['company_details'][0]['pin'] ?>
                 </p>
                 <p></p>
                 <p><strong>Ph</strong>:
        <?= $data['company_details'][0]['phone_no'] ?>, <strong>Email</strong>:
        <?= $data['company_details'][0]['email'] ?>
                 </p>
             </div>

         </div>-->
        <div class="preloader" >
            <div class="pageloader"><img src="<?= $theme_path; ?>/assets/images/solutions12gif.gif" alt="processing"></div>
        </div>
        <!-- Pre-loader start -->
        <!--<div class="theme-loader">
            <div class="loader-track">
                <div class="preloader-wrapper">
                    <div class="spinner-layer spinner-blue">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                    <div class="spinner-layer spinner-red">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>

                    <div class="spinner-layer spinner-yellow">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>

                    <div class="spinner-layer spinner-green">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>-->
        <!-- Pre-loader end -->
        <div id="pcoded" class="pcoded">
            <div class="pcoded-overlay-box"></div>
            <div class="pcoded-container navbar-wrapper">
                <nav class="navbar header-navbar pcoded-header">
                    <div class="navbar-wrapper">
                        <div class="navbar-logo">
                            <a class="mobile-menu waves-effect waves-light" id="mobile-collapse" href="#!">
                                <i class="ti-menu"></i>
                            </a>
                            <a href="<?php echo $this->config->item('base_url') . 'admin/' ?>">
                                <img class="img-fluid" src="<?= $theme_path; ?>/assets/images/f2f-logo.png" alt="Theme-Logo" style="width:135px"/>
                            </a>
                            <a class="mobile-options waves-effect waves-light">
                                <i class="ti-more"></i>
                            </a>
                        </div>

                        <div class="navbar-container container-fluid">
                            <ul class="nav-left">
                                <li>
                                    <div class="sidebar_toggle"><a href="javascript:void(0)"><i class="ti-menu"></i></a></div>
                                </li>
                                <li>
                                    <a href="#!" onclick="javascript:toggleFullScreen()" class="waves-effect waves-light">
                                        <i class="ti-fullscreen"></i>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav-right">
                                <li class="header-notification">
                                    <a href="#!" class="waves-effect waves-light">
                                        <i class="ti-bell"></i>
                                        <span class="badge bg-c-red"></span>
                                    </a>
                                    <?php
                                    if (($user_info[0]['role'] == 1 || $user_info[0]['role'] == 2)) {
                                        $this->load->model('api/notification_model');
                                        $notification = $this->notification_model->all_notification();
                                        ?>
                                        <ul class="show-notification">
                                            <li>
                                                <h6>Notifications</h6>
                                                <label class="label label-danger"><?php echo count($user_count); ?></label>
                                            </li>
                                            <?php
                                            if (!empty($user_activation)) {
                                                $default_image = $this->config->item("base_url") . "admin_image/original/admin_icon.png";
                                                foreach ($user_activation as $key => $notify_data) {
                                                    ?>
                                                    <li class="waves-effect waves-light">
                                                        <?php
                                                        if ($notify_data['user_type'] == 1 && $notify_data['status'] == 1) {
                                                            $user_name = $notify_data['user_name'];
                                                            $profile_image = $notify_data['user_image'];
                                                            $exists = file_exists(FCPATH . 'admin_image/original/' . $profile_image);
                                                            $logo_image = (!empty($f_name) && $exists) ? $f_name : "admin_icon.png";
                                                            $path = "admin_image/original/";
                                                            $profile_image_data = $this->config->item("base_url") . $path . $profile_image;

                                                            if (!empty($profile_image)) {
                                                                $profile_image = ($exists) ? $profile_image_data : $default_image;
                                                            } else {
                                                                $profile_image = $this->config->item("base_url") . "admin_image/original/admin_icon.png";
                                                            }
                                                            ?>
                                                            <div class="media">
                                                                <img class="d-flex align-self-center img-radius" src="<?php echo $profile_image; ?>" alt="Generic placeholder image">
                                                                <div class="media-body">
                                                                    <h5 class="notification-user"><?php echo $user_name; ?></h5>
                                                                    <!-- <p class="notification-msg">Lorem ipsum dolor sit amet, consectetuer elit.</p>
                                                                    <span class="notification-time">30 minutes ago</span> -->
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>
                                        </ul>
                                        <!--                                        <ul class="show-notification1">
                                                                                    <li>
                                                                                        <h6>Notifications</h6>
                                                                                        <label class="label label-danger"><?php echo (count($notification) != 0) ? count($notification) : '0' ?></label>
                                                                                    </li>

                                                                                    <li class="waves-effect waves-light">
                                                                                        <div class="noti_scroll">
                                                                                            <div class="media">
                                                                                                <div class="media-body">
                                        <?php
                                        if (isset($notification) && !empty($notification)) {
                                            foreach ($notification as $noty) {
                                                ?>
                                                                                                                                                                                                                    <p class="notification-msg">
                                                                                                                                                                                                                    <a href="<?php echo $this->config->item('base_url') . $noty['link'] . '?notification=' . $noty['id']; ?>" style="color:#448aff">
                                                <?php
                                                if ($noty['type'] == 'payment')
                                                    echo 'Payment';
                                                else if ($noty['type'] == 'purchase_payment')
                                                    echo 'Purchase Payment';
                                                else if ($noty['type'] == 'min_qty')
                                                    echo 'Quantity Shortage';
                                                else if ($noty['type'] == 'quotation')
                                                    echo 'Quotation';
                                                ?>
                                                                                                                                                                                                                    </a>
                                                                                                                                                                                                                    <br>
                                                                                                                                                                                                                    <small class="text-muted"><?php echo $noty['Message']; ?></small>
                                                                                                                                                                                                                    </p>
                                                <?php
                                            }
                                        } else {
                                            echo '<p class="notification-msg">No data found...</p>';
                                        }
                                        ?>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </li>

                                                                                </ul>-->
                                    <?php } ?>
                                </li>
                                <li class="">
                                    <a href="#!" class="displayChatbox waves-effect waves-light">
                                        <i class="ti-comments"></i>
                                        <span class="badge bg-c-green"></span>
                                    </a>
                                </li>
                                <li class="user-profile header-notification">
                                    <a href="#!" class="waves-effect waves-light">
                                        <?php
                                        $exists = file_exists(FCPATH . 'admin_image/original/' . $this->user_auth->get_from_session('profile_image'));
                                        $f_name = $this->user_auth->get_from_session('profile_image');
                                        $logo_image = (!empty($f_name) && $exists) ? $f_name : "admin_icon.png";
                                        ?>
                                        <img  class="img-80 img-radius" src="<?php echo $this->config->item("base_url") . 'admin_image/original/' . $logo_image; ?>" width="40px" height="40px"/>
                                        <span><?php echo ucfirst($user_info[0]['username']) ?></span>
                                        <i class="ti-angle-down"></i>
                                    </a>
                                    <ul class="show-notification profile-notification">
                                        <li class="waves-effect waves-light">
                                            <a href="<?php echo $this->config->item('base_url') . 'admin/update_profile' ?>">
                                                <i class="ti-user"></i> Profile
                                            </a>
                                        </li>
                                        <li class="waves-effect waves-light">
                                            <a href="<?php echo $this->config->item('base_url') . 'admin/general_info' ?>">
                                                <i class="ti-info"></i> General Info
                                            </a>
                                        </li>
                                        <li class="waves-effect waves-light">
                                            <a href="<?php echo $this->config->item('base_url') . 'admin/logout' ?>">
                                                <i class="ti-layout-sidebar-left"></i> Logout
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
                <div id="sidebar" class="users p-chat-user showChat">
                    <div class="had-container">
                        <div class="card card_main p-fixed users-main">
                            <div class="user-box">
                                <div class="chat-search-box">
                                    <a class="back_friendlist">
                                        <i class="fa fa-chevron-left"></i>
                                    </a>
                                    <div class="right-icon-control">
                                        <form class="form-material">
                                            <div class="form-group form-primary">
                                                <input type="text" name="footer-email" class="form-control" id="search-friends" required="">
                                                <span class="form-bar"></span>
                                                <label class="float-label"><i class="fa fa-search m-r-10"></i>Search Friend</label>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="main-friend-list">

                                <?php
                                if (!empty($user_activation)) {
                                    $default_image = $this->config->item("base_url") . "admin_image/original/admin_icon.jpg";
                                    foreach ($user_activation as $key => $notify_cust_data) {
                                        if ($notify_cust_data['user_type'] == 2) {
                                            $customer_name = $notify_cust_data['store_name'];
                                            $cust_image = $notify_cust_data['customer_image'];
                                            $cust_path = "attachement/cust_image/";
                                            $exists = file_exists(FCPATH . 'attachement/cust_image/' . $cust_image);
                                            $$cust_image_data = $this->config->item("base_url") . $cust_path . $cust_image;

                                            if (!empty($cust_image)) {
                                                $cust_image = ($exists) ? $$cust_image_data : $default_image;
                                            } else {
                                                $cust_image = $this->config->item("base_url") . "admin_image/original/admin_icon.jpg";
                                            }
                                            ?>
                                                <div class="media userlist-box waves-effect waves-light" data-id="1" data-status="online" data-username="<?php echo $customer_name; ?>" data-toggle="tooltip" data-placement="left" title="<?php echo $customer_name; ?>">
                                                    <a class="media-left" href="#!">
                                                        <img class="media-object img-radius img-radius" src="<?php echo $cust_image; ?>" alt="Generic placeholder image ">
                                                        <div class="live-status bg-success"></div>
                                                    </a>
                                                    <div class="media-body">
                                                        <div class="f-13 chat-header"><?php echo $customer_name; ?></div>
                                                    </div>
                                                </div>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
# Initialize
                $title = '';
                $dashboard = $home = $bread = $sub_title = $menu_trigger = '';
# Dashboard
                if (($this->uri->uri_string() == 'admin/index') || ($this->uri->uri_string() == 'admin') || ($this->router->class == 'admin' && $this->router->method == 'index') || ($this->router->class == 'admin' && $this->router->method == 'dashboard')) {
                    // $bread = 'Home';
                    $title = 'Dashboard';
                    $sub_title = 'Dashboard';
                }
# My Profile
                if (($this->uri->uri_string() == 'admin/update_profile')) {
                    // $bread = 'Home';
                    $title = 'My Profile';
                    $sub_title = 'My Profile';
                }
# General Info
                if (($this->uri->uri_string() == 'admin/general_info')) {
                    $bread = 'Dashboard';
                    $title = 'General Info';
                    $sub_title = 'General Info';
                }
# Masters - Supplier
                if (($this->uri->uri_string() == 'vendor/index') || ($this->uri->uri_string() == 'vendor/index') || ($this->router->class == 'vendor' && $this->router->method == 'edit_vendor') || ($this->router->class == 'vendor' && $this->router->method == 'view')) {
                    // $bread = 'Masters';
                    $title = 'Masters - Vendor';
                    $sub_title = 'Vendor';
                    $menu_trigger = 'pcoded-trigger';
                }
# Masters - Customer
                if (($this->uri->uri_string() == 'customer/index') || ($this->uri->uri_string() == 'customer/index') || ($this->router->class == 'customer' && $this->router->method == 'edit_customer') || ($this->router->class == 'customer' && $this->router->method == 'view')) {
                    // $bread = 'Masters';
                    $title = 'Masters - Customer';
                    $sub_title = 'Customer';
                    $menu_trigger = 'pcoded-trigger';
                }
# Masters - User roles
                if (($this->uri->uri_string() == 'masters/user_roles') || ($this->uri->uri_string() == 'masters/user_roles') || ($this->router->class == 'user_roles' && $this->router->method == 'user_permissions') || ($this->router->class == 'masters/user_roles' && $this->router->method == 'view')) {
                    // $bread = 'Masters';
                    $title = 'Masters - User Roles';
                    $sub_title = 'User Roles';
                    $menu_trigger = 'pcoded-trigger';
                }

# Masters - Expense Category
                if (($this->uri->uri_string() == 'masters/expense_category') || ($this->uri->uri_string() == 'masters/expense_category') || ($this->router->class == 'masters' && $this->router->method == 'expense_category') || ($this->router->class == 'masters/expense_category' && $this->router->method == 'view') || ($this->router->class == 'expense_category' && $this->router->method == 'edit')) {
                    // $bread = 'Masters';
                    $title = 'Masters - Spending Category';
                    $sub_title = 'Spending Category';
                    $menu_trigger = 'pcoded-trigger';
                }
# Masters - Users
                if (($this->uri->uri_string() == 'users/index') || ($this->uri->uri_string() == 'users/index') || ($this->router->class == 'users' && $this->router->method == 'edit_user') || ($this->router->class == 'users' && $this->router->method == 'view')) {
                    // $bread = 'Masters';
                    $title = 'Masters - Users';
                    $sub_title = 'Users';
                    $menu_trigger = 'pcoded-trigger';
                }
# Masters - Product
                if (($this->uri->uri_string() == 'product/index') || ($this->uri->uri_string() == 'product/index') || ($this->router->class == 'product' && $this->router->method == 'edit_product') || ($this->router->class == 'product' && $this->router->method == 'view')) {
                    // $bread = 'Masters';
                    $title = 'Masters - Product';
                    $sub_title = 'Product';
                    $menu_trigger = 'pcoded-trigger';
                }
# Masters - Category
                if (($this->uri->uri_string() == 'master_category/index') || ($this->uri->uri_string() == 'master_category/index') || ($this->router->class == 'master_category' && $this->router->method == 'update_cat') || ($this->router->class == 'master_category' && $this->router->method == 'view')) {
                    // $bread = 'Masters';
                    $title = 'Masters - Category';
                    $sub_title = 'Category';
                    $menu_trigger = 'pcoded-trigger';
                }
# Masters - Brand
                if (($this->uri->uri_string() == 'master_brand/index') || ($this->uri->uri_string() == 'master_brand/index') || ($this->router->class == 'master_brand/index' && $this->router->method == 'master_brand/index') || ($this->router->class == 'master_brand' && $this->router->method == 'view')) {
                    //$bread = 'Masters';
                    $title = 'Masters - Brand';
                    $sub_title = 'Brand';
                    $menu_trigger = 'pcoded-trigger';
                }
# Masters - Email
                if (($this->uri->uri_string() == 'email/index') || ($this->uri->uri_string() == 'email/index') || ($this->router->class == 'email/index' && $this->router->method == 'email/index') || ($this->router->class == 'email' && $this->router->method == 'view')) {
                    //$bread = 'Masters';
                    $title = 'Masters - Email Settings';
                    $sub_title = 'Email Settings';
                    $menu_trigger = 'pcoded-trigger';
                }
# Masters - Adverstisment
                if (($this->uri->uri_string() == 'advertisement') || ($this->uri->uri_string() == 'advertisement/index') || ($this->uri->uri_string() == 'advertisement/add') || ($this->router->class == 'advertisement' && $this->router->method == 'edit')) {
                    // $bread = 'Masters';
                    $title = 'Masters - Adverstisment';
                    $sub_title = 'Adverstisment';
                    $menu_trigger = 'pcoded-trigger';
                }
# Masters - Manage Links
                if (($this->uri->uri_string() == 'manage_links') || ($this->uri->uri_string() == 'manage_links/index') || ($this->uri->uri_string() == 'manage_links/add') || ($this->router->class == 'manage_links' && $this->router->method == 'edit')) {
                    //$bread = 'Masters';
                    $title = 'Masters - Manage Links';
                    $sub_title = 'Manage Links';
                    $menu_trigger = 'pcoded-trigger';
                }
# Enquiry
                if (($this->uri->uri_string() == 'enquiry') || ($this->uri->uri_string() == 'enquiry/enquiry_list') || ($this->uri->uri_string() == 'enquiry') || ($this->router->class == 'enquiry' && $this->router->method == 'enquiry_edit') || ($this->router->class == 'enquiry' && $this->router->method == 'view')) {
                    //$bread = 'Home';
                    $title = 'Leads';
                    $sub_title = 'Leads';
                }
# Services
                if (($this->uri->uri_string() == 'service') || ($this->uri->uri_string() == 'service/to_do_service') || ($this->uri->uri_string() == 'service') || ($this->router->class == 'to_do_service' && $this->router->method == 'service_edit') || ($this->router->class == 'to_do_service' && $this->router->method == 'service_view')) {
                    //$bread = 'Home';
                    $title = 'Services';
                    $sub_title = 'Services';
                }
# Quotation
                if (($this->uri->uri_string() == 'quotation') || ($this->uri->uri_string() == 'quotation/quotation_list') || ($this->uri->uri_string() == 'quotation') || ($this->router->class == 'quotation' && $this->router->method == 'quotation_edit') || ($this->router->class == 'quotation' && $this->router->method == 'quotation_view') || ($this->router->class == 'quotation' && $this->router->method == 'history_view')) {
                    //$bread = 'Home';
                    $title = 'Quotation';
                    $sub_title = 'Quotation';
                }
# Purchase Order
                if (($this->uri->uri_string() == 'purchase_order') || ($this->uri->uri_string() == 'purchase_order/purchase_order_list') || ($this->uri->uri_string() == 'purchase_order') || ($this->router->class == 'purchase_order' && $this->router->method == 'po_edit') || ($this->router->class == 'purchase_order' && $this->router->method == 'po_view')) {
                    // $bread = 'Purchase';
                    $title = 'Purchase';
                    $sub_title = 'Purchase Order';
                }
# Purchase Return
                if (($this->uri->uri_string() == 'purchase_return') || ($this->uri->uri_string() == 'purchase_return/index') || ($this->uri->uri_string() == 'purchase_return') || ($this->router->class == 'purchase_return' && $this->router->method == 'po_edit') || ($this->router->class == 'purchase_return' && $this->router->method == 'view')) {
                    // $bread = 'Purchase';
                    $title = 'Purchase';
                    $sub_title = 'Purchase Return';
                }
# Purchase Receipt
                if (($this->uri->uri_string() == 'purchase_receipt') || ($this->uri->uri_string() == 'purchase_receipt/receipt_list') || ($this->uri->uri_string() == 'purchase_receipt') || ($this->router->class == 'purchase_receipt' && $this->router->method == 'manage_receipt') || ($this->router->class == 'purchase_receipt' && $this->router->method == 'view_receipt')) {
                    // $bread = 'Purchase';
                    $title = 'Purchase';
                    $sub_title = 'Purchase Receipt';
                }
# Stock
                if (($this->uri->uri_string() == 'stock') || ($this->uri->uri_string() == 'stock/index') || ($this->uri->uri_string() == 'stock/index') || ($this->router->class == 'stock' && $this->router->method == 'stock/index') || ($this->router->class == 'stock' && $this->router->method == 'stock_view')) {
                    //$bread = 'Home';
                    $title = 'Stock';
                    $sub_title = 'Stock';
                }
# Death Stock
                if (($this->uri->uri_string() == 'stock/death_stock') || ($this->uri->uri_string() == 'stock/death_stock/add')) {
                    //$bread = 'Home';
                    $title = 'Stock';
                    $sub_title = 'Dead Stock';
                }
# Job
                if (($this->uri->uri_string() == 'project_cost') || ($this->uri->uri_string() == 'project_cost/project_cost_list') || ($this->uri->uri_string() == 'purchase_receipt') || ($this->router->class == 'project_cost' && $this->router->method == 'quotation_edit') || ($this->router->class == 'project_cost' && $this->router->method == 'invoice_edit') || ($this->router->class == 'project_cost' && $this->router->method == 'invoice_view') || ($this->router->class == 'project_cost' && $this->router->method == 'quotation_view')) {
                    //$bread = 'Sales';
                    $title = 'Project';
                    $sub_title = 'Project';
                }
# Sales Return
                if (($this->uri->uri_string() == 'sales_return') || ($this->uri->uri_string() == 'sales_return/index') || ($this->uri->uri_string() == 'sales_return') || ($this->router->class == 'sales_return' && $this->router->method == 'po_edit') || ($this->router->class == 'sales_return' && $this->router->method == 'view')) {
                    //$bread = 'Sales';
                    $title = 'Sales Return';
                    $sub_title = 'Sales Return';
                }
# Sales Receipt
                if (($this->uri->uri_string() == 'receipt') || ($this->uri->uri_string() == 'receipt/receipt_list') || ($this->uri->uri_string() == 'receipt') || ($this->router->class == 'receipt' && $this->router->method == 'manage_receipt') || ($this->router->class == 'receipt' && $this->router->method == 'view_receipt')) {
                    //$bread = 'Sales';
                    $title = 'Sales Receipt';
                    $sub_title = 'Sales Receipt';
                }
# Service and Repair
                if (($this->uri->uri_string() == 'service') || ($this->uri->uri_string() == 'service/service_list') || ($this->uri->uri_string() == 'service/paid_service_add') || ($this->uri->uri_string() == 'service/project_cost_warranty_service') || ($this->uri->uri_string() == 'service/project_cost_add') || ($this->router->class == 'service' && $this->router->method == 'project_cost_update') || ($this->router->class == 'service' && $this->router->method == 'project_cost_warranty_service') || ($this->router->class == 'service' && $this->router->method == 'service_view')) {
                    //$bread = 'Home';
                    $title = 'Service and Repair';
                    $sub_title = 'Service and Repair';
                }
# Service Inward and Outward Dc
                if (($this->uri->uri_string() == 'service_inward_and_outward_dc') || ($this->uri->uri_string() == 'service_inward_and_outward_dc/index') || ($this->uri->uri_string() == 'service_inward_and_outward_dc/add') || ($this->uri->uri_string() == 'service/project_cost_warranty_service') || ($this->router->class == 'service_inward_and_outward_dc' && $this->router->method == 'add_inward_dc') || ($this->router->class == 'service_inward_and_outward_dc' && $this->router->method == 'add_outward_dc') || ($this->router->class == 'service_inward_and_outward_dc' && $this->router->method == 'list')) {
                    //$bread = 'Home';
                    $title = 'Service Inward and Outward DC';
                    $sub_title = 'Service Inward and Outward DC';
                }
# Reports
                if ($this->uri->uri_string() == 'report') {
                    //$bread = 'Home';
                    $title = 'Reports';
                    $sub_title = 'Reports';
                    $menu_trigger = 'pcoded-trigger';
                } else if ($this->uri->uri_string() == 'report/quotation_report') {
                    //$bread = 'Reports';
                    $title = 'Reports';
                    $sub_title = 'Quotation Report';
                    $menu_trigger = 'pcoded-trigger';
                } else if ($this->uri->uri_string() == 'report/grn_report') {
                    //$bread = 'Reports';
                    $title = 'Reports';
                    $sub_title = 'GRN Report';
                    $menu_trigger = 'pcoded-trigger';
                } else if ($this->uri->uri_string() == 'report/purchase_report') {
                    //$bread = 'Reports';
                    $title = 'Reports';
                    $sub_title = 'Purchase Report';
                    $menu_trigger = 'pcoded-trigger';
                } else if ($this->uri->uri_string() == 'report/purchase_receipt') {
                    //$bread = 'Reports';
                    $title = 'Reports';
                    $sub_title = 'Purchase Payment Report';
                    $menu_trigger = 'pcoded-trigger';
                } else if ($this->uri->uri_string() == 'report/stock_report') {
                    //$bread = 'Reports';
                    $title = 'Reports';
                    $sub_title = 'Stock Report';
                    $menu_trigger = 'pcoded-trigger';
                } else if ($this->uri->uri_string() == 'report/pc_report') {
                    //$bread = 'Reports';
                    $title = 'Reports';
                    $sub_title = 'PC Report';
                    $menu_trigger = 'pcoded-trigger';
                } else if ($this->uri->uri_string() == 'report/invoice_report') {
                    //$bread = 'Reports';
                    $title = 'Reports';
                    $sub_title = 'Invoice Report';
                    $menu_trigger = 'pcoded-trigger';
                } else if ($this->uri->uri_string() == 'report/gst_return_report') {
                    //$bread = 'Reports';
                    $title = 'Reports';
                    $sub_title = 'GST Return Report';
                    $menu_trigger = 'pcoded-trigger';
                } else if ($this->uri->uri_string() == 'report/profit_list') {
                    //$bread = 'Reports';
                    $title = 'Reports';
                    $sub_title = 'Profit and Loss Report';
                    $menu_trigger = 'pcoded-trigger';
                } else if ($this->uri->uri_string() == 'report/conversion_list') {
                    //$bread = 'Reports';
                    $title = 'Reports';
                    $sub_title = 'Quotation Vs Project Conversion Ratio';
                    $menu_trigger = 'pcoded-trigger';
                } else if ($this->uri->uri_string() == 'report/customer_report') {
                    //$bread = 'Reports';
                    $title = 'Reports';
                    $sub_title = 'Active Customer Report';
                    $menu_trigger = 'pcoded-trigger';
                } else if ($this->uri->uri_string() == 'report/employee_report') {
                    //$bread = 'Reports';
                    $title = 'Reports';
                    $sub_title = 'Active Employee Report';
                    $menu_trigger = 'pcoded-trigger';
                } else if ($this->uri->uri_string() == 'report/outstanding_report') {
                    //$bread = 'Reports';
                    $title = 'Reports';
                    $sub_title = 'Payment Outstanding Report';
                    $menu_trigger = 'pcoded-trigger';
                } else if ($this->uri->uri_string() == 'report/service_ratio_report') {
                    // $bread = 'Reports';
                    $title = 'Reports';
                    $sub_title = 'Service vs Completed Service Ratio';
                    $menu_trigger = 'pcoded-trigger';
                } else if ($this->uri->uri_string() == 'report/monthly_attendance_report') {
                    //$bread = 'Reports';
                    $title = 'Reports';
                    $sub_title = 'Monthly Attendance Report';
                    $menu_trigger = 'pcoded-trigger';
                } else if ($this->uri->uri_string() == 'report/daily_cash_book_report') {
                    // $bread = 'Reports';
                    $title = 'Reports';
                    $sub_title = 'Cash Book Report';
                    $menu_trigger = 'pcoded-trigger';
                } else if ($this->uri->uri_string() == 'report/service_material_report') {
                    // $bread = 'Reports';
                    $title = 'Reports';
                    $sub_title = 'Service Material Report';
                    $menu_trigger = 'pcoded-trigger';
                }

# Goods Receive Note
                if (($this->uri->uri_string() == 'grn') || ($this->uri->uri_string() == 'grn/grn_list') || ($this->uri->uri_string() == 'grn') || ($this->router->class == 'grn' && $this->router->method == 'grn_edit') || ($this->router->class == 'grn' && $this->router->method == 'grn_view') || ($this->router->class == 'grn' && $this->router->method == 'view_barcode')) {
                    //$bread = 'Home';
                    $title = 'Goods Receive Note';
                    $sub_title = 'Goods Receive Note';
                }
# To do List
                if (($this->uri->uri_string() == 'to_do_list') || ($this->uri->uri_string() == 'to_do_list/grn_list') || ($this->uri->uri_string() == 'to_do_list')) {
                    //$bread = 'Home';
                    $title = 'To do List';
                    $sub_title = 'To do List';
                }
# Expense
                if (($this->uri->uri_string() == 'expense') || ($this->uri->uri_string() == 'expense/expense') || ($this->router->class == 'expense' && $this->router->method == 'edit')) {
                    //$bread = 'Expense';
                    $title = 'Spending';
                    $sub_title = 'Spending';
                    $menu_trigger = 'pcoded-trigger';
                }
# Company Amount
                if (($this->uri->uri_string() == 'expense/company_amount')) {
                    //$bread = 'Home';
                    $title = 'Spending';
                    $sub_title = 'Petty Cash Amount';
                    $menu_trigger = 'pcoded-trigger';
                }
# Balance Sheet
                if (($this->uri->uri_string() == 'expense/balance_sheet')) {
                    //$bread = 'Home';
                    $title = 'Spending';
                    $sub_title = 'Balance Sheet Report';
                    $menu_trigger = 'pcoded-trigger';
                }
# Attendance
                if (($this->uri->uri_string() == 'attendance')) {
                    //$bread = 'Home';
                    $title = 'Attendance';
                    $sub_title = 'Attendance';
                }
                ?>
                <div class="pcoded-main-container">
                    <div class="pcoded-wrapper">
                        <nav class="pcoded-navbar">
                            <div class="sidebar_toggle"><a href="#"><i class="icon-close icons"></i></a></div>
                            <div class="pcoded-inner-navbar main-menu">
                                <div class="">
                                    <div class="main-menu-header">
                                        <?php
                                        $exists = file_exists(FCPATH . 'admin_image/original/' . $this->user_auth->get_from_session('profile_image'));
                                        $f_name = $this->user_auth->get_from_session('profile_image');
                                        $logo_image = (!empty($f_name) && $exists) ? $f_name : "admin_icon.png";
                                        ?>
                                        <img  class="img-80 img-radius" src="<?php echo $this->config->item("base_url") . 'admin_image/original/' . $logo_image; ?>" width="60px" height="60px;"/>
                                        <div class="user-details">
                                            <span id="more-details"><?php echo ucfirst($user_info[0]['username']) ?><i class="fa fa-caret-down"></i></span>
                                        </div>
                                    </div>

                                    <div class="main-menu-content">
                                        <ul>
                                            <li class="more-details">
                                                <a href="<?php echo $this->config->item('base_url') . 'admin/update_profile' ?>"><i class="ti-user"></i>View Profile</a>
                                                <a href="<?php echo $this->config->item('base_url') . 'admin/logout' ?>"><i class="ti-layout-sidebar-left"></i>Logout</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- <div class="pcoded-navigation-label">Dashboard</div>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="<?php echo ($cur_class == 'admin') ? 'active' : '' ?>">
                                        <a href="<?php echo $this->config->item('base_url') . 'admin/' ?>" class="waves-effect waves-dark">
                                            <span class="pcoded-micon"><i class="ti-home"></i><b>D</b></span>
                                            <span class="pcoded-mtext">Dashboard</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                    </li>
                                </ul> -->
                                <div class="pcoded-navigation-label">Masters</div>
                                <ul class="pcoded-item pcoded-left-item">
                                    <li class="pcoded-hasmenu <?php echo $menu_trigger; ?> <?= ($cur_class == 'users' || $cur_class == 'master_colour' || $cur_class == 'product' || $cur_class == 'master_size' || $cur_class == 'item_code' || $cur_class == 'master_style_type' || $cur_class == 'master_fit' || $cur_class == 'vendor' || $cur_class == 'agent' || $cur_class == 'customer' || $cur_class == 'master_brand' || $cur_class == 'master_category' || $cur_class == 'master_transport' || $cur_class == 'email' || $cur_class == 'advertisement' || $cur_class == 'expense_category' && $cur_method == 'fixed_expense' && $cur_method == 'variable_expense' || $cur_class == 'manage_links' ) ? 'active' : '' ?>">
                                        <a href="javascript:void(0)" class="waves-effect waves-dark">
                                            <span class="pcoded-micon "><i class="ti-dashboard"></i><b>M</b></span>
                                            <span class="pcoded-mtext">Masters</span>
                                            <span class="pcoded-mcaret"></span>
                                        </a>
                                        <ul class="pcoded-submenu">
                                            <!-- <?php if ($this->user_auth->is_section_allowed('masters', 'vendor')): ?>
                                                <li class="<?php echo ($cur_class == 'vendor') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'vendor/index' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Vendor</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            <?php endif; ?> -->
                                            <!-- <?php if ($this->user_auth->is_section_allowed('masters', 'customer')): ?>
                                                <li class="<?php echo ($cur_class == 'customer') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'customer/index' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Customer</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            <?php endif; ?> -->
                                            <?php if (($user_info[0]['role'] != 2)) { ?>
                                                <?php if ($this->user_auth->is_section_allowed('masters', 'user_roles')): ?>
                                                    <li class="<?php echo ($cur_class == 'user_roles') ? 'active' : '' ?>">
                                                        <a href="<?php echo $this->config->item('base_url') . 'masters/user_roles' ?>" class="waves-effect waves-dark">
                                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                            <span class="pcoded-mtext">User Role</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if ($this->user_auth->is_section_allowed('masters', 'users')): ?>
                                                    <li class="<?php echo ($cur_class == 'users') ? 'active' : '' ?>">
                                                        <a href="<?php echo $this->config->item('base_url') . 'users/index' ?>" class="waves-effect waves-dark">
                                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                            <span class="pcoded-mtext">User</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php } ?>
                                            <!-- <?php if ($this->user_auth->is_section_allowed('masters', 'product')): ?>
                                                <li class="<?php echo ($cur_class == 'product') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'product/index' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Products</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            <?php endif; ?> -->
                                            <?php if ($this->user_auth->is_section_allowed('masters', 'master_category')): ?>
                                                <li class="<?php echo ($cur_class == 'master_category') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'master_category/index' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Category</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <!-- <?php if ($this->user_auth->is_section_allowed('masters', 'master_brand')): ?>
                                                <li class="<?php echo ($cur_class == 'master_brand') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'master_brand/index' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Brand</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            <?php endif; ?> -->
                                            <!-- <?php if (($user_info[0]['role'] != 2)) { ?>
                                                <?php if ($this->user_auth->is_section_allowed('masters', 'email')): ?>
                                                    <li class="<?php echo ($cur_class == 'email') ? 'active' : '' ?>">
                                                        <a href="<?php echo $this->config->item('base_url') . 'email/index' ?>" class="waves-effect waves-dark">
                                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                            <span class="pcoded-mtext">Email Settings</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php } ?> -->
                                            <?php if ($this->user_auth->is_section_allowed('masters', 'advertisement')): ?>
                                                <li class="<?php echo ($cur_class == 'advertisement') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'advertisement' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Manage Ads</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if ($this->user_auth->is_section_allowed('masters', 'manage_links')): ?>
                                                <li class="<?php echo ($cur_class == 'manage_links') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'manage_links' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Manage Links</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <!-- <?php if ($this->user_auth->is_section_allowed('masters', 'expense_category')): ?>
                                                <li class="<?php echo ($cur_class == 'expense_category') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'masters/expense_category' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Spending Category</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            <?php endif; ?> -->
                                            <!-- <?php if ($this->user_auth->is_section_allowed('masters', 'db_backup')): ?>
                                                <li class="<?php echo ($cur_class == 'back_up') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'admin/back_up' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">DB Backup</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            <?php endif; ?> -->
                                        </ul>
                                    </li>
                                </ul>
                                <?php if ($this->user_auth->is_section_allowed('enquiry', 'enquiry')): ?>
                                    <div class="pcoded-navigation-label">Leads</div>
                                    <ul class="pcoded-item pcoded-left-item">
                                        <li class="<?php echo ($cur_class == 'enquiry') ? 'active' : '' ?>">
                                            <a href="<?php echo $this->config->item('base_url') . 'enquiry/enquiry_list' ?>" class="waves-effect waves-dark">
                                                <span class="pcoded-micon"><i class="ti-list-ol"></i><b>L</b></span>
                                                <span class="pcoded-mtext">Leads</span>
                                                <?php if ($pending_leads_count != 0) { ?>
                                                    <span class="label label-rounded label-info pull-right pcount"  data-toggle="tooltip" data-placement="left" data-original-title="All Followup Count"><?php echo $pending_leads_count; ?></span>
                                                <?php } ?>
                                                <span class="pcoded-mcaret"></span>
                                            </a>
                                        </li>
                                    </ul>
                                <?php endif; ?>

                                <!-- <?php if ($user_info[0]['role'] != 5) { ?>
                                    <?php if ($user_info[0]['role'] != 4) { ?>
                                        <?php if ($this->user_auth->is_section_allowed('quotation', 'quotation')): ?>
                                            <div class="pcoded-navigation-label">Quotation</div>
                                            <ul class="pcoded-item pcoded-left-item">
                                                <li class="<?php echo ($cur_class == 'quotation') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'quotation/quotation_list' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-zip"></i><b>Q</b></span>
                                                        <span class="pcoded-mtext">Quotation</span>
                                                        <?php if ($pending_quotation_count != 0) { ?>
                                                            <span class="label label-rounded label-info pull-right pcount"  data-toggle="tooltip" data-placement="left" data-original-title="Pending Count"><?php echo $pending_quotation_count; ?></span>
                                                        <?php } ?>
                                                        </span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        <?php endif; ?> -->
                                        <!-- <?php if ($user_info[0]['role'] != 3) { ?>
                                            <div class="pcoded-navigation-label">Purchase</div>
                                            <ul class="pcoded-item pcoded-left-item">
                                                <?php if ($this->user_auth->is_section_allowed('purchase_order', 'purchase_order')): ?>
                                                    <li class="<?php echo ($cur_class == 'purchase_order') ? 'active' : '' ?>">
                                                        <a href="<?php echo $this->config->item('base_url') . 'purchase_order/purchase_order_list' ?>" class="waves-effect waves-dark">
                                                            <span class="pcoded-micon"><i class="ti-shopping-cart"></i><b>PO</b></span>
                                                            <span class="pcoded-mtext">Purchase</span>
                                                            <?php if ($pending_delivery_po_count != 0) { ?>
                                                                <span class="label label-rounded label-info pull-right pcount"  data-toggle="tooltip" data-placement="left" data-original-title="Pending Count"><?php echo $pending_delivery_po_count; ?>
                                                                <?php } ?></span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if ($this->user_auth->is_section_allowed('goods_receive_note', 'goods_receive_note')): ?>
                                                    <li class="<?= ($cur_class == 'grn') ? 'active' : '' ?>">
                                                        <a href="<?php echo $this->config->item('base_url') . 'grn/grn_list' ?>" class="waves-effect waves-dark">
                                                            <span class="pcoded-micon"><i class="ti-agenda"></i><b>GRN</b></span>
                                                            <span class="pcoded-mtext">Goods Receive Note</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if ($this->user_auth->is_section_allowed('purchase_return', 'purchase_return')): ?>
                                                    <li class="<?php echo ($cur_class == 'purchase_return') ? 'active' : '' ?>">
                                                        <a href="<?php echo $this->config->item('base_url') . 'purchase_return/index' ?>" class="waves-effect waves-dark">
                                                            <span class="pcoded-micon"><i class="ti-shift-left"></i><b>PR</b></span>
                                                            <span class="pcoded-mtext">Purchase Return</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                                <?php if ($this->user_auth->is_section_allowed('purchase_receipt', 'purchase_receipt')): ?>
                                                    <li class="<?php echo ($cur_class == 'purchase_receipt') ? 'active' : '' ?>">
                                                        <a href="<?php echo $this->config->item('base_url') . 'purchase_receipt/receipt_list' ?>"  class="waves-effect waves-dark">
                                                            <span class="pcoded-micon"><i class="ti-receipt"></i><b>PR</b></span>
                                                            <span class="pcoded-mtext">Purchase Receipt</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        <?php } ?> -->
                                        <!-- <?php if ($this->user_auth->is_section_allowed('stock', 'stock')): ?>
                                            <div class="pcoded-navigation-label">Stock</div>
                                            <ul class="pcoded-item pcoded-left-item">
                                                <li class="<?php echo ($cur_class == 'stock') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'stock/' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-shopping-cart-full"></i><b>S</b></span>
                                                        <span class="pcoded-mtext">Stock
                                                            <?php // if (count($stock_count) != 0) {      ?></span>
                                                            <span class="label label-rounded label-info pull-right pcount"  data-toggle="tooltip" data-placement="left" data-original-title="Pending Count"><?php //echo count($stock_count);?></span>
                                                        <?php // }    ?>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li> -->
                                                <!-- <li class="<?php echo ($cur_class == 'death_stock') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'stock/death_stock' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-shopping-cart-full"></i><b>S</b></span>
                                                        <span class="pcoded-mtext">Dead Stock
                                                            <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            </ul>
                                        <?php endif; ?>
                                    <?php } ?> -->
<!-- 
                                    <div class="pcoded-navigation-label">Sales</div>
                                    <ul class="pcoded-item pcoded-left-item">
                                        <?php if ($this->user_auth->is_section_allowed('project_cost', 'project_cost')): ?>
                                            <li class="<?php echo ($cur_class == 'project_cost') ? 'active' : '' ?>">
                                                <a href="<?php echo $this->config->item('base_url') . 'project_cost/project_cost_list' ?>" class="waves-effect waves-dark">
                                                    <span class="pcoded-micon"><i class="ti-export"></i><b>J</b></span>
                                                    <span class="pcoded-mtext">Project</span>
                                                    <?php if ($quotation_count != 0) { ?>
                                                        <span class="label label-rounded label-info pull-right pcount"  data-toggle="tooltip" data-placement="left" data-original-title="Pending Count"><?php echo $quotation_count; ?></span>
                                                    <?php } ?>
                                                    <span class="pcoded-mcaret"></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if ($user_info[0]['role'] != 4) { ?>
                                            <?php if ($this->user_auth->is_section_allowed('sales_return', 'sales_return')): ?>
                                                <li class="<?php echo ($cur_class == 'sales_return') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'sales_return/' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-share-alt"></i><b>SR</b></span>
                                                        <span class="pcoded-mtext">Sales Return</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>

                                            <?php if ($user_info[0]['role'] != 3) { ?>
                                                <?php if ($this->user_auth->is_section_allowed('receipt', 'receipt')): ?>
                                                    <li class="<?php echo ($cur_class == 'receipt') ? 'active' : '' ?>">
                                                        <a href="<?php echo $this->config->item('base_url') . 'receipt/receipt_list' ?>" class="waves-effect waves-dark">
                                                            <span class="pcoded-micon"><i class="ti-money"></i><b>R</b></span>
                                                            <span class="pcoded-mtext">Receipt</span>
                                                            <?php if ($pending_receipt_count != 0) { ?>
                                                                <span class="label label-rounded label-info pull-right pcount"  data-toggle="tooltip" data-placement="left" data-original-title="Pending Count"><?php echo $pending_receipt_count; ?></span>
                                                            <?php } ?>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                    </li>
                                                <?php endif; ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </ul> -->
                                    <?php if ($this->user_auth->is_section_allowed('service', 'service')): ?>
                                        <div class="pcoded-navigation-label">Services</div>
                                        <ul class="pcoded-item pcoded-left-item">
                                            <!-- <li class="<?php echo ($cur_class == 'service') ? 'active' : '' ?>">
                                                <a href="<?php echo $this->config->item('base_url') . 'service/service_list' ?>" class="waves-effect waves-dark">
                                                    <span class="pcoded-micon"><i class="ti-share"></i><b>SR</b></span>
                                                    <span class="pcoded-mtext">Service and Repair</span>
                                                    <span class="pcoded-mcaret"></span>
                                                </a>
                                            </li> -->
                                            <?php if ($this->user_auth->is_module_allowed('services')): ?>
                                                <li class="<?php echo ($cur_class == 'to_do_service') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'service/to_do_service' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-check-box"></i><b>S</b></span>
                                                        <span class="pcoded-mtext">Services
                                                            <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                    <?php endif; ?>
                                    <!-- <?php if ($this->user_auth->is_section_allowed('service_inward_and_outward_dc', 'service_inward_and_outward_dc')): ?>
                                        <div class="pcoded-navigation-label">Service Inward and Outward DC</div>
                                        <ul class="pcoded-item pcoded-left-item">
                                            <li class="<?php echo ($cur_class == 'service_inward_and_outward_dc') ? 'active' : '' ?>">
                                                <a href="<?php echo $this->config->item('base_url') . 'service_inward_and_outward_dc' ?>" class="waves-effect waves-dark">
                                                    <span class="pcoded-micon"><i class="ti-share"></i><b>IODC</b></span>
                                                    <span class="pcoded-mtext">Inward and Outward DC</span>
                                                    <span class="pcoded-mcaret"></span>
                                                </a>
                                            </li>
                                        </ul>
                                    <?php endif; ?> -->
                                    <?php if ($this->user_auth->is_section_allowed('to_do_list', 'to_do_list')): ?>
                                        <div class="pcoded-navigation-label">To do List</div>
                                        <ul class="pcoded-item pcoded-left-item">
                                            <li class="<?php echo ($cur_class == 'to_do_list') ? 'active' : '' ?>">
                                                <a href="<?php echo $this->config->item('base_url') . 'to_do_list' ?>" class="waves-effect waves-dark">
                                                    <span class="pcoded-micon"><i class="ti-share"></i><b>SR</b></span>
                                                    <span class="pcoded-mtext">To do List</span>
                                                    <span class="pcoded-mcaret"></span>
                                                </a>
                                            </li>
                                        </ul>
                                    <?php endif; ?>
                                    <!-- <?php if ($this->user_auth->is_module_allowed('attendance', 'attendance')): ?>
                                        <div class="pcoded-navigation-label">Attendance</div>
                                    <?php endif; ?>
                                    <ul class="pcoded-item pcoded-left-item">
                                        <?php if ($this->user_auth->is_section_allowed('attendance', 'attendance')): ?>
                                            <li class="<?php echo ($cur_class == 'attendance') ? 'active' : '' ?>">
                                                <a href="<?php echo $this->config->item('base_url') . 'attendance' ?>" class="waves-effect waves-dark">
                                                    <span class="pcoded-micon"><i class="ti-angle-right"></i><b>Attendance</b></span>
                                                    <span class="pcoded-mtext">Attendance</span>
                                                    <span class="pcoded-mcaret"></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    </ul> -->
                                    <!-- <?php if ($this->user_auth->is_module_allowed('expense', 'expense')): ?>
                                        <div class="pcoded-navigation-label">Spending</div>
                                        <ul class="pcoded-item pcoded-left-item">
                                            <li class="pcoded-hasmenu <?php echo $menu_trigger; ?> <?= ($cur_class == 'expense') ? 'active' : '' ?>">
                                                <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                    <span class="pcoded-micon "><i class="ti-money"></i><b>E</b></span>
                                                    <span class="pcoded-mtext">Spending</span>
                                                    <span class="pcoded-mcaret"></span>
                                                </a>
                                                <ul class="pcoded-submenu">
                                                    <?php if ($this->user_auth->is_section_allowed('expense', 'expense')): ?>
                                                        <li class="<?php echo ($cur_class == 'expense') ? 'active' : '' ?>">
                                                            <a href="<?php echo $this->config->item('base_url') . 'expense' ?>" class="waves-effect waves-dark">
                                                                <span class="pcoded-micon"><i class="ti-angle-right"></i><b>SR</b></span>
                                                                <span class="pcoded-mtext">Spending</span>
                                                                <span class="pcoded-mcaret"></span>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if ($this->user_auth->is_section_allowed('expense', 'company_amount')): ?>
                                                        <li class="<?php echo ($cur_method == 'company_amount') ? 'active' : '' ?>">
                                                            <a href="<?php echo $this->config->item('base_url') . 'expense/company_amount' ?>" class="waves-effect waves-dark">
                                                                <span class="pcoded-micon"><i class="ti-angle-right"></i><b>CA</b></span>
                                                                <span class="pcoded-mtext">Petty Cash Amount</span>
                                                                <span class="pcoded-mcaret"></span>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if ($this->user_auth->is_section_allowed('expense', 'daily_cash_book_report')): ?>
                                                        <li class="<?php echo ($cur_method == 'daily_cash_book_report') ? 'active' : '' ?>">
                                                            <a href="<?php echo $this->config->item('base_url') . 'report/daily_cash_book_report' ?>" class="waves-effect waves-dark">
                                                                <span class="pcoded-micon"><i class="ti-angle-right"></i><b>Cash Book Report</b></span>
                                                                <span class="pcoded-mtext">Cash Book Report</span>
                                                                <span class="pcoded-mcaret"></span>
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </li>
                                        </ul>
                                    <?php endif; ?> -->

                                    <!-- <?php if ($this->user_auth->is_module_allowed('report')): ?>
                                        <div class="pcoded-navigation-label">Reports</div>
                                        <ul class="pcoded-item pcoded-left-item">
                                            <li class="pcoded-hasmenu <?php echo $menu_trigger; ?> <?php echo ($cur_class == 'report') ? 'active' : '' ?>">
                                                <a href="javascript:void(0)" class="waves-effect waves-dark">
                                                    <span class="pcoded-micon"><i class="ti-list"></i><b>R</b></span>
                                                    <span class="pcoded-mtext">Reports</span>
                                                    <span class="pcoded-mcaret"></span>
                                                </a>
                                                <ul class="pcoded-submenu">
                                                    <?php if ($user_info[0]['role'] != 4) { ?>
                                                        <?php if ($user_info[0]['role'] != 3) { ?>
                                                            <li class="<?= ($cur_method == 'quotation_report') ? 'active' : '' ?>">
                                                                <a href="<?php echo $this->config->item('base_url') . 'report/quotation_report' ?>" class="waves-effect waves-dark">
                                                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                                    <span class="pcoded-mtext">Quotation Report</span>
                                                                    <span class="pcoded-mcaret"></span>
                                                                </a>
                                                            </li>
                                                            <li class="<?= ($cur_method == 'purchase_report') ? 'active' : '' ?>">
                                                                <a href="<?php echo $this->config->item('base_url') . 'report/purchase_report' ?>" class="waves-effect waves-dark">
                                                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                                    <span class="pcoded-mtext">Purchase Report</span>
                                                                    <span class="pcoded-mcaret"></span>
                                                                </a>
                                                            </li>
                                                            <li class="<?php echo ($cur_method == 'grn_report') ? 'active' : '' ?>">
                                                                <a href="<?php echo $this->config->item('base_url') . 'report/grn_report' ?>" class="waves-effect waves-dark">
                                                                    <span class="pcoded-micon"><i class="ti-angle-right"></i><b>GRN Report</b></span>
                                                                    <span class="pcoded-mtext">GRN Report</span>
                                                                    <span class="pcoded-mcaret"></span>
                                                                </a>
                                                            </li>
                                                            <li class="<?= ($cur_method == 'purchase_receipt') ? 'active' : '' ?>">
                                                                <a href="<?php echo $this->config->item('base_url') . 'report/purchase_receipt' ?>" class="waves-effect waves-dark">
                                                                    <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                                    <span class="pcoded-mtext">Purchase Payment Report</span>
                                                                    <span class="pcoded-mcaret"></span>
                                                                </a>
                                                            </li>
                                                        <?php } ?>
                                                        <li class="<?= ($cur_method == 'stock_report') ? 'active' : '' ?>">
                                                            <a href="<?php echo $this->config->item('base_url') . 'report/stock_report' ?>" class="waves-effect waves-dark">
                                                                <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                                <span class="pcoded-mtext">Stock Report</span>
                                                                <span class="pcoded-mcaret"></span>
                                                            </a>
                                                        </li>
                                                        <?php if ($user_info[0]['role'] != 3) { ?>                                                                                                                </a>
                                                    </li>
                                                    <li class="<?= ($cur_method == 'invoice_report') ? 'active' : '' ?>">
                                                        <a href="<?php echo $this->config->item('base_url') . 'report/invoice_report' ?>" class="waves-effect waves-dark">
                                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                            <span class="pcoded-mtext">Invoice Report</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if ($user_info[0]['role'] != 4) { ?>
                                                <?php if ($user_info[0]['role'] != 3) { ?>
                                                    <li class="<?= ($cur_method == 'profit_list') ? 'active' : '' ?>">
                                                        <a href="<?php echo $this->config->item('base_url') . 'report/profit_list' ?>" class="waves-effect waves-dark">
                                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                            <span class="pcoded-mtext">Profit and Loss Report</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                    </li>
                                                    <li class="<?= ($cur_method == 'conversion_list') ? 'active' : '' ?>">
                                                        <a href="<?php echo $this->config->item('base_url') . 'report/conversion_list' ?>" class="waves-effect waves-dark">
                                                            <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                            <span class="pcoded-mtext">Quotation Vs Project Conversion ratio</span>
                                                            <span class="pcoded-mcaret"></span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if ($this->user_auth->is_section_allowed('report', 'outstanding_report')): ?>
                                                <li class="<?php echo ($cur_method == 'outstanding_report') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'report/outstanding_report' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i><b>Payment Outstanding Report</b></span>
                                                        <span class="pcoded-mtext">Payment Outstanding Report</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if ($this->user_auth->is_section_allowed('report', 'customer_report')): ?>
                                                <li class="<?php echo ($cur_method == 'customer_report') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'report/customer_report' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i><b>Active Customer Report</b></span>
                                                        <span class="pcoded-mtext">Active Customer Report</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if ($this->user_auth->is_section_allowed('report', 'employee_report')): ?>
                                                <li class="<?php echo ($cur_method == 'employee_report') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'report/employee_report' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i><b>Active Employee Report</b></span>
                                                        <span class="pcoded-mtext">Active Employee Report</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if ($this->user_auth->is_section_allowed('report', 'monthly_attendance_report')): ?>
                                                <li class="<?php echo ($cur_method == 'monthly_attendance_report') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'report/monthly_attendance_report' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i><b>Monthly attendance Report</b></span>
                                                        <span class="pcoded-mtext">Monthly attendance Report</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if ($this->user_auth->is_section_allowed('report', 'gst_return_report')): ?>
                                                <li class="<?php echo ($cur_method == 'gst_return_report') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'report/gst_return_report' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i><b>GST Return Report</b></span>
                                                        <span class="pcoded-mtext">GST Return Report</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if ($this->user_auth->is_section_allowed('report', 'service_list')): ?>
                                                <li class="<?php echo ($cur_method == 'service_ratio_report') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'report/service_ratio_report' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i><b>Service vs completed service ratio</b></span>
                                                        <span class="pcoded-mtext">Service vs Completed service Ratio</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                            <?php if ($this->user_auth->is_section_allowed('report', 'balance_sheet')): ?>
                                                <li class="<?php echo ($cur_class == 'balance_sheet') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'expense/balance_sheet' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i></span>
                                                        <span class="pcoded-mtext">Balance Sheet Report</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>

                                            <?php if ($this->user_auth->is_section_allowed('report', 'service_material_report')): ?>
                                                <li class="<?php echo ($cur_method == 'service_material_report') ? 'active' : '' ?>">
                                                    <a href="<?php echo $this->config->item('base_url') . 'report/service_material_report' ?>" class="waves-effect waves-dark">
                                                        <span class="pcoded-micon"><i class="ti-angle-right"></i><b>Service Material Report</b></span>
                                                        <span class="pcoded-mtext">Service Material Report</span>
                                                        <span class="pcoded-mcaret"></span>
                                                    </a>
                                                </li>
                                            <?php endif; ?>
                                        </ul>
                                        </li>
                                        </ul>
                                    <?php endif; ?>
                                <?php } ?> -->
                            </div>
                        </nav>
                        <div class="pcoded-content">
                            <!-- Page-header start -->
                            <div class="page-header">
                                <div class="page-block">
                                    <div class="row align-items-center">
                                        <div class="col-md-8">
                                            <div class="page-header-title">
                                                <h5 class="m-b-10"><?php echo $title ?></h5>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item">
                                                    <a href="<?php echo $this->config->item('base_url') . 'admin/' ?>"><i class="fa fa-home"></i> </a>
                                                </li>
                                                <li class="breadcrumb-item remove_symbol_bd"><a href="#!"><?php echo $bread ?></a>
                                                </li>
                                                <li class="breadcrumb-item"><a href="#!" class="sub_title"><?php echo $sub_title ?></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Page-header end -->
                            <div class="pcoded-inner-content">
                                <div class="main-body">
                                    <div class="page-wrapper">
                                        <div class="page-body">
                                            <?php echo $content ?>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <!--<span class="pull-right">-->
                        <div class="col-md-12">
                            <footer class="main-footer">
                                <div class="">
                                    <div class="copyright" id="bot_copyright">

                                        <div class="nvqc-show-hide-log  mt-foot">Copyright <?php echo date('Y'); ?> &COPY; <b><a href='http://www.incsol.net/' target="_blank" style='color:#448aff'>F2F Solutions</a><span class="pull-right">Powered By <a href="http://f2fsolutions.co.in/" target="_blank" style="">F2F Solutions</a></span></div>
                                    </div>
                                </div>
                            </footer>
                        </div>
                        <!--                        <div id="styleSelector">

                                                </div>-->
                    </div>
                </div>
            </div>
        </div>
        <script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
        <script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
        <script type="text/javascript">
                                        $(document).ready(function () {
                                            $(".preloader").fadeOut();
                                            $('input, .form-control').attr('autocomplete', 'off');
                                            $('.mail').on('keyup', function () {
                                                $(this).val($(this).val().toLowerCase());
                                            });
                                            $('form').submit(function () {
                                                $('input:submit').attr("disabled", true);
                                                $('input:submit').val('Please wait Processing');
                                            });
                                        });
                                        var BASE_URL = '<?php echo $this->config->item('base_url');
                                            ?>';

        </script>
        <script>
            $(document).on('keyup click', '.form-material input,textarea ', function (ev) {
                // stuff happens
                //alert("hjdg");
                //if ($(this).val() != "") {
                $(this).parent().find(".float-label").removeClass('newClass1');
                $(this).parent().find(".float-label").addClass('newClass');
                //}

            });
            $(document).on('blur', '.form-material input,textarea ', function (ev) {
                // stuff happens
                //alert("hjdg");
                if ($(this).val() == "") {
                    $(this).parent().find(".float-label").removeClass('newClass');
                    $(this).parent().find(".float-label").addClass('newClass1');

                } else {
                    $(this).parent().find(".float-label").removeClass('newClass1');
                    $(this).parent().find(".float-label").addClass('newClass');
                }
            });
            $(".form-material input,textarea").each(function () {
                if ($(this).val() != "") {
                    $(this).parent().find(".float-label").removeClass('newClass1');
                    $(this).parent().find(".float-label").addClass('newClass');
                } else {
                    $(this).parent().find(".float-label").removeClass('newClass');
                    $(this).parent().find(".float-label").addClass('newClass1');
                }
            });


            $(document).ready(function () {
                $(document).keydown(function (e) {
                    var keycode = e.keyCode;

                    if (e.ctrlKey && keycode == 81) {
                        // (ctrl+ q )
                        document.location.href = '<?php echo base_url() . "quotation/"; ?>';
                    }
                    if (e.ctrlKey && keycode == 82) {
                        // (ctrl+ r )
                        document.location.href = '<?php echo base_url() . "receipt/receipt_list"; ?>';
                    }
                    if (e.ctrlKey && keycode == 73) {
                        e.preventDefault();
                        // (ctrl+ i )
                        document.location.href = '<?php echo base_url() . "project_cost/project_cost_list"; ?>';
                    }
                    if (e.ctrlKey && keycode == 79) {
                        e.preventDefault();
                        // (ctrl+ o )
                        document.location.href = '<?php echo base_url() . "purchase_order/"; ?>';
                    }

                });
            });
        </script>
        <script>
            $('.excel_btn').live('click', function () {
                fnExcelReport();
            });
        </script>
        <script>
            function fnExcelReport()
            {
                var tab_text = "<table border='5px'><tr width='100px' bgcolor='#87AFC6'>";
                var textRange;
                var j = 0;
                tab = document.getElementById('basicTable'); // id of table
                for (j = 0; j < tab.rows.length; j++)
                {
                    tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
                    //tab_text=tab_text+"</tr>";
                }
                tab_text = tab_text + "</table>";
                tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
                tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
                tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params
                var ua = window.navigator.userAgent;
                var msie = ua.indexOf("MSIE ");
                if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
                {
                    txtArea1.document.open("txt/html", "replace");
                    txtArea1.document.write(tab_text);
                    txtArea1.document.close();
                    txtArea1.focus();
                    sa = txtArea1.document.execCommand("SaveAs", true, "Say Thanks to Sumit.xls");
                } else                 //other browser not tested on IE 11
                    sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
                return (sa);
            }
        </script>
        <script>
            $('.sub_title').click(function () {
                var sub_title = $(this).text();
                switch (sub_title)
                {
                    case 'Vendor':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'vendor/index' ?>');
                        break;
                    case 'Customer':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'customer/index' ?>');
                        break;
                    case 'User Roles':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'masters/user_roles' ?>');
                        break;
                    case 'Users':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'users/index' ?>');
                        break;
                    case 'Product':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'product/index' ?>');
                        break;
                    case 'Category':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'master_category/index' ?>');
                        break;
                    case 'Brand':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'master_brand/index' ?>');
                        break;
                    case 'Email Settings':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'email/index' ?>');
                        break;
                    case 'Adverstisment':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'Advertisement' ?>');
                        break;
                    case 'Manage Links':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'manage_links' ?>');
                        break;
                    case 'Spending Category':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'masters/expense_category' ?>');
                        break;
                    case 'Leads':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'enquiry/enquiry_list' ?>');
                        break;
                    case 'Quotation':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'quotation/quotation_list' ?>');
                        break;
                    case 'Purchase Order':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'purchase_order/purchase_order_list' ?>');
                        break;
                    case 'Goods Receive Note':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'grn/grn_list' ?>');
                        break;
                    case 'Purchase Return':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'purchase_return/index' ?>');
                        break;
                    case 'Stock':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'stock' ?>');
                        break;
                    case 'Project':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'project_cost/project_cost_list' ?>');
                        break;
                    case 'Sales Return':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'sales_return' ?>');
                        break;
                    case 'Sales Receipt':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'receipt/receipt_list' ?>');
                        break;
                    case 'Service and Repair':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'service/service_list' ?>');
                        break;
                    case 'Service Inward and Outward DC':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'service_inward_and_outward_dc' ?>');
                        break;
                    case 'To do List':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'to_do_list' ?>');
                        break;
                    case 'Attendance':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'attendance' ?>');
                        break;
                    case 'Spending':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'expense' ?>');
                        break;
                    case 'Petty Cash Amount':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'expense/company_amount' ?>');
                        break;
                    case 'Balance Sheet Report':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'expense/balance_sheet' ?>');
                        break;
                    case 'Quotation Report':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'report/quotation_report' ?>');
                        break;
                    case 'Purchase Report':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'report/purchase_report' ?>');
                        break;
                    case 'GRN Report':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'report/grn_report' ?>');
                        break;
                    case 'Purchase Payment Report':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'report/purchase_receipt' ?>');
                        break;
                    case 'Stock Report':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'report/stock_report' ?>');
                        break;
                    case 'Invoice Report':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'report/invoice_report' ?>');
                        break;
                    case 'Profit and Loss Report':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'report/profit_list' ?>');
                        break;
                    case 'Quotation Vs Project Conversion Ratio':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'report/conversion_list' ?>');
                        break;
                    case 'Payment Outstanding Report':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'report/outstanding_report' ?>');
                        break;
                    case 'Active Customer Report':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'report/customer_report' ?>');
                        break;
                    case 'Active Employee Report':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'report/employee_report' ?>');
                        break;
                    case 'Monthly Attendance Report':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'report/monthly_attendance_report' ?>');
                        break;
                    case 'GST Return Report':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'report/gst_return_report' ?>');
                        break;
                    case 'Service vs Completed Service Ratio':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'report/service_ratio_report' ?>');
                        break;
                    case 'Cash Book Report':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'report/daily_cash_book_report' ?>');
                        break;
                    case 'Service Material Report':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'report/service_material_report' ?>');
                        break;
                    case 'Purchase Receipt':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'purchase_receipt/receipt_list' ?>');
                        break;
                    case 'Dead Stock':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'stock/death_stock' ?>');
                        break;
                    case 'Dashboard':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'admin/' ?>');
                        break;
                    case 'Services':
                        $(this).attr('href', '<?php echo $this->config->item('base_url') . 'service/to_do_service' ?>');
                        break;
                }
            })
        </script>


        <!-- Required Jquery -->
        <script type="text/javascript" src="<?= $theme_path; ?>/bower_components/jquery/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?= $theme_path; ?>/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?= $theme_path; ?>/bower_components/popper.js/js/popper.min.js"></script>
        <script type="text/javascript" src="<?= $theme_path; ?>/bower_components/bootstrap/js/bootstrap.min.js"></script>
        <!-- waves js -->
        <script src="<?= $theme_path; ?>/assets/pages/waves/js/waves.min.js"></script>
        <!-- jquery slimscroll js -->
        <script type="text/javascript" src="<?= $theme_path; ?>/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
        <!-- modernizr js -->
        <script type="text/javascript" src="<?= $theme_path; ?>/bower_components/modernizr/js/modernizr.js"></script>
        <script type="text/javascript" src="<?= $theme_path; ?>/bower_components/modernizr/js/css-scrollbars.js"></script>
        <script src="<?= $theme_path; ?>/assets/js/pcoded.min.js"></script>
        <script src="<?= $theme_path; ?>/assets/js/vertical/vertical-layout.min.js"></script>
        <script src="<?= $theme_path; ?>/assets/js/jquery.mCustomScrollbar.concat.min.js"></script>

        <script src="<?= $theme_path; ?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="<?= $theme_path; ?>/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="<?= $theme_path; ?>/assets/pages/data-table/js/jszip.min.js"></script>
        <script src="<?= $theme_path; ?>/assets/pages/data-table/js/pdfmake.min.js"></script>
        <script src="<?= $theme_path; ?>/assets/pages/data-table/js/vfs_fonts.js"></script>
        <script src="<?= $theme_path; ?>/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="<?= $theme_path; ?>/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
        <script src="<?= $theme_path; ?>/bower_components/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="<?= $theme_path; ?>/bower_components/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?= $theme_path; ?>/bower_components/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
        <!-- Custom js -->
        <script src="<?= $theme_path; ?>/assets/pages/data-table/js/data-table-custom.js"></script>
        <script type="text/javascript" src="<?= $theme_path; ?>/assets/js/script.js"></script>
    </body>


    <!-- Mirrored from html.phoenixcoded.net/mega-able/default/sample-page.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 01 Oct 2019 04:03:46 GMT -->
</html>
