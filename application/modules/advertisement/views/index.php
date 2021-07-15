<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    table tr td:nth-child(9){text-align:center;}
    table tr td:nth-child(6){text-align:center;}
    .table-responsive {
        display: inline-block;
        width: 100%;
        overflow-x: unset !important;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="md-tabs-main">
            <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#ads_details" role="tab">Ads List</a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if (!$this->user_auth->is_action_allowed('masters', 'advertisement', 'add')): ?>alerts<?php endif ?>" data-toggle="tab" href="<?php if ($this->user_auth->is_action_allowed('masters', 'advertisement', 'add')): ?>#advertisement<?php endif ?>" role="tab">Add advertisement</a>
                    <div class="slide"></div>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="ads_details" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">Ads Details</h5>
                        <div class="pull-right">
                            <a href="javascript::" style="display: none" title="Active" class="activeButton" onclick="$('#projects_action').val('1');   $('#actionform').submit();"><span class="badge badge-success white " id="status_active" style="margin-right:5px;">ACTIVE</span></a>
                            <a href="javascript::" style="display: none" class="inactiveButton" title="Inactive" onclick="$('#projects_action').val('0');$('#actionform').submit();"><span class="badge badge-danger white" id="status_inactive">INACTIVE</span></a>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <form action="<?php echo base_url(); ?>advertisement/change_status" method="post" id="actionform">
                                <input type="hidden" name="action" id="projects_action" value="">
                                <table class="table table-striped table-bordered" id="ads_table">
                                    <thead>
                                        <tr>
                                            <th width="5%">S.No</th>
                                            <th >Ads Name</th>
                                            <th >Status</th>
                                            <th class="action-btn-align">Action</th>
                                            <th class="action-btn-align"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($ads)) {
                                            $i = 1;
                                            foreach ($ads as $ads_list) {
                                                ?>

                                                <tr class="ads_row<?php echo $ads_list['id'] ?>">

                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo ucfirst($ads_list['name']); ?></td>
                                                    <td class="text-center"><span class="AdsStatus label <?php echo ($ads_list['status'] == 1) ? 'label-success' : 'label-danger'; ?>" addType="<?php echo ($ads_list['status'] == 1) ? 'Active' : 'Inactive'; ?>"><?php echo ($ads_list['status'] == 1) ? 'Active' : 'Inactive'; ?></span></td>
                                                    <?php if ($this->user_auth->is_action_allowed('masters', 'advertisement', 'edit') || $this->user_auth->is_action_allowed('masters', 'advertisement', 'delete')): ?>
                                                        <td class="" style="text-align:center">
                                                            <?php if ($this->user_auth->is_action_allowed('masters', 'advertisement', 'edit')): ?>
                                                                <a href="<?php echo base_url(); ?>advertisement/edit/<?php echo $ads_list['id']; ?>" class="btn btn-round btn-primary btn-mini waves-effect waves-light" title="Edit"><span class="fa fa-pencil" style="color: white;"></span></a>
                                                            <?php endif; ?>

                                                            <a href="<?php if ($this->user_auth->is_action_allowed('masters', 'advertisement', 'delete')): ?>#del_ads<?php echo $ads_list['id']; ?><?php endif ?>" data-toggle="modal" name="delete" class="btn btn-round btn-danger btn-mini waves-effect waves-light deletw-row delete_group <?php if (!$this->user_auth->is_action_allowed('masters', 'advertisement', 'delete')): ?>alerts<?php endif ?>" title="Delete">
                                                                <span class="fa fa-trash-o" style="color: white;"></span></a>

                                                        </td>
                                                    <?php endif; ?>
                                                    <td>
                                                        <label class="pos-rel"><input type="checkbox" name="projects_checkbox" value="<?php echo $ads_list['id'] ?>" class="projects_checkbox ace" /><span class="lbl"></span></label>
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
            if (isset($ads) && !empty($ads)) {
                $i = 0;
                foreach ($ads as $val) {
                    $i++
                    ?>
                    <div id="del_ads<?php echo $val['id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" align="center">
                        <div class="modal-dialog">
                            <div class="modal-content modalcontent-top">
                                <div class="modal-header modal-padding modalcolor">
                                    <h4 id="myModalLabel" class="inactivepop">In-Active Advertisement</h4>
                                    <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                                </div>
                                <div class="modal-body">
                                    Do You Want In-Active This Ads? <?php echo ucfirst($val['name']); ?>
                                    <input type="hidden" value="<?php echo $val['id']; ?>" class="id" id="ads_hidden_id"/>
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

           
        <table class="static" style="display: none;">
                <tr>
                    <td align="center" class="s_no"></td>
                    <td>
                        <div class="" >
                            <select name="adds_file_type[]" autocomplete="off" class="form-control input-sm  adds_file_type" id="">
                                <option value="1">Images</option>
                            </select>
                            <span class="error_msg adds_file_type_error"></span>
                        </div>
                    </td>
                    <td class="file_type_content">
                        <div class="ads_image_div" >
                            <div class="col-md-9 add-img-upload flt-left">
                                <fieldset _ngcontent-c7="" class="">
                                    <div _ngcontent-c7="" class="custom-file center-block d-block">
                                        <input _ngcontent-c7="" class="add_data_images custom-file-input adsdata" id="ads" name="ads_data_image[]" data-type="image" type="file">
                                        <label _ngcontent-c7="" class="custom-file-label" for="inputGroupFile01">Choose File</label>	
                                    </div>
                                    <span class="error_msg file_error"></span>
                                </fieldset>
                                

                            </div>
                            <div class="col-md-3 flt-left">
                                <img src="<?php echo base_url('/') . '/attachement/product/no-img.gif'; ?>"  class="img_src img_video_tbl" width="40px" height="40px" />
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="">
                            <input type="text" autocomplete="off" name="ads_sort_order[]" id="" onkeypress="return isNumber(event)" class="form-control ads_sort_order "/>
                            <span class="error_msg sort_order_error"></span>
                        </div>
                    </td>

                    <td width="5%" class="action-btn-align" style="text-align:center;">
                        <a  class="remove_data del btn btn-round btn-danger btn-mini" onclick="remove_data($(this))">
                            <span class="fa fa-trash" style="color:white;"></span>
                        </a>
                    </td>
                </tr>
        </table>
            <div class="tab-pane" id="advertisement" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">Add Advertisement</h5>
                    </div>
                    <div class="card-block">
                        <form class="" action="<?php echo $this->config->item('base_url'); ?>advertisement/add" enctype="multipart/form-data" name="form" method="post" novalidate>
                            <div class=" row">
                                <div class="col-md-6">
                                    <div class="material-group">
                                        <div class="form-group form-primary">
                                        <label class="float-label">Ads Name</label>
                                            <input type="text" placeholder="Enter Ads Name" name="ads[ads_name]" class="form-control required" id="ads_name"/>
                                            
                                            <span class="form-bar"></span>
                                            <span class="error_msg"></span>
                                        </div>
                                    </div>
                                </div>
                            
                            <div class="col-lg-12">
                                <label><strong>Ads Content/File Details:</strong></label><span class="req">*</span>
                                <div class="table-border-style">
                                    <div class="table-responsive">
                                        <table class="addstbl table table-bordered" id="add_quotation">
                                            <thead id="add_header">
                                                <th width="1%" class="first_td1">S.No</th>
                                                <th width="15%" class="first_td1 ads_file_type" >File Type</th>
                                                <th width="40%" class="first_td1 add_title_datatype"> Ads Data</th>
                                                <th width="5%" class="first_td1">Sort Order</th>
                                                <th width="1%" class="action-btn-align" style="text-align:center;"><a onclick="ads_content_clone()" id='add_data' data-type="0" class="btn btn-round btn-primary btn-mini waves-effect waves-light d-inline-block md-trigger">
                                                    <span class="fa fa-plus" style="color:white;"></span> </a></th>
                                            </thead>
                                            <tbody id="add_body"> 
                                                <tr>
                                                    <td align="center" class="s_no">1</td>
                                                    <td>
                                                        <div class="" >
                                                            <select name="adds_file_type[]" autocomplete="off" class="form-control input-sm  adds_file_type required" id="">
                                                                <option value="3" selected>Content</option>
                                                            </select>
                                                            <span class="error_msg adds_file_type_error"></span>
                                                        </div>
                                                    </td>
                                                    <td class="file_type_content">
                                                        <div class="ads_content_div">
                                                            <div class="">
                                                                <textarea   placeholder="Content" class="add_data_contents required form-control txt_area_height " name="ads_data[]"></textarea>
                                                                <span class="error_msg file_error"></span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="">
                                                            <input type="text" autocomplete="off" name="ads_sort_order[]" id="" onkeypress="return isNumber(event)" class="form-control required ads_sort_order "/>
                                                            <span class="error_msg sort_order_error"></span>
                                                        </div>
                                                    </td>

                                                    <td width="5%" class="action-btn-align" style="text-align:center;"> -
                                                    </td>
                                                </tr>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="row text-center m-10">
                                <div class="col-md-12 text-center">
                                    <input type="submit" name="submit" class="btn btn-round btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light" value="Save" id="submit" tabindex="1"/>
                                    <input type="reset" value="Clear" class="btn btn-round btn-danger waves-effect m-b-10 btn-sm waves-light" id="reset" tabindex="1"/>
                                    <a href="<?php echo $this->config->item('base_url') . 'advertisement' ?>" class="btn btn-round btn-inverse btn-sm waves-effect waves-light m-b-10" tabindex="1"> Back </a>
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
    setTimeout(function () {
        $('.ft-disc').attr('data-toggle', 'collapsed');
        $('.ft-disc').addClass('ft-circle');
        $('.ft-disc').removeClass('ft-disc');
        $('.wrapper').addClass('nav-collapsed');
        $('.wrapper').addClass('menu-collapsed');
    }, 1000);

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
        $('#ads_table').dataTable({
            "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
            "language": {
                "infoFiltered": ""
            },
        });

        $(".delete_yes").on("click", function ()
        {
            var hidin = $(this).parent().parent().find('.id').val
            var ad_id = $('#ads_hidden_id').val();
            $.ajax({
                url: BASE_URL + "advertisement/delete",
                type: 'POST',
                data: {value1: ad_id},
                success: function (result) {

                    window.location.reload(BASE_URL + "vendor/");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

        BASE_URL = "<?php echo $this->config->item('base_url'); ?>";
        $('#submit').click(function () {
            m = 0;
            $('.required').each(function () {
                this_val = $.trim($(this).val());
                this_id = $(this).attr('id');
                this_class = $(this).attr('class');
                this_ele = $(this);
                if (this_val == '') {

                    $(this).closest('div.form-group').find('.error_msg').text('Field is required').slideDown('500').css('display', 'block');
                    m++;
                } else {
                    $(this).closest('div.form-group').find('.error_msg').text('').slideUp('500');
                }

            });

            if (m > 0)
                return false;
        });

    });
   
    function ads_content_clone() {
        var table_data=$(".static").find('tr').clone();
        table_data.find('.adds_file_type ,.add_data_images,.ads_sort_order').addClass('required');
        $('#add_body').append(table_data);
        loop_set();
    }

    function loop_set(){
        var i = 0;
        var inc_id= 1;
        $('#add_body tr').each(function () {
            $(this).closest("tr").attr('class', '');
            $(this).closest("tr").attr('data-rowid', i);
            $(this).closest("tr").addClass('ads_row' + i);
            $(this).closest("tr").find('.s_no').html(inc_id++);
            $(this).closest("tr").find('.add_data_contents').attr('id', 'ads_content' + i + '');
            $(this).closest("tr").find('.add_data_contents').attr('name', 'ads_data[' + i + ']');
            $(this).closest("tr").find('.add_data_images').attr('id', 'ads_image' + i + '');
            $(this).closest("tr").find('input.add_data_images').attr('name', 'ads_data_image[' + i + ']');
            $(this).closest("tr").find('.add_data_images').attr('onchange', 'loadImageFileAsURL(' + i + ')');
            i++;
        });
    }
    function remove_data(_this) {
        _this.closest("tr").remove();
        loop_set();
    }
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && ((charCode != 46 && charCode != 45 && charCode != 43 && charCode < 48) || charCode > 57)) {
            return false;
        } else {
            return true;
        }
    }
    function loadImageFileAsURL(inc_id) {

        var tr_class = '.ads_row' + inc_id + '';
        var type = $('' + tr_class + '').find('.adds_file_type').val();
        $('' + tr_class + '').find('.adds_file_type_error').text('');

        if (type != undefined && type == 1) {
            if (type == 1)
                var id = "ads_image" + inc_id + '';
            var filesSelected = document.getElementById('' + id + '').files;
            var img = document.getElementById('' + id + '');
            if (filesSelected.length > 0)
            {
                var fileExtension = ['jpeg', 'jpg', 'png', 'mp4'];
                var fileUpload = $('#' + id + '')[0];
                var file_type_split = fileUpload.files[0].type.split('/');
                var file_type = file_type_split[1];
                //Read the contents of Image File.
                var reader = new FileReader();
                reader.readAsDataURL(fileUpload.files[0]);
                reader.onload = function (e) {
                    //Initiate the JavaScript Image object.
                    var image = new Image();
                    //Set the Base64 string return from FileReader as source.
                    image.src = e.target.result;

                    if (type == 1) {

                        if ($.inArray(file_type, fileExtension) == -1) {
                            $('' + tr_class + '').find('.file_error').text('Invalid file format..only allowed:jpeg,jpg,png').slideDown('500').css('display', 'block');
                            return false;
                        } else {
                            image.onload = function () {
                                //Determine the Height and Width.

                                var height = this.height;
                                var width = this.width;
                                if (height == 1060 || width == 1300)
                                {
                                    $('' + tr_class + '').find('.file_error').text('Width and Height must be in 1300 X 1060 px.').slideDown('500').css('display', 'block');
                                    $('#' + id + '').val('');
                                    return false;
                                } else
                                {
                                    $('' + tr_class + '').find('.file_error').text(' ').slideDown('500').css('display', 'block');
                                    $('' + tr_class + '').find('.img_src').attr('src', e.target.result);
                                    return true;
                                }
                            };
                        }

                    } 

                }

            } else {
                $('' + tr_class + '').find('.file_error').text('Please Select file').slideDown('500').css('display', 'block');
            }
        } else {
            if (type != 1 || type != 2)
                $('' + tr_class + '').find('.adds_file_type_error').text('Select file Type').slideDown('500').css('display', 'block');
        }
    }
</script>




