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
			<h5>View Class Board</h5>
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
	<div class="card dataTables_wrapper postDivder">
		<div class="card-header f20"> 
			<!--<span class="d-inline-block mt-1"><i class="fas fa-clipboard-list"></i> List of Assignments</span>-->
			<span class="float-right">
				<a href="javascript:void(0);" class="btn btn-primary" ng-click="addPost();">
					Create Post
				</a>
			</span>
		</div>
		<div class="card-body class-cardbody" ng-repeat="post in classboardPostData track by $index">
			<div class="mail-sender p-0">
				<div class="media media-class-board">
					<a href="javascript:void(0);" class="float-left"> 
					<img ng-show="post.teacherphoto!=''" alt="" src="<?php echo base_url();?>img/teacher/{{post.teacherphoto}}" class="img-circle" width="40">
					<img ng-show="post.teacherphoto==''" alt="" src="<?php echo base_url();?>img/noImage.png" class="img-circle" width="40">
					</a>
					<div class="media-body">
						<h6 class="m-0">{{post.teachername}}</h6>
						<small class="text-muted">{{post.classname}}</small>
					</div>
					
					<div class="date-center-b">
					{{post.created|date:"dd MMM y"}}
					</div>
					
					<div class="pp-links">
						<a href="javascript:void(0);" ng-click="editPost(post);"><i class="fas fa-pencil-alt" ></i></a>
						
						<a href="javascript:void(0);" class="text-danger" ng-click="deletePost(post.id,$index);"><i class="fas fa-trash-alt" ></i></a>
					</div>
				</div>
			</div>
			<div class="view-mail pl-0 pr-0 pt-2 pb-2">
				<p class="p-0 m-0">{{post.description}}</p>
			</div>
			<div class="attachment-mail p-0 clearfix">
				<ul>
					<li ng-repeat="attachment in post.attachmentData">
						<a class="atch-thumb" target="_blank" href="<?php echo base_url();?>img/classboard/post/{{attachment.file}}"> 
						<img  ng-show="attachment.type=='image'" src="<?php echo base_url();?>img/classboard/post/{{attachment.file}}" alt="image" class="doctor-pic">
						<img  ng-show="attachment.type=='pdf'" src="<?php echo base_url();?>img/pdficon.png" alt="pdf" class="doctor-pic">
						<img  ng-show="attachment.type=='doc'" src="<?php echo base_url();?>img/doc-img.png" alt="doc" class="doctor-pic">
						</a>
					</li>
					
				</ul>
			</div>
			<hr />
			<div class="classboard-comment">
				<h5 class="text-primary mt-3">Comments</h5>
				<div class="comment-form">
					<form action="" method="post">
						<div class="form-group">
							<input type="text" ng-model="postcomment[$index]"  name="postcomment" class="form-control" placeholder="Add Comments" />
							<button type="button" ng-click="comment(post,$index);" class="btn btn-primary">Post</button>
						</div>
					</form>
				</div>
			</div>
			
			<div class="rply-classboard-comment pl-5">
			
				<div class="media media-class-board" ng-repeat="comment in post.commentData | orderBy : 'post.created'">
					<a href="javascript:void(0);" class="float-left" ng-show="comment.user_type=='Student'"> 
					<img ng-show="comment.photo!=''" alt="" src="<?php echo base_url();?>img/child/{{comment.photo}}" class="img-circle" width="40">
					<img ng-show="comment.photo==''" alt="" src="<?php echo base_url();?>img/noImage.png" class="img-fluid" width="40">
					</a>
					</a>
					<a href="javascript:void(0);" class="float-left" ng-show="comment.user_type=='Teacher'"> 
					<img ng-show="comment.photo!=''" alt="" src="<?php echo base_url();?>img/teacher/{{comment.photo}}" class="img-circle" width="40">
					<img ng-show="comment.photo==''" alt="" src="<?php echo base_url();?>img/noImage.png" class="img-fluid" width="40">
					</a>
					<div class="media-body">
						<h6 class="m-0">{{comment.uname}}</h6>
						<p class="m-0">{{comment.comment}}</p>
					</div>
					<div class="pp-links">
						<a href="javascript:void(0);" ng-click="deleteComment(post,comment.id,$index);" class="text-danger"><i class="fas fa-trash-alt" ></i></a>
					</div>
				</div>
				
			</div>
		</div>
		<div class="TcrLoadmore" ng-show="countclassboardPostData>limit && classboardPostData.length<countclassboardPostData"><a href="javascript:void(0)" ng-click="loadMoreClassboardPostList();">Load More</a></div>
	</div>
</div>
</div>
<!-- Row end -->
</div>
<!-- END: .main-content -->
</div>
<!-- END: .app-main -->
<div class="modal fade" id="post-c-comment" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
<div class="modal-content">
<div class="modal-body">
<form>
	<div class="form-group">
		<label>Post Description</label>
		<textarea class="form-control" ng-model="description" rows="3"></textarea>
	</div>
	<div class="form-group">
		<label>Upload</label>
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
	<hr />
	<div class="form-group mt-3">
		<button type="button" ng-click="createPost();" class="btn btn-primary">Submit</button>
		<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
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