<!-- BEGIN .app-main -->
<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
<div class="row">

<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
<div class="page-icon">
<i class="icon-dashboard"></i>
</div>
<div class="page-title">
<h5>View Class Schedule</h5>
</div>
</div>
<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
<div class="right-actions">
<!-- <a href="add-school.html" class="btn btn-primary">Add School</a>
<a href="#" class="btn btn-primary">Add School</a> -->
</div>
</div>
</div>
</div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">
<div class="card">
<div class="card-body full-detail">
<div class="row">
    <!--
<div class="col-md-4">
<div class="form-group">
    <select class="form-control" id="">
        <option>School Type</option>
        <option>School - A</option>
        <option>School - B</option>
        <option>School - C</option>
        <option>School - D</option>
    </select>
</div>
</div> -->
<!--
<div class="col-md-4">
<div class="form-group">
    <select class="form-control" id="">
        <option>Select Class</option>
        <option selected>2nd - A</option>
        <option>2nd - B</option>
        <option>3rd - B</option>
        <option>4th - B</option>
    </select>
</div>
</div>
-->
<!--<div class="col-md-4 text-right">
<div class="form-group">
    <button type="button" class="btn btn-primary br-0">Search</button>
</div>
</div>-->
</div>
<div class="table-responsive time_table class-schedule-tbl">
<table width="100%" border="0" cellpadding="1" cellspacing="1" ng-if="day_timeTable.length>0">
<tr>
    <th class="day">Day</th>
    <th ng-repeat="pd in day_timeTable[0].lectureList track by $index">{{$index+1}} [{{pd.start_time+' To '+pd.end_time}}]</th>
</tr>
<tr ng-repeat="timetable in day_timeTable">
    <td class="day">{{timetable.val}}</td>
    <td ng-repeat="lecture in timetable.lectureList">
        <span>{{lecture.subject&&lecture.subject!=''?lecture.subject:'Subject Name : N/A'}}</span>
         {{lecture.teacher_name&&lecture.teacher_name!=''?lecture.teacher_name:'Teacher Name : N/A'}} 
         <span>Lecture Name: {{lecture.ltname&&lecture.ltname!=''?lecture.ltname:'N/A'}}</span>
         <span ng-show="lecture.zoom_link!=null">Zoom Link: <a target="_blank" href="lecture.zoom_link">{{lecture.zoom_link}}</a></span>
         <span ng-show="lecture.zoom_link==null">Zoom Link: N/A</span>
         <span>Other Info: {{lecture.teacher_name&&lecture.other_info!=null?lecture.other_info:'N/A'}}</span>
    </td>
</tr>

</table>
<div class="p-3 alert alert-info" ng-if="day_timeTable.length==0"> Class schedule not found. </div>
</div>
</div>					
</div>
<!-- Row end -->
</div>
<!-- END: .main-content -->
</div>
<!-- END: .app-main -->