<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .tabth {
        color: #448aff !important;
    }
    .termcolor {
        color: #222d33 !important;
    }
    .terms-bottom-tbl{border: 1px solid #dee2e6;}
    .terms-bottom-tbl tr{border: 1px solid #dee2e6;}
    .pl-30{padding-left:30px;}
    .pl-52{padding-left:52px;}
    .pl-32{padding-left:32px;}
</style>
<div class="card">
    <?php
    $this->load->view("admin/main-printheader");
    ?>
    <div class="card-header">
        <h5>View Project Cost
        </h5>
    </div>
    <div class="card-block table-border-style">
        <div class="table-responsive" id='result_div'>
            <?php
            if (isset($quotation) && !empty($quotation)) {
                foreach ($quotation as $val) {
                    ?>
                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline newtbl-bordr">
                        <tr>
                            <td width="39%" class="text-left"><span  class="f-w-700">TO,</span><br/>
                                <div><b><?php echo $val['store_name']; ?></b></div>
                                <div><?php echo $val['address1']; ?> </div>
                                <div> <?php echo $val['mobil_number']; ?></div>
                                <div> <?php echo $val['email_id']; ?></div>
                            </td>
                            <td class="action-btn-align"> <img src="<?= $theme_path; ?>/assets/images/logo-1.png" alt="Chain Logo" width="240px"></td>
                        </tr>
                        <tr>
                            <td id="contact_text" class="text-left"><span  class="f-w-700">Reference Name : </span><?php echo $val['nick_name']; ?></td>
                            <td id="contact_text1" class="text-left" style="display:none;"><span  class="f-w-700">Contact Person : </span><?php echo $val['name']; ?></td>

                            <td class="text-left"><span  class="f-w-700">  Quotation NO:</span>  <?php echo $val['q_no']; ?> </td>
                        </tr>
                        <tr>
                            <td class="text-left"><span  class="f-w-700"> Job Id <span class="">:</span></span> <?php echo $val['job_id']; ?> </td>
                            <!--<td class="text-left"><span  class="f-w-700">GSTIN No:</span> <?php //echo $company_details[0]['tin_no']                       ?>  </td>-->
                            <!--<td><span  class="tdhead">Customer Name:</span> <?php echo $val['store_name']; ?> </td>-->
                            <td class="text-left"><span  class="f-w-700"> Date <span>:</span></span><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td>
                        </tr>
                        <!--<tr>

                            <td></td>
                        </tr>-->
                    </table>

                    <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline m-t-5 newtbl-bordr" id="add_quotation">
                        <thead>
                            <tr>
                                <td  width="2%" class="first_td1 action-btn-align ser-wid">S.No</td>
                                <td width="8%" class="first_td1 ser-wid">Category</td>
                                <td width="8%" class="first_td1 ser-wid">Brand</td>
                                <td width="8%" class="first_td1 ser-wid">Model No</td>
                                <td width="30%" class="first_td1 pro-wid">Product Description</td>
                                <td width="5%" class="first_td1 ser-wid">Add Amt</td>
                                <td  width="2%" class="first_td1 action-btn-align ser-wid">QTY</td>
                                <td  width="5%" class="first_td1 action-btn-align ser-wid">Unit Price</td>
                                <td  width="2%" class="first_td1 action-btn-align ser-wid" style="display: none;">Tax</td>
                                <td  width="5%" class="first_td1 action-btn-align qty-wid">Net Value</td>

                            </tr>
                        </thead>
                        <tbody id='app_table'>
                            <?php
                            $i++;
                            if (isset($quotation_details) && !empty($quotation_details)) {
                                foreach ($quotation_details as $vals) {
                                    ?>
                                    <tr>
                                        <td class="action-btn-align">
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
                                            <b><?php echo ($vals['product_name']) ? $vals['product_name'] : ''; ?></b>
                                            <?php echo str_replace($vals['product_name'], "", $vals['product_description']); ?>
                                        </td>
                                        <td class="text-right">
                                            <?php echo $vals['po_add_amount'] ?>
                                        </td>
                                        <td class="action-btn-align">
                                            <?php echo $vals['quantity'] ?>
                                        </td>
                                        <td class="text-right">
                                            <?php echo number_format($vals['per_cost'], 2); ?>
                                        </td>
                                        <td class="action-btn-align" style="display: none;">
                                            <?php echo $vals['tax'] ?>
                                        </td>
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

                        <tfoot>
                            <tr>
                                <td colspan="6" class="totbold" style=" text-align:right;">Total</td>
                                <td class="action-btn-align"><?php echo $val['total_qty']; ?></td>
                                <td class="totbold" style="text-align:right;">Sub Total</td>
                                <td class="text-right"><?php echo number_format($val['subtotal_qty'], 2); ?></td>

                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:right;"></td>
                                <td colspan="6" style="text-align:right;font-weight:bold;"><?php echo $val['tax_label']; ?> </td>
                                <td class="text-right">
                                    <?php echo number_format($val['tax'], 2); ?>

                            </tr>
                            <?php
                            foreach ($val['other_cost'] as $key) {
                                ?>
                                <tr>
                                    <td colspan="2" style=" text-align:right;"></td>
                                    <td colspan="6" style="text-align:right;font-weight:bold;"><?php echo $key['item_name']; ?> </td>
                                    <td class="text-right">
                                        <?php echo number_format($key['amount'], 2); ?>

                                </tr>
                            <?php }
                            ?>
                            <tr>
                                <td colspan="2" style="text-align:right;"></td>
                                <td colspan="5">  <?php echo ucfirst($in_words); ?></td>
                                <td  style="text-align:right;font-weight:bold;">Net Total</td>
                                <td class="text-right"><?php echo number_format($val['net_total'], 2); ?></td>

                            </tr>
                            <tr>
                                <td colspan="9" style="text-align:left" class="remark-tbl-bottom">
                                    <span class="totbold" style="float:left;  top:12px;">Remarks&nbsp;&nbsp;&nbsp;</span>
                                    <?php echo $val['remarks']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td  colspan="9"  class="text-left">
                                    <span style="float:left;  top:12px;" class="f-w-700">Bank Details &nbsp;&nbsp;&nbsp;</span></td>
                            </tr>
                            <tr>	 <td  colspan="9"  class="text-left">
                                    <span  class="f-w-700">Bank Name<span class="pl-30">:</span>&nbsp; </span><?php echo $val['bank_name']; ?></td>
                            </tr>
                            <tr>		 <td  colspan="9"  class="text-left">
                                    <span  class="f-w-700">Account Number <span class="">:</span>&nbsp; </span><?= $val['account_num']; ?></td>
                            </tr>
                            <tr>	 <td  colspan="9"  class="text-left">
                                    <span  class="f-w-700">Branch<span class="pl-52">:</span> &nbsp;</span><?php echo $val['bank_branch']; ?></td>
                            </tr>
                            <tr>	 <td  colspan="9"  class="text-left">
                                    <span  class="f-w-700">IFSC Code <span class="pl-32">:</span> &nbsp;</span> <?= $val['ifsc']; ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="form-group row m-10">
                        <div class="col-md-12 text-center">
                            <button class="btn btn-primary print_btn btn-sm waves-effect waves-light"> Print</button>
                            <a href="<?php echo $this->config->item('base_url') . 'project_cost/project_cost_list/' ?>" class="btn btn-inverse btn-sm waves-effect waves-light"> Back </a>
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

