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
                    <a class="nav-link active" data-toggle="tab" href="#expense-details" role="tab">Category List</a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item col-md-2">
                    <a class="nav-link <?php if (!$this->user_auth->is_action_allowed('masters', 'expense_category', 'add')): ?>alerts<?php endif ?>" data-toggle="tab" href="<?php if ($this->user_auth->is_action_allowed('masters', 'expense_category', 'add')): ?>#add_expense<?php endif ?>" role="tab">Add Category</a>
                    <div class="slide"></div>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="expense-details" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">Spending Category Details</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="exp_table">
                                <thead>
                                <th>S.No</th>
                                <th>Spending Category</th>
                                <th class="action-btn-align">Action</th>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="add_expense" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">Add Spending Category</h5>
                    </div>
                    <div class="card-block">
                        <form class="form-material" action="<?php echo $this->config->item('base_url'); ?>masters/expense_category/add" enctype="multipart/form-data" name="form" method="post">
                            <div class="form-material row">
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-briefcase-alt-1"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Spending Category <span class="req">*</span></label>
                                            <input type="text" name="exp[category_name]" class="required form-control" id="exp_category"/>
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
                                </div>-->
                            </div>

                            <div class="form-group row text-center m-10">
                                <div class="col-md-12 text-center">
                                    <input type="submit" name="submit" class="btn btn-primary m-b-10 btn-sm waves-effect waves-light m-r-20" value="Save" id="submit" tabindex="1"/>
                                    <input type="reset" value="Clear" class="btn btn-danger waves-effect m-b-10 btn-sm waves-light" id="reset" tabindex="1"/>
                                    <a href="<?php echo $this->config->item('base_url') . 'masters/expense_category' ?>" class="btn btn-inverse btn-sm waves-effect waves-light m-b-10"><span class="glyphicon"></span> Back </a>
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
    $(document).ready(function () {
        $('#submit').click(function () {
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
            //var exp_type = $('.exp_type:checked').length;
            //if (exp_type == 0) {
            //    $('.exp_type').closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
            //    m++;
           // } else {
            //    $('.exp_type').closest('div.form-group').find('.error_msg').text('').slideUp('500');
            //}
            exp_category = $.trim($('#exp_category').val())
            if (exp_category != '') {
                $.ajax({
                    type: 'POST',
                    async: false,
                    data: {exp_category: $.trim($('#exp_category').val())},
                    url: '<?php echo base_url(); ?>masters/expense_category/is_expense_category_available/',
                    success: function (data) {

                        if (data == 'yes') {
                            $('#exp_category').closest('div.form-group').find('.error_msg').text('This Category name is already taken').slideDown('500').css('display', 'inline-block');
                            m++;
                        } else {
                            $('#exp_category').closest('div.form-group').find('.error_msg').text('').slideUp('500');
                        }
                    }
                });
            }
            if (m > 0)
                return false;
        });
    });

    $('#exp_category').on('keyup blur', function () {
        this_val = $.trim($(this).val());
        if ($.trim($(this).val()) == '') {
            $(this).closest('div.form-group').find('.error_msg').text('This field is required').slideDown('500').css('display', 'inline-block');
        } else {
            $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
        }
    });


</script>



<?php
if (isset($expense_category) && !empty($expense_category)) {
    foreach ($expense_category as $val) {
        ?>
        <div id="delexp_<?php echo $val['id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
            <div class="modal-dialog">
                <div class="modal-content modalcontent-top">
                    <div class="modal-header modal-padding modalcolor">
                        <h4 id="myModalLabel" class="inactivepop">In-Active Spending Category </h4>
                        <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                    </div>
                    <div class="modal-body">
                        Do You Want In-Active This Spending Category? <?= $val['category_name']; ?>
                        <input type="hidden" value="<?php echo $val['id']; ?>" class="id" />
                    </div>
                    <div class="modal-footer action-btn-align">
                        <button class="btn btn-primary btn-sm delete_yes" id="yesin">Yes</button>
                        <button type="button" class="btn btn-danger btn-sm delete_all"  data-dismiss="modal" id="no">No</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>
<script type="text/javascript">
    function delete_expense(val) {

        $('#delexp_' + val).modal('show');
    }
    $(document).ready(function ()
    {
        $(".delete_yes").on("click", function ()
        {

            var hidin = $(this).parent().parent().find('.id').val();

            $.ajax({
                url: BASE_URL + "masters/expense_category/delete",
                type: 'POST',
                data: {id: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "masters/expense_category/");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");
        $('#exp_table').DataTable({
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "language": {
                "infoFiltered": ""
            },
            "order": [], //Initial no order.
            //dom: 'Bfrtip',
            // Load data for the table's content from an Ajax source
            "ajax": {
                url: BASE_URL + "masters/expense_category/ajaxList",
                "type": "POST",
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0, 2], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
        });
        /* var table;
         table = $('#exp_table').DataTable({
         alert();
         'lengthMenu': [[50, 100, 150, -1], [50, 100, 150, 'All']],
         'processing': true, //Feature control the processing indicator.
         'serverSide': true, //Feature control DataTables' server-side processing mode.
         'retrieve': true,
         'order': [], //Initial no order.

         //dom: 'Bfrtip',

         // Load data for the table's content from an Ajax source

         'ajax': {
         url: BASE_URL + "masters/expense_category/ajaxList",
         'type': 'POST',
         },
         'columnDefs': [{
         'targets': 0,
         'searchable': false

         },
         {
         orderable: false,
         targets: [-1]
         }, {"bSortable": false, "aTargets": [0]}
         ],
         "footerCallback": function (row, data, start, end, display) {
         $('.remove_order_icon').removeClass('sorting');
         }
         });*/
    });
</script>