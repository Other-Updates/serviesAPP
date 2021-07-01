<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    table tbody tr td:nth-child(8){text-align: center;}
    table tbody tr td:nth-child(6){text-align: right;}
    table tbody tr td:nth-child(5){text-align: center;}
    table tbody tr td:nth-child(7){text-align: center;}
    @media print{
        table tr td:last-child{display:none;}
    }
</style>
<div class="card">
    <?php
    $this->load->view("admin/main-printheader");
    ?>
    <div class="card-header">
        <h5>Good Receive Note Report </h5>
    </div>
    <div class="card-block table-border-style">
        <form>
            <div class="form-material row">
                <div class="col-md-3">
                    <div class="material-group">
                        <div class="material-addone">
                            <i class="icofont icofont-address-book"></i>
                        </div>
                        <div class="form-group form-primary">
                            <select id='grn_no' class="form-control">
                                <option>Select GRN NO</option>
                                <?php
                                if (isset($all_grn) && !empty($all_grn)) {
                                    foreach ($all_grn as $val) {
                                        ?>
                                        <option value='<?= $val['grn_no'] ?>'><?= $val['grn_no'] ?></option>
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
                    <div class="material-group">
                        <div class="material-addone">
                            <i class="icofont icofont-address-book"></i>
                        </div>
                        <div class="form-group form-primary">
                            <select id='po_no' class="form-control">
                                <option>Select PO NO</option>
                                <?php
                                if (isset($all_style) && !empty($all_style)) {
                                    foreach ($all_style as $val) {
                                        ?>
                                        <option value='<?= $val['po_no'] ?>'><?= $val['po_no'] ?></option>
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
                    <div class="material-group">
                        <div class="material-addone">
                            <i class="icofont icofont-address-book"></i>
                        </div>
                        <div class="form-group form-primary">
                            <select id='supplier'  class="form-control">
                                <option>Select Vendor</option>
                                <?php
                                if (isset($all_supplier) && !empty($all_supplier)) {
                                    foreach ($all_supplier as $val) {
                                        ?>
                                        <option value='<?= $val['name'] ?>'><?= $val['name'] ?></option>
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
                    <div class="material-group">
                        <div class="material-addone">
                            <i class="icofont icofont-ui-calendar"></i>
                        </div>
                        <div class="form-group form-primary">
                            <label class="float-label">From Date</label>
                            <input tabindex="1" id="from_date" name="inv_date" data-date="" data-month="" data-year=""  class="form-control required dropper-default" type="text" placeholder="" />
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
                            <input tabindex="1" id="to_date" name="inv_date" data-date="" data-month="" data-year="" class="form-control required dropper-default" type="text" placeholder="" />
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
    <div class="card-block table-border-style">
        <div id='result_div' class="table-responsive">
            <table class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" id="basicTable">
                <thead>
                    <tr>
                        <td class="action-btn-align">S.No</td>
                        <td >GRN #</td>
                        <td>PO #</td>
                        <td>Vendor</td>
                        <td >GRN Qty</td>
                        <td >GRN Value</td>
                        <td >Date</td>
                        <td class="hide_class action-btn-align">Action</td>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            <div class="text-center m-10">
                <button class="btn btn-primary print_btn btn-sm waves-effect waves-light"> Print</button>
                <button class="btn btn-success excel_btn btn-sm waves-effect waves-light"> Excel</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('.print_btn').click(function () {
        window.print();
    });
    $('#search').on('click', function () {
        table.ajax.reload();
    });
</script>
<script>
    $(document).ready(function () {
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
                url: BASE_URL + "report/grn_ajaxList",
                "type": "POST",
                "data": function (data) {
                    data.po_no = $('#po_no').val();
                    data.grn_no = $('#grn_no').val();
                    data.supplier = $('#supplier').val();
                    data.from_date = $('#from_date').val();
                    data.to_date = $('#to_date').val();
                }
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
//                    "targets": [0, 11], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
        });
//        jQuery('.datepicker').datepicker();
    });
</script>