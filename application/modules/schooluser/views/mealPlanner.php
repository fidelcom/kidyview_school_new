<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-7 align-self-center mb-3 mb-sm-0">
					<div class="page-icon">
						<i class="fas fa-utensils"></i>
					</div>
					<div class="page-title">
						<h5>Meal Planner</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-5">
					<div class="right-actions">
						<a href="#!/add-meal" class="btn btn-primary"> <i class="icon-plus2"></i> Add Meal</a>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content update-dt-list-update update-dt-list-update-n privilage-r-table">
		<div class="card">
			<div class="card-body">	
				<div class="table-responsive white-space-nowrap">
				<table datatable="ng" class="table parents-listing-c table-striped table-bordered ">
					<thead>
                                            <tr>
                                                <th>S.No.</th>                                                
                                                <th>School Type</th>
                                                <th>From Date</th>
                                                <th>To Date</th>
                                                <th class="text-right">Action</th>
                                            </tr>
					</thead>
					<tbody>
                                            <tr ng-repeat="m in mealList">
                                                <td>{{$index + 1}}</td>
                                                <td>{{m.school_type_name}}</td>
                                                <td>{{m.from_date}}</td>
                                                <td>{{m.to_date}}</td>
                                                <td class="action text-right">
                                                        <a href="#!/edit-meal/{{m.id}}"><i class="icon-edit2" title="Edit"></i></a>
                                                        <a href="javascript:void(0);" ng-click="deleteList(m.id)" title="Delete"><i class="icon-trash"></i></a>
                                                       
                                                </td>
                                            </tr>																
					</tbody>
				</table>	</div>			
			</div>
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->