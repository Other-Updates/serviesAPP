<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    #add_group, #add_group_service {
        color: #fff;
    }
    #delete_group, #delete_label, #add_label {
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
        $model_numbers_json[] = '{ label: "' . $list['model_no'] . '", value: "' . $list['id'] . '"}';
    }
}

$model_numbers_json1 = array();
if (!empty($products1)) {
    foreach ($products1 as $list) {
        $model_numbers_json1[] = '{ label: "' . $list['model_no'] . '", value: "' . $list['id'] . '"}';
    }
}
?>
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
                        <td colspan="4" style="text-align:right;font-weight:bold;"><input type="text" name="item_name[]" tabindex="1" class="tax_label form-control text-right" ></td>
                        <td>
                            <input type="text" name="amount[]" class="totaltax form-control text-right"  tabindex="1" >
                            <input type="hidden" name="type[]" class="text-right"  value="project_cost" >
                        </td>
                        <td width="2%" class="action-btn-align"><a id='delete_label' class="del btn btn-danger btn-mini"><span class="fa fa-trash"></span></a></td>
                    </tr>
                </table>
                <table class="static" style="display: none;">
                    <tr>
                        <td>
                            <select id='' class='cat_id static_style form-control class_req required' name='categoty[]' >
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
                            <select name='brand[]' class='brand_id form-control required brand' >
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
                            <input type="text"  name="model_no[]" id="model_no" class='form-control auto_customer tabwid model_no' tabindex="1"/>
                            <span class="error_msg"></span>
                            <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-control product_id' />
                            <input type="hidden"  name="product_type[]" id="type" class=' tabwid form-control type' />
                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                        </td>
                        <td>
                            <textarea  name="product_description[]" id="product_description"  class='form-control auto_customer tabwid4 product_description' onkeyup='f2(this);'/>  </textarea>
                        </td>
                        <td>
                            <input type="text"   tabindex="1"  name='quantity[]' class="qty form-control" id="qty"/>
                            <span class="error_msg"></span>
                        </td>

                        <td><div class="avl_qty">
                                <input type="text"   tabindex="1"  name='per_cost[]' class="cost_price percost form-control" id="price"/>
                                <span class="error_msg"></span></div>
                        </td>

                        <td style="display:none">
                            <input type="text"   tabindex="1"   name='tax[]' class="pertax form-control" />
                        </td>
                        <td>
                            <input type="text"  name='sub_total[]' readonly="readonly" id="sub_toatl" class="subtotal form-control text-right" />
                        </td>
                        <td class="action-btn-align"><a id='delete_group' class="del btn btn-danger btn-mini"><span class="fa fa-trash"></span></a></td>
                    </tr>
                </table>
                <table class="static_ser" style="display: none;">
                    <tr>
                        <td>
                            <select id='' class='cat_id form-control static_style class_req' name='categoty[]' >
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
                            <select name='brand[]' class='brand_id form-control brand'>
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
                            <input type="text"  name="model_no[]" id="model_no_ser" class='form-control auto_customer tabwid model_no_ser' tabindex="1"/>
                            <span class="error_msg"></span>
                            <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-control product_id' />
                            <input type="hidden"  name="product_type[]" id="type_ser" class=' tabwid form-control type type_ser' />
                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                        </td>
                        <td>
                            <textarea  name="product_description[]"  id="product_description" class='form-control auto_customer tabwid4 product_description' onkeyup='f2(this);'/>  </textarea>
                        </td>
                        <td>
                            <input type="text"   tabindex="1"  name='quantity[]' class="qty form-control" id="qty"/>
                            <span class="error_msg"></span>
                        </td>
                        <td><div class="avl_qty">
                                <input type="text"   tabindex="1"  name='per_cost[]' class="cost_price form-control percost " id="price"/>
                                <span class="error_msg"></span></div>
                        </td>
                        <td style="display:none">
                            <input type="text"   tabindex="1"   name='tax[]' class="pertax form-control" />
                        </td>
                        <td>
                            <input type="text" name='sub_total[]' readonly="readonly" id="sub_toatl" class="subtotal form-control text-right" />
                        </td>
                        <td class="action-btn-align"><a id='delete_group' class="del btn btn-danger btn-mini"><span class="fa fa-trash"></span></a></td>
                    </tr>
                </table>
                <?php
                if (isset($quotation) && !empty($quotation)) {
                    foreach ($quotation as $val) {
                        ?>
                        <form  action="<?php echo $this->config->item('base_url'); ?>project_cost/" method="post">
                            <input type="hidden" name="quotation[q_id]" value="<?php echo trim($val['id']); ?>" />
                            <table  class="table table-striped responsive table-bordered dataTable no-footer dtr-inline">

                                <tr>
                                    <td class="text-left"><span  class="f-w-700">TO,</span>
                                        <div><?php echo $val['address1']; ?></div>
                                    </td>
                                    <td class="action-btn-align"> <img src="<?= $theme_path; ?>/assets/images/logo-1.png" alt="Chain Logo" width="125px" ></td>
                                </tr>
                                <tr>
                                    <td class="text-left"><span  class="f-w-700"> Contact Person:</span> <?php echo $val['name'] ?> </td>
                                    <td class="text-left"> <span  class="f-w-700"> Quotation NO:</span>  <?php echo $val['q_no']; ?> </td>
                                </tr>
                                <tr>
                                    <td class="text-left"><span  class="f-w-700"> Job Id:</span><?php echo $val['job_id']; ?>
                                        <input type="hidden"  name="quotation[job_id]" class="code form-control colournamedup tabwid form-align" value="<?php echo $val['job_id']; ?> "  id="grn_no">
                                    </td>
                                    <td class="text-left"><span  class="text-left">Company Name:</span> <?php echo $val['store_name']; ?> </td>
                                </tr>
                                <tr>
                                    <td class="text-left"><span  class="f-w-700">Customer Mobile No:</span><?php echo $val['mobil_number']; ?> </td>
                                    <td class="text-left" id='customer_td'><span  class="f-w-700">Customer Email ID:</span> <?php echo $val['email_id']; ?> </td>
                                </tr>
                                <tr>
                                    <td class="text-left"><span  class="f-w-700">GSTIN No:</span> <?= $company_details[0]['tin_no'] ?>  </td>
                                    <td class="text-left"><span  class="f-w-700"> Date:</span>
                                        <input type="date" tabindex="1"  class="form-control tabwid" name="quotation[created_date]" value="<?= date('d-m-Y', strtotime($val['created_date'])); ?>" style="width:200px; display: inline"/>
                                    </td>
                                </tr>
                            </table>
                            <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline m-t-5" id="add_quotation">
                                <thead>
                                    <tr>
                                        <td width="10%" class="first_td1">Category</td>
                                        <td width="10%" class="first_td1">Brand</td>
                                        <td width="10%" class="first_td1">Model Number</td>
                                        <td width="10%" class="first_td1">Product Description</td>
                                        <td  width="8%" class="first_td1">QTY</td>
                                        <td  width="2%" class="first_td1">Cost/QTY</td>
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
                                                <td>
                                                    <select id='' class='cat_id static_style form-control class_req required' name='categoty[]'>
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
                                                    <select name='brand[]' class="brand_id form-control required brand">
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
                                                    <input type="text"  name="model_no[]" id="model_no" tabindex="1" class='form-control auto_customer tabwid <?php echo ($vals['type'] == 'product') ? 'model_no' : 'model_no_ser'; ?> required' value="<?php echo $vals['model_no']; ?>"/>
                                                    <span class="error_msg"></span>
                                                    <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-control' value="<?php echo $vals['product_id']; ?>" />
                                                    <input type="hidden"  name="product_type[]" id="type" class=' tabwid form-control type'value="<?php echo $vals['type']; ?>"  />
                                                    <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                                                </td>
                                                <td>
                                                    <textarea  name="product_description[]"  id="product_description" class='form-control auto_customer tabwid4 product_description' onkeyup='f2(this);'/><?php echo $vals['product_description']; ?></textarea>
                                                </td>
                                                <td>
                                                    <input type="text"   tabindex="1"  name='quantity[]' class="qty form-control required" value="<?php echo $vals['quantity'] ?>"/>
                                                    <span class="error_msg"></span>
                                                </td>
                                                <td><div class="avl_qty">
                                                    <input type="text"   tabindex="1"  name='per_cost[]'  class="cost_price form-control percost required" value="<?php echo $vals['per_cost'] ?>" /><!--value="<?php echo $vals['po'][0]['per_cost'] ?>"-->
                                                        <span class="error_msg"></span></div>
                                                </td>
                                                <td style="display:none">
                                                    <input type="text"   tabindex="1"   name='tax[]' class="pertax form-control" value="<?php echo $vals['tax'] ?>" />
                                                </td>
                                                <td>
                                                    <input type="text"   name='sub_total[]' readonly="readonly" class="subtotal form-control text-right" value="<?php echo $vals['sub_total'] ?>"/>
                                                </td>
                                        <input type="hidden" value = "<?php echo $vals['p_id']; ?>" class="del_id"/>
                                        <td width="2%" class="action-btn-align"><a id='delete_label' value = "<?php echo $vals['p_id']; ?>" class="del btn btn-danger btn-mini"><span class="fa fa-trash"></span></a></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                                </tbody>
                                <tbody>
                                <td colspan="4" style="text-align:right;">Total</td>
                                <td><input type="text"   name="quotation[total_qty]"   readonly="readonly" value="<?php echo $val['total_qty']; ?>" class="total_qty form-control"  id="total" /></td>
                                <td style="text-align:right;">Sub Total</td>
                                <td><input type="text" name="quotation[subtotal_qty]"  readonly="readonly" value="<?php echo $val['subtotal_qty']; ?>"  class="final_sub_total form-control text-right"  /></td>
                                <td></td>
                                </tbody>
                                <tbody class="add_cost">
                                <td colspan="2" style=" text-align:right;"></td>
                                <td colspan="4" style="text-align:right;font-weight:bold;"><input type="text"  tabindex="1" name="quotation[tax_label]" class='tax_label form-control text-right' value="<?php echo $val['tax_label']; ?>"/></td>
                                <td>
                                    <input type="text"  name="quotation[tax]" tabindex="1" class='totaltax form-control text-right'  value="<?php echo $val['tax']; ?>"   />
                                </td>
                                <td width="2%" class="action-btn-align"><a id='add_label' class="btn btn-primary form-control btn-mini"><span class="fa fa-plus"></span> Add </a></td>
                                </tbody>
                                <tfoot>

                                    <tr>
                                        <td colspan="2" style=" text-align:right;"></td>
                                        <td colspan="4"style="text-align:right;font-weight:bold;">Net Total</td>
                                        <td><input type="text"  name="quotation[net_total]"  readonly="readonly" class="final_amt form-control text-right"  value="<?php echo $val['net_total']; ?>" /></td>
                                        <td></td>
                                    </tr>
                                    <tr>

                                        <td colspan="9" style="">
                                            <span class="remark">Remarks&nbsp;&nbsp;&nbsp;</span>
                                            <input name="quotation[remarks]" type="text" class="form-control remark" value="<?php echo $val['remarks']; ?>" tabindex="1" />
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <input type="hidden"  name="quotation[customer]" id="c_id" class='id_customer'  value="<?php echo $val['customer']; ?>"/>
                            <div class="form-group row m-10">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-info btn-sm waves-effect waves-light " id="save" tabindex="1"> Create </button>
                                    <a href="<?php echo $this->config->item('base_url') . 'project_cost/project_cost_list/' ?>" class="btn btn-inverse btn-sm waves-effect waves-light"> Back </a>
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
        $('#add_quotation .required').each(function () {
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
            var pertax = $(this).closest('tr').find('.pertax');
            var subtotal = $(this).closest('tr').find('.subtotal');

            if (Number(qty.val()) != 0)
            {
                pertax1 = Number(pertax.val() / 100) * Number(percost.val());
                sub_total = (Number(qty.val()) * Number(percost.val())) + (pertax1 * Number(qty.val()));
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
            cat_id = $('#firm').val();
            cust_id = $('#customer_id').val();
            $(".model_no").autocomplete({
                source: product_data,
                minLength: 0,
                autoFill: false,
                select: function (event, ui) {
                    this_val = $(this);
                    product = ui.item.label;
                    $(this).val(product);
                    model_number_id = ui.item.value;
                    $.ajax({
                        type: 'POST',
                        data: {model_number_id: model_number_id, c_id: cust_id},
                        url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_product/",
                        success: function (data) {
                            result = JSON.parse(data);
                            if (result != null && result.length > 0) {
                                this_val.closest('tr').find('.brand').val(result[0].brand_id);
                                this_val.closest('tr').find('.cat_id').val(result[0].category_id);
                                this_val.closest('tr').find('.pertax').val(result[0].cgst);
                                this_val.closest('tr').find('.gst').val(result[0].sgst);
                                this_val.closest('tr').find('.discount').val(result[0].discount);
                                this_val.closest('tr').find('.cost_price').val(result[0].cost_price);
                                this_val.closest('tr').find('.type').val(result[0].type);
                                this_val.closest('tr').find('.product_id').val(result[0].id);
                                this_val.closest('tr').find('.model_no').val(result[0].model_no);
                                // this_val.closest('tr').find('.model_no_extra').val(result[0].model_no);
                                this_val.closest('tr').find('.product_description').val(result[0].product_description);
                                this_val.closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + result[0].product_image);
                                calculate_function();

                            }
                        }
                    });
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
                source: product_data,
                minLength: 0,
                autoFill: false,
                select: function (event, ui) {
                    this_val = $(this);
                    product = ui.item.label;
                    $(this).val(product);
                    model_number_id = ui.item.value;
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
                                this_val.closest('tr').find('.cost_price').val(result[0].cost_price);
                                this_val.closest('tr').find('.type').val(result[0].type);
                                this_val.closest('tr').find('.product_id').val(result[0].id);
                                this_val.closest('tr').find('.model_no_ser').val(result[0].model_no);
                                //  this_val.closest('tr').find('.model_no_extra').val(result[0].model_no);
                                this_val.closest('tr').find('.product_description').val(result[0].product_description);
                                this_val.closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + result[0].product_image);
                                calculate_function();

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
//
//    $(document).ready(function () {
//        $('body').click(function () {
//            $(this).closest('tr').find(".suggesstion-box1").hide();
//        });
//
//    });
//    $(document).ready(function () {
//
//        calculate_function();
//    });
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

    function f2(textarea)
    {
        string = textarea.value;
        string = string.toUpperCase();
        textarea.value = string;
    }
</script>


