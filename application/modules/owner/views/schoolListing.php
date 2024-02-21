BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-8 align-self-center">
					<div class="page-icon">
						<i class="icon-school"></i>
					</div>
					<div class="page-title">
						<h5>School Management</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-4">
					<div class="right-actions">
						<a href="#!/add-school" class="btn btn-primary"> <i class="icon-plus2"></i> Add School</a>
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
				<div class="table-responsive white-space-nowrap">
				<table datatable="ng" class="table school-listing-c table-striped table-bordered table-responsive white-space-nowrap">
					<thead>
						<tr>
							<th>Sr. no.</th>
							<th>School Name</th>
							<th class="add-break-word">Email Id</th>
							<th>Address</th>
							<th>City</th>
							<!--<th>Pin Code</th>-->
							<th>Subscription Plan</th>
							<th>Subscription Validity</th>
							<th class="text-right">Action</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="school in schoolList">
							<td>{{ $index+1 }}</td>
							<td>{{school.school_name}}</td>
							<td class="add-break-word">{{school.email}}</td>
							<td>{{school.location}}</td>
							<td>{{school.city}}</td>
							<!--<td>{{school.pincode}}</td>-->
							<td>{{school.subscriptiondetails.name}}</td>
							<td>{{school.subscriptiondetails.days?school.subscriptiondetails.days+' days' :''}}</td>
							<td class="text-right action">
                                                                <a href="#!/transaction-list/{{school.schoolID}}" alt="{{school.id}}"><i class="fas fa-file"></i></a>
								<a href="#!/school-view/{{school.schoolID}}" alt="{{school.id}}"><i class="icon-eye"></i></a>
								<a href="#!/edit-school/{{school.schoolID}}"><i class="icon-edit"></i></a>
								<a ng-if="school.status == '1'"><i class="fas fa-toggle-on" ng-click="schoolDisabled(school.id, 0);"></i></a>
								<a ng-if="school.status == '0'"><i class="fas fa-toggle-off" ng-click="schoolDisabled(school.id, 1);"></i></a>
							</td>
						</tr>
						
					</tbody>
				</table>
			</div>
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main