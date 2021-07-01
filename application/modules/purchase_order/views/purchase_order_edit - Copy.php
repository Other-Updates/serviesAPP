<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style type="text/css">
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
        float: left;
    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5>Update Purchase Order</h5>
            </div>
            <div class="card-block">
                <table class="static" style="display: none;">
                    <tr>
                        <td>
                            <select id='' class='cat_id static_style class_req form-control' name='categoty[]'>
                                <option>Select</option>
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
                            <select name='brand[]' class="form-control">
                                <option>Select</option>
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
                            <input type="text"  name="model_no[]" id="model_no" class='form-control auto_customer tabwid model_no' />
                            <span class="error_msg"></span>
                            <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-control product_id' />
                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                        </td>
                        <td>
                            <textarea  name="product_description[]" id="product_description" class='form-control auto_customer tabwid product_description' />  </textarea>
                        </td>
                        <td>
                            <input type="text"   tabindex="-1"  name='quantity[]' class="qty form-control " id="qty"/>
                            <span class="error_msg"></span>
                        </td>
                        <td>
                            <input type="text"   tabindex="-1"  name='per_cost[]' class="percost form-control" id="price"/>
                            <span class="error_msg"></span>
                        </td>
                        <td>
                            <input type="text"   tabindex="-1"   name='tax[]'  class="pertax form-control" />
                        </td>
                        <td>
                            <input type="text"   tabindex="-1"  name='sub_total[]' readonly="readonly" id="sub_toatl" class="subtotal text-right form-control" />
                        </td>
                        <td class="text-center"><a id='delete_group' class="del btn btn-danger btn-mini"><span class="fa fa-trash"></span></a></td>
                    </tr>
                </table>
                <?php
                if (isset($po) && !empty($po)) {
                    foreach ($po as $val) {
                        ?>
                        <form  action="<?php echo $this->config->item('base_url'); ?>purchase_order/update_po/<?php echo $val['id']; ?>" method="post">
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label">PO NO</label>
                                    <input type="text"  tabindex="-1" name="po[po_no]" class=" form-control colournamedup " readonly="readonly" value="<?php echo $val['po_no']; ?>"  id="grn_no">
                                </div>
                                <div class="col-md-3">
                                    <label class="col-form-label">Supplier Name</label>
                                    <input type="text"  name="supplier[name]" id="customer_name" class='  form-control auto_customer required ' value="<?php echo $val['name']; ?>"  />
                                    <span class="error_msg"></span>
                                    <input type="hidden"  name="supplier[id]" id="customer_id" class=' form-control  id_customer tabwid' value="<?php echo $val['id']; ?>" />
                                    <div id="suggesstion-box" class="auto-asset-search"></div>
                                </div>
                                <div class="col-md-3">
                                    <label class="col-form-label">Supplier Mobile No</label>
                                    <input type="text"  name="supplier[mobil_number]" class="form-control required " id="customer_no" value="<?php echo $val['mobil_number']; ?>"/>
                                    <span class="error_msg"></span>
                                </div>
                                <div class="col-md-3">
                                    <label class="col-form-label">Supplier Email ID</label>
                                    <input type="text"  name="supplier[email_id]" class=" form-control required " id="email_id" value="<?php echo $val['email_id']; ?>"/>
                                    <span class="error_msg"></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <label class="col-form-label">Supplier Address</label>
                                    <textarea name="supplier[address1]" class=" form-control required" id="address1"><?php echo $val['address1']; ?></textarea>
                                    <span class="error_msg"></span>
                                </div>
                                <div class="col-md-3">
                                    <label class="col-form-label">GSTIN No</label>
                                    <input type="text" name="company[tin_no]" class="form-control " value="<?= $company_details[0]['tin_no'] ?>" />
                                </div>
                            </div>
                            <div class="row card-block table-border-style">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">
                                        <thead>
                                            <tr>
                                                <td width="10%" class="first_td1">Category</td>
                                                <td width="10%" class="first_td1">Brand</td>
                                                <td width="10%" class="first_td1">Model Number</td>
                                                <td width="10%" class="first_td1">Product Description</td>
                                                <td  width="8%" class="first_td1">QTY</td>
                                                <td  width="2%" class="first_td1">Cost/QTY</td>
                                                <td  width="2%" class="first_td1">Tax</td>
                                                <td  width="2%" class="first_td1">Net Value</td>
                                                <td width="2%" class="action-btn-align"><a id='add_group' class="btn btn-primary btn-mini waves-effect waves-light d-inline-block md-trigger"><span class="fa fa-plus"></span> Add Row</a>
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody id='app_table'>
                                            <?php
                                            if (isset($po_details) && !empty($po_details)) {
                                                foreach ($po_details as $vals) {
                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <select id='' class='cat_id static_style class_req required form-control' name='categoty[]'>
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
                                                            <span class="error_msg" ></span>
                                                        </td>

                                                        <td >
                                                            <select name='brand[]' class="required form-control">
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
                                                            <input type="text"  name="model_no[]" id="model_no" class='form-control auto_customer tabwid model_no required' value="<?php echo $vals['model_no']; ?>"/>
                                                            <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-control' value="<?php echo $vals['product_id']; ?>" />
                                                            <span class="error_msg"></span>
                                                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                                                        </td>
                                                        <td>
                                                            <textarea  name="product_description[]" id="product_description" class='form-control auto_customer tabwid product_description' />  <?php echo $vals['product_description']; ?></textarea>
                                                        </td>
                                                        <td>
                                                            <input type="text"   tabindex="-1"  name='quantity[]' class="qty required form-control" value="<?php echo $vals['quantity'] ?>"/>
                                                            <span class="error_msg"></span>
                                                        </td>
                                                        <td>
                                                            <input type="text"   tabindex="-1"  name='per_cost[]'  class="percost required form-control" value="<?php echo $vals['per_cost'] ?>"/>
                                                            <span class="error_msg"></span>
                                                        </td>
                                                        <td>
                                                            <input type="text"   tabindex="-1"   name='tax[]' class="pertax form-control" value="<?php echo $vals['tax'] ?>" />

                                                        </td>
                                                        <td>
                                                            <input type="text"   tabindex="-1"  name='sub_total[]' readonly="readonly" class="subtotal form-control text-right" value="<?php echo $vals['sub_total'] ?>"/>
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
                                                <td colspan="4" style=" text-align:right;">Total</td>
                                                <td><input type="text"   name="po[total_qty]"  tabindex="-1" readonly="readonly" value="<?php echo $val['total_qty']; ?>" class="total_qty form-control" id="total" /></td>
                                                <td colspan="2" style="text-align:right;">Sub Total</td>
                                                <td><input type="text" name="po[subtotal_qty]"  tabindex="-1" readonly="readonly" value="<?php echo $val['subtotal_qty']; ?>"  class="final_sub_total form-control text-right"  /></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style=" text-align:right;"></td>
                                                <td colspan="4" style="text-align:right;font-weight:bold;"><input type="text"  name="po[tax_label]" class='tax_label form-control text-right' style=" float: right" value="<?php echo $val['tax_label']; ?>"/></td>
                                                <td>
                                                    <input type="text"  name="po[tax]" class='totaltax form-control text-right'  value="<?php echo $val['tax']; ?>"  />
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" style=" text-align:right;"></td>
                                                <td colspan="4"style="text-align:right;font-weight:bold;">Net Total</td>
                                                <td><input type="text"  name="po[net_total]"  readonly="readonly"  tabindex="-1" class="final_amt form-control text-right" value="<?php echo $val['net_total']; ?>" /></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 ">
                                    <h4 class="sub-title">TERMS AND CONDITIONS</h4>
                                    <div class="form-group row">
                                        <div class="col-md-3">
                                            <label class="col-form-label">Remarks</label>
                                            <input name="po[remarks]" type="text" class="form-control remark" value="<?php echo $val['remarks']; ?>" />
                                        </div>
                                        <div class="col-md-3">
                                            <label class="col-form-label">Mode of Payment</label>
                                            <input type="text" class="form-control class_req borderra0 terms" value="<?php echo $val['mode_of_payment']; ?>" name="po[mode_of_payment]"/>
                                        </div>
                                        <input type="hidden"  name="po[supplier]" id="customer_id" class='id_customer' value="<?php echo $val['id']; ?>"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row m-10">
                                <div class="col-md-12 text-center">
                                    <button class="btn btn-primary btn-sm waves-effect waves-light " id="save"> Update </button>
                                    <a href="<?php echo $this->config->item('base_url') . 'purchase_order/purchase_order_list/' ?>" class="btn btn-inverse btn-sm waves-effect waves-light"  > Back </a>
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
        $('.required').each(function () {
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
        $('.final_amt').val((final_sub_total + Number($('.totaltax').val())).toFixed(2));
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

</script>
