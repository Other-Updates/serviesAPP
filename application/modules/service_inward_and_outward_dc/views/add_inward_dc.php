<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<style>
    #add_group, #add_group_service {
        color: #fff;
    }
    .green {
        color: green;
    }
    .red {
        color: red;
    }
    #delete_group {
        color: #fff;
    }
    .sub-title {
        margin-bottom: 0px;
    }
    .remark {

    }

</style>
<?php
$model_numbers_json = array();
if (!empty($products)) {
    foreach ($products as $list) {
        $model_numbers_json[] = '{ value: "' . $list['model_no'] . '", id: "' . $list['id'] . '"}';
    }
}

$model_numbers_json1 = array();
if (!empty($products1)) {
    foreach ($products1 as $list) {
        $model_numbers_json1[] = '{ value: "' . $list['model_no'] . '", id: "' . $list['id'] . '"}';
    }
}

$customers_json = array();
if (!empty($customers)) {
    foreach ($customers as $list) {
        $customers_json[] = '{ id: "' . $list['id'] . '", value: "' . $list['store_name'] . '"}';
    }
}
$invoice_json = array();
if (!empty($invoice)) {
    foreach ($invoice as $list) {
        $invoice_json[] = '{ id: "' . $list['customer'] . '", value: "' . $list['inv_id'] . '", inv_id: "' . $list['invoice_id'] . '"}';
    }
}
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Add Inward DC</h5>
            </div>

            <div class="card-block">
                <table class="static" style="display: none;">
                    <tr>
                        <td >
                            <input type="text"  name="model_no[]" id="model_no" tabindex="6"  class='form-control auto_customer tabwid model_no ' />
                            <span class="error_msg text-danger"></span>
                            <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-control product_id' />
                            <input type="hidden"  name="product_type[]" id="type" class=' tabwid form-control type' />
                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                        </td>
                        <td>
                            <input type="text" name="serial_no[]" id='serial_no'  class='form-control'>
                            <span class="error_msg text-danger"></span>
                        </td>
                        <td>
                            <textarea  name="product_description[]" tabindex="-1"  id="product_description" class='form-control auto_customer tabwid4 product_description' onkeyup='f2(this);'/>  </textarea>

                        </td>
                        <td class="action-btn-align">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="label label-primary">Stock.Qty</label>
                                    <input type="text"   tabindex="-1"  name='available_quantity[]' class="stock_qty max_qty form-control m-t-5 cent-align"  readonly="readonly" />
                                </div>
                                <div class="col-md-6">
                                    <label class="label label-info">DC.Qty</label>
                                    <input type="text"   tabindex="6"  name='dc_quantity[]'  class="m-t-5 dc_qty int_val form-control cent-align required" onkeypress="return isNumber(event, this)" />
                                </div>
                                <span class="error_msg" style="padding-left:22px;"></span>
                            </div>
                        </td>
                        <td class="action-btn-align">
                            <a href="javascript:void(0);" class="green up order-icon" tabindex="-1"><i class="fa fa-long-arrow-up"></i></a> &nbsp;
                            <a class="red down order-icon" href="javascript:void(0);" tabindex="-1"><i class="fa fa-long-arrow-down"></i></a>&nbsp;
                            <a id='delete_group' tabindex="-1" class="del btn btn-danger btn-mini"><span class="fa fa-trash"></span></a>
                        </td>
                    </tr>
                </table>
                <table class="static_ser" style="display: none;">
                    <tr>

                        <td >
                            <input type="text"  name="model_no[]" tabindex="6" id="model_no_ser" class='form-control auto_customer tabwid model_no_ser ' />
                            <span class="error_msg text-danger"></span>
                            <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-control product_id' />
                            <input type="hidden"  name="product_type[]" id="type_ser" class=' tabwid form-control type type_ser' />
                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                        </td>
                        <td>
                            <input type="text" name="serial_no[]" id='serial_no'  class='form-control'>
                            <span class="error_msg text-danger"></span>
                        </td>
                        <td>
                            <textarea  name="product_description[]" tabindex="-1"  id="product_description" class='form-control auto_customer tabwid4 product_description' onkeyup='f2(this);'/>  </textarea>

                        </td>
                        <td class="action-btn-align">
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="label label-info">DC.Qty</label>
                                    <input type="text"   tabindex="6"  name='dc_quantity[]'  class="m-t-5 dc_qty int_val form-control cent-align required" onkeypress="return isNumber(event, this)" />
                                </div>
                                <span class="error_msg" style="padding-left:22px;"></span>
                            </div>
                            <input type="text"   tabindex="-1"  name='quantity[]' class="qty form-control cent-align" id="qty"/>
                            <span class="error_msg text-danger"></span>
                        </td>
                        <td class="action-btn-align">
                            <a href="javascript:void(0);" class="green up order-icon" tabindex="-1"><i class="fa fa-long-arrow-up"></i></a> &nbsp;
                            <a class="red down order-icon" href="javascript:void(0);" tabindex="-1"><i class="fa fa-long-arrow-down"></i></a>&nbsp;
                            <a id='delete_group' class="del btn btn-danger btn-mini" tabindex="-1"><span class="fa fa-trash"></span></a>
                        </td>
                    </tr>
                </table>
                <form  id="quotation" method="post" novalidate>
                    <div class="form-material row">
                        <div class="col-md-3">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-address-book"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <label class="float-label">Inward DC NO</label>
                                    <input type="text"  tabindex="-1" name="quotation[dc_no]" class="code form-control colournamedup" readonly="readonly" value="<?php echo $last_id; ?>"  id="dc_no">
                                    <span class="form-bar"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-address-book"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <label class="float-label">Invoice NO</label>
                                    <input type="text" name="inv_no" tabindex="1" class="form-control"  id="invoice_number">
                                    <input type="hidden"  name="quotation[inv_id]" id="invoice_id" class=' tabwid form-control' />
                                    <input type="hidden"  name="quotation[service_type]" value="inward" id="invoice_id" class=' tabwid form-control' />
                                    <span class="form-bar"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-briefcase-alt-1"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <label class="float-label">Company Name <span class="req">*</span></label>
                                    <input type="text"  name="customer[store_name]" id="customer_name" tabindex="2" class='form-control auto_customer required' />
                                    <span class="form-bar"></span>
                                    <span class="error_msg text-danger"></span>
                                    <input type="hidden"  name="customer[id]" id="customer_id" class='id_customer form-control' />
                                    <!--<input type="hidden"  name="quotation[product_id]" id="cust_id" class='id_customer' />-->
                                    <div id="suggesstion-box" class="auto-asset-search "></div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-call"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <label class="float-label">Customer Mobile No <span class="req">*</span></label>
                                    <input type="text"  name="customer[mobil_number]" id="customer_no" class="form-control  required" tabindex="-1"  />
                                    <span class="form-bar"></span>
                                    <span class="error_msg text-danger"></span>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-material row">
                        <div class="col-md-3">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-email"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <label class="float-label">Customer Email ID <span class="req">*</span></label>
                                    <input type="text"  name="customer[email_id]" id="email_id" class="form-control required" tabindex="-1"/>
                                    <span class="form-bar"></span>
                                    <span class="error_msg text-danger"></span>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-location-pin"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <label class="float-label">Customer Address <span class="req">*</span></label>
                                    <textarea name="customer[address1]" id="address1" class="form-control required" tabindex="-1"></textarea>
                                    <span class="form-bar"></span>
                                    <span class="error_msg text-danger"></span>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-calendar"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <label class="float-label new-class1">Date <span class="req">*</span></label>
                                    <input tabindex="3" id="dropper-default" name="quotation[created_date]" data-date="" data-month="" data-year="" value="<?php echo date('d-M-Y'); ?>" class="form-control required dropper-default" type="text" placeholder="" />
                                    <span class="form-bar"></span>
                                    <span class="error_msg text-danger"></span>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-architecture-alt"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <label class="float-label">Project <span class="req">*</span></label>
                                    <input name="quotation[project]"  type="text" class="form-control project_name required"  tabindex="4" />
                                    <span class="form-bar"></span>
                                    <span class="error_msg text-danger"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-tasks-alt"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <label class="float-label">Complaint Details <span class="req">*</span></label>
                                    <textarea name="quotation[complaint_details]" id="complaint" class="form-control required" tabindex="-1"></textarea>
                                    <span class="form-bar"></span>
                                    <span class="error_msg text-danger"></span>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row card-block table-border-style">
                        <div class="table-responsive">
                            <div class="action-btn-inner-table">
                                <a id='add_group' class="btn btn-primary btn-mini waves-effect waves-light d-inline-block md-trigger"><i class="fa fa-plus"></i> Add Product</a>
                                <a id='add_group_service' class="btn btn-primary btn-mini waves-effect waves-light d-inline-block md-trigger "><i class="fa fa-plus"></i> Add Service</a>
                            </div>
                            <table class="table table-bordered" id="add_quotation" >
                                <thead>
                                    <tr>
                                        <td width="10%" class="first_td1">Model Number</td>
                                        <td width="10%" class="first_td1">Serial No</td>
                                        <td width="10%" class="first_td1">Product Description</td>
                                        <td width="10%" class="first_td1 action-btn-align">QTY</td>
                                        <td width="5%" class="action-btn-align remove_nowrap">
                                    </tr>
                                </thead>
                                <tbody id="service_tr">

                                </tbody>
                                <tbody id='app_table'>
                                    <tr>

                                        <td >
                                            <input type="text"  name="model_no[]" id="model_no" tabindex="4"  class='form-control auto_customer tabwid model_no required' />
                                            <span class="error_msg text-danger"></span>
                                            <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-control' />
                                            <input type="hidden"  name="product_type[]" id="type" class=' tabwid form-control type' />
                                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                                        </td>
                                        <td>
                                            <input type="text" name="serial_no[]" id='serial_no'  class='form-control required'>
                                            <span class="error_msg text-danger"></span>
                                        </td>
                                        <td>
                                            <textarea  name="product_description[]"   id="product_description" class='form-control auto_customer tabwid4 product_description' onkeyup='f2(this);'/> </textarea>
                                        </td>
                                        <td class="action-btn-align">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="label label-primary">Stock.Qty</label>
                                                    <input type="text"   tabindex="-1"  name='available_quantity[]' class="stock_qty max_qty form-control m-t-5 cent-align"  readonly="readonly" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="label label-info">DC.Qty</label>
                                                    <input type="text"   tabindex="5"  name='dc_quantity[]'  class="m-t-5 dc_qty int_val form-control cent-align required" onkeypress="return isNumber(event, this)" />
                                                </div>
                                                <span class="error_msg" style="padding-left:22px;"></span>
                                            </div>

                                        <td class="action-btn-align">
                                            <a href="javascript:void(0);" class="green up order-icon" tabindex="-1"><i class="fa fa-long-arrow-up"></i></a> &nbsp;
                                            <a class="red down order-icon" href="javascript:void(0);" tabindex="-1"><i class="fa fa-long-arrow-down"></i></a> &nbsp;
                                            <a id='delete_group' class="del btn btn-danger btn-mini" tabindex="-1"><span class="fa fa-trash"></span></a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2"></td>
                                        <td  class="totbold" style=" text-align:right;">Total</td>
                                        <td class="action-btn-align"><input type="text"   name="quotation[total_qty]"  readonly="readonly" class="total_qty form-control cent-align" id="total" tabindex="-1"/></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 ">
                            <h4 class="sub-title">TERMS AND CONDITIONS</h4>
                            <div class="form-material  row m-t-15">
                                <div class="col-md-4">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-address-book"></i>
                                        </div>

                                        <div class="form-group form-primary">
                                            <label class="float-label">Remarks</label>
                                            <textarea class="form-control remark" tabindex="7" name="quotation[remarks]" ></textarea>
                                            <span class="form-bar"></span>

                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-bank"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Delivery</label>
                                            <input type="text" tabindex="8" class="form-control class_req terms" name="quotation[delivery]"  onkeyup='f2(this);'/>
                                            <span class="form-bar"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-address-book"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Warranty</label>
                                            <input type="text" tabindex="9" class="form-control class_req terms" name="quotation[warranty]"  onkeyup='f2(this);'/>

                                            <input type="hidden"  name="quotation[customer]" id="c_id" class="id_customer" />
                                            <input type="hidden"  name="gst_type" id="gst_type" class="gst_type" />
                                            <span class="form-bar"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row m-10">
                        <div class="col-md-12 text-center">
                            <button  id="save" class="btn btn-primary m-b-10 btn-sm waves-effect waves-light" tabindex="10">Create</button>
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

    $('#add_quotation').on('click', '.up', function () {
        var thisRow = $(this).closest('tr');
        var prevRow = thisRow.prev();
        if (prevRow.length) {
            prevRow.before(thisRow);
        }
    });

    $('#add_quotation').on('click', '.down', function () {
        var thisRow = $(this).closest('tr');
        var nextRow = thisRow.next();
        if (nextRow.length) {
            nextRow.after(thisRow);
        }
    });
    $(document).ready(function () {
        /* $(document).on('blur', ".dc_qty", function () {
         var dc_qty = $(this).val();
         var qty = $(this).closest('tr').find('.max_qty').val();
         if (Number(dc_qty) > Number(qty))
         {
         $(this).closest('td').find('.error_msg').text('Invalid Qty').css('display', 'inline-block');
         } else {
         $(this).closest('td').find('.error_msg').text("");
         }
         });*/
        $('#save').on('click', function () {

            m = 0;
            /*  $('.dc_qty').each(function () {
             var qty = $(this).closest('tr').find('.max_qty').val();
             this_val = $.trim($(this).val());
             if (this_val != "") {
             if (Number(this_val) > Number(qty))
             {
             $(this).closest('td').find('.error_msg').text('Invalid Qty').css('display', 'inline-block');
             m = 1;
             } else {
             $(this).closest('td').find('.error_msg').text("");
             }
             }
             }); */
            $('#quotation .required').each(function () {
                this_val = $.trim($(this).val());
                this_id = $(this).attr("id");
                if (this_val == "") {
                    $(this).closest('div .form-group').find('.error_msg').text('This field is required').css('display', 'inline-block');
                    $(this).closest('td').find('.error_msg').text('This field is required').css('display', 'inline-block');
                    m++;
                } else {
                    $(this).closest('div .form-group').find('.error_msg').text('');
                    $(this).closest('td').find('.error_msg').text('');
                }
            });
            if (m > 0) {
                return false;
            }

        });

        $('body').on('keydown', 'input#invoice_number', function (e) {
            $('.total_qty').val('');
            var c_data = [<?php echo implode(',', $invoice_json); ?>];

            $("#invoice_number").autocomplete({
                source: function (request, response) {
                    // filter array to only entries you want to display limited to 10
                    var outputArray = new Array();
                    for (var i = 0; i < c_data.length; i++) {
                        if (c_data[i].value.toLowerCase().match(request.term.toLowerCase())) {
                            outputArray.push(c_data[i]);
                        }
                    }
                    response(outputArray.slice(0, 10));
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
                            $('#service_tr').html('');
                            $('#app_table').html('');
                            result = JSON.parse(data);
                            if (result != null && result.length > 0) {
                                $("#customer_no").parent().find(".float-label").removeClass('newClass1');
                                $("#customer_no").parent().find(".float-label").addClass('newClass');
                                $("#email_id").parent().find(".float-label").removeClass('newClass1');
                                $("#email_id").parent().find(".float-label").addClass('newClass');
                                $("#address1").parent().find(".float-label").removeClass('newClass1');
                                $("#address1").parent().find(".float-label").addClass('newClass');
                                $("#customer_name").parent().find(".float-label").removeClass('newClass1');
                                $("#customer_name").parent().find(".float-label").addClass('newClass');
                                $("#gst_type").val(result[0].state_id);
                                $("#customer_id").val(result[0].id);
                                $("#c_id").val(result[0].id);
                                $("#customer_name").val(result[0].store_name);
                                $("#customer_no").val(result[0].mobil_number);
                                $("#email_id").val(result[0].email_id);
                                $("#address1").val(result[0].address1);
                                $("#tin").val(result[0].tin);
                                $("#invoice_id").val(ui.item.inv_id);
                                clone_invoice_tr(ui.item.inv_id);
                            }
                        }
                    });
                }
            });
        });
        $('body').on('keydown', 'input#customer_name', function (e) {
            $('#invoice_number').val('');
            $('#service_tr').html('');
            $('.total_qty').val('');
            var c_data = [<?php echo implode(',', $customers_json); ?>];
            $("#customer_name").autocomplete({
                source: function (request, response) {
                    // filter array to only entries you want to display limited to 10
                    var outputArray = new Array();
                    for (var i = 0; i < c_data.length; i++) {
                        if (c_data[i].value.toLowerCase().match(request.term.toLowerCase())) {
                            outputArray.push(c_data[i]);
                        }
                    }
                    response(outputArray.slice(0, 10));
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
                                $("#customer_no").parent().find(".float-label").removeClass('newClass1');
                                $("#customer_no").parent().find(".float-label").addClass('newClass');
                                $("#email_id").parent().find(".float-label").removeClass('newClass1');
                                $("#email_id").parent().find(".float-label").addClass('newClass');
                                $("#address1").parent().find(".float-label").removeClass('newClass1');
                                $("#address1").parent().find(".float-label").addClass('newClass');
                                $("#gst_type").val(result[0].state_id);
                                $("#customer_id").val(result[0].id);
                                $("#c_id").val(result[0].id);
                                $("#customer_name").val(result[0].store_name);
                                $("#customer_no").val(result[0].mobil_number);
                                $("#email_id").val(result[0].email_id);
                                $("#address1").val(result[0].address1);
                                $("#tin").val(result[0].tin);
                            }
                        }
                    });
                }
            });
        });
        function clone_invoice_tr(inv_id) {
            var invoice_id = inv_id;
            $.ajax({
                url: BASE_URL + "service_inward_and_outward_dc/view_invoice",
                type: 'GET',
                data: {
                    q_id: invoice_id,
                    type: 'inward',
                },
                beforeSend: function () {
//                        for_loading(' Warranty Services Loading...');
                },
                success: function (result) {
                    $('#service_tr').append(result);
                }
            });
        }
    });

    function calculate_function()
    {
        var final_qty = 0;
        $('.dc_qty').each(function () {
            var qty = $(this);
            if (Number(qty.val()) != 0)
            {
                final_qty = final_qty + Number(qty.val());
            }

        });
        $('.total_qty').val(final_qty);

    }
    $('#add_group').click(function () {
        var tableBody = $(".static").find('tr').clone();
        $(tableBody).closest('tr').find('select,.model_no,.model_no_ser,.percost,.qty').addClass('required');
        $('#app_table').append(tableBody);

    });
    $('#add_group_service').click(function () {
        var tableBody = $(".static_ser").find('tr').clone();
        $(tableBody).closest('tr').find('select,.model_no,.model_no_ser,.percost,.qty').addClass('required');
        $('#app_table').append(tableBody);
    });
    $('#delete_group').live('click', function () {
        $(this).closest("tr").remove();
        calculate_function();
    });

    $(".remove_comments").live('click', function () {
        $(this).closest("tr").remove();
        var full_total = 0;
        $('.total_qty').each(function () {
            full_total = full_total + Number($(this).val());
        });
        $('.full_total').val(full_total);
        console.log(full_total);
    });

    $('.qty,.percost,.pertax,.totaltax,.dc_qty').live('keyup', function () {
        calculate_function();
    });


    $(document).ready(function () {
        jQuery('.datepicker').datepicker();
    });
    $().ready(function () {
        $("#po_no").autocomplete(BASE_URL + "gen/get_po_list", {
            width: 260,
            autoFocus: true,
            matchContains: true,
            selectFirst: false
        });
    });
    $('#search').live('click', function () {
        for_loading();
        $.ajax({
            url: BASE_URL + "po/search_result",
            type: 'GET',
            data: {
                po: $('#po_no').val(),
                style: $('#style').val(),
                supplier: $('#supplier').val(),
                supplier_name: $('#supplier').find('option:selected').text(),
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val()
            },
            success: function (result) {
                for_response();
                $('#result_div').html(result);
            }
        });
    });

