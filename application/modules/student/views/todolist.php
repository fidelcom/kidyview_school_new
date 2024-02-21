<?php /* 
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
<h6 class="sub-heading">To Do List</h6>
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

<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" ng-show="todoData.length>0">
<aside class="right-aside">
<div class="card todo-card">
<div class="card-body">
<h6>To Do</h6>
<ul>
<li ng-repeat="doList in todoData track by $index">
<span class="close-li"><i class="fas fa-times" ng-click="deleteToDo(doList,$index);"></i></span>
<p ng-show="doList.type=='Assignment'" class="highlight-text"><a href="#!/assignment-detail/{{doList.ID}}">{{doList.title}}</a> <a ng-show="doList.isAssignmentOpen==0" title="Assignment Locked"><i class="fas fa-lock"></i></a></p>
<p>{{doList.subject}}</p>
<p>No. of Attempts: {{doList.no_of_attempt?doList.no_of_attempt:'N/A'}}</p>
<p class="dttime">{{doList.createdDate|myDate}}</p>
</li>   
</ul>
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
*/?>

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
                <h6 class="sub-heading">To Do Details</h6>
            </div>
        </div>
    </div>
</div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">

<!-- Row start -->

<div class="row student-dashboard-blk todo-dtl-list">

    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        <div class="outer-todo-content">
            <div class="card">
                <div class="card-body" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                
                        <div class="row">
                            <div class="col-md-4">
                                <div class="nav flex-column nav-pills bg-light" id="v-pills-tab" role="tablist" aria-orientation="vertical" style="height:100%;">
                                <div class="rdiv" ng-repeat="doList in todoData track by $index">
                                    <a class="nav-link" ng-class="{'active':indexID==doList.id}"  ng-click="getAssignmentDetails(doList.id);" data-toggle="pill" href="javascript:void(0);" role="tab" aria-controls="toDo-1-home" aria-selected="true">
                                        <i class="far fa-file-alt"></i>
                                        <div class="todo-tab-list">
                                            <div class="todo-subname">{{doList.title}} </div>
                                            <div class="todo-lessonno">{{doList.subject}}</div>
                                            <div class="todo-subdatetime">{{doList.submission_date|myDate}}</div>
                                        </div>
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                    </div>
                                
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="toDo-1-tab">
                                        <div class="todo-com-detail" ng-if="isAssignmentOpen==0">
                                            <ul>
                                            <li>
                                                <label>{{assignmentname}}</label>
                                                <div>Assignment Locked</div>
                                                <div>Open Submission Date: {{open_submission_date?(open_submission_date|myDate):'N/A'}}</div>
                                            </li>
                                            </ul>
                                        </div>
                                        <div class="todo-com-detail" ng-if="isAssignmentOpen==1">
                                            <ul>
                                                <li>
                                                    <h5>{{assignmentname}}</h5>
                                                    <!--<div class="txt-mut-sm"><span>100 pts</span> <span>Not Submitted</span> </div>-->
                                                </li>
                                                <li>
                                                    <label>Submission Date</label>
                                                    <div>{{submissiondate|myDate}}</div>
                                                </li>
                                                
                                                <li>
                                                    <label>Open Submission Date</label>
                                                    <div>{{open_submission_date?(open_submission_date|myDate):'N/A'}}</div>
                                                </li>
                                                <li>
                                                    <label>Submission Type</label>
                                                    <div>{{submissionType}}</div>
                                                </li>
                                                <li ng-if="attachmentArray.length>0">
                                                    <label>File Type</label>
                                                    <div>{{fileTypeArr.join(',')}}</div>
                                                    <div class="attachment-mail mt-2 mb-0 p-0">
                                                        <p>
                                                            <span><i class="fa fa-paperclip"></i> {{attachmentArray.length}} attachments — </span>
                                                            <a href="javascript:void(0);" ng-click="assignmentdownload(assignmentinfo.id);">Download all attachments</a>
                                                        </p>
                                                        <ul>
                                                            <li ng-repeat="attach in attachmentArray">
                                                                <a class="atch-thumb" href="javascript:void(0);"> {{attach.attachment}}
                                                                    </a>
                                                                    <div class="links">
                                                                    <a target="_blank" href="{{attach.downloadurl}}">View</a> - <a target="_self" download="{{attach.attachment}}" href="{{attach.downloadurl}}">Download</a>
                                                                    </div>
                                                            </li>
                                        
                                                        </ul>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <label>Attempts Allowed</label>
                                                    <div>{{no_of_attempt?no_of_attempt:'N/A'}}</div>
                                                </li>
                                                <li>
                                                    <label>Description</label>
                                                    <p>{{description}}</p>
                                                </li>
                                                
                                            </ul>
                                            <a href="#!/submit-assignment/{{viewassignmentID}}" class="btn btn-primary">Submit Assignment</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



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