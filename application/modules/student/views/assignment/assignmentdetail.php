<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
<div class="row">

<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
<div class="page-icon">
<a href="#!/assignment-list"> <i class="icon-arrow-back"></i></a>
</div>
<div class="page-title">
<h5> Assignment Details</h5>
</div>
</div>
<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
<div class="right-actions">
<a href="javascript:void(0);" ng-click="attemptCount(viewassignmentID,no_of_attempt,userAttemptCount);" class="btn btn-primary"> Submit Assignment</a>
</div>
</div>
</div>

</div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">
<div class="card">
<div class="card-body">
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="card-body vendor-full-detail p-0">
	<p class="days-left-con" ng-if="latedays!=''">late days : {{latedays}} </p>
	<p class="rmn-right-blk text-green" ng-if="leftdays!=''">remaining days : {{leftdays}} </p>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Assignment Name:</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh"> {{assignmentname}}</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Assignment Category:</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh"> {{category}}</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Total Marks:</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh"> {{totalmarks}}</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Class Name:</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{class}}</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Teacher Name:</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{teacher}}</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Date of Submission:</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh" ng-class="{'text-green':(currDate|date:'yyyy-MM-dd')<=submissiondate,'text-red':(currDate|date:'yyyy-MM-dd')>submissiondate}">{{submissiondate|date:"dd MMM y"}}</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Subject:</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{subject}}</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Issued Date:</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{dateofissue|date:"dd MMM y"}}</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Description</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{description}}</div>

	</div>
	<div class="row" ng-if="attachmentArray.length>0">
		<div class="col-md-3 col-lg-3 col-sm-12">Attachments</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">
			<!--<div class="">
				<div class="single-attachment">
					<div class="btn-group send_btn">
						<button class="btn-primary btn btn-sm" ng-click="viewAttachment(1);"><i class="icon-eye2"></i> view</button>
						<a target="_self" download="{{attachment}}" href="<?php echo base_url();?>img/assignment/{{attachment}}" class="btn btn-info btn-sm"><i class="icon-download3"></i> Download </a>
					</div>
					<div ng-show="showAtachment==1" ng-if="attachmentUrl!=''"><iframe ng-src="{{attachmentUrl}}"></iframe></div>
				</div>
			</div>-->
			<div class="btn-group send_btn DownloadAll">
				<a ng-click="assignmentdownload(assignmentinfo.id)" href="javascript:void(0);" class="btn btn-info btn-sm"><i class="icon-download3"></i> Download All</a>
			</div>			
		</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12"></div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">
			<div class="row" ng-repeat="attach in attachmentArray">
				<div class="col-sm-6 col-md-6 col-lg-6 col-sm-12">
				<p>{{attach.attachment}}</p>
				</div>
				<div class="col-sm-6 col-md-6 col-lg-6 col-sm-12">				
					<div class="single-attachment BottonBox">
						<div class="btn-group send_btn">
							<a target="_blank" class="btn-primary btn btn-sm" href="{{attach.downloadurl}}"><i class="icon-eye2"></i> <span>view</span></button>
							<a target="_self" download="{{attach.attachment}}" href="{{attach.downloadurl}}" class="btn btn-info btn-sm"><i class="icon-download3"></i> <span>Download </span></a>
						</div>
					</div>
				</div>
					
			</div>
		</div>
	</div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="row">
			<div class="form-group">
				<a class="btn btn-secondary" href="#!/assignment-list">Back To List</a>
			</div>
		</div>
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