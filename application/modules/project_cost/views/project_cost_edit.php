<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/spectrum/js/spectrum.js"></script>
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/jscolor/js/jscolor.js"></script>
<!-- Mini-color js -->
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/jquery-minicolors/js/jquery.minicolors.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<!-- Custom js -->
<style type="text/css">
    #add_group, #add_group_service {
        color: #fff;
    }
    #delete_group, #add_label, #delete_label {
        color: #fff;
    }
    .sub-title {
        margin-bottom: 0px;
    }
    .remark {
        float: left;
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
?>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Edit Project Cost</h5>
            </div>
            <div class="card-block">
                <table class="static1" style="display:none">
                    <?php
                    // foreach ($quotation[0]['other_cost'] as $key => $val) {
                    ?>
                    <tr>
                        <td colspan="2" style=" text-align:right;"></td>
                        <td colspan="5" style="text-align:right;font-weight:bold;"><input type="text" name="item_name[]" tabindex="-1" class="tax_label form-control text-right" style="width:100%;" ><span class="error_msg"></span></td>
                        <td>
                            <input type="text" name="amount[]" class="totaltax form-control text-right"  tabindex="-1"  ><span class="error_msg"></span>
                            <input type="hidden" name="type[]" class="text-right"  value="project_cost" >
                        </td>
                        <td width="2%" class="action-btn-align"><a id='delete_label' class="del btn btn-danger btn-mini"><span class="fa fa-trash"></span></a></td>
                    </tr>
                    <?php
                    //}
                    ?>
                </table>
                <table class="static" style="display: none;">
                    <tr>
                        <!--<td></td>-->
                        <td>
                            <select id='' class='cat_id static_style form-control class_req required' name='categoty[]' tabindex="-1">
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
                            <span class="error_msg"></span>
                        </td>
                        <td>
                            <select name='brand[]' class='brand_id form-control required brand' tabindex="-1">
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
                            <span class="error_msg"></span>
                        </td>
                        <td >
                            <input type="text"  name="model_no[]" id="model_no" class='form-control auto_customer tabwid model_no' tabindex="3"/>
                            <span class="error_msg"></span>
                            <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-control product_id' />
                            <input type="hidden"  name="product_type[]" id="type" class=' tabwid form-control type' />
                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                        </td>
                        <td>
                            <textarea  name="product_description[]" tabindex="-1" id="product_description" class='form-control auto_customer tabwid4 product_description' onkeyup='f2(this);'/>  </textarea>
                        </td>
                        <td class="action-btn-align add_amount_td">
                            <input type="text"  name="add_amount[]" id="add_amount" tabindex="-1"  class='form-control add_amount right-align' />

                        </td>
                        <td>
                            <input type="text"   tabindex="-1"  name='available_quantity[]' class="code form-control colournamedup tabwid stock_qty cent-align" readonly="readonly"/>
                            <input type="text"   tabindex="3"  name='quantity[]' class="qty form-control cent-align" id="qty" onkeypress="return isNumber(event, this)"/>
                            <input type="hidden" name='old_quantity[]' class="old_qty"  value="0"/>
                            <span class="error_msg"></span>
                        </td>

                        <td><div class="avl_qty">
                                <input type="text"   tabindex="-1"  name='per_cost[]' class="cost_price percost form-control text-right" id="price" onkeypress="return isNumber(event, this)"/>
                                <span class="error_msg"></span></div>
                        </td>

                        <td style="display:none">
                            <input type="text"   tabindex="-1"   name='tax[]' class="pertax form-control" />
                        </td>
                        <td>
                            <input type="text" name='sub_total[]' tabindex="-1" readonly="readonly" id="sub_toatl" class="subtotal form-control text-right" />
                        </td>
                        <td class="action-btn-align"><a id='delete_group' class="del btn btn-danger btn-mini" tabindex="-1"><span class="fa fa-trash"></span></a></td>
                    </tr>
                </table>
                <table class="static_ser" style="display: none;">
                    <tr>
                        <td>
                            <select id='' class='cat_id static_style form-control class_req' name='categoty[]' tabindex="-1">
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
                            <span class="error_msg"></span>
                        </td>
        <!--                            <td class="sub_category">
                            <select class=" static_color" name='sub_categoty[]'>
                                <option value="">select</option>
                            </select>
                        </td>-->
                        <td >
                            <select name='brand[]' class='brand_id form-control brand' tabindex="-1" >
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
                            <span class="error_msg"></span>
                        </td>
                        <td >
                            <input type="text"  name="model_no[]" id="model_no_ser" class='form-control auto_customer tabwid model_no_ser' tabindex="3"/>
                            <span class="error_msg"></span>
                            <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-control product_id' />
                            <input type="hidden"  name="product_type[]" id="type_ser" class=' tabwid form-control type type_ser' />
                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                        </td>
                        <td>
                            <textarea  name="product_description[]" tabindex="-1" id="product_description" class='form-control auto_customer tabwid4 product_description' onkeyup='f2(this);' />  </textarea>
                        </td>
                        <td class="action-btn-align add_amount_td">
                            <input type="text"  name="add_amount[]" id="add_amount" tabindex="-1"  class='form-control add_amount right-align' />

                        </td>
                        <td>
                            <input type="hidden"    name='available_quantity[]'  value="0" readonly="readonly"/>
                            <input type="text"   tabindex="3"  name='quantity[]' class="qty form-control cent-align" id="qty" onkeypress="return isNumber(event, this)"/>
                            <input type="hidden" name='old_quantity[]' class="old_qty" value="0"/>
                            <span class="error_msg"></span>
                        </td>
                        <td><div class="avl_qty">
                                <input type="text"   tabindex="-1"  name='per_cost[]' class="cost_price percost form-control right-align" id="price" onkeypress="return isNumber(event, this)"/>
                                <span class="error_msg"></span></div>
                        </td>
                        <td style="display:none">
                            <input type="text"   tabindex="-1"   name='tax[]' class="pertax form-control" />
                        </td>
                        <td>
                            <input type="text"  name='sub_total[]' tabindex="-1" readonly="readonly" id="sub_toatl" class="subtotal form-control text-right" />
                        </td>
                        <td class="action-btn-align"><a id='delete_group' class="del btn btn-danger btn-mini"><span class="fa fa-trash"></span></a></td>
                    </tr>
                </table>

                <?php
                if (isset($quotation) && !empty($quotation)) {
                    foreach ($quotation as $val) {
                        ?>
                        <form  action="<?php echo $this->config->item('base_url'); ?>project_cost/update_project_cost/" method="post">
                            <input type="hidden" name="quotation[q_id]" value="<?php echo trim($val['q_id']); ?>" />
                            <input type="hidden" name="pjt_cost_id" value="<?php echo trim($val['id']); ?>" />
                            <table  class="table responsive table-bordered dataTable no-footer dtr-inline">
                                <tr>
                                    <td class="text-left"><span  class="f-w-700">TO,</span><br/>
                                        <div><?php echo $val['address1']; ?></div>
                                    </td>
                                    <td class="action-btn-align"> <img src="<?= $theme_path; ?>/assets/images/logo-1.png" alt="Chain Logo" width="125px" ></td>
                                </tr>
                                <tr>
                                    <td class="text-left"><span  class="f-w-700"> Contact Person:</span> <?php echo $val['name'] ?>
                                        <input type="hidden"  name="quotation[customer]" id="c_id" class='id_customer'  value="<?php echo $val['customer']; ?>"/>
                                    </td>
                                    <td class="text-left"> <span  class="f-w-700"> Quotation NO:</span>  <?php echo $val['q_no']; ?> </td>
                                </tr>
                                <tr>
                                    <td class="text-left"><span  class="f-w-700"> Project Cost Id:</span><?php echo $val['job_id']; ?>
                                        <input type="hidden"  name="quotation[job_id]" class="code form-control colournamedup tabwid form-control" value="<?php echo $val['job_id']; ?> "  id="grn_no">
                                    </td>
                                    <td class="text-left"><span  class="f-w-700">Company Name:</span> <?php echo $val['store_name']; ?> </td>
                                </tr>
                                <tr>
                                    <td class="text-left"><span  class="f-w-700">Customer Mobile No:</span><?php echo $val['mobil_number']; ?> </td>
                                    <td class="text-left" id='customer_td'><span  class="f-w-700">Customer Email ID:</span> <?php echo $val['email_id']; ?> </td>
                                </tr>
                                <tr>
                                    <td class="text-left"><span  class="f-w-700"> Date:</span>
                                        <input type="text" id="dropper-default" tabindex="1" data-date="" data-month="" data-year=""  class="form-control tabwid" name="quotation[created_date]" value="<?= date('d-M-Y', strtotime($val['created_date'])); ?>" style="width:200px; display: inline"/>
                                    </td>
                                    <td class="text-left"><!--<span  class="f-w-700">GSTIN No:</span> <?php //echo $company_details[0]['tin_no']                                                     ?> --> </td>

                                </tr>
                            </table>

                            <div class="action-btn-inner-table">
                                <a id='add_group' class="btn btn-primary btn-mini waves-effect waves-light d-inline-block md-trigger"><span class="fa fa-plus"></span> Add Product</a>
                                <a id='add_group_service' class="btn btn-primary btn-mini waves-effect waves-light d-inline-block md-trigger "><span class="fa fa-plus"></span> Add Service</a>
                            </div>
                            <table class="table  table-bordered responsive dataTable no-footer dtr-inline m-t-5" id="add_quotation">
                                <thead>
                                    <tr>
                                        <!--<td width="3%" class="first_td1">S.No</td>-->
                                        <td width="10%" class="first_td1">Category</td>
                                        <td width="10%" class="first_td1">Brand</td>
                                        <td width="10%" class="first_td1">Model Number</td>
                                        <td width="10%" class="first_td1">Product Description</td>
                                        <td width="5%" class="first_td1 add_amount_td">Add Amt</td>
                                        <td  width="3%" class="first_td1">QTY</td>
                                        <td  width="6%" class="first_td1">Unit Price</td>
                                        <td width="6%" class="first_td1" style="display:none">Tax</td>
                                        <td  width="8%" class="first_td1">Net Value</td>
                                        <td width="2%" class="action-btn-align remove_nowrap">

                                        </td>
                                    </tr>
                                </thead>
                                <tbody id='app_table'>
                                    <?php
                                    $sno_count = 0;
                                    if (isset($quotation_details) && !empty($quotation_details)) {
                                        foreach ($quotation_details as $vals) {
//                                            $sno_count++;
                                            ?>
                                            <tr>
                                                <!--<td><?php echo $sno_count; ?></td>-->
                                                <td>
                                                    <select id='' class='cat_id static_style form-control class_req required' name='categoty[]' tabindex="-1" >
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
                                                    <span class="error_msg"></span>
                                                </td>

                                                <td >
                                                    <select name='brand[]' class="brand_id form-control required brand" tabindex="-1" >
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
                                                    <span class="error_msg"></span>
                                                </td>
                                                <td>
                                                    <input type="text"  name="model_no[]" id="model_no" tabindex="2" class='form-control auto_customer tabwid <?php echo ($vals['type'] == 'product') ? 'model_no' : 'model_no_ser'; ?> required' value="<?php echo $vals['model_no']; ?>"/>
                                                    <span class="error_msg"></span>
                                                    <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-control' value="<?php echo $vals['product_id']; ?>" />
                                                    <input type="hidden"  name="product_type[]" id="type" class=' tabwid form-control type'value="<?php echo $vals['type']; ?>"  />
                                                    <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                                                </td>
                                                <td>
                                                    <textarea  name="product_description[]" tabindex="-1" id="product_description" class='form-control auto_customer tabwid4 product_description' onkeyup='f2(this);' /><?php echo $vals['product_description']; ?></textarea>
                                                </td>

                                                <td class="action-btn-align add_amount_td">
                                                    <input type="text"  name="add_amount[]" id="add_amount" tabindex="-1" value="<?php echo $vals['po_add_amount']; ?>"  class='form-control add_amount right-align' />

                                                </td>
                                                <?php
                                                if ($vals['type'] == 'product') {
                                                    if (isset($vals['stock']) && !empty($vals['stock'])) {
                                                        ?>
                                                        <td>
                                                            <input type="text" tabindex="-1"  name='available_quantity[]' class="code form-control colournamedup tabwid form-control stock_qty cent-align" value="<?php echo $vals['stock'][0]['quantity'] ?>" readonly="readonly"/>
                                                            <input type="text"  name='quantity[]' tabindex="2"  class="qty form-control required cent-align" value="<?php echo $vals['quantity'] ?>" onkeypress="return isNumber(event, this)"/>
                                                            <input type="hidden" name='old_quantity[]' class="old_qty" value="<?php echo ($is_update =='1') ? $vals['quantity'] : '0' ?>"/>
                                                            <span class="error_msg"></span>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td><div class="avl_qty"></div>
                                                            <input type="text" tabindex="-1"  name='available_quantity[]' class="code form-control colournamedup tabwid form-control stock_qty cent-align" value="0" readonly="readonly"/>
                                                            <input type="text"  name='quantity[]' tabindex="2" class="qty form-control required cent-align" value="<?php echo $vals['quantity'] ?>" onkeypress="return isNumber(event, this)"/>
                                                            <input type="hidden" name='old_quantity[]'  class="old_qty" value="<?php echo ($is_update =='1') ? $vals['quantity'] : '0' ?>"/>
                                                            <span class="error_msg"></span>
                                                        </td>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                                <?php if ($vals['type'] == 'service') {
                                                    ?>
                                                    <td>
                                                        <input type="hidden" name='available_quantity[]' class="form-align" value="0" />
                                                        <input type="text"  name='quantity[]' tabindex="2" class="qty form-control required cent-align" value="<?php echo $vals['quantity'] ?>" onkeypress="return isNumber(event, this)"/>
                                                        <input type="hidden" name='old_quantity[]'  class="old_qty" value="0"/>
                                                        <span class="error_msg"></span>
                                                    </td>
                                                <?php } ?>
                                                <td><div class="avl_qty">
                                                    <input type="text"   tabindex="-1"  name='per_cost[]' class="cost_price form-control percost required right-align" value="<?php echo $vals['per_cost'] ?>" onkeypress="return isNumber(event, this)" /><!--value="<?php echo $vals['po'][0]['per_cost'] ?>"-->
                                                        <span class="error_msg"></span></div>
                                                </td>
                                                <td style="display:none">
                                                    <input type="text"   tabindex="-1"   name='tax[]' class="pertax form-control" value="<?php echo $vals['tax'] ?>" />
                                                </td>
                                                <td>
                                                    <input type="text" name='sub_total[]' tabindex="-1" readonly="readonly" class="subtotal text-right form-control" value="<?php echo $vals['sub_total'] ?>"/>
                                                </td>
                                        <input type="hidden" value = "<?php echo $vals['p_id']; ?>" class="del_id"/>
                                        <td width="2%" class="action-btn-align"><a id='delete_label' value = "<?php echo $vals['p_id']; ?>" class="del btn btn-danger btn-mini waves-effect waves-light"><span class="fa fa-trash"></span></a></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td colspan="5" class="totbold" style=" text-align:right;">Total</td>
                                        <td><input type="text" tabindex="-1"  name="quotation[total_qty]"   readonly="readonly" value="<?php echo $val['total_qty']; ?>" class="total_qty form-control cent-align"  id="total" /></td>
                                        <td class="totbold" style="text-align:right;">Sub Total</td>
                                        <td><input type="text" tabindex="-1" name="quotation[subtotal_qty]"  readonly="readonly" value="<?php echo $val['subtotal_qty']; ?>"  class="final_sub_total form-control text-right" /></td>
                                        <td></td>
                                    </tr>
                                </tbody>
        <!--                                <tbody>
                                <td colspan="5" style=" text-align:right;"></td>
                                <td class="totbold" style="text-align:right;">Advance</td>
                                <td><input type="text" name="quotation[advance]" tabindex="-1"  value="<?php echo (!empty($val['advance'])) ? $val['advance'] : 0; ?>"  class="advance text_right form-control"/></td>
                                <td></td>
                                </tbody>-->
                                <tbody class="add_cost">
                                    <tr>
                                        <td colspan="2" style=" text-align:right;"></td>
                                        <td colspan="5" style="text-align:right;font-weight:bold;"><input type="text"  tabindex="-1" name="quotation[tax_label]" class='tax_label form-control text-right'    style="width:100%;" value="<?php echo $val['tax_label']; ?>"/></td>
                                        <td>
                                            <input type="text"  name="quotation[tax]" tabindex="-1" class='totaltax text-right form-control'  value="<?php echo $val['tax']; ?>"  />
                                        </td>
                                        <td width="2%" class="action-btn-align"><a id='add_label' class="btn btn-primary form-control btn-mini"><span class="fa fa-plus"></span> Add </a></td>
                                    </tr>
                                    <?php foreach ($val["other_cost"] as $key => $valu) {
                                        ?>
                                        <tr>
                                            <td colspan="2" style="text-align:right;"></td>
                                            <td colspan="5" style="text-align:right;font-weight:bold;"><input type="text" name="item_name[]" tabindex="-1" class="tax_label form-control text-right" value="<?php echo $valu['item_name']; ?>" ></td>
                                            <td>
                                                <input type="text" name="amount[]" value="<?php echo number_format($valu['amount'], 2); ?>" class="totaltax form-control text-right"  tabindex="-1" >
                                                <input type="hidden" name="type[]" class="text-right"  value="project_cost" >
                                            </td>
                                            <td width="2%" class="action-btn-align"><a id='delete_label' class="del btn btn-danger btn-mini waves-effect waves-light"><span class="fa fa-trash"></span></a></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" style="text-align:right;"></td>
                                        <td colspan="4" id="in_words"></td>
                                        <td style="text-align:right;font-weight:bold;">Net Total</td>
                                        <td><input type="text"  name="quotation[net_total]" tabindex="-1"  readonly="readonly" class="final_amt form-control text-right" value="<?php echo $val['net_total']; ?>" /></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="9" style="">
                                            <span class="remark">Remarks&nbsp;&nbsp;&nbsp;</span>
                                            <input tabindex="4" name="quotation[remarks]" type="text" class="form-control remark"  value="<?php echo $val['remarks']; ?>" />
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="form-group row m-10">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-primary btn-sm waves-effect waves-light " tabindex="8" id="save" onclick="javascript: form.action = '<?php echo $this->config->item('base_url') . 'project_cost/update_project_cost/';?>';"  > Update </button>
                                    <button class="btn btn-success btn-sm waves-effect waves-light complete" tabindex="9" id="complete_btn" onclick="javascript: form.action = '<?php echo $this->config->item('base_url') . 'project_cost/change_completed_status/' . $quotation[0]['id'] . '/2' ?>';"  > Complete </button>
                                    <a href="<?php echo $this->config->item('base_url') . 'project_cost/project_cost_list/' ?>" class="btn btn-inverse btn-sm waves-effect waves-light" tabindex="10" > Back </a>
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
        maxYear: new Date().getFullYear() + 50,
        format: 'd-M-Y'
    });
    
    $('#complete_btn').live('click', function (e) {
        var m = 0;
        $('#add_quotation .required').each(function () {
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
                $(this).closest('td').find('.error_msg').text('This field is required').css('display', 'inline-block');
                m++;
            } else {
                $(this).closest('td').find('.error_msg').text('');
            }
        });
        
        $('#add_quotation .qty').each(function () {
            var qty = $.trim($(this).val());
            var old_qty = $(this).closest('tr').find('.old_qty').val();
            var stock_qty = $(this).closest('tr').find('.stock_qty').val();
            var diff = Number(qty) - Number(old_qty);
            
            if (qty != "") {
                // if (Number(qty) > Number(stock_qty)) {
                //     $(this).closest('td').find('.error_msg').text('Invalid Qty').css('display', 'inline-block');
                //     m = 1;
                // } else
                 if (Number(stock_qty) < Number(diff)) {
                    $(this).closest('td').find('.error_msg').text('Invalid Qty').css('display', 'inline-block');
                    m = 1;
                } else {
                    $(this).closest('td').find('.error_msg').text("");
                }
            }
        });        
        
        if (m == 0) 
            return true;
        
        return false;

    });
    
    $('#save').live('click', function () {
        m = 0;
        $('#add_quotation .required').each(function () {
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
                $(this).closest('td').find('.error_msg').text('This field is required').css('display', 'inline-block');
                m++;
            } else {
                $(this).closest('td').find('.error_msg').text('');
            }
        });
        
        $('#add_quotation .qty').each(function () {
            var qty = $.trim($(this).val());
            var old_qty = $(this).closest('tr').find('.old_qty').val();
            var stock_qty = $(this).closest('tr').find('.stock_qty').val();
            var diff = Number(qty) - Number(old_qty);
            
            if (qty != "") {
                // if (Number(qty) > Number(stock_qty)) {
                //     $(this).closest('td').find('.error_msg').text('Invalid Qty').css('display', 'inline-block');
                //     m = 1;
                // } else
                 if (Number(stock_qty) < Number(diff)) {
                    $(this).closest('td').find('.error_msg').text('Invalid Qty').css('display', 'inline-block');
                    m = 1;
                } else {
                    $(this).closest('td').find('.error_msg').text("");
                }
            }
        });    
        
        /*$('#add_quotation .stock_qty').each(function () {

            var qty = $(this).closest('tr').find('.qty').val();
            var old_qty = $(this).closest('tr').find('.old_qty').val();
            var diff = Number(qty) - Number(old_qty);
            
            stock_qty = $.trim($(this).val());
            if (Number(stock_qty) < Number(diff))
            {
                $(this).closest('td').find('.error_msg').text('Invalid Qty').css('display', 'inline-block');
                m++;
            } else {
                $(this).closest('td').find('.error_msg').text("");
            }
        });*/
        if (m > 0)
            return false;

    });
    $('.qty').live('keyup', function () {
        // var pro_qty = $(this).val();
        // var stock_qty = $(this).closest('tr').find('.stock_qty').val();
        // if (Number(pro_qty) > Number(stock_qty))
        // {
        //     $(this).closest('td').find('.error_msg').text('Invalid Qty').css('display', 'inline-block');
        // } else {
        //     $(this).closest('td').find('.error_msg').text("");
        // }
        var qty = $.trim($(this).val());
        var old_qty = $(this).closest('tr').find('.old_qty').val();
        var stock_qty = $(this).closest('tr').find('.stock_qty').val();
        var diff = Number(qty) - Number(old_qty);
        if (qty != "") {
            if (Number(stock_qty) < Number(diff)) {
                $(this).closest('td').find('.error_msg').text('Invalid Qty').css('display', 'inline-block');
                m = 1;
            } else {
                $(this).closest('td').find('.error_msg').text("");
            }
        }
    });
    $(document).ready(function () {
        // var $elem = $('#scroll');
        //  window.csb = $elem.customScrollBar();
        $("#customer_name").keyup(function () {
            $.ajax({
                type: "GET",
                url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_customer",
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
        $("#c_id").val($(this).attr('cust_id'));
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
    $('#add_group_service').click(function () {
        var tableBody = $(".static_ser").find('tr').clone();
        $(tableBody).closest('tr').find('select,.model_no,.model_no_ser,.percost,.qty').addClass('required');
        $('#app_table').append(tableBody);
    });
    $('#add_label').click(function () {
        var tables = $(".static1").find('tr:last').clone();
        $(tables).closest('tr').find('.tax_label,.totaltax').addClass('required');
        $('.add_cost').append(tables);

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
            url: "<?php echo $this->config->item('base_url'); ?>" + "project_cost/delete_id",
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

    $('.qty,.percost,.pertax,.totaltax').live('keyup', function () {
        calculate_function();
    });
    function calculate_function()
    {
        var final_qty = 0;
        var final_sub_total = 0;
        $('.qty').each(function () {
            var qty = $(this);
            var percost = $(this).closest('tr').find('.percost');
            var pertax = $(this).closest('tr').find('.pertax');
            var subtotal = $(this).closest('tr').find('.subtotal');

            if (Number(qty.val()) != 0)
            {
                pertax1 = Number(pertax.val() / 100) * Number(percost.val());
                sub_total = (Number(qty.val()) * (Number(percost.val())));
                subtotal.val(sub_total.toFixed(2));
                final_qty = final_qty + Number(qty.val());
                final_sub_total = final_sub_total + sub_total;
            }
        });
        $('.total_qty').val(final_qty);
        $('.final_sub_total').val(final_sub_total.toFixed(2));
        //other item total
        total_item = 0;
        $('.totaltax').each(function () {
            var totaltax = $(this);
            if (Number(totaltax.val()) != 0)
            {
                total_item = total_item + Number(totaltax.val());
            }
        });
        var final_amt = final_sub_total + total_item;
        $('.final_amt').val(final_amt.toFixed(2));
        in_words = $('.final_amt').val();
        numbertoword = convertNumberToWords(in_words);
        $('#in_words').html(numbertoword);
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
                                    this_val.closest('tr').find('.pertax').val(result[0].cgst);
                                    this_val.closest('tr').find('.gst').val(result[0].sgst);
                                    this_val.closest('tr').find('.discount').val(result[0].discount);
                                    this_val.closest('tr').find('.cost_price').val(parseInt(result[0].cost_price) + parseInt(result[0].po_add_amount));
                                    this_val.closest('tr').find('.type').val(result[0].type);
                                    this_val.closest('tr').find('.product_id').val(result[0].id);
                                    this_val.closest('tr').find('.model_no').val(result[0].model_no);
                                    this_val.closest('tr').find('.add_amount').val(result[0].po_add_amount);
                                    // this_val.closest('tr').find('.model_no_extra').val(result[0].model_no);
                                    this_val.closest('tr').find('.product_description').val(result[0].product_description);
                                    this_val.closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + result[0].product_image);
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
        $('body').on('keydown', 'input.model_no_ser', function (e) {
            var product_data = [<?php echo implode(',', $model_numbers_json1); ?>];
            cat_id = $('#firm').val();
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
                                this_val.closest('tr').find('.pertax').val(result[0].cgst);
                                this_val.closest('tr').find('.gst').val(result[0].sgst);
                                this_val.closest('tr').find('.discount').val(result[0].discount);
                                this_val.closest('tr').find('.cost_price').val(parseInt(result[0].cost_price) + parseInt(result[0].po_add_amount));
                                this_val.closest('tr').find('.type').val(result[0].type);
                                this_val.closest('tr').find('.product_id').val(result[0].id);
                                this_val.closest('tr').find('.add_amount').val(result[0].po_add_amount);
                                this_val.closest('tr').find('.model_no_ser').val(result[0].model_no);
                                //  this_val.closest('tr').find('.model_no_extra').val(result[0].model_no);
                                this_val.closest('tr').find('.product_description').val(result[0].product_description);
                                this_val.closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + result[0].product_image);
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
//    $("#model_no").live('keyup', function () {
//        var this_ = $(this)
//        $.ajax({
//            type: "GET",
//            url: "<?php echo $this->config->item('base_url'); ?>" + "project_cost/get_product",
//            data: 'q=' + $(this).val(),
//            success: function (datas) {
//                this_.closest('tr').find(".suggesstion-box1").show();
//                this_.closest('tr').find(".suggesstion-box1").html(datas);
//
//            }
//        });
//    });
//
//    $("#model_no_ser").live('keyup', function () {
//        var this_ = $(this)
//        $.ajax({
//            type: "GET",
//            url: "<?php echo $this->config->item('base_url'); ?>" + "project_cost/get_service",
//            data: 's=' + $(this).val(),
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
    $(document).ready(function () {

        calculate_function();
    });
    $('.pro_class').live('click', function () {
        $(this).closest('tr').find('.brand').val($(this).attr('pro_brand'));
        $(this).closest('tr').find('.cat_id').val($(this).attr('pro_cat'));
        $(this).closest('tr').find('.cost_price').val($(this).attr('pro_cost'));
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
        $(this).closest('tr').find('.cost_price').val($(this).attr('ser_cost'));
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


