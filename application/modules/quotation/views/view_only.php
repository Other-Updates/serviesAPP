<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .text_left {
        text-align: left !important;
    }
</style>

<div class="enquiryview hisview">
    <?php
    //echo '<pre>';
    //print_r($quotation);
    if (isset($quotation) && !empty($quotation)) {
        foreach ($quotation as $val) {
            ?>
            <table  class="table table-striped table-bordered responsive dataTable no-footer dtr-inline tablecolor">
                <tr>
                    <td class="text_left"><span  class="f-w-700">TO,</span><br/>
                        <div><b><?php echo $val['store_name']; ?></b></div>
                        <div><?php echo $val['address1']; ?> </div>
                        <div> <?php echo $val['mobil_number']; ?></div>
                        <div> <?php echo $val['email_id']; ?></div>
                        <?php if ($val['is_gst'] == 1) { ?>
                            <div> <b>GTSIN NO:</b> <?php echo $val['tin']; ?></div>
                        <?php } ?>
                    </td>
                    <td COLSPAN=2 class="text-center"> <img src="<?= $theme_path; ?>/assets/images/logo-1.png" alt="Chain Logo" width="260px"></td>
                </tr>
                <tr>
                    <td class="text_left"><span  class="f-w-700">Quotation NO : </span><?php echo $val['q_no']; ?></td>
                    <td class="text_left"><span  class="f-w-700">Project Name : </span><?= $val['project_name'] ?></td>
                </tr>
                <tr>
                    <td class="text_left"><span  class="f-w-700">Contact Person : </span><?php echo $val['name']; ?></td>
                    <td class="text_left"><span  class="f-w-700">Date : </span><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td>
                </tr>

            </table>

            <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline m-t-5" id="add_quotation">
                <thead>
                    <tr>
                        <td width="2%" class="action-btn-align">S.No</td>
                        <td width="10%" class="hide_class first_td1">Category</td>
                        <td width="10%" class="hide_class first_td1">Brand</td>
                        <td width="10%" class="hide_class first_td1">Model No</td>
                        <?php if ($val['is_gst'] == 1) { ?>
                            <td width="10%" class="hide_class first_td1">HSN Code</td>
                        <?php } else { ?>
                            <td width="5%" class="hide_class first_td1">Add Amt</td>
                        <?php } ?>
                        <td width="20%" class="first_td1">Product Description</td>
                        <td width="10%" class="first_td1 action-btn-align">Product Image</td>
                        <td  width="8%" class="first_td1 action-btn-align">QTY</td>
                        <td  width="5%" class="first_td1 action-btn-align">Unit Price</td>
                        <?php if ($val['is_gst'] == 1) { ?>
                            <td width="6%" class="first_td1 action-btn-align proimg-wid">CGST%</td>
                            <?php
                            $gst_type = $quotation[0]['state_id'];
                            if ($gst_type != '') {
                                if ($gst_type == 31) {
                                    ?>
                                    <td  width="6%" class="first_td1 action-btn-align proimg-wid" >SGST%</td>
                                <?php } else { ?>
                                    <td  width="6%" class="first_td1 action-btn-align proimg-wid" >IGST%</td>

                                    <?php
                                }
                            }
                        }
                        ?>
                        <td  width="5%" class="action-btn-align first_td1">Net Value</td>
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
                                <td  class="hide_class">
                                    <?php echo $vals['categoryName'] ?>
                                </td>
                                <td  class="hide_class">
                                    <?php echo $vals['brands'] ?>
                                </td>
                                <td  class="hide_class">
                                    <?php echo $vals['model_no'] ?>
                                </td>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td class="hide_class">
                                        <?php echo $vals['hsn_sac']; ?>
                                    </td>
                                <?php } else { ?>
                                    <td class="hide_class text-right">
                                        <?php echo $vals['add_amount']; ?>
                                    </td>
                                <?php } ?>
                                <td class="remove_nowrap">
                                    <b><?php echo ($vals['product_name']) ? $vals['product_name'] : ''; ?></b>
                                    <?php echo str_replace($vals['product_name'], "", $vals['product_description']); ?>
                                </td>
                                <td class="action-btn-align">
                                    <?php
                                    if (!empty($vals['product_image'])) {
                                        $file = FCPATH . 'attachement/product/' . $vals['product_image'];
                                        $exists = file_exists($file);
                                    }
                                    $cust_image = (!empty($exists) && isset($exists)) ? $vals['product_image'] : "no-img.gif";
                                    ?>
                                    <img id="blah" name="product_image[]" class="add_staff_thumbnail product_image img-50" src="<?= $this->config->item("base_url") ?>attachement/product/<?php echo $cust_image; ?>"/>
                                </td>

                                <td class="action-btn-align">
                                    <?php echo $vals['quantity'] ?>
                                </td>
                                <td class="action-btn-align">
                                    <?php echo number_format($vals['per_cost'], 2) ?>
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
                                    <?php echo number_format($vals['sub_total'], 2); ?>
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
                            <td colspan="1" class="" style=" text-align:right;"></td>
                            <td colspan="4" class="hide_class" style=" text-align:right;"></td>
                            <td colspan="2" style=" text-align:right;">Total</td>
                            <td style="text-align:center;"><?php echo $val['total_qty']; ?></td>
                            <td colspan="3" style="text-align:right;">Sub Total</td>
                            <td style="text-align:right;"><?php echo number_format($val['subtotal_qty'], 2); ?></td>

                        </tr>
                        <tr>
                            <td colspan="1" class="" style=" text-align:right;"></td>
                            <td colspan="4" class="hide_class" style=" text-align:right;"></td>
                            <td colspan="6" style="text-align:right !important;">Advance Amount</td>
                            <td class="text-right"><?php echo (!empty($val['advance'])) ? $val['advance'] : 0; ?></td>
                        </tr>
                        <tr>
                            <td colspan="1" class="" style=" text-align:right;"></td>
                            <td colspan="4" class="hide_class" style=" text-align:right;"></td>
                            <td colspan="4" style="text-align:right !important;">CGST:</td>
                            <td class="text-right"><?php echo $cgst; ?></td>
                            <?php
                            $gst_type = $quotation[0]['state_id'];
                            if ($gst_type != '') {
                                if ($gst_type == 31) {
                                    ?>
                                    <td  style="text-align:right;">SGST:</td>
                                <?php } else { ?>
                                    <td  style="text-align:right;">IGST:</td>
                                    <?php
                                }
                            }
                            ?>
                            <td class="text-right"><?php echo $sgst; ?></td>
                        </tr>
                        <tr>
                            <td colspan="1" class="" style=" text-align:right;"></td>
                            <td colspan="4" class="hide_class" style=" text-align:right;"></td>
                            <td colspan="6" style="text-align:right;font-weight:bold;"><?php echo $val['tax_label']; ?></td>
                            <td style="text-align:right;">
                                <?php echo number_format($val['tax'], 2); ?>

                        </tr>
                        <tr>
                            <td colspan="4" class="hide_class" style=" text-align:right;"></td>
                            <td colspan="6">  <?php echo ucfirst($in_words); ?></td>
                            <td style="text-align:right;font-weight:bold;">Net Total</td>
                            <td style="text-align:right;"><?php echo number_format($val['net_total'], 2); ?></td>

                        </tr>
                    </tfoot>
                <?php } else { ?>
                    <tfoot>
                        <tr>
                            <td colspan="1" class="" style=" text-align:right;"></td>
                            <td colspan="4" class="hide_class" style=" text-align:right;"></td>
                            <td colspan="2" style=" text-align:right;">Total</td>
                            <td style="text-align:center;"><?php echo $val['total_qty']; ?></td>
                            <td colspan="1" style="text-align:right;">Sub Total</td>
                            <td style="text-align:right;"><?php echo number_format($val['subtotal_qty'], 2); ?></td>

                        </tr>
                        <tr>
                            <td colspan="1" class="" style=" text-align:right;"></td>
                            <td colspan="4" class="hide_class" style=" text-align:right;"></td>
                            <td colspan="4" style="text-align:right !important;">Advance Amount</td>
                            <td class="text-right"><?php echo (!empty($val['advance'])) ? $val['advance'] : 0; ?></td>
                        </tr>
                        <tr>
                            <td colspan="1" class="" style=" text-align:right;"></td>
                            <td colspan="4" class="hide_class" style=" text-align:right;"></td>
                            <td colspan="1" class="" style=" text-align:right;"></td>
                            <td colspan="3" style="text-align:right;font-weight:bold;"><?php echo $val['tax_label']; ?></td>
                            <td style="text-align:right;">
                                <?php echo number_format($val['tax'], 2); ?>

                        </tr>
                        <tr>
                            <td colspan="4" class="hide_class" style=" text-align:right;"></td>
                            <td colspan="4">  <?php echo ucfirst($in_words); ?></td>
                            <td style="text-align:right;font-weight:bold;">Net Total</td>
                            <td style="text-align:right;"><?php echo number_format($val['net_total'], 2); ?></td>

                        </tr>
                    </tfoot>
                <?php } ?>
            </table>
            <table class="table table-striped tablecolor m-t-5 terms-bottom-tbl table-bordered">
                <tr>
                    <th class="tabth" colspan="7">TERMS AND CONDITIONS</th>
                </tr>
                <tr>
                    <th class="tabth">Warranty:<span class="termcolor"><?php echo $val['warranty']; ?></span></th>
                </tr>
                <tr>
                    <th class="tabth">Payment Terms:<span class="termcolor"><?php echo $val['mode_of_payment']; ?></span></th>
                </tr>
                <tr>
                    <th class="tabth remark-tbl-bottom">Remarks:<span class="termcolor"><?php echo $val['remarks']; ?></span></th>
                </tr>
                <tr>
                    <th class="tabth">Validity:<span class="termcolor"><?php echo $val['validity']; ?></span></th>
                </tr>
            </table>
            <div class="hide_class text-center">
                <a href="<?php echo $this->config->item('base_url') . 'quotation/quotation_list/' ?>"class="btn btn-inverse btn-sm waves-effect waves-light">Back </a>
                <button class="btn btn-primary print_btn btn-sm waves-effect waves-light"> Print</button>
            </div>
            <?php
        }
    }
    ?>
</div>


