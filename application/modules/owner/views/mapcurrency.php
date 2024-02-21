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
                        <h5>Map Currency </h5>
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
                                <label class="form-label">Country List* </label>
                                <div class="controls">

                                    <select ng-model="countrycode" class="form-control" id="countrycode" ng-change="getContentList(countrycode)">
                                        <option value="" selected="selected" >Please Select</option>
                                        <option   ng-repeat="country in countryCodes" value="{{country.id}}" >{{country.name}}</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="form-label">Currency List*</label>
                                <div class="controls">
                                     <select ng-model="currencycode" class="form-control" id="currencycode">
                                        <option value="" selected="selected"  selected="selected">Please Select</option>
                                        <option  ng-repeat="curr in currency" value="{{curr.id}}" >{{curr.currency_name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <input class="btn btn-primary" type="button" name="submit" ng-click="mapCurrency()" value="Save">
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
										<th>Country Name</th>
                                                                                <th>Currency Title</th>
                                                                                <th>Currency Code</th>
                                                                                <th>Symbol</th>
                                                                                <th>Exchange Rate</th>
                                                                                <th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="curren in currencylist">
										<td>{{$index + 1}}</td>
                                                                                <th>{{curren.countryName}}</th>
                                                                                <td>{{curren.currency_name}}</td>
                                                                                <td>{{curren.currency_code}}</td>
                                                                            	<td>{{curren.currency_symbol}}</td>
                                                                                <td>{{curren.currency_rate}}</td>
                                                                               <td>
                                                                                <a  href="javascript:void()" ng-click="unMapCurrency(curren.id)"><i class="icon-delete" title="Delete"></i></a>
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