<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    table tr td:nth-child(5){text-align:center;}
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="tab-header card">
            <ul class="nav nav-tabs md-tabs tab-timeline" role="tablist" id="mytab">
                <li class="nav-item col-md-2">
                    <a class="nav-link active" data-toggle="tab" href="#customer-details" role="tab">Customer List</a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item col-md-2">
                    <a class="nav-link <?php if (!$this->user_auth->is_action_allowed('masters', 'customer', 'add')): ?>alerts<?php endif ?>" data-toggle="tab" href="<?php if ($this->user_auth->is_action_allowed('masters', 'customer', 'add')): ?>#customer<?php endif ?>" role="tab">Add Customer</a>
                    <div class="slide"></div>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="customer-details" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">Customer Details</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="customer_table">
                                <thead>
                                <th>S.No</th>
                                <th>Customer #</th>
                                <th>Company</th>
                                <th>Contact Person</th>
                                <th>Mobile#</th>
                                <th>City</th>
                                <th>GSTIN</th>
                                <th>Email</th>
                                <th>Staff</th>
                                <th class="action-btn-align">Action</th>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="customer" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">Add Customer</h5>
                    </div>
                    <div class="card-block">
                        <form class="form-material" action="<?php echo $this->config->item('base_url'); ?>customer/insert_customer" enctype="multipart/form-data" name="form" method="post">
                            <div class="form-material row">
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-building-alt"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <select id="state_id" name='state_id' class="state_id form-control" >
                                                <option value="">Select State</option>
                                                <?php
                                                if (isset($all_state) && !empty($all_state)) {
                                                    foreach ($all_state as $val) {
                                                        $selected_state = ($val['state'] == "Tamil Nadu" ? 'selected="selected"' : '');
                                                        echo '<option ' . $selected_state . ' value="' . $val['id'] . '">' . $val['state'] . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>

                                            <span id="cuserror" class="val text-danger"></span>
                                            <span class="form-bar"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-building-alt"></i>
                                        </div>
                                        <div class="form-group form-primary">

                                            <input type="text" name="city" class="form-control" id="city"/>
                                            <span id="cuserror8" class="val text-danger"></span>
                                            <span class="form-bar"></span>
                                            <label class="float-label">City</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-briefcase-alt-1"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Company Name <span class="req">*</span></label>
                                            <input type="text" name="store" class="store form-control" id="store"/>
                                            <span class="form-bar"></span>
                                            <span id="cuserror2" class="val text-danger"></span>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-address-book"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Account No</label>
                                            <input type="text" name="acnum" class="form-control" id="acnum"/>
                                            <span id="cuserror11" class="val text-danger"></span>
                                            <span class="form-bar"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-material row">
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-ui-user"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Contact Person <span class="req">*</span></label>
                                            <input type="text" name="name" class="name form-control" id="name" />
                                            <span class="form-bar"></span>
                                            <span id="cuserror1" class="val text-danger"></span>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-money-bag"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Payment Terms</label>
                                            <input type="text"  name="payment_terms"  class="form-control" id="payment_terms"/>
                                            <span id="cuserror14" class="val text-danger"></span>
                                            <span class="form-bar"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-email"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Email Id <span class="req">*</span></label>
                                            <input type="text" name="mail" class="mail form-control email_dup" id="mail" />
                                            <span class="form-bar"></span>
                                            <span id="cuserror5" class="val text-danger"></span>
                                            <span id="duplica" class="val text-danger"></span>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-bank"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Bank Name</label>
                                            <input type="text" name="bank" class="form-control" id="bank"/>
                                            <span id="cuserror6" class="val text-danger"></span>
                                            <span class="form-bar"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-material row">

                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-ui-call"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Mobile Number <span class="req">*</span></label>
                                            <input type="text" name="number" class="number form-control form-align" id="number" />
                                            <span class="form-bar"></span>
                                            <span id="cuserror4" class="val text-danger"></span>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-ui-call"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Mobile Number 2 </label>
                                            <input type="text" name="number2" class="phone2 form-control form-align" id="phone2" />
                                            <span class="form-bar"></span>
                                            <span id="phone2_err" class="val text-danger"></span>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-ui-call"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Mobile Number 3</label>
                                            <input type="text" name="number3" class="phone3 form-control form-align" id="phone3" />
                                            <span id="phone3_err" class="val text-danger"></span>
                                            <span class="form-bar"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-bank-alt"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Bank Branch</label>
                                            <input type="text" name="branch" class="form-control" id="branch"/>
                                            <span id="cuserror10" class="val text-danger"></span>
                                            <span class="form-bar"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-material row">

                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-ui-user"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <select id='staff_name'  name="staff_name"  class="form-control ">
                                                <option value="">Select Staff Name</option>
                                                <?php
                                                if (isset($staff_name) && !empty($staff_name)) {
                                                    foreach ($staff_name as $val) {
                                                        ?>
                                                        <option  value="<?php echo $val['id'] ?>"><?php echo $val['name'] ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <span class="form-bar"></span>
                                            <span id="cuserror12" class="val text-danger"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-location-pin"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Address1 <span class="req">*</span></label>
                                            <textarea name="address1" id="address" class="form-control form-align"></textarea>
                                            <span class="form-bar"></span>
                                            <span id="cuserror3" class="val text-danger"></span>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-location-pin"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Address2</label>
                                            <textarea name="address2" id="address2" class="form-control form-align"></textarea>
                                            <span class="form-bar"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-bank"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">IFSC Code</label>
                                            <input type="text" name="ifsc" class="form-control" id="">
                                            <span class="form-bar"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-material row">
                                <!--                                <div class="col-md-3">
                                                                    <div class="material-group">
                                                                        <div class="material-addone">
                                                                            <i class="icofont icofont-briefcase-alt-1"></i>
                                                                        </div>
                                                                        <div class="form-group form-primary">
                                                                            <label class="float-label">Nick Name</label>
                                                                            <input type="text" name="nick_name" class=" form-control " id="nick_name" />
                                                                            <span class="form-bar"></span>
                                                                            <span id="nick" class="val text-danger"></span>

                                                                        </div>
                                                                    </div>
                                                                </div>-->
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-briefcase-alt-1"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Password <span class="req">*</span></label>
                                            <input type="password" name="password" class="form-control" id="pass" />
                                            <span id="password_err" class="val text-danger"></span>
                                            <span class="form-bar"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-briefcase-alt-1"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">GSTIN </label>
                                            <input type="text" name="tin" class="form-control" id="tin" />
                                            <span id="tin_err" class="val text-danger"></span>
                                            <span class="form-bar"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row text-center m-10">
                                <div class="col-md-12 text-center">
                                    <input type="submit" name="submit" class="btn btn-primary m-b-10 btn-sm waves-effect waves-light m-r-20" value="Save" id="submit" tabindex="1"/>
                                    <input type="reset" value="Clear" class="btn btn-danger waves-effect m-b-10 btn-sm waves-light" id="reset" tabindex="1"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--<div id="profile_img_<?= $val['id'] ?>" class="modal fade in close_div" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false"  align="center">
    <div class="modal-dialog">
        <div class="modal-content">
            <a class="close1" data-dismiss="modal">×</a>
            <div class="modal-body">
                <img src="<?= $this->config->item('base_url') . '/cust_image/thumb/' . $val['cus_image'] ?>" width="50%" />

            </div>
        </div>
    </div>
</div>-->

<script type="text/javascript">
    $(document).on('click', '.alerts', function () {
        sweetAlert("Oops...", "This Access is blocked!", "error");
        return false;
    });
    $(function () {
        $('input').keyup(function () {
            input_val = $(this).val();
            input_upper = input_val.toLocaleUpperCase();
            $(this).val(input_upper);
        });
    });

    $("#pass").live('blur', function ()
    {
        var pass = $("#pass").val();
        if (pass == "")
        {
            $("#password_err").html("Required Field");
        } else
        {
            $("#password_err").html("");
        }
    });
    $('#state_id').live('blur', function ()
    {
        var state = $('#state_id').val();
        if (state == "")
        {
            $('#cuserror').html("Select State");
        } else
        {
            $('#cuserror').html("");
        }
    });
    $('.state_id').live('blur', function ()
    {
        var state = $('.state_id').val();
        if (state == "37")
        {
            $('#cuserror').html('<input type="text" name="state" placeholder="Fill the other state" class="state form-control form-align" id="state" autocomplete="off">\n\
                     <span id="cuserror_state" class="val"  style="color:#F00; font-style:oblique;"></span>');
        }
    });

    $('#state').live('blur', function () {

        var this_ = $(this).val();
        if (this_ == "")
        {
            $('#cuserror_state').html("Required Field");
        } else
        {
            $('#cuserror_state').html("");
            $.ajax({
                type: "GET",
                url: "<?php echo $this->config->item('base_url'); ?>" + "customer/add_state",
                data: {state: this_},
                success: function (datas) {

                }
            });
        }

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
    $("#store").live('blur', function ()
    {
        var store = $("#store").val();
        if (store == "" || store == null || store.trim().length == 0)
        {
            $("#cuserror2").html("Required Field");
        } else
        {
            $("#cuserror2").html("");
        }
    });
    $("#mail").live('blur', function ()
    {
        var mail = $("#mail").val();
        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (mail == "")
        {
            $("#cuserror5").text("Required Field");
        } else if (!efilter.test(mail))
        {
            $("#cuserror5").text("Enter Valid Email");
        } else
        {
            $("#cuserror5").text("");
        }
    });

    $("#number").live('blur', function ()
    {
        var number = $("#number").val();
        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;
        if (number == "" || number == null || number.trim().length == 0) {
            $("#cuserror4").html("Required Field");
        } else if (!nfilter.test(number))
        {
            $("#cuserror4").html("Enter Valid Mobile Number");
        } else if (number != "") {
            $.ajax({
                type: 'POST',
                data: {mobile: $.trim($('#number').val())},
                url: '<?php echo base_url(); ?>customer/is_mobile_number_available/',
                success: function (data) {
                    if (data == 'yes') {
                        $("#cuserror4").html('This Mobile Number is already taken');
                    } else {
                        $("#cuserror4").html('');
                    }
                }
            });
        } else
        {
            $("#cuserror4").html("");
        }
    });
    $("#phone2").live('blur', function ()
    {
        var number = $("#phone2").val();
        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;
        if (number != "") {
            if (!nfilter.test(number))
            {
                $("#phone2_err").html("Enter Valid Mobile Number");
            } else
            {
                $("#phone2_err").html("");
            }
        } else {
            $("#phone2_err").html("");
        }
    });
    $("#phone3").live('blur', function ()
    {
        var number = $("#phone3").val();
        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;
        if (number != "")
        {
            if (!nfilter.test(number))
            {
                $("#phone3_err").html("Enter Valid Mobile Number");
            } else
            {
                $("#phone3_err").html("");
            }
        } else {
            $("#phone3_err").html("");
        }
    });

    /* $('#address').live('blur', function ()
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
     $('#bank').live('blur', function ()
     {
     var bank = $('#bank').val();
     if (bank == "" || bank == null || bank.trim().length == 0)
     {
     $('#cuserror6').html("Required Field");
     } else
     {
     $('#cuserror6').html("");
     }
     });
     $('#percentage').live('blur', function ()
     {
     var percentage = $('#percentage').val();
     var pefilter = /^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;
     if (percentage == "" || percentage == null || percentage.trim().length == 0)
     {
     $('#cuserror7').html("Required Field");
     } else if (!pefilter.test(percentage))
     {
     $("#cuserror7").html("Enter Valid Percentage");
     } else
     {
     $('#cuserror7').html("");
     }
     });
     $('#city').live('blur', function ()
     {
     var city = $('#city').val();
     if (city == "")
     {
     $('#cuserror8').html("Required Field");
     } else
     {
     $('#cuserror8').html("");
     }
     });
     $("#pincode").live('blur', function ()
     {
     var pincode = $("#pincode").val();
     if (pincode == "")
     {
     $("#cuserror9").html("Required Field");
     } else if (pincode.length != 6)
     {
     $("#cuserror9").html("Maximum 6 characters");
     } else
     {
     $("#cuserror9").html("");
     }
     });
     $("#branch").live('blur', function ()
     {
     var branch = $("#branch").val();
     if (branch == "" || branch == null || branch.trim().length == 0)
     {
     $("#cuserror10").html("Required Field");
     } else
     {
     $("#cuserror10").html("");
     }
     });
     $("#acnum").live('blur', function ()
     {
     var acnum = $("#acnum").val();
     var acfilter = /^[a-zA-Z0-9]+$/;
     if (acnum == "")
     {
     $("#cuserror11").html("Required Field");
     } else if (!acfilter.test(acnum))
     {
     $("#cuserror11").html("Numeric or Alphanumeric");
     } else
     {
     $("#cuserror11").html("");
     }
     }); */

    $('#staff_name').live('change', function ()
    {
        var staff_name = $('#staff_name').val();
        if (staff_name == "")
        {
            $('#cuserror12').html("Required Field");
        } else
        {
            $('#cuserror12').html("");
        }
    });
    $('#address').on('blur', function ()
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
    /* $('#agent_comm').live('blur', function ()
     {
     var agent_comm = $('#agent_comm').val();
     var apefilter = /^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;
     if (agent_comm == "" || agent_comm == null || agent_comm.trim().length == 0)
     {
     $('#cuserror13').html("Required Field");
     } else if (!apefilter.test(agent_comm))
     {
     $("#cuserror13").html("Enter Valid Percentage");
     } else
     {
     $('#cuserror13').html("");
     }
     });
     $("#payment_terms").live('blur', function ()
     {
     var payment_terms = $("#payment_terms").val();

     if (payment_terms == "")
     {
     $("#cuserror14").html("Required Field");
     } else
     {
     $("#cuserror14").html("");
     }
     });
     $('#tin_vat').live('blur', function ()
     {
     var tin = $('#tin_vat').val();
     if (tin == "" || tin == null || tin.trim().length == 0)
     {
     $('#cuserror15').html("Required Field");
     } else
     {
     $('#cuserror15').html("");
     }
     });

     $('#c_cst').live('blur', function ()
     {
     var cst = $('#c_cst').val();
     if (cst == "")
     {
     $("#c_cst").css('border-color', 'red');
     } else
     {
     $("#c_cst").css('border-color', '');
     }
     });
     $('#c_vat').live('blur', function ()
     {
     var vat = $('#c_vat').val();
     if (vat == "")
     {
     $("#c_vat").css('border-color', 'red');
     } else
     {
     $("#c_vat").css('border-color', '');
     }
     });*/
    $('#reset').live('click', function ()
    {
        $('.val').html("");
    });
    $('input[name!="mail"], textarea').live('keyup', function () {

        this_val = $(this).val();
        value = this_val.toUpperCase();
        $(this).val(value);

    });
</script>
<script type="text/javascript">
    $('#submit').live('click', function ()
    {
        var i = 0;
        var state = $('#state_id').val();
        if (state == "")
        {
            $('#cuserror').html("Select State");
            i = 1;
        } else
        {
            $('#cuserror').html("");
        }
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
        var password = $("#pass").val();
        if (password == "")
        {
            $("#password_err").html("Required Field");
            i = 1;
        } else
        {
            $("#password_err").html("");
        }
        var store = $("#store").val();
        if (store == "" || store == null || store.trim().length == 0)
        {
            $("#cuserror2").html("Required Field");
            i = 1;
        } else
        {
            $("#cuserror2").html("");
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
        var mail = $("#mail").val();
        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (mail == "")
        {
            $("#cuserror5").text("Required Field");
            i = 1;
        } else if (!efilter.test(mail))
        {
            $("#cuserror5").text("Enter Valid Email");
            i = 1;
        } else
        {
            $("#cuserror5").text("");
        }

        /* var address = $('#address').val();
         if (address == "" || address == null || address.trim().length == 0)
         {
         $('#cuserror3').html("Required Field");
         i = 1;
         } else
         {
         $('#cuserror3').html("");
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
         var bank = $('#bank').val();
         if (bank == "" || bank == null || bank.trim().length == 0)
         {
         $('#cuserror6').html("Required Field");
         i = 1;
         } else
         {
         $('#cuserror6').html("");
         }
         var city = $('#city').val();
         if (city == "")
         {
         $('#cuserror8').html("Required Field");
         i = 1;
         } else
         {
         $('#cuserror8').html("");
         }
         var percentage=$('#percentage').val();
         var pefilter=/^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;
         if(percentage=="" || percentage==null || percentage.trim().length==0)
         {
         $('#cuserror7').html("Required Field");
         i=1;
         }
         else if(!pefilter.test(percentage))
         {
         $("#cuserror7").html("Enter Valid Percentage");
         i=1;
         }
         else
         {
         $('#cuserror7').html("");
         }

         var pincode=$("#pincode").val();
         if(pincode=="")
         {
         $("#cuserror9").html("Required Field");
         i=1;
         }
         else if (pincode.length!=6)
         {
         $("#cuserror9").html("Maximum 6 characters");
         i=1;
         }
         else
         {
         $("#cuserror9").html("");
         }
         var branch = $("#branch").val();
         if (branch == "" || branch == null || branch.trim().length == 0)
         {
         $("#cuserror10").html("Required Field");
         i = 1;
         } else
         {
         $("#cuserror10").html("");
         }
         var acnum = $("#acnum").val();
         var acfilter = /^[a-zA-Z0-9]+$/;
         if (acnum == "")
         {
         $("#cuserror11").html("Required Field");
         i = 1;
         } else if (!acfilter.test(acnum))
         {
         $("#cuserror11").html("Numeric or Alphanumeric");
         i = 1;
         } else
         {
         $("#cuserror11").html("");
         } */
        var staff_name = $('#staff_name').val();
        if (staff_name == "")
        {
            $('#cuserror12').html("Required Field");
            i = 1;
        } else
        {
            $('#cuserror12').html("");
        }

        var number = $("#number").val();
        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;
        if (number == "" || number == null || number.trim().length == 0) {
            $("#cuserror4").html("Required Field");
            i = 1;
        } else if (!nfilter.test(number))
        {
            $("#cuserror4").html("Enter Valid Mobile Number");
            i = 1;
        } else if (number != "") {
            $.ajax({
                type: 'POST',
                data: {mobile: $.trim($('#number').val())},
                url: '<?php echo base_url(); ?>customer/is_mobile_number_available/',
                success: function (data) {
                    if (data == 'yes') {
                        $("#cuserror4").html('This Mobile Number is already taken');
                        i = 1;
                    } else {
                        $("#cuserror4").html('');
                    }
                }
            });
        } else
        {
            $("#cuserror4").html("");
        }

        var phone2 = $("#phone2").val();
        if (phone2 != "")
        {
            if (!nfilter.test(phone2))
            {
                $("#phone2_err").html("Enter Valid Mobile Number");
                i = 1;
            } else
            {
                $("#phone2_err").html("");
            }
        } else {
            $("#phone2_err").html("");
        }
        var phone3 = $("#phone3").val();
        if (phone3 != "")
        {
            if (!nfilter.test(phone3))
            {
                $("#phone3_err").html("Enter Valid Mobile Number");
                i = 1;
            } else
            {
                $("#phone3_err").html("");
            }
        } else {
            $("#phone3_err").html("");
        }

        /*var agent_comm = $('#agent_comm').val();
         var apefilter = /^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;
         if (agent_comm == "" || agent_comm == null || agent_comm.trim().length == 0)
         {
         $('#cuserror13').html("Required Field");
         i = 1;
         } else if (!apefilter.test(agent_comm))
         {
         $("#cuserror13").html("Enter Valid Percentage");
         i = 1;
         } else
         {
         $('#cuserror13').html("");
         }
         var payment_terms = $("#payment_terms").val();

         if (payment_terms == "")
         {
         $("#cuserror14").html("Required Field");
         i = 1;
         } else
         {
         $("#cuserror14").html("");
         }
         var tin = $('#tin_vat').val();
         if (tin == "" || tin == null || tin.trim().length == 0)
         {
         $('#cuserror15').html("Required Field");
         i = 1;
         } else
         {
         $('#cuserror15').html("");
         }
         var cst=$('#c_cst').val();
         if(cst=="")
         {
         $("#c_cst").css('border-color','red');
         i=1;
         }
         else
         {
         $("#c_cst").css('border-color','');
         }
         var vat=$('#c_vat').val();
         if(vat=="")
         {
         $("#c_vat").css('border-color','red');
         i=1;
         }
         else
         {
         $("#c_vat").css('border-color','');
         } */
        var mess = $('#duplica').html();
        if ((mess.trim()).length > 0)
        {
            i = 1;
        }
//        console.log(i);
//        return false;
        if (i == 1)
        {
            return false;
        } else
        {
            return true;
        }

    });


    $(".email_dup").live('blur', function ()
    {
        email = $("#mail").val();
        if (email != "") {
            $.ajax({
                url: BASE_URL + "customer/add_duplicate_email",
                type: 'get',
                data: {value1: email},
                success: function (result)
                {
                    $("#duplica").html(result);
                }
            });
        } else {
            $("#duplica").html("");
        }
    });
</script>



<?php
if (isset($customer) && !empty($customer)) {
    foreach ($customer as $val) {
        ?>
        <div id="test3_<?php echo $val['id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
            <div class="modal-dialog">
                <div class="modal-content modalcontent-top">
                    <div class="modal-header modal-padding modalcolor">
                        <h4 id="myModalLabel" class="inactivepop">In-Active Customer</h4>
                        <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                    </div>
                    <div class="modal-body">
                        Do You Want In-Active This Customer? <?= $val['name']; ?> <strong>(<?= $val['store_name']; ?>)</strong>
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
    function delete_customer(val) {
        $('#test3_' + val).modal('show');
    }
    $(document).ready(function ()
    {
        $(".delete_yes").on("click", function ()
        {

            var hidin = $(this).parent().parent().find('.id').val();

            $.ajax({
                url: BASE_URL + "customer/delete_customer",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "customer/");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");
        $('#customer_table').DataTable({
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
                url: BASE_URL + "customer/ajaxList",
                "type": "POST",
            },
            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [0, 9], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
        });
    });
</script>