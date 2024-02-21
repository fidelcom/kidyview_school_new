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
						<h5>Article Detail</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
					<div class="right-actions">
						<a href="#!/add-article" class="btn btn-primary"> <i class="icon-plus2"></i> Add Article</a>
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
				<div class="row justify-content-center article_detail">
					<div class="col-md-8 col-lg-8 col-sm-12">
						<figure><img ng-show="photo != ''" class="art_img" src="<?= base_url(); ?>img/article/{{photo}}" /><img ng-show="photo == ''" class="art_img" src="<?= base_url(); ?>img/article/noImage.png" /></figure>
						<h3>{{title}}</h3>
						<p>{{description}}</p>
					</div>
					<?php if((isset($ALLPRIVILEGE) && $ALLPRIVILEGE['ArticleComment']['view']==1) || $this->session->userdata('user_role')=='school'){?>
					<div class="col-md-4 col-lg-4 col-sm-12">
						<div class="album_view comment_view">
							<h3>Comments</h3>
							<li ng-show = "articleCommentinfo.length == 0"><span>No Records..</span></li>
							<li ng-show = "articleCommentinfo.length > 0">
								<div class="attachmentComments" ng-repeat="comments in articleCommentinfo">
									<div class="img">
										<img src="{{comments.create_by_photo}}" />
										<p class="comment_user">{{comments.create_by}}</p>
										<p class="comment_userType">{{comments.user_type}}</p>
									</div>
									<div class="cont">{{comments.comment}}
										<a ng-click="articleCommentDelete(comments.comment_id)" class="contdelete"><i class="icon-trash2" title="Delete"></i></a>	
									</div>
								</div>
							</li>
						</div>
					</div>
					<?php } ?>
				</div>
				<a class="btn btn-secondary" href="#!/article-list">Back To List</a>
			</div>
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->