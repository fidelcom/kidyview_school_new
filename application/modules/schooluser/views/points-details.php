<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
	    <div class="container-fluid">
	        <div class="row">
	            <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
	                <div class="page-icon">
	                    <i class="icon-school"></i>
	                </div>
	                <div class="page-title">
	                    <h5>{{ totalPoint.studentName }} </h5>
	                </div>
	            </div>
	            <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
				<div class="right-actions">
					<a href="javascript:void(0);" class="btn btn-primary">{{ totalPoint.totalPoints ? totalPoint.totalPoints : '-'  }} Points</a>
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
                            <div class="point_deatil_box">
                                <ul>
                                  
                                    <li ng-repeat="val in allPointsData">
                                        <figure class="green">
                                            + {{ val.points}}
                                            <span>Points</span>
                                        </figure>
                                        <figcaption>
                                            <h3>{{ val.title }} </h3>
                                            <ul>
                                                <li>Tanuj test teacher</li>
                                                <li class="date" >{{ val.created_date }} </li>
                                                <!-- <li class="date" >{{ val.created_date }} 23 Nov 2019</li> -->
                                            </ul>
                                        </figcaption>
                                    </li>
                                  
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Card end -->
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