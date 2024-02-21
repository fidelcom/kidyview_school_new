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
        <!-- Common CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>adminasset/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>adminasset/fonts/icomoon/icomoon.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>adminasset/css/morris/morris.css" />
        <!-- Chartist css -->
        <link href="<?php echo base_url(); ?>adminasset/css/chartist/chartist.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>adminasset/css/chartist/chartist-custom.css" rel="stylesheet" />
        <!-- database css -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>adminasset/css/datatables/dataTables.bs4.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>adminasset/css/datatables/dataTables.bs4-custom.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/all.css" />
        <!-- global css -->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>adminasset/css/all.css" />

        <link rel="stylesheet" href="<?php echo base_url(); ?>adminasset/css/global.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/global.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/css/intlTelInput.css" />
        <script src="<?php echo base_url(); ?>adminasset/js/ngdatatable/angular-datatables.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>adminasset/js/ngdatatable/css/angular-datatables.css">
        <script src="<?php echo base_url(); ?>asset/uiselect/dist/select.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>asset/uiselect/dist/select.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>adminasset/css/multiselect/select2.css">    
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.8.5/css/selectize.default.css">
    </head>
    <body>

        <?php
        $adminDetail = $this->session->userdata();
        $adminName = $adminDetail['user_data']['full_Name'];
        $adminPhoto = $adminDetail['user_data']['photo'];
        ?>
        <script>
            var BASE_URL = '<?php echo base_url(); ?>';
            var xapikey = 'AOmAfXgEOBiziaIZfynXNuUnnNvWnjjcoP1Qpd8S';
            var jsonPrivilege = '<?php echo json_encode($JSONPRIVILEGE, true); ?>';
        </script>

        <!-- start app wrap -->
        <div class="app-wrap">
            <!-- stard app header -->
            <header class="app-header" ng-controller="headerControllers">
                <div class="container-fluid">
                    <div class="row gutters">
                        <div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 col-7">
                            <a class="mini-nav-btn" href="javascript:void0;" id="app-side-mini-toggler">
                                <span class="brandlogo"><img src="<?php echo base_url(); ?>img/small_logo.png" alt="Airo.Life" /></span>
                                <i class="icon-menu5"></i>
                            </a>
                            <a href="#app-side" data-toggle="onoffcanvas" class="onoffcanvas-toggler" aria-expanded="true">
                                <i class="icon-chevron-thin-right"></i>
                            </a>
                            <span class="header-links">
                            </span>
                        </div>
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 col-5	">
                            <ul class="header-actions">

                                <li class="dropdown">
                                    <a href="javascript:void0;" id="notifications" data-toggle="dropdown" aria-haspopup="true">
                                        <i class="icon-notifications_none"></i>
                                        <span class="count-label">{{notificationCount}}</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right lg" aria-labelledby="notifications">
                                        <ul class="imp-notify">
                                        <li ng-repeat="notification in notificationData">
                                            <a href="#!/{{notification.url}}">
                                            <div class="icon">{{notification.iconText}}</div>
                                            </a>
                                            <div class="details">
                                            <p><a href="#!/{{notification.url}}" ng-click="updateNotification(notification.id);">{{notification.message}}</a></p>
                                            </div>

                                            </li>
                                            <li ng-if="notificationCount==0">
                                            No record
                                            </li>
                                            <li class="text-center" ng-if="notificationCountAll>0">
                                            <a class="see-all-link" href="#!/notification">See All</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>

                                <li class="dropdown">
                                    <a href="javascript:void0;" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                                        <?php if ($this->session->userdata('user_role') == 'admin') { ?>
                                            <img class="avatar profileImageHeader" src="<?php echo base_url(); ?>img/admin/<?php echo $adminPhoto; ?>" alt="User Thumb" />
                                        <?php } elseif ($this->session->userdata('user_role') == 'adminsubadmin') { ?>
                                            <img class="avatar profileImageHeader" src="<?php echo base_url(); ?>img/school/subadmin/<?php echo $adminPhoto; ?>" alt="User Thumb" />
                                        <?php } ?>
                                        <span class="user-name username"><?php echo $adminName; ?></span>
                                        <i class="icon-chevron-small-down"></i>
                                    </a>
                                    <div class="dropdown-menu lg dropdown-menu-right" aria-labelledby="userSettings">
                                        <ul class="user-settings-list">
                                            <li>
                                                <?php if ($this->session->userdata('user_role') == 'admin') { ?>
                                                    <a href="#!/admin-profile">
                                                        <div class="icon">
                                                            <i class="icon-account_circle"></i>
                                                        </div>
                                                        <p>Profile</p>
                                                    </a>
                                                <?php } else { ?>
                                                    <a href="#!/profile">
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
                    <?php
                    if ($this->session->userdata('user_role') == 'admin') {
                        $this->load->view('admin-left-menu.php');
                    } elseif ($this->session->userdata('user_role') == 'adminsubadmin') {
                        $this->load->view('subadmin-left-menu.php');
                    }
                    ?>
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
    <script>
    app.controller('headerControllers', function($scope,$http,$interval) {
	
	$scope.notificationData=[];
	$scope.notificationCount=0;
	$scope.getLatestNotification = function()
	{
		$scope.encryptStr = function(id)
		{
		var qry = id.toString();
		var encrypted = CryptoJS.AES.encrypt(qry, "KidyView");
		var str = encrypted.toString();
		if(str.indexOf("/") == -1) {
		return str;
		}
		else{
		return $scope.encryptStr(id);
		}

		};
		var formData = {'schoolID':''}
		$http.post(BASE_URL+'api/admin/notification/getLatestNotification',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{  
				$scope.notificationData = response.data.data;
				$scope.notificationCount = response.data.countUnReadData;
				$scope.notificationCountAll = response.data.countReadData;
				var encrypted;
				for(var i = 0; i < $scope.notificationData.length; i++)
				{
					var idSplit=$scope.notificationData[i].sender_id.split('-');
					idSplit=idSplit[1];
					encrypted = $scope.encryptStr(idSplit);
					var iconText = $scope.notificationData[i].name.match(/\b(\w)/g); // ['J','S','O','N']
					iconText = iconText.join('');
					if($scope.notificationData[i].user_type=='Teacher'){
						$scope.notificationData[i]['senderUrl'] = 'teacher-details/'+encrypted;
					}else if($scope.notificationData[i].user_type=='Student'){
						$scope.notificationData[i]['senderUrl'] = 'student-details/'+encrypted;
					}
					$scope.notificationData[i]['iconText'] = angular.uppercase(iconText);
				}
				
			}
			}, function errorCallback(response){
				$scope.notificationData=[];
				$scope.notificationCount=0;
		});
		
	}
	$interval(function () {
		$scope.getLatestNotification();
	}, 2000);
	$scope.updateNotification = function(id)
	{
		var formData = {'id':id}
		$http.post(BASE_URL+'api/school/notification/updateNotification',formData,{
			headers:{
				'Content-Type':undefined, 'x-api-key':xapikey
			}
			}).then(function(response) {
			
			if(response.status == 200)
			{  
				$scope.getLatestNotification();
			}
			}, function errorCallback(response){

		});
	}
});
</script>
    </body>
</html>