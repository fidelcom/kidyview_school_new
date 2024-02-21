<!-- BEGIN .app-main -->
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
			<h5>Class Board</h5>
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
	<div class="card dataTables_wrapper">
		<div class="card-header f20"> 
			<span class="d-inline-block mt-1"></span>
			<span class="float-right">
				<a href="#!/create-classboard" class="btn btn-primary">
					Create New
				</a>
			</span>
		</div>
		<div class="card-body small-font">
				<div class="panel class-board-panel" ng-repeat="classboard in classboardData">
					<div class="left-content">
						<div class="panel-header clearfix">
							<div class="h6">{{classboard.name}} <span class="classboard-dt">{{classboard.created|date:"dd MMM y"}}</span></div>
							<div class="class">Class: {{classboard.classname}}</div>
							
							</div>
						<p>{{classboard.description}}</p>
						<div class="clearfix"></div>
					</div>
					<div class="link-v-classboard">
					<a href="#!/view-post/{{classboard.classboardID}}" data-toggle="tooltip" data-original-title="View Detail" data-placement="top"><i class="icon-eye"></i></a>
					<a href="#!/edit-classboard/{{classboard.classboardID}}" data-toggle="tooltip" data-original-title="Edit Detail" data-placement="top"><i class="icon-edit2"></i></a>
					<a href="javascript:void(0);" ng-click="delete(classboard.id,$index)"><i class="icon-trash"></i></a>
					<div class="clearfix"></div>
					</div>
				</div> 
				<div class="TcrLoadmore" ng-show="countclassboardData>limit && classboardData.length<countclassboardData"><a href="javascript:void(0)" ng-click="loadMoreClassboardData();">Load More</a></div>
		</div>
	</div>
</div>
</div>
<!-- Row end -->
</div>
<!-- END: .main-content -->
</div>
<!-- END: .app-main -->