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
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/assets/css/autocomplete.css">

<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<style>
    .modal-dialog{
        margin-top: 10px !important;
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
                <h5>Add Leads</h5>
            </div>
            <div class="card-block">
                <form class="form-material" action="<?php echo $this->config->item('base_url'); ?>enquiry/add_enquiry" enctype="multipart/form-data" name="form" method="post" novalidate>
                    <div class="form-material row">
                        <div class="col-md-3">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-address-book"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <label class="float-label">Leads Number</label>
                                    <input type="text" name="enquiry_no" value="<?php echo $last_id; ?>" class=" form-control" id="user_name" readonly tabindex="1"/>
                                    <span class="form-bar"></span>
                                    <span id="cuserror8" class="val text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-contact-add"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <label class="float-label">Customer Name <span class="req">*</span></label>
                                    <input type="text" name="customer_name"  class="form-control" id="name" tabindex="1">
                                    <input type="hidden"  name="customer_id" id="customer_id" class='id_customer form-control' />
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
                                    <input type="text" name="customer_email" class="mail form-control email_dup" id="mail" tabindex="1" />
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
                                    <input type="text" name="enquiry_about" class="number form-control form-align" id="enquiry_about" tabindex="1"/>
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
                                    <!--<input type="date" name="followup_date" class="form-control" id="date" tabindex="1"/>-->
                                    <input id="dropper-default" name="followup_date" data-date="" data-month="" data-year="" value="<?php echo date('d-M-Y'); ?>" class="form-control" type="text" placeholder="" />
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
                                    <input type="text" name="contact_number"  class="form-control" id="number" tabindex="1" >
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
                                    <input type="text" name="contact_number_2"  class="form-control" id="phone2" tabindex="1" >
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
                                        <input type="text" name="remarks" class="number form-control" id="remarks" tabindex="1"/>
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
                                    <textarea name="customer_address" id="address" class="form-control" tabindex="1" ></textarea>
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
                                    <select id='staff_name' name="assigned_to[]" class="form-control" multiple="multiple">
                                        <option value="">Assign to Staff</option>
                                        <?php
                                        if (isset($staff_name) && !empty($staff_name)) {
                                            foreach ($staff_name as $val) {
                                                ?>
                                                <option  value="<?php echo $val['id'] ?>"><?php echo $val['name'] ?></option>
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
                                                <option  value="<?php echo $cat_val['cat_id'] ?>"><?php echo $cat_val['categoryName'] ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <span class="form-bar"></span>
                                    <span id="category_err" class="val text-danger"></span>
                                </div>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-address-book"></i>
                                </div>
                                <div class="form-group form-primary">

                                    <select class='form-control' name='status' id='status' tabindex="1">
                                        <option value='' >Select Status</option>
                                        <option value='leads' selected="" >Pending Leads</option>
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
                        </div>
                        <div class="col-md-3 q_ref_no" style="display:none;">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-notepad"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <label class="float-label">Quotation Ref.No</label>
                                    <input type="text" name="quotation_ref_no" class="form-control form-align" id="quotation_ref_no" tabindex="1"/>
                                    <span class="form-bar"></span>
                                    <span id="q_ref_no_err" class="val text-danger" ></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row text-center m-10">
                        <div class="col-md-12 text-center">
                            <input type="submit" name="submit" class="btn btn-round btn-primary m-b-10 btn-sm waves-effect waves-light m-r-20" value="Save" id="submit" tabindex="1"/>
                            <input type="reset" value="Clear" class="btn btn-round btn-danger waves-effect m-b-10 btn-sm waves-light" id="reset" tabindex="1"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#dropper-default").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        maxYear: new Date().getFullYear() + 50,
        format: 'd-M-Y'
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
    $("#name").on('blur', function ()
    {
        var name = $("#name").val();
        var filter = /^[a-zA-Z.\s]{3,30}$/;
        if (name == "" || name == null || name.trim().length == 0)
        {
            $("#cuserror1").html("Required Field");
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
    $("#status").on('blur', function ()
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
    $("#user_name").on('blur', function ()
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
    $('#address').on('blur', function ()
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
    $("#number").on('blur', function ()
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
    $("#phone2").on('blur', function ()
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

    $('#remarks').on('blur', function ()
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
    $('#enquiry_about').on('blur', function ()
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



</script>
<script type="text/javascript">
    $('#submit').on('click', function ()
    {
        var i = 0;
        var name = $("#name").val();
        var filter = /^[a-zA-Z.\s]{3,30}$/;
        if (name == "" || name == null || name.trim().length == 0)
        {
            $("#cuserror1").html("Required Field");
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
        var bank = $('#remarks').val();
        if (bank == "" || bank == null || bank.trim().length == 0)
        {
            $('#cuserror_remarks').html("Required Field");
            i = 1;
        } else
        {
            $('#cuserror_remarks').html("");
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



        var address = $('#address').val();
        if (address == "" || address == null || address.trim().length == 0)
        {
            $('#cuserror3').html("Required Field");
            i = 1;
        } else
        {
            $('#cuserror3').html("");
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
        if (number == "" || number == null || number.trim().length == 0)
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

        if (i == 1)
        {
            return false;
        } else
        {
            return true;
        }

    });
</script>
<script>
    $(".email_dup").on('blur', function ()
    {
        email = $("#mail").val();
        $.ajax(
                {
                    url: BASE_URL + "enquiry/add_duplicate_email",
                    type: 'get',
                    data: {value1: email},
                    success: function (result)
                    {
                        $("#duplica").html(result);
                    }
                });
    });
</script>

<?php
if (isset($agent) && !empty($agent)) {
    foreach ($agent as $val) {
        ?>
        <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header modal-padding"> <a class="close modal-close" data-dismiss="modal">×</a>
                        <h3 id="myModalLabel" style="color:#06F;margin-top:10px;">In-Active user</h3>
                    </div>
                    <div class="modal-body">
                        Do You Want In-Active This user?<strong><?= $val['name']; ?></strong>
                        <input type="hidden" value="<?php echo $val['id']; ?>" class="id" />
                    </div>
                    <div class="modal-footer action-btn-align">
                        <button class="btn btn-primary btn-sm delete_yes" id="yesin">Yes</button>
                        <button type="button" class="btn btn-danger delete_all"  data-dismiss="modal" id="no">No</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>


<script type="text/javascript">
    $(document).ready(function ()
    {
        $("#delete_yes").on("click", function ()
        {

            var hidin = $(this).parent().parent().find('.id').val();
            $.ajax({
                url: BASE_URL + "users/delete_user",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "users/");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });
    $('body').on('keydown', 'input#name', function (e) {
        var c_data = [<?php echo implode(',', $customers_json); ?>];

        $("#name").autocomplete({
//            source: c_data,
            source: function (request, response) {
                // filter array to only entries you want to display limited to 10
                var outputArray = new Array();
                for (var i = 0; i < c_data.length; i++) {
                    if (c_data[i].value.toLowerCase().match(request.term.toLowerCase())) {
                        outputArray.push(c_data[i]);
                    }
                }
                if (outputArray.length == 0) {
                    var nodata = 'Add new Customer';
                    outputArray.push(nodata);
                    $('#customer_id').val('');
                }
                response(outputArray.slice(0, 10));
            },
            minLength: 0,
            autoFill: false,
            select: function (event, ui) {
                if (ui.item.value == "Add new Customer") {
                    clear_data();
                    $('#exampleModal-4').modal('toggle');
                    return false;

                } else {
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
            }
        });
    });
    function clear_data() {
        $('#customername').val('');
        $('#email_address').val('');
        $('#company_name').val('');
        $('#mobile_num').val('');
        $('#mobile_num_2').val('');
        $('#address1').val('');
    }
    $(document).on('click', '#update_customer', function (e) {
        m = 0;
        $('.mandatory').each(function () {
            this_ele = $(this);
            this_val = $.trim($(this).val());
            this_id = $(this).attr('id');
            if (this_val == '') {
                $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
                m++;
            } else if (this_id == 'email_address') {
                emailRegexStr = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                is_valid = emailRegexStr.test(this_val);
                if (!is_valid) {
                    $(this).closest('div.form-group').find('.error_msg').text('Enter Valid Email Address').slideDown('500').css('display', 'inline-block');
                    m++;
                } else {
                    $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                }
            } else if (this_id == "mobile_num") {
                nfilter = /^(\+91-|\+91|0)?\d{10}$/;
                if (!nfilter.test(this_val))
                {
                    $(this).closest('div.form-group').find('.error_msg').text("Enter Valid Mobile Number");
                    m++;
                } else {
                    $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                }
            } else if (this_id == "mobile_num_2") {
                nfilter = /^(\+91-|\+91|0)?\d{10}$/;
                if (!nfilter.test(this_val))
                {
                    $(this).closest('div.form-group').find('.error_msg').text("Enter Valid Mobile Number");
                    m++;
                } else {
                    $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                }
            } else {
                $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
            }
        });
        if (m == 0) {
            $.ajax({
                url: BASE_URL + "customer/check_duplicate_email",
                type: 'post',
                data: {email: $('#email_address').val()},
                success: function (result)
                {
                    if (result === 0) {
                        $('#email_address').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                    } else {
                        $('#email_address').closest('div.form-group').find('.error_msg').text(result).slideDown('500').css('display', 'inline-block');
                        m++;
                    }
                }
            });

            $.ajax({
                url: BASE_URL + "customer/check_duplicate_mobile_number",
                type: 'post',
                data: {number: $('#mobile_num').val()},
                success: function (result)
                {
                    //alert(result!=0);
                    if (result === 0) {
                        $('#mobile_num').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                    } else {
                        $('#mobile_num').closest('div.form-group').find('.error_msg').text(result).slideDown('500').css('display', 'inline-block');
                        m++;
                    }
                }
            });
        }

        if (m > 0) {
            //console.log(m);
            return false;
        } else {
            var cus_name = $('#customername').val();
            var cus_email = $('#email_address').val();
            var cus_store = $('#company_name').val();
            var cus_num = $('#mobile_num').val();
            var cus_num_2 = $('#mobile_num_2').val();
            var cus_address = $('#address1').val();
            $.ajax({
                url: BASE_URL + "customer/add_customers",
                type: 'post',
                data: {cus_name: cus_name, cus_email: cus_email, cus_store: cus_store, cus_num: cus_num, cus_num_2: cus_num_2, cus_address: cus_address},
                success: function (result) {
                    $.ajax({
                        type: 'POST',
                        data: {cust_id: result},
                        url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_customer/",
                        success: function (data) {
                            var result = JSON.parse(data);
                            if (result != null && result.length > 0) {
                                $("#name").parent().find(".float-label").removeClass('newClass1');
                                $("#name").parent().find(".float-label").addClass('newClass');
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
                                clear_data();
                                $('#model_discard').trigger('click');

                            }
                        }
                    });
                }
            });
            return true;
        }

    });
</script>
<div class="modal fade" id="exampleModal-4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header modalcolor">
                <h5 class="modal-title" id="exampleModalLabel-4">Insert Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form id="customer_model_form" action="<?php echo $this->config->item('base_url'); ?>customer/insert_customer" enctype="multipart/form-data" name="form" method="post">

                    <div class="form-material row">
                        <div class="col-md-12">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-user"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="customer_name"  class="form-control mandatory" id="customername" tabindex="1">
                                    <span class="error_msg" class="val text-danger"></span>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Customer Name <span class="req">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-email"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="customer_email" class="form-control mandatory" id="email_address" tabindex="1"/>
                                    <span class="error_msg" class="val text-danger"></span>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Customer Email <span class="req">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-call"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="contact_number"  class="form-control mandatory" id="mobile_num" tabindex="1">
                                    <span class="error_msg" class="val text-danger"></span>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Contact Number <span class="req">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-call"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="contact_number_2"  class="form-control mandatory" id="mobile_num_2" tabindex="1">
                                    <span class="error_msg" class="val text-danger"></span>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Contact Number 2 <span class="req">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-location-pin"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <textarea name="customer_address" id="address1" class="form-control mandatory" tabindex="1"></textarea>
                                    <span class="error_msg" class="val text-danger"></span>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Customer Address <span class="req">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-briefcase-alt-1"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <input type="text" name="store" class="store form-control mandatory" id="company_name"/>
                                    <span class="error_msg" class="val text-danger"></span>
                                    <span class="form-bar"></span>
                                    <label class="float-label">Company Name <span class="req">*</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success btn-sm" id="update_customer">Update</button>
                <button type="button" class="btn btn-danger btn-sm" id="model_discard" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>