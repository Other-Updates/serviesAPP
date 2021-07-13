<?php
$theme_path = $this->config->item('theme_locations') . $this->config->item('active_template');
$user_info = $this->user_auth->get_from_session('user_info');
?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<link rel="stylesheet" href="<?= $theme_path; ?>/bower_components/select2/css/select2.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/select2/js/select2.full.min.js"></script>
<div class="mainpanel">
    <div class="contentpanel">
        <div class="row">
            <div class="col-sm-12">
                <div class="tab-header card">
                    <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                        <li class="nav-item col-md-2">
                            <a class="nav-link active" data-toggle="tab" href="#update-user" role="tab">Update Service</a>
                            <div class="slide"></div>
                        </li>
                </div>
                <div class="tab-content">
                    <div class="tab-pane active" id="update-user" role="tabpanel">
                        <div class="card">
                            <div class="card-header">
                                <h5>Update Service</h5>
                            </div>
                            <div class="card-block">
                                <?php
                                if (!empty($edit_service) && isset($edit_service)) {
                                    foreach ($edit_service as $val) {
                                        $selected_array = explode(',', $val['emp_id']);
                                        ?>
                                        <form class="form-material" action="<?php echo $this->config->item('base_url'); ?>service/to_do_service/update_service/<?php echo $val['id']; ?>" method="POST" enctype="multipart/form-data">
                                            <div class="form-material row">
                                                <!-- <div class="col-md-3">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-address-book"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <label class="float-label">Invoice number</label>
                                                            <input type="text" value="<?php echo $val["inv_no"]; ?>" class=" form-control"  readonly tabindex="1"/>
                                                            <span class="form-bar"></span>

                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="col-md-4">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-address-book"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <label class="float-label">Ticket Number</label>
                                                            <input type="text"  class=" form-control" value="<?= $val['ticket_no'] ?>"  tabindex="1" readonly/>
                                                            <span class="form-bar"></span>
                                                            <span id="cuserror1" class="val text-danger"></span>

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-tasks-alt"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <label class="float-label">Description</label>
                                                            <!-- <textarea class="form-control" readonly="" tabindex="1"><?php echo $val['description']; ?></textarea> -->
                                                            <input type="text" class="form-control form-align uppercase_class" id="nick" value="<?= $val['description'] ?>" tabindex="1" />
                                                            <span class="form-bar"></span>
                                                            <span id="nick"  class="val text-danger"></span>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="col-md-3">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-briefcase-alt-1"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <label class="float-label">Warranty</label>
                                                            <input type="text" class=" form-control " value="<?= $val['warrenty'] ?>"  tabindex="1" readonly/>
                                                            <span id="cuserror8" class="val text-danger"></span>
                                                            <span class="form-bar"></span>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="col-md-4">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-notepad"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <select name="status" class="form-control " id="status"  tabindex="1">
                                                                <option value="2" <?php echo ($val['status'] == 2) ? 'selected' : ''; ?>>Pending</option>
                                                                <option value="1" <?php echo ($val['status'] == 1) ? 'selected' : ''; ?>>Completed</option>
                                                                <option value="0" <?php echo ($val['status'] == 0) ? 'selected' : ''; ?>>In-Progress</option>
                                                            </select>
                                                            <span id="cuserror3" class="val text-danger"></span>
                                                            <span class="form-bar"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-material row">
                                                <div class="col-md-4">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-ui-calendar"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <label class="float-label">Service Date</label>
                                                            <!-- <input type="text" class=" form-control"  value="<?= date('m/d/Y', strtotime($val['created_date'])); ?>"  tabindex="1" readonly/> -->
                                                            <input id="dropper-default" class="form-control" name="created_date"  data-date="<?php echo date('d', strtotime($val['created_date'])); ?>" data-month="<?php echo date('m', strtotime($val['created_date'])); ?>" data-formats="<?php echo date('m/d/Y', strtotime($val['created_date'])); ?>" data-year="<?php echo date('Y', strtotime($val['created_date'])); ?>" placeholder="Select your date" value="<?php echo date('d-M-Y', strtotime($val['created_date'])); ?>" />
                                                            <span class="form-bar"></span>
                                                            <span id="date1" class="val text-danger"></span>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!--                                                <div class="col-md-12">
                                                                                                    <div class="row">
                                                                                                        <div class="col-md-12 new-style-form">
                                                                                                            <span class="help-block">Customer Images Upload</span>
                                                                                                        </div>
                                                                                                        <div class="col-md-12">
                                                <?php
                                                if (!empty($service_images) && ($service_images[0]['type'] == "add")) {
                                                    $exists = file_exists($service_images[0]['img_path']);
                                                    $cust_image = (!empty($exists) && isset($exists)) ? $service_images[0]['img_path'] : $this->config->item("base_url") . 'attachement/product/no-img.gif';
                                                } else {
                                                    $cust_image = $this->config->item("base_url") . 'attachement/product/no-img.gif';
                                                }
                                                ?>
                                                                                                            <img id="blah" class="img-40 add_staff_thumbnail" src="<?= $cust_image; ?>"/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>-->
                                                <?php
                                                if ($user_info[0]['role'] == 1 || $user_info[0]['role'] == 2) {
                                                    ?>
                                                    <div class="col-md-4">
                                                        <div class="material-group">
                                                            <div class="material-addone">
                                                                <i class="icofont icofont-ui-user"></i>
                                                            </div>
                                                            <div class="form-group form-primary">
                                                                <select name="emp_id[]" class="form-control required hh" id="emp_id" tabindex="1">
                                                                    <?php
                                                                  
                                                                    if (isset($staff_name) && !empty($staff_name)) {
                                                                        foreach ($staff_name as $vals) {
                                                                            $mark_as_select = (in_array($vals['id'], $selected_array)) ? 'selected' : '';
                                                                            ?>
                                                                            <option value="<?php echo $vals['id'] ?>" <?php echo $mark_as_select; ?> ><?php echo $vals['name'] ?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                                <span class="form-bar"></span>
                                                                <span id="staff_err" class="val text-danger"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <div class="col-md-4">
                                                    <div class="form-group">


                                                        <label >Upload Image</label>
                                                        <input type="file" name="service_image[]" class="wp form-control form-align" id="service_image"   tabindex="1" multiple />

                                                        <span  class="val error_msg text-danger"></span>


                                                    </div>
                                                </div>

                                                <!-- <div class="col-md-3">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-notepad"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <select name="status" class="form-control " id="status"  tabindex="1">
                                                                <option value="2" <?php echo ($val['status'] == 2) ? 'selected' : ''; ?>>Pending</option>
                                                                <option value="1" <?php echo ($val['status'] == 1) ? 'selected' : ''; ?>>Completed</option>
                                                                <option value="0" <?php echo ($val['status'] == 0) ? 'selected' : ''; ?>>In-Progress</option>
                                                            </select>
                                                            <span id="cuserror3" class="val text-danger"></span>
                                                            <span class="form-bar"></span>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                <div class="col-md-12">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-email"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <label class="float-label">Work Performed </label>
                                                            <input type="text" name="work_performed" class="wp form-control form-align" id="wp" value="<?= $val['work_performed']; ?>"  tabindex="1"/>
                                                            <span class="form-bar"></span>
                                                            <span  class="val error_msg text-danger"></span>

                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <div class="pcoded-inner-content">
                                                <div class="">
                                                    <div class="page-wrapper">
                                                        <!-- Page body start -->
                                                        <div class="page-body gallery-page">
                                                            <div class="row">
                                                                <!-- image grid -->
                                                                <div class="col-sm-12">

                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h5>Product Service Image - Employee</h5>
                                                                        </div>
                                                                        <div class="card-block">
                                                                            <div class="row">
                                                                                <?php
                                                                                //print_r($service_images);
                                                                                if (!empty($service_images_employee)) {
                                                                                    foreach ($service_images_employee as $service_images_val) {
                                                                                        ?>

                                                                                        <div class="col-lg-3 col-sm-6">
                                                                                            <div class="thumbnail">
                                                                                                <div class="thumb">
                                                                                                    <a href="#" data-lightbox="1" data-title="My caption 1">
                                                                                                        <img src="<?php echo $service_images_val['img_path']; ?>" alt="" class="img-fluid img-thumbnail">
                                                                                                    </a>
                                                                                                </div>
                                                                                                <span title="Work Performed"><b>Work Performed</b> : <?php echo ($val['work_performed'] != '' ? $val['work_performed'] : '- ');?></span></br>
                                                                                                <span title="Description"><b>Description</b> : <?php echo ($val['description'] != '' ? $val['description'] : '-');?></span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }
                                                                                }
                                                                                 if (!empty($service_history)) {
                                                                                    foreach ($service_history as $history) {
                                                                                        ?>

                                                                                        <div class="col-lg-3 col-sm-6">
                                                                                            <div class="thumbnail">
                                                                                                <div class="thumb">
                                                                                                    <a href="#" data-lightbox="1">
                                                                                                        <img src="<?php echo ($history['emp_image_upload'] != '' ?$history['emp_image_upload'] : $theme_path.'/assets/images/favicon.png'); ?>" alt="" class="img-fluid img-thumbnail">
                                                                                                    </a>
                                                                                                </div>
                                                                                                <span title="Work Performed"><b>Work Performed</b> : <?php echo ($history['work_performed'] != '' ? $history['work_performed'] : '- ');?></span></br>
                                                                                                <span title="Description"><b>Description</b> : <?php echo ($history['description'] != '' ? $history['description'] : '-');?></span>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }
                                                                                } 
                                                                                if(empty($service_images_employee) && empty($service_history)) {
                                                                                    ?>
                                                                                    <div class="col-lg-12 col-sm-6">
                                                                                        No data found
                                                                                    </div>
                                                                                    <?php
                                                                                }
                                                                                ?>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="card">
                                                                        <div class="card-header">
                                                                            <h5>Product Service Image - Customer</h5>
                                                                        </div>
                                                                        <div class="card-block">
                                                                            <div class="row">
                                                                                <?php
                                                                                //print_r($service_images);
                                                                                if (!empty($service_images_customer)) {
                                                                                    foreach ($service_images_customer as $service_images_val) {
                                                                                        ?>

                                                                                        <div class="col-lg-2 col-sm-6">
                                                                                            <div class="thumbnail">
                                                                                                <div class="thumb">
                                                                                                    <a href="#" data-lightbox="1" data-title="My caption 1">
                                                                                                        <img src="<?php echo $service_images_val['img_path']; ?>" alt="" class="img-fluid img-thumbnail">
                                                                                                    </a>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                                                                    }
                                                                                } else {
                                                                                    ?>
                                                                                    <div class="col-lg-12 col-sm-6">
                                                                                        No data found
                                                                                    </div>
                                                                                    <?php
                                                                                }
                                                                                ?>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Image grid card end -->
                                                </div>
                                            </div>




                                            <div class="form-group row text-center m-10">
                                                <div class="col-md-12 text-center">
                                                    <input type="submit" name="submit" class="btn btn-round btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light" value="Save" id="submit" tabindex="1"/>
                                                    <a href="<?php echo $this->config->item('base_url') . 'service/to_do_service' ?>" class="btn btn-round btn-inverse btn-sm waves-effect waves-light m-b-10"><span class="glyphicon"></span> Back </a>
                                                </div>
                                            </div>
                                        </form>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // $('#emp_id').select2({
        //     placeholder: "Staff Assigned",
        //     tags: true
        // });
        // $('#emp_id').on("select2:emp_id", function (evt) {
        //     var element = evt.params.data.element;
        //     var $element = $(element);
            
        //     $element.detach();
            
        //     $(this).append($element);
        //     $(this).trigger("change");
        // });

        $('#submit').on('click', function () {
            var i = 0;
//            var wp = $(this).closest('form').find('.wp').val();
//            if (wp == '') {
//                $(this).closest('form').find('.error_msg').text('This field is required');
//                i = 1;
//            } else {
//                $(this).closest('form').find('.error_msg').text('');
//            }
            var emp_id = $('#emp_id').val();
            if (emp_id == "")
            {
                $('#staff_err').html("This field is required");
                i = 1;
                $('#staff_err').focus();
            } else
            {
                $('#category').html("");
            }
            if (i == 1)
            {
                return false;
            } else
            {
                return true;
            }
        })
        $("#emp_id").live('blur', function ()
        {
            var emp_id = $("#emp_id").val();
            if (emp_id == "" || emp_id == null || emp_id.trim().length == 0)
            {
                $("#staff_err").html("This field is required");
            } else
            {
                $("#staff_err").html("");
            }
        });

        $("#dropper-default").live('blur', function ()
    {
        var date = $("#dropper-default").val();

        if (date == "" || date == null || date.trim().length == 0)
        {
            $("#date1").html("Required Field");
        } else
        {
            $("#date1").html("");
        }
    });
    </script>
    <script>
     var date = $("#dropper-default").val();

if (date == "" || date == null || date.trim().length == 0)
{
    $("#date1").html("Required Field");
    i = 1;
} else
{
    $("#date1").html("");
}</script>
