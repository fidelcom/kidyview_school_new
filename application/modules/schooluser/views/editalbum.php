<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="icon-photo"></i>
					</div>
					<div class="page-title">
						<h5>Update Album</h5>
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
				<form>
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label">Album Title<em>*</em></label>
								<div class="controls">
									<input type="text" class="form-control" ng-model="title">
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								<label class="form-label">Detail</label>
								<div class="controls">
									<textarea class="form-control" ng-model="description"></textarea>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12">
							<div class="form-group">
								
								<h5>Uploaded Photos</h5>
								<div class="upload-preview-box" ng-repeat ="pic in picUrl">
									<img src="<?= base_url();?>img/album/{{pic}}" class="thumb">
									<span ng-click="deleteMedia(pic)" class="remove-photo"><i class="fa fa-close"></i></span>
								</div>
								<h5 class="mt-3">Uploaded Videos</h5>
								<div class="upload-preview-box" ng-repeat ="video in videoUrl">
									<video width="200px" height="150px" src="<?= base_url(); ?>img/album/{{video}}" controls></video>
									<span ng-click="deleteMedia(video)" class="remove-photo"><i class="fa fa-close"></i></span>
								</div>
								
								<div class="clearfix"></div>
							</div>
							<div class="form-group" style="border-top:2px solid #ddd;">
								
								<div class="upload-preview-box" ng-repeat ="data in previewData track by $index">
									<img src="{{data.src}}" class="thumb">
									<span ng-click="remove(data)" class="remove-photo"><i class="fa fa-close"></i></span>
								</div>
								<div class="btn-uploadprof">
									<span class="uploadbtn-normal">
										<i class="icon-camera-outline"></i>
										<input class="files file-upload" ngf-select="" ngf-change="onChange($files)" name="pic[]" ng-model="pic" accept="image/png, image/jpeg, image/gif" type="file" multiple="">
										<span ng-if="picUrl.length == 0">Upload Photos</span>
										<span ng-if="picUrl.length > 0">Upload More Photo</span>
									</span>
								</div>
								<div class="upload-preview-box" ng-repeat ="data in previewVideoData track by $index">
									<img src="<?= base_url();?>img/videothumb.png" class="thumb">
									<span ng-click="removeVideo(data)" class="remove-photo"><i class="fa fa-close"></i></span>
								</div>
								<div class="btn-uploadprof">
									<span class="uploadbtn-normal">
										<i class="icon-camera-outline"></i>
										<input class="files file-upload" ngf-select="" ngf-change="onChangeVideo($files)" name="video[]" ng-model="video" accept="video/mp4, video/mkv, video/3GPP, video/flv" type="file" multiple="">
										<span ng-if="videoUrl.length == 0">Upload Videos</span>
										<span ng-if="videoUrl.length > 0">Upload More Videos</span>
									</span>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
						
						<div class="col-md-12 col-sm-12 col-xs-12 mt-3">
							<div class="form-group">
								<button class="btn btn-primary" ng-click="editAlbum()" type="button" name="submit">Update</button>
								<a class="btn btn-secondary" href="#!/album-list">Back To List</a>
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