</script>
<script>
    $(document).ready(function () {
        $('body').on('keydown', 'input.model_no', function (e) {
            var product_data = {};
            product_data.results = [<?php echo implode(',', $model_numbers_json); ?>];
            cust_id = $('#customer_id').val();
            $(".product_id").each(function () {

                if ($(this).val() != '') {
                    Array.prototype.removeValue = function (name, value) {
                        var array = $.map(this, function (v, i) {
                            return v[name] === value ? null : v;
                        });
                        this.length = 0; //clear original array
                        this.push.apply(this, array); //push all elements except the one we want to delete
                    }

                    product_data.results.removeValue('id', $(this).val());
                }
            });
            $(".model_no").autocomplete({
                source: function (request, response) {
                    // filter array to only entries you want to display limited to 10
                    var outputArray = new Array();
                    for (var i = 0; i < product_data.results.length; i++) {
                        if (product_data.results[i].value.toLowerCase().match(request.term.toLowerCase())) {
                            outputArray.push(product_data.results[i]);
                        }
                    }
                    if (outputArray.length == 0) {
                        var nodata = 'No Product Found';
                        outputArray.push(nodata);
                    }
                    response(outputArray.slice(0, 10));
                },
                minLength: 0,
                autoFill: false,
                select: function (event, ui) {
                    this_val = $(this);
                    product = ui.item.value;
                    $(this).val(product);
                    model_number_id = ui.item.id;
                    if (product == 'No Product Found') {
                        this_val.closest('tr').find('.model_no').val('');
                        this_val.closest('tr').find('.brand').val('');
                        this_val.closest('tr').find('.cat_id').val('');
                        this_val.closest('tr').find('.selling_price').val('');
                        this_val.closest('tr').find('.type').val('');
                        this_val.closest('tr').find('.product_id').val('');
                        this_val.closest('tr').find('.product_description').val('');
                        this_val.closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/no-img.gif' ?>");
                        this_val.closest('tr').find('.qty').val('');
                        this_val.closest('tr').find('.subtotal').val('');
                        this_val.closest('tr').find('.stock_qty').val('');
                        calculate_function();
                    } else {
                        $.ajax({
                            type: 'POST',
                            data: {model_number_id: model_number_id, c_id: cust_id},
                            url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_product/",
                            success: function (data) {
                                result = JSON.parse(data);
                                if (result != null && result.length > 0) {
                                    if (result[0].quantity != null) {
                                        this_val.closest('tr').find('.stock_qty').val(result[0].quantity);
                                    } else {
                                        this_val.closest('tr').find('.stock_qty').val('0');
                                    }
                                    this_val.closest('tr').find('.brand').val(result[0].brand_id);
                                    this_val.closest('tr').find('.cat_id').val(result[0].category_id);
//                                this_val.closest('tr').find('.pertax').val(result[0].cgst);
//                                this_val.closest('tr').find('.gst').val(result[0].sgst);
                                    this_val.closest('tr').find('.discount').val(result[0].discount);
                                    this_val.closest('tr').find('.selling_price').val(result[0].selling_price);
                                    this_val.closest('tr').find('.type').val(result[0].type);
                                    this_val.closest('tr').find('.product_id').val(result[0].id);
                                    this_val.closest('tr').find('.model_no').val(result[0].model_no);
                                    //  this_val.closest('tr').find('.model_no_extra').val(result[0].model_no);
                                    this_val.closest('tr').find('.product_description').val(result[0].product_description);

                                    calculate_function();
                                    this_val.closest('tr').find('.dc_qty').focus();
                                }
                            }
                        });
                    }
                }
            });
        });
    });

    $(document).ready(function () {

        $('body').on('keydown', 'input.model_no_ser', function (e) {
            var product_data = [<?php echo implode(',', $model_numbers_json1); ?>];

            cust_id = $('#customer_id').val();
            $(".model_no_ser").autocomplete({
                source: function (request, response) {
                    // filter array to only entries you want to display limited to 10
                    var outputArray = new Array();
                    for (var i = 0; i < product_data.length; i++) {
                        if (product_data[i].value.toLowerCase().match(request.term.toLowerCase())) {
                            outputArray.push(product_data[i]);
                        }
                    }
                    response(outputArray.slice(0, 10));
                },
                minLength: 0,
                autoFill: false,
                select: function (event, ui) {
                    this_val = $(this);
                    product = ui.item.value;
                    $(this).val(product);
                    model_number_id = ui.item.id;
                    $.ajax({
                        type: 'POST',
                        data: {model_number_id: model_number_id, c_id: cust_id},
                        url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_service/",
                        success: function (data) {

                            result = JSON.parse(data);
                            if (result != null && result.length > 0) {
                                this_val.closest('tr').find('.brand').val(result[0].brand_id);
                                this_val.closest('tr').find('.cat_id').val(result[0].category_id);
                                this_val.closest('tr').find('.discount').val(result[0].discount);
                                this_val.closest('tr').find('.selling_price').val(result[0].selling_price);
                                this_val.closest('tr').find('.type').val(result[0].type);
                                this_val.closest('tr').find('.product_id').val(result[0].id);
                                // this_val.closest('tr').find('.model_no').val(result[0].product_name);
                                this_val.closest('tr').find('.model_no_ser').val(result[0].model_no);
                                this_val.closest('tr').find('.product_description').val(result[0].product_description);
                                calculate_function();
                                this_val.closest('tr').find('.dc_qty').focus();
                            }
                        }
                    });
                }
            });
        });
    });
