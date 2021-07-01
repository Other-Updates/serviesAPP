<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    #petty_cash_table tbody tr td:nth-child(2){text-align:center;}
    #petty_cash_table tbody tr td:nth-child(3){text-align:center;}
    #petty_cash_table tbody tr td:nth-child(4){text-align:right;}
    #petty_cash_table tbody tr td:nth-child(5){text-align:left !important;}
    .form-material .float-label {
        pointer-events: none;
        position: absolute;
        top: -9px;
        left: 0;
        font-size: 11px;
        font-weight: 400;
        transition: 0.2s ease all;
        -moz-transition: 0.2s ease all;
        -webkit-transition: 0.2s ease all;
    }
    .total_bg {
        background: #448aff;
        color: #fff;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card ">
            <div class="card-header">
                <h5 class="card-header-text">Petty Cash Amount</h5>
            </div>
            <div class="card-block">
                <div role="tabpanel" class="tab-pane active" id="email">
                    <form class="form-material" action="<?php echo $this->config->item('base_url'); ?>expense/update_petty_cash_amount" enctype="multipart/form-data" name="form" method="post" >
                        <div class="form-material row">
                            <div class="col-md-3">
                                <div class="material-group">
                                    <div class="form-group form-primary">
                                        <label class="float-label">Petty Cash Amount</label>
                                        <input type="text" name="amount" class="form-control company_amount required" value="" id="company_amt" tabindex="1">
                                        <span class="form-bar"></span>
                                        <span class="error_msg"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="material-group">
                                    <div class="form-group form-primary">
                                        <label class="float-label">Remarks</label>
                                        <input type="text" name="remarks" class="form-control remarks" value="" id="remarks" tabindex="1">
                                        <span class="form-bar"></span>
                                        <span class="error_msg"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group form-primary">
                                    <div class="form-radio col-lg-12 mt-2">
                                        <div class="radio radiofill radio-primary radio-inline">
                                            <label>
                                                <input type="radio" name="company_type" value="add"  data-bv-field="type" class="form-check-input company_type required">
                                                <i class="helper"></i>Add
                                            </label>
                                        </div>
                                        <div class="radio radiofill radio-primary radio-inline">
                                            <label>
                                                <input type="radio" name="company_type" value="subtract"  data-bv-field="type" class="form-check-input company_type required">
                                                <i class="helper"></i>Subtract
                                            </label>
                                        </div>

                                    </div>
                                    <span class="error_msg"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row text-center mt-20">
                            <div class="col-md-12 text-center">
                                <input type="submit" name="submit" class="btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light" value="Save" id="submit" tabindex="1"/>
                            </div>
                        </div>
                    </form>
                </div>
                <table id="petty_cash_table" class="table table-striped table-bordered responsive dataTable no-footer dtr-inline  ">
                    <thead>
                        <tr>
                            <td class="action-btn-align">S.No</td>
                            <td class="action-btn-align">Created Date</td>
                            <td class="action-btn-align">Mode</td>
                            <td class="action-btn-align">Amount</td>
                            <td class="action-btn-align">Remarks</td>
                        </tr>
                    </thead>
                    <tbody >
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td  class="total_bg" style="text-align: right !important;"></td>
                            <td class="hide_class"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        var table;
        table = $('#petty_cash_table').DataTable({
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "language": {
                "infoFiltered": ""
            },
            //"lengthMenu": [[50, 100, 150, -1], [50, 100, 150, "All"]],
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "retrieve": true,
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('expense/expense/petty_cash_ajaxList/'); ?>",
                "type": "POST",
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
//                    "targets": [0, 7], //first column / numbering column
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
                var cols = [3];

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
        $('.required').on('blur', function () {
            this_val = $.trim($(this).val());
            this_id = $(this).attr('id');
            this_ele = $(this);
            if (this_val == '') {
                $(this).closest('div.form-group').find('.error_msg').text('Enter Valid Amount').slideDown('500').css('display', 'inline-block');
            } else {
                $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
            }
        });

        $('#submit').on('click', function () {
            m = 0;
            $('.required').each(function () {
                this_val = $.trim($(this).val());
                this_id = $(this).attr('id');
                this_ele = $(this);
                if (this_val == '') {
                    $(this).closest('div.form-group').find('.error_msg').text('Enter Valid Amount').slideDown('500').css('display', 'inline-block');
                    m++;
                } else {
                    $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                }
            });
            var company_type = $('.company_type:checked').length;
            if (company_type == 0) {
                $('.company_type').closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
                m++;
            } else {
                $('.company_type').closest('div.form-group').find('.error_msg').text('').slideUp('500');
            }
            if (m > 0)
                return false;
        });
    });
</script>