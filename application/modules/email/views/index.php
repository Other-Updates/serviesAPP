<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<script src="<?= $theme_path; ?>/assets/js/jquery-1.8.2.js" type="text/javascript"></script>
<script src="<?= $theme_path; ?>/assets/js/jquery-ui-1.10.3.min.js"></script>
<style>
    .form-control{margin-bottom:6px;}
    form{border: 1px solid #dfdfdf;
         padding: 20px;
    }
    .form-material .float-label {
        pointer-events: none;
        position: absolute;
        top: -9px;
        left: 0;
        font-size: 11px;
        font-weight: 400;
        transition: 0.2s ease all;
        -moz-transition: 0.2s ease all;
        -webkit-transition: 0.2s ease all;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="card ">
            <div class="card-header">
                <h5 class="card-header-text">Email Settings</h5>
            </div>
            <div class="card-block">
                <div role="tabpanel" class="tab-pane active" id="email">
                    <form class="form-material" action="<?php echo $this->config->item('base_url'); ?>email/insert_email" enctype="multipart/form-data" name="form" method="post" ><br />
                        <div class="form-material row">
                            <?php
                            if (isset($emails) && !empty($emails)) {
                                foreach ($emails as $val) {
                                    ?>



                                    <div class="col-md-4">
                                        <div class="material-group">
                                            <div class="material-addone">
                                                <i class="icofont icofont-email"></i>
                                            </div>
                                            <div class="form-group form-primary">
                                                <label class="float-label"><?php echo $val['label'] ?></label>

                                                <input type="hidden" name="type[]" value="<?php echo $val['type'] ?>" />
                                                <input type="hidden" name="label[]" value="<?php echo $val['label'] ?>" />
                                                <input type="text" name="value[]" class="form-control form-align value <?php echo $val['type']; ?>" value="<?php echo $val['value'] ?>" id="name" tabindex="1"/>
                                                <span id="cuserror1" class="val text-danger"></span>
                                                <span class="form-bar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>


                                    <?php
                                }
                            }
                            ?>
                        </div>
                        <div class="form-group row text-center mt-20">
                            <div class="col-md-12 text-center">
                                <input type="submit" name="submit" class="btn btn-primary btn-print-invoice m-b-10 btn-sm waves-effect waves-light" value="Save" id="submit" tabindex="1"/>

                                <a href="<?php echo $this->config->item('base_url'); ?>" class="btn btn-inverse btn-sm waves-effect waves-light m-b-10"><span class="glyphicon"></span> Back </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div><br />
        </div>

        <script type="text/javascript">
            $(document).on('click', '.alerts', function () {
                sweetAlert("Oops...", "This Access is blocked!", "error");
                return false;
            });
            $(document).ready(function ()
            {
                //            var val = $('.company_amount').val();
                //            if (val == "" || val == 0)
                //            {
                //                $('.company_amount').removeAttr('readonly');
                //            } else {
                //                $('.company_amount').attr('readonly', true);
                //            }

            });
            $('#submit').live('click', function ()
            {
                var i = 0;
                var name = $(".value").val();
                if (name == "" || name == null || name.trim().length == 0)
                {
                    $(".cuserror1").html("Required Field");
                    i = 1;
                } else
                {
                    $(".cuserror1").html("");
                }
                if (i == 1)
                {
                    return false;
                } else
                {
                    return true;
                }
            });

            $('.q_sender, .q_subject, .inv_sender, .inv_subject').live('keyup', function () {

                this_val = $(this).val();
                value = this_val.toUpperCase();
                $(this).val(value);

            });

        </script>

        <?php
        if (isset($agent) && !empty($agent)) {
            foreach ($agent as $val) {
                ?>
                <div id="test3_<?php echo $val['id']; ?>" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false" align="center">
                    <div class="modal-dialog">
                        <div class="modal-content modalcontent-top">
                            <div class="modal-header modal-padding modalcolor">
                                <h3 id="myModalLabel" style="color:#06F;margin-top:10px">In-Active agent</h3>
                                <a class="close modal-close closecolor" data-dismiss="modal">×</a>
                            </div>
                            <div class="modal-body">
                                Do You Want In-Active This agent?<strong><?= $val['name']; ?></strong>
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
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function ()
    {
        $("#yesin").on("click", function ()
        {

            var hidin = $(this).parent().parent().find('.id').val();

            $.ajax({
                url: BASE_URL + "agent/delete_agent",
                type: 'POST',
                data: {value1: hidin},
                success: function (result) {

                    window.location.reload(BASE_URL + "agent/");
                }
            });

        });

        $('.modal').css("display", "none");
        $('.fade').css("display", "none");

    });
</script>