<div class="app-main">
			<!-- BEGIN .main-heading -->
			<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						
						<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
							<div class="page-icon">
								<i class="icon-tree"></i>
							</div>
							<div class="page-title">
								<h5>Add Sponsor </h5>
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
						<form>
							<div class="row">
							
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Company Name<em>*</em></label>
										<div class="controls">
											<input type="text" class="form-control"  ng-model="title" required="">
										</div>
									</div>
								</div>
                                                            
                                                                <div class="col-md-6 col-sm-6 col-xs-12">
									<div class="form-group">
										<label class="form-label">Link<em>*</em></label>
										<div class="controls">
											<input type="text" class="form-control"  ng-model="link" required="">
										</div>
									</div>
								</div>
                                                                
                                                                <div class="col-lg-6 col-md-6 col-md-6 col-sm-6 col-xs-12">
							<div class="form-group">
								<label class="form-label"></label>
								<div class="col-md-12">
									<div class="upload-preview-box upload-img-view" ng-show="isImage(fileExt)">
									<img  ngf-src="logophoto[0]" class="thumb">
								</div>
								</div>
								<div class="btn-uploadprof mt-0">
									<span>
										<i class="icon-camera-outline"></i>
										<input class="file-upload" ngf-select="" ngf-change="onChange($files)" id="pic" ng-model="logophoto" accept="image/png, image/jpeg" type="file" />
										<span>Upload Logo</span>
									</span>
								</div>
							</div>
						</div>
								
								<div class="col-md-12 col-sm-12 col-xs-12 mt-3">
									<div class="form-group">
									<button class="btn btn-primary" ng-click="addSponser()">Add Sponsor </button>
									
									</div>
								</div>
								
							</div>
						</form>
					</div>
				</div>
				<!-- Row end -->
                                
                                
                             <div class="card">
            <div class="card-body">
                
                <div class="row set-tb-search">
                    <div class="col-md-12">
						<div class="table-responsive white-space-nowrap">
							<table datatable="ng" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>S.No.</th>
                                                                                <th>Company Name</th>
                                                                                <th>Logo</th>
										<th>Link</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="sponser in sponsers">
										<td>{{$index + 1}}</td>
                                                                                <td>{{sponser.title}}</td>
                                                                                <td><img ng-if="sponser.pic!='' " src="<?= base_url();?>img/sponser/{{sponser.pic}}" alt="" width="50" height="50" /></td>
                                                                            	<td>{{sponser.	link}}</td>
                                                                                <td>
                                                                                    <a ng-if="sponser.status == '1'"><i class="fas fa-toggle-on" ng-click="sponserDisabled(sponser.id, 0);"></i></a>
                                                                                    <a ng-if="sponser.status == '0'"><i class="fas fa-toggle-off" ng-click="sponserDisabled(sponser.id, 1);"></i></a>
                                                                                    <a  href="#!/edit-sponser/{{sponser.id}}"><i class="icon-pencil" title="Edit"></i></a>
                                                                                    <a  href="javascript:void()" ng-click="sponserDelete(sponser.id)"><i class="icon-delete" title="Delete"></i></a>
                                                                                </td>
										
									</tr>
								</tbody>
							</table>	
						</div>
                    </div>
                </div>    
            </div>
        </div>   
                                
                                
			</div>
			<!-- END: .main-content -->
		</div>
		<!-- END: .app-main -->