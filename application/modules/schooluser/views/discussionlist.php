<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="fas fa-comments"></i>
					</div>
					<div class="page-title">
						<h5>Discussion</h5>
					</div>
				</div>
				<!-- <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
					<div class="right-actions">
					<a href="add-discussion-category.html" class="btn btn-primary"> <i class="icon-plus2"></i> Add Category</a>
					</div>
				</div> -->
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-6">
						<label>Search</label>
						<input type="text" ng-model="search" class="form-control" placeholder="Search">
					</div>
					<div class="col-md-6">
						<label for="search">items per page:</label>
						<input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
					</div>
				</div>
			</div>
		</div>
		<div class="card mt-3">
			<div class="card-body">
				<div class="discussion_box" dir-paginate="discussion in discussionList|filter:search|itemsPerPage:pageSize">
					<div class="dis_img">
						<img ng-show="discussion.pic != ''" src="<?= base_url(); ?>img/discussion/{{discussion.pic}}" />
						<img ng-show="discussion.pic == ''" src="<?= base_url(); ?>img/article/noImage.png" />
					</div>
					<div class="dis_cnt">
						<h3>{{discussion.discussion_type_text}}</h3>
						<div class="submit_user">
							<a href="javascript:void(0);">
							<figure><img src="{{discussion.create_by_photo}}" /></figure>
							<span>{{discussion.create_by}}</span>
							</a>
						</div>
						<div class="clearfix"></div>
						<p>{{discussion.detail}}</p>
						<p>{{discussion.optional_detail}}</p>
						<div class="accept_decline_btn">
							<a href="#!/discussion-detail/{{discussion.discussionID}}" ng-if="discussion.status == 1 && discussion.admin_reviewed == 1" class="btn btn-primary btn-sm"><span class="icon-eye"></span> View Detail</a>
							<button ng-if="discussion.status == 1 && discussion.admin_reviewed == 1" class="btn btn-default btn-sm"><span class="icon-check"></span> Accepted</button>
							<button class="btn btn-success btn-sm" ng-if="discussion.status == 0 && discussion.admin_reviewed == 0" ng-click="discussionAccept(discussion.id, 1);"><span class="icon-check"></span> Accept</button>
							<button class="btn btn-danger btn-sm" ng-if="discussion.status == 0 && discussion.admin_reviewed == 0" ng-click="discussionDecline(discussion.id, 0);"><span class="icon-close"></span> Decline</button>
							<button class="btn btn-danger btn-sm" ng-if="discussion.status == 0 && discussion.admin_reviewed == 1"><span class="icon-close"></span> Declined</button>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
		<dir-pagination-controls
		max-size="10" class="mt-3 mb-5 mb-5 float-left"
		direction-links="true"
		boundary-links="true">
		</dir-pagination-controls>
		<dir-pagination-controls
		max-size="10"
		direction-links="true" class=" mt-3 mb-5 float-right display_nmbr"
		boundary-links="true"
		template-url="asset/js/dirPagination.tpl.html">
		</dir-pagination-controls>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->