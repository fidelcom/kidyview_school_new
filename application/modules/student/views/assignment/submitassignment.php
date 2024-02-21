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
			<h5> Submit Assignment</h5>
		</div>
	</div>
</div>
</div>
</header>
<!-- END: .main-heading -->
<!-- BEGIN .main-content -->
<div class="main-content">

<!-- Row start -->

<div class="row same-height-card">
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
	<div class="card">

		<div class="card-body small-font">
			<form>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="form-group">
						<label class="form-label">Enter description <em>*</em></label>
						<!--<textarea class="form-control" ng-model="description" rows="5"></textarea>-->
						<div ng- text-angular ng-model="description"></div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="form-group">
						<label class="form-label">Upload attachments</label>
						<div class="row">
							<div class="btn-uploadprof uploadlogo col-md-3 col-sm-3">
								<span>
									<input id="pic" multiple class="files file-upload ng-pristine ng-valid ng-not-empty ng-touched" accept="image/png, image/jpeg, application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,audio/*,video/*" type="file" onchange="angular.element(this).scope().SelectFile(event)">
									<span>Upload</span>
								</span>
							</div>
							<!--<div class="attachment-note">Note: Only jpeg, png, pdf,doc allowed.</div>-->
							<div class="col-md-12 prev-section mt-2" ng-repeat="prev in PreviewImage">
								<div class="row">
									<div class="col-md-3 fpUploadImg">
										<i class="icon-trash2" ng-click="remove($index);"></i>
										<div> {{prev.name}}</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12 mt-3">
					<div class="form-group">
						<a class="btn btn-primary submit-btn" ng-click="submitAssignment();">Submit</a>
						<a class="btn btn-secondary" href="#!/assignment-list">Back To List</a>
					</div>
				</div>
				<div class="col-md-12">
				<div ng-show="showLoader==1">
					<div class="loader-bx-container">
						<div class="loader-bx"></div>
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