<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-my-1.10.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<style>
    #add_group, #add_group_service {
        color: #fff;
    }
    #delete_group, #add_label, #delete_label {
        color: #fff;
    }
    .green {
        color: green;
    }
    .red {
        color: red;
    }
    .sub-title {
        margin-bottom: 0px;
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
                <h5>Add Project Cost</h5>
                <div style="float:right;" onClick="dcl(this)">
                    <label class="togswitch">
                        <input type="checkbox" class="grand_gst" >
                        <span class="togslider round"></span>
                    </label>
                    <span class="gst_check_err text-danger"></span>
                </div>
            </div>
            <div class="card-block">
                <table class="static1" style="display: none;">
                    <tr>
                        <td colspan="3" class="remove_gst" style=" text-align:right;"></td>
                        <td colspan="5" class="gst_add"  style=" text-align:right;"></td>
                        <td colspan="4" style="text-align:right;font-weight:bold;"><input type="text" tabindex="-1" name="item_name[]" class="tax_label form-control text-right"></td>
                        <td>
                            <input type="text" tabindex="-1"  name="amount[]" class="totaltax form-control text-right"  style="width:100%;" >
                            <input type="hidden" name="type[]" class="text-right"  value="invoice" >
                        </td>
                        <td width="2%" class="action-btn-align"><a id='delete_label' class="del btn btn-danger btn-mini"><span class="fa fa-trash"></span></a></td>
                    </tr>
                </table>
                <table class="static" style="display: none;">
                    <tr>
                        <td>
                            <select id="" class="cat_id static_style form-control class_req" tabindex="-1" name="categoty[]">
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
                            <select name='brand[]' class="brand form-control " tabindex="-1" >
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
                            <input type="text"  name="model_no[]" id="model_no" class='form-control auto_customer tabwid model_no' tabindex=""  />
                            <span class="error_msg"></span>
                            <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-control product_id' />
                            <input type="hidden"  name="type[]" id="type" class=' tabwid form-control type' />
                            <input type="hidden"  name="product_type[]" id="type" class=' tabwid form-control type' />
                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                        </td>
                        <td>
                            <textarea  name="product_description[]" tabindex="-1"  id="product_description" class='form-control auto_customer tabwid product_description' onkeyup='f2(this);'/>  </textarea>
                        </td>
                        <td class="action-btn-align hsn_td">
                            <input type="text"  name="hsn_sac[]" id="hsn_sac" class='form-control hsn_sac' tabindex="-1"  />
                        </td>
                        <td class="action-btn-align add_amount_td">
                            <input type="text"  name="add_amount[]" id="add_amount" tabindex="-1"  class='form-control add_amount right-align' />

                        </td>

                        <td>
                            <input type="text"   tabindex="-1"  name='available_quantity[]' class="code form-control tabwid stock_qty cent-align" value="0" readonly="readonly"/>
                            <input type="text"   tabindex="-1"  name='quantity[]' class="qty form-control cent-align" id="qty" onkeypress="return isNumber(event, this)"/>

                            <span class="error_msg"></span>
                        </td>
                        <td>
                            <input type="text"   tabindex="-1"  name='per_cost[]' class="sell_price percost form-control right-align" id="price"/>
                            <input type="hidden" class="selling_price_actual" />
                            <span class="error_msg"></span>
                        </td>
                        <td class="action-btn-align tax_td">
                            <input type="text" tabindex="-1" name='tax[]' readonly="" class="pertax  form-control cent-align" />
                        </td>
                        <td class="action-btn-align sgst_td">
                            <input type="text"  tabindex="-1"  name='gst[]' readonly="" class="gst  form-control cent-align" />
                        </td>
                        <td class="action-btn-align igst_td">
                            <input type="text" tabindex="-1" name='igst[]' readonly="" class="igst wid50  form-control cent-align"  />
                        </td>
                        <td>
                            <input type="text" tabindex="-1" name='sub_total[]' readonly="readonly" id="sub_toatl" class="subtotal form-control text-right" />
                        </td>
                        <td class="action-btn-align"><a id='delete_group' tabindex="-1" class="del btn btn-danger btn-mini"><span class="fa fa-trash"></span></a></td>
                    </tr>
                </table>
                <table class="static_ser" style="display: none;">
                    <tr>
                        <td>
                            <select id="" class="cat_id static_style form-control class_req" name="categoty[]" tabindex="-1">
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
                            <select name="brand[]" class="brand form-control " tabindex="-1">
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
                            <input type="text"  name="model_no[]" id="model_no_ser" class='form-control auto_customer tabwid model_no_ser' tabindex="" />
                            <span class="error_msg"></span>
                            <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-control product_id' />
                            <input type="hidden"  name="product_type[]" id="type_ser" class=' tabwid form-control type_ser' />
                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                        </td>
                        <td>
                            <textarea tabindex="-1" name="product_description[]" id="product_description"   class='form-control auto_customer tabwid product_description' onkeyup='f2(this);'/>  </textarea>
                        </td>
                        <td class="action-btn-align hsn_td">
                            <input type="text"  name="hsn_sac[]" id="hsn_sac" class='form-control hsn_sac' tabindex="-1"  />
                        </td>
                        <td class="action-btn-align add_amount_td">
                            <input type="text"  name="add_amount[]" id="add_amount" tabindex="-1"  class='form-control add_amount right-align' />

                        </td>
                        <td>
                            <input type="hidden"    name='available_quantity[]'  value="0" readonly="readonly"/>
                            <input type="text"   tabindex="-1"  name='quantity[]' class="qty form-control cent-align" id="qty" onkeypress="return isNumber(event, this)"/>

                            <span class="error_msg"></span>
                        </td>
                        <td>
                            <input type="text"   tabindex="1"  name='per_cost[]' class="sell_price percost form-control right-align" id="price"/>
                            <input type="hidden" class="selling_price_actual" />
                            <span class="error_msg"></span>
                        </td>
                        <td class="action-btn-align tax_td">
                            <input type="text" tabindex="-1" name='tax[]' readonly="" class="pertax  form-control cent-align" />
                        </td>
                        <td class="action-btn-align sgst_td">
                            <input type="text"  tabindex="-1"  name='gst[]' readonly="" class="gst  form-control cent-align" />
                        </td>
                        <td class="action-btn-align igst_td">
                            <input type="text" tabindex="-1" name='igst[]' readonly="" class="igst wid50  form-control cent-align"  />
                        </td>
                        <td>
                            <input type="text" tabindex="-1" name='sub_total[]' readonly="readonly" id="sub_toatl" class="subtotal form-control text-right" />
                        </td>
                        <td class="action-btn-align"><a id='delete_group' class="del btn btn-danger btn-mini"><span class="fa fa-trash"></span></a></td>
                    </tr>
                </table>
                <form  action="<?php echo $this->config->item('base_url'); ?>service/paid_service_add" method="post" >
                    <input type="hidden" name="check_gst" id="gst_check_status_value">
                    <div class="form-material row">
                        <div class="col-md-3">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-user"></i>
                                </div>
                                <div class="form-group form-primary">

                                    <select id='ref_class'  tabindex="1"  class='nick static_style form-control class_req required' name='quotation[ref_name]'>
                                        <option value="">Select Contact Person</option>
                                        <?php
                                        if (isset($nick_name) && !empty($nick_name)) {
                                            foreach ($nick_name as $val) {
                                                ?>
                                                <option  value="<?php echo $val['id'] ?>"><?php echo $val['name'] ?>-<?php echo $val['nick_name'] ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <span class="error_msg"></span>
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
                                    <label class="float-label">Quotation NO</label>
                                    <input type="text"  tabindex="-1" name="quotation[q_no]" class="code form-control colournamedup tabwid form-control" readonly="readonly" value="<?php echo $gno; ?>"  id="grn_no">
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
                                    <label class="float-label">Company Name</label>
                                    <input type="hidden"  name="quotation[type]" value="indirect" />
                                    <input type="hidden"  name="quotation[job_id]"value="<?php echo $last_id; ?>"  />
                                    <input type="text"  name="customer[name]" id="customer_name" tabindex="2"  class='form-control auto_customer tabwid' />
                                    <span class="error_msg"></span>
                                    <input type="hidden"  name="customer[id]" id="customer_id" class='id_customer tabwid form-control' />
            <!--                              <input type="hidden"  name="quotation[product_id]" id="cust_id" class='id_customer' />-->
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
                                    <label class="float-label">Customer Mobile No</label>
                                    <input type="text"  name="customer[mobil_number]" tabindex="-1"  id="customer_no" class="form-control tabwid required" />
                                    <span class="error_msg"></span>
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
                                    <label class="float-label">Customer Email ID</label>
                                    <input type="text"  name="customer[email_id]" tabindex="-1" id="email_id" class="form-control tabwid required"/>
                                    <span class="error_msg"></span>
                                    <span class="form-bar"></span>
                                </div>
                            </div>
                        </div>
                        <!--                        <div class="col-md-3">
                                                    <div class="material-group">
                                                        <div class="material-addone">
                                                            <i class="icofont icofont-address-book"></i>
                                                        </div>
                                                        <div class="form-group form-primary">
                                                            <label class="float-label">GSTIN No</label>
                                                            <input type="text" name="company[tin_no]"  value="<?= $company_details[0]['tin_no'] ?>" class="form-control" readonly="readonly" />
                                                            <span class="form-bar"></span>
                                                        </div>
                                                    </div>
                                                </div>-->
                        <div class="col-md-3">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-location-pin"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <label class="float-label">Customer Address</label>
                                    <textarea name="customer[address1]" id="address1" tabindex="-1"  class="form-control tabwid3 required"></textarea>
                                    <span class="error_msg"></span>
                                    <span class="form-bar"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="material-group">
                                <div class="material-addone">
                                    <i class="icofont icofont-ui-calendar"></i>
                                </div>
                                <div class="form-group form-primary">
                                    <label class="float-label">Date</label>
                                    <input tabindex="3" id="dropper-default" name="quotation[created_date]" data-date="" data-month="" data-year="" value="<?php echo date('d-M-Y'); ?>" class="form-control required dropper-default" type="text" placeholder="" />
                                    <span class="error_msg"></span>
                                    <span class="form-bar"></span>
                                </div>
                            </div>
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
                                        <td width="5%" class="first_td1 hsn_td">HSN Code</td>
                                        <td width="5%" class="first_td1 add_amount_td">Add Amt</td>
                                        <td  width="8%" class="first_td1">QTY</td>
                                        <td  width="5%" class="first_td1">Unit Price</td>
                                        <td width="5%" class="first_td1 action-btn-align cgst_td ">CGST %</td>
                                        <td width="5%" class="first_td1 action-btn-align sgst_td ">SGST %</td>
                                        <td width="5%" class="first_td1 action-btn-align igst_td ">IGST %</td>
                                        <td  width="5%" class="first_td1">Net Value</td>
                                        <td width="5%" class="action-btn-align remove_nowrap">
                                            <a id='add_group' class="btn btn-primary btn-mini waves-effect waves-light d-inline-block md-trigger"><span class="fa fa-plus"></span> Add Product</a>
                                            <a id='add_group_service' class="btn btn-primary btn-mini waves-effect waves-light d-inline-block md-trigger m-t-5"><span class="fa fa-plus"></span> Add Service</a>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody id='app_table'>
                                    <tr>
                                        <td>
                                            <select id=''   class='cat_id form-control static_style class_req required' name='categoty[]' tabindex="-1">
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
                                            <select name='brand[]'  class="brand form-control required" tabindex="-1">
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
                                        <td>
                                            <input type="text"  name="model_no[]"  tabindex="4" id="model_no_ser" class='form-control auto_customer tabwid model_no_ser required' />
                                            <span class="error_msg"></span>
                                            <input type="hidden"  name="product_id[]" id="product_id" class=' tabwid form-control product_id' />
                                            <input type="hidden"  name="product_type[]" id="type_ser" class=' tabwid form-control type_ser' />
                                            <div id="suggesstion-box1" class="auto-asset-search suggesstion-box1"></div>
                                        </td>
                                        <td>
                                            <textarea  name="product_description[]" tabindex="-1"  id="product_description" class='form-control auto_customer tabwid product_description' onkeyup='f2(this);'/>  </textarea>
                                        </td>
                                        <td class="action-btn-align hsn_td">
                                            <input type="text"  name="hsn_sac[]" id="hsn_sac" class='form-control hsn_sac' tabindex="-1"  />
                                        </td>
                                        <td class="action-btn-align add_amount_td">
                                            <input type="text"  name="add_amount[]" id="add_amount" tabindex="-1"  class='form-control add_amount right-align' />

                                        </td>
                                        <td>
                                            <input type="hidden" name='available_quantity[]' class="form-control" value="0" />
                                            <input type="text"  name='quantity[]' class="qty form-control required cent-align" onkeypress="return isNumber(event, this)"/>

                                            <span class="error_msg"></span>
                                        </td>
                                        <td>
                                            <input type="text"   tabindex="-1"  name='per_cost[]'  class="sell_price form-control percost required right-align" />
                                            <input type="hidden" class="selling_price_actual" />
                                            <span class="error_msg"></span>
                                        </td>
                                        <td class="action-btn-align tax_td">
                                            <input type="text"  name='tax[]' tabindex="-1" readonly="readonly" class="pertax form-control cent-align" />
                                        </td>
                                        <td class="action-btn-align sgst_td">
                                            <input type="text"  name='gst[]' tabindex="-1" readonly="readonly" class="gst form-control cent-align" />
                                        </td>
                                        <td class="action-btn-align igst_td">
                                            <input type="text"  name='igst[]' tabindex="-1" readonly="readonly" class="igst wid50 form-control cent-align"  />
                                        </td>
                                        <td>
                                            <input type="text" tabindex="-1" name='sub_total[]' readonly="readonly" class="subtotal text-right form-control" />
                                        </td>
                                        <td><a id='delete_label' class="del btn btn-danger btn-mini"><span class="fa fa-trash"></span></a>

                                        </td>
                <!--                            <td class="action-btn-align"><a id='delete_group' class="btn btn-danger form-control"><span class="glyphicon glyphicon-trash"></span></a></td>-->
                                    </tr>
                                </tbody>
                                <tbody>
                                <td colspan="5" style=" text-align:right;">Total</td>
                                <td><input type="text"   name="quotation[total_qty]" tabindex="-1"  readonly="readonly" value="<?php echo $val['total_qty']; ?>" class="total_qty form-control cent-align" id="total" /></td>
                                <td colspan="3" class="gst_add totbold" style="text-align:right;">Sub Total</td>
                                <td class="remove_gst totbold" style="text-align:right;">Sub Total</td>
                                <td><input type="text" name="quotation[subtotal_qty]" tabindex="-1" readonly="readonly" value="<?php echo $val['subtotal_qty']; ?>"  class="final_sub_total form-control text-right" /></td>
                                <td></td>
                                </tbody>
                                <tbody class="additional gst_add" id="add_new_values">
                                <td colspan="5" style="text-align:right;"> </td>
                                <td style="text-align:right;" class="sgst_td totbold"> SGST </td>
                                <td style="text-align:right;" class="igst_td v"> IGST </td>
                                <td colspan="2"><input type="text" tabindex="-1" value=""  readonly class="add_sgst form-control text_right" /></td>
                                <td style="text-align:right;" class="totbold"> CGST </td>
                                <td><input type="text" tabindex="-1"  value=""  readonly class="add_cgst form-control text_right" /></td>
                                <td></td>
                                </tbody>
                                <tbody class="add_cost">
                                <td colspan="5" class="gst_add" style=" text-align:right;"></td>
                                <td colspan="3" class="remove_gst" style=" text-align:right;"></td>
                                <td colspan="4" style="text-align:right;font-weight:bold;">
                                    <input type="text"  name="quotation[tax_label]" class='tax_label form-control text-right'   tabindex="-1"  /></td>
                                <td>
                                    <input type="text"  name="quotation[tax]" class='totaltax form-control text-right'  tabindex="-1"   />
                                </td>
                                <td width="2%" class="action-btn-align"><a id='add_label' tabindex="-1" class="form-control btn btn-primary btn-mini waves-effect waves-light d-inline-block md-trigger"><span class="fa fa-plus"></span> Add </a></td>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="gst_add" style=" text-align:right;"></td>
                                        <td colspan="3" class="remove_gst" style=" text-align:right;"></td>
                                        <td colspan="4"style="text-align:right;font-weight:bold;">Net Total</td>
                                        <td><input type="text" tabindex="-1" name="quotation[net_total]"  readonly="readonly"  class="final_amt form-control text-right"  /></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 ">
                            <h4 class="sub-title">TERMS AND CONDITIONS</h4>
                            <div class="form-material row">
                                <!--                                <div class="col-md-3">
                                                                    <label class="float-label">Delivery Schedule</label>
                                                                    <input type="date" class="form-control class_req borderra0 terms" name="quotation[delivery_schedule]" placeholder="dd-mm-yyyy" >
                                                                    <span id="colorpoerror" style="color:#F00;" ></span>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="float-label">Notification Date</label>
                                                                    <input type="date"  id='to_date' class="form-control borderra0 terms" name="quotation[notification_date]" placeholder="dd-mm-yyyy" >
                                                                </div>-->
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-address-book"></i>
                                        </div>

                                        <div class="form-group form-primary">
                                            <label class="float-label">Remarks</label>
                                            <input name="quotation[remarks]" type="text" class="form-control remark" />
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
                                            <label class="float-label">Mode of Payment</label>
                                            <input type="text"  class="form-control class_req borderra0 terms" name="quotation[mode_of_payment]" onkeyup='f2(this);'/>
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
                                            <input type="text"  class="form-control class_req borderra0 terms" name="quotation[validity ]" onkeyup='f2(this);'/>
                                            <span class="form-bar"></span>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden"  name="quotation[customer]" id="c_id" class='id_customer' />
                                <input type="hidden"  name="gst_type" id="gst_type" class="gst_type" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group row m-10">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary btn-sm waves-effect waves-light" id="save"  > Create</button>
                            <a href="<?php echo $this->config->item('base_url') . 'service/service_list' ?>" class="btn btn-inverse btn-sm waves-effect waves-light"><span class="glyphicon"></span> Back </a>
                        </div>
                    </div>
                </form>
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
        maxYear: new Date().getFullYear() + 50,
        format: 'd-M-Y'
    });
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
            var tr = $('#app_table tr').length;
            if (tr > 1)
            {
                tr_model_no = $(this).closest('tr td').find('input.model_no').val();
                if (tr_model_no == '') {
                    $(this).closest('tr').remove();
                }
            }
        });
        $('.qty').each(function () {
            var stock_qty = $(this).closest('tr').find('.stock_qty').val();
            this_val = $.trim($(this).val());
            if (this_val != "") {
                if (Number(this_val) > Number(stock_qty))
                {
                    $(this).closest('td').find('.error_msg').text('Qty exceeds Stock').css('display', 'inline-block');
                    m = 1;
                } else {
                    $(this).closest('td').find('.error_msg').text("");
                }
            }
        });
