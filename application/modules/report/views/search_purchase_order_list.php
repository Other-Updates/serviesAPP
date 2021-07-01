
<?php
if (isset($po) && !empty($po)) {
    $i = 1;
    foreach ($po as $val) {
        ?>
        <tr>
            <td class='first_td'><?= $i ?></td>
            <td><?= $val['po_no'] ?></td>
            <td><?= $val['store_name'] ?></td>
            <td class="text-center"><?= $val['total_qty'] ?></td>
        <!--                                    <td><?= $val['tax'] ?></td> -->
            <td class="text-right"><?= number_format($val['subtotal_qty'], 2); ?></td>
            <td class="text-right"><?= number_format($val['net_total'], 2); ?></td>
            <!--<td class="text-center"><?= $val['delivery_schedule'] ?></td>-->
            <td><?= $val['mode_of_payment'] ?></td>
            <td><?= $val['remarks'] ?></td>

            <td class='hide_class  action-btn-align'>
        <!--<a href="<?php echo $this->config->item('base_url') . 'purchase_order/po_edit/' . $val['id'] ?>" data-toggle="tooltip" class="tooltips btn btn-info btn-xs" title="" data-original-title="Edit"><span class="fa fa-edit "></span></a>
           <a href="#test3_<?php echo $val['id']; ?>" data-toggle="modal" name="delete" class="tooltips btn btn-danger btn-xs" title="In-Active"><span class="fa fa-ban"></span></a>-->
                <a href="<?php echo $this->config->item('base_url') . 'purchase_order/po_view/' . $val['id'] ?>" data-toggle="tooltip" class=" btn btn-info btn-mini waves-effect waves-light" title="" data-original-title="View" ><span class="fa fa-eye"></span></a>
            </td>
        </tr>
        <?php
        $i++;
    }
} else {
    echo '<tr><td colspan="9">Data not found...</td></tr>';
}
?>