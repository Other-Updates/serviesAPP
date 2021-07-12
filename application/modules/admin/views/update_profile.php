<?php
$theme_path = $this->config->item('theme_locations') . $this->config->item('active_template');
$user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
$data["user_details"] = $user_details = $this->user_model->get_user1($user_info[0]['id']);
?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<div>
    <form action="<?php echo $this->config->item('base_url'); ?>admin/update_profile" method="post" enctype="multipart/form-data" name="sform">
        <div class="row">
            <div class="col-lg-12">
                <div class="cover-profile">
                    <div class="profile-bg-img">
                        <img class="profile-bg-img img-fluid" src="<?= $theme_path; ?>/assets/images/bg-img1.jpg" alt="bg-img">
                        <div class="card-block user-info">
                            <div class="col-md-12">
                                <div class="media-left">
                                    <a href="#" class="profile-image">
                                        <?php
                                        $exists = file_exists(FCPATH . 'admin_image/original/' . $admin[0]['admin_image']);
                                        $f_name = $admin[0]['admin_image'];
                                        $logo_image = (!empty($f_name) && $exists) ? $f_name : "admin_icon.png";
                                        ?>
                                        <img class="add_staff_thumbnail user-img img-radius img-100" src="<?php echo $this->config->item("base_url") . 'admin_image/original/' . $logo_image; ?>" alt="user-img" width="100px" height="100px"/>
                                    </a>
                                </div>
                                <div class="media-body row">
                                    <div class="col-lg-12">
                                        <div class="user-title">
                                            <h2><?php echo ucfirst($admin[0]['username']); ?></h2>
                                            <span class="text-white"></span>
                                        </div>
                                    </div>
                                    <div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="sup-align profilemargin">Profile Details</h5>
            </div>
            <div class="card-block">
                <div class="form-group row">
                    <div class="col-md-3">
                        <label class="col-form-label">User Name</label>
                        <input type="text" class="name form-control admin_name" name="admin_name" id="admin_name" value="<?= $admin[0]['username']; ?>" required />
                        <span id="profileerror" class="val text-danger"></span>
                        <input type="hidden" name="id" id="admin_name" class="admin_name" value="<?php echo $admin[0]['id']; ?>"/>
                    </div>
                    <div class="col-md-3">
                        <label class="col-form-label">Password</label>
                        <input type="password" class="name form-control form-align" name="password"   id="password" value="" autocomplete="off" maxlength="20" tabindex="3"  />
                        <span id="profileerror1"  class="val text-danger"></span>
                    </div>
                    <div class="col-md-3">
                        <label class="col-form-label">Profile Picture</label>
                        <input type='file' name="admin_image" id="imgInp" class="form-control"/>
                        <span id="profileerror9" class="val text-danger"></span>
                    </div>
                </div>
            </div>
        </div>



        <div class="" style="display: <?php
        $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
        echo ($user_info[0]['role'] == 1) ? 'block' : 'none'
        ?>">
            <div class="card">
                <div class="card-header">
                    <h5 class="cpy-details sup-align profilemargin">Company Details</h5>
                </div>
                <div class="card-block">
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label class="col-form-label">Company Name</label>
                            <input type="text" class="name form-control form-align" name="company[company_name]" id="company_name" value="<?php echo $company_details[0]['company_name']; ?>" />
                            <span id="profileerror2" class="val text-danger"></span>
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label" >Phone Number</label>
                            <input type="text" class="name form-control form-align" name="company[phone_no]" id="phone_no" value="<?php echo $company_details[0]['phone_no']; ?>"  />
                            <span id="profileerror3"  class="val text-danger"></span>
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label">Address Line 1</label>
                            <input type="text" class="name form-control form-align" name="company[address1]" id="address1" value="<?php echo $company_details[0]['address1']; ?>"  />
                            <span id="profileerror4" class="val text-danger"></span>
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label" >Address Line 2</label>
                            <input type="text" class="name form-control form-align" name="company[address2]" id="address2" value="<?php echo $company_details[0]['address2']; ?>" />
                            <span id="profileerror10" class="val text-danger"></span>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label class="col-form-label" >City</label>
                            <input type="text" class="name form-control form-align" name="company[city]" id="city"  value="<?php echo $company_details[0]['city']; ?>" />
                            <span id="profileerror5" class="val text-danger"></span>
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label" >State</label>
                            <input type="text" class="name form-control form-align" name="company[state]" id="state" value="<?php echo $company_details[0]['state']; ?>" />
                            <span id="profileerror6" class="val text-danger"></span>
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label" >Pin Code</label>
                            <input type="text" class="name form-control form-align" name="company[pin]" id="pin" value="<?php echo $company_details[0]['pin']; ?>"  />
                            <span id="profileerror7" class="val text-danger"></span>
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label" >Email Id</label>
                            <input type="text" class="name form-control form-align" name="company[email]" id="email" value="<?php echo $company_details[0]['email']; ?>"  />
                            <span id="profileerror8" class="val text-danger"></span>
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label" >Account Number</label>
                            <input type="text" class="name form-control form-align" name="company[ac_no]"  value="<?php echo $company_details[0]['ac_no']; ?>"  />
                            <span id="profileerror7" class="val text-danger"></span>
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label">IFSC Code</label>
                            <input type="text" class="name form-control form-align" name="company[ifsc]" value="<?php echo $company_details[0]['ifsc']; ?>"  />
                            <span id="profileerror8"  class="val text-danger"></span>
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label" >Bank Name</label>
                            <input type="text" class="name form-control form-align" name="company[bank_name]" value="<?php echo $company_details[0]['bank_name']; ?>"  />
                            <span id="profileerror7" class="val text-danger"></span>
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label" >Branch</label>
                            <input type="text" class="name form-control form-align" name="company[branch]"  value="<?php echo $company_details[0]['branch']; ?>"  />
                            <span id="profileerror8" class="val text-danger"></span>
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label">GSTIN No</label>
                            <input type="text" class="name form-control form-align" name="company[tin_no]" value="<?php echo $company_details[0]['tin_no']; ?>"  />
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label">PAN ID</label>
                            <input type="text" class="name form-control form-align" name="company[pan_id]" value="<?php echo $company_details[0]['pan_id']; ?>"  />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12 text-center">
                        <input type="submit" value="Update" name="submit" id="submit"  class="btn btn-round btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light"/>
                        <input type="reset" value="Clear" id="cancel" class="btn btn-round btn-danger waves-effect m-b-10 btn-sm waves-light"  tabindex="9"/>
                        <a href="<?php echo $this->config->item('base_url') . 'admin/' ?>" class="btn btn-round btn-inverse btn-sm waves-effect waves-light m-b-10"><span class="glyphicon"></span> Back </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="" style="display: <?php
        $user_info = $this->user_info = $this->user_auth->get_from_session('user_info');
        echo ($user_info[0]['role'] != 1) ? 'block' : 'none'
        ?>">
            <div class="card">
                <div class="card-header">
                    <h5 class="cpy-details sup-align profilemargin">User Details</h5>
                </div>
                <div class="card-block">
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label class="col-form-label">ID Proof No</label>
                            <input type="text" class=" form-control" value="<?= $user_details[0]['id_proof_no'] ?>" id="id_proof_no" tabindex="1" readonly=""/>
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label" >ID Proof Type</label>
                            <input type="text" class=" form-control" value="<?= $user_details[0]['id_proof_type'] ?>" id="id_proof_type" tabindex="1" readonly=""/>
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label" >Account Number</label>
                            <input type="text" class="name form-control form-align"  value="<?php echo $user_details[0]['account_num']; ?>"  readonly=""/>
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label">IFSC Code</label>
                            <input type="text" class="name form-control form-align"  value="<?php echo $user_details[0]['ifsc']; ?>" readonly="" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3">
                            <label class="col-form-label" >Bank Name</label>
                            <input type="text" class="name form-control form-align"  value="<?php echo $user_details[0]['bank_name']; ?>" readonly="" />
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label" >Branch</label>
                            <input type="text" class="name form-control form-align"   value="<?php echo $user_details[0]['bank_branch']; ?>"  readonly=""/>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="col-form-label" >ID Proof Photo:</label>
                                </div>
                                <div class="col-md-2">
                                    <?php if ($user_details[0]['signature'] != '') { ?>
                                        <img id="blah" src="<?= $this->config->item("base_url") . 'attachement/sign/' . $user_details[0]['signature']; ?>" alt="" height="50px" width="50px">
                                    <?php } else { ?>
                                        <img id="blah" src="<?= $this->config->item("base_url") . 'attachement/sign/no-img.gif' ?>" alt="" height="50px" width="50px">
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12 text-center">
                        <input type="submit" value="Update" name="submit" id="submit"  class="btn btn-round btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light"/>
                        <input type="reset" value="Clear" id="cancel" class="btn btn-round btn-danger waves-effect m-b-10 btn-sm waves-light"  tabindex="9"/>
                        <a href="<?php echo $this->config->item('base_url') . 'admin/' ?>" class="btn btn-round btn-inverse btn-sm waves-effect waves-light m-b-10"><span class="glyphicon"></span> Back </a>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>

<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#imgInp").change(function () {
        if ($(this).val() == "" || $(this).val() == null)
        {

        } else
        {
            readURL(this);
        }
    });
