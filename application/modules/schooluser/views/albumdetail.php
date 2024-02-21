<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 align-self-center">
					<div class="page-icon">
						<i class="icon-photo"></i>
					</div>
					<div class="page-title">
						<h5>View {{title}}</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
					<div class="right-actions">
						<a href="#!/add-album" class="btn btn-primary"> <i class="icon-plus2"></i> Add Album</a>
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
				<ul class="album_view">
					<li ng-show = "picUrl.length > 0" ng-repeat="pic in picUrl"><a class="group1" rel="gallery1" href="<?= base_url(); ?>img/album/{{pic.attachment}}" title="{{title}}"><img src="<?= base_url(); ?>img/album/{{pic.attachment}}" /></a>
					<?php if((isset($ALLPRIVILEGE) && $ALLPRIVILEGE['AlbumComment']['view']==1) || $this->session->userdata('user_role')=='school'){?>
						<div class="attachmentCommentsscroll">
							<div class="attachmentComments" ng-repeat="comments in pic.comment_detail">
								<div class="img">
									<img src="{{comments.create_by_photo}}" />
									<p class="comment_user">{{comments.create_by}}</p>
									<p class="comment_userType">{{comments.user_type}}</p>
								</div>
								<div class="cont">{{comments.comment}}
									<a ng-click="albumCommentDelete(comments.comment_id)" class="contdelete"><i class="icon-trash2" title="Delete"></i></a>	
								</div>
							</div>
						</div>
					<?php } ?>
					</li>
					<li ng-show = "videoUrl.length > 0" ng-repeat="video in videoUrl">
						<video type="video/x-matroska;" width="192px" height="300px" src="<?= base_url(); ?>img/album/{{video.attachment}}" controls>
						</video>
						<?php if((isset($ALLPRIVILEGE) && $ALLPRIVILEGE['AlbumComment']['view']==1) || $this->session->userdata('user_role')=='school'){?>
						<div class="attachmentCommentsscroll">
							<div class="attachmentComments" ng-repeat="comments in video.comment_detail">
								<div class="img">
									<img src="{{comments.create_by_photo}}" />
									<p class="comment_user">{{comments.create_by}}</p>
									<p class="comment_userType">{{comments.user_type}}</p>
								</div>
								<div class="cont">{{comments.comment}}
									<a ng-click="albumCommentDelete(comments.comment_id)" class="contdelete"><i class="icon-trash2" title="Delete"></i></a>	
								</div>
							</div>
						</div>
						<?php } ?>
					</li>
				</ul>
			</div>
		</div>
		<a class="btn btn-secondary" href="#!/album-list">Back To List</a>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->