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
								<h5>Calendar</h5>
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
					<form class="form-inline float-left mb-3">
					
					<div class="form-group">
						<input type="text" ng-model="search" class="form-control" placeholder="Search">
					</div>
				</form>
				
				<div class="form-inline float-right mb-3">
					<label for="search">items per page:</label>
					<input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
				</div>
				
						
						<table class="table parents-listing-c table-striped table-bordered table-responsive">
					<thead>
						<tr>
							<th>S. No</th>
							<th>Type</th>
							<!--<th ng-click="sort('type')" class="sorting-tb">Type
								<span class="glyphicon sort-icon" ng-show="sortKey=='type'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
							<th ng-click="sort('start')" class="sorting-tb">Day
							<span class="glyphicon sort-icon" ng-show="sortKey=='start'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>-->
							<th ng-click="sort('title')" class="sorting-tb">Name / Date
							<span class="glyphicon sort-icon" ng-show="sortKey=='title'" ng-class="{'glyphicon-chevron-up':reverse,'glyphicon-chevron-down':!reverse}"></span>
							</th>
						
						</tr>
					</thead>
					<tbody>
						<tr dir-paginate="calendar in calendarList|orderBy:sortKey:reverse|filter:search|itemsPerPage:pageSize">
							<td>{{$index + 1}}</td>
							<td ng-if="calendar.type=='Birthday'"><img src="<?php echo base_url();?>assets/img/cake.png" height="30" width="30"/></td>
							<td ng-if="calendar.type=='Event'"><img src="<?php echo base_url();?>assets/img/note.png" height="30" width="30"/></td>
							<td ng-if="calendar.type=='Holiday'"><img src="<?php echo base_url();?>assets/img/calender.png" height="30" width="30"/></td>
							<!--<td>{{calendar.type}}</td>
						    <td>{{calendar.start}}</td>-->
							<td ng-if="calendar.type=='Birthday'">{{calendar.title}} ({{calendar.start}})</td>
							<td ng-if="calendar.type=='Event'">{{calendar.title}} ({{calendar.start}} {{calendar.time && calendar.time!=0?calendar.time:''}})</td>
							<td ng-if="calendar.type=='Holiday'">{{calendar.title}}</td>
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
				<!-- Card end -->
			</div>
			<!-- END: .main-content -->
		</div>
		<!-- END: .app-main -->
		