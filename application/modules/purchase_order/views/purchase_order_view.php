<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .tabth {

    }
    .tabth{width:110px;}
    .terms-bottom-tbl{border: 1px solid #dee2e6;}
    .terms-bottom-tbl tr{border: 1px solid #dee2e6;}
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
            <?php if ($po[0]['is_gst'] == 1) { ?>
                <strong>GSTIN NO</strong>:<?= $data['company_details'][0]['tin_no'] ?>
            <?php } ?>

        </div>

    </div>

    <div class="print-line"></div>
    <div class="card-header">
        <h5>View Purchase Order
        </h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive" id='result_div'>
            <?php
            if (isset($po) && !empty($po)) {
                foreach ($po as $val) {
                    ?>
                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline tablecolor" style="border:1px solid #dee2e6;">
                        <tr>
                            <?php if ($val['is_gst'] == 1) { ?>
                                <td width="63.5%" class="text-left"><span  class="f-w-700">TO,</span><br/>
                                    <div><b><?php echo $val['store_name']; ?></b></div>
                                    <div><?php echo $val['address1']; ?> </div>
                                    <div> <?php echo $val['mobil_number']; ?></div>
                                    <div> <?php echo $val['email_id']; ?></div>
                                    <?php if ($val['is_gst'] == 1) { ?>
                                        <div> <b>GTSIN NO:</b> <?php echo $val['tin']; ?></div>
                                    <?php } ?>
                                </td>
                            <?php } else { ?>
                                <td width="72%" class="text-left"><span  class="f-w-700">TO,</span><br/>
                                    <div><b><?php echo $val['store_name']; ?></b></div>
                                    <div><?php echo $val['address1']; ?> </div>
                                    <div> <?php echo $val['mobil_number']; ?></div>
                                    <div> <?php echo $val['email_id']; ?></div>
                                    <?php if ($val['is_gst'] == 1) { ?>
                                        <div> <b>GTSIN NO:</b> <?php echo $val['tin']; ?></div>
                                    <?php } ?>
                                </td>
                            <?php } ?>

                            <td class="action-btn-align" colspan="2"> <img src="<?= $theme_path; ?>/assets/images/logo-1.png" alt="Chain Logo" width="200px"></td>
                        </tr>
                        <tr>
                            <td id="contact_text" class="text-left"><span  class="f-w-700">Contact Person : </span><?php echo $val['name']; ?></td>
                            <td id="contact_text1" style="display:none;"><span  class="tdhead">Contact Person : </span><?php echo $val['name']; ?></td>
                            <td style="display:none"><span  class="f-w-700">GSTIN No : </span><?= $company_details[0]['tin_no'] ?></td>
                            <td class="text-left"><span  class="f-w-700"> Date : </span><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td>
                        </tr>
                    </table>

                    <table width="100%" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline m-t-5" id="add_quotation" style="border:1px solid #dee2e6;">
                        <thead>
                            <tr>
                                <td  width="1%" class="first_td1 action-btn-align ser-wid">S.No</td>
                                <td width="10%" class=" first_td1 hide_class">Category</td>
                                <td width="10%" class=" first_td1 hide_class">Brand</td>
                                <td width="15%" class="first_td1">Model No</td>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td width="34%" class="first_td1 pro-wid">Product Description</td>
                                <?php } else { ?>
                                    <td width="40%" class="first_td1 pro-wid">Product Description</td>
                                <?php } ?>

                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td width="5%" class="first_td1">HSN Code</td>
                                <?php } else { ?>
                                    <td width="5%" class="first_td1 hide_class">Add Amt</td>
                                <?php } ?>
                                <td  width="2%" class="first_td1 action-btn-align ser-wid">QTY</td>
                                <td  width="5%" class="first_td1 action-btn-align ser-wid">Unit Price</td>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td width="3%" class="first_td1 action-btn-align proimg-wid">CGST%</td>
                                    <?php
                                    $gst_type = $po[0]['state_id'];
                                    if ($gst_type != '') {
                                        if ($gst_type == 31) {
                                            ?>
                                            <td  width="3%" class="first_td1 action-btn-align proimg-wid" >SGST%</td>
                                        <?php } else { ?>
                                            <td  width="3%" class="first_td1 action-btn-align proimg-wid" >IGST%</td>

                                            <?php
                                        }
                                    }
                                }
                                ?>
                                <td  width="12%" class="first_td1 action-btn-align qty-wid">Net Value</td>

                            </tr>
                        </thead>
                        <tbody id='app_table'>
                            <?php
                            $i = 1;
                            if (isset($po_details) && !empty($po_details)) {
                                foreach ($po_details as $vals) {
                                    $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['quantity']);

                                    $gst_type = $po[0]['state_id'];
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
                                        <td width="1%" class="action-btn-align">
                                            <?php echo $i; ?>
                                        </td>
                                        <td width="10%" class="hide_class">
                                            <?php echo $vals['categoryName'] ?>
                                        </td>
                                        <td width="10%" class="hide_class">
                                            <?php echo $vals['brands'] ?>
                                        </td>
                                        <td width="15%" align="center" >
                                            <?php echo $vals['model_no'] ?>
                                        </td>
                                        <?php if ($val['is_gst'] == 1) { ?>
                                            <td width="34%" class="remove_nowrap">
                                                <b><?php echo ($vals['product_name']) ? $vals['product_name'] : ''; ?></b>
                                                <?php echo str_replace($vals['product_name'], "", $vals['product_description']); ?>
                                            </td>
                                        <?php } else { ?>
                                            <td width="40%" class="remove_nowrap">
                                                <b><?php echo ($vals['product_name']) ? $vals['product_name'] : ''; ?></b>
                                                <?php echo str_replace($vals['product_name'], "", $vals['product_description']); ?>
                                            </td>
                                        <?php } ?>

                                        <?php if ($val['is_gst'] == 1) { ?>
                                            <td width="5%" class="" align="center">
                                                <?php echo $vals['hsn_sac'] ?>
                                            </td>
                                        <?php } else { ?>
                                            <td width="5%" class="hide_class text-right">
                                                <?php echo $vals['add_amount'] ?>
                                            </td>
                                        <?php } ?>
                                        <td width="2%" class="action-btn-align">
                                            <?php echo $vals['quantity'] ?>
                                        </td>
                                        <td width="5%" class="text-right">
                                            <?php echo number_format($vals['per_cost'], 2); ?>
                                        </td>
                                        <?php if ($val['is_gst'] == 1) { ?>
                                            <td width="3%" class="action-btn-align">
                                                <?php echo $vals['tax'] ?>
                                            </td>
                                            <?php
                                            $gst_type = $po[0]['state_id'];
                                            if ($gst_type != '') {
                                                if ($gst_type == 31) {
                                                    ?>
                                                    <td width="3%" class="action-btn-align">
                                                        <?php echo $vals['gst']; ?>
                                                    </td>
                                                <?php } else { ?>
                                                    <td width="3%" class="action-btn-align">
                                                        <?php echo $vals['igst']; ?>
                                                    </td>

                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                        <td width="12%" class="text-right">
                                            <?php echo number_format($vals['sub_total'], 2, '.', ',') ?>
                                        </td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td colspan="2" class="hide_class"></td>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td colspan="3" class="totbold" style=" text-align:right;">Total</td>
                                <?php } else { ?>
                                    <td class="hide_class"></td>
                                    <td colspan="2" class="totbold" style=" text-align:right;">Total</td>
                                <?php } ?>
                                <td class="action-btn-align"><?php echo $val['total_qty']; ?></td>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td colspan="3" class="gst_add totbold" style="text-align:right;">Sub Total</td>
                                <?php } else { ?>
                                    <td colspan=""class="totbold" style="text-align:right;">Sub Total</td>
                                <?php } ?>
                                <td class="text-right"><?php echo number_format($val['subtotal_qty'], 2, '.', ','); ?></td>

                            </tr>
                            <?php if ($val['is_gst'] == 1) { ?>
                                <tr>
                                    <td></td>
                                    <td colspan="2" class="hide_class"></td>
                                    <td colspan="4" class="totbold" style="text-align:right !important;">CGST</td>
                                    <td colspan="2" class="text-right"><?php echo number_format($cgst, 2, '.', ','); ?></td>
                                    <?php
                                    $gst_type = $po[0]['state_id'];
                                    if ($gst_type != '') {
                                        if ($gst_type == 31) {
                                            ?>
                                            <td class="totbold" style="text-align:right;">SGST</td>
                                        <?php } else { ?>
                                            <td class="totbold" style="text-align:right;">IGST</td>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <td class="text-right"><?php echo number_format($sgst, 2, '.', ','); ?></td>
                                </tr>
                            <?php } ?>
                            <tr><td></td>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td colspan="2" class="hide_class"></td>
                                    <td colspan="3" class=""></td>
                                <?php } else { ?>
                                    <td colspan="3" class="hide_class"></td>
                                <?php } ?>
                                <td colspan="4" style="text-align:right;font-weight:bold;"><?php echo $val['tax_label']; ?> </td>
                                <td class="text-right">
                                    <?php echo number_format($val['tax'], 2); ?>

                            </tr>
                            <tr>

                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td></td>
                                    <td colspan="2" class="hide_class"></td>
                                    <td colspan="6">  <?php echo ucfirst($in_words); ?></td>
                                <?php } else { ?>
                                    <td></td>
                                    <td colspan="3" class="hide_class"></td>
                                    <td colspan="3">  <?php echo ucfirst($in_words); ?></td>
                                <?php } ?>
                                <td style="text-align:right;font-weight:bold;">Net Total</td>
                                <td class="text-right net_bg"><?php echo number_format($val['net_total'], 2, '.', ','); ?></td>

                            </tr>
                        </tfoot>
                    </table>
                    <table style="width:100%;" class="table table-striped tablecolor m-t-5 terms-bottom-tbl ">
                        <tr>
                            <th class="tabth" colspan="2">TERMS AND CONDITIONS</th>
                        </tr>
                        <tr>
                            <th class="tabth remark-tbl-bottom">Remarks</th><th style="vertical-align:top;">:<span class="termcolor"> <?php echo $val['remarks']; ?></span></th>
                        </tr>
                        <tr>
                            <th class="tabth">Payment Terms</th><th>:<span class="termcolor"><?php echo $val['mode_of_payment']; ?></span>
                            </th>
                        </tr>

                    </table>
                    <div class="hide_class text-center m-t-5">
                        <a href="<?php echo $this->config->item('base_url') . 'purchase_order/purchase_order_list/' ?>"class="btn btn-inverse btn-sm waves-effect waves-light"> Back </a>
                        <button class="btn btn-primary print_btn btn-sm waves-effect waves-light"> Print</button>
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

