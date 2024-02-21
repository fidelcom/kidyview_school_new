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
<h5>Subject</h5>
<h6 class="sub-heading">Details</h6>
</div>
</div>
</div>
</div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">

<!-- Row start -->
<div class="card">
<div class="card-body">
<div class="row student-dashboard-blk">


<div class="col-md-12">
<h4>{{subjectinfo.subject}}</h4>
<p class="mb-1 text-blue">{{subjectinfo.teachername}}</p>
<hr />
</div>


<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mt-2">
<div class="row">
    <div class="col-md-8">
        <div class="sub-detail-content">
            <div class="dtl-lg-img mb-3">
                <img ng-show="subjectinfo.image!=''" class="card-img-top" src="<?php echo base_url();?>img/subject/{{subjectinfo.image}}" alt="Subject">
                <img ng-show="subjectinfo.image==''" class="card-img-top" src="<?php echo base_url();?>img/noImage.png" alt="Subject">
            </div>
            <p>{{subjectinfo.description}}</p>
            </div>
    </div>
    <div class="col-md-4" ng-show="subjectinfo.assignments.length>0">
        <h4 class="mb-0 text-white text-uppercase text-left p-3 bg-dark">Assignments</h4>
        
        <ul class="col-aside">
            <li ng-repeat="assignment in subjectinfo.assignments">
                <a href="#!assignment-detail/{{assignment.id}}"><h5>{{assignment.title}}</h5></a>
                <div class="assignment-dt">{{assignment.created|date:"dd MMM y"}}</div>
            </li>
        </ul>
    </div>
</div>

</div>
</div>
</div>
</div>
<!-- Row end -->
</div>
<!-- END: .main-content -->
</div>
<!-- END: .app-main -->