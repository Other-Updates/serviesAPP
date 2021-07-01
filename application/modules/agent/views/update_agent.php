<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/js/jquery-ui-1.10.3.min.js"></script>
<div class="mainpanel">
    <div class="media">
    </div>
    <div class="contentpanel">
        <div class="media">
            <h4>Update Field Agent</h4>
        </div>
        <div class="panel-body">
            <div class="tabs">
                <!-- Nav tabs -->
                <ul class="list-inline tabs-nav tabsize-17" role="tablist">

                    <li role="presentation" class="active"><a href="#update-field" aria-controls="profile" role="tab" data-toggle="tab" aria-expanded="false">Field Agent List</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content tabbor">

                    <div role="tabpanel" class="tab-pane active" id="update-field">
                        <!-- <h4 align="center" class="sup-align">Update Field Agent</h4>-->
                        <form  method="POST"  name="upform" enctype="multipart/form-data" action="<?php echo $this->config->item('base_url') . 'agent/update_agent'; ?>">
                            <table class="table table-striped  responsive no-footer dtr-inline">
                                <?php
                                if (isset($agent) && !empty($agent)) {
                                    $i = 0;
                                    foreach ($agent as $val) {
                                        $i++
                                        ?>
                                        <tr>
                                            <td>Name</td>
                                            <td>
                                                <input type="text" name="name" id="name"  class="name form-control form-align" value="<?= $val['name'] ?>"  tabindex="1"/>
                                                <input type="hidden" name="id" class="id id_dup form-control" readonly="readonly" value="<?php echo $val['id']; ?>" />
                                                <span id="cuserror1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                            <td >User Name</td>
                                            <td>
                                                <input type="text" name="username" class=" form-control form-align" id="username" value="<?= $val['username'] ?>"  tabindex="1"/>
                                                <span id="username1" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                            <td>Password</td>
                                            <td>
                                                <input type="password" name="password" class="form-control form-align"  autocomplete="off"  tabindex="1"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>City</td>
                                            <td>
                                                <input type="text" name="city" id="city"  class="form-control form-align" value="<?= $val['city'] ?>"  tabindex="1"/>
                                                <span id="cuserror8" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                            <td>Account No</td>
                                            <td>
                                                <input type="text" name="acnum" class="form-control form-align" id="acnum" value="<?= $val['account_num'] ?>"  tabindex="1"/>
                                                <span id="cuserror11" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                            <td>Mobile Number</td>
                                            <td>
                                                <input type="text" name="number" class="mobile form-control form-align" id="number" value="<?= $val['mobil_number'] ?>"  tabindex="1"/>
                                                <span id="cuserror4" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>Pin Code</td>
                                            <td>
                                                <input type="text" name="pin" id="pincode"  class="form-control form-align" value="<?= $val['pincode'] ?>"  tabindex="1"/>
                                                <span id="cuserror9" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>

                                            <td>Bank Name</td>
                                            <td>
                                                <input type="text" name="bank" class="bank form-control form-align" id="bank" value="<?= $val['bank_name'] ?>"  tabindex="1"/>
                                                <span id="cuserror6" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                            <td>Email Id</td>
                                            <td>
                                                <input type="text" name="mail" class="mail up_mail_dup form-control form-align" id="mail" value="<?= $val['email_id'] ?>"  tabindex="1"/>
                                                <span id="cuserror5" class="val"  style="color:#F00; font-style:oblique;"></span>
        <!--                                                <span id="upduplica" class="val"  style="color:#F00; font-style:oblique;"></span>-->
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>IFSC Code </td>
                                            <td>
                                                <input type="text" name="ifsc" class="form-control form-align" id="" value="<?= $val['ifsc'] ?>"  tabindex="1"/>
                                            </td>

                                            <td>Bank Branch</td>
                                            <td>
                                                <input type="text" name="branch" class="form-control form-align" id="branch" value="<?= $val['bank_branch'] ?>"  tabindex="1"/>
                                                <span id="cuserror10" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                            <td >Role</td>
                                            <td>
                                                <select name="role" class="form-control form-align" id="role"  tabindex="1">
                                                    <option value="4">Field Agent</option>
                                                </select>
                                                <span id="cuserror6" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>

                                        </tr>
                                        <tr>
                                            <td>Agent Amount </td>
                                            <td>
                                                <input type="text" name="agent_amount" class="form-control form-align"  value="<?php echo $amount; ?>"  tabindex="1"/>
                                            </td>

                                            <td>Advance Amount</td>
                                            <td>
                                                <input type="text" name="company_amount" class="form-control form-align company_amount"  tabindex="1"/>
                                                <span id="err" class="val"  style="color:#F00; font-style:oblique;"></span>
                                                <input type="hidden" name="company" class="form-control form-align company" value="<?php echo $company_amount[0]['value']; ?>"/>
                                                <input type="hidden" name="rec_id" value="<?php echo$this->session->userdata['user_info'][0]['id']; ?>" class="rec_id"/>
                                            </td>
                                            <td><input type="button" value="pay" class="btn btn-success" id="pay" /></td>
                                        </tr>
                                        <tr>
                                            <td>Address1</td>
                                            <td>
                                                <textarea  name='address1' id="address" class="form-control form-align"  tabindex="1"><?= $val['address1'] ?></textarea>
                                                <span id="cuserror3" class="val"  style="color:#F00; font-style:oblique;"></span>
                                            </td>
                                            <td>Address2</td>
                                            <td>
                                                <textarea  name='address2' id="address" class="form-control form-align"  tabindex="1"><?= $val['address2'] ?></textarea>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </table>

                            <div class="frameset_table action-btn-align">
                                <table>
                                    <tr>
                                        <td width="570">&nbsp;</td>
                                        <td><input type="submit" value="Update" class="submit btn btn-info" id="edit"  tabindex="1"/></td>
                                        <td>&nbsp;</td>
                                        <td><input type="reset" value="Clear" class="submit btn btn-danger " id="reset"  tabindex="1"/></td>
                                        <td>&nbsp;</td>
                                        <td><a href="<?php echo $this->config->item('base_url') . 'agent/' ?>" class="btn btn-defaultback"  tabindex="1"><span class="glyphicon"></span> Back </a></td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $("#username").live('blur', function ()
            {

                var username = $("#username").val();
                if (username == "" || username == null || username.trim().length == 0)
                {
                    $("#username1").html("Required Field");
                } else
                {
                    $("#username1").html("");
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
            $("#mail").live('blur', function ()
            {
                var mail = $("#mail").val();
                var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                if (mail != "")
                {
                    if (!efilter.test(mail))
                    {
                        $("#cuserror5").html("Enter Valid Email");
                    } else
                    {
                        $("#cuserror5").html("");
                    }
                }
            });

            $("#number").live('blur', function ()
            {
                var number = $("#number").val();
                var nfilter = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
                if (number != "")
                {
                    if (!nfilter.test(number))
                    {
                        $("#cuserror4").html("Enter Valid Mobile Number");
                    } else
                    {
                        $("#cuserror4").html("");
                    }
                }
            });
            $('#reset').live('click', function ()
            {
                $('.val').html("");
            });
            $('input[name!="mail"], textarea').live('keyup', function () {

                this_val = $(this).val();
                value = this_val.toUpperCase();
                $(this).val(value);

            });
            /*$("#store").live('blur',function()
             {
             var store=$("#store").val();
             if(store=="" || store==null || store.trim().length==0)
             {
             $("#cuserror2").html("Required Field");
             }
             else
             {
             $("#cuserror2").html("");
             }
             });
             $('#address').live('blur',function()
             {
             var address=$('#address').val();
             if(address=="" || address==null || address.trim().length==0)
             {
             $('#cuserror3').html("Enter Address");
             }
             else
             {
             $('#cuserror3').html("");
             }
             });
             $("#mobile").live('blur',function()
             {
             var number=$("#mobile").val();
             var nfilter=/^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
             if(number=="")
             {
             $("#cuserror4").html("Required Field");
             }
             else if(!nfilter.test(number))
             {
             $("#cuserror4").html("Enter Valid Mobile Number");
             }
             else
             {
             $("#cuserror4").html("");
             }
             });
             $("#mail").live('blur',function()
             {
             var mail=$("#mail").val();
             var efilter=/^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
             if(mail=="")
             {
             $("#cuserror5").html("Required Field");
             }
             else if(!efilter.test(mail))
             {
             $("#cuserror5").html("Enter Valid Email");
             }
             else
             {
             $("#cuserror5").html("");
             }
             });
             $('#bank').live('blur',function()
             {
             var bank=$('#bank').val();
             if(bank=="" || bank==null || bank.trim().length==0)
             {
             $('#cuserror6').html("Enter Details");
             }
             else
             {
             $('#cuserror6').html("");
             }
             });
             $('#percent').live('blur',function()
             {
             var percentage=$('#percent').val();
             var pefilter=/^(100(\.0{1,2})?|[1-9]?\d(\.\d{1,2})?)$/;
             if(percentage=="" || percentage==null || percentage.trim().length==0)
             {
             $('#cuserror7').html("Required Field");
             }
             else if(!pefilter.test(percentage))
             {
             $("#cuserror7").html("Enter Valid Percentage");
             }
             else
             {
             $('#cuserror7').html("");
             }
             });
             $('#city').live('blur',function()
             {
             var city=$('#city').val();
             if(city=="")
             {
             $('#cuserror8').html("Required Field");
             }
             else
             {
             $('#cuserror8').html("");
             }
             });
             $("#pincode").live('blur',function()
             {
             var pincode=$("#pincode").val();
             if(pincode=="")
             {
             $("#cuserror9").html("Required Field");
             }
             else if (pincode.length!=6)
             {
             $("#cuserror9").html("Maximum 6 characters");
             }
             else
             {
             $("#cuserror9").html("");
             }
             });
             $("#branch").live('blur',function()
             {
             var branch=$("#branch").val();
             if(branch=="" || branch==null || branch.trim().length==0)
             {
             $("#cuserror10").html("Required Field");
             }
             else
             {
             $("#cuserror10").html("");
             }
             });
             $("#acnum").live('blur',function()
             {
             var acnum=$("#acnum").val();
             var acfilter=/^[a-zA-Z0-9]+$/;
             if(acnum=="")
             {
             $("#cuserror11").html("Required Field");
             }
             else if(!acfilter.test(acnum))
             {
             $("#cuserror11").html("Numeric or Alphanumeric");
             }
             else
             {
             $("#cuserror11").html("");
             }
             }); */
        </script>
        <script type="text/javascript">
            $('#pay').live('click', function ()
            {
                var i = 0;
                var company_amount = $('.company_amount').val();
                var rec_id = $('.rec_id').val();
                var company = $('.company').val();
                if (Number(company_amount) > Number(company))
                {
                    $("#err").html("This Field less then the company amount");
                    i = 1;
                } else
                {
                    $("#err").html("");
                }
                if (i == 1)
                {
                    return false;
                } else
                {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo $this->config->item('base_url'); ?>" + "agent/pay/" + "<?php echo $agent[0]['id']; ?>",
                        data: {
                            company_amount: company_amount,
                            rec_id: rec_id},
                        success: function (data) {
                            location.reload();
                        }
                    });

                }


            });

            $('#edit').live('click', function ()
            {
                var i = 0;
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

                /* var address = $('#address').val();
                 if (address == "" || address == null || address.trim().length == 0)
                 {
                 $('#cuserror3').html("Enter Address");
                 i = 1;
                 } else
                 {
                 $('#cuserror3').html("");
                 }
                 var number = $("#mobile").val();
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
                 $('#cuserror6').html("Enter Details");
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
                 var pincode = $("#pincode").val();
                 if (pincode == "")
                 {
                 $("#cuserror9").html("Required Field");
                 i = 1;
                 } else if (pincode.length != 6)
                 {
                 $("#cuserror9").html("Maximum 6 characters");
                 i = 1;
                 } else
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
                 }*/

                var username = $("#username").val();
                if (username == "" || username == null || username.trim().length == 0)
                {
                    $("#username1").html("Required Field");
                    i = 1;
                } else
                {
                    $("#username1").html("");
                }

                var mail = $("#mail").val();
                var efilter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                if (mail != "")
                {
                    if (!efilter.test(mail))
                    {
                        $("#cuserror5").html("Enter Valid Email");
                        i = 1;
                    } else
                    {
                        $("#cuserror5").html("");
                    }
                }
                var number = $("#number").val();
                var nfilter = /^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$/;
                if (number != "")
                {

                    if (!nfilter.test(number))
                    {
                        $("#cuserror4").html("Enter Valid Mobile Number");
                        i = 1;
                    } else
                    {
                        $("#cuserror4").html("");
                    }
                }

                /* var password=$("#password").val();
                 if(password=="" || password==null || password.trim().length==0)
                 {
                 $("#password1").html("Required Field");
                 i=1;
                 }
                 else
                 {
                 $("#password1").html("");
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
                 }*/
                /* var mess = $("#upduplica").html();
                 if ((mess.trim()).length > 0)
                 {
                 i = 1;
                 }*/
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
            /* $("#mail").live('blur', function ()
             {
             mail = $("#mail").val();
             id = $('.id').val();
             $.ajax(
             {
             url: BASE_URL + "agent/update_duplicate_email",
             type: 'POST',
             data: {value1: mail, value2: id},
             success: function (result)
             {
             $("#upduplica").html(result);
             }
             });
             });*/
        </script>