</script>
<script type="text/javascript">
    $('.admin_name').blur(function ()
    {
        var name = $('#admin_name').val();
        if (name == '' || name == null || name.trim().length == 0)
        {

            $('#profileerror').html("Required Field");
        } else
        {
            $('#profileerror').html("");
        }
    });
    $('#password').blur(function ()
    {
        var password = $('#password').val();
        if (password == '')
        {
        } else if (password == null || password.trim().length == 0)
        {
            $('#profileerror1').html("Required Field");
        } else
        {
            $('#profileerror1').html("");
        }
    });
    $('#company_name').blur(function ()
    {
        var cname = $('#company_name').val();
        if (cname == '' || cname == null || cname.trim().length == 0)
        {
            $('#profileerror2').html("Required Field");
        } else
        {
            $('#profileerror2').html("");
        }
    });
    $('#phone_no').blur(function ()
    {
        var phone = $('#phone_no').val();
        if (phone == '' || phone == null || phone.trim().length == 0)
        {
            $('#profileerror3').html("Required Field");
        } else
        {
            $('#profileerror3').html("");
        }
    });
    $('#address1').blur(function ()
    {
        var add1 = $('#address1').val();
        if (add1 == '' || add1 == null || add1.trim().length == 0)
        {
            $('#profileerror4').html("Required Field");
        } else
        {
            $('#profileerror4').html("");
        }
    });
    $('#address2').blur(function ()
    {
        var add2 = $('#address2').val();
        if (add2 == '' || add2 == null || add2.trim().length == 0)
        {
            $('#profileerror10').html("Required Field");
        } else
        {
            $('#profileerror10').html("");
        }
    });
    $('#city').blur(function ()
    {
        var city = $('#city').val();
        if (city == '' || city == null || city.trim().length == 0)
        {
            $('#profileerror5').html("Required Field");
        } else
        {
            $('#profileerror5').html("");
        }
    });
    $('#state').blur(function ()
    {
        var state = $('#state').val();
        if (state == '' || state == null || state.trim().length == 0)
        {
            $('#profileerror6').html("Required Field");
        } else
        {
            $('#profileerror6').html("");
        }
    });
    $('#pin').blur(function ()
    {
        var pin = $('#pin').val();
        if (pin == '' || pin == null || pin.trim().length == 0)
        {
            $('#profileerror7').html("Required Field");
        } else
        {
            $('#profileerror7').html("");
        }
    });
    $('#email').blur(function ()
    {
        var email_id = $('#email').val();
        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (email_id == "")
        {
            $("#profileerror8").html("Required Field");
        } else if (!efilter.test(email_id))
        {
            $("#profileerror8").html("Enter Valid Email");
        } else
        {
            $("#profileerror8").html("");
        }
    });
    // Image validation size checking
    $("#imgInp").change(function () {
//alert('hi');
        var val = $(this).val();

        switch (val.substring(val.lastIndexOf('.') + 1).toLowerCase()) {
            case 'jpg':
            case 'png':
            case 'jpeg':
            case '':
                $("#profileerror9").html("");
                break;
            default:
                $(this).val();
                // error message here
                $("#profileerror9").html("Invalid File Type");
                break;
        }
    });

    $(document).ready(function ()
    {
        $('#submit').click(function ()
        {
            var i = 0;
            var name = $('#admin_name').val();
            if (name == '' || name == null || name.trim().length == 0)
            {
                $('#profileerror').html("Required Field");
                i = 1;
            } else
            {
                $('#profileerror').html("");
            }
            var password = $('#password').val();
            if (password == '')
            {
            } else if (password == null || password.trim().length == 0)
            {
                $('#profileerror1').html("Required Field");
                i = 1;
            } else
            {
                $('#profileerror1').html("");
            }
            var cname = $('#company_name').val();
            if (cname == '' || cname == null || cname.trim().length == 0)
            {
                $('#profileerror2').html("Required Field");
                i = 1;
            } else
            {
                $('#profileerror2').html("");
            }
            var phone = $('#phone_no').val();
            if (phone == '' || phone == null || phone.trim().length == 0)
            {
                $('#profileerror3').html("Required Field");
                i = 1;
            } else
            {
                $('#profileerror3').html("");
            }
            var add1 = $('#address1').val();
            if (add1 == '' || add1 == null || add1.trim().length == 0)
            {
                $('#profileerror4').html("Required Field");
                i = 1;
            } else
            {
                $('#profileerror4').html("");
            }
            var add2 = $('#address2').val();
            if (add2 == '' || add2 == null || add2.trim().length == 0)
            {
                $('#profileerror10').html("Required Field");
                i = 1;
            } else
            {
                $('#profileerror10').html("");
            }
            var city = $('#city').val();
            if (city == '' || city == null || city.trim().length == 0)
            {
                $('#profileerror5').html("Required Field");
                i = 1;
            } else
            {
                $('#profileerror5').html("");
            }
            var state = $('#state').val();
            if (state == '' || state == null || state.trim().length == 0)
            {
                $('#profileerror6').html("Required Field");
                i = 1;
            } else
            {
                $('#profileerror6').html("");
            }
            var pin = $('#pin').val();
            if (pin == '' || pin == null || pin.trim().length == 0)
            {
                $('#profileerror7').html("Required Field");
                i = 1;
            } else
            {
                $('#profileerror7').html("");
            }
            var email_id = $('#email').val();
            var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if (email_id == "" || email_id == null || email_id.trim().length == 0)
            {
                $("#profileerror8").html("Required Field");
                i = 1;
            } else if (!efilter.test(email_id))
            {
                $("#profileerror8").html("Enter Valid Email");
                i = 1;
            } else
            {
                $("#profileerror8").html("");
            }
            var mess = $('#profileerror9').html();
            if ((mess.trim()).length > 0)
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
    });
    $('#cancel').click(function ()
    {
        $('.val').html("");

    });
    $('#email').keyup(function () {
        $(this).val($(this).val().toLowerCase());

    });
</script>