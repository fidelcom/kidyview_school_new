<!-- END: .app-side -->            <!-- BEGIN .app-main -->
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
			<h5>Add Assignment</h5>
		</div>
	</div>
</div>
</div>
</header>
<!-- BEGIN .main-content -->
<div class="main-content">
<!-- Row start -->
<div class="row same-height-card">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
	<div class="card dataTables_wrapper">
		<div class="card-body">
			<form>
			<div class="row form-group">
					<div class="col-md-3 pr-0">
						<label>Select Subject<em>*</em></label>
					</div>
					<div class="col-md-6 pl-0">
						<div class="multi-dorpdown-list">
							<div class="controls">
								<select class="form-control" ng-model="subject" >
									<option value="">Select Subject</option>
									<option value="{{subject.id}}" ng-repeat="subject in subjectData">{{subject.subject}} ({{subject.classname}})</option>
								</select>
							</div>
							<div class="error" ng-show="errormsg">{{errormsg}}</div>
						</div>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-3 pr-0">
						<label>Assignment Name<em>*</em></label>
					</div>
					<div class="col-md-6 pl-0">
						<input type="text" class="form-control" ng-model="title" name="classroom" value='' />
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-3 pr-0">
						<label>Submission Date<em>*</em></label>
					</div>
					<div class="col-md-6 pl-0">
						<input type="date" class="form-control" ng-model="date" name="classroom" value='' />
					</div>
				</div>
					<div class="row form-group">
						<div class="col-md-3 pr-0">
							<label>Description<em>*</em></label>
						</div>
						<div class="col-md-6 pl-0">
							<textarea class="form-control" rows="4" ng-model="description" name="description"></textarea>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-3 pr-0">
							<label>Upload</label>
						</div>
						<div class="col-md-6 pl-0">
							<div class="btn-uploadprof uploadlogo d-inline-block">
							<span class="pl-3 pr-3">
							<i class="fas fa-upload text-white"></i>
							<input class="files file-upload ng-pristine ng-valid ng-not-empty ng-touched" id="pic" ng-model="photo" multiple accept="image/png, image/jpeg, application/pdf" type="file" onchange="angular.element(this).scope().SelectFile(event)">
							<span>Upload</span>
							</span>
							</div>
							<div class="col-md-12 prev-section mt-2" ng-repeat="prev in PreviewImage">
							<div class="row">
							<div class="col-md-12 fpUploadImg">
							<i class="icon-trash2" ng-click="remove($index);"></i>
							<div class="upload-preview-box">{{prev.name}}</div>
							</div>
							</div>
							</div>
							<div class="col-md-12 prev-section mt-2" ng-repeat="prev in editAttachmentData">
							<div class="row">
							<div class="col-md-12 fpUploadImg">
							<i class="icon-trash2" ng-click="removeEdit(prev,$index);"></i>
							<div class="upload-preview-box">{{prev.file}}</div>
							</div>
							</div>
							</div>	
						</div>
					</div>
				
				<div class="row form-group mt-3">
					<div class="col-md-3 pr-0">
					</div>
					<div class="col-md-6 pl-0">
						<button type="button" ng-click="createAssignment();" class="btn btn-primary">Create</button>
						<a href="#!/assignment-list" class="btn btn-danger text-white">Cancel</a>
						<div ng-show="showLoader==1">
						<div class="loader-bx-container">
						<div class="loader-bx"></div>
						</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
<!-- Row end -->
</div>
<!-- END: .main-content -->
</div>
<!-- END: .app-main -->