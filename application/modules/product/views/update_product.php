<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<div class="row">
    <div class="col-sm-12">
        <div class="tab-header card">
            <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                <li class="nav-item col-md-2">
                    <a class="nav-link active" data-toggle="tab" href="#update-field" role="tab">Update Product</a>
                    <div class="slide"></div>
                </li>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="update-field" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5>Update List</h5>
                    </div>
                    <div class="card-block">
                        <form class="form-material" action="<?php echo $this->config->item('base_url') . 'product/update_products'; ?>" enctype="multipart/form-data" name="form" method="post">
                            <?php
                            if (isset($product) && !empty($product)) {
                                $i = 0;
                                foreach ($product as $val) {
                                    $i++
                                    ?>
                                    <div class="form-material row">
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-address-book"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Model Number <span class="req">*</span></label>
                                                    <input type="hidden" name="id" class="id id_dup form-control" value="<?php echo $val['id']; ?>" id="model_id"/>
                                                    <input type="text" name="model_no" org_name="<?php echo $val['model_no']; ?>" class="form-control form-align" value="<?php echo $val['model_no']; ?>" id="model_no" tabindex="1"/>
                                                    <span class="form-bar"></span>
                                                    <span id="model" class="val text-danger"></span>
                                                    <span id="dup" class="val text-danger"></span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-cc-camera"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Product Name <span class="req">*</span></label>
                                                    <input type="text" name="product_name" class=" form-control form-align" id="name" value="<?php echo $val['product_name']; ?>" tabindex="1"/>
                                                    <span class="form-bar"></span>
                                                    <span id="cuserror2" class="val text-danger"></span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="col-md-12 new-style-form">
                                                <span class="help-block">Type</span>
                                            </div>
                                            <div class="form-radio col-lg-12">
                                                <div class="radio radiofill radio-primary radio-inline">
                                                    <label>
                                                        <input type="radio" name="type" value="product"  <?php if ($val['type'] == 'product') echo 'checked="checked"'; ?>  data-bv-field="type" tabindex="1">
                                                        <i class="helper"></i>Product
                                                    </label>
                                                </div>
                                                <div class="radio radiofill radio-primary radio-inline">
                                                    <label>
                                                        <input type="radio" name="type" value="service" <?php if ($val['type'] == 'service') echo 'checked="checked"'; ?> data-bv-field="type" tabindex="1">
                                                        <i class="helper"></i>Service
                                                    </label>
                                                </div>
                                            </div>
                                            <span class="form-bar"></span>
                                            <span id="type1" class="val text-danger"></span>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="row">
                                                <div class="col-md-12 new-style-form">
                                                    <span class="help-block">Product image</span>
                                                </div>
                                                <div class="col-md-2">
                                                    <?php
                                                    if (!empty($val['product_image'])) {
                                                        $file = FCPATH . 'attachement/product/' . $val['product_image'];
                                                        $exists = file_exists($file);
                                                        $cust_image = (!empty($exists) && isset($exists)) ? $val['product_image'] : "no-img.gif";
                                                    } else {
                                                        $cust_image = "no-img.gif";
                                                    }
                                                    ?>
                                                    <img id="blah" class="img-40 add_staff_thumbnail" src="<?= $this->config->item("base_url") . 'attachement/product/' . $cust_image; ?>"/>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type='file' name="admin_image" class="form-control imgInp productmargin-40" autocomplete="off" tabindex="1"/><span id="profileerror9" class="val text-danger"></span>
                                                    <span class="form-bar"></span>
                                                    <span id="cuserror1" class="val text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-material row">
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-address-book"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <select name="category_id" class="form-control form-align" id="category_id" tabindex="1">
                                                        <option value="">Select Category</option>
                                                        <?php
                                                        foreach ($cat as $vals) {
                                                            $slected = ($vals['cat_id'] == $val['category_id'] ) ? 'selected' : '';
                                                            ?>

                                                            <option value="<?php echo $vals['cat_id'] ?>" <?php echo $slected; ?> ><?php echo $vals['categoryName'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <span class="form-bar"></span>
                                                    <span id="category" class="val text-danger"></span>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-address-book"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <select name="brand_id" class="form-control form-align" id="brand_id" tabindex="1">
                                                        <option value="">Select Brand</option>
                                                        <?php
                                                        foreach ($brand as $vals) {
                                                            $slected = ($vals['id'] == $val['brand_id'] ) ? 'selected' : '';
                                                            ?>
                                                            <option value="<?php echo $vals['id'] ?>" <?php echo $slected; ?>><?php echo $vals['brands'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <span class="form-bar"></span>
                                                    <span id="brand" class="val text-danger"></span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">

                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-money-bag"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Cost Price <span class="req">*</span></label>
                                                    <input type="text" name="cost_price" class=" form-control form-align" id="cost_price" value="<?php echo $val['cost_price']; ?>" tabindex="1"/>
                                                    <span class="form-bar"></span>
                                                    <span id="cost" class="val text-danger"></span>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-money-bag"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Minimum Quantity <span class="req">*</span></label>
                                                    <input type="text" name="min_qty" class=" form-control form-align" id="min_qty" value="<?php echo $val['min_qty']; ?>" tabindex="1"/>
                                                    <span class="form-bar"></span>
                                                    <span id="min_qty1" class="val text-danger"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-material row">
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-money-bag"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Minimum Selling Price <span class="req">*</span></label>
                                                    <input type="text" name="selling_price" class="form-control form-align" id="sell_price" value="<?php echo $val['selling_price']; ?>" tabindex="1"/>
                                                    <span class="form-bar"></span>
                                                    <span id="sell" class="val text-danger"></span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-file-text"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Product Description <span class="req">*</span></label>
                                                    <textarea name="product_description" class=" form-control form-align"  id="description" onkeyup='f2(this);' tabindex="1"><?php echo $val['product_description']; ?></textarea>
                                                    <span class="form-bar"></span>
                                                    <span id="cuserror3" class="val text-danger"></span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-coins"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">CGST % <span class="req">*</span></label>
                                                    <input type="text" name="cgst" class="form-control form-align" id="cgst" value="<?php echo $val['cgst']; ?>"/>
                                                    <span class="form-bar"></span>
                                                    <span id="cgst_err" class="val text-danger"></span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-coins"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">SGST % <span class="req">*</span></label>
                                                    <input type="text" name="sgst" class="form-control form-align" id="sgst" value="<?php echo $val['sgst']; ?>"/>
                                                    <span class="form-bar"></span>
                                                    <span id="sgst_err" class="val text-danger"></span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-coins"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">IGST % <span class="req">*</span></label>
                                                    <input type="text" name="igst" class="form-control form-align" id="igst" value="<?php echo $val['igst']; ?>"/>
                                                    <span class="form-bar"></span>
                                                    <span id="igst_err" class="val text-danger"></span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-address-book"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">HSN Code </label>
                                                    <input type="text" name="hsn_sac" class="form-control" value="<?php echo $val['hsn_sac']; ?>" id="hsn_sac"/>
                                                    <span class="form-bar"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-money-bag"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Sales Corrected Amount <span class="req">*</span></label>
                                                    <input type="text" name="add_amount" value="<?php echo $val['add_amount']; ?>" class=" form-control" id="add_amount" />
                                                    <span class="form-bar"></span>
                                                    <span id="add_amount_err" class="val text-danger" ></span>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-money-bag"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Purchase Corrected Amount <span class="req">*</span></label>
                                                    <input type="text" name="po_add_amount" value="<?php echo $val['po_add_amount']; ?>" class=" form-control" id="po_add_amount" />
                                                    <span class="form-bar"></span>
                                                    <span id="po_add_amount_err" class="val text-danger" ></span>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                                        <thead>
                                        <td class="action-btn-align" colspan="4">Last Purchased Supplier Invoice Details</td>
                                        </thead>
                                        <tr>
                                            <?php if (isset($vendor_details) && !empty($vendor_details)) { ?>
                                                <td class="text-left"><span  class="f-w-700">Company Name:</span><?= $vendor_details[0]['store_name'] ?></td>
                                                <td class="text-left"><span  class="f-w-700">Name:</span><?= $vendor_details[0]['name'] ?></td>
                                                <td class="text-left"><span  class="f-w-700">PO NO:</span><?= $vendor_details[0]['po_no'] ?></td>
                                                <td class="text-left"><span  class="f-w-700">Quantity:</span><?= $vendor_details[0]['quantity'] ?></td>
                                                <?php
                                            } else {
                                                echo "<tr>
                        <td colspan='4'>No Data Found</td>
                    </tr>";
                                            }
                                            ?>
                                        </tr>
                                    </table>
                                    <div class="form-material row text-center m-10">
                                        <div class="col-md-12 text-center">
                                            <input type="submit" name="submit" class="btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light" value="Save" id="submit" tabindex="1"/>
                                            <input type="reset" value="Clear" class="btn btn-danger waves-effect m-b-10 btn-sm waves-light" id="reset" tabindex="1"/>
                                            <a href="<?php echo $this->config->item('base_url') . 'product/' ?>" class="btn btn-inverse btn-sm waves-effect waves-light m-b-10"><span class="glyphicon"></span> Back </a>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function readURL(input) {
        console.log(input);
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(input).parent('div').parent('div').find('#blah').attr('src', e.target.result);
                $(input).closest('div').find('#blah').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(".imgInp").live('change', function () {
        readURL(this);
    });
    $("#name").live('blur', function ()
    {
        var name = $("#name").val();
        if (name == "" || name == null || name.trim().length == 0)
        {
            $("#cuserror2").html("Required Field");
        } else
        {
            $("#cuserror2").html("");
        }
    });
    $("#add_amount").live('blur', function ()
    {
        var add_amount = $("#add_amount").val();
        if (add_amount == "" || add_amount == null || add_amount.trim().length == 0)
        {
            $("#add_amount_err").html("Required Field");
        } else
        {
            $("#add_amount_err").html("");
        }
    });
    $("#po_add_amount").live('blur', function ()
    {
        var po_add_amount = $("#po_add_amount").val();
        if (po_add_amount == "" || po_add_amount == null || po_add_amount.trim().length == 0)
        {
            $("#po_add_amount_err").html("Required Field");
        } else
        {
            $("#po_add_amount_err").html("");
        }
    });
    $("#description").live('blur', function ()
    {
        var name = $("#description").val();
        if (name == "" || name == null || name.trim().length == 0)
        {
            $("#cuserror3").html("Required Field");
        } else
        {
            $("#cuserror3").html("");
        }
    });
    //$("#img").live('blur',function()
    //{
    //	var store=$("#img").val();
    //	if(store=="" || store==null || store.trim().length==0)
    //	{
    //		$("#cuserror1").html("Required Field");
    //	}
    //	else
    //	{
    //		$("#cuserror1").html("");
    //	}
    //});
    $("#model_no").live('blur', function ()
    {
        var model_no = $("#model_no").val();
        if (model_no == "" || model_no == null || model_no.trim().length == 0)
        {
            $("#model").html("Required Field");
        } else
        {
            $("#model").html("");
        }
    });
    $("#sell_price").live('blur', function ()
    {
        var sell_price = $("#sell_price").val();
        if (sell_price == "" || sell_price == null || sell_price.trim().length == 0)
        {
            $("#sell").html("Required Field");
        } else
        {
            $("#sell").html("");
        }
    });
    $("#cost_price").live('blur', function ()
    {
        var cost_price = $("#cost_price").val();
        if (cost_price == "" || cost_price == null || cost_price.trim().length == 0)
        {
            $("#cost").html("Required Field");
        } else
        {
            $("#cost").html("");
        }
    });

    $("#category_id").live('blur', function ()
    {
        var category_id = $("#category_id").val();
        if (category_id == "" || category_id == null || category_id.trim().length == 0)
        {
            $("#category").html("Required Field");
        } else
        {
            $("#category").html("");
        }
    });

    $("#brand_id").live('blur', function ()
    {
        var brand_id = $("#brand_id").val();
        if (brand_id == "" || brand_id == null || brand_id.trim().length == 0)
        {
            $("#brand").html("Required Field");
        } else
        {
            $("#brand").html("");
        }
    });
    $("#cgst").on('blur', function ()
    {
        var cgst = $("#cgst").val();
        var nfilter = /^[0-9]*\.?[0-9]*$/;
        if (cgst == "" || cgst == null || cgst.trim().length == 0)
        {
            $("#cgst_err").html("Required Field");
        } else if (!nfilter.test(cgst))
        {
            $("#cgst_err").html("Enter Valid Amount");
        } else
        {
            $("#cgst_err").html("");
        }
    });

    $("#sgst").on('blur', function ()
    {
        var sgst = $("#sgst").val();
        var nfilter = /^[0-9]*\.?[0-9]*$/;
        if (sgst == "")
        {
            $("#sgst_err").html("Required Field");
        } else if (!nfilter.test(sgst))
        {
            $("#sgst_err").html("Enter Valid Amount");
        } else
        {
            $("#sgst_err").html("");
        }
    });

    $("#igst").on('blur', function ()
    {
        var igst = $("#igst").val();
        var nfilter = /^[0-9]*\.?[0-9]*$/;
        if (igst == "")
        {
            $("#igst_err").html("Required Field");
        } else if (!nfilter.test(igst))
        {
            $("#igst_err").html("Enter Valid Amount");
        } else
        {
            $("#igst_err").html("");
        }
    });

    $('#reset').live('click', function ()
    {
        $('.val').html("");
    });
    $('input[type="text"]').live('keyup', function (e) {
        var start = e.target.selectionStart;
        var end = e.target.selectionEnd;
        e.target.value = e.target.value.toUpperCase();
        e.target.setSelectionRange(start, end);
//        this_val = $(this).val();
//        value = this_val.toUpperCase();
//        $(this).val(value);

    });
</script>
<script type="text/javascript">
    $('#submit').live('click', function ()
    {
        email = $.trim($("#model_no").val());
        id = $('#model_id').val();
        $.ajax(
                {
                    url: BASE_URL + "product/update_duplicate_product",
                    type: 'get',
                    async: false,
                    data: {value1: email, value2: id},
                    success: function (result)
                    {
                        if ($('#model_no').attr('org_name') != email)
                            $("#dup").html(result);
                    }
                });
        var i = 0;
        var name = $("#name").val();
        if (name == "" || name == null || name.trim().length == 0)
        {
            $("#cuserror2").html("Required Field");
            i = 1;
        } else
        {
            $("#cuserror2").html("");
        }
        var add_amount = $("#add_amount").val();
        if (add_amount == "" || add_amount == null || add_amount.trim().length == 0)
        {
            $("#add_amount_err").html("Required Field");
            i = 1;
        } else
        {
            $("#add_amount_err").html("");
        }
        var po_add_amount = $("#po_add_amount").val();
        if (po_add_amount == "" || po_add_amount == null || po_add_amount.trim().length == 0)
        {
            $("#po_add_amount_err").html("Required Field");
            i = 1;
        } else
        {
            $("#po_add_amount_err").html("");
        }
        var city = $('#description').val();
        if (city == "")
        {
            $('#cuserror3').html("Required Field");
            i = 1;
        } else
        {
            $('#cuserror3').html("");
        }
        var model_no = $("#model_no").val();
        if (model_no == "" || model_no == null || model_no.trim().length == 0)
        {
            $("#model").html("Required Field");
            i = 1;
        } else
        {
            $("#model").html("");
        }


        var cost_price = $("#cost_price").val();
        if (cost_price == "" || cost_price == null || cost_price.trim().length == 0)
        {
            $("#cost").html("Required Field");
            i = 1;
        } else
        {
            $("#cost").html("");
        }
        var min_qty = $("#min_qty").val();
        if (min_qty == "" || min_qty == null || min_qty.trim().length == 0)
        {
            $("#min_qty1").html("Required Field");
            i = 1;
        } else
        {
            $("#min_qty1").html("");
        }
        var category = $('#category_id').val();
        if (category == "")
        {
            $('#category').html("Required Field");
            i = 1;
            $('#category_id').focus();
        } else
        {
            $('#category').html("");
        }

        var brand = $('#brand_id').val();
        if (brand == "")
        {
            $('#brand').html("Required Field");
            i = 1;
            $('#brand_id').focus();
        } else
        {
            $('#brand').html("");
        }
        var sell_price = $("#sell_price").val();
        if (sell_price == "" || sell_price == null || sell_price.trim().length == 0)
        {
            $("#sell").html("Required Field");
            i = 1;
        } else
        {
            $("#sell").html("");
        }
        if ($('input[name=type]:checked').length <= 0)
        {
            $("#type1").html("Required Field");
            i = 1;
        } else
        {
            $("#type1").html("");
        }
        if ($('#dup').html() == 'Model Number Already Exist')
        {
            i = 1;
        } else
        {
            $('#dup').html('');
        }

        var cgst = $("#cgst").val();
        var nfilter = /^[0-9]*\.?[0-9]*$/;
        if (cgst == "" || cgst == null || cgst.trim().length == 0)
        {
            $("#cgst_err").html("Required Field");
            i = 1;
        } else if (!nfilter.test(cgst))
        {
            $("#cgst_err").html("Enter Valid Amount");
            i = 1;
        } else
        {
            $("#cgst_err").html("");
        }

        var sgst = $("#sgst").val();
        if (sgst == "")
        {
            $("#sgst_err").html("Required Field");
            i = 1;
        } else if (!nfilter.test(sgst))
        {
            $("#sgst_err").html("Enter Valid Amount");
            i = 1;
        } else
        {
            $("#sgst_err").html("");
        }

        var igst = $("#igst").val();
        if (igst == "")
        {
            $("#igst_err").html("Required Field");
            i = 1;
        } else if (!nfilter.test(igst))
        {
            $("#igst_err").html("Enter Valid Amount");
            i = 1;
        } else
        {
            $("#igst_err").html("");
        }



        if (i == 1)
        {
            return false;
        } else
        {
            return true;
        }

    });
</script>
<script>
    $("#model_no").live('blur', function ()
    {
        email = $.trim($("#model_no").val());
        id = $('#model_id').val();
        $.ajax(
                {
                    url: BASE_URL + "product/update_duplicate_product",
                    type: 'get',
                    data: {value1: email, value2: id},
                    success: function (result)
                    {
                        if ($('#model_no').attr('org_name') != email)
                            $("#dup").html(result);
                    }
                });
    });
</script>
<script>
    function f2(textarea)
    {
//        string = textarea.value;
//        string = string.toUpperCase();
//        textarea.value = string;
    }

</script>
<script type="text/javascript">
    function forceInputUppercase(e) {
        var start = e.target.selectionStart;
        var end = e.target.selectionEnd;
        e.target.value = e.target.value.toUpperCase();
        e.target.setSelectionRange(start, end);
    }
    document.getElementById("description").addEventListener("keyup", forceInputUppercase, false);
</script>
