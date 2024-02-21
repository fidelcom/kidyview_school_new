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
		var formData = {'schoolID':schoolID}
		$http.post(BASE_URL+'api/teachers/notification/getLatestNotification',formData,{
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
		$http.post(BASE_URL+'api/student/notification/updateNotification',formData,{
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
<!-- stard app header -->
<header class="app-header" ng-controller="headerControllers">
	<div class="container-fluid">
		<div class="row gutters">
			<div class="col-xl-7 col-lg-7 col-md-7 col-sm-3 col-3">
				<a class="mini-nav-btn" href="javascript:void(0);" id="app-side-mini-toggler">
					<span class="brandlogo"><img src="<?php echo base_url(); ?>teacherasset/img/logo.png" alt="Airo.Life" /></span>
					<i class="icon-menu5"></i>
				</a>
				<a data-target="#app-side" href="javascript:void(0);" data-toggle="onoffcanvas" class="onoffcanvas-toggler" aria-expanded="true">
					<i class="icon-chevron-thin-right"></i>
				</a>
			</div>
			<div class="col-xl-5 col-lg-5 col-md-5 col-sm-9 col-9	">
				<ul class="header-actions">

				<li class="dropdown">
						<a href="javascript:void(0);" id="notifications" data-toggle="dropdown" aria-haspopup="true">
							<i class="icon-notifications_none"></i>
							<span class="count-label" ng-if="notificationCount>=0">{{notificationCount}}</span>
						</a>
						<div class="dropdown-menu dropdown-menu-right lg" aria-labelledby="notifications">
							<ul class="imp-notify"> 
								<li ng-repeat="notification in notificationData">
									<a href="#!/{{notification.senderUrl}}">
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
						<a href="javascript:void(0);" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
							<img class="avatar" src="<?php echo base_url(); ?>img/teacher/<?php echo $TEACHERDATA->teacherphoto;?>" alt="" />
							<span class="user-name"><?php echo $TEACHERDATA->teacherfname;?></span>
							<i class="icon-chevron-small-down"></i>
						</a>
						<div class="dropdown-menu lg dropdown-menu-right" aria-labelledby="userSettings">
							<ul class="user-settings-list">
								<li>
									<a href="#!/profile">
										<div class="icon">
											<i class="icon-account_circle"></i>
										</div>
										<p>Profile</p>
									</a>
								</li>
								<li>
									<a href="<?php echo base_url();?>teacher/logout">
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