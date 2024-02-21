<div class="app-main">
			<!-- BEGIN .main-heading -->
			<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
							<div class="page-icon">
								<i class="icon-calendar"></i>
							</div>
							<div class="page-title">
								<h5>Holiday Calendar</h5>
							</div>
						</div>
						<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
							<div class="right-actions">
								<a href="#!/add-holiday" class="btn btn-primary"> <i class="icon-plus2"></i> Add Holiday</a>
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
					<div class="holiday-card-col">
					<div ui-calendar="uiConfig.calendar" ng-model="eventSources" calendar="myCalendar"></div>
					</div>
					<div class="clearfix">
						<form class="form-inline float-left mb-3">
							
							<div class="form-group">
								<input type="text" ng-model="search" class="form-control" placeholder="Search">
							</div>
						</form>
				
						<div class="form-inline float-right mb-3">
							<label for="search">items per page:</label>
							<input type="number" min="1" max="100" class="form-control ml-1" ng-model="pageSize">
						</div>
					</div>
						<div class="table-responsive white-space-nowrap">
						<table class="table parents-listing-c table-striped table-bordered m-0">
					<thead>
						<tr>
							<th>S. No</th>
							<th ng-click="sort('title')" class="sorting-tb">Holiday Name
								<span class="glyphicon sort-icon" ng-show="sortKey=='title'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th ng-click="sort('academicsession')" class="sorting-tb">Session
							<span class="glyphicon sort-icon" ng-show="sortKey=='academicsession'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							
							</th>
							<th>Date</th>
							<th class="text-right">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr dir-paginate="holiday in holidayList|orderBy:sortKey:reverse|filter:search|itemsPerPage:pageSize">
							<td>{{$index + 1}}</td>
							
							<td>{{holiday.title}}</td>
							<td>{{holiday.academicsession}}</td>
							<td>{{holiday.for_date}}</td>
							<td class="action text-right">
								<a href="#!/edit-holiday/{{holiday.holidayID}}"><i class="icon-edit2" title="Edit"></i></a>
								<a ng-click="holidayDelete(holiday.id)"><i class="icon-trash2" title="Delete"></i></a>
                                
							</td>
						</tr>
					</tbody>
				</table>
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
				</div>
				<!-- Card end -->
			</div>
			<!-- END: .main-content -->
		</div>
		<!-- END: .app-main -->
		