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

<style>
    #add_group, #add_group_service {
        color: #fff;
    }
    .green {
        color: green;
    }
    .red {
        color: red;
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

//echo '<pre>';print_r($model_numbers_json);exit;

$model_numbers_json1 = array();
if (!empty($products1)) {
    foreach ($products1 as $list) {
        $model_numbers_json1[] = '{ value: "' . $list['model_no'] . '", id: "' . $list['id'] . '"}';
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
                <h5>Update Quotation</h5>
                <?php
                if (isset($quotation) && !empty($quotation)) {
                    foreach ($quotation as $val) {
                        ?>
                        <div style="float:right;" onClick="dcl(this)">
                            <label class="togswitch">
                                <input class=" grand_gst" type="checkbox" <?php echo ($val['is_gst'] == '1') ? 'checked' : '' ?> >
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
                            <select id='' class='form-control cat_id static_style class_req' tabindex="-1" name='categoty[]' >
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
                            <span class="error_msg text-danger"></span>
                        </td>
                        <td >
                            <input type="text"  name="model_no[]" id="model_no" class='form-control auto_customer tabwid model_no' tabindex="6"  />
                            <span class="error_msg text-danger"></span>
                            <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-control product_id' />
                            <input type="hidden"  name="type[]" id="type" class=' tabwid form-control type' />
                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                        </td>
                        <td>
                            <textarea  name="product_description[]" tabindex="-1"  id="product_description" class='form-control auto_customer tabwid4 product_description' onkeyup='f2(this);'/>  </textarea>
                        </td>
                        <td class="action-btn-align">
                            <img id="blah" name="product_image[]"  class="add_staff_thumbnail product_image img-50"  src="<?= $this->config->item("base_url") . 'attachement/product/no-img.gif' ?>"/>
                            <input type="file" name="product_image[]" tabindex="-1" id="product_image" class='form-control auto_customer tabwid' style="display:none"/>
                        </td>
                        <td class="action-btn-align hsn_td">
                            <input type="text"  name="hsn_sac[]" id="hsn_sac" tabindex="-1"  class='form-control hsn_sac ' />

                        </td>
                        <td class="action-btn-align add_amount_td">
                            <input type="text"  name="add_amount[]" id="add_amount" tabindex="-1"  class='form-control add_amount right-align' />

                        </td>
                        <td class="action-btn-align">
                            <input type="text"   tabindex="-1"  name='available_quantity[]' class="code form-control colournamedup tabwid stock_qty cent-align" readonly="readonly"/>
                            <input type="text" tabindex="6" name='quantity[]' class="qty form-control cent-align" id="qty"/>
                            <span class="error_msg text-danger"></span>
                        </td>
                        <td>
                            <input type="text"   tabindex="-1"  name='per_cost[]' class="selling_price percost form-control right-align" id="price"/>
                            <input type="hidden" class="selling_price_actual" />
                            <input type="hidden"  name='project_cost_per_cost[]' class="cost_price cp_percost form-control" id="costprice"/>
                            <span class="error_msg text-danger"></span>
                        </td>
                        <td class="action-btn-align cgst_td">
                            <input type="text"  tabindex="-1"    name='tax[]' readonly="" class="pertax form-control cent-align" />
                        </td>
                        <td class="action-btn-align sgst_td">
                            <input type="text"   tabindex="-1"   name='gst[]' readonly="" class="gst form-control cent-align" />
                        </td>
                        <td class="action-btn-align igst_td">
                            <input type="text"   tabindex="-1"   name='igst[]' readonly="" class="igst wid50 form-control cent-align"  />
                        </td>
                        <td>
                            <input type="text" tabindex="-1" name='sub_total[]' readonly="readonly" id="sub_toatl" class="subtotal form-control text_right" />
                            <input type="hidden" tabindex="-1" name='project_cost_sub_total[]' readonly="readonly" id="project_cost_sub_total " class="project_cost_subtotal form-control text-right" />
                        </td>
                        <td class="action-btn-align">
                            <a href="javascript:void(0);" class="green up order-icon" tabindex="-1"><i class="fa fa-long-arrow-up"></i></a> &nbsp;
                            <a class="red down order-icon" href="javascript:void(0);" tabindex="-1"><i class="fa fa-long-arrow-down"></i></a>&nbsp;
                            <a id='delete_group' class="del btn btn-danger btn-mini" tabindex="-1"><span class="fa fa-trash"></span></a>
                        </td>
                    </tr>
                </table>
                <table class="static_ser" style="display: none;">
                    <tr>
                        <td>
                            <select id='' class='cat_id static_style class_req form-control' name='categoty[]' tabindex="-1" >
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
<!--                        <td class="sub_category">
                            <select class="form-control static_color" name='sub_categoty[]'>
                                <option value="">select</option>
                            </select>
                        </td>-->
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
                            <input type="text"  name="model_no[]" id="model_no_ser" class='form-control auto_customer tabwid model_no_ser' tabindex="6" />
                            <span class="error_msg text-danger"></span>
                            <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-control product_id' />
                            <input type="hidden"  name="type[]" id="type_ser" class=' tabwid form-control type type_ser' />
                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                        </td>
                        <td>
                            <textarea  name="product_description[]" tabindex="-1" id="product_description"  class='form-control auto_customer tabwid4 product_description' onkeyup='f2(this);' />  </textarea>
                        </td>
                        <td class="action-btn-align">
                            <img id="blah" name="product_image[]" class="add_staff_thumbnail product_image img-50"  src="<?= $this->config->item("base_url") . 'attachement/product/no-img.gif' ?>"/>
                            <input type="file" name="product_image[]"  id="product_image" class='form-control auto_customer tabwid' style="display:none"/>
                        </td>
                        <td class="action-btn-align hsn_td">
                            <input type="text"  name="hsn_sac[]" id="hsn_sac" tabindex="-1"  class='form-control hsn_sac ' />

                        </td>
                        <td class="action-btn-align add_amount_td">
                            <input type="text"  name="add_amount[]" id="add_amount" tabindex="-1"  class='form-control add_amount right-align' />

                        </td>
                        <td class="action-btn-align">
                            <input type="text" tabindex="6" name='quantity[]' class="qty form-control cent-align" id="qty"/>
                            <span class="error_msg text-danger"></span>
                        </td>
                        <td>
                            <input type="text"   tabindex="-1"  name='per_cost[]' class="selling_price percost form-control right-align" id="price"/>
                            <input type="hidden" class="selling_price_actual" />
                            <input type="hidden"  name='project_cost_per_cost[]' class="cost_price cp_percost form-control" id="costprice"/>
                            <span class="error_msg text-danger"></span>
                        </td>
                        <td class="action-btn-align cgst_td">
                            <input type="text"  tabindex="-1"    name='tax[]' readonly="" class="pertax form-control cent-align" />
                        </td>
                        <td class="action-btn-align sgst_td">
                            <input type="text"   tabindex="-1"   name='gst[]' readonly="" class="gst form-control cent-align" />
                        </td>
                        <td class="action-btn-align igst_td">
                            <input type="text"   tabindex="-1"   name='igst[]' readonly="" class="igst wid50 form-control cent-align"  />
                        </td>
                        <td>
                            <input type="text" name='sub_total[]' tabindex="-1" readonly="readonly" id="sub_toatl" class="subtotal text-right form-control" />
                            <input type="hidden" tabindex="-1" name='project_cost_sub_total[]' readonly="readonly" id="project_cost_sub_total " class="project_cost_subtotal form-control text-right" />
                        </td>
                        <td class="action-btn-align">
                            <a href="javascript:void(0);" class="green up order-icon" tabindex="-1"><i class="fa fa-long-arrow-up"></i></a> &nbsp;
                            <a class="red down order-icon" href="javascript:void(0);" tabindex="-1"><i class="fa fa-long-arrow-down"></i></a>&nbsp;
                            <a id='delete_group' class="del btn btn-danger btn-mini" tabindex="-1"><span class="fa fa-trash"></span></a>
                        </td>
                    </tr>
                </table>
                <?php
                if (isset($quotation) && !empty($quotation)) {
                    foreach ($quotation as $val) {
                        ?>
                        <form name="form" method="post">
                            <input id="gst_check_status_value" type="hidden"  name="check_gst"  value="<?php echo ($val['is_gst']) ?>">

                            <div class="form-material row">
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-address-book"></i>
                                        </div>

                                        <div class="form-group form-primary">
                                            <select id='' class='nick static_style class_req required form-control' tabindex="1"  name='quotation[ref_name]'>
                                                <?php
                                                if (isset($nick_name) && !empty($nick_name)) {
                                                    foreach ($nick_name as $vals) {
                                                        if ($vals['id'] == $val['ref_name']) {
                                                            echo '<option value="' . $vals['id'] . '" selected="selected">' . $vals['name'] . '-' . $vals['nick_name'] . '</option>';
                                                        } else {
                                                            echo '<option value="' . $vals['id'] . '" >' . $vals['name'] . '-' . $vals['nick_name'] . '</option>';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <span class="form-bar"></span>
                                            <span class="error_msg text-danger"></span>

                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-address-book"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Quotation NO</label>
                                            <input type="text"  tabindex="-1" name="quotation[q_no]" class=" form-control colournamedup form-align tabwid" readonly="readonly" value="<?php echo $val['q_no'];
                                                ?>"  id="quotation_number">
                                            <input type="hidden" id="quotation_id"  value="<?php echo $val['id']; ?>" />
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
                                            <input type="text"  name="customer[store_name]" id="customer_name" tabindex="2" class='auto_customer form-control tabwid required' value="<?php echo $val['store_name']; ?>"  />
                                            <input type="hidden"  name="customer[id]" id="customer_id" class='id_customer form-control tabwid' value="" />
                                            <span class="error_msg text-danger"></span>
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
                                            <label class="float-label">Customer Mobile No <span class="req">*</span></label>
                                            <input type="text"  tabindex="-1" name="customer[mobil_number]" class="form-control tabwid required" id="customer_no" value="<?php echo $val['mobil_number']; ?>"/>
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
                                            <i class="icofont icofont-email"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Customer Email ID <span class="req">*</span></label>
                                            <input type="text" tabindex="-1"  name="customer[email_id]" class="form-control tabwid required" id="email_id" value="<?php echo $val['email_id']; ?>"/>
                                            <span class="form-bar"></span>
                                            <span class="error_msg text-danger"></span>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-location-pin"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Customer Address <span class="req">*</span></label>
                                            <textarea name="customer[address1]" tabindex="-1" class="form-control tabwid1 required" id="address1"><?php echo $val['address1']; ?></textarea>
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
                                            <input id="dropper-default" name="quotation[created_date]" tabindex="3" data-date="" data-month="" data-year="" class="form-control tabwid required" type="text" placeholder=""  value="<?php echo date('d-M-Y', strtotime($val['created_date'])); ?>"/>

                                            <span class="form-bar"></span>
                                            <span class="error_msg text-danger"></span>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-architecture-alt"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Project Name <span class="req">*</span></label>
                                            <input name="quotation[project_name]"  type="text" value="<?php echo $val['project_name']; ?>" class="form-control project_name"  tabindex="4" />
                                            <span class="form-bar"></span>
                                            <span class="error_msg text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-address-book"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Referred By</label>
                                            <input name="quotation[referred_by]"  type="text" class="form-control"  value="<?php echo $val['referred_by']; ?>" tabindex="4" />
                                            <span class="form-bar"></span>
                                            <!--<span class="error_msg text-danger"></span>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--                                <div class="col-md-3">
                                                                <label class="float-label">Advance Amount</label>
                                                                <input type="text" tabindex="1"  name="quotation[advance]" id="advance" class="form-control tabwid required" value="<?php echo $val['advance']; ?>"/>
                                                                <span class="error_msg text-danger"></span>
                                                            </div>-->
                            <div class="row card-block table-border-style">
                                <div class="table-responsive">
                                    <div class="action-btn-inner-table">
                                        <a id='add_group' class="btn btn-primary btn-mini waves-effect waves-light d-inline-block md-trigger"><i class="fa fa-plus"></i> Add Product</a>
                                        <a id='add_group_service' class="btn btn-primary btn-mini waves-effect waves-light d-inline-block md-trigger "><i class="fa fa-plus"></i> Add Service</a>
                                    </div>
                                    <table class="table table-striped table-bordered" id="add_quotation">
                                        <thead>
                                            <tr>
                                                <td width="10%" class="first_td1">Category</td>
                                                <td width="10%" class="first_td1">Brand</td>
                                                <td width="10%" class="first_td1">Model Number</td>
                                                <td width="10%" class="first_td1">Product Description</td>
                                                <td width="4%" class="first_td1">Product Img</td>
                                                <td width="5%" class="first_td1 hsn_td">HSN Code</td>
                                                <td width="5%" class="first_td1 add_amount_td">Add Amt</td>
                                                <td  width="3%" class="first_td1">QTY</td>
                                                <td  width="5%" class="first_td1">Unit Price</td>
                                                <td width="5%" class="first_td1 action-btn-align proimg-wid cgst_td">CGST %</td>
                                                <?php
                                                $gst_type = $quotation[0]['state_id'];
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
                                                <td width="1%" class="action-btn-align remove_nowrap">
                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody id='app_table'>
                                            <?php
                                            $cgst = 0;
                                            $sgst = 0;
                                            if (isset($quotation_details) && !empty($quotation_details)) {
                                                foreach ($quotation_details as $vals) {
                                                    $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);
                                                    $gst_type = $quotation[0]['state_id'];
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
                                                            <select id='' class='cat_id static_style class_req required form-control' tabindex="-1" name='categoty[]' >
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
                                                        <td >
                                                            <select name='brand[]' class="brand_id required brand form-control" tabindex="-1">
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
                                                            <input type="text"  name="model_no[]" id="model_no" class='form-control auto_customer tabwid <?php echo ($vals['type'] == 'product') ? 'model_no' : 'model_no_ser'; ?> required'   value="<?php echo $vals['model_no']; ?>"  tabindex="4"/>
                                                            <span class="error_msg text-danger"></span>
                                                            <input type="hidden"  name="product_id[]" id="product_id" class='product_id tabwid form-control' value="<?php echo $vals['product_id']; ?>" />
                                                            <input type="hidden"  name="type[]" id="type" class=' tabwid form-control type'value="<?php echo $vals['type']; ?>" />
                                                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                                                        </td>
                                                        <td>
                                                            <textarea  name="product_description[]" tabindex="-1" id="product_description" class='form-control auto_customer tabwid4 product_description' onkeyup='f2(this);' /><?php echo $vals['product_description']; ?></textarea>
                                                        </td>
                                                        <td class="action-btn-align">
                                                            <?php
                                                            if (!empty($vals['product_image'])) {
                                                                $file = FCPATH . 'attachement/product/' . $vals['product_image'];
                                                                $exists = file_exists($file);
                                                                $cust_image = (!empty($exists) && isset($exists)) ? $vals['product_image'] : "no-img.gif";
                                                            } else {
                                                                $cust_image = "no-img.gif";
                                                            }
                                                            ?>
                                                            <img id="blah" name="product_image[]" tabindex="-1" class="add_staff_thumbnail product_image img-50" src="<?= $this->config->item("base_url") ?>attachement/product/<?php echo $cust_image; ?>"/>

                                                        </td>
                                                        <td class="action-btn-align hsn_td">
                                                            <input type="text"  name="hsn_sac[]" id="hsn_sac" tabindex="-1" value="<?php echo $vals['hsn_sac']; ?>"  class='form-control hsn_sac ' />

                                                        </td>
                                                        <td class="action-btn-align add_amount_td">
                                                            <input type="text"  name="add_amount[]" id="add_amount" tabindex="-1" value="<?php echo $vals['add_amount']; ?>"  class='form-control add_amount right-align' />

                                                        </td>
                                                        <?php
                                                        if ($vals['type'] == 'product') {
                                                            if (isset($vals['stock']) && !empty($vals['stock'])) {
                                                                ?>
                                                                <td class="action-btn-align">
                                                                    <input type="text" tabindex="-1"  name='available_quantity[]' class="code form-control colournamedup tabwid form-control stock_qty cent-align" value="<?php echo $vals['stock'][0]['quantity'] ?>" readonly="readonly"/>
                                                                    <input type="text"  name='quantity[]' tabindex="5" class="qty form-control cent-align required" value="<?php echo $vals['quantity'] ?>" />
                                                                    <span class="error_msg"></span>
                                                                </td>
                                                            <?php } else { ?>
                                                                <td class="action-btn-align">
                                                                    <input type="text" tabindex="-1"  name='available_quantity[]' class="code form-control colournamedup tabwid form-control stock_qty cent-align" value="0" readonly="readonly"/>
                                                                    <input type="text"     name='quantity[]' tabindex="5" class="qty form-control required cent-align" value="<?php echo $vals['quantity'] ?>" />
                                                                    <span class="error_msg"></span>
                                                                </td>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                        <?php if ($vals['type'] == 'service') {
                                                            ?>
                                                            <td class="action-btn-align">
                                                                <input type="text"  name='quantity[]' tabindex="5" class="qty form-control required cent-align" value="<?php echo $vals['quantity'] ?>"/>
                                                                <span class="error_msg"></span>
                                                            </td>
                                                        <?php } ?>
                                                        <td class="action-btn-align">
                                                            <?php 
                                                                $is_gst = $quotation[0]['is_gst'];
                                                                $selling_price_actual = ($is_gst == 1 ? $vals['per_cost'] : ($vals['per_cost'] - $vals['add_amount']));
                                                            ?>
                                                            <input type="text"   tabindex="-1"  name='per_cost[]' class="selling_price percost required form-control right-align" value="<?php echo $vals['per_cost'] ?>"/>
                                                            <input type="hidden"  name='project_cost_per_cost[]' class="cost_price cp_percost form-control" value="<?php echo $vals['project_cost_per_cost'] ?>" id="costprice"/>
                                                            <input type="hidden" class="selling_price_actual" value="<?php echo $selling_price_actual; ?>" />
                                                            <span class="error_msg text-danger"></span>
                                                        </td>
                                                        <td class="cgst_td">
                                                            <input type="text" tabindex="-1"  name='tax[]' readonly="" class="pertax  form-control cent-align" value="<?php echo $vals['tax']; ?>" />
                                                        </td>
                                                        <?php
                                                        $gst_type = $quotation[0]['state_id'];
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
                                                            <input type="text" name='sub_total[]' tabindex="-1" readonly="readonly" class="subtotal text-right form-control" value="<?php echo $vals['sub_total'] ?>"/>
                                                            <input type="hidden" tabindex="-1" name='project_cost_sub_total[]' readonly="readonly" id="project_cost_sub_total " class="project_cost_subtotal form-control text-right" value="<?php echo $vals['project_cost_sub_total'] ?>" />

                                                        </td>
                                                <input type="hidden" value = "<?php echo $vals['del_id']; ?>" class="del_id"/>
                                                <td class="action-btn-align">
                                                    <a href="javascript:void(0);" class="green up order-icon" tabindex="-1"><i class="fa fa-long-arrow-up"></i></a> &nbsp;
                                                    <a class="red down order-icon" href="javascript:void(0);" tabindex="-1"><i class="fa fa-long-arrow-down"></i></a> &nbsp;
                                                    <a id='delete_group' class="del btn btn-danger btn-mini" tabindex="-1"><span class="fa fa-trash"></span></a>
                                                </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6" class="totbold" style=" text-align:right;">Total</td>
                                                <td class="action-btn-align "><input type="text" tabindex="-1"  name="quotation[total_qty]"   readonly="readonly" value="<?php echo $val['total_qty']; ?>" class="total_qty form-control cent-align" id="total" /></td>
                                                <td colspan="3" class="gst_add totbold" style="text-align:right;">Sub Total</td>
                                                <td class="remove_gst totbold" style="text-align:right;">Sub Total</td>
                                                <td class="action-btn-align"><input type="text" name="quotation[subtotal_qty]" tabindex="-1"  readonly="readonly" value="<?php echo$val['subtotal_qty']; ?>"  class="final_sub_total text-right form-control"/></td>
                                                <td></td>
                                            </tr>
                                        <input type="hidden" name="quotation[project_cost_subtotal_qty]" class="project_cost_final_sub_total text-right form-control " value="<?php echo$val['project_cost_subtotal_qty']; ?>">
                                        <tr>
                                            <td colspan="10" class="gst_add totbold" style="text-align:right;">Advance Amount</td>
                                            <td colspan="8" class="remove_gst totbold" style="text-align:right;">Advance Amount</td>
                                            <td><input type="text" name="quotation[advance]" tabindex="-1"  value="<?php echo (!empty($val['advance'])) ? $val['advance'] : 0; ?>"  class="advance text_right form-control"/></td>
                                            <td></td>
                                        </tr>
                                        <input type="hidden" name='quo_old_amount' class="old_adv_amt" value="<?php echo $val['advance']; ?>"/>
                                        <tr class="additional gst_add">
                                            <td colspan="7" class="totbold" style="text-align:right !important;">CGST:</td>
                                            <td colspan="2"><input tabindex="-1" type="text"  value="<?php echo $cgst; ?>"  readonly class="add_cgst text_right form-control"/></td>
                                            <?php
                                            $gst_type = $quotation[0]['state_id'];
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
                                            <td colspan="6" class="gst_add" style=" text-align:right;"></td>
                                            <td colspan="4" class="remove_gst" style=" text-align:right;"></td>
                                            <td colspan="4" style="text-align:right;font-weight:bold;"><input type="text"  tabindex="-1" name="quotation[tax_label]" class='tax_label text-right form-control' value="<?php echo $val['tax_label']; ?>"/></td>
                                            <td class="action-btn-align">
                                                <input type="text"  name="quotation[tax]" class='totaltax text-right form-control' tabindex="-1"  value="<?php echo $val['tax']; ?>"  />
                                            </td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="gst_add" style=" text-align:right;"></td>
                                            <td colspan="2" class="remove_gst" style=" text-align:right;"></td>
                                            <td colspan="5" id="in_words"></td>
                                            <td class="totbold" style="text-align:right;font-weight:bold;">Net Total</td>
                                            <td class="action-btn-align"><input type="text"  name="quotation[net_total]" tabindex="-1" readonly="readonly"   class="final_amt text-right form-control" value="<?php echo $val['net_total']; ?>" /></td>
                                            <td></td>
                                        </tr>
                                        <input type="hidden" name="quotation[project_cost_net_total]" class="form-control project_cost_final_amt text-right" value="<?php echo $val['project_cost_net_total']; ?>">
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 ">
                                    <h4 class="sub-title">TERMS AND CONDITIONS</h4>
                                    <div class="form-material  row m-t-10">
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-address-book"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Warranty</label>
                                                    <input type="text" tabindex="7" class="form-control class_req terms" name="quotation[warranty]" value="<?php echo $val['warranty']; ?>"/>
                                                    <span class="form-bar"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-bank"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Payment Terms</label>
                                                    <input type="text" tabindex="8" class="form-control class_req borderra0 terms" value="<?php echo $val['mode_of_payment']; ?>" name="quotation[mode_of_payment]" onkeyup='f2(this);'/>
                                                    <span class="form-bar"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-address-book"></i>
                                                </div>

                                                <div class="form-group form-primary">
                                                    <label class="float-label">Remarks</label>
                                                    <textarea name="quotation[remarks]" class="form-control remark" tabindex="9" > <?php echo $val['remarks']; ?> </textarea>
                                                    <span class="form-bar"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="material-group">
                                                <div class="material-addone">
                                                    <i class="icofont icofont-address-book"></i>
                                                </div>
                                                <div class="form-group form-primary">
                                                    <label class="float-label">Validity</label>
                                                    <input type="text" tabindex="10" class="form-control class_req borderra0 terms"  value="<?php echo $val['validity']; ?>" name="quotation[validity]" onkeyup='f2(this);' />
                                                    <input type="hidden"  name="quotation[job_id]" value="<?php echo $val['job_id']; ?> " >
                                                    <input type="hidden"  name="gst_type" id="gst_type" class="gst_type" value="<?php echo $quotation[0]['state_id']; ?>"/>
                                                    <input type="hidden"  name="quotation[customer]" id="customer_id" class='id_customer' value="<?php echo $val['customer']; ?>"/>
                                                    <span class="form-bar"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row m-10">
                                <div class="col-md-12 text-center">
                                    <?php if ($val['estatus'] == 2) { ?>
                                        <a href="<?php echo $this->config->item('base_url') . 'quotation/quotation_list/' ?>" class="btn btn-inverse btn-sm waves-effect waves-light" ><span class="glyphicon"></span> Back </a>
                                        <?php
                                    } else {
                                        ?>
                                        <button class="btn btn-primary btn-sm waves-effect waves-light " tabindex="11" id="save" onclick="javascript: form.action = '<?php echo $this->config->item('base_url'); ?>quotation/update_quotation/<?php echo $val['id']; ?>';" > Update </button>
                                        <button class="btn btn-success btn-sm waves-effect waves-light complete" tabindex="12" id="complete_btn" onclick="javascript: form.action = '<?php echo $this->config->item('base_url') . 'quotation/change_status/' . $quotation[0]['id'] . '/2' ?>';"  > Complete </button>
                                        <!--<a href="<?php echo $this->config->item('base_url') . 'quotation/change_status/' . $quotation[0]['id'] . '/2' ?>" class="btn btn-success btn-sm waves-effect waves-light complete" id="complete_btn" tabindex="1" > Complete </a>-->
                                        <a href="<?php echo $this->config->item('base_url') . 'quotation/quotation_list/' ?>" class="btn btn-inverse btn-sm waves-effect waves-light" ><span class="glyphicon"></span> Back </a>
                                    </div>
                                </div>
                            </form>
                            <?php
                        }
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
    $('#save, #complete_btn').live('click', function () {
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
            var tr = $('#app_table tr').length;
            if (tr > 1)
            {
                tr_model_no = $(this).closest('tr td').find('input.model_no').val();
                if (tr_model_no == '') {
                    $(this).closest('tr').remove();
                }
            }
//            $('.qty').each(function () {
//                var stock_qty = $(this).closest('tr').find('.stock_qty').val();
//                this_val = $.trim($(this).val());
//                if (this_val != "") {
//                    if (Number(this_val) > Number(stock_qty))
//                    {
//                        $(this).closest('td').find('.error_msg').text('Qty exceeds Stock').css('display', 'inline-block');
//                        m = 1;
//                    } else {
//                        $(this).closest('td').find('.error_msg').text("");
//                    }
//                }
//            });
        });
        project_name = $(".project_name").val();
        if (project_name == "") {
            $(".project_name").closest('div .form-group').find('.error_msg').text('This field is required').css('display', 'inline-block');
            m++;
        } else {
            $(".project_name").closest('div .form-group').find('.error_msg').text('');
        }
        if (m > 0)
            return false;
        //$("#quotation").submit();

    });
//    $('.qty').live('keyup', function () {
//        var pro_qty = $(this).val();
//        var stock_qty = $(this).closest('tr').find('.stock_qty').val();
//        if (Number(pro_qty) > Number(stock_qty))
//        {
//            $(this).closest('td').find('.error_msg').text('Qty exceeds Stock').css('display', 'inline-block');
//        } else {
//            $(this).closest('td').find('.error_msg').text("");
//        }
//    });
    $('#add_quotation').on('click', '.up', function () {
        var thisRow = $(this).closest('tr');
        var prevRow = thisRow.prev();
        if (prevRow.length) {
            prevRow.before(thisRow);
        }
    });
    $('#add_quotation').on('click', '.down', function () {
        var thisRow = $(this).closest('tr');
        var nextRow = thisRow.next();
        if (nextRow.length) {
            nextRow.after(thisRow);
        }
    });
    $(document).ready(function () {
        // var $elem = $('#scroll');
        //  window.csb = $elem.customScrollBar();
        $(".advance").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
                    // Allow: Ctrl+A, Command+A
                            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                            // Allow: home, end, left, right, down, up
                                    (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                        e.preventDefault();
                    }
                });
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
            $('.hsn_td').hide();
            $('.add_amount_td').show();
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
//    $('.cust_class').live('click', function () {
//        $("#customer_id").val($(this).attr('cust_id'));
//        $("#cust_id").val($(this).attr('cust_id'));
//        $("#customer_name").val($(this).attr('cust_name'));
//        $("#customer_no").val($(this).attr('cust_no'));
//        $("#email_id").val($(this).attr('cust_email'));
//        $("#address1").val($(this).attr('cust_address'));
//    });
    var gst_ref = 'G';
    var quo_number = $('#quotation_number').val();
    var split_val = quo_number.split("/");
    var split_gst = quo_number.split("-");
    var split_g = split_val[0].split("-");

    $(document).ready(function () {

        if ($('.grand_gst').is(':checked') && (split_gst.length < 3)) {
            final_id = split_val[0] + '-' + gst_ref + '/' + split_val[1] + '/' + split_val[2] + '/' + split_val[3];
            $('#quotation_number').val(final_id);
        } else {
            final_id = split_val[0] + '/' + split_val[1] + '/' + split_val[2] + '/' + split_val[3];
            $('#quotation_number').val(final_id);
        }
        $('.grand_gst').click(function () {
            if ($(this).prop('checked') == true && (split_gst.length < 3)) {
                final_id = split_val[0] + '-' + gst_ref + '/' + split_val[1] + '/' + split_val[2] + '/' + split_val[3];
                $('#quotation_number').val(final_id);
            } else if ($(this).prop('checked') == true && (split_gst.length > 2)) {
                $('#quotation_number').val(quo_number);
            } else {
                if (split_g[1] == 'G') {
                    final_id = split_g[0] + '/' + split_val[1] + '/' + split_val[2] + '/' + split_val[3];
                    $('#quotation_number').val(final_id);
                } else {
                    final_id = split_val[0] + '/' + split_val[1] + '/' + split_val[2] + '/' + split_val[3];
                    $('#quotation_number').val(final_id);
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
                        url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_customer/",
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
    $('#add_group_service').click(function () {
        var tableBody = $(".static_ser").find('tr').clone();
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
    $('.pertax,.totaltax,.percost').live('keyup', function () {
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
                    var actual_cost = $(this).closest('tr').find('.selling_price_actual').val();
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

                    var actual_cost = $(this).closest('tr').find('.selling_price_actual').val();
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
        var cp_final_sub_total = 0;
        $('.qty').each(function () {
            var qty = $(this);
            var percost = $(this).closest('tr').find('.cp_percost');
            var project_cost_subtotal = $(this).closest('tr').find('.project_cost_subtotal');

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
                project_cost_subtotal.val(sub_total.toFixed(2));
                cp_final_sub_total = cp_final_sub_total + sub_total;
            }

        });
        $('.project_cost_final_sub_total').val(cp_final_sub_total.toFixed(2));
        $('.project_cost_final_amt').val((cp_final_sub_total + total_item).toFixed(2));
    }
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
    });</script>
<script>
    $(document).ready(function () {
        $('body').on('keydown', 'input.model_no', function (e) {
            var product_data = {};
            //console.log('wahidh');
            product_data.results = [<?php echo implode(',', $model_numbers_json); ?>];
            //console.log(product_data.results);
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
                        this_val.closest('tr').find('.selling_price').val('');
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
//                                this_val.closest('tr').find('.pertax').val(result[0].cgst);
//                                this_val.closest('tr').find('.gst').val(result[0].sgst);
                                    this_val.closest('tr').find('.discount').val(result[0].discount);
                                    this_val.closest('tr').find('.selling_price').attr('value', (result[0].selling_price));
                                    this_val.closest('tr').find('.selling_price_actual').attr('value', (result[0].selling_price));
                                    this_val.closest('tr').find('.cost_price').val(parseInt(result[0].cost_price) + parseInt(result[0].po_add_amount));
                                    this_val.closest('tr').find('.type').val(result[0].type);
                                    this_val.closest('tr').find('.product_id').val(result[0].id);
                                    this_val.closest('tr').find('.hsn_sac').val(result[0].hsn_sac);
                                    this_val.closest('tr').find('.add_amount').attr('value', result[0].add_amount);
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
        $('body').on('keydown', 'input.model_no_ser', function (e) {
            var product_data = [<?php echo implode(',', $model_numbers_json1); ?>];
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
//                                this_val.closest('tr').find('.pertax').val(result[0].cgst);
//                                this_val.closest('tr').find('.gst').val(result[0].sgst);
                                this_val.closest('tr').find('.discount').val(result[0].discount);
                                this_val.closest('tr').find('.selling_price').attr('value', (result[0].selling_price));
                                this_val.closest('tr').find('.selling_price_actual').attr('value', (result[0].selling_price));
                                this_val.closest('tr').find('.cost_price').val(parseInt(result[0].cost_price) + parseInt(result[0].po_add_amount));
                                this_val.closest('tr').find('.type').val(result[0].type);
                                this_val.closest('tr').find('.product_id').val(result[0].id);
                                this_val.closest('tr').find('.hsn_sac').val(result[0].hsn_sac);
                                this_val.closest('tr').find('.add_amount').attr('value', result[0].add_amount);
                                // this_val.closest('tr').find('.model_no').val(result[0].product_name);
                                this_val.closest('tr').find('.model_no_ser').val(result[0].model_no);
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
            });
        });
    });
//    $("#model_no").live('keyup', function () {
//        var this_ = $(this)
//        $.ajax({
//            type: "GET",
//            url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_product",
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
//            url: "<?php echo $this->config->item('base_url'); ?>" + "quotation/get_service",
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
    $('.pro_class').live('click', function () {
        $(this).closest('tr').find('.brand').val($(this).attr('pro_brand'));
        $(this).closest('tr').find('.cat_id').val($(this).attr('pro_cat'));
        $(this).closest('tr').find('.selling_price').val($(this).attr('pro_sell'));
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
        $(this).closest('tr').find('.selling_price').val($(this).attr('ser_sell'));
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