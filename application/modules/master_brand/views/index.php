<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="tab-header card">
            <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                <li class="nav-item col-md-2">
                    <a class="nav-link active" data-toggle="tab" href="#brand-details" role="tab">Brand List</a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item col-md-2">
                    <a class="nav-link <?php if (!$this->user_auth->is_action_allowed('masters', 'master_brand', 'add')): ?>alerts<?php endif ?>" data-toggle="tab" href="<?php if ($this->user_auth->is_action_allowed('masters', 'master_brand', 'add')): ?>#brand<?php endif ?>" role="tab">Add Brand</a>
                    <div class="slide"></div>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="brand-details" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">Brand Details</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="brand_table">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Brand</th>
                                        <th class="action-btn-align">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="brand" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">Add Brand</h5>
                    </div>
                    <div class="card-block">
                        <form class="form-material" action="<?php echo $this->config->item('base_url'); ?>master_brand/insert_brand"  name="form" method="post">
                            <div class="form-material row">
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-brand-china-mobile"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Brand Name <span class="req">*</span></label>
                                            <input type="text" name="brands" class="brand form-control brandnamedup borderra0" placeholder=" " id="brandname" maxlength="40" />
                                            <span class="form-bar"></span>
                                            <span id="cnameerror" class="reset val text-danger"></span>
                                            <span id="dup"  class="val text-danger"></span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row text-center m-10">
                                <div class="col-md-12 text-center">
                                    <input type="submit" class="btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light submit" value="Save" id="submit" tabindex="1"/>
                                    <input type="reset" value="Clear" class="btn btn-danger waves-effect m-b-10 btn-sm waves-light" id="reset" tabindex="1"/>
                                    <a href="<?php echo $this->config->item('base_url') . 'master_brand/' ?>" class="btn btn-inverse btn-sm waves-effect waves-light m-b-10" tabindex="1"> Back </a>
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
    $(document).on('click', '.alerts', function () {
        sweetAlert("Oops...", "This Access is blocked!", "error");
        return false;
    });
    $('#brandname').on('blur', function ()
    {
        var cname = $('#brandname').val();
        if (cname == '' || cname == null || cname.trim().length == 0)
        {
            $('#cnameerror').html("Required Field");
        } else
        {
            $('#cnameerror').html(" ");
        }
    });


    $('#submit').on('click', function ()
    {

        cname = $.trim($("#brandname").val());
        $.ajax(
                {
                    url: BASE_URL + "master_brand/add_duplicate_brandname",
                    type: 'POST',
                    async: false,
                    data: {value1: cname},
                    success: function (result)
                    {
                        $("#dup").html(result);
                    }
                });
        var i = 0;
        var cname = $('#brandname').val();
        if (cname == '' || cname == null || cname.trim().length == 0)
        {
            $('#cnameerror').html("Required Field");
            i = 1;
        } else
        {
            $('#cnameerror').html("");
        }
        var m = $('#dup').html();
        if ((m.trim()).length > 0)
        {
            i = 1;
        }
        if (i == 1)
        {
            return false;
        } else
        {
            return true;

        }
    });
</script>
<script type="text/javascript">
    // STYLE NAME DUPLICATION
    $(".brandnamedup").on('blur', function ()
    {
        cname = $.trim($("#brandname").val());

        $.ajax(
                {
                    url: BASE_URL + "master_brand/add_duplicate_brandname",
                    type: 'POST',
                    async: false,
                    data: {value1: cname},
                    success: function (result)
                    {
                        $("#dup").html(result);
                    }
                });
    });
    $('input[type="text"]').on('keyup', function () {

        this_val = $(this).val();
        value = this_val.toUpperCase();
        $(this).val(value);

    });

</script>
<br />

