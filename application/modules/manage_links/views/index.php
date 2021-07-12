<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    table tr td:nth-child(4){text-align:center;}
    table tr td:nth-child(6){text-align:center;}
    .addstbl, .addstbl tr th, .addstbl tr td{border:1px solid #ccc;}
    .addstbl tr th{font-weight:bold;}
    #delete_group, #add_data, #delete_label {
        color: #fff;
    }
    .error_msg {
        font-size: 13px;
        color: #ff5252 !important;
        text-align: left;
    }
    .table-responsive {
        display: inline-block;
        width: 100%;
        overflow-x: unset !important;
    }
    .pos-rel{margin-bottom: .0rem;
             margin-top: 0.2rem;}
    #add_quotation .form-control {
        font-size: 12px !important;
        border-radius: 2px !important;
        border: 1px solid #cccccc !important;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="tab-header card">
            <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                <li class="nav-item col-md-2">
                    <a class="nav-link active" data-toggle="tab" href="#links_details" role="tab">Links List</a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item col-md-2">
                    <a class="nav-link <?php if (!$this->user_auth->is_action_allowed('masters', 'manage_links', 'add')): ?>alerts<?php endif ?>" data-toggle="tab" href="<?php if ($this->user_auth->is_action_allowed('masters', 'manage_links', 'add')): ?>#links<?php endif ?>" role="tab">Add Links</a>
                    <div class="slide"></div>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="links_details" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">Links Details</h5>
                        <div class="pull-right">
                            <a href="javascript::" style="display: none" title="Active" class="activeButton" onclick="$('#projects_action').val('1'); $('#actionform').submit();"><span class="badge badge-success white" id="status_active" style="margin-right:5px;">ACTIVE</span></a>
                            <a href="javascript::" style="display: none" title="Inactive" class="inactiveButton" onclick="$('#projects_action').val('0'); $('#actionform').submit();"><span class="badge badge-danger white" id="status_inactive">INACTIVE</span></a>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <form action="<?php echo base_url(); ?>manage_links/change_status" method="post" id="actionform">
                                <input type="hidden" name="action" id="projects_action" value="">
                                <table class="table table-striped table-bordered" id="link_table" >
                                    <thead>
                                        <tr>
                                            <th width="33">S.No</th>
                                            <th width="35">Links name</th>
                                            <th width="35">Status</th>
                                            <th width="107" class="action-btn-align">Action</th>
                                            <th width="107" class="action-btn-align"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($links)) {
                                            $i = 1;
                                            foreach ($links as $link_list) {
                                                ?>
                                                <tr class="ads_row<?php echo $link_list['id'] ?>">

                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo ucfirst($link_list['name']); ?></td>
                                                    <td class="text-center"><span class="AdsStatus label <?php echo ($link_list['status'] == 1) ? 'label-success' : 'label-danger'; ?>" addType="<?php echo ($link_list['status'] == 1) ? 'Active' : 'Inactive'; ?>"><?php echo ($link_list['status'] == 1) ? 'Active' : 'Inactive'; ?></span></td>
                                                    <?php if ($this->user_auth->is_action_allowed('masters', 'manage_links', 'edit') || $this->user_auth->is_action_allowed('masters', 'advertisement', 'delete')): ?>
                                                        <td class="">
                                                            <?php if ($this->user_auth->is_action_allowed('masters', 'manage_links', 'edit')): ?>
                                                                <a href="<?php echo base_url(); ?>manage_links/edit/<?php echo $link_list['id']; ?>" class="btn btn-round btn-primary btn-mini waves-effect waves-light" title="Edit"><span class="fa fa-pencil" style="color: white;"></span></a>
                                                            <?php endif; ?>

                                                            <a href="<?php if ($this->user_auth->is_action_allowed('masters', 'manage_links', 'delete')): ?>#del_ads<?php echo $link_list['id']; ?><?php endif ?>" data-toggle="modal" name="delete" class="btn btn-round btn-danger btn-mini waves-effect waves-light deletw-row delete_group <?php if (!$this->user_auth->is_action_allowed('masters', 'manage_links', 'delete')): ?>alerts<?php endif ?>" title="Delete">
                                                                <span class="fa fa-trash-o" style="color: white;"></span></a>

                                                        </td>
                                                    <?php endif; ?>
                                                    <td>
                                                        <label class="pos-rel"><input type="checkbox" name="projects_checkbox" value="<?php echo $link_list['id'] ?>" class="projects_checkbox ace" /><span class="lbl"></span></label>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if (isset($links) && !empty($links)) {
                $i = 0;
                foreach ($links as $val) {
                    $i++
                    ?>
                    <div id="del_ads<?php echo $val['id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" align="center">
                        <div class="modal-dialog">
                            <div class="modal-content modalcontent-top">
                                <div class="modal-header modal-padding modalcolor">
                                    <h4 id="myModalLabel" class="inactivepop">Delete Link</h4>
                                    <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                                </div>
                                <div class="modal-body">
                                    Do You Want Delete This Link? <?php echo ucfirst($val['name']); ?>
                                    <input type="hidden" value="<?php echo $val['id']; ?>" class="id" id="link_hidden_id"/>
                                </div>
                                <div class="modal-footer action-btn-align">
                                    <button class="btn btn-round btn-primary btn-sm delete_yes" id="yesin">Yes</button>
                                    <button type="button" class="btn btn-round btn-danger btn-sm delete_all"  data-dismiss="modal" id="no">No</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="tab-pane" id="links" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">Add Links</h5>
                    </div>
                    <div class="card-block">
                        <table class="static1" style="display:none">
                            <tr>
                                <td style="text-align:right;font-weight:bold;"><input type="text" name="link_name[]" tabindex="-1" class="link_name form-control " ><span class="error_msg"></span></td>
                                <td> <input name="description[]" class="description form-control"><span class="error_msg"></span></td>
                                <td width="2%" class="action-btn-align"><a id='delete_label' class="del btn btn-round btn-danger btn-mini"><span class="fa fa-trash"></span></a></td>
                            </tr>
                        </table>
                        <form class="" action="<?php echo $this->config->item('base_url'); ?>manage_links/add" enctype="multipart/form-data" name="form" method="post" novalidate>
                            <div class="form-material row">
                                <div class="col-md-6">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-building-alt"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <input type="text" name="link[name]" class="form-control required" id="link_name"/>
                                            <label class="float-label">Link Name</label>
                                            <span class="form-bar"></span>
                                            <span class="error_msg"></span>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="col-md-6">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-building-alt"></i>
                                        </div>
                                        <div class="form-group form-primary ">
                                            <select name="link[status]" class="form-control">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>

                                            <span class="form-bar"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>-->
                                <div class="col-lg-12">
                                    <label><strong>Link Details:</strong></label>
                                    <div class="row card-block table-border-style">
                                        <div class="table-responsive">

                                            <table class="addstbl" id="add_quotation">
                                                <thead id="add_header">
                                                <th width="5%" class="first_td1">Link Data</th>
                                                <th width="5%" class="first_td1">Link Description</th>
                                                <th width="1%" class="action-btn-align" style="text-align:center;"><a id='add_data' data-type="0" class="btn btn-round btn-primary btn-mini waves-effect waves-light d-inline-block md-trigger"><span class="fa fa-plus" style="color:white;"></span> </a></td>
                                                    </thead>
                                                <tbody id="add_body">
                                                <td style="text-align:right;font-weight:bold;"><input type="text" name="link_name[]" tabindex="-1" class="link_name required form-control " ><span class="error_msg"></span></td>
                                                <td> <input name="description[]" class="description required form-control"><span class="error_msg"></span></td>
                                                <td width="2%" class="action-btn-align"><a id='delete_label' class="del btn btn-round btn-danger btn-mini"><span class="fa fa-trash"></span></a></td>

                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                    <div class="row text-center m-10">
                                        <div class="col-md-12 text-center">
                                            <input type="submit" name="submit" class="btn btn-round btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light" value="Save" id="submit" tabindex="1"/>
                                            <a href="<?php echo $this->config->item('base_url') . 'manage_links' ?>" class="btn btn-round btn-inverse btn-sm waves-effect waves-light m-b-10" tabindex="1"> Back </a>
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
                $("input:checkbox.projects_checkbox").change(function () {
                    if ($('.projects_checkbox').length > 1) {
                        $('.projects_checkbox').prop('checked', false);
                        $(this).prop('checked', true);
                    }
                    if($(".projects_checkbox:checkbox").filter(":checked").length >0){
                        if($(this).closest('tr').find('.AdsStatus').attr('addType') == "Active"){
                            $('.activeButton').css({"display":"none"});
                            $('.inactiveButton').css({"display":""});
                        }else if($(this).closest('tr').find('.AdsStatus').attr('addType') == "Inactive"){
                            $('.activeButton').css({"display":""});
                            $('.inactiveButton').css({"display":"none"});
                        }else{
                            $('.activeButton').css({"display":"none"});
                            $('.inactiveButton').css({"display":"none"});
                        }
                    }
                });
                $('#link_table').dataTable({
                    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                    "language": {
                        "infoFiltered": ""
                    },
                });

                $(".delete_yes").on("click", function ()
                {
                    var hidin = $(this).parent().parent().find('.id').val
                    var link_id = $('#link_hidden_id').val();
                    $.ajax({
                        url: BASE_URL + "manage_links/delete",
                        type: 'POST',
                        data: {value1: link_id},
                        success: function (result) {

                            window.location.reload(BASE_URL + "manage_links/");
                        }
                    });

                });

                $('.modal').css("display", "none");
                $('.fade').css("display", "none");
                $('#submit').click(function () {
                    m = 0;
                    $('.required').each(function () {
                        this_val = $.trim($(this).val());
                        this_id = $(this).attr('id');
                        this_class = $(this).attr('class');
                        this_ele = $(this);
                        if (this_val == '') {

                            $(this).closest('div.form-group').find('.error_msg').text('Field is required').slideDown('500').css('display', 'block');
                            $(this).closest('td').find('.error_msg').text('Field is required').slideDown('500').css('display', 'block');
                            m++;
                        } else {
                            $(this).closest('td').find('.error_msg').text('').slideDown('500').css('display', 'block');
                            $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                        }

                    });
                    $('#add_quotation .required').each(function () {
                        this_val = $.trim($(this).val());
                        this_id = $(this).attr("id");
                        if (this_val == "") {
                            $(this).closest('td').find('.error_msg').text('Field is required').slideDown('500').css('display', 'block');
                            m++;
                        } else {
                            $(this).closest('td').find('.error_msg').text('');
                        }
                    });


                    if (m > 0)
                        return false;
                });
            });

            $('#add_data').click(function () {
                var tables = $(".static1").find('tr:last').clone();
                $(tables).closest('tr').find('.link_name,.description').addClass('required');
                $('#add_body').append(tables);

            });
            $('#delete_label').live('click', function () {
                $(this).closest("tr").remove();
            });
        </script>