<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
<div class="row">

<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
<div class="page-icon">
<a href="#!/submitted-assignment-list"> <i class="icon-arrow-back"></i></a>
</div>
<div class="page-title">
<h5> Submitted Assignment Details</h5>
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
<div class="card-body vendor-full-detail">
<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Assignment Name:</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh"> {{assignmentname}}</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Class Name:</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{class}}</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Subject:</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{subject}}</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Student Name:</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{studentname}}</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Last Date of Submission:</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{lastsubmissiondate|date:"dd MMM y"}}</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Date of Submitted:</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{submissiondate|date:"dd MMM y"}}</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Description</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh" ng-bind-html="description"></div>

	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Feedback</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh" ng-show="isEdit==1">
		<textarea class="form-control" ng-model="feedback"></textarea>
		<button class="btn btn-primary mt-2" type="button" ng-click="updateAssignmentFeedback(id,feedback);">{{feedbackButton}}</button>
		</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh" ng-show="isEdit==0">
		{{feedback&&feedback!=''?feedback:'N/A'}}
		<a  ng-click="editFeedBack();"><i class="icon-edit2"></i></a>
		</div>
	</div>
<div class="row" ng-if="attachmentArray.length>0">
		<div class="col-md-3 col-lg-3 col-sm-12">Attachments</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">
			<div class="btn-group send_btn DownloadAll mb-2">{{assignmentinfo}}
				<a href="javascript:void(0);" ng-click="submitassignmentdownload(assignmentinfo.id);" class="btn btn-info btn-sm"><i class="icon-download3"></i> Download All</a>
			</div>			
		</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12"></div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">
			<div class="row" ng-repeat="attach in attachmentArray">
				<div class="col-sm-8 col-md-8 col-lg-8 col-sm-12">
				<p>{{attach.attachment}}</p>
				</div>
				<div class="col-sm-4 col-md-4 col-lg-4 col-sm-12">				
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
	</div>
	
	<div class="col-md-12 col-sm-12 col-xs-12 pl-0 pl-md-3">
	<div class="form-group">
		<a class="btn btn-secondary" href="#!/submitted-assignment-list">Back To List</a>
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