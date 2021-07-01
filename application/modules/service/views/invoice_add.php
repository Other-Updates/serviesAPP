<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<style type="text/css">
    .text_right
    {
        text-align:right;
    }
    .box, .box-body, .content { padding:0; margin:0;border-radius: 0;}
    #top_heading_fix h3 {top: -57px;left: 6px;}
    #TB_overlay { z-index:20000 !important; }
    #TB_window { z-index:25000 !important; }
    .dialog_black{ z-index:30000 !important; }
    #boxscroll22 {max-height: 291px;overflow: auto;cursor: inherit !important;}
    .auto-asset-search ul#country-list li:hover {
        background: #c3c3c3;
        cursor: pointer;
    }
    .auto-asset-search ul#product-list li:hover {
        background: #c3c3c3;
        cursor: pointer;
    }
    .auto-asset-search ul#country-list li {
        background: #dadada;
        margin: 0;
        padding: 5px;
        border-bottom: 1px solid #f3f3f3;
    }
    .auto-asset-search ul#product-list li {
        background: #dadada;
        margin: 0;
        padding: 5px;
        border-bottom: 1px solid #f3f3f3;
    }
    ul li {
        list-style-type: none;
    }
    .product_description::first-line{
        font-weight: bold;

    }
</style>
<div class="mainpanel">
    <!--<div class="pageheader">
        <div class="media">
        <div class="pageicon pull-left">
                <i class="fa fa-quote-right pageheader_icon iconquo"></i>
            </div>
            <div class="media-body">
                <ul class="breadcrumb">
                    <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                    <li>Home</li>
                    <li>Update</li>
                </ul>
                <h4>Update Quotation</h4>
           </div>
        </div>
    </div>-->
    <div id='empty_data'></div>
    <div class="contentpanel mb-25">
        <div class="media">
            <h4>Add Invoice</h4>
        </div><table class="static1" style="display: none;">
            <tr>
                <td colspan="3" style="width:70px; text-align:right;"></td>
                <td colspan="5" style="text-align:right;font-weight:bold;"><input type="text" name="item_name[]" class="tax_label text_right" style="width:70px;" ></td>
                <td>
                    <input type="text" name="amount[]" class="totaltax text_right"  style="width:70px;" >
                    <input type="hidden" name="type[]" class="text_right"  value="invoice" style="width:70px;" >
                </td>
                <td width="2%" class="action-btn-align"><a id='delete_label' class="del"><span class="glyphicon glyphicon-trash"></span></a></td>
            </tr>
        </table>
        <table class="static" style="display: none;">
            <tr>
                <td>
                    <select id='' class='cat_id static_style class_req' name='categoty[]'>
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
                </td>
                <td>
                    <select name='brand[]' class="brand">
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
                </td>
                <td >
                    <input type="text"  name="model_no[]" id="model_no" class='form-align auto_customer tabwid model_no' />
                    <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-align product_id' />
                    <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                </td>
                <td>
                    <textarea  name="product_description[]" id="product_description" class='form-align auto_customer tabwid product_description' onkeyup='f2(this);'/></textarea>
                </td>
                <td>
                    <img id="blah" name="product_image[]" class="add_staff_thumbnail product_image" width="50px" height="50px" src="<?= $this->config->item("base_url") . 'attachement/product/no-img.gif' ?>"/>
<!--                                <input type="file" name="product_image[]"  id="product_image" class='form-align auto_customer tabwid' style="display:none"/>                               -->
                </td>
                <td>
                    <input type="text"   tabindex="-1"  name='quantity[]' style="width:70px;" class="qty " id="qty"/>
                </td>
                <td>
                    <input type="text"   tabindex="-1"  name='per_cost[]' style="width:70px;" class="percost " id="price"/>
                </td>
                <td>
                    <input type="text"   tabindex="-1"   name='tax[]' style="width:70px;" class="pertax" />
                </td>
                <td>
                    <input type="text"   tabindex="-1" style="width:70px;" name='sub_total[]' readonly="readonly" id="sub_toatl" class="subtotal text_right" />
                </td>
                <td class="action-btn-align"><a id='delete_group' class="del"><span class="glyphicon glyphicon-trash"></span></a></td>
            </tr>
        </table>

        <form  action="<?php echo $this->config->item('base_url'); ?>service/add_invoice" method="post" class=" panel-body">

            <table class="table table-striped responsive dataTable no-footer dtr-inline">
                <tr>
                    <td class="first_td1">Invoice Id</td>
                    <td> <input type="text"  tabindex="-1" name="quotation[inv_id]" class="code form-control colournamedup  form-align" readonly="readonly" value="<?php echo $last_id[0]['value']; ?>"  id="grn_no"></td>
                    <td class="first_td1">Reference No</td>
                    <td>   <input type="text"  name="quotation[q_no]" id="ref_no" class="form-control form-align " /></td>
                    <td>Customer Name</td>
                    <td>
                        <input type="text"  name="customer[name]" id="customer_name" class='form-control form-align auto_customer ' />
                        <input type="hidden"  name="customer[id]" id="customer_id" class='id_customer tabwid form-align' />
