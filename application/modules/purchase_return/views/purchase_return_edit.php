<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<style>
    .remark {

    }
    .sub-title {
        margin-bottom: 0px;
    }
    .table-bordered {
        border: 1px solid #dee2e6 !important;}
    .err-new{padding-left:15px !important;}

</style>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Purchase Return</h5>
            </div>
            <div class="card-block">
                <?php
                if (isset($po) && !empty($po)) {
                    foreach ($po as $val) {
                        ?>
                        <form  action="<?php echo $this->config->item('base_url'); ?>purchase_return/update_po/<?php echo $val['id']; ?>" method="post">
                            <div class="form-material">
                                <div class="form-material row">
                                    <div class="col-md-3">
                                        <div class="material-group">
                                            <div class="material-addone">
                                                <i class="icofont icofont-address-book"></i>
                                            </div>
                                            <div class="form-group form-primary">
                                                <label class="float-label">GRN NO</label>
                                                <input type="hidden"  name="purchase_order_id" value="<?php echo $val['po_id'] ?>"/>
                                                <input type="hidden"  name="po[gen_id]" value="<?php echo $val['id'] ?>"/>
                                                <input type="text"  tabindex="-1" name="po[grn_no]" class=" form-control colournamedup " readonly="readonly" value="<?php echo $val['grn_no']; ?>"  id="grn_no" >
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
                                                <label class="float-label">Company Name</label>
                                                <input type="text"  name="supplier[store_name]" id="customer_name" class='  form-control auto_customer required ' value="<?php echo $val['store_name']; ?>"  readonly="readonly"/>
                                                <input type="hidden"  name="supplier[id]" id="customer_id" class=' form-control  id_customer tabwid' value="<?php echo $val['id']; ?>" />
                                                <div id="suggesstion-box" class="auto-asset-search"></div>
                                                <span class="form-bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="material-group">
                                            <div class="material-addone">
                                                <i class="icofont icofont-ui-call"></i>
                                            </div>
                                            <div class="form-group form-primary">
                                                <label class="float-label">Vendor Mobile No</label>
                                                <input type="text"  name="supplier[mobil_number]" class="form-control required " id="customer_no" value="<?php echo $val['mobil_number']; ?>" readonly="readonly"/>
                                                <span class="form-bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="material-group">
                                            <div class="material-addone">
                                                <i class="icofont icofont-email"></i>
                                            </div>
                                            <div class="form-group form-primary">
                                                <label class="float-label">Vendor Email ID</label>
                                                <input type="text"  name="supplier[email_id]" class=" form-control required " id="email_id" value="<?php echo $val['email_id']; ?>" readonly="readonly"/>
                                                <span class="form-bar"></span>
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
                                                <label class="float-label">Vendor Address</label>
                                                <textarea name="supplier[address1]" class=" form-control required" id="address1" readonly="readonly"><?php echo $val['address1']; ?></textarea>
                                                <span class="form-bar"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="material-group">
                                            <div class="material-addone">
                                                <i class="icofont icofont-ui-calendar"></i>
                                            </div>
                                            <div class="form-group form-primary">
                                                <label class="float-label">Purchase Return Date <span class="req">*</span></label>
                                                <input id="dropper-default" name="po[created_date]" data-date="" data-month="" data-year="" value="<?php echo date('d-M-Y'); ?>" class="form-control required " type="text" placeholder="" />

                                                <span class="form-bar"></span>
                                                <span class="error_msg"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row card-block table-border-style">
                                <div class="table-responsive">
                                    <table class="table table-bordered  dataTable no-footer dtr-inline" id="add_quotation">
                                        <thead>
                                            <tr>
                                                <td width="10%" class="first_td1">Category</td>
                                                <td width="10%" class="first_td1">Brand</td>
                                                <td width="10%" class="first_td1">Model Number</td>
                                                <td width="10%" class="first_td1">Product Description</td>
                                                <?php if ($val['is_gst'] == 1) { ?>
                                                    <td width="10%" class="first_td1">HSN Code</td>
                                                <?php } else { ?>
                                                    <td width="5%" class="first_td1">Add Amt</td>
                                                <?php } ?>
                                                <td  width="12%" class="first_td1">QTY</td>
                                                <td  width="5%" class="first_td1">Unit Price</td>
                                                <?php if ($val['is_gst'] == 1) { ?>
                                                    <td width="3%" class="first_td1 action-btn-align proimg-wid">CGST%</td>
                                                    <?php
                                                    $gst_type = $po[0]['state_id'];
                                                    if ($gst_type != '') {
                                                        if ($gst_type == 31) {
                                                            ?>
                                                            <td  width="1%" class="first_td1 action-btn-align proimg-wid" >SGST%</td>
                                                        <?php } else { ?>
                                                            <td  width="1%" class="first_td1 action-btn-align proimg-wid" >IGST%</td>

                                                            <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                                <td  width="1%" class="first_td1" style="display:none">Tax</td>
                                                <td  width="7%" class="first_td1">Net Value</td>
                                            </tr>
                                        </thead>
                                        <tbody id='app_table'>
                                            <?php
                                            $cgst = 0;
                                            $sgst = 0;
                                            $sub_total = $delivery_qty_total = $over_all_net = $over_all_net_total = 0;
                                            if (isset($po_details) && !empty($po_details)) {
                                                foreach ($po_details as $vals) {

                                                    $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['current_quantity']);

                                                    $gst_type = $po[0]['state_id'];
                                                    if ($gst_type != '') {
                                                        if ($gst_type == 31) {

                                                            $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * $vals['current_quantity']);
                                                        } else {
                                                            $sgst1 = ($vals['igst'] / 100 ) * ($vals['per_cost'] * $vals['current_quantity']);
                                                        }
                                                    }
                                                    $cgst += $cgst1;
                                                    $sgst += $sgst1;

                                                    $deliver_qty = $vals['current_quantity'];

                                                    $per_cost = $vals['per_cost'];
                                                    $gst_val = $vals['tax'];
                                                    $cgst_val = $vals['gst'];
                                                    if ($val['is_gst'] == 1) {
                                                        $net_total = $deliver_qty * $per_cost;
                                                    } else {
                                                        $net_total = $deliver_qty * ($per_cost);
                                                    }

                                                    $sub_total += $net_total;
                                                    if ($val['is_gst'] == 1) {
                                                        $final_sub__total = $deliver_qty * $per_cost + (($deliver_qty * $per_cost) * $gst_val / 100) + (($deliver_qty * $per_cost) * $cgst_val / 100);
                                                    } else {
                                                        $final_sub__total = $deliver_qty * ($per_cost);
                                                    }
                                                    $over_all_net += $final_sub__total;
                                                    $over_all_net_total = $over_all_net + $val['tax'];
                                                    $delivery_qty_total += $vals['current_quantity'];
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="po[is_gst]" id="gst_check_status" value="<?php echo $val['is_gst'] ?>">
                                                            <input type="hidden"  name="gen_details_id[]" value="<?php echo $vals['gen_details_id'] ?>"/>
                                                            <input type="hidden" class='cat_id static_style form-control' name='categoty[]' readonly="" value='<?php echo $vals['cat_id'] ?>'>
                                                            <input type="text" class="form-control" readonly="" value='<?php echo $vals['categoryName'] ?>'>
                                                        </td>
                                                        <td>
                                                            <input type="hidden"  name='brand[]' readonly="" value='<?php echo $vals['id'] ?>'>
                                                            <input type="text"  class=" form-control" readonly="" value='<?php echo $vals['brands'] ?>'>
                                                        </td>
                                                        <td>
                                                            <input type="text"  name="model_no[]" id="model_no" class='form-control auto_customer tabwid model_no required' value="<?php echo $vals['model_no']; ?>" readonly="readonly"/>
                                                            <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-control' value="<?php echo $vals['product_id']; ?>" />

                                                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                                                        </td>
                                                        <td>
                                                            <textarea  name="product_description[]" id="product_description" class='form-control auto_customer tabwid product_description' readonly="readonly" />  <?php echo $vals['product_description']; ?></textarea>
                                                        </td>
                                                        <?php if ($val['is_gst'] == 1) { ?>
                                                            <td>
                                                                <input type="text"  name="hsn_sac[]" id="hsn_sac" class='form-control hsn_sac' value="<?php echo $vals['hsn_sac']; ?>" readonly="readonly"/>
                                                            </td>
                                                        <?php } else { ?>
                                                            <td>
                                                                <input type="text"  name="add_amount[]" id="add_amount" class='form-control add_amount right-align' value="<?php echo $vals['add_amount']; ?>" readonly="readonly"/>
                                                            </td>
                                                        <?php } ?>

                                                        <?php if (isset($vals['stock']) && !empty($vals['stock'])) { ?>
                                                            <td align="center">
                                                                <div class="row">
                                                                    <!--                                                                    <div class="col-md-4">
                                                                                                                                            <label class="label label-primary">PO.Qty</label>
                                                                                                                                            <input type="text"   tabindex="-1"  name='quantity[]' class=" form-control m-t-5  cent-align" value="<?php echo $vals['quantity'] ?>" readonly="readonly" />
                                                                                                                                        </div>-->
                                                                    <div class="col-md-4">
                                                                        <label class="label label-primary">GRN.Qty</label>
                                                                        <input type="text"   tabindex="-1"  name='delivery_quantity[]' class="qty form-control m-t-5 po_qty cent-align" value="<?php echo $vals['current_quantity'] ?>" readonly="readonly" />
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label class="label label-success">S.Qty</label>
                                                                        <input type="text"   tabindex="-1"  name='available_quantity[]' class=" cent-align m-t-5 avl_qty form-control colournamedup tabwid  " value="<?php echo $vals['stock'][0]['quantity'] ?>" readonly="readonly"/>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <label class="label label-info">R.Qty</label>
                                                                        <input type="text"   tabindex="1"  name='return_quantity[]'  class="m-t-5 return_qty form-control cent-align" />
                                                                    </div>
                                                                    <span class="error_msg err-new"></span>

                                                                </div>
                                                            </td>
                                                        <?php } else { ?>
                                                            <td>
                                                                <div class="row">
                                                                    <!--                                                                    <div class="col-md-6">
                                                                                                                                            <label class="label label-info">PO.Qty</label>
                                                                                                                                            <input type="text"   tabindex="-1"  name='quantity[]' class=" form-control m-t-5  cent-align" value="<?php echo $vals['quantity'] ?>" readonly="readonly" />
                                                                                                                                        </div>-->
                                                                    <div class="col-md-6">
                                                                        <label class="label label-primary">GRN.Qty</label>
                                                                        <input type="text"   tabindex="-1"  name='delivery_quantity[]' class="qty form-control m-t-5 po_qty cent-align" value="<?php echo ($vals['current_quantity']) ?>" readonly="readonly" />
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="label label-success">S.Qty</label>
                                                                        <input type="text"   tabindex="-1"  name='available_quantity[]' class=" cent-align m-t-5 avl_qty form-control colournamedup tabwid  " value="<?php echo ($vals['stock'][0]['quantity'] != '') ? $vals['stock'][0]['quantity'] : '0'; ?>" readonly="readonly"/>
                                                                    </div>

                                                                    <span class="error_msg err-new"></span>
                                                                </div>
                                                            </td>
                                                        <?php } ?>

                                                        <td>
                                                            <input type="text"   tabindex="-1"  name='per_cost[]'  class="percost required form-control right-align" value="<?php echo $vals['per_cost'] ?>" readonly="readonly"/>

                                                        </td>
                                                        <?php if ($val['is_gst'] == 1) { ?>
                                                            <td class="action-btn-align">
                                                                <input type="text"   tabindex="-1"   name='tax[]' class="pertax cgst form-control cent-align" value="<?php echo $vals['tax'] ?>" readonly="readonly" />
                                                            </td>
                                                            <?php
                                                            $gst_type = $po[0]['state_id'];
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
                                                            <input type="text"   tabindex="-1" name='sub_total[]' readonly="readonly" class="subtotal form-control text-right" readonly="readonly"/>
                                                        </td>

                                                    </tr>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="5" class="totbold" style=" text-align:right;">Total</td>
                                                <td align="center"><input type="text"   name="po[total_qty]"  tabindex="-1" readonly="readonly" value="<?php echo $delivery_qty_total; ?>" class="total_qty form-control cent-align"  id="total" readonly="readonly"/></td>
                                                <?php if ($val['is_gst'] == 1) { ?>
                                                    <td colspan="3" class="gst_add totbold" style="text-align:right;">Sub Total</td>
                                                <?php } else { ?>
                                                    <td class="totbold" style="text-align:right;">Sub Total</td>
                                                <?php } ?>
                                                <td><input type="text" name="po[subtotal_qty]"  tabindex="-1" readonly="readonly"  class="final_sub_total form-control text-right" readonly="readonly"/></td>

                                            </tr>
                                            <?php if ($val['is_gst'] == 1) { ?>
                                                <tr>
                                                    <td colspan="7" class="totbold" style="text-align:right !important;">CGST</td>
                                                    <td class="text-right"><input class="form-control text-right add_cgst" tabindex="-1" readonly="readonly"></td>
                                                    <?php
                                                    $gst_type = $po[0]['state_id'];
                                                    if ($gst_type != '') {
                                                        if ($gst_type == 31) {
                                                            ?>
                                                            <td  class="totbold" style="text-align:right;">SGST</td>
                                                        <?php } else { ?>
                                                            <td class="totbold" style="text-align:right;">IGST</td>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <td class="text-right"><input class="form-control text-right add_sgst" tabindex="-1" readonly="readonly"></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <?php if ($val['is_gst'] == 1) { ?>
                                                    <td colspan="5"></td>
                                                <?php } else { ?>
                                                    <td colspan="3" style="text-align:right;"></td>
                                                <?php } ?>
                                                <td colspan="4" style="text-align:right;font-weight:bold;"><input type="text"  name="po[tax_label]" class='tax_label form-control text-right' value="<?php echo $val['tax_label']; ?>" readonly="readonly"/></td>
                                                <td>
                                                    <input type="text"  name="po[tax]" class='totaltax form-control text-right' value="<?php echo $val['tax']; ?>"  readonly="readonly"/>
                                                </td>

                                            </tr>
                                            <tr>
                                                <?php if ($val['is_gst'] == 1) { ?>
                                                    <td colspan="2"></td>
                                                <?php } ?>
                                                <td colspan="5" style=" text-align:right;"></td>
                                                <td colspan="2"style="text-align:right;font-weight:bold;">Net Total</td>
                                                <td><input type="text"  name="po[net_total]"  readonly="readonly"  tabindex="-1" class="final_amt form-control text-right" readonly="readonly"/></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 ">
                                    <h4 class="sub-title">TERMS AND CONDITIONS</h4>
                                    <div class="form-material row m-t-15">
                                        <div class="col-md-6">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-address-book"></i>
                                                </div>

                                                <div class="form-group form-primary">
                                                    <label class="float-label">Remarks</label>
                                                    <textarea name="po[remarks]" type="text" class="form-control remark" ><?php echo $val['remarks']; ?></textarea>
                                                    <span class="form-bar"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-bank"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Mode of Payment</label>
                                                    <input type="text" class="form-control class_req borderra0 terms" value="<?php echo $val['mode_of_payment']; ?>" name="po[mode_of_payment]" readonly="readonly"/>

                                                    <input type="hidden"  name="gst_type" id="gst_type" class="gst_type" value="<?php echo $val['state_id']; ?>"/>
                                                    <input type="hidden"  name="po[supplier]" id="customer_id" class='id_customer' value="<?php echo $val['id']; ?>"/>
                                                    <span class="form-bar"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row m-10">
                                <div class="col-md-12 text-center" >
                                    <button class="btn btn-primary btn-sm waves-effect waves-light " id="save"  tabindex="1" > Update </button>
                                    <a href="<?php echo $this->config->item('base_url') . 'purchase_return/' ?>" class="btn btn-inverse btn-sm waves-effect waves-light" tabindex="1" > Back </a>
                                </div>
                            </div>
                        </form>
                    </div>
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
        maxYear: new Date().getFullYear() + 50,
        format: 'd-M-Y'
    });
    $(".return_qty").keyup(function () {
        var qty = $(this).closest('tr').find('.po_qty').val();
        this_val = $.trim($(this).val());
        var stock_qty = $(this).closest('tr').find('.avl_qty').val();
        if (Number(this_val) > Number(qty) || Number(this_val) >= Number(stock_qty) && (Number(this_val) != 0))
        {
            $(this).closest('td').find('span.error_msg').text('Invalid Return Qty').css('display', 'inline-block');
        } else {
            $(this).closest('td').find('span.error_msg').text("");
        }
        if (Number(this_val) != '' && Number(this_val) != 0) {
            $('.totaltax').val("<?php echo $po[0]['tax']; ?>");
            $('.tax_label').val("<?php echo $po[0]['tax_label']; ?>");

        } else {
            $('.totaltax').val("");
            $('.tax_label').val("");
        }
    });
    $('#save').live('click', function () {
        m = 0;
        $('.required').each(function () {
            this_val = $.trim($(this).val());
            if (this_val == "") {
                $(this).closest('div .form-group').find('.error_msg').text('This field is required').css('display', 'inline-block');
                $(this).closest('td').find('.error_msg').text('This field is required').css('display', 'inline-block');
                m++;
            } else {
                $(this).closest('div .form-group').find('.error_msg').text('');
                $(this).closest('td').find('.error_msg').text('');
            }
        });
        $('.return_qty').each(function () {
            var qty = $(this).closest('tr').find('.po_qty').val();
            this_val = $.trim($(this).val());
            var stock_qty = $(this).closest('tr').find('.avl_qty').val();
            if (Number(this_val) > Number(qty) || Number(this_val) >= Number(stock_qty))
            {
                $(this).closest('td').find('span.error_msg').text('Invalid Return Qty').css('display', 'inline-block');
                m++;
            } else {
                $(this).closest('td').find('span.error_msg').text("");
            }
        });
        if (m > 0)
        {
            return false;
        } else
        {
            return true;
        }

    });

    $(document).ready(function () {
        $('.totaltax').val("");
        $('.tax_label').val("");
        // var $elem = $('#scroll');
        //  window.csb = $elem.customScrollBar();
        $("#customer_name").keyup(function () {
            $.ajax({
                type: "GET",
                url: "<?php echo $this->config->item('base_url'); ?>" + "purchase_order/get_customer",
                data: 'q=' + $(this).val(),
                success: function (data) {
                    $("#suggesstion-box").show();
                    $("#suggesstion-box").html(data);
                    $("#search-box").css("background", "#FFF");
                }
            });
        });
        $('body').click(function () {
            $("#suggesstion-box").hide();
        });
    });

    $('.cust_class').live('click', function () {
        $("#customer_id").val($(this).attr('cust_id'));
        $("#cust_id").val($(this).attr('cust_id'));
        $("#customer_name").val($(this).attr('cust_name'));
        $("#customer_no").val($(this).attr('cust_no'));
        $("#email_id").val($(this).attr('cust_email'));
        $("#address1").val($(this).attr('cust_address'));
    });

    $('#add_group').click(function () {
        var tableBody = $(".static").find('tr').clone();
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

    $('.qty,.percost,.pertax,.totaltax,.return_qty').live('keyup', function () {
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
            $('.return_qty').each(function () {
                var rq = $(this).closest('tr').find('.return_qty');
                var qty = $(this).closest('tr').find('.qty');
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
                if (Number(rq.val()) != 0 && Number(rq.val()) != '')
                {
                    taxless = (Number(rq.val())) * Number(percost.val());
                    cgst += Number(pertax.val() / 100) * taxless;
                    sgst += Number(gst.val() / 100) * taxless;
                    sub_total = Number(((Number(rq.val())) * Number(percost.val())));
                    subtotal.val(sub_total.toFixed(2));
                    final_qty = final_qty + (Number(rq.val()));
                    final_sub_total = final_sub_total + sub_total;

                } else if ((Number(rq.val())) == 0) {
                    subtotal.val(0);
                }
            });
            $('.add_cgst').val(cgst.toFixed(2));
            $('.add_sgst').val(sgst.toFixed(2));
            $('.total_qty').val(final_qty);
            $('.final_sub_total').val(final_sub_total.toFixed(2));
            $('.final_amt').val((final_sub_total + cgst + sgst + Number($('.totaltax').val())).toFixed(2));
        } else {
            $('.return_qty').each(function () {
                var rq = $(this).closest('tr').find('.return_qty');
                var qty = $(this).closest('tr').find('.qty');
                var percost = $(this).closest('tr').find('.percost');
                var pertax = $(this).closest('tr').find('.pertax');
                var subtotal = $(this).closest('tr').find('.subtotal');
                // alert (rq.val());
                if (Number(rq.val()) != 0 && Number(rq.val()) != '')
                {
                    pertax1 = Number(pertax.val() / 100) * Number(percost.val());
                    sub_total = ((Number(rq.val())) * (Number(percost.val())));
                    subtotal.val(sub_total.toFixed(2));
                    final_qty = final_qty + (Number(rq.val()));
                    final_sub_total = final_sub_total + sub_total;
                } else if ((Number(rq.val())) == 0) {
                    subtotal.val(0);
                }
            });

            $('.total_qty').val(final_qty);
            $('.final_sub_total').val(final_sub_total.toFixed(2));
            $('.final_amt').val((final_sub_total + Number($('.totaltax').val())).toFixed(2));
        }


    }

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
    $(".model_no").live('keyup', function () {
        var this_ = $(this)
        $.ajax({
            type: "GET",
            url: "<?php echo $this->config->item('base_url'); ?>" + "purchase_order/get_product",
            data: 'q=' + $(this).val(),
            success: function (datas) {
                this_.closest('tr').find(".suggesstion-box1").show();
                this_.closest('tr').find(".suggesstion-box1").html(datas);

            }
        });
    });
    $(document).ready(function () {
        $('body').click(function () {
            $(this).closest('tr').find(".suggesstion-box1").hide();
        });

    });
    $('.pro_class').live('click', function () {
        $(this).closest('tr').find('.product_id').val($(this).attr('pro_id'));
        $(this).closest('tr').find('.model_no').val($(this).attr('mod_no'));
        $(this).closest('tr').find('.product_description').val($(this).attr('pro_name') + "  " + $(this).attr('pro_description'));
        $(this).closest('tr').find(".suggesstion-box1").hide();
    });

    $('.cat_id,.brand_id,.pro_class').live('change', function () {
        $('.cat_id,.brand_id,.pro_class').live('click', function () {
            var cat_id = $(this).closest('tr').find('.cat_id').val();
            var brand_id = $(this).closest('tr').find('.brand_id').val();
            var model_no = $(this).closest('tr').find('.product_id').val();
            var this_ = $(this).closest('tr').find('.avl_qty');
            $.ajax({
                url: BASE_URL + "project_cost/get_stock",
                type: 'GET',
                data: {
                    cat_id: cat_id,
                    brand_id: brand_id,
                    model_no: model_no
                },
                success: function (result) {
                    this_.html(result);
                }
            });
        });
    });
</script>
