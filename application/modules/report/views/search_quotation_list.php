
<?php
if (isset($quotation) && !empty($quotation)) {
    $i = 1;
    foreach ($quotation as $val) {
        ?>
        <tr>
            <td class='first_td'><?= $i ?></td>
            <td><?= $val['q_no'] ?></td>
            <td><?= $val['name'] ?></td>
            <td class="action-btn-align"><?= $val['total_qty'] ?></td>
            <td class="action-btn-align"><?= number_format($val['tax_details'][0]['tot_tax'], 2); ?></td>
            <td class="text-right"><?= number_format($val['subtotal_qty'], 2); ?></td>
            <td class="text-right"><?= number_format($val['net_total'], 2); ?></td>
        <!--            <td class="text-right"><?= number_format($val['advance'], 2); ?></td>
            <td><?= ($val['delivery_schedule'] != '1970-01-01') ? date('d-M-Y', strtotime($val['delivery_schedule'])) : ''; ?></td>
            <td><?= ($val['notification_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['notification_date'])) : ''; ?></td>-->
            <td><?= $val['mode_of_payment'] ?></td>
            <td><?= ($val['created_date'] != '1970-01-01') ? date('d-M-Y', strtotime($val['created_date'])) : ''; ?></td>
            <td>
                <?php
                if ($val['estatus'] == 1) {
                    ?>
                    <span class=" label label-danger"> <?php echo 'Pending'; ?></span>

                    <?php
                }
                if ($val['estatus'] == 2) {
                    ?>
                    <span class=" label label-success"> <?php echo 'Completed'; ?></span>
                    <?php
                }
                if ($val['estatus'] == 4) {
                    ?>
                    <span class="label label-info"> <?php echo 'Order Approved'; ?></span>
                    <?php
                }
                if ($val['estatus'] == 5) {
                    ?>
                    <span class="label label-warning"> <?php echo 'Order Reject'; ?></span>
                    <?php
                }
                ?>
            </td>

            <td class="hide_class action-btn-align">  <a href="<?php echo $this->config->item('base_url') . 'quotation/quotation_view/' . $val['id'] ?>" data-toggle="tooltip" class="btn btn-info btn-mini waves-effect waves-light" title="" data-original-title="View" ><span class="fa fa-eye"></span></a>
            </td>

        </tr>
        <?php
        $i++;
    }
} else {
    echo '<tr><td colspan="11">Data not found...</td></tr>';
}
?>