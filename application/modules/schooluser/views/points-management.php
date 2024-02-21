<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
                    <div class="page-icon">
                        <i class="fas fa-gift"></i>
                    </div>
                    <div class="page-title">
                        <h5>Points Management</h5>
                    </div>
                </div>
                <!-- <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
				<div class="right-actions">
					<a href="add-meal.html" class="btn btn-primary"> <i class="icon-plus2"></i> Add meal</a>
				</div>
			</div> -->
            </div>
        </div>
    </header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
                    <div class="card">
                        <div class="card-body">
                            
                  <div class="row">
                    <div class="col-md-6">
                      
                        <select ng-model="stdclass" name="stdclass" class="form-control" ng-change="pointManagement(stdclass)">
                            <option value="" selected="selected" >Please Select</option>
                            <option ng-repeat="class in classList" value="{{class.id}}">{{class.class}}-{{class.section}}</option>
                        </select>
                    </div>
                </div>
                            
                            
                            <div class="meal_tab point_box">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active" id="primary">
                                        <ul >
                                            <li ng-repeat="val in pointMgmt">
                                                <figure><img src="<?php echo base_url(); ?>img/child/{{ val.childphoto}}" alt="child_photo"></figure>
                                                <figcaption>
                                                    <h3> {{ val.studentName }}</h3>
                                                    <h4>{{ val.fatherName }}</h4>
                                                    <div class="company">{{ val.class }}</div>
                                                    <div class="price color-green">{{val.currency_code}} 100 - {{ val.totalPoints }} Points</div>
                                                    <a class="btn btn-primary" href="#!/point-details/{{ val.student_id_encrypt }}">View Point History</a>
                                                </figcaption>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Card end -->
                </div>
	<!-- END: .main-content -->
</div>
<!-- END: .app-main -->