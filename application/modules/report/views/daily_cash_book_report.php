<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-my-1.10.3.min.js"></script>
<style>
    table tr td:nth-child(2){text-align:center;}
    table tr td:nth-child(3){text-align:left;}
    table tr td:nth-child(4){text-align:center;}
    table tr td:nth-child(5){text-align:right;}
    table tr td:nth-child(6){text-align:center;}
    table td{white-space:unset; text-align:center;}
</style>
<div class="card">
    <?php
    $this->load->view("admin/main-printheader");
    ?>
    <div class="card-header">
        <h5>Cash Book Report
        </h5>
    </div>
    <div class="card-block table-border-style">
        <form class="" >
            <div class="form-material row">
                <div class="col-md-3">
                    <div class="material-group">
                        <div class="material-addone">
                            <i class="icofont icofont-address-book"></i>
                        </div>
                        <div class="form-group form-primary">
                            <select id='category' class="form-control">
                                <option>Select Category</option>
                                <?php
                                if (isset($all_category) && !empty($all_category)) {
                                    foreach ($all_category as $val) {
                                        ?>
                                        <option value='<?= $val['category_name'] ?>'><?= $val['category_name'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <span class="form-bar"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="float-label hide-color">Search</label>
                    <div>
                        <a id='search' class="submit btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light"> Search</a>
                    </div>
                </div>

            </div>
        </form>
    </div>
    <div class="card-block">

        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table id="basicTable" class="table table-striped table-bordered responsive">
                    <thead>
                        <tr>
                            <td class="action-btn-align">S.No</td>
                            <td>Created Date</td>
                            <td>Remarks</td>
                            <td>Category</td>
                            <td>Amount</td>
                            <td>Mode</td>

                        </tr>
                    </thead>
                    <tbody id='result_div' >

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
<script type="text/javascript">
    $('.print_btn').click(function () {
        window.print();
    });
    $('#search').on('click', function () {
        table.ajax.reload();
    });
</script>
<script type="text/javascript">
    $(document).ready(function ()
    {
        table = $('#basicTable').DataTable({
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
                url: BASE_URL + "report/daily_cash_book_ajaxList",
                "type": "POST",
                "data": function (data) {
                    data.category = $('#category').val();
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

