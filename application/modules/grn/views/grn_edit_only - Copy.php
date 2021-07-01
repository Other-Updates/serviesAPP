<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .ui-helper-hidden-accessible {
        display: none;
    }
    .serial_error_msg {
        font-size: 13px;
        color: #ff5252 !important;
    }
</style>
<?php if ($from == 1) { ?>

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Goods Receive Note Using Scanner</h5>
                </div>
                <div class="card-block" style="width:40%;margin:0 auto;">
                    <table  class="table table-striped table-bordered " style="margin:0 auto;width:50%">
                        <tr>
                            <td id='error'></td>
                        </tr>
                    </table>
                    <form method="post" action="<?php echo $this->config->item('base_url') . 'grn/'; ?>">
                    <?php } ?>
                    <div class="col-sm-12 ">
                        <div class="form-material row m-t-15">
                            <div class="col-md-4">
                                <div class="material-group">
                                    <div class="material-addone">
                                        <i class="icofont icofont-address-book"></i>
                                    </div>
                                    <div class="form-group form-primary">
                                        <label class="float-label">Vendor Invoice No</label>
                                        <input type="text" name="gen[vendor_inv_no]" class="form-control vendot_inv_no" id="vendot_inv_no" />
                                        <span class="form-bar"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="gen[po_no]" value='<?= $gen_info[0]['po_no'] ?>'  />
                    <table style="width:50%;margin:0 auto;" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                        <tr>
                            <td class="first_td1">PO NO</td>
                            <td >
                                <b><?= $gen_info[0]['po_no'] ?></b>
                                <input type="hidden" value="<?= $gen_info[0]['po_no'] ?>"  name="po_no">
                            </td>
                            <td class="first_td1">Vendor</td>
                            <td id='customer_td'>
                                <?= $gen_info[0]['store_name'] ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="first_td1">GRN NO</td>
                            <td><b><?= $last_no ?></b></td>
                        <input type="hidden" value="<?php echo $last_no ?>" name="grn_no">
                        <td class="first_td1">Date</td>
                        <td >
                            <?= date('d-M-Y', strtotime($gen_info[0]['created_date'])) ?>
                        </td>

                        </tr>

                    </table>

                    <div class="row card-block table-border-style">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline"  id="add_quotation">
                                <thead>
                                    <tr>
                                        <td width="10%" class="first_td1">Category</td>
                                        <td width="10%" class="first_td1">Product Serial No</td>
                                        <td width="10%" class="first_td1">Warranty</td>
                                        <td width="10%" class="first_td1">Brand</td>
                                        <td width="10%" class="first_td1">Model Number</td>
                                        <?php if ($gen_info[0]['is_gst'] == 1) { ?>
                                            <td width="10%" class="first_td1 hst_td">HSN Code</td>
                                        <?php } else { ?>
                                            <td width="5%" class="first_td1 add_amount">Add Amt</td>
                                        <?php } ?>
                                        <td  width="8%" class="first_td1">QTY</td>
                                        <td  width="5%" class="first_td1">Unit Price</td>
                                        <?php if ($gen_info[0]['is_gst'] == 1) { ?>
                                            <td width="6%" class="first_td1 action-btn-align proimg-wid">CGST%</td>
                                            <?php
                                            $gst_type = $gen_info[0]['state_id'];
                                            if ($gst_type != '') {
                                                if ($gst_type == 31) {
                                                    ?>
                                                    <td  width="6%" class="first_td1 action-btn-align proimg-wid" >SGST%</td>
                                                <?php } else { ?>
                                                    <td  width="6%" class="first_td1 action-btn-align proimg-wid" >IGST%</td>

                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                        <td  width="2%" class="first_td1" style="display:none">Tax</td>
                                        <td  width="7%" class="first_td1">Net Value</td>
                                    </tr>
                                </thead>
                                <tbody id='app_table'>
                                    <?php
                                    $cgst = 0;
                                    $sgst = 0;
                                    if (isset($po_details) && !empty($po_details)) {
                                        foreach ($po_details as $vals) {
                                            $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);

                                            $gst_type = $gen_info[0]['state_id'];
                                            if ($gst_type != '') {
                                                if ($gst_type == 31) {

                                                    $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);
                                                } else {
                                                    $sgst1 = ($vals['igst'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);
                                                }
                                            }
                                            $cgst += $cgst1;
                                            $sgst += $sgst1;

                                            $current_quantity = $vals['quantity'] - $vals['return_quantity'] - $vals['delivery_quantity'];
                                            ?>
                                            <tr class="inc_class<?php echo $vals['id'] ?>" data-inc="<?php echo $vals['id'] ?>">
                                                <td>
                                                    <input type="hidden"  name="type[]" id="type"  value="<?php echo $vals['po_type'] ?>"/>
                                                    <input type="hidden"  name="po_details_id[]"  value="<?php echo $vals['po_details_id'] ?>"/>
                                                    <input  name="product_description[]" id="product_description" type="hidden" value="<?php echo $vals['product_description']; ?>" class='form-control product_description'  />
                                                    <input type="hidden" id="gst_check_status" name="gen[is_gst]" value="<?php echo $gen_info[0]['is_gst'] ?>">
                                                    <input type="hidden" class='cat_id static_style form-control' name='categoty[]' readonly="" value='<?php echo $vals['cat_id'] ?>'>
                                                    <input type="text" class="form-control" readonly="" value='<?php echo $vals['categoryName'] ?>'>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input class="form-control serial_number" name="product_serial_no[]">
                                                        <span class="input-group-append serial_modal_add">
                                                            <label class="input-group-text " title="Add Serial Code" data-toggle="modal" data-target="#exampleModal-4" data-whatever="@mdo"><i class="fa fa-plus"></i></label>
                                                        </span>
                                                        <span class="serial_error_msg"></span>
                                                    </div>
                                                </td>
        <!--                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control serial_number" name="product_serial_no[]">
                                                        <span class="input-group-append serial_modal_add" id="basic-addon3" id="serial_code_add" title="Add Serial Code" onclick="serial_modal(<?php echo $vals['id']; ?>)">
                                                            <label class="input-group-text " >+</label>
                                                        </span>
                                                        <span class="serial_error_msg"></span>
                                                    </div>
                                                </td>-->
                                                <td>
                                                    <?php
                                                    if ($vals['is_warranty'] == 1) {
                                                        $warranty = 'Warranty Item' . ' ' . date('d-M-Y', strtotime($vals['created_date'])) . ' - ' . date('d-M-Y', strtotime('+1 year', strtotime($vals['created_date'])));
                                                    } else {
                                                        $warranty = 'Non-Warranty Item';
                                                    }
                                                    ?>
                                                    <input type="text" class="form-control" readonly="" value='<?php echo $warranty ?>'>
                                                </td>
                                                <td>
                                                    <input type="hidden"  name='brand[]' readonly="" value='<?php echo $vals['id'] ?>'>
                                                    <input type="text"  class=" form-control" readonly="" value='<?php echo $vals['brands'] ?>'>
                                                </td>
                                        <div id="add_modal">

                                        </div>
                                        <td>
                                            <input type="text"  name="model_no[]" id="model_no" class='form-control auto_customer tabwid model_no' value="<?php echo $vals['model_no']; ?>" readonly="readonly"/>
                                            <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-control' value="<?php echo $vals['product_id']; ?>" />

                                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                                        </td>
                                        <?php if ($gen_info[0]['is_gst'] == 1) { ?>
                                            <td class="hsn_td">
                                                <input type="text"  name="hsn_sac[]" id="hsn_sac" class='form-control hsn_sac' value="<?php echo $vals['hsn_sac']; ?>" readonly="readonly"/>
                                            </td>
                                        <?php } else { ?>
                                            <td class="add_amount_td">
                                                <input type="text"  name="add_amount[]" id="add_amount" class='form-control add_amount right-align' value="<?php echo $vals['add_amount']; ?>" readonly="readonly"/>
                                            </td>
                                        <?php } ?>



                                        <td align="center">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="label label-primary">PO.Qty</label>
                                                    <input type="text"   tabindex="-1"  name='quantity[]' class="qty form-control m-t-5 po_qty cent-align" value="<?php echo $current_quantity ?>" readonly="readonly" />
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="label label-info">D.Qty</label>
                                                    <input type="text"   tabindex="1"  name='deliver_quantity[]'  class="m-t-5 deliver_qty int_val form-control cent-align" data-stock_qty="<?php echo $vals['stock'][0]['quantity'] ?>" data-current_qty="<?php echo $current_quantity ?>"/>
                                                </div>
                                                <span class="error_msg" style="padding-left:22px;"></span>
                                            </div>
                                        </td>


                                        <td>
                                            <input type="text"   tabindex="-1"  name='per_cost[]'  class="percost  form-control right-align" value="<?php echo $vals['per_cost'] ?>" readonly="readonly"/>

                                        </td>
                                        <?php if ($gen_info[0]['is_gst'] == 1) { ?>
                                            <td class="action-btn-align">
                                                <input type="text"   tabindex="-1"   name='tax[]' class="pertax cgst form-control cent-align" value="<?php echo $vals['tax'] ?>" readonly="readonly" />
                                            </td>
                                            <?php
                                            $gst_type = $gen_info[0]['state_id'];
                                            if ($gst_type != '') {
                                                if ($gst_type == 31) {
                                                    ?>
                                                    <td class="action-btn-align">
                                                        <input type="text"   tabindex="-1"   name='gst[]' class="gst form-control cent-align" value="<?php echo $vals['gst'] ?>" readonly="readonly" />
                                                    </td>
                                                <?php } else { ?>
                                                    <td class="action-btn-align">
                                                        <input type="text"   tabindex="-1"   name='igst[]' class="igst form-control cent-align" value="<?php echo $vals['igst'] ?>" readonly="readonly" />
                                                    </td>

                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                        <td>
                                            <input type="text"   tabindex="-1" name='sub_total[]' readonly="readonly" class="subtotal form-control text-right" value="" readonly="readonly"/>
                                        </td>

                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="6" class="totbold" style=" text-align:right;">Total</td>
                                        <td align="center"><input type="text"   name="gen[total_qty]"  tabindex="-1" readonly="readonly" value="" class="total_qty form-control cent-align"  id="total" readonly="readonly"/>
                                            <span class="error_msg"></span>
                                        </td>
                                        <?php if ($gen_info[0]['is_gst'] == 1) { ?>
                                            <td colspan="3" class="gst_add totbold" style="text-align:right;">Sub Total</td>
                                        <?php } else { ?>
                                            <td class="totbold" style="text-align:right;">Sub Total</td>
                                        <?php } ?>
                                        <td><input type="text" name="gen[subtotal_qty]"  tabindex="-1" readonly="readonly" value=""  class="final_sub_total form-control text-right" readonly="readonly"/></td>

                                    </tr>
                                    <?php if ($gen_info[0]['is_gst'] == 1) { ?>
                                        <tr>
                                            <td colspan="7" class="totbold" style="text-align:right !important;">CGST:</td>
                                            <td colspan="2" class="text-right"><input class="form-control text-right add_cgst" value="" tabindex="-1" readonly="readonly"></td>
                                            <?php
                                            $gst_type = $gen_info[0]['state_id'];
                                            if ($gst_type != '') {
                                                if ($gst_type == 31) {
                                                    ?>
                                                    <td  class="totbold" style="text-align:right;">SGST:</td>
                                                <?php } else { ?>
                                                    <td class="totbold" style="text-align:right;">IGST:</td>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <td class="text-right"><input class="form-control text-right add_sgst" value="" tabindex="-1" readonly="readonly"></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <?php if ($gen_info[0]['is_gst'] == 1) { ?>
                                            <td colspan="6"></td>
                                        <?php } else { ?>
                                            <td colspan="4" style="text-align:right;"></td>
                                        <?php } ?>
                                        <td colspan="4" style="text-align:right;font-weight:bold;"><input type="text"  name="gen[tax_label]" class='tax_label form-control text-right' value="<?php echo $gen_info[0]['tax_label']; ?>" readonly="readonly"/></td>
                                        <td>
                                            <input type="text"  name="gen[tax]" class='totaltax form-control text-right'  value="<?php echo $gen_info[0]['tax']; ?>"  readonly="readonly"/>
                                        </td>

                                    </tr>
                                    <tr>
                                        <?php if ($gen_info[0]['is_gst'] == 1) { ?>
                                            <td colspan="6"></td>
                                        <?php } else { ?>
                                            <td colspan="4" style="text-align:right;"></td>
                                        <?php } ?>
                                        <td colspan="4" style="text-align:right;font-weight:bold;">Parcel Charges</td>
                                        <td>
                                            <input type="text"  name="gen[parcel_charges]" class='parcel_tax form-control text-right'  value="<?php echo $gen_info[0]['parcel_charges']; ?>"  />
                                        </td>

                                    </tr>
                                    <tr>
                                        <?php if ($gen_info[0]['is_gst'] == 1) { ?>
                                            <td colspan="2"></td>
                                        <?php } ?>
                                        <td colspan="6" style=" text-align:right;"></td>
                                        <td colspan="2"style="text-align:right;font-weight:bold;">Net Total</td>
                                        <td><input type="text"  name="gen[net_total]"  readonly="readonly"  tabindex="-1" class="final_amt form-control text-right" value="" readonly="readonly"/></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 ">
                            <h4 class="sub-title">TERMS AND CONDITIONS</h4>
                            <div class="form-material row m-t-15">
                                <div class="col-md-4">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-building-alt"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Remarks</label>
                                            <input name="gen[remarks]" type="text" class="form-control remark" value="<?php echo $gen_info[0]['remarks']; ?>" readonly="readonly"/>
                                            <span class="form-bar"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-building-alt"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Mode of Payment</label>
                                            <input type="text" class="form-control class_req borderra0 terms" value="<?php echo $gen_info[0]['mode_of_payment']; ?>" name="gen[mode_of_payment]" readonly="readonly"/>
                                            <span class="form-bar"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-location-pin"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Received Location</label>
                                            <input name="gen[location]" type="text" class="form-control location" />
                                            <span class="form-bar"></span>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden"  name="gst_type" id="gst_type" class="gst_type" value="<?php echo $gen_info[0]['state_id']; ?>"/>
                                <input type="hidden"  name="gen[po_id]"  value="<?php echo $gen_info[0]['id']; ?>"/>
                                <input type="hidden"  name="gen[supplier]"  value="<?php echo $gen_info[0]['supplier']; ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row m-10">
                        <div class="col-md-12 text-center">
                            <input type="submit" class="btn btn-sm btn-primary waves-effect waves-light" id='add_gen' value="Update"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script>
            $(document).ready(function () {

                $(".remark").parent().find(".float-label").removeClass('newClass1');
                $(".remark").parent().find(".float-label").addClass('newClass');
                $(".terms").parent().find(".float-label").removeClass('newClass1');
                $(".terms").parent().find(".float-label").addClass('newClass');
                $('.totaltax').val("");
                $('.tax_label').val("");
            });
            $('.deliver_qty').on('keyup', function () {
                delivery_qty = $(this).val();
                if (delivery_qty) {
                    $(this).closest('tr').find('span.modal_show').show();
                } else {
                    $(this).closest('tr').find('span.modal_show').hide();
                }
            });
            $(".deliver_qty").on('keyup', function () {
                var current_qty = $(this).attr('data-current_qty');
                this_val = $.trim($(this).val());
                if (Number(this_val) != '' && Number(this_val) != 0) {

                    $('.total_qty').closest('td').find('span.error_msg').text("");
                    $('.totaltax').val("<?php echo $gen_info[0]['tax']; ?>");
                    $('.tax_label').val("<?php echo $gen_info[0]['tax_label']; ?>");
                } else {
                    $('.totaltax').val("");
                    $('.tax_label').val("");
                }
                if (Number(this_val) > Number(current_qty))
                {
                    $(this).closest('td').find('span.error_msg').text('Invalid Delivery Quantity').css('display', 'inline-block');
                } else {
                    $(this).closest('td').find('span.error_msg').text("");
                    $('.total_qty').closest('td').find('span.error_msg').text("");

                }
            });

            $(".po_no_dup").live('blur', function ()
            {
                po_no = $(".po_no_dup").val();
                //alert(po_no);
                $.ajax(
                        {
                            url: BASE_URL + "grn/po_duplication",
                            type: 'post',
                            data: {value1: po_no},
                            success: function (result)
                            {

                                $("#duplica").html(result);
                            }
                        });
            });
            $('#view_po').live('click', function () {
                var i = 0;
                var po = $("#po_no").val();
                if (po == '')
                {
                    $("#poerror").html("Enter PO NO");
                    i = 1;

                } else
                {
                    $("#poerror").html("");
                }
                po_no = $(".po_no_dup").val();
                $.ajax(
                        {
                            url: BASE_URL + "grn/po_duplication",
                            type: 'post',
                            data: {value1: po_no},
                            success: function (result)
                            {
                                if ((result.trim()).length > 0) {
                                    i = 1;
                                }
                                if (i == 1)
                                {
                                    return false;
                                } else
                                {
                                    //            for_loading();
                                    $.ajax({
                                        url: BASE_URL + "grn/view_po",
                                        type: 'GET',
                                        data: {
                                            po: $('#po_no').val()
                                        },
                                        success: function (result) {
                                            //                    for_response();
                                            $('#grn_html').html(result);
                                        }
                                    });
                                }
                            }
                        });
                if (i == 1)
                {
                    return false;
                } else
                {
                    return true;
                }
            });

            $('.deliver_qty,.parcel_tax').live('keyup', function () {
                calculate_function();
            });
            function calculate_function()
            {
                var final_qty = 0;
                var final_sub_total = 0;
                var cgst = 0;
                var sgst = 0;
                var gst_check_status = $("#gst_check_status").val();
                if (gst_check_status == 1) {
                    $('.deliver_qty').each(function () {
                        var qty = $(this);
                        var percost = $(this).closest('tr').find('.percost');
                        var pertax = $(this).closest('tr').find('.pertax');
                        if ($('#gst_type').val() != '')
                        {
                            if ($('#gst_type').val() == 31)
                            {
                                var gst = $(this).closest('tr').find('.gst');

                            } else {
                                gst = $(this).closest('tr').find('.igst');
                            }
                        }

                        var subtotal = $(this).closest('tr').find('.subtotal');
                        // alert (rq.val());
                        if (Number(qty.val()) > 0)
                        {
                            taxless = (Number(qty.val())) * Number(percost.val());
                            cgst += Number(pertax.val() / 100) * taxless;
                            sgst += Number(gst.val() / 100) * taxless;
                            sub_total = Number((Number(qty.val()) * Number(percost.val())));
                            subtotal.val(sub_total.toFixed(2));
                            final_qty = final_qty + parseInt(qty.val());
                            final_sub_total = final_sub_total + sub_total;

                        } else {
                            subtotal.val(0);
                        }
                    });
                    $('.add_cgst').val(cgst.toFixed(2));
                    $('.add_sgst').val(sgst.toFixed(2));
                    $('.total_qty').val(final_qty);
                    $('.final_sub_total').val(final_sub_total.toFixed(2));
                    $('.final_amt').val((final_sub_total + cgst + sgst + Number($('.totaltax').val()) + Number($('.parcel_tax').val())).toFixed(2));
                } else {
                    $('.deliver_qty').each(function () {
                        var qty = $(this);
                        var percost = $(this).closest('tr').find('.percost');
                        var pertax = $(this).closest('tr').find('.pertax');
                        var subtotal = $(this).closest('tr').find('.subtotal');
                        // alert (rq.val());
                        if (Number(qty.val()) > 0)
                        {
                            sub_total = ((Number(qty.val())) * (Number(percost.val())));
                            subtotal.val(sub_total.toFixed(2));
                            final_qty = final_qty + (Number(qty.val()));
                            final_sub_total = final_sub_total + sub_total;
                        } else if ((Number(qty.val())) == 0) {
                            subtotal.val(0);
                        }
                    });

                    $('.total_qty').val(final_qty);
                    $('.final_sub_total').val(final_sub_total.toFixed(2));
                    $('.final_amt').val((final_sub_total + Number($('.totaltax').val()) + Number($('.parcel_tax').val())).toFixed(2));
                }


            }

        </script>
        <script type="text/javascript">
            $(".int_val").live('keypress', function (event) {
                var characterCode = (event.charCode) ? event.charCode : event.which;
                var browser;
                if ($.browser.mozilla)
                {
                    if ((characterCode > 47 && characterCode < 58) || characterCode == 8 || event.keyCode == 39 || event.keyCode == 37 || characterCode == 97 || characterCode == 118)
                    {

                        return true;
                    }
                    return false;
                }
                if ($.browser.chrome)
                {
                    if (event.keyCode != 8 && event.keyCode != 0 && (event.keyCode < 48 || event.keyCode > 57)) {
                        //display error message

                        return false;
                    }
                }


            });
            function serial_modal(id) {
                var modal_id = "serial_code_modal" + id;
                var classname = "inc_class" + id;
                delivery_qty = $('.' + classname + '').find('.deliver_qty ').val();
                if (delivery_qty > 0) {
                    $('.' + classname + '').find('span.serial_error_msg').text('');
                    var html = '';
                    html += '<div id="serial_code_modal' + id + '" class="modal fade in" data-backdrop="false" tabindex="-1" class="serial_code_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false"' +
                            'align="center" style="display: none;">' +
                            '<div class="modal-dialog ">' +
                            '<div class="modal-content modalcontent-top">' +
                            '<div class="modal-header modal-padding modalcolor "><a class="close modal-close closecolor"  onclick="ime_modal_discard(' + id + ')">×</a>' +
                            '<h3 id="myModalLabel" style="color:white;margin-top:10px">Product S.Code</h3>' +
                            ' </div>' +
                            '<div class="modal-body modal_scroll">' +
                            '<form>' +
                            '<div class="row">';


                    for (i = 1; i <= delivery_qty; i++) {
                        html += '<div class="serial_code_loop"><div class="row col-md-12">' +
                                '<div class="col-md-6">' +
                                '<h5><strong>Serial No ' + i + '</strong></h5>' +
                                '</div>' +
                                '<div class="col-md-6 serial_code_div">' +
                                '<input type="text" class=" form-control serial_code_width serial_code" name="serail_code[]" value="" id="serail_code' + id + i + '" maxlength="15" autocomplete="off">' +
                                '</div></div></div>';
                    }


                    html += '</div>' +
                            '</form>' +
                            '</div>' +
                            '<div class="modal-footer action-btn-align" style="">' +
                            ' <button type="button" class="edit btn btn-info1 update_serial" tabindex="3" onclick="serial_modal_update(' + id + "," + delivery_qty + ')">Update</button>' +
                            '<button type="button" class="btn btn-danger1 "  onclick="serail_modal_discard(' + id + ')"> Discard</button>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div> ';
                    $('#add_modal').html(html);

                    $('#' + modal_id + '').modal('show');


                } else {
                    $('.' + classname + '').find('span.serial_error_msg').text('Please Enter D.Qty');
                }
            }

        </script>
        <?php if ($from == 1) { ?>
        </div>
    </div>
<?php }
?>
<div class="modal fade in" id="exampleModal-4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel-4" aria-hidden="false" align="center" style="display:none">
    <div class="modal-dialog">
        <div class="modal-content modalcontent-top">
            <div class="modal-header modal-padding modalcolor">
                <h5 class="modal-title" id="exampleModalLabel-4">Insert Product S.No</h5>
                <a class="close modal-close closecolor" data-dismiss="modal">×</a>
            </div>
            <div class="modal-body">
                <form id="customer_model_form" action="<?php echo $this->config->item('base_url'); ?>" enctype="multipart/form-data" name="form" method="post">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">S.No</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control">
                            <span class="error_msg"></span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer action-btn-align">
                <button type="button" class="btn btn-primary btn-sm" id="update_customer">Update</button>
                <button type="button" class="btn btn-danger btn-sm" id="no" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>