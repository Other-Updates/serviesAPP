<!DOCTYPE html>
<html lang="en">


    <!-- Mirrored from html.phoenixcoded.net/mega-able/default/auth-normal-sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 01 Oct 2019 03:56:10 GMT -->
    <head>
        <?php $theme_path = $this->config->item('theme_locations') . $this->config->item('active_template'); ?>
        <title><?= $this->config->item('site_title'); ?> | <?= $this->config->item('site_powered'); ?></title>
        <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 10]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
          <![endif]-->
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="Gradient Able Bootstrap admin template made using Bootstrap 4 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
        <meta name="keywords" content="bootstrap, bootstrap admin template, admin theme, admin dashboard, dashboard template, admin template, responsive" />
        <meta name="author" content="Phoenixcoded" />
        <!-- Favicon icon -->

        <link rel="icon" href="<?= $theme_path; ?>/assets/images/favicon.png" type="image/x-icon">
        <!-- Google font-->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
        <!-- Required Fremwork -->
        <link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/bower_components/bootstrap/css/bootstrap.min.css">
        <!-- waves.css -->
        <link rel="stylesheet" href="<?= $theme_path; ?>/assets/pages/waves/css/waves.min.css" type="text/css" media="all">
        <!-- themify-icons line icon -->
        <link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/assets/icon/themify-icons/themify-icons.css">
        <!-- ico font -->
        <link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/assets/icon/icofont/css/icofont.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/assets/icon/font-awesome/css/font-awesome.min.css">
        <!-- Style.css -->
        <link rel="stylesheet" type="text/css" href="<?= $theme_path; ?>/assets/css/style.css">
		<style>
		hr {
		margin-top: 0rem;}
		 .newClass {
        top: -13px !important;
        font-size: 11px !important;
    }
	.newClass {
                top: -12px !important;
                font-size: 11px !important;
                font-weight:600 !important;
            }
    
	.login-block{margin-top:0px;}
		</style>
    </head>

    <body themebg-pattern="theme1">
	<div class="">
	
        <!-- Pre-loader start -->
        <div class="theme-loader">
            <div class="loader-track">
                <div class="preloader-wrapper">
                    <div class="spinner-layer spinner-blue">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                    <div class="spinner-layer spinner-red">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>

                    <div class="spinner-layer spinner-yellow">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>

                    <div class="spinner-layer spinner-green">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
        <!-- Pre-loader end -->

        <section class="login-block login-bg-image">
			<div class="innerlogin-image">
			</div>
            <!-- Container-fluid starts -->
            <div class="container">
                <?php echo $content; ?>
                <!-- end of row -->
            </div>
			
            <!-- end of container-fluid -->
        </section>
		</div>
        <!-- Warning Section Starts -->
        <!-- Older IE warning message -->
        <!-- Warning Section Ends -->
        <!-- Required Jquery -->
        <script type="text/javascript" src="<?= $theme_path; ?>/bower_components/jquery/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?= $theme_path; ?>/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?= $theme_path; ?>/bower_components/popper.js/js/popper.min.js"></script>
        <script type="text/javascript" src="<?= $theme_path; ?>/bower_components/bootstrap/js/bootstrap.min.js"></script>
        <!-- waves js -->
        <script src="<?= $theme_path; ?>/assets/pages/waves/js/waves.min.js"></script>
        <!-- jquery slimscroll js -->
        <script type="text/javascript" src="<?= $theme_path; ?>/bower_components/jquery-slimscroll/js/jquery.slimscroll.js"></script>
        <!-- modernizr js -->
        <script type="text/javascript" src="<?= $theme_path; ?>/bower_components/modernizr/js/modernizr.js"></script>
        <script type="text/javascript" src="<?= $theme_path; ?>/bower_components/modernizr/js/css-scrollbars.js"></script>
        <!-- i18next.min.js -->
        <script type="text/javascript" src="<?= $theme_path; ?>/bower_components/i18next/js/i18next.min.js"></script>
        <script type="text/javascript" src="<?= $theme_path; ?>/bower_components/i18next-xhr-backend/js/i18nextXHRBackend.min.js"></script>
        <script type="text/javascript" src="<?= $theme_path; ?>/bower_components/i18next-browser-languagedetector/js/i18nextBrowserLanguageDetector.min.js"></script>
        <script type="text/javascript" src="<?= $theme_path; ?>/bower_components/jquery-i18next/js/jquery-i18next.min.js"></script>
        <script type="text/javascript" src="<?= $theme_path; ?>/assets/js/common-pages.js"></script>
		
    </body>


    <!-- Mirrored from html.phoenixcoded.net/mega-able/default/auth-normal-sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 01 Oct 2019 03:56:10 GMT -->
</html>
