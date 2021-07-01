<table class="table table-striped table-bordered no-footer dtr-inline search_table_hide mb-0 mt-20">
    <?php
    if (isset($quotation) && !empty($quotation)) {
        ?>
        <tr>
            <td class="style">Conversion Ratio</td>
            <td class="style">
                <span class="badge bg-green total"></span>
                   <!--<input type="text" id='from_date' value="<?php echo $quotation[0]['count'] ?>/<?php echo $quotation[0]['count'] ?>" class=" form-control" name="inv_date" id="" style="width:100px">-->
            </td>
            <td class="style">Conversion Percentage</td>
            <td class="style">
                <span class="badge bg-green per"></span>
             <!--<input type="text"  id='to_date' class=" form-control" name="inv_date"  value="<?php echo number_format((float) $quotation[0]['percentage']); ?>" style="width:100px">-->

            </td>
        </tr>
    <?php }
    ?>
</table>
<table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
    <thead>
        <tr>
            <td>S.No</td>
            <td>Quotation No</td>
            <td>Customer Name</td>
            <td>Quotation Amount</td>
            <td>Quotation Date</td>
            <td>Job ID</td>
            <td>Project Cost Amount</td>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($quotation) && !empty($quotation)) {
            if ($quotation[0]['count'] == 0) {
                ?>
                <tr><td colspan="7">No data found...</td></tr>
                <?php
            } else {
                $i = 1;
                foreach ($quotation as $val) {
                    ?>
                    <tr>
                        <td class='first_td action-btn-align td_count'><?= $i ?></td>
                        <td><?= $val['q_no'] ?></td>
                        <td><?= $val['name'] ?></td>
                        <td class="text_right"><?= number_format($val['net_total'], 2); ?></td>
                        <td><?php echo date('d-M-Y', strtotime($val['created_date'])); ?></td>
                        <?php if (isset($val['pc_amount']) && !empty($val['pc_amount'])) { ?>
                            <td class="pc_count"><?php echo $val['pc_amount'][0]['job_id']; ?></td>
                            <td class="text_right"><?php echo number_format($val['pc_amount'][0]['net_total'], 2); ?></td>

                        <?php } else { ?>
                            <td></td><td></td>

                        </tr>
                        <?php
                    }
                    $i++;
                }
            }
        }
        ?>
    </tbody>
</table>
<div class="text-center m-10">
    <button class="btn btn-primary print_btn btn-sm waves-effect waves-light"> Print</button>
    <button class="btn btn-success excel_btn btn-sm waves-effect waves-light"> Excel</button>
</div>

<script>
    $('.print_btn').click(function () {
        window.print();
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {

        var tds = $('#basicTable').children('tbody').children('tr').find('.td_count').length;
        var td_pc = $('#basicTable').children('tbody').children('tr').find('.pc_count').length;
        var val = ((td_pc / tds) * 100).toFixed(2);
        $('.total').html(td_pc + "/" + tds);
        $('.per').html(val);
    });
</script>