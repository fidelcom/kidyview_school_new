<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
					<div class="page-icon">
						<i class="fas fa-comments"></i>
					</div>
					<div class="page-title">
						<h5>Discussion Detail</h5>
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
				<div class="discussion_box">
					<!-- <div class="dis_img">
						<img ng-show="picUrl.length > 0" src="<?= base_url();?>img/discussion/{{picUrl[0]}}" />
						<img ng-show="picUrl.length == 0" src="<?= base_url(); ?>img/article/noImage.png" />
					</div> -->
					<div class="dis_cnt">
						<h3>{{type}}</h3>
						<div class="submit_user">
							<a href="javascript:void(0);">
							<figure><img src="{{create_by_photo}}" /></figure>
							<span>{{create_by}}</span>
							</a>
						</div>
						<div class="clearfix"></div>
						<h4>{{title}}</h4>
						<p>{{optional_detail}}</p>
					</div>
					<div class="clearfix"></div>
				</div>
				<ul class="album_view">
					<h3>Attachments</h3>
					<li ng-show = "picUrl.length > 0" ng-repeat="pic in picUrl"><a class="group1" rel="gallery1" href="<?= base_url(); ?>img/discussion/{{pic}}" title="{{title}}"><img src="<?= base_url(); ?>img/discussion/{{pic}}" /></a></li>
						<iframe ng-show = "docUrl.length > 0" ng-repeat="doc in docUrl" src="{{getIframeSrc(doc)}}"src="" height="310" width="300" scrolling="no" allowfullscreen="true">tetxt</iframe>
					<li ng-show = "docUrl.length == 0 && picUrl.length == 0"><span>No Records..</span></li>
				</ul>
				<?php 
				if((isset($ALLPRIVILEGE) && $ALLPRIVILEGE['DiscussionComment']['view']==1) || $this->session->userdata('user_role')=='school'){?>
				<ul class="album_view comment_view">
					<h3>Comments</h3>
					<li ng-show = "discussionCommentinfo.length == 0"><span>No Records..</span></li>
					<li ng-show = "discussionCommentinfo.length > 0">
						<div class="attachmentComments" ng-repeat="comments in discussionCommentinfo">
							<div class="img">
								<img src="{{comments.create_by_photo}}" />
								<p class="comment_user">{{comments.create_by}}</p>
								<p class="comment_userType">{{comments.user_type}}</p>
							</div>
							<div class="cont">{{comments.comment}}
								<a ng-click="discussionCommentDelete(comments.comment_id)" class="contdelete"><i class="icon-trash2" title="Delete"></i></a>	
							</div>
						</div>
					</li>
				</ul>
				<?php } ?>
			</div>
		</div>
		<a class="btn btn-secondary" href="#!/discussion-list">Back To List</a>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->