<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script type="text/javascript" src="<?php echo $theme_path; ?>/js/jquery-1.8.2.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<script type="text/javascript" src="<?php echo $theme_path; ?>/select2/select2.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $theme_path; ?>/select2/select2.min.css">
<style type="text/css">
    .select2-container { border:0px #fff solid; }
</style>
<div class="mainpanel">
    <div class="media">
    </div>
    <div class="contentpanel mb-50">
        <div class="media mt--2">
            <h4>User Details</h4>
        </div>
        <div class="panel-body">
            <div class="tabs">
                <!-- Nav tabs -->
                <ul class="list-inline tabs-nav tabsize-17" role="tablist">

                    <li role="presentation" class="active"><a href="#user-details" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">User List</a></li>
                    <li role="presentation" class=""><a href="<?php if ($this->user_auth->is_action_allowed('masters', 'users', 'add')): ?>#user<?php endif ?>" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false" class="<?php if (!$this->user_auth->is_action_allowed('masters', 'users', 'add')): ?>alerts<?php endif ?>">Add User</a></li>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane" id="user">
                        <form class="form-material" action="<?php echo $this->config->item('base_url'); ?>masters/users/insert_user" enctype="multipart/form-data" name="form" method="post">
                            <div class="row">
                                <div class="col-md-4 form-material">

                                    <div class="form-group form-primary">
									
                                        <label class="col-sm-4 control-label">Firm Name <span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <select name="firm_id[]" multiple="" class="form-control required form-align select2" id="firm" >
                                                <?php
                                                if (isset($firms) && !empty($firms)) {
                                                    foreach ($firms as $firm) {
                                                        ?>
                                                        <option value="<?php echo $firm['firm_id']; ?>"> <?php echo $firm['firm_name']; ?> </option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <span id="cuserror9" class="val"  style="color:#F00; font-style:oblique;"></span>
											<span class="form-bar"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Name <span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="name" class="form-align" id="name" />
                                                <div class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                            <span id="cuserror1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">User Name <span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="text" name="user_name" class="form-control form-align" id="user_name"  />
                                            <span id="cuserror8" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            <span id="duplica_user" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Password <span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <input type="password" name="pass" class="form-control form-align" id="pass" />
                                            <span id="cuserror11" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Nick Name <span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="nick_name" class="form-align" id="nick_name" />
                                                <div class="input-group-addon">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                            </div>
                                            <span id="nick" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Mobile Number <span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="number" class="number form-align" id="number" />
                                                <div class="input-group-addon">
                                                    <i class="fa fa-phone"></i>
                                                </div>
                                            </div>
                                            <span id="cuserror4" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Role <span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <select name="role" class="form-control form-align" id="role" >
                                                <option value="">--Select--</option>
                                                <?php
                                                if (isset($user) && !empty($user)) {
                                                    foreach ($user as $users) {
                                                        ?>
                                                        <option value="<?php echo $users['id']; ?>"> <?php echo $users['user_role']; ?> </option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <span id="cuserror6" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-4">

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Email Id <span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input type="text" name="mail" class="mail email_dup form-align" id="mail" />
                                                <div class="input-group-addon">
                                                    <i class="fa fa-envelope"></i>
                                                </div>
                                            </div>
                                            <span id="cuserror5" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            <span id="duplica" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Address <span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <textarea name="address1" id="address" class="form-control form-align"></textarea>
                                            <span id="cuserror3" class="val"  style="color:#F00; font-style:oblique;"></span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Signature <span style="color:#F00; font-style:oblique;">*</span></label>
                                        <div class="col-sm-8">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <img id="blah" class="add_staff_thumbnail" width="32px" height="33px" src="<?= $this->config->item("base_url") . 'attachement/sign/no-img.gif'; ?>"/>
                                                </div>
                                                <div class="col-md-10">
                                                    <input type="file" name="signature" class="margin0 imgInp form-control email_dup form-align" id="signature" />
                                                    <span id="sign" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="frameset_table action-btn-align">
                                <input type="submit" name="submit" class="btn btn-success" value="Save" id="submit" />
                                <input type="reset" value="Clear" class=" btn btn-danger1" id="reset" />
                                <a href="<?php echo $this->config->item('base_url') . 'masters/users/' ?>" class="btn btn-defaultback"><span class="glyphicon"></span> Back </a>
                            </div>
                        </form>
                    </div>
                    <div role="tabpanel" class="tab-pane active tablelist" id="user-details">
                        <div class="frameset_big1">

                            <table id="basicTable"  class="table table-striped table-bordered responsive dataTable no-footer dtr-inline">
                                <thead>
                                <th width="5%">S.No</th>
                                <th width="10%">Name</th>
                                <th width="8%">User Name</th>
                                <th width="10%">Mobile Number</th>
                                <th width="10%">Email Id</th>
                                <th width="10%">User Role</th>
                                <th width="15%">Firm Name</th>
                                <th width="10%">Action</th>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($agent) && !empty($agent)) {
                                        $i = 0;
                                        foreach ($agent as $val) {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td class="first_td"><?php echo "$i"; ?></td>
                                                <td><?php echo $val['name']; ?></td>
                                                <td><?php echo $val['username']; ?></td>
                                                <td><?php echo $val['mobile_no']; ?></td>
                                                <td><?php echo $val['email_id']; ?></td>
                                                <td><?php echo $val['user_role']; ?></td>
                                                <td><?php foreach ($val['firm_name'] as $list) { ?>
                                                        <span class="badge bg-green" style="padding: 2px;"><?php echo $list['name']; ?></span><br>
                                                    <?php }
                                                    ?></td>
                                                <td class="action-btn-align">
                                                    <a href="<?php if ($this->user_auth->is_action_allowed('masters', 'users', 'edit')): ?><?php echo $this->config->item('base_url') . 'masters/users/edit_user/' . $val['id']; ?><?php endif ?>" class="tooltips btn btn-info btn-xs <?php if (!$this->user_auth->is_action_allowed('masters', 'users', 'edit')): ?>alerts<?php endif ?>" title="Edit">
                                                        <span class="fa fa-edit"></span></a>&nbsp;&nbsp;
                                                    <a href="<?php if ($this->user_auth->is_action_allowed('masters', 'users', 'delete')): ?>#test3_<?php echo $val['id']; ?><?php endif ?>" data-toggle="modal" name="delete" class="tooltips btn btn-danger btn-xs <?php if (!$this->user_auth->is_action_allowed('masters', 'users', 'delete')): ?>alerts<?php endif ?>" title="In-Active">
                                                        <span class="fa fa-ban "></span></a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<br />
<script type="text/javascript">
    $(document).on('click', '.alerts', function () {
        sweetAlert("Oops...", "This Access is blocked!", "error");
        return false;
    });
    function readURL(input) {
        console.log(input);
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $(input).parent('div').parent('div').find('#blah').attr('src', e.target.result);
                $(input).closest('div').find('#blah').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".imgInp").live('change', function () {
        readURL(this);
    });

    $("#name").live('blur', function ()
    {
        var name = $("#name").val();
        var filter = /^[a-zA-Z.\s]{3,30}$/;
        if (name == "" || name == null || name.trim().length == 0)
        {
            $("#cuserror1").html("Required Field");
        } else if (!filter.test(name))
        {
            $("#cuserror1").html("Alphabets and Min 3 to Max 30 ");
        } else
        {
            $("#cuserror1").html("");
        }
    });
    $("#user_name").live('blur', function ()
    {
        var store = $("#user_name").val();
        if (store == "" || store == null || store.trim().length == 0)
        {
            $("#cuserror8").html("Required Field");
        } else
        {
            $("#cuserror8").html("");
        }
    });
    $("#nick_name").live('blur', function ()
    {
        var nick_name = $("#nick_name").val();
        if (nick_name == "" || nick_name == null || nick_name.trim().length == 0)
        {
            $("#nick").html("Required Field");
        } else
        {
            $("#nick").html("");
        }
    });

    $('#address').live('blur', function ()
    {
        var address = $('#address').val();
        if (address == "" || address == null || address.trim().length == 0)
        {
            $('#cuserror3').html("Required Field");
        } else
        {
            $('#cuserror3').html("");
        }
    });
    $("#number").live('blur', function ()
    {
        var number = $("#number").val();
        var nfilter = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
        if (number == "")
        {
            $("#cuserror4").html("Required Field");
        } else if (!nfilter.test(number))
        {
            $("#cuserror4").html("Enter Valid Mobile Number");
        } else
        {
            $("#cuserror4").html("");
        }
    });
    $("#mail").live('blur', function ()
    {
        var mail = $("#mail").val();
        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (mail == "")
        {
            $("#cuserror5").html("Required Field");
        } else if (!efilter.test(mail))
        {
            $("#cuserror5").html("Enter Valid Email");
        } else
        {
            $("#cuserror5").html("");
        }
    });
    $('#role').live('blur', function ()
    {
        var bank = $('#role').val();
        if (bank == "" || bank == null || bank.trim().length == 0)
        {
            $('#cuserror6').html("Required Field");
        } else
        {
            $('#cuserror6').html("");
        }
    });

    $('#firm').live('blur', function ()
    {
        var firm = $('#firm').val();
        if (firm == "" || firm == null || firm.trim().length == 0)
        {
            $('#cuserror9').html("Required Field");
        } else
        {
            $('#cuserror9').html("");
        }
    });

    $("#pass").live('blur', function ()
    {
        var acnum = $("#pass").val();
        if (acnum == "")
        {
            $("#cuserror11").html("Required Field");
        } else
        {
            $("#cuserror11").html("");
        }
    });



</script>
<script type="text/javascript">


    $('#submit').on('click', function ()
    {
        var i = 0;

        $('select.required').each(function () {
            this_val = $.trim($(this).val());
            this_id = $(this).attr('id');

            if (this_val == '') {
                $('#cuserror9').text('Required Field');
                i = 1;
            } else {
                $('#cuserror9').text('');

            }
        });

        var name = $("#name").val();
        var filter = /^[a-zA-Z.\s]{3,30}$/;
        if (name == "" || name == null || name.trim().length == 0)
        {
            $("#cuserror1").html("Required Field");
            i = 1;
        } else if (!filter.test(name))
        {
            $("#cuserror1").html("Alphabets and Min 3 to Max 30 ");
            i = 1;
        } else
        {
            $("#cuserror1").html("");
        }


        var user_name = $("#user_name").val();
        if (user_name == "" || user_name == null || user_name.trim().length == 0)
        {
            $("#cuserror8").html("Required Field");
            i = 1;
        } else
        {
            $("#cuserror8").html("");
        }

        var signature = $("#signature").val();
        if (signature == "" || signature == null || signature.trim().length == 0)
        {
            $("#sign").html("Required Field");
            i = 1;
        } else
        {
            $("#sign").html("");
        }

        var nick_name = $("#nick_name").val();
        if (nick_name == "" || nick_name == null || nick_name.trim().length == 0)
        {
            $("#nick").html("Required Field");
            i = 1;
        } else
        {
            $("#nick").html("");
        }

        var number = $("#number").val();
        var nfilter = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
        if (number == "")
        {
            $("#cuserror4").html("Required Field");
            i = 1;
        } else if (!nfilter.test(number))
        {
            $("#cuserror4").html("Enter Valid Mobile Number");
            i = 1;
        } else
        {
            $("#cuserror4").html("");
        }

        var mail = $("#mail").val();
        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (mail == "")
        {
            $("#cuserror5").html("Required Field");
            i = 1;
        } else if (!efilter.test(mail))
        {
            $("#cuserror5").html("Enter Valid Email");
            i = 1;
        } else
        {
            $("#cuserror5").html("");
        }
        var bank = $('#role').val();
        if (bank == "" || bank == null || bank.trim().length == 0)
        {
            $('#cuserror6').html("Required Field");
            i = 1;
        } else
        {
            $('#cuserror6').html("");
        }

        var address = $('#address').val();
        if (address == "" || address == null || address.trim().length == 0)
        {
            $('#cuserror3').html("Required Field");
            i = 1;
        } else
        {
            $('#cuserror3').html("");
        }
        var acnum = $("#pass").val();
        if (acnum == "")
        {
            $("#cuserror11").html("Required Field");
            i = 1;
        } else
        {
            $("#cuserror11").html("");
        }
        var mess = $('#duplica').html();
        if ((mess.trim()).length > 0)
        {
            i = 1;
        }

        var user = $('#duplica_user').html();
        if ((user.trim()).length > 0)
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
<script>
    $(".email_dup").live('blur', function ()
    {
        email = $("#mail").val();
        $.ajax(
                {
                    url: BASE_URL + "masters/users/add_duplicate_email",
                    type: 'get',
                    data: {value1: email},
                    success: function (result)
                    {
                        $("#duplica").html(result);
                    }
                });
    });

    $("#user_name").live('blur', function ()
    {

        email = $("#user_name").val();
        $.ajax(
                {
                    url: BASE_URL + "masters/users/add_duplicate_user",
                    type: 'get',
                    data: {value1: email},
                    success: function (result)
                    {
                        $("#duplica_user").html(result);
                    }
                });
    });
</script>



<?php
if (isset($agent) && !empty($agent)) {
    foreach ($agent as $val) {
        ?>
        <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
            <div class="modal-dialog">
                <div class="modal-content modalcontent-top">
                    <div class="modal-header modal-padding modalcolor"> <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                        <h3 id="myModalLabel" class="inactivepop">In-Active user</h3>
                    </div>
                    <div class="modal-body">
                        Do You Want In-Active This user?<strong><?php echo $val['name']; ?></strong>
                        <input type="hidden" value="<?php echo $val['id']; ?>" class="id" />
                    </div>
                    <div class="modal-footer action-btn-align">
                        <button class="btn btn-primary delete_yes" id="yesin">Yes</button>
                        <button type="button" class="btn btn-danger1 delete_all"  data-dismiss="modal" id="no">No</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>


<script type="text/javascript">
    $(document).ready(function ()
    {
        $('#firm').select2();
        $(".delete_yes").live("click", function ()
        {

            var hidin = $(this).parent().parent().find('.id').val();
            $.ajax({
                url: BASE_URL + "masters/users/delete_user",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "masters/users/");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });
</script>