<?php
if (isset($brand) && !empty($brand)) {
    foreach ($brand as $val) {
        ?>
        <div id="test1_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1"
             role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
            <div class="modal-dialog">
                <div class="modal-content modalcontent-top">
                    <div class="modal-header modal-padding modalcolor">
                        <h4 class="modal-title">Update Brand</h4>
                        <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                    </div>
                    <div class="modal-body">
                        <form class="form-material">

                            <div class="form-material row">
                                <div class="col-md-12">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-brand-china-mobile"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <input type="hidden" name="id" class="id form-control id_update" id="id" value="<?php echo $val["id"]; ?>" readonly="readonly" />
                                            <label class="float-label newClass">Brand Name <span class="req">*</span></label>
                                            <input type="text" class="brand form-control colornameup colornamecup brandnameup borderra0" name="brands" value="<?php echo $val["brands"]; ?>" id="colornameup" maxlength="40" />
                                            <input type="hidden" class="root1_h"  value="<?php echo $val["brand"]; ?>"  />
                                            <span class="form-bar"></span>
                                            <span id="cnameerrorup" class="cnameerrorup text-danger"></span>
                                            <span id="dupup" class="dupup text-danger" ></span>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer action-btn-align">
                        <button type="button" class="edit btn btn-info btn-sm "  id="edit">Update</button>
                        <button type="reset" class="btn btn-danger btn-sm"  id="no" data-dismiss="modal"> Discard</button>
                    </div>
                </div>
            </div>
        </div>


        <script type="text/javascript">
            $('.brandnamecup').on('change', function ()
            {
                var cname = $(this).parent().parent().find(".$brandnamecup").val();
                //var sname=$('.style_nameup').val();
                var m = $(this).offsetParent().find('.cnameerrorup');
                if (cname == '' || cname == null || cname.trim().length == 0)
                {
                    m.html("Required Field");
                } else
                {
                    m.html("");
                }
            });
            $(document).ready(function ()
            {
                $('#no').on('click', function ()
                {
                    var root_h = $(this).parent().parent().parent().find('.root1_h').val();
                    $(this).parent().parent().find('.brandnameup').val(root_h);
                    var m = $(this).offsetParent().find('.cnameerrorup');
                    var message = $(this).offsetParent().find('.dupup');
                    //var message=$(this).parent().parent().find('.dupup').html();
                    m.html("");
                    message.html("");
                });
            });
        </script>
        <script type="text/javascript">
            $(".brandnameup").on('blur', function ()
            {
                //alert("hi");
                var cname = $.trim($(this).parent().parent().find('.brandnameup').val());
                var id = $(this).offsetParent().find('.id_update').val();
                var message = $(this).offsetParent().find('.dupup');


                $.ajax(
                        {
                            url: BASE_URL + "master_brand/update_duplicate_brandname",
                            type: 'get',
                            data: {value1: cname, value2: id},
                            success: function (result)
                            {
                                message.html(result);
                            }
                        });
            });
        </script>
        <?php
    }
}
?>
<?php
if (isset($brand) && !empty($brand)) {
    foreach ($brand as $val) {
        ?>
        <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
            <div class="modal-dialog">
                <div class="modal-content modalcontent-top">
                    <div class="modal-header modal-padding modalcolor">
                        <h4 id="myModalLabel" class="inactivepop">In-Active Brand</h4>
                        <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                    </div>
                    <div class="modal-body">
                        Do You Want In-Active? &nbsp; <strong><?php echo $val["brands"]; ?></strong>
                        <input type="hidden" value="<?php echo $val['id']; ?>" class="hidin" />
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


    $(".edit").on("click", function ()
    {
        var cname = $.trim($(this).parent().parent().find('.brandnameup').val());
        var ids = $(this).offsetParent().find('.id_update').val();
        var message = $(this).offsetParent().find('.dupup');
        $.ajax(
                {
                    url: BASE_URL + "master_brand/update_duplicate_brandname",
                    type: 'get',
                    async: false,
                    data: {value1: cname, value2: ids},
                    success: function (result)
                    {
                        message.html(result);
                    }
                });
        var i = 0;
        var id = $(this).parent().parent().find('.id').val();
        var brand = $(this).parent().parent().find(".brand").val();
        var m = $(this).offsetParent().find('.cnameerrorup');
        //var message=$(this).offsetParent().find('.dupup');
        var message = $(this).parent().parent().find('.dupup').html();
        if ((message.trim()).length > 0)
        {
            i = 1;
        }
        if (brand == '' || brand == null || brand.trim().length == 0)
        {
            m.html("Required Field");
            i = 1;
        } else
        {
            m.html("");
        }
        if (i == 1)
        {
            return false;
        } else
        {
            $.ajax({
                url: BASE_URL + "master_brand/update_brand",
                type: 'POST',
                data: {value1: id, value2: brand},
                success: function (result)
                {
                    window.location.reload(BASE_URL + "index/");
                }
            });
        }
        $('.modal').css("display", "none");
        $('.fade').css("display", "none");
    });
</script>

<script type="text/javascript">
    function delete_brand(val) {
        $('#test3_' + val).modal('show');
    }
    function edit_brand(val) {
        $('#test1_' + val).modal('show');
        $(".brandnameup").parent().find(".float-label").removeClass('newClass1');
        $(".brandnameup").parent().find(".float-label").addClass('newClass');
    }
    $(document).ready(function ()
    {
        $('#brand_table').DataTable({
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
                url: BASE_URL + "master_brand/ajaxList",
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
        $(".delete_yes").on("click", function ()
        {

            var hidin = $(this).parent().parent().find('.hidin').val();

            $.ajax({
                url: BASE_URL + "master_brand/delete_master_brand",
                type: 'get',
                data: {value1: hidin},
                success: function (result) {
                    window.location.reload(BASE_URL + "master_brand/");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });
</script>
<script>
    $(document).on('keyup click', '.form-material input,textarea ', function (ev) {
// stuff happens
//alert("hjdg");
//if ($(this).val() != "") {
        $(this).parent().find(".float-label").removeClass('newClass1');
        $(this).parent().find(".float-label").addClass('newClass');
//}

    });
    $(document).on('blur', '.form-material input,textarea ', function (ev) {
// stuff happens
//alert("hjdg");
        if ($(this).val() == "") {
            $(this).parent().find(".float-label").removeClass('newClass');
            $(this).parent().find(".float-label").addClass('newClass1');

        } else {
            $(this).parent().find(".float-label").removeClass('newClass1');
            $(this).parent().find(".float-label").addClass('newClass');
        }
    });
    $(".form-material input,textarea").each(function () {
        //alert($(this).find(':input').val());
        if ($(this).val() != "") {
            $(this).parent().find(".float-label").removeClass('newClass1');
            $(this).parent().find(".float-label").addClass('newClass');
        } else {
            $(this).parent().find(".float-label").removeClass('newClass');
            $(this).parent().find(".float-label").addClass('newClass1');
        }
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#cancel').on('click', function ()
        {
            $('.reset').html("");
            $('.dup').html("");
        });
    });
</script>