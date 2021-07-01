<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script async  src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script async  src="<?= $theme_path; ?>/assets/js/jquery-ui-my-1.10.3.min.js"></script>

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
<style>
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
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Add Project Cost</h5>
            </div>
            <div class="card-block">
                <table class="static1" style="display: none;">
                    <tr>
                        <td colspan="2" style=" text-align:right;"></td>
                        <td colspan="5" style="text-align:right;font-weight:bold;"><input type="text" name="item_name[]" class="tax_label form-control text-right" style="width:100%;" ></td>
                        <td>
                            <input type="text" name="amount[]" class="totaltax form-control text-right"   tabindex="-1" style="width:100%;" >
                            <input type="hidden" name="type[]" class="text-right"  value="project_cost"  >
                        </td>
                        <td width="2%" class="action-btn-align"><a id='delete_label' class="del btn btn-danger btn-mini"><span class="fa fa-trash"></span></a></td>
                    </tr>
                </table>
                <table class="static" style="display: none;">
                    <tr>
                        <td>
                            <select id='' class='cat_id static_style form-control class_req' tabindex="-1"  name='categoty[]'>
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

                        <td >
                            <select name='brand[]' class="brand form-control" tabindex="-1">
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
                            <input type="text"  name="model_no[]"  tabindex="3" id="model_no" class='form-control auto_customer tabwid model_no' />
                            <span class="error_msg"></span>
                            <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-control product_id' />
                            <input type="hidden"  name="product_type[]" id="type" class=' tabwid form-control type' />
                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                        </td>
                        <td>
                            <textarea tabindex="-1" name="product_description[]" id="product_description"   class='form-control auto_customer tabwid product_description' onkeyup='f2(this);'/>  </textarea>
                        </td>
                        <td >
                            <input type="text"  name="add_amount[]" id="add_amount" class='form-control add_amount' tabindex="-1"  />
                        </td>
                        <td>
                            <input type="text"   tabindex="-1"  name='available_quantity[]' class="code form-control stock_qty" value="0" readonly="readonly"/>
                            <input type="text"   tabindex="3"  name='quantity[]' class="qty form-control " id="qty" onkeypress="return isNumber(event, this)"/>
                            <input type="hidden" name='old_quantity[]' value="0"/>
                            <span class="error_msg"></span>
                        </td>
                        <td>
                            <input type="text"   tabindex="-1"  name='per_cost[]' class="cost_price percost form-control" id="price"/>
                            <span class="error_msg"></span>
                        </td>
                        <td style="display:none">
                            <input type="text"   tabindex="-1"   name='tax[]' style="width:70px;" class="pertax" />
                        </td>
                        <td>
                            <input type="text" name='sub_total[]' tabindex="-1" readonly="readonly" id="sub_toatl" class="subtotal form-control text-right" />
                        </td>
                        <td class="action-btn-align"><a id='delete_group' tabindex="-1" class="del btn btn-danger btn-mini"><span class="fa fa-trash"></span></a></td>
                    </tr>
                </table>
                <table class="static_ser" style="display: none;">
                    <tr>
                        <td>
                            <select id='' class='cat_id static_style form-control class_req'  name='categoty[]' tabindex="-1">
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
                            <select name='brand[]'  class="brand form-control" tabindex="-1">
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
                            <input type="text"  name="model_no[]" id="model_no_ser"   tabindex="3" class='form-control auto_customer tabwid model_no_ser' />
                            <span class="error_msg"></span>
                            <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-control product_id' />
                            <input type="hidden"  name="product_type[]" id="type_ser" class=' tabwid form-control type type_ser' />
                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                        </td>
                        <td>
                            <textarea tabindex="-1" name="product_description[]" id="product_description" class='form-control auto_customer tabwid product_description' onkeyup='f2(this);' />  </textarea>
                        </td>
                        <td >
                            <input type="text"  name="add_amount[]" id="add_amount" class='form-control add_amount' tabindex="-1"  />
                        </td>
                        <td>
                            <input type="hidden"  name='available_quantity[]'  value="0" readonly="readonly"/>
                            <input type="text" tabindex="3"  name='quantity[]' class="qty form-control " id="qty" onkeypress="return isNumber(event, this)"/>
                            <input type="hidden" name='old_quantity[]' value="0"/>
                            <span class="error_msg"></span>
                        </td>
                        <td>
                            <input type="text"   tabindex="-1"  name='per_cost[]' class="cost_price percost form-control" id="price"/>
                            <span class="error_msg"></span>
                        </td>
                        <td style="display: none;">
                            <input type="text"   tabindex="-1"   name='tax[]' style="width:70px;" class="pertax" />
                        </td>
                        <td>
                            <input type="text" name='sub_total[]' tabindex="-1" readonly="readonly" id="sub_toatl" class="subtotal text-right form-control" />
                        </td>
                        <td class="action-btn-align"><a id='delete_group' tabindex="-1" class="del btn btn-danger btn-mini"><span class="fa fa-trash"></span></a></td>
                    </tr>
                </table>
                <?php
                if (isset($quotation) && !empty($quotation)) {
                    foreach ($quotation as $val) {
                        ?>
                        <form  action="<?php echo $this->config->item('base_url'); ?>service/" method="post" >
                            <input type="hidden" name="quotation[q_id]" value="  <?php echo $val['id']; ?>  " />
                            <table  class="table table-striped responsive table-bordered dataTable no-footer dtr-inline">
                                <tr>
                                    <td class="text-left">TO,
                                        <div><b><?php echo $val['name']; ?></b></div>
                                        <div><?php echo $val['address1']; ?> </div>
                                        <div> <?php echo $val['mobil_number']; ?></div>
                                        <div> <?php echo $val['email_id']; ?></div>
                                    </td>
                                    <td class="action-btn-align"> <img src="<?= $theme_path; ?>/assets/images/logo-1.png" alt="Chain Logo" width="182px"></td>
                                </tr>
                                <tr>
                                    <td class="text-left"> Invoice NO: <?php echo $val['inv_id'] ?> </td>
                                    <td class="text-left">  Quotation NO:  <?php echo $val['q_no']; ?> </td>
                                </tr>
                                <tr>
                                    <td class="text-left"> Job Id: <?php echo $val['job_id']; ?>
                                        <input type="hidden"  name="quotation[job_id]" class="code form-control colournamedup tabwid form-control" value="<?php echo $val['job_id']; ?>"  id="grn_no">
                                    </td>
                                    <td class="text-left">Date: <?= date('d-M-Y', strtotime($val['created_date'])); ?>  </td>
                                     <!--<td>Customer Name: <?php echo $val['name']; ?> </td>-->
                                </tr>
                                <tr>
                                 <!-- <td class="first_td1">Customer Mobile No:<?php echo $val['mobil_number']; ?> </td>
                                  <td id='customer_td'>Customer Email ID: <?php echo $val['email_id']; ?> </td> -->

                                </tr>
                            </table>

                            <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline m-t-5" id="add_quotation">
                                <thead>
                                    <tr>
                                        <td width="10%" class="first_td1">Category</td>
                                        <td width="10%" class="first_td1">Brand</td>
                                        <td width="10%" class="first_td1">Model Number</td>
                                        <td width="10%" class="first_td1">Product Description</td>
                                        <td width="5%" class="first_td1">Add Amt</td>
                                        <td  width="8%" class="first_td1">QTY</td>
                                        <td  width="2%" class="first_td1">Unit Price</td>
                                        <td  width="2%" class="first_td1" style="display:none">Tax</td>
                                        <td  width="2%" class="first_td1">Net Value</td>
                                        <td width="2%" class="action-btn-align remove_nowrap">
                                            <a id='add_group' class="btn btn-primary btn-mini waves-effect waves-light d-inline-block md-trigger"><span class="fa fa-plus"></span> Add Product</a>
                                            <a id='add_group_service' class="btn btn-primary btn-mini waves-effect waves-light d-inline-block md-trigger m-t-5"><span class="fa fa-plus"></span> Add Service</a>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody id='app_table'>
                                    <?php
                                    if (isset($quotation_details) && !empty($quotation_details)) {
                                        foreach ($quotation_details as $vals) {
                                            ?>

                                            <tr>
                                                <td> <input type="hidden"  name="categoty[]" id="type" class=' tabwid form-control type required'   tabindex="-1" value="<?php echo $vals['cat_id']; ?>"  />
                                                    <select id='' class='cat_id static_style form-control class_req ' name='categoty[]' disabled="true" >
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

                                                <td > <input type="hidden"  name="brand[]" id="type" class=' tabwid form-control type required brand'  tabindex="-1" value="<?php echo $vals['brand']; ?>"  />
                                                    <select name='brand[]' class="form-control" disabled="true">
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
                                                    <input type="text"  name="model_no[]" id="model_no"  tabindex="1" class='form-control auto_customer tabwid <?php echo ($vals['type'] == 'product') ? 'model_no' : 'model_no_ser'; ?> required' value="<?php echo $vals['model_no']; ?>" readonly="readonly"/>
                                                    <span class="error_msg"></span>
                                                    <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-control' value="<?php echo $vals['product_id']; ?>" />
                                                    <input type="hidden"  name="product_type[]" id="type" class=' tabwid form-control type' value="<?php echo $vals['type']; ?>"  />
                                                    <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                                                </td>
                                                <td>
                                                    <textarea tabindex="-1" name="product_description[]" id="product_description"    class='form-control auto_customer tabwid product_description ' readonly="readonly" onkeyup='f2(this);'><?php echo $vals['product_description']; ?></textarea>
                                                </td>
                                                <td >
                                                    <input type="text"  name="add_amount[]" id="add_amount" value="<?php echo $vals['add_amount'] ?>" class='form-control add_amount' tabindex="-1"  />
                                                </td>
                                                <?php
                                                if ($vals['type'] == 'product') {
                                                    if (isset($vals['stock']) && !empty($vals['stock'])) {
                                                        ?>
                                                        <td>
                                                            <input type="text"   tabindex="-1"  name='available_quantity[]' class="code form-control colournamedup tabwid form-align stock_qty" value="<?php echo $vals['stock'][0]['quantity'] ?>" readonly="readonly"/>
                                                            <input type="text"   tabindex="2"  name='quantity[]' class="qty form-control required" value="<?php echo $vals['quantity'] ?>" onkeypress="return isNumber(event, this)"/>
                                                            <span class="error_msg"></span>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td><div class="avl_qty"></div>
                                                            <input type="text"   tabindex="-1"  name='available_quantity[]' class="code form-control colournamedup tabwid form-align stock_qty" value="0" readonly="readonly"/>
                                                           <!--<input type="hidden"  class="stock_qty" value="<?php echo $vals['stock'][0]['quantity'] ?>" />-->
                                                            <input type="text"   tabindex="2"  name='quantity[]' class="qty required form-control" value="<?php echo $vals['quantity'] ?>" onkeypress="return isNumber(event, this)"/>
                                                            <span class="error_msg"></span>
                                                        </td>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                        <input type="hidden" name='old_quantity[]' value="<?php echo ($vals['quantity'] != '') ? $vals['quantity'] : '0' ?>"/>
                                        <?php if ($vals['type'] == 'service') {
                                            ?>
                                            <td>
                                                <input type="hidden" name='available_quantity[]' class="form-control" value="0" />
                                                <input type="text"   tabindex="2"  name='quantity[]' class="qty form-control" value="<?php echo $vals['quantity'] ?>" onkeypress="return isNumber(event, this)"/>
                                                <span class="error_msg"></span>
                                            </td>
                                        <?php } ?>
                                        <td>
                                            <input type="text"   tabindex="-1"  name='per_cost[]' class="cost_price percost required form-control" value="<?php echo $vals['per_cost']; ?>" readonly="readonly"/>
                                            <span class="error_msg"></span>
                                        </td>
                                        <td style="display:none">
                                            <input type="text"   tabindex="-1"   name='tax[]' style="width:70px;" class="pertax " value="<?php echo $vals['tax'] ?>"readonly="readonly" />
                                        </td>
                                        <td>
                                            <input type="text" tabindex="-1" name='sub_total[]' readonly="readonly" class="subtotal form-control text-right" value="<?php echovals['sub_total']; ?>"/>
                                        </td>
                                        <td></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                                <tbody>
                                <td colspan="5" style=" text-align:right;">Total</td>
                                <td><input type="text" tabindex="-1"  name="quotation[total_qty]"  readonly="readonly" value="<?php echo $val['total_qty']; ?>" class="total_qty form-control" id="total" /></td>
                                <td class=" totbold" style="text-align:right;">Sub Total</td>
                                <td><input type="text" name="quotation[subtotal_qty]"tabindex="-1"  readonly="readonly" value="<?php echo $val['subtotal_qty']; ?>"  class="final_sub_total form-control text-right" /></td>
                                <td></td>
                                </tbody>

                                <tbody class="add_cost">
                                <td colspan="2" style=" text-align:right;"></td>
                                <td colspan="5" style="text-align:right;font-weight:bold;"><input type="text"  name="quotation[tax_label]" class='tax_label form-control text-right '  tabindex="-1" style="width:100%;" value="<?php echo $val['tax_label']; ?>"/></td>
                                <td>
                                    <input type="text"  name="quotation[tax]" class='totaltax form-control text-right '  readonly="readonly" value="<?php echo $val['tax']; ?>"   tabindex="-1"  />
                                </td>
                                <td width="2%" class="action-btn-align"><a id='add_label' class="btn btn-primary btn-mini waves-effect waves-light d-inline-block md-trigger form-control"><span class="fa fa-plus"></span> Add </a></td>
                                <?php foreach ($val["other_cost"] as $key => $val) {
                                    ?>
                                    <tr>
                                        <td colspan="2" style=" text-align:right;"></td>
                                        <td colspan="5" style="text-align:right;font-weight:bold;"><input type="text" name="item_name[]" tabindex="-1" class="tax_label form-control text-right" style="width:100%;" value="<?php echo $val['item_name']; ?>" ></td>
                                        <td>
                                            <input type="text" name="amount[]" value="<?php echo number_format($val['amount'], 2); ?>" class="totaltax form-control text-right"  tabindex="-1" >
                                            <input type="hidden" name="type[]" class="text-right form-control"  value="project_cost" >
                                        </td>
                                        <td width="2%" class="action-btn-align"><a id='delete_label' class="del btn btn-danger btn-mini"><span class="fa fa-trash"></span></a></td>
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
                                        <td><input type="text" tabindex="-1" name="quotation[net_total]"  readonly="readonly"  class="final_amt form-control text-right" value="<?php
                                            echo $val['net_total'];
                                            ?>" /></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td colspan="10" style="">
                                            <span class="remark">Remarks&nbsp;&nbsp;&nbsp;</span>
                                            <input name="quotation[remarks]" type="text"   tabindex="4" class="form-control remark" value="<?php echo $val['remarks']; ?>" />
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <input type="hidden"  name="quotation[customer]" id="c_id" class='id_customer'  value="<?php echo $val['customer']; ?>"/>
                            <div class="form-group row m-10">
                                <div class="col-md-12 text-center">
                                    <button  id="save" class="btn btn-primary btn-sm waves-effect waves-light" tabindex="5">Update</button>
                                    <a href="<?php echo $this->config->item('base_url') . 'service/service_list' ?>" class="btn btn-inverse btn-sm waves-effect waves-light"  tabindex="6"> Back </a>
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

    $('#save').live('click', function () {
        m = 0;
        $('.qty').each(function () {
            var stock_qty = $(this).closest('tr').find('.stock_qty').val();
            this_val = $.trim($(this).val());
            if (this_val != "") {
                if (Number(this_val) > Number(stock_qty))
                {
                    $(this).closest('td').find('.error_msg').text('Invalid quantity').css('display', 'inline-block');
                    m = 1;
                } else {
                    $(this).closest('td').find('.error_msg').text("");
                }
            }
        });
        $('.stock_qty').each(function () {
//            this_val = $.trim($(this).val());
//            this_id = $(this).attr("id");
//            if (this_val == "") {
//                $(this).closest('td').find('.error_msg').text('Stock is not available').css('display', 'inline-block');
//                m++;
//            } else {
//                $(this).closest('td').find('.error_msg').text('');
//            }
            var qty = $(this).closest('tr').find('.qty').val();
            this_val = $.trim($(this).val());
            if (Number(this_val) < Number(qty))
            {
                $(this).closest('td').find('.error_msg').text('Invalid quantity').css('display', 'inline-block');
                m++;
            } else {
                $(this).closest('td').find('.error_msg').text("");
            }
        });
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
                $(this).closest('td').find('.error_msg').text('This field is required').css('display', 'inline-block');
                m++;
            } else {
                $(this).closest('td').find('.error_msg').text('');
            }
        });
        if (m > 0)
            return false;

    });
//
//
//    $(document).ready(function () {
//// var $elem = $('#scroll');
////  window.csb = $elem.customScrollBar();
//        $("#customer_name").keyup(function () {
//            $.ajax({
//                type: "GET",
//                url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_customer",
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
//
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
        var tables = $(".static1").find('tr').clone();
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
//            var pertax = $(this).closest('tr').find('.pertax');
            var subtotal = $(this).closest('tr').find('.subtotal');

            if (Number(qty.val()) != 0)
            {
//                pertax1 = Number(pertax.val() / 100) * Number(percost.val());
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
    $('.qty').live('keyup', function () {
        var pro_qty = $(this).val();
        var stock_qty = $(this).closest('tr').find('.stock_qty').val();
        if (Number(pro_qty) > Number(stock_qty))
        {
            $(this).closest('td').find('.error_msg').text('Invalid quantity').css('display', 'inline-block');
        } else {
            $(this).closest('td').find('.error_msg').text("");
        }
    });

</script>

<script>

    $('body').live('keydown', 'input.model_no1', function (e) {
        var product_data = {};
        product_data.results = [<?php echo implode(',', $model_numbers_json); ?>];
        // cust_id = $('#customer_id').val();

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
        $('.model_no').autocomplete({
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
            //source: products.results,
            minLength: 0,
            autoFill: false,
            select: function (event, ui) {
                this_val = $(this);
                product = ui.item.value;
                $(this).val(product);
                model_number_id = ui.item.id;
                $.ajax({
                    type: 'POST',
                    data: {model_number_id: model_number_id},
                    url: "<?php echo $this->config->item('base_url'); ?>" + "service/get_product/",
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
                            this_val.closest('tr').find('.cost_price').val(result[0].cost_price);
                            this_val.closest('tr').find('.add_amount').val(result[0].add_amount);
                            this_val.closest('tr').find('.type').val(result[0].type);
                            this_val.closest('tr').find('.product_id').val(result[0].id);
                            this_val.closest('tr').find('.model_no').val(result[0].model_no);
                            //  this_val.closest('tr').find('.model_no_extra').val(result[0].model_no);
                            this_val.closest('tr').find('.product_description').val(result[0].product_name + "\n" + result[0].product_description);
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


    $('body').live('keydown', 'input.model_no_ser', function (e) {
        var product_data = [<?php echo implode(',', $model_numbers_json1); ?>];

        //cust_id = $('#customer_id').val();
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
            //source: product_data,
            minLength: 0,
            autoFill: false,
            select: function (event, ui) {
                this_val = $(this);
                product = ui.item.value;
                $(this).val(product);
                model_number_id = ui.item.id;
                $.ajax({
                    type: 'POST',
                    data: {model_number_id: model_number_id},
                    url: "<?php echo $this->config->item('base_url'); ?>" + "service/get_service/",
                    success: function (data) {

                        result = JSON.parse(data);
                        if (result != null && result.length > 0) {
                            this_val.closest('tr').find('.brand').val(result[0].brand_id);
                            this_val.closest('tr').find('.cat_id').val(result[0].category_id);
                            this_val.closest('tr').find('.pertax').val(result[0].cgst);
                            this_val.closest('tr').find('.gst').val(result[0].sgst);
                            this_val.closest('tr').find('.discount').val(result[0].discount);
                            this_val.closest('tr').find('.cost_price').val(parseInt(result[0].cost_price) + parseInt(result[0].add_amount));
                            this_val.closest('tr').find('.type_ser').val(result[0].type);
                            this_val.closest('tr').find('.add_amount').val(result[0].add_amount);
                            this_val.closest('tr').find('.product_id').val(result[0].id);
                            // this_val.closest('tr').find('.model_no').val(result[0].product_name);
                            this_val.closest('tr').find('.model_no_ser').val(result[0].model_no);
                            this_val.closest('tr').find('.product_description').val(result[0].product_name + "\n" + result[0].product_description);
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
        $(this).closest('tr').find('.product_description').val($(this).attr('pro_name') + "\n" + $(this).attr('pro_description'));
        $(this).closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + $(this).attr('pro_image'));
        $(this).closest('tr').find(".suggesstion-box1").hide();
        calculate_function();
    });

    $('.ser_class').live('click', function () {
        $(this).closest('tr').find('.brand').val($(this).attr('ser_brand'));
        $(this).closest('tr').find('.cat_id').val($(this).attr('ser_cat'));
        $(this).closest('tr').find('.cost_price').val($(this).attr('ser_sell'));
        $(this).closest('tr').find('.type_ser').val($(this).attr('ser_type'));
        $(this).closest('tr').find('.product_id').val($(this).attr('ser_id'));
        $(this).closest('tr').find('.model_no_ser').val($(this).attr('ser_no'));
        $(this).closest('tr').find('.product_description').val($(this).attr('ser_name') + "\n" + $(this).attr('ser_description'));
        $(this).closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + $(this).attr('ser_image'));
        $(this).closest('tr').find(".suggesstion-box1").hide();
        calculate_function();
    });
    $(document).ready(function () {

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
