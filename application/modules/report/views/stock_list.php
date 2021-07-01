<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-my-1.10.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<style>
    table tr td:nth-child(6){text-align:center;}
    @media print{

        table tr td:nth-child(5){white-space:unset !important;}
    }
</style>
<div class="card">
    <?php
    $this->load->view("admin/main-printheader");
    ?>
    <div class="card-header">
        <h5>Stock List
        </h5>
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

                            <select id='category' class="form-control">
                                <option>Select Category</option>
                                <?php
                                if (isset($cat) && !empty($cat)) {
                                    foreach ($cat as $val) {
                                        ?>
                                        <option value='<?= $val['cat_id'] ?>'><?= $val['categoryName'] ?></option>
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

                            <select id='brand'  class="form-control">
                                <option>Select Brand</option>
                                <?php
                                if (isset($brand) && !empty($brand)) {
                                    foreach ($brand as $val) {
                                        ?>
                                        <option value='<?= $val['id'] ?>'><?= $val['brands'] ?></option>
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

                            <select id='product'  class="form-control">
                                <option>Select Model No</option>
                                <?php
                                if (isset($product) && !empty($product)) {
                                    foreach ($product as $val) {
                                        ?>
                                        <option value='<?= $val['id'] ?>'><?= $val['model_no'] ?></option>
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
    <div class="card-block table-border-style">
        <div  class="table-responsive">
            <table id="basicTable" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline" >
                <thead>
                    <tr>
                        <td class="action-btn-align">S.No</td>
                        <td>Category</td>
                        <td>Brand</td>
                        <td>Model #</td>
                        <td>Product</td>
                        <td class="action-btn-align">Quantity</td>

                    </tr>
                </thead>
                <tbody id='result_div'>

                </tbody>
            </table>

            <div class="text-center m-10">
                <button class="btn btn-primary print_btn btn-sm waves-effect waves-light">Print</button>
                <button class="btn btn-success excel_btn btn-sm waves-effect waves-light"> Excel</button>
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
        format: 'd-M-Y'
    });
    $('.print_btn').click(function () {
        window.print();
    });
    $('#search').live('click', function () {
        table.ajax.reload();
//        for_loading();
//        $.ajax({
//            url: BASE_URL + "report/stock_search_result",
//            type: 'GET',
//            data: {
//                brand: $('#brand').val(),
//                model_no: $('#product').val(),
//                category: $('#category').val(),
//            },
//            success: function (result) {
////                for_response();
//                $('#result_div').html('');
//                $('#result_div').html(result);
//            }
//        });
    });
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
                url: BASE_URL + "report/stock_ajaxList",
                "type": "POST",
                "data": function (data) {
                    data.brand = $('#brand').val();
                    data.product = $('#product').val();
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