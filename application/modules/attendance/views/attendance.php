<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<style>

    table tr td:nth-child(3) {
        text-align:left !important;
    }
    table tr td:nth-child(2) {
        text-align:center !important;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="tab-header card">
            <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                <li class="nav-item col-md-2">
                    <a class="nav-link active" data-toggle="tab" href="#expense-details" role="tab">Attendance List</a>
                    <div class="slide"></div>
                </li>

            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="expense-details" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">Attendance List</h5>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table class="table table-striped table-bordered" id="exp_table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Employee ID</th>
                                        <th>Employee Name</th>
                                        <th>Status</th>

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
    $(".dropper-default").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        maxYear: new Date().getFullYear() + 50,
        format: 'm-Y'
    });
    $(document).ready(function () {
        var table;
        table = $('#exp_table').DataTable({
            "lengthMenu": [[10 , 25 ,50, 100, -1], [10 , 25 , 50, 100, "All"]],
            //"lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],
            "language": {
                "infoFiltered": ""
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "retrieve": true,
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('attendance/attendance/attendance_ajaxList/'); ?>",
                "type": "POST",
                "data": function (data) {
                    data.month = $('#month').val();

                }
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0, 3], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
            "footerCallback": function (row, data, start, end, display) {
                var api = this.api(), data;
                // Remove the formatting to get integer data for summation
                var intVal = function (i) {
                    return typeof i === 'string' ?
                            i.replace(/[\$,]/g, '') * 1 :
                            typeof i === 'number' ?
                            i : 0;
                };
                // Total over all pages
                var cols = [2];
                var numFormat = $.fn.dataTable.render.number('\,', '.', 2).display;
                for (x in cols) {
                    total = api.column(cols[x]).data().reduce(function (a, b) {

                        return intVal(a) + intVal(b);
                    }, 0);
                    // Total over this page
                    pageTotal = api.column(cols[x], {page: 'current'}).data().reduce(function (a, b) {
                        if (b.indexOf('--') !== -1) {
                            var test = b.split('--');
                            b = 0;
                            //for (var j = 0, len = test.length; j < len; j++) {
                            b = intVal(b) + intVal(test[0]);
                            // }
                        }
                        return intVal(a) + intVal(b);
                    }
                    , 0);
                    // Update footer
//                    if (Math.floor(pageTotal) == pageTotal && $.isNumeric(pageTotal)) {
//                        pageTotal = pageTotal;
//
//                    } else {
//                        pageTotal = pageTotal.toFixed(2);/* float */
//
//                    }
                    $(api.column(cols[x]).footer()).html(numFormat(pageTotal));
                }


            },
            responsive: true,
            columnDefs: [
                {responsivePriority: 1, targets: 0},
                {responsivePriority: 2, targets: -2}
            ]
        });
    });
</script>

