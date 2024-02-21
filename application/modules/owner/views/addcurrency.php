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
                        <h5>Add Currency</h5>
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
                                <label class="form-label">Currency Name*</label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="currency_name" ng-model="currency_name" >
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Currency Code*</label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="currency_code" ng-model="currency_code">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Symbol *</label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="currency_symbol" ng-model="currency_symbol">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Rate (1$)*</label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="currency_rate" ng-model="currency_rate">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <input class="btn btn-primary" type="button" name="submit" ng-click="addCurrency()" value="Save">
                                <input class="btn btn-info" type="reset" value="Reset">
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
                                                                                <th>Sr no</th>
										<th>Currency Name</th>
                                                                                <th>Currency Code</th>
                                                                                <th>Symbol</th>
                                                                                <th>Exchange Rate</th>
                                                                                <th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="curr in currency" >
										<td>{{$index + 1}}</td>
                                                                                <td>{{curr.currency_name}}</td>
                                                                                <td>{{curr.currency_code}}</td>
                                                                            	<td>{{curr.currency_symbol}}</td>
                                                                                <td>{{curr.currency_rate}}</td>
                                                                               <td>
                                                                                 <!-- <div ng-if="setID(curr.id)!='1'">-->
                                                                                 <div>
                                                                                <a  href="#!/edit-currency/{{curr.id}}"><i class="icon-pencil" title="Edit"></i></a>
                                                                                <a  href="javascript:void()" ng-click="currencyDelete(curr.id)"><i class="icon-delete" title="Delete"></i></a>
                                                                                  </div>
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