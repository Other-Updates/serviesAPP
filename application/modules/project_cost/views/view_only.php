<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-my-1.10.3.min.js"></script>
<style type="text/css">
    .text_right
    {
        text-align:right;
    }
    .box, .box-body, .content { padding:0; margin:0;border-radius: 0;}
    #top_heading_fix h3 {top: -57px;left: 6px;}
    #TB_overlay { z-index:20000 !important; }
    #TB_window { z-index:25000 !important; }
    .dialog_black{ z-index:30000 !important; }
    #boxscroll22 {max-height: 291px;overflow: auto;cursor: inherit !important;}
    .auto-asset-search ul#country-list li:hover {
        background: #c3c3c3;
        cursor: pointer;
    }
    .auto-asset-search ul#country-list li {
        background: #dadada;
        margin: 0;
        padding: 5px;
        border-bottom: 1px solid #f3f3f3;
    }
    ul li {
        list-style-type: none;
    }
</style>
<div class="mainpanel">
    <div class="contentpanel enquiryview hisview">
        <?php
        //echo '<pre>';
        //print_r($quotation);
        if (isset($quotation) && !empty($quotation)) {
            foreach ($quotation as $val) {
                ?>
                <table style="width:50%;margin:0 auto;" class="table table-striped responsive dataTable no-footer dtr-inline">
                    <tr>
                        <td class="first_td1">Contact Person</td>
                        <td> <?php echo $val['ref_name']; ?></td>
                        <td class="first_td1">Quotation NO</td>
                        <td> <?php echo $val['q_no']; ?></td>
                        <td>Customer Name</td>
                        <td>
                            <?php echo $val['name']; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="first_td1">Customer Mobile No</td>
                        <td>
                            <?php echo $val['mobil_number']; ?>
                        </td>
                        <td class="first_td1"  >Customer Email ID</td>
                        <td id='customer_td'>
                            <?php echo $val['email_id']; ?>
                        </td>
                        <td class="first_td">GSTIN No</td>
                        <td><?= $company_details[0]['tin_no'] ?></td>
                    </tr>
                    <tr>
                        <td  class="first_td1">Customer Address</td>
                        <td colspan="3">
                            <?php echo $val['address1']; ?>
                        </td>
                    </tr>
                </table>
                <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="add_quotation">
                    <tr>
                        <td width="10%" class="first_td1">Category</td>
                        <td width="10%" class="first_td1">Model No</td>
                        <td width="10%" class="first_td1">Brand</td>
                        <td width="10%" class="first_td1">Product Description</td>
                        <td width="10%" class="first_td1">Product Image</td>
                        <td  width="8%" class="first_td1">QTY</td>
                        <td  width="2%" class="first_td1">Cost/QTY</td>
                        <td  width="2%" class="first_td1">Tax</td>
                        <td  width="2%" class="first_td1">Net Value</td>
                    </tr>
                    <tbody id='app_table'>
                        <?php
                        if (isset($quotation_details) && !empty($quotation_details)) {
                            foreach ($quotation_details as $vals) {
                                ?>
                                <tr>
                                    <td>
                                        <?php echo $vals['categoryName'] ?>
                                    </td>
                                    <td>
                                        <?php echo $vals['model_no'] ?>
                                    </td>
                                    <td >
                                        <?php echo $vals['brands'] ?>
                                    </td>
                                    <td>
                                        <?php echo $vals['product_description'] ?>
                                    </td>
                                    <td>
                                        <img id="blah" name="product_image[]" class="add_staff_thumbnail product_image" width="50px" height="50px" src="<?= $this->config->item("base_url") ?>attachement/product/<?php echo $vals['product_image']; ?>"/>
                                    </td>
                                    <td>
                                        <?php echo $vals['quantity'] ?>
                                    </td>
                                    <td>
                                        <?php echo $vals['per_cost'] ?>
                                    </td>
                                    <td>
                                        <?php echo $vals['tax'] ?>
                                    </td>
                                    <td>
                                        <?php echo $vals['sub_total'] ?>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="5" style="width:70px; text-align:right;">Total</td>
                            <td><?php echo $val['total_qty']; ?></td>
                            <td colspan="2" style="text-align:right;">Sub Total</td>
                            <td><?php echo $val['subtotal_qty']; ?></td>

                        </tr>
                        <tr>
                            <td colspan="3" style="width:70px; text-align:right;"></td>
                            <td colspan="5" style="text-align:right;font-weight:bold;"><?php echo $val['tax_label']; ?></td>
                            <td>
                                <?php echo $val['tax']; ?>

                        </tr>
                        <tr>
                            <td colspan="3" style="width:70px; text-align:right;"></td>
                            <td colspan="5"style="text-align:right;font-weight:bold;">Net Total</td>
                            <td><?php echo $val['net_total']; ?></td>

                        </tr>
                        <tr>
                            <td colspan="10" style="">
                                <span style="float:left;  top:12px;">Remarks&nbsp;&nbsp;&nbsp;</span>
                                <?php echo $val['remarks']; ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <table class="table table-striped" style="width:100%;border:1 solid #CCC;">
                    <tr>
                        <td  style="width:49%;">
                            <table style="width:100%;">
                                <tr>
                                    <td colspan="4"><b style="font-size:15px;">TERMS AND CONDITIONS</b></td>
                                </tr>
                                <tr>
                                    <td>1.</td>
                                    <td>Delivery Schedule</td>
                                    <td></td>
                                    <td>
                                        <div class="input-group" style="width:70%;">
                                            <?php echo $val['delivery_schedule']; ?>
                                            <span id="colorpoerror" style="color:#F00;" ></span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>Notification Date</td>
                                    <td></td>
                                    <td>
                                        <div class="input-group" style="width:70%;">
                                            <?php echo $val['notification_date']; ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3.</td>
                                    <td>Mode of Payment</td>
                                    <td></td>
                                    <td><?php echo $val['mode_of_payment']; ?></td>
                                </tr>
                                <input type="hidden"  name="quotation[customer]" id="customer_id" class='id_customer' value="<?php echo $val['id']; ?>"/>

                            </table>
                        </td>
                        <td style="width:49%;">
                        </td>
                    </tr>
                </table>
                <div class="hide_class action-btn-align mb-bot4">
                    <a href="<?php echo $this->config->item('base_url') . 'quotation/quotation_list/' ?>"class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                </div>
            <?php
            }
        }
        ?>
    </div><!-- contentpanel -->
</div><!-- mainpanel -->

