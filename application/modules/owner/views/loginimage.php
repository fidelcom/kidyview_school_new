<div class="app-main">
    <!-- BEGIN .main-heading -->
    <header class="main-heading">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 d-flex">
                    <div class="page-icon">
                        <i class="icon-tree mt-2"></i>
                    </div>
                    <div class="page-title ml-3 align-self-center">
                        <h5>Login Image</h5>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
                    <div class="right-actions">

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
					<table datatable="ng" class="table table-striped table-bordered ">
						<thead>
							<tr>
								<th>#</th>
								<th>User Type</th>
                                <th>Background Image</th>
								<th>Main Image</th>                            
								<th class="text-right">Action</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="x in dataList">
								<td>{{$index + 1}}</td>
								<td>{{x.login_screen}}</td>
                                <td>
									<img style="height:100px; width:auto;" src="<?php  echo base_url('asset/images/')?>{{x.bg_image}}" />                                
								</td>
								<td>
									<img style="height:100px; width:auto;" src="<?php  echo base_url('asset/images/')?>{{x.image}}" />                                
								</td>
								<td class="action text-right">
									<a ng-click="editData(x)"><i class="icon-edit" title="Editd"></i></a>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
            </div>
        </div>
        <!-- Card end -->
    </div>
    <!-- END: .main-content -->
</div>
<!-- END: .app-main -->


    <!--Update category Modal-->
<div class="modal fade" id="update-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="">Update {{obEdit.login_screen}} Login Image</h5>
            </div>
            <form class="form-horizontal" onsubmit="return false;" ng-submit="updateData()"  name="add-category">
                <div class="modal-body"> 
                <div class="form-group">
                        <label>Background Image</label>                            
                        <img  ng-show="obEdit.bg_image != ''" style="background-color: #000;" height="50" width="50" src="<?php  echo base_url('asset/images/')?>{{obEdit.bg_image}}"/>
                        <input type="file" onchange="angular.element(this).scope().bgImageUpload(this)" class="form-control" id="bgImageFile" aria-describedby="bgImageFile">
                        <span class="bg-danger" ng-if="error.image">@{{error.bgImageFile[0]}}</span>                                                     
                    </div>                      
                    <div class="form-group">
                        <label>Image</label>                            
                        <img  ng-show="obEdit.image != ''" style="background-color: #000;" height="50" width="50" src="<?php  echo base_url('asset/images/')?>{{obEdit.image}}"/>
                        <input type="file" onchange="angular.element(this).scope().ImageUpload(this)" class="form-control" id="imageFile" aria-describedby="imageFile">
                        <span class="bg-danger" ng-if="error.image">@{{error.image[0]}}</span>                                                     
                    </div>
                </div>    
                <div class="modal-footer">
                    <a href="javascript:;" class="btn width-100 btn-default" data-dismiss="modal">Close</a>
                    <button ng-disabled="isUpload==0" type="submit" class="btn width-100 btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--End Update category Modal-->
