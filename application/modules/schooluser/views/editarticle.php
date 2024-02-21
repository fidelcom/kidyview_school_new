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
						<h5>Edit Article</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
					<div class="right-actions">
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
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Article Title<em>*</em></label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="title">
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Detail<em>*</em></label>
								<div class="controls">
									<textarea class="form-control" ng-model="description"></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<div class="upload-preview-box">
									<img ng-show="isImage(fileExt)" ngf-src="pic[0]" class="thumb">
									<img ng-show="photo != ''" src="<?= base_url();?>img/article/{{photo}}" class="thumb">
								</div>
								<div class="btn-uploadprof uploadlogo mt-0">
									<span>
										<i class="icon-camera-outline"></i>
										<input class="file-upload" ngf-select="" ngf-change="onChange($files)" id="pic" ngf-select ng-model="pic" accept="image/png, image/jpeg" type="file" />
										<span>Change Photo</span>
									</span>
								</div>
							</div>
							
							
							
							
						</div>
						
						<div class="col-md-12 col-sm-12 col-xs-12 mt-2 mt-md-3">
							<div class="form-group">
								<button class="btn btn-primary" ng-click="editArticle()" name="submit">Update</button>
								<a class="btn btn-secondary" href="#!/article-list">Back To List</a>
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