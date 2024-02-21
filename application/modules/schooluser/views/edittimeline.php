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
						<h5>Update Timeline</h5>
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
								
								<h5>Uploaded Photos</h5>
								<div class="upload-preview-box attachments" ng-repeat ="pic in timelineattachmentinfo">
									<div class="attachmentImages">
										<img src="<?= base_url();?>img/timeline/{{pic.attachment}}" class="thumb">
										<span ng-click="deleteMedia(pic.attachment)" class="remove-photo"><i class="fa fa-close"></i></span>
									</div>
									<div class="attachmentCommentsscroll">
										<div class="attachmentComments" ng-repeat="comments in pic.comment_detail">
											<div class="img">
												<img src="{{comments.create_by_photo}}" />
												<p class="comment_user">{{comments.create_by}}</p>
												<p class="comment_userType">{{comments.user_type}}</p>
											</div>
											<div class="cont">{{comments.comment}}
												<a ng-click="timelineCommentDelete(comments.comment_id)" class="contdelete"><i class="icon-trash2" title="Delete"></i></a>	
											</div>
										</div>
									</div>
									
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
								<div class="clearfix"></div>
							</div>
						</div>
						
						<div class="col-md-12 col-sm-12 col-xs-12 mt-3">
							<div class="form-group">
								<button class="btn btn-primary" ng-click="editTimeline()" type="button" name="submit">Update</button>
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