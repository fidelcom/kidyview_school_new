<!-- BEGIN .app-main -->
<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
<div class="row">
<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
<div class="page-icon">
<i class="fa fa-cogs"></i>
</div>
<div class="page-title">
<h5>Settings</h5>
<h6 class="sub-heading">Notification</h6>
</div>
</div>
</div>
</div>
</header>
<div class="main-content">
<div class="student-dashboard-blk">
<div class="card">
<div class="card-body" id="v-pills-tab" role="tablist" aria-orientation="vertical">
<div class="">
<ul class="list-group notification-list notification-lst-update">
<li class="list-group-item" ng-repeat="setting in notificationSettingData">
<div class="row">
<div class="col-md-12">
<h4>{{setting.module_name}}</h4>
</div>
</div>
<div class="row mt-1">
<div class="col-md-4 align-self-center">
Web Notification
</div>
<div class="col-md-8 text-right">
<div class="float-right">
<a ng-if="setting.is_web == '0'" class="ng-scope"><i class="fas fa-toggle-off" ng-click="updateNotificationSetting(setting,'1','web');"></i></a>
<a ng-if="setting.is_web == '1'"><i class="fas fa-toggle-on" ng-click="updateNotificationSetting(setting,'0','web');"></i></a>
</div>
</div>
</div>
<div class="row mt-1">
<div class="col-md-4 align-self-center">
Push Notification
</div>
<div class="col-md-8 text-right">
<div class="float-right">
<a ng-if="setting.is_push == '0'" class="ng-scope"><i class="fas fa-toggle-off" ng-click="updateNotificationSetting(setting,'1','push');"></i></a>
<a ng-if="setting.is_push == '1'"><i class="fas fa-toggle-on" ng-click="updateNotificationSetting(setting,'0','push');"></i></a>
</div>
</div>
</div>
</li>
</ul>
</div>
</div>
</div>
</div>
</div>
</div