<!DOCTYPE html>
<html lang="en" ng-app="KidyViewSchool">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Creative - Bootstrap 3 Responsive Admin Template">
        <meta name="author" content="GeeksLabs">
        <link rel="shortcut icon" href="<?php echo base_url(); ?>img/fav.png">
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700,900' rel='stylesheet' type='text/css'>
        <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
        <script src = "<?php echo base_url(); ?>asset/angular-1.6.9/angular.min.js"></script>
        <script src = "<?php echo base_url(); ?>asset/angular-1.6.9/angular-route.min.js"></script>
        <script src = "<?php echo base_url(); ?>asset/angular-1.6.9/angular-animate.min.js"></script>
        <script src = "<?php echo base_url(); ?>asset/angular-1.6.9/angular-loader.min.js"></script>
        <script src="<?php echo base_url(); ?>asset/angular-1.6.9/angular-sanitize.js"></script>
        <script src="<?php echo base_url(); ?>asset/js/dirPagination.js"></script>
        <script src="<?php echo base_url(); ?>asset/js/customDirPagination.js"></script>
        <script src="<?php echo base_url(); ?>asset/js/ng-file-upload-all.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
        <link href="<?php echo base_url(); ?>asset/js/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>asset/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
        <script src="<?php echo base_url(); ?>asset/js/appSchool.js"></script>
        <script src="<?php echo base_url(); ?>asset/js/controllersSchool.js"></script>
        
        <script src="<?php echo base_url(); ?>assets/mdate/dist/moment-with-locales.js"></script>
        <script src="<?php echo base_url(); ?>assets/mdate/dist/angular-moment-picker.min.js"></script>

        <title>Welcome to Kidy View School</title>
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fonts/icomoon/icomoon.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/morris/morris.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/all.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.fancybox.css" />
        <!-- Chartist css -->
        <link href="<?php echo base_url(); ?>assets/css/chartist/chartist.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>assets/css/chartist/chartist-custom.css" rel="stylesheet" />
        <!-- database css -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datatables/dataTables.bs4.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datatables/dataTables.bs4-custom.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/mdate/dist/angular-moment-picker.min.css" />
        <!-- global css -->
        <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/global.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/intlTelInput.css" />
        <script src="<?php echo base_url(); ?>adminasset/js/ngdatatable/angular-datatables.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>adminasset/js/ngdatatable/css/angular-datatables.css">
        <script src="<?php echo base_url(); ?>asset/uiselect/dist/select.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/uiselect/dist/select.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.4.5/select2.css">    
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/css/selectize.default.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/bootstrap-main.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/bootstrap-main.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/core-main.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/core-main.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/daygrid-main.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/daygrid-main.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/list-main.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/list-main.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/timegrid-main.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/js/ui-calendar/css/timegrid-main.min.css">
       </head>
    <body>

        <?php
        $schoolDetail = $this->session->all_userdata();
        if($this->session->userdata('user_role')=='school'){
            $schoolID 		= $schoolDetail['user_data']['school_id'];
            $schoolAdminID 	= $schoolDetail['user_data']['id'];
        }elseif($this->session->userdata('user_role')=='schoolsubadmin'){
            $schoolID = $schoolDetail['user_data']['school_id'];
        }
        $schoolPhoto = $schoolDetail['user_data']['pic'];
        $schoolName = $schoolDetail['user_data']['school_name'];
        $schoolEmail = $schoolDetail['user_data']['email'];
        ?>
        <script>
                            var BASE_URL 		= '<?php echo base_url(); ?>';
                            var School_ID 		= '<?php echo $schoolID; ?>';
                            <?php if($this->session->userdata('user_role')=='school'){ ?>
							var SchoolAdmin_ID 	= 'SA-<?php echo $schoolAdminID; ?>';
							<?php }	
							?>
							var xapikey 		= 'AOmAfXgEOBiziaIZfynXNuUnnNvWnjjcoP1Qpd8S';
                            var jsonPrivilege 	= '<?php echo json_encode($JSONPRIVILEGE,true); ?>';
        </script>
        <!-- container section start -->

        <!-- start app wrap -->
        <div class="app-wrap">
            <!-- stard app header -->
            <header class="app-header">
                <div class="container-fluid">
                    <div class="row gutters">
                        <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-2">
                            <a class="mini-nav-btn" href="#" id="app-side-mini-toggler">
                                <span class="brandlogo"><img src="<?php echo base_url(); ?>assets/img/logo.png" alt="Airo.Life" /></span>
                                <i class="icon-menu5"></i>
                            </a>
                            <a href="#app-side" data-toggle="onoffcanvas" class="onoffcanvas-toggler" aria-expanded="true">
                                <i class="icon-chevron-thin-right"></i>
                            </a>
                        </div>
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-10 text-right	">
                            <ul class="header-actions">

                                <li class="dropdown">
                                    <a href="#" id="notifications" data-toggle="dropdown" aria-haspopup="true">
                                        <i class="icon-notifications_none"></i>
                                        <span class="count-label">3</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right lg" aria-labelledby="notifications">
                                        <ul class="imp-notify">
                                            <li>
                                                <a href="javascript:void(0);">
                                                    <div class="icon">W</div>
                                                    <div class="details">
                                                        <p><span>Wilson</span> The best Dashboard design I have seen ever.</p>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);">
                                                    <div class="icon">J</div>
                                                    <div class="details">
                                                        <p><span>John Smith</span> Jhonny sent you a message. Read now!</p>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0);">
                                                    <div class="icon secondary">R</div>
                                                    <div class="details">
                                                        <p><span>Justin Mezzell</span> Stella, Added you as a Friend. Accept it!</p>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="text-center">
                                                <a class="see-all-link" href="javascript:void(0);">See All</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="dropdown">
                                    <a href="javascript:void(0);" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                                        <?php 
                                       // echo $this->session->userdata('user_role');die;
                                        if($this->session->userdata('user_role')=='school'){?>
                                        <img class="avatar profileImageHeader" src="<?php echo base_url(); ?>img/school/<?php echo $schoolPhoto; ?>" alt="User Thumb" />
                                        <?php }elseif($this->session->userdata('user_role')=='schoolsubadmin'){ ?>
                                        <img class="avatar profileImageHeader" src="<?php echo base_url(); ?>img/school/subadmin/<?php echo $schoolPhoto; ?>" alt="User Thumb" />
                                        <?php } ?>
                                        <span class="user-name username"><?php echo $schoolName; ?></span>
                                        <i class="icon-chevron-small-down"></i>
                                    </a>
                                    <div class="dropdown-menu lg dropdown-menu-right" aria-labelledby="userSettings">
                                        <ul class="user-settings-list">
                                        <li>
                                        <?php if($this->session->userdata('user_role')=='school'){?>
                                                <a href="#!/school-profile">
                                                    <div class="icon">
                                                        <i class="icon-account_circle"></i>
                                                    </div>
                                                    <p>Profile</p>
                                                </a>
                                        <?php }elseif($this->session->userdata('user_role')=='schoolsubadmin'){?>
                                                <a href="#!/subadmin-profile">
                                                    <div class="icon">
                                                        <i class="icon-account_circle"></i>
                                                    </div>
                                                    <p>Profile</p>
                                                </a>
                                        <?php } ?>
                                            </li>
                                            <li>
                                                <a href="<?php echo base_url(); ?>schoollogin">
                                                    <div class="icon">
                                                        <i class="icon-log-out"></i>
                                                    </div>
                                                    <p>Logout</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </header>

            <!-- start app container -->
            <div class="app-container">
                <!-- start sidebar -->
                <aside class="app-side" id="app-side">
                <?php if($this->session->userdata('user_role')=='school'){
                   $this->load->view('school-left-menu.php');
                }elseif($this->session->userdata('user_role')=='schoolsubadmin'){
                    $this->load->view('subadmin-left-menu.php');
                }?>
                    <!-- END: .side-content -->
                </aside>
                <!-- END: .app-side -->

                <!-- BEGIN .app-main -->
                <div style="width:100%" ng-view ng-animate="{enter: 'view-enter'}"></div>

                <!-- END: .app-container -->
                <!-- BEGIN .main-footer -->
                <footer class="main-footer fixed-btm">
                    Copyright kidyview.admin 2019.
                </footer>
                <!-- END: .main-footer -->
            </div>
            <!-- END: .app-wrap -->

            <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwBRVfP3aoCIZ77fhT1Gj8ntbKoL01qPE&libraries=places"></script>
            <script src="<?php echo base_url(); ?>assets/js/tether.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/unifyMenu.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/onoffcanvas.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/moment.js"></script>
            <!-- Morris Graphs -->
            <script src="<?php echo base_url(); ?>assets/js/morris/raphael-min.js"></script>
            <!-- Data Tables -->
            <script src="<?php echo base_url(); ?>assets/js/datatables/dataTables.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/datatables/dataTables.bootstrap.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/datatables/custom-datatables.js"></script>
            <!-- Flot Charts -->
            <script src="<?php echo base_url(); ?>assets/js/flot/jquery.flot.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/flot/jquery.flot.time.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/flot/jquery.flot.pie.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/flot/jquery.flot.stack.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/flot/jquery.flot.tooltip.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/flot/jquery.flot.resize.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/flot/line.js"></script>
            <!-- Newsticker JS -->
            <script src="<?php echo base_url(); ?>assets/js/newsticker/newsTicker.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/newsticker/custom-newsTicker.js"></script>
            <!-- Form Wizard -->
            <script src="<?php echo base_url(); ?>assets/js/formwizard/jquery.bootstrap.wizard.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/form-validation.js"></script>
            <!-- Multiple Select -->
            <script src="<?php echo base_url(); ?>assets/js/multiselect/select2.min.js" type="text/javascript"></script>
            <!-- Data Tables -->
            <script src="<?php echo base_url(); ?>assets/js/slimscroll/slimscroll.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/slimscroll/custom-scrollbar.js"></script>
            <!-- Common JS -->
            <script src="<?php echo base_url(); ?>asset/js/gritter/js/jquery.gritter.js" type="text/javascript"></script>
            <script src="<?php echo base_url(); ?>assets/js/common.js"></script>
            <script src="<?php echo base_url(); ?>asset/js/intlTelInput.min.js"></script>
            <script src="<?php echo base_url(); ?>asset/js/utils.js"></script>
            <script src="<?php echo base_url(); ?>asset/js/ng-intl-tel-input.js"></script>
            <script src="<?php echo base_url(); ?>asset/js/ng-pattern-restrict.min.js"></script>
            <script src="<?php echo base_url(); ?>assets/js/jquery.fancybox.js"></script>
            <script src="<?php echo base_url(); ?>asset/js/ui-calendar/calendar.js"></script>
            <script src="<?php echo base_url(); ?>asset/js/ui-calendar/fullcalendar.min.js"></script>
    </body>
</html>												