<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 d-flex">
					<div class="page-icon">
						<i class="fas fa-utensils"></i>
					</div>
					<div class="page-title ml-3 align-self-center">
						<h5>Home Meal</h5>
					</div>
				</div>
				<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
					<div class="right-actions">
						<a ng-click="addMealModal('addMealModal');" class="btn btn-primary"> <i class="icon-plus2"></i> Add Meal</a>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content update-dt-list-update update-dt-list-update-n privilage-r-table w-auto">
		<div class="card">
			<div class="card-body">	
				<div class="table-responsive">
				<table datatable="ng" class="table parents-listing-c table-striped table-bordered tb-width-auto">
					<thead>
                                            <tr>
                                                <th>S.No.</th>                                                
                                                <th>Title</th>
                                                <th class="text-right">Action</th>
                                            </tr>
					</thead>
					<tbody>
                                            <tr ng-repeat="m in mealList">
                                                <td>{{$index + 1}}</td>
                                                <td>{{m.name}}</td>
                                                <td class="action text-right">
                                                        <a href="#!/meal-detail/"><i class="icon-eye" title="View"></i></a>
                                                        <a href="#!/edit-meal/"><i class="icon-edit2" title="Edit"></i></a>
                                                        <a ><i class="icon-trash2" title="Delete"></i></a>
                                                </td>
                                            </tr>																
					</tbody>
				</table>	
</div>				
			</div>
		</div>
		<!-- Row end -->
	</div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->
<!-- Modal -->
<div class="modal" id="addMealModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Meal</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <form ng-submit="addHomeMeal()"  method="post">
      <!-- Modal body -->
          <div class="modal-body">
              <div class="form-group">
                <label for="email">Name:</label>
                <input type="text" ng-model="meal.name" class="form-control" placeholder="Name" id="name">
              </div>
          </div>
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" >Save</button>
          </div>
      </form> 
    </div>
  </div>
</div>