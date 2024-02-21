<!-- BEGIN .app-main -->
<div class="app-main">
		<header class="main-heading">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 align-self-center">
							<div class="page-icon">
								<i class="icon-wallet"></i>
							</div>
							<div class="page-title">
								<h5>Details</h5>
							</div>
						</div>
						 <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
							<div class="right-actions add-2px d-flex">
									<a href="#!/fees-list" class="btn btn-primary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
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
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-body full-detail p-0">
                            <ul>
                                <li><span>Class Name:</span>{{ feesDetails.class }}</li>
                                <li><span>School Type:</span> {{ feesDetails.schooltype }}</li>
                                <li><span>Fees Type:</span> {{ feesDetails.fee_type }}</li>
                                <li><span>Fees Amount:</span>  {{ feesDetails.fee_amount ? currencySym + feesDetails.fee_amount : '-' }}</li>
                                <li><span>Subscription Amount:</span>{{ feesDetails.suscription_fee ? currencySym+feesDetails.suscription_fee : '-' }}</li>
                                <li><span>Fees Categories:</span> {{ feesDetails.categories }}</li>
                                <li><span>Comment:</span> {{ feesDetails.description }}</li>
                                <li><span>Created On:</span> {{feesDetails.created_at}}</li>
                            </ul>
                        </div>
                    </div>
                </div>
                 <div class="row">
                     <div class="col-md-12">
                         <div class="card-body full-detail p-0">
                          <ul><li><a class="btn btn-primary" role="button" href="#!/transaction-history/{{feesDetails.class_id}}/{{feesDetails.session_id}}">View Payment</a></li> </ul>
                         </div>
                    </div>    
                </div>
            </div>
        </div>
        <!-- Row end -->
    </div>
	<!-- END: .main-content -->
</div>
