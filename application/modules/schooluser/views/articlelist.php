<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="icon-news"></i>
					</div>
					<div class="page-title">
						<h5>Article Data</h5>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
					<div class="right-actions right-action-article">
						<a class="btn btn-primary" href="#!/add-article"><i class="icon-plus2"></i> Add Article</a>
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
	<div class="row">
		<div class="col-md-12">
			<div class="card" dir-paginate="article in articleList|filter:search|itemsPerPage:pageSize">
							<div class="card-body article_bx">
								<div class="article_img"><img ng-show="article.pic != ''" src="<?= base_url(); ?>img/article/{{article.pic}}" /><img ng-show="article.pic == ''" src="<?= base_url(); ?>img/article/noImage.png" /></div>
								<div class="content">
									<div class="title">
										{{article.title}}	
										<small class="by-auther-nane">{{article.created_time}}</small>
									</div>
									<p>{{article.description}}... <a class="link-theme" href="#!/article-detail/{{article.articleID}}">read more</a></p>
									<div class="accordion comment_accordion artical-accord mt-1 mt-md-3" id="accordionExample">
										<div class="card">
											<div class="card-header set-cardheader-mob" id="headingOne">
												<div class="btn-group float-left">
													<button class="btn btn-link float-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
														{{article.comments}}	 Comments
													</button>
													<button class="btn btn-link float-left" type="button" aria-expanded="true" aria-controls="collapseOne">{{article.like}}	 Like
													</button>
													<button class="btn btn-link float-left" type="button" aria-expanded="true" aria-controls="collapseOne">{{article.view}}	 views
													</button>
												</div>
												<div class="btn-group float-right">
													<a href="#!/edit-article/{{article.articleID}}" class="btn btn-link"><span class="icon-pencil"></span> Edit</a>
													<a class="btn btn-link" ng-click="articleDelete(article.id)"><span><i class="icon-trash2"></i></span> Delete</a>
												</div>
											</div>
										</div>									
									</div>
								</div>
							</div>
						</div>
					<dir-pagination-controls
					max-size="10" class="mb-3 float-left"
					direction-links="true"
					boundary-links="true">
					</dir-pagination-controls>
					<div class="clearfix"></div>
					<dir-pagination-controls
					max-size="10"
					direction-links="true" class="float-left"
					boundary-links="true"
					template-url="asset/js/dirPagination.tpl.html">
					</dir-pagination-controls>
		</div>
		<!-- Card end -->
		<!-- Card end -->
	</div>
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->