<!DOCTYPE html>
<html lang="en" ng-app="KidyViewAdmin">
	
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content=" " />
		<meta name="keywords" content=" " />
		<meta name="author" content=" " />
		<link rel="shortcut icon" href="<?php echo base_url(); ?>img/fav.png">
		<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
		<script src = "<?php echo base_url(); ?>asset/angular-1.6.9/angular.min.js"></script>
		<script src = "<?php echo base_url(); ?>asset/angular-1.6.9/angular-route.min.js"></script>
		<script src = "<?php echo base_url(); ?>asset/angular-1.6.9/angular-animate.min.js"></script>
		<script src = "<?php echo base_url(); ?>asset/angular-1.6.9/angular-loader.min.js"></script>
		<script src="<?php echo base_url(); ?>asset/angular-1.6.9/angular-sanitize.js"></script>		
		<link href="<?php echo base_url(); ?>asset/js/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
		<script src="<?php echo base_url(); ?>asset/js/dirPagination.js"></script>
        <script src="<?php echo base_url(); ?>asset/js/customDirPagination.js"></script>
        <script src="<?php echo base_url(); ?>asset/js/ng-file-upload-all.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
        <link href="<?php echo base_url(); ?>asset/js/gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css"/>
        <link href="<?php echo base_url(); ?>asset/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
		<script src="<?php echo base_url(); ?>asset/js/appAdmin.js"></script>
		<script src="<?php echo base_url(); ?>asset/js/controllersAdmin.js"></script>
		
		<script src="<?php echo base_url(); ?>assets/mdate/dist/moment-with-locales.js"></script>
        <script src="<?php echo base_url(); ?>assets/mdate/dist/angular-moment-picker.min.js"></script>
		
		<title>Welcom to Kidy View Admin</title>
		
		<!--link href="<?php echo base_url();?>asset/css/style.css" rel="stylesheet"-->
		<!-- Common CSS -->
		<link rel="stylesheet" href="<?php echo base_url(); ?>adminasset/css/bootstrap.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>adminasset/fonts/icomoon/icomoon.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>adminasset/css/morris/morris.css" />
		<!-- Chartist css -->
		<link href="<?php echo base_url();?>adminasset/css/chartist/chartist.min.css" rel="stylesheet" />
		<link href="<?php echo base_url();?>adminasset/css/chartist/chartist-custom.css" rel="stylesheet" />
		<!-- database css -->
		<link rel="stylesheet" href="<?php echo base_url();?>adminasset/css/datatables/dataTables.bs4.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>adminasset/css/datatables/dataTables.bs4-custom.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/all.css" />
		<!-- global css -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>adminasset/css/all.css" />
		
		<link rel="stylesheet" href="<?php echo base_url();?>adminasset/css/global.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/global.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/intlTelInput.css" />
        <script src="<?php echo base_url(); ?>adminasset/js/ngdatatable/angular-datatables.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>adminasset/js/ngdatatable/css/angular-datatables.css">
        <script src="<?php echo base_url(); ?>asset/uiselect/dist/select.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/uiselect/dist/select.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.4.5/select2.css">    
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/css/selectize.default.css">
	</head>
	<body>
		
		<?php 
			$adminDetail 	= $this->session->userdata();
			$adminName 		= $adminDetail['user_data']['full_Name'];
			$adminPhoto 	= $adminDetail['user_data']['photo'];
			
		?>
		<script>
			var BASE_URL = '<?php echo base_url(); ?>';
			var xapikey = 'AOmAfXgEOBiziaIZfynXNuUnnNvWnjjcoP1Qpd8S';
		</script>
		
		<!-- start app wrap -->
		<div class="app-wrap">
			<!-- stard app header -->
			<header class="app-header">
				<div class="container-fluid">
					<div class="row gutters">
						<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 col-12">
							<a class="mini-nav-btn" href="javascript:void0;" id="app-side-mini-toggler">
							<span class="brandlogo"><img src="<?php echo base_url();?>img/small_logo.png" alt="Airo.Life" /></span>
							<i class="icon-menu5"></i>
							</a>
							<a href="#app-side" data-toggle="onoffcanvas" class="onoffcanvas-toggler" aria-expanded="true">
							<i class="icon-chevron-thin-right"></i>
							</a>
							<span class="header-links">
							</span>
						</div>
						<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12 col-12	">
							<ul class="header-actions">
								
								<li class="dropdown">
									<a href="javascript:void0;" id="notifications" data-toggle="dropdown" aria-haspopup="true">
									<i class="icon-notifications_none"></i>
									<span class="count-label">3</span>
									</a>
									<div class="dropdown-menu dropdown-menu-right lg" aria-labelledby="notifications">
										<ul class="imp-notify">
											<li>
												<div class="icon">W</div>
												<div class="details">
													<p><span>Wilson</span> The best Dashboard design I have seen ever.</p>
												</div>
											</li>
											<li>
												<div class="icon">J</div>
												<div class="details">
													<p><span>John Smith</span> Jhonny sent you a message. Read now!</p>
												</div>
											</li>
											<li>
												<div class="icon secondary">R</div>
												<div class="details">
													<p><span>Justin Mezzell</span> Stella, Added you as a Friend. Accept it!</p>
												</div>
											</li>
											<li class="text-center"><a href="javascript:void(0)" class="see-all-link" href="">See All</a></li>
										</ul>
									</div>
								</li>
								
								<li class="dropdown">
									
									<a href="javascript:void0;" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
									<?php if($this->session->userdata('user_role')=='admin'){?>
									<img class="avatar profileImageHeader" src="<?php echo base_url(); ?>img/admin/<?php echo $adminPhoto; ?>" alt="User Thumb" />
									<?php }elseif($this->session->userdata('user_role')=='adminsubadmin'){ ?>
									<img class="avatar profileImageHeader" src="<?php echo base_url(); ?>img/school/subadmin/<?php echo $adminPhoto; ?>" alt="User Thumb" />
									<?php } ?>
									<span class="user-name username"><?php echo $adminName; ?></span>
									<i class="icon-chevron-small-down"></i>
									</a>
									<div class="dropdown-menu lg dropdown-menu-right" aria-labelledby="userSettings">
										<ul class="user-settings-list">
											<li>
											<?php if($this->session->userdata('user_role')=='admin'){ ?>
												<a href="#!/admin-profile">
												<div class="icon">
													<i class="icon-account_circle"></i>
												</div>
												<p>Profile</p>
												</a>
											<?php }else{ ?>
												<a href="javascript:void(0);">
												<div class="icon">
													<i class="icon-account_circle"></i>
												</div>
												<p>Profile</p>
												</a>
											<?php } ?>
											</li>
											<li>
												<a href="<?= base_url(); ?>administrator"">
                                                <div class="icon">
												<i class="icon-log-out"></i>
											</div>
											<p>Logout</p>
											</a>
										</li>
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
					<div class="side-content ">
						<!-- user profile -->
						<div class="user-profile">
						<?php if($this->session->userdata('user_role')=='admin'){?>
						<img src="<?php echo base_url(); ?>img/admin/<?php echo $adminPhoto; ?>" class="profile-thumb profileImageHeader" alt="User Thumb" />
						<?php }elseif($this->session->userdata('user_role')=='adminsubadmin'){ ?>
						<img src="<?php echo base_url(); ?>img/school/subadmin/<?php echo $adminPhoto; ?>" class="profile-thumb profileImageHeader" alt="User Thumb" />
						<?php } ?>
							<h6 class="profile-name username"><?php echo $adminName; ?></h6>
							<div class="dept-position">
							<?php if($this->session->userdata('user_role')=='admin'){
								echo "Admin";
							}else{
								echo "Sub Admin";
							}
							?>
							</div>
							<ul class="profile-actions">
								<li class=" ">
									<a href="javascript:void0;">
									<i class="icon-notifications_none"></i>
									</a>
								</li>
								<li class="">
									<a href="javascript:void0;">
									<i class="icon-person_outline"></i>
									</a>
								</li>
								<li>
									<a href="javascript:void0;">
									<i class="icon-log-out"></i>
									</a>
								</li>
							</ul>
						</div>
						<!-- sidebar navigation -->
						<nav class="side-nav">
							<ul class="unifyMenu customScroll" id="unifyMenu">
								<li class="active selected">
									<a href="#!/dashboard" aria-expanded="false">
									<span class="has-icon">
										<i class="icon-laptop_windows"></i>
									</span>
									<span class="nav-title">Dashboard</span>
									</a>
								</li>
								
								<li>
									<a class="has-arrow" aria-expanded="false" href="JavaScript:Void(0);">
									
									<span class="has-icon">
										<i class="icon-briefcase"></i>
									</span>
									<span class="nav-title">User Management</span>
									</a>
									<ul aria-expanded="false" class="collapse">
										
										<li>
											<a href="#!/school-list" aria-expanded="false">
											School Management
											</a>
											
										</li>
										<li>
											<a href="javascript:void(0)" aria-expanded="false">
											Parent Listings
											</a>
										</li>
										<li>
											<a href="javascript:void(0)" aria-expanded="false">
											Student Listing
											</a>
										</li>
										<li>
											<a href="javascript:void(0)" aria-expanded="false">
											Driver & Device Management
											</a>
										</li>
										<li><a href="#!subadmin-list">Super Sub Admin</a></li>
									</ul>
									
								</li>
								<li>
									<a class="has-arrow" aria-expanded="false" href="JavaScript:Void(0);">
									
									<span class="has-icon">
										<i class="icon-briefcase"></i>
									</span>
									<span class="nav-title">Role Management</span>
									</a>
									<ul aria-expanded="false" class="collapse">
										<li>
											<a href="#!/role-list" aria-expanded="false">
											Role
											</a>
										</li>
										<li>
											<a href="#!/privilege-list" aria-expanded="false">
											Privilege
											</a>
										</li>
									</ul>
									
								</li>
								
								<li>
									<a href="javascript:void(0)" aria-expanded="false">
									<span class="has-icon">
										<i class="icon-subscriptions"></i>
									</span>
									<span class="nav-title">Subscription Management</span>
									</a>
								</li>
								<li>
									<a href="#!/goal-list" aria-expanded="false">
									<span class="has-icon">
										<i class="fas fa-bullseye"></i>
									</span>
									<span class="nav-title">Goals Management</span>
									</a>
								</li>
								
								<li>
									<a href="#!/gift-list" aria-expanded="false">
									<span class="has-icon">
										<i class="fas fa-gift"></i>
									</span>
									<span class="nav-title">Gift Management</span>
									</a>
								</li>
								<li">
									<a href="javascript:void(0)" aria-expanded="false">
									<span class="has-icon">
										<i class="fas fa-gift"></i>
									</span>
									<span class="nav-title">Coupon Management</span>
									</a>
								</li>
								
								<li>
									<a href="javascript:void(0)" aria-expanded="false">
									<span class="has-icon">
										<i class="icon-payment"></i>
									</span>
									<span class="nav-title">Payment</span>
									</a>
								</li>
								
								<li>
									<a href="javascript:void(0)" aria-expanded="false">
									<span class="has-icon">
										<i class="icon-perm_data_setting"></i>
									</span>
									<span class="nav-title">Customisation </span>
									</a>
								</li>
								<li>
									<a href="javascript:void(0)" aria-expanded="false">
									<span class="has-icon">
										<i class="icon-book2"></i>
									</span>
									<span class="nav-title">Report Generation</span>
									</a>
								</li>
								<li>
									<a href="javascript:void(0)" aria-expanded="false">
									<span class="has-icon">
										<i class="icon-settings_applications"></i>
									</span>
									<span class="nav-title">CMS</span>
									</a>
								</li>
								<li>
									<a href="javascript:void(0)" aria-expanded="false">
									<span class="has-icon">
										<i class="icon-drag_handle"></i>
									</span>
									<span class="nav-title">Feedback</span>
									</a>
								</li>
								<li>
									<a href="javascript:void(0)">
									<span class="has-icon">
										<i class="icon-coin-dollar"></i>
									</span>
									<span class="nav-title">Revenues</span>
									</a>
								</li>
								<li>
									<a class="has-arrow" aria-expanded="false" href="JavaScript:Void(0);">
									<span class="has-icon">
										<i class="icon-settings"></i>
									</span>
									<span class="nav-title">Setting</span>
									</a>
									<ul aria-expanded="false" class="collapse">
										<li>
											<a href='javascript:void(0)' class="current-page">
											<span class="has-icon">
												<i class="icon-notifications_active"></i>
											</span>
											<span class="nav-title">Notification</span>
											</a>
										</li>
									</ul>
								</li>
							</ul>
							<!-- END: side-nav-content -->
						</nav>
						<!-- END: .side-nav -->
					</div>
					<!-- END: .side-content -->
				</aside>
				<!-- END: .app-side -->
				<div style="width:100%" ng-view ng-animate="{enter: 'view-enter'}"></div>
				
			</div>
			<!-- END: .app-container -->
			<!-- BEGIN .main-footer -->
			<footer class="main-footer fixed-btm">
				Copyright kidyview.admin 2019.
			</footer>
			<!-- END: .main-footer -->
		</div>
		<!-- END: .app-wrap -->
		
		<script src="<?php echo base_url(); ?>adminasset/js/tether.min.js"></script>
		<script src="<?php echo base_url(); ?>adminasset/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>adminasset/js/unifyMenu.js"></script>
		<script src="<?php echo base_url(); ?>adminasset/js/onoffcanvas.js"></script>
		<script src="<?php echo base_url(); ?>adminasset/js/moment.js"></script>
		<!-- Morris Graphs -->
		<script src="<?php echo base_url(); ?>adminasset/js/morris/raphael-min.js"></script>
		<script src="<?php echo base_url(); ?>adminasset/js/morris/morris.min.js"></script>
		<script src="<?php echo base_url(); ?>adminasset/js/morris/barColors.js"></script>
		<script src="<?php echo base_url(); ?>adminasset/js/chartist/chartist.min.js"></script>
		<script src="<?php echo base_url(); ?>adminasset/js/chartist/chartist-tooltip.js"></script>
		<script src="<?php echo base_url(); ?>adminasset/js/chartist/custom-line-chart1.js"></script>
		<script src="<?php echo base_url(); ?>adminasset/js/chartist/custom-area-chart.js"></script>
		<!-- Data Tables -->
		<script src="<?php echo base_url(); ?>adminasset/js/datatables/dataTables.min.js"></script>
		<script src="<?php echo base_url(); ?>adminasset/js/datatables/dataTables.bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>adminasset/js/datatables/custom-datatables.js"></script>
		<!-- Flot Charts -->
		<script src="<?php echo base_url(); ?>adminasset/js/flot/jquery.flot.min.js"></script>
		<script src="<?php echo base_url(); ?>adminasset/js/flot/jquery.flot.time.min.js"></script>
		<script src="<?php echo base_url(); ?>adminasset/js/flot/jquery.flot.pie.min.js"></script>
		<script src="<?php echo base_url(); ?>adminasset/js/flot/jquery.flot.stack.min.js"></script>
		<script src="<?php echo base_url(); ?>adminasset/js/flot/jquery.flot.tooltip.min.js"></script>
		<script src="<?php echo base_url(); ?>adminasset/js/flot/jquery.flot.resize.min.js"></script>
		<script src="<?php echo base_url(); ?>adminasset/js/flot/line.js"></script>
		<!-- Newsticker JS -->
		<script src="<?php echo base_url(); ?>adminasset/js/newsticker/newsTicker.min.js"></script>
		<script src="<?php echo base_url(); ?>adminasset/js/newsticker/custom-newsTicker.js"></script>
		<!-- Form Wizard -->
		<script src="<?php echo base_url(); ?>adminasset/js/formwizard/jquery.bootstrap.wizard.min.js"></script>
		<script src="<?php echo base_url(); ?>adminasset/js/form-validation.js"></script>
		<!-- Multiple Select -->
		<script src="<?php echo base_url(); ?>adminasset/js/multiselect/select2.min.js" type="text/javascript"></script>
		<!-- Data Tables -->
		<script src="<?php echo base_url(); ?>adminasset/js/slimscroll/slimscroll.min.js"></script>
		<script src="<?php echo base_url(); ?>adminasset/js/slimscroll/custom-scrollbar.js"></script>
		<!-- Common JS -->
		<script src="<?php echo base_url(); ?>adminasset/js/common.js"></script>
		<script src="<?php echo base_url(); ?>asset/js/gritter/js/jquery.gritter.js" type="text/javascript"></script>
		<script src="<?php echo base_url(); ?>asset/js/intlTelInput.min.js"></script>
		<script src="<?php echo base_url(); ?>asset/js/utils.js"></script>
		<script src="<?php echo base_url(); ?>asset/js/ng-intl-tel-input.js"></script>
		<script src="<?php echo base_url(); ?>asset/js/ng-pattern-restrict.min.js"></script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDwBRVfP3aoCIZ77fhT1Gj8ntbKoL01qPE&libraries=places"></script>
	</body>
</html>