<!--                              <input type="hidden"  name="quotation[product_id]" id="cust_id" class='id_customer' />-->
                        <div id="suggesstion-box" class="auto-asset-search "></div>
                    </td>
                </tr>
                <tr>
                    <td class="first_td1">Customer Mobile No</td>
                    <td>
                        <input type="text"  name="customer[mobil_number]" id="customer_no" class="form-control form-align " />
                    </td>
                    <td class="first_td1"  >Customer Email ID</td>
                    <td id='customer_td'>
                        <input type="text"  name="customer[email_id]" id="email_id" class="form-control form-align "/>
                    </td>
                    <td class="first_td">Tin No</td>
                    <td><input type="text" name="company[tin_no]" value="<?= $company_details[0]['tin_no'] ?>" class="code form-control colournamedup  form-align" readonly="readonly" />
                    </td>

                </tr>
                <tr>
                    <td class="first_td1">Customer Po</td>
                    <td>
                        <input type="text" name="quotation[customer_po]" class="form-control form-align" />
                    </td>
                    <td class="first_td1">Warranty</td>
                    <td> <input type="text"   name="quotation[warranty_from]" class="form-control form-align datepicker class_req tab-wid1" placeholder="dd-mm-yyyy"></td>
                    <td> <input type="text"   name="quotation[warranty_to]" class="form-control form-align datepicker class_req " placeholder="dd-mm-yyyy"></td>
                </tr>
                <tr>
                    <td class="first_td1">Customer Address</td>
                    <td>
                        <textarea name="customer[address1]" id="address1" class="form-control form-align "></textarea>
                    </td>
                </tr>
            </table>

            <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">
                <thead>
                    <tr>
                        <td width="10%" class="first_td1">Category</td>
                        <td width="10%" class="first_td1">Brand</td>
                        <td width="10%" class="first_td1">Model Number</td>
                        <td width="10%" class="first_td1">Product Description</td>
                        <td width="10%" class="first_td1">Product Image</td>
                        <td  width="8%" class="first_td1">QTY</td>
                        <td  width="2%" class="first_td1">Cost/QTY</td>
                        <td  width="2%" class="first_td1">Tax</td>
                        <td  width="2%" class="first_td1">Net Value</td>
                        <td width="2%" class="action-btn-align"><a id='add_group' class="btn btn-success form-control pad10"><span class="glyphicon glyphicon-plus"></span> Add Row</a>
                        </td>
                    </tr>
                </thead>
                <tbody id='app_table'>

                    <tr>
                        <td>
                            <select id='' class='cat_id static_style class_req required' name='categoty[]'>
                                <option value="">Select</option>
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
                        </td>

                        <td >
                            <select name='brand[]' class="brand required">
                                <option value="">Select</option>
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
                        </td>
                        <td>
                            <input type="text"  name="model_no[]" id="model_no" class='form-align auto_customer tabwid model_no' />
                            <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-align'  />
