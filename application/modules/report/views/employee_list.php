<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-my-1.10.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<style>    
    table tr td:nth-child(6){text-align:left;}
    table tr td:nth-child(12){text-align:center;}
    table tr td:nth-child(5){text-align:left;}
	table tr td:nth-child(4){text-align:center;}
</style>
<div class="card">
    <?php
    $this->load->view("admin/main-printheader");
    ?>
    <div class="">

        <div class="card-header">
            <h5>Employee List
            </h5>
        </div>

        <div class="card-block table-border-style">
            <div class="table-responsive">
                <table id="basicTable" class="table table-striped table-bordered responsive">
                    <thead>
                    <td>S.No</td>
                    <td>Employee ID</td>
                    <td>Name</td>
                    <td>Mobile Number</td>
                    <td>Role</td>
                    <td>Email</td>
                    <tbody>
                    </tbody>
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
                    url: BASE_URL + "report/employee_ajaxList",
                    "type": "POST",
                },
                //Set column definition initialisation properties.
                "columnDefs": [
                    {
//                        "targets": [0, 9], //first column / numbering column
                        "orderable": false, //set not orderable
                    },
                ],
            });
            $("#yesin").on("click", function ()
            {

                var hidin = $(this).parent().parent().find('.id').val();
                // alert(hidin);
                $.ajax({
                    url: BASE_URL + "quotation/quotation_delete",
                    type: 'POST',
                    data: {value1: hidin},
                    success: function (result) {

                        window.location.reload(BASE_URL + "quotation/quotation_list");
                    }
                });

            });

            $('.modal').css("display", "none");
            $('.fade').css("display", "none");

        });
    </script>
