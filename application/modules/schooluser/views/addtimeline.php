<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="icon-news"></i>
					</div>
					<div class="page-title">
						<h5>Add Timeline</h5>
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
			<div class="card-body">
				<form name="myForm">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Description<em>*</em></label>
								<div class="controls">
									<textarea class="form-control" ng-model="description"></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<div class="upload-preview-box" ng-repeat ="data in previewData track by $index">
									<img src="{{data.src}}" class="thumb">
									<span ng-click="remove(data)" class="remove-photo"><i class="fa fa-close"></i></span>
								</div>
								<div class="btn-uploadprof uploadlogo mt-0">
									<span class="uploadbtn-normal mb-4">
										<i class="icon-camera-outline"></i>
										<input class="files file-upload" ngf-select="" ngf-change="onChange($files)" name="pic[]" ng-model="pic" accept="image/png, image/jpeg, image/gif" type="file" multiple="">
										<span>Upload Photos</span>
									</span>
								</div>
							</div>
						</div>
						
						<div class="col-md-12 col-sm-12 col-xs-12 mt-3">
							<div class="form-group">
								<button class="btn btn-primary" ng-click="addTimeline()" name="submit">Submit</button>
								<a class="btn btn-secondary" href="#!/timeline-list">Back To List</a>
							</div>
						</div>
						
					</div>
				</form>
			</div>
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->