<!--                                <input type="hidden"  name="quotation[product_id]" id="cust_id" class='id_customer' />-->
                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                        </td>
                        <td>
                            <textarea  name="product_description[]" id="product_description" class='form-align auto_customer tabwid product_description' onkeyup='f2(this);'/></textarea>
                        </td>
                        <td>
                            <img id="blah" name="product_image[]" class="add_staff_thumbnail product_image" width="50px" height="50px" src="<?= $this->config->item("base_url") ?>attachement/product/no-img.gif"/>
                        </td>
                        <?php if (isset($vals['stock']) && !empty($vals['stock'])) { ?>
                            <td>
                                <input type="text"   tabindex="-1"  name='available_quantity[]' style="width:70px;" class="code form-control colournamedup tabwid form-align " value="<?php echo $vals['stock'][0]['quantity'] ?>" readonly="readonly"/>
                                <input type="text"   tabindex="-1"  name='quantity[]' style="width:70px;" class="qty " />
                            </td>
                        <?php } else { ?>
                            <td>
                                <input type="text"   tabindex="-1"  name='available_quantity[]' style="width:70px;" class="code form-control colournamedup tabwid form-align " value="0" readonly="readonly"/>
                                <input type="text"   tabindex="-1"  name='quantity[]' style="width:70px;" class="qty "/>
                            </td>
                        <?php } ?>
                        <td>
                            <input type="text"   tabindex="-1"  name='per_cost[]' style="width:70px;" class="percost " />
                        </td>
                        <td>
                            <input type="text"   tabindex="-1"   name='tax[]' style="width:70px;" class="pertax"  />
                        </td>
                        <td>
                            <input type="text"   tabindex="-1" style="width:70px;" name='sub_total[]' readonly="readonly" class="subtotal text_right" />
                        </td>
                        <td></td>
                    </tr>

                </tbody>
                <tbody>
                <td colspan="5" style="width:70px; text-align:right;">Total</td>
                <td><input type="text"   name="quotation[total_qty]"  tabindex="-1" readonly="readonly" class="total_qty" style="width:70px;" id="total" /></td>
                <td colspan="2" style="text-align:right;">Sub Total</td>
                <td><input type="text" name="quotation[subtotal_qty]"  tabindex="-1" readonly="readonly"  class="final_sub_total text_right" style="width:70px;" /></td>
                <td></td>
                </tbody>

                <tbody class="add_cost">
                <td colspan="3" style="width:70px; text-align:right;"></td>
                <td colspan="5" style="text-align:right;font-weight:bold;"><input type="text"  name="quotation[tax_label]" class='tax_label text_right'    style="width:100%;" /></td>
                <td>
                    <input type="text"  name="quotation[tax]" class='totaltax text_right'    style="width:70px;" />
                </td>
                <td width="2%" class="action-btn-align"><a id='add_label' class="btn btn-success form-control"><span class="glyphicon glyphicon-plus"></span> Add </a></td>
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="3" style="width:70px; text-align:right;"></td>
                        <td colspan="5"style="text-align:right;font-weight:bold;">Net Total</td>
                        <td><input type="text"  name="quotation[net_total]"  readonly="readonly"  tabindex="-1" class="final_amt text_right" style="width:70px;"  /></td>
                        <td></td>
                    </tr>
                    <tr>

                        <td colspan="10" style="">
                            <span class="remark">Remarks&nbsp;&nbsp;&nbsp;</span>
                            <input name="quotation[remarks]" type="text" class="form-control remark" value="<?php echo $val['remarks']; ?>" />
                        </td>
                    </tr>
                </tfoot>
            </table>
            <input type="hidden"  name="quotation[customer]" id="customers_id" class='id_customer' />
            <div class="action-btn-align">

                <button class="btn btn-info "> Create </button>

                <a href="<?php echo $this->config->item('base_url') . 'service/service_list/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
            </div>
        </form>
        <br />

    </div><!-- contentpanel -->
</div><!-- mainpanel -->

<script type="text/javascript">

    $(document).ready(function () {
// var $elem = $('#scroll');
//  window.csb = $elem.customScrollBar();
        $("#customer_name").keyup(function () {
            $.ajax({
                type: "GET",
                url: "<?php echo $this->config->item('base_url'); ?>" + "service/get_customer",
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
        $("#customers_id").val($(this).attr('cust_id'));
        $("#customer_name").val($(this).attr('cust_name'));
        $("#customer_no").val($(this).attr('cust_no'));
        $("#email_id").val($(this).attr('cust_email'));
        $("#address1").val($(this).attr('cust_address'));
    });

    $('#add_group').click(function () {
        var tableBody = $(".static").find('tr').clone();
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
    $(".model_no").live('keyup', function () {
        var this_ = $(this)
        $.ajax({
            type: "GET",
            url: "<?php echo $this->config->item('base_url'); ?>" + "service/get_product",
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
        $(this).closest('tr').find('.product_description').val($(this).attr('pro_name') + "\n" + $(this).attr('pro_description'));
        $(this).closest('tr').find('.product_image').attr('src', "<?php echo $this->config->item("base_url") . 'attachement/product/' ?>" + $(this).attr('pro_image'));
        $(this).closest('tr').find(".suggesstion-box1").hide();
    });
    function f2(textarea)
    {
        string = textarea.value;
        string = string.toUpperCase();
        textarea.value = string;
    }
</script>
</div>

