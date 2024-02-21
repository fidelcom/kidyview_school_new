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
    <input type="checkbox" ng-model="setting.is_web" ng-change="updateNotificationSetting(setting)"
    ng-true-value="'1'" ng-false-value="'0'">
</div>
</div>
</div>
<div class="row mt-1">
<div class="col-md-4 align-self-center">
Push Notification
</div>
<div class="col-md-8 text-right">
<div class="float-right">
    <input type="checkbox" ng-model="setting.is_push" ng-change="updateNotificationSetting(setting)"
    ng-true-value="'1'" ng-false-value="'0'">
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