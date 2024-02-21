<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="icon-file-text"></i>
					</div>
					<div class="page-title">
						<h5>Timeline</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
					<div class="right-actions">
						
						<a href="#!/add-timeline" class="btn btn-primary"> <i class="icon-plus2"></i> Add Timeline</a>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group">
					<label>Search</label>
					<input type="text" ng-model="search" class="form-control" placeholder="Search">
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group">
					<label for="search">items per page:</label>
					<input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
				</div>
			</div>
		</div>
		<div class="timeline">
			<div class="timeline__group">
				<div class="timeline__box" dir-paginate="timeline in timelineList|filter:search|itemsPerPage:pageSize">
					<div class="timeline__date">
						<img src="{{timeline.create_by_photo}}" />
					</div>
					<div class="timeline__post">
						<div class="name_designation">{{timeline.create_by}} <span>{{timeline.user_type}}</span></div>
						<div class="date_time">{{timeline.created}}</div>
						<div class="timeline__content">
							<p>{{timeline.description}}</p>
						</div>
						<div class="accordion comment_accordion" id="accordionExample{{timeline.id}}">
							<div class="card">
								<div class="card-header" id="headingOne{{timeline.id}}">
									<h2 class="mb-0">
										
										<div class="btn-group float-left" >
											<button ng-if="timeline.comment_detail.length == 0" class="btn btn-link float-left" type="button">{{timeline.comments}} Comments</button>
											<button ng-if="timeline.comment_detail.length > 0" class="btn btn-link float-left" type="button" data-toggle="collapse" data-target="#collapseOne{{timeline.id}}" aria-expanded="true" aria-controls="collapseOne{{timeline.id}}">{{timeline.comments}} Comments</button>
											<button class="btn btn-link float-left" type="button">{{timeline.like}} Like</button>
										</div>
										<div class="btn-group float-right" >
											<a href="#!/edit-timeline/{{timeline.timelineID}}" class="btn btn-link"><span class="icon-pencil"></span> Edit</a>
											<!-- <button ng-if="timeline.status == '0'" type="button" class="btn btn-link" ng-click="timelineDisabled(timeline.id, 1);"><span class="icon-bin2"></span> Enable</button> -->
											<button ng-if="timeline.status == '1'" type="button" class="btn btn-link" ng-click="timelineDisabled(timeline.id, 0);"><span class="icon-bin2"></span> Delete</button>
										</div>
									</h2>
								</div>
								<?php if((isset($ALLPRIVILEGE) && $ALLPRIVILEGE['TimelineComments']['view']==1) || $this->session->userdata('user_role')=='school'){?>
								<div id="collapseOne{{timeline.id}}" class="collapse" aria-labelledby="headingOne{{timeline.id}}" data-parent="#accordionExample{{timeline.id}}">
									<div class="card-body" ng-repeat="comments in timeline.comment_detail">
										<div class="img">
											<img src="{{comments.create_by_photo}}" />
											<!--p class="comment_user">{{comments.create_by}}</p-->
											<!--p class="comment_userType">{{comments.user_type}}</p-->
										</div>
										<div class="cont">{{comments.comment}}
										</div>
									</div>
								</div>
								<?php } ?>
							</div>									
						</div>
					</div>
				</div>
			</div>
		</div>
		<dir-pagination-controls
		max-size="10" class="mt-3 mb-5 mb-5 float-right"
		direction-links="true"
		boundary-links="true">
		</dir-pagination-controls>
		<dir-pagination-controls
		max-size="10"
		direction-links="true" class=" mt-3 mb-5 float-left display_nmbr"
		boundary-links="true"
		template-url="<?php echo base_url(); ?>asset/js/dirPagination.tpl.html">
		</dir-pagination-controls>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->