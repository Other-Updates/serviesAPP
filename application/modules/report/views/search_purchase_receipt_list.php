<?php
$paid = $bal = $inv = 0;
if (isset($all_receipt) && !empty($all_receipt)) {
    $i = 1;
    foreach ($all_receipt as $val) {
        $inv = $inv + $val['net_total'];
        $paid = $paid + $val['receipt_bill'][0]['receipt_paid'];
        $bal = $bal + ($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount']));
        ?>
        <tr>
            <td class='first_td'><?= $i ?></td>
            <td><?= $val['po_no'] ?></td>
            <td><?= $val['store_name'] ?></td>
            <td  class="text_right"><?= number_format($val['net_total'], 2, '.', ',') ?></td>
            <td  class="text_right"><?= number_format($val['receipt_bill'][0]['receipt_paid'], 2, '.', ',') ?></td>
            <td  class="text_right"><?= number_format($val['receipt_bill'][0]['receipt_discount'], 2, '.', ',') ?></td>
            <td  class="text_right"><?= number_format(($val['net_total'] - ($val['receipt_bill'][0]['receipt_paid'] + $val['receipt_bill'][0]['receipt_discount'])), 2, '.', ',') ?></td>
            <td><?= ($val['receipt_bill'][0]['next_date'] != '') ? date('d-M-Y', strtotime($val['receipt_bill'][0]['next_date'])) : ''; ?></td>
            <td class="hide_class action-btn-align">
        <?php
        if ($val['payment_status'] == 'Pending') {
            echo '<a href="#" data-toggle="modal" class="tooltips ahref" title="In-Complete"><span class="fa fa-thumbs-down blue">&nbsp;</span></a>';
        } else {
            echo '<a href="#" data-toggle="modal" class="tooltips ahref" title="Complete"><span class="fa fa-thumbs-up green">&nbsp;</span></a>';
        }
        ?>
            </td>

        </tr>
                <?php
                $i++;
            }
            ?>
    <!--                <tfoot>
    <tr>
    <td></td>
    <td></td>
    <td></td>
    <td class="text_right"><?= number_format($inv, 2, '.', ',') ?></td>
    <td class="text_right"><?= number_format($paid, 2, '.', ',') ?></td>
    <td></td>
    <td class="text_right"><?= number_format($bal, 2, '.', ',') ?></td>
    <td></td>
    <td class="hide_class"></td>

    </tr>
    </tfoot>-->
    <?php
} else {
    ?>
    <tr><td colspan="9">No data found...</td></tr>
    <?php
}
?>