//        $('#add_quotation .qty').each(function () {
//            var qty = $(this).closest('tr').find('.stock_qty').val();
//            this_val = $.trim($(this).val());
//            if (Number(this_val) < Number(qty))
//            {
//                $(this).closest('td').find('.error_msg').text('Invalid quantity').css('display', 'inline-block');
//                m++;
//            } else {
//                $(this).closest('td').find('.error_msg').text("");
//            }
//        });

        if (m > 0)
            return false;

    });
    $('.qty').live('keyup', function () {
        var pro_qty = $(this).val();
        var stock_qty = $(this).closest('tr').find('.stock_qty').val();
        if (Number(pro_qty) > Number(stock_qty))
        {
            $(this).closest('td').find('.error_msg').text('Qty exceeds Stock').css('display', 'inline-block');
        } else {
            $(this).closest('td').find('.error_msg').text("");
        }
    });
    $(document).ready(function () {
        if ($('#gst_type').val() == '')
        {
            $('#add_quotation').find('tr td.igst_td').hide();
            $('#add_new_values').find('tr td.igst_td').hide();
        }
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
                                $("#gst_type").val(result[0].state_id);
                                $("#address1").val(result[0].address1);
                                $("#tin").val(result[0].tin);
                                $('.grand_gst').click(function () {
                                    if ($(this).prop('checked') == true) {
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
                                    }
                                });
                            }
                        }
                    });
                }
            });
        });
    });
