<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    table tr td:nth-child(8){text-align:center;}
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="tab-header card">
            <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                <li class="nav-item col-md-2">
                    <a class="nav-link active" data-toggle="tab" href="#expense-details" role="tab">Attendance Reports</a>
                    <div class="slide"></div>
                </li>

            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="expense-details" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">Monthly Attendance Reports</h5>
                    </div>
                    <div class="card-block">
                        <?php
                        $s_date = date('d-m-Y', strtotime($start_date));
                        $std_dt = $end_date . " 00:00:00";

                        $exclude_date = new DateTime($std_dt . ' +1 day');
                        $e_date = $exclude_date->format('d-m-Y');
                        $start = new DateTime($s_date . ' 00:00:00');
                        $end = new DateTime($e_date . ' 00:00:00');

                        $interval = new DateInterval('P1D');
                        $period = new DatePeriod($start, $interval, $end);


                        foreach ($period as $date) {
                            $days_array[] = $date->format('d-m-Y');
                        }
                        ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="exp_tablee">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Employee&nbsp;ID&nbsp;</div></th>
                                        <th>Emp&nbsp;Name&nbsp;</th>
                                        <th style="text-align: center;" colspan="<?= count($days_array) ?>"> Period / Hours of Over Time</th>
                                        <th  colspan="<?= count($days_array) ?>"> &nbsp;No.of&nbsp;working&nbsp;days&nbsp;</th>

                                    </tr>

                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>








<script type="text/javascript">

    $(document).ready(function () {


        $('#monthly_attendance_table').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                url: BASE_URL + "report/monthly_attendance_ajaxList",
                "type": "POST",
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0, 4], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
        });
    });
</script>