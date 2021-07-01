<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-my-1.10.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<style>
    table tr td:nth-child(2){text-align:left;}
    table tr td:nth-child(3){text-align:left;}
    table tr td:nth-child(9){text-align:center;}
    table tr td:nth-child(10){text-align:center;}
    table tr td:nth-child(12){text-align:center;}
    table tr td:nth-child(13){text-align:center;}
    table td{white-space:unset; text-align:center;}
    table thead tr td{text-align:center !important;}
    @media print{
        @page {size:A4 landscape !important;}
        body table tr th, table tr td{font-size:8px !important;}
        .print-line {margin-bottom:15px !important;}
    }
    @page {size:A4 landscape;}
</style>
<div class="card">
    <?php
    $this->load->view("admin/main-printheader");
    ?>
    <div class="card-header">
        <h5>Monthly Attendance Report
        </h5>
    </div>
    <div class="card-block table-border-style">
        <form class="" name="form" method="post" action="<?php echo $this->config->item('base_url'); ?>report/monthly_attendance_report">
            <div class="form-material row">
                <div class="col-md-3">
                    <div class="material-group">
                        <div class="material-addone">
                            <i class="icofont icofont-ui-calendar"></i>
                        </div>
                        <div class="form-group form-primary">
                            <label class="float-label">From Date</label>
                            <?php
                            $default = '';
                            if (isset($start_date) && $start_date != "") {
                                $default = date("d-m-Y", strtotime($start_date));
                            }
                            ?>
                            <input tabindex="1" id="from_date" name="start_date" data-date="" data-month="" data-year="" value="<?php echo $default ?>"  class="form-control required dropper-default" type="text" placeholder="" />
                            <span class="form-bar"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="material-group">
                        <div class="material-addone">
                            <i class="icofont icofont-ui-calendar"></i>
                        </div>
                        <div class="form-group form-primary">
                            <label class="float-label">To Date</label>
                            <?php
                            $default = '';
                            if (isset($end_date) && $end_date != "") {
                                $default = date("d-m-Y", strtotime($end_date));
                            }
                            ?>
                            <input tabindex="1" id="to_date" name="end_date" value="<?php echo $default ?>" data-date="" data-month="" data-year="" class="form-control required dropper-default" type="text" placeholder="" />
                            <span class="form-bar"></span>
                        </div>
                    </div>

                </div>
                <div class="col-md-3">
                    <label class="float-label hide-color">Search</label>
                    <div>
                        <input type="submit" name="search" value="Search" id="search" class="submit btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light" title="Search">
                    </div>
                </div>

            </div>
        </form>
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
        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table id="basicTable" class="table table-striped table-bordered responsive">
                    <thead>
                        <tr>
                            <td rowspan="2" class="action-btn-align">S.No</td>
                            <td rowspan="2">EMP ID</td>
                            <td rowspan="2">Name</td>
                            <td style="text-align: center;" colspan="<?= count($days_array) ?>">Status</td>
                        </tr>
                        <tr>
                            <?php for ($d = 0; $d <= count($days_array) - 1; $d++) {
                                ?>
                                <td align="center"><?php
                                    $current_day = explode("-", $days_array[$d]);
                                    $jd = gregoriantojd($current_day[1], $current_day[0], $current_day[2]);
                                    $m_name = jdmonthname($jd, 0);
                                    echo $m_name . " " . $current_day[0];
                                    ?></td>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody id='result_div' >
                        <?php
                        if (!empty($monthly_reports)) {
                            foreach ($monthly_reports as $key => $report_data) {
                                ?>
                                <tr>
                                    <td> <?php echo $key + 1; ?></td>
                                    <td><?php echo $report_data['emp_code']; ?></td>
                                    <td class="action-btn-align" style="text-align: center;"><?php echo ucwords($report_data['name']); ?><br><hr/><span style="color: #448aff;">Work Details</span></td>
                                    <?php
                                    foreach ($report_data['monthly_works'] as $key1 => $over_data) {
                                        ?>                                                                                                                                                                                                                                                                                                                                                                                                                                             <!--<td><?php echo $over_data['over_all_attenance'] . " " . $over_data['overall_break'] . " " . $over_data['work_time'] . " " . $over_data['month_attenance']; ?></td>-->
                                        <td class="btn-center"><span><?php echo $over_data['month_attenance']; ?></span><br><hr/><span><?php echo $over_data['location']; ?></span></td>
                                    <?php } ?>
                                </tr>
                                <?php
                            }
                        } else {
                            $days_array_count = count($days_array);
                            if (count($days_array) == 0)
                                $days_array_count = 1;
                            $colspan = 7 + $days_array_count;
                            ?>
                            <tr><td colspan="<?php echo $colspan; ?>">No Results Found</td></tr>
                        <?php } ?>

                    </tbody>
                </table>

                <div class="text-center m-10">
                    <button class="btn btn-primary print_btn btn-sm waves-effect waves-light"> Print</button>
                    <button class="btn btn-success excel_btn btn-sm waves-effect waves-light" >Excel</button>
                </div>
            </div>

        </div>
    </div>
</div>
<script>
    $(".dropper-default").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        maxYear: new Date().getFullYear() + 50,
        format: 'd-M-Y',
    });
    $('.print_btn').click(function () {
        window.print();
    });
</script>
<script type="text/javascript">
    $('#search').on('click', function () {
        table.ajax.reload();
    });
</script>
<script type="text/javascript">
    $(document).ready(function ()
    {
        $('#basicTable').DataTable({
            "ordering": false
        });
        $('#basicTable1').DataTable({
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "language": {
                "infoFiltered": ""
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                url: BASE_URL + "report/monthly_attendance_ajaxList",
                "type": "POST",
                "data": function (data) {
                    data.from_date = $('#from_date').val();
                    data.to_date = $('#to_date').val();
                }
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
//                        "targets": [0, 9], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
        });
    });
</script>
