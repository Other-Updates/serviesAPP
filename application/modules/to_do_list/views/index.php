<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-my-1.10.3.min.js"></script>
<link rel="stylesheet" href="<?= $theme_path; ?>/bower_components/select2/css/select2.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/select2/js/select2.full.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/bootstrap-multiselect/css/bootstrap-multiselect.css" />
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/multiselect/css/multi-select.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/bootstrap-multiselect/js/bootstrap-multiselect.js">
</script>
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/multiselect/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?= $theme_path; ?>/assets/js/jquery.quicksearch.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/assets/css/autocomplete.css">
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<?php
$job_type_arr = array(
    'leads' => 'Leads',
    'project' => 'Project',
    'services' => 'Services'
);
?>
<style>
    .hidden_div, .hidden_leads{
        display:none;
    }
    .emp_select {
        display:none;
    }
    .show_project {
        display:none;
    }

    #service_table1 tbody tr td:nth-child(6){text-align:center;}
    #service_table1 tbody tr td:nth-child(7){text-align:center;}
    #leads_table tbody tr td:nth-child(9){text-align:center;}
    #leads_table tbody tr td:nth-child(6){text-align:center;}
    #leads_table tbody tr td:nth-child(5){text-align:center;}
    #project_table tbody tr td:nth-child(3){text-align:center;}
    project_table tbody tr td:nth-child(4){text-align:right;}

</style>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Add To Do List</h5>
            </div>
            <div class="card-block">
                <div class="form-material row">
                    <div class="col-md-4">
                        <div class="material-group">
                            <div class="material-addone">
                                <i class="icofont icofont-address-book"></i>
                            </div>
                            <div class="form-group form-primary">
                                <select class='form-control required' name='cat_id' id='category' tabindex="1">
                                    <option value=''>Select Category</option>
                                    <?php
                                    if (isset($job_type_arr) && !empty($job_type_arr)) {
                                        foreach ($job_type_arr as $job_type_key => $job_type_val) {
                                            ?>
                                            <option  value="<?php echo $job_type_key ?>"><?php echo $job_type_val; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <span class="error_msg"></span>
                            </div>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="material-group">
                            <div class="material-addone">
                                <i class="icofont icofont-ui-calendar"></i>
                            </div>
                            <div class="form-group form-primary">
                                <label class="float-label">From Date</label>
                                <input tabindex="1" id="from_date" name="from_date" data-date="" data-month="" data-year=""  class="form-control required dropper-default" type="text" placeholder="" />
                                <span class="form-bar"></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="material-group">
                            <div class="material-addone">
                                <i class="icofont icofont-ui-calendar"></i>
                            </div>
                            <div class="form-group form-primary">
                                <label class="float-label">To Date</label>
                                <input tabindex="1" id="to_date" name="to_date" data-date="" data-month="" data-year="" class="form-control required dropper-default" type="text" placeholder="" />
                                <span class="form-bar"></span>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">
                        <div>
                            <a id='search' class="submit btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light"> Search</a>
                        </div>
                    </div>
                    <!--                    <div class="col-md-4 emp_select">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-contact-add"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <select id="employee" class="form-control emp required" name="employee" disabled="disabled">
                                                        <option value="">Select Employee</option>
                    <?php
                    if (isset($users) && !empty($users)) {
                        foreach ($users as $users_key => $users_val) {
                            ?>
                                                                                                                                                                                                                                                <option  value="<?php echo $users_val['id'] ?>"><?php echo ucfirst($users_val['name']) ?></option>
                            <?php
                        }
                    }
                    ?>
                                                    </select>
                                                    <span class="error_msg" style="color:red;"></span>
                                                </div>
                                            </div>
                                        </div>-->
                </div>
                <div class="tab-pane active hidden_div" id="service_details" role="tabpanel" >
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-header-text">Service Details</h5>
                        </div>
                        <div class="col-xs-12" style="margin-left:  919px;">
                            <div class="service_error">
                                <span id="service_error" style="color:red;"></span>
                            </div>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table class="table table-striped table-bordered" id="service_table">
                                    <thead>
                                        <tr>
                                            <th width="33">S.No</th>
                                            <th width="35">Inv #</th>
                                            <th width="35">Ticket #</th>
                                            <!--<th width="35">Product Image</th>-->
                                            <th width="35">Description</th>
                                            <th width="35">Warranty</th>
                                            <th width="35">Inv Date</th>
                                            <th width="92">Status</th>
                                            <!--<th width="107" class="action-btn-align">Action</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
//                                        if (!empty($service)) {
//                                            $i = 1;
//                                            foreach ($service as $service_list) {
//
                                        ?>
<!--                                                <tr class="ads_row//<?php echo $service_list['id'] ?>">
                                                    <td style="display:none;" class="hidden_service_id">//<?php echo $service_list['id']; ?></td>
                                                    <td>//<?php echo $i++; ?></td>
                                                    <td>//<?php echo $service_list['inv_no']; ?></td>
                                                    <td>//<?php echo $service_list['ticket_no']; ?></td>
                                                    <td>//<?php echo $product_image; ?></td>
                                                    <td>//<?php echo ucfirst($service_list['description']); ?></td>
                                                    <td>//<?php echo $service_list['warrenty']; ?></td>
                                                    <td>//<?php echo date('d-M-Y', strtotime($service_list['created_date'])); ?></td>

                                                    <td class="text-center"><span class="  label  //<?php echo ($service_list['status'] == 1) ? 'label-success' : 'label-danger'; ?>"><?php echo ($service_list['status'] == 1) ? 'Completed' : 'Pending'; ?></span></td>
                                                    <td><input type="checkbox" class="assign_service" /></td>
                                                </tr>-->
                                        <?php
//                                            }
//                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row m-10">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary btn-sm waves-effect waves-light" id="save"  tabindex="1"> Create</button>

                        </div>
                    </div>
                </div>
                <div class="tab-pane active hidden_leads" id="leads_details" role="tabpanel" >
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-header-text">Today's Leads list</h5>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table class="table table-striped table-bordered" id="leads_table">
                                    <thead>
                                        <tr>
                                            <td class="action-btn-align">S.No</td>
                                            <td>Leads #</td>
                                            <td>Customer</td>
                                            <td>Cus.Address</td>
                                            <td>L.Date</td>
                                            <td>L.Followup Date</td>
                                            <td>Assigned</td>
                                            <td>L.About</td>
                                            <td>Status</td>
                                            <td>Remarks</td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" value="" id="category_type">
                <div class="tab-pane active show_project" id="project_details" role="tabpanel" >
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-header-text">Today's Project List</h5>
                        </div>
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table class="table table-striped table-bordered" id="project_table">
                                    <thead>
                                        <tr>
                                            <th width="33">S.No</th>
                                            <th width="35">Project #</th>
                                            <th width="35">Total Qty</th>
                                            <th width="35">Project Cost Amt</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $('#search').on('click', function () {
        cate_type = $('#category_type').val();
        if (cate_type == 'services') {
            table.ajax.reload();
        } else if (cate_type == 'leads') {
            leads_table.ajax.reload();
        } else if (cate_type == 'project') {
            project_table.ajax.reload();
        }
    });
    $(document).ready(function () {
        table = $('#service_table').DataTable({
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "language": {
                "infoFiltered": ""
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                url: BASE_URL + "to_do_list/service_ajaxList",
                "type": "POST",
                "data": function (data) {
                    data.from_date = $('#from_date').val();
                    data.to_date = $('#to_date').val();
                }
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "orderable": false, //set not orderable
                },
            ],
        });
        leads_table = $('#leads_table').DataTable({
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "language": {
                "infoFiltered": ""
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                url: BASE_URL + "to_do_list/leads_ajaxList",
                "type": "POST",
                "data": function (data) {
                    data.from_date = $('#from_date').val();
                    data.to_date = $('#to_date').val();
                }
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "orderable": false, //set not orderable
                },
            ],
        });
        project_table = $('#project_table').DataTable({
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "language": {
                "infoFiltered": ""
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                url: BASE_URL + "to_do_list/project_ajaxList",
                "type": "POST",
                "data": function (data) {
                    data.from_date = $('#from_date').val();
                    data.to_date = $('#to_date').val();
                }
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "orderable": false, //set not orderable
                },
            ],
        });
    });
    $('#category').on('keyup change', function () {
        this_val = $.trim($(this).val());
        $('#category_type').val(this_val);
        if (this_val == 'services') {
            $("#service_details").removeClass("hidden_div");
            $("#leads_details").addClass("hidden_leads");
            $("#project_details").addClass("show_project");
//            $(".emp_select").css('display', 'block');
            $('#employee').removeAttr('disabled');
        } else if (this_val == 'leads') {
            $("#service_details").addClass("hidden_div");
            $("#project_details").addClass("show_project");
            $("#leads_details").removeClass("hidden_leads");
//            $(".emp_select").css('display', 'none');
            $('#employee').removeAttr('disabled');
        } else if (this_val == 'project') {
            $("#project_details").removeClass("show_project");
            $("#leads_details").addClass("hidden_leads");
            $("#service_details").addClass("hidden_div");
//            $(".emp_select").css('display', 'none');
            $('#employee').removeAttr('disabled');
        } else {
            $("#service_details").addClass("hidden_div");
            $("#leads_details").addClass("hidden_leads");
            $("#project_details").addClass("show_project");
//            $(".emp_select").css('display', 'none');
        }

    });
