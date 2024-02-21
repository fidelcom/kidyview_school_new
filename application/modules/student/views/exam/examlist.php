<!-- BEGIN .app-main -->
<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
<div class="row">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 d-flex">
<div class="page-icon">
<i class="icon-user-tie"></i>
</div>
<div class="page-title ml-3 align-self-center">
<h5>Exam List</h5>
</div>
</div>
</div>
</div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">
<div class="card">
<!--
<div class="card-header">
<div class="row">

<div class="col-md-4"></div>
<div class="col-md-4">
<label class="mr-2">Status</label>
    <select class="form-control"> 
        <option value="">Select Status</option>
        <option value="completed">Completed</option>
        <option value="pending">Pending</option>
    </select>
</div>
</div>
</div>
</div>-->
<div class="card-body small-font">
<div class="table-responsive">
<div class="row filter-row-examlist">
	<div class="col-md-4">
		<!--<label class="mr-2">Subject</label>-->
		<select class="form-control" ng-model="subject_id" ng-change="getExamList()"> 
			<option value="">Select Subject</option>
			<option value="{{subject.id}}" ng-repeat="subject in subjectArray | unique : 'id'">{{subject.name}}</option>
		</select>
	</div>
	<div class="col-md-4">
		<!--<label class="mr-2">Status</label>-->
		<select class="form-control" ng-model="status" ng-change="getExamList()"> 
			<option value="">Select Status</option>
			<option value="{{status.name}}" ng-repeat="status in statusArray | unique : 'name'">{{status.name}}</option>
		</select>
	</div>
    <div class="col-md-4">
		<!--<label class="mr-2">Status</label>-->
		<select class="form-control" ng-model="sessionval" ng-change="getExamList()"> 
			<option value="">Exam Session</option>
			<option value="{{session.name}}" ng-repeat="session in sessionArray | unique : 'name'">{{session.name}}</option>
		</select>
	</div>
</div>
<div class="table-responsive ">
<table datatable="ng" class="table table-striped table-bordered white-space-nowrap table-responsive table-exam-list">
<thead>
    <tr>
        <th>S.No.</th>
        <th>Exam Name</th>
        <th>Exam Mode</th>
        <th>Exam Category</th>
        <th>Exam Date</th>
        <!--<th>Exam Duration</th>-->
        <th>Subject</th>
        <th>Attempts Allowed</th>
        <th>Attempts Made</th>
        <th>Last Submission Date</th>
        <!--<th class="text-right">Total Marks</th>-->
        <th>Status</th>
        <th class="text-right">Action</th>
    </tr>
</thead>
<tbody>
    <tr ng-repeat="exam in examData">
        <td>{{$index+1}}</td>
        <td>{{exam.name}}</td>
        <td>{{exam.exam_mode}}</td>
        <td>{{exam.exam_category}}</td>
        <td>{{(exam.exam_date|myDate)+' '+exam.exam_time}}</td>
        <!--<td>{{exam.examduration}}</td>-->
        <td>{{exam.subject}}</td>
        <td>{{exam.exam_attempt_no}}</td>
        <td>{{exam.no_of_attempt!=null?exam.no_of_attempt:0}}</td>
        <td>{{exam.last_submission_date|myDate}}</td>
       <!-- <td class="text-right">{{exam.total_marks}}</td>-->
        <td><span ng-class="{'text-red':exam.exam_status=='Locked','text-green':exam.exam_status=='Completed' || exam.exam_status=='Ongoing' || exam.exam_status=='Graded','text-yellow':exam.exam_status=='Unlock'}">{{exam.exam_status}}</span></td>
        <td class="action text-right">
            <a href="#!exam-details/{{exam.examID}}" data-toggle="tooltip" data-original-title="View" data-placement="top"><i class="icon-eye"></i></a>
        </td>
    </tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
<!-- Row end -->
</div>
<!-- END: .main-content -->
</div>
<!-- END: .app-main -->