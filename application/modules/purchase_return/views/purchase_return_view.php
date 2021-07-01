<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .tabth {
        /*color: #448aff !important;*/
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
            <?php if ($po[0]['is_gst'] == 1) { ?>
                <strong>GSTIN NO</strong>:<?= $data['company_details'][0]['tin_no'] ?>
            <?php } ?>

        </div>

    </div>

    <div class="print-line"></div>
    <div class="card-header">
        <h5>View Purchase Return
        </h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive" id='result_div'>
            <?php
            if (isset($po) && !empty($po)) {
                foreach ($po as $val) {
                    ?>
                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline tablecolor m-t-5" style="border:1px solid #dee2e6;">
                        <tr>
                            <td width="50%" class="text-left"><span  class="f-w-700">TO,</span><br/>
                                <div> <?php echo $val['address1']; ?> </div>
                            </td>
                            <td width="50%" class="action-btn-align" colspan="2"> <img src="<?= $theme_path; ?>/assets/images/logo-1.png" alt="Chain Logo" width="260px"></td>
                        </tr>
                        <tr>
                            <td class="text-left">GRN NO:<?php echo $val['grn_no']; ?> </td>
                            <td class="text-left">Vendor Name:<?php echo $val['name']; ?></td>
                        </tr>
                        <tr>
                            <td class="text-left">Vendor Mobile No: <?php echo $val['mobil_number']; ?></td>
                            <td class="text-left">Vendor Email ID:<?php echo $val['email_id']; ?></td>
                        </tr>
                        <?php if ($val['is_gst'] == 1) { ?>
                            <tr>
                                <td class="text-left">GSTIN No:<?= $val['tin'] ?></td>
                                <td></td>
                            </tr>
                        <?php } ?>
                    </table>

                    <table width="100%" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline m-t-5" id="add_quotation">
                        <thead>
                            <tr>
                                <td  width="2%" class="first_td1">S.No</td>
                                <td width="10%" class="first_td1">Category</td>
                                <td width="10%" class="first_td1">Brand</td>
                                <td width="10%" class="first_td1">Model No</td>
                                <td width="10%" class="first_td1">Product Description</td>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td width="10%" class="first_td1">HSN Code</td>
                                <?php } else { ?>
                                    <td width="5%" class="first_td1">Add Amt</td>
                                <?php } ?>
                                <td  width="8%" class="first_td1">QTY</td>
                                <td  width="5%" class="first_td1">Unit Price</td>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td width="2%" class="first_td1 action-btn-align proimg-wid">CGST%</td>
                                    <?php
                                    $gst_type = $po[0]['state_id'];
                                    if ($gst_type != '') {
                                        if ($gst_type == 31) {
                                            ?>
                                            <td  width="2%" class="first_td1 action-btn-align proimg-wid" >SGST%</td>
                                        <?php } else { ?>
                                            <td  width="2%" class="first_td1 action-btn-align proimg-wid" >IGST%</td>

                                            <?php
                                        }
                                    }
                                }
                                ?>
                                <td  width="5%" class="first_td1">Net Value</td>

                            </tr>
                        </thead>
                        <tbody id='app_table'>
                            <?php
                            $i = 1;
                            $cgst = 0;
                            $sgst = $sub_total = 0;
                            if (isset($po_details) && !empty($po_details)) {
                                foreach ($po_details as $vals) {
                                    $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['return_quantity']);

                                    $gst_type = $po[0]['state_id'];
                                    if ($val['is_gst'] == 1) {
                                        $sub_total = $vals['per_cost'] * $vals['return_quantity'];
                                    } else {
                                        $sub_total = ($vals['per_cost']) * $vals['return_quantity'];
                                    }

                                    if ($gst_type != '') {
                                        if ($gst_type == 31) {

                                            $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * $vals['return_quantity']);
                                        } else {
                                            $sgst1 = ($vals['igst'] / 100 ) * ($vals['per_cost'] * $vals['return_quantity']);
                                        }
                                    }
                                    $cgst += $cgst1;
                                    $sgst += $sgst1;
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $i; ?>
                                        </td>
                                        <td>
                                            <?php echo $vals['categoryName'] ?>
                                        </td>
                                        <td>
                                            <?php echo $vals['brands'] ?>
                                        </td>
                                        <td >
                                            <?php echo $vals['model_no'] ?>
                                        </td>
                                        <td class="remove_nowrap">
                                            <?php echo $vals['product_description'] ?>
                                        </td>
                                        <?php if ($val['is_gst'] == 1) { ?>
                                            <td >
                                                <?php echo $vals['hsn_sac'] ?>
                                            </td>
                                        <?php } else { ?>
                                            <td >
                                                <?php echo $vals['add_amount'] ?>
                                            </td>
                                        <?php } ?>
                                        <td class="text-center">
                                            <?php echo $vals['return_quantity'] ?>
                                        </td>
                                        <td>
                                            <?php echo $vals['per_cost'] ?>
                                        </td>
                                        <?php if ($val['is_gst'] == 1) { ?>
                                            <td class="action-btn-align">
                                                <?php echo $vals['tax'] ?>
                                            </td>
                                            <?php
                                            $gst_type = $po[0]['state_id'];
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
                                            <?php echo number_format($sub_total, 2) ?>
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
                                <td colspan="2" class=""></td>
                                <td colspan="3" class="totbold" style=" text-align:right;">Total</td>
                                <td class="action-btn-align"><?php echo $val['return_qty']; ?></td>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td colspan="3" class="gst_add totbold" style="text-align:right;">Sub Total</td>
                                <?php } else { ?>
                                    <td class="totbold" style="text-align:right;">Sub Total</td>
                                <?php } ?>
                                <td class="text-right"><?php echo number_format($val['subtotal_qty'], 2, '.', ','); ?></td>

                            </tr>
                            <?php if ($val['is_gst'] == 1) { ?>
                                <tr>
                                    <td></td>
                                    <td colspan="2" class=""></td>
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
                                    <td colspan="2" class=""></td>
                                <?php } ?>
                                <td colspan="2" class=""></td>
                                <td colspan="5" style="text-align:right;font-weight:bold;"><?php echo $val['tax_label']; ?> </td>
                                <td class="text-right">
                                    <?php echo number_format($val['tax'], 2); ?>

                            </tr>
                            <tr>

                                <?php if ($val['is_gst'] == 1) { ?>

                                    <td colspan="9" style="text-align:left;">  <?php echo ucfirst($in_words); ?></td>
                                <?php } else { ?>

                                    <td colspan="7" style="text-align:left;">  <?php echo ucfirst($in_words); ?></td>
                                <?php } ?>
                                <td style="text-align:right;font-weight:bold;">Net Total</td>
                                <td class="text-right net_bg"><?php echo number_format($val['return_amount'], 2, '.', ','); ?></td>

                            </tr>
                        </tfoot>
                    </table>
                    <table  class="table table-striped tablecolor m-t-5 terms-bottom-tbl table-bordered">
                        <tr>
                            <th class="tabth" colspan="4">TERMS AND CONDITIONS</th>
                        </tr>
                        <tr>
                            <th class="tabth remark-tbl-bottom">Remarks:<span class="termcolor"><?php echo $val['remarks']; ?></span></th>
                        </tr>
                        <tr>
                            <th class="tabth">Payment Terms:<span class="termcolor"><?php echo $val['mode_of_payment']; ?></span>
                            </th>
                        </tr>

                    </table>
                    <div class="hide_class text-center m-t-5">
                        <a href="<?php echo $this->config->item('base_url') . 'purchase_return/' ?>"class="btn btn-inverse btn-sm waves-effect waves-light"> Back </a>
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

