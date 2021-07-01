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
                    <a class="nav-link active" data-toggle="tab" href="#supplier_details" role="tab">Vendor List</a>
                    <div class="slide"></div>
                </li>
                <li class="nav-item col-md-2">
                    <a class="nav-link <?php if (!$this->user_auth->is_action_allowed('masters', 'vendor', 'add')): ?>alerts<?php endif ?>" data-toggle="tab" href="<?php if ($this->user_auth->is_action_allowed('masters', 'vendor', 'add')): ?>#supplier<?php endif ?>" role="tab">Add Vendor</a>
                    <div class="slide"></div>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="supplier_details" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">Vendor Details</h5>
                    </div>
                    <div class="card-block">
                        <div class="dt-responsive table-responsive">
                            <table class="table table-striped table-bordered" id="vendor_table">
                                <thead>
                                    <tr>
                                        <th width="33" >S.No</th>
                                        <th width="35">Vendor #</th>
                                        <th width="92">Company </th>
                                        <th width="92">Contact Person</th>
                                        <th width="88">Mobile #</th>
                                        <th width="28">City</th>
                                        <th width="66">GSTIN</th>
                                        <th width="51">Email</th>
                                        <th width="107" class="action-btn-align">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            if (isset($vendor) && !empty($vendor)) {
                $i = 0;
                foreach ($vendor as $val) {
                    $i++
                    ?>
                    <div id="test<?php echo $val['id']; ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" align="center">
                        <div class="modal-dialog">
                            <div class="modal-content modalcontent-top">
                                <div class="modal-header modal-padding modalcolor">
                                    <h4 id="myModalLabel" class="inactivepop">In-Active Vendor</h4>
                                    <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                                </div>
                                <div class="modal-body">
                                    Do You Want In-Active This Vendor? <?php echo $val['name']; ?> <strong>(<?php echo $val['store_name']; ?>)</strong>
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
            <div class="tab-pane" id="supplier" role="tabpanel">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-header-text">Add Vendor</h5>
                    </div>
                    <div class="card-block">
                        <form class="form-material" action="<?php echo $this->config->item('base_url'); ?>vendor/insert_vendor" enctype="multipart/form-data" name="form" method="post" novalidate>
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
                                            <span id="superror" class="val text-danger"></span>
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
                                            <span class="form-bar"></span>
                                            <span id="superror10" class="val text-danger"></span>
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
                                            <input type="text" name="store" class="store form-control" id="store"/>
                                            <span class="form-bar"></span>
                                            <span id="superror2" class="val text-danger"></span>

                                            <label class="float-label">Company Name <span class="req">*</span></label>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-address-book"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <input type="text" name="acnum" class="form-control" id="acnum"/>
                                            <span class="form-bar"></span>
                                            <span id="superror9" class="val text-danger"></span>
                                            <label class="float-label">Account No</label>
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
                                            <input type="text" name="number" class="number form-control" id="number" />
                                            <span class="form-bar"></span>
                                            <span id="superror4" class="val text-danger"></span>
                                            <label class="float-label">Mobile Number <span class="req">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-ui-call"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <input type="text" name="number2" class="phone2 form-control" id="phone2" />
                                            <span class="form-bar"></span>
                                            <span id="phone2_err" class="val text-danger" ></span>
                                            <label class="float-label">Mobile Number 2</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-ui-call"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <input type="text" name="number3" class="phone3 form-control" id="phone3"/>
                                            <span class="form-bar"></span>
                                            <span id="phone3_err" class="val text-danger"></span>
                                            <label class="float-label">Mobile Number 3</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-bank"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <input type="text" name="bank" class="form-control " id="bank"/>
                                            <span class="form-bar"></span>
                                            <span id="superror6" class="val text-danger"></span>
                                            <label class="float-label">Bank Name</label>
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
                                            <input type="text" name="name" class="name form-control " id="name"/>
                                            <span class="form-bar"></span>
                                            <span id="superror1" class="val text-danger"></span>

                                            <label class="float-label">Contact Person <span class="req">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-money-bag"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <input type="text" name="payment_terms" class="number form-control " id="payment_terms"/>
                                            <span class="form-bar"></span>
                                            <span id="superror11" class="val text-danger"></span>
                                            <label class="float-label">Payment Terms</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-email"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <input type="text" name="mail" class="mail form-control" id="mail" />
                                            <span class="form-bar"></span>
                                            <span id="superror5" class="val text-danger"></span>
                                            <span id="duplica" class="val text-danger"></span>
                                            <label class="float-label">Email Id <span class="req">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-bank-alt"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <input type="text" name="branch" class="form-control " id="branch"/>
                                            <span class="form-bar"></span>
                                            <span id="superror8" class="val text-danger"></span>
                                            <label class="float-label">Bank Branch</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-material row">
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-location-pin"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <textarea name="address1" id="address1" class="form-control" autocomplete="off"></textarea>
                                            <span class="form-bar"></span>
                                            <span id="superror3" class="val text-danger"></span>
                                            <label class="float-label">Address1 <span class="req">*</span></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-location-pin"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <textarea name="address2" id="address2" class="form-control"></textarea>
                                            <span class="form-bar"></span>
                                            <label class="float-label">Address2</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-location-pin"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <input type="text" class="form-control " name="pin" id="pincode" />
                                            <span class="form-bar"></span>
                                            <span id="superror7" class="val text-danger"></span>
                                            <label class="float-label">Pin Code</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-bank"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <input type="text" name="ifsc" class="form-control " id=""/>
                                            <span class="form-bar"></span>
                                            <label class="float-label">IFSC Code</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-briefcase-alt-1"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">Nick Name <span class="req">*</span></label>
                                            <input type="text" name="nick_name" class=" form-control " id="nick_name" />
                                            <span class="form-bar"></span>
                                            <span id="nick" class="val text-danger"></span>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="material-group">
                                        <div class="material-addone">
                                            <i class="icofont icofont-briefcase-alt-1"></i>
                                        </div>
                                        <div class="form-group form-primary">
                                            <label class="float-label">GSTIN</label>
                                            <input type="text" name="tin" class=" form-control " id="tin" />
                                            <span class="form-bar"></span>
                                            <span id="tin_no" class="val text-danger"></span>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row text-center m-10">
                                <div class="col-md-12 text-center">
                                    <input type="submit" name="submit" class="btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light" value="Save" id="submit" tabindex="1"/>
                                    <input type="reset" value="Clear" class="btn btn-danger waves-effect m-b-10 btn-sm waves-light" id="reset" tabindex="1"/>
                                    <a href="<?php echo $this->config->item('base_url') . 'vendor/' ?>" class="btn btn-inverse btn-sm waves-effect waves-light m-b-10" tabindex="1"> Back </a>
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
    function delete_vendor(val) {
        $('#test' + val).modal('show');
    }
    $('#state_id').on('blur', function ()
    {
        var state = $('#state_id').val();
        if (state == "")
        {
            $('#superror').html("Select State");
        } else
        {
            $('#superror').html("");
        }
    });
    $("#name").on('blur', function ()
    {
        var name = $("#name").val();
        var filter = /^[a-zA-Z.\s]{3,30}$/;
        if (name == "" || name == null || name.trim().length == 0)
        {
            $("#superror1").html("Required Field");
        } else if (!filter.test(name))
        {
            $("#superror1").html("Alphabets and Min 3 to Max 30 ");
        } else
        {
            $("#superror1").html("");
        }
    });
    $("#store").on('blur', function ()
    {
        var store = $("#store").val();
        if (store == "" || store == null || store.trim().length == 0)
        {
            $("#superror2").html("Required Field");
        } else
        {
            $("#superror2").html("");
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
    $('#address1').on('blur', function ()
    {
        var address = $('#address1').val();
        if (address == "" || address == null || address.trim().length == 0)
        {
            $('#superror3').html("Required Field");
        } else
        {
            $('#superror3').html("");
        }
    });
    $("#mail").on('blur', function ()
    {
        var mail = $("#mail").val();
        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (mail == "")
        {
            $("#superror5").html("Required Field");
        } else if (!efilter.test(mail))
        {
            $("#superror5").html("Enter Valid Email");
        } else
        {
            $("#superror5").html("");
        }
    });

    $("#number").on('blur', function ()
    {
        var number = $("#number").val();
        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;

        if (number == "" || number == null || number.trim().length == 0) {
            $("#superror4").html("Required Field");
        } else if (!nfilter.test(number))
        {
            $("#superror4").html("Enter Valid Mobile Number");
        } else if (number != '') {
            $.ajax({
                type: 'POST',
                data: {mobile: $.trim($('#number').val())},
                url: '<?php echo base_url(); ?>vendor/is_mobile_number_available/',
                success: function (data) {
                    if (data == 'yes') {
                        $("#superror4").html('This Mobile Number is already taken');
                    } else {
                        $("#superror4").html('');
                    }
                }
            });
        } else
        {
            $("#superror4").html("");
        }
    });
    $("#phone2").on('blur', function ()
    {
        var number = $("#phone2").val();
        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;
        if (number != "")
        {
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
    $("#phone3").on('blur', function ()
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
    $('#reset').on('click', function ()
    {
        $('.val').html("");
    });

    $('input[name!="mail"], textarea').on('keyup', function () {

        this_val = $(this).val();
        value = this_val.toUpperCase();
        $(this).val(value);

    });


    /* $('#address1').on('blur',function()
     {
     var address=$('#address1').val();
     if(address=="" || address==null || address.trim().length==0)
     {
     $('#superror3').html("Required Field");
     }
     else
     {
     $('#superror3').html("");
     }
     });
     $("#number").on('blur',function()
     {
     var number=$("#number").val();
     var nfilter=/^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
     if(number=="")
     {
     $("#superror4").html("Required Field");
     }
     else if(!nfilter.test(number))
     {
     $("#superror4").html("Enter Valid Mobile Number");
     }
     else
     {
     $("#superror4").html("");
     }
     });
     $("#mail").on('blur',function()
     {
     var mail=$("#mail").val();
     var efilter=/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
     if(mail=="")
     {
     $("#superror5").html("Required Field");
     }
     else if(!efilter.test(mail))
     {
     $("#superror5").html("Enter Valid Email");
     }
     else
     {
     $("#superror5").html("");
     }
     });
     $('#bank').on('blur',function()
     {
     var bank=$('#bank').val();
     if(bank=="" || bank==null || bank.trim().length==0)
     {
     $('#superror6').html("Required Field");
     }
     else
     {
     $('#superror6').html("");
     }
     }); */
    /*$('#percentage').on('blur',function()
     {
     var percentage=$('#percentage').val();
     if(percentage=="" || percentage==null || percentage.trim().length==0)
     {
     $('#superror7').html("Required Field");
     }
     else if (percentage.trim().length>3 || percentage>100)
     {
     $("#superror7").html("Invalid Selling Percentage");
     }
     else
     {
     $('#superror7').html("");
     }
     });
     $("#pincode").on('blur',function()
     {
     var pincode=$("#pincode").val();
     if(pincode=="")
     {
     $("#superror7").html("Required Field");
     }
     else if (pincode.length!=6)
     {
     $("#superror7").html("Maximum 6 Numbers");
     }
     else
     {
     $("#superror7").html("");
     }
     });
     $("#branch").on('blur',function()
     {
     var branch=$("#branch").val();
     if(branch=="" || branch==null || branch.trim().length==0)
     {
     $("#superror8").html("Required Field");
     }
     else
     {
     $("#superror8").html("");
     }
     });
     $("#acnum").on('blur',function()
     {
     var acnum=$("#acnum").val();
     var acfilter=/^[a-zA-Z0-9]+$/;
     if(acnum=="")
     {
     $("#superror9").html("Required Field");
     }
     else if(!acfilter.test(acnum))
     {
     $("#superror9").html("Numeric or Alphanumeric");
     }
     else
     {
     $("#superror9").html("");
     }
     });
     $("#city").on('blur',function()
     {
     var city=$("#city").val();
     if(city=="" || city==null || city.trim().length==0)
     {
     $("#superror10").html("Required Field");
     }
     else
     {
     $("#superror10").html("");
     }
     });
     $("#payment_terms").on('blur',function()
     {
     var payment_terms=$("#payment_terms").val();

     if(payment_terms=="")
     {
     $("#superror11").html("Required Field");
     }
     else
     {
     $("#superror11").html("");
     }
     });*/
    /*$("#tin").on('blur', function ()
     {
     var tin = $("#tin").val();
     if (tin == "" || tin == null || tin.trim().length == 0)
     {
     $("#superror12").html("Required Field");
     } else
     {
     $("#superror12").html("");
     }
     });*/


</script>
<script type="text/javascript">
    $('#submit').on('click', function ()
    {
        var i = 0;
        /* $(".dup_mbl").each(function () {
         get_id = $(this).attr("id");
         get_value = $('#' + get_id + '').val();
         $.ajax({
         type: 'POST',
         data: {mobile: get_value},
         url: '<?php echo base_url(); ?>vendor/is_mobile_number_available/',
         success: function (data) {
         if (data == 'yes') {
         $('#' + get_id + '').closest('div.form-group').find('.dup_err').text('This Mobile Number is already taken');
         } else {
         $('#' + get_id + '').closest('div.form-group').find('.dup_err').text('');
         }
         }
         });
         });*/
        var state = $('#state_id').val();
        if (state == "")
        {
            $('#superror').html("Select State");
            i = 1;
        } else
        {
            $('#superror').html("");
        }
        var name = $("#name").val();
        var filter = /^[a-zA-Z.\s]{3,30}$/;
        if (name == "" || name == null || name.trim().length == 0)
        {
            $("#superror1").html("Required Field");
            i = 1;
        } else if (!filter.test(name))
        {
            $("#superror1").html("Alphabets and Min 3 to Max 30 ");
            i = 1;
        } else
        {
            $("#superror1").html("");
        }
        var store = $("#store").val();
        if (store == "" || store == null || store.trim().length == 0)
        {
            $("#superror2").html("Required Field");
            i = 1;
        } else
        {
            $("#superror2").html("");
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

        var mail = $("#mail").val();
        var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (mail == "")
        {
            $("#superror5").html("Required Field");
            i = 1;
        } else if (!efilter.test(mail))
        {
            $("#superror5").html("Enter Valid Email");
            i = 1;
        } else
        {
            $("#superror5").html("");
        }
        var number = $("#number").val();
        var nfilter = /^(\+91-|\+91|0)?\d{10}$/;
        if (number == "" || number == null || number.trim().length == 0)
        {
            $("#superror4").html("Required Field");
            i = 1;
        } else if (!nfilter.test(number))
        {
            $("#superror4").html("Enter Valid Mobile Number");
            i = 1;
        } else if (number != "") {
            $.ajax({
                type: 'POST',
                data: {mobile: $.trim($('#number').val())},
                url: '<?php echo base_url(); ?>vendor/is_mobile_number_available/',
                success: function (data) {
                    if (data == 'yes') {
                        $("#superror4").html('This Mobile Number is already taken');
                        i = 1;
                    } else {
                        $("#superror4").html('');
                    }
                }
            });
        } else
        {
            $("#superror4").html("");
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
        var address = $('#address1').val();
        if (address == "" || address == null || address.trim().length == 0)
        {
            $('#superror3').html("Required Field");
            i = 1;
        } else
        {
            $('#superror3').html("");
        }
        /* var number = $("#number").val();
         var nfilter = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
         if (number == "")
         {
         $("#superror4").html("Required Field");
         i = 1;
         } else if (!nfilter.test(number))
         {
         $("#superror4").html("Enter Valid Mobile Number");
         i = 1;
         } else
         {
         $("#superror4").html("");
         }
         var mail = $("#mail").val();
         var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
         if (mail == "")
         {
         $("#superror5").html("Required Field");
         i = 1;
         } else if (!efilter.test(mail))
         {
         $("#superror5").html("Enter Valid Email");
         i = 1;
         } else
         {
         $("#superror5").html("");
         }
         var bank = $('#bank').val();
         if (bank == "" || bank == null || bank.trim().length == 0)
         {
         $('#superror6').html("Required Field");
         i = 1;
         } else
         {
         $('#superror6').html("");
         }
         var pincode = $("#pincode").val();
         if (pincode == "")
         {
         $("#superror7").html("Required Field");
         i = 1;
         } else if (pincode.length != 6)
         {
         $("#superror7").html("Maximum 6 Numbers");
         i = 1;
         } else
         {
         $("#superror7").html("");
         }
         var branch = $("#branch").val();
         if (branch == "" || branch == null || branch.trim().length == 0)
         {
         $("#superror8").html("Required Field");
         i = 1;
         } else
         {
         $("#superror8").html("");
         }
         var acnum = $("#acnum").val();
         var acfilter = /^[a-zA-Z0-9]+$/;
         if (acnum == "")
         {
         $("#superror9").html("Required Field");
         i = 1;
         } else if (!acfilter.test(acnum))
         {
         $("#superror9").html("Numeric or Alphanumeric");
         i = 1;
         } else
         {
         $("#superror9").html("");
         }
         var city = $("#city").val();
         if (city == "" || city == null || city.trim().length == 0)
         {
         $("#superror10").html("Required Field");
         i = 1;
         } else
         {
         $("#superror10").html("");
         }
         var payment_terms = $("#payment_terms").val();
         if (payment_terms == "")
         {
         $("#superror11").html("Required Field");
         i = 1;
         } else
         {
         $("#superror11").html("");
         }*/
        /* var tin = $("#tin").val();
         if (tin == "" || tin == null || tin.trim().length == 0)
         {
         $("#superror12").html("Required Field");
         i = 1;
         } else
         {
         $("#superror12").html("");
         }*/
        var mess = $('#duplica').html();
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
</script>
<!--<div id="profile_img_<?= $val['id'] ?>" class="modal fade in close_div" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false"  align="center">
    <div class="modal-dialog">
        <div class="modal-content">
            <a class="close1" data-dismiss="modal">×</a>
            <div class="modal-body">
                <img src="<?= $this->config->item('base_url') . 'vendor_image/original/' . $val['vendor_image'] ?>" width="50%" />

            </div>
        </div>
    </div>
</div>-->

<script type="text/javascript">
    $(document).ready(function () {

        $(".delete_yes").on("click", function ()
        {
            var hidin = $(this).parent().parent().find('.id').val();
            $.ajax({
                url: BASE_URL + "vendor/delete_vendor",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "vendor/");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });

    $(".mail").on('blur', function ()
    {
        mail = $("#mail").val();
        if (mail != "") {
            $.ajax({
                url: BASE_URL + "vendor/add_duplicate_mail",
                type: 'get',
                data: {value1: mail
                },
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