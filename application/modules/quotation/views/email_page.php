<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<style type="text/css">
    table {border-collapse:collapse; width:100%; }
    table th { font-size: 10px; }
    table th,td { text-align:center; }
    table td {font-size: 10px; padding: 10px 10px; }
    .pdf-f{font-weight:bold}
</style>
<table border=0 cellpadding=0 cellspacing=0 style="table-layout:fixed; width: 100%" align="center">
    <tr>
        <td valign="top" align="left" width="20%" >
            <img src="<?= $this->config->item("base_url") ?>themes/incsol/assets/images/printlogo.png" >
        </td>
        <td valign="top" width="60%" align="left">
            <font size="15px"><b><?= $company_details[0]['company_name'] ?></b></font><br />
            <font size="10px">
            <?= $company_details[0]['city'] ?>,
            <?= $company_details[0]['state'] ?> -
            <?= $company_details[0]['pin'] ?><br>
            PH:<?= $company_details[0]['phone_no'] ?><br>
            Email:<?= $company_details[0]['email'] ?><br>
            <?php if ($quotation[0]['is_gst']) { ?>
                <strong>GSTIN NO</strong>:<?= $data['company_details'][0]['tin_no'] ?>
            <?php } ?>
            </font>
        </td>
        <td valign="top" align="right" width="20%">
            <font size="10px"><?php echo date('m/d/Y ') ?> <br>
            </font>
        </td>
    </tr>