//    $('#employee').select2({
//        placeholder: "Select Employee"
//    });
    $(".dropper-default").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        maxYear: new Date().getFullYear() + 50,
        format: 'd-m-Y'
    });
    $('#save').click(function () {

        m = 0;
        var pay_checkbox = $(".assign_service").is(':checked') ? 1 : 0;
        if (pay_checkbox == 0) {
            m = 1;
            $('#service_error').empty();
            $('#service_error').append('Please select service list');
            setTimeout(function () {
                $('#service_error').html('');
            }, 5000);
        }
        $('.required').each(function () {
            this_val = $.trim($(this).val());
            if (this_val == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
                m = 1;
            } else {
                $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
            }
        });
        if (m > 0) {
            return false;
        } else
        {
            return true;
        }

        /* else {
         var service_id = [];
         var employee_id = $.trim($('#employee').val());
         $('input:checkbox:checked').each(function () {
         var id = $(this).closest('tr').find('.hidden_service_id').text();
         service_id.push(id);
         });
         $.ajax({
         type: 'POST',
         data: {employee_id: employee_id, service_id: service_id},
         url: '<?php echo base_url(); ?>to_do_list/update_employee_assigned/',
         success: function (data) {
         if (data == 1) {
         setTimeout(function ()
         {
         location.reload();
         }, 1000);
         }

         }
         });
         } */

    });
    $('#employee').on('change', function () {
        var employee = $(this).val();
        if (employee == '') {
            $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
        } else {
            $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
        }
    });
    $('#category').on('change', function () {
        var category = $(this).val();
        if (category == '') {
            $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
        } else {
            $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
        }
    });

</script>