//    $(".model_no").live('keyup', function () {
//        var this_ = $(this)
//        $.ajax({
//            type: "GET",
//            url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_product",
//            data: 'q=' + $(this).val(),
//            success: function (datas) {
//                this_.closest('tr').find(".suggesstion-box1").show();
//                this_.closest('tr').find(".suggesstion-box1").html(datas);
//
//            }
//        });
//    });
//    $("#model_no_ser").live('keyup', function () {
//        var this_ = $(this)
//        $.ajax({
//            type: "GET",
//            url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_service",
//            data: 's=' + $(this).val(),
//            success: function (datas) {
//                this_.closest('tr').find(".suggesstion-box1").show();
//                this_.closest('tr').find(".suggesstion-box1").html(datas);
//
//            }
//        });
//    });
    $("#ref_class").live('change', function () {
        var nick = $("#ref_class option:selected").text().split("-");
        var increment_id = $('#grn_no').val().split("/");
        final_id = increment_id[0] + '/' + nick[1] + '/' + increment_id[2] + '/' + increment_id[3];
        $('#grn_no').val(final_id);
    });

    $(document).ready(function () {

        $('body').click(function () {
            $(this).closest('tr').find(".suggesstion-box1").hide();
        });
    });
    $('.pro_class').live('click', function () {
        $(this).closest('tr').find('.brand').val($(this).attr('pro_brand'));
        $(this).closest('tr').find('.cat_id').val($(this).attr('pro_cat'));
        //$(this).closest('tr').find('.selling_price').val($(this).attr('pro_sell'));
        $(this).closest('tr').find('.selling_price').val($(this).attr('pro_sell'));
        $(this).closest('tr').find('.type').val($(this).attr('pro_type'));
        $(this).closest('tr').find('.product_id').val($(this).attr('pro_id'));
        $(this).closest('tr').find('.model_no').val($(this).attr('mod_no'));
        $(this).closest('tr').find('.product_description').val($(this).attr('pro_name') + "\n" + $(this).attr('pro_description'));
        $(this).closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + $(this).attr('pro_image'));
        $(this).closest('tr').find(".suggesstion-box1").hide();
        calculate_function();
    });
    $('.ser_class').live('click', function () {
        $(this).closest('tr').find('.brand').val($(this).attr('ser_brand'));
        $(this).closest('tr').find('.cat_id').val($(this).attr('ser_cat'));
        //$(this).closest('tr').find('.selling_price').val($(this).attr('ser_sell'));
        $(this).closest('tr').find('.selling_price').val($(this).attr('ser_sell'));
        $(this).closest('tr').find('.type_ser').val($(this).attr('ser_type'));
        $(this).closest('tr').find('.product_id').val($(this).attr('ser_id'));
        $(this).closest('tr').find('.model_no_ser').val($(this).attr('ser_no'));
        $(this).closest('tr').find('.product_description').val($(this).attr('ser_name') + "\n" + $(this).attr('ser_description'));
        $(this).closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + $(this).attr('ser_image'));
        $(this).closest('tr').find(".suggesstion-box1").hide();
        calculate_function();
    });
    function f2(textarea)
    {
        string = textarea.value;
        string = string.toUpperCase();
        textarea.value = string;
    }
    function isNumber(evt, this_ele) {
        this_val = $(this_ele).val();
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (evt.which == 13) {//Enter key pressed
            $(".thVal").blur();
            return false;
        }
        if (charCode > 39 && charCode > 37 && charCode > 31 && ((charCode != 46 && charCode < 48) || charCode > 57 || (charCode == 46 && this_val.indexOf('.') != -1))) {
            return false;
        } else {
            return true;
        }

    }

</script>
