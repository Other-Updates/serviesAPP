<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<link rel="stylesheet" href="<?= $theme_path; ?>/bower_components/select2/css/select2.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/select2/js/select2.full.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/bootstrap-multiselect/css/bootstrap-multiselect.css" />
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/multiselect/css/multi-select.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/bootstrap-multiselect/js/bootstrap-multiselect.js">
</script>
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/multiselect/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?= $theme_path; ?>/assets/js/jquery.quicksearch.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<script type="text/javascript" src="https://momentjs.com/downloads/moment.js"></script>
<style>
    a:focus, a:hover {
        color: #fff;
    }
</style>
<?php
$customers_json = array();
if (!empty($customers)) {
    foreach ($customers as $list) {
        $customers_json[] = '{ value: "' . $list['name'] . '", id: "' . $list['id'] . '"}';
    }
}
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Edit Leads</h5>
            </div>
            <div class="card-block">
                <?php
                if (isset($all_enquiry) && !empty($all_enquiry)) {
                    foreach ($all_enquiry as $val) {
                        $selected_array = explode(',', $val['assigned_to']);
                        ?>
                        <form class="form-material" action="<?php echo $this->config->item('base_url'); ?>enquiry/update_enquiry/<?php echo $val['id']; ?>" enctype="multipart/form-data" name="form" method="post">
                            <div class="form-material row">
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-address-book"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Leads Number</label>
                                            <input type="text" name="enquiry_no" value="<?php echo $val['enquiry_no']; ?>" class=" form-control" id="user_name" readonly tabindex="1"/>
                                            <span class="form-bar"></span>
                                            <span id="cuserror8" class="val text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-ui-user"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Customer Name <span class="req">*</span></label>
                                            <input type="text" name="customer_name"  value="<?php echo $val['customer'][0]['name']; ?>" class="form-control" id="name" tabindex="1">
                                            <input type="hidden"  name="customer_id" id="customer_id" class='id_customer form-control' value="<?php echo $val['customer_id']; ?>" />
                                            <span class="form-bar"></span>
                                            <span id="cuserror1" class="val text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-email"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Customer Email</label>
                                            <input type="text" name="customer_email" value="<?php echo $val['customer'][0]['email_id']; ?>" class="mail form-control email_dup" id="mail" tabindex="1" />
                                            <span class="form-bar"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-architecture-alt"></i>
                                        </div>
                                        <div class="form-group form-primary">

                                            <label class="float-label">Leads About <span class="req">*</span></label>
                                            <input type="text" name="enquiry_about" value="<?php echo $val['enquiry_about']; ?>" class="number form-control" id="enquiry_about" tabindex="1"/>
                                            <span class="form-bar"></span>
                                            <span id="cuserror_enquiry_about" class="val text-danger" ></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-material row">
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-ui-calendar"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Followup Date <span class="req">*</span></label>
                                            <!--<input type="date" name="followup_date" class="datepicker1 form-control" id="date"  value="<?php //echo $val['followup_date'];?>"  tabindex="1"/>-->
                                            <input id="dropper-default" class="form-control" name="followup_date" type="text" data-date="<?php echo date('d', strtotime($val['followup_date'])); ?>" data-month="<?php echo date('m', strtotime($val['followup_date'])); ?>" data-formats="<?php echo date('m/d/Y', strtotime($val['followup_date'])); ?>" data-year="<?php echo date('Y', strtotime($val['followup_date'])); ?>" placeholder="Select your date" value="<?php echo date('d-M-Y', strtotime($val['followup_date'])); ?>" />
                                            <!--<span class="form-bar"></span>-->
                                            <span id="date1" class="val text-danger"></span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-ui-call"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Contact Number <span class="req">*</span></label>
                                            <input type="text" name="contact_number"  class="form-control" id="number" value="<?php echo $val['customer'][0]['mobil_number']; ?>" tabindex="1" >
                                            <span class="form-bar"></span>
                                            <span id="cuserror4" class="val text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-ui-call"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Contact Number 2</label>
                                            <input type="text" name="contact_number_2" class="phone2 form-control" id="phone2" value="<?= $val['customer'][0]['mobile_number_2'] ?>" />
                                            <span class="form-bar"></span>
                                            <span id="phone2_err" class="val text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-primary">
                                        <div class="material-group">
                                            <div class="material-addone">
                                                <i class="icofont icofont-tasks-alt"></i>
                                            </div>
                                            <div class="form-group form-primary">
                                                <label class="float-label">Remarks <span class="req">*</span></label>
                                                <input type="text" name="remarks" value="<?php echo $val['remarks']; ?>" class="number form-control" id="remarks" tabindex="1"/>
                                                <span class="form-bar"></span>
                                                <span id="cuserror_remarks" class="val text-danger" ></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-material row">

                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-location-pin"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Customer Address <span class="req">*</span></label>
                                            <textarea name="customer_address" id="address" class="form-control" tabindex="1" > <?php echo $val['customer'][0]['address1']; ?> </textarea>
                                            <span class="form-bar"></span>
                                            <span id="cuserror3" class="val text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-address-book"></i>
                                        </div>
                                        <div class="form-group form-primary">

                                            <select id='staff_name'  name="assigned_to[]"  class="form-control"  multiple="multiple" >
                                                <option value="">Assign to Staff </option>
                                                <?php
                                                if (isset($staff_name) && !empty($staff_name)) {
                                                    foreach ($staff_name as $list) {
                                                        $mark_as_select = (in_array($list['id'], $selected_array)) ? 'selected' : NULL;
                                                        echo '<option value="' . $list['id'] . '" ' . $mark_as_select . '>' . $list['name'] . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <span class="form-bar"></span>
                                            <span id="staff_err" class="val text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-address-book"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <select class='form-control' name='cat_id' id='category' tabindex="1">
                                                <option value='' >Select Category</option>
                                                <?php
                                                if (isset($category) && !empty($category)) {
                                                    foreach ($category as $cat_val) {
                                                        ?>
                                                        <option value="<?php echo $cat_val['cat_id']; ?>" <?php echo ($val['cat_id'] == $cat_val['cat_id']) ? 'selected="selected"' : ''; ?>><?php echo ucfirst($cat_val['categoryName']) ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <span class="form-bar"></span>
                                            <span id="category_err" class="val text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-primary">

                                        <select class='form-control' name='status' id='status' tabindex="1">
                                            <?php
                                            if ($val['status'] == 'leads') {
                                                $status = 'Pending Leads';
                                            } else if ($val['status'] == 'leads_follow_up') {
                                                $status = 'Leads follow up';
                                            } else if ($val['status'] == 'leads_rejected') {
                                                $status = 'Leads Rejected';
                                            } else if ($val['status'] == 'quotation') {
                                                $status = 'Quotation';
                                            } else if ($val['status'] == 'quotation_follow_up') {
                                                $status = 'Quotation follow up';
                                            } else if ($val['status'] == 'quotation_rejected') {
                                                $status = 'Quotation Rejected';
                                            } else if ($val['status'] == 'order_conform') {
                                                $status = 'Order Completed';
                                            }
                                            ?>
                                            <option value="<?php echo $val['status']; ?>"> <?php echo $status ?> </option>
                                            <option value='leads'>Pending Leads</option>
                                            <option value='leads_follow_up'>Leads follow up</option>
                                            <option value='leads_rejected'>Leads rejected</option>
                                            <option value='quotation'>Quotation</option>
                                            <option value='quotation_follow_up'>Quotation follow up</option>
                                            <option value='quotation_rejected'>Quotation rejected</option>
                                            <option value='order_conform'>Order Completed</option>
                                        </select>
                                        <span class="form-bar"></span>
                                        <span id="status1" class="val text-danger"></span>
                                    </div>

                                </div>
                                <div class="col-md-3 q_ref_no" style="display:none;">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-notepad"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Quotation Ref.No</label>
                                            <input type="text" name="quotation_ref_no" class="form-control form-align"  value="<?php echo $val['quotation_ref_no']; ?>" id="quotation_ref_no" tabindex="1"/>
                                            <span class="form-bar"></span>
                                            <span id="q_ref_no_err" class="val text-danger" ></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-material row text-center m-10">
                                <div class="col-md-12 text-center">
                                    <input type="submit" name="submit" class="btn btn-round btn-primary m-b-10 btn-sm waves-effect waves-light m-r-20" value="Update" id="edit" tabindex="1"/>
                                    <a href="<?php echo $this->config->item('base_url') . 'enquiry/enquiry_list/' ?>" class="btn btn-round btn-inverse btn-sm waves-effect waves-light m-b-10" tabindex="1"> Back </a>
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
<script type="text/javascript">
    $("#dropper-default").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        format: 'd-M-Y',
        maxYear: new Date().getFullYear() + 50
    });
    $('#staff_name').select2({
        placeholder: "Staff Assigned"
    });
    $("#status").on("change", function () {
        this_val = this.value;
        if (this_val == "quotation_follow_up" || this_val == "quotation" || this_val == "quotation_rejected") {
            $("#quotation_ref_no").closest('div.q_ref_no').css("display", "block");
        } else {
            $("#quotation_ref_no").closest('div.q_ref_no').css("display", "none");
        }
    });
    var q_ref_no = $('#status').val();
    if (q_ref_no == "quotation_follow_up" || q_ref_no == "quotation" || q_ref_no == "quotation_rejected") {
        $("#quotation_ref_no").closest('div.q_ref_no').css("display", "block");
    } else {
        $("#quotation_ref_no").closest('div.q_ref_no').css("display", "none");
    }
    $("#name").live('blur', function ()
    {
        var name = $("#name").val();
        var filter = /^[a-zA-Z.\s]{3,30}$/;
        if (name == "" || name == null || name.trim().length == 0)
        {
            $("#cuserror1").html("Required Field");
            clear_data();
        } else if (!filter.test(name))
        {
            $("#cuserror1").html("Alphabets and Min 3 to Max 30 ");
        } else
        {
            $("#cuserror1").html("");
        }
    });
    $("#quotation_ref_no").on('blur', function ()
    {
        var q_ref_no = $("#quotation_ref_no").val();
        var status = $('#status').val();
        if (status == "quotation_follow_up" || status == "quotation" || status == "quotation_rejected") {
            if (q_ref_no == "" || q_ref_no == null || q_ref_no.trim().length == 0)
            {
                $("#q_ref_no_err").html("Required Field");
            } else {
                $("#q_ref_no_err").html("");
            }
        } else {
            $("#q_ref_no_err").html("");
        }

    });
    $("#user_name").live('blur', function ()
    {
        var store = $("#user_name").val();
        if (store == "" || store == null || store.trim().length == 0)
        {
            $("#cuserror8").html("Required Field");
        } else
        {
            $("#cuserror8").html("");
        }
    });
    $('#address').live('blur', function ()
    {
        var address = $('#address').val();
        if (address == "" || address == null || address.trim().length == 0)
        {
            $('#cuserror3').html("Required Field");
        } else
        {
            $('#cuserror3').html("");
        }
    });
    $("#number").live('blur', function ()
    {
        var number = $("#number").val();
        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;
        if (number == "" || number == null || number.trim().length == 0)
        {
            $("#cuserror4").html("Required Field");
        } else if (!nfilter.test(number))
        {
            $("#cuserror4").html("Enter Valid Mobile Number");
        } else
        {
            $("#cuserror4").html("");
        }
    });
    $("#phone2").live('blur', function ()
    {
        var number = $("#phone2").val();
        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;
        if (number != "") {
            if (!nfilter.test(number))
            {
                $("#phone2_err").html("Enter Valid Mobile Number");
            } else
            {
                $("#phone2_err").html("");
            }
        } else {
            $("#phone2_err").html("");
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
    $("#status").live('blur', function ()
    {
        var date = $("#status").val();

        if (date == "" || date == null || date.trim().length == 0)
        {
            $("#status1").html("Required Field");
        } else
        {
            $("#status1").html("");
        }
    });
    $("#category").on('blur', function ()
    {
        var category = $("#category").val();

        if (category == "" || category == null || category.trim().length == 0)
        {
            $("#category_err").html("Required Field");
        } else
        {
            $("#category_err").html("");
        }
    });
//        $("#mail").live('blur', function ()
//        {
//            var mail = $("#mail").val();
//            var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
//            if (mail == "")
//            {
//                $("#cuserror5").html("Required Field");
//            } else if (!efilter.test(mail))
//            {
//                $("#cuserror5").html("Enter Valid Email");
//            } else
//            {
//                $("#cuserror5").html("");
//            }
//        });
    $('#remarks').live('blur', function ()
    {
        var bank = $('#remarks').val();
        if (bank == "" || bank == null || bank.trim().length == 0)
        {
            $('#cuserror_remarks').html("Required Field");
        } else
        {
            $('#cuserror_remarks').html("");
        }
    });
    $('#enquiry_about').live('blur', function ()
    {
        var bank1 = $('#enquiry_about').val();
        if (bank1 == "" || bank1 == null || bank1.trim().length == 0)
        {
            $('#cuserror_enquiry_about').html("Required Field");
        } else
        {
            $('#cuserror_enquiry_about').html("");
        }
    });


    function clear_data() {
        $('#number').val('');
        $('#phone2').val('');
        $('#mail').val('');
        $('#address').val('');
        $('#customer_id').val('');
    }
</script>
<script type="text/javascript">
    $('#edit').live('click', function ()
    {

        var i = 0;
        var name = $("#name").val();
        var filter = /^[a-zA-Z.\s]{3,30}$/;
        if (name == "" || name == null || name.trim().length == 0)
        {
            $("#cuserror1").html("Required Field");
            clear_data();
            i = 1;
        } else if (!filter.test(name))
        {
            $("#cuserror1").html("Alphabets and Min 3 to Max 30 ");
            i = 1;
        } else
        {
            $("#cuserror1").html("");
        }

        var q_ref_no = $("#quotation_ref_no").val();
        var estatus = $('#status').val();
        if (estatus == "quotation_follow_up" || estatus == "quotation" || estatus == "quotation_rejected") {
            if (q_ref_no == "" || q_ref_no == null || q_ref_no.trim().length == 0)
            {
                $("#q_ref_no_err").html("Required Field");
                i = 1;
            } else {
                $("#q_ref_no_err").html("");
            }
        } else {
            $("#q_ref_no_err").html("");
        }


        var status = $('#status').val();
        if (status == "" || status == null || status.trim().length == 0)
        {
            $('#status1').html("Required Field");
            i = 1;
        } else
        {
            $('#status1').html("");
        }

        var category = $("#category").val();
        if (category == "" || category == null || category.trim().length == 0)
        {
            $("#category_err").html("Required Field");
            i = 1;
        } else
        {
            $("#category_err").html("");
        }

        var bank = $('#remarks').val();
        if (bank == "" || bank == null || bank.trim().length == 0)
        {
            $('#cuserror_remarks').html("Required Field");
            i = 1;
        } else
        {
            $('#cuserror_remarks').html("");
        }
        var bank1 = $('#enquiry_about').val();
        if (bank1 == "" || bank1 == null || bank1.trim().length == 0)
        {
            $('#cuserror_enquiry_about').html("Required Field");
            i = 1;
        } else
        {
            $('#cuserror_enquiry_about').html("");
        }

        var user_name = $("#user_name").val();
        if (user_name == "" || user_name == null || user_name.trim().length == 0)
        {
            $("#cuserror8").html("Required Field");
            i = 1;
        } else
        {
            $("#cuserror8").html("");
        }

        var date = $("#dropper-default").val();

        if (date == "" || date == null || date.trim().length == 0)
        {
            $("#date1").html("Required Field");
            i = 1;
        } else
        {
            $("#date1").html("");
        }
        var number = $("#number").val();
        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;
        if (number == "")
        {
            $("#cuserror4").html("Required Field");
            i = 1;
        } else if (!nfilter.test(number))
        {
            $("#cuserror4").html("Enter Valid Mobile Number");
            i = 1;
        } else
        {
            $("#cuserror4").html("");
        }
        var phone2 = $("#phone2").val();
        if (phone2 != "")
        {
            if (!nfilter.test(phone2))
            {
                $("#phone2_err").html("Enter Valid Mobile Number");
                i = 1;
            } else
            {
                $("#phone2_err").html("");
            }
        } else {
            $("#phone2_err").html("");
        }

        var address = $('#address').val();
        if (address == "" || address == null || address.trim().length == 0)
        {
            $('#cuserror3').html("Required Field");
            i = 1;
        } else
        {
            $('#cuserror3').html("");
        }

//        var mess = $('#duplica').html();
//        if ((mess.trim()).length > 0)
//        {
//            i = 1;
//        }


        if (i == 1)
        {
            return false;
        } else
        {
            return true;
        }

    });

    $(document).ready(function () {
        $('body').on('keydown', 'input#name', function (e) {
            var c_data = [<?php echo implode(',', $customers_json); ?>];
            $("#name").autocomplete({
                source: function (request, response) {
                    var outputArray = new Array();
                    for (var i = 0; i < c_data.length; i++) {
                        if (c_data[i].value.toLowerCase().match(request.term.toLowerCase())) {
                            outputArray.push(c_data[i]);
                        }
                    }
                    if (outputArray.length == 0) {
                        clear_data();
                        var nodata = 'No data found';
                        outputArray.push(nodata);
                    }
                    response(outputArray);
                },
                minLength: 0,
                autoFill: false,
                select: function (event, ui) {

                    cust_id = ui.item.id;
                    $.ajax({
                        type: 'POST',
                        data: {cust_id: cust_id},
                        url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_customer/",
                        success: function (data) {
                            result = JSON.parse(data);
                            if (result != null && result.length > 0) {
                                $("#number").parent().find(".float-label").removeClass('newClass1');
                                $("#number").parent().find(".float-label").addClass('newClass');
                                $("#phone2").parent().find(".float-label").removeClass('newClass1');
                                $("#phone2").parent().find(".float-label").addClass('newClass');
                                $("#mail").parent().find(".float-label").removeClass('newClass1');
                                $("#mail").parent().find(".float-label").addClass('newClass');
                                $("#address").parent().find(".float-label").removeClass('newClass1');
                                $("#address").parent().find(".float-label").addClass('newClass');

                                $("#customer_id").val(result[0].id);
                                $("#name").val(result[0].name);
                                $("#number").val(result[0].mobil_number);
                                $("#phone2").val(result[0].mobile_number_2);
                                $("#mail").val(result[0].email_id);
                                $("#address").val(result[0].address1);
                            }
                        }
                    });
                }
            });
        });
    });
    $(document).ready(function () {
        var text_val = $('#name').val();
        if (text_val === "") {
            $('#name').parent().find(".float-label").removeClass('newClass');
            $('#name').parent().find(".float-label").addClass('newClass1');
        } else {
            $("#name").parent().find(".float-label").removeClass('newClass1');
            $("#name").parent().find(".float-label").addClass('newClass');
        }
    });
</script>
<script>
//        $(".email_dup").live('blur', function ()
//        {
//            email = $("#mail").val();
//            $.ajax(
//                    {
//                        url: BASE_URL + "enquiry/add_duplicate_email",
//                        type: 'get',
//                        data: {value1: email},
//                        success: function (result)
//                        {
//                            $("#duplica").html(result);
//                        }
//                    });
//        });
</script>
