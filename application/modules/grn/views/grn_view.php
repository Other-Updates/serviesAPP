<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .tabth {

    }

    @media print{
        td, th {
            white-space: unset !important;
        }
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
            <?php if ($gen[0]['is_gst'] == 1) { ?>
                <strong>GSTIN NO</strong>:<?= $data['company_details'][0]['tin_no'] ?>
            <?php } ?>

        </div>

    </div>

    <div class="print-line"></div>
    <div class="card-header">
        <h5>View Goods Receive Note
        </h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive" id='result_div'>
            <?php
            if (isset($gen) && !empty($gen)) {
                foreach ($gen as $val) {
                    ?>
                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline tablecolor" style="border:1px solid #dee2e6;">
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
                            <td class="text-left"><span  class="f-w-700">PO NO : </span><?php echo $val['po_no']; ?>
                                <input type="hidden" value="<?= $val['po_no'] ?>"  name="po_no">
                            </td>

                            <td class="text-left"><span  class="f-w-700">Date : </span><?= ($val['inv_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['inv_date'])) : ''; ?></td>
                        </tr>
                        <tr>

                            <td  id="contact_text" class="text-left"><span  class="f-w-700">GRN NO : </span><?php echo $val['grn_no']; ?></td>
                            <td class="text-left"><span  class="f-w-700">Vendor Inv NO : </span><?php echo $val['vendor_inv_no']; ?></td>
                        </tr>
                    </table>

                    <table width="100%" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline m-t-5" id="add_quotation" style="border:1px solid #dee2e6;">
                        <thead>
                            <tr>
                                <td  width="2%" class="first_td1 action-btn-align ser-wid">S.No</td>
                                <td width="10%" class="first_td1">Product Serial No</td>
                                <td width="8%" class=" first_td1">Category</td>
                                <td width="8%" class=" first_td1">Warranty</td>
                                <td width="8%" class=" first_td1">Brand</td>
                                <td width="8%" class="first_td1">Model No</td>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td width="5%" class="first_td1">HSN Code</td>
                                <?php } else { ?>
                                    <td width="5%" class="first_td1">Add Amt</td>
                                <?php } ?>
                                <td width="15%" class="first_td1 pro-wid">Product Description</td>
                                <td  width="4%" class="first_td1 action-btn-align ser-wid">QTY</td>
                                <td  width="2%" class="first_td1 action-btn-align ser-wid">Unit Price</td>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td width="6%" class="first_td1 action-btn-align proimg-wid">CGST%</td>
                                    <?php
                                    $gst_type = $gen[0]['state_id'];
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
                                <td  width="8%" class="first_td1 action-btn-align qty-wid">Net Value</td>

                            </tr>
                        </thead>
                        <tbody id='app_table'>
                            <?php
                            $i = 1;
                            if (isset($po_details) && !empty($po_details)) {
                                foreach ($po_details as $vals) {
                                    $cgst1 = ($vals['tax'] / 100 ) * ($vals['per_cost'] * $vals['delivery_quantity']);

                                    $gst_type = $gen[0]['state_id'];
                                    if ($gst_type != '') {
                                        if ($gst_type == 31) {

                                            $sgst1 = ($vals['gst'] / 100 ) * ($vals['per_cost'] * $vals['delivery_quantity']);
                                        } else {
                                            $sgst1 = ($vals['igst'] / 100 ) * ($vals['per_cost'] * $vals['delivery_quantity']);
                                        }
                                    }
                                    $cgst += $cgst1;
                                    $sgst += $sgst1;
                                    ?>
                                    <tr>
                                        <td class="action-btn-align">
                                            <?php echo $i; ?>
                                        </td>
                                        <td>
                                            <?php echo $vals['product_serial_no'] ?>
                                        </td>
                                        <td class="">
                                            <?php echo $vals['categoryName'] ?>
                                        </td>
                                        <td class="">
                                            <?php
                                            if ($vals['is_warranty'] == 1) {
                                                $warranty = 'Warranty Item' . ' ' . date('d-M-Y', strtotime($vals['created_date'])) . ' - ' . date('d-M-Y', strtotime('+1 year', strtotime($vals['created_date'])));
                                            } else {
                                                $warranty = 'Non-Warranty Item';
                                            }
                                            ?>
                                            <?php echo $warranty ?>
                                        </td>
                                        <td class="">
                                            <?php echo $vals['brands'] ?>
                                        </td>
                                        <td >
                                            <?php echo $vals['model_no'] ?>
                                        </td>
                                        <?php if ($val['is_gst'] == 1) { ?>
                                            <td >
                                                <?php echo $vals['hsn_sac'] ?>
                                            </td>
                                        <?php } else { ?>
                                            <td class="text-right">
                                                <?php echo $vals['add_amount'] ?>
                                            </td>
                                        <?php } ?>

                                        <td class="remove_nowrap">
                                            <b><?php echo ($vals['product_name']) ? $vals['product_name'] : ''; ?></b>
                                            <?php echo str_replace($vals['product_name'], "", $vals['product_description']); ?>
                                        </td>
                                        <td class="action-btn-align">
                                            <?php echo ($vals['delivery_quantity']) ?>
                                        </td>
                                        <td class="text-right">
                                            <?php echo number_format($vals['per_cost'], 2); ?>
                                        </td>
                                        <?php if ($val['is_gst'] == 1) { ?>
                                            <td class="action-btn-align">
                                                <?php echo $vals['tax'] ?>
                                            </td>
                                            <?php
                                            $gst_type = $gen[0]['state_id'];
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

                        <tfoot>
                            <tr>

                                <td colspan="8" class="totbold" style=" text-align:right;">Total</td>
                                <td class="action-btn-align"><?php echo $val['total_qty']; ?></td>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td colspan="3" class="gst_add totbold" style="text-align:right;">Sub Total</td>
                                <?php } else { ?>
                                    <td class="totbold" style="text-align:right;">Sub Total</td>
                                <?php } ?>
                                <td class="text-right"><?php echo number_format($val['subtotal_qty'], 2); ?></td>

                            </tr>
                            <?php if ($val['is_gst'] == 1) { ?>
                                <tr>
                                    <td colspan="10" class="totbold" style="text-align:right !important;">CGST:</td>
                                    <td class="text-right"><?php echo $cgst; ?></td>
                                    <?php
                                    $gst_type = $gen[0]['state_id'];
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
                                    <td class="text-right"><?php echo $sgst; ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td colspan="2"></td>
                                <?php } ?>

                                <td colspan="10" style="text-align:right;font-weight:bold;"><?php echo $val['tax_label']; ?> </td>
                                <td class="text-right">
                                    <?php echo number_format($val['tax'], 2); ?>

                            </tr>
                            <tr>
                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td colspan="2"></td>
                                <?php } ?>

                                <td colspan="10" style="text-align:right;font-weight:bold;">Parcel Charges </td>
                                <td class="text-right">
                                    <?php echo number_format($val['parcel_charges'], 2); ?>

                            </tr>
                            <tr>

                                <?php if ($val['is_gst'] == 1) { ?>
                                    <td colspan="11" style="text-align:left;">  <?php echo ucfirst($in_words); ?></td>
                                <?php } else { ?>
                                    <td colspan="9" style="text-align:left;">  <?php echo ucfirst($in_words); ?></td>
                                <?php } ?>
                                <td style="text-align:right;font-weight:bold;">Net Total</td>
                                <td class="text-right net_bg"><?php echo number_format($val['net_total'], 2); ?></td>

                            </tr>
                        </tfoot>
                    </table>
                    <table style="width:100%;" class="table table-striped tablecolor m-t-5 terms-bottom-tbl table-bordered">
                        <tr>
                            <th class="tabth" colspan="4">TERMS AND CONDITIONS</th>
                        </tr>
                        <tr>
                            <th class="tabth remark-tbl-bottom">Remarks:<span class="termcolor"> <?php echo $val['remarks']; ?></span></th>
                        </tr>
                        <tr>
                            <th class="tabth">Payment Terms:<span class="termcolor"><?php echo $val['mode_of_payment']; ?></span>
                            </th>
                        </tr>
                        <tr>
                            <th class="tabth">Received Location:<span class="termcolor"> <?php echo $val['location']; ?></span></th>
                        </tr>

                    </table>
                    <div class="hide_class text-center m-t-5">
                        <a href="<?php echo $this->config->item('base_url') . 'grn/grn_list/' ?>"class="btn btn-inverse btn-sm waves-effect waves-light"> Back </a>
                        <button class="btn btn-primary print_btn btn-sm waves-effect waves-light"> Print</button>
                        <a href="<?php echo $this->config->item('base_url') . 'grn/view_barcode/' . $val['id'] ?>"class="btn btn-inverse btn-sm waves-effect waves-light mr-2" style="float: right"> View QR Code </a>
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

