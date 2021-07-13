<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-my-1.10.3.min.js"></script>
<style type="text/css">
    .tabth {
        color: #448aff !important;
    }
    .termcolor {
        color: #222d33 !important;
    }
</style>

<div class="card">
    <?php
    $data["admin"] = $this->admin_model->get_admin($user_info[0]['role'], $user_info[0]['id']);
    $data['company_details'] = $this->admin_model->get_company_details();
    ?>
    <div class="print_header print-align ml-95" style="display:none">
        <div class="print_header_logo " >
            <img class="img-fluid" src="<?= $theme_path; ?>/assets/images/printlogo.png" alt="Theme-Logo" style="width:200px;"/>
        </div>
        <div class="print_header_tit" >
            <h3><?= $data['company_details'][0]['company_name'] ?></h3>
            <?= $data['company_details'][0]['address1'] ?>,
            <?= $data['company_details'][0]['address2'] ?>,
            <?= $data['company_details'][0]['city'] ?>,
            <?= $data['company_details'][0]['state'] ?>
            <?= $data['company_details'][0]['pin'] ?>-<br/>

            <strong>Ph</strong>:
            <?= $data['company_details'][0]['phone_no'] ?>, <strong>Email</strong>:
            <?= $data['company_details'][0]['email'] ?><br/>
            <?php if ($quotation[0]['is_gst'] == 1) { ?>
                <strong>GSTIN NO</strong>:<?= $data['company_details'][0]['tin_no'] ?>
            <?php } ?>

        </div>

    </div>

    <div class="print-line"></div>
    <div class="card-header">
        <h5>View Paid Service
        </h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive" id='result_div'>
            <?php
            if (isset($quotation) && !empty($quotation)) {
                foreach ($quotation as $val) {
                    ?>
                    <table  class="table table-striped table-bordered responsive dataTable no-footer dtr-inline tablecolor newtbl-bordr">
                        <tr>
                            <td class="text-left"><span  class="f-w-700">TO,</span><br/>
                                <div><b><?php echo $val['store_name']; ?></b></div>
                                <div><?php echo $val['address1']; ?> </div>
                                <div> <?php echo $val['mobil_number']; ?></div>
                                <div> <?php echo $val['email_id']; ?></div>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <div> <b>GTSIN NO:</b> <?php echo $val['tin']; ?></div>
                                <?php } ?>
                            </td>
                            <td COLSPAN=2  class="action-btn-align"> <img src="<?= $theme_path; ?>/assets/images/logo-1.png" alt="Chain Logo" width="260px"></td>
                        </tr>
                        <tr>
                            <td colspan="2" id="contact_text" class="text-left"><span  class="f-w-700">Contact Person : </span><?php echo $val['name']; ?></td>
                            <td colspan="2" id="contact_text1" style="display:none;"><span  class="f-w-700">Contact Person : </span><?php echo $val['name']; ?></td>
                            <td class="text-left"><span  class="f-w-700">Quotation NO: </span><?php echo $val['q_no']; ?></td>
                        </tr>
                        <tr style="display:none">
                    <!--  <td><span  class="tdhead">Customer Email ID:</span> <?php echo $val['email_id']; ?></td>-->
                            <td><span  class="f-w-700">GSTIN No:</span><?= $company_details[0]['tin_no'] ?></td>
                            <td></td>
                        </tr>
                    </table>
                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline m-t-5 newtbl-bordr" id="add_quotation">
                        <thead>
                            <tr>
                                <td  width="2%" class="first_td1 action-btn-align ser-wid">S.No</td>
                                <td width="10%" class="first_td1 hide_class">Category</td>
                                <td width="10%" class="first_td1 hide_class">Brand</td>
                                <td width="10%" class="first_td1 hide_class">Model No</td>
                                <td width="10%" class="first_td1 pro-wid">Product Description</td>
                                <td width="10%" class="first_td1 action-btn-align">Product Image</td>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td width="10%" class="first_td1">HSN Code</td>
                                <?php } else { ?>
                                    <td width="5%" class="first_td1 hide_class">Add Amt</td>
                                <?php } ?>
                                <td  width="2%" class="first_td1 action-btn-align ser-wid">QTY</td>
                                <td  width="5%" class="first_td1 action-btn-align ser-wid">Unit Price</td>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td width="2%" class="first_td1 action-btn-align proimg-wid">CGST%</td>
                                    <?php
                                    $gst_type = $quotation[0]['state_id'];
                                    if ($gst_type != '') {
                                        if ($gst_type == 31) {
                                            ?>
                                            <td  width="6%" class="first_td1 action-btn-align proimg-wid" >SGST%</td>
                                        <?php } else { ?>
                                            <td  width="2%" class="first_td1 action-btn-align proimg-wid" >IGST%</td>

                                            <?php
                                        }
                                    }
                                }
                                ?>
                                <td  width="5%" class="first_td1 action-btn-align qty-wid">Net Value</td>

                            </tr>
                        </thead>
                        <tbody id='app_table'>
                            <?php
                            $i = 1;
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
                                        <td class="action-btn-align">
                                            <?php echo $i; ?>
                                        </td>
                                        <td class="hide_class">
                                            <?php echo $vals['categoryName'] ?>
                                        </td>
                                        <td class="hide_class">
                                            <?php echo $vals['brands'] ?>
                                        </td>
                                        <td class="hide_class">
                                            <?php echo $vals['model_no'] ?>
                                        </td>
                                        <td class="remove_nowrap">
                                            <b><?php echo ($vals['product_name']) ? $vals['product_name'] : ''; ?></b>
                                            <?php echo str_replace($vals['product_name'], "", $vals['product_description']); ?>
                                        </td>
                                        <td class="action-btn-align">
                                            <?php
                                            if (!empty($vals['product_image'])) {
                                                $file = FCPATH . 'attachement/product/' . $vals['product_image'];
                                                $exists = file_exists($file);
                                                $product_image = (!empty($exists) && isset($exists)) ? $vals['product_image'] : "no-img.gif";
                                            } else {
                                                $product_image = "no-img.gif";
                                            }
                                            ?>
                                            <img id="blah" name="product_image[]" class="add_staff_thumbnail product_image" width="50px" height="50px" src="<?= $this->config->item("base_url") . 'attachement/product/' . $product_image; ?>"/>
                                        </td>
                                        <?php if ($val['is_gst'] == 1) { ?>
                                            <td class="">
                                                <?php echo $vals['hsn_sac'] ?>
                                            </td>
                                        <?php } else { ?>
                                            <td class="hide_class text-right">
                                                <?php echo $vals['add_amount'] ?>
                                            </td>
                                        <?php } ?>
                                        <td class="action-btn-align">
                                            <?php echo $vals['quantity'] ?>
                                        </td>
                                        <td class="text-right">
                                            <?php echo number_format($vals['per_cost'], 2); ?>
                                        </td>
                                        <?php if ($val['is_gst'] == 1) { ?>
                                            <td class="action-btn-align">
                                                <?php echo $vals['tax'] ?>
                                            </td>
                                            <?php
                                            $gst_type = $quotation[0]['state_id'];
                                            if ($gst_type != '') {
                                                if ($gst_type == 31) {
                                                    ?>
                                                    <td class="action-btn-align">
                                                        <?php echo $vals['gst']; ?>
                                                    </td>
                                                <?php } else { ?>
                                                    <td class="action-btn-align">
                                                        <?php echo $vals['igst']; ?>
                                                    </td>

                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                        <td class="text-right">
                                            <?php echo number_format($vals['sub_total'], 2) ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                        <?php if ($val['is_gst'] == 1) { ?>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td colspan="3" class="hide_class" style=" text-align:right;"></td>
                                    <td colspan="3" style=" text-align:right;">Total</td>
                                    <td class="action-btn-align"><?php echo $val['total_qty']; ?></td>
                                    <td colspan="3" style="text-align:right;">Sub Total</td>
                                    <td class="text-right"><?php echo number_format($val['subtotal_qty'], 2); ?></td>

                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="3" class="hide_class" style=" text-align:right;"></td>
                                    <td colspan="5" class="totbold" style="text-align:right !important;">CGST:</td>
                                    <td class="text-right"><?php echo number_format($cgst, 2, '.', ','); ?></td>
                                    <?php
                                    $gst_type = $quotation[0]['state_id'];
                                    if ($gst_type != '') {
                                        if ($gst_type == 31) {
                                            ?>
                                            <td class="totbold" style="text-align:right;">SGST:</td>
                                        <?php } else { ?>
                                            <td  class="totbold" style="text-align:right;">IGST:</td>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <td class="text-right"><?php echo number_format($sgst, 2, '.', ','); ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td colspan="3" class="hide_class" style=" text-align:right;"></td>
                                    <td colspan="7"  style="text-align:right;font-weight:bold;"><?php echo $val['tax_label']; ?> </td>
                                    <td class="text-right">
                                        <?php echo number_format($val['tax'], 2); ?>

                                </tr>
                                <?php
                                foreach ($val['other_cost'] as $key) {
                                    ?>
                                    <tr>
                                        <td colspan="4" class="hide_class" style="text-align:right;"></td>
                                        <td colspan="7" style="text-align:right;font-weight:bold;"><?php echo $key['item_name']; ?> </td>
                                        <td class="text-right">
                                            <?php echo number_format($key['amount'], 2); ?></td>

                                    </tr>
                                <?php }
                                ?>
                                <tr>
                                    <td class="hide_class"></td>
                                    <td align="left" colspan="4"> <span class="flt-left"><?php echo ucfirst($in_words); ?></span></td>
                                    <td colspan="2" class="hide_class" style=" text-align:right;"></td>
                                    <td colspan="4" style="text-align:right;font-weight:bold;">Net Total</td>
                                    <td class="text-right"><?php echo number_format($val['net_total'], 2); ?></td>

                                </tr>
                                <tr>
                                    <td class="remark-tbl-bottom"><span style="float:left;  top:12px;">Remarks&nbsp;&nbsp;&nbsp;</span> </td>
                                    <td colspan="11" style="">
                                        <?php echo $val['remarks']; ?>
                                    </td>
                                </tr>
                            </tfoot>
                        <?php } else { ?>
                            <tfoot>
                                <tr>
                                    <td class=""></td>
                                    <td colspan="4" class="hide_class" style=" text-align:right;"></td>
                                    <td colspan="2" class="totbold" style=" text-align:right;">Total</td>
                                    <td class="action-btn-align"><?php echo $val['total_qty']; ?></td>
                                    <td class="totbold" style="text-align:right;">Sub Total</td>
                                    <td class="text-right"><?php echo number_format($val['subtotal_qty'], 2); ?></td>

                                </tr>
                                <tr>
                                    <td class=""></td>
                                    <td colspan="4" class="hide_class" style=" text-align:right;"></td>
                                    <td colspan="4"  style="text-align:right;font-weight:bold;"><?php echo $val['tax_label']; ?> </td>
                                    <td class="text-right">
                                        <?php echo number_format($val['tax'], 2); ?>

                                </tr>
                                <?php
                                foreach ($val['other_cost'] as $key) {
                                    ?>
                                    <tr>
                                        <td class=""></td>
                                        <td colspan="4" class="hide_class" style="text-align:right;"></td>
                                        <td colspan="4" style="text-align:right;font-weight:bold;"><?php echo $key['item_name']; ?> </td>
                                        <td class="text-right">
                                            <?php echo number_format($key['amount'], 2); ?></td>

                                    </tr>
                                <?php }
                                ?>
                                <tr>

                                    <td align="left" colspan="5"> <span class="flt-left"><?php echo ucfirst($in_words); ?></span></td>
                                    <td colspan="3" class="hide_class" style="text-align:right;"></td>
                                    <td style="text-align:right;font-weight:bold;">Net Total</td>
                                    <td class="text-right"><?php echo number_format($val['net_total'], 2); ?></td>

                                </tr>
                                <tr>
                                    <td ><span style="float:left;  top:12px;">Remarks&nbsp;&nbsp;&nbsp;</span> </td>
                                    <td colspan="9" style="">
                                        <?php echo $val['remarks']; ?>
                                    </td>
                                </tr>
                            </tfoot>
                        <?php } ?>
                    </table>
                    <div class="row text-center m-10">
                        <div class="col-sm-12 invoice-btn-group hide_class text-center">
                            <button class="btn btn-round btn-primary print_btn btn-sm waves-effect waves-light"> Print</button>
                            <a href="<?php echo $this->config->item('base_url') . 'service/service_list/' ?>" class="btn btn-round btn-inverse btn-sm waves-effect waves-light"><span class="glyphicon"></span> Back </a>

                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</div>
<script>
    $('.print_btn').click(function () {
        window.print();
    });
</script>

