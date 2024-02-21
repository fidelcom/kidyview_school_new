<!--BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
					<div class="page-icon">
						<i class="icon-user-plus"></i>
					</div>
					<div class="page-title">
						<h5>Activity Performance</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
					<div class="right-actions">
						<!-- <a href="#!/add-student" class="btn btn-primary"> <i class="icon-plus2"></i> Add Students</a> -->
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- BEGIN .main-content -->
	<div class="main-content">
				<div class="card">
					<div class="card-body">
						<div class="clearfix"></div>
						
						<div class="table-responsive">
						<table datatable="ng" class="table table-striped table-bordered">
				<thead>
						<tr>
							<th>S.No.</th>
							<th ng-click="sort('name')" class="sorting-tb">Name
							
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="perpofmance in performanceData">
							<td>{{$index + 1}}</td>
							<td>{{perpofmance.name}} 	</td>
							
							<td class="action">
								<a href="javascript:void(0);" ng-click="getData(perpofmance)"><i class="icon-edit2" title="Edit"></i></a>
							</td>
						</tr>															
					</tbody>
				</table>
						</div>
						<!-- <div class="range-label float-left">Displaying {{ pageSize * (currentPage-1)+$index+1 }} - {{ pageSize*currentPage }} of {{ studentData.length }}</div> -->
						<div class="clearfix"></div>
					</div>
				</div>
				<!-- Row end -->
			</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main-->

<div class="modal fade custom_modal ng-scope show" id="getpopup" role="dialog" style="display: none;">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">×</button>
	<h4 class="modal-title">Update Activity Performance</h4>
</div>
<div class="modal-body">
	<form class="ng-pristine ng-invalid ng-invalid-required ng-valid">

		<div class="row form-group">
			
			<div class="col-md-12">
				<input type="" class="form-control" name="pname" ng-model="name"/>
			</div>
		</div>
			
		<div class="row form-group mt-3">
			
			<div class="col-md-12">
				<button ng-click="updateActivityPerformance()" class="btn btn-primary">Update</button>
			</div>
		</div>
	</form>
</div>
</div>
</div>
