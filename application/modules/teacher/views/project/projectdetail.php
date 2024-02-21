<div class="app-main">
<!-- BEGIN .main-heading -->
<header class="main-heading">
<div class="container-fluid">
<div class="row">

<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
<div class="page-icon">
<a href="#!/project-list"> <i class="icon-arrow-back"></i></a>
</div>
<div class="page-title">
<h5> Project Details</h5>
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
		<div class="col-md-3 col-lg-3 col-sm-12">Project Name:</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh"> {{assignmentname}}</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Project Cateory:</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh"> {{category}}</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Total Marks:</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh"> {{total_marks}}</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Class Name:</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{class}}</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Due Date:</div>
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
		<div class="col-md-3 col-lg-3 col-sm-12">Open Project Date:</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{openassignmentdate!=null?(openassignmentdate|date:"dd MMM y"):'N/A'}}</div>
	</div>
	<div class="row">
		<div class="col-md-3 col-lg-3 col-sm-12">Description</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">{{description}}</div>

	</div> 
	<div class="row" ng-if="attachmentArray.length>0">
		<div class="col-md-3 col-lg-3 col-sm-12">Attachments</div>
		<div class="col-md-9 col-lg-9 col-sm-12 text-highligh">
			<div class="btn-group send_btn DownloadAll">
				<a href="javascript:void(0);" ng-click="projectdownload(assignmentinfo.id);" class="btn btn-info btn-sm"><i class="icon-download3"></i> Download All</a>
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
				<a class="btn btn-secondary" href="#!/project-list">Back To List</a>
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