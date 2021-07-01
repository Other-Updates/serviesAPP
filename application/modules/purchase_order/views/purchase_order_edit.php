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
//echo '<pre>';print_r($po);exit;
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Update Purchase Order</h5>
                <?php
                if (isset($po) && !empty($po)) {
                    foreach ($po as $val) {
                        ?>
                        <div style="float:right;" onClick="dcl(this)">
                            <!--<label>GST</label>-->
                            <label class="togswitch">
                                <input type="checkbox" class="grand_gst"  <?php echo ($val['is_gst'] == '1') ? 'checked' : '' ?>>
                                <span class="togslider round"></span>
                            </label>
                            <span class="gst_check_err text-danger"></span>
                        </div>
                        <?php
                    }
                }
                ?>
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
                            <input type="text"  name="model_no[]" id="model_no" tabindex="4" class='form-control auto_customer tabwid model_no' />
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
                            <input type="text" tabindex="-1" name='add_amount[]' class="add_amount  form-control right-align" />
                        </td>

                        <td class="action-btn-align">
                            <input type="text"   tabindex="-1"  name='available_quantity[]' class="code form-control colournamedup tabwid stock_qty cent-align" readonly="readonly"/>
                            <input type="text"  name='quantity[]' tabindex="4" class="qty form-control cent-align" id="qty" />
                            <span class="error_msg text-danger"></span>
                        </td>
                        <td>
                            <input type="text"   tabindex="-1"  name='per_cost[]'  class="cost_price percost form-control right-align " id="price"/>
                            <input type="hidden" name="old_cost_price[]" class="cost_price_actual" />
                            <input type="hidden" class="right-align" name="old_unit_price[]"   >
                            <span class="error_msg text-danger right-align"></span>
                        </td>
                        <td class="action-btn-align cgst_td">
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
                <?php
                if (isset($po) && !empty($po)) {
                    foreach ($po as $val) {
                        ?>
                        <form  method="post" class="panel-body" action="<?php echo $this->config->item('base_url'); ?>purchase_order/update_po/<?php echo $val['id']; ?>" id="purchase_order_form">
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
                                                <input type="text"  tabindex="-1" name="po[po_no]" class="code form-control colournamedup" readonly="readonly" value="<?php echo $val['po_no']; ?>"   id="po_number">
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
                                                <input type="text" tabindex="1" name="supplier[store_name]" value="<?php echo $val['store_name']; ?>" id="customer_name" class='form-control ref_class auto_customer required ' />
                                                <span class="error_msg text-danger"></span>
                                                <input type="hidden"  name="supplier[id]" id="customer_id" class='form-control id_customer tabwid' value="<?php echo $val['id']; ?>" />
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
                                                <input type="text"  tabindex="-1" name="supplier[mobil_number]" id="customer_no"  value="<?php echo $val['mobil_number']; ?>"  class="form-control required" />
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
                                                <input type="text"  tabindex="-1" value="<?php echo $val['email_id']; ?>" name="supplier[email_id]" id="email_id" tabindex="-1" class="form-control required"/>
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
                                                <textarea name="supplier[address1]" tabindex="-1" id="address1" tabindex="-1" class="form-control required"><?php echo $val['address1']; ?></textarea>
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
                                            <td width="5%" class="first_td1 add_amount_td">Add Amt Code</td>
                                            <td  width="3%" class="first_td1">QTY</td>
                                            <td  width="5%" class="first_td1 action-btn-align">Unit Price</td>
                                            <td width="5%" class="first_td1 action-btn-align proimg-wid cgst_td">CGST %</td>
                                            <?php
                                            $gst_type = $po[0]['state_id'];
                                            if ($gst_type != '') {
                                                if ($gst_type == 31) {
                                                    ?>
                                                    <td  width="5%" class="first_td1 action-btn-align proimg-wid sgst_td" >SGST%</td>
                                                <?php } else { ?>
                                                    <td  width="5%" class="first_td1 action-btn-align proimg-wid igst_td" >IGST%</td>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <td  width="7%" class="first_td1">Net Value</td>
                                            <td width="1%" class="action-btn-align"><a id='add_group' class="btn btn-primary btn-mini waves-effect waves-light d-inline-block md-trigger"><span class="fa fa-plus"></span> Add Row</a>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody id='app_table'>
                                        <?php
                                        if (isset($po_details) && !empty($po_details)) {
                                            foreach ($po_details as $vals) {
                                                $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);

                                                $gst_type = $po[0]['state_id'];
                                                if ($gst_type != '') {
                                                    if ($gst_type == 31) {

                                                        $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);
                                                    } else {
                                                        $sgst1 = ($vals['igst'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);
                                                    }
                                                }
                                                $cgst += $cgst1;
                                                $sgst += $sgst1;
                                                ?>
                                                <tr>
                                                    <td>
                                                        <select id="" class="cat_id static_style class_req required form-control" name="categoty[]" tabindex="-1">
                                                            <option value='<?php echo $vals['cat_id'] ?>'><?php echo $vals['categoryName'] ?></option>
                                                            <?php
                                                            if (isset($category) && !empty($category)) {
                                                                foreach ($category as $va) {
                                                                    ?>
                                                                    <option value='<?php echo $va['cat_id'] ?>'><?php echo $va['categoryName'] ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <span class="error_msg text-danger"></span>
                                                    </td>
                                                    <td>
                                                        <select name='brand[]'  class="brand static_style class_req required form-control" tabindex="-1">
                                                            <option value='<?php echo $vals['id'] ?>'> <?php echo $vals['brands'] ?> </option>
                                                            <?php
                                                            if (isset($brand) && !empty($brand)) {
                                                                foreach ($brand as $valss) {
                                                                    ?>
                                                                    <option value='<?php echo $valss['id'] ?>'> <?php echo $valss['brands'] ?></option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <span class="error_msg text-danger"></span>
                                                    </td>
                                                    <td>
                                                        <input type="text"  name="model_no[]" value="<?php echo $vals['model_no']; ?>" id="model_no" tabindex="3" class='form-control auto_customer tabwid model_no required'  />
                                                        <span class="error_msg text-danger"></span>
                                                        <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-align' value="<?php echo $vals['product_id']; ?>"/>
                                                        <input type="hidden"  name="type[]" id="type" class=' tabwid form-align type' />
                                                        <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                                                    </td>
                                                    <td>
                                                        <textarea  name="product_description[]" id="product_description" tabindex="-1" class='form-control auto_customer tabwid4 product_description' onkeyup='f2(this);' /> <?php echo $vals['product_description']; ?> </textarea>
                                                    </td>
                                                    <td class="action-btn-align hsn_td">
                                                        <input type="text" tabindex="-1" name='hsn_sac[]' value="<?php echo $vals['hsn_sac']; ?>" class="hsn_sac  form-control" />
                                                    </td>
                                                    <td class="action-btn-align add_amount_td">
                                                        <input type="text" tabindex="-1" name='add_amount[]' value="<?php echo $vals['add_amount']; ?>" class="add_amount  form-control right-align" />
                                                    </td>
                                                    <?php
                                                    if (isset($vals['stock']) && !empty($vals['stock'])) {
                                                        ?>
                                                        <td class="action-btn-align">
                                                            <input type="text" tabindex="-1"  name='available_quantity[]' class="code form-control colournamedup tabwid form-control stock_qty cent-align" value="<?php echo $vals['stock'][0]['quantity'] ?>" readonly="readonly"/>
                                                            <input type="text"   name='quantity[]' value="<?php echo $vals['quantity'] ?>" class="qty form-control required cent-align" tabindex="3" />
                                                            <span class="error_msg"></span>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td class="action-btn-align">
                                                            <input type="text"   name='quantity[]' value="<?php echo $vals['quantity'] ?>" class="qty form-control required cent-align" tabindex="3" />
                                                            <span class="error_msg"></span>
                                                        </td>
                                                        <?php
                                                    }
                                                    ?>
                                                    <td>
                                                        <input type="text" name='per_cost[]' value="<?php echo $vals['per_cost'] ?>" class="cost_price percost required form-control right-align" tabindex="-1"/>
                                                        <input type="hidden" name="old_cost_price[]" class="cost_price_actual" value="<?php echo $vals['per_cost'] - $vals['add_amount'] ?>"  />
                                                        <input type="hidden" class="cost_price right-align" name="product_cost_price">
                                                        <input type="hidden" class="right-align" name="old_unit_price[]"  value="<?php echo $vals['per_cost'] ?>" >
                                                        <span class="error_msg text-danger"></span>
                                                    </td>
                                                    <td class="cgst_td">
                                                        <input type="text" tabindex="-1"  name='tax[]' readonly="" class="pertax  form-control cent-align" value="<?php echo $vals['tax']; ?>" />
                                                    </td>
                                                    <?php
                                                    $gst_type = $po[0]['state_id'];
                                                    if ($gst_type != '') {
                                                        if ($gst_type == 31) {
                                                            ?>
                                                            <td class="sgst_td">
                                                                <input type="text" tabindex="-1" name='gst[]' readonly="" class="gst form-control cent-align" value="<?php echo $vals['gst']; ?>" />
                                                            </td>
                                                        <?php } else { ?>
                                                            <td class="igst_td">
                                                                <input type="text" name='igst[]' tabindex="-1" readonly="" class="igst form-control cent-align" value="<?php echo $vals['igst']; ?>" />
                                                            </td>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    <td>
                                                        <input type="text"  name='sub_total[]' value="<?php echo $vals['sub_total'] ?>" readonly="readonly" tabindex="-1" class="subtotal text-right form-control" />
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="totbold" style=" text-align:right;">Total</td>
                                            <td class="action-btn-align "><input type="text" tabindex="-1"  name="po[total_qty]"   readonly="readonly" value="<?php echo $val['total_qty']; ?>" class="total_qty form-control cent-align" id="total" /></td>
                                            <td colspan="3" class="gst_add totbold" style="text-align:right;">Sub Total</td>
                                            <td class="remove_gst totbold" style="text-align:right;">Sub Total</td>
                                            <td class="action-btn-align"><input type="text" name="po[subtotal_qty]" tabindex="-1"  readonly="readonly" value="<?php echo$val['subtotal_qty']; ?>"  class="final_sub_total text-right form-control"/></td>
                                            <td></td>
                                        </tr>
                                        <tr class="additional gst_add">
                                            <td colspan="6" class="totbold" style="text-align:right !important;">CGST:</td>
                                            <td colspan="2"><input tabindex="-1" type="text"  value="<?php echo $cgst; ?>"  readonly class="add_cgst text_right form-control"/></td>
                                            <?php
                                            $gst_type = $po[0]['state_id'];
                                            if ($gst_type != '') {
                                                if ($gst_type == 31) {
                                                    ?>
                                                    <td class="totbold" style="text-align:right;">SGST:</td>
                                                <?php } else { ?>
                                                    <td class="totbold" style="text-align:right;">IGST:</td>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <td colspan=""><input type="text" tabindex="-1"  value="<?php echo $sgst; ?>"  readonly class="add_sgst text_right form-control" /></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="5" class="gst_add" style=" text-align:right;"></td>
                                            <td colspan="3" class="remove_gst" style=" text-align:right;"></td>
                                            <td colspan="4" style="text-align:right;font-weight:bold;"><input type="text"  tabindex="-1" name="po[tax_label]" class='tax_label text-right form-control' value="<?php echo $val['tax_label']; ?>"/></td>
                                            <td class="action-btn-align">
                                                <input type="text"  name="po[tax]" class='totaltax text-right form-control' tabindex="-1"  value="<?php echo $val['tax']; ?>"  />
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3" class="gst_add" style=" text-align:right;"></td>
                                            <td colspan="1" class="remove_gst" style=" text-align:right;"></td>
                                            <td colspan="5" id="in_words"></td>
                                            <td class="totbold" style="text-align:right;font-weight:bold;">Net Total</td>
                                            <td class="action-btn-align"><input type="text"  name="po[net_total]" tabindex="-1" readonly="readonly"   class="final_amt text-right form-control" value="<?php echo $val['net_total']; ?>" /></td>
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
                                                    <textarea name="po[remarks]"   class="form-control remark" value="<?php echo $val['remarks']; ?>" tabindex="5" ></textarea>
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
                                                    <input type="text" value="<?php echo $val['mode_of_payment']; ?>" class="form-control class_req borderra0 terms" tabindex="6"  name="po[mode_of_payment]" onkeyup='f2(this);'/>

                                                    <input type="hidden"  name="po[supplier]" id="c_id" class='id_customer' value="<?php echo $val['id']; ?>" />
                                                    <input type="hidden"  name="gst_type" id="gst_type" class="gst_type" value="<?php echo $po[0]['state_id']; ?>" />
                                                    <span class="form-bar"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row m-10">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-primary btn-sm waves-effect waves-light " tabindex="7" id="save" > Update </button>
                                    <a href="<?php echo $this->config->item('base_url') . 'purchase_order/purchase_order_list/' ?>" class="btn btn-inverse btn-sm waves-effect waves-light" tabindex="8" > Back </a>
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
        format: 'd-M-Y',
        maxYear: new Date().getFullYear() + 50
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
                    $('#add_quotation').find('tr td.cgst_td').show();
                    $('.gst_add').show();
                    $('.remove_gst').hide();
                    $('#app_table').find('tr td.sgst_td').show();
                    $('#app_table').find('tr td.igst_td').hide();
                    $('#app_table').find('tr td.cgst_td').show();
                } else {
                    $('.igst_td ').css('display', 'table-cell');
                    $('.cgst_td ').css('display', 'table-cell');
                    $('.sgst_td ').css('display', 'none');
                    $('#add_quotation').find('tr td.sgst_td').hide();
                    $('#add_quotation').find('tr td.igst_td').show();
                    $('#add_quotation').find('tr td.cgst_td').show();
                    $('.gst_add').show();
                    $('.remove_gst').hide();
                }
            } else {
                $('.sgst_td ').css('display', 'none');
                $('.igst_td ').css('display', 'none');
                $('.cgst_td ').css('display', 'none');
                $('#add_quotation').find('tr td.sgst_td').hide();
                $('#add_quotation').find('tr td.igst_td').hide();
                $('#add_quotation').find('tr td.cgst_td').hide();
                $('.gst_add').hide();
                $('.remove_gst').show();
                $('.hsn_td').hide();
                $('.add_amount_td').show();
            }
            in_words = $('.final_amt').val();
            numbertoword = convertNumberToWords(in_words);
            $('#in_words').html(numbertoword);
            $('#gst_check_status_value').val('on');
        } else {
            $('.sgst_td ').css('display', 'none');
            $('.igst_td ').css('display', 'none');
            $('.cgst_td ').css('display', 'none');
            $('#add_quotation').find('tr td.sgst_td').hide();
            $('#add_quotation').find('tr td.igst_td').hide();
            $('#add_quotation').find('tr td.cgst_td').hide();
            $('#app_table').find('tr td.gst').hide();
            $('#app_table').find('tr td.igst').hide();
            $('#app_table').find('tr td.sgst').hide();
            $('.gst_add').hide();
            $('.remove_gst').show();
            in_words = $('.final_amt').val();
            numbertoword = convertNumberToWords(in_words);
            $('#in_words').html(numbertoword);
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
                        $('#add_quotation').find('tr td.cgst_td').show();
                        $('.gst_add').show();
                        $('.remove_gst').hide();
                    } else {
                        $('.igst_td ').css('display', 'table-cell');
                        $('.cgst_td ').css('display', 'table-cell');
                        $('.sgst_td ').css('display', 'none');
                        $('#add_quotation').find('tr td.sgst_td').hide();
                        $('#add_quotation').find('tr td.igst_td').show();
                        $('#add_quotation').find('tr td.cgst_td').show();
                        $('.gst_add').show();
                        $('.remove_gst').hide();
                    }
                } else {
                    $('.sgst_td ').css('display', 'none');
                    $('.igst_td ').css('display', 'none');
                    $('.cgst_td ').css('display', 'none');
                    $('#add_quotation').find('tr td.sgst_td').hide();
                    $('#add_quotation').find('tr td.igst_td').hide();
                    $('#add_quotation').find('tr td.cgst_td').hide();
                    $('.gst_add').hide();
                    $('.remove_gst').show();
                }
                calculate_function();
                in_words = $('.final_amt').val();
                numbertoword = convertNumberToWords(in_words);
                $('#in_words').html(numbertoword);
                $('#gst_check_status_value').val('on');
            } else {
                add_amount();
                $('.sgst_td ').css('display', 'none');
                $('.igst_td ').css('display', 'none');
                $('.cgst_td ').css('display', 'none');
                $('#add_quotation').find('tr td.sgst_td').hide();
                $('#add_quotation').find('tr td.igst_td').hide();
                $('#add_quotation').find('tr td.cgst_td').hide();
                $('.gst_add').hide();
                $('.remove_gst').show();
                $('.hsn_td').hide();
                $('.add_amount_td').show();
                calculate_function();
                in_words = $('.final_amt').val();
                numbertoword = convertNumberToWords(in_words);
                $('#in_words').html(numbertoword);
                $('#gst_check_status_value').val('');
            }
        });
    });
    var gst_ref = 'G';
    var po_number = $('#po_number').val();
    var split_val = po_number.split("/");
    var split_gst = po_number.split("-");
    var split_g = split_val[0].split("-");
    $(document).ready(function () {
        if ($('.grand_gst').is(':checked') && (split_gst.length < 3)) {
            $('.hsn_td').show();
            $('.add_amount_td').hide();
            final_id = split_val[0] + '-' + gst_ref + '/' + split_val[1] + '/' + split_val[2] + '/' + split_val[3];
            $('#po_number').val(final_id);
        } else {
            $('.hsn_td').hide();
            $('.add_amount_td').show();
            final_id = split_val[0] + '/' + split_val[1] + '/' + split_val[2] + '/' + split_val[3];
            $('#po_number').val(final_id);
        }
        $('.grand_gst').click(function () {
            if ($(this).prop('checked') == true && (split_gst.length < 3)) {
                final_id = split_val[0] + '-' + gst_ref + '/' + split_val[1] + '/' + split_val[2] + '/' + split_val[3];
                $('#po_number').val(final_id);
            } else if ($(this).prop('checked') == true && (split_gst.length > 2)) {
                $('#po_number').val(po_number);
            } else {
                if (split_g[1] == 'G') {
                    final_id = split_g[0] + '/' + split_val[1] + '/' + split_val[2] + '/' + split_val[3];
                    $('#po_number').val(final_id);
                } else {
                    final_id = split_val[0] + '/' + split_val[1] + '/' + split_val[2] + '/' + split_val[3];
                    $('#po_number').val(final_id);
                }
            }

        });
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
    });
    $('#add_group').click(function () {
        var tableBody = $(".static").find('tr').clone();
        $(tableBody).closest('tr').find('select,.model_no,.percost,.qty').addClass('required');
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
    $('#delete_label').live('click', function () {
        $(this).closest("tr").remove();
        calculate_function();
    });
    $('.del').live('click', function () {

        var del_id = $(this).closest('tr').find('.del_id').val();
        $.ajax({
            type: "GET",
            url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/delete_id",
            data: {del_id: del_id
            },
            success: function (datas) {
                calculate_function();
            }
        });
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
    $('.percost,.pertax,.totaltax').live('keyup', function () {
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
//        $('.final_amt').val((final_sub_total + Number($('.totaltax').val())).toFixed(2));

            var final_amt = final_sub_total + total_item + cgst + sgst;
            final_amt = final_amt;
            finals = Math.abs(final_amt);
            $('.final_amt').val(finals.toFixed(2));
            in_words = $('.final_amt').val();
            numbertoword = convertNumberToWords(in_words);
            $('#in_words').html(numbertoword);
        } else {
            $('.qty').each(function () {
                var qty = $(this);
                var percost = $(this).closest('tr').find('.percost');
                var subtotal = $(this).closest('tr').find('.subtotal');
                total_item = 0;
                $('.totaltax').each(function () {
                    var totaltax = $(this);
                    if (Number(totaltax.val()) != 0)
                    {
                        total_item = total_item + Number(totaltax.val());
                    }
                });
                if (Number(qty.val()) != 0)
                {
                    sub_total = (Number(qty.val()) * (Number(percost.val())));
                    subtotal.val(sub_total.toFixed(2));
                    final_qty = final_qty + Number(qty.val());
                    final_sub_total = final_sub_total + sub_total;
                }
            });
            $('.total_qty').val(final_qty);
            $('.final_sub_total').val(final_sub_total.toFixed(2));
            $('.final_amt').val((final_sub_total + total_item).toFixed(2));
            in_words = $('.final_amt').val();
            numbertoword = convertNumberToWords(in_words);
            $('#in_words').html(numbertoword);
        }

    }
    $().ready(function () {
        $("#po_no").autocomplete(BASE_URL + "gen/get_po_list", {
            width: 260,
            autoFocus: true,
            matchContains: true,
            selectFirst: false
        });
    });</script>
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
                        this_val.closest('tr').find('.cost_price').val('');
                        this_val.closest('tr').find('.type').val('');
                        this_val.closest('tr').find('.product_id').val('');
                        this_val.closest('tr').find('.product_description').val('');
                        this_val.closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/no-img.gif' ?>");
                        this_val.closest('tr').find('.pertax').val('');
                        this_val.closest('tr').find('.gst').val('');
                        this_val.closest('tr').find('.hsn_sac').val('');
                        this_val.closest('tr').find('.add_amount').val('');
                        this_val.closest('tr').find('.igst').val('');
                        this_val.closest('tr').find('.qty').val('');
                        this_val.closest('tr').find('.subtotal').val('');
                        this_val.closest('tr').find('.stock_qty').val('');
                        calculate_function();
                    } else {
                        $.ajax({
                            type: 'POST',
                            data: {model_number_id: model_number_id, c_id: cust_id},
                            url: "<?php echo $this->config->item('base_url'); ?>" + "purchase_order/get_product/",
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
                                    //  this_val.closest('tr').find('.model_no_extra').val(result[0].model_no);
                                    this_val.closest('tr').find('.product_description').val(result[0].product_description);

                                    if (result[0].product_image != '') {
                                        $.ajax({
                                            url: "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + result[0].product_image,
                                            type: 'HEAD',
                                            error: function ()
                                            {
                                                this_val.closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/no-img.gif' ?>");
                                            },
                                            success: function ()
                                            {
                                                this_val.closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + result[0].product_image);
                                            }
                                        });
                                    } else {
                                        this_val.closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/no-img.gif' ?>");
                                    }

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
                }
            });
        });
    });

    $(document).ready(function () {
        $('body').click(function () {
            $(this).closest('tr').find(".suggesstion-box1").hide();
        });
    });
    $('.pro_class').live('click', function () {
        $(this).closest('tr').find('.brand').val($(this).attr('pro_brand'));
        $(this).closest('tr').find('.cat_id').val($(this).attr('pro_cat'));
        $(this).closest('tr').find('.cost_price').val($(this).attr('pro_sell'));
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
        $(this).closest('tr').find('.pertax').val($(this).attr('ser_cgst'));
        $(this).closest('tr').find('.cost_price').val($(this).attr('ser_sell'));
        $(this).closest('tr').find('.type_ser').val($(this).attr('ser_type'));
        $(this).closest('tr').find('.product_id').val($(this).attr('ser_id'));
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

    $(document).ready(function () {
        var text_val = $('#customer_name').val();
        if (text_val === "") {
            $('#customer_name').parent().find(".float-label").removeClass('newClass');
            $('#customer_name').parent().find(".float-label").addClass('newClass1');
        } else {
            $("#customer_name").parent().find(".float-label").removeClass('newClass1');
            $("#customer_name").parent().find(".float-label").addClass('newClass');
        }
    });

</script>
<script>
    $(document).ready(function () {
        in_words = $('.final_amt').val();
        numbertoword = convertNumberToWords(in_words);
        $('#in_words').html(numbertoword);
    });

    function convertNumberToWords(amount) {
        var words = new Array();
        words[0] = '';
        words[1] = 'One';
        words[2] = 'Two';
        words[3] = 'Three';
        words[4] = 'Four';
        words[5] = 'Five';
        words[6] = 'Six';
        words[7] = 'Seven';
        words[8] = 'Eight';
        words[9] = 'Nine';
        words[10] = 'Ten';
        words[11] = 'Eleven';
        words[12] = 'Twelve';
        words[13] = 'Thirteen';
        words[14] = 'Fourteen';
        words[15] = 'Fifteen';
        words[16] = 'Sixteen';
        words[17] = 'Seventeen';
        words[18] = 'Eighteen';
        words[19] = 'Nineteen';
        words[20] = 'Twenty';
        words[30] = 'Thirty';
        words[40] = 'Forty';
        words[50] = 'Fifty';
        words[60] = 'Sixty';
        words[70] = 'Seventy';
        words[80] = 'Eighty';
        words[90] = 'Ninety';
        amount = amount.toString();
        var atemp = amount.split(".");
        var number = atemp[0].split(",").join("");
        var n_length = number.length;
        var words_string = "";
        if (n_length <= 9) {
            var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
            var received_n_array = new Array();
            for (var i = 0; i < n_length; i++) {
                received_n_array[i] = number.substr(i, 1);
            }
            for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
                n_array[i] = received_n_array[j];
            }
            for (var i = 0, j = 1; i < 9; i++, j++) {
                if (i == 0 || i == 2 || i == 4 || i == 7) {
                    if (n_array[i] == 1) {
                        n_array[j] = 10 + parseInt(n_array[j]);
                        n_array[i] = 0;
                    }
                }
            }
            value = "";
            for (var i = 0; i < 9; i++) {
                if (i == 0 || i == 2 || i == 4 || i == 7) {
                    value = n_array[i] * 10;
                } else {
                    value = n_array[i];
                }
                if (value != 0) {
                    words_string += words[value] + " ";
                }
                if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += "Crores ";
                }
                if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += "Lakhs ";
                }
                if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                    words_string += "Thousand ";
                }
                if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                    words_string += "Hundred and ";
                } else if (i == 6 && value != 0) {
                    words_string += "Hundred ";
                }
            }
            words_string = words_string.split("  ").join(" ");
        }
        return words_string;
    }
</script>

