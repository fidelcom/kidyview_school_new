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
						<h5>Album</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5">
					<div class="right-actions">
						<a href="#!/add-album" class="btn btn-primary"> <i class="icon-plus2"></i> Add Album</a>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content albm-cate-list">
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
			<div class="col-md-4 col-sm-6 col-xs-12" dir-paginate="album in albumList|orderBy:sortKey:reverse|filter:search|itemsPerPage:pageSize">
				<div class="card">
					<div class="card-body album_bx">
						<figure>
							<img ng-show="album.picUrl != null" src="<?= base_url(); ?>img/album/{{album.picUrl}}" />
							<img ng-show="album.picUrl == null" src="<?= base_url();?>img/videothumb.png" />
							<a href="#!/edit-album/{{album.albumID}}" class="btn btn-link edit_icon"><i class="fas fa-pen"></i></a>
						</figure>
						<div class="cont">
							<h4>{{album.title}}</h4>
							<h6 class="album-dis">{{album.description}}</h6>
							<span>({{album.attachments.length}}) Media</span>
							<div class="divGroup">
								<a class="btn btn-primary" href="#!/album-detail/{{album.albumID}}">View Media</a>
								<div class="d-btn">
									<a ng-if="album.status == '1'"><i class="fas fa-toggle-on" ng-click="albumDisabled(album.id, 0);"></i></a>
									<a ng-if="album.status == '0'"><i class="fas fa-toggle-off" ng-click="albumDisabled(album.id, 1);"></i></a>
									
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
						<div class="view-dtl-sec">
							<a class="float-left">{{album.comments}} Comment</a>
							<a class="float-right" href="javascript:void(0);">{{album.like}} Likes</a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12">
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
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->