//    $(document).ready(function () {
//        // var $elem = $('#scroll');
//        //  window.csb = $elem.customScrollBar();
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
    $('#add_label').click(function () {
        var tables = $(".static1").find('tr').clone();
        $(tables).closest('tr').find('select,.model_no,.model_no_ser,.percost,.qty').addClass('required');
        $('.add_cost').append(tables);
        calculate_function();

    });
    $('#delete_label').live('click', function () {
        $(this).closest("tr").remove();
        calculate_function();
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
        } else {

            $('.qty').each(function () {
                var qty = $(this);
                var percost = $(this).closest('tr').find('.percost');
                var pertax = $(this).closest('tr').find('.pertax');
                var subtotal = $(this).closest('tr').find('.subtotal');

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
                        this_val.closest('tr').find('.sell_price').val('');
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
//                                    this_val.closest('tr').find('.pertax').val(result[0].cgst);
//                                    this_val.closest('tr').find('.gst').val(result[0].sgst);
                                    this_val.closest('tr').find('.discount').val(result[0].discount);
                                    this_val.closest('tr').find('.hsn_sac').val(result[0].hsn_sac);
                                    this_val.closest('tr').find('.add_amount').val(result[0].add_amount);
                                    this_val.closest('tr').find('.sell_price').attr('value', (result[0].cost_price));
                                    this_val.closest('tr').find('.selling_price_actual').attr('value', (result[0].cost_price));
                                    this_val.closest('tr').find('.type').val(result[0].type);
                                    this_val.closest('tr').find('.product_id').val(result[0].id);
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
                        url: "<?php echo $this->config->item('base_url'); ?>" + "service/get_service/",
                        success: function (data) {
                            console.log(data);
                            result = JSON.parse(data);
                            if (result != null && result.length > 0) {
                                //alert(result[0].quantity);
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
                                this_val.closest('tr').find('.sell_price').attr('value', (result[0].cost_price));
                                this_val.closest('tr').find('.selling_price_actual').attr('value', (result[0].cost_price));
                                this_val.closest('tr').find('.type_ser').val(result[0].type);
                                this_val.closest('tr').find('.hsn_sac').val(result[0].hsn_sac);
                                this_val.closest('tr').find('.add_amount').val(result[0].add_amount);
                                this_val.closest('tr').find('.product_id').val(result[0].id);
                                // this_val.closest('tr').find('.model_no').val(result[0].product_name);
                                this_val.closest('tr').find('.model_no_ser').val(result[0].model_no);
                                this_val.closest('tr').find('.product_description').val(result[0].product_description);
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

//    $(".model_no").live('keyup', function () {
//        var this_ = $(this)
//        $.ajax({
//            type: "GET",
//            url: "<?php echo $this->config->item('base_url'); ?>" + "service/get_product",
//            data: 'q=' + $(this).val(),
//            success: function (datas) {
//                this_.closest('tr').find(".suggesstion-box1").show();
//                this_.closest('tr').find(".suggesstion-box1").html(datas);
//
//            }
//        });
//    });
//    $("#model_no_ser").live('keyup', function () {
//        var this_ = $(this)
//        $.ajax({
//            type: "GET",
//            url: "<?php echo $this->config->item('base_url'); ?>" + "service/get_service",
//            data: 's=' + $(this).val(),
//            success: function (datas) {
//                this_.closest('tr').find(".suggesstion-box1").show();
//                this_.closest('tr').find(".suggesstion-box1").html(datas);
//
//            }
//        });
//    });
    $("#ref_class").live('change', function () {
        var nick = $("#ref_class option:selected").text().split("-");
        var increment_id = $('#grn_no').val().split("/");
        final_id = increment_id[0] + '/' + nick[1] + '/' + increment_id[2] + '/' + increment_id[3];
        $('#grn_no').val(final_id);
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
            $('.sgst_td ').css('display', 'table-cell');
            $('.cgst_td ').css('display', 'table-cell');
            $('.igst_td ').css('display', 'none');
            $('#add_quotation').find('tr td.sgst_td').show();
            $('#add_quotation').find('tr td.igst_td').hide();
            $('#add_quotation').find('tr td.tax_td').show();
            $('.gst_add').show();
            $('.remove_gst').hide();
            $('#gst_check_status_value').val('on');
            $('.hsn_td').show();
            $('.add_amount_td').hide();
        } else {
            $('.sgst_td ').css('display', 'none');
            $('.igst_td ').css('display', 'none');
            $('.cgst_td ').css('display', 'none');
            $('#add_quotation').find('tr td.sgst_td').hide();
            $('#add_quotation').find('tr td.igst_td').hide();
            $('#add_quotation').find('tr td.tax_td').hide();
            $('.gst_add').hide();
            $('.remove_gst').show();
            $('.hsn_td').hide();
            $('.add_amount_td').show();
            $('#gst_check_status_value').val('');
        }
        $('body').click(function () {
            $(this).closest('tr').find(".suggesstion-box1").hide();
        });
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
                        $('#add_quotation').find('tr td.tax_td').show();
                        $('.gst_add').show();
                        $('.remove_gst').hide();
                    } else {
                        $('.igst_td ').css('display', 'table-cell');
                        $('.cgst_td ').css('display', 'table-cell');
                        $('.sgst_td ').css('display', 'none');

                        $('#add_quotation').find('tr td.sgst_td').hide();
                        $('#add_quotation').find('tr td.igst_td').show();
                        $('#add_quotation').find('tr td.tax_td').show();
                        $('.gst_add').show();
                        $('.remove_gst').hide();
                    }
                } else {
                    $('.sgst_td ').css('display', 'none');
                    $('.igst_td ').css('display', 'none');
                    $('.cgst_td ').css('display', 'none');

                    $('#add_quotation').find('tr td.sgst_td').hide();
                    $('#add_quotation').find('tr td.igst_td').hide();
                    $('#add_quotation').find('tr td.tax_td').hide();
                    $('.gst_add').hide();
                    $('.remove_gst').show();
                }
                calculate_function();
                $('#gst_check_status_value').val('on');
            } else {
                add_amount();
                $('.sgst_td ').css('display', 'none');
                $('.igst_td ').css('display', 'none');
                $('.cgst_td ').css('display', 'none');
                $('#add_quotation').find('tr td.sgst_td').hide();
                $('#add_quotation').find('tr td.igst_td').hide();
                $('#add_quotation').find('tr td.tax_td').hide();
                $('.gst_add').hide();
                $('.remove_gst').show();
                $('.hsn_td').hide();
                $('.add_amount_td').show();
                calculate_function();
                $('#gst_check_status_value').val('');
            }
        });
    });
    $('.pro_class').live('click', function () {
        $(this).closest('tr').find('.brand').val($(this).attr('pro_brand'));
        $(this).closest('tr').find('.cat_id').val($(this).attr('pro_cat'));
        $(this).closest('tr').find('.sell_price').val($(this).attr('pro_cost'));
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
        $(this).closest('tr').find('.sell_price').val($(this).attr('ser_cost'));
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
