<div class="result_div">
    <table id="basicTable_call_back" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline ">
        <thead>
            <tr>
                <td class="action-btn-align">S.No</td>
                <td class="action-btn-align">Invoice ID</td>
                <td class="action-btn-align">Customer Name</td>
                <td class="action-btn-align">Total Quantity</td>
                <td class="action-btn-align">CGST</td>
                <td class="action-btn-align">SGST</td>
                <td class="action-btn-align">Sub Total</td>
                <td class="action-btn-align">Invoice Amount</td>
                <!--<td class="action-btn-align">Paid Amount</td>-->
                <!--<td class="action-btn-align">Return Amount</td>-->
                <!--<td class="action-btn-align">Balance Amount</td>-->
                <td class="action-btn-align">Invoice Date</td>
                <!--<td class="action-btn-align">Paid Date</td>-->
                <!--<td class="action-btn-align">Credit Days</td>-->
                <!--<td class="action-btn-align">Due Date</td>-->
<!--                <td class="action-btn-align">Credit Limit</td>
                <td class="action-btn-align">Exceeded Credit Limit</td>
                <td class="action-btn-align">Driver</td>-->
                <!--<td>Remarks</td>-->
                <td class="action-btn-align">Driver</td>
                <th class="action-btn-align">Vehicle</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $quotation = array_filter($quotation);
            if (isset($quotation) && !empty($quotation)) {

                $count = count($quotation);



                $i = 1;
                $tot = 0;
                $cnt = 0;
                foreach ($quotation as $key => $val) {
                    if (isset($val['inv_id']) && !empty($val['inv_id'])) {
                        if (isset($quotation['inv_all_details'])) {
                            if (++$cnt === $count) {
                                //echo "last index!";
                            } else {


                                $invoice_id = $val['id'];
                                $tot += $val['net_total'];
                                if ($val['credit_days'] > 0 && $val['created_date'] != '1970-01-01') {
                                    $due_date = date('d-M-Y', strtotime($val['created_date'] . "+" . $val['credit_days'] . " days"));
                                } else {
                                    $due_date = '-';
                                }
                                ?>
                                <tr>
                                    <td class='first_td action-btn-align'><?= $i ?></td>
                                    <td class="action-btn-align"><?= $val['inv_id'] ?></td>
                                    <td><?php echo ucfirst($val['name']); ?></td>

                                    <?php
                                    if (isset($quotation['inv_all_details']) && !empty($quotation['inv_all_details'])) {
                                        ?>
                                        <?php
                                        if (isset($quotation['inv_all_details'][$invoice_id]['in_id'])) {
                                            ?>
                                            <td class="action-btn-align"><?= round($quotation['inv_all_details'][$invoice_id]['quantity']) ?></td>
                                            <td class="text_right"><?= number_format(($quotation['inv_all_details'][$invoice_id]['cgst']), 2); ?></td>
                                            <td class="text_right"><?= number_format(($quotation['inv_all_details'][$invoice_id]['sgst']), 2); ?></td>

                                            <?php
                                        } else {
                                            ?>

                                            <td class="action-btn-align"><?= number_format($val['total_qty']) ?></td>
                                            <td class="text_right"><?= number_format(($val['erp_invoice_details'][0]['cgst']), 2); ?></td>
                                            <td class="text_right"><?= number_format(($val['erp_invoice_details'][0]['sgst']), 2); ?></td>
                                            <?php
                                        }
                                        ?>
                                        <?php
                                    } else {
                                        ?>
                                        <td class="action-btn-align"><?= number_format($val['total_qty']) ?></td>
                                        <td class="text_right"><?= number_format(($val['erp_invoice_details'][0]['cgst']), 2); ?></td>
                                        <td class="text_right"><?= number_format(($val['erp_invoice_details'][0]['sgst']), 2); ?></td>
                                    <?php } ?>

                                    <td class="text_right"><?= number_format($val['subtotal_qty'], 2); ?></td>
                                    <td class="text_right"><?= number_format($val['net_total'], 2); ?></td>
                                    <!--<td  class="text_right"><?php echo number_format(($val['receipt_bill'][0]['receipt_paid'] + $val['advance']), 2, '.', ',') ?></td>-->
                                    <!--<td class="text_right"><?= number_format($val['return_amt'], 2, '.', ','); ?></td>-->
                                    <!--<td class="text_right"><?= number_format(($val['net_total'] - $val['return_amt']) - (round($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'] + $val['advance'], 2)), 2, '.', ','); ?></td>-->
                                    <td class="action-btn-align"><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td>
                                    <!--<td class="action-btn-align"><?php echo ($val['receipt_bill'][0]['paid_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['paid_date'])) : '-'; ?></td>-->
                                    <!--<td class="action-btn-align"><?= $val['credit_days'] > 0 ? $val['credit_days'] : '-'; ?></td>-->
                                    <!--<td class="action-btn-align"><?= $due_date; ?></td>-->
                    <!--                                <td class="action-btn-align"><?= ($val['credit_limit'] != '') ? $val['credit_limit'] : '-'; ?></td>
                                    <td class="action-btn-align"><?= ($val['exceeded_limit'] != '') ? $val['exceeded_limit'] : '-'; ?></td>
                                    <td><?= $val['sales_man_name'] ?></td>-->
                    <!--<td><?= $val['remarks'] ?></td>-->
                                    <td><?= ucfirst($val['driver_name']) ?></td>
                                    <td><?= $val['vehicle_no'] ?></td>
                                </tr>

                                <?php
                                $i++;
                            }
                        } else {

                            $invoice_id = $val['id'];

                            $tot += $val['net_total'];
                            if ($val['credit_days'] > 0 && $val['created_date'] != '1970-01-01') {
                                $due_date = date('d-M-Y', strtotime($val['created_date'] . "+" . $val['credit_days'] . " days"));
                            } else {
                                $due_date = '-';
                            }
                            ?>
                            <tr>
                                <td class='first_td action-btn-align'><?= $i ?></td>
                                <td class="action-btn-align"><?= $val['inv_id'] ?></td>
                                <td><?php echo ($val['store_name']) ? $val['store_name'] : $val['name']; ?></td>

                                <?php
                                if (isset($quotation['inv_all_details']) && !empty($quotation['inv_all_details'])) {
                                    ?>
                                    <?php
                                    if (isset($quotation['inv_all_details'][$invoice_id]['in_id'])) {
                                        ?>
                                        <td class="action-btn-align"><?= round($quotation['inv_all_details'][$invoice_id]['quantity']) ?></td>
                                        <td class="text_right"><?= number_format(($quotation['inv_all_details'][$invoice_id]['cgst']), 2); ?></td>
                                        <td class="text_right"><?= number_format(($quotation['inv_all_details'][$invoice_id]['sgst']), 2); ?></td>

                                        <?php
                                    } else {
                                        ?>

                                        <td class="action-btn-align"><?= number_format($val['total_qty']) ?></td>
                                        <td class="text_right"><?= number_format(($val['erp_invoice_details'][0]['cgst']), 2); ?></td>
                                        <td class="text_right"><?= number_format(($val['erp_invoice_details'][0]['sgst']), 2); ?></td>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                } else {
                                    ?>
                                    <td class="action-btn-align"><?= number_format($val['total_qty']) ?></td>
                                    <td class="text_right"><?= number_format(($val['erp_invoice_details'][0]['cgst']), 2); ?></td>
                                    <td class="text_right"><?= number_format(($val['erp_invoice_details'][0]['sgst']), 2); ?></td>
                                <?php } ?>

                                <td class="text_right"><?= number_format($val['subtotal_qty'], 2); ?></td>
                                <td class="text_right"><?= number_format($val['net_total'], 2); ?></td>
                                <!--<td  class="text_right"><?php echo number_format(($val['receipt_bill'][0]['receipt_paid'] + $val['advance']), 2, '.', ',') ?></td>-->
                                <!--<td class="text_right"><?= number_format($val['return_amt'], 2, '.', ','); ?></td>-->
                                <!--<td class="text_right"><?= number_format(($val['net_total'] - $val['return_amt']) - (round($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'] + $val['advance'], 2)), 2, '.', ','); ?></td>-->
                                <td class="action-btn-align"><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td>
                                <!--<td class="action-btn-align"><?php echo ($val['receipt_bill'][0]['paid_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['paid_date'])) : '-'; ?></td>-->
                                <!--<td class="action-btn-align"><?= $val['credit_days'] > 0 ? $val['credit_days'] : '-'; ?></td>-->
                                <!--<td class="action-btn-align"><?= $due_date; ?></td>-->
                <!--                            <td class="action-btn-align"><?= ($val['credit_limit'] != '') ? $val['credit_limit'] : '-'; ?></td>
                                <td class="action-btn-align"><?= ($val['exceeded_limit'] != '') ? $val['exceeded_limit'] : '-'; ?></td>
                                <td><?= $val['sales_man_name'] ?></td>-->
                <!--<td><?= $val['remarks'] ?></td>-->
                                <td><?= ucfirst($val['driver_name']) ?></td>
                                <td><?= $val['vehicle_no'] ?></td>
                            </tr>

                            <?php
                            $i++;
                        }
                    }
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td class="action-btn-align total-bg"></td>
                <td class="text_right total-bg"></td>
                <td class="text_right total-bg"></td>
                <td class="text_right total-bg"></td>
                <!--<td class="text_right total-bg"></td>-->
                <!--<td class="text_right total-bg"></td>-->
                <!--<td class="text_right total-bg"></td>-->
                <td class="text_right total-bg"></td>
                <td></td>
                <td></td>
                <td></td>
              <!--<td ></td>-->
              <!--<td></td>-->
              <!--                <td></td>
              <td></td>
              <td class=""></td>-->

            </tr>
        </tfoot>

    </table>
</div>