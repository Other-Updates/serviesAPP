<?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
<style>
    .form-group {
        margin-bottom: 1.25em;
    }
    .card .card-block {
        padding: 20px;
    }
    .login-copyrights{
        text-align:center;
    }
    .alert{
        margin-bottom:0.7rem;
    }
    .icofont{
        color:red;
    }
    .login-block .auth-box {
        margin: 98px auto 0 auto;
        max-width: 425px;
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <!-- Authentication card start -->
        <form class="md-float-material form-material" method="post" >

            <div class="auth-box card">
                <div class="text-center m-t-5">
                    <img src="<?= $theme_path; ?>/assets/images/f2f-logo.png" alt="logo.png" style="width:200px;">
                </div>
                <div class="card-block">
                    <?php
                    if (isset($_GET['login']) && !empty($_GET['login'])) {
                        ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <i class="icofont icofont-close-line-circled"></i>
                            </button>
                            <strong>Sorry!</strong> Incorrect Login Credentials !
                        </div>
                    <?php } ?>

                    <div class="row m-b-20">
                        <div class="col-md-12">
                            <h3 class="text-center">Sign In</h3>
                        </div>
                    </div>
                    <div class="form-group form-primary">
                        <input type="text" class="form-control" autocomplete="off" name="username" required="">
                        <span class="form-bar"></span>
                        <label class="float-label newClass">Username</label>
                    </div>
                    <div class="form-group form-primary">
                        <input type="password" class="form-control" autocomplete="off" name="password" required="">
                        <span class="form-bar"></span>
                        <label class="float-label newClass">Password</label>
                    </div>
                    <div class="row m-t-30">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Sign in</button>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12 login-copyrights">
                            <div><p class="text-inverse text-center">Copyright &COPY; <b style='color:#448aff'>Incredible Solutions</b></div> <div>Powered By <b><a href="http://f2fsolutions.co.in/" target="_blank">F2F Solutions</a></b></div></p>
                        </div>
                        <!--<div class="col-md-2">
                            <img src="<?= $theme_path; ?>/assets/images/favicon.png" alt="small-logo.png" style="width: 100%">
                        </div>-->
                    </div>
                </div>
            </div>
        </form>
        <!-- end of form -->
    </div>
    <!-- end of col-sm-12 -->
</div>