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
    <!--  <div class="pageheader">
          <div class="media">
              <div class="pageicon pull-left">
                  <i class="fa fa-quote-right iconquo"></i>
              </div>
              <div class="media-body">
                  <ul class="breadcrumb">
                      <li><a href="#"><i class="glyphicon glyphicon-home"></i></a></li>
                      <li>Home</li>
                      <li>Add</li>
                  </ul>
                  <h4>Add Quotation</h4>
              </div>
          </div>
      </div>-->
    <div id='empty_data'></div>
    <div class="contentpanel mb-45">
        <div class="media">
            <h4>Add Quotation</h4>
        </div>
        <table class="static" style="display: none;">
            <tr>
                <td>
                    <select id="" class="cat_id static_style class_req required" name='categoty[]'>
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
                </td>
<!--                            <td class="sub_category">
                    <select class=" static_color" name='sub_categoty[]'>
                        <option value="">select</option>
                    </select>
                </td>-->
                <td >
                    <select name="brand[]" class="brand required">
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
                </td>
                <td >
                    <input type="text"  name="model_no[]" id="model_no" class='form-align auto_customer tabwid model_no' />
                    <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-align product_id' />
                    <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                </td>
                <td>
                    <textarea  name="product_description[]" id="product_description" class='form-align auto_customer tabwid product_description' />  </textarea>
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
                <td class="action-btn-align"><a id='delete_group' class="btn btn-danger form-control"><span class="glyphicon glyphicon-trash"></span></a></td>
            </tr>
        </table>
        <form  method="post" class="panel-body">
            <table style="width:78%;margin:0 auto;" class="table table-striped  responsive dataTable no-footer dtr-inline">
                <tr>
                    <td class="first_td1">Contact Person</td>
                    <td><select id='' class='nick static_style class_req' name='quotation[ref_name]' style="width:170px;">

                            <option>Select</option>
                            <?php
                            if (isset($nick_name) && !empty($nick_name)) {
                                foreach ($nick_name as $val) {
                                    ?>
                                    <option value='<?php echo $val['nick_name'] ?>'><?php echo $val['nick_name'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select></td>
                    <td class="first_td1">Quotation NO</td>
                    <td> <input type="text"  tabindex="-1" name="quotation[q_no]" class="code form-control colournamedup tabwid form-align" readonly="readonly" value="<?php echo $last_id[0]['value']; ?>"  id="grn_no"></td>
                    <td>Customer Name</td>
                    <td>
                        <input type="text"  name="customer[name]" id="customer_name" class='form-align auto_customer tabwid' />
                        <input type="hidden"  name="customer[id]" id="customer_id" class='id_customer tabwid form-align' />
<!--                              <input type="hidden"  name="quotation[product_id]" id="cust_id" class='id_customer' />-->
                        <div id="suggesstion-box" class="auto-asset-search "></div>
                    </td>
                </tr>
                <tr>
                    <td class="first_td1">Customer Mobile No</td>
                    <td>
                        <input type="text"  name="customer[mobil_number]" id="customer_no" class="form-align tabwid" />
                    </td>
                    <td class="first_td1"  >Customer Email ID</td>
                    <td id='customer_td'>
                        <input type="text"  name="customer[email_id]" id="email_id" class="form-align tabwid"/>
                    </td>
                    <td class="first_td">GSTIN No</td>
                    <td><input type="text" name="company[tin_no]" value="<?= $company_details[0]['tin_no'] ?>" style="width:170px;"  />
                    </td>
                </tr>
                <tr>
                    <td class="first_td1">Customer Address</td>
                    <td colspan="3">
                        <textarea name="customer[address1]" id="address1" class="form-align tabwid1"></textarea>
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
                        <td  width="5%" class="first_td1">QTY</td>
                        <td  width="5%" class="first_td1">Cost/QTY</td>
                        <td  width="5%" class="first_td1">VAT %</td>
                        <td  width="5%" class="first_td1">Net Value</td>
                        <td width="5%" class="action-btn-align"><a id='add_group' class="btn btn-success form-control"><span class="glyphicon glyphicon-plus"></span> Add Row</a>
                        </td>
                    </tr>
                </thead>
                <tbody id='app_table'>
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
<!--                            <td class="sub_category">
                            <select class=" static_color" name='sub_categoty[]'>
                                <option value="">select</option>
                            </select>
                        </td>-->
                        <td >
                            <select name='brand[]'>
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
                            <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-align' />
<!--                                <input type="hidden"  name="quotation[product_id]" id="cust_id" class='id_customer' />-->
                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                        </td>
                        <td>
                            <textarea  name="product_description[]" id="product_description" class='form-align auto_customer tabwid product_description' />  </textarea>
                        </td>
                        <td>
                            <img id="blah" name="product_image[]" class="add_staff_thumbnail product_image" width="50px" height="50px" src="<?= $this->config->item("base_url") . 'attachement/product/no-img.gif' ?>"/>
                        </td>
                        <td>
                            <input type="text"   tabindex="-1"  name='quantity[]' style="width:70px;" class="qty " />
                        </td>
                        <td>
                            <input type="text"   tabindex="-1"  name='per_cost[]' style="width:70px;" class="percost " />
                        </td>
                        <td>
                            <input type="text"   tabindex="-1"   name='tax[]' style="width:70px;" class="pertax" />
                        </td>

                        <td>
                            <input type="text"   tabindex="-1" style="width:70px;" name='sub_total[]' readonly="readonly" class="subtotal text_right" />
                        </td>
                        <td></td>
<!--                            <td class="action-btn-align"><a id='delete_group' class="btn btn-danger form-control"><span class="glyphicon glyphicon-trash"></span></a></td>-->
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" style="width:70px; text-align:right;">Total</td>
                        <td><input type="text"   name="quotation[total_qty]"  tabindex="-1" readonly="readonly" class="total_qty" style="width:70px;" id="total" /></td>
                        <td colspan="2" style="text-align:right;">Sub Total</td>
                        <td><input type="text" name="quotation[subtotal_qty]"  tabindex="-1" readonly="readonly"  class="final_sub_total text_right" style="width:70px;" /></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="width:70px; text-align:right;"></td>
                        <td colspan="5" style="text-align:right;font-weight:bold;"><input type="text"  name="quotation[tax_label]" class='tax_label text_right'    style="width:70px;" /></td>
                        <td>
                            <input type="text"  name="quotation[tax]" class='totaltax text_right'    style="width:70px;" />
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="width:70px; text-align:right;"></td>
                        <td colspan="5"style="text-align:right;font-weight:bold;">Net Total</td>
                        <td><input type="text"  name="quotation[net_total]"  readonly="readonly"  tabindex="-1" class="final_amt text_right" style="width:70px;" /></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="10">
                            <span class="remark">Remarks</span>
                            <input name="quotation[remarks]"  type="text" class="form-control remark"  />
                        </td>
                    </tr>
                </tfoot>
            </table>
            <table class="table table-striped" style="width:100%;border:1 solid #CCC;">
                <tr>
                    <td  style="width:49%;">
                        <table style="width:100%;">
                            <tr>
                                <td colspan="4"><b style="font-size:15px;">TERMS AND CONDITIONS</b></td>
                            </tr>
                            <tr>
                                <td>1.</td>
                                <td>Delivery Schedule</td>
                                <td></td>
                                <td>
                                    <div class="input-group" style="width:70%;">
                                        <input type="text" class="form-control datepicker class_req borderra0" name="quotation[delivery_schedule]" placeholder="dd-mm-yyyy" >
                                        <span id="colorpoerror" style="color:#F00;" ></span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Notification Date</td>
                                <td></td>
                                <td>
                                    <div class="input-group" style="width:70%;">
                                        <input type="text"  id='to_date' class="form-control datepicker borderra0" name="quotation[notification_date]" placeholder="dd-mm-yyyy" >
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>Mode of Payment</td>
                                <td></td>
                                <td>
                                    <div class="input-group" style="width:70%;">
                                        <input type="text"  class="form-control class_req borderra0" name="quotation[mode_of_payment]"/>
                                    </div>
                                </td>
                            </tr>
                            <input type="hidden"  name="quotation[customer]" id="c_id" class='id_customer' />

                        </table>
                    </td>
                    <td style="width:49%;">

                    </td>
                </tr>
            </table>
            <div class="action-btn-align mb-bot20">
                <button class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Create</button>
            </div>
            <br />
        </form>
    </div><!-- contentpanel -->
</div><!-- mainpanel -->

<script type="text/javascript">

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
//		$('.cat_id').live('change',function(){
//			if($(this).val()!='Select')
//			{
//                            var this_=$(this);
//                            for_loading();
//                            $.ajax({
//                                url:BASE_URL+"quotation/get_sub_category",
//                                type:'GET',
//                                data:{
//                                        c_id:$(this).val()
//                                  },
//                                success:function(result){
//                                    for_response();
//                                    this_.closest('tr').find('.sub_category').html(result);
//                                }
//                            });
//			}
//            });

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
            url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_product",
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

</script>
