<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 d-flex">
					<div class="page-icon">
						<i class="icon-calendar3"></i>
					</div>
					<div class="page-title ml-3 align-self-center">
						<h5>Events Data</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5 mt-2 mt-sm-0">
					<div class="right-actions">
						<a href="#!/add-event" class="btn btn-primary"> <i class="icon-plus2"></i> Add Events</a>
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
				<div class="clearfix">
				<form class="form-inline float-none float-md-left src-mobile">
					<div class="form-group mb-3 mb-md-0">
						<input type="text" ng-model="search" class="form-control" placeholder="Search">
					</div>
				</form> 
				<div class="form-inline float-none float-md-right mb-3 item-form-mg">
					<label class="mr-0 mr-md-2" for="search">items per page:</label> 
					 <input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
				</div>
				</div>
				<div class="table-responsive white-space-nowrap">
				<table class="table parents-listing-c table-striped table-bordered">
					<thead>
						<tr>
							<th>S.No.</th>
							<th ng-click="sort('title')" class="sorting-tb">Title
								<span class="glyphicon sort-icon" ng-show="sortKey=='title'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th ng-click="sort('is_paid')" class="sorting-tb">Event Type
								<span class="glyphicon sort-icon" ng-show="sortKey=='is_paid'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th>Date & Time</th>
							<th>Address</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr dir-paginate="event in eventList|orderBy:sortKey:reverse|filter:search|itemsPerPage:pageSize">
							<td>{{$index + 1}}</td>
							<td>{{event.title}}</td>
							<td ng-show="event.is_paid == '0'">Free</td>
							<td ng-show="event.is_paid == '1'">Paid</td>
							<td>{{event.formattedDate}} {{event.time | date:"h:mma"}}</td>
							<td>{{event.address}}</td>
							<td class="action">
								<a href="#!/event-detail/{{event.eventID}}"><i class="icon-eye" title="View"></i></a>
								<a ng-if="event.visibility!=''" href="#!/edit-event/{{event.eventID}}"><i class="icon-edit2" title="Edit"></i></a>
								<button ng-if="event.visibility==''" disabled><i class="icon-edit2" title="Edit"></i></button>
								<a ng-click="eventDelete(event.id)"><i class="icon-trash2" title="Delete"></i></a>
							</td>
						</tr>																
					</tbody>
				</table>
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
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->