<!-- BEGIN .app-main -->
<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
<div class="row">
<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
<div class="page-icon">
<i class="icon-laptop_windows"></i>
</div>
<div class="page-title">
<h5>Student</h5>
<h6 class="sub-heading">Dashboard</h6>
</div>
</div>
</div>
</div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">
<!-- Row start -->
<div class="row student-dashboard-blk">

<div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 card-left">
<div class="row">
<div class="col-md-6 col-sm-6" ng-repeat="subject in subjectData">
<a href="#!/subject-detail/{{subject.subjectID}}">
<div class="card">
    <!--<span class="toggleicon-drp"><i class="fas fa-ellipsis-v"></i></span>-->
    <img ng-show="subject.image!=''" class="card-img-top" src="<?php echo base_url();?>img/subject/{{subject.image}}" alt="Subject">
    <img ng-show="subject.image==''" class="card-img-top" src="<?php echo base_url();?>img/noImage.png" alt="Subject">
    <div class="card-body">
        <h5 class="card-title">{{subject.subject}}</h5>
    </div>
   <!-- <div class="card-footer">
        <span class="msg-icon mr-3"><i class="far fa-comments"></i></span>
        <span class="msg-icon"><i class="far fa-folder-open"></i></span>
    </div>-->
</div>
</a>
</div>
</div>
</div>

<div class="col-xl-4 col-lg-4 col-md-12 col-sm-12" ng-show="toDoData.length>0 || removeData>0">
<aside class="right-aside">
<div class="card">
<div class="card-body">
    <h6>To Do</h6>
    <span class="showHidetxt" ng-show="removeData>0"><a href="javascript:void(0);" ng-click="showToDoRemoveData();">Show hide To Do</a></span>
    <ul>
        <li ng-class="{'text-green':(currDate|date:'yyyy-MM-dd')<=doList.submission_date,'text-red':(currDate|date:'yyyy-MM-dd')>doList.submission_date}" ng-repeat="doList in toDoData|limitTo : 5">
            <span class="close-li"><i class="fas fa-times" ng-click="deleteToDo(doList,$index);"></i></span>
           <p ng-show="doList.type=='Assignment'" class="highlight-text"><a href="#!/to-do-list/{{doList.ID}}">{{doList.title}}</a> <a ng-show="doList.isAssignmentOpen==0" title="Assignment Locked"><i class="fas fa-lock"></i></a></p>
            <p>{{doList.subject}}</p>
            <p>Attempts Allowed: {{doList.no_of_attempt?doList.no_of_attempt:'N/A'}}</p>
            <!--<p>100 points</p>-->
            <p class="dttime">{{doList.submission_date|myDate}}</p>
        </li> 
    </ul>
    <a ng-show="toDoData.length>0" href="#!/to-do-list">Show All</a>
</div>
</div>
</aside>
</div>

</div>
<!-- Row end -->
</div>
<!-- END: .main-content -->
</div>
<!-- END: .app-main -->