</table>
<?php
if (isset($quotation) && !empty($quotation)) {
    foreach ($quotation as $val) {
        ?>
        <table border="1" row-style="page-break-inside:avoid;">
            <tr >
                <td align="left" width="208"><span class="pdf-f">TO,</span><br/>
                    <div><b><?php echo $val['store_name']; ?></b></div>
                    <div><?php echo $val['address1']; ?> </div>
                    <div> <?php echo $val['mobil_number']; ?></div>
                    <div> <?php echo $val['email_id']; ?></div>
                    <?php if ($val['is_gst'] == 1) { ?>
                        <div> <b>GTSIN NO:</b> <?php echo $val['tin']; ?></div>
                    <?php } ?>
                </td>

                <td colspan="2" align="center" width="325"> <img src="<?= $this->config->item("base_url") ?>themes/incsol/assets/images/printlogo.png" alt="Chain Logo" style="margin-top: 5px; width:100px;"></td>
            </tr>
            <tr>
                <td align="left" width="208"><span class="pdf-f">Project Name : </span><?php echo $val['project_name']; ?></td>
                <td colspan="2" align="left" width="325" ><span class="pdf-f">Quotation NO : </span><?php echo $val['q_no']; ?></td>
            </tr>
            <tr>
                <td align="left" width="208" ><span class="pdf-f">Contact Person : </span> <?php echo $val['referred_by']; ?></td>
                <td colspan="2"align="left" width="325" ><span class="pdf-f">Date: </span> <?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td>
            </tr>
        </table>

        <table border="1" style="padding: 5px 5px;" row-style="page-break-inside:avoid;">
            <tr>
                <?php if ($val['is_gst'] == 1) { ?>
                    <td colspan="8" align="center"><b>QUOTATION DETAILS</b></td>
                <?php } else { ?>
                    <td colspan="6" align="center"><b>QUOTATION DETAILS</b></td>
                <?php } ?>
            </tr>
            <tr>
                <?php if ($val['is_gst'] == 1) { ?>
                    <td colspan="8" style="background-color:#ddd;"></td>
                <?php } else { ?>
                    <td colspan="6" style="background-color:#ddd;"></td>
                <?php } ?>
            </tr>
            <tr align="center" style="background-color:#e6e6ff;">
                <td width="7%"><b>S.No</b></td>
                <?php if ($val['is_gst'] == 1) { ?>
                    <td width="30%" ><b>Product Description</b></td>
                <?php } else { ?>
                    <td width="42%" ><b>Product Description</b></td>
                <?php } ?>
                <td width="11%"><b>Product</b></td>
                <td width ="10%"><b>QTY</b></td>
                <td width ="15%"><b>Unit Price</b></td>
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
                <td width ="15%"><b>Net Value</b></td>
            </tr>
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
                        <td align="center" width="7%">
                            <?php echo $i; ?>
                        </td>
                        <?php if ($val['is_gst'] == 1) { ?>
                            <td align="center" width="30%" >
                                <?php echo $vals['product_description'] ?>
                            </td>
                        <?php } else { ?>
                            <td align="center" width="42%" >
                                <?php echo $vals['product_description'] ?>
                            </td>
                        <?php } ?>
                        <td align="center" width="11%">
                            <img id="blah" name="product_image[]" class="add_staff_thumbnail product_image" width="50px" height="50px" src="<?= $this->config->item("base_url") ?>attachement/product/<?php echo $vals['product_image']; ?>"/>
                        </td>
                        <td align="center" width="10%"><?php echo $vals['quantity'] ?></td>
                        <td align="right" width="15%">
                            <?php echo number_format($vals['per_cost'], 2); ?>
                        </td>
                        <?php if ($val['is_gst'] == 1) { ?>
                            <td class="action-btn-align" width="6%">
                                <?php echo $vals['tax'] ?>
                            </td>
                            <?php
                            $gst_type = $quotation[0]['state_id'];
                            if ($gst_type != '') {
                                if ($gst_type == 31) {
                                    ?>
                                    <td class="action-btn-align" width="6%">
                                        <?php echo $vals['gst']; ?>
                                    </td>
                                <?php } else { ?>
                                    <td class="action-btn-align" width="6%">
                                        <?php echo $vals['igst']; ?>
                                    </td>
                                    <?php
                                }
                            }
                        }
                        ?>
                        <td align="right" width="15%">
                            <?php echo number_format($vals['sub_total'], 2); ?>
                        </td>
                    </tr>
                    <?php
                    $i++;
                }
            }
            ?>
            <?php if ($val['is_gst'] == 1) { ?>
                <tr>
                    <td colspan="2" class="hide_class" style=" text-align:right;"></td>
                    <td align="right" ><b>Total</b></td>
                    <td align="center"><?php echo $val['total_qty']; ?></td>
                    <td colspan="3" align="right"><b>Sub Total</b></td>
                    <td align="right"><?php echo number_format($val['subtotal_qty'], 2); ?></td>
                </tr>
                <tr>
                    <td colspan="7" style="text-align:right !important;">Advance Amount</td>
                    <td class="text-right" align="right"><?php echo (!empty($val['advance'])) ? $val['advance'] : 0; ?></td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align:right !important;">CGST:</td>
                    <td class="text-right" align="right"><?php echo $cgst; ?></td>
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
                    <td class="text-right" align="right"><?php echo $sgst; ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="hide_class" style=" text-align:right;"></td>
                    <td colspan="4" align="center"><b><?php echo number_format($val['tax_label'], 2); ?> </b></td>
                    <td align="right">
                        <?php echo $val['tax']; ?>
                    </td>
                </tr>
                <tr >
                    <td colspan="3" class="hide_class" style=" text-align:right;"></td>
                    <td colspan="3">  <?php echo ucfirst($in_words); ?></td>
                    <td  align="right"><b>Net Total</b></td>
                    <td align="right"><b><?php echo number_format($val['net_total'], 2); ?></b></td>
                </tr>
                <tr>
                    <td colspan="8" align="left">
                        <span class="pdf-f">Remarks : </span>
                        <?php echo $val['remarks']; ?>
                    </td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td  class="hide_class" style=" text-align:right;"></td>
                    <td colspan="2" align="right" ><b>Total</b></td>
                    <td  align="center"><?php echo $val['total_qty']; ?></td>
                    <td colspan="1" align="right"><b>Sub Total</b></td>
                    <td align="right"><?php echo number_format($val['subtotal_qty'], 2); ?></td>
                </tr>
                <tr>
                    <td colspan="5" style="text-align:right !important;">Advance Amount</td>
                    <td class="text-right"><?php echo (!empty($val['advance'])) ? $val['advance'] : 0; ?></td>
                </tr>
                <tr>
                    <td colspan="1" class="hide_class" style=" text-align:right;"></td>
                    <td colspan="4" align="center"><b><?php echo number_format($val['tax_label'], 2); ?> </b></td>
                    <td align="right">
                        <?php echo $val['tax']; ?>
                    </td>
                </tr>
                <tr >
                    <td  class="hide_class" style=" text-align:right;"></td>
                    <td colspan="3">  <?php echo ucfirst($in_words); ?></td>
                    <td align="right"><b>Net Total</b></td>
                    <td align="right"><b><?php echo number_format($val['net_total'], 2); ?></b></td>
                </tr>
                <tr>
                    <td colspan="6" align="left">
                        <span class="pdf-f">Remarks : </span>
                        <?php echo $val['remarks']; ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
        </br></br></br>
        <?php
    }
}
?>

