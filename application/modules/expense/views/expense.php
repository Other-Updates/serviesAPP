<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/datedropper/css/datedropper.min.css" />
<script type="text/javascript" src="<?= $theme_path; ?>/bower_components/datedropper/js/datedropper.min.js"></script>
<style>
    .input-group-addon .fa { width:10px !important; }
    td a {
        border: 0px solid #cbced4 !important;
    }
    .ui-datepicker td.ui-datepicker-today a {
        background:999999;
    }
    #ui-datepicker-div {
        z-index: 4 !important;
    }

    table tr td:nth-child(7) {
        text-align:center !important;
    }
    table tr td:nth-child(6) {
        text-align:center !important;
    }
    table tr th {
        text-align:center;
    }
    table tr td:nth-child(4) {
        text-align:center !important;
    }
    table tr td:nth-child(6) {
        text-align:center !important;
    }
    table tr td:nth-child(2) {
        text-align:center !important;
    }
    table tr td:nth-child(5) {
        text-align:right !important;
    }
    .mtop4{margin-top:-10px;}
    .total_bg {
        background: #448aff;
        color: #fff;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <div class="tab-header card">
            <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                <li class="nav-item col-md-2">
                    <a class="nav-link active" data-toggle="tab" href="#expense-details" role="tab">Spending List</a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item col-md-2">
                    <a class="nav-link <?php if (!$this->user_auth->is_action_allowed('expense', 'expense', 'add')): ?>alerts<?php endif ?>" data-toggle="tab" href="<?php if ($this->user_auth->is_action_allowed('expense', 'expense', 'add')): ?>#userrole<?php endif ?>" role="tab">Add Spending</a>
                    <div class="slide"></div>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="expense-details" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">Spending List</h5>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table class="table table-striped table-bordered" id="exp_table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Date</th>
                                        <th>Remarks</th>
                                        <th>Category</th>
                                        <th>Amount</th>
                                        <th>Mode</th>
                                        <th class="action-btn-align">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td class="total_bg" style="text-align: right !important;"></td>
                                        <td></td>
                                        <td class="hide_class"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="userrole" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">Add Spending</h5>
                    </div>
                    <div class="card-block">
                        <form class="form-material" name="myform" method="post" action="<?php echo $this->config->item('base_url'); ?>expense/expense/add/">
                            <div class="form-material row">
                                <!--<div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-ui-user"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <select name="exp[exp_type]" id="exp_type" class="form-control form-align required">
                                                <option value="">Expense Type</option>
                                                <option value="fixed">Fixed</option>
                                                <option value="variable">Variable</option>
                                            </select>

                                            <span class="error_msg"></span>

                                        </div>
                                    </div>
                                </div>-->
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-ui-user"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <select name="exp[exp_cat_type]" id="exp_cat_type" class="form-control form-align required">
                                                <option value="">Select Category</option>

                                            </select>
                                            <span class="form-bar"></span>
                                            <span class="error_msg"></span>
                                            <input type="hidden" name="exp[company_amount]" id="company_amount" value="0" >
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-money-bag"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Spending Amount <span class="req">*</span></label>
                                            <input type="text" name="exp[exp_amount]" class=" form-align required form-control" id="exp_amount" maxlength="10"/>
                                            <span class="form-bar"></span>
                                            <span class="error_msg"></span>

                                        </div>
                                    </div>
                                </div>

                                <!--<div class="col-md-3">
                                     <div class="form-group form-primary">
                                         <div class="col-md-12 new-style-form">
                                             <span class="help-block">Expense Type<span class="req">*</span></span>
                                         </div>

                                         <div class="form-radio col-lg-12">

                                             <div class="radio radiofill radio-primary radio-inline">
                                                 <label>
                                                     <input type="radio" name="exp[exp_type]" value="fixed"  data-bv-field="type" class="form-check-input exp_type required">
                                                     <i class="helper"></i>Fixed
                                                 </label>
                                             </div>
                                             <div class="radio radiofill radio-primary radio-inline">
                                                 <label>
                                                     <input type="radio" name="exp[exp_type]" value="variable"  data-bv-field="type" class="form-check-input exp_type required">
                                                     <i class="helper"></i>Variable
                                                 </label>
                                             </div>

                                         </div>
                                         <span class="error_msg"></span>
                                     </div>
                                 </div> -->

                                <div class="col-md-3">
                                    <div class="form-group form-primary">
                                        <div class="col-md-12 new-style-form">
                                            <span class="help-block">Spending Mode</span>
                                        </div>

                                        <div class="form-radio col-lg-12">

                                            <div class="radio radiofill radio-primary radio-inline">
                                                <label>
                                                    <input type="radio" name="exp[exp_mode]" value="credit"  data-bv-field="type" class="form-check-input  required exp_mode" checked="">
                                                    <i class="helper"></i>Income
                                                </label>
                                            </div>
                                            <div class="radio radiofill radio-primary radio-inline">
                                                <label>
                                                    <input type="radio" name="exp[exp_mode]" value="debit"  data-bv-field="type" class="form-check-input  required exp_mode">
                                                    <i class="helper"></i>Expense
                                                </label>
                                            </div>

                                        </div>
                                        <span class="error_msg"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="fa fa-pencil"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Remarks </label>
                                            <input type="text" name="exp[remarks]" class="store form-control" id="remarks"/>
                                            <span class="form-bar"></span>
                                            <span class="error_msg"></span>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-ui-calendar"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Expense Date <span class="req">*</span></label>
                                            <input id="dropper-default" name="exp[exp_date]" data-date="" data-month="" data-year="" value="<?php echo date('d-M-Y'); ?>" class="form-control " type="text" placeholder="" />
                                            <span class="form-bar"></span>
                                            <span class="error_msg"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row text-center m-10">
                                <div class="col-md-12 text-center">
                                    <input type="submit" name="submit" class="btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light" value="Save" id="submit" tabindex="1"/>
                                    <input type="reset" value="Clear" class="btn btn-danger waves-effect m-b-10 btn-sm waves-light" id="cancel" tabindex="1"/>
                                    <a href="<?php echo $this->config->item('base_url') . 'expense' ?>" class="btn btn-inverse btn-sm waves-effect waves-light m-b-10" tabindex="1"> Back </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#dropper-default").dateDropper({
        dropWidth: 200,
        dropPrimaryColor: "#1abc9c",
        dropBorder: "1px solid #1abc9c",
        maxYear: new Date().getFullYear() + 50,
        format: 'd-M-Y'
    });
    $(document).ready(function () {

        $('#submit').on('click', function () {

            m = 0;
            $('.required').each(function () {
                this_val = $.trim($(this).val());
                this_id = $(this).attr('id');
                this_ele = $(this);
                if (this_val == '') {
                    $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
                    m++;
                } else {
                    $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                }
            });

            if (m > 0)
                return false;
        });

        var table;
        table = $('#exp_table').DataTable({
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
                "url": "<?php echo site_url('expense/expense/expenses_ajaxList/'); ?>",
                "type": "POST",
                "data": function (data) {
                    data.cat_id = $('#ex_category').val();
                    data.from_date = $('#from_date').val();
                    data.to_date = $('#to_date').val();
                }
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0, 7], //first column / numbering column
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
                var cols = [4];

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
    //$('#exp_type').change(function () {
    //exp_type = $('#exp_type option:selected').val();

    //if (exp_type != '') {
    $.ajax({
        type: "POST",
        url: '<?php echo site_url("expense/expense/get_expense_categories"); ?>',
        //data: {exp_type: exp_type},
        dataType: "json",
        success: function (data) {
            var html = '';
            var i;

            html = '<option value="">' + 'Select Category' + '</option>';
            for (i = 0; i < data.length; i++) {

                html += '<option value=' + data[i].id + '>' + data[i].category_name + '</option>';
            }
            $('#exp_cat_type').html(html);

        }
    });
    // }
    //});
    //$('.exp_type').on('change', function () {
    // var exp_type = $('.exp_type:checked').length;
    //if (exp_type == 0) {
    //    $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
    //} else {
    //    $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
    //}
    //});
    $('#exp_amount').on('keyup blur', function () {
        this_val = $.trim($(this).val());
        if ($.trim($(this).val()) == '') {
            $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
        } else {
            $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
        }
    });
    $('#exp_cat_type').on('change', function () {
        var category = $('#exp_cat_type').val();
        if (category == '') {
            $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
        } else {
            $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
        }
    });
    $('#exp_cat_type').change(function () {

        $('#exp_amount').val('');
        $.ajax({
            url: BASE_URL + "expense/expense/get_company_amount",
            method: 'post',
            data: {firm_id: ''},
            dataType: 'json',
            success: function (result) {
                if (result[0].company_amount != null && result[0].company_amount > 0) {
                    $("#company_amount").val(result[0].company_amount);
                } else {
                    $("#company_amount").val('0');
                }
            }
        });
    });</script>



<script>

    onload = function () {
        var exp_amount = document.querySelectorAll('#exp_amount')[0];
        exp_amount.onkeypress = function (e) {
            if (isNaN(this.value + "" + String.fromCharCode(e.charCode)))
                return false;
        }
        exp_amount.onpaste = function (e) {
            e.preventDefault();
        }
    }
</script>