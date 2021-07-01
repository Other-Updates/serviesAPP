<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<style>
    #add_group {
        color: #fff;
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

$customers_json = array();
if (!empty($customers)) {
    foreach ($customers as $list) {
        $customers_json[] = '{ value: "' . $list['store_name'] . '", id: "' . $list['id'] . '"}';
    }
}
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Add Purchase Order</h5>
                <div style="float:right;" onClick="dcl(this)">
                    <!--<label>GST</label>-->
                    <label class="togswitch">
                        <input type="checkbox" class="grand_gst" >
                        <span class="togslider round"></span>
                    </label>
                    <span class="gst_check_err text-danger"></span>
                </div>
            </div>
            <div class="card-block">
                <table class="static" style="display: none;">
                    <tr>
                        <td>
                            <select id='cat_id' class='form-control cat_id static_style class_req' tabindex="-1"  name='categoty[]'>
                                <option value="">Select</option>
                                <?php
                                if (isset($category) && !empty($category)) {
                                    foreach ($category as $val) {
                                        ?>
                                        <option value='<?php echo $val['cat_id'] ?>'><?php echo $val['categoryName'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <span class="error_msg text-danger"></span>
                        <td>
                            <select id='brand' name='brand[]' tabindex="-1"  class='form-control brand'>
                                <option value="">Select</option>
                                <?php
                                if (isset($brand) && !empty($brand)) {
                                    foreach ($brand as $val) {
                                        ?>
                                        <option value='<?php echo $val['id'] ?>'><?php echo $val['brands'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <span class="error_msg text-danger"></span>
                        </td>
                        <td >
                            <input type="text"  name="model_no[]" id="model_no" class='form-control auto_customer tabwid model_no' />
                            <span class="error_msg text-danger"></span>
                            <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-control product_id' />
                            <input type="hidden"  name="type[]" id="type" class=' tabwid form-control type' />
                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                        </td>
                        <td>
                            <textarea  name="product_description[]" tabindex="-1"  id="product_description" class='form-control auto_customer tabwid4 product_description' onkeyup='f2(this);'/>  </textarea>

                        </td>
                        <td class="action-btn-align hsn_td">
                            <input type="text" tabindex="-1" name='hsn_sac[]' class="hsn_sac  form-control" />
                        </td>
                        <td class="action-btn-align add_amount_td">
                            <input type="text"  name="add_amount[]" id="add_amount" tabindex="-1"  class='form-control add_amount right-align' />

                        </td>
                        <td class="action-btn-align">
                            <input type="text"   tabindex="-1"  name='available_quantity[]' class="code form-control colournamedup tabwid stock_qty cent-align" readonly="readonly"/>
                            <input type="text"   tabindex="-1"  name='quantity[]' class="qty form-control cent-align" id="qty" />
                            <span class="error_msg text-danger"></span>
                        </td>
                        <td>
                            <input type="text"   tabindex="-1"  name='per_cost[]'  class="cost_price percost form-control right-align " id="price"/>
                            <input type="hidden" name="old_cost_price[]" class="cost_price_actual" />
                            <span class="error_msg text-danger right-align"></span>
                        </td>
                        <td class="action-btn-align tax_td">
                            <input type="text" tabindex="-1" name='tax[]' readonly="readonly" class="pertax  form-control cent-align" />
                        </td>
                        <td class="action-btn-align sgst_td">
                            <input type="text"  tabindex="-1"  name='gst[]' readonly="readonly" class="gst  form-control cent-align" />
                        </td>
                        <td class="action-btn-align igst_td">
                            <input type="text" tabindex="-1" name='igst[]' readonly="readonly" class="igst wid50  form-control cent-align"  />
                        </td>
                        <td>
                            <input type="text" tabindex="-1"  name='sub_total[]' readonly="readonly" id="sub_toatl" class="subtotal form-control text_right" />
                        </td>
                        </td>
                        <td class="action-btn-align">
                            <a id='delete_group' class="del btn btn-danger btn-mini" tabindex="-1"><span class="fa fa-trash"></span></a>
                        </td>
                    </tr>
                </table>
                <form  method="post" class="panel-body" id="purchase_order_form">
                    <input type="hidden" name="check_gst" id="gst_check_status_value">
                    <div class="form-material">
                        <div class="form-material row">
                            <div class="col-md-3">
                                <div class="material-group">
                                    <div class="material-addone">
                                        <i class="icofont icofont-address-book"></i>
                                    </div>
                                    <div class="form-group form-primary">
                                        <label class="float-label">PO NO</label>
                                        <input type="text"  tabindex="-1" name="po[po_no]" class="code form-control colournamedup" readonly="readonly" value="<?php echo $last_id; ?>"  id="grn_no">
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
                                        <input type="text" tabindex="1" name="supplier[store_name]"  id="customer_name" class='form-control ref_class auto_customer required ' />
                                        <span class="error_msg text-danger"></span>
                                        <input type="hidden"  name="supplier[id]" id="customer_id" class='form-control id_customer tabwid' />
                <!--                              <input type="hidden"  name="po[product_id]" id="cust_id" class='id_customer' />-->
                                        <div id="suggesstion-box" class="auto-asset-search "></div>
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
                                        <label class="float-label">Vendor Mobile No <span class="req">*</span></label>
                                        <input type="text"  tabindex="-1" name="supplier[mobil_number]" id="customer_no"  class="form-control required" />
                                        <span class="form-bar"></span>
                                        <span class="error_msg text-danger"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="material-group">
                                    <div class="material-addone">
                                        <i class="icofont icofont-email"></i>
                                    </div>
                                    <div class="form-group form-primary">
                                        <label class="float-label">Vendor Email ID <span class="req">*</span></label>
                                        <input type="text"  tabindex="-1" name="supplier[email_id]" id="email_id" tabindex="-1" class="form-control required"/>
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
                                        <i class="icofont icofont-location-pin"></i>
                                    </div>
                                    <div class="form-group form-primary">
                                        <label class="float-label">Vendor Address <span class="req">*</span></label>
                                        <textarea name="supplier[address1]" tabindex="-1" id="address1" tabindex="-1" class="form-control required"></textarea>
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
                                        <label class="float-label">Date <span class="req">*</span></label>
                                        <input id="dropper-default" name="po[created_date]" tabindex="2" data-date="" data-month="" data-year="" value="<?php echo date('d-M-Y'); ?>" class="form-control form-align required" type="text" placeholder="" />
                                        <span class="form-bar"></span>
                                        <span class="error_msg text-danger"></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="row card-block table-border-style">
                        <table class="table table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">
                            <thead>
                                <tr>
                                    <td width="10%" class="first_td1">Category</td>
                                    <td width="10%" class="first_td1">Brand</td>
                                    <td width="10%" class="first_td1">Model Number</td>
                                    <td width="10%" class="first_td1">Product Description</td>
                                    <td width="5%" class="first_td1 hsn_td">HSN Code</td>
                                    <td width="5%" class="first_td1 add_amount_td">Add Amt</td>
                                    <td  width="3%" class="first_td1">QTY</td>
                                    <td  width="5%" class="first_td1 action-btn-align">Unit Price</td>
                                    <td width="5%" class="first_td1 action-btn-align cgst_td gst_td">CGST %</td>
                                    <td width="5%" class="first_td1 action-btn-align sgst_td gst_td">SGST %</td>
                                    <td width="5%" class="first_td1 action-btn-align igst_td gst_td">IGST %</td>
                                    <td  width="7%" class="first_td1">Net Value</td>
                                    <td width="1%" class="action-btn-align"><a id='add_group' class="btn btn-primary btn-mini waves-effect waves-light d-inline-block md-trigger"><span class="fa fa-plus"></span> Add Row</a>
                                    </td>
                                </tr>
                            </thead>
                            <tbody id='app_table'>
                                <tr>
                                    <td>
                                        <select id="" class="cat_id static_style class_req required form-control" name="categoty[]" tabindex="-1">
                                            <option value="">Select</option>
                                            <?php
                                            if (isset($category) && !empty($category)) {
                                                foreach ($category as $val) {
                                                    ?>
                                                    <option value='<?php echo $val['cat_id'] ?>'><?php echo $val['categoryName'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <span class="error_msg text-danger"></span>
                                    </td>
                                    <td>
                                        <select name='brand[]'  class="brand static_style class_req required form-control" tabindex="-1">
                                            <option value="">Select</option>
                                            <?php
                                            if (isset($brand) && !empty($brand)) {
                                                foreach ($brand as $val) {
                                                    ?>
                                                    <option value='<?php echo $val['id'] ?>'><?php echo $val['brands'] ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>
                                        </select>
                                        <span class="error_msg text-danger"></span>
                                    </td>
                                    <td>
                                        <input type="text"  name="model_no[]" id="model_no" tabindex="3" class='form-control auto_customer tabwid model_no required'  />
                                        <span class="error_msg text-danger"></span>
                                        <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-align' />
                                        <input type="hidden"  name="type[]" id="type" class=' tabwid form-align type' />
                                        <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                                    </td>
                                    <td>
                                        <textarea  name="product_description[]" id="product_description" tabindex="-1" class='form-control auto_customer tabwid4 product_description' onkeyup='f2(this);' />  </textarea>
                                    </td>
                                    <td class="action-btn-align hsn_td">
                                        <input type="text" tabindex="-1" name='hsn_sac[]' class="hsn_sac  form-control" />
                                    </td>
                                    <td class="action-btn-align add_amount_td">
                                        <input type="text"  name="add_amount[]" id="add_amount" tabindex="-1"  class='form-control add_amount right-align' />

                                    </td>

                                    <td>
                                        <input type="text"   tabindex="-1"  name='available_quantity[]' class="code form-control colournamedup tabwid stock_qty cent-align" readonly="readonly"/>
                                        <input type="text"   name='quantity[]' class="qty form-control required cent-align" tabindex="4" />
                                        <span class="error_msg text-danger"></span>
                                    </td>
                                    <td>
                                        <input type="text" name='per_cost[]' class="cost_price percost required form-control right-align" tabindex="-1"/>
                                        <input type="hidden" class="cost_price right-align" name="product_cost_price">
                                        <input type="hidden" name="old_cost_price[]" class="cost_price_actual" />
                                        <span class="error_msg text-danger"></span>
                                    </td>
                                    <td class="action-btn-align tax_td">
                                        <input type="text" tabindex="-1" name='tax[]' readonly="readonly" class="pertax  form-control cent-align" />
                                    </td>
                                    <td class="action-btn-align sgst_td">
                                        <input type="text"  tabindex="-1"  name='gst[]' readonly="readonly" class="gst  form-control cent-align" />
                                    </td>
                                    <td class="action-btn-align igst_td">
                                        <input type="text" tabindex="-1" name='igst[]' readonly="readonly" class="igst wid50  form-control cent-align"  />
                                    </td>
                                    <td>
                                        <input type="text"  name='sub_total[]' readonly="readonly" tabindex="-1" class="subtotal text-right form-control" />
                                    </td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="totbold" style=" text-align:right;">Total</td>
                                    <td><input type="text"   name="po[total_qty]"  tabindex="-1" readonly="readonly" class="total_qty form-control"  id="total" /></td>
                                    <td colspan="3" class="gst_add totbold" style="text-align:right;">Sub Total</td>
                                    <td class="remove_gst totbold"  style="text-align:right;">Sub Total</td>
                                    <td><input type="text" name="po[subtotal_qty]" tabindex="-1"  readonly="readonly"  class="final_sub_total text-right form-control"  /></td>
                                    <td></td>
                                </tr>
                                <tr class="additional gst_add" id="add_new_values">
                                    <td colspan="6" style="text-align:right;"></td>
                                    <td style="text-align:right;" class="sgst_td totbold"> SGST </td>
                                    <td style="text-align:right;" class="igst_td totbold"> IGST </td>
                                    <td><input type="text" tabindex="-1" value=""  readonly class="add_sgst form-control text_right" /></td>
                                    <td style="text-align:right;" class="totbold"> CGST </td>
                                    <td><input type="text" tabindex="-1"  value=""  readonly class="add_cgst form-control text_right" /></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="gst_add"></td>
                                    <td colspan="4" style=" text-align:right;"></td>
                                    <td colspan="3" style="text-align:right;font-weight:bold;"><input type="text"  tabindex="-1" name="po[tax_label]" class='tax_label text-right form-control'    style="width:100%;" /></td>
                                    <td>
                                        <input type="text"  name="po[tax]" class='totaltax text-right form-control'  tabindex="-1"  />
                                    </td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="gst_add"></td>
                                    <td colspan="4" style=" text-align:right;"></td>
                                    <td colspan="3" class="totbold" style="text-align:right;font-weight:bold;">Net Total</td>
                                    <td><input type="text"  name="po[net_total]" tabindex="-1"  readonly="readonly"  class="final_amt text-right form-control"  /></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
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
                                            <textarea name="po[remarks]"   class="form-control remark" tabindex="5" ></textarea>
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
                                            <input type="text"  class="form-control class_req borderra0 terms" tabindex="6"  name="po[mode_of_payment]" onkeyup='f2(this);'/>

                                            <input type="hidden"  name="po[supplier]" id="c_id" class='id_customer' />
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
                            <button  id="save" class="btn btn-primary btn-sm waves-effect waves-light" >Create</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function dcl(eve)
    {
        if ($('.grand_gst').hasClass('disabled')) {
            $('.gst_check_err').html("Select company");
        } else {
            $('.gst_check_err').html("");
        }
    }
    $("#dropper-default").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        maxYear: new Date().getFullYear() + 50,
        format: 'd-M-Y'
    });
    $('#save').live('click', function () {
        m = 0;
        $('.required').each(function () {
            var tr = $('#app_table tr').length;
            if (tr > 1)
            {
                tr_model_no = $(this).closest('tr td').find('input.model_no').val();
                if (tr_model_no == '') {
                    $(this).closest('tr').remove();
                }
            }
        });
        $('#purchase_order_form .required').each(function () {
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

        if (m > 0)
            return false;

    });

    $(document).ready(function () {
        $("#customer_name").on('blur', function () {
            var c_name = $("#customer_name").val();
            if (c_name == "") {
                $('.grand_gst').attr('disabled', 'disabled');
                $('.grand_gst').addClass('disabled');
            } else {
                $('.grand_gst').removeAttr('disabled');
                $('.grand_gst').removeClass('disabled');
            }
        });

        var c_name = $("#customer_name").val();
        if (c_name == "") {
            $('.grand_gst').attr('disabled', 'disabled');
            $('.grand_gst').addClass('disabled');
        } else {
            $('.grand_gst').removeAttr('disabled');
            $('.grand_gst').removeClass('disabled');
        }
        if ($('.grand_gst').is(':checked')) {
            $('.sgst_td ').css('display', 'table-cell');
            $('.cgst_td ').css('display', 'table-cell');
            $('.igst_td ').css('display', 'none');
            $('#add_quotation').find('tr td.sgst_td').show();
            $('#add_quotation').find('tr td.igst_td').hide();
            $('#add_quotation').find('tr td.tax_td').show();
            $('.gst_add').show();
            $('.remove_gst').hide();
            $('.hsn_td').show();
            $('.add_amount_td').hide();
            $('#gst_check_status_value').val('on');
        } else {
            $('.sgst_td ').css('display', 'none');
            $('.igst_td ').css('display', 'none');
            $('.cgst_td ').css('display', 'none');
            $('#add_quotation').find('tr td.sgst_td').hide();
            $('#add_quotation').find('tr td.igst_td').hide();
            $('#add_quotation').find('tr td.tax_td').hide();
            $('.gst_add').hide();
            $('.remove_gst').show();
            $('.hsn_td').hide();
            $('.add_amount_td').show();
            $('#gst_check_status_value').val('');
        }


        $('.grand_gst').click(function () {
            if ($(this).prop('checked') == true) {
                add_amount();
                $('.hsn_td').show();
                $('.add_amount_td').hide();
                if ($('#gst_type').val() != '')
                {
                    if ($('#gst_type').val() == 31)
                    {
                        $('.sgst_td ').css('display', 'table-cell');
                        $('.cgst_td ').css('display', 'table-cell');
                        $('.igst_td ').css('display', 'none');
                        $('#add_quotation').find('tr td.sgst_td').show();
                        $('#add_quotation').find('tr td.igst_td').hide();
                        $('#add_quotation').find('tr td.tax_td').show();
                        $('.gst_add').show();
                        $('.remove_gst').hide();
                    } else {
                        $('.igst_td ').css('display', 'table-cell');
                        $('.cgst_td ').css('display', 'table-cell');
                        $('.sgst_td ').css('display', 'none');

                        $('#add_quotation').find('tr td.sgst_td').hide();
                        $('#add_quotation').find('tr td.igst_td').show();
                        $('#add_quotation').find('tr td.tax_td').show();
                        $('.gst_add').show();
                        $('.remove_gst').hide();
                    }
                } else {
                    $('.sgst_td ').css('display', 'none');
                    $('.igst_td ').css('display', 'none');
                    $('.cgst_td ').css('display', 'none');

                    $('#add_quotation').find('tr td.sgst_td').hide();
                    $('#add_quotation').find('tr td.igst_td').hide();
                    $('#add_quotation').find('tr td.tax_td').hide();
                    $('.gst_add').hide();
                    $('.remove_gst').show();
                }
                calculate_function();
                $('#gst_check_status_value').val('on');
            } else {
                add_amount();
                $('.sgst_td ').css('display', 'none');
                $('.igst_td ').css('display', 'none');
                $('.cgst_td ').css('display', 'none');
                $('#add_quotation').find('tr td.sgst_td').hide();
                $('#add_quotation').find('tr td.igst_td').hide();
                $('#add_quotation').find('tr td.tax_td').hide();
                $('.gst_td').hide();
                $('.gst_add').hide();
                $('.remove_gst').show();
                $('.hsn_td').hide();
                $('.add_amount_td').show();
                calculate_function();
                $('#gst_check_status_value').val('');
            }
        });


        if ($('#gst_type').val() != '')
        {
            if ($('#gst_type').val() == 31)
            {
                $('#add_quotation').find('tr td.sgst_td').show();
                $('#add_quotation').find('tr td.igst_td').hide();

            } else {
                $('#add_quotation').find('tr td.igst_td').show();
                $('#add_quotation').find('tr td.sgst_td').hide();
            }
        } else {
            $('#add_quotation').find('tr td.igst_td').hide();
        }
        var gst_ref = 'G';

        $('body').on('keydown', 'input#customer_name', function (e) {
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
                        url: "<?php echo $this->config->item('base_url'); ?>" + "purchase_order/get_customer/",
                        success: function (data) {
                            result = JSON.parse(data);
                            if (result != null && result.length > 0) {
                                $("#customer_no").parent().find(".float-label").removeClass('newClass1');
                                $("#customer_no").parent().find(".float-label").addClass('newClass');
                                $("#email_id").parent().find(".float-label").removeClass('newClass1');
                                $("#email_id").parent().find(".float-label").addClass('newClass');
                                $("#address1").parent().find(".float-label").removeClass('newClass1');
                                $("#address1").parent().find(".float-label").addClass('newClass');


                                $("#customer_id").val(result[0].id);
                                $("#gst_type").val(result[0].state_id);
                                $("#c_id").val(result[0].id);
                                $("#customer_name").val(result[0].store_name);
                                $("#customer_no").val(result[0].mobil_number);
                                $("#email_id").val(result[0].email_id);
                                $("#address1").val(result[0].address1);
                                $("#tin").val(result[0].tin);
                                var increment_id = $('#grn_no').val().split("/");
                                var check_gst_on = $('#gst_check_status_value').val();
                                if (check_gst_on == 'on') {
                                    final_id = increment_id[0] + '-' + gst_ref + '/' + result[0].nick_name + '/' + increment_id[2] + '/' + increment_id[3];
                                    $('#grn_no').val(final_id);
                                } else {
                                    final_id = increment_id[0] + '/' + result[0].nick_name + '/' + increment_id[2] + '/' + increment_id[3];
                                    $('#grn_no').val(final_id);
                                }

                                $('.grand_gst').click(function () {
                                    if ($(this).prop('checked') == true) {
                                        final_id = increment_id[0] + '-' + gst_ref + '/' + result[0].nick_name + '/' + increment_id[2] + '/' + increment_id[3];
                                    } else {
                                        final_id = increment_id[0] + '/' + result[0].nick_name + '/' + increment_id[2] + '/' + increment_id[3];
                                    }
                                    $('#grn_no').val(final_id);
                                });
                                $('.grand_gst').click(function () {
                                    if ($(this).prop('checked') == true) {
                                        if ($('#gst_type').val() != '')
                                        {
                                            if ($('#gst_type').val() == 31)
                                            {
                                                $('#add_quotation').find('tr td.sgst_td').show();
                                                $('#add_quotation').find('tr td.igst_td').hide();

                                            } else {
                                                $('#add_quotation').find('tr td.igst_td').show();
                                                $('#add_quotation').find('tr td.sgst_td').hide();
                                            }
                                        } else {
                                            $('#add_quotation').find('tr td.igst_td').hide();
                                        }
                                    }
                                });
                            }
                        }
                    });
                }
            });
        });
    });

//    $(document).ready(function () {
//        // var $elem = $('#scroll');
//        //  window.csb = $elem.customScrollBar();
//        $("#customer_name").keyup(function () {
//            $.ajax({
//                type: "GET",
//                url: "<?php echo $this->config->item('base_url'); ?>" + "purchase_order/get_customer",
//                data: 'q=' + $(this).val(),
//                success: function (data) {
//                    $("#suggesstion-box").show();
//                    $("#suggesstion-box").html(data);
//                    $("#search-box").css("background", "#FFF");
//                }
//            });
//        });
//        $('body').click(function () {
//            $("#suggesstion-box").hide();
//        });
//    });
//
//    $('.cust_class').live('click', function () {
//        $("#customer_id").val($(this).attr('cust_id'));
//        $("#c_id").val($(this).attr('cust_id'));
//        $("#customer_name").val($(this).attr('cust_name'));
//        $("#customer_no").val($(this).attr('cust_no'));
//        $("#email_id").val($(this).attr('cust_email'));
//        $("#address1").val($(this).attr('cust_address'));
//    });

    $('#add_group').click(function () {
        var tableBody = $(".static").find('tr').clone();
        $(tableBody).closest('tr').find('select,.model_no,.model_no_ser,.percost,.qty').addClass('required');
        $('#app_table').append(tableBody);
        if ($('.grand_gst').is(':checked')) {
            if ($('#gst_type').val() != '')
            {
                if ($('#gst_type').val() == 31)
                {
                    $('#add_quotation').find('tr td.sgst_td').show();
                    $('#add_quotation').find('tr td.igst_td').hide();

                } else {
                    $('#add_quotation').find('tr td.igst_td').show();
                    $('#add_quotation').find('tr td.sgst_td').hide();
                }
            } else {
                $('#add_quotation').find('tr td.igst_td').hide();
            }
        } else {
            $('#add_quotation').find('tr td.igst_td').hide();
            $('#add_quotation').find('tr td.sgst_td').hide();
            $('#add_quotation').find('tr td.tax_td').hide();
        }
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

    $('.qty,.percost,.pertax,.totaltax').live('keyup', function () {
        calculate_function();
    });
    $('.qty').live('keyup', function () {
        add_amount();
        calculate_function();
    });

    function add_amount() {
        if ($('.grand_gst').is(':checked')) {
            $('.qty').each(function () {
                if ($(this).val() != '') {
                    var cost_price = $(this).closest('tr').find('.percost');
                    var actual_cost = $(this).closest('tr').find('.cost_price_actual').val();
                    if (actual_cost == cost_price.val()) {
                        $(this).closest('tr').find('.percost').val(parseInt(actual_cost));
                    } else {
                        $(this).closest('tr').find('.percost').val(parseInt(actual_cost));
                    }
                }
            });

        } else {
            $('.qty').each(function () {
                if ($(this).val() != "") {
                    var cost_price = $(this).closest('tr').find('.percost');

                    var actual_cost = $(this).closest('tr').find('.cost_price_actual').val();
                    var add_amount = $(this).closest('tr').find('.add_amount').val();

                    if (actual_cost == cost_price.val()) {
                        $(this).closest('tr').find('.percost').val(parseInt(cost_price.val()) + parseInt(add_amount));
                    } else {
                        $(this).closest('tr').find('.percost').val(parseInt(cost_price.val()));
                    }
                }
            });
        }

    }
    function calculate_function()
    {
        var final_qty = 0;
        var final_sub_total = 0;
        var cgst = 0;
        var sgst = 0;
        if ($('.grand_gst').is(':checked')) {
            $('.qty').each(function () {
                var qty = $(this);
                var percost = $(this).closest('tr').find('.percost');
                var pertax = $(this).closest('tr').find('.pertax');
                var subtotal = $(this).closest('tr').find('.subtotal');

                if ($('#gst_type').val() != '')
                {
                    if ($('#gst_type').val() == 31)
                    {
                        var gst = $(this).closest('tr').find('.gst');
                    } else {
                        gst = $(this).closest('tr').find('.igst');
                    }
                }

                if (Number(qty.val()) != 0)
                {
                    taxless = Number(qty.val()) * Number(percost.val());
                    total_tax = pertax + gst;
                    pertax1 = Number(pertax.val() / 100) * Number(percost.val());
                    cgst += Number(pertax.val() / 100) * taxless;
                    sgst += Number(gst.val() / 100) * taxless;
                    sub_total = (Number(qty.val()) * Number(percost.val()));
                    subtotal.val(sub_total.toFixed(2));
                    final_qty = final_qty + Number(qty.val());
                    final_sub_total = final_sub_total + sub_total;
                }
            });
            $('.add_cgst').val(cgst.toFixed(2));
            $('.add_sgst').val(sgst.toFixed(2));
            $('.total_qty').val(final_qty);
            $('.final_sub_total').val(final_sub_total.toFixed(2));
            total_item = 0;
            $('.totaltax').each(function () {
                var totaltax = $(this);
                if (Number(totaltax.val()) != 0)
                {
                    total_item = total_item + Number(totaltax.val());
                }
            });

            var final_amt = final_sub_total + total_item + cgst + sgst;
            final_amt = final_amt;
            finals = Math.abs(final_amt);
            $('.final_amt').val(finals.toFixed(2));
        } else {
            $('.qty').each(function () {
                var qty = $(this);
                var percost = $(this).closest('tr').find('.percost');
                var pertax = $(this).closest('tr').find('.pertax');
                var subtotal = $(this).closest('tr').find('.subtotal');
                if (Number(qty.val()) != 0)
                {
                    pertax1 = Number(pertax.val() / 100) * (Number(percost.val()));
                    sub_total = (Number(qty.val()) * (Number(percost.val())));
                    subtotal.val(sub_total.toFixed(2));
                    final_qty = final_qty + Number(qty.val());
                    final_sub_total = final_sub_total + sub_total;
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

    $(document).ready(function () {
        $('body').on('keydown', 'input.model_no', function (e) {
            var product_data = [<?php echo implode(',', $model_numbers_json); ?>];
            cust_id = $('#customer_id').val();
            $(".model_no").autocomplete({
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
                        url: "<?php echo $this->config->item('base_url'); ?>" + "purchase_order/get_product",
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
                                this_val.closest('tr').find('.cost_price').attr('value', (result[0].cost_price));
                                this_val.closest('tr').find('.cost_price_actual').attr('value', (result[0].cost_price));
                                this_val.closest('tr').find('.type').val(result[0].type);
                                this_val.closest('tr').find('.product_id').val(result[0].id);
                                this_val.closest('tr').find('.hsn_sac').val(result[0].hsn_sac);
                                this_val.closest('tr').find('.add_amount').val(result[0].add_amount);
                                this_val.closest('tr').find('.model_no').val(result[0].model_no);
                                //this_val.closest('tr').find('.model_no_extra').val(result[0].model_no);
                                this_val.closest('tr').find('.product_description').val(result[0].product_description);
                                this_val.closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + result[0].product_image);

                                if ($('#gst_type').val() != '')
                                {
                                    if ($('#gst_type').val() == 31)
                                    {
                                        this_val.closest('tr').find('.pertax').val(result[0].cgst);
                                        this_val.closest('tr').find('.gst').val(result[0].sgst);
                                    } else {
                                        this_val.closest('tr').find('.pertax').val(result[0].cgst);
                                        this_val.closest('tr').find('.igst').val(result[0].igst);

                                    }
                                }
                                calculate_function();
                                var model_name = $('#app_table tr:last').find('.model_no').val();
                                if (model_name != '') {
                                    $('#add_group')[0].click();
                                    this_val.closest('tr').find('.qty').focus();
                                    this_val.closest('tr').find('.qty').attr('tabindex', '');
                                }
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
//            url: "<?php echo $this->config->item('base_url'); ?>" + "purchase_order/get_product",
//            data: 'q=' + $(this).val(),
//            success: function (datas) {
//                this_.closest('tr').find(".suggesstion-box1").show();
//                this_.closest('tr').find(".suggesstion-box1").html(datas);
//
//            }
//        });
//    });
    $(document).ready(function () {
        $('body').click(function () {
            $(this).closest('tr').find(".suggesstion-box1").hide();
        });

    });
    $('.pro_class').live('click', function () {
        $(this).closest('tr').find('.brand').val($(this).attr('pro_brand'));
        $(this).closest('tr').find('.cat_id').val($(this).attr('pro_cat'));
        $(this).closest('tr').find('.cost_price').val($(this).attr('pro_cost'));
        $(this).closest('tr').find('.type').val($(this).attr('pro_type'));
        $(this).closest('tr').find('.product_id').val($(this).attr('pro_id'));
        $(this).closest('tr').find('.model_no').val($(this).attr('mod_no'));
        $(this).closest('tr').find('.product_description').val($(this).attr('pro_name') + "  " + $(this).attr('pro_description'));
        $(this).closest('tr').find(".suggesstion-box1").hide();
        calculate_function();
    });

    function f2(textarea)
    {
        string = textarea.value;
        string = string.toUpperCase();
        textarea.value = string;
    }

</script>

