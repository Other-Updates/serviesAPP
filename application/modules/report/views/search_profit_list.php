<table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
    <thead>
        <tr>
            <td>S.No</td>
            <td>Quotation No</td>
            <td>Customer Name</td>
            <td>Quotation Amount</td>
            <td>Invoice NO</td>
            <td>Invoice Date</td>
            <td>Invoice Amount</td>
            <td>Job ID</td>
            <td>Project Cost Amount</td>
            <td>Profit %</td>
            <td>Profit Amount</td>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($quotation) && !empty($quotation)) {
            $i = 1;
            foreach ($quotation as $val) {
                ?>
                <tr>
                    <td class='first_td'><?= $i ?></td>
                    <td><?= $val['q_no'] ?></td>
                    <td><?= $val['name'] ?></td>
                    <td><?= number_format($val['net_total'], 2); ?></td>
                    <?php if (isset($val['pc_amount']) && !empty($val['pc_amount'])) { ?>
                        <?php if (isset($val['inv_amount']) && !empty($val['inv_amount'])) { ?>
                            <td><?php echo $val['inv_amount'][0]['inv_id']; ?></td>
                            <td><?php echo date('d-M-y', strtotime($val['inv_amount'][0]['created_date'])); ?></td>
                            <td><?php echo number_format($val['inv_amount'][0]['net_total'], 2);
                ;
                            ?></td>

            <?php } else { ?>
                            <td></td>
                            <td></td>
                            <td></td>

                        <?php }
                    } else {
                        ?>
                        <td></td>
                        <td></td>
                        <td></td>

        <?php } ?>
                        <?php if (isset($val['pc_amount']) && !empty($val['pc_amount'])) { ?>
                        <td><?php echo $val['pc_amount'][0]['job_id']; ?></td>
                        <td style="text-align: right;"><?php echo number_format($val['pc_amount'][0]['net_total'], 2);
                ;
                            ?></td>
                        <td style="text-align: right;"><?php
                if ($val['inv_amount'][0]['net_total'] != '')
                    echo number_format(((($val['inv_amount'][0]['net_total'] - $val['pc_amount'][0]['net_total']) * 100) / (float) $val['pc_amount'][0]['net_total']), 2, '.', ',') . '%';
                            ?>
                        </td>
                        <td style="text-align: right;"><?php
                        if ($val['inv_amount'][0]['net_total'] != '')
                            echo number_format(($val['inv_amount'][0]['net_total'] - $val['pc_amount'][0]['net_total']), 2, '.', ',');
                        ?></td>
        <?php } else { ?>
                        <td></td>
                        <td></td>
                        <td></td>

                    </tr>
                    <?php
                }
                $i++;
            }
        } else {
            echo '<tr><td colspan="11">Data not found...</td></tr>';
        }
        ?>
    </tbody>
</table>
<div class="text-center m-10">
    <button class="btn btn-primary print_btn btn-sm waves-effect waves-light"> Print</button>
    <button class="btn btn-success excel_btn btn-sm waves-effect waves-light"> Excel</button>
</div>
