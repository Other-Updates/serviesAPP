<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    table tr td:nth-child(8){text-align:center;}
    /*table tr td:nth-child(5){text-align:center;}*/
    table tr td:nth-child(6){text-align:center;}
    table tr td:nth-child(7){text-align:right;}
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="tab-header card">
            <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                <li class="nav-item col-md-2">
                    <a class="nav-link active" data-toggle="tab" href="#field-agent-details" role="tab">Product List</a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item col-md-2">
                    <a class="nav-link <?php if (!$this->user_auth->is_action_allowed('masters', 'product', 'add')): ?>alerts<?php endif ?>" data-toggle="tab" href="<?php if ($this->user_auth->is_action_allowed('masters', 'product', 'add')): ?>#field-agent<?php endif ?>" role="tab">Add Product</a>
                    <div class="slide"></div>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="field-agent-details" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">Product Details</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="product_table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>HSN Code</th>
                                        <th>Model#</th>
                                        <th>Product</th>
                                        <th>Product Description</th>
                                        <th>Min Qty</th>
                                        <th>Selling Price</th>
                                        <th>Product.Img</th>
                                        <th class="action-btn-align">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="field-agent" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">Add Product</h5>
                    </div>
                    <div class="card-block">
                        <form class="form-material" action="<?php echo $this->config->item('base_url'); ?>product/insert_product" enctype="multipart/form-data" name="form" method="post">
                            <div class="form-material row">
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-address-book"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Model Number <span class="req">*</span></label>
                                            <input type="text" name="model_no" class="form-control model_no"  id="model_no" />
                                            <span class="form-bar"></span>
                                            <span id="model" class="val text-danger" ></span>
                                            <span id="dup" class="dup text-danger"></span>

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
                                            <input type="text" name="product_name" class=" form-control " id="name" />
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
                                                <input type="radio" name="type" value="1" id="service_item" data-bv-field="type">
                                                <i class="helper"></i>Product
                                            </label>
                                        </div>
                                        <div class="radio radiofill radio-primary radio-inline">
                                            <label>
                                                <input type="radio" name="type" value="2" id="service_item" data-bv-field="type">
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
                                            <img id="blah" class="img-40 add_staff_thumbnail" src="<?= $this->config->item("base_url") . 'attachement/product/no-img.gif' ?>"/>
                                        </div>
                                        <div class="col-md-10">
                                            <input type='file' name="admin_image" class="form-control imgInp productmargin-40" />
                                            <span class="form-bar"></span>
                                            <span id="profileerror9" class="val text-danger" id="img"></span>
                                            <span id="cuserror1" class="val text-danger" ></span>


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
                                            <select name="category_id" class="form-control " id="category_id" >
                                                <option value="">Select Category</option>
                                                <?php foreach ($cat as $val) { ?>
                                                    <option value="<?php echo $val['cat_id'] ?>"><?php echo $val['categoryName'] ?></option>
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
                                            <select name="brand_id" class="form-control" id="brand_id" >
                                                <option value="">Select Brand</option>
                                                <?php foreach ($brand as $val) { ?>
                                                    <option value="<?php echo $val['id'] ?>"><?php echo $val['brands'] ?></option>
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
                                            <input type="text" name="cost_price" class=" form-control" id="cost_price" />
                                            <span class="form-bar"></span>
                                            <span id="cost" class="val text-danger" ></span>

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
                                            <input type="text" name="min_qty" class=" form-control " id="min_qty" />
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
                                            <input type="text" name="selling_price" class="form-control " id="sell_price"/>
                                            <span class="form-bar"></span>
                                            <span id="sell" class="val text-danger" ></span>

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
                                            <textarea name="product_description"  class=" form-control " id="description" onkeyup='f2(this);'></textarea>
                                            <span class="form-bar"></span>
                                            <span id="cuserror3" class="val text-danger" ></span>

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
                                            <input type="text" name="cgst" class="form-control " id="cgst"/>
                                            <span class="form-bar"></span>
                                            <span id="cgst_err" class="val text-danger" ></span>

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
                                            <input type="text" name="sgst" class="form-control" id="sgst"/>
                                            <span class="form-bar"></span>
                                            <span id="sgst_err" class="val text-danger" ></span>

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
                                            <input type="text" name="igst" class="form-control" id="igst"/>
                                            <span class="form-bar"></span>
                                            <span id="igst_err" class="val text-danger" ></span>

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
                                            <input type="text" name="hsn_sac" class="form-control" id="hsn_sac"/>
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
                                            <input type="text" name="add_amount" class=" form-control" id="add_amount" />
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
                                            <input type="text" name="po_add_amount" class=" form-control" id="po_add_amount" />
                                            <span class="form-bar"></span>
                                            <span id="po_add_amount_err" class="val text-danger" ></span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row text-center m-10">
                                <div class="col-md-12 text-center">
                                    <input type="submit" name="submit" class="btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light" value="Save" id="submit" tabindex="1"/>
                                    <input type="reset" value="Clear" class="btn btn-danger waves-effect m-b-10 btn-sm waves-light" id="reset" tabindex="1"/>
                                    <a href="<?php echo $this->config->item('base_url') . 'product/' ?>" class="btn btn-inverse btn-sm waves-effect waves-light m-b-10" tabindex="1"> Back </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).on('click', '.alerts', function () {
        sweetAlert("Oops...", "This Access is blocked!", "error");
        return false;
    });
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
    $('input[type="text"]').live('keyup', function (e) {
        var start = e.target.selectionStart;
        var end = e.target.selectionEnd;
        e.target.value = e.target.value.toUpperCase();
        e.target.setSelectionRange(start, end);
//        this_val = $(this).val();
//        value = this_val.toUpperCase();
//        $(this).val(value);
//        console.log(value);
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
    //$("#type").live('blur',function()
    //{
    //	var type=$("#type").val();
    //	if(type=="" || type==null || type.trim().length==0)
    //	{
    //		$("#type1").html("Required Field");
    //	}
    //	else
    //	{
    //		$("#type1").html("");
    //	}
    //});
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
    $("#min_qty").live('blur', function ()
    {
        var min_qty = $("#min_qty").val();
        if (min_qty == "" || min_qty == null || min_qty.trim().length == 0)
        {
            $("#min_qty1").html("Required Field");
        } else
        {
            $("#min_qty1").html("");
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
    });</script>
<script type="text/javascript">
    $('#submit').live('click', function ()
    {
        email = $.trim($("#model_no").val());
        $.ajax(
                {
                    url: BASE_URL + "product/add_duplicate_product",
                    type: 'get',
                    async: false,
                    data: {value1: email},
                    success: function (result)
                    {
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
        var model_no = $("#model_no").val();
        if ($('#dup').html() == 'Model Number Already Exist')
        {
            i = 1;
        } else if (model_no == "" || model_no == null || model_no.trim().length == 0)
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
        var sell_price = $("#sell_price").val();
        if (sell_price == "" || sell_price == null || sell_price.trim().length == 0)
        {
            $("#sell").html("Required Field");
            i = 1;
        } else
        {
            $("#sell").html("");
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


        if ($('input[name=type]:checked').length <= 0)
        {
            $("#type1").html("Required Field");
            i = 1;
        } else
        {
            $("#type1").html("");
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

    });</script>
<script>
    $("#model_no").live('blur', function ()
    {
        email = $.trim($("#model_no").val());
        $.ajax(
                {
                    url: BASE_URL + "product/add_duplicate_product",
                    type: 'get',
                    data: {value1: email},
                    success: function (result)
                    {
                        $("#dup").html(result);
                    }
                });
    });</script>

<?php
if (isset($product) && !empty($product)) {
    foreach ($product as $val) {
        ?>
        <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
            <div class="modal-dialog">
                <div class="modal-content modalcontent-top">
                    <div class="modal-header modal-padding modalcolor">
                        <h4 id="myModalLabel" class="inactivepop">In-Active Product</h4>
                        <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                    </div>
                    <div class="modal-body">
                        Do You Want In-Active This Product?<strong><?= $val['model_no']; ?></strong>
                        <input type="hidden" value="<?php echo $val['id']; ?>" class="id" />
                    </div>
                    <div class="modal-footer action-btn-align">
                        <button class="btn btn-primary btn-sm delete_yes" id="yesin">Yes</button>
                        <button type="button" class="btn btn-danger btn-sm delete_all"  data-dismiss="modal" id="no">No</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
<script type="text/javascript">
    function delete_product(val) {
        $('#test3_' + val).modal('show');
    }
    $(document).ready(function ()
    {
        $('#product_table').DataTable({
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "language": {
                "infoFiltered": ""
            },
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                url: BASE_URL + "product/ajaxList",
                "type": "POST",
            },
            createdRow: function (row, data, index) {
                $('td', row).eq(3).addClass('remove_nowrap'); // 6 is index of column
            },
            //Set column definition initialisation properties.
//            "columnDefs": [
//                {
//                    "targets": [0, 9], //first column / numbering column
//                    "orderable": false, //set not orderable
//                },
//            ],
        });
        $(".delete_yes").on("click", function ()
        {

            var hidin = $(this).parent().parent().find('.id').val();
            $.ajax({
                url: BASE_URL + "product/delete_product",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "agent/");
                }
            });
        });
        $('.modal').css("display", "none");
        $('.fade').css("display", "none");
